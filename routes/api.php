<?php

use App\Http\Controllers\API\akademikAuth\AuthController;
use App\Http\Controllers\Api\ClassromController;
use App\Http\Controllers\API\IndexController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\TeacherController;
use App\Http\Controllers\API\ogrenciAuth\StudentAuthController;
use App\Http\Controllers\API\SubjectController;
use App\Http\Controllers\API\StudentAttendance;
use App\Http\Controllers\API\TeacherAttendanceController;

use App\Http\Controllers\API\TimeTableController;
use App\Http\Controllers\API\SubjectRootController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  //  return $request->user();
//});
Route::post('/akademik/auth/register',[AuthController::class,'register']);
Route::post('/akademik/auth/login',[AuthController::class,'login']);
Route::post('/ogrenci/auth/register',[StudentAuthController::class,'register']);
Route::post('/ogrenci/auth/login',[StudentAuthController::class,'register']);

Route::prefix('admin')->middleware(['auth:sanctum','role:admin'])->group(function (){
   Route::get('/index',[IndexController::class,'ShowIndex']);
//Classroom Controller
     Route::post('/classroomAdd',[ClassromController::class,'classroomAdd']);
     Route::get('/classroomList',[ClassromController::class,'classroomList']);
     Route::put('/classroomUpdate/{id}',[ClassromController::class,'classroomUpdate']);
    Route::delete('/classroomDelete/{id}',[ClassromController::class,'classroomDelete']);
    Route::put('/classroomChangeStatus/{id}',[ClassromController::class,'changeStatus']);
    Route::get('/classroomSearch/{searchTerm}',[ClassromController::class,'searchTerm']);
 //StudentController
    Route::post('/studentAdd',[StudentController::class,'studentAdd']);
    Route::get('/studentGuardianList/{id}',[StudentController::class,'studentGuardianList']);
    Route::put('/studentUpdate/{id}',[StudentController::class,'studentGuardianUpdate']);
    Route::get('/studentList',[StudentController::class,'studentList']);
    Route::get('/studentSelectClassList',[StudentController::class,'studentSelectClassList']);
    Route::post('/studentSelectClassAdd',[StudentController::class,'studentSelectClassAdd']);
    Route::put('/studentSelectClassUpdate/{id}',[StudentController::class,'studentSelectClassUpdate']);
    Route::post('/studentPaymentAdd/{id}',[StudentController::class,'studentPaymentAdd']);
    Route::get('/studentPaymentList/{id}',[StudentController::class,'studentPaymentList']);
    Route::get('/studentPaymentListDetais/{id}',[StudentController::class,'studentPaymentListDetais']);
    Route::post('/studentSearch',[StudentController::class,'search']);

  //Subject Controller
    Route::post('/subjectAdd',[SubjectController::class,'subjectAdd']);
    Route::put('/subjectUpdate/{id}',[SubjectController::class,'subjectUpdate']);
    //Teacher Controller
    Route::post('/teacherAdd',[TeacherController::class,'teacherAdd']);
    Route::put('/teacherUpdate/{id}',[TeacherController::class,'teacherUpdate']);
    Route::delete('/teacherDelete/{id}',[TeacherController::class,'teacherDelete']);
    //Subject Rooting Contorller
    Route::get('/subjectList',[SubjectRootController::class,'List']);
    Route::post('/subjectRootAdd',[SubjectRootController::class,'subjectRootAdd']);
    Route::put('/subjectRootUpdate/{id}',[SubjectRootController::class,'subjectRootUpdate']);
    Route::get('/subjectRootList',[SubjectRootController::class,'subjectRootList']);
    Route::delete('/subjectRootDelete/{id}',[SubjectRootController::class,'subjectRootDelete']);
    //TimeTableController
    Route::get('/timeTableList',[TimeTableController::class,'timeTableList']);
    Route::post('/timeTableAdd',[TimeTableController::class,'timeTableAdd']);
    Route::put('/timeTableUpdate/{id}',[TimeTableController::class,'timeTableUpdate']);
    Route::delete('/timeTableDelete/{id}',[TimeTableController::class,'timeTableDelete']);
    Route::post('/searchClass/{searchTerm}',[TimeTableController::class,'searchClass']);
    //studentAttendanceController
    Route::get('/studentAttandanceSearchlist/{sinif_id}',[StudentAttendance::class,'StudentAttandanceSearchlist']);
    //TeacherAttendanceController
        Route::post('/teacherAttendanceList',[TeacherAttendanceController::class,'TeacherAttendanceList']);
});
Route::middleware(['auth:sanctum','role:ogretmen'])->group(function (){

});

Route::middleware(['auth:sanctum','role:ogrenci'])->group(function (){


});








