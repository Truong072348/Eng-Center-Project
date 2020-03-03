<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    //
    protected $table = "test";

    protected $fillable = ['time', 'name', 'id_category'];

    public $timestamps = false;
}
