<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\subject;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    public function subjectAdd(Request $request){
        try {
            $validator=Validator::make($request->all(),[
                'ders_adi'=>'required',
                'saatlik_ucret'=>'required'
            ]);
            if ($validator->fails()){
                return response()->json([
                    'status'=>false,
                    'message'=>$validator->errors()->all()
                ],422);
            }else{
                $data=subject::create([
                    'ders_adi'=>$request->ders_adi,
                    'ders_saatlik_ucret'=>$request->saatlik_ucret
                ]);
                if($data){
                    return response()->json([
                        'status'=>true,
                        'message'=>'Ders ekleme İşlemi Başarılı başarılı'
                    ],201);
                }else{
                    return response()->json([
                        'status'=>false,
                        'message'=>'Ders ekleme olurken Başarısız oldu'
                    ],400);
                }
            }
        }catch (\exception $e){
             return  response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
             ],400);
        }


    }

    public function subjectUpdate(Request $request,$id){
        try {
            $validator=Validator::make($request->all(),[
                'ders_adi'=>'required',
                'saatlik_ucret'=>'required'
            ]);
            if ($validator->fails()){
                return response()->json([
                    'status'=>false,
                    'message'=>$validator->errors()->all()
                ],422);
            }else{
                $data=subject::where('id',$id)->update([
                    'ders_adi'=>$request->ders_adi,
                    'ders_saatlik_ucret'=>$request->saatlik_ucret
                ]);
                if($data){
                    return response()->json([
                        'status'=>true,
                        'message'=>'Ders ekleme İşlemi Başarılı başarılı'
                    ],201);
                }else{
                    return response()->json([
                        'status'=>false,
                        'message'=>'Ders ekleme olurken Başarısız oldu'
                    ],400);
                }
            }
        }catch (\exception $e){
             return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
             ],400);
        }

    }

}
