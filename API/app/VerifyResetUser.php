<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerifyResetUser extends Model
{
    public $table = 'verify_reset_password_users';
    protected $fillable = [
        'token', 'user_id', 'confirmation','reset','expired_at',
    ];
    public function user(){
        return $this->belongsTo('App\User','user_id','idUser');
    }
}
