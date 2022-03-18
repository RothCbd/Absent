<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function report(Request $request)
    {
        $dates = $request->dates;
        $employee_id = $request->employee_id;
        $getData = array();
        $report = array();

        if($dates || $employee_id)
        {
            // ---BY-EMPLOYEE-AND-DATES---
            if($dates && $employee_id)
            {
                if(count($dates) == 1)
                {
                    foreach($employee_id as $id){
                        $getData[] = Employee::with(['absent' => function($q) use($dates){
                            $q->where('date', $dates[0]);
                        }])->where('id', $id)->get();
                    }
                }else{
                    if($dates[1] > $dates[0])
                    {
                        foreach($employee_id as $id){
                            $getData[] = Employee::with(['absent' => function($q) use($dates){
                                $q->where('date', '>=', $dates[0]);
                                $q->where('date', '<=', $dates[1]);
                            }])->where('id', $id)->get();
                        }
                    }else{
                        foreach($employee_id as $id){
                            $getData[] = Employee::with(['absent' => function($q) use($dates){
                                $q->where('date', '>=', $dates[1]);
                                $q->where('date', '<=', $dates[0]);
                            }])->where('id', $id)->get();
                        }
                    }
                }
            }

            // ---BY-DATES----
            if($dates && !$employee_id){
                if(count($dates) == 1){
                    $getData[] = Employee::with(['absent' => function($q) use($dates){
                        $q->where('date', $dates[0]);
                    }])->get();
                }else{
                    if($dates[1] > $dates[0]){
                        $getData[] = Employee::with(['absent' => function($q) use($dates){
                            $q->where('date', '>=', $dates[0]);
                            $q->where('date', '<=', $dates[1]);
                        }])->get();
                    }else{
                        $getData[] = Employee::with(['absent' => function($q) use($dates){
                            $q->where('date', '>=', $dates[1]);
                            $q->where('date', '<=', $dates[0]);
                        }])->get();
                    }
                }
            }

            // ---BY-EMPLOYEE---
            if($employee_id && !$dates){
                foreach($employee_id as $id){
                    $getData[] = Employee::with('absent')->where('id', $id)->get();
                }
            }

            // -----result-------
            foreach($getData as $items){
                foreach($items as $item){
                    if($dates && $employee_id)
                    {
                        $absent_total = 0;
                        foreach($item->absent as $absent)
                        {
                            $absent_total = $absent_total + $absent->number;
                        }
                        $report[] = array(
                            'id' => $item->id,
                            'name' => $item->name,
                            'pic' => $item->pic,
                            'position' => $item->position,
                            'profile_color' => $item->profile_color,
                            'absent_total' => $absent_total,
                            'absent_count' => count($item->absent),
                            'absents' => $item->absent,
                        );
                    }elseif($employee_id && !$dates)
                    {
                        $absent_total = 0;
                        foreach($item->absent as $absent)
                        {
                            $absent_total = $absent_total + $absent->number;
                        }
                        $report[] = array(
                            'id' => $item->id,
                            'name' => $item->name,
                            'pic' => $item->pic,
                            'position' => $item->position,
                            'profile_color' => $item->profile_color,
                            'absent_total' => $absent_total,
                            'absent_count' => count($item->absent),
                            'absents' => $item->absent,
                        );
                    }elseif($dates){
                        if(count($item->absent) > 0){
                            $absent_total = 0;
                            foreach($item->absent as $absent)
                            {
                                $absent_total = $absent_total + $absent->number;
                            }
                            $report[] = array(
                                'id' => $item->id,
                                'name' => $item->name,
                                'pic' => $item->pic,
                                'position' => $item->position,
                                'profile_color' => $item->profile_color,
                                'absent_total' => $absent_total,
                                'absent_count' => count($item->absent),
                                'absents' => $item->absent,
                            );
                        }
                    }
                }
            }

            return $report;

        }else{
            return response()->json(['message' => 'no result']);
        }
    }
}
