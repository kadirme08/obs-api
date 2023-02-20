<?php

namespace App\Http\Controllers\API\akademik;

use App\Http\Controllers\Controller;
use App\Models\teacherinfo;
use App\Models\time_table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyTimeTableController extends Controller
{
    public function MytimeTableList(Request $request){
        try {
            $user_id=Auth::id();
            $ogretmen=teacherinfo::where('user_id',$user_id)->first();
            $ogretmen_id=$ogretmen->id;
            $data=time_table::where('ogretmen_id',$ogretmen_id)->get();
           if($data){
               return response()->json([
                  'status'=>false,
                  'data'=>$data
               ],200);
           }else{
               return  response()->json([
                  'status'=>true,
                  'message'=>'Ders programı bulunamadı'
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
