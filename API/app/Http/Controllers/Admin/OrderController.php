<?php

namespace App\Http\Controllers\Admin;

use App\Deliver;
use App\Order;
use App\OrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        return view('admin.order.index', ['orders' => $orders,'status' => $status]);
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
        //
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
        $status = DB::table('order_status')->whereIn('statusName', ['Đã xác nhận', 'Đã Hủy'])->pluck('statusName', 'idStatus');
        $deliver = DB::table('shippers')->pluck('idShipper', 'idShipper');
        return response()->json(view('admin.order.edit',
            ['deliver' => $deliver,
                'order' => $order,
                'status' => $status])->render());
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
        $status = $request->get('Status');
        $deliver = $request->get('Deliver');
        DB::table('orders')->where('idOrder',$id)->update(array('idShipper'=>$deliver,'idOrderStatus'=>$status));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
