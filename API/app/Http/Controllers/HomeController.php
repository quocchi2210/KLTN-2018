<?php

namespace App\Http\Controllers;

use App\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OrderController;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(OrderController $order)
    {
        $this->order = $order;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            return view('home');
        } else {
            return redirect('login');
        }

    }

    public function editProfile($id)
    {
        $store = Store::find($id);
        return view('store.profile',['store'=>$store]);
    }

    public function updateProfile(Request $request,$id)
    {
        $storeRequest = $request->get('Store');
        $latlong = $this->order->getLatLong($storeRequest['address']);
        $storeLat = $latlong['results'][0]['geometry']['location']['lat'];
        $storeLong = $latlong['results'][0]['geometry']['location']['lng'];
        $storeUpdate = Store::where('idStore',$id)->update(array('nameStore'=>$storeRequest['name'],'typeStore'=>$storeRequest['type'],
            'addressStore'=>$storeRequest['address'],'descriptionStore'=>$storeRequest['description'],'latitudeStore'=>$storeLat,
            'longitudeStore'=>$storeLong));
        if ($storeUpdate)
            return redirect(route('home'));
    }



}
