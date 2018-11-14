<?php

namespace App\Http\Controllers\Auth;

use App\Store;
use App\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;


class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/store/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'Store.name' => 'required|string|max:255',
            'User.email' => 'required|string|email|max:255|unique:users',
            'User.password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
//    protected function create(array $data)
//    {
//        return User::create([
//            'name' => $data['name'],
//            'email' => $data['email'],
//            'password' => bcrypt($data['password']),
//        ]);
//    }
    public function register(Request $request)
    {
        $storeRequest = $request->get('Store');
        $userRequest = $request->get('User');
        $user = User::create([
            'email' => $userRequest['email'],
            'password' => bcrypt($userRequest['password']),
        ]);
        if ($user->idUser) {
            Store::create([
                'idUser' => $user->idUser,
                'nameStore' => $storeRequest['name']
            ]);
            $this->guard()->login($user);
            return redirect(route('home'));
        }
    }
}
