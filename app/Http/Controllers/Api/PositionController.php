<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Position\PositionData;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
{
    public function read()
    {
        return new PositionData(Position::with('employee')->withCount('employee')->get());
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|min:2|regex:/[a-zA-Z]+$/u|max:255|unique:positions,title',
        ],[
            'title.required' => 'The Position name field is required.',
            'title.regex' => 'The Position name format is invalid.',
        ]);

        $positon = new Position();
        $positon->title = $request->title;
        $positon->save();

        return response()->json(['message' => 'Position created successfully'], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string|min:2|regex:/[a-zA-Z]+$/u|max:255|unique:positions,title,'.$id,
        ],[
            'title.required' => 'The Position name field is required.',
        ]);

        $positon = Position::findOrFail($id);
        $positon->title = $request->title;
        $positon->save();

        return response()->json(['message' => 'Position updated successfully'], 200);
    }

    public function delete($id){

        $employee = Position::findOrFail($id);
        $employee->delete();
        return response()->json([ 'message' => 'Position deleted successfully.' ], 200);
    }
}
