<?php

namespace App\Http\Controllers\Auth;

use App\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class RegisterController extends Controller
{
    public function register(Request $request)
    {
        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);
    }
}
