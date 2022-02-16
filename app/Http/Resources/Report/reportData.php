<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\ResourceCollection;

class reportData extends ResourceCollection
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
            'data' => $this->collection->transform(function($report){
                return[
                    'day' => $report->day,
                    'date' => $report->date,
                    'desription' => $report->description,
                    'employee' => [
                        'name' => $report->employee->name,
                        'gender' => $report->employee->gender,
                        'image' => $report->employee->pic,
                        'position' => $report->employee->position
                    ]
                ];
            })
        ];
    }
}
