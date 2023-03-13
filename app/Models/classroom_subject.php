<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classroom_subject extends Model
{
    use HasFactory;
    protected $table='classroom_subject';
    protected $guarded=[];
    protected $with=["sinif","ders","ogretmen"];

    public function sinif(){
        return $this->hasOne(classroom_status::class,'id','sinif_id');
    }
    public function ders(){
        return $this->hasMany(subject::class,'id','ders_id');
    }
    public function ogretmen(){
        return $this->hasMany(teacherinfo::class,'id','ogretmen_id');
    }
}
