<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-bar-rating-master/dist/themes/fontawesome-stars.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-bar-rating-master/dist/themes/bars-square.css') }}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}" type="text/javascript"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<style>

    .right-panel-box{
        overflow-x: scroll;
        max-height: 34rem;
    }


    .resume-button{
        text-align: center; margin-top: 1rem
    }

    .containerLab {
      display: block;
      position: relative;
      padding-left: 35px;
      margin-bottom: 12px;
      cursor: pointer;
      font-size: 17px;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      line-height:1.5;
    }

    /* Hide the browser's default checkbox */
    .containerLab input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
      height: 0;
      width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
      position: absolute;
      top: 0;
      left: 0;
      height: 25px;
      width: 25px;
      background-color: #eee;
    }

    /* On mouse-over, add a grey background color */
    .containerLab:hover input ~ .checkmark {
      background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .containerLab input:checked ~ .checkmark {
      background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }

    /* Show the checkmark when checked */
    .containerLab input:checked ~ .checkmark:after {
      display: block;
    }

    /* Style the checkmark/indicator */
    .containerLab .checkmark:after {
      left: 9px;
      top: 5px;
      width: 5px;
      height: 10px;
      border: solid white;
      border-width: 0 3px 3px 0;
      -webkit-transform: rotate(45deg);
      -ms-transform: rotate(45deg);
      transform: rotate(45deg);
    }

    .main-sidebar {
        z-index:0 !important;
    }

    .control-sidebar-slide-open .control-sidebar {
        width: 50% !important;
    }

    .rpanel-title{

        font-size: 18px !important;
        font-weight:500 !important;
        text-transform: capitalize !important;
    }

    .ui-widget.ui-widget-content {
        border: 1px solid #c5c5c5;
        box-shadow:2px 2px 2px 2px  #888888;
        height:100%!important;
    }

    .br-theme-bars-square .br-widget a {
        width: 20px !important;
        height: 20px !important;
        font-size: 12px !important;
        line-height: 1.3 !important;
    }
</style>
<div class="rpanel-title"> {{ ucwords($application->full_name) }}
            <a style="cursor-pointer" onclick="window.location.reload()"><i style="font-size:30px;" class="fa fa-times-circle fa-lg right-side-toggle" aria-hidden="true"></i></a>
</div>


<div class="r-panel-body p-3" style="min-height:650px !important;overflow:scroll;">
    <div id="tabs">
    <ul>
        <li><a href="#tabs-1">Basic Info</a></li>
        <li><a href="#tabs-2">Resume / CV</a></li>
        <li><a href="#tabs-3">Questionnaires</a></li>
        <li><a href="#tabs-4">Attachments</a></li>
    </ul>
    <div id="tabs-1">
    <div class="row font-12">
        <div class="col-4">
            @if(is_null($application->photo))
                <img src="{{ asset('avatar.png') }}" class="img-circle img-fluid">
            @else
                <img src="{{ asset('user-uploads/candidate-photos/'.$application->photo) }}" class=" img-fluid" width="150">
            @endif

        </div>

        <div class="col-8 right-panel-box">
            <div class="col-sm-12">
                <strong>@lang('app.name')</strong><br>
                <p class="text-muted">{{ ucwords($application->full_name) }}</p>
            </div>

            <div class="col-sm-12">
                <strong>@lang('modules.jobApplication.appliedFor')</strong><br>
                <p class="text-muted">{{ ucwords($application->job->title).' ('.ucwords($application->job->job_location).')' }}</p>
            </div>

            <div class="col-sm-12">
                <strong>@lang('app.email')</strong><br>
                <p class="text-muted">{{ $application->email }}</p>
            </div>

            <div class="col-sm-12">
                <strong>@lang('app.phone')</strong><br>
                <p class="text-muted">{{ $application->phone }}</p>
            </div>

            <div class="col-sm-12">
                <strong>@lang('modules.jobApplication.appliedAt')</strong><br>
                <p class="text-muted">{{ $application->created_at->format('d M, Y H:i') }}</p>
            </div>

            @if(!is_null($application->schedule))
             <hr>
                <h5>@lang('modules.interviewSchedule.scheduleDetail')</h5>
                <div class="col-sm-12">
                    <strong>@lang('modules.interviewSchedule.scheduleDate')</strong><br>
                    <p class="text-muted">{{ $application->schedule->schedule_date->format('d M, Y H:i') }}</p>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <strong>@lang('modules.interviewSchedule.assignedEmployee')</strong><br>
                    </div>
                    <div class="col-sm-6">
                        <strong>@lang('modules.interviewSchedule.employeeResponse')</strong><br>
                    </div>
                    @forelse($application->schedule->employee as $key => $emp )
                        <div class="col-sm-6">
                            <p class="text-muted">{{ ucwords($emp->user->name) }}</p>
                        </div>

                        <div class="col-sm-6">
                            @if($emp->user_accept_status == 'accept')
                                <label class="badge badge-success">{{ ucwords($emp->user_accept_status) }}</label>
                            @elseif($emp->user_accept_status == 'refuse')
                                <label class="badge badge-danger">{{ ucwords($emp->user_accept_status) }}</label>
                            @else
                                <label class="badge badge-warning">{{ ucwords($emp->user_accept_status) }}</label>
                            @endif
                        </div>
                    @empty
                    @endforelse
                </div>

            @endif

            @if(isset($application->schedule->comments) == 'interview' && count($application->schedule->comments) > 0)
                <hr>

                <h5>@lang('modules.interviewSchedule.comments')</h5>
                @forelse($application->schedule->comments as $key => $comment )

                    <div class="col-sm-12">
                        <p class="text-muted"><b>{{$comment->user->name }}:</b> {{ $comment->comment }}</p>
                    </div>
                @empty
                @endforelse

            @endif
            <div class="col-sm-12">
                <p class="text-muted">
                    @if(!is_null($application->skype_id))
                        <span class="skype-button rounded" data-contact-id="live:{{$application->skype_id}}" data-text="Call"></span>
                    @endif
                </p>
            </div>
            <div class="row">
                @if($user->can('add_schedule') && is_null($application->schedule))
                    <div class="col-sm-6">
                        <p class="text-muted">
                            <a style="color:white !important;" onclick="createSchedule('{{$application->id}}')" href="javascript:;" class="btn btn-sm btn-info">@lang('modules.interviewSchedule.scheduleInterview')</a>
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <a href="#" class="share-application"  data-application-id="{{ $application->id }}" data-toggle="modal" data-target="#emailModal"
        style="border: 0.1px solid; border-radius: 5px; padding:0px 5px;right: 16px;color:#007bff">Share Candidate <i class="fa fa-share"></i></a>

    </div>
    </div>

    <div id="tabs-2">
    @if($user->can('edit_job_applications'))
                    <div class="stars stars-example-fontawesome">
                        <label style="display:inline-block">Rate CV / Resume</label>
                        <select style="display:inline-block" id="example-fontawesome" name="rating" autocomplete="off">
                            <option value=""></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                @endif
    {{--<div class="col-sm-6">--}}
    <?php $path = $application->resume;
        $ext = pathinfo($path, PATHINFO_EXTENSION);
    ?>

    @if($ext == "pdf")
         <iframe style="height:500px !important;width:100% !important" src="{{asset('user-uploads/resumes/'.$application->resume)}}" >
             This browser does not support PDFs. Please download the PDF to view it: Download PDF
        </iframe>

    @else
    <iframe style="height:500px !important;width:100% !important" src="https://view.officeapps.live.com/op/view.aspx?src={{asset('user-uploads/resumes/'.$application->resume)}}">

    </iframe>

    @endif
    {{--</div>--}}

    </div>
    <div id="tabs-3">
    <?php $sn = 0; ?>
    @forelse($answers as $answer)
    <?php $sn = $sn+1; ?>
            <div class="col-sm-12">
                <p class="pull-left" style="display:inline-block"><b>Q{{$sn}}.</b>&nbsp;{{$answer->question->question}}&nbsp;&nbsp; </p>
                <p class="stars stars-example-fontawesome">
                        <select class="question_rating_class" style="display:inline-block" id="{{$answer->id}}" name="question_rating" autocomplete="off">
                            <option value=""></option>
                            @if($answer->score == 1)
                             <option value="1" selected>1</option>
                            @else
                             <option value="1">1</option>
                            @endif

                            @if($answer->score == 2)
                             <option value="2" selected>2</option>
                            @else
                             <option value="2">2</option>
                            @endif

                            @if($answer->score == 3)
                             <option value="3" selected>3</option>
                            @else
                             <option value="3">3</option>
                            @endif
                        </select>
                    </p></br>
                @if($answer->question->question_type == "Text")
                    <p class="text-muted">{{ ucfirst($answer->answer)}}</p>
                @elseif($answer->question->question_type == "Video")
                    <video width="400" controls>
                      <source src="{{ asset('user-uploads/video-answers/'.$answer->answer) }}" type="video/webm">
                      Your browser does not support HTML5 video.
                    </video>
                @elseif($answer->question->question_type == "Audio")

                    <audio controls>
                      <source src="{{ asset('user-uploads/audio-answers/'.$answer->answer) }}" type="audio/mpeg">
                    </audio>

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
            </div></br>
            @empty
            @endforelse
    </div>

    <div id="tabs-4">
      <div class="col-sm-12">
          <div id="fileSection">
            <p>Cover Letter: <a href="/user-uploads/cover-letters/{{ $application->cover_letter }}" target="_blank" style="color:#1b5dd0;text-decoration:underline">Download</a></p>
            @if($application->attachments)
                @foreach (json_decode($application->attachments) as $item)
                <p>{{ $item->name }}: <a href="/user-uploads/attachments/{{ $item->location }}" target="_blank" style="color:#1b5dd0;text-decoration:underline">Download</a></p>
                @endforeach
            @endif
          </div>
          <form id="attachmentsUpload" action="/submit-attachments" method="POST">
            @csrf
                <div class="row">
                    <div class="col-12">
                    <label for="file_name">Name</label>
                    <input id="file_name" required class="form-control col-11" type="text" name="file_name">
                    </div>
                    <div class="col-12 mt-2">
                    <input type="file" name="file_description" id="myFile" required>
                    </div>
                    <input type="hidden" name="id" value="{{ $application->id }}">
                    <div class="col-12 mt-2">
                        <button id="submitAttachments" type="submit" class="btn btn-success">Submit</button>
                    </div>         
                </div>
          </form>
           
      </div>
    </div>

    <div id="tabs-5">

    </div>

</div>

{{-- Send email --}}
    <div class="modal" id="emailModal">
        <div class="modal-dialog">
        <form action="/admin/jobs/emailForm" id="emailForm" method="POST">
                 @csrf
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Share this applicant</h4>
                        <button type="button"  class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="assessment_name">Email</label>
                            <input class="form-control" type="email" name="email" id="job_name" required>
                            <br/>
                            <input type="hidden" value="{{ $application->id }}" name="applicantID">
                        </div>
                        <div class="form-group">
                            <label for="assessment_name">Total Days</label>
                            <input class="form-control" type="number" name="totalDays" required><br/>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <p id="shareEmailLoading" style="display: none">processing!! please wait...</p>
                        <button type="submit" id="shareEmail" class="btn btn-success" >Share</button>
                        <button type="button"  " class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
        </form>
        </div>
    </div>


@if($user->can('edit_job_applications'))
<script src="{{ asset('assets/plugins/jquery-bar-rating-master/dist/jquery.barrating.min.js') }}" type="text/javascript"></script>
<script>

    $('#attachmentsUpload').submit(function (event) {
          event.preventDefault();
        $.easyAjax({
            url: '/submit-attachments',
            container: '#attachmentsUpload',
            type: "POST",
            file:true,
            data: $('#attachmentsUpload').serialize(),
            success: function (response){
                $('#file_name').val("");
                $('#myFile').val(null);
                $( "#fileSection" ).append( `<p>${response.name}: <a href="/user-uploads/attachments/${response.location}" target="_blank" style="color:#1b5dd0;text-decoration:underline">Download</a></p>` );
                swal({
                title: "Succeed!",
                text: `${response.name} has been successfully uploaded`,
                type: "success"
                });
            },
            error: function (response) {
                handleFails(response);
            }
        })
    });

    $( function() {
        $( "#tabs" ).tabs();
    });

    $('#date-start').bootstrapMaterialDatePicker({ weekStart : 0, time: false })
    $('#schedule-time').bootstrapMaterialDatePicker({
         date: false,
        shortTime: true,   // look it
        format: 'HH:mm',
        switchOnClick: true
    })

    $(".team_members").select2({
            placeholder: "Choose Team Members",
            theme: "classic"
        })

    $('.question_rating_class').barrating({
        theme: 'bars-square',
        showSelectedRating: false,
        showValues: true,
        onSelect:function(value, text, event){
            if(event !== undefined && value !== ''){
                var el          = this;
                var q_id = el.$elem[0].id

                var url = "{{ route('admin.job-applications.score-save',':id') }}";
                url = url.replace(':id', {{$application->id}}+'-'+q_id);
                var token = '{{ csrf_token() }}';
                var id = {{$application->id}};
                $.easyAjax({
                    type: 'Post',
                    url: url,
                    container: '#'+q_id,
                    data: {'rating':value, '_token':token},
                    success: function (response) {
                        $('#'+q_id).barrating('set', value);
                    }
                });
            }

        }
    });

    $('#example-fontawesome').barrating({
        theme: 'fontawesome-stars',
        showSelectedRating: false,
        onSelect:function(value, text, event){
            if(event !== undefined && value !== ''){
                var url = "{{ route('admin.job-applications.rating-save',':id') }}";
                url = url.replace(':id', {{$application->id}});
                var token = '{{ csrf_token() }}';
                var id = {{$application->id}};
                $.easyAjax({
                    type: 'Post',
                    url: url,
                    container: '#example-fontawesome',
                    data: {'rating':value, '_token':token},
                    success: function (response) {
                        $('#example-fontawesome_'+id).barrating('set', value);
                    }
                });
            }

        }
    });


    @if($application->rating !== null)
        $('#example-fontawesome').barrating('set', {{$application->rating}});
    @endif

    @if($application->score !== null)
        $('#example-fontawesome').barrating('set', {{$application->rating}});
    @endif

    $('#save-form').click(function () {
        $.easyAjax({
            url: '{{route("admin.pipeline.scheduleInterview")}}',
            container: '#editSettings',
            type: "POST",
            redirect: false,
            file: true
        })
    });

</script>
@endif
@if(!is_null($application->skype_id))
    <script src="https://swc.cdn.skype.com/sdk/v1/sdk.min.js"></script>
@endif