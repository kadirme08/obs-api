<?php

use App\Http\Controllers\API\akademikAuth\AuthController;
use App\Http\Controllers\Api\ClassromController;
use App\Http\Controllers\API\IndexController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\ogrenciAuth\StudentAuthController;
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
    Route::get('/studentList',[StudentController::class,'studentList']);
    Route::post('/studentSearch',[StudentController::class,'search']);
    //




});
Route::middleware(['auth:sanctum','role:ogrenci'])->group(function (){


});
Route::middleware(['auth:sanctum','role:ogretmen'])->group(function (){

});








