<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teacher_attendance extends Model
{
    use HasFactory;
    protected $table="teacher_attendance";
    protected $guarded=[];
    protected $with=["ogretmen_devamsizlik"];


    public function ogretmen_devamsizlik(){
        return $this->hasMany(User::class,'id','user_id');
    }
}
