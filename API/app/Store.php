<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $primaryKey = 'idStore';
    public $table = 'stores';
    protected $fillable = [
        'idUser',
        'nameStore',
        'typeStore',
        'addressStore',
        'descriptionStore',
        'latitudeStore',
        'longitudeStore',
        'startWorkingTime',
        'endWorkingTime',
    ];
    public function user(){
        return $this->belongsTo('App\User','idUser','idUser');
    }

    public function orders()
    {
        return $this->hasMany('App\Order','idStore','idStore');
    }
}
