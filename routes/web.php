<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('index');
});



//Login admin
Route::get('admin/login', 'Auth\LoginController@getLoginAdmin');
Route::post('admin/login', 'Auth\LoginController@postLoginAdmin');
Route::get('admin/logout', ['as'=>'logoutAdmin', 'uses'=>'Auth\LogoutController@getAdminLogout']);

Route::get('admin/dashboard', 'PagesController@getAdminIndex')->middleware('checkadmin');

Route::group(['prefix'=>'admin', 'middleware' => 'checkadmin'], function() {

	Route::group(['prefix'=>'teacher'], function(){
		Route::get('list','TeacherController@getList')->name('listTeacher');

		Route::get('add','TeacherController@getAdd');

		Route::post('add','TeacherController@postAdd');

		Route::get('edit/{id}','TeacherController@getEdit');

		Route::post('edit/{id}','TeacherController@postEdit');
		
		Route::post('search', 'TeacherController@postSearch')->name('searchTeacher');

	});

	Route::group(['prefix'=>'question'], function(){

		Route::get('add','QuestionController@getAdd');

		Route::post('add','QuestionController@postAdd');

		Route::get('edit/{id}','QuestionController@getEdit');

		Route::post('edit/{id}', 'QuestionController@postEdit');

		Route::get('list', ['as'=>'loadQuestion', 'uses'=>'QuestionController@getListBasic']);

		Route::get('para', 'QuestionController@getPagePara');

		Route::get('basic', 'QuestionController@getPageBasic');

		Route::get('audio', 'QuestionController@getPageAudio');
		
	});


	Route::group(['prefix'=>'account'], function(){

		Route::get('add','AccountController@getAdd');

		Route::get('list', 'AccountController@getList')->name('listUser');

		Route::post('search', 'AccountController@postSearch')->name('searchUser');

	});


	Route::group(['prefix'=>'student'], function(){

		Route::get('list', 'StudentController@getList')->name('listStudent');

		Route::get('add','StudentController@getAdd');

		Route::post('add','StudentController@postAdd');

		Route::get('profile/{id}','StudentController@getProfile');

		Route::post('search', 'StudentController@postSearch')->name('searchStudent');
	});


	Route::group(['prefix'=>'course'], function(){ 
		Route::get('add', 'CourseController@getAdd');

		Route::post('add', 'CourseController@postAdd');

		Route::get('list', 'CourseController@getList')->name('listCourse');

		Route::get('list/{id}', 'CourseController@getListCate');

		Route::get('edit/{id}', 'CourseController@getEdit');

		Route::post('edit/{id}', 'CourseController@postEdit');

		Route::get('test/{id}', 'CourseController@getAddTest');

		Route::get('test/{id}/{keyword}', 'CourseController@getSearchTest')->name('getTestLesson');

		Route::post('test/{id}', 'CourseController@postAddTest');

		Route::post('searchTest', 'CourseController@searchTestLesson')->name('searchTestLesson');


		Route::get('comment/{id}', 'CourseController@getComment');

		Route::post('search', 'CourseController@postSearch')->name('searchCourse');

		Route::get('active/{id}', 'CourseController@getActive');

		Route::get('close/{id}', 'CourseController@getClose');

		Route::get('waitting/{id}', 'CourseController@getWait');

	});

	Route::group(['prefix'=>'lesson'], function(){

		Route::get('add/{id}', 'CourseController@getAddLesson');

		Route::get('add/{id}/{keyword}', 'CourseController@getSearchLesson')->name('getAddLesson');

		Route::post('add/{id}', 'CourseController@postAddLesson');

		Route::post('edit/{id}', 'CourseController@postEditLesson');

		Route::get('edit/{id}', 'CourseController@getEditLesson');

		Route::get('delete/{id}/{lesson}', 'CourseController@getDeleteLesson');

		Route::post('search', 'CourseController@postSearchLesson')->name('searchLesson');

	});

	Route::group(['prefix'=>'test'], function(){

		Route::get('list', 'TestController@getList')->name('listTest');

		Route::get('add', 'TestController@getAdd');

		Route::post('add', 'TestController@postAdd');

		Route::get('add/para', 'QuestionController@getPagePara');

		Route::get('add/basic', 'QuestionController@getPageBasic');

		Route::get('add/audio', 'QuestionController@getPageAudio');

		Route::get('edit/{id}', ['as'=>'editTest', 'uses'=>'TestController@getEdit']);

		Route::post('edit/{id}', 'TestController@postEdit');

		Route::get('delete/{id}', 'CourseController@deleteTest');

		Route::post('search', 'TestController@searchTest')->name('searchTest');

		Route::get('deletelist/{id}', 'TestController@deleteTestList');


	});

	Route::group(['prefix'=>'ajax'], function(){
		Route::post('level','AjaxController@postLevel');

		// Route::get('list', 'AjaxController@getTestList');
	});

});

Route::get('Home', 'PagesController@getIndex')->name('index');

//CategoryController
Route::get('Danh-sach/{keyword}', 'CategoryController@getCourse')->name('list');
Route::get('Danh-muc/{categoryType}', 'CategoryController@getCourseType');

Route::get('course/{course}', 'PagesController@getIntro')->name('courseintro');
Route::get('lesson/{id}', 'PagesController@getDesc');
Route::get('download/{name}', 'PagesController@fileDownload');

//PaymentController
Route::get('payment/{id}', 'PaymentController@payment');
Route::post('payment/{id}', 'PaymentController@postPayment');
Route::post('discount', 'PaymentController@postDiscount');

Route::get('login', function () {
    return redirect()->route('index')->with(['openLogin' => true, 'regSuccess'=>'Vui lòng đăng nhập']);
})->name('login');


Route::post('login', ['as'=>'login', 'uses'=>'Auth\LoginController@postLogin']);
Route::get('logout', ['as'=>'logout', 'uses'=>'Auth\LogoutController@getLogout']);

Route::post('register', ['as'=>'register','uses'=>'Auth\RegisterController@register']);

Route::post('comment', 'PagesController@postComment');

Route::post('replay/{id}', 'PagesController@postReplay');
Route::post('replayCourse/{id}', 'PagesController@postReplayCourse');

Route::post('studylesson', 'PagesController@postStudyLesson');
Route::get('overview/{id}', 'PagesController@getOverview')->name('overview');
Route::get('test/{id}', ['as'=>'getTest', 'uses'=>'PagesController@getTest']);
Route::post('postQuiz/{id}', 'PagesController@postQuiz');

Route::get('profile/{id}', 'PagesController@getProfile')->middleware('auth')->name('getProfile');
Route::post('profile/{id}','PagesController@postProfile');

Route::get('danh-sach-giao-vien','PagesController@listTeacher');
Route::get('giao-vien/{teacher}','PagesController@showTeacher')->middleware('auth');

Route::post('changepassword/{id}', 'PagesController@postChangePass');

Route::get('account/{id}', 'PagesController@getAccount')->middleware('auth');
Route::post('account/{id}','PagesController@postAccount');
Route::post('search', 'PagesController@postSearch');
Route::get('review/{id}', 'PagesController@getReview');

Route::post('nap-tien/{id}','PagesController@rechargeAccount')->middleware('auth');
