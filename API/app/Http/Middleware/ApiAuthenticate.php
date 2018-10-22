<?php

namespace App\Http\Middleware;

//use App\AuthToken;
use Closure;
use Illuminate\Support\Facades\Lang;

class ApiAuthenticate
{
    public function __construct(
    )
    {
        $this->apiErrorCode = Lang::get('apiErrorCode');
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        $request->attributes->add([
                    'token' => $token,
                    'user' => null
                ]);

//        $response = array(
//            "error" => true,
//            "data" => null,
//            "errors" => array([
//                'errorCode'=>$this->apiErrorCode['ApiErrorCodes']['token_error'],
//                'errorMessage'=>$this->apiErrorCode['token_error']
//            ])
//        );
//        return response()->json($response, 400, array());
//        if ($token && $authToken = AuthToken::where('token', $token)->first()) {
//            if ($authToken->isExpired()) {
//                throw new Exception('Token is expired.', 1001);
//            } else {
//                $authToken->extendExpiry();
//
//                // put auth token to request
//                $request->attributes->add([
//                    'token' => $token,
//                    'user' => $authToken->owner
//                ]);
//            }
//        } else {
//            throw new Exception('Unauthorized', 1000);
//        }

        return $next($request);
    }
}
