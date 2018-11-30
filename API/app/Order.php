<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    public $table = 'orders';

    protected $fillable = [
        'name', 'description'
    ];
    protected static function boot()
    {
        if (auth()->user()->roleId == 1){
            parent::boot();
            static::addGlobalScope('idStore', function (Builder $builder) {
                $builder->where('idStore',auth()->user()->store->idStore);
            });
        }
    }
    public function status()
    {
        return $this->belongsTo('App\OrderStatus', 'idOrderStatus', 'idStatus');
    }

    public function store()
    {
        return $this->belongsTo('App\Store','idStore','idStore');
    }

}
