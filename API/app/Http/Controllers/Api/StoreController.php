<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class StoreController extends Controller
{
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
     *	 security={{"api_key":{}}}
     * )
     */

	public function updateProfileStore(Request $request) {
		$name_store = $request->get('name_store');
		$type_store = $request->get('type_store');
		$address_store = $request->get('address_store');
		$description_store = $request->get('description_store');
		$latitude_store = 11.3;
		$longitude_store = 12.3;
		$start_working_time = $request->get('start_working_time');
		$end_working_time = $request->get('end_working_time');

		$user_id = $request->authen_id;

		$curl = curl_init();

		//curl_setopt($curl, CURLOPT_URL, 'https://maps.googleapis.com/maps/api/geocode/json?address=' . rawurlencode('TPHCM'));
		curl_setopt($curl, CURLOPT_URL, 'https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyDZg4UjrDXfteRf8s6NErw0BKVfDSledVE');
		

		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);

		$json = curl_exec($curl);

		curl_close ($curl);

		return response()->json([
					'error' => false,
					'data' => $json,
					'errors' => null,
				], 200);

		// if ($request->isMethod('post')) {

		// 	$affected = DB::insert('insert into store (idUser, nameStore,typeStore,addressStore,descriptionStore,latitudeStore,longitudeStore,startWorkingTime,endWorkingTime) values (?, ?, ?, ?, ?, ?, ?, ?, ?)', [$user_id,$name_store,$type_store,$address_store,$description_store,$latitude_store,$longitude_store ,$start_working_time,$end_working_time ]);

		// 	if($affected){
		// 		return response()->json([
		// 			'error' => false,
		// 			'data' => $affected,
		// 			'errors' => null,
		// 		], 200);
		// 	}else{
		// 		return $this->respondWithErrorMessage(
		// 			$errorCode['authentication'],
		// 			$errorCode['ApiErrorCodes']['authentication'],
		// 		, 400);
		// 	}
		// }
		
	}
}
