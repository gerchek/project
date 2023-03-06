<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;

class DocumentsGroup extends Model
{
    protected $table = 'documents_groups';
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        // Удаление документов связанных с данной группой
        self::deleting(function (DocumentsGroup $docsGroup) {
            $docsItems = $docsGroup->childs;
            foreach ($docsItems as $docsItem) {
                 app(Filesystem::class)->delete($docsItem->file);
            }
        });
    }

    public function childs()
    {
        return $this->hasMany(DocumentsItem::class, 'documents_group_id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}