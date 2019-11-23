<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategoryType;
use App\Test;
use App\TestDetail;

class AjaxController extends Controller
{
   public function postLevel(Request $request){
   		
   		if($request->input('id') != ''){
   			$id = $request->input('id');
   			$type = CategoryType::where('id_category','=', $id)->get();
   		}

   		return response()->json($type);
   }	

    public function getTestList(Request $request){
    	$test = Test::Paginate(5);
        $testDetail = TestDetail::all();

        if($request->ajax()){
            $record = $request->input('_record');

            $test = Test::paginate($record);
        
            return response(view('admin/test/list', ['test'=>$test, 'detail'=>$testDetail]));
        }

    	

    	return view('admin/test/list', ['test'=>$test, 'detail'=>$testDetail]);
    }
}
