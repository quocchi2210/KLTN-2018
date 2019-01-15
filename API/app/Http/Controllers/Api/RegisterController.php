<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\VerifyMail;
use App\Store;
use App\User;
use App\VerifyResetUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Log;

class RegisterController extends Controller {
	/**
	 * @SWG\Post(
	 *   path="/api/register",
	 *   summary="Register",
	 *     tags={"User"},
	 *   @SWG\Parameter(
	 *     name="email",
	 *     in="query",
	 *     description="Your Email",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="type",
	 *     in="query",
	 *     description="Login with Email/Phone Number",
	 *     type="string",
	 *     required=true,
	 *     enum={"Email", "Phone"}
	 *   ),
	 *   @SWG\Parameter(
	 *     name="username",
	 *     in="query",
	 *     description="Your Username",
	 *     type="string",
	 *   ),
	 *     @SWG\Parameter(
	 *     name="name",
	 *     in="query",
	 *     description="Your Full Name",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="date_of_birth",
	 *     in="query",
	 *     description="Date of Birth",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="gender",
	 *     in="query",
	 *     description="You Gender",
	 *     type="string",
	 *     required=true,
	 *     enum={"male", "female"}
	 *   ),
	 *   @SWG\Parameter(
	 *     name="password",
	 *     in="query",
	 *     description="Your Password",
	 *     type="string",
	 *     format="password",
	 *   ),
	 *     @SWG\Parameter(
	 *     name="confirm",
	 *     in="query",
	 *     description="Confirmed",
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
	protected function register(Request $request) {
		$type = 'Email';
		if ($type == 'Email') {
			return $this->registerEmail($request);}

		if ($type == 'Phone') {
			return $this->registerPhone($request);
		}
	}
	public function registerEmail(Request $request) {
		$rules = new User;
		$email = $request->get('email');
		$username = $request->get('username');
		$name_store = $request->get('name_store');
		$check_email_exist = false;
		// $dataEmail = User::where('email', $email)->first();
		// $dataUsername = User::where('username', $username)->first();

		$users = User::all();

		foreach ($users as $user) {

			//Log::debug("123 " . print_r($user['idUser'], 1));
			if ($email === $user['email']) {

				$check_email_exist = true;
			}
		}

		// if ($dataEmail) {
		// 	return $this->respondWithErrorMessage('This email has been exists', 2018);
		// }

		// if ($dataUsername) {
		// 	return $this->respondWithErrorMessage('This username has been exists', 2019);
		// }

		// $message = [
		// 	'name.required' => 'The name is required',
		// 	'name.max' => 'The name may not be greater than 255',
		// 	'email.required' => 'The email is required',
		// 	'email.email' => 'The email must be a valid email address.',
		// 	'email.regex' => 'The email is not correct format',
		// 	'password.required' => 'The password is required',
		// 	'password.min' => 'The password must be at least 6.',
		// 	'date_of_birth.required' => 'The date of birth is required',
		// 	'date_of_birth.date' => 'The date of birth is not correct format',
		// 	'gender.required' => 'The gender is required',
		// 	'gender.regex' => 'The gender must be male or female',

		// ];
		// $validator = Validator::make($request->all(), $rules->ruleCustom['RULE_USERS_CREATE'], $message);
		// if ($validator->fails()) {
		//		 	return $this->errorWithValidation($validator);
		//		 }
		$create = User::create([
			'fullName' => encrypt($request['name']),
			'email' => encrypt($request['email']),
			'username' => encrypt($request['username']),
			'password' => bcrypt($request['password']),
			'dateOfBirth' => encrypt($request->input('date_of_birth')),
			'gender' => encrypt($request->input('gender')),
		]);

		if ($create->idUser) {
			Store::create([
				'idUser' => $create->idUser,
				'nameStore' => encrypt($name_store),
			]);
			// $this->guard()->login($user);
			// return redirect(route('home'));
		}

		$verifyUser = VerifyResetUser::create([
			'user_id' => $create->idUser,
			'token' => str_random(32),
			'confirmation' => 1,
		]);

		$userDecypt = User::find($create->idUser);
		Mail::to($userDecypt->email)->send(new VerifyMail($userDecypt, $verifyUser));

		return response()->json([
			'error' => false,
			'check_email_exist' => $check_email_exist,
			'errors' => null,
		], 200);
	}
	public function registerPhone(Request $request) {
		$rules = new User;
		$message = [
			'name.required' => 'The name is required',
			'name.alpha' => 'The name may only contain letters',
			'name.max' => 'The name may not be greater than 255',
			'phone_number.required' => 'The phone number is required',
			'phone_number.regex' => 'The phone number is not correct format',
			'password.required' => 'The password is required',
			'password.min' => 'The password must be at least 6.',
			// 'country_code.required' => 'The country code is required',
			// 'country_code.numeric' => 'The country code must be a number.',
			// 'date_of_birth.required' => 'The date of birth is required',
			// 'date_of_birth.date' => 'The date of birth is not correct format',
			// 'gender.required' => 'The gender is required',
			// 'gender.regex' => 'The gender must be male or female',
			// 'init_lat.required' => 'The latitude is required',
			// 'init_lat.regex' => 'The latitude must be a number between -90 and 90',
			// 'init_lng.required' => 'The longitude is required',
			// 'init_lng.regex' => 'The longitude must be a number between -180 and 180',
			// 'address.required' => 'The address is required',
			// 'address.max' => 'The address may not be greater than 60 character.',
			// 'about.required' => 'You must be fill about yourself',
			// 'about.max' => 'About yourself may not be greater than 255 character.',

		];
		$validator = Validator::make($request->all(), $rules->ruleCustom['RULE_USERS_CREATE_PHONE'], $message);
		if ($validator->fails()) {
			return $this->errorWithValidation($validator);
		}
		$create = User::create([
			'name' => $request['name'],
			'phone_number' => $request['phone_number'],
			'country_code' => $request['country_code'],
			'password' => bcrypt($request['password']),
			'date_of_birth' => $request->input('date_of_birth'),
			'gender' => $request->input('gender'),
			'init_lat' => $request->input('init_lat'),
			'init_lng' => $request->input('init_lng'),
			'address' => $request->input('address'),
			'about' => $request->input('about'),
			'qr_code' => str_random(80),
		]);
		return response()->json([
			'error' => false,
			'data' => $create,
			'errors' => null,
		], 200);
	}
}
