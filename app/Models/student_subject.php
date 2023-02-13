<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student_subject extends Model
{
    use HasFactory;

    protected $table="student_subject";
    protected $guarded=[];
    protected $with=["ogrenci","sinif","ders_secimi"];

    public function ogrenci(){
        return $this->hasOne(studentinfo::class,'id','ogrenci_id');

    }
    public function sinif(){
        return $this->hasOne(Classroom::class,'id','sinif_id');
    }
    public function ders_secimi(){
        return $this->hasMany(subject_root::class,'id','ders_secimi_id');
    }
}
