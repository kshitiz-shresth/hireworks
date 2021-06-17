<?php

namespace App\Http\Controllers\Admin;

use App\InterviewSchedule;
use App\User;
use App\Job;
use App\JobApplication;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Company;
use App\CompanySetting;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use DateTime;

class AdminDashboardController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageIcon = 'icon-speedometer';
        $this->pageTitle = "Home";
    }

    public function library(){
        return view('admin.assessments.library',$this->data);
    }

    private function isFuture($date){
        if(strtotime(now())<=strtotime($date)){
            return 1;
        }
        return 0;
    }

    public function index(){
        if($this->user->email=="super@super.com"){
            return redirect('admin/assessments');
        }

        // if($this->user->package!='free'){
        //     $allPlans = Stripe::invoices()->all(array("customer" => $this->customerId));
        //     // if first time registration
        //     if(isset($allPlans['data']) && !$allPlans['data'])
        //     {
        //         $amountDue = Stripe::plans()->find($this->user->package)['amount'];
        //         return view('admin.dashboard.pay',compact(
        //             'amountDue'
        //         ));
        //     }
        //     if((isset($allPlans['data'][0]['paid']) && !$allPlans['data'][0]['paid'])){
        //         $amountDue = $allPlans['data'][0]['amount_remaining'];
        //         return view('admin.dashboard.pay',compact(
        //             'amountDue'
        //         ));
        //     }

        //     $this->expiryDate = date('Y-m-d',Stripe::invoices()->upcomingInvoice($this->customerId)['period_end']);

        //     $this->subscription = Stripe::customers()->find($this->customerId)['subscriptions']['data'][0];
        //     // $subscription = Stripe::subscriptions()->update($this->customerId, $this->subscription['id'], [
        //     //     'plan' => 'premium',
        //     // ]);

        //      $this->invoices =  Stripe::invoices()->upcomingInvoice($this->customerId)['lines']['data'];
        //      $this->amountPaid = $allPlans['data'][0]['amount_paid'];
        // }

        // $client = new Client();
        // $res = $client->request('GET', config('laraupdater.update_baseurl').'/laraupdater.json');
        // $lastVersion = $res->getBody();
        // $lastVersion = json_decode($lastVersion, true);
        $this->company_id = $this->user->company_id;
        $this->first_time_login = CompanySetting::where('id', $this->user->company_id)->first()->first_time_login;

        if($this->user->company_id==9){
            $this->totalCompanies = CompanySetting::count();
            $this->activeCompanies = CompanySetting::count();
            $this->inactiveCompanies = 0;// CompanySetting::where('status', 'inactive')->count();
        }else{

        //       if (version_compare($lastVersion['version'], File::get('version.txt')) > 0)
        // {
        //     $this->lastVersion = $lastVersion['version'];
        // }
        $this->totalOpenings = Job::where('company_id', $this->user->company_id)->count();
        $this->totalCompanies = Company::count();
        $this->totalApplications = JobApplication::join('jobs', 'jobs.id', '=', 'job_applications.job_id')->where('company_id', $this->user->company_id)->count();
        $this->totalHired = JobApplication::join('application_status', 'application_status.id', '=', 'job_applications.status_id')
            ->join('jobs', 'jobs.id', '=', 'job_applications.job_id')->where('company_id', $this->user->company_id)->where('application_status.status', 'hired')
            ->count();
        $this->totalRejected = JobApplication::join('application_status', 'application_status.id', '=', 'job_applications.status_id')
             ->join('jobs', 'jobs.id', '=', 'job_applications.job_id')->where('company_id', $this->user->company_id)->where('application_status.status', 'rejected')
            ->count();
        $this->newApplications = JobApplication::join('application_status', 'application_status.id', '=', 'job_applications.status_id')
             ->join('jobs', 'jobs.id', '=', 'job_applications.job_id')->where('company_id', $this->user->company_id)->where('application_status.status', 'applied')
            ->count();

        $this->shortlisted = JobApplication::join('application_status', 'application_status.id', '=', 'job_applications.status_id')
            ->join('jobs', 'jobs.id', '=', 'job_applications.job_id')
            ->where('application_status.status', 'interview')
            ->where('jobs.company_id',$this->user->company_id)
            ->count();

        $currentDate = Carbon::now()->format('Y-m-d');

        $this->totalTodayInterview = InterviewSchedule::where(DB::raw('DATE(`schedule_date`)'),  "$currentDate")
                                        ->count();

        $this->jobs = Job::select('jobs.*')->where('company_id',$this->user->company_id)
        ->orderBy('jobs.created_at', 'DESC')->get();

        // getting candidates for this company
        $jobID =  Job::where('company_id',$this->user->company_id)->get(['id']);
        $jobIdArray[] = "";
        foreach($jobID as $row){
            $jobIdArray[] = $row->id;
        }
        $jobApplications = JobApplication::whereIn('job_id',$jobIdArray)->get();
        $this->jobApplications = $jobApplications;

        $msql = 'select u.name,u.id,j.job_id from job_team_members j
                inner join users u on j.user_id = u.id where u.company_id='.$this->user->company_id;

        $this->teams = DB::select($msql);

         $this->schedules = InterviewSchedule::
            select('interview_schedules.*', 'jobs.title', 'job_applications.full_name' )
            ->with(['employee','employee.user'])
            ->join('job_applications', 'job_applications.id', 'interview_schedules.job_application_id')
            ->join('jobs', 'jobs.id', 'job_applications.job_id')
            ->where('jobs.company_id',$this->user->company_id)
            ->where('interview_schedules.status', 'pending')
            ->get();

         // Filter upcoming schedule
        $upComingSchedules = $this->schedules->filter(function ($value, $key)use($currentDate) {
            return $value->schedule_date >= $currentDate;
        });

        $upcomingData = [];

        // Set array for upcoming schedule
        foreach($upComingSchedules as $upComingSchedule){
            $dt = $upComingSchedule->schedule_date->format('Y-m-d');
            $upcomingData[$dt][] = $upComingSchedule;
        }

        $this->upComingSchedules = $upcomingData;
        }

        return view('admin.dashboard.index', $this->data);
    }

    public function firstLogin(){

        $this->user = auth()->user();
        $setting = CompanySetting::find($this->user->company_id);
        $setting->first_time_login = 1;
        $setting->save();
        return "1";
    }
}
