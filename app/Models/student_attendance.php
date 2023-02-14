<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student_attendance extends Model
{
    use HasFactory;
    protected $table="student_attendance";
    protected $guarded=[];
    protected $with=["gelmeyen_ogrenci"];


    public function gelmeyen_ogrenci(){
        return $this->hasMany(User::class,'id','user_id');
    }
}
