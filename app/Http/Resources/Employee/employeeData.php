<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Resources\Json\ResourceCollection;

class employeeData extends ResourceCollection
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
            'data' => $this->collection->transform(function($employee){
                return[
                    'id' => $employee->id,
                    'name' => $employee->name,
                    'email' => $employee->email,
                    'gender' => $employee->gender,
                    'position' => $employee->position,
                    'start_date' => $employee->start_date,
                    'phone_number' => $employee->phone_number,
                    'image' => $employee->pic,
                    'profile_color' => $employee->profile_color,
                    'is_inactived' => $employee->is_inactive
                ];
            })
        ];
    }
}
