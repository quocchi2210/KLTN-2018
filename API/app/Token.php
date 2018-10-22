<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use User;

class Token extends Model
{

    public $table = 'token';
    protected $fillable = [
        'token', 'user_token_id', 'expired_at',
    ];
    public function user(){
        return $this->belongsTo('App\User');
    }
}
