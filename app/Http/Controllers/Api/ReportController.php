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
        $getData = array();
        $report = array();

        if($dates || $employee_id){

            // ========By=Employee_id==Date========
            if($dates && $employee_id){
                if(count($dates) == 1){
                    foreach($employee_id as $id){
                        $getData[] = Absent::with('employee')->where('employee_id', $id)->where('date', $dates[0])->get();
                    }
                    foreach($getData as $items){
                        foreach($items as $item){
                            $report[] = array(
                                'day' => $item->day,
                                'date' => $item->date,
                                'employee' => [
                                    'name' => $item->employee->name,
                                    'pic' => $item->employee->pic,
                                ]
                            );
                        }
                    }
                    return $report;

                }else{
                    if($dates[1] > $dates[0]){
                        foreach($employee_id as $id){
                            $getData[] = Absent::with('employee')->where('employee_id', $id)->where('date', '>=', $dates[0])->where('date', '<=', $dates[1])->get();
                        }
                        foreach($getData as $items){
                            foreach($items as $item){
                                $report[] = array(
                                    'day' => $item->day,
                                    'date' => $item->date,
                                    'employee' => [
                                        'name' => $item->employee->name,
                                        'pic' => $item->employee->pic,
                                    ]
                                );
                            }
                        }
                        return $report;

                    }else{
                        foreach($employee_id as $id){
                            $getData[] = Absent::with('employee')->where('employee_id', $id)->where('date', '>=', $dates[1])->where('date', '<=', $dates[0])->get();
                        }
                        foreach($getData as $items){
                            foreach($items as $item){
                                $report[] = array(
                                    'day' => $item->day,
                                    'date' => $item->date,
                                    'employee' => [
                                        'name' => $item->employee->name,
                                        'pic' => $item->employee->pic,
                                    ]
                                );
                            }
                        }
                        return $report;
                    }
                }
            }

            // ========BY=DATE=========
            if($dates){
                if(count($dates) == 1){
                    return Absent::with('employee')->where('date', $dates[0])->get();
                }else{
                    if($dates[1] > $dates[0]){
                        return Absent::with('employee')->where('date', '>=', $dates[0])->where('date', '<=', $dates[1])->get();
                    }else{
                        return Absent::with('employee')->where('date', '>=', $dates[1])->where('date', '<=', $dates[0])->get();
                    }
                }
            }

            // =======BY=EMPLOYEE_ID=====
            if($employee_id){
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
                                'pic' => $item->employee->pic,
                            ]
                        );
                    }
                }
                return $report;
            }

        }else{
            return response()->json(['message' => 'Please select any Date or Employee to get report.']);
        }


        // Absent::with('employee')->where('date', $dates[0])->where('employee_id', $id)->get();
        // ============================================================================================
        $dates = $request->dates;
        $employee_id = $request->employee_id;

        if($dates || $employee_id){
            if($dates){
                if(count($dates) == 1){
                    return Absent::with('employee')->where('date', $dates[0])->get();
                }else{
                    if($dates[1] > $dates[0]){
                        return Absent::with('employee')->where('date', '>=', $dates[0])->where('date', '<=', $dates[1])->get();
                    }else{
                        return Absent::with('employee')->where('date', '>=', $dates[1])->where('date', '<=', $dates[0])->get();
                    }
                }
            }else if($employee_id){
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
                                'pic' => $item->employee->pic,
                            ]
                        );
                    }
                }
                return $report;
            }
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
                        'pic' => $item->employee->pic,
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
