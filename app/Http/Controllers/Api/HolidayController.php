<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Holiday;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    public function read()
    {
        $year = Carbon::now()->year;
        return Holiday::orderBy('date', 'ASC')->where('date', $year)->get();
    }

    public function readDate()
    {
        $year = Carbon::now()->year;
        $holidays = Holiday::orderBy('date', 'ASC')->where('date', $year)->get();
        $getDates = array();
        foreach($holidays as $holiday){
            $getDates[] = $holiday->date;
        }

        return $getDates;
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'date' => 'required|date_format:Y-m-d|unique:holidays,date',
            'holiday' => 'required|min:3'
        ]);

        $holiday = new Holiday();
        $holiday->date = $request->date;
        $day = new DateTime($request->date);
        $holiday->day = $day->format('l');
        $holiday->holiday = $request->holiday;

        $holiday->save();
        return response()->json(['message' => 'Holiday was saved successfully.'], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'date' => 'required|date_format:Y-m-d|unique:holidays,date,'.$id,
            'holiday' => 'required|min:3'
        ]);

        $holiday = Holiday::findOrFail($id);
        $holiday->date = $request->date;
        $day = new DateTime($request->date);
        $holiday->day = $day->format('l');
        $holiday->holiday = $request->holiday;

        $holiday->save();
        return response()->json(['message' => 'Holiday was updated successfully.'], 200);
    }

    public function delete($id){
        $holiday = Holiday::findOrFail($id);
        $holiday->delete();
        return response()->json(['message' => 'Holiday deleted successfully.'], 200);
    }
}
