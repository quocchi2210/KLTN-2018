<?php

namespace App\Http\Controllers\Auth;

use App\Mail\VerifyMail;
use App\Store;
use App\User;
use Config;
use App\Helper;
use App\Http\Controllers\Controller;
use App\VerifyResetUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
    protected $redirectTo = '/store';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
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
        $fullNameRequest = $request->get('fullName');
        $user = User::create([
            'email' => encrypt($userRequest['email']),
            'fullName' => encrypt($fullNameRequest['name']),
            'password' => bcrypt($userRequest['password'])
        ]);
        $verifyUser = VerifyResetUser::create([
            'user_id' => $user->idUser,
            'token' => str_random(32),
            'confirmation' => 1
        ]);
        if ($user->idUser) {
            Store::create([
                'idUser' => $user->idUser,
                'nameStore' => encrypt($storeRequest['name']),
            ]);
        }
        $userDecypt = User::find($user->idUser);
        Mail::to($userDecypt->email)->send(new VerifyMail($userDecypt,$verifyUser));
        $this->guard()->login($user);
        return redirect(route('home'));

    }
    public function verifyUser($userId,$token)
    {
        $this->guard()->logout();
        $verifyUser = VerifyResetUser::where('token', $token)->where('user_id',$userId)->where('confirmation', 1)->first();
        if(isset($verifyUser) ){
            $user = $verifyUser->user;
            if(!$user->isActivated) {
                $verifyUser->user->isActivated = 1;
                $verifyUser->user->save();
                $status = "Your email is verified. You can now using our services ";
            }else{
                $status = "Your email is already verified. You can now using our services.";
            }
        }
        $this->guard()->login($user);
        return redirect(route('home'))->with('status', $status);
    }
}
