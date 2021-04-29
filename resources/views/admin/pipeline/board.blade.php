@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/lobipanel/dist/css/lobipanel.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/multiselect/css/multi-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-bar-rating-master/dist/themes/fontawesome-stars.css') }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <style>

        .content-wrapper {
            min-height: 100% !important;
        }


        .board-column{
            /* max-width: 21%; */
        }

        .board-column .card{
            box-shadow: none;
        }
        .notify-button{
            /*width: 9em;*/
            height: 1.5em;
            font-size: 0.730rem !important;
            line-height: 0.5 !important;
        }
        .panel-scroll{
            height: calc(100vh - 330px); overflow-y: scroll
        }
        .mb-20{
            margin-bottom: 20px
        }
        .datepicker{
            z-index: 9999 !important;
        }
        .select2-container--default .select2-selection--single, .select2-selection .select2-selection--single {
            width: 100%;
        }
        .select2-search {
            width: 100%;
        }
        .select2.select2-container {
            width: 100% !important;
        }
        .select2-search__field {
            width: 100% !important;
            display: block;
            padding: .375rem .75rem !important;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }
        .d-block{
            display: block;
        }
        .upcomingdata {
            height: 37.5rem;
            overflow-x: scroll;
        }
        .notify-button{
            height: 1.5em;
            font-size: 0.730rem !important;
            line-height: 0.5 !important;
        }
        .scheduleul
        {
            padding: 0 15px 0 11px;
        }

        .content-header{
            display:none;
        }

        .card{
            min-height:90% !important;
        }

        .box{
            background-color:#f2f2f2;
        }

    </style>
@endpush

