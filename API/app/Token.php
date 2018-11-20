<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{

    public $table = 'tokens';
    protected $fillable = [
        'token', 'user_token_id', 'expired_at',
    ];
    public function user(){
        return $this->belongsTo('App\User','user_token_id','idUser');
    }
}
