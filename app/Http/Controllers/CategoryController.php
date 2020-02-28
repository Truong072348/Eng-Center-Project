<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use  App\Course;
use App\CategoryType;
use Cloudder;
use Validator;

class CategoryController extends Controller
{
     function __construct(){
        $categoryList = Category::all();
        $typeCList = CategoryType::all();
        $courseTotal = Course::all();

        view()->share('categoryList', $categoryList);
        view()->share('typeCList', $typeCList);
        view()->share('courseTotal', $courseTotal);
    }

    function getCourseType($courseType){
        
        if(CategoryType::where('slug', $courseType)->exists()) {

            $type = CategoryType::where('slug', '=', $courseType)->firstOrFail();
            $courseList = Course::where('id_ctype', $type->id)->where('status', '=', 'opening')->paginate(9);

            foreach ($courseList as $key) {
                $img = Cloudder::show('english-Center/course-image/'.$key->image);
                $key->setAttribute('img', $img);    
            }

            $cate = CategoryType::where('id', $type->id_category)->first();
            if(!empty($cate)){
                $name = Category::where('id', $cate->id_category)->first();
                return view('pages.list', ['courseList'=>$courseList, 'key'=>$type->id, 'name'=>$name]);
            }

            return view('pages.list', ['courseList'=>$courseList, 'key'=>$type->id, 'cate'=>$cate]);

        } else {

            return view('pages.listnone');
        }
        
        
    }

    function getCourse($keyword){
        $key = $keyword;
        $courseList = null;
        if(Course::where('status' , 'opening')->where(function($q) use ($key){
            $q->where('name', 'like', "%$key%")->orWhere('description', 'like', "$key")->orWhere('short_description', 'like', "%$key%"); })->exists()) {

            $courseList = Course::where('status' , 'opening')->where(function($q) use ($key){
                $q->where('name', 'like', "%$key%")->orWhere('description', 'like', "$key")->orWhere('short_description', 'like', "%$key%");
            })->paginate(9);

            foreach ($courseList as $key) {

                $img = Cloudder::show('english-Center/course-image/'.$key->image);
                $key->setAttribute('img', $img);    
            }

        }
    	return view('pages.list', ['courseList'=>$courseList, 'key'=>$keyword]);
    }

}
