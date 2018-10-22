<?php

namespace App\Http\Controllers;


use App\Friends;
use Illuminate\Http\Request;
use App\User;
use DB;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

    /**
     * @param Request $request
     * @return Request
     */
    /**
     * @SWG\Get(
     *   path="/api/profile",
     *     tags={"User Profile"},
     *   summary="Show Profile",
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

    public function getProfile(Request $request)
    {
        $errorCode = $this->apiErrorCodes;
        $token = $request->headers->get('token');
        $data = User::select('id','name', 'email',DB::raw("CONCAT(country_code,phone_number) AS 'Phone Number'"),"date_of_birth AS DOB","gender AS Gender",
            DB::raw("CONCAT('(',init_lat,',',init_lng,')') AS 'Location'"),"address AS Address","about AS Bio")->where('id',(DB::table('token')->where('token', $token)->first()->user_token_id))->first();
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
     *   path="/api/update",
     *   summary="Update Profile",
     *     tags={"User Profile"},
     * @SWG\Parameter(
     *     name="name",
     *     in="query",
     *     description="Name",
     *     type="string",
     *   ),
     *     @SWG\Parameter(
     *     name="name",
     *     in="query",
     *     description="Your Name",
     *     type="string",
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
     *   @SWG\Parameter(
     *     name="phone_number",
     *     in="query",
     *     description="Your Phone Number",
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
     *     description="Your Latitude",
     *     type="string",
     *   ),
     *     @SWG\Parameter(
     *     name="init_lng",
     *     in="query",
     *     description="Your Longitude",
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     name="address",
     *     in="query",
     *     description="Your Address",
     *     type="string",
     *   ),
     *    @SWG\Parameter(
     *     name="about",
     *     in="query",
     *     description="About yourself",
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
    public function updateProfile(Request $request){
        if($request->authen_id != 0){
            $email = $request->get('email');
            $data = User::where('email',$email)->first();
            if ($data)
                return $this->respondWithErrorMessage('This email has been exists',2018);
            $rules = new User;
            $message =[
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
            $validator = Validator::make($request->all(),$rules->ruleCustom['RULE_USERS_UPDATE_PROFILE'],$message);
            if ( $validator->fails() ) {
                return $this->errorWithValidation($validator);
            }
            else{
                User::where('id',$request->authen_id)->update([
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
                return response() ->json([
                    'error' => false,
                    'data' => array ((object) array('Messaage'=>'Update profile successful !!!',
                    )),
                    'errors' => null
                ],400);
            }
        }
    }
     /**
      * @SWG\Post(
      *   path="/api/friend",
      *   summary="Request/Response a friend request",
      *     tags={"User"},
      *   @SWG\Parameter(
      *     name="type",
      *     in="query",
      *     description="Request/Response a friend request",
      *     type="string",
      *     required=true,
      *     enum={"Request", "Response"}
      *   ),
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
    public function friendAction(Request $request)
    {
        $type = $request ->get('type');
        if ($type == 'Request'){
            return $this->friendRequestSender($request);
        }
        if ($type == 'Response' ) {
            return $this->friendRequestResponse($request);
        }
    }
    public  function friendRequestSender(Request $request){
        $id = $request->get('id');
        $req_id = User::find($id);
        $user = User::findOrFail($request->user->id);
        if (!$req_id){
            return $this->respondWithErrorMessage('Cannot find this user',2006);
        }
        else if ($user == $req_id ){
            return $this->respondWithErrorMessage('Cannot request yourself',2003);
        }
        else if (($user ->hasFriendRequestPending($req_id))== true){
            return $this->respondWithErrorMessage('You has sending request for this user',2004);
        }
        else $user ->addFriend($req_id);
        return $this->respondWithSuccess('Your request has been send',200);
    }
    public  function friendRequestResponse(Request $request){
        $id = $request->get('id');
        $req_id = User::find($id);
        $user = User::findOrFail($request->user->id);
        if (!$req_id){
            return $this->respondWithErrorMessage('Cannot find this user',2006);
        }
        else if(($user ->hasFriendResponse($req_id))== true){
            return $this->respondWithErrorMessage('You has accept for this user',2005);
        }
        else
        {
            $user->acceptFriendRequest($req_id);
            return $this->respondWithSuccess('Accept success !!!',200);
        }

    }
    /**
     * @SWG\Get(
     *   path="/api/list",
     *   summary="Friend/ Friend Request/ Block List",
     *     tags={"User"},
     *   @SWG\Parameter(
     *     name="type",
     *     in="query",
     *     description="Friend/ Friend Request/ Block List",
     *     type="string",
     *     required=true,
     *     enum={"Friend", "Request", "Block"}
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
    public function friendActionList(Request $request)
    {
        $type = $request ->get('type');
        if ($type == 'Friend'){
            return $this->friendRequestList($request);
        }
        if ($type == 'Request' ) {
            return $this->friendList($request);
        }
        if ($type == 'Block' ) {
            return $this->blockList($request);
        }
    }
    public  function friendRequestList(Request $request){
        $user = User::findOrFail($request->user->id);
        $users = $user ->friendRequestsPending();
        if (!count($users)){
            return $this->respondWithErrorMessage('Empty list',2013);
        }
        else{
            return $list = $users -> map(function ($list) {
                return collect($list->toArray())
                    ->only(['id', 'name', 'email'])
                    ->all();
            });
        }
    }
    public  function friendList(Request $request){
        $user = User::findOrFail($request->user->id);
        $users = $user ->friendList();
        if (!count($users)){
            return $this->respondWithErrorMessage('Empty list',2013);
        }
        else{
            return $list = $users -> map(function ($list) {
                return collect($list->toArray())
                    ->only(['id', 'name', 'email'])
                    ->all();
            });
        }
    }
    public  function blockList(Request $request){
        $user = User::findOrFail($request->user->id);
        $users = $user ->blockList();
        if (!count($users)){
            return $this->respondWithErrorMessage('Empty list',2013);
        }
        else{
            return $list = $users -> map(function ($list) {
                return collect($list->toArray())
                    ->only(['id', 'name', 'email'])
                    ->all();
            });
        }
    }
    /**
     * @SWG\Post(
     *   path="/api/follow",
     *   summary="Follow/ Unfollow friend",
     *     tags={"User"},
     *   @SWG\Parameter(
     *     name="type",
     *     in="query",
     *     description="Follow/ Unfollow friend",
     *     type="string",
     *     required=true,
     *     enum={"Follow", "Unfollow"}
     *   ),
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
    public function friendActionFollow(Request $request)
    {
        $type = $request ->get('type');
        if ($type == 'Unfollow'){
            return $this->unfollowFriend($request);
        }
        if ($type == 'Follow' ) {
            return $this->followFriend($request);
        }
    }
    public  function unfollowFriend(Request $request){
        $id = $request->get('id');
        $req_id = User::find($id);
        $user = User::findOrFail($request->user->id);
        if (!$req_id){
            return $this->respondWithErrorMessage('Cannot find this user',2006);
        }
        else if(($user ->hasUnfollowResponse($req_id))== true){
            return $this->respondWithErrorMessage('You has unfollow for this user',2005);
        }
        else
        {
            $user->acceptUnfollow($req_id);
            return $this->respondWithSuccess('Unfollow success !!!',200);
        }
    }
    public  function followFriend(Request $request){
        $id = $request->get('id');
        $req_id = User::find($id);
        $user = User::findOrFail($request->user->id);
        if (!$req_id){
            return $this->respondWithErrorMessage('Cannot find this user',2006);
        }
        else if(($user ->hasFollowResponse($req_id))== true){
            return $this->respondWithErrorMessage('You has follow for this user',2005);
        }
        else
        {
            $user->acceptFollow($req_id);
            return $this->respondWithSuccess('Follow success !!!',200);
        }
    }
    /**
     * @SWG\Post(
     *   path="/api/unfriend",
     *   summary="Unfriend/ Block Friend/ Unblock Friend",
     *     tags={"User"},
     *   @SWG\Parameter(
     *     name="type",
     *     in="query",
     *     description="Unfriend/ Block Friend/ Unblock Friend",
     *     type="string",
     *     required=true,
     *     enum={"Unfriend", "Block", "Unblock"}
     *   ),
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
    public function friendActionFriend(Request $request)
    {
        $type = $request ->get('type');
        if ($type == 'Friend'){
            return $this->unfriend($request);
        }
        if ($type == 'Block' ) {
            return $this->blockFriend($request);
        }
        if ($type == 'Unblock' ) {
            return $this->unblockFriend($request);
        }
    }
    public  function unfriend(Request $request){
        $id = $request->get('id');
        $req_id = User::find($id);
        $user = User::findOrFail($request->user->id);
        if (!$req_id){
            return $this->respondWithErrorMessage('Cannot find this user',2006);
        }
        else
        {
            $user->removeFriend($req_id);
            return $this->respondWithSuccess('Unfriend success !!!',200);
        }
    }

    public  function blockFriend(Request $request){
        $id = $request->get('id');
        $req_id = User::find($id);
        $user = User::findOrFail($request->user->id);
        if (!$req_id){
            return $this->respondWithErrorMessage('Cannot find this user',2006);
        }
        else if(($user ->hasBlockResponse($req_id))== true){
            return $this->respondWithErrorMessage('You has blocked for this user',2005);
        }
        else
        {
            $user->acceptBlock($req_id);
            return $this->respondWithSuccess('Blocked success !!!',200);
        }
    }

    public  function unblockFriend(Request $request){
        $id = $request->get('id');
        $req_id = User::find($id);
        $user = User::findOrFail($request->user->id);
        if (!$req_id){
            return $this->respondWithErrorMessage('Cannot find this user',2006);
        }
        else if(($user ->hasUnblockResponse($req_id))== true){
            return $this->respondWithErrorMessage('You has unblocked for this user',2005);
        }
        else
        {
            $user->acceptUnblock($req_id);
            return $this->respondWithSuccess('Unblocked success !!!',200);
        }
    }

    /**
     * @SWG\Post(
     *   path="/api/deactive",
     *   summary="Deactive",
     *     tags={"User"},
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
    public  function deactiveAccount(Request $request){
        User::where('id',$request->authen_id)->update(['disabled'=> true,]);
        return $this->respondWithSuccess('Deactive success !!!',200);
    }
}
