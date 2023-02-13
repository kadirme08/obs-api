<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subject_root extends Model
{
    use HasFactory;
    protected $table="subject_root";
    protected $guarded=[];
    protected $with=["sinif","ders","ogretmen"];

    public function sinif(){
        return $this->hasMany(Classroom::class,'id','sinif_id');
    }
    public function ders(){
        return $this->hasOne(subject::class,'id','ders_id');
    }
    public function ogretmen(){
        return $this->hasOne(teacherinfo::class,'id','ogretmen_id');
    }

}


