<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    //
    protected $table = "teacher";
    protected $keyType = 'string';
    public $timestamps = false;
    
    public function course(){
    	return $this->hasMany('App\Course','id_teacher','id');
    }

    
}
