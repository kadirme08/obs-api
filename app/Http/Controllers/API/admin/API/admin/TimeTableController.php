<?php

namespace App\Http\Controllers\API\admin\API\admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\time_table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TimeTableController extends Controller
{
    public function timeTableAdd(Request $request){
        try {
            $validator=Validator::make($request->all(),[
                'ders_gunu'=>'required',
                'ders_id'=>'required',
                'ogretmen_id'=>'required',
                'sinif_id'=>'required',
                'ders_baslangic_saati'=>'required',
                'ders_bitis_saati'=>'required'
            ]);
            if ($validator->fails()){
                return  response()->json([
                   'status'=>false,
                   'message'=>$validator->errors()->all()
                ],422);
            }else{
                $data=time_table::create([
                   'ders_gunu'=>$request->ders_gunu,
                   'ders_id'=>$request->ders_id,
                   'ogretmen_id'=>$request->ogretmen_id,
                   'sinif_id'=>$request->sinif_id,
                   'ders_baslangic_saati'=>$request->ders_baslangic_saati,
                   'ders_bitis_saati'=>$request->ders_bitis_saati
                ]);
                if($data){
                    return response()->json([
                       'status'=>true,
                       'message'=>'Ders programı Başarı İle olusturuldu'
                    ],201);
                }else{
                    return response()->json([
                       'status'=>false,
                       'message'=>'İşlem başarısız oldu'
                    ]);
                }
            }

        }catch (\exception $e){
            return response()->json([
               'status'=>false,
               'message'=>$e->getMessage()
            ]);
        }

    }
    public function timeTableList(){
        try {
            $time_table=time_table::get();
            $classrom=Classroom::get();
            $data=array('time_table'=>$time_table,'classrom'=>$classrom);
            if ($data){
                return response()->json([
                   'status'=>true,
                   'data'=>$data
                ],200);
            }else{
                return response()->json([
                   'status'=>false,
                   'message'=>'Ders programı Bulunamadı'
                ]);
            }
        }catch (\exception $e){
             return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
             ]);
        }


    }
    public function timeTableUpdate(Request $request , $id){
        try {
            $validator=Validator::make($request->all(),[
                'ders_gunu'=>'required',
                'ders_id'=>'required',
                'ogretmen_id'=>'required',
                'sinif_id'=>'required',
                'ders_baslangic_saati'=>'required',
                'ders_bitis_saati'=>'required'
            ]);
            if ($validator->fails()){
                return  response()->json([
                    'status'=>false,
                    'message'=>$validator->errors()->all()
                ],422);
            }else{
                $data=time_table::where('id',$id)->update([
                    'ders_gunu'=>$request->ders_gunu,
                    'ders_id'=>$request->ders_id,
                    'ogretmen_id'=>$request->ogretmen_id,
                    'sinif_id'=>$request->sinif_id,
                    'ders_baslangic_saati'=>$request->ders_baslangic_saati,
                    'ders_bitis_saati'=>$request->ders_bitis_saati
                ]);
                if($data){
                    return response()->json([
                        'status'=>true,
                        'message'=>'Ders programı Başarı İle Güncellendi'
                    ],201);
                }else{
                    return response()->json([
                        'status'=>false,
                        'message'=>'İşlem başarısız oldu'
                    ]);
                }
            }

        }catch (\exception $e){
            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ]);
        }


    }
    public function timeTableDelete($id){
        try {
            time_table::where('id',$id)->delete();
            return response()->json([
                'status'=>true,
                'message'=>'silme işlemi başarılı'
            ],200);

        }catch (\exception $e){
            return response()->json([
               'status'=>false ,
                'messae'=>$e->getMessage()
            ],400);
        }

    }
    public function searchClass($searchTerm){
        try {

            $data=time_table::where('sinif_id',$searchTerm)->get();
            if($data){
                return response()->json([
                   'status' =>false,
                    'data'=>$data
                ],200);
            }else{
                return response()->json([
                   'status'=>false,
                   'message'=>'Sınıf bulunamadı'
                ],400);
            }


        }catch (\exception $e){
            return response()->json([
               'status'=>true,
               'message'=>$e->getMessage()
            ]);
        }
    }
}