@section('content')


    <div class="container-scroll" style="padding-top:15px;">
        <div class="container-fluid" style="padding-top:15px;">
            <h3 style="display:inline-block">
            @if($job->status == "active")
                <i class="fa fa-circle" aria-hidden="true" style="color:#76d691"></i>
            @else
                <i class="fa fa-circle" aria-hidden="true" style="color:red"></i>
            @endif
            </h3>
            <h3 style="display:inline-block">{{$job->title}}</h3>
            <h4 style="display:inline-block" class="pull-right">

                <i style="color:#007bff"  title="Team Members" class="fa fa-users" aria-hidden="true"></i>&nbsp;
                <?php $ind =1; ?>
                @foreach($teams as $t)
                    @if($t->job_id == $job->id)
                        <span data-toggle="tooltip" data-placement="bottom" class="badge badge-secondary myTooltip">{{$t->name }}</span>&nbsp;
                    @else
                        @if($ind == 1)
                            <span class="badge badge-secondary">No Team Members</span>
                        @endif
                    @endif

                <?php $ind = $ind+1; ?>
                @endforeach
            </h4><br/>

            &nbsp;<span class="fa fa-map-marker"></span>
                @if($job->is_remote == 1)
                    <span>Remote</span>
                @else
                    <span>{{$job->job_location}}, {{$job->job_country}}</span>
                @endif

            @if($job->status == "active")
            &nbsp;<a target="_blank" href="/job/{{$job->slug}}"> <span class="fa fa-external-link-square" aria-hidden="true"></span>
                <span>View Job</span></a>
            @else
            @endif

            <br/>

        </div>

        <div class="row container-row">
            @foreach($boardColumns as $key=>$column)
                <div class="board-column p-0" data-column-id="{{ $column->id }}">
                    <div class="card" style="margin-bottom:0 !important;">
                        <div class="card-body">
                            <h4 class="card-title pt-1 pb-1">
                             @if($column->status == "applied")
                             {{ ucwords($column->status) }} <span class="badge badge-pill badge-primary text-white ml-auto">{{ $applied_job}}</span>
                             @elseif($column->status == "rejected")
                             {{ ucwords($column->status) }} <span class="badge badge-pill badge-primary text-white ml-auto">{{ $rejected}}</span>
                             @elseif($column->status == "interview")
                             {{ ucwords($column->status) }} <span class="badge badge-pill badge-primary text-white ml-auto">{{ $interview}}</span>
                             @elseif($column->status == "hired")
                             {{ ucwords($column->status) }} <span class="badge badge-pill badge-primary text-white ml-auto">{{ $hired}}</span>
                             @else
                             In-Progress <span class="badge badge-pill badge-primary text-white ml-auto">{{ $phonescreen}}</span>
                             @endif
                             </h4>
                            <div class="card-text">
                                <div class="panel-body ">
                                    <div class="row">
                                        <div class="custom-column panel-scroll">
                                            @foreach($column->applications as $application)
                                            @if($application->job_id == $jobId)

                                                <div class="panel panel-default lobipanel "
                                                     data-sortable="true" data-row-id="{{ $application->id }}"
                                                     data-application-id="{{ $application->id }}">

                                                    <div class="panel-body show-detail" data-widget="control-sidebar" data-slide="true"
                                                     data-row-id="{{ $application->id }}"
                                                     data-application-id="{{ $application->id }}"  data-sortable="true"
                                                      >
                                                        <h5 style="display:inline-block">
                                                            {!!  ($application->photo) ? '<img src="'.asset('user-uploads/candidate-photos/'.$application->photo).'"
                                                                        alt="user" class="img-circle" width="25">' : '<img src="'.asset('avatar.png').'"
                                                                        alt="user" class="img-circle" width="25">' !!}
                                                            {{ ucwords($application->full_name) }} @if(!$application->seen) <p class="badge badge-pill badge-warning">new</p> @endif</h5>

                                                        @if($application->score_percent != null)
                                                            @if($application->score_percent >= 0 && $application->score_percent < 35)
                                                                <span style="display:inline-block;" class="badge badge-pill badge-danger pull-right">{{number_format((float)$application->score_percent, 0, '.', '')}}%</span>
                                                            @elseif($application->score_percent >=35  && $application->score_percent < 60)
                                                                <span style="display:inline-block;" class="badge badge-pill badge-warning pull-right">{{number_format((float)$application->score_percent, 0, '.', '')}}%</span>
                                                            @elseif($application->score_percent >=60  && $application->score_percent < 80)
                                                                <span style="display:inline-block;" class="badge badge-pill badge-info pull-right">{{number_format((float)$application->score_percent, 0, '.', '')}}%</span>
                                                            @else
                                                                <span style="display:inline-block;" class="badge badge-pill badge-success pull-right">{{number_format((float)$application->score_percent, 0, '.', '')}}%</span>
                                                            @endif
                                                        @endif

                                                        <div class="container-fluid">
                                                            <span class="text-dark font-8" style="font-size:12px !important;font-weight:400">
                                                                @if(!is_null($application->schedule)  && $column->id == 3)

                                                                   <?php
                                                                        $startTimeStamp = strtotime($application->created_at);
                                                                        $endTimeStamp = time();
                                                                        $datediff = $endTimeStamp - $startTimeStamp;
                                                                        $dateinDays = intval($datediff / (60 * 60 * 24));
                                                                    ?>
                                                                    <span> <i class="fa fa-clock-o" aria-hidden="true"></i>

                                                                    @if($dateinDays <= 0)
                                                                       <?php $dateinDays = intval($datediff / 60); ?>
                                                                       @if($dateinDays > 60)
                                                                       <?php $dateinHR = intval($datediff / (60*60)); ?>
                                                                       <span>{{$dateinHR}} hr ago</span>
                                                                       @else
                                                                        <span>{{$dateinDays}} mins ago</span>
                                                                       @endif

                                                                    @else
                                                                        <span>{{$dateinDays}} days ago</span>
                                                                    @endif

                                                                    </span>
                                                                @else
                                                                    <?php
                                                                        $startTimeStamp = strtotime($application->created_at);
                                                                        $endTimeStamp = time();
                                                                        $datediff = $endTimeStamp - $startTimeStamp;
                                                                        $dateinDays = intval($datediff / (60 * 60 * 24));
                                                                    ?>
                                                                    <span> <i class="fa fa-clock-o" aria-hidden="true"></i>

                                                                    @if($dateinDays <= 0)
                                                                       <?php $dateinDays = intval($datediff / 60); ?>
                                                                       @if($dateinDays > 60)
                                                                       <?php $dateinHR = intval($datediff / (60*60)); ?>
                                                                       <span>{{$dateinHR}} hr ago</span>
                                                                       @else
                                                                        <span>{{$dateinDays}} mins ago</span>
                                                                       @endif
                                                                    @else
                                                                        <span>{{$dateinDays}} days ago</span>
                                                                    @endif

                                                                    </span>
                                                                @endif
                                                            </span>

                                                           @if($application->team_member_id == null)
                                                            <a  title="Reserve Candidate" href="#" onclick="ReserveCandidate(this, event,{{$application->id}})" class="pull-right follow_icon">

                                                                <i title="Reserve Candidate" class="fa fa-unlock-alt fa-lg" aria-hidden="true"></i>
                                                            </a>
                                                            <span class="pull-right team_img_sec">

                                                            </span>
                                                            @else
                                                            @foreach($app_teams as $t)
                                                            @if($t->id == $application->team_member_id)
                                                                <a href="#" data-toggle="tooltip" title="{{$t->name}}" data-placement="bottom" class="badge badge-secondary pull-right">{{substr($t->name,0,1)}}</a>
                                                            @endif
                                                            @endforeach
                                                            @endif


                                                                <span id="buttonBox{{ $column->id }}{{$application->id}}" data-timestamp="@if(!is_null($application->schedule)){{$application->schedule->schedule_date->timestamp}}@endif">

                                                                    @if(!is_null($application->schedule) && $column->id == 3 && $currentDate < $application->schedule->schedule_date->timestamp)
                                                                        <button onclick="sendReminder({{$application->id}}, 'reminder')" type="button" class="btn btn-sm btn-info notify-button">@lang('app.reminder')</button>@endif
                                                                    @if($column->id == 4)
                                                                        <button onclick="sendReminder({{$application->id}}, 'notify')" type="button" class="btn btn-sm btn-info notify-button">@lang('app.notify')</button>
                                                                    @endif
                                                                </span>
                                                        </div>
                                                    </div>

                                                </div>
                                            @endif
                                            @endforeach
                                            <div class="panel panel-default lobipanel" data-sortable="true"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{--Ajax Modal Start for--}}
    <div class="modal fade bs-modal-md in" id="scheduleDetailModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn blue">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--Ajax Modal Ends--}}


