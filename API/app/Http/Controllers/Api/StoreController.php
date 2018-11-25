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
     *   path="/api/store/showOrder",
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
				return response()->json([
                         'error' => true,
                         'data' => $affected,
                         'errors' => null,
                    ], 400);
			}
		}
		
	}
}
