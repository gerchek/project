<?php

namespace App\Resources;

use App\Models\EmployeeGroup;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EmployeesCollection extends ResourceCollection
{
    // public static $wrap = 'results';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->get()->map(function ($item) use ($request) {
            $employeeGroup = EmployeeGroup::where('id', $item->employee_group_id)->firstOrFail();

            return [
                'name' => $item->name,
                'post' => $item->post,
                'filter_name' => \Str::slug($employeeGroup->name),
                'photo' => $item->photo,
                'short_text' => strip_tags($item->short_text),
                'full_text' => $item->full_text,
            ];
        })->paginate(15);
    }
}
