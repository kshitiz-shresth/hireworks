<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class JobApplication extends Model
{
    use Notifiable;

    public function job(){
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function status(){
        return $this->belongsTo(ApplicationStatus::class, 'status_id');
    }

    public function schedule(){
        return $this->hasOne(InterviewSchedule::class)->latest();
    }
}
