<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Absent\absentData;
use App\Models\Absent;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsentController extends Controller
{
    public function read()
    {
        $absents = Absent::with(['employee' => function($q){
            $q->where('is_inactive', false);
        }])
        ->OrderBy('date')
        ->get();

        $absentData = array();
        foreach ($absents->reverse() as $key => $absent){
            if($absent->employee){
                $absentData[] = array(
                    'no' => $key + 1,
                    'id' => $absent->id,
                    'absent' => $absent->absent,
                    'absent_time' => $absent->absent_time,
                    'day' => $absent->day,
                    'date' => $absent->date,
                    'year_month' => $absent->year_month,
                    'description' => $absent->description,
                    'employee' => [
                        'id' => $absent->employee->id,
                        'name' => $absent->employee->name,
                        'image' => $absent->employee->pic,
                        'profile_color' => $absent->employee->profile_color,
                    ],
                );
            }
        }
        return $absentData;
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'employee_id' => 'required|integer',
            'absent' => 'in:fullday,halfday',
            'date' => 'required'
        ], [
            'employee_id.required' => 'select employee.',
        ]);

        if($request->absent == 'halfday'){
            $this->validate($request, [
                'absent_time' => 'in:morning,afternoon'
            ]);
        }

        $absent = new Absent();
        $absent->employee_id = $request->employee_id;

        $absent->date = $request->date;
        $date = $request->date;
        $day = new DateTime($date);
        $absent->day = $day->format('l');

        if($request->absent == 'fullday')
        {
            $absent->number = 1;
        }

        if($request->absent == 'halfday')
        {
            $absent->number = 0.5;
        }

        $absent->absent_time = $request->absent_time;
        $absent->absent = $request->absent;
        $absent->description = $request->description;
        $absent->year_month = $day->format('Y-m');
        $absent->save();
        return response()->json(['message' => 'Absent save successfully.'], 200);
    }

    public function update(Request $request, $id){

        $this->validate($request, [
            'employee_id' => 'required|integer',
            'absent' => 'in:fullday,halfday',
            'date' => 'required'
        ], [
            'employee_id.required' => 'select employee.',
        ]);

        if($request->absent == 'halfday'){
            $this->validate($request, [
                'absent_time' => 'in:morning,afternoon'
            ]);
        }

        $absent = Absent::findOrFail($id);

        $absent->date = $request->date;
        $date = $request->date;
        $day = new DateTime($date);
        $absent->day = $day->format('l');

        if($request->absent == 'fullday')
        {
            $absent->number = 1;
            $absent->absent_time = null;
        }

        if($request->absent == 'halfday')
        {
            $absent->number = 0.5;
            $absent->absent_time = $request->absent_time;
        }

        $absent->absent = $request->absent;
        $absent->employee_id = $request->employee_id;
        $absent->date = $request->date;
        $absent->description = $request->description;
        $absent->year_month = $day->format('Y-m');
        $absent->save();
        return response()->json(['message' => 'Absent update successfully.'], 200);
    }

    public function delete($id){
        $absent = Absent::findOrFail($id);
        $absent->delete();
        return response()->json(['message' => 'Absent delete successfully.'], 200);
    }
}
