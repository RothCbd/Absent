<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

        $responese = [
            'user' => $user,
            'token' => $token
        ];

        return response($responese, 201);
    }

    public function login(Request $request){

        $this->validate($request, [
            'email' => 'required|string|email',
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

    public function logout(Request $request){
        $request->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response()->json('Logged out successfully', 200);
    }

    public function userData(){
        return response()->json([
            'user' => User::with('role')->get()
        ]);
    }

    // ============Profile UPdate================
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required|min:2|max:50',
            'email' => 'required|email|max:255|regex:/(.*)\.com/i|unique:users,email,'.$id,
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        $slug = Str::slug($request->name, '-');
        if($request->hasfile('profile'))
        {
            $this->validate($request, [
                'profile' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $name = $slug.'-'.time().'-'.$request->profile->getClientOriginalName();
            \Image::make($request->profile)->save(public_path('profiles/').$name);
            $user->profile = $name;
        }

        if($request->profile){
            $url = public_path('profiles/'.$user->profile);
            if (file_exists($url)){
                unlink(public_path('profiles/'.$user->profile));
            }

            $folderPath = public_path('profiles/');
            $image_parts = explode(";base64,", $request->profile);
            $image_base64 = base64_decode($image_parts[1]);
            $imageName = auth('sanctum')->user()->id.'-'.uniqid() . '.png';
            $imageFullPath = $folderPath.$imageName;
            file_put_contents($imageFullPath, $image_base64);
            $user->profile = $imageName;
        }

        $user->save();

        return response()->json([
            'message' => "Profile updat succefully",
            'user' => $user
        ]);
    }
}
