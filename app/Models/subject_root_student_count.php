<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subject_root_student_count extends Model
{
    use HasFactory;
    protected $table="subject_root_student_count";
    protected $guarded=[];
    protected $with=["ders_adi","ders_alan_ogrenciler"];



    public function ders_alan_ogrenciler(){
        return $this->hasMany(studentinfo::class,'id','ogrenci_id');
    }
    public function ders_adi(){
        return $this->hasMany(subject::class,'id','ders_id');
    }
}

