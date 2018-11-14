<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;
use DB;
use Token;
use App\User;
use App\Http\Controllers\Controller;
class CheckAdmin extends Controller
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
        $token_db = DB::table('token')->where('token',$api_token)->first();
        $role_id = User::where('idUser',(DB::table('tokens')->where('token', $api_token)->first()->user_token_id))->first()->role_id;
        if(!$token_db ){
            return $this->respondWithErrorMessage(
                $errorCode['token_error'],
                $errorCode['ApiErrorCodes']['token_error'], 400);
        }
        elseif ($role_id != 5){
            return $this->respondWithErrorMessage('You are not admin',2011);
        }

        else {
                $user = User::where('idUser',(DB::table('tokens')->where('token', $api_token)->first()->user_token_id))->first();
                $authen_id = User::where('id',(DB::table('tokens')->where('token', $api_token)->first()->user_token_id))->first()->id;
                $request->request->add(array('user' => $user));
                $request->request->add(array('authen_id'=>$authen_id));
                return $next($request);
            }
    }
}
