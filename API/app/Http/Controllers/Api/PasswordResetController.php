<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use Auth;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    /** @SWG\Post(
*   path="/api/user/reset",
*   summary="Reset Password",
     *     tags={"User"},
*   @SWG\Parameter(
*     name="email",
*     in="query",
*     description="Your Email",
*     type="string",
*   ),
     *   @SWG\Response(
     *     response=200,
     *     description="A list with products"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     *)
     */
    public function resetUser(Request $request){
        $errorCode = $this->apiErrorCodes;
        $email = $request->get('email');
        $user = User::where('email',$email['email'])->first();
        if ($user){

            $resetPassword = VerifyResetUser::create([
            'user_id' => $user->idUser,
            'token' => str_random(32),
            'reset' => 1
            ]);
            Mail::to($user->email)->send(new ResetPassword($user,$resetPassword));
            return response() ->json([
                'error' => false,
                'data' => 'Your new password sending successful!!! Check your email',
                'errors' =>null
            ],200);
        }
        else {
            return $this->respondWithErrorMessage(
                $errorCode['no_email'],
                $errorCode['ApiErrorCodes']['no_email'], 400);
         

    }
}



