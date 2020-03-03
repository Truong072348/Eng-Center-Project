<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyTest extends Model
{
    protected $table = "study_test";

    protected $fillable = ['score', 'time', 'id_test', 'id_course', 'id_users'];

    public $timestamps = true;

    
}
