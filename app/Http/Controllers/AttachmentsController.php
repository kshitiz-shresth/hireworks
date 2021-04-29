<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\JobApplication;

class AttachmentsController extends Controller
{
    public function update(Request $request){
        $applicant = JobApplication::find($request->id);
        if ($request->hasFile('file_description')) {
            $file_name = $request->file_description->hashName();
            $request->file_description->store('user-uploads/attachments');
        }
        $toBePush = [
            'name' => $request->file_name,
            'location' => $file_name
        ];
        $attachments = $applicant->attachments ? json_decode($applicant->attachments) : [];
        array_push($attachments, $toBePush);
        $applicant->attachments = json_encode($attachments);

        $applicant->update();
        return $toBePush;

        
    }
}