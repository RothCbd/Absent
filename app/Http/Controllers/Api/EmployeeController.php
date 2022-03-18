<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Employee\employeeData;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    public function active()
    {
        return new employeeData(Employee::where('is_inactive', false)->orderBy('id', 'DESC')->get());
    }

    public function inactive()
    {
        return new employeeData(Employee::where('is_inactive', true)->orderBy('id', 'DESC')->get());
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|max:255|regex:/(.*)\.com/i|unique:employees,email',
            'gender' => 'required',
            'position' => 'required',
            'start_date' => 'required',
            'phone_number' => 'required|unique:employees,phone_number',
        ]);

        $employee = new Employee();
        $employee->name = $request->name;
        $employee->gender = $request->gender;
        $employee->email = $request->email;
        $employee->position = Str::title($request->position);
        $employee->start_date = $request->start_date;

        $phoneEmpty = array(['phone' => null]);
        foreach($request->phone_number as $phoneNum){
            if($phoneNum['phone'] != null){
                $employee->phone_number = $request->phone_number;
            }else{
                $employee->phone_number = $phoneEmpty;
            }
        }

        $slug = Str::slug($request->name, '-');
        if($request->hasfile('image'))
        {
            $this->validate($request, [
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $name = $slug.'-'.time().'-'.$request->image->getClientOriginalName();
            \Image::make($request->image)->save(public_path('employees/').$name);
            $employee->pic = $name;
        }

        $employee->profile_color = substr(uniqid(),-6);

        $employee->save();
        return response()->json(['message' => 'Employee data save successfully'], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|max:255|regex:/(.*)\.com/i|unique:employees,email,'.$id,
            'gender' => 'required',
            'position' => 'required',
            'start_date' => 'required',
            'phone_number' => 'required|unique:employees,phone_number,'.$id,
        ]);

        $employee = Employee::findOrFail($id);
        $employee->name = $request->name;
        $employee->gender = $request->gender;
        $employee->email = $request->email;
        $employee->position = Str::title($request->position);
        $employee->start_date = $request->start_date;

        $phoneEmpty = array(['phone' => null]);
        foreach($request->phone_number as $phoneNum){
            if($phoneNum['phone'] != null){
                $employee->phone_number = $request->phone_number;
            }else{
                $employee->phone_number = $phoneEmpty;
            }
        }

        $slug = Str::slug($request->name, '-');
        if($request->hasfile('image'))
        {
            $this->validate($request, [
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $url = public_path('employees/'.$employee->pic);
            if (file_exists($url)){
                unlink(public_path('employees/'.$employee->pic));
            }

            $name = $slug.'-'.time().'-'.$request->image->getClientOriginalName();
            \Image::make($request->image)->save(public_path('employees/').$name);
            $employee->pic = $name;
        }

        $employee->	is_inactive = $request->is_inactived;
        $employee->save();

        return response()->json(['message' => 'Employee update successfully.'], 200);
    }

    public function delete($id){

        $employee = Employee::findOrFail($id);
        $url = public_path('employees/'.$employee->pic);
        if (file_exists($url))
        {
            unlink(public_path('employees/'.$employee->pic));
        }

        $employee->delete();
        return response()->json([ 'message' => 'Employee data delete successfully.' ], 200);
    }
}
