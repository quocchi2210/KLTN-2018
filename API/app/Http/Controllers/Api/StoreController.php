<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Config;
use DB;
use Illuminate\Http\Request;
use Log;

class StoreController extends Controller {
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
	 *   @SWG\Parameter(
	 *     name="lat",
	 *     in="query",
	 *     description="Your Start Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="long",
	 *     in="query",
	 *     description="Your Start Working Store",
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
	public function insertProfileStore(Request $request) {
		if ($request->isMethod('post')) {

			//Log::debug('testtttttt 1111'. print_r($request->all(),1));
			$name_store = encrypt($request->get('name_store'));
			$type_store = encrypt($request->get('type_store'));
			$address_store = encrypt($request->get('address_store'));
			$description_store = encrypt($request->get('description_store'));
			$latitude_store = encrypt($request->get('lat'));
			$longitude_store = encrypt($request->get('long'));
			$latitude_store = encrypt("11.3");
			$longitude_store = encrypt("12.3");
			$start_working_time = encrypt($request->get('start_working_time'));
			$end_working_time = encrypt($request->get('end_working_time'));

			//Get from Middleware/CheckToken
			// $user_id = $request->idUser;
			// $user_id = 1;

			// 	$request->request->add(
			// 	array(
			// 		'idUser' => $user_id,
			// 	)

			// );
			//[$user_id, $name_store, $type_store, $address_store, $description_store, $latitude_store, $longitude_store, $start_working_time, $end_working_time]
			$idUser = auth()->user()->idUser;

			$affected = DB::insert('insert into stores (idUser,nameStore,typeStore,addressStore,descriptionStore,latitudeStore,longitudeStore,startWorkingTime,endWorkingTime) values (?, ?, ?, ?, ?, ?, ?, ?, ?)', [$user_id, $name_store, $type_store, $address_store, $description_store, $latitude_store, $longitude_store, $start_working_time, $end_working_time]);
			if ($affected) {
				return response()->json([
					'error' => false,
					'data' => $affected,
					'errors' => null,
				], 200);
			} else {
				return response()->json([
					'error' => true,
					'data' => $affected,
					'errors' => null,
				], 200);

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

			// $user_id = $request->idUser;
			// $user_id = 1;
			$idUser = auth()->user()->idUser;

			$result_store = DB::table('stores')->select('idStore')->where('idUser', $idUser)->get();

			if ($result_store->count() > 0) {

				$idStore = $result_store[0]->idStore;

				$affected_store = DB::table('stores')->where('idStore', $idStore)->update([
					'nameStore' => encrypt($name_store),
					'typeStore' => encrypt($type_store),
					'addressStore' => encrypt($address_store),
					'descriptionStore' => encrypt($description_store),
					'latitudeStore' => encrypt($latitude_store),
					'longitudeStore' => encrypt($longitude_store),
					'startWorkingTime' => encrypt($start_working_time),
					'endWorkingTime' => encrypt($end_working_time),
				]);

				if ($affected_store) {
					return response()->json([
						'error' => false,
						'data' => $affected_store,
						'errors' => null,
					], 400);
				} else {
					return response()->json([
						'error' => true,
						'data' => $affected_store,
						'errors' => null,
					], 400);
				}

			} else {
				return response()->json([
					'error' => true,
					'data' => 'count > 0',
					'errors' => null,
				], 400);
			}

			//Log::debug('result_store' . print_r(decrypt($test[0]->nameStore), 1));

			// if ($result_store->count() > 0) {

			// 	$affected = DB::table('stores')->where('idStore', $store_id)->update([
			// 		'idUser' => $user_id,
			// 		'nameStore' => $name_store,
			// 		'typeStore' => $type_store,
			// 		'addressStore' => $address_store,
			// 		'descriptionStore' => $description_store,
			// 		'latitudeStore' => $latitude_store,
			// 		'longitudeStore' => $longitude_store,
			// 		'startWorkingTime' => $start_working_time,
			// 		'endWorkingTime' => $end_working_time,
			// 	]);

			// 	if ($affected) {
			// 		return response()->json([
			// 			'error' => false,
			// 			'data' => $affected,
			// 			'errors' => null,
			// 		], 200);
			// 	} else {

			// 		response()->json([
			// 			'error' => true,
			// 			'data' => $affected,
			// 			'errors' => null,
			// 		], 400);
			// 	}

			// } else {
			// 	return response()->json([
			// 		'error' => true,
			// 		'data' => null,
			// 		'errors' => null,
			// 	], 400);
			// }

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

			$idUser = auth()->user()->idUser;

			$result_store = DB::table('stores')->select('idStore')->where('idUser', $idUser)->get();

			if ($result_store->count() > 0) {

				$store_id = $result_store[0]->idStore;

				$affected = DB::table('stores')
					->join('users', 'stores.idUser', '=', 'users.idUser')
					->where('idStore', 1)
					->get();

				myDecrypt($affected);

				if ($affected) {
					return response()->json([
						'error' => false,
						'data' => $affected,
						'errors' => null,
					], 200);
				} else {

					response()->json([
						'error' => true,
						'data' => $affected,
						'errors' => null,
					], 400);
				}

			} else {
				return response()->json([
					'error' => true,
					'data' => 'count > 0',
					'errors' => null,
				], 400);
			}
		}

	}

	/**
	 * @SWG\POST(
	 *   path="/api/store/showOrder",
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

	public function showOrder(Request $request) {
		if ($request->isMethod('post')) {

			// $idUser = $request->idUser;
			// $idUser = 1;
			$idUser = auth()->user()->idUser;

			$result_store = DB::table('stores')->select('idStore')->where('idUser', $idUser)->get();

			if ($result_store->count() > 0) {

				// Log::debug('idUser'. print_r($idUser,1));
				// Log::debug('idShipper'. print_r($result_shipper[0]['idShipper'],1));

				$idStore = $result_store[0]->idStore;
				// $users = DB::statement("SELECT * FROM orders WHERE idShipper=?",[$idShipper]);

				// $users = DB::select("SELECT * FROM orders WHERE idShipper = ?",[$idShipper]);

				$users = DB::table('orders')
					->join('stores', 'stores.idStore', '=', 'orders.idStore')
					->where('orders.idStore', $idStore)
					->get();

				//Log::debug("call helper user".print_r($users[0],1));
				myDecrypt($users);
				//Log::debug("call helper" . print_r(myDecrypt($users), 1));

				if ($users) {
					return response()->json([
						'error' => false,
						'data' => $users,
						'errors' => null,
					], 200);
				} else {
					return response()->json([
						'error' => true,
						'data' => null,
						'errors' => null,
					], 400);
				}
			} else {
				return response()->json([
					'error' => true,
					'data' => 'count > 0',
					'errors' => null,
				], 400);
			}
		}
	}

	/**
	 * @SWG\POST(
	 *   path="/api/store/showOrder_pending",
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

	public function showOrder_pending(Request $request) {
		if ($request->isMethod('post')) {

			$idUser = auth()->user()->idUser;

			$result_store = DB::table('stores')->select('idStore')->where('idUser', $idUser)->get();

			if ($result_store->count() > 0) {

				$idStore = $result_store[0]->idStore;

				$users = DB::table('orders')
					->join('stores', 'stores.idStore', '=', 'orders.idStore')
					->where('orders.idStore', $idStore)
					->where('idOrderStatus', Config::get('constants.status_type.pending'))
					->get();

				myDecrypt($users);

				if ($users) {
					return response()->json([
						'error' => false,
						'data' => $users,
						'errors' => null,
					], 200);
				} else {
					return response()->json([
						'error' => true,
						'data' => null,
						'errors' => null,
					], 400);
				}
			} else {
				return response()->json([
					'error' => true,
					'data' => 'count > 0',
					'errors' => null,
				], 400);
			}
		}
	}

	/**
	 * @SWG\POST(
	 *   path="/api/store/showOrder_confirm",
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

	public function showOrder_confirm(Request $request) {
		if ($request->isMethod('post')) {

			$idUser = auth()->user()->idUser;

			$result_store = DB::table('stores')->select('idStore')->where('idUser', $idUser)->get();

			if ($result_store->count() > 0) {

				$idStore = $result_store[0]->idStore;

				$users = DB::table('orders')
					->join('stores', 'stores.idStore', '=', 'orders.idStore')
					->where('orders.idStore', $idStore)
					->where('idOrderStatus', Config::get('constants.status_type.confirm'))
					->get();

				myDecrypt($users);

				if ($users) {
					return response()->json([
						'error' => false,
						'data' => $users,
						'errors' => null,
					], 200);
				} else {
					return response()->json([
						'error' => true,
						'data' => null,
						'errors' => null,
					], 400);
				}
			} else {
				return response()->json([
					'error' => true,
					'data' => 'count > 0',
					'errors' => null,
				], 400);
			}
		}
	}

	/**
	 * @SWG\POST(
	 *   path="/api/store/showOrder_pickup",
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

	public function showOrder_pickup(Request $request) {
		if ($request->isMethod('post')) {

			$idUser = auth()->user()->idUser;

			$result_store = DB::table('stores')->select('idStore')->where('idUser', $idUser)->get();

			if ($result_store->count() > 0) {

				$idStore = $result_store[0]->idStore;

				$users = DB::table('orders')
					->join('stores', 'stores.idStore', '=', 'orders.idStore')
					->where('orders.idStore', $idStore)
					->where('idOrderStatus', Config::get('constants.status_type.pickup'))
					->get();

				myDecrypt($users);

				if ($users) {
					return response()->json([
						'error' => false,
						'data' => $users,
						'errors' => null,
					], 200);
				} else {
					return response()->json([
						'error' => true,
						'data' => null,
						'errors' => null,
					], 400);
				}
			} else {
				return response()->json([
					'error' => true,
					'data' => 'count > 0',
					'errors' => null,
				], 400);
			}
		}
	}

	/**
	 * @SWG\POST(
	 *   path="/api/store/showOrder_delivery",
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

	public function showOrder_delivery(Request $request) {
		if ($request->isMethod('post')) {

			$idUser = auth()->user()->idUser;

			$result_store = DB::table('stores')->select('idStore')->where('idUser', $idUser)->get();

			if ($result_store->count() > 0) {

				$idStore = $result_store[0]->idStore;

				$users = DB::table('orders')
					->join('stores', 'stores.idStore', '=', 'orders.idStore')
					->where('orders.idStore', $idStore)
					->where('idOrderStatus', Config::get('constants.status_type.delivery'))
					->get();

				myDecrypt($users);

				if ($users) {
					return response()->json([
						'error' => false,
						'data' => $users,
						'errors' => null,
					], 200);
				} else {
					return response()->json([
						'error' => true,
						'data' => null,
						'errors' => null,
					], 400);
				}
			} else {
				return response()->json([
					'error' => true,
					'data' => 'count > 0',
					'errors' => null,
				], 400);
			}
		}
	}

	/**
	 * @SWG\POST(
	 *   path="/api/store/showOrder_done",
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

	public function showOrder_done(Request $request) {
		if ($request->isMethod('post')) {

			$idUser = auth()->user()->idUser;

			$result_store = DB::table('stores')->select('idStore')->where('idUser', $idUser)->get();

			if ($result_store->count() > 0) {

				$idStore = $result_store[0]->idStore;

				$users = DB::table('orders')
					->join('stores', 'stores.idStore', '=', 'orders.idStore')
					->where('orders.idStore', $idStore)
					->where('idOrderStatus', Config::get('constants.status_type.done'))
					->get();

				myDecrypt($users);

				if ($users) {
					return response()->json([
						'error' => false,
						'data' => $users,
						'errors' => null,
					], 200);
				} else {
					return response()->json([
						'error' => true,
						'data' => null,
						'errors' => null,
					], 400);
				}
			} else {
				return response()->json([
					'error' => true,
					'data' => 'count > 0',
					'errors' => null,
				], 400);
			}
		}
	}

	/**
	 * @SWG\POST(
	 *   path="/api/store/showOrder_cancel",
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

	public function showOrder_cancel(Request $request) {
		if ($request->isMethod('post')) {

			$idUser = auth()->user()->idUser;

			$result_store = DB::table('stores')->select('idStore')->where('idUser', $idUser)->get();

			if ($result_store->count() > 0) {

				$idStore = $result_store[0]->idStore;

				$users = DB::table('orders')
					->join('stores', 'stores.idStore', '=', 'orders.idStore')
					->where('orders.idStore', $idStore)
					->where('idOrderStatus', Config::get('constants.status_type.cancel'))
					->get();

				myDecrypt($users);

				if ($users) {
					return response()->json([
						'error' => false,
						'data' => $users,
						'errors' => null,
					], 200);
				} else {
					return response()->json([
						'error' => true,
						'data' => null,
						'errors' => null,
					], 400);
				}
			} else {
				return response()->json([
					'error' => true,
					'data' => 'count > 0',
					'errors' => null,
				], 400);
			}
		}
	}

	/**
	 * @SWG\POST(
	 *   path="/api/store/showDetailOrder",
	 *     tags={"Store"},
	 *   summary="Show Profile",
	 *   @SWG\Response(
	 *     response=200,
	 *     description="A list with products"
	 *   ),
	 *   @SWG\Parameter(
	 *     name="id_order",
	 *     in="query",
	 *     description="Your End Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Response(
	 *     response="default",
	 *     description="an ""unexpected"" error"
	 *   ),
	 *     security={{"api_key":{}}}
	 * )
	 */
	public function showDetailOrder(Request $request) {

		if ($request->isMethod('post')) {

			$idOrder = $request->get('id_order');
			// $idUser = $request->idUser;
			// $idUser = 1;
			$idUser = auth()->user()->idUser;

			$result_store = DB::table('stores')->select('idStore')->where('idUser', $idUser)->get();
			if ($result_store->count() > 0) {

				$users = DB::table('order_details')
					->join('orders', 'order_details.idOrder', '=', 'orders.idOrder')
					->join('stores', 'stores.idStore', '=', 'orders.idStore')
					->where('order_details.idOrder', $idOrder)
					->get();

				myDecrypt($users);

				if ($users) {
					return response()->json([
						'error' => false,
						'data' => $users,
						'errors' => null,
					], 200);
				} else {
					return response()->json([
						'error' => true,
						'data' => null,
						'errors' => null,
					], 400);
				}
			} else {
				return response()->json([
					'error' => true,
					'data' => null,
					'errors' => null,
				], 400);
			}
		}
	}

	/**
	 * @SWG\POST(
	 *   path="/api/store/insertOrderStore",
	 *     tags={"Store"},
	 *   summary="Show Profile",
	 *   @SWG\Parameter(
	 *     name="name_sender",
	 *     in="query",
	 *     description="Your Name Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="address_sender",
	 *     in="query",
	 *     description="Your Type Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="phone_sender",
	 *     in="query",
	 *     description="Your Type Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="latitude_receiver",
	 *     in="query",
	 *     description="Your Address Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="longitude_receiver",
	 *     in="query",
	 *     description="Your Description Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="name_receiver",
	 *     in="query",
	 *     description="Your Start Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="address_receiver",
	 *     in="query",
	 *     description="Your Start Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="phone_receiver",
	 *     in="query",
	 *     description="Your Start Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="description_order",
	 *     in="query",
	 *     description="Your End Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="id_service_type",
	 *     in="query",
	 *     description="Your End Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="total_weight",
	 *     in="query",
	 *     description="Your End Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="cod",
	 *     in="query",
	 *     description="COD",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="price_service",
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

	public function insertOrderStore(Request $request) {
		if ($request->isMethod('post')) {

			// $idUser = $request->idUser;
			// $idUser = 1;
			$idUser = auth()->user()->idUser;

			$result_store = DB::table('stores')->select('idStore')->where('idUser', $idUser)->get();

			if ($result_store->count() > 0) {

				$name_sender = $request->get('name_sender');
				$address_sender = $request->get('address_sender');
				$phone_sender = $request->get('phone_sender');

				$name_receiver = $request->get('name_receiver');
				$address_receiver = $request->get('address_receiver');
				$phone = $request->get('phone_receiver');

				$email = $request->get('email_receiver');
				$description = $request->get('description_order');
				$cod = $request->get('cod');
				$total_weight = $request->get('total_weight');
				$id_service_type = $request->get('id_service_type'); // CPN FAST 1 2 ....

				$bill_of_lading = 'LUX' . str_random(12);

				$time_delivery = $request->get('time_delivery');
				$distance_shipping = $request->get('distance_shipping');

				$price_service = encrypt("1111"); // Don't use

				$email = encrypt("EMAIL"); // Don't use

				$money_send = encrypt($request->get('money_send'));

				//////////////////////////////
				$result_service_types = DB::table('service_types')
					->where('idService', $id_service_type)
					->get();

				$service_price = $result_service_types[0]->price;

				$sender = $this->getLatLong($request->get('address_sender'));
				$senderLat = $sender['results'][0]['geometry']['location']['lat'];
				$senderLong = $sender['results'][0]['geometry']['location']['lng'];

				$receiver = $this->getLatLong($request->get('address_receiver'));
				$receiverLat = $receiver['results'][0]['geometry']['location']['lat'];
				$receiverLong = $receiver['results'][0]['geometry']['location']['lng'];

				$distance_shipping = $this->getDistance($senderLat, $senderLong, $receiverLat, $receiverLong);
				$distance_shipping = floatval($distance_shipping['rows'][0]['elements'][0]['distance']['text']);
				$distance_shipping = $this->milesToKilometers($distance_shipping);

				Log::debug("call helper distance_shipping " . print_r($distance_shipping, 1));
				Log::debug("call helper total_weight " . print_r($total_weight, 1));
				Log::debug("call helper service_price" . print_r($service_price, 1));

				$total_money = $this->calculateMoney($distance_shipping, $total_weight, $service_price);
				$time_delivery = $this->getDelivery($distance_shipping, $id_service_type);

				//Log::debug("call helper test " . print_r($senderLat, 1));
				//Log::debug("call helper distance_shipping " . print_r($distance_shipping, 1));
				//Log::debug("call helper time_delivery " . print_r($time_delivery, 1));

				// Log::debug("call helper service_price" . print_r($service_price, 1));

				// Log::debug("call helper total_money" . print_r($total_money, 1));

				// $receiverLat = encrypt($receiverLat);
				// $receiverLong = encrypt($receiverLong);

				// $senderLat = encrypt($senderLat);
				// $senderLong = encrypt($senderLong);

				//////////////////////////////////

				$id_shipper = $request->get('id_shipper');
				//$id_order_status = $request->get('id_order_status'); // comfirm done .....

				$store_id = $result_store[0]->idStore;

				$data_created = date('Y-m-d H:i:s');
				// $affected = DB::table('stores')->where('idStore', $store_id)->update([
				//           'idStore' => $store_id,
				//           'billOfLading' => $bill_of_lading,
				//           'nameReceiver' => $name_receiver,
				//           'addressReceiver' => $address_receiver,
				//           'latitudeReceiver' => $lat,
				//           'longitudeReceiver' => $long,
				//           'phoneReceiver' => $phone,
				//           'emailReceiver' => $email,
				//           'descriptionOrder' => $description,
				//           'COD' => $cod,
				//           'timeDelivery' => $time_delivery,
				//           'distanceShipping' => $distance_shipping,
				//           'idServiceType' => $id_service_type,
				//           'totalWeight' => $total_weight,
				//           'priceService' => $price_service,
				//           'totalMoney' => $total_money,
				//           'idOrderStatus' => Config::get('constants.status_type.pending'),
				//      ]);

				// insert into orders (idStore, billOfLading,nameReceiver,addressReceiver,latitudeReceiver,longitudeReceiver,phoneReceiver,emailReceiver,descriptionOrder,COD,timeDelivery,distanceShipping,idServiceType,totalWeight,priceService,totalMoney,idOrderStatus,dateCreated) values (1, 'LUXNONONON' , 'abc', '123', 11.3, 12.3, 123, 'email', 'des',123,'2018-12-11 00:00:00',1,1,123,400,123,1,'2018-12-06 03:24:41')

<<<<<<< HEAD
				$affected_order = DB::insert('insert into orders (idStore, billOfLading,nameSender, addressSender,phoneSender,nameReceiver,addressReceiver,latitudeSender,longitudeSender,latitudeReceiver,longitudeReceiver,phoneReceiver,emailReceiver,descriptionOrder,COD,timeDelivery,distanceShipping,idServiceType,totalWeight,priceService,totalMoney,idOrderStatus) values (?,?, ?,?,?,?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?)', [$store_id, $bill_of_lading, $name_sender, $address_sender, $phone_sender, $name_receiver, $address_receiver, $senderLat, $senderLong, $receiverLat, $receiverLong, $phone, $email, $description, $cod, $time_delivery, $distance_shipping, $id_service_type, $total_weight, $price_service, $money_send , Config::get('constants.status_type.pending')]);
=======
				$affected_order = DB::insert('insert into orders (idStore, billOfLading,nameSender, addressSender,phoneSender,nameReceiver,addressReceiver,latitudeSender,longitudeSender,latitudeReceiver,longitudeReceiver,phoneReceiver,emailReceiver,descriptionOrder,COD,timeDelivery,distanceShipping,idServiceType,totalWeight,priceService,totalMoney,idOrderStatus) values (?,?, ?,?,?,?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?)', [$store_id, encrypt($bill_of_lading), encrypt($name_sender), encrypt($address_sender), encrypt($phone_sender), encrypt($name_receiver), encrypt($address_receiver), encrypt($senderLat), encrypt($senderLong), encrypt($receiverLat), encrypt($receiverLong), encrypt($phone), encrypt($email), encrypt($description), encrypt($cod), encrypt($time_delivery), encrypt($distance_shipping), $id_service_type, encrypt($total_weight), encrypt($price_service), encrypt($total_money), Config::get('constants.status_type.pending')]);
>>>>>>> c3aca8147d5606933ad4d34f348928d582d69851

				$affected_store = DB::table('stores')->where('idStore', $store_id)->update([

					'nameStore' => encrypt($name_sender),
					'addressStore' => encrypt($address_sender),

				]);

				$affected_user = DB::table('users')->where('idUser', $idUser)->update([
					'phoneNumber' => encrypt($phone_sender),
				]);

				if ($affected_order && $affected_store && $affected_store) {
					return response()->json([
						'error' => false,
						'data' => $affected_order,
						'data1' => $affected_store,
						'data2' => $affected_user,
						'errors' => null,
					], 200);
				} else {

					return response()->json([
						'error' => true,
						'data' => $affected_order,
						'data1' => $affected_store,
						'data2' => $affected_user,
						'errors' => null,
					], 400);
				}
			} else {
				return response()->json([
					'error' => true,
					'data' => 'count > 0',
					'errors' => null,
				], 400);
			}

		}
	}

	/**
	 * @SWG\POST(
	 *   path="/api/store/getInfoEditFromIdorder",
	 *     tags={"Store"},
	 *   summary="Show Profile",
	 *   @SWG\Response(
	 *     response=200,
	 *     description="A list with products"
	 *   ),
	 *   @SWG\Parameter(
	 *     name="id_order",
	 *     in="query",
	 *     description="Your End Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Response(
	 *     response="default",
	 *     description="an ""unexpected"" error"
	 *   ),
	 *     security={{"api_key":{}}}
	 * )
	 */
	public function getInfoEditFromIdorder(Request $request) {
		if ($request->isMethod('post')) {

			// $idUser = $request->idUser;
			// $idUser = 1;
			$idUser = auth()->user()->idUser;

			$idOrder = $request->get('id_order');

			$result_store = DB::table('stores')->select('idStore')->where('idUser', $idUser)->get();

			if ($result_store->count() > 0) {

				$users = DB::table('orders')
					->join('stores', 'stores.idStore', '=', 'orders.idStore')
					->join('users', 'stores.idUser', '=', 'users.idUser')
					->where('idOrder', $idOrder)
					->get();

				myDecrypt($users);

				if ($users) {
					return response()->json([
						'error' => false,
						'data' => $users,
						'errors' => null,
					], 200);
				} else {
					return response()->json([
						'error' => true,
						'data' => null,
						'errors' => null,
					], 400);
				}
			} else {
				return response()->json([
					'error' => true,
					'data' => null,
					'errors' => null,
				], 400);
			}
		}
	}

	/**
	 * @SWG\POST(
	 *   path="/api/store/updateOrderStore",
	 *     tags={"Store"},
	 *   summary="Show Profile",
	 *   @SWG\Parameter(
	 *     name="name_sender",
	 *     in="query",
	 *     description="Your Name Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="address_sender",
	 *     in="query",
	 *     description="Your Type Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="phone_receiver",
	 *     in="query",
	 *     description="Your Start Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="email_receiver",
	 *     in="query",
	 *     description="Your End Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="description_order",
	 *     in="query",
	 *     description="Your End Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="address_receiver",
	 *     in="query",
	 *     description="Your Type Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="phone_receiver",
	 *     in="query",
	 *     description="Your End Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="id_service_type",
	 *     in="query",
	 *     description="Your End Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="total_weight",
	 *     in="query",
	 *     description="Your End Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="price_service",
	 *     in="query",
	 *     description="Your End Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="cod",
	 *     in="query",
	 *     description="Your End Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="order_id",
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

	public function updateOrderStore(Request $request) {
		//Log::debug("id_order_fsdfsfsfsdfstatus ");
		if ($request->isMethod('post')) {

			// $idUser = $request->idUser;
			// $idUser = 1;
			$idUser = auth()->user()->idUser;

			$result_store = DB::table('stores')->select('idStore')->where('idUser', $idUser)->get();
			//Log::debug("wtffffffffffffff");
			if ($result_store->count() > 0) {

				$bill_of_lading = $request->get('bill_of_lading');
				$bill_of_lading = 'LUX' . str_random(12);
				$name_receiver = $request->get('name_receiver');
				$address_receiver = $request->get('address_receiver');
				$lat = $request->get('latitude_receiver');
				$long = $request->get('longitude_receiver');
				$phone = $request->get('phone_receiver');
				$email = $request->get('email_receiver');
				$description = $request->get('description_order');
				$cod = $request->get('cod');
				$time_delivery = $request->get('time_delivery');
				$distance_shipping = $request->get('distance_shipping');
				$id_service_type = $request->get('id_service_type');
				$total_weight = $request->get('total_weight');
				$total_money = $request->get('total_money');
				$id_shipper = $request->get('id_shipper');
				//$id_order_status = $request->get('id_order_status');

				$order_id = $request->get('order_id');

				$id_order_status = DB::table('orders')
					->select('idOrderStatus')
					->where('idOrder', $order_id)
					->get();

				$id_order_status_db = $id_order_status[0]->idOrderStatus;

				// $lat = 11.3;
				// $long = 12.3;

				// $time_delivery = '2018-12-11 00:00:00';
				// $distance_shipping = 12;
				// $store_id = $result_store[0]->idStore;
				// $order_id = 1;
				// $store_id = 1;
				// $total_money = 123;

				//$data_created = date('Y-m-d H:i:s');

				$email = "test@test.com";
				Log::debug("order_id " . $order_id);
				Log::debug("id_order_status " . print_r($id_order_status[0]->idOrderStatus, 1));

				$result_service_types = DB::table('service_types')
					->where('idService', $id_service_type)
					->get();

				$service_price = $result_service_types[0]->price;

				$sender = $this->getLatLong($request->get('address_sender'));
				$senderLat = $sender['results'][0]['geometry']['location']['lat'];
				$senderLong = $sender['results'][0]['geometry']['location']['lng'];

				$receiver = $this->getLatLong($request->get('address_receiver'));
				$receiverLat = $receiver['results'][0]['geometry']['location']['lat'];
				$receiverLong = $receiver['results'][0]['geometry']['location']['lng'];

				$distance_shipping = $this->getDistance($senderLat, $senderLong, $receiverLat, $receiverLong);
				$distance_shipping = floatval($distance_shipping['rows'][0]['elements'][0]['distance']['text']);
				$distance_shipping = $this->milesToKilometers($distance_shipping);

				$total_money = $this->calculateMoney($distance_shipping, $total_weight, $service_price);
				$time_delivery = $this->getDelivery($distance_shipping, $id_service_type);

				if ($id_order_status_db > Config::get('constants.status_type.pending')) {
					return response()->json([
						'error' => true,
						'data' => "data confirmed",
						'errors' => null,
					], 200);
				}

				//Log::debug("wtffffffffffffff " . print_r($order_id, 1));

				$affected = DB::table('orders')->where('idOrder', $order_id)->update([
					'billOfLading' => encrypt($bill_of_lading),
					'nameReceiver' => encrypt($name_receiver),
					'addressReceiver' => encrypt($address_receiver),
					'latitudeReceiver' => encrypt($lat),
					'longitudeReceiver' => encrypt($long),
					'phoneReceiver' => encrypt($phone),
					'emailReceiver' => encrypt($email),
					'descriptionOrder' => encrypt($description),
					'COD' => encrypt($cod),
					'timeDelivery' => encrypt($time_delivery),
					'distanceShipping' => encrypt($distance_shipping),
					'totalWeight' => encrypt($total_weight),
					'priceService' => encrypt($service_price),
					'totalMoney' => encrypt($total_money),
					'idServiceType' => $id_service_type,
					'idOrderStatus' => Config::get('constants.status_type.pending'),
				]);

				if ($affected) {
					return response()->json([
						'error' => false,
						'data' => $affected,
						'errors' => null,
					], 200);
				} else {

					return response()->json([
						'error' => true,
						'data' => $affected,
						'errors' => null,
					], 400);
				}
			} else {
				return response()->json([
					'error' => true,
					'data' => "count > 0",
					'errors' => null,
				], 400);
			}

		}
	}

	/**
	 * @SWG\POST(
	 *   path="/api/store/deleteOrderStore",
	 *     tags={"Store"},
	 *   summary="Show Profile",
	 *   @SWG\Response(
	 *     response=200,
	 *     description="A list with products"
	 *   ),
	 *   @SWG\Parameter(
	 *     name="order_id",
	 *     in="query",
	 *     description="Your End Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Response(
	 *     response="default",
	 *     description="an ""unexpected"" error"
	 *   ),
	 *     security={{"api_key":{}}}
	 * )
	 */
	public function deleteOrderStore(Request $request) {
		///?????
		if ($request->isMethod('post')) {
			$order_id = $request->get('order_id');
			// $idUser = $request->idUser;
			// $idUser = 1;
			$idUser = auth()->user()->idUser;

			$result_store = DB::table('stores')->select('idStore')->where('idUser', $idUser)->get();
			Log::debug('idUser' . print_r($result_store, 1));
			if ($result_store->count() > 0) {

				$idStore = $result_store[0]->idStore;

				$affected = DB::table('orders')->where('idOrder', $order_id)->delete();

				if ($affected) {
					return response()->json([
						'error' => false,
						'data' => $affected,
						'errors' => null,
					], 200);
				} else {

					response()->json([
						'error' => true,
						'data' => $affected,
						'errors' => null,
					], 400);
				}
			} else {
				return response()->json([
					'error' => true,
					'data' => null,
					'errors' => null,
				], 400);
			}
		}
	}

	public function getLatLong($address) {
		$request_url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key=AIzaSyBVLZZFaDU6nn96cbs59PfMBNXu9ZNdxYE";
		$string = file_get_contents($request_url);
		return json_decode($string, true);
	}

	private function caculateTimedelivery($idServiceType, $distance) {
		if ($idServiceType == 1) {
			if ($distance < 50) {
				return 1;
			} else if (50 <= $distance && $distance < 200) {
				return 2;
			} else if ($distance >= 200) {
				return 3;
			}

		} else if ($idServiceType == 2) {
			if ($distance < 50) {
				return 1;
			} else if (50 <= $distance && $distance < 200) {
				return 2;
			} else if ($distance >= 200) {
				return 3;
			}

		} else if ($idServiceType == 3) {
			if ($distance < 50) {
				return 1;
			} else if (50 <= $distance && $distance < 200) {
				return 1;
			} else if ($distance >= 200) {
				return 2;
			}
		}
	}

	private function getDelivery($distance, $services) {
		switch ($services) {
		case 1:
			if ($distance < 50) {
				return $date = Carbon::now()->addDays(1);
			} elseif ($distance >= 50 && $distance < 200) {
				return $date = Carbon::now()->addDays(2);
			} elseif ($distance >= 200) {
				return $date = Carbon::now()->addDays(3);
			}

			break;
		case 2:
			if ($distance < 50) {
				return $date = Carbon::now()->addDays(1);
			} elseif ($distance >= 50 && $distance < 200) {
				return $date = Carbon::now()->addDays(2);
			} elseif ($distance >= 200) {
				return $date = Carbon::now()->addDays(2);
			}

			break;
		case 3:
			if ($distance < 50) {
				return $date = Carbon::now()->addDays(1);
			} elseif ($distance >= 50 && $distance < 200) {
				return $date = Carbon::now()->addDays(1);
			} elseif ($distance >= 200) {
				return $date = Carbon::now()->addDays(2);
			}

		}
	}

	private function getDistance($originLat, $originLong, $desLat, $desLong) {
		$request_url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=" . $originLat . "," . $originLong . "&destinations=" . $desLat . "," . $desLong . "&key=AIzaSyBVLZZFaDU6nn96cbs59PfMBNXu9ZNdxYE";
		$string = file_get_contents($request_url);
		return json_decode($string, true);
	}
	private function milesToKilometers($miles) {
		return round($miles * 1.60934, 1);
	}
	private function calculateMoney($distance, $totalWeight, $servicePrice) {
		if ($distance < 15) {
			return round($distance * $servicePrice * $totalWeight);
		} elseif ($distance >= 15 && $distance < 30) {
			return round($distance * ($servicePrice / 2) * $totalWeight);
		} elseif ($distance >= 30 && $distance < 50) {
			return round($distance * ($servicePrice / 4) * $totalWeight);
		} elseif ($distance >= 50 && $distance < 100) {
			return round($distance * ($servicePrice / 6) * $totalWeight);
		} elseif ($distance >= 100) {
			return round($distance * ($servicePrice / 10) * $totalWeight);
		}

	}

	/**
	 * @SWG\POST(
	 *   path="/api/store/getPreMoney",
	 *     tags={"Store"},
	 *   summary="Show Profile",
	 *   @SWG\Response(
	 *     response=200,
	 *     description="A list with products"
	 *   ),
	 *   @SWG\Parameter(
	 *     name="idServices",
	 *     in="query",
	 *     description="Your End Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="SenderAddress",
	 *     in="query",
	 *     description="Your End Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="ReceiverAddress",
	 *     in="query",
	 *     description="Your End Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="OrderWeight",
	 *     in="query",
	 *     description="Your End Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Response(
	 *     response="default",
	 *     description="an ""unexpected"" error"
	 *   ),
	 *     security={{"api_key":{}}}
	 * )
	 */
	public function getPreMoney(Request $request) {
		$idServices = $request->get('idServices');
		$senderAddress = $request->get('SenderAddress');
		$receiverAddress = $request->get('ReceiverAddress');
		$orderWeight = $request->get('OrderWeight');

		if (!empty($idServices) && !empty($senderAddress) && !empty($receiverAddress) && !empty($orderWeight)) {
			$servicePrice = DB::table('service_types')->where('idService', $idServices)->first()->price;
			$sender = $this->getLatLong($senderAddress);
			$senderLat = $sender['results'][0]['geometry']['location']['lat'];
			$senderLong = $sender['results'][0]['geometry']['location']['lng'];
			$receiver = $this->getLatLong($receiverAddress);
			$receiverLat = $receiver['results'][0]['geometry']['location']['lat'];
			$receiverLong = $receiver['results'][0]['geometry']['location']['lng'];
			$distance = $this->getDistance($senderLat, $senderLong, $receiverLat, $receiverLong);
			$distance = floatval($distance['rows'][0]['elements'][0]['distance']['text']);
			$distance = $this->milesToKilometers($distance);
			$money = $this->calculateMoney($distance, $orderWeight, $servicePrice);
			$timeDelivery = $this->getDelivery($distance, $idServices)->toFormattedDateString();
			return response()->json([
				'preMoney' => $money,
				'timeDelivery' => $timeDelivery,
			]);

		}

	}

	/**
	 * @SWG\POST(
	 *   path="/api/store/searchBilloflading",
	 *     tags={"Shipper"},
	 *   summary="Show Profile",
	 *   @SWG\Response(
	 *     response=200,
	 *     description="A list with products"
	 *   ),
	 *   @SWG\Parameter(
	 *     name="bill_of_lading",
	 *     in="query",
	 *     description="bill_of_lading",
	 *     type="string",
	 *   ),
	 *   @SWG\Response(
	 *     response="default",
	 *     description="an ""unexpected"" error"
	 *   ),
	 *	 security={{"api_key":{}}}
	 * )
	 */
	public function searchBilloflading(Request $request) {
		$idUser = auth()->user()->idUser;

		$bill_of_lading = $request->get('bill_of_lading');

		//Log::debug('bill_of_lading' . print_r($bill_of_lading, 1));

		$result_shipper = DB::table('shippers')->select('idShipper')->where('idUser', $idUser)->get();

		if ($result_shipper->count() > 0) {

			$idShipper = $result_shipper[0]->idShipper;

			$result_order = DB::table('orders')
				->join('stores', 'stores.idStore', '=', 'orders.idStore')
				->join('users', 'stores.idUser', '=', 'users.idUser')
				->where('idShipper', $idShipper)
			//->where('billOfLading', $bill_of_lading);
				->get();

			myDecrypt($result_order);

			$result = array();

			foreach ($result_order as $key => $line) {

				foreach ($line as $key_line => $value) {
					if ($key_line == "billOfLading") {
						if ($line->$key_line == $bill_of_lading) {
							$result = $line;
						}

					}

					//Log::debug('search' . print_r($line->$key_line, 1));
				}
			}

			return response()->json([
				'error' => false,
				'data' => $result,
				//'data' => $result_order,
				'errors' => null,
			], 200);

		} else {
			return response()->json([
				'error' => true,
				'data' => null,
				'errors' => null,
			], 400);
		}
	}

}