<?php

namespace App\Http\Controllers\Admin;

Use DB;
Use View;
use App\Helper\Reply;
use App\Http\Requests\StoreJob;
use App\Job;
use App\User;
use App\JobTeamMember;
use App\Country;
use App\JobCategory;
use App\JobLocation;
use App\JobQuestion;
use App\JobSkill;
use App\Question;
use App\Assessment;
use App\AssessmentQuestion;
use App\Skill;
use App\MultipleChoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Company;
use App\CompanySetting;
use App\Notifications\NewJobApplication;
use Illuminate\Support\Facades\Notification;
use App\JobApplication;
use Illuminate\Support\Facades\Http;

class AdminJobsController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('menu.jobs');
        $this->pageIcon = 'icon-badge';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!$this->user->can('view_jobs'), 403);

        $this->companies = Company::all();
        $this->totalJobs = Job::where('company_id', $this->user->company_id)->count();
        $this->activeJobs = Job::where('status','active')->where('company_id', $this->user->company_id)->count();
        $this->inactiveJobs = Job::where('status', 'inactive')->where('company_id', $this->user->company_id)->count();

        return view('admin.jobs.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!$this->user->can('add_jobs'), 403);

        $this->categories = JobCategory::all();
        $this->locations = JobLocation::all();
        $this->countries = Country::all();
        $this->questions = Question::all();
        $this->companies = CompanySetting::all();

        $this->assessments =  Assessment::where('company_id', $this->user->company_id)->get();

        $this->assessmentsq =  AssessmentQuestion::all();
        return view('admin.jobs.create', $this->data);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJob $request)
    {
        abort_if(!$this->user->can('add_jobs'), 403);
        $compId = User::where('id', $this->user->id)->first();

        $job = new Job();
        $job->slug = null;
        $job->company_id = $compId->company_id;
        $job->title = $request->title;
        $job->category_id = $request->category_id;

        $job->job_type =  $request->job_type;
        $job->total_positions = $request->total_positions;

        $job->salary_frequency = $request->salary_frequency;
        $job->salary = $request->salary;



        if($request->is_remote == null){
            $job->is_remote= 0;
            $job->job_country = $request->country;
            $job->job_location = $request->location_id;
        }else{
            $job->is_remote= 1;
        }


        $job->start_date = $request->start_date;
        $job->end_date = $request->end_date;

        $job->job_description = $request->job_description;
        $job->job_requirement = $request->job_requirement;

        $job->skills = $request->job_skills;

        $job->location_id = 5;


        $job->status = $request->status;


        $job->save();

        if (!is_null($request->skill_id)) {
            JobSkill::where('job_id', $job->id)->delete();

            foreach ($request->skill_id as $skill) {
                $jobSkill = new JobSkill();
                $jobSkill->skill_id = $skill;
                $jobSkill->job_id = $job->id;
                $jobSkill->save();
            }
        }

        // Save Question for job
        if (!is_null($request->question)) {
            JobQuestion::where('job_id', $job->id)->delete();

            foreach ($request->question as $question) {
                $jobQuestion = new JobQuestion();
                $jobQuestion->question_id = $question;
                $jobQuestion->job_id = $job->id;
                $jobQuestion->save();
            }
        }

        return Reply::redirect(route('admin.jobs.index'), __('menu.jobs') . ' ' . __('messages.createdSuccessfully'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $id = $_GET['id'];

        $pageNumber = isset($_GET['page']) ? $_GET['page'] : 0 ;

        $job = Job::find($id);

        if($pageNumber>4){ abort(404); }
        $this->job = $job;
        $this->categories = JobCategory::all();
        $this->countries = Country::all();
        $this->questions = Question::where('job_id',$id)->orderBy('order_no', 'ASC')->get();
        $this->users = User::where('company_id',$this->user->company_id)->get();

        $this->team = JobTeamMember::where('job_id',$id)->get();

        $page[0] = 'edit';
        $page[1] = 'details';
        $page[2] = 'description';
        $page[3] = 'hiring-team';
        $page[4] = 'assesment';
        
        return view('admin.jobs.'.$page[$pageNumber], $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(!$this->user->can('edit_jobs'), 403);
        $this->job = Job::find($id);
        $this->categories = JobCategory::all();
        $this->locations = JobLocation::all();
        $this->skills = Skill::where('category_id', $this->job->category_id)->get();
        $this->jobQuestion = JobQuestion::where('job_id', $id)->pluck('question_id')->toArray();
        $this->questions = Question::all();
        $this->companies = Company::all();

        return view('admin.jobs.edit', $this->data);
    }

    public function editQuestion(){
        $id = $_GET["id"];
        $this->aq = Question::find($id);

        $mSql = 'select * from multiple_choices where question_id ='.$id;

        $this->assessmentMultiple = DB::select($mSql);

        $html = View::make('admin.jobs.editquestion', $this->data)->render();
        return $html;
    }

    public function updateQuestion()
    {

        return Reply::success(__('menu.question').' '.__('messages.updatedSuccessfully'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreJob $request, $id)
    {
        abort_if(!$this->user->can('edit_jobs'), 403);

        $job = Job::find($id);

        $compId = User::where('id', $this->user->id)->first();
        $job->company_id = $compId->company_id;

        $job->title = $request->title;
        $job->category_id = $request->category_id;

        $job->job_type =  $request->job_type;
        $job->total_positions = $request->total_positions;

        $job->salary_frequency = $request->salary_frequency;
        $job->salary = $request->salary;



        if($request->is_remote == null){
            $job->is_remote= 0;
            $job->job_country = $request->country;
            $job->job_location = $request->location_id;
        }else{
            $job->is_remote= 1;
        }


        $job->start_date = $request->start_date;
        $job->end_date = $request->end_date;

        $job->job_description = $request->job_description;
        $job->job_requirement = $request->job_requirement;

        $job->skills = $request->job_skills;

        $job->location_id = 5;
        $job->advertise = $request->advertise;
        $job->status = $request->status;

        $job->save();

        JobTeamMember::where('job_id', $job->id)->delete();

        if($request->team_members != null){
            foreach ($request->team_members as $team) {
                $jobTeamMember = new JobTeamMember();
                $jobTeamMember->user_id = $team;
                $jobTeamMember->job_id = $job->id;
                $jobTeamMember->save();
            }
            $jobApplication = JobApplication::find(1);

            $users = User::where('id',$this->user->id)->get();
            //Notification::send($users, new NewJobApplication($jobApplication));
        }

     //   $credentials = base64_encode('abhis07:batman137##N');

    //    $client = new \GuzzleHttp\Client();

     //   $client->post(
    //        'https://book.hireworks.us/index.php/api/v1/services',
     //       ['headers' => ['Content-type' => 'application/json'],
     //       'auth' => [
      //          'abhis07',
      //          'batman137##N'
      //      ],
     //       'json' => [
     //               "name"=>$request->title,
     //               "duration"=>"30",
     //               "price"=>"2212",
     //               "currency"=>"Euro",
     //               "description"=>"adsfasdsf",
     //              "availabilities_type"=>"flexible",
     //               "attendants_number"=>"1"
      //          ],
      //      ]
       // ); 

        return Reply::success(__('messages.updatedSuccessfully'));
    }

    public function saveJob(){
        $job_name = $_GET["name"];

        $job = new Job();
        $job->title = $job_name;
        $job->company_id = $_GET["company_id"];

        $job->save();

        $this->job_name =  $job_name;
        $this->job_id = $job->id;

        return json_encode($job->id);
    }

    public function changeOrder(){
        $job_id = $_GET["job_id"];
        $question_id = $_GET["question_id"];
        $order_no = $_GET["order_no"];

        $old_order_no = Question::where('id',$question_id)->first()->order_no;

        $mSql = "Select * from questions where job_id=".$job_id." and order_no=".$order_no;

        $nxtQuestion =  Question::where('job_id',$job_id)->where('order_no',$order_no)->first()->id;


        $nxtQuestionDB = Question::find($nxtQuestion);
        $nxtQuestionDB->order_no = $old_order_no;
        $nxtQuestionDB->save();

        $question = Question::find($question_id);
        $question->order_no = $order_no;
        $question->save();

        return json_encode($job_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!$this->user->can('delete_jobs'), 403);

        Job::destroy($id);
        return Reply::success(__('messages.recordDeleted'));
    }

    public function changeStatus(Request $request){
        
        //  if checked is true then set status to 1
        if($request->checked=="true"){
            $job = Job::find($request->id);
            $job->status = "active";
            $job->save();
        }
        else{
            $job = Job::find($request->id);
            $job->status = "inactive";
            $job->save();          
        }
        return response([
            'status'=>'success'
        ]);

    }

    public function data()
    {
        abort_if(!$this->user->can('view_jobs'), 403);

         $compId = User::where('id', $this->user->id)->first();


         $categories = Job::where('company_id','=',$compId->company_id);

        if (\request('filter_company') != "") {
            $categories->where('company_id', \request('filter_company'));
        }

        if (\request('filter_status') != "") {
            $categories->where('status', \request('filter_status'));
        }

        $categories->get();

        return DataTables::of($categories)
            ->addColumn('action', function ($row) {
                $action = '';

                if ($this->user->can('edit_jobs')) {
                    $action .= '<a href="/admin/jobs/show?id='.$row->id.'&page=1" class=""
                      data-toggle="tooltip" data-original-title="' . __('app.edit') . '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                }

                if ($this->user->can('delete_jobs')) {
                    $action .= ' | <a href="javascript:;" class="sa-params"
                      data-toggle="tooltip" data-row-id="' . $row->id . '" data-original-title="' . __('app.delete') . '"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
                }
                return $action;
            })

            ->editColumn('title', function ($row) {
                return '<a target="_blank" href="/admin/pipeline/pipeline/'.$row->id. '">'. $row->title.'</a>';
            })


            ->editColumn('job_location', function ($row) {
                if($row->is_remote == 0){
                    return ucfirst($row->job_location);
                }else{
                    return "Remote";
                }
            })

            // ->editColumn('start_date', function ($row) {
            //     return $row->start_date->format('d M, Y');
            // })

            // ->editColumn('end_date', function ($row) {
            //     return $row->end_date->format('d M, Y');
            // })

            ->editColumn('status', function ($row) {
                if ($row->status == 'active') {
                    if($row->title!=null && $row->category_id!=null && $row->job_type!=null && $row->total_positions!=null && $row->salary_frequency!=null && $row->salary!=null && $row->job_location!=null && $row->job_country!=null && $row->skills!=null || $row->is_remote!=null){
                        return '<input class="jobCheckBox" type="checkbox" checked data-id='."$row->id".'> <span id="activeOrInactive">Active</span>';
                    }
                    else{
                        return '<input class="jobCheckBox" type="checkbox" checked data-id='."$row->id".'> Draft';
                    }
                    // return '<label class="badge bg-success">' . __('app.active') . '</label>';
                }
                if ($row->status == 'inactive') {
                    if($row->title!=null && $row->category_id!=null && $row->job_type!=null && $row->total_positions!=null && $row->salary_frequency!=null && $row->salary!=null && $row->job_location!=null && $row->job_country!=null && $row->skills!=null || $row->is_remote!=null)
                    {
                    return '<input class="jobCheckBox" type="checkbox" data-id='."$row->id".'> <span id="activeOrInactive">InActive</span>';
                        
                    }
                    else{
                    return '<input class="jobCheckBox" type="checkbox" data-id='."$row->id".'> Draft';
                    }
                }
            })

            ->editColumn('hiring_team', function ($row) {
                $html = '';
                $team_members = JobTeamMember::where('job_id',$row->id)->get();
                foreach($team_members as $t){
                    $name = User::where('id',$t->user_id)->first();
                    $initial = substr($name->name, 0, 1);
                    $html .= '<span data-toggle="tooltip" data-original-title="' .$name->name. '" data-placement="bottom" class="badge badge-secondary">'. $initial .'</span>&nbsp;';
                }
                return $html;
            })

            ->rawColumns(['status', 'action','title','hiring_team'])

            ->addIndexColumn()
            ->make(true);
    }

}
