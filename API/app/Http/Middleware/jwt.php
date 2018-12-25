<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class jwt {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {

		try {
			JWTAuth::parseToken()->authenticate();

			// $idUser = auth()->user()->idUser;

			// $request->request->add(
			// 	array(
			// 		'idUser' => $idUser,
			// 	)

			// );

			//Log::debug('$REQUEST HANDLE JWT' . print_r($request, 1));

		} catch (\Exception $e) {
			if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
				return response()->json(['status' => 'Token is Invalid']);
			} else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
				return response()->json(['status' => 'Token is Expired']);
			} else {
				return response()->json(['status' => 'Authorization Token not found']);
			}
		}
		return $next($request);
	}
}
