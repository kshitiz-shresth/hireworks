<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Reply;
use App\Http\Requests\Question\StoreRequest;
use App\Http\Requests\Question\UpdateRequest;
use App\Question;
use App\MultipleChoice;
use DB;
use App\Assessment;
use App\AssessmentQuestion;
use App\AssessmentMultipleChoice;
use Yajra\DataTables\Facades\DataTables;

class AdminAssessmentController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = "My Assessments";
        $this->pageIcon = 'icon-grid';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(! $this->user->can('view_question'), 403);
        //$this->assessments =  Assessment::where('company_id', $this->user->company_id)->get();

        $msql = "SELECT assessments.*, COUNT(m.id) count
                 FROM assessments
                 LEFT JOIN assessment_questions AS m ON assessments.id = m.assessment_id
                 where assessments.company_id= ".$this->user->company_id." GROUP BY assessments.id";

        $this->assessments = DB::select($msql);

        return view('admin.assessments.index', $this->data);
    }

    public function getQuestions(){
        $ass_id = $_GET['id'];

        $assementq = AssessmentQuestion::where('assessment_id', $ass_id)->get();
        return json_encode($assementq);
    }

    public function fetchAssessementQuestion(){
        $ass_id = $_GET['id'];

        $assementqq = AssessmentQuestion::where('assessment_id', $ass_id)->get();

        $q_count = Question::where('job_id', $_GET['job_id'])->count();
        foreach($assementqq as $a){
           $q_count = $q_count + 1;

            $question = new Question();
            $question->job_id = $_GET['job_id'];
            $question->question = $a->question;
            $question->question_type = $a->question_type;
            $question->required = $a->required;
            $question->audio_video_length = $a->audio_video_length;
            $question->company_id= $this->user->company_id;
            $question->order_no = $q_count;

            if (!empty($a->time_limit)) {
                $question->audio_video_length = $a->time_limit;
            }

            $question->save();

            $multipleChoice = AssessmentMultipleChoice::where('question_id',$a->id)->get();
            if($multipleChoice != null){
                if($multipleChoice->count() > 0){
                    foreach($multipleChoice as $mc){
                        $q_multiple = new MultipleChoice();
                        $q_multiple->question_id = $question->id;
                        $q_multiple->answer = $mc->answer;

                        $q_multiple->save();
                    }


                }
            }


        }

        $assementq = Question::where('job_id', $_GET["job_id"])->get();

        return json_encode($assementq);
    }

    public function fetchassessments(){
        $msql = "SELECT assessments.*, COUNT(m.id) count
        FROM assessments
        LEFT JOIN assessment_questions AS m ON assessments.id = m.assessment_id
        where assessments.company_id= ".$this->user->company_id." GROUP BY assessments.id";

        $assementq = $this->assessments = DB::select($msql);


        return json_encode($assementq);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(! $this->user->can('add_question'), 403);

        $id = $_GET['id'];
        $assessment = Assessment::find($id);

        $this->assessment_name = $assessment->name;
        $this->assessment_id = $id;

        $this->assessmentsq =  AssessmentQuestion::all();

        return view('admin.assessments.create', $this->data);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        abort_if(! $this->user->can('add_question'), 403);

        $assementq = new AssessmentQuestion();
        $assementq->question = $request->question;
        $assementq->question_type = $request->question_type;

        if (!empty($request->time_limit)) {
            $assementq->audio_video_length = $request->time_limit;
        }

        $assementq->required = $request->required;

        $assementq->assessment_id = $request->assessment_id;
        $assementq->save();

        $question_id = $assementq->id;
        if (!empty($request->multiple)) {
            if($request->question_type == "Multiple"){
                foreach($request->multiple as $key=>$value){
                    $multiplechoice = new AssessmentMultipleChoice();
                    $multiplechoice->question_id = $question_id;
                    $multiplechoice->answer = $request->multiple[$key];
                    $multiplechoice->save();
                }
            }
        }

        return Reply::success(__('menu.question').' '.__('messages.createdSuccessfully'));
    }

    public function saveAssessment(StoreRequest $request){

        $assessment = new Assessment();
        $assessment->name = $request->assessment_name;
        $assessment->summary = $request->summary;
        $assessment->company_id = $this->user->company_id;
        $assessment->save();

        $this->assessment_name =  $request->assessment_name;
        $this->assessment_id = $assessment->id;

        return json_encode($assessment->id);
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
        $assessment = Assessment::find($id);

        $this->assessment_name = $assessment->name;
        $this->assessment_id = $id;

        $this->assessmentq = AssessmentQuestion::where('assessment_id', $id)->get();

        $mSql = 'select * from assessment_multiple_choices
        where question_id in (select id from assessment_questions where assessment_id ='.$id.')';

        $this->assessmentMultiple = DB::select($mSql);

        return view('admin.assessments.edit', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(! $this->user->can('edit_question'), 403);

        $this->question = Question::find($id);
        return view('admin.assessments.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        abort_if(! $this->user->can('edit_question'), 403);
        $question = AssessmentQuestion::find($id);
        $question->question = $request->question;
        $question->required = $request->required;
        $question->question_type = $request->question_type;

        if (!empty($request->time_limit)) {
            $question->audio_video_length = $request->time_limit;
        }

        $question->save();

        $mSql = 'delete from assessment_multiple_choices where question_id='.$id;

        DB::delete($mSql);


        $question_id = $id;
        if (!empty($request->multiple)) {
            if($request->question_type == "Multiple"){
                foreach($request->multiple as $key=>$value){
                    $multiplechoice = new AssessmentMultipleChoice();
                    $multiplechoice->question_id = $question_id;
                    $multiplechoice->answer = $request->multiple[$key];
                    $multiplechoice->save();
                }
            }
        }

        return Reply::success(__('menu.question').' '.__('messages.updatedSuccessfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(! $this->user->can('delete_question'), 403);

        Question::destroy($id);
        return Reply::success(__('messages.questionDeleted'));
    }

    public function data() {
        abort_if(! $this->user->can('view_question'), 403);

        $questions = Question::all();

        return DataTables::of($questions)
            ->addColumn('action', function ($row) {
                $action = '';

                if( $this->user->can('edit_question')){
                    $action.= '<a href="' . route('admin.questions.edit', [$row->id]) . '" class="btn btn-primary btn-circle"
                      data-toggle="tooltip" data-original-title="'.__('app.edit').'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                }

                if( $this->user->can('delete_question')){
                    $action.= ' <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                      data-toggle="tooltip" data-row-id="' . $row->id . '" data-original-title="'.__('app.delete').'"><i class="fa fa-times" aria-hidden="true"></i></a>';
                }
                return $action;
            })
            ->editColumn('required', function ($row) {
                return ucfirst($row->required);
            })
            ->editColumn('requ', function ($row) {
                return ucfirst($row->question);
            })
            ->addIndexColumn()
            ->make(true);
    }

}