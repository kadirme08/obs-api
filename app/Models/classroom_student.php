<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classroom_student extends Model
{
    use HasFactory;
    protected $table="classroom_student";
    protected $guarded=[];
    protected $with=["ogrenci_bilgisi"];
    public function ogrenci_bilgisi(){
        return $this->hasOne(studentinfo::class,'id','ogrenci_id');
    }

    /*
     *
        foreach ($siniflar as $item) {
            foreach ($item as $value){
                if(isset($arr[$value->sinif->sinif_adi.$value->sube->sube])){
                    $arr[$value->sinif->sinif_adi.$value->sube->sube]+=1;
                }
                else{
                    $arr[$value->sinif->sinif_adi.$value->sube->sube]=1;
                }
            }
        }
     */
}
