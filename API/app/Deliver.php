<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deliver extends Model
{
    public $table = 'shippers';
    protected  $primaryKey = 'idShipper';
    protected $fillable = [
        'idUser',
        'licensePlates',
        'latitudeShipper',
        'longitudeShipper',
    ];
    public function user()
    {
        return $this->belongsTo('App\User','idUser','idUser');
    }
}
