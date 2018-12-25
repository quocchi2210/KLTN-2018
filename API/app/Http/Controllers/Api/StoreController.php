<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
			$user_id = $request->idUser;
			$user_id = 1;

			// 	$request->request->add(
			// 	array(
			// 		'idUser' => $user_id,
			// 	)

			// );
			//[$user_id, $name_store, $type_store, $address_store, $description_store, $latitude_store, $longitude_store, $start_working_time, $end_working_time]

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

			$user_id = $request->idUser;
			$user_id = 1;

			$store_id = 1;

			$result_store = DB::table('stores')->select('idStore')->where('idUser', $user_id)->get();

			$test = DB::table('stores')->where('idUser', $user_id)->get();

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

			$user_id = $request->authen_id;
			$store_id = 1;

			$affected = DB::table('stores')
				->join('users', 'stores.idUser', '=', 'users.idUser')
				->where('idStore', 1)
				->get();

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

			$idUser = $request->idUser;
			$idUser = 1;

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


				Log::debug("call helper".print_r(myDecrypt($users),1));

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
			$idUser = $request->idUser;

			$idUser = 1;

			$result_store = DB::table('stores')->select('idStore')->where('idUser', $idUser)->get();
			if ($result_store->count() > 0) {

				$users = DB::table('order_details')
					->join('orders', 'order_details.idOrder', '=', 'orders.idOrder')
					->join('stores', 'stores.idStore', '=', 'orders.idStore')
					->where('order_details.idOrder', $idOrder)
					->get();

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

			$idUser = $request->idUser;
			$idUser = 1;

			$result_store = DB::table('stores')->select('idStore')->where('idUser', $idUser)->get();

			if ($result_store->count() > 0) {

				$name_sender = encrypt($request->get('name_sender'));
				$address_sender = encrypt($request->get('address_sender'));
				$phone_sender = encrypt($request->get('phone_sender'));

				$name_receiver = encrypt($request->get('name_receiver'));
				$address_receiver = encrypt($request->get('address_receiver'));
				$phone = encrypt($request->get('phone_receiver'));

				$email = encrypt($request->get('email_receiver'));
				$description = encrypt($request->get('description_order'));
				$cod = encrypt($request->get('cod'));
				$total_weight = encrypt($request->get('total_weight'));
				$id_service_type = $request->get('id_service_type'); // CPN FAST 1 2 ....

				$bill_of_lading = encrypt($request->get('bill_of_lading'));
				$bill_of_lading = encrypt('LUXABC1234');

				$lat = encrypt($request->get('latitude_receiver'));
				$long = encrypt($request->get('longitude_receiver'));

				$lat = encrypt("11.3");
				$long = encrypt("12.3");

				$time_delivery = encrypt($request->get('time_delivery'));
				$distance_shipping = encrypt($request->get('distance_shipping'));

				$time_delivery = encrypt('2018-12-11 00:00:00');
				$distance_shipping = encrypt("12");

				$price_service = encrypt("400");
				$total_money = encrypt("500");
				$email = encrypt("EMAIL");

				Log::debug("WTF".$long);
				//////////////////////////////
				// $result_service_types = DB::table('service_types')
				// 	->where('idService', $id_service_type)
				// 	->get();

				// $service_price = $result_service_types[0]->price;
				// $distance_shipping = $this->getDistance($senderLat, $senderLong, $receiverLat, $receiverLong);

				// $distance_shipping = floatval($distance['rows'][0]['elements'][0]['distance']['text']);

				// $distance_shipping = $this->milesToKilometers($distance);
				// $total_money = $this->calculateMoney($distance_shipping, $total_weight, $service_price);

				// $time_delivery = caculateTimedelivery($id_service_type, $distance_shipping);

				// $time_delivery = date('Y-m-d H:i:s', strtotime($time_delivery . "+ days"));

				//////////////////////////////////

				$id_shipper = $request->get('id_shipper');
				$id_order_status = $request->get('id_order_status'); // comfirm done .....

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

				$affected_order = DB::insert('insert into orders (idStore, billOfLading,nameSender, addressSender,phoneSender,nameReceiver,addressReceiver,latitudeSender,longitudeSender,latitudeReceiver,longitudeReceiver,phoneReceiver,emailReceiver,descriptionOrder,COD,timeDelivery,distanceShipping,idServiceType,totalWeight,priceService,totalMoney,idOrderStatus) values (?,?, ?,?,?,?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?)', [$store_id, $bill_of_lading, $name_sender,$address_sender,$phone_sender,$name_receiver, $address_receiver,$lat, $long, $lat, $long, $phone, $email, $description, $cod, $time_delivery, $distance_shipping, $id_service_type, $total_weight, $price_service, $total_money, Config::get('constants.status_type.pending')]);

				$affected_store = DB::table('stores')->where('idStore', $store_id)->update([

					'nameStore' => $name_sender,
					'addressStore' => $address_sender,

				]);

				$affected_user = DB::table('users')->where('idUser', $idUser)->update([
					'phoneNumber' => $phone_sender,
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
			}else{
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

			$idUser = $request->idUser;

			$idUser = 1;

			$idOrder = $request->get('id_order');

			$result_store = DB::table('stores')->select('idStore')->where('idUser', $idUser)->get();

			if ($result_store->count() > 0) {

				$users = DB::table('orders')
					->join('stores', 'stores.idStore', '=', 'orders.idStore')
					->join('users', 'stores.idStore', '=', 'orders.idStore')
					->where('idOrder', $idOrder)
					->get();

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
	 *     name="name_receiver",
	 *     in="query",
	 *     description="Your Name Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="address_receiver",
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
		if ($request->isMethod('post')) {

			$idUser = $request->idUser;
			$idUser = 1;

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
				$price_service = 400;
				$total_money = $request->get('total_money');
				$id_shipper = $request->get('id_shipper');
				$id_order_status = $request->get('id_order_status');

				$lat = 11.3;
				$long = 12.3;

				$time_delivery = '2018-12-11 00:00:00';
				$distance_shipping = 12;
				$store_id = $result_store[0]->idStore;
				$order_id = 1;
				$store_id = 1;
				$total_money = 123;

				$data_created = date('Y-m-d H:i:s');

				$email = "test@test.com";

				//Log::debug("wtffffffffffffff " . print_r($order_id, 1));

				$affected = DB::table('orders')->where('idOrder', $order_id)->update([
					'billOfLading' => $bill_of_lading,
					'nameReceiver' => $name_receiver,
					'addressReceiver' => $address_receiver,
					'latitudeReceiver' => $lat,
					'longitudeReceiver' => $long,
					'phoneReceiver' => $phone,
					'emailReceiver' => $email,
					'descriptionOrder' => $description,
					'COD' => $cod,
					'timeDelivery' => $time_delivery,
					'distanceShipping' => $distance_shipping,
					'idServiceType' => $id_service_type,
					'totalWeight' => $total_weight,
					'priceService' => $price_service,
					'totalMoney' => $total_money,
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

		if ($request->isMethod('post')) {
			$order_id = $request->get('order_id');
			$idUser = $request->idUser;
			$idUser = 1;
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

}