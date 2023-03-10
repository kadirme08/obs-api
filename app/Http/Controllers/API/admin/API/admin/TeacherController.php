<?php

namespace App\Http\Controllers\API\admin\API\admin;

use App\Http\Controllers\Controller;
use App\Models\studentinfo;
use App\Models\subject;
use App\Models\subject_root;
use App\Models\teacherinfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function teacherList(){
        try {
            // $data=teacherinfo::get();
             $data=subject_root::get();
            if ($data){
                return response()->json([
                   'status'=>true,
                    'data'=>$data
                ]);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'Listelenicek Veri Bulunamadı'
                ]);
            }

        }catch (\exception $exception){
            return response()->json([
               'status'=>false,
               'message'=> $exception->getMessage()
            ],400);
        }
    }
    public function teacherSearch(Request $request){
        try {
            $ogretmen_no=$request->ogretmen_no;
            $isim=$request->isim;
            $ogretmen=teacherinfo::where('isim_soyisim',$isim)->get();
            if ($isim && count($ogretmen)>0){
                foreach ($ogretmen as $ogr)
                {
                    $ogretmen_id[]=$ogr->id;
                     foreach ($ogretmen_id as $ogretmen_bilgisi_id){
                         $data=subject_root::where('ogretmen_id',$ogretmen_id)->get();
                     }
                }
                if (count($data)>0){
                    return response()->json([
                        'status'=>true,
                        'data'=>$data
                    ],200);
                }else{

                    return response()->json([
                        'status'=>false,
                        'message'=>'Listelenicek Öğretmen bulunamadı'
                    ],400);
                }
            }elseif($ogretmen_no){
                $ogretmen=teacherinfo::where('ogretmen_no',$ogretmen_no)->get();
                 if(count($ogretmen)>0){
                     foreach ($ogretmen as $ogr){
                         $ogretmen_id[]=$ogr->id;
                          foreach ($ogretmen_id as $ogretmen_bilgisi_id){
                              $data=subject_root::where('ogretmen_id',$ogretmen_bilgisi_id)->get();
                          }
                     }
                 }
                if (count($data)>0){
                    return response()->json([
                        'status'=>true,
                        'data'=>$data
                    ],200);
                }else{
                    return response()->json([
                        'status'=>false,
                        'message'=>'Listelenicek Öğretmen bulunamadı'
                    ],400);
                }
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'Listelenicek Öğretmen bulunamadı'
                ],400);
            }
        }catch (\exception $e){
            return response()->json([
               'status'=>false,
               'message'=>$e->getMessage()
            ],400);
        }

    }
    public function teacherAdd(Request $request){
        try {
            $validator=Validator::make($request->all(),[
                 'name'=>'required',
                 'tc_kimlik'=>'required',
                 'adres'=>'required',
                 'cinsiyet'=>'required',
                 'telefon_no'=>'required',
                 'email'=>'required',
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
                    'ogretmen_no'=>$request->ogretmen_no,
                    'profil_foto'=>$request->profil_foto
                ]);
                $ogretmen_id=$data->id;
                $subject_root=subject_root::create([
                     'sinif_id'=>$request->sinif_id,
                     'sube_id'=>$request->sube_id,
                     'ders_id'=>$request->ders_id,
                     'ogretmen_id'=>$ogretmen_id
                 ]);
                 if($data && $user && $subject_root){
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
    public  function teacherUpdateList($id){
        try {
               $teacher=teacherinfo::where('id',$id)->first();
               $teacher_id=$teacher->id;
               $user_id=$teacher->user_id;
               $subject=subject_root::where('ogretmen_id',$teacher_id)->get();
               $user=User::where('id',$user_id)->first();
                foreach ($subject as $value){
                    $sinif=$value->sinif;
                    $ders=$value->ders;
                    $sube=$value->sube;
                }
                $data=array('teacher'=>$teacher,'sinif'=>$sinif,'ders'=>$ders,'sube'=>$sube,'user'=>$user);
               if ($teacher && $teacher_id){
                    return  response()->json([
                       'status'=>true,
                       'data'=>$data,

                    ],200);
               }else{
                   return  response()->json([
                       'status'=>false,
                        'message'=>'Ogretmen bulunamadı'
                   ],400);
               }
        }catch (\exception $e){
             return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
             ],400);
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
            ]);
            if($validator->fails()){
                return  response()->json([
                    'status'=>false,
                    'message'=>$validator->errors()->all()
                ],422);

            }else{
                $data=teacherinfo::where('id',$id)->update([
                    'tc_kimlik'=>$request->tc_kimlik,
                    'ogretmen_no'=>$request->ogretmen_no,
                    'isim_soyisim'=>$request->name,
                    'adres'=>$request->adres,
                    'cinsiyet'=>$request->cinsiyet,
                    'telefon_no'=>$request->telefon_no,
                    'email'=>$request->email,
                    'profil_foto'=>$request->profil_foto
                ]);
                 $ogretmen=teacherinfo::where('id',$id)->first();
                 $ogretmen_id=$ogretmen->id;
                 $subject=subject_root::where('id',$ogretmen_id)->update([
                    'ders_id'=>$request->ders_id,
                    'sinif_id'=>$request->sinif_id,
                    'sube_id'=>$request->sube_id,
                    'ogretmen_id'=>$ogretmen_id
                 ]);
                $user_id=$ogretmen->user_id;
                $user=User::where('id',$user_id)->update([
                     'email'=>$request->email,
                    'password'=>Hash::make($request->password),
                ]);
                if($data && $subject && $user){
                    return  response()->json([
                        'status'=>true,
                        'message'=>'ogretmen Güncelleme İşlemi başarılı'
                    ],201);
                }else{
                    return response()->json([
                        'status'=>false,
                        'message'=>'Güncelleme işlemi başarısız oldu lütfen Hizmet aldıgınız sunucudan destek alın',

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
