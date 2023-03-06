<?php

namespace App\Http\Controllers\API\admin\API\admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\classroom_student;
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
    public function studentUpdateGet($id){
        try {
            $data=studentinfo::where('id',$id)->first();
             if ($data){
                 return response()->json([
                     'status'=>true,
                     'data'=>$data
                 ],200);
             }else{
                 return response()->json([
                     'status'=>false,
                     'message'=>'ogrenci Bulunamadı'
                 ],400);
             }
        }catch (\exception $e){
            return response()->json([
               'status'=>false,
               'message'=>$e->getMessage()
            ]);
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
    public function studentAdd(Request $request){
        try {
            $validator=Validator::make($request->all(),[
                'tc_kimlik'=>'required|unique:studentinfo',
                'adres'=>'required',
                'email'=>'required',
                'telefon'=>'required',
                'dogum_tarihi'=>'required',
                'cinsiyet'=>'required',
                'sube_id'=>'required',
                'sinif_id'=>'required'
            ]);
            if ($validator->fails()){
                 return response()->json([
                    'status'=>false,
                    'message'=>$validator->errors()->all()
                 ]);
            }else{
                if($request->file('profil_resim')){
                    $image=$request->file('profil_resim');
                    $ext=$image->extension();
                    $file=time().'.'.$ext;
                    $image->move('public/studentİmage',$file);
                }
                $random=rand(1,100);
                $yil=date('Y');
                $ogrenci_no=$yil.$random;
                $user=User::create([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=>Hash::make($ogrenci_no),
                    'Utype'=>'1'
                ],200);
                $user->syncRoles('ogrenci');
                $user_id=$user->id;
                $data=studentinfo::create([
                    'user_id'=>$user_id,
                    'tc_kimlik'=>$request->tc_kimlik,
                    'ogrenci_no'=>$ogrenci_no,
                    'isim_soyisim'=>$request->name,
                    'adres'=>$request->adres,
                    'email'=>$request->email,
                    'telefon'=>$request->telefon,
                    'dogum_tarihi'=>$request->dogum_tarihi,
                    'cinsiyet'=>$request->cinsiyet,
                    'profil_resim'=>$file,
                    'sube_id'=>$request->sube_id,
                    'sinif_id'=>$request->sinif_id,
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

    public function studentGuardianUpdate(Request $request,$id){
        try {
            $validator=Validator::make($request->all(),[
                'tc_kimlik'=>'required',
                'ogrenci_no'=>'required',
                'adres'=>'required',
                'email'=>'required',
                'telefon'=>'required',
                'dogum_tarihi'=>'required',
                'cinsiyet'=>'required',
                'sube_id'=>'required',
                'sinif_id'=>'required',
            ]);
            if ($validator->fails()){
                return response()->json([
                    'status'=>false,
                    'message'=>$validator->errors()->all()
                ],422);

            }else{
               /* $image_name = $request->profil_resim->getClientOriginalName();
                $upload_path = 'images/';
                $request->profil_resim->move($upload_path, $image_name);*/
                $data=studentinfo::where('id',$id)->update([
                    'tc_kimlik'=>$request->tc_kimlik,
                    'ogrenci_no'=>$request->ogrenci_no,
                    'isim_soyisim'=>$request->isim_soyisim  ,
                    'adres'=>$request->adres,
                    'email'=>$request->email,
                    'telefon'=>$request->telefon,
                    'dogum_tarihi'=>$request->dogum_tarihi,
                    'cinsiyet'=>$request->cinsiyet,
                    'profil_resim'=>$request->image,
                    'sube_id'=>$request->sube_id,
                    'sinif_id'=>$request->sinif_id,
                ],200);
              /*student_guardian::where('user_id',$id)->update([
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
            $sinif_id=$request->sinif_id;
            $sube_id=$request->sube_id;
            $ogrenci_no=$request->ogr_no;
            if ($sinif_id && $sube_id && $ogrenci_no){
                $ogrenci=studentinfo::where('ogrenci_no',$ogrenci_no)->first();
                if($ogrenci){
                    $ogr_id=$ogrenci->id;
                    $data=classroom_student::where('sinif_id',$sinif_id)->where('sube_id',$sube_id)->where('ogrenci_id',$ogr_id)->get();
                        foreach ($data as $ogr) {
                            if ($ogr->ogrenci_bilgisi) {
                                $ogrenciBilgisi[] = $ogr->ogrenci_bilgisi;
                                return response()->json([
                                    'status' => true,
                                    'data' => $ogrenciBilgisi
                                ], 200);
                            }
                        }
                    return response()->json([
                        'status'=>false,
                        'message'=>'Listelenicek ogrenci bulunamadı'
                    ]);
                }else{
                    return response()->json([
                        'status'=>false,
                        'message'=>'Listelenicek ogrenci bulunamadı'
                    ]);
                }

            }else  if ($sinif_id && $sube_id){
                $data=classroom_student::where('sinif_id',$sinif_id)->where('sube_id',$sube_id)->get();
                    foreach ($data as $ogr){
                            $ogrenciBilgisi[]=$ogr->ogrenci_bilgisi;
                    }
                    if (isset($ogrenciBilgisi)){
                        return response()->json([
                            'status'=>true,
                            'data'=>$ogrenciBilgisi
                        ],200);

                    }else{
                        return response()->json([
                            'status'=>false,
                            'message'=>'Listeleencek öğrenci bulunamadı'
                        ]);

                    }

            }else{
                return response()->json([
                    'status'=>false,
                     'message'=>'Lutfen sınıf ve sube seçiniz'
                ]);
            }
        }catch (\Exception $e){

            return response()->json([
                'status'=>false,
                'message' =>$e->getMessage()
            ]);
        }

    }

}
