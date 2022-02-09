<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $this->validate($request, [
            'name' => 'required|max:50,min:2|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $token = $user->createToken('myapptoken')->plainTextToken;

        // event(new Registered($user));

        $responese = [
            'user' => $user,
            'token' => $token
        ];

        return response($responese, 201);
    }

    public function login(Request $request){

        $this->validate($request, [
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response([
                'message' => 'Credentials not match'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $responese = [
            'user' => $user,
            'token' => $token
        ];

        return response($responese, 201);
    }


    public function userData(){
        return response()->json([
            'user' => User::with('role')->get()
        ]);
    }
}
