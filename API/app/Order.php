<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table = 'orders';

    protected $fillable = [
        'name', 'description'
    ];
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('idStore', function (Builder $builder) {
            $builder->where('idStore',auth()->user()->idUser);
        });
    }
    public function status()
    {
        return $this->belongsTo('App\OrderStatus', 'idOrderStatus', 'idStatus');
    }

}
