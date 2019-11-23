<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\CategoryType;
use App\Teacher;
use App\Course;
use App\Lesson;
use App\Test;
use App\CourseTest;
use App\TestDetail;
use App\Register;
use App\Comment;
use App\StudyLesson;
use App\StudyTest;
class CourseController extends Controller
{
    public function getAdd(){

    	$category = Category::all();
    	$teacher = Teacher::all();
    	$course = Course::all();
    	return view('admin/course/add',['category'=>$category, 'teacher'=>$teacher, 'course'=>$course]);
    }


    public function postAdd(Request $request){
    	$this->validate($request, 
            [
                'name'=>'required|min:2|max:100',
                'shortdesc'=>'required',
                'txtContent'=>'required',
                'fee'=>'required|numeric',
                'avatar'=>'required',
                'start'=>'required',
                'idteacher'=>'required' 
                
            ], 
            [
                'name.required'=>'Vui lòng nhập tên khóa học',
                'name.min'=>'Tên khóa học quá ngắn',
                'name.max'=>'Tên khóa học quá dài',
                'shortdesc.required'=>'Vui lòng nhập thông tin',
                'txtContent.required'=>'Vui lòng nhập thông tin',
                'fee.required'=>'Vui lòng nhập học phí',
                'fee.numeric'=>'Học phí phải là số',
                'avatar.required'=>'Vui lòng chọn ảnh khóa học',
                'start'=>'Vui lòng chọn ngày bắt đầu',
                'idteacher'=>'Vui lòng chọn giáo viên'
            ]);

    		$course = new Course;
    		$course->id = mt_rand(1000,9999);
    		while (Course::where('id', $course->id)->exists()) {
             	$course->id = mt_rand(100000,999999);
        	}

        	if($request->hasFile('avatar')){
	            $file = $request->file('avatar');
	            $name = $file->getClientOriginalName();
	            
	            $img = str_random(5)."_".$name;
	            while (file_exists("Images/".$img)) {
	                $img = str_random(5)."_".$name;
	            }

	            $file->move("Images", $img);

	            $course->image = $img;
	        }

        	$course->name = $request->name;
        	$course->price = $request->fee;
        	$course->date_start = $request->start;
        	$course->date_finish = $request->finish;
        	$course->short_description = $request->shortdesc;
        	$course->description = $request->txtContent;
        	$course->status = 'waiting';
        	$course->id_ctype = $request->level;
        	$course->id_teacher = $request->idteacher;

            $register = new Register;
            $register->id = mt_rand(100000,999999);
            while (Register::where('id', $register->id)->exists()) {
                $register->id = mt_rand(100000,999999);
            }
            
            $register->price = 0;
            $register->id_student = $request->idteacher;
            $register->id_course = $course->id;

        	$course->save();
            $register->save();

    	return redirect('admin/course/add')->with(['notify'=>'Successfully Added']);
    }


    public function getList(Request $request){
    	
        $teacher = Teacher::all();
        $type = CategoryType::all();
        $category = Category::all();
        $lesson = Lesson::all();
        $test = CourseTest::all();
        $register =Register::all();

        if($request->query('keyword')){
            $keyword = $request->query('keyword');
            
            $course = Course::where('name', 'like', "%$keyword%")->paginate(25);
           
            return view('admin/course/list', ['course'=>$course, 'teacher'=>$teacher, 'type'=>$type, 'listcategory'=>$category, 'lesson'=>$lesson, 'test'=>$test, 'register'=>$register]);
        }


    	$course = Course::Paginate(5);
    	
        
        if($request->ajax()){
            $record = $request->input('_record');
        
            $course = Course::paginate($record);
            return response(view('admin/course/list', ['course'=>$course, 'teacher'=>$teacher, 'type'=>$type, 'listcategory'=>$category, 'lesson'=>$lesson, 'test'=>$test, 'register'=>$register]));
        }



    	return view('admin/course/list', ['course'=>$course, 'teacher'=>$teacher, 'type'=>$type, 'listcategory'=>$category, 'lesson'=>$lesson, 'test'=>$test, 'register'=>$register]);
    }

