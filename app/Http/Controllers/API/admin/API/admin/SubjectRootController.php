<?php

namespace App\Http\Controllers\API\admin\API\admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\subject;
use App\Models\subject_root;
use App\Models\teacherinfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectRootController extends Controller
{

    public function List(){
        try {
      $subject=subject::get();
      $classroom=Classroom::get();
      $teacher=teacherinfo::get();
      $data=array('subject'=>$subject
                  ,'classroom'=>$classroom,
                      'teacher'=>$teacher);
       return  response()->json([
          'status'=>false,
           'data'=>$data
       ],200);

        }catch (\exception $e){
        return response()->json([
           'status'=>false,
           'message'=>$e->getMessage()
        ],400);

        }


    }
    public function subjectRootAdd(Request $request){
        try {
            $validator=Validator::make($request->all(),[
               'sinif_id'=>'required',
               'ders_id'=>'required',
               'ogretmen_id'=>'required',
               'ders_saati'=>'required'
            ]);
            if ($validator->fails()){
                return  response()->json([
                   'status'=>false,
                   'message'=>$validator->errors()->all()
                ],422);
            }else{
                $data=subject_root::create([
                   'sinif_id'=>$request->sinif_id,
                   'ders_id'=>$request->ders_id,
                   'ogretmen_id'=>$request->ogretmen_id,
                   'ders_saati'=>$request->ders_saati
                ]);
                if($data){
                    return response()->json([
                       'status'=>true,
                       'message'=>'Ekleme İşlemi Başarılı'
                    ],201);
                }else{
                    return  response()->json([
                       'status'=>false,
                       'message'=>'Eklenirken bir sorun olustu'
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
    public function subjectRootUpdate(Request $request,$id){
        try {
            $validator=Validator::make($request->all(),[
                'sinif_id'=>'required',
                'ders_id'=>'required',
                'ogretmen_id'=>'required',
                'ders_saati'=>'required'
            ]);
            if ($validator->fails()){
                return  response()->json([
                    'status'=>false,
                    'message'=>$validator->errors()->all()
                ],422);
            }else{
                $data=subject_root::where('id',$id)->update([
                    'sinif_id'=>$request->sinif_id,
                    'ders_id'=>$request->ders_id,
                    'ogretmen_id'=>$request->ogretmen_id,
                    'ders_saati'=>$request->ders_saati
                ]);
                if($data){
                    return response()->json([
                        'status'=>true,
                        'message'=>'Ekleme İşlemi Başarılı'
                    ],201);
                }else{
                    return  response()->json([
                        'status'=>false,
                        'message'=>'Eklenirken bir sorun olustu'
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
    public function subjectRootDelete($id){
        try {
            subject_root::where('id',$id)->delete();
            return response()->json([
               'status'=>true,
               'message'=>'silme işlemi başarılı'
            ]);

        }catch (\exception $e){
             return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
             ],400);
        }
    }
    public function subjectRootList(){
        try {
            $data=subject_root::all();
            if ($data){
                return response()->json([
                   'status'=>false,
                   'data'=>$data
                ],200);
            }else{
                return response()->json([
                   'status'=>false,
                   'message'=>'listelenicek Program bulunamadı'
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
