<?php

namespace App\Http\Resources\Position;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PositionData extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($position){
                return[
                    'id' => $position->id,
                    'title' => $position->title,
                    'employee' => $position->employee,
                    'employee_count' => $position->employee->count()
                ];
            })
        ];
    }
}
