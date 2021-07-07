<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $guarded = ['id','created_at','updated_at'];

    public function questions(){
        return $this->hasMany(AssessmentQuestion::class,'assessment_id');
    }
}