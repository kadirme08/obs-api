<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class time_table extends Model
{
    use HasFactory;

    protected $table="time_table";
    protected $guarded=[];
    protected $with=["ders","ogretmen","sinif","gun"];


    public function ders(){
        return $this->hasMany(subject::class,'id','ders_id');
    }

    public function ogretmen(){
        return $this->hasMany(teacherinfo::class,'id','ogretmen_id');

    }

    public function sinif(){
        return $this->hasMany(classroom_status::class,'id','sinif_id');
    }
    public function gun(){
        return $this->hasMany(days::class,'id','gun_id');

    }

}
