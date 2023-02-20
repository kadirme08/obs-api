<?php

namespace App\Http\Controllers\API\ogrenci;

use App\Http\Controllers\Controller;
use App\Models\student_subject;
use App\Models\studentinfo;
use App\Models\subject_root;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class studentSubjectListController extends Controller
{
    public function studentSubjectList(){
        try {
            $user_id=Auth::id();
            $ogrenci=studentinfo::where('user_id',$user_id)->first();
            $ogrenci_id=$ogrenci->id;
            $data=student_subject::where('ogrenci_id',$ogrenci_id)->get();
              foreach ($data as $ders){
                  foreach ($ders->ders_secimi as $item){
                           $dersler[]=$item->ders;
                  }
              }
             if ($data){
                 return  response()->json([
                    'status'=>true,
                    'data'=>$data,
                    'ogenci dersleri'=>$dersler
                 ]);
             }else{
                 return response()->json([
                    'status'=>true,
                    'message'=>"listelenicek Ders bulunamadı"
                 ]);
             }
            dd($data);

        }catch (\exception $e){
            return response()->json([
               'status'=>false,
               'message'=>$e->getMessage()
            ],400);
        }

    }
    public function studentTeacherList(){
        try {
            $user_id=Auth::id();
            $ogrenci=studentinfo::where('user_id',$user_id)->first();
            $ogrenci_id=$ogrenci->id;
            $data=student_subject::where('ogrenci_id',$ogrenci_id)->get();
            foreach ($data as $ders) {
                  foreach ($ders->ders_secimi as $item){
                       $ogretmen[]=$item->ogretmen;
                  }
               }
            if($data){
                return  response()->json([
                     'status'=>false,
                      'ogretmen'=>$ogretmen,

                ],200);
            }else{
                return response()->json([
                   'status'=>true,
                   'message'=>"Listelenicek ogretmen bulunamadı"
                ]);
            }

        }catch (\exception $e){
            return response()->json([
               'status'=>false,
               'message'=>$e->getMessage()
            ],400);
        }

    }
}
