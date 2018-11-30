<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use App\OrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function getOrders()
    {
        $orders = Order::all();
        $status = OrderStatus::all();
        return view('admin.order.index', ['orders' => $orders,'status' => $status]);
    }
}
