@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/node_modules/html5-editor/bootstrap-wysihtml5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/all.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.tagsinput.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endpush

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

        input{
            height:38px;
        }

        .content-header{
            display:none;
        }

        .teamMem .select2-search__field{
            height:100% !important;
        }

        .card{
            margin-top:5px;
        }

        .select2-selection  {
            height:40px !important;
        }

        .checkbox {
            display: inline-block;
            vertical-align: top;
            padding-left: 25px;
            position: relative;
        }

        .checkbox input {
            position: absolute;
            left: 0;
            top: 0;
        }

        .tagsinput{
            width:100% !important;
        }

        .assessmentsGroupBox {
            max-width: 1000px!important;
        }

        i{
            cursor:pointer !important;
        }
    </style>


<div id="myModalYY" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Question</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>

      </div>
      <div class="modal-body editBody">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

    <div class="row">
        @include('admin.jobs.include.sidebar')

        <div class="col-10">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4"><b>Create New Job Position</b></h4>

                    <form class="ajax-form" method="POST" id="createForm">
                        @csrf

                        <input name="_method" type="hidden" value="PUT">

                        <div class="row" >


                            <div class="col-md-4" style="display:none">

                                <div class="form-group">
                                    <label for="address">Job Title</label>
                                    <input type="text" value="{{$job->title}}" class="form-control" name="title" placeholder="e.g. Software Developer">
                                </div>

                            </div>

                            <div class="col-md-4" style="display:none">
                                <div class="form-group">
                                    <label for="address">@lang('menu.jobCategories')</label>
                                    <select name="category_id" id="category_id"
                                            class="form-control">
                                        <option value="">@lang('app.choose') @lang('menu.jobCategories')</option>
                                        @foreach($categories as $category)
                                            @if($job->category_id == $category->id)
                                                <option selected value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
                                            @else
                                                <option value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4" style="display:none">
                                <div class="form-group">
                                    <label for="jobType">Job Type</label>
                                    <select name="job_type" id="job_type" class="form-control">
                                        <option value="">Choose Job Type</option>

                                        @if($job->job_type == "Full-Time")
                                            <option selected value="Full-Time">Full-Time</option>
                                        @else
                                            <option value="Full-Time">Full-Time</option>
                                        @endif

                                        @if($job->job_type == "Part-Time")
                                            <option selected value="Part-Time">Part-Time</option>
                                        @else
                                            <option value="Part-Time">Part-Time</option>
                                        @endif

                                        @if($job->job_type == "Contract")
                                            <option selected value="Contract">Contract</option>
                                        @else
                                            <option value="Contract">Contract</option>
                                        @endif

                                        @if($job->job_type == "Freelance")
                                            <option selected value="Freelance">Freelance</option>
                                        @else
                                            <option value="Freelance">Freelance</option>
                                        @endif

                                        @if($job->job_type == "Internship")
                                            <option selected value="Internship">Internship</option>
                                        @else
                                            <option value="Internship">Internship</option>
                                        @endif

                                        @if($job->job_type == "Traineeship")
                                            <option selected value="Traineeship">Traineeship</option>
                                        @else
                                            <option value="Traineeship">Traineeship</option>
                                        @endif

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4" style="display:none">
                                <div class="form-group">
                                    <label for="address">@lang('modules.jobs.totalPositions')</label>
                                    <input value="{{$job->total_positions}}" type="number" class="form-control" name="total_positions" id="total_positions" placeholder="e.g. 5">
                                </div>
                            </div>

                            <div class="col-md-4" style="display:none">
                                <div class="form-group">
                                    <label for="salaryfrequency">Salary Frequency</label>
                                    <select name="salary_frequency" id="salary_frequency" class="form-control">
                                        <option value="">Choose Salary Frequency</option>

                                        @if($job->salary_frequency == "Annually")
                                            <option selected value="Annually">Annually</option>
                                        @else
                                            <option value="Annually">Annually</option>
                                        @endif

                                        @if($job->salary_frequency == "Monthly")
                                            <option selected value="Monthly">Monthly</option>
                                        @else
                                            <option value="Monthly">Monthly</option>
                                        @endif

                                        @if($job->salary_frequency == "Hourly")
                                            <option selected value="Hourly">Hourly</option>
                                        @else
                                            <option value="Hourly">Hourly</option>
                                        @endif

                                        @if($job->salary_frequency == "Project-Wise")
                                            <option selected value="Project-Wise">Project Wise</option>
                                        @else
                                            <option value="Project-Wise">Project Wise</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4" style="display:none">
                                <div class="form-group">
                                    <label for="salary">Salary</label>
                                    <input value="{{$job->salary}}" type="text" class="form-control" name="salary" id="salary" placeholder="e.g. $80,000">
                                </div>
                            </div>

                            <div class="col-md-4" style="display:none">
                                <div class="form-group">
                                    <label for="country">@lang('menu.locations')</label>
                                    <select name="country" id="country"
                                            class="form-control select2 custom-select">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                        @if($job->job_country == $country->country_name)
                                            <option selected value="{{ $country->country_name }}">{{ ucfirst($country->country_name) }}</option>
                                        @else
                                            @if($country->country_name == "United States")
                                                <option selected value="{{ $country->country_name }}">{{ ucfirst($country->country_name) }}</option>
                                            @else
                                                <option value="{{ $country->country_name }}">{{ ucfirst($country->country_name) }}</option>
                                            @endif
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4" style="display:none">
                                <div class="form-group">
                                    <label for="location">&nbsp;</label>
                                    <input value="{{$job->job_location}}" type="text" class="form-control" name="location_id" id="location_id" placeholder="Job location (e.g. California)">
                                </div>
                            </div>

                            <div class="col-md-2" style="display: none">
                                <div class="form-group">
                                    <div class="inner"><br/>
                                        <label class="checkbox">
                                            @if($job->is_remote == "1")
                                                <input checked class="input-checkbox" name="is_remote" id="is_remote" type="checkbox">
                                            @else
                                                <input class="input-checkbox" name="is_remote" id="is_remote" type="checkbox">
                                            @endif
                                            <p style="font-weight:700;margin-top:10px;">Remote</p>
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4" style="display:none">
                                <div class="form-group">
                                    <label>@lang('menu.skills')</label>
                                    <input value="{{$job->skills}}"  id="job_skills" style="width: 100% !important;" name="job_skills">
                                    <p>Press "Enter" Key to add Skills</p> <br/>
                                </div>
                            </div>

                            {{-- <div class="col-md-4" style="display:none">
                                <div class="form-group">
                                    <label for="address">@lang('app.startDate')</label>
                                    <input type="text" class="form-control" id="date-start" name="start_date"
                                    value="{{ $job->start_date != null ? $job->start_date->format('Y-m-d'): \Carbon\Carbon::now()->format('Y-m-d') }}" >
                                </div>
                            </div>

                            <div class="col-md-4" style="display:none">
                                <div class="form-group">
                                    <label for="address">@lang('app.endDate')</label>
                                    <input type="text" class="form-control" id="date-end" name="end_date"
                                    value="{{ $job->end_date != null ? $job->end_date->format('Y-m-d'): \Carbon\Carbon::now()->addMonth(1)->format('Y-m-d') }}"
                                    >

                                </div>
                            </div> --}}



                            <div class="col-md-12" style="display:none">
                                <div class="form-group">
                                    <label for="address">@lang('modules.jobs.jobDescription')</label>
                                    <textarea value="{{$job->job_description}}" class="form-control" id="job_description" name="job_description" rows="15" placeholder="Enter Job Descrption">
                                        {{$job->job_description}}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-12" style="display:none">
                                <div class="form-group">
                                    <label for="address">@lang('modules.jobs.jobRequirement')</label>
                                    <textarea class="form-control" id="job_requirement" name="job_requirement" rows="15" placeholder="Enter Job Requirement">
                                        {{$job->job_requirement}}
                                    </textarea>
                                </div>
                            </div>

                            {{-- main --}}
                            <div class="col-md-4 teamMem">
                                <div class="form-group">
                                    <label for="address">Add Team Members</label>
                                    <select style="height:100% !important;" name="team_members[]" multiple="multiple"
                                            class="form-control team_members">
                                        <option></option>
                                        @foreach($users as $u)
                                            <option value="{{ $u->id }}">{{ ucfirst($u->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4"  style="display:none">
                                <div class="form-group">
                                    <label for="address">@lang('app.status')</label>
                                    <select name="status" id="status" class="form-control">
                                        @if($job->status == "active")
                                            <option selected value="active">@lang('app.active')</option>
                                        @else
                                            <option value="active">@lang('app.active')</option>
                                        @endif

                                        @if($job->status == "inactive")
                                            <option selected value="inactive">@lang('app.inactive')</option>
                                        @else
                                            <option value="inactive">@lang('app.inactive')</option>
                                        @endif


                                    </select>
                                </div>
                            </div>

                            <!-- <div class="col-md-4">
                                <div class="form-group text-center">
                                    <label for="address">Advertise Job (Free)</label>
                                    @if($job->advertise == "on")
                                    <input checked type="checkbox" name="advertise" style="width:15px;height:15px;margin-top:30px"/>
                                    @else
                                    <input type="checkbox" name="advertise" style="width:15px;height:15px;margin-top:30px"/>
                                    @endif


                                </div>
                            </div> -->
                            {{-- end main --}}

                            <hr>

                            <div class="col-md-12" style="display:none">
                                <label for="address">Assessments</label>
                                <div class="row">
                                    <div class="col-md-4">
                                    <a class="nav-link mb-3 p-3 shadow text-center" id="plusButton" >
                                            <span class="font-weight-bold big"><br/>
                                            <i class="fa fa-plus-circle fa-lg"> </i>
                                            <h4>Add Assessment from Library</h4>
                                            <br/>
                                         </a>

                                    </div>
                                    <div class="col-md-4">

                                    <a class="nav-link mb-3 p-3 shadow text-center" id="plusCButton" data-toggle="modal" data-target="#myModalX">
                                            <span class="font-weight-bold big"><br/>
                                            <i class="fa fa-plus-circle fa-lg"> </i>
                                            <h4>Add Custom Question</h4>
                                            <br/>
                                         </a>
                                    </div>


                                </div>

                            </div>



                            <div style="display: none">

                            @if($questions->count() > 0)
                                <div class="col-md-12 questionDiv" style="display:block">
                            @else
                                <div class="col-md-12 questionDiv" style="display:none">
                            @endif

                                <table class="table table-bordered qtbl">
                                    <thead>
                                        <th class='text-center'>S.N</th>
                                        <th class='text-center'>Question</th>
                                        <th class='text-center'>Answer Type</th>
                                        <th class='text-center'>Action</th>
                                    </thead>

                                    <tbody class='qtblBody'>
                                        <?php $ind = 1; ?>
                                        @if($questions->count() > 0)
                                        @foreach($questions as $qs)

                                        <tr id="{{$qs->id}}">
                                            <td  class="text-center"><i class="pull-left fa fa-sort fa-lg" aria-hidden="true"></i>
                                            {{$ind}}
                                            </td>
                                            <td>{{$qs->question}}</td>
                                            <td class="text-center">{{$qs->question_type}}</td>
                                            <td class="text-center">
                                            <i onclick="editQuestion({{$qs->id}})" class="fa fa-pencil fa-lg"></i> | <i
                                            onclick="deleteQuestion({{$qs->id}})" class="fa fa-trash fa-lg"></i>
                                            </td>
                                        </tr>
                                        <?php $ind = $ind + 1; ?>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <p>**Drag Rows to change question order</p>
                            </div>

                            </div>
                        </div>
                        <br />
                       <input type="hidden" name="page" value="{{ request('page') }}">

                        <!-- <button type="button" id="save-form" class="btn btn-success"><i
                                    class="fa fa-check"></i> @lang('app.save')</button> -->
                        <button type="button" id="save-next-form" class="btn btn-primary ml-2"><i
                                    class="fa fa-arrow-right"></i> Next</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- The Modal -->
<div class="modal" id="myModal" style="z-index:999999;">
  <div class="modal-dialog assessmentsGroupBox">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Select Assessments</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <div class="row modalbody">

           </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>

    </div>
  </div>
</div>


<div class="modal" id="myModalX">
  <div class="modal-dialog">
    <div class="modal-content">

    <form class="ajax-form" method="POST" id="customQuestion">
    @csrf

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Question</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="address">Write your question here</label>
                    <input value="{{$job->id}}" type="hidden" name="job_id" />
                    <input name="question" id="question" class="form-control" placeholder="Write your question here"></textarea>

                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="address">Answer Type</label>
                    <select  id="question_type"onchange="changeddl.call(this)" name="question_type" class="form-control question-type-ddl">
                        <option value="Text">Text</option>
                        <option value="Multiple">Multiple Choice</option>
                        <option value="Video">Video</option>
                        <option value="Audio">Audio</option>
                    </select>
                </div>
            </div>

            <div class="col-md-12" >
                <div class="form-group multiple-choice-div" style="display:none">
                    <div class="answerParentDiv">
                        <div class="row answerDiv">
                            <div class="col-md-6">
                                <input class="form-control Multiple" name="multiple[]" type="text" placeholder="Enter answer" /><br />
                            </div>
                            <div class="col-md-1 removeDivInter">

                            </div>
                        </div>
                    </div>
                    <a style="cursor:pointer;color:#0151ce" onclick="addAnswer.call(this)" class="addAnswer"><span class="fa fa-plus"></span> <b>Add Answer</b></a>
                </div>

            </div>

            <div class="col-md-9">
                <div class="form-group time_limit" style="display:none">
                    <label for="address">Max Recording time limit (in minutes)</label>
                    <input type="number" name="time_limit"  class="form-control time_input" placeholder="e.g. 5"></input>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="address">@lang('app.required')</label>
                    <select name="required" class="form-control">
                        <option value="yes">@lang('app.yes')</option>
                        <option value="no">@lang('app.no')</option>
                    </select>
                </div>
            </div>
      </div



      <!-- Modal footer -->
      <div class="modal-footer">
      <button type="button" class="btn btn-success" id="mSave">Add</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </form>
    </div>
  </div>
</div>




@endsection

@push('footer-script')
    <script src="{{ asset('assets/node_modules/html5-editor/wysihtml5-0.3.0.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/html5-editor/bootstrap-wysihtml5.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/moment/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}" type="text/javascript"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('js/jquery.tagsinput.js') }}"></script>

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>

            $('.team_members').val([
                @foreach($team as $t)
                   '{{$t->user_id}}',
                @endforeach]).change();



        $('tbody').sortable({
            start: function(event, ui) {
            oldIndex = ui.item.index();
        },
        stop: function(event, ui) {
            var newIndex = ui.item.index();
            var movingForward = newIndex > oldIndex;
            var nextIndex = newIndex + (movingForward ? -1 : 1);

            var items = $('#sortable > div');

            // Find the element to move
            var itemToMove = items.get(nextIndex);
            if (itemToMove) {

                // Find the element at the index where we want to move the itemToMove
                var newLocation = $(items.get(oldIndex));

                // Decide if it goes before or after
                if (movingForward) {
                    $(itemToMove).insertBefore(newLocation);
                } else {
                    $(itemToMove).insertAfter(newLocation);
                }
            }
        },
            update: function( event, ui ) {
                $('.qtbl > tbody  > tr').each(function(index, tr) {
                    $this = $(this)
                    $this.find('td:first-child').html('<i class="pull-left fa fa-sort fa-lg" aria-hidden="true"></i> '+(index+1))
                });

                var job_id = '{{$job->id}}';
                var question_id = ui.item.attr("id");
                var order_no = Number($("#"+ui.item.attr("id")).index())+1;
                $.ajax({
                    url:'/admin/jobs/changeOrder?job_id='+job_id+'&question_id='+question_id+'&order_no='+order_no,
                    type:'GET',
                    success:function(){

                    }
                })
            }
        });

        var is_rem = '{{$job->is_remote}}'

        if(is_rem == "1"){
            $("#country").attr("disabled","disabled")
            $("#location_id").attr("disabled","disabled")
            $("#location_id").val("")
        }

        $('#job_skills').tagsInput();

        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
        })

        $("#plusCButton").on('click',function(){
            $("#question").val("")
            $("#question_type").val("Text")

            $("#required").val("yes")
            $(".multiple-choice-div").css("display","none")
            $(".time_limit").css("display","none")
            $(".Multiple").val("")
            $(".time_input").val("")
        })

        // For select 2
        $(".select2").select2();

        $(".team_members").select2({
            placeholder: "Choose Team Members",
            theme: "classic"
        })

        $('#date-end').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
        $('#date-start').bootstrapMaterialDatePicker({ weekStart : 0, time: false }).on('change', function(e, date)
        {
            $('#date-end').bootstrapMaterialDatePicker('setMinDate', date);
        });

        var jobDescription = $('#job_description').wysihtml5({
            "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
            "emphasis": true, //Italics, bold, etc. Default true
            "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
            "html": true, //Button which allows you to edit the generated HTML. Default false
            "link": true, //Button to insert a link. Default true
            "image": true, //Button to insert an image. Default true,
            "color": true, //Button to change color of font
            stylesheets: ["{{ asset('assets/node_modules/html5-editor/wysiwyg-color.css') }}"], // (path_to_project/lib/css/wysiwyg-color.css)
        });

        $('#job_requirement').wysihtml5({
            "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
            "emphasis": true, //Italics, bold, etc. Default true
            "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
            "html": true, //Button which allows you to edit the generated HTML. Default false
            "link": true, //Button to insert a link. Default true
            "image": true, //Button to insert an image. Default true,
            "color": true, //Button to change color of font
            stylesheets: ["{{ asset('assets/node_modules/html5-editor/wysiwyg-color.css') }}"], // (path_to_project/lib/css/wysiwyg-color.css)

        });



        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route('admin.jobs.update',$job->id)}}',
                container: '#createForm',
                type: "POST",
                redirect: true,
                data: $('#createForm').serialize()
            })
        });
        $('#save-next-form').click(function () {
            $.easyAjax({
                url: '{{route('admin.jobs.update',$job->id)}}',
                container: '#createForm',
                type: "POST",
                redirect: true,
                data: $('#createForm').serialize(),
                success:function(data){
                    var url = "/admin/jobs/show?id={{ $job->id }}&page=4";
                        window.location.href = url;
                }
            })
        });
        $("#is_remote").on('click',function(){
           var isChecked = $('#is_remote').prop("checked") ? 1 : 0 ;
           if(isChecked == 1){
               $("#country").attr("disabled","disabled")
               $("#location_id").attr("disabled","disabled")
               $("#location_id").val("")
           }else{
               $("#country").removeAttr("disabled","disabled")
               $("#location_id").removeAttr("disabled","disabled")
           }
        })

        $("#job_description").data("wysihtml5").editor.on("change",function(){
            var html = this.textarea.getValue();
            var check = html.length;
            if(check > 30000 )
            {
                alert("Please enter limited values.");
            }

        })

        $("#job_requirement").data("wysihtml5").editor.on("change",function(){
            var html = this.textarea.getValue();
            var check = html.length;
            if(check > 30000 )
            {
                alert("Please enter limited values.");
            }
        })

        function changeddl(){
            debugger;
            var ddlVal = $(this).val()
            var parentMultiple = $(this).parent().parent().parent().find(".multiple-choice-div")
            var parentLength = $(this).parent().parent().parent().find(".time_limit")

            if(ddlVal == "Multiple"){
                $(".multiple-choice-div").css("display","block")
            }else {
                $(".multiple-choice-div").css("display","none")
            }

            if(ddlVal == "Audio" || ddlVal == "Video"){
                $(".time_limit").css("display","block")
            }else {
                $(".time_limit").css("display","none")
            }

        }




        function addQuestion(id){
            $("#myModal").modal('hide')
            $(".questionDiv").css("display","block")

            var job_id = '{{$job->id}}'

            var url = '/admin/assessments/fetchAssessementQuestion?id='+id+'&job_id='+job_id


            $.easyAjax({
                type: 'GET',
                url: url,
                success: function (response) {
                    $(response).each(function(i,v){
                        var tdLength = $(".qtblBody tr").length
                        var html = '<tr class="ui-state-default" id="'+v.id+'">'+
                        '<td class="text-center"><i class="pull-left fa fa-sort fa-lg" aria-hidden="true"></i>'+(tdLength+1)+'</td>'+
                        '<td>'+v.question+'</td>'+
                        '<td class="text-center">'+v.question_type+'</td>'+
                        '<td class="text-center"><i onclick="editQuestion('+v.id+')" class="fa fa-pencil fa-lg"></i> | <i '+
                        ' onclick="deleteQuestion('+v.id+')" class="fa fa-trash fa-lg"></i></td></tr>'
                        $(".qtblBody").append(html)
                    })
                }
            });
        }

        function deleteQuestion(id){
            $("#"+id).remove();

            $('.qtbl > tbody  > tr').each(function(index, tr) {
                    $this = $(this)
                    $this.find('td:first-child').html('<i class="pull-left fa fa-sort fa-lg" aria-hidden="true"></i> '+(index+1))
                });

            var url = "{{ route('admin.questions.destroyAssQuestion',':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {'_token': token, '_method': 'DELETE'},
                        success: function (response) {
                            if (response.status == "success") {

                            }
                        }
                    });
        }


        function editQuestion(id){
            $("#myModalYY").modal('show')

           $.ajax({
               url: '/admin/jobs/editQuestion?id='+id,
               type:'get',
               success:function(response){
                $(".editBody").children().remove()
                $(".editBody").append(response)

               }
           })
        }

        function updateform(id) {
                $.easyAjax({
                    url: '/admin/questions/update?id='+id,
                    container: '#createFormEdit',
                    type: "POST",
                    redirect: true,
                    data: $('#createFormEdit').serialize(),
                    success:function(){
                        var question =  $("#equestion").val()
                        var question_type= $("#equestiontype").val()

                        $("#"+id).find('td:eq(1)').text(question)
                        $("#"+id).find('td:eq(2)').text(question_type)
                    }
                })
        };




        $("#mSave").on('click',function(){
            var question=$("#question").val()
            var question_type=$("#question_type").val()
            var is_req = $("#required").val()

            var tdLength = $(".qtblBody tr").length

            $(".questionDiv").css("display","block")

            $.easyAjax({
                url: '{{route('admin.questions.store')}}',
                container: '#customQuestion',
                type: "POST",
                redirect: false,
                data: $('#customQuestion').serialize(),
                success:function(response){

                    var tbbb = '<tr id='+response.title+'><td class="text-center"><i class="pull-left fa fa-sort fa-lg" aria-hidden="true"></i>'+(tdLength+1)+'</td>'+
                                '<td>'+question+'</td><td class="text-center">'+question_type+'</td>'+
                                '<td class="text-center"><i onclick="editQuestion('+response.title+')" class="fa fa-pencil fa-lg"></i> | <i '+
                                                            'onclick="deleteQuestion('+response.title+')" class="fa fa-trash fa-lg"></i></td></tr>'
                                $(".qtblBody").append(tbbb)
                }
            })



            $("#myModalX").modal('hide')


        })

        function addAnswer(){

            var answerLength = $(".answerDiv").length

            var ansLength = answerLength + 1
            var newName = "multiple["+ansLength +"]"
            var clone = $( ".answerDiv:first").clone(true).find("input").val("").end()
            clone.find('.Multiple').prop('name', newName);
            clone.find(".removeDivInter").append('<span style="font-size:30px;margin-top:7px;cursor:pointer;color:red;" onclick="removeAnswer($(this))" class="fa fa-times-circle-o fa-lg removeAnswer"></span> </br>')
            clone.appendTo(".answerParentDiv");

        }

        function removeAnswer(obj){
            obj.parent().parent().remove()
        }

        $("#plusButton").on('click',function(){
            $("#myModal").modal('show')
            var url = '/admin/assessments/fetchassessments'
            $(".assessment_boxes").remove()
            $.easyAjax({
                type: 'GET',
                url: url,
                success: function (response) {
                    $(response).each(function(i,v){
                        var html = '<div style="cursor:pointer;" class="col-md-4 assessment_boxes" style="padding:20px;">'+
                                        '<div class="nav flex-column nav-pills nav-pills-custom" id="v-pills-tab" role="tablist" aria-orientation="vertical">'+
                                        '<a class="nav-link mb-3 p-3 shadow" id="plusButton" onclick="addQuestion('+ v.id +')">'+
                                            '<span class="font-weight-bold big"><br/>'+
                                            '<h2>'+v.name+'</h2><hr/>'+
                                            '<h5> Summary </h5></span>'+
                                            '<p style="color:black">'+v.summary+'</p><hr/>'+
                                            '<h5> Questions </h5></span>'+
                                            '<p style="color:black">'+v.count+'</p><hr/>'+
                                            '<h5> Created <span style="color:black">&nbsp;&nbsp;'+v.created_at+'</span></h5></span>'+
                                            '</a>'+
                                        '</div>'+
                                    '</div>'
                        $(".modalbody").append(html)
                    })
                }
            });
        })

    </script>
@endpush
