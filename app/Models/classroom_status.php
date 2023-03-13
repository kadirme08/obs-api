<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classroom_status extends Model
{
    use HasFactory;
    protected $table='classroom_status';
    protected $guarded=[];
    protected $with=['sinif','sube'];

    public function sinif(){
        return $this->hasOne(Classroom::class,'id','sinif_id');
    }

    public function sube(){
        return $this->hasOne(classroom_branch::class,'id','sube_id');
    }
}
