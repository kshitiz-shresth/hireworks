<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hireworks</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body class="bg-secondary">
    <div class="container pt-5 bg-white">
        <p>Hello! <span class="badge badge badge-primary">{{ $user->email }}. </span> This profile is shared by <span class="badge badge badge-primary">{{$user->recruiter_name}}</span>. This login will get expired on <span class="badge badge badge-primary">{{ date('jS F, Y',strtotime($user->expiry_date)) }}.</span> Thankyou.</p>
        <div class="basic-info-block">
            <h5 class="text-primary underline">Basic Info</h5>
            <div class="row">
                <div class="col-2">
                    @if(is_null($application->photo))
                        <img src="{{ asset('avatar.png') }}" class="img-circle img-fluid">
                    @else
                        <img src="{{ asset('user-uploads/candidate-photos/'.$application->photo) }}" class=" img-fluid" width="150">
                    @endif
                </div>
                <table class="table table-bordered table-striped col-10">
                    <tbody>
                        <tr>
                            <td><strong>Name:</strong> </td>
                            <td>{{ ucwords($application->full_name) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Applied For:</strong> </td>
                            <td>{{ ucwords($application->job->title) }}</td>
                        </tr>
                        <!-- <tr>
                       <td><strong>Email:</strong> </td>
                            <td>{{ $application->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Phone:</strong> </td>
                            <td>{{ $application->phone }}</td>
                        </tr> -->
                        <tr>
                            <td><strong>Applied at:</strong> </td>
                            <td>{{ $application->created_at->format('d M, Y H:i') }}</td>
                        </tr>                         
                    </tbody>
                </table>
            </div>

        </div>
        <div class="resume-block">
            <h5 class="text-primary underline">Resume</h5>
            <?php $path = $application->resume;
                $ext = pathinfo($path, PATHINFO_EXTENSION);
            ?>

            @if($ext == "pdf")
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="{{asset('user-uploads/resumes/'.$application->resume)}}" allowfullscreen>This browser does not support PDFs. Please download the PDF to view it: Download PDF</iframe>
                
            </div>
                {{-- <iframe style="height:500px !important;width:100% !important" src="{{asset('user-uploads/resumes/'.$application->resume)}}" >
                    This browser does not support PDFs. Please download the PDF to view it: Download PDF
                </iframe> --}}

            @else
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="https://view.officeapps.live.com/op/view.aspx?src={{asset('user-uploads/resumes/'.$application->resume)}}" allowfullscreen></iframe>
            </div>
                {{-- <iframe style="height:500px !important;width:100% !important" src="https://view.officeapps.live.com/op/view.aspx?src={{asset('user-uploads/resumes/'.$application->resume)}}">
                </iframe> --}}

            @endif
        </div>
        <div class="row">
            <div class="col-6">
                <div class="question-block mt-5">
                            <h5 class="text-primary underline">Questionnaires</h5>

                            @php
                                $sn=0;
                            @endphp
                            @forelse($answers as $answer)
                                    <?php $sn = $sn+1; ?>
                                    <p class="pull-left" style="display:inline-block"><b>Q{{$sn}}.</b>&nbsp;{{$answer->question->question}}&nbsp;&nbsp; </p>
                                        <p class="stars stars-example-fontawesome">
                                            @if ($answer->score)
                                            {{ $answer->score }} out of 3
                                            @endif
                                        </p>
                                    @if($answer->question->question_type == "Text")
                                        <p class="text-muted">{{ ucfirst($answer->answer)}}</p>
                                    @elseif($answer->question->question_type == "Video")
                                        <video width="400" controls>
                                        <source src="{{ asset('user-uploads/video-answers/'.$answer->answer) }}" type="video/webm">
                                        Your browser does not support HTML5 video.
                                        </video> <br>
                                    @elseif($answer->question->question_type == "Audio")
                                        <audio controls>
                                        <source src="{{ asset('user-uploads/audio-answers/'.$answer->answer) }}" type="audio/mpeg">
                                        </audio> <br>

                                    @elseif($answer->question->question_type == "Multiple")
                                        @foreach($mcq_q as $mcq)
                                            @if($mcq->id == $answer->answer)
                                            <label class="containerLab">{{ $mcq->answer }}
                                                                    <input type="checkbox" checked disabled>
                                                                    <span class="checkmark"></span>
                                            </label>
                                            @endif
                                        @endforeach
                                    @endif
                                @empty
                                @endforelse
                </div>
            </div>
            <div class="col-6">
                <div class="cover-letter-block mt-5">
                    <h5 class="text-primary underline">Attachments</h5>
                     <p>Cover Letter: <a href="/user-uploads/cover-letters/{{ $application->cover_letter }}" target="_blank" style="color:#1b5dd0;text-decoration:underline !important;">Download</a></p>
                        @if($application->attachments)
                            @foreach (json_decode($application->attachments) as $item)
                            <p>{{ $item->name }}: <a href="/user-uploads/attachments/{{ $item->location }}" target="_blank" style="color:#1b5dd0;text-decoration:underline">Download</a></p>
                            @endforeach
                        @endif
                </div>
            </div>
        </div>


    </div>
</body>
</html>