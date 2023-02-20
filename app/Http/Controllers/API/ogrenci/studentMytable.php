<?php

namespace App\Http\Controllers\API\ogrenci;

use App\Http\Controllers\Controller;
use App\Models\student_subject;
use App\Models\studentinfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class studentMytable extends Controller
{
    public function myTableList(){
        try {
            $user_id=Auth::id();
            $ogrenci=studentinfo::where('user_id',$user_id)->first();
            $ogrenci_id=$ogrenci->id;
             $subject=student_subject::where('ogrenci_id',$ogrenci_id)->get();
               foreach ($subject as $ders){
                    foreach ($ders->ders_secimi as $item){
                        $sinif[]=$item->sinif;
                        $ogretmen[]=$item->ogretmen;
                        $dersler[]=$item->ders;
                    }
               }
            return response()->json([
                'sinif'=>$sinif,
                'ogretmen'=>$ogretmen,
                'ders'=>$dersler

                ]);

        }catch (\exception $e){
        return response()->json([
           'status'=>false,
           'message'=>$e->getMessage()
        ],400);
        }

    }

}
