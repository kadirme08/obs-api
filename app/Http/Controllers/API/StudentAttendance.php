<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\student_attendance;
use Illuminate\Http\Request;

class StudentAttendance extends Controller
{
    public function StudentAttandanceSearchlist(Request $request){
        try {
            $sinif_id=$request->sinif_id;
            $data=student_attendance::where('sinif_id',$sinif_id)->get();
            if($data){
                return response()->json([
                    'status'=>true,
                    'data'=>$data
                ],200);
            }else{
                return response()->json([
                   'status'=>false,
                   'message'=>"devamsızlık Bulunamadı"
                ],400);
            }
        }catch (\exception $e){
            return  response()->json([
               'status'=>false,
               'message'=>$e->getMessage()
            ],400);
        }

    }




}
