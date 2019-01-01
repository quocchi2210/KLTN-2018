<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function getLogin()
    {
        if (Auth::check()) {
            return redirect('admin');
        } else {
            return view('admin.login');
        }

    }
    public function postLogin(Request $request)
    {
//        $login = [
//            'email' => $request->email,
//            'password' => $request->password,
//        ];
//        if (Auth::attempt($login)) {
//            return redirect('admin');
//        } else {
//            return redirect()->back()->with('status', 'Email hoặc Password không chính xác');
//        }
        $users = User::all();
        foreach ($users as $user) {
            if ($request->get('email') == $user['email'] && Hash::check($request->get('password'), $user['password'])) {
                auth()->login($user);
                return redirect('admin');
            }
        }
    }
    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('getLogin');
    }
}
