<?php

namespace App\Http\Controllers\API\admin\API\admin;

use App\Http\Controllers\Controller;
use App\Models\exam_name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    public function examAdd(Request $request){
        try {
            $validator=Validator::make($request->all(),[
               'sinav_adi'=>'required',
            ]);
            if ($validator->fails()){
                return  response()->json([
                   'status'=>false,
                   'message'=>$validator->errors()->all()
                ],422);
            }else{
                $data=exam_name::create([
                   'sinav_adi'=>$request->sinav_adi
                ]);
                if ($data){
                    return response()->json([
                       'status'=>true,
                       'message'=>'Sinav olusturma başarılı'
                    ],201);
                }else{
                    return  response()->json([
                       'status'=>false,
                       'message'=>'Sınav olusturulamadı'
                    ]);
                }
            }
        }catch (\exception $e){
            return response()->json([
               'status'=>false,
                'message'=>$e->getMessage()
            ],400);
        }


    }
    public function examList(){
        try {
             $data=exam_name::get();
             if($data){
                 return response()->json([
                    'status'=>true,
                    'data'=>$data
                 ],200);
             }else{
                 return  response()->json([
                    'status'=>false,
                    'message'=>'Kayıtlı sınav bulunamadı'
                 ],400);
             }
        }catch (\exception $e){
            return response()->json([
               'status'=>false,
               'message'=>$e->getMessage()
            ],400);
        }
    }




}
