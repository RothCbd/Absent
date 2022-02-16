<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Report\reportData;
use App\Models\Absent;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function report(Request $request){

        $dates = $request->dates;

        if($dates){
            if(count($dates) == 1){
                return new reportData(Absent::with('employee')->where('date', $dates[0])->get());
            }else{

                if($dates[1] > $dates[0]){
                    return new reportData(Absent::with('employee')->where('date', '>=', $dates[0])->where('date', '<=', $dates[1])->get());
                }else{
                    return new reportData(Absent::with('employee')->where('date', '>=', $dates[1])->where('date', '<=', $dates[0])->get());
                }
                // return $dates[1] > $dates[0];
                // return Absent::with('employee')->whereBetween('date', $dates)->get();
                // return Absent::with('employee')->where('date', '>=', $dates[0])->where('date', '<=', $dates[1])->get();
            }
        }
    }
}
