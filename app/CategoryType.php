<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryType extends Model
{

    protected $table = "category_type";
    public $timestamps = false;

    public function category(){
    return $this->belongsTo('App\Category','id_category','id');
    }
    public function course(){
    return $this->hasMany('App\Course','id_ctype','id');
    }
    public function test(){
    return $this->hasMany('App\Test','id_ctype','id');
    }

}
