<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\userData;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function read(){
        return new userData(User::with('role')->orderBy('id', 'DESC')->get());
    }
}
