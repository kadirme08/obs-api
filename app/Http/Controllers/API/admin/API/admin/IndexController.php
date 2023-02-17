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
            $data=array();

            return response()->json([
                $data='student'=>$get_student,'teacher'=>$get_teacher
            ],200);

        }catch (\exception $e){
       return  response()->json([
           'satatus'=>false,
           'Message'=>$e->getMessage()
       ]);
        }
    }
}
