<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Lesson;
use App\Test;
use App\CourseTest;
use App\TestDetail;

class SearchController extends Controller
{

    public function postSearchTeacher(Request $request){
        $search = $request->search;
        return redirect()->route('listTeacher', ['keyword'=>$search]);
    }

    public function postSearchAccount(Request $request){
        $search = $request->search;
        return redirect()->route('listUser', ['keyword'=>$search]);
    }
    
    public function postSearchStudent(Request $request){
        $search = $request->search;
        return redirect()->route('listStudent', ['keyword'=>$search]);

    }

    public function postSearchCourse(Request $request){

        $keyword = $request->search;
        return redirect()->route('list', ['keyword'=>$keyword]);
    }

    public function getSearchLesson(Request $request){

       $course = Course::find($request->id);
       $key = $request->keyword;
       $lesson = Lesson::where('lesson', 'like', "%$key%")->where('id_course', $course->id)->paginate(10);
       return view('admin/lesson/add', ['lesson'=>$lesson, 'course'=>$course]);
    }


    public function postSearchLesson(Request $request){
        $keyword = $request->search;
        $id = $request->id_course;
        return redirect()->route('getAddLesson', ['id'=>$id, 'keyword'=>$keyword]);
    }

    public function searchTest(Request $request){
        $keyword = $request->search;
        return redirect()->route('listTest', ['keyword'=>$keyword]);
    }

    public function getSearchTest(Request $request){
        $course = Course::find($request->id);
        $testDetail = TestDetail::all();

        $key = $request->keyword;

        $testList = Test::where('name', 'like', "%$key%")->paginate(5);

        $test = CourseTest::where('id_course', $course->id)->paginate(10);

         if($request->ajax()){
            $record = $request->input('_record');

            $testList = Test::paginate($record);
        
            return response(view('admin/course/addTest', ['course'=>$course, 'testList'=>$testList, 'test'=>$test, 'detail'=>$testDetail]));
        }

        return view('admin/course/addTest', ['course'=>$course, 'testList'=>$testList, 'test'=>$test, 'detail'=>$testDetail]);
    }

}
