<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerifyUser extends Model
{
    public $table = 'verify_users';
    protected $fillable = [
        'token', 'user_id', 'expired_at',
    ];
    public function user(){
        return $this->belongsTo('App\User','user_id','idUser');
    }
}
