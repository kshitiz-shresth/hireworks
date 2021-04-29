@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/node_modules/html5-editor/bootstrap-wysihtml5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/node_modules/multiselect/css/multi-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/all.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.tagsinput.css') }}" />
@endpush

@section('content')

    <style>
        input,select{
            height:40px !important;
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
    </style>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">@lang('app.createNew')</h4>

                    <form class="ajax-form" method="POST" id="createForm">
                        @csrf

                        <div class="row" >
                            <div class="col-md-12" style="display:none;">

                                <div class="form-group">
                                    <label for="address">@lang('app.company')</label>
                                    <select name="company" class="form-control">
                                        @foreach ($companies as $comp)
                                            <option value="{{ $comp->id }}">{{ ucwords($comp->company_name) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="form-group">
                                    <label for="address">@lang('modules.jobs.jobTitle')</label>
                                    <input type="text" class="form-control" name="title" placeholder="e.g. Software Developer">
                                </div>

                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="address">@lang('menu.jobCategories')</label>
                                    <select name="category_id" id="category_id"
                                            class="form-control">
                                        <option value="">@lang('app.choose') @lang('menu.jobCategories')</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jobType">Job Type</label>
                                    <select name="job_type" id="job_type" class="form-control">
                                        <option value="">Choose Job Type</option>
                                        <option value="Full-Time">Full-Time</option>
                                        <option value="Part-Time">Part-Time</option>
                                        <option value="Contract">Contract</option>
                                        <option value="Freelance">Freelance</option>
                                        <option value="Internship">Internship</option>
                                        <option value="Traineeship">Traineeship</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="address">@lang('modules.jobs.totalPositions')</label>
                                    <input type="number" class="form-control" name="total_positions" id="total_positions" placeholder="e.g. 5">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="salaryfrequency">Salary Frequency</label>
                                    <select name="salary_frequency" id="salary_frequency" class="form-control">
                                        <option value="">Choose Salary Frequency</option>
                                        <option value="Annually">Annually</option>
                                        <option value="Monthly">Monthly</option>
                                        <option value="Hourly">Hourly</option>
                                        <option value="Project-Wise">Project Wise</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="salary">Salary</label>
                                    <input type="text" class="form-control" name="salary" id="salary" placeholder="e.g. $80,000">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="country">@lang('menu.locations')</label>
                                    <select name="country" id="country"
                                            class="form-control select2 custom-select">
                                        <option value="">Select Country</option> 
                                        @foreach($countries as $country)
                                            <option value="{{ $country->country_name }}">{{ ucfirst($country->country_name) }}</option>        
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="location">&nbsp;</label>
                                    <input type="text" class="form-control" name="location_id" id="location_id" placeholder="Job location (e.g. California)">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="inner"><br/>
                                        <label class="checkbox">
                                            <input class="input-checkbox" name="is_remote" id="is_remote" type="checkbox">
                                            <p style="font-weight:700;margin-top:10px;">Remote</p>
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('menu.skills')</label>
                                    <input  id="job_skills" style="width: 100% !important;" name="job_skills">
                                    <p>Press "Enter" Key to add Skills</p> <br/>
                                </div>
                            </div>

                            {{-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="address">@lang('app.startDate')</label>
                                    <input type="text" class="form-control" id="date-start" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" name="start_date">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="address">@lang('app.endDate')</label>
                                    <input type="text" class="form-control" id="date-end" name="end_date" value="{{ \Carbon\Carbon::now()->addMonth(1)->format('Y-m-d') }}">
                                   
                                </div>
                            </div>   --}}

                            

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">@lang('modules.jobs.jobDescription')</label>
                                    <textarea class="form-control" id="job_description" name="job_description" rows="15" placeholder="Enter text ..."  ></textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">@lang('modules.jobs.jobRequirement')</label>
                                    <textarea class="form-control" id="job_requirement" name="job_requirement" rows="15" placeholder="Enter text ..."></textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">@lang('app.status')</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="active">@lang('app.active')</option>
                                        <option value="inactive">@lang('app.inactive')</option>
                                    </select>
                                </div>
                            </div>

                            <hr>

                            <div class="col-md-12">
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

                           

                            

                            <div class="col-md-12 questionDiv" style="display:none">
                                <table class="table table-bordered qtbl">
                                    <thead>
                                        <th class='text-center'>S.N</th>
                                        <th class='text-center'>Question</th>
                                        <th class='text-center'>Question Type</th>
                                        <th class='text-center'>Action</th>
                                    </thead>

                                    <tbody class='qtblBody'>

                                    </tbody>
                                </table>
                                <p>**Drag Rows to change question order</p>
                            </div>
                        </div>
                        <br />
                        <button type="button" id="save-form" class="btn btn-success"><i
                                    class="fa fa-check"></i> @lang('app.save')</button>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- The Modal -->
<div class="modal" id="myModal">
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
                    <input name="question" id="question" class="form-control" placeholder="Write your question here"></textarea>
                                        
                </div>
            </div>
                                    
            <div class="col-md-12">
                <div class="form-group">
                    <label for="address">Question Type</label>
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
                                <input class="form-control Multiple" name="multiple[    ]" type="text" placeholder="Enter answer" /><br />
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
    <script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/html5-editor/wysihtml5-0.3.0.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/html5-editor/bootstrap-wysihtml5.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/moment/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/multiselect/js/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('js/jquery.tagsinput.js') }}"></script>  
    
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>  
    <script>
        $('tbody').sortable();

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
                url: '{{route('admin.jobs.store')}}',
                container: '#createForm',
                type: "POST",
                redirect: true,
                data: $('#createForm').serialize()
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
            if(check > 3000 )
            {
                alert("Please enter limited values.");
            }

        })

        $("#job_requirement").data("wysihtml5").editor.on("change",function(){
            var html = this.textarea.getValue();
            var check = html.length;
            if(check > 3000 )
            {
                alert("Please enter limited values.");
            }
        })

        function changeddl(){
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
            
            var url = '/admin/assessments/fetchAssessementQuestion?id='+id
            

            $.easyAjax({
                type: 'GET',
                url: url,
                success: function (response) {
                    $(response).each(function(i,v){
                        var tdLength = $(".qtblBody tr").length
                        var html = '<tr class="ui-state-default '+v.assessment_id+'" id="'+v.id+'">'+
                        '<td class="text-center"><i class="pull-left fa fa-sort fa-lg" aria-hidden="true"></i>'+(tdLength+1)+'</td>'+
                        '<td>'+v.question+'</td>'+
                        '<td class="text-center">'+v.question_type+'</td>'+
                        '<td class="text-center"><i onclick="editQuestion('+v.id+')" class="fa fa-pencil fa-lg"></i> | <i'+
                        'onclick="deleteQuestion('+v.id+')" class="fa fa-trash fa-lg"></i></td></tr>'
                        $(".qtblBody").append(html)
                    })
                }
            });
        }

        function deleteQuestion(id){
            alert(id)
            $("#"+id).remove();
        }

        
        function editQuestion(id){
           $("#myModalX").modal('show')

           var question = $("#"+id).find('td:first').text();
           $("#question").val(question)
        }

        $("#mSave").on('click',function(){
            var question=$("#question").val()
            var question_type=$("#question_type").val()
            var is_req = $("#required").val()

            var tdLength = $(".qtblBody tr").length

            $(".questionDiv").css("display","block")
            

            var tbbb = '<tr><td class="text-center"><i class="pull-left fa fa-sort fa-lg" aria-hidden="true"></i>'+(tdLength+1)+'</td>'+
            '<td>'+question+'</td><td class="text-center">'+question_type+'</td>'+
            '<td class="text-center"><i onclick="editQuestion()" class="fa fa-pencil fa-lg"></i> | <i'+
                                        'onclick="deleteQuestion()" class="fa fa-trash fa-lg"></i></td></tr>'
            $(".qtblBody").append(tbbb)

            $("#myModalX").modal('hide')

            $.easyAjax({
                url: '{{route('admin.questions.store')}}',
                container: '#customQuestion',
                type: "POST",
                redirect: false,
                data: $('#customQuestion').serialize()
            })
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
            
            $.easyAjax({
                type: 'GET',
                url: url,
                success: function (response) {
                    $(response).each(function(i,v){
                        var html = '<div class="col-md-4" style="padding:20px;">'+
                                        '<div class="nav flex-column nav-pills nav-pills-custom" id="v-pills-tab" role="tablist" aria-orientation="vertical">'+
                                        '<a class="nav-link mb-3 p-3 shadow" id="plusButton" onclick="addQuestion('+ v.id +')">'+
                                            '<span class="font-weight-bold big"><br/>'+
                                            '<h2>'+v.name+'</h2><hr/>'+
                                            '<h5> Summary </h5></span>'+
                                            '<p style="color:black">'+v.summary+'</p><hr/>'+
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
