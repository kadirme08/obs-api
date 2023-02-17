<?php

namespace App\Http\Controllers\API\admin\API\admin;

use App\Http\Controllers\Controller;
use App\Models\teacher_attendance;
use Illuminate\Http\Request;

class TeacherAttendanceController extends Controller
{

     public function TeacherAttendanceList(Request $request){
         try {
             $ogretmen_id=$request->ogretmen_id;
             $data=teacher_attendance::where('user_id',$ogretmen_id)->get();
             if($data){
                 return response()->json([
                     'status'=>true,
                     'data'=>$data
                 ],200);
             }else{
                 return response()->json([
                    'status'=>false,
                    'message'=>'Öğretmen devamsızlığı bulunamadı'
                 ]);
             }
         }catch (\exception $e){
         return response()->json([
            'status'=>false,
            'message'=>$e->getMessage()
         ],400);
         }

     }
}
