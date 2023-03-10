<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classroom_head_of_departman extends Model
{
    use HasFactory;
    protected $table='classroom_head_of_departman';
    protected $guarded=[];
    protected $with=["sinif","sorumluOgretmen"];

    public function sinif(){
        return $this->hasOne(Classroom::class,'id','sinif_id');
    }
    public function sorumluOgretmen(){
        return $this->hasOne(teacherinfo::class,'id','ogretmen_id');
    }
}
