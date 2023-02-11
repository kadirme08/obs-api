<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\studentinfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function studentAdd(Request $request){
        try {
            $validator=Validator::make($request->all(),[
                'tc_kimlik'=>'required|unique:studentinfo',
                'ogrenci_no'=>'required|unique:studentinfo',
                'adres'=>'required',
                'email'=>'required',
                'telefon'=>'required',
                'dogum_tarihi'=>'required',
                'cinsiyet'=>'required',
                'sube'=>'required',
                'sinif'=>'required',
            ]);
            if ($validator->fails()){
                 return response()->json([
                    'status'=>false,
                    'message'=>$validator->errors()->all()
                 ],422);

            }else{
                $user=User::create([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=>Hash::make($request->password),
                    'Utype'=>'1'
                ],200);
                $user->syncRoles('ogrenci');
                $user_id=$user->id;
                $data=studentinfo::create([
                    'user_id'=>$user_id,
                    'tc_kimlik'=>$request->tc_kimlik,
                    'ogrenci_no'=>$request->ogrenci_no,
                    'isim_soyisim'=>$request->name,
                    'adres'=>$request->adres,
                    'email'=>$request->email,
                    'telefon'=>$request->telefon,
                    'dogum_tarihi'=>$request->dogum_tarihi,
                    'cinsiyet'=>$request->cinsiyet,
                    'profil_resim'=>$request->resim,
                    'sube'=>$request->sube,
                    'sinif'=>$request->sinif,
                ],200);
                if ($data){
                    return response()->json([
                       'status'=>true,
                       'message'=>'Öğrenci Kayıt işlemi başarılı'
                    ],201);
                }else{
                    return response()->json([
                        'status'=>false,
                        'message'=>'Öğrenci Kayıt edilirken Sorun olustu'
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

    public function studentList(){
        $data=studentinfo::all();
        if ($data){
             return response()->json([
                'status'=>true,
                'data'=>$data
             ]);
        }else{
            return  response()->json([
               'status'=>false,
               'message'=>'Kayıtlı öğrenci listesi boş'
            ]);

        }

    }

    public function search(Request $request){
        try {
            $sinif=$request->sinif;
            $sube=$request->sube;
            $data=studentinfo::where('sinif',$sinif)
                ->where('sube',$sube)->get();
            if ($data){
                return  response()->json([
                   'status'=>true,
                   'data'=>$data
                ],200);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'Sonuc bulunamadı'
                ],400);

            }

        }catch (\Exception $e){
            return response()->json([
               'status'=>false,
               'message' =>$e->getMessage()
            ],400);
        }

    }
}
