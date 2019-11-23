<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $table = "comment";

    public function feedback(){
    	return $this->hasMany('App\FeedBack','id_comment','id');
    }

    public function user(){
    	return $this->belongsTo('App\User','id_user','id');
    }
}
