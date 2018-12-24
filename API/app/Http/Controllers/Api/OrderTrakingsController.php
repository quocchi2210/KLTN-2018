<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class OrderTrakingsController extends Controller {
	/**
	 * @SWG\POST(
	 *   path="/api/ordertrakings/insertPosition",
	 *     tags={"Tracking"},
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
	public function insertPosition(Request $request) {

		if ($request->isMethod('post')) {
			$lat = $request->get('lat');
			$long = $request->get('long');
			$order_id = $request->get('order_id');

			$idUser = $request->idUser;
			$idUser = 1;
			// $lat = 10;
			// $long = 10;

			$result_shipper = DB::table('shippers')->select('idShipper')->where('idUser', $idUser)->get();

			if ($result_shipper->count() > 0) {

				$idShipper = $result_shipper[0]->idShipper;

				$affected = DB::insert('insert into order_trackings (idOrder, idShipper,latitude,longitude) values (?, ?, ?, ?)', [$order_id, $idShipper, $lat, $long]);

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

	public function updatePosition(Request $request) {

		if ($request->isMethod('post')) {
			$lat = $request->get('lat');
			$long = $request->get('long');
			$order_id = $request->get('order_id');

			$idUser = $request->idUser;
			$idUser = 1;
			// $lat = 10;
			// $long = 10;

			$result_shipper = DB::table('shippers')->select('idShipper')->where('idUser', $idUser)->get();

			if ($result_shipper->count() > 0) {

				$idShipper = $result_shipper[0]->idShipper;

				$result_order_tracking = DB::table('order_trackings')->where('idShipper', $idShipper)->get();

				if ($result_order_tracking->count() > 0) {
					$affected = DB::table('order_trackings')
						->where('idShipper', $idShipper)
						->update([
							'latitude' => $lat,
							'longitude' => $long,
						]);

				} else {

					$affected = DB::insert('insert into order_trackings (idOrder, idShipper,latitude,longitude) values (?, ?, ?, ?)', [$order_id, $idShipper, $lat, $long]);
				}

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
}
