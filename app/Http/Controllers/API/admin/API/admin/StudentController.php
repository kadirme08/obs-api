<?php

namespace App\Http\Controllers\API\admin\API\admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\student_guardian;
use App\Models\student_payment;
use App\Models\student_subject;
use App\Models\studentinfo;
use App\Models\subject_root;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
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
                /* student_guardian::create([
                     'user_id'=>$user_id,
                     'tc_kimlik'=>$request->guardian_tc_kimlik,
                     'isim_soyisim'=>$request->guardian_name,
                     'adres'=>$request->guardian_adres,
                     'email'=>$request->guardian_email,
                     'telefon'=>$request->guardian_telefon,
                     'dogum_tarihi'=>$request->guardian_dogum_tarihi,
                     'cinsiyet'=>$request->guardian_cinsiyet,
                     'profil_foto'=>$request->guardian_profil_foto
                 ]);*/
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
    public function studentGuardianList($id){
       $user=User::where('id',$id)->first();
       if($user){
           return response()->json([
               'status'=>true,
               'user'=>$user
           ],200);
       }else{
           return  response()->json([
              'status'=>false,
              'message'=>"Öğrenci Bulunamadı"
           ],);
       }
    }
    public function studentGuardianUpdate(Request $request,$id){
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
                $data=studentinfo::where('user_id',$id)->update([
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
                student_guardian::where('user_id',$id)->update([
                    'tc_kimlik'=>$request->guardian_tc_kimlik,
                    'isim_soyisim'=>$request->guardian_name,
                    'adres'=>$request->guardian_adres,
                    'email'=>$request->guardian_email,
                    'telefon'=>$request->guardian_telefon,
                    'dogum_tarihi'=>$request->guardian_dogum_tarihi,
                    'cinsiyet'=>$request->guardian_cinsiyet,
                    'profil_foto'=>$request->guardian_profil_foto
                ]);
                if ($data){
                    return response()->json([
                        'status'=>true,
                        'message'=>'Öğrenci Güncelleme işlemi başarılı'
                    ],201);
                }else{
                    return response()->json([
                        'status'=>false,
                        'message'=>'Öğrenci Güncellenirken edilirken Sorun olustu'
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
    public function studentSelectClassList(){
        try {
            $student=studentinfo::get();
            $class=Classroom::get();
            $subject_root=subject_root::get();
            $data=array('class'=>$class,"subject_root"=>$subject_root,"student"=>$student);
            return response()->json([
               'status'=>true,
               'data'=>$data
            ],200);
        }catch (\exception $e){
          return  response()->json([
           'status'=>false,
           'message'=>$e->getMessage()
          ],400);

        }

    }
    public function studentSelectClassAdd(Request $request){
        try {
            $validator=Validator::make($request->all(),[
                'ogrenci_id'=>'required',
                'sinif_id'=>'required',
                'ders_secimi'=>'required'
            ]);
            if($validator->fails()){
                return  response()->json([
                   'status'=>false,
                   'message'=>$validator->errors()->all()
                ]);
            }else{
                $data=student_subject::create([
                    'ogrenci_id'=>$request->ogrenci_id,
                    'sinif_id'=>$request->sinif_id,
                    'ders_secimi_id'=>$request->ders_secimi,
                ]);
                if($data){
                    return response()->json([
                        'status'=>true,
                        'message'=>'ekleme işlemi başarılı'
                    ]);
                }else{
                    return  response()->json([
                        'status'=>false,
                        'message'=>'ekleme işlemi Başarısız'
                    ]);
                }
            }
        }catch (\Exception $e){
             return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
             ],400);
        }

    }
    public function studentSelectClassUpdate($id){
        $data=student_subject::where('ogrenci_id',$id)->get();
        if($data){
            return response()->json([
                'status'=>false,
                'data'=>$data
            ],200);
        }else{
            return  response()->json([
               'status'=>true,
               'message'=>'Seçilmiş ders bulunamadı'
            ]);
        }

    }
    public function studentPaymentAdd(Request $request,$id){
        try {
            $data=student_payment::create([
                'user_id'=>$id,
                'hangi_ay'=>$request->hangi_ay,
                'aylik_odeme'=>$request->aylik_odeme,
                'odenmis_tutar'=>$request->odenmis_tutar
            ]);
            if ($data){
                return  response()->json([
                   'status'=>false,
                    'message'=>'Ekleme işlemi başarılı'
                ],201);

            }else{
                return  response()->json([
                   'status'=>false,
                   'message'=>'Ekleme İşlemi başarısız '
                ],400);
            }
        } catch (\exception $e){
            return response()->json([
               'status'=>false,
               'message'=>$e->getMessage()
            ],400);

        }
    }
    public  function studentPaymentList($id){
        try {
            $data=student_payment::where('user_id',$id)->get();
             if ($data){
                 return  response()->json([
                     'status'=>true,
                     'data'=>$data
                 ],200);
             }else{
                 return  response()->json([
                      'status'=>false,
                     'message'=>'Listelenicek ödeme bulunamadı'
                 ],400);
             }
        }catch (\exception $e){
             return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
             ]);

        }



    }
    public function studentPaymentListDetais($id){
        try {
            $student=student_subject::where('ogrenci_id',$id)->get();
              foreach ($student as $item){
                  $data=$item->ders_secimi;
              }
            if($data){
                return  response()->json([
                   'status'=>true,
                   'data'=>$data
                ],200);
            }else{
                return  response()->json([
                   'status'=>false,
                    'message'=>'Seçilmiş ders bulunamadı'
                ]);
            }
        }catch (\exception $e){
           return response()->json([
              'status'=>false,
              'message'=>$e->getMessage()
           ],400);
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
