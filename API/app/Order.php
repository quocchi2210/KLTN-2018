<?php

namespace App;

use App\Traits\Decryption;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class Order extends Model
{
    public $table = 'orders';
    protected  $primaryKey = 'idOrder';
    use Decryption;
    protected $fillable = [
        'idStore',
        'billOfLading',
        'nameSender',
        'addressSender',
        'latitudeSender',
        'longitudeSender',
        'phoneSender',
        'nameReceiver',
        'addressReceiver',
        'latitudeReceiver',
        'longitudeReceiver',
        'phoneReceiver',
        'emailReceiver',
        'descriptionOrder',
        'dateCreated',
        'COD',
        'timeDelivery',
        'distanceShipping',
        'idOrderStatus',
        'idServiceType',
        'totalWeight',
        'priceService',
        'totalMoney',
    ];
    protected static function boot()
    {
//        if (auth()->user()->roleId == 1){
//            parent::boot();
//            static::addGlobalScope('idStore', function (Builder $builder) {
//                $builder->where('idStore',auth()->user()->store->idStore);
//            });
//        }
    }


    public function status()
    {
        return $this->belongsTo('App\OrderStatus', 'idOrderStatus', 'idStatus');
    }

    public function store()
    {
        return $this->belongsTo('App\Store','idStore','idStore');
    }

    public function detail()
    {
        return $this->hasMany('App\OrderDetail','idOrder','idOrder');
    }

}
