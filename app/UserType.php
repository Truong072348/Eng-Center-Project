<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    //
    protected $table = "users_type";


    public function userType(){
    	return $this->hasMany('App\User','id_utype','id');
    }
}
