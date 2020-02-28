<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\addCourseRequest;
use App\Http\Requests\addLessonRequest;
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
use Cloudder;
use Validator;
use Storage;

class CourseController extends Controller
{
    function __construct() {
        $teachers = Teacher::all();
        $categories = Category::all();
        $types = CategoryType::all();
        $tests = CourseTest::all();
        $lessons = Lesson::all();
        $registers = Register::all();
        $courses = Course::all();

        if(!empty($teachers)) {
            foreach ($teachers as $key) {
                $img = Cloudder::show('english-Center/avatar/'.$key->avatar);
                $key->setAttribute('avatar', $img);
            }
            
        }

        view()->share('teachers', $teachers);
        view()->share('categories', $categories);
        view()->share('types', $types);
        view()->share('tests', $tests);
        view()->share('lessons', $lessons);
        view()->share('registers', $registers);
        view()->share('courses', $courses);
    }

    public function getList(Request $request){

        if($request->query('keyword')){
            $keyword = $request->query('keyword');    
            $course = Course::where('name', 'like', "%$keyword%")->paginate(25);        
            return view('admin/course/list');
        }

        $course = Course::Paginate(5);
        
        if($request->ajax()){
            $record = $request->input('_record');
        
            $course = Course::paginate($record);
            return response(view('admin/course/list', ['course'=>$course]));
        }

        return view('admin/course/list', ['course'=>$course]);
    }

    public function getAdd(){
    	return view('admin/course/add');
    }


    //course function: add course, edit, delete

    public function postAdd(addCourseRequest $request){

       
        $data = request()->all();
        $data['status'] = 'watting';
        $data['id'] = mt_rand(100000,999999);

        while (Course::where('id', $data['id'])->exists()) {
            $data['id'] = mt_rand(100000,999999);
        }

    	if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $name = $file->getClientOriginalName(); 
            $img = str_random(5)."_".$name;
            Cloudder::upload($file, 'english-Center/course-image/'.$img);

            $data['image'] = $img;
        } else {
            $data['image'] = 's32N4_6h2u8_banner-5.png_j2owbo';
        }
 
    	$course = Course::create($data);
        Register::create([
            'tuition' => -1,
            'course_price' => $course->price,
            'id_student' => $request->id_teacher,
            'id_course' => $course->id

        ]);

    	return redirect('admin/course/add')->with(['notify'=>'Successfully Added']);
    }

    public function getEdit($id){


        $course = Course::find($id);
        $type = CategoryType::find($course->id_ctype);
        $category = Category::find($type->id_category);
 
        if(!empty($course)) {
            $img = Cloudder::show('english-Center/course-image/'.$course->image);
            $course->setAttribute('image', $img);
        }

        return view('admin/course/edit', ['course'=>$course, 'category'=>$category, 'type'=>$type]);
    }

    public function postEdit(Request $request, $id){

        $course = Course::find($id);

        if($course->id_teacher != $request->id_teacher) {
            
            Register::create([
                'tuition' => -1,
                'course_price' => $course->price,
                'id_student' => $request->id_teacher,
                'id_course' => $id
            ]);

            Register::where('id_student', $course->id_teacher)->delete();
        }

        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $name = $file->getClientOriginalName(); 
            $img = str_random(5)."_".$name;
            Cloudder::upload($file, 'english-Center/course-image/'.$img);

            $course->image = $img;
        } 

        $course->fill($request->all())->save();

        return redirect('admin/course/edit/'.$id)->with(['notify'=>'Successfully Edited']);
    }


    
    public function getAddLesson($id){

        $course = Course::find($id);   
        $lesson = Lesson::where('id_course', $id)->paginate(10);

        return view('admin/lesson/add', ['lesson'=>$lesson, 'course'=>$course]);
    }

    public function postAddLesson(addLessonRequest $request, $id){

        $lesson = new Lesson;

        if($request->hasFile('video')){

            $name = $request->file('video')->getClientOriginalName();

            $file = $request->file('video')->getRealPath();

            $videoUpload = Cloudder::uploadVideo($file, 'english-Center/course-video/'.$name."_".str_random(5), ['resource_type' => 'video']);

            $video_url = Cloudder::secureShow(Cloudder::getPublicId(), ['resource_type' => 'video', 'format' => 'mp4', "width" =>  null, "height"=> null, "crop" => null]);

            $lesson->links_svideo = $video_url;  
        }

        if($request->hasFile('document')){
                $name = $request->file('document')->getClientOriginalName();

                $file = $request->file('document')->getRealPath();

                Cloudder::upload($file, 'english-Center/course-document/'.$name."_".str_random(5), ['resource_type' => 'raw']);

                $document_url = Cloudder::secureShow(Cloudder::getPublicId());

                $lesson->links_document = $document_url;

        }

        $lesson->lesson = $request->name;
        $lesson->id_course = $id;
        $lesson->save();

        return redirect('admin/lesson/add/'.$id)->with(['notify'=>'Successfully Added']);
    }


    public function getListCate($id){

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
        return view('admin/course/list', ['course'=>$course, 'lesson'=>$lesson, 'test'=>$test, 'register'=>$register]);
    }

    public function postSearch(Request $request){

        $keyword = $request->search;
        return redirect()->route('listCourse', ['keyword'=>$keyword]);
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
        
            return response(view('admin/course/addTest', ['course'=>$course, 'testList'=>$testList, 'test'=>$test, 'detail'=>$testDetail]));
        }


        return view('admin/course/addTest', ['course'=>$course, 'testList'=>$testList, 'test'=>$test, 'detail'=>$testDetail]);
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


    public function getComment($id){
        $course = Course::find($id);
        $comment = Comment::where('id_course', $course->id)->paginate(5);
        return view('admin/course/comment', ['course'=>$course, 'comment'=>$comment]);
    }
}
