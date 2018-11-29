<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $table = 'order_status';
    protected $fillable = [
        'statusName',

    ];

    public function order()
    {
        return $this->hasMany('App\Order','idOrderStatus','idStatus');
    }
}
