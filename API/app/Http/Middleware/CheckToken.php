<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Token;
use App\User;
use App\Http\Controllers\Controller;

class CheckToken extends Controller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $errorCode = $this->apiErrorCodes;
        $api_token = $request->header('token');
        $token_db = DB::table('tokens')->where('token',$api_token)->first();
        // $user_lock = User::where('idUser',(DB::table('token')->where('token', $api_token)->first()->user_token_id))->first()->locked;
        if(!$token_db ){
            return $this->respondWithErrorMessage(
                $errorCode['token_error'],
                $errorCode['ApiErrorCodes']['token_error'], 400);
        }
        // if ($user_lock == 1) {
        //     return $this->respondWithErrorMessage('You account has been lock ! Please contact with an Admin', 2013);
        // }
        else {
            $user = User::where('idUser',(DB::table('tokens')->where('token', $api_token)->first()->user_token_id))->first();
            $request->request->add(array('user' => $user));
            $authen_id = User::where('idUser',(DB::table('tokens')->where('token', $api_token)->first()->user_token_id))->first()->id;
            $request->request->add(
                array(
                    'authen_id'=>$authen_id,
                )

            );
        return $next($request);
        }
    }
}
