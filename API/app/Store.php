<?php

namespace App;

use App\Traits\Decryption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Store extends Model
{
    protected $primaryKey = 'idStore';
    public $table = 'stores';
    use Decryption;
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

//    public function setAttribute($key, $value)
//    {
//        if (in_array($key, $this->fillable))
//        {
//            $value = Crypt::encrypt($value);
//        }
//
//        return parent::setAttribute($key, $value);
//    }
//
//    public function getAttribute($key)
//    {
//        if (in_array($key, $this->fillable))
//        {
//            return Crypt::decrypt($this->attributes[$key]);
//        }
//
//        return parent::getAttribute($key);
//    }
//
//    public function attributesToArray()
//    {
//        $attributes = parent::attributesToArray();
//
//        foreach ($attributes as $key => $value)
//        {
//            if (in_array($key, $this->fillable))
//            {
//                $attributes[$key] = Crypt::decrypt($value);
//            }
//        }
//
//        return $attributes;
//    }
    public function user(){
        return $this->belongsTo('App\User','idUser','idUser');
    }
    public function decryptName()
    {
        return decrypt($this->attributes['nameStore']);
    }
    public function orders()
    {
        return $this->hasMany('App\Order','idStore','idStore');
    }
}
