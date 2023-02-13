<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class time_table extends Model
{
    use HasFactory;

    protected $table="time_table";
    protected $guarded=[];
    protected $with=["ders","ogretmen","sinif"];


    public function ders(){
        return $this->hasOne(subject::class,'id','ders_id');
    }

    public function ogretmen(){
        return $this->hasOne(teacherinfo::class,'id','ogretmen_id');

    }

    public function sinif(){
        return $this->hasOne(Classroom::class,'id','sinif_id');
    }
}
