<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssessmentQuestion extends Model
{
    protected $guarded = ['id','created_at','updated_at'];
    public function multiple_choices(){
        return $this->hasMany(AssessmentMultipleChoice::class,'question_id');
    }
}