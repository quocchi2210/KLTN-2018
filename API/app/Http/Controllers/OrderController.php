<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderStatus;
use App\Role;
use App\Store;
use Carbon\Carbon;
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
        $orders = Auth::user()->store->orders;
        $status = OrderStatus::all();
        $serviceTypes = DB::table('service_types')->pluck('nameService', 'idService');
        $note = array(
            'Cho xem hàng, không cho thử' => 'Cho xem hàng, không cho thử',
            'Cho thử hàng' => 'Cho thử hàng',
            'Không cho xem hàng' => 'Không cho xem hàng');
        return view('order.index', ['orders' => $orders,'status' => $status,'serviceTypes'=>$serviceTypes,'note'=>$note]);
    }

    public function getidOrderStatus($bill)
    {
        $billOfLadings = Order::all();
        foreach ($billOfLadings as $billOfLading) {
            if($bill === $billOfLading['billOfLading'])
                return $idOrderStatus = $billOfLading['idOrder'];
        }

    }

    public function tracking(Request $request)
    {
        $bill = $request->get('bill_of_lading');
        if ($bill){
            $idOrderStatus = $this->getidOrderStatus($bill);
            $order = Order::find($idOrderStatus);
            $store = $order->store;
            if ($order){
                $status = DB::table('order_status')->where('idStatus',$order->idOrderStatus)->first();
                if ($status)
                    return view('tracking.trackingStatus', ['status' => $status->statusName,'bill'=>$bill,'nameReceiver'=>$order['nameReceiver'],
                        'nameStore'=>$store['nameStore']]);
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
    public function getLatLong($address){
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
        if($distance<15)
            return round($distance * $servicePrice * $totalWeight);
        elseif($distance>=15 && $distance<30)
            return round($distance * ($servicePrice/2) * $totalWeight);
        elseif($distance>=30 && $distance<50)
            return round($distance * ($servicePrice/4) * $totalWeight);
        elseif($distance>=50 && $distance<100)
            return round($distance * ($servicePrice/6) * $totalWeight);
        elseif($distance >= 100)
            return round($distance * ($servicePrice/10) * $totalWeight);
    }

    private function getPreDelivery($distance,$services)
    {
        switch ($services) {
            case 1 :
                if($distance<50)
                    return $date = Carbon::now()->addDays(1);
                elseif($distance>=50 && $distance<200)
                    return $date = Carbon::now()->addDays(2);
                elseif($distance>=200)
                    return $date = Carbon::now()->addDays(3);
                break;
            case 2 :
                if($distance<50)
                    return $date = Carbon::now()->addDays(1);
                elseif($distance>=50 && $distance<200)
                    return $date = Carbon::now()->addDays(2);
                elseif($distance>=200)
                    return $date = Carbon::now()->addDays(2);
                break;
            case 3 :
                if($distance<50)
                    return $date = Carbon::now()->addDays(1);
                elseif($distance>=50 && $distance<200)
                    return $date = Carbon::now()->addDays(1);
                elseif($distance>=200)
                    return $date = Carbon::now()->addDays(2);

        }
    }

    public function getPreMoney(Request $request)
    {
        $idServices = $request->idServices;
        $senderAddress = $request->SenderAddress;
        $receiverAddress = $request->ReceiverAddress;
        $orderWeight = $request->OrderWeight;
        if (!empty($idServices) && !empty($senderAddress) && !empty($receiverAddress) && !empty($orderWeight)){
            $servicePrice = DB::table('service_types')->where('idService',$idServices)->first()->price;
            $sender = $this->getLatLong($senderAddress);
            $senderLat = $sender['results'][0]['geometry']['location']['lat'];
            $senderLong = $sender['results'][0]['geometry']['location']['lng'];
            $receiver = $this->getLatLong($receiverAddress);
            $receiverLat = $receiver['results'][0]['geometry']['location']['lat'];
            $receiverLong = $receiver['results'][0]['geometry']['location']['lng'];
            $distance = $this->getDistance($senderLat,$senderLong,$receiverLat,$receiverLong);
            $distance = floatval($distance['rows'][0]['elements'][0]['distance']['text']);
            $distance = $this->milesToKilometers($distance);
            $money = $this->calculateMoney($distance,$orderWeight,$servicePrice);
            $timeDelivery = $this->getPreDelivery($distance,$idServices)->format('d/m/Y');
            return response()->json([
                'preMoney' => $money,
                'timeDelivery' => $timeDelivery
                ]);
        }

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
        $timeDelivery = $this->getPreDelivery($distance,$orderRequest['serviceTypes'])->format('Y-m-d');
        $order = Order::create(array('idStore'=> $store->idStore,
            'billOfLading'=> encrypt('LUX' . str_random(12)),
            'nameSender'=>encrypt($senderRequest['name']),
            'addressSender'=>encrypt($senderRequest['address']),
            'latitudeSender'=>encrypt($senderLat),
            'longitudeSender'=>encrypt($senderLong),
            'phoneSender'=>encrypt($senderRequest['phone']),
            'nameReceiver'=>encrypt($receiverRequest['name']),
            'addressReceiver'=>encrypt($receiverRequest['address']),
            'latitudeReceiver'=>encrypt($receiverLat),
            'longitudeReceiver'=>encrypt($receiverLong),
            'phoneReceiver'=>encrypt($receiverRequest['phone']),
            'descriptionOrder'=>encrypt($orderRequest['note']),
            'timeDelivery' => encrypt($timeDelivery),
            'distanceShipping'=>encrypt($distance),
            'idServiceType'=>$orderRequest['serviceTypes'],
            'totalWeight'=>encrypt($orderRequest['weight']),
            'priceService'=>encrypt($servicePrice),
            'totalMoney'=>encrypt($money),
            'idOrderStatus'=>1));
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
