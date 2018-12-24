<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\VerifyResetUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */
    protected $redirectTo = '/store';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm()
    {
        return view('auth.passwords.reset');
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset($userId,$token, Request $request)
    {
        $password = $request->get('password');
        $this->guard()->logout();
        $verifyUser = VerifyResetUser::where('token', $token)->where('user_id',$userId)->where('reset', 1)->first();
        if(isset($verifyUser) ){
            $user = User::find($verifyUser->user_id);
            $user->password = bcrypt($password);
            $user->save();
//            if($result) {
//                $status = "Your password has been reset. You can now using with new password ";
//            }else{
//                $status = "Your email is already verified. You can now using our services.";
//            }
        }
        return redirect(route('home'));
    }


    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }


}
