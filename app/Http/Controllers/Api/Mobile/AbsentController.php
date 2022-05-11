<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Absent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsentController extends Controller
{
    public function read()
    {
        $absents = DB::table('absents')
            ->join('employees', 'employees.id', '=' ,'absents.employee_id')
            ->select(array(
                'absents.id',
                'absents.absent',
                'absents.absent_time',
                'absents.day',
                'absents.date',
                'employees.id as employee_id',
                'employees.name',
                'employees.pic',
                'employees.position',
                'employees.profile_color'
            ))
            ->orderBy('date', 'DESC')
            ->get()
            ->groupBy(function($val) {
            return Carbon::parse($val->date)->format('Y-m');
        });

        $result = array();
        foreach($absents as $key => $value){
            $result[] = array(
                "date" => $key,
                "count" => count($value),
                "data" => $value
            );
        }

        return $result;
    }
}
