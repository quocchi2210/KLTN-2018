<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $table = 'roles';

    protected $fillable = [
        'name', 'description'
    ];

    public function user()
    {
        return $this->hasMany('App\User','roleId','id');
    }
}
