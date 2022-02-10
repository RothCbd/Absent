<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\userData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{

    // ==============READ==================
    public function read()
    {
        return new userData(User::with('role')->orderBy('id', 'DESC')->get());
    }

    // =============CREATE=================
    public function create(Request $request)
    {
        $this->validate($request, [
            'role_id' => 'required|integer|max:2|min:1',
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|max:255|regex:/(.*)\.com/i|unique:users,email',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|confirmed|min:6'
        ], [
            'role_id.required' => 'The user role is required number1(admin), number2(user).',
            'role_id.min' => 'The role number must be at least 1.',
            'role_id.max' => 'The role number must not be greater than 2.'
        ]);

        if(auth('sanctum')->user()->role->role != 'admin')
        {
            return response()->json(['message' => 'You not have permission!'], 403);
        }

        $user = new User();
        $user->role_id = $request->role_id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->password = Hash::make($request->password);
        $slug = Str::slug($request->name, '-');
        if($request->hasfile('image'))
        {
            $name = $slug.'-'.time().'-'.$request->image->getClientOriginalName();
            \Image::make($request->image)->save(public_path('profiles/').$name);
            $user->profile = $name;
        }
        else{
            $user->profile = 'default.png';
        }
        $user->save();
        return response()->json(['message' => 'User save succeefully.'], 200);
    }

    // ==========UDATE============
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'role_id' => 'required|integer|max:2|min:1',
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|max:255|regex:/(.*)\.com/i|unique:users,email,'.$id,
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'role_id.required' => 'The user role is required number 1:admin and 2:User.',
            'role_id.min' => 'The role number must be at least 1.',
            'role_id.max' => 'The role number must not be greater than 2.'
        ]);

        if(auth('sanctum')->user()->role->role != 'admin')
        {
            return response()->json(['message' => 'You not have permission!'], 403);
        }

        $user = User::findOrFail($id);
        $user->role_id = $request->role_id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $slug = Str::slug($request->name, '-');
        if($request->hasfile('image'))
        {
            $url = public_path('profiles/'.$user->profile);
            if (file_exists($url)){
                unlink(public_path('profiles/'.$user->profile));
            }

            $name = $slug.'-'.time().'-'.$request->image->getClientOriginalName();
            \Image::make($request->image)->save(public_path('profiles/').$name);
            $user->profile = $name;
        }
        else{
            $user->profile = $user->profile;
        }
        $user->save();
        return response()->json(['message' => 'User updated successfully.'], 200);
    }


    public function delete($id)
    {
        if(auth('sanctum')->user()->role->role != 'admin')
        {
            return response()->json(['message' => 'You not have permission!'], 403);
        }

        $user = User::findOrFail($id);
        $url = public_path('profiles/'.$user->profile);
        if (file_exists($url))
        {
            unlink(public_path('profiles/'.$user->profile));
        }

        $user->delete();
        return response()->json([ 'message' => 'User data delete successfully.' ], 200);
    }
}
