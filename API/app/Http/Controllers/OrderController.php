<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderStatus;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
        $status = OrderStatus::all();
        $serviceTypes = DB::table('service_types')->pluck('nameService', 'idService');
        $note = array(
            'Cho xem hàng, không cho thử' => 'Cho xem hàng, không cho thử',
            'Cho thử hàng' => 'Cho thử hàng',
            'Không cho xem hàng' => 'Không cho xem hàng');
        return view('order.index', ['orders' => $orders,'status' => $status,'serviceTypes'=>$serviceTypes,'note'=>$note]);
    }

    public function tracking(Request $request)
    {
        $bill = $request->get('bill_of_lading');
        if ($bill){
            $idOrderStatus = DB::table('orders')->where('billOfLading',$bill)->first();
            if ($idOrderStatus){
                $status = DB::table('order_status')->where('idStatus',$idOrderStatus->idOrderStatus)->first();
                if ($status)
                    return view('tracking.trackingStatus', ['status' => $status->statusName,'bill'=>$bill,'nameReceiver'=>$idOrderStatus->nameReceiver]);
            }
            else
                return view('handleError.notfoundbill',['bill'=>$bill]);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function getLatLong($address){
        $request_url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&key=AIzaSyBVLZZFaDU6nn96cbs59PfMBNXu9ZNdxYE";
        $string = file_get_contents($request_url);
        return json_decode($string, true);
    }
    private function getDistance($originLat,$originLong,$desLat,$desLong){
        $request_url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=".$originLat.",".$originLong."&destinations=".$desLat.",".$desLong."&key=AIzaSyBVLZZFaDU6nn96cbs59PfMBNXu9ZNdxYE";
        $string = file_get_contents($request_url);
        return json_decode($string, true);
    }
    private function milesToKilometers($miles){
        return round($miles * 1.60934,1);
    }
    private function calculateMoney($distance, $totalWeight ,$servicePrice){
        return round($distance * $servicePrice * $totalWeight);
    }
    public function store(Request $request)
    {
        $senderRequest = $request->get('sender');
        $receiverRequest = $request->get('receiver');
        $orderRequest = $request->get('order');
        $store = DB::table('stores')->where('idUser',Auth::user()->idUser)->first();
        $sender = $this->getLatLong($senderRequest['address']);
        $senderLat = $sender['results'][0]['geometry']['location']['lat'];
        $senderLong = $sender['results'][0]['geometry']['location']['lng'];
        $receiver = $this->getLatLong($receiverRequest['address']);
        $receiverLat = $receiver['results'][0]['geometry']['location']['lat'];
        $receiverLong = $receiver['results'][0]['geometry']['location']['lng'];
        $distance = $this->getDistance($senderLat,$senderLong,$receiverLat,$receiverLong);
        $distance = floatval($distance['rows'][0]['elements'][0]['distance']['text']);
        $servicePrice = DB::table('service_types')->where('idService',$orderRequest['serviceTypes'])->first()->price;
        $distance = $this->milesToKilometers($distance);
        $money = $this->calculateMoney($distance,$orderRequest['weight'],$servicePrice);
        $order = Order::create(array('idStore'=> $store->idStore, 'billOfLading'=> 'LUX001', 'nameSender'=>$senderRequest['name'],
            'addressSender'=>$senderRequest['address'],'latitudeSender'=>$senderLat,'longitudeSender'=>$senderLong,'phoneSender'=>$senderRequest['phone'],
            'nameReceiver'=>$receiverRequest['name'],'addressReceiver'=>$receiverRequest['address'],'latitudeReceiver'=>$receiverLat,'longitudeReceiver'=>$receiverLong,
            'phoneReceiver'=>$receiverRequest['phone'],'descriptionOrder'=>$orderRequest['note'],'','distanceShipping'=>$distance,'idServiceType'=>$orderRequest['serviceTypes'],
            'totalWeight'=>$orderRequest['weight'],'priceService'=>$servicePrice,'totalMoney'=>$money,'idOrderStatus'=>1));
        if($order)
            return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        return response()->json(view('order.detail', ['order' => $order])->render());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        return response()->json(view('order.detail', ['order' => $order])->render());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Order::destroy($id);
        return back();
    }
}
