@extends('layouts.app')

@if($company_id != 9)
@section('content')

<style>
    .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 30px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.tooltip {
   font-family: Arial,sans-serif !important;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 22px;
  width: 23px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

        #dataRow a{
            cursor:pointer;
        }

        .jobStatusCss{
            margin-right:10px;
        }

        #dataRow a:hover{
            color:#41afe9 !important;
            text-decoration:none ;
        }

        #dataRow{
            padding:10px 10px 10px 10px;
        }

        #statList{
             padding:20px 10px 0px 10px !important;
        }

        .statNumber{
            font-size:18px;
        }

        .statmetrics li {
            display: inline-block;
            text-align: center;
            margin-right:30px;
        }

        .statmetrics li h2 {
            display: inline-block;
            position: relative;
            font-size: 30px;
            line-height: 36px;
        }

        .statmetrics li p {
            text-align: left;
            display: inline-block;
            font-size: 12px;
            line-height: 1.3;
            white-space: nowrap;
            color: #84929f;
        }

        .content-header{
            display:none;
        }
    </style>

    <div class="row" id="statList">
        <div class="col-md-2 d-flex">
             <h3>Dashboard</h3>
             @if($user->package!='free')
             <span class="badge badge-info" style="align-self: end">{{ $subscription['plan']['name']}}</span>
             @else
             <span class="badge badge-info" style="align-self: end">Free</span>
             @endif
             {{-- <a style="color: #f36421" href="#">Upgrade</a> --}}
        </div>
        <div class="col-md-10">
            <ul class="statmetrics pull-right">
            <li>
                <h2>
                    {{ $totalOpenings }}
                    <p>
                        Total <br/>Openings
                    </p>
                </h2>
            </li>
              <li>
                <h2>
                    {{ $totalApplications }}
                    <p>
                        Total <br/>Applications
                    </p>
                </h2>
            </li>

            <li>
                <h2>
                    {{ $newApplications }}
                    <p>
                        New <br/>Applications
                    </p>
                </h2>
            </li>

            <li>
                <h2>
                    {{ $shortlisted }}
                    <p>
                        Shortlisted <br/>Candidates
                    </p>
                </h2>
            </li>
              <li>
                <h2>
                    {{ $totalHired }}
                    <p>
                        Total <br/>Hired
                    </p>
                </h2>
            </li>

              <li>
                <h2>
                    {{ $totalTodayInterview }}
                    <p>
                        Interviews <br/>Today
                    </p>
                </h2>
            </li>
        </ul>
        </div>
    </div>


    <div class="row" id="dataRow">
        <div class="col-md-8">
            @foreach($jobs as $job)
            <a href="{{ route('admin.pipeline.pipeline',$job->id) }}">
            <div class="card" >
                <div class="card-body">
                    <h4>
                        {{$job->title}}

                        <a class="btn btn-primary pull-right" href="/admin/jobs/show?id={{$job->id}}&page=1" target="_blank">
                            <span style="color:white;" class="fa fa-cog fa-lg"></span>
                        </a>

                        @if($job->status == "active")
                         <button disabled class="btn btn-success pull-right jobStatusCss">Active</button>
                        @else
                         <button disabled class="btn btn-danger pull-right jobStatusCss">Closed</button>
                        @endif

                        <a style="position: relative!important" class="btn btn-primary pull-right mr-3" href="{{ route('admin.pipeline.pipeline',$job->id) }}">
                            <span class="badge badge-warning navbar-badge ">{{ count($jobApplications->where('job_id',$job->id)->where('seen','!=',1)) }}</span>

                            <span style="color:white;"  class="fa fa-bell-o"></span>
                        </a>

                    </h4>
                    <p>
                       <span class="fa fa-map-marker"></span>
                        @if($job->is_remote == 1)
                            <span>Remote</span>
                        @else
                            <span>{{$job->job_location}}, {{$job->job_country}}</span>
                        @endif
                       <br />
                    </p>

                    <p>
                       @foreach($teams as $t)
                       @if($t->job_id == $job->id)
                            <span data-toggle="tooltip" title="{{$t->name}}" data-placement="bottom" class="badge badge-secondary">{{substr($t->name, 0, 1)}}</span>&nbsp;
                       @endif
                       @endforeach

                       @if($job->status == "active")
                            <a class="pull-right" style="color:#192739;font-weight:600;" target="_blank" href="/job/{{$job->slug}}">View Posting</a>
                        @else

                        @endif

                    </p>
                </div>
            </div>
            </a>
            @endforeach
        </div>
         <div class="col-md-4">
             @if($user->package!='free')
            <div class="card">
                <div class="card-header d-flex p-0 ui-sortable-handle">
                    <h3 class="card-title p-3">
                        <i class="fa fa-info-circle"></i> Plan Details
                    </h3>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <h5>Expiry Date: {{ $expiryDate }}</h5>
                    <h5>Current Plan: {{ $subscription['plan']['name'] }}</h5>
                    <hr>
                    <h4>Total Amount Paid: ${{ $amountPaid/100 }}</h4>
                </div><!-- /.card-body -->
            </div>
            @endif
            <div class="card">
                <div class="card-header d-flex p-0 ui-sortable-handle">
                    <h3 class="card-title p-3">
                        <i class="fa fa-file"></i> @lang('modules.interviewSchedule.interviewSchedule')
                    </h3>
                </div><!-- /.card-header -->
                <div class="card-body">
                        @forelse($upComingSchedules as $key => $upComingSchedule)
                            <div>
                                @php
                                    $date = \Carbon\Carbon::createFromFormat('Y-m-d', $key);
                                @endphp
                                <h4>{{ $date->format('M d, Y') }}</h4>


                                <ul class="scheduleul">
                                    @forelse($upComingSchedule as $key => $dtData)

                                        <li class="deco" id="schedule-{{$dtData->id}}" onclick="getScheduleDetail(event, {{$dtData->id}}) "
                                            style="list-style: none;">
                                            <h5 class="text-muted"
                                                style="float: left">{{ ucfirst($dtData->title) }} </h5>
                                            <div class="pull-right">
                                                @if($user->can('edit_schedule'))
                                                    <span style="margin-right: 15px;">
                                                        <button onclick="editUpcomingSchedule(event, '{{ $dtData->id }}')"
                                                                class="btn btn-sm btn-info notify-button editSchedule"
                                                                title="Edit"> <i class="fa fa-pencil"></i></button>
                                                    </span>
                                                @endif
                                                @if($user->can('delete_schedule'))
                                                    <span style="margin-right: 15px;">
                                                        <button data-schedule-id="{{ $dtData->id }}"
                                                                class="btn btn-sm btn-danger notify-button deleteSchedule"
                                                                title="Delete"> <i class="fa fa-trash"></i></button>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="direct-chat-name"
                                                 style="font-size: 13px">{{ ucfirst($dtData->full_name) }}</div>
                                            <span class="direct-chat-timestamp"
                                                  style="font-size: 13px">{{ $dtData->schedule_date->format('h:i a') }}</span>

                                                @if(in_array($user->id, $dtData->employee->pluck('user_id')->toArray()))
                                                @php
                                                    $empData = $dtData->employeeData($user->id);
                                                @endphp

                                                @if($empData->user_accept_status == 'accept')
                                                    <label class="badge badge-success float-right">@lang('app.accepted')</label>
                                                @elseif($empData->user_accept_status == 'refuse')
                                                    <label class="badge badge-danger float-right">@lang('app.refused')</label>
                                                @else
                                                    <span class="float-right">
                                                        <button onclick="employeeResponse({{$empData->id}}, 'accept')"
                                                                class="btn btn-sm btn-success notify-button responseButton">@lang('app.accept')</button>
                                                        <button onclick="employeeResponse({{$empData->id}}, 'refuse')"
                                                                class="btn btn-sm btn-danger notify-button responseButton">@lang('app.refuse')</button>
                                                    </span>
                                                @endif
                                            @endif
                                        </li>
                                        @if($key != (count($upComingSchedule)-1))
                                            <hr>@endif
                                    @empty

                                    @endforelse
                                </ul>

                            </div>
                            <hr>
                        @empty
                            <div>
                                <p>@lang('messages.noUpcomingScheduleFund')</p>
                            </div>
                        @endforelse
                </div><!-- /.card-body -->
            </div>
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

    {{--Ajax Modal Start for--}}
    <div class="modal fade bs-modal-md in" id="scheduleEditModal" role="dialog" aria-labelledby="myModalLabel"
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


    <!--First Time Login Modal -->
    <div class="modal fade" id="firstTimeLogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Welcome to Hireworks</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            This is your first time logging in. You can update your business settings by clicking <a href="/admin/settings/settings">here</a>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Skip for Now</button>
        </div>
        </div>
    </div>
    </div>