    public function getListCate($id){
        $teacher = Teacher::all();
        $type = CategoryType::all();
        $category = Category::all();
        $lesson = Lesson::all();
        $test = CourseTest::all();
        $register =Register::all();
        $listtype = CategoryType::where('id_category', $id)->get();
        $course = [];

        foreach ($listtype as $type) {
            $course = Course::where('id_ctype', $type->id)->first();
        }

        // return $course;

        $listcourse = Category::with('course')->where('id', $id)->get();
        $course = $listcourse[0]->course;
        // return $course;
        // return $course->paginate(5);
        return view('admin/course/list', ['course'=>$course, 'teacher'=>$teacher, 'type'=>$type, 'listcategory'=>$category, 'lesson'=>$lesson, 'test'=>$test, 'register'=>$register]);
    }

    public function postSearch(Request $request){

        $keyword = $request->search;
        return redirect()->route('listCourse', ['keyword'=>$keyword]);
    }


    public function getEdit($id){


        $course = Course::find($id);
        $courseList = Course::all();
        $categoryList = Category::all();
        $typeList = CategoryType::all();
 
        $type = CategoryType::find($course->id_ctype);

        $category = Category::find($type->id_category);
        

        $teacher = Teacher::all();
        return view('admin/course/edit', ['course'=>$course, 'category'=>$category, 'type'=>$type, 'typeList'=>$typeList ,'teacher'=>$teacher, 'courseList'=>$courseList, 'categoryList'=>$categoryList]);
    }

    public function postEdit(Request $request, $id){

        $this->validate($request, 
            [
                'name'=>'required|min:2|max:100',
                'shortdesc'=>'required',
                'txtContent'=>'required',
                'fee'=>'required|numeric',
                'start'=>'required',
                'idteacher'=>'required' 
                
            ], 
            [
                'name.required'=>'Vui lòng nhập tên khóa học',
                'name.min'=>'Tên khóa học quá ngắn',
                'name.max'=>'Tên khóa học quá dài',
                'shortdesc.required'=>'Vui lòng nhập thông tin',
                'txtContent.required'=>'Vui lòng nhập thông tin',
                'fee.required'=>'Vui lòng nhập học phí',
                'fee.numeric'=>'Học phí phải là số',
                'start'=>'Vui lòng chọn ngày bắt đầu',
                'idteacher'=>'Vui lòng chọn giáo viên'
            ]);

        $course = Course::find($id);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $name = $file->getClientOriginalName();
            
            $img = str_random(5)."_".$name;
            while (file_exists("Images/".$img)) {
                $img = str_random(5)."_".$name;
            }

            $file->move("Images", $img);

            $course->image = $img;
        }

        $course->name = $request->name;
        $course->price = $request->fee;
        $course->date_start = $request->start;
        $course->date_finish = $request->finish;
        $course->short_description = $request->shortdesc;
        $course->description = $request->txtContent;
        // $course->status = $course->status;
        $course->id_ctype = $request->level;

        $register = new Register;
        $register->id = mt_rand(100000,999999);
        while (Register::where('id', $register->id)->exists()) {
            $register->id = mt_rand(100000,999999);
        }

        $register->price = 0;
        $register->id_student = $request->idteacher;
        $register->id_course = $id;
        $register->save();


        $course->save();