@endsection

@push('footer-script')
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="{{ asset('assets/lobipanel/dist/js/lobipanel.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/moment/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/multiselect/js/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jquery-bar-rating-master/dist/jquery.barrating.min.js') }}" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
    <script>

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function(){
            $('.myTooltip').tooltip();
        });

        $('.example-fontawesome').barrating({
            theme: 'fontawesome-stars',
            showSelectedRating: false,
            readonly:true,

        });


        function ReserveCandidate(element,event,id){
            event.preventDefault();
            event.stopPropagation();
            $.ajax({
                url:'/admin/pipeline/reserve-candidate',
                type: 'POST',
                data: { application_id:id },
                success: function(response){
                    element.style.display = 'none';
                    var elem = $(element).parent().find('.team_img_sec').append('<a href="#" data-toggle="tooltip" title="'+ response.name +'" data-placement="bottom" class="badge badge-secondary myTooltip">'+ response.initial +'</a>')
                }
            })
        }

        $(function() {
            $('.bar-rating').each(function(){
                const val = $(this).data('value');

                $(this).barrating('set', val ? val : '');
            });
        });

        {{--@if($application->rating !== null)--}}
            $('.example-fontawesome').barrating('set', '');
        {{--@endif--}}
        // Schedule create modal view
        function createSchedule (id) {
            var url = "{{ route('admin.job-applications.create-schedule',':id') }}";
            url = url.replace(':id', id);
            $('#modelHeading').html('Schedule');
            $.ajaxModal('#scheduleDetailModal', url);
        }

        // Send Reminder and notification to Candidate
        function sendReminder(id, type){
            var msg;

            if(type == 'notify'){
                msg = "@lang('errors.sendHiredNotification')";
            }
            else{
                msg = "@lang('errors.sendInterviewReminder')";
            }
            swal({
                title: "@lang('errors.areYouSure')",
                text: msg,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('app.yes')",
                cancelButtonText: "@lang('app.cancel')",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if (isConfirm) {

                    var url = "{{ route('admin.interview-schedule.notify',[':id',':type']) }}";
                    url = url.replace(':id', id);
                    url = url.replace(':type', type);

                    // update values for all tasks
                    $.easyAjax({
                        url: url,
                        type: 'GET',
                        success: function (response) {
                        }
                    });
                }
            });
        }

        $(function () {
            // Getting Data of all colomn and applications
            boardStracture =  JSON.parse('{!! $boardStracture !!}');

            var oldParentId, oldElementIds = [], i = 1;
            $('.lobipanel').on('dragged.lobiPanel', function (e, a) {
                var $parent = $(this).parent(),
                    $children = $parent.children();
                var pr = $(this).closest('.board-column'),
                    c = pr.find('.custom-column');

                if (i++ % 2) {
                    oldParentId = pr.data('column-id');
                    $children.each(function (ind, el) {
                        oldElementIds.push($(el).data('application-id'));
                    });
                    return true;
                }
                var currentParentId = pr.data('column-id');
                var currentElementIds = [];
                $children.each(function (ind, el) {
                    currentElementIds.push($(el).data('application-id'));
                });

                var oldOriginalIds = boardStracture[oldParentId];

                var range = oldOriginalIds.length;
                var missingElementId;
                for (var j = 0; j < range; j++) {
                    if (oldOriginalIds[j] !== oldElementIds[j]) {
                        missingElementId = oldOriginalIds[j];
                        break;
                    }
                }

                boardStracture[oldParentId] = oldElementIds.slice(0, -1);
                boardStracture[currentParentId] = currentElementIds.slice(0, -1);
                var boardColumnIds = [];
                var applicationIds = [];
                var prioritys = [];

                $children.each(function (ind, el) {
                    boardColumnIds.push($(el).closest('.board-column').data('column-id'));
                    applicationIds.push($(el).data('application-id'));
                    prioritys.push($(el).index());
                });

                if(oldParentId == 3 && currentParentId == 4){
                    $('#buttonBox' + oldParentId + missingElementId).show();
                    var button  = '<button onclick="sendReminder('+ missingElementId +', \'notify\')" type="button" class="btn btn-sm btn-info notify-button">@lang('app.notify')</button>';
                    $('#buttonBox' + oldParentId + missingElementId).html(button);
                    $('#buttonBox' + oldParentId + missingElementId).attr('id', 'buttonBox' + currentParentId + missingElementId);

                }else if(oldParentId == 4  && currentParentId == 3){
                    var timeStamp = $('#buttonBox' + oldParentId + missingElementId).data('timestamp');
                    var currentDate = {{$currentDate}};
                    if(currentDate < timeStamp){
                    $('#buttonBox' + oldParentId + missingElementId).show();
                    var button  = '<button onclick="sendReminder('+ missingElementId +', \'reminder\')" type="button" class="btn btn-sm btn-info notify-button">@lang('app.reminder')</button>';
                    $('#buttonBox' + oldParentId + missingElementId).html(button);
                        $('#buttonBox' + oldParentId + missingElementId).attr('id', 'buttonBox' + currentParentId + missingElementId);
                    }
                }else{
                    $('#buttonBox' + oldParentId + missingElementId).attr('id', 'buttonBox' + currentParentId + missingElementId);
                    $('#buttonBox' + currentParentId + missingElementId).hide();
                }

                // update values for all tasks
                $.easyAjax({
                    url: '{{ route("admin.job-applications.updateIndex") }}',
                    type: 'POST',
                    data: {
                        boardColumnIds: boardColumnIds,
                        applicationIds: applicationIds,
                        prioritys: prioritys,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function (response) {
                    }
                });
                oldParentId = null; oldElementIds = []; currentParentId = null; currentElementIds = [];


            }).lobiPanel({
                sortable: true,
                reload: false,
                editTitle: false,
                close: false,
                minimize: false,
                unpin: false,
                expand: false

            });

        });
    </script>
    <script>
        $('body').on('click','.share-application',function(event){
            var applicantID = $(this).data('application-id');
            $('#applicantID').val(applicantID);
        });

        $('body').on('click', '.show-detail', function (event) {
            if($(event.target).hasClass('notify-button')){
               return false;
            }


            $(".right-sidebar").slideDown(50).addClass("shw-rside");

            var id = $(this).data('row-id');
            var url = "{{ route('admin.pipeline.show',':id') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                type: 'GET',
                url: url,
                success: function (response) {
                    if (response.status == "success") {
                        $('#right-sidebar-content').html(response.view);
                    }
                }
            });
        })
        // job-applications.create-schedule
    </script>

    <script>
        @if(session()->has('success'))
            swal({
                title: "Succeed!",
                text: "Email has been sent!",
                type: "success"
            });
        @endif
    </script>
@endpush