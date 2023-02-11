<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassromController extends Controller
{
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
        $data=Classroom::all();
         if($data){
             return  response()->json([
                 'status'=>'true',
                'data'=>$data
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

    public function searchTerm($searchTerm){
        try {
            $data=Classroom::where('sinif_adi',$searchTerm)->first();
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

}
