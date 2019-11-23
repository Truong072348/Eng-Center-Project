<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "category";
    public $timestamps = false;

    public function type(){
    return $this->hasMany('App\CategoryType','id_category','id');
    }
    public function course(){
    return $this->hasManyThrough('App\Course', 'App\CategoryType', 'id_category', 'id_ctype', 'id', 'id');
    }

}
