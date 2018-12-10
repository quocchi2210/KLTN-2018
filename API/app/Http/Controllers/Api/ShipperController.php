<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Config;
use DB;
use Illuminate\Http\Request;

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

			$idUser = $request->idUser;
			$idUser = 1;
			$result_shipper = DB::table('shippers')->select('idShipper')->where('idUser', $idUser)->get();
			if ($result_shipper->count() > 0) {

				// Log::debug('idUser'. print_r($idUser,1));
				// Log::debug('idShipper'. print_r($result_shipper[0]['idShipper'],1));

				$idShipper = $result_shipper[0]->idShipper;
				// $users = DB::statement("SELECT * FROM orders WHERE idShipper=?",[$idShipper]);

				// $users = DB::select("SELECT * FROM orders WHERE idShipper = ?",[$idShipper]);

				$users = DB::table('orders')
					->where('idShipper', $idShipper)->whereNotIn('idOrderStatus', [Config::get('constants.status_type.pending')])
				// ->orWhere('idOrderStatus', Config::get('constants.status_type.confirm'))
				// ->orWhere('idOrderStatus', Config::get('constants.status_type.pickup'))
				// ->orWhere('idOrderStatus', Config::get('constants.status_type.delivery'))
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

			$idUser = $request->idUser;
			$idUser = 1;
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

			$idUser = $request->idUser;
			$idUser = 1;
			$result_shipper = DB::table('shippers')->select('idShipper')->where('idUser', $idUser)->get();
			if ($result_shipper->count() > 0) {

				// Log::debug('idUser'. print_r($idUser,1));
				// Log::debug('idShipper'. print_r($result_shipper[0]['idShipper'],1));

				$idShipper = $result_shipper[0]->idShipper;

				$users = DB::table('orders')
					->join('stores', 'stores.idStore', '=', 'orders.idStore')
					->where('idShipper', $idShipper)->whereIn('idOrderStatus', [Config::get('constants.status_type.delivery')])
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
	 *   path="/api/shipper/showDetailOrder",
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
	 *   @SWG\Response(
	 *     response="default",
	 *     description="an ""unexpected"" error"
	 *   ),
	 *	 security={{"api_key":{}}}
	 * )
	 */
	public function showDetailOrder(Request $request) {

		if ($request->isMethod('post')) {

			$idOrder = $request->get('id_order');
			$idUser = $request->idUser;

			$idUser = 1;

			$result_shipper = DB::table('shippers')->select('idShipper')->where('idUser', $idUser)->get();
			if ($result_shipper->count() > 0) {

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

			$idUser = $request->idUser;
			$idUser = 1;
			$result_shipper = DB::table('shippers')->select('idShipper')->where('idUser', $idUser)->get();

			if ($result_shipper->count() > 0) {

				$idShipper = $result_shipper[0]->idShipper;

				$result_order = DB::table('orders')
					->join('stores', 'stores.idStore', '=', 'orders.idStore')
					->where('idShipper', $idShipper)
					->where('idOrderStatus', Config::get('constants.status_type.done'))
					->get();

				if ($result_order->count() > 0) {
					return response()->json([
						'error' => false,
						'data' => $result_order,
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
	 *   @SWG\Response(
	 *     response="default",
	 *     description="an ""unexpected"" error"
	 *   ),
	 *	 security={{"api_key":{}}}
	 * )
	 */
	public function updateStatus(Request $request) {

		if ($request->isMethod('post')) {
			$status_order = $request->get('status_order');
			$idUser = $request->idUser;
			// $idUser =2;
			// $status_order=4;
			$result_shipper = DB::table('shippers')->select('idShipper')->where('idUser', $idUser)->get();

			if ($result_shipper->count() > 0) {

				$idShipper = $result_shipper[0]->idShipper;

				if ($status_order < Config::get('constants.status_type.done')) {
					$status_order++;
				}

				$affected = DB::table('orders')
					->where('idShipper', $idShipper)
					->update(['idOrderStatus' => $idOrderStatus]);

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
}
