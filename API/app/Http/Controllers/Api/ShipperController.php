<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Config;
use DB;
use Illuminate\Http\Request;
use Validator;

class ShipperController extends Controller {
	/**
	 * @SWG\POST(
	 *   path="/api/shipper/showOrder",
	 *     tags={"Shipper"},
	 *   summary="Show Profile",
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
	public function showOrder(Request $request) {

		if ($request->isMethod('post')) {

			$idUser = auth()->user()->idUser;

			$result_shipper = DB::table('shippers')->select('idShipper')->where('idUser', $idUser)->get();
			if ($result_shipper->count() > 0) {

				// Log::debug('idUser'. print_r($idUser,1));
				// Log::debug('idShipper'. print_r($result_shipper[0]['idShipper'],1));

				$idShipper = $result_shipper[0]->idShipper;
				// $users = DB::statement("SELECT * FROM orders WHERE idShipper=?",[$idShipper]);

				// $users = DB::select("SELECT * FROM orders WHERE idShipper = ?",[$idShipper]);

				$users = DB::table('orders')
					->where('idShipper', $idShipper)->whereNotIn('idOrderStatus', [Config::get('constants.status_type.pending')])
					->where('idOrderStatus', Config::get('constants.status_type.confirm'))
				// ->orWhere('idOrderStatus', Config::get('constants.status_type.confirm'))
				// ->orWhere('idOrderStatus', Config::get('constants.status_type.pickup'))
				// ->orWhere('idOrderStatus', Config::get('constants.status_type.delivery'))
					->get();

				// $test = DB::table('orders')
				// 	->where('idShipper', $idShipper)->whereNotIn('idOrderStatus', [Config::get('constants.status_type.pending')])
				// 	->where('idOrderStatus', Config::get('constants.status_type.confirm'))
				// 	->toSql();

				//Log::debug("Log query showOrder" . print_r($test, 1));

				myDecrypt($users);

				if ($users) {
					return response()->json([
						'error' => false,
						'data' => $users,
						'iduser' => $idUser,
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
					'iduser' => $idUser,
					//'test' => decrypt_test($abc),
					'errors' => null,
				], 400);
			}
		}
	}

	/**
	 * @SWG\POST(
	 *   path="/api/shipper/showProfileShipper",
	 *     tags={"Shipper"},
	 *   summary="showProfileShipper",
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
	public function showProfileShipper(Request $request) {
		if ($request->isMethod('post')) {
			$idUser = auth()->user()->idUser;

			$result_shipper = DB::table('shippers')->select('idShipper')->where('idUser', $idUser)->get();

			if ($result_shipper->count() > 0) {

				$idShipper = $result_shipper[0]->idShipper;

				$result_shipper = DB::table('shippers')->where('idShipper', $idShipper)->get();

				$result_user = DB::table('users')->where('idUser', $idUser)->get();

				myDecrypt($result_shipper);
				myDecrypt($result_user);

				if ($result_user && $result_shipper) {
					return response()->json([
						'error' => false,
						'data' => $result_shipper,
						'data1' => $result_user,
						'errors' => null,
					], 200);
				} else {
					return response()->json([
						'error' => true,
						'data' => $result_shipper,
						'data1' => $result_user,
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
	 *   path="/api/shipper/updateProfileShipper",
	 *     tags={"Shipper"},
	 *   summary="Show Profile",
	 *   @SWG\Response(
	 *     response=200,
	 *     description="A list with products"
	 *   ),
	 *   @SWG\Parameter(
	 *     name="license_plates",
	 *     in="query",
	 *     description="Your End Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="date_of_Birth",
	 *     in="query",
	 *     description="Your End Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="gender",
	 *     in="query",
	 *     description="Your End Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="id_number",
	 *     in="query",
	 *     description="Your End Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Response(
	 *     response="default",
	 *     description="an ""unexpected"" error"
	 *   ),
	 *	 security={{"api_key":{}}}
	 * )
	 */
	public function updateProfileShipper(Request $request) {
		if ($request->isMethod('post')) {
			$license_plates = $request->get('license_plates');
			$date_of_Birth = $request->get('date_of_Birth');
			$gender = $request->get('gender');
			$id_number = $request->get('id_number');
			$full_name = $request->get('full_name');

			$idUser = auth()->user()->idUser;

			$validate = Validator::make(
				$request->all(),
				[
					'license_plates' => 'required|max:255',
					'date_of_Birth' => 'max:255',
					'id_number' => 'required|max:255',
					'full_name' => 'required|max:255',
				],

				[
					'required' => ':attribute không được để trống',
					'min' => ':attribute không được nhỏ hơn :min',
					'max' => ':attribute không được lớn hơn :max',
				],

				[
					'license_plates' => 'Biển số xe',
					'date_of_Birth' => 'Ngày sinh nhật',
					'id_number' => 'Số chứng minh nhân dân',
					'full_name' => 'Họ và tên',
				]

			);

			if ($validate->fails()) {
				return response()->json([
					'data' => 'validate',
					'success' => false,
					'errors' => $validate->messages(),
				]);
			}

			$result_shipper = DB::table('shippers')->select('idShipper')->where('idUser', $idUser)->get();

			if ($result_shipper->count() > 0) {

				$idShipper = $result_shipper[0]->idShipper;

				$affected_shipper = DB::table('shippers')->where('idShipper', $idShipper)->update([
					'licensePlates' => encrypt($license_plates),
				]);

				$affected_user = DB::table('users')->where('idUser', $idUser)->update([
					'idNumber' => encrypt($id_number),
					'dateOfBirth' => encrypt($date_of_Birth),
					'gender' => encrypt($gender),
					'fullName' => encrypt($full_name),
				]);

				if ($affected_shipper && $affected_user) {
					return response()->json([
						'error' => false,
						'data' => $affected_shipper,
						'data1' => $affected_user,
						'errors' => null,
					], 200);
				} else {
					return response()->json([
						'error' => true,
						'data' => $affected_shipper,
						'data1' => $affected_user,
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
	 *   path="/api/shipper/showAllStoreOrder",
	 *     tags={"Shipper"},
	 *   summary="Show Profile",
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
	public function showAllStoreOrder(Request $request) {

		if ($request->isMethod('post')) {

			$idUser = auth()->user()->idUser;

			$result_shipper = DB::table('shippers')->select('idShipper')->where('idUser', $idUser)->get();
			if ($result_shipper->count() > 0) {

				// Log::debug('idUser'. print_r($idUser,1));
				// Log::debug('idShipper'. print_r($result_shipper[0]['idShipper'],1));

				$idShipper = $result_shipper[0]->idShipper;
				// $users = DB::statement("SELECT * FROM orders WHERE idShipper=?",[$idShipper]);

				// $users = DB::select("SELECT * FROM orders WHERE idShipper = ?",[$idShipper]);

				$users = DB::table('orders')
					->distinct('idStore')
					->select('stores.idStore', 'stores.nameStore')
					->join('stores', 'stores.idStore', '=', 'orders.idStore')
					->where('idShipper', $idShipper)
					->where('idOrderStatus', Config::get('constants.status_type.done'))
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
					'data' => 'count > 0',
					'errors' => null,
				], 400);
			}
		}
	}

	/**
	 * @SWG\POST(
	 *   path="/api/shipper/showOrderReceived",
	 *     tags={"Shipper"},
	 *   summary="Show Profile",
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
	public function showOrderReceived(Request $request) {

		if ($request->isMethod('post')) {

			$idUser = auth()->user()->idUser;

			$result_shipper = DB::table('shippers')->select('idShipper')->where('idUser', $idUser)->get();
			if ($result_shipper->count() > 0) {

				// Log::debug('idUser'. print_r($idUser,1));

				$idShipper = $result_shipper[0]->idShipper;

				$users = DB::table('orders')
					->join('stores', 'stores.idStore', '=', 'orders.idStore')
					->where('idShipper', $idShipper)
				//->whereBetween('idOrderStatus', array(3, 4))
					->where('idOrderStatus', Config::get('constants.status_type.pickup'))
					->get();

				myDecrypt($users);
				// DB::enableQueryLog();

				// $laQuery = DB::getQueryLog();

				// DB::disableQueryLog();

				// Log::debug('idShipper' . print_r($laQuery, 1));

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

	public function showDetailOrder(Request $request) {

		if ($request->isMethod('post')) {

			$idOrder = $request->get('id_order');
			$idUser = auth()->user()->idUser;

			$result_shipper = DB::table('shippers')->select('idShipper')->where('idUser', $idUser)->get();
			if ($result_shipper->count() > 0) {

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
	 *   path="/api/shipper/showHistory",
	 *     tags={"Shipper"},
	 *   summary="Show Profile",
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
	public function showHistory(Request $request) {

		if ($request->isMethod('post')) {

			$idUser = auth()->user()->idUser;

			$result_shipper = DB::table('shippers')->select('idShipper')->where('idUser', $idUser)->get();

			if ($result_shipper->count() > 0) {

				$idShipper = $result_shipper[0]->idShipper;

				$result_order = DB::table('orders')
					->join('stores', 'stores.idStore', '=', 'orders.idStore')
					->where('idShipper', $idShipper)
					->where('idOrderStatus', Config::get('constants.status_type.done'))
					->get();

				$store_name = DB::table('orders')
					->distinct('idStore')
					->select('stores.idStore', 'stores.nameStore')
					->join('stores', 'stores.idStore', '=', 'orders.idStore')
					->where('idShipper', $idShipper)
					->where('idOrderStatus', Config::get('constants.status_type.done'))
					->get();

				myDecrypt($result_order);

				myDecrypt($store_name);

				if ($result_order->count() > 0) {
					return response()->json([
						'error' => false,
						'data' => $result_order,
						'store_name' => $store_name,
						'errors' => null,
					], 200);
				} else {
					return response()->json([
						'error' => true,
						'data' => 'wtf',
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
	 *   path="/api/shipper/updateStatus",
	 *     tags={"Shipper"},
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
	 *   @SWG\Parameter(
	 *     name="status_order_rq",
	 *     in="query",
	 *     description="Your End Working Store",
	 *     type="string",
	 *   ),
	 *   @SWG\Response(
	 *     response="default",
	 *     description="an ""unexpected"" error"
	 *   ),
	 *	 security={{"api_key":{}}}
	 * )
	 */
	public function updateStatus(Request $request) {

		if ($request->isMethod('post')) {
			$status_order_rq = $request->get('status_order_rq');
			$id_order = $request->get('id_order');
			$idUser = auth()->user()->idUser;

			// $status_order=4;
			$result_shipper = DB::table('shippers')->select('idShipper')->where('idUser', $idUser)->get();

			if ($result_shipper->count() > 0) {

				$idShipper = $result_shipper[0]->idShipper;

				$result_order = DB::table('orders')
					->where('idOrder', $id_order)
					->get();

				$status_order = $result_order[0]->idOrderStatus;

				if ($status_order_rq < Config::get('constants.status_type.done')) {
					$status_order_rq++;
				}

				if ($status_order == 6) {
					$status_order_rq = 6;
				}

				$affected = DB::table('orders')
					->where('idOrder', $id_order)
					->update(['idOrderStatus' => $status_order_rq]);

				if ($affected) {
					return response()->json([
						'error' => false,
						'data' => $affected,
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
	 *   path="/api/shipper/getDirection",
	 *     tags={"Shipper"},
	 *   summary="Show Profile",
	 *   @SWG\Response(
	 *     response=200,
	 *     description="A list with products"
	 *   ),
	 *   @SWG\Parameter(
	 *     name="origin",
	 *     in="query",
	 *     description="origin",
	 *     type="string",
	 *   ),
	 *   @SWG\Parameter(
	 *     name="destination",
	 *     in="query",
	 *     description="destination",
	 *     type="string",
	 *   ),
	 *   @SWG\Response(
	 *     response="default",
	 *     description="an ""unexpected"" error"
	 *   ),
	 *	 security={{"api_key":{}}}
	 * )
	 */
	public function getDirection(Request $request) {

		$origin = $request->get('origin');

		$destination = $request->get('destination');

		$request_url = "https://maps.googleapis.com/maps/api/directions/json?origin=" . urlencode($origin) . "&destination=" . urlencode($destination) . "&key=AIzaSyBVLZZFaDU6nn96cbs59PfMBNXu9ZNdxYE";

		$string = file_get_contents($request_url);

		return json_decode($string, true);
	}

	/**
	 * @SWG\POST(
	 *   path="/api/shipper/checkOrderShipper",
	 *     tags={"Shipper"},
	 *   summary="Show Profile",
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
	public function checkOrderShipper(Request $request) {

		$idUser = auth()->user()->idUser;

		//$id_shipper = $request->get('id_shipper');

		$result_shipper = DB::table('shippers')->select('idShipper')->where('idUser', $idUser)->get();

		if ($result_shipper->count() > 0) {

			$idShipper = $result_shipper[0]->idShipper;

			//Log::debug('idShipper' . print_r($idShipper, 1));

			$result_order = DB::table('orders')
				->join('stores', 'stores.idStore', '=', 'orders.idStore')
				->join('users', 'stores.idUser', '=', 'users.idUser')
				->where('idShipper', $idShipper)
				->where('idOrderStatus', Config::get('constants.status_type.delivery'))
				->get();

			myDecrypt($result_order);

			return response()->json([
				'error' => false,
				'data' => $result_order->count(),
				'data_order' => $result_order,
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

	/**
	 * @SWG\POST(
	 *   path="/api/shipper/searchBilloflading",
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

	/**
	 * @SWG\POST(
	 *   path="/api/shipper/showAllGeoStore",
	 *     tags={"Shipper"},
	 *   summary="Show Profile",
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

	public function showAllGeoStore() {
		$idUser = auth()->user()->idUser;

		$result_shipper = DB::table('shippers')->select('idShipper')->where('idUser', $idUser)->get();

		if ($result_shipper->count() > 0) {

			$idShipper = $result_shipper[0]->idShipper;

			$result_order = DB::table('orders')
				->join('stores', 'stores.idStore', '=', 'orders.idStore')
				->join('users', 'stores.idUser', '=', 'users.idUser')
				->where('idShipper', $idShipper)
				->get();

			myDecrypt($result_order);

			return response()->json([
				'error' => false,
				'data' => $result_order,
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
