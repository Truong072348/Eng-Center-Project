<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    //
    protected $primaryKey = ['id_student', 'id_course'];
    public $incrementing = false;
    
    protected $table = "course_register";

    protected $fillable = [
        'tuition', 'id_student', 'id_course','id_discount','course_price'
    ];

    public function course(){
    	return $this->belongsTo('App\Course','id_course','id');
    }

    public function student(){
    	return $this->belongsTo('App\Student','id_student','id');
    }
}
