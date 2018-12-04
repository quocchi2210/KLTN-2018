<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public $table = 'order_details';
    protected $fillable = [
        'nameProduct',
        'priceProduct',
        'quantityProduct',
        'imgProduct'
    ];

    public function order()
    {
        return $this->belongsTo('App\Order','idOrder','idOrder');
    }
}
