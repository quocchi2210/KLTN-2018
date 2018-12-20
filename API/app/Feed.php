<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use User;

class Feed extends Model
{
    public $table = 'feed';
    protected $fillable = [
        'title', 'content', 'user_post_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public function user(){
        return $this->belongsTo('App\User');
    }
    public  $ruleCustom = [
        'title'=> 'required|string|min:8|max:255',
        'content'=> 'required|max:255',
    ];
}
