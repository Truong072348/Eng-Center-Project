<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    //
    protected $table = "teacher";
    
    protected $keyType = 'string';

    protected $fillable = ['id', 'name', 'avatar', 'degree', 'introduction', 'address', 'phone', 'birth', 'gender'];

    public $timestamps = false;
    

    public function course(){
    	return $this->hasMany('App\Course','id_teacher','id');
    }

    
}
