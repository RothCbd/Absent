<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Report\reportData;
use App\Http\Resources\Report\Testing;
use App\Models\Absent;
use App\Models\Employee;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function report(Request $request)
    {
        $dates = $request->dates;
        $employee_id = $request->employee_id;

        if($dates || $employee_id){
            return response()->json([
                'date' => $dates,
                'employee_id' => $employee_id
            ]);
        }else{
            return 'no input data';
        }

        // ===============Working=======================
        $getData = array();
        foreach($employee_id as $id){
            $getData[] = Absent::with('employee')->where('employee_id', $id)->get();
        }

        $report = array();
        foreach($getData as $items){
            foreach($items as $item){
                $report[] = array(
                    'day' => $item->day,
                    'date' => $item->date,
                    'employee' => [
                        'name' => $item->employee->name,
                        'image' => $item->employee->pic,
                    ]
                );
            }
        }

        return $report;

        // ===============Working=======================


        if($dates){
            if(count($dates) == 1){
                return new reportData(Absent::with('employee')->where('date', $dates[0])->get());
            }else{

                if($dates[1] > $dates[0]){
                    return new reportData(Absent::with('employee')->where('date', '>=', $dates[0])->where('date', '<=', $dates[1])->get());
                }else{
                    return new reportData(Absent::with('employee')->where('date', '>=', $dates[1])->where('date', '<=', $dates[0])->get());
                }
            }
        }
    }
}
