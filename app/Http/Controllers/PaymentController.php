<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Course;
use App\Teacher;
use App\CategoryType;
use App\Category;
use App\Student;
use App\Lesson;
use App\Test;
use App\Discount;
use App\Register;
use Carbon\Carbon;

use Cloudder;
use Validator;

class PaymentController extends Controller
{
    
	public function __construct() {

		$teacherList = Teacher::all();
    	$studentList = Student::all();
    	$testList = Test::all();
    	$lessonList = Lesson::all();
        $categoryList = Category::all();
        $typeCList = CategoryType::all();
        $courseTotal = Course::all();

    	view()->share('teacherList', $teacherList);
    	view()->share('studentList', $studentList);
    	view()->share('testList', $testList);
    	view()->share('lessonList', $lessonList);
        view()->share('categoryList', $categoryList);
        view()->share('typeCList', $typeCList);
        view()->share('courseTotal', $courseTotal);

		return $this->middleware('auth');
	}

	function postDiscount (Request $request){

        $validator = \Validator::make($request->all(),[
            'coupon'=>'required|string|min: 3|max: 191'
          
        ], 
        [
            'coupon.required'=>'Vui lòng nhập mã giảm giá',
            'coupon.string'=>'Mã giảm giá không hợp lệ',
            'coupon.min'=>'Mã giảm giá không hợp lệ',
            'coupon.max'=>'Mã giảm giá không hợp lệ'

        ]);


        if ($validator->fails())
        {
            return redirect()->back()->with(['errors'=>$validator->errors()]);
        }

        $discount = Discount::where('code', $request->coupon)->first();
        $timenow = Carbon::now('Asia/Ho_Chi_Minh');

        if($discount != null){
            if($discount->date_finish < $timenow) {
                return redirect()->back()->with(['time'=>'Mã giảm giá hết hạn sử dụng']);
            }

            if($discount->quantity == 0) {
                return redirect()->back()->with(['quantity'=>'Hết lượt sử dụng']);
            }

            if(Register::where('id_student', Auth::id())->where('id_discount',$request->coupon)->exists()) {
            	return redirect()->back()->with(['err'=>'Mã giảm giá đã được sử dụng']);
            }

            $course = Course::find($request->id_course);
            if($course->price < $discount->reduce) {
                $sale = $course->price;
            } else {
                $sale = $discount->reduce;
            }

            return redirect()->back()->with(['sale'=>$sale, 'name'=>$request->coupon]);
        } else {
            return redirect()->back()->with(['err'=>'Mã không tồn tại']);
        }
    }

	function payment($id){
		
		if(Course::where('id', $id)->exists()) {
	        $course = Course::find($id);
	        $img = Cloudder::show('english-Center/course-image/'.$course->image);
	        $course->setAttribute('img', $img);
	        $teacher = Teacher::where('id', $course->id_teacher)->first();
	        return view('pages.pay', ['course'=>$course, 'teacher'=>$teacher]);
	    } else {
	    	return view('pages.listnone');
	    }
    }


    function postPayment(Request $request, $id){

        if(Course::where('id', $id)->exists()) {

            $course = Course::find($id);
            if(Discount::where('code', $request->idcoupon)->exists()) {
                $code = Discount::where('code', $request->idcoupon)->first();
                if($course->price < $code->reduce) {
                    $sale = $course->price;
                } else {
                    $sale = $code->reduce;
                }

                $price = $course->price - $sale;

            } else {
                if(Auth::user()->account_balance < $request->price){
                    return redirect('payment/'.$id)->with(['pushCard'=>true]);
                
                } else {
                    $price = $course->price;
                }
            }

        	if(Register::where('id_course', $course->id)->where('id_student', Auth::id())->exists()) {
        		return redirect()->route('courseintro',['course'=>$course->slug]);
        	} else {

        		$register = Register::create([
		            'tuition' => $price,
		            'course_price' => $course->price,
		            'id_student' => Auth::id(),
		            'id_course' => $id,
		            'id_discount' => $request->idcoupon
	        	]);

	        	$balance = Auth::user()->account_balance - $price;
	        	
	        	Discount::where('code', $request->idcoupon)->decrement('quantity', 1);

	        	\Auth::user()->update(['account_balance'=>$balance]);
        	}

        	return redirect('course/'.$course->slug)->with(['success'=>'Đăng ký khóa học thành công']);
	

        } else {

        	return view('pages.listnone');
        }

    }
}
