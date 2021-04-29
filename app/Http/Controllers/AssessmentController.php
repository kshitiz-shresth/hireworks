<?php

namespace App\Http\Controllers;

use App\Assessment;
use App\AssessmentMultipleChoice;
use App\AssessmentQuestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssessmentController extends Controller
{
    public function import(Request $request){
        // clone assessment
        $toCloneAssessment = Assessment::find($request->assessment_id)->toArray();
        $toCloneAssessment['company_id'] =$request->company_id;
        $clonedAssessment = Assessment::create($toCloneAssessment);

        // clone questions
        $toCloneAssessmentQuestions = AssessmentQuestion::where('assessment_id',$toCloneAssessment['id'])->get();
        foreach($toCloneAssessmentQuestions as $toCloneAssessmentQuestion){

            $toCloneAssessmentQuestion['assessment_id'] = $clonedAssessment['id'];
            $clonedAssesmentQuestion = AssessmentQuestion::create($toCloneAssessmentQuestion->toArray());
            if($toCloneAssessmentQuestion->question_type=='Multiple'){
                // add multiple questions
                $toCloneMultipleCoiceQuestions = AssessmentMultipleChoice::where('question_id',$toCloneAssessmentQuestion->id)->get();
                foreach($toCloneMultipleCoiceQuestions as $toCloneMultipleCoiceQuestion){
                    $toCloneMultipleCoiceQuestion['question_id'] = $clonedAssesmentQuestion->id;
                    AssessmentMultipleChoice::create($toCloneMultipleCoiceQuestion->toArray());
                }
            }
        }

        return redirect('/admin/assessments');
    }
}
