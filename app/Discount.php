<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    //
    protected $table = "discount";
    public $timestamps = false;

    public function register(){
        return $this->hasMany('App\Register');
    } 
}
