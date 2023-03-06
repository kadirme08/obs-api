<?php

use App\Http\Controllers\API\admin\API\admin\ClassromController;
use App\Http\Controllers\API\admin\API\admin\ExamController;
use App\Http\Controllers\API\admin\API\admin\IndexController;
use App\Http\Controllers\API\admin\API\admin\StudentAttendance;
use App\Http\Controllers\API\admin\API\admin\StudentController;
use App\Http\Controllers\API\admin\API\admin\SubjectController;
use App\Http\Controllers\API\admin\API\admin\SubjectRootController;
use App\Http\Controllers\API\admin\API\admin\TeacherAttendanceController;
use App\Http\Controllers\API\admin\API\admin\TeacherController;
use App\Http\Controllers\API\admin\API\admin\TimeTableController;
use App\Http\Controllers\API\admin\API\akademikAuth\AuthController;
use App\Http\Controllers\API\admin\API\ogrenciAuth\StudentAuthController;
use App\Http\Controllers\API\adminAuth\AdminAuthController;


use App\Http\Controllers\API\akademik\MystudentController;
use App\Http\Controllers\API\akademik\MyTimeTableController;
use App\Http\Controllers\API\akademik\MyAttandanceListControler;
use App\Http\Controllers\API\ogrenci\studentSubjectListController;
use App\Http\Controllers\API\ogrenci\studentMytable;
use App\Http\Controllers\API\ogrenci\studentAttandanceController;
use Illuminate\Support\Facades\Request;
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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::post('/akademik/auth/register',[AuthController::class,'register']);
//Route::post('/ogrenci/auth/register',[StudentAuthController::class,'register']);
Route::post('/akademik/auth/login',[AuthController::class,'login']);
    Route::post('/ogrenci/auth/login',[StudentAuthController::class,'login']);
    Route::post('/admin/auth/login',[AdminAuthController::class,'login']);

Route::prefix('admin')->middleware(['auth:sanctum','role:admin'])->group(function (){
   Route::get('/index',[IndexController::class,'ShowIndex']);
//Classroom Controller
     Route::post('/classroomAdd',[ClassromController::class,'classroomAdd']);
     Route::get('/classroomList',[ClassromController::class,'classroomList']);
    Route::get('/classroomBranchList',[ClassromController::class,'classroomBranch']);
     Route::put('/classroomUpdate/{id}',[ClassromController::class,'classroomUpdate']);
    Route::delete('/classroomDelete/{id}',[ClassromController::class,'classroomDelete']);
    Route::put('/classroomChangeStatus/{id}',[ClassromController::class,'changeStatus']);
    Route::get('/classroomSearch/{searchTerm}',[ClassromController::class,'searchTerm']);
 //StudentController
    Route::post('/studentAdd',[StudentController::class,'studentAdd']);
    Route::get('/studentUpdatePerson/{id}',[StudentController::class,'studentUpdateGet']);
    Route::post('/studentUpdate/{id}',[StudentController::class,'studentGuardianUpdate']);
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
    Route::get('/teacherList',[TeacherController::class,'teacherList']);
    Route::post('/teacherSearch',[TeacherController::class,'teacherSearch']);
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
    Route::post('/TeacherAttendanceAdd',[TeacherAttendanceController::class,'TeacherAttendanceAdd']);
    //Exam Controller
    Route::get('/examList',[ExamController::class,'examList']);
    Route::post('/examAdd',[ExamController::class,'examAdd']);

});
Route::prefix('admin')->middleware(['auth:sanctum','role:ogretmen'])->group(function (){
    Route::get('/mySubjecList',[MystudentController::class,'mySubjecList']);
    Route::get('/myStudentList',[MystudentController::class,'myStudentList']);
    Route::post('/searchSubjectList',[MystudentController::class,'searchSubjectList']);
    Route::post('/studentScore',[MystudentController::class,'StudentScore']);
    Route::post('/StudentUpdateScore',[MystudentController::class,'StudentUpdateScore']);

    //
    Route::get('/mytimeTableList',[MyTimeTableController::class,'MytimeTableList']);
    //
    Route::get('/MyAttadanceList',[MyAttandanceListControler::class,'MyAttadanceList']);
});
Route::prefix('ogrenci')->middleware(['auth:sanctum','role:ogrenci'])->group(function (){
    Route::post('/logout',[StudentAuthController::class,'logout']);
    Route::get('/studentSubjectList',[studentSubjectListController::class,'studentSubjectList']);
    Route::get('/studentTeacherList',[studentSubjectListController::class,'studentTeacherList']);
    //
    Route::get('/myTableList',[studentMytable::class,'myTableList']);
    //
    Route::get('/studentAttandanceList',[studentAttandanceController::class,'studentAttandanceList']);


});








