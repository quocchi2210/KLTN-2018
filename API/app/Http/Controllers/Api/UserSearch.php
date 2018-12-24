<?php

namespace App\Http\Controllers\Api;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class UserSearch extends Controller
{
    /**
     * @param Request $request
     * @return Request
     */
    /**
     * @SWG\Get(
     *   path="/api/search",
     *     tags={"User"},
     *   summary="Search User",
     *    @SWG\Parameter(
     *     name="gender",
     *     in="query",
     *     description="Your Gender",
     *     type="string",
     *   ),
     *    @SWG\Parameter(
     *     name="min_age",
     *     in="query",
     *     description="Min Age",
     *     type="string",
     *   ),
     *    @SWG\Parameter(
     *     name="max_age",
     *     in="query",
     *     description="Max Age",
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
    public function search(Request $request){
        $errorCode = $this->apiErrorCodes;
        $gender = $request->get('gender');
        $minAge = $request->get('min_age');
        $maxAge = $request->get('max_age');
        if ($maxAge && $minAge && ($maxAge < $minAge)){
            return $this->respondWithErrorMessage('Valid input',2000);
        }
        $latitude = $request->get('user')->init_lat;
        $longitude = $request->get('user')->init_lng;
        $start = Carbon::now()->subYears($maxAge + 1)->addDay()->format('Y-m-d');
        $end = Carbon::now()->subYears($minAge)->addDay()->format('Y-m-d');
        $user = DB::table('users')
//            ->join('user_friend',function ($join){
//                $join->on('user_friend.user_id','=','users.id')
//                    ->orOn('user_friend.friend_id','=','users.id');
//            })
            ->select('users.id','users.name','users.email','users.country_code','users.phone_number','users.about','users.gender')
//            ->where(function ($query) use ($request){
//                $query->where([['user_friend.user_id',$request->authen_id],
//                    ['user_friend.blocked',0],
//                ])
//                    ->orWhere([['user_friend.friend_id',$request->authen_id],
//                        ['user_friend.blocked',0],
//                    ]);
//            })
            ->selectRaw("FLOOR((DATEDIFF(CURRENT_DATE,STR_TO_DATE(date_of_birth,'%Y-%m-%d'))/365))as age,(3959 * ACOS(COS(RADIANS(?))
            * COS(RADIANS(users.init_lat))
            * COS(RADIANS(?) - RADIANS(users.init_lng))
            + SIN(RADIANS(?))
            * SIN(RADIANS(users.init_lat)))) AS distance",[$latitude,$longitude,$latitude])
            ->whereRaw('id != ? AND users.disabled != ? AND users.locked != ? ', [$request->authen_id,1,1])
            ->when($maxAge && $minAge, function ($query) use ($start,$end){
                return $query->whereRaw('date_of_birth >= ?',[$start])
                             ->whereRaw('date_of_birth <= ?',[$end]);
            })
            ->when(!$maxAge && $minAge, function ($query) use ($start,$end){
                return $query->whereRaw('date_of_birth <= ?',[$end]);
            })
            ->when($maxAge && !$minAge, function ($query) use ($start,$end){
                return $query->whereRaw('date_of_birth >= ?',[$start]);
            })
            ->when($gender, function ($query) use ($gender){
                return $query->whereRaw('gender = ?',[$gender]);
            })
            ->orderBy('distance','asc')
            ->Paginate(5);
        if (!count($user)){
            return $this->respondWithErrorMessage(
                $errorCode['no_user'],
                $errorCode['ApiErrorCodes']['no_user'], 400);
        }
        else {
            return response()->json($user);
        }
    }

    /**
     * @SWG\Get(
     *   path="/api/searchFriend",
     *     tags={"User"},
     *   summary="Search Friend by Phone or QR Code",
     *    @SWG\Parameter(
     *     name="qr_code",
     *     in="query",
     *     description="Your friend QR code",
     *     type="string",
     *   ),
     *    @SWG\Parameter(
     *     name="country_code",
     *     in="query",
     *     description="Country Code",
     *     type="string",
     *   ),
     *    @SWG\Parameter(
     *     name="phone_number",
     *     in="query",
     *     description="Phone Number",
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
    public function searchFriend(Request $request){
        $errorCode = $this->apiErrorCodes;
        $qrcode = $request->get('qr_code');
        $country_code = $request->get('country_code');
        $phone_number = $request->get('phone_number');
        $phone = substr($phone_number,1);
        $user = DB::table('users')
            ->join('user_friend',function ($join){
                $join->on('user_friend.user_id','=','users.id')
                    ->orOn('user_friend.friend_id','=','users.id');
            })
            ->select('users.id','users.name','users.email','users.country_code','users.phone_number','users.about','users.gender')
            ->where(function ($query) use ($request){
                $query->where([['user_friend.user_id',$request->authen_id],
                    ['user_friend.blocked',0],
                ])
                    ->orWhere([['user_friend.friend_id',$request->authen_id],
                        ['user_friend.blocked',0],
                    ]);
            })
            ->whereRaw('users.disabled != ? AND users.locked != ? ', [1,1])
            ->when($qrcode && !$country_code && !$phone_number , function ($query) use ($qrcode){
                return $query->whereRaw('qr_code = ?',$qrcode);
            })
            ->when(!$qrcode && $country_code && $phone_number, function ($query) use ($country_code,$phone_number){
                return $query->whereRaw('country_code = ? AND phone_number = ?',[$country_code,$phone_number]);
            })
            ->when(!$qrcode && !$country_code && $phone_number, function ($query) use ($phone){
                return $query->whereRaw('phone_number = ?',$phone);
            })
            ->distinct()
            ->Paginate(5);
        if (!count($user)){
            return $this->respondWithErrorMessage(
                $errorCode['no_user'],
                $errorCode['ApiErrorCodes']['no_user'], 400);
        }
        else {
            return response()->json($user);
        }
    }

}
