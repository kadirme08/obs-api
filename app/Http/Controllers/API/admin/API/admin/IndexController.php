<?php

namespace App\Http\Controllers\API\admin\API\admin;

use App\Http\Controllers\Controller;
use App\Models\studentinfo;
use App\Models\teacherinfo;

class IndexController extends Controller
{
    public  function ShowIndex(){
        try {
            $get_student=studentinfo::get();
            $get_teacher=teacherinfo::get();
            return response()->json([
                'status'=>true,
                $data='student'=>$get_student,'teacher'=>$get_teacher
            ],200);

        }catch (\exception $e){
       return  response()->json([
           'status'=>false,
           'Message'=>$e->getMessage()
       ],400);
        }
    }
}
