<?php

namespace App\Http\Controllers\API\admin\API\admin;

use App\Http\Controllers\Controller;
use App\Models\teacherinfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function teacherAdd(Request $request){
        try {
            $validator=Validator::make($request->all(),[
                'name'=>'required',
                'tc_kimlik'=>'required',
                'adres'=>'required',
                'cinsiyet'=>'required',
                 'telefon_no'=>'required',
                'email'=>'required',
                'profil_foto'=>'required',
            ]);
            if($validator->fails()){
                return  response()->json([
                   'status'=>false,
                   'message'=>$validator->errors()->all()
                ],422);

            }else{
                $user=User::create([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=>Hash::make($request->password),
                    'Utype'=>2
                ]);
                $user->syncRoles('ogretmen');
                $user_id=$user->id;
                $data=teacherinfo::create([
                    'user_id'=>$user_id,
                    'tc_kimlik'=>$request->tc_kimlik,
                    'isim_soyisim'=>$request->name,
                    'adres'=>$request->adres,
                    'cinsiyet'=>$request->cinsiyet,
                    'telefon_no'=>$request->telefon_no,
                    'email'=>$request->email,
                    'profil_foto'=>$request->profil_foto
                ]);
                 if($data){
                     return  response()->json([
                        'status'=>true,
                        'message'=>'ogretmen Ekleme İşlemi başarılı'
                     ],201);
                 }else{
                     return response()->json([
                        'status'=>false,
                        'message'=>'Ekleme işlemi başarısız oldu lütfen Hizmet aldıgınız sunucudan destek alın'
                     ],400);
                 }

            }
        }catch (\Exception $e){
            return response()->json([
               'status'=>false,
               'message'=>$e->getMessage()
            ]);
        }

    }

    public function teacherUpdate(Request $request,$id){
        try {
            $validator=Validator::make($request->all(),[
                'name'=>'required',
                'tc_kimlik'=>'required',
                'adres'=>'required',
                'cinsiyet'=>'required',
                'telefon_no'=>'required',
                'email'=>'required',
                'profil_foto'=>'required',
            ]);
            if($validator->fails()){
                return  response()->json([
                    'status'=>false,
                    'message'=>$validator->errors()->all()
                ],422);

            }else{
                $data=teacherinfo::where('id',$id)->update([
                    'tc_kimlik'=>$request->tc_kimlik,
                    'isim_soyisim'=>$request->name,
                    'adres'=>$request->adres,
                    'cinsiyet'=>$request->cinsiyet,
                    'telefon_no'=>$request->telefon_no,
                    'email'=>$request->email,
                    'profil_foto'=>$request->profil_foto
                ]);
                if($data){
                    return  response()->json([
                        'status'=>true,
                        'message'=>'ogretmen Güncelleme İşlemi başarılı'
                    ],201);
                }else{
                    return response()->json([
                        'status'=>false,
                        'message'=>'Güncelleme işlemi başarısız oldu lütfen Hizmet aldıgınız sunucudan destek alın'
                    ],400);
                }

            }
        }catch (\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ]);
        }

    }

    public function teacherDelete($id){
        try {
            $data1=teacherinfo::where('id',$id)->first();
            $user_id=$data1->user_id;
            $data=teacherinfo::where('id',$id)->delete();
            User::where('id',$user_id)->delete();
            if ($data){
                return response()->json([
                   'status'=>true,
                   'message'=> 'silme işlemi başarılı'
                ],200);
            }else{
                return  response()->json([
                   'status'=>true,
                   'message'=>'silme işlemi olurken bir hata olustu'
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
