<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;

class DocumentsItem extends Model
{
    protected $table = 'documents';
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        // Удаление файла связанного с данным документом
        self::deleting(function (DocumentsItem $docsItem) {
            app(Filesystem::class)->delete($docsItem->file);
        });
    }

    public function parent()
    {
        return $this->belongsTo(DocumentsGroup::class, 'documents_group_id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public static function getGroupedDocuments()
    {
        $docs = self::active()->ordered()->with('parent')->get();
        $groupedDocs = $docs->groupBy(['parent.name', function ($item, $key) {
            return $item;
        }]);

        return $groupedDocs;
    }

    public function getTypeAttribute()
    {
        $type = '';
        if (\File::exists($this->file)) {
            $mimeType = \File::mimeType($this->file);
            if ($mimeType == 'application/pdf') {
                $type = 'pdf';
            } elseif ($mimeType == 'application/msword' ||
                $mimeType == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                $type = 'doc';
            }
        }

        return $type;
    }

    public function getDownloadAttribute()
    {
        if (!empty($this->type) && $this->type == 'doc') {
            return 'download';
        } else {
            return '';
        }
    }
}