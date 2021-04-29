@extends('layouts.app')

@section('content')

    <style>
        .form-control {
            font-size: 1rem !important;
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">@lang('app.createNew')</h4>

                    <form class="ajax-form" method="POST" id="createForm">
                        @csrf

                        <div class="row">
                            
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="address">@lang('menu.question')</label>
                                    <textarea name="question" class="form-control" placeholder="Write your question here"></textarea>
                                </div>
                            </div>
                            
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="address">Select Question Type</label>
                                    <select name="question_type" class="form-control" id="question-type-ddl">
                                        <option value="Text">Text</option>
                                        <option value="Multiple">Multiple Choice</option>
                                        <option value="Video">Video</option>
                                        <option value="Audio">Audio</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-9" >
                                <div class="form-group" id="multiple-choice-div" style="display:none">
                                    <div id="answerParentDiv">
                                        <div class="row answerDiv">
                                            <div class="col-md-6">
                                                <input class="form-control Multiple" name="multiple" type="text" placeholder="Enter answer" /><br />
                                            </div>
                                            <div class="col-md-1">
                                                <span style="font-size:30px;margin-top:7px;cursor:pointer;color:red;display:none;" onclick="removeAnswer($(this))" class="fa fa-times-circle-o fa-lg removeAnswer"></span> </br>
                                            </div>
                                        </div>
                                    </div>
                                    <a style="cursor:pointer;color:#0151ce" id="addAnswer"><span class="fa fa-plus"></span> <b>Add Answer</b></a>
                                </div>
                                
                            </div>
                            
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="address">@lang('app.required')</label>
                                    <select name="required" class="form-control">
                                        <option value="yes">@lang('app.yes')</option>
                                        <option value="no">@lang('app.no')</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="save-form" class="btn btn-success"><i class="fa fa-check"></i> @lang('app.save')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-script')
<script>
    $('#save-form').click(function () {
        $.easyAjax({
            url: '{{route('admin.questions.store')}}',
            container: '#createForm',
            type: "POST",
            redirect: true,
            data: $('#createForm').serialize()
        })
    });
    
    $("#question-type-ddl").on('change',function(){
        var ddlVal = $(this).val()
        if(ddlVal == "Multiple"){
            $("#multiple-choice-div").css("display","block")
        }else{
            $("#multiple-choice-div").css("display","none")
        }
    })
    
    
    $("#addAnswer").on('click',function(){
        var answerLength = $(".answerDiv").length
        if( answerLength <= 1){
            $(".removeAnswer").css("display","block")
        }
        
        var ansLength = answerLength + 1
        var newName = "multiple["+ansLength +"]"
        var clone = $( ".answerDiv:first").clone(true).find("input").val("").end()
        clone.find('.Multiple').prop('name', newName);
        clone.appendTo("#answerParentDiv");
    })
    
    function removeAnswer(obj){
        obj.parent().parent().remove()
        if($(".answerDiv").length <= 1){
           $(".removeAnswer").css("display","none")
        }
    }
    
</script>
@endpush