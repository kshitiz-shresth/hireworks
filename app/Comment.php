<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id','job_application_id','comment'];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function jobApplication(){
        return $this->belongsTo(JobApplication::class,'job_application_id');
    }
}
