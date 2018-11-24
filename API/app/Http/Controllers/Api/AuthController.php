<?php

namespace App\Http\Controllers;

use App\Token;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Log;
/**
 * @SWG\Swagger(
 *   basePath="/",
 *   @SWG\Info(
 *     version="2.0.0",
 *     title="API Swagger",
 *  ),
 * @SWG\SecurityScheme(
 *   securityDefinition="api_key",
 *   type="apiKey",
 *   in="header",
 *   name="Authorization"
 * )
 * )
 */
class AuthController extends Controller {
	/**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
    	//auth:api
        $this->middleware('jwt', ['except' => ['loginJWT']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginJWT()
    {
    	   Log::debug('hello kitty'.print_r(Auth::user(),1));
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logoutJWT()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
	/**
	 *   @SWG\Response(
	 *     response="default",
	 *     description="an ""unexpected"" error"
	 *   )
	 * @SWG\Post(
	 *   path="/api/login",
	 *   summary="Login",
	 *     tags={"User"},
	 *   @SWG\Parameter(
	 *     name="type",
	 *     in="query",
	 *     description="Login with Email/Phone Number",
	 *     type="string",
	 *     required=true,
	 *     enum={"Email", "Phone"}
	 *   ),
	 *   @SWG\Parameter(
	 *     name="email",
	 *     in="query",
	 *     description="Your Email",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="country_code",
	 *     in="query",
	 *     description="Your Country Code",
	 *     type="string",
	 *   ),
	 *     @SWG\Parameter(
	 *     name="phone_number",
	 *     in="query",
	 *     description="Your Phone Number",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="password",
	 *     in="query",
	 *     description="Your Password",
	 *     type="string",
	 *     format="password",
	 *   ),
	 *   @SWG\Response(
	 *     response=200,
	 *     description="A list with products"
	 *   ),
	 *   @SWG\Response(
	 *     response="default",
	 *     description="an ""unexpected"" error"
	 *   )
	 * )
	 */
	public function login(Request $request) {
		$type = $request->get('type');
		if ($type == 'Email') {
			return $this->loginEmail($request);
		}
		if ($type == 'Phone') {
			return $this->loginPhone($request);
		}
	}
	public function loginEmail(Request $request) {
		$errorCode = $this->apiErrorCodes;
		$email = $request->get('email');
		$password = $request->get('password');
		$rules = new User;
		$message = [
			'email.required' => 'The email is required',
			'email.email' => 'The email must be a valid email address.',
			'email.regex' => 'The email is not correct format',
			'password.required' => 'The password is required',
		];
		$validator = Validator::make($request->all(), $rules->ruleCustom['RULE_USER_CHECK'], $message);
		if ($validator->fails()) {
			return $this->errorWithValidation($validator);
		}
        $input = $request->only('email', 'password');
        $jwt_token = null;

        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }
        return response()->json([
            'success' => true,
            'token' => $jwt_token,
        ]);

//		return $this->respondWithErrorMessage(
//			$errorCode['authentication'],
//			$errorCode['ApiErrorCodes']['authentication'], 400);
	}
	public function loginPhone(Request $request) {
		$errorCode = $this->apiErrorCodes;
		$CountryCode = $request->get('country_code');
		$phone = $request->get('phone_number');
		$password = $request->get('password');
		$rules = new User;
		$message = [
			'country_code.numeric' => 'The country code must be a number',
			'country_code.required' => 'The country code number is required',
			'phone_number.required' => 'The phone number is required',
			'phone_number.regex' => 'The phone number is not correct format',
		];
		$validator = Validator::make($request->all(), $rules->ruleCustom['RULE_USER_CHECK_PHONE'], $message);
		if ($validator->fails()) {
			return $this->errorWithValidation($validator);
		}
		if ($CountryCode != null) {
			if (auth::attempt(['country_code' => $CountryCode, 'phone_number' => $phone, 'password' => $password])) {
				Token::create([
					'tokens' => str_random(32),
					'user_token_id' => auth()->user()->idUser,
					'expired_at' => Carbon::now()->addDays(30),
				]);
				// User::where('idUser', auth()->user()->idUser)->update(['disabled' => false]);
				$user = DB::table('users')
					->join('tokens', 'users.idUser', '=', 'tokens.user_token_id')
					->select('users.idUser', 'users.fullName', 'users.email', 'users.phone_number', 'tokens.token', 'tokens.expired_at')
					->get()
					->last();
				return response()->json([
					'error' => false,
					'data' => $user,
					'errors' => null,
				], 200);
			} else {
				return $this->respondWithErrorMessage(
					$errorCode['authentication'],
					$errorCode['ApiErrorCodes']['authentication'], 400);
			}
		} else {
			$phone = substr($phone, 1);
			if (auth::attempt(['phone_number' => $phone, 'password' => $password])) {
				Token::create([
					'token' => str_random(32),
					'user_token_id' => auth()->user()->idUser,
					'expired_at' => Carbon::now()->addDays(30),
				]);
				// User::where('id', auth()->user()->id)->update(['disabled' => false]);
				$user = DB::table('users')
					->join('tokens', 'users.idUser', '=', 'tokens.user_token_id')
					->select('users.idUser', 'users.name', 'users.email', 'users.phone_number', 'tokens.token', 'tokens.expired_at')
					->get()
					->last();
				return response()->json([
					'error' => false,
					'data' => $user,
					'errors' => null,
				], 200);
			} else {
				return $this->respondWithErrorMessage(
					$errorCode['authentication'],
					$errorCode['ApiErrorCodes']['authentication'], 400);
			}
		}

	}

/** @SWG\Post(
 *   path="/api/logout",
 *   summary="Logout",
 *     tags={"User"},
 * security={{"api_key": {}}},
 *     @SWG\Response(
 *     response=200,
 *     description="A list with products"
 *   ),
 *   @SWG\Response(
 *     response="default",
 *     description="an ""unexpected"" error"
 *   )
 *   )
 */
	public function logout(Request $request) {
		$token = $request->header('token');
		//return array("err" => false,...)
		//  return $this->respondWithSuccess($token);
		$idUser = User::where('id', (DB::table('tokens')->where('token', $token)->first()->user_token_id))->first()->id;
		DB::table('token')->where('user_token_id', '=', $idUser)->delete();
		return response()->json([
			'error' => false,
			'data' => array((object) array('Messaage' => 'Logout Success !!!',
			)),
			'errors' => null,
		], 400);
	}
}