@endsection

@push('footer-script')
    <script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/bootstrap-select/bootstrap-select.min.js') }}"
            type="text/javascript"></script>
    <script src="//cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script src="{{ asset('assets/node_modules/moment/moment.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/plugins/calendar/dist/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/calendar/dist/jquery.fullcalendar.js') }}"></script>
    <script src="{{ asset('assets/plugins/calendar/dist/locale-all.js') }}"></script>

    <script>
            $('[data-toggle="tooltip"]').tooltip();

            $('input[type="checkbox"]').click(function(){

                if($(this).prop("checked") == true){
                    setTimeout(
                        function()
                        {
                            alert("Your Job has been advertised to LinkedIn")
                        }, 500);
                }
                else if($(this).prop("checked") == false){

                }


            });


        $(document).ready(function(){
            var isFirstTimeLogin = '{{$first_time_login}}'
            if(isFirstTimeLogin == "0"){
                $('#firstTimeLogin').modal('show');


                $.ajax({
                    url :'{{route('admin.dashboard.firstLogin')}}',
                    type: "GET",
                    success: function (response) {

                    }
                })
            }
        })
    </script>

    <script>
        userCanAdd = false;
        userCanEdit = false;
        @if($user->can('add_schedule'))
            userCanAdd = true;
        @endif
        @if($user->can('edit_schedule'))
            userCanEdit = true;
        @endif
        taskEvents = [
                @foreach($schedules as $schedule)
            {
                id: '{{ ucfirst($schedule->id) }}',
                title: '{{ $schedule->title }} on {{ $schedule->full_name }}',
                start: '{{ $schedule->schedule_date }}',
                end: '{{ $schedule->schedule_date }}',
            },
            @endforeach
        ];
    </script>
    <script src="{{ asset('js/schedule-calendar.js') }}"></script>

    <script>
        // Schedule create modal view

        @if($user->can('edit_schedule'))
        // Schedule create modal view
        function editUpcomingSchedule(event, id) {
            if (!$(event.target).closest('.editSchedule').length) {
                return false;
            }
            var url = "{{ route('admin.interview-schedule.edit',':id') }}";
            url = url.replace(':id', id);
            $('#modelHeading').html('Schedule');
            $('#scheduleEditModal').modal('hide');
            $.ajaxModal('#scheduleEditModal', url);
        }
        @endif

        // Update Schedule
        function reloadSchedule() {
            $.easyAjax({
                url: '{{route('admin.interview-schedule.index')}}',
                container: '#updateSchedule',
                type: "GET",
                success: function (response) {
                    $('.upcomingdata').html(response.data);

                    taskEvents = [];
                    response.scheduleData.forEach(function(schedule){
                        const taskEvent = {
                            id: schedule.id,
                            title: schedule.title +' on '+  schedule.full_name ,
                            start: schedule.schedule_date ,
                            end: schedule.schedule_date,
                        };
                        taskEvents.push(taskEvent);
                    });

                    $.CalendarApp.reInit();
                }
            })
        }
        @if($user->can('delete_schedule'))
        $('body').on('click', '.deleteSchedule', function (event) {
            var id = $(this).data('schedule-id');
            if (!$(event.target).closest('.deleteSchedule').length) {
                return false;
            }
            swal({
                title: "@lang('errors.areYouSure')",
                text: "@lang('errors.deleteWarning')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('app.delete')",
                cancelButtonText: "@lang('app.cancel')",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {

                    var url = "{{ route('admin.interview-schedule.destroy',':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {'_token': token, '_method': 'DELETE'},
                        success: function (response) {
                            if (response.status == "success") {
                                $.unblockUI();
                                $('#schedule-'+id).remove();
                                // Schedule create modal view
                                reloadSchedule();
                            }
                        }
                    });
                }
            });
        });
        @endif
        // Employee Response on schedule
        function employeeResponse(id, type) {
            var msg;

            if (type == 'accept') {
                msg = "@lang('errors.acceptSchedule')";
            } else {
                msg = "@lang('errors.refuseSchedule')";
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
            }, function (isConfirm) {
                if (isConfirm) {
                    var url = "{{ route('admin.interview-schedule.response',[':id',':type']) }}";
                    url = url.replace(':id', id);
                    url = url.replace(':type', type);

                    // update values for all tasks
                    $.easyAjax({
                        url: url,
                        type: 'GET',
                        success: function (response) {
                            if (response.status == 'success') {
                                window.location.reload();
                            }
                        }
                    });
                }
            });
        }

        // schedule detail
        var getScheduleDetail = function (event, id) {

            if ($(event.target).closest('.editSchedule, .deleteSchedule, .responseButton').length) {
                return false;
            }

            var url = '{{ route('admin.interview-schedule.show', ':id')}}';
            url = url.replace(':id', id);

            $('#modelHeading').html('Schedule');
            $.ajaxModal('#scheduleDetailModal', url);
        }
        @if($user->can('add_schedule'))

        // Schedule create modal view
        function createSchedule(scheduleDate) {
            if (typeof scheduleDate === "undefined") {
                scheduleDate = '';
            }
            var url = '{{ route('admin.interview-schedule.create')}}?date=' + scheduleDate;
            $('#modelHeading').html('Schedule');
            $.ajaxModal('#scheduleDetailModal', url);
        }
        @endif

        @if($user->can('add_schedule'))
            function addScheduleModal(start, end, allDay) {
            var scheduleDate;
            if (start) {
                var sd = new Date(start);
                var curr_date = sd.getDate();
                if (curr_date < 10) {
                    curr_date = '0' + curr_date;
                }
                var curr_month = sd.getMonth();
                curr_month = curr_month + 1;
                if (curr_month < 10) {
                    curr_month = '0' + curr_month;
                }
                var curr_year = sd.getFullYear();
                scheduleDate = curr_year + '-' + curr_month + '-' + curr_date;
            }

            createSchedule(scheduleDate);
        }
        @endif
    </script>
