<?php

namespace App\Http\Controllers\API\ogrenci;

use App\Http\Controllers\Controller;
use App\Models\student_attendance;
use App\Models\studentinfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class studentAttandanceController extends Controller
{
    public  function studentAttandanceList(){
        try {
            $user_id=Auth::id();
            $ogrenci=studentinfo::where('user_id',$user_id)->first();
            $ogrenci_id=$ogrenci->id;
            $devamsizlik=student_attendance::where('user_id',$ogrenci_id)->get();
           if($devamsizlik){
               return response()->json([
                  'status'=>true,
                  'data'=>$devamsizlik
               ],200);
           }else{
               return  response()->json([
                  'status'=>false,
                  'message'=>"listelenicek devasmizlik bulunamadı"
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
