<?php

namespace App\Http\Controllers\API\admin\API\admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\classroom_branch;
use App\Models\classroom_head_of_departman;
use App\Models\classroom_student;
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
                $data=Classroom::create([
                    'sinif_adi'=>$request->sinif_adi,
                    'sinif_sayisi'=>$request->sinif_sayisi,
                ]);
                if ($data){
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
        }catch (\exception $e){
            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ],400);

        }

    }
    public function classroomList(){
        $siniflar[]=classroom_student::get();
        $arr=array();
        foreach ($siniflar as $item) {
            foreach ($item as $value){
                if(isset($arr[$value->sinif->sinif_adi.$value->sube->sube])){
                    $ogretmen=classroom_head_of_departman::where('sinif_id',$value->sinif_id)->where('sube_id',$value->sube_id)->first();
                    $arr[$value->sinif->sinif_adi.$value->sube->sube]["sinif"]=$value->sinif->sinif_adi.$value->sube->sube;
                    $arr[$value->sinif->sinif_adi.$value->sube->sube]["count"]+=1;
                    $arr[$value->sinif->sinif_adi.$value->sube->sube]["ogretmen"]=$ogretmen->sorumluOgretmen->isim_soyisim;
                    $arr[$value->sinif->sinif_adi.$value->sube->sube]["students"][]=$value->ogrenci_bilgisi->isim_soyisim;

                }
                else{
                    $ogretmen=classroom_head_of_departman::where('sinif_id',$value->sinif_id)->where('sube_id',$value->sube_id)->first();
                    $arr[$value->sinif->sinif_adi.$value->sube->sube]["sinif"]=$value->sinif->sinif_adi.'/'.$value->sube->sube;
                    $arr[$value->sinif->sinif_adi.$value->sube->sube]["count"]=1;
                    $arr[$value->sinif->sinif_adi.$value->sube->sube]["ogretmen"]=$ogretmen->sorumluOgretmen->isim_soyisim;
                    $arr[$value->sinif->sinif_adi.$value->sube->sube]["students"][]=$value->ogrenci_bilgisi->isim_soyisim;

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
    public function changeStatus(Request $request,$id){
        try {
            $status=$request->status;
            if($status==0){
                $status=1;
                $data=Classroom::where('id',$id)->update([
                    'sinif_durum'=>$status
                ]);
                if ($data){
                    return response()->json([
                        'status'=>true,
                        'message'=>'Durum Güncelleme başarılı',
                        'data'=> $data
                    ],200);

                }else{
                    return response()->json([
                        'status'=>true,
                        'message'=>'Durum Güncellenirken hata olustu'
                    ],400);

                }


            }else{
                $status=0;
                $data=Classroom::where('id',$id)->update([
                    'sinif_durum'=>$status
                ]);
                if ($data){
                    return response()->json([
                        'status'=>true,
                        'message'=>'Durum Güncelleme başarılı',
                        'data'=>$data
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
                            $data[$dep->sinif->sinif_adi.$dep->sube->sube]['sinif']=$dep->sinif->sinif_adi.$dep->sube->sube;
                            $data[$dep->sinif->sinif_adi.$dep->sube->sube]['count']+=1;
                            $data[$dep->sinif->sinif_adi.$dep->sube->sube]['ogretmen']=$ogretmen->sorumluOgretmen->isim_soyisim;
                            $data[$dep->sinif->sinif_adi.$dep->sube->sube]['students'][]=$ogretmen->sorumluOgretmen->isim_soyisim;

                        }else{
                            $ogretmen=classroom_head_of_departman::where('sinif_id',$sinif_id)->where('sube_id',$sube_id)->first();
                            $data[$dep->sinif->sinif_adi.$dep->sube->sube]['sinif']=$dep->sinif->sinif_adi.'/'.$dep->sube->sube;
                            $data[$dep->sinif->sinif_adi.$dep->sube->sube]['count']=1;
                            $data[$dep->sinif->sinif_adi.$dep->sube->sube]['ogretmen']=$ogretmen->sorumluOgretmen->isim_soyisim;
                            $data[$dep->sinif->sinif_adi.$dep->sube->sube]['students'][]=$dep->ogrenci_bilgisi->isim_soyisim;
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
    public function classroomCount(){

    }

}
