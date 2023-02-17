<?php

namespace App\Http\Controllers\API\akademik;

use App\Http\Controllers\Controller;
use App\Models\studentinfo;
use App\Models\subject_root;
use App\Models\subject_root_student_count;
use App\Models\teacherinfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MystudentController extends Controller
{
    public function mySubjecList(){
        try {
             $user_id=Auth::id();
             $ogretmen=teacherinfo::where('user_id',$user_id)->first();
             $ogretmen_id=$ogretmen->id;
             $data=subject_root::where('ogretmen_id',$ogretmen_id)->with('ders')->get();
             $dersler=array();
              foreach ($data as $item){
                   $dersler[]=$item->ders;
              }
            if ($data){
                return  response()->json([
                   'status'=>true,
                   'ogretmen_dersleri'=>$dersler,
                    'data'=>$data
                ],200);
            }else{
                return response()->json([
                   'message'=>"Ögretmenin kayıtlı dersi bulunamadı"
                ]);
            }

        }catch (\exception $e){
            return response()->json([
               'status'=>"false",
               'message'=>$e->getMessage()
            ],400);

        }
    }
    public function myStudentList(){
        try {
            /*
            $ogretmen=teacherinfo::where('user_id',$user_id)->first();
            $ogretmen_id=$ogretmen->id;
            $ders=subject_root::where('ogretmen_id',$ogretmen_id)->get();
            $ogrenci_sayisi=array();
              foreach ($ders as $item){
                  $ogrenci_sayisi[]=subject_root_student_count::where('ders_id',$item->ders_id)->get();
              }
              /*
              foreach ($ogrenci_sayisi as $key =>$value)
                  foreach (json_decode($value->ders_alan_ogrenciler,1) as $item)
                       $return[]=$item;*/
            $user_id=Auth::id();
            $ogrenci = DB::table('teacherinfo')
                ->join('subject_root', 'teacherinfo.id', '=', 'subject_root.ogretmen_id')
                ->join('subject_root_student_count', 'subject_root.ders_id', '=', 'subject_root_student_count.ders_id')
                //->select('users.*', 'contacts.phone', 'orders.price')where
                    ->where('teacherinfo.user_id',$user_id)
                ->get();
            $id=array();
                foreach ($ogrenci as $key){
                     $id[]=$key->ogrenci_id;
                     $student[]=studentinfo::where('id',$id)->get();
                }
                if ($ogrenci){
                    return  response()->json([
                        'status'=>'true',
                        'ogretmen'=>$ogrenci,
                        'ogrenci bilgileri'=>$student,
                        'ogreci sayisi'=>count($id)

                    ],200);
                }else{
                    return  response()->json([
                       'status'=>false,
                       'message'=>"Listelenicek öğrenci bulunamadı"
                    ]);
                }

        }catch (\exception $e){
            return response()->json([
               'status'=>false,
               'message'=>$e->getMessage()
            ]);
        }

    }
    public function searchSubjectList(Request $request){
        try {
            $ders_id=$request->ders_id;
            if ($ders_id){
                $user=Auth::id();
                $ders=subject_root_student_count::where('ders_id',$ders_id)->get();
                if ($ders){
                    return  response()->json([
                        'status'=>true,
                        'data'=>$ders,

                    ],200);
                }else{
                    return  response()->json([
                       'status'=> false,
                        'message'=>"ders bulunamadı"
                    ]);
                }

            }else{
                return  response()->json([
                    'status'=> false,
                    'message'=>"Ders id Yok"
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
