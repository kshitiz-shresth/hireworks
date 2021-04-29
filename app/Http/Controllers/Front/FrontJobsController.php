<?php

namespace App\Http\Controllers\Front;

use App\Helper\Reply;
use App\Http\Requests\FrontJobApplication;
use App\Job;
use App\JobApplication;
use App\JobApplicationAnswer;
use App\JobCategory;
use App\JobLocation;
use App\JobQuestion;
use App\Question;
Use App\CompanySetting;
use App\MultipleChoice;
use App\MultipleChoiceAnswer;
use App\Notifications\NewJobApplication;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Http;
use File;

class FrontJobsController extends FrontBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('modules.front.jobOpenings');
    }

    public function jobOpenings()
    {
        $this->jobs = Job::where('status','active')->get();
        $this->locations = JobLocation::all();
        $this->categories = JobCategory::all();
        return view('front.job-openings', $this->data);
    }

    public function jobByCompany($company_id)
    {
        $this->jobs = Job::where('company_id',$company_id)->where('status','active')->get();
        $this->locations = JobLocation::all();
        $this->categories = JobCategory::all();
        return view('front.job-openings', $this->data);
    }

    public function jobDetail($slug)
    {
        $this->job = Job::where('slug', $slug)->where('status', 'active')->firstOrFail();
        $this->company_name = CompanySetting::where('id',$this->job->company_id)->first()->company_name;
        $this->company_website = CompanySetting::where('id',$this->job->company_id)->first()->website;
        return view('front.job-detail', $this->data);
    }

    public function jobApply($id)
    {
        $this->job = Job::where('id', $id)->first();
        $this->jobQuestion = Question::where('job_id', $id)->orderBy('order_no','ASC')->get();
        $this->multipleQuestion = MultipleChoice::all();
        return view('front.job-apply', $this->data);
    }

     public function saveApplication(FrontJobApplication $request)
    {
        $jobApplication = new JobApplication();
        $jobApplication->full_name = $request->full_name;
        $jobApplication->job_id = $request->job_id;
        $jobApplication->status_id = 1; //applied status id
        $jobApplication->email = $request->email;
        $jobApplication->phone = $request->phone;
        $jobApplication->column_priority = 0;
        if ($request->hasFile('cover_letter')) {
            $jobApplication->cover_letter = $request->cover_letter->hashName();
            $request->cover_letter->store('user-uploads/cover-letters');

           // $filename = $request->cover_letter->hashName();

           // $client = new \GuzzleHttp\Client();
           // $body = fopen('user-uploads/cover-letters/' . $filename, 'r');
          // $response = $client->post(
          //     'https://rezscore.com/a/84027f/grade',
          //     [
          //         'multipart' => [
          //             [
          //                 'name' => 'cover_letter',
          //                 'contents' => fopen($_SERVER['DOCUMENT_ROOT'] . '/public/user-uploads/cover-letters/' . $filename, 'rb'),
          //                 'filename' => $filename,
          //             ]
          //         ],
          //         'headers' => [
          //             # Do not override the Content-Type header here, Guzzle takes care of it
          //         ],
          //     ]
          // );
        }
        if ($request->hasFile('resume')) {
            $jobApplication->resume = $request->resume->hashName();
            $request->resume->store('user-uploads/resumes');

           // $filename = $request->resume->hashName();

           // $client = new \GuzzleHttp\Client();
           // $body = fopen('user-uploads/resumes/'.$filename, 'r');
           // $response =$client->post(
           //     'https://rezscore.com/a/84027f/grade', [
           //         'multipart' => [
           //             [
           //                 'name' => 'resume',
           //                 'contents' => fopen($_SERVER['DOCUMENT_ROOT'].'/public/user-uploads/resumes/'.$filename, 'rb'),
           //                 'filename' => $filename,
           //             ]
           //         ],
           //         'headers' => [
           //             # Do not override the Content-Type header here, Guzzle takes care of it
           //         ] ,
           //     ]
           // );

        }

        // $s = $response->getBody()->getContents();



        if ($request->hasFile('photo')) {
            $jobApplication->photo = $request->photo->hashName();
            $request->photo->store('user-uploads/candidate-photos');
        }

        $jobApplication->rezscore = strval("");

        $jobApplication->save();


        $users = User::allAdmins();
        if (!empty($request->answer)) {
                foreach ($request->answer as $key => $value) {
                    $answer = new JobApplicationAnswer();
                    $answer->job_application_id = $jobApplication->id;
                    $answer->job_id = $request->job_id;
                    $answer->question_id = $key;
                    $answer->answer = $value;
                    $answer->save();
                }
            }

        //Notification::send($users, new NewJobApplication($jobApplication));

        return $jobApplication->id;
    }


    public function saveVideo()
    {

        $fileName = '';
        $tempName = '';
        $file_idx = '';

        if (!empty($_FILES['video-blob'])) {
             $file_idx = 'video-blob';
            $fileName = $_POST['video-filename'];
            $tempName = $_FILES[$file_idx]['tmp_name'];
            $filePath = 'user-uploads/video-answers/' . $fileName;
        }else{
             $file_idx = 'audio-blob';
            $fileName = $_POST['audio-filename'];
            $tempName = $_FILES[$file_idx]['tmp_name'];
            $filePath = 'user-uploads/audio-answers/' . $fileName;
        }



        move_uploaded_file($tempName, $filePath);

        return Reply::dataOnly(['status' => 'success', 'msg' => __('modules.front.applySuccessMsg')]);
    }

    public function saveMCQs(Request $request){
        $data = json_decode($request->getContent(), true);
        foreach($data as $r){
            $question_id = $r['question_id'];
            $answer_id = $r['answer_id'];

            $mcqs = new MultipleChoiceAnswer();
            $mcqs->job_application_id = $r['job_application_id'];;
            $mcqs->job_id = $r['job_id'];
            $mcqs->question_id=$question_id;
            $mcqs->answer_id = $answer_id;
            $mcqs->save();

            $answer = new JobApplicationAnswer();
            $answer->job_application_id = $r['job_application_id'];;
            $answer->job_id = $r['job_id'];
            $answer->question_id = $question_id;
            $answer->answer = $answer_id;
            $answer->save();
        }

        $answer = new JobApplicationAnswer();

        return "asd";

    }



}
