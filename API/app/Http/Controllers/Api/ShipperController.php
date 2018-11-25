<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Log;

class ShipperController extends Controller
{
     /**
     * @SWG\POST(
     *   path="/api/shipper/showOrder",
     *     tags={"Shipper"},
     *   summary="Show Profile",
     *   @SWG\Parameter(
     *     name="name_store",
     *     in="query",
     *     description="Your Name Store",
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
    public function showOrder(Request $request){

    	$idShipper = 1;

		if ($request->isMethod('post')) {

			//$users = DB::statement("SELECT * FROM orders WHERE idShipper=?",[$idShipper]);

			$users = DB::select("SELECT * FROM orders WHERE idShipper = ?",
 				[$idShipper]);

			if($users){
				return response()->json([
					'error' => false,
					'data' => $users,
					'errors' => null,
				], 200);
			}else{
				return response()->json([
                         'error' => true,
                         'data' => $users,
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
     *   @SWG\Parameter(
     *     name="name_store",
     *     in="query",
     *     description="Your Name Store",
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
    public function showHistory(Request $request){

		if ($request->isMethod('post')) {

			$users = DB::table('orders')->select('*')->whereRaw('idShipper', [1])->get();

			if($users){
				return response()->json([
					'error' => false,
					'data' => $users,
					'errors' => null,
				], 200);
			}else{
				return response()->json([
                         'error' => true,
                         'data' => $users,
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
     *   @SWG\Parameter(
     *     name="name_store",
     *     in="query",
     *     description="Your Name Store",
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
    public function updateStatus(Request $request){

		if ($request->isMethod('post')) {

			$users = DB::table('orders')->select('*')->where('idShipper = ?',1)->get();

			if($users){
				return response()->json([
					'error' => false,
					'data' => $users,
					'errors' => null,
				], 200);
			}else{
				return response()->json([
                         'error' => true,
                         'data' => $users,
                         'errors' => null,
                    ], 400);
			}
		}
    }
}
