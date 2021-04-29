<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\JobApplication;
use App\JobApplicationAnswer;
use App\MultipleChoice;
use App\MultipleChoiceAnswer;
use App\User;
use App\TemporaryUser;

class TemporaryUserController extends Controller
{
    /**
     * @var array
     */
    public $data = [];

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->data[$name];
    }

    public function  index(Request $request){
        $user = TemporaryUser::where('email',$request->email)->where('password',$request->password)->first();
        if($user)
        {
            if(strtotime(now())<=strtotime($user->expiry_date)){
                // return JobApplication::find($user->applicantID);
                $id = $user->applicantID;
                $this->user = $user;
                $this->application = JobApplication::with(['schedule', 'status', 'schedule.employee', 'schedule.comments.user'])->find($id);

                $this->answers = JobApplicationAnswer::with(['question'])
                ->where('job_id', $this->application->job_id)
                ->where('job_application_id', $this->application->id)
                ->get();

                $this->mcqs = MultipleChoiceAnswer::all();
                $this->mcq_q = MultipleChoice::all();
                return view('temp-user.applicant-details', $this->data);
            }
            return redirect()->back()->withErrors(['Your email is expired on '.$user->expiry_date]);
        }
        else{
            return redirect()->back()->withErrors(['No User Found']);
        }
    }

    public function getIndex(){
       return abort('404');  
    }
}