@endpush


@else
@section('content')
<style>
    .mt-2{
        display:none !important;
    }
</style>
<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-primary"><i class="icon-badge"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">@lang('modules.dashboard.totalCompanies')</span>
                <span class="info-box-number">{{ number_format($totalCompanies) }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-success"><i class="icon-badge"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">@lang('modules.dashboard.activeCompanies')</span>
                <span class="info-box-number">{{ number_format($activeCompanies) }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-danger"><i class="icon-badge"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">@lang('modules.dashboard.inactiveCompanies')</span>
                <span class="info-box-number">{{ number_format($inactiveCompanies) }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>
<div class="row">

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-40">
                    <table id="myTable" class="table table-bordered table-striped ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('modules.accountSettings.companyLogo')</th>
                                <th>@lang('menu.companies')</th>
                                <th>@lang('modules.accountSettings.companyEmail')</th>
                                <th>@lang('app.status')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
 @push('footer-script')
<script src="//cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

<script>

    var table = $('#myTable').dataTable({
            responsive: true,
            // processing: true,
            serverSide: true,
            ajax: '{!! route('admin.company.data') !!}',
            language: {
                "url": "<?php echo __("app.datatable") ?>"
            },
            "fnDrawCallback": function( oSettings ) {
                $("body").tooltip({
                    selector: '[data-toggle="tooltip"]'
                });
            },
            columns: [
                { data: 'DT_Row_Index'},
                { data: 'logo', name: 'logo' },
                { data: 'company_name', name: 'company_name' },
                { data: 'company_email', name: 'company_email' },
                { data: 'status', name: 'status' }
            ]
        });

        new $.fn.dataTable.FixedHeader( table );

        $('body').on('click', '.sa-params', function(){
            var id = $(this).data('row-id');
            swal({
                title: "@lang('errors.areYouSure')",
                text: "@lang('errors.deleteWarning')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('app.delete')",
                cancelButtonText: "@lang('app.cancel')",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if (isConfirm) {

                    var url = "{{ route('admin.company.destroy',':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {'_token': token, '_method': 'DELETE'},
                        success: function (response) {
                            if (response.status == "success") {
                                $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
                                table._fnDraw();
                            }
                        }
                    });
                }
            });
        });
</script>

@endpush
@endif