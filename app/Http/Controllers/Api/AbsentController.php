<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Absent\absentData;
use App\Models\Absent;
use Illuminate\Http\Request;

class AbsentController extends Controller
{
    public function read(){
        return new absentData(Absent::orderBy('id', 'DESC')->get());
    }

    public function create(Request $request){

        $this->validate($request, [
            'employee_id' => 'required|integer',
            'date' => 'required'
        ]);

        $absent = new Absent();
        $absent->employee_id = $request->employee_id;
        $absent->date = $request->date;
        $absent->description = $request->description;
        $absent->save();
        return response()->json(['message' => 'Absent save successfully.'], 200);
    }

    public function update(Request $request, $id){

        $this->validate($request, [
            'employee_id' => 'required|integer',
            'date' => 'required'
        ]);

        $absent = Absent::findOrFail($id);
        $absent->employee_id = $request->employee_id;
        $absent->date = $request->date;
        $absent->description = $request->description;
        $absent->save();
        return response()->json(['message' => 'Absent update successfully.'], 200);
    }

    public function delete($id){
        $absent = Absent::findOrFail($id);
        $absent->delete();
        return response()->json(['message' => 'Absent delete successfully.'], 200);
    }
}
