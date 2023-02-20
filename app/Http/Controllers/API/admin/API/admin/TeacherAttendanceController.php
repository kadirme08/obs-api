<?php

namespace App\Http\Controllers\API\admin\API\admin;

use App\Http\Controllers\Controller;
use App\Models\teacher_attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
     public function TeacherAttendanceAdd(Request $request){
         $validator=Validator::make($request->all(),[
             'user_id'=>'required',
             'ogretim_yili'=>'required',
             'devamsizlik_tarihi'=>'required',
             'aciklama'=>'required'
         ]);
         if ($validator->fails()){
             return response()->json([
                'status'=>false,
                'message'=>$validator->errors()->all()
             ],422);
         }else{
             $data=teacher_attendance::create([
                  'user_id'=>$request->user_id,
                 'ogretim_yili'=>$request->ogretim_yili,
                 'devamsizlik_tarihi'=>$request->devamsizlik_tarihi,
                 'aciklama'=>$request->aciklama,
             ]);
             if($data){
                 return  response()->json([
                    'status'=>true,
                    'Message'=>'Kayıt işlemi başarılı'
                 ],201);
             }else{
                 return  response()->json([
                    'status'=>false,
                    'message'=>'kayıt olusturulurken hata olustu'
                 ]);
             }
         }

     }
}
