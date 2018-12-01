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
     *     security={{"api_key":{}}}
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
                  $user_id = $request->idUser;
               $user_id = 1;
          
               $affected = DB::insert('insert into stores (idUser, nameStore,typeStore,addressStore,descriptionStore,latitudeStore,longitudeStore,startWorkingTime,endWorkingTime) values (?, ?, ?, ?, ?, ?, ?, ?, ?)', [$user_id,$name_store,$type_store,$address_store,$description_store,$latitude_store,$longitude_store ,$start_working_time,$end_working_time]);
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
          
               $affected = DB::table('stores')->where('idStore', $store_id)->update([
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
          
               $affected = DB::table('stores')->where('idStore', 1)->select('*')->get();

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

     public function showOrder(Request $request){

          if ($request->isMethod('post')) {

               $idUser = $request->idUser;
               $idUser = 2;

          $result_store = DB::table('stores')->select('idStore')->where('idUser', $idUser)->get();

          if($result_store->count() > 0){

              // Log::debug('idUser'. print_r($idUser,1));
              // Log::debug('idShipper'. print_r($result_shipper[0]['idShipper'],1));

               $idStore = $result_store[0]->idStore;
                    // $users = DB::statement("SELECT * FROM orders WHERE idShipper=?",[$idShipper]);

                    // $users = DB::select("SELECT * FROM orders WHERE idShipper = ?",[$idShipper]);

                    $users = DB::table('orders')
                    ->where('idStore', $idStore)
                    ->get();

                    if($users){
                         return response()->json([
                              'error' => false,
                              'data' => $users,
                              'errors' => null,
                         ], 200);
                    }else{
                         return response()->json([
                              'error' => true,
                              'data' => null,
                              'errors' => null,
                         ], 400);
                    }
               }else{
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
     public function showDetailOrder(Request $request){

          if ($request->isMethod('post')) {

               $idOrder = $request->get('id_order');
               $idUser = $request->idUser;

               $idUser = 2;

               $result_store = DB::table('stores')->select('idStore')->where('idUser', $idUser)->get();
          if($result_store->count() > 0){

                    $users = DB::table('order_details')
                    ->where('idOrder', $idOrder)
                    ->get();

                    if($users){
                         return response()->json([
                              'error' => false,
                              'data' => $users,
                              'errors' => null,
                         ], 200);
                    }else{
                         return response()->json([
                              'error' => true,
                              'data' => null,
                              'errors' => null,
                         ], 400);
                    }
               }else{
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
               $idUser = 2;

               $result_store = DB::table('stores')->select('idStore')->where('idUser', $idUser)->get();

          if($result_store->count() > 0){

               $bill_of_lading = $request->get('bill_of_lading');
               $bill_of_lading = 'LUXABC1234';
               $name_receiver = $request->get('name_receiver');
               $address_receiver = $request->get('address_receiver');
               $lat = $request->get('latitude_receiver');
               $long = $request->get('longitude_receiver');
               $phone = $request->get('phone_receiver');
               $email = $request->get('email_receiver');
               $description = $request->get('description_order'); 
               $cod = $request->get('phone_receiver');
               $time_delivery = $request->get('time_delivery');
               $distance_shipping = $request->get('distance_shipping');
               $id_service_type = $request->get('id_service_type');
               $total_weight = $request->get('total_weight');
               $price_service = $request->get('price_service');
               $total_money = $request->get('total_money');
               $id_shipper = $request->get('id_shipper');
               $id_order_status = $request->get('id_order_status');

               $lat = 11.3;
               $long = 12.3;
          
               $store_id = $result_store[0]->idStore;
               `idOrder`, `idStore`, `billOfLading`, `nameReceiver`, `addressReceiver`, `latitudeReceiver`, `longitudeReceiver`, `phoneReceiver`, `emailReceiver`, `descriptionOrder`, `dateCreated`, `COD`, `timeDelivery`, `distanceShipping`, `idServiceType`, `totalWeight`, `totalPriceProduct`, `priceService`, `totalMoney`, `idShipper`, `idOrderStatus`, `created_at`, `updated_at`
               $affected = DB::table('stores')->where('idStore', $store_id)->update([
                         'idStore' => $user_id,
                         'billOfLading' => $name_store,
                         'nameReceiver' => $type_store,
                         'addressReceiver' => $address_store,
                         'latitudeReceiver' => $description_store,
                         'longitudeReceiver' => $latitude_store,
                         'phoneReceiver' => $longitude_store,
                         'emailReceiver' => $start_working_time,
                         'descriptionOrder' => $end_working_time,
                          'COD' => $description_store,
                         'timeDelivery' => $latitude_store,
                         'distanceShipping' => $longitude_store,
                         'idServiceType' => $start_working_time,
                         'totalWeight' => $end_working_time,
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
}