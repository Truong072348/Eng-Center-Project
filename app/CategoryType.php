<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class CategoryType extends Model
{

    use Sluggable; 

    protected $table = "category_type";
    public $timestamps = false;

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'category.name','level'
            ]
        ];
    }

    // protected $sluggable = array(
    //     'build_from' => 'category.name'.'-'.'level',
    //     'save_to'   => 'slug'   
    // );

    public function getRouteKeyName()
    {
        return 'slug';
    }

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