        return redirect('admin/course/edit/'.$id)->with(['notify'=>'Successfully Edited']);
    }


    public function getAddLesson($id){

        $course = Course::find($id);
        
        $lesson = Lesson::where('id_course', $id)->paginate(10);

        return view('admin/lesson/add', ['lesson'=>$lesson, 'course'=>$course]);
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

    public function postAddLesson(Request $request, $id){

         $this->validate($request, 
            [
                'name'=>'required|min:2|max:100',
                'video'=>'required',
                'document'=>'required'
            ], 
            [   
                'name.required'=>'Vui lòng nhập tên bài giảng',
                'name.max'=>'Tên quá dài',
                'name.min'=>'Tên quá ngắn',
                'video.required'=>'Vui lòng thêm video',
                'document.required'=>'Vui lòng thêm tài liệu'
            ]);

         $lesson = new Lesson;
          if($request->hasFile('video')){
                $file = $request->file('video');
                $name = $file->getClientOriginalName();
                
                $video = str_random(5)."_".$name;
                while (file_exists("upload/video/".$video)) {
                    $video = str_random(5)."_".$video;
                }

                $file->move("upload/video", $video);

                $lesson->links_video = $video;

            }

        if($request->hasFile('document')){
                $file = $request->file('document');
                $name = $file->getClientOriginalName();
                
                $document = str_random(5)."_".$name;
                while (file_exists("upload/document/".$document)) {
                    $document = str_random(5)."_".$document;
                }

                $file->move("upload/document", $document);

                $lesson->links_document = $document;

        }

        $lesson->lesson = $request->name;
        $lesson->id_course = $id;
        $lesson->save();

        return redirect('admin/lesson/add/'.$id)->with(['notify'=>'Successfully Added']);
    }


    public function getEditLesson($id){
        $lesson = Lesson::find($id);
        $course = Course::where('id', $lesson->id_course)->get();

        return view('admin/lesson/edit', ['course'=>$course, 'lesson'=>$lesson]);
    }

     public function postEditLesson($id, Request $request){
         $this->validate($request, 
            [
                'name'=>'required|max: 100',
            ], 
            [   
                'name.required'=>'Vui lòng nhập tên bài giảng',
                'name.max'=>'Tên quá dài',
            ]);

        $lesson = Lesson::find($id);
        $course = Course::where('id', $lesson->id_course)->get();
        $course[0]->name = $request->name;
        $course[0]->save();

        if($request->hasFile('video')){
                $file = $request->file('video');
                $name = $file->getClientOriginalName();
                
                $video = str_random(5)."_".$name;
                while (file_exists("upload/video/".$video)) {
                    $video = str_random(5)."_".$video;
                }

                $file->move("upload/video", $video);

                $lesson->links_video = $video;

        }

        if($request->hasFile('document')){
                $file = $request->file('document');
                $name = $file->getClientOriginalName();
                
                $document = str_random(5)."_".$name;
                while (file_exists("upload/document/".$document)) {
                    $document = str_random(5)."_".$document;
                }

                $file->move("upload/document", $document);

                $lesson->links_document = $document;

        }

        $lesson->save();

        return redirect('admin/lesson/edit/'.$id)->with('notify', 'Successfully Edited');
    }

    public function getDeleteLesson($id, $lesson){
        $less = Lesson::find($lesson);
        if(StudyLesson::where('id_lesson', $less->id)->exists()) {
            return redirect('admin/lesson/add/'.$id)->with('deleteFail', true);
        } else {
            $less->delete();
        }

        return redirect('admin/lesson/add/'.$id)->with('notify', 'Successfully Deleted');
    }

    public function getAddTest($id, Request $request){

        $course = Course::find($id);
        $testDetail = TestDetail::all();
        $testList = Test::paginate(5);
        $category = Category::all();
        $test = CourseTest::where('id_course', $course->id)->paginate(10);

         if($request->ajax()){
            $record = $request->input('_record');

            $testList = Test::paginate($record);
        
            return response(view('admin/course/addTest', ['course'=>$course, 'testList'=>$testList, 'test'=>$test, 'detail'=>$testDetail, 'category'=>$category]));
        }


        return view('admin/course/addTest', ['course'=>$course, 'testList'=>$testList, 'test'=>$test, 'detail'=>$testDetail, 'category'=>$category]);
    }

    public function getSearchTest(Request $request){
        $course = Course::find($request->id);
        $category = Category::all();
        $testDetail = TestDetail::all();

        $key = $request->keyword;

        $testList = Test::where('name', 'like', "%$key%")->paginate(5);

        $test = CourseTest::where('id_course', $course->id)->paginate(10);

         if($request->ajax()){
            $record = $request->input('_record');

            $testList = Test::paginate($record);
        
            return response(view('admin/course/addTest', ['course'=>$course, 'testList'=>$testList, 'test'=>$test, 'detail'=>$testDetail, 'category'=>$category]));
        }

        return view('admin/course/addTest', ['course'=>$course, 'testList'=>$testList, 'test'=>$test, 'detail'=>$testDetail, 'category'=>$category]);
    }

    public function searchTestLesson(Request $request){
        $keyword = $request->search;
        $id = $request->id_course;
        return redirect()->route('getTestLesson', ['id'=>$id, 'keyword'=>$keyword]);
    }


    public function postAddTest($id, Request $request){
        $this->validate($request, 
        [
            'name'=>'required',
            'idtest'=>'required'
        ], 
        [   
            'name.required'=>'Vui lòng nhập tên bài kiểm tra',
            'idtest.required'=>'Vui lòng chọn bài kiểm tra'
        ]);
        $courseTest = new CourseTest;
        $courseTest->id = mt_rand(1000,9999);
        while (CourseTest::where('id', $courseTest->id)->exists()) {
            $courseTest->id = mt_rand(1000,9999);
        }

        $courseTest->name = $request->name;
        $courseTest->id_course = $id;
        $courseTest->id_test = $request->idtest;
        $courseTest->save();

        return redirect('admin/course/test/'.$id)->with('notify', 'Successfully Added');
    }


    public function deleteTest($id){
        $courseTest = CourseTest::find($id);
        $course = Course::where('id', $courseTest->id_course)->first();
        if(StudyTest::where('id_test', $courseTest->id)->exists()){
    
            return redirect('admin/course/test/'.$course->id)->with('deleteLessonTestFail', true);
        } else {

            $courseTest->delete();
        }

        return redirect('admin/course/test/'.$course->id)->with('notify', 'Successfully Deleted');
    }

    public function getActive($id){

        $course = Course::find($id);
        $course->status = 'opening';
        $course->save();

        $courseList = Course::all();
        $categoryList = Category::all();
        $typeList = CategoryType::all();
 
        $type = CategoryType::find($course->id_ctype);

        $category = Category::find($type->id_category);
        

        $teacher = Teacher::all();
        return view('admin/course/edit', ['course'=>$course, 'category'=>$category, 'type'=>$type, 'typeList'=>$typeList ,'teacher'=>$teacher, 'courseList'=>$courseList, 'categoryList'=>$categoryList]);
    }

    public function getClose($id){

        $course = Course::find($id);
        $course->status = 'closed';
        $course->save();

        $courseList = Course::all();
        $categoryList = Category::all();
        $typeList = CategoryType::all();
 
        $type = CategoryType::find($course->id_ctype);

        $category = Category::find($type->id_category);
        

        $teacher = Teacher::all();
        return view('admin/course/edit', ['course'=>$course, 'category'=>$category, 'type'=>$type, 'typeList'=>$typeList ,'teacher'=>$teacher, 'courseList'=>$courseList, 'categoryList'=>$categoryList]);
    }

    public function getWait($id){

        $course = Course::find($id);
        $course->status = 'waitting';
        $course->save();

        $courseList = Course::all();
        $categoryList = Category::all();
        $typeList = CategoryType::all();
 
        $type = CategoryType::find($course->id_ctype);

        $category = Category::find($type->id_category);
        

        $teacher = Teacher::all();
        return view('admin/course/edit', ['course'=>$course, 'category'=>$category, 'type'=>$type, 'typeList'=>$typeList ,'teacher'=>$teacher, 'courseList'=>$courseList, 'categoryList'=>$categoryList]);
    }

    public function getComment($id){
        $course = Course::find($id);
        $comment = Comment::where('id_course', $course->id)->paginate(5);
        return view('admin/course/comment', ['course'=>$course, 'comment'=>$comment]);
    }
}
