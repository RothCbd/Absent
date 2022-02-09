<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){

        // $users = User::with('role')->select(['users.name', 'users.email'])->get();
        return User::select('name', 'email', 'profile')->with(['role'])->get();

        return response()->json([
            'data' => $users
        ]);
    }
}
