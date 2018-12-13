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
        return view('order.index', ['orders' => $orders,'status' => $status]);
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
    public function store(Request $request)
    {
        //
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
