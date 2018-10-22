<?php

namespace App\Http\Controllers\Api\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    /**
     * @SWG\Get(
     *   path="/api/user",
     *   summary="Dashboard",
     *     tags={"Admin"},
     *   @SWG\Response(
     *     response=200,
     *     description="A list with products"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   ),
     * security={{"api_key":{}}}
     * )
     */
    public function getUser(){
        $data = User::select('id','name', 'email',DB::raw("CONCAT(country_code,phone_number) AS 'Phone Number'"),"date_of_birth AS DOB","gender AS Gender",
            DB::raw("CONCAT('(',init_lat,',',init_lng,')') AS 'Location'"),"address AS Address","about AS Bio","qr_code AS QR Code","disabled AS Inactive")->Paginate(3);
        if (empty($data)) {
            return $this->respondWithErrorMessage(
                $errorCode['no_user'],
                $errorCode['ApiErrorCodes']['no_user'], 401);
        }else{
            return $this->respondWithSuccess($data);
        }
    }
    /**
     * @SWG\Get(
     *   path="/api/user/search",
     *     tags={"Admin"},
     *   summary="Search User by Name, Email, Address",
     *    @SWG\Parameter(
     *     name="name",
     *     in="query",
     *     description="Name of user",
     *     type="string",
     *   ),
     *    @SWG\Parameter(
     *     name="email",
     *     in="query",
     *     description="Email of user",
     *     type="string",
     *   ),
     *    @SWG\Parameter(
     *     name="address",
     *     in="query",
     *     description="Address of user",
     *     type="string"
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="A list with products"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   ),
     * security={{"api_key":{}}}
     * )
     */
    public function searchUser(Request $request){
        $errorCode = $this->apiErrorCodes;
        $name = '%'.$request->get('name').'%';
        $email = '%'.$request->get('email').'%';
        $address = '%'.$request->get('address').'%';
        $user = DB::table('users')
                ->select('id','name', 'email',DB::raw("CONCAT(country_code,phone_number) AS 'Phone Number'"),"date_of_birth AS DOB","gender AS Gender",
                        DB::raw("CONCAT('(',init_lat,',',init_lng,')') AS 'Location'"),"address AS Address","about AS Bio","qr_code AS QR Code","disabled AS Inactive")
                ->when($name && $email && $address , function ($query) use ($name,$email,$address){
                return $query->whereRaw('name LIKE ? AND email LIKE ? AND address LIKE ?',[$name,$email,$address]);
                })
                ->when($name && $email && !$address , function ($query) use ($name,$email){
                return $query->whereRaw('name LIKE ? AND email LIKE ? ',[$name,$email]);
                })
                ->when($name && !$email && $address , function ($query) use ($name,$address){
                return $query->whereRaw('name LIKE ? AND address LIKE ?',[$name,$address]);
                })
                ->when(!$name && $email && $address , function ($query) use ($email,$address){
                return $query->whereRaw('email LIKE ? AND address LIKE ?',[$email,$address]);
                })
                ->when($name && !$email && !$address , function ($query) use ($name){
                    return $query->whereRaw('name LIKE ?',$name);
                })
                ->when(!$name && $email && !$address , function ($query) use ($email){
                return $query->whereRaw('email LIKE ?',$email);
                })
                ->when(!$name && !$email && $address , function ($query) use ($address){
                return $query->whereRaw('address LIKE ?',$address);
                })
                ->Paginate(3);
        if (empty($user)) {
            return $this->respondWithErrorMessage(
                $errorCode['no_user'],
                $errorCode['ApiErrorCodes']['no_user'], 401);
        }else{
            return $this->respondWithSuccess($user);
        }
    }
    /**
     * @SWG\Get(
     *   path="/api/user/sort",
     *     tags={"Admin"},
     *   summary="Sort User by Name, Age, Email, Address",
     *    @SWG\Parameter(
     *      name="sort",
     *      in="query",
     *      description="Sort By",
     *      required=true,
     *      type="string",
     *      enum={"Name", "Age","Email", "Address"},
    ),
     *    @SWG\Parameter(
     *      name="sort_status",
     *      in="query",
     *      description="Status",
     *      required=true,
     *      type="string",
     *      enum={"Desc", "Asc"},
    ),
     *   @SWG\Response(
     *     response=200,
     *     description="A list with products"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   ),
     * security={{"api_key":{}}}
     * )
     */
    public function sortUser(Request $request){
        $errorCode = $this->apiErrorCodes;
        $sort = $request->get('sort');
        $sortBy = $request->get('sort_status');
        $user = DB::table('users')
            ->select('id','name', 'email',DB::raw("CONCAT(country_code,phone_number) AS 'Phone Number'"),"date_of_birth AS DOB","gender AS Gender",
                DB::raw("CONCAT('(',init_lat,',',init_lng,')') AS 'Location'"),"address AS Address","about AS Bio","qr_code AS QR Code","disabled AS Inactive")
            ->selectRaw("FLOOR((DATEDIFF(CURRENT_DATE,STR_TO_DATE(date_of_birth,'%Y-%m-%d'))/365))as age")
            ->orderBy($sort,$sortBy)
            ->Paginate(10);
        if (empty($user)) {
            return $this->respondWithErrorMessage(
                $errorCode['no_user'],
                $errorCode['ApiErrorCodes']['no_user'], 401);
        }else{
            return $this->respondWithSuccess($user);
        }
    }
    /**
     * @SWG\Post(
     *   path="/api/user/lock",
     *   summary="Lock/Unlock User",
     *     tags={"Admin"},
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     description="Request an ID",
     *     type="string",
     *   ),
     *    @SWG\Parameter(
     *      name="role",
     *      in="query",
     *      description="Action",
     *      required=true,
     *      type="string",
     *      enum={"Lock", "Unlock"},
    ),
     *   @SWG\Response(
     *     response=200,
     *     description="A list with products"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   ),
     * security={{"api_key":{}}}
     * )
     */
    public function actionUser(Request $request){
        $role = $request->get('role');
        if ($role == 'Lock')
            return $this->lockUser($request);
        elseif ($role == 'Unlock')
            return $this->unlockUser($request);
    }
    public function lockUser(Request $request){
        $id = $request->get('id');
        $req_id = User::find($id);
        $user = User::findOrFail($request->user->id);
        if (!$req_id){
            return $this->respondWithErrorMessage('Cannot find this user',2006);
        }
        else if ($user == $req_id ){
            return $this->respondWithErrorMessage('Cannot lock youself',2003);
        }
        else
        {
            User::where('id',$req_id->id)->update(['locked'=> true,]);
            return $this->respondWithSuccess('Lock user success !!!',200);
        }
    }
    public function unlockUser(Request $request){
        $id = $request->get('id');
        $req_id = User::find($id);
        $user = User::findOrFail($request->user->id);
        if (!$req_id){
            return $this->respondWithErrorMessage('Cannot find this user',2006);
        }
        else if ($user == $req_id ){
            return $this->respondWithErrorMessage('Cannot lock youself',2003);
        }
        else
        {
            User::where('id',$req_id->id)->update(['locked'=> false,]);
            return $this->respondWithSuccess('Unlock user success !!!',200);
        }
    }
    /**
     * @SWG\Post(
     *   path="/api/user/role",
     *   summary="Assign User Role",
     *     tags={"Admin"},
     *    @SWG\Parameter(
     *      name="role",
     *      in="query",
     *      description="Action",
     *      required=true,
     *      type="string",
     *      enum={"Normal User","Premium User","Moderator", "Super Moderator","Administrator"},
    ),
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     description="Request an ID",
     *     type="string",
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="A list with products"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   ),
     * security={{"api_key":{}}}
     * )
     */
    public function actionAssignUser(Request $request){
        $id = $request->get('id');
        $role = $request->get('role');
        $req_id = User::find($id);
        $user = User::findOrFail($request->user->id);
        if (!$req_id){
            return $this->respondWithErrorMessage('Cannot find this user',2006);
        }
        else if ($user == $req_id ){
            return $this->respondWithErrorMessage('Cannot assign yourself !!!',2003);
        }
        if ($role == 'Normal User')
        {
            DB::table('users')->where('id',$req_id->id)->update(['role_id'=> 1,]);
            return $this->respondWithSuccess('Assign this user to be Normal User success !!!',200);
        }
        if ($role == 'Premium User')
        {
            DB::table('users')->where('id',$req_id->id)->update(['role_id'=> 2,]);
            return $this->respondWithSuccess('Assign this user to be Preminum User success !!!',200);
        }
        if ($role == 'Moderator')
        {
            DB::table('users')->where('id',$req_id->id)->update(['role_id'=> 3,]);
            return $this->respondWithSuccess('Assign this user to be Moderator success !!!',200);
        }
        if ($role == 'Super Moderator')
        {
            DB::table('users')->where('id',$req_id->id)->update(['role_id'=> 4,]);
            return $this->respondWithSuccess('Assign this user to be Super Moderator success !!!',200);
        }
        if ($role == 'Administrator')
        {
            DB::table('users')->where('id',$req_id->id)->update(['role_id'=> 5,]);
            return $this->respondWithSuccess('Assign this user to be Administrator success !!!',200);
        }
    }

    /**
     * @SWG\Post(
     *   path="/api/user/create",
     *   summary="Create an User",
     *     tags={"Admin"},
     *   @SWG\Parameter(
     *     name="email",
     *     in="query",
     *     description="Email",
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     name="country_code",
     *     in="query",
     *     description="Country Code",
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     name="phone_number",
     *     in="query",
     *     description="Phone Number",
     *     type="string",
     *   ),
     *     @SWG\Parameter(
     *     name="name",
     *     in="query",
     *     description="Name",
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
     *     description="Gender",
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     name="init_lat",
     *     in="query",
     *     description="Latitude",
     *     type="string",
     *   ),
     *     @SWG\Parameter(
     *     name="init_lng",
     *     in="query",
     *     description="Longitude",
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     name="address",
     *     in="query",
     *     description="Address",
     *     type="string",
     *   ),
     *    @SWG\Parameter(
     *     name="about",
     *     in="query",
     *     description="About",
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     name="password",
     *     in="query",
     *     description="Password",
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
     *   ),
     * security={{"api_key":{}}}
     * )
     */

    public function createUser(Request $request){
        $rules = new User;
        $message =[
            'name.required'             => 'The name is required',
            'name.alpha'                => 'The name may only contain letters',
            'name.max'                  => 'The name may not be greater than 255',
            'email.required'            => 'The email is required',
            'email.email'               => 'The email must be a valid email address.',
            'email.regex'               => 'The email is not correct format',
            'password.required'         => 'The password is required',
            'password.min'              => 'The password must be at least 6.',
            'date_of_birth.required'    => 'The date of birth is required',
            'date_of_birth.date'        => 'The date of birth is not correct format',
            'gender.required'           => 'The gender is required',
            'gender.regex'              => 'The gender must be male or female',
            'init_lat.required'         => 'The latitude is required',
            'init_lat.regex'            => 'The latitude must be a number between -90 and 90',
            'init_lng.required'         => 'The longitude is required',
            'init_lng.regex'            => 'The longitude must be a number between -180 and 180',
            'address.max'               => 'The address may not be greater than 60 character.',
            'about.max'                 => 'About yourself may not be greater than 255 character.',

        ];
        $validator = Validator::make($request->all(),$rules->ruleCustom['RULE_USERS_CREATE'],$message);
        if ( $validator->fails() ) {
            return $this->errorWithValidation($validator);
        }
        $email = $request->get('email');
        $data = User::where('email',$email)->first();
        if ($data)
            return $this->respondWithErrorMessage('This email has been exists',2018);
        return response() ->json([
            'error' => false,
            'data' => $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'phone_number' => $request ['phone_number'],
                'country_code' => $request ['country_code'],
                'password' => bcrypt($request['password']),
                'date_of_birth' => $request->input('date_of_birth'),
                'gender' => $request->input('gender'),
                'init_lat' => $request->input('init_lat'),
                'init_lng' => $request->input('init_lng'),
                'address' => $request->input('address'),
                'about' => $request->input('about'),
                'qr_code'=> str_random(80),
            ]),
            'errors' =>null
        ],200);
    }

    /**
     * @SWG\Get(
     *   path="/api/user/profile/{id}",
     *     tags={"Admin"},
     *   summary="Read User Profile",
     *  @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Request an ID",
     *     type="string",
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="A list with products"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   ),
     * security={{"api_key":{}}}
     * )
     */

    public function readProfile($id)
    {
        $errorCode = $this->apiErrorCodes;
        $data = User::select('id','name', 'email',DB::raw("CONCAT(country_code,phone_number) AS 'Phone Number'"),"date_of_birth AS DOB","gender AS Gender",
            DB::raw("CONCAT('(',init_lat,',',init_lng,')') AS 'Location'"),"address AS Address","about AS Bio","qr_code AS QR Code","disabled AS Inactive","locked AS Lock")
            ->where('id',$id)->first();
        if (empty($data)) {
            return $this->respondWithErrorMessage(
                $errorCode['no_user'],
                $errorCode['ApiErrorCodes']['no_user'], 401);
        }else{
            return $this->respondWithSuccess($data);
        }
    }

    /**
     * @SWG\Put(
     *   path="/api/user/update/{id}",
     *   summary="Update User Profile",
     *     tags={"Admin"},
     *    @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Request an ID",
     *     type="string",
     *   ),
     *     @SWG\Parameter(
     *     name="name",
     *     in="query",
     *     description="Name",
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     name="email",
     *     in="query",
     *     description="Email",
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     name="country_code",
     *     in="query",
     *     description="Country Code",
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     name="phone_number",
     *     in="query",
     *     description="Phone Number",
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
     *     name="init_lat",
     *     in="query",
     *     description="Latitude",
     *     type="string",
     *   ),
     *     @SWG\Parameter(
     *     name="init_lng",
     *     in="query",
     *     description="Longitude",
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     name="address",
     *     in="query",
     *     description="Address",
     *     type="string",
     *   ),
     *    @SWG\Parameter(
     *     name="about",
     *     in="query",
     *     description="About",
     *     type="string",
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="A list with products"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   ),
     * security={{"api_key":{}}}
     * )
     */
    public function updateUserProfile(Request $request,$id){
        unset($request['user']);
        unset($request['authen_id']);
        $email = $request->get('email');
        $data = User::where('email',$email)->first();
        if ($data)
            return $this->respondWithErrorMessage('This email has been exists',2018);
       $data = User::find($id);
       if (!$data){
           return $this->respondWithErrorMessage('Cannot find this user',2006);
       }
          else {

              $rules = new User;
              $message = [
                  'date_of_birth.required'    => 'The date of birth is required',
                  'date_of_birth.date'        => 'The date of birth is not correct format',
                  'gender.required'           => 'The gender is required',
                  'gender.regex'              => 'The gender must be male or female',
                  'init_lat.required'         => 'The latitude is required',
                  'init_lat.regex'            => 'The latitude must be a number between -90 and 90',
                  'init_lng.required'         => 'The longitude is required',
                  'init_lng.regex'            => 'The longitude must be a number between -180 and 180',
                  'address.max'               => 'The address may not be greater than 60 character.',
                  'about.max'                 => 'About yourself may not be greater than 255 character.',
              ];
              $validator = Validator::make($request->all(), $rules->ruleCustom['RULE_USERS_UPDATE_PROFILE'], $message);
              if ($validator->fails()) {
                  return $this->errorWithValidation($validator);
              } else {
                  User::where('id', $id)->update([
                      'name' => $request['name'],
                      'email' => $request['email'],
                      'phone_number' => $request ['phone_number'],
                      'country_code' => $request ['country_code'],
                      'date_of_birth' => $request->input('date_of_birth'),
                      'gender' => $request->input('gender'),
                      'init_lat' => $request->input('init_lat'),
                      'init_lng' => $request->input('init_lng'),
                      'address' => $request->input('address'),
                      'about' => $request->input('about'),
                  ]);
                  return response()->json([
                      'error' => false,
                      'data' => array((object)array('Messaage' => 'Update profile successful !!!',
                      )),
                      'errors' => null
                  ], 400);
              }
          }
    }

    /**
     * @SWG\Delete(
     *   path="/api/user/delete/{id}",
     *   summary="Delete User",
     *     tags={"Admin"},
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="Request an ID",
     *     type="string",
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="A list with products"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   ),
     * security={{"api_key":{}}}
     * )
     */
    public function deleteUser(Request $request,$id)
    {
        $errorCode = $this->apiErrorCodes;
        $data = User::find($id);
        $user = User::findOrFail($request->user->id);
        if (!$data) {
            return $this->respondWithErrorMessage(
                $errorCode['no_user'],
                $errorCode['ApiErrorCodes']['no_user'], 401);
        }
        if ($data == $user){
            return $this->respondWithErrorMessage('Cannot delete yourself !!!', 2003);
                }
        else
            {
            $data->delete();
                return response()->json([
            'error' => false,
            'data' => array((object)array('Messaage' => 'Delete user successful !!!',
            )),
            'errors' => null
        ], 400);

            }
    }
    /** @SWG\Post(
     *   path="/api/admin/reset",
     *   summary="Reset Password",
     *     tags={"Admin"},
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
    public function resetAdmin(Request $request)
    {
        $errorCode = $this->apiErrorCodes;
        $email = $request->get('email');
        $email_check = User::where('email', $email)->first();
        if ($email_check) {
            $admin_id = User::where('email', $email)->first()->id;
            $admin_check = DB::table('role_user')->where('user_id', $admin_id)->first()->role_id;
            if ($admin_check == 5) {
                $newPassword = str_random(20);
                User::query()->update(array('password' => bcrypt($newPassword)));
                Mail::send('password', array('content' => $newPassword), function ($message) {
                    $message->to('nkhoaa96@gmail.com', 'Khoa')->subject('Password Reset!');
                });
                return response()->json([
                    'error' => false,
                    'data' => 'Your new password sending successful!!! Check your email',
                    'errors' => null
                ], 200);
            }
           else {
                return $this->respondWithErrorMessage('This account not is an Admin',2019);
           }
        }
        else {
            return $this->respondWithErrorMessage(
                $errorCode['no_email'],
                $errorCode['ApiErrorCodes']['no_email'], 400);
        }
    }
}
