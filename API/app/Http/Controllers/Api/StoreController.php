<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class StoreController extends Controller
{
    /**
     * @SWG\POST(
     *   path="/api/store/insertProfileStore",
     *     tags={"Store"},
     *   summary="Show Profile",
     *   @SWG\Parameter(
     *     name="name_store",
     *     in="query",
     *     description="Your Name Store",
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     name="type_store",
     *     in="query",
     *     description="Your Type Store",
     *     type="string",
     *   ),
      *   @SWG\Parameter(
     *     name="address_store",
     *     in="query",
     *     description="Your Address Store",
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     name="description_store",
     *     in="query",
     *     description="Your Description Store",
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     name="start_working_time",
     *     in="query",
     *     description="Your Start Working Store",
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     name="end_working_time",
     *     in="query",
     *     description="Your End Working Store",
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
     *	 security={{"api_key":{}}}
     * )
     */
	public function insertProfileStore(Request $request) {
          if ($request->isMethod('post')) {
     		$name_store = $request->get('name_store');
     		$type_store = $request->get('type_store');
     		$address_store = $request->get('address_store');
     		$description_store = $request->get('description_store');
     		$latitude_store = 11.3;
     		$longitude_store = 12.3;
     		$start_working_time = $request->get('start_working_time');
     		$end_working_time = $request->get('end_working_time');

               //Get from Middleware/CheckToken
     		$user_id = $request->authen_id;
		
			$affected = DB::insert('insert into store (idUser, nameStore,typeStore,addressStore,descriptionStore,latitudeStore,longitudeStore,startWorkingTime,endWorkingTime) values (?, ?, ?, ?, ?, ?, ?, ?, ?)', [$user_id,$name_store,$type_store,$address_store,$description_store,$latitude_store,$longitude_store ,$start_working_time,$end_working_time]);

     }

	public function updateProfileStore(Request $request) {
		$name_store = $request->get('name_store');
		$type_store = $request->get('type_store');
		$address_store = $request->get('address_store');
		$description_store = $request->get('description_store');
		$latitude_store = 11.3;
		$longitude_store = 12.3;
		$start_working_time = $request->get('start_working_time');
		$end_working_time = $request->get('end_working_time');

		$idUser = $request->idUser;
         
		if ($request->isMethod('post')) {

			$affected = DB::insert('insert into stores (idUser, nameStore,typeStore,addressStore,descriptionStore,latitudeStore,longitudeStore,startWorkingTime,endWorkingTime) values (?, ?, ?, ?, ?, ?, ?, ?, ?)', [$idUser,$name_store,$type_store,$address_store,$description_store,$latitude_store,$longitude_store ,$start_working_time,$end_working_time ]);


			if($affected){
				return response()->json([
					'error' => false,
					'data' => $affected,
					'errors' => null,
				], 200);
			}else{

				// return $this->respondWithErrorMessage(
				// 	$errorCode['authentication'],
				// 	$errorCode['ApiErrorCodes']['authentication'],
    //                      $affected,
				// , 400);
                    response()->json([

				return response()->json([

                         'error' => true,
                         'data' => $affected,
                         'errors' => null,
                    ], 400);
			}
		}
		
	}

     /**
     * @SWG\POST(
     *   path="/api/store/updateProfileStore",
     *     tags={"Store"},
     *   summary="Show Profile",
     *   @SWG\Parameter(
     *     name="name_store",
     *     in="query",
     *     description="Your Name Store",
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     name="type_store",
     *     in="query",
     *     description="Your Type Store",
     *     type="string",
     *   ),
      *   @SWG\Parameter(
     *     name="address_store",
     *     in="query",
     *     description="Your Address Store",
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     name="description_store",
     *     in="query",
     *     description="Your Description Store",
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     name="start_working_time",
     *     in="query",
     *     description="Your Start Working Store",
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     name="end_working_time",
     *     in="query",
     *     description="Your End Working Store",
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
     *     security={{"api_key":{}}}
     * )
     */

     public function updateProfileStore(Request $request) {
          if ($request->isMethod('post')) {
               $name_store = $request->get('name_store');
               $type_store = $request->get('type_store');
               $address_store = $request->get('address_store');
               $description_store = $request->get('description_store');
               $latitude_store = 11.3;
               $longitude_store = 12.3;
               $start_working_time = $request->get('start_working_time');
               $end_working_time = $request->get('end_working_time');

               $user_id = $request->authen_id;
               $store_id = 1;
          
               $affected = DB::table('store')->where('idStore', $store_id)->update([
                         'idUser' => $user_id,
                         'nameStore' => $name_store,
                         'typeStore' => $type_store,
                         'addressStore' => $address_store,
                         'descriptionStore' => $description_store,
                         'latitudeStore' => $latitude_store,
                         'longitudeStore' => $longitude_store,
                         'startWorkingTime' => $start_working_time,
                         'endWorkingTime' => $end_working_time,
                    ]);

               if($affected){
                    return response()->json([
                         'error' => false,
                         'data' => $affected,
                         'errors' => null,
                    ], 200);
               }else{

                    response()->json([
                         'error' => true,
                         'data' => $affected,
                         'errors' => null,
                    ], 400);
               }
          }
          
     }

        /**
     * @SWG\POST(
     *   path="/api/store/showProfileStore",
     *     tags={"Store"},
     *   summary="Show Profile",
     *   @SWG\Response(
     *     response=200,
     *     description="A list with products"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   ),
     *     security={{"api_key":{}}}
     * )
     */

     public function showProfileStore(Request $request) {
          if ($request->isMethod('post')) {
         
               $user_id = $request->authen_id;
               $store_id = 1;
          
               $affected = DB::table('store')->where('idStore', 1)->select('*')->get();

               if($affected){
                    return response()->json([
                         'error' => false,
                         'data' => $affected,
                         'errors' => null,
                    ], 200);
               }else{

                    response()->json([
                         'error' => true,
                         'data' => $affected,
                         'errors' => null,
                    ], 400);
               }
          }
          
     }

     //  public function showProfileStore(Request $request) {
     //      if ($request->isMethod('post')) {
         
     //           $user_id = $request->authen_id;
     //           $store_id = 1;
          
     //           $affected = DB::table('store')->where('idStore', 1)->select('*')->get();

     //           if($affected){
     //                return response()->json([
     //                     'error' => false,
     //                     'data' => $affected,
     //                     'errors' => null,
     //                ], 200);
     //           }else{

     //                response()->json([
     //                     'error' => true,
     //                     'data' => $affected,
     //                     'errors' => null,
     //                ], 400);
     //           }
     //      }
          
     // }
}
