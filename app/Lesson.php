<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Lesson extends Model
{
    //
    protected $table = "course_lesson";
    public $timestamps = false;

    use Sluggable; 

    public function sluggable() {
        return [
            'slug' => [
                'source' => ['course.name','lesson','course.id']
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    
    public function course(){
    	return $this->belongsTo('App\Course','id_course','id');
    }
}
