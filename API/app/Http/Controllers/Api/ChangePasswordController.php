<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Illuminate\Support\Facades\Validator;


class ChangePasswordController extends Controller
{
    /** @SWG\Post(
     *   path="/api/change",
     *   summary="Change Password",
     *     tags={"User"},
     *   security={{"api_key": {}}},
     *   @SWG\Parameter(
     *     name="password",
     *     in="query",
     *     format="password",
     *     description="Your new password",
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
    public function change(Request $request){
        $token = $request->headers->get('token');
        $data = User::where('id',(DB::table('token')->where('token', $token)->first()->user_token_id))->first()->id;
        if($data != 0){
            $rules = new User;
            $message =[
                'password.required'   => 'The password is required',
                'password.min'        => 'The password must be at least 6.',

            ];
            $validator = Validator::make($request->all(),$rules->ruleCustom['RULE_USERS_CHANGE_PASSWORD'],$message);
            if ( $validator->fails() ) {
                return $this->errorWithValidation($validator);
            }
            else{
                User::where('id',$data)->update(array('password' => bcrypt($request->input('password'))));
                return response() ->json([
                    'error' => false,
                    'data' => array ((object) array('Messaage'=>'Change password success !!!',
                    )),
                    'errors' => null
                ],400);
            }
        }

    }
}
