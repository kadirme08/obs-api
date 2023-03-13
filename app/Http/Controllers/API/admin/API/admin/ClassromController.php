<?php

namespace App\Http\Controllers\API\admin\API\admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\classroom_branch;
use App\Models\classroom_head_of_departman;
use App\Models\classroom_status;
use App\Models\classroom_student;
use App\Models\classroom_subject;
use App\Models\subject;
use App\Models\time_table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassromController extends Controller
{
    public function classroomBranch(Request $request){
        try {
            $data=classroom_branch::all();
            if($data){
                return  response()->json([
                    'status'=>true,
                    'data'=>$data
                ],200);
            }else{
                return response()->json([
                    'status'=>false,
                    'Message'=>'Sube Listesi Boş '

                ],400);
            }

        }catch (\exception $e){
            return  response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ],400);

        }



    }
    public  function classroomAdd(Request $request){
        try {
             $sinif_adi=$request->sinif_adi;
             $sube_adi=$request->sube_adi;
             $ogretmen_id=$request->ogretmen_id;
             $validator=Validator::make($request->all(),[
                'sinif_adi'=>'required',
                'sube_adi'=>'required',
                'ogretmen_id'=>'required'
            ]);
            if($validator->fails()){
                return  response()->json([
                    'status'=>false,
                    'message'=>$validator->errors()->all(),
                ]);
            }else{
                $sinif_true=Classroom::where('sinif_adi',$sinif_adi)->first();
                $sube_true=classroom_branch::where('sube',$sube_adi)->first();
                if($sinif_true){
                    $sinif_id=$sinif_true->id;
                }else{
                    $sinif_2=Classroom::create([
                        'sinif_adi'=> $sinif_adi
                    ]);
                    $sinif_id=$sinif_2->id;
                }if($sube_true){
                    $sube_id=$sube_true->id;
                }else{
                    $sube=classroom_branch::create([
                        'sube'=> $sube_adi
                    ]);
                    $sube_id=$sube->id;
                }
                $sinif=classroom_status::where('sinif_id',$sinif_id)->where('sube_id',$sube_id)->first();
                $ogretmen=classroom_head_of_departman::where('ogretmen_id',$ogretmen_id)->first();
                if($ogretmen && $sinif){
                    return  response()->json([
                        'status'=>false,
                        'message'=>'Öğretmen Ve sınıf zaten kayıtlı Lütfen Farklı Bir sınıf ve öğretmen seçiniz..'
                    ]);
                }
                elseif ($sinif){
                    return  response()->json([
                        'status'=>false,
                        'message'=>'Böyle Bir sınıf zaten mevcut..'
                    ]);
                }elseif($ogretmen){
                    return  response()->json([
                        'status'=>false,
                        'message'=>'Böyle Bir Öğretmen Başka bir Sınıfın Başkanı Lütfen farklı Öğretmen seçiniz'
                    ]);
                }else{
                    $data=classroom_status::create([
                        'sinif_id'=>$sinif_id,
                        'sube_id'=> $sube_id,
                    ]);
                    $data2=classroom_head_of_departman::create([
                        'sinif_id'=>$sinif_id,
                        'sube_id'=>$sube_id,
                        'ogretmen_id'=> $ogretmen_id
                    ]);
                    if ($data && $data2){
                        return response()->json([
                            'status'=>true,
                            'message'=>'Sınıf Ekleme İşlemi başarılı',
                        ],201);
                    }else{
                        return response()->json([
                            'status'=>false,
                            'message'=>'sınıf Eklenirken Bir hata olustu'
                        ],400);
                    }
                }
             }
        }catch (\exception $e){
            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ],400);

        }

    }
    public function classroomList(){
        $siniflar[]=classroom_status::get();
        $arr=array();
        foreach ($siniflar as $item) {
            foreach ($item as $value){
                if(isset($arr[$value->sinif->sinif_adi.$value->sube->sube])){
                    $ogretmen=classroom_head_of_departman::where('sinif_id',$value->sinif_id)->where('sube_id',$value->sube_id)->first();
                    $ogrenci_bilgisi=classroom_student::where('sinif_id',$value->id)->get();
                    foreach ($ogrenci_bilgisi as $ogrenci){
                        $arr[$value->sinif->sinif_adi.$value->sube->sube]["students"][]=$ogrenci->ogrenci_bilgisi->isim_soyisim;
                        $arr[$value->sinif->sinif_adi.$value->sube->sube]['ogrenci_No'][]=$ogrenci->ogrenci_bilgisi->ogrenci_no;
                        $arr[$value->sinif->sinif_adi.$value->sube->sube]["count"]+=1;
                    }
                    $arr[$value->sinif->sinif_adi.$value->sube->sube]["sinif"]=$value->sinif->sinif_adi.'/'.$value->sube->sube;
                    $arr[$value->sinif->sinif_adi.$value->sube->sube]["ogretmen"]=$ogretmen->sorumluOgretmen->isim_soyisim;
                    $arr[$value->sinif->sinif_adi.$value->sube->sube]["students"][]=$value->ogrenci_bilgisi->isim_soyisim;
                    $arr[$value->sinif->sinif_adi.$value->sube->sube]['ogrenci_No'][]=$value->ogrenci_bilgisi->ogrenci_no;
                    $arr[$value->sinif->sinif_adi.$value->sube->sube]['sinif_status_id']=$value->id;
                }
                else{
                    $ogretmen=classroom_head_of_departman::where('sinif_id',$value->sinif_id)->where('sube_id',$value->sube_id)->first();
                    $ogrenci_bilgisi=classroom_student::where('sinif_id',$value->id)->get();
                     foreach ($ogrenci_bilgisi as $ogrenci){
                         $arr[$value->sinif->sinif_adi.$value->sube->sube]["students"][]=$ogrenci->ogrenci_bilgisi->isim_soyisim;
                         $arr[$value->sinif->sinif_adi.$value->sube->sube]['ogrenci_No'][]=$ogrenci->ogrenci_bilgisi->ogrenci_no;
                     }
                    $arr[$value->sinif->sinif_adi.$value->sube->sube]["count"]=1;
                    $arr[$value->sinif->sinif_adi.$value->sube->sube]["sinif_status_id"]=$value->id;
                    $arr[$value->sinif->sinif_adi.$value->sube->sube]["sinif"]=$value->sinif->sinif_adi.'/'.$value->sube->sube;
                    $arr[$value->sinif->sinif_adi.$value->sube->sube]["ogretmen"]=$ogretmen->sorumluOgretmen->isim_soyisim;
                    $arr[$value->sinif->sinif_adi.$value->sube->sube]["status"]=$value->status;
                    $arr[$value->sinif->sinif_adi.$value->sube->sube]["sinif_id"]=$value->sinif_id;
                    $arr[$value->sinif->sinif_adi.$value->sube->sube]["sube_id"]=$value->sube_id;
                }
            }
        }
        if($arr){
            return  response()->json([
                'status'=>true,
                'data'=>$arr
            ],200);
        }else{
            return response()->json([
                'status'=>false,
                'Message'=>'Sınıf Listesi Boş '

            ],400);
        }
    }
    public function classroomList2(){
        try {
            $data=Classroom::get();
            if($data){
                return response()->json([
                    'status'=>true,
                    'data'=>$data
                ]);
            }
        }catch (\exception $e){
            return response()->json([
               'status'=>false,
               'message'=>$e->getMessage()
            ],400);
        }
    }
    public function classroomUpdate(Request $request , $id){
        try {

            $validator=Validator::make($request->all(),[
                'sinif_adi'=>'required',
                'sinif_sayisi'=>'required',
            ]);
            if($validator->fails()){
                return  response()->json([
                    'status'=>false,
                    'message'=>$validator->errors()->all(),
                ],422);
            }else{
                if($id){
                    $data=Classroom::where('id',$id)->update([
                        'sinif_adi'=>$request->sinif_adi,
                        'sinif_sayisi'=>$request->sinif_sayisi,
                    ]);
                    if ($data){
                        return response()->json([
                            'status'=>true,
                            'message'=>'Sınıf Güncelleme İşlemi başarılı',
                            'data'=>$data
                        ],200);
                    }else{

                        return response()->json([
                            'status'=>false,
                            'message'=>'sınıf Düzenlerken Bir hata olustu'
                        ],400);
                    }
                }else{
                    return  response()->json([
                        'status'=>'false',
                        'message'=>"gelen id değeri yok"
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
    public function classroomDelete($id){
        try {
            if ($id){
                $data=Classroom::where('id',$id)->delete();
                if($data){
                    return response()->json([
                        'status'=>false,
                        'Message'=>'Silme İşlemi Başarılı'
                    ],200);
                }else{
                    return  response()->json([
                        'status'=>true,
                        'message'=>'Silme İşlemi yapılırken hata olustu'
                    ]);
                }
            }else{
                return  response()->json([
                    'status'=>false,
                    'message'=>'Gelen İd değeri Yok Lütfen id Değeri Giriniz'
                ]);
            }

        }catch (\exception  $e){
            return response()->json([
                'status'=>true,
                'message'=>$e->getMessage()
            ],400);

        }

    }
    public function changeStatus(Request $request){
        try {
            $sinif_id=$request->sinif_id;
            $sube_id=$request->sube_id;
            $status=$request->status;
            if($status==0){
                $status=1;
                $data=classroom_status::where('sinif_id',$sinif_id)->where('sube_id',$sube_id)->update([
                    'status'=>$status
                ]);
                $siniflar[]=classroom_status::get();
                $arr=array();

                foreach ($siniflar as $item) {
                    foreach ($item as $value){
                        if(isset($arr[$value->sinif->sinif_adi.$value->sube->sube])){
                            $ogretmen=classroom_head_of_departman::where('sinif_id',$value->sinif_id)->where('sube_id',$value->sube_id)->first();
                            $ogrenci_bilgisi=classroom_student::where('sinif_id',$value->id)->get();
                            foreach ($ogrenci_bilgisi as $ogrenci){
                                $arr[$value->sinif->sinif_adi.$value->sube->sube]["students"][]=$ogrenci->ogrenci_bilgisi->isim_soyisim;
                                $arr[$value->sinif->sinif_adi.$value->sube->sube]['ogrenci_No'][]=$ogrenci->ogrenci_bilgisi->ogrenci_no;
                                $arr[$value->sinif->sinif_adi.$value->sube->sube]["count"]+=1;
                            }
                            $arr[$value->sinif->sinif_adi.$value->sube->sube]["sinif"]=$value->sinif->sinif_adi.'/'.$value->sube->sube;
                            $arr[$value->sinif->sinif_adi.$value->sube->sube]["ogretmen"]=$ogretmen->sorumluOgretmen->isim_soyisim;
                            $arr[$value->sinif->sinif_adi.$value->sube->sube]["students"][]=$value->ogrenci_bilgisi->isim_soyisim;
                            $arr[$value->sinif->sinif_adi.$value->sube->sube]['ogrenci_No'][]=$value->ogrenci_bilgisi->ogrenci_no;
                            $arr[$value->sinif->sinif_adi.$value->sube->sube]['sinif_status_id']=$value->id;
                        }
                        else{
                            $ogretmen=classroom_head_of_departman::where('sinif_id',$value->sinif_id)->where('sube_id',$value->sube_id)->first();
                            $ogrenci_bilgisi=classroom_student::where('sinif_id',$value->id)->get();
                            foreach ($ogrenci_bilgisi as $ogrenci){
                                $arr[$value->sinif->sinif_adi.$value->sube->sube]["students"][]=$ogrenci->ogrenci_bilgisi->isim_soyisim;
                                $arr[$value->sinif->sinif_adi.$value->sube->sube]['ogrenci_No'][]=$ogrenci->ogrenci_bilgisi->ogrenci_no;
                            }
                            $arr[$value->sinif->sinif_adi.$value->sube->sube]["count"]=1;
                            $arr[$value->sinif->sinif_adi.$value->sube->sube]["sinif_status_id"]=$value->id;
                            $arr[$value->sinif->sinif_adi.$value->sube->sube]["sinif"]=$value->sinif->sinif_adi.'/'.$value->sube->sube;
                            $arr[$value->sinif->sinif_adi.$value->sube->sube]["ogretmen"]=$ogretmen->sorumluOgretmen->isim_soyisim;
                            $arr[$value->sinif->sinif_adi.$value->sube->sube]["status"]=$value->status;
                            $arr[$value->sinif->sinif_adi.$value->sube->sube]["sinif_id"]=$value->sinif_id;
                            $arr[$value->sinif->sinif_adi.$value->sube->sube]["sube_id"]=$value->sube_id;
                        }
                    }
                }

                if ($arr){
                    return response()->json([
                        'status'=>true,
                        'message'=>'Durum Güncelleme başarılı',
                        'data'=> $arr
                    ],200);

                }else{
                    return response()->json([
                        'status'=>true,
                        'message'=>'Durum Güncellenirken hata olustu'
                    ],400);

                }
            }else{
                $status=0;
                $data=classroom_status::where('sinif_id',$sinif_id)->where('sube_id',$sube_id)->update([
                    'status'=>$status
                    ]);
                $siniflar[]=classroom_status::get();
                $arr=array();
                foreach ($siniflar as $item) {
                    foreach ($item as $value){
                        if(isset($arr[$value->sinif->sinif_adi.$value->sube->sube])){
                            $ogretmen=classroom_head_of_departman::where('sinif_id',$value->sinif_id)->where('sube_id',$value->sube_id)->first();
                            $ogrenci_bilgisi=classroom_student::where('sinif_id',$value->id)->get();
                            foreach ($ogrenci_bilgisi as $ogrenci){
                                $arr[$value->sinif->sinif_adi.$value->sube->sube]["students"][]=$ogrenci->ogrenci_bilgisi->isim_soyisim;
                                $arr[$value->sinif->sinif_adi.$value->sube->sube]['ogrenci_No'][]=$ogrenci->ogrenci_bilgisi->ogrenci_no;
                                $arr[$value->sinif->sinif_adi.$value->sube->sube]["count"]+=1;
                            }
                            $arr[$value->sinif->sinif_adi.$value->sube->sube]["sinif"]=$value->sinif->sinif_adi.'/'.$value->sube->sube;
                            $arr[$value->sinif->sinif_adi.$value->sube->sube]["ogretmen"]=$ogretmen->sorumluOgretmen->isim_soyisim;
                            $arr[$value->sinif->sinif_adi.$value->sube->sube]["students"][]=$value->ogrenci_bilgisi->isim_soyisim;
                            $arr[$value->sinif->sinif_adi.$value->sube->sube]['ogrenci_No'][]=$value->ogrenci_bilgisi->ogrenci_no;
                            $arr[$value->sinif->sinif_adi.$value->sube->sube]['sinif_status_id']=$value->id;
                        }
                        else{
                            $ogretmen=classroom_head_of_departman::where('sinif_id',$value->sinif_id)->where('sube_id',$value->sube_id)->first();
                            $ogrenci_bilgisi=classroom_student::where('sinif_id',$value->id)->get();
                            foreach ($ogrenci_bilgisi as $ogrenci){
                                $arr[$value->sinif->sinif_adi.$value->sube->sube]["students"][]=$ogrenci->ogrenci_bilgisi->isim_soyisim;
                                $arr[$value->sinif->sinif_adi.$value->sube->sube]['ogrenci_No'][]=$ogrenci->ogrenci_bilgisi->ogrenci_no;
                            }
                            $arr[$value->sinif->sinif_adi.$value->sube->sube]["count"]=1;
                            $arr[$value->sinif->sinif_adi.$value->sube->sube]["sinif_status_id"]=$value->id;
                            $arr[$value->sinif->sinif_adi.$value->sube->sube]["sinif"]=$value->sinif->sinif_adi.'/'.$value->sube->sube;
                            $arr[$value->sinif->sinif_adi.$value->sube->sube]["ogretmen"]=$ogretmen->sorumluOgretmen->isim_soyisim;
                            $arr[$value->sinif->sinif_adi.$value->sube->sube]["status"]=$value->status;
                            $arr[$value->sinif->sinif_adi.$value->sube->sube]["sinif_id"]=$value->sinif_id;
                            $arr[$value->sinif->sinif_adi.$value->sube->sube]["sube_id"]=$value->sube_id;
                        }
                    }
                }
                if ($arr){
                    return response()->json([
                        'status'=>true,
                        'message'=>'Durum Güncelleme başarılı',
                        'data'=>$arr
                    ],200);

                }else{
                    return response()->json([
                        'status'=>true,
                        'message'=>'Durum Güncellenirken hata olustu'
                    ],400);
                }
            }
        }catch (\Exception $e){
            return response()->json([
                'status'=>false,
                'Message'=>$e->getMessage()
            ],400);
        }
    }
    public function searchTerm(Request $request){
         $departman_name=$request->departman_name;
         $sube=$request->sube;
        try {
            if($departman_name && $sube){
                 $sinif=Classroom::where('sinif_adi',$departman_name)->first();
                 $subeler=classroom_branch::where('sube',$sube)->first();
                $data=array();
                if($sinif && $subeler){
                    $sinif_id=$sinif->id;
                    $sube_id=$subeler->id;
                    $departman=classroom_student::where('sinif_id',$sinif_id)->where('sube_id',$sube_id)->get();
                    foreach ($departman as $dep){
                        if(isset( $data[$dep->sinif->sinif_adi.$dep->sube->sube])){
                            $ogretmen=classroom_head_of_departman::where('sinif_id',$sinif_id)->where('sube_id',$sube_id)->first();
                            $data[$dep->sinif->sinif_adi.$dep->sube->sube]['sinif']=$dep->sinif->sinif_adi.'/'.$dep->sube->sube;
                            $data[$dep->sinif->sinif_adi.$dep->sube->sube]['count']+=1;
                            $data[$dep->sinif->sinif_adi.$dep->sube->sube]['ogretmen']=$ogretmen->sorumluOgretmen->isim_soyisim;
                            $data[$dep->sinif->sinif_adi.$dep->sube->sube]['students'][]=$ogretmen->sorumluOgretmen->isim_soyisim;
                            $data[$dep->sinif->sinif_adi.$dep->sube->sube]['Ogrenci_No'][]=$dep->ogrenci_bilgisi->ogrenci_no;


                        }else{
                            $ogretmen=classroom_head_of_departman::where('sinif_id',$sinif_id)->where('sube_id',$sube_id)->first();
                            $data[$dep->sinif->sinif_adi.$dep->sube->sube]['sinif']=$dep->sinif->sinif_adi.'/'.$dep->sube->sube;
                            $data[$dep->sinif->sinif_adi.$dep->sube->sube]['count']=1;
                            $data[$dep->sinif->sinif_adi.$dep->sube->sube]['ogretmen']=$ogretmen->sorumluOgretmen->isim_soyisim;
                            $data[$dep->sinif->sinif_adi.$dep->sube->sube]['students'][]=$dep->ogrenci_bilgisi->isim_soyisim;
                            $data[$dep->sinif->sinif_adi.$dep->sube->sube]['Ogrenci_No'][]=$dep->ogrenci_bilgisi->ogrenci_no;

                        }
                    }
                }else{
                    return response()->json([
                       'status'=>false,
                       'message'=>'Bu isimle aradığınız Sınıf Bulunamadı'
                    ]);
                }

            }
            if ($data){
                return response()->json([
                    'status'=>true,
                    'data'=>$data
                ],200);
            }else{
                return  response()->json([
                    'status'=>false,
                    'message'=>"Bu isimle aradığınız Sınıf Bulunamadı"
                ],400);
            }
        }catch (\Exception $e){
            return  response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ],400);
        }




    }
    public function getClassroomDetais($id){
         $data=classroom_status::where('id',$id)->first();
         $sinif_id=$data->id;
         $sinif_adi=$data->sinif_id;
         $sube_adi=$data->sube_id;
          $sinif=Classroom::where('id',$sinif_adi)->first();
          $sube=classroom_branch::where('id',$sube_adi)->first();
         $student=classroom_student::where('sinif_id',$sinif_id)->get();
         $ders=classroom_subject::where('sinif_id',$sinif_id)->get();
         $ders_programi=time_table::where('sinif_id',$id)->get();
         $ogrenciler=array();
        foreach ($student as $item){
               $ogrenciler[$sinif->sinif_adi.$sube->sube]['ogrenciler'][]=$item->ogrenci_bilgisi->isim_soyisim;
           }
        foreach ($ders as $value){
             foreach ($value->ders as $item2){
                 $ogrenciler[$sinif->sinif_adi.$sube->sube]['sinif_dersleri'][]=$item2->ders_adi;
             }

            $ogrenciler[$sinif->sinif_adi.$sube->sube]['ogretmen'][]=$value->ogretmen;
        }

          return response()->json([
             'data'=>$ogrenciler
          ]);
    }


}
