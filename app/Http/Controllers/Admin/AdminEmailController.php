<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TemporaryUser;
use App\Mail\TemporaryEmail;

class AdminEmailController extends Controller
{
    //
    public function email(Request $request){
        $add_days = $request->totalDays;
        $date = date('Y-m-d', strtotime(now()) + (24 * 3600 * $add_days));
        $password = $this->randomPassword();
        $tempUser = new TemporaryUser();
        $tempUser['password'] = $password;
        $tempUser['email'] = $request->email;
        $tempUser['expiry_date'] = $date;
        $tempUser['days'] = $add_days;
        $tempUser['applicantID'] = $request->applicantID;
        $tempUser['recruiter_name'] = $request->recruiterName;
        $tempUser->save();
        $data = [
            'email' => $request->email,
            'applicantID' => $request->applicantID,
            'totalDays' => $request->totalDays,
            'password' => $password,
            'expiry_date' => $date
        ];

        Mail::send('emails.board', $data, function ($message) use ($data) {
            $message->to($data['email']);
            $message->subject('Temporary Username & Password');
        });

       // Mail::to($data['email'])->send(new TemporaryEmail($data));


        return redirect()->back()->with('success','Submitted');

    }
    private function randomPassword()
    {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
