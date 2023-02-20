<?php

namespace App\Http\Controllers\API\akademik;

use App\Http\Controllers\Controller;
use App\Models\teacher_attendance;
use App\Models\teacherinfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyAttandanceListControler extends Controller
{
    public function MyAttadanceList(){
        try{
            $user_id=Auth::id();
            $ogretmen=teacherinfo::where('user_id',$user_id)->first();
            $ogretmen_id=$ogretmen->id;
            $data=teacher_attendance::where('user_id',$ogretmen_id)->get();
            if($data){
                return  response()->json([
                    'status'=>true,
                    'data'=>$data
                ]);
            }else{
                return  response()->json([
                   'status'=>false,
                   'message'=>'listelenicek devamsızlık bulunamadı'
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
