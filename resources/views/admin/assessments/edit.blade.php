@extends('layouts.app')

@section('content')

<style>
    .content-header{
        display:none;
    }

    .content-wrapper {
        background: #f5f5f5 !important;
    }
    .card {
        box-shadow: none !important;
    }


    .up_header{
        padding:20px 20px 0px 20px;
    }




        .form-group{
            margin-bottom:35px !important;
        }

        .form-control{
            font-size: 1rem;
        }

    /*

*
* ==========================================
* CUSTOM UTIL CLASSES
* ==========================================
*/
.nav-pills-custom .nav-link {
    color: #151516;
    background: #fff;
    position: relative;
}

.nav-pills-custom .nav-link.active {
    color: #45b649;
    background: #fff;
}



/* Add indicator arrow for the active tab */
@media (min-width: 992px) {
    .nav-pills-custom .nav-link::before {
        content: '';
        display: block;
        border-top: 1px solid transparent;
        border-left: 10px solid #fff;
        border-bottom: 8px solid transparent;
        position: absolute;
        top: 50%;
        right: -10px;
        transform: translateY(-50%);
        opacity: 0;
    }
}

.nav-pills-custom .nav-link.active::before {
    opacity: 1;
}

.main_area{
    padding:20px;
}

.pt-5, .py-5 {
     padding-top: 0rem!important;
     padding-bottom:0rem!important;
}

#sortable {
    display: block;
    list-style-type: disc;
    margin-block-start: 0em !important;
    margin-block-end: 0em !important;
    margin-inline-start: 0px !important;
    margin-inline-end: 0px !important;
    padding-inline-start: 0px !important;
}


</style>

    <div class="row up_header">
            <div class="col-md-6 mb-20">
                <h3>{{$assessment_name}}</h3>
            </div>

            <div class="col-md-6 mb-20">
            <a href="{{route('admin.assessments.index')}}" class="btn btn-primary pull-right"> Back &nbsp;<i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
            </div>
    </div>
    <hr />

    <!-- Verticle Tabs -->
<!-- Demo header-->
<section class="py-5 header main_area">
    <div class="py-4">

        <div class="row">
            <div class="col-md-3" style="height:550px;overflow-y:scroll;overflow-x:hidden;padding:10px;">
                <!-- Tabs nav -->
                <div class="nav flex-column nav-pills nav-pills-custom" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                   <a class="nav-link mb-3 p-3 shadow text-center" id="plusButton"   href="#" >
                       <span class="font-weight-bold big"><br/><i class="fa fa-plus-circle" style="font-size:40px;margin-bottom:5px;"></i><br/>
                       <h4> Add New Question </h4></span>
                       <h6 id="no_of_q">( {{$assessmentq->count()}} Question )</h6>
                       </br/>
                    </a>
                    <?php $ind = 1; ?>

                    @if($assessmentq->count() > 0)
                    @foreach($assessmentq as $aq)
                    @if($ind == 1)
                    <a  class="question_section nav-link mb-3 p-3 shadow active" id="question{{$ind}}-tab" data-toggle="pill" href="#question{{$ind}}" role="tab" aria-controls="question{{$ind}}" aria-selected="true">
                    @else
                    <a  class="question_section nav-link mb-3 p-3 shadow" id="question{{$ind}}-tab" data-toggle="pill" href="#question{{$ind}}" role="tab" aria-controls="question{{$ind}}" aria-selected="true">
                    @endif
                        <span class="font-weight-bold big"><p><h4 class="question_no">Question {{$ind}}</h4>

                        </p>
                        <p style="font-weight:normal"><h6>{{$aq->question}}</h6></p>
                            @if($aq->question_type == "Multiple")
                                <h6><b>Multiple Choice</b></h6>
                            @else
                                <h6><b>{{$aq->question_type}}</b></h6>
                            @endif
                        </span>
                        <!--<p style="color:black">No Question</p>
                        <p style="color:#0151ce"><b>Question type  not choosed </b>  </p> -->
                    </a>
                    <?php $ind = $ind + 1; ?>
                    @endforeach
                    @else
                        <a class="question_section nav-link mb-3 p-3 shadow active" id="question1-tab" data-toggle="pill" href="#question1" role="tab" aria-controls="question1" aria-selected="true">

                        <span class="font-weight-bold big"><p><h4>Question 1</h4>

                        </p></span>
                        <!--<p style="color:black">No Question</p>
                        <p style="color:#0151ce"><b>Question type  not choosed </b>  </p> -->
                    </a>
                    @endif
                </div>
            </div>


            <div class="col-md-9">
                <!-- Tabs content -->
                <div class="tab-content" id="v-pills-tabContent">
                <?php $inds = 1; ?>

                    @if($assessmentq->count() > 0)
                    @foreach($assessmentq as $aq)
                    @if($inds == 1)
                    <div style="height:550px!important;overflow-y:scroll;overflow-x:hidden;" class="tab-pane fade shadow rounded bg-white show active p-5" id="question{{$inds}}" role="tabpanel" aria-labelledby="question{{$inds}}-tab">
                    @else
                    <div style="height:550px!important;overflow-y:scroll;overflow-x:hidden;" class="tab-pane fade shadow rounded bg-white show p-5" id="question{{$inds}}" role="tabpanel" aria-labelledby="question{{$inds}}-tab">
                    @endif


                    <h4 class="font-italic mb-4">Question {{$inds}}</h4>
                        <p class="font-italic text-muted mb-2">
                        <form class="ajax-form" method="POST" id="createForm{{$inds}}">
                        @csrf
                        <input name="_method" type="hidden" value="PUT">
                        <div class="row">

                            <div id="addMoreBox1" class="col-md-12">
                                <div class="row">
                                    <div class="col-md-11">
                                    <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="address">Write your question here</label>
                                        <input name="question" value="{{$aq->question}}" class="form-control" placeholder="Write your question here"></textarea>
                                        <input type="hidden" name="assessment_id" value="{{$assessment_id}}" />
                                    </div>
                                </div>

                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="address">Answer Type</label>
                                        <select select onchange="changeddl.call(this)" name="question_type" class="form-control question-type-ddl">
                                            @if($aq->question_type=="Text")
                                                <option value="Text" selected>Text</option>
                                            @else
                                                <option value="Text" >Text</option>
                                            @endif

                                            @if($aq->question_type=="Multiple")
                                                <option value="Multiple" selected>Multiple Choice</option>
                                            @else
                                                <option value="Multiple" >Multiple Choice</option>
                                            @endif

                                            @if($aq->question_type=="Video")
                                                <option value="Video" selected>Video</option>
                                            @else
                                                <option value="Video">Video</option>
                                            @endif

                                            @if($aq->question_type=="Audio")
                                                <option value="Audio" selected>Audio</option>
                                            @else
                                                <option value="Audio">Audio</option>
                                            @endif

                                        </select>
                                    </div>
                                </div>
                                @if($aq->question_type=="Multiple")

                                <div class="col-md-9">
                                    <div class="form-group multiple-choice-div">
                                        <div class="answerParentDiv">
                                        @foreach($assessmentMultiple as $am)
                                        @if($aq->id == $am->question_id)
                                            <div class="row answerDiv">
                                                <div class="col-md-6">
                                                    <input class="form-control Multiple" value="{{$am->answer}}" name="multiple[]" type="text" placeholder="Enter answer" /> <br />
                                                </div>
                                                <div class="col-md-1 removeDivInter">
                                                <span style="font-size:30px;margin-top:7px;cursor:pointer;color:red;" onclick="removeAnswer($(this))" class="fa fa-times-circle-o fa-lg removeAnswer"></span>
                                                </div>
                                            </div>
                                        @endif
                                        @endforeach
                                        </div>
                                        <a style="cursor:pointer;color:#0151ce" onclick="addAnswer.call(this)" class="addAnswer"><span class="fa fa-plus"></span> <b>Add Answer</b></a>
                                     </div>

                                </div>

                                @elseif ($aq->question_type=="Audio" || $aq->question_type=="Video")
                                    <div class="col-md-9">
                                        <div class="form-group time_limit">
                                            <label for="address">Max Recording time limit (in minutes)</label>
                                            <input type="number" name="time_limit" value="{{$aq->audio_video_length}}"  class="form-control"></input>
                                        </div>
                                    </div>
                                @else
                                <div class="col-md-9" >
                                    <div class="form-group multiple-choice-div" style="display:none">
                                        <div class="answerParentDiv">
                                            <div class="row answerDiv">
                                                <div class="col-md-6">
                                                    <input class="form-control Multiple" name="multiple[1]" type="text" placeholder="Enter answer" /><br />
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
                                            <input type="number" name="time_limit"  class="form-control" placeholder="e.g. 5"></input>
                                        </div>
                                    </div>
                                @endif

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


                                </div>

                            </div>
                            <div id="insertBefore"></div>
                            <div class="clearfix">

                            </div>

                           <!-- <div class="col-md-12">
                                <button type="button" id="plusButton" class="btn btn-sm btn-info" style="margin-bottom: 20px">
                                    @lang('app.addMore') <i class="fa fa-plus"></i>
                                </button>
                            </div>-->
                            </div>


                            <button type="button" onclick="updateform({{$aq->id}},{{$inds}})" class="btn btn-success "><i class="fa fa-check"></i> Update</button>
                            </form>
                        </p>
                    </div>
                    <?php $inds = $inds + 1; ?>
                    @endforeach
                    @else
                    <div style="height:550px!important;overflow-y:scroll;overflow-x:hidden;" class="tab-pane fade shadow rounded bg-white show active p-5" id="question1" role="tabpanel" aria-labelledby="question1-tab">
                        <h4 class="font-italic mb-4">Question 1</h4>
                        <p class="font-italic text-muted mb-2">
                        <form class="ajax-form" method="POST" id="createForm1">
                        @csrf
                        <div class="row">

                            <div id="addMoreBox1" class="col-md-12">
                                <div class="row">
                                    <div class="col-md-11">
                                    <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="address">Write your question here</label>
                                        <textarea name="question"  class="form-control" placeholder="Write your question here"></textarea>
                                        <input type="hidden" name="assessment_id" value="{{$assessment_id}}" />
                                    </div>
                                </div>

                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="address">Answer Type</label>
                                        <select onchange="changeddl.call(this)" name="question_type" class="form-control question-type-ddl">
                                            <option value="Text">Text</option>
                                            <option value="Multiple">Multiple Choice</option>
                                            <option value="Video">Video</option>
                                            <option value="Audio">Audio</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-9" >
                                    <div class="form-group multiple-choice-div" style="display:none">
                                        <div class="answerParentDiv">
                                            <div class="row answerDiv">
                                                <div class="col-md-6">
                                                    <input class="form-control Multiple" name="multiple[1]" type="text" placeholder="Enter answer" /><br />
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
                                        <input name="time_limit"  class="form-control" placeholder="e.g. 5"></input>
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


                                </div>

                            </div>
                            <div id="insertBefore"></div>
                            <div class="clearfix">

                            </div>

                            </div>


<button type="button" onclick="saveForm('1')" class="btn btn-success "><i class="fa fa-check"></i> @lang('app.save')</button>
</form>
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>


</section>


     <!-- Verticle Tabs -->


@endsection

@push('footer-script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>


    var $i = 0;
    $(document).ready(function(){
            var total_q = $(".question_section").length
            var url = "#question"+total_q+"-tab"
            window.location.hash = url;

            $(url).trigger('click');
            if (window.location.hash)
                scroll(0,0);
            // takes care of some browsers issue
            setTimeout(function(){scroll(0,0);},1);
    })

    $( function() {
        $( "#sortable" ).sortable();
        //$( "#sortable" ).disableSelection();
    } );

    // Add More Inputs
    $('#plusButton').click(function(){

        $i = $i+1;


        var indexs = $(".question_section").length + 1;
        $("#no_of_q").html("( "+(indexs) + " Questions" + " )")
        var insertBefore = $('#question'+indexs);

        var question_np = ' <a class="question_section nav-link mb-3 p-3 shadow" id="question'+indexs+'-tab" data-toggle="pill" '+
        ' href="#question'+indexs+'" role="tab" aria-controls="v-pills-home" aria-selected="true"> '+
        ' <span class="font-weight-bold big"><p><h4>Question ' + indexs + ' <i onclick="removeBox('+indexs+')" class="fa fa-trash pull-right" style="color:#dc3545;font-size:30px;margin-bottom:5px;"></i></h4></p></span> '+

        '</a>'

        var question_body = '<div class="tab-pane fade shadow rounded bg-white show p-5" '+
                            'id="question'+indexs+'" role="tabpanel" aria-labelledby="question'+indexs+'-tab">'+
                            '<h4 class="font-italic mb-4">Question '+indexs+'</h4>'+
                        '<p class="font-italic text-muted mb-2">'+
                            '</div>'

        $("#v-pills-tabContent").append(question_body)

        $("#v-pills-tab").append(question_np)

        var question_content = ' <form class="ajax-form" method="POST" id="createForm'+indexs+'"> '+
                        '@csrf'+
         '<div id="addMoreBox'+indexs+'" class="col-md-12"> ' +
            '<div class="row">' +
            '<div class="col-md-11">' +
            '<div class="col-md-9">' +
            '<div id="dateBox" class="form-group ">' +
            '<label for="name">Write your question here</label>' +
            '<input type="text" name="question" class="form-control" placeholder="Write your question here">' +
            ' <input type="hidden" name="assessment_id" value="{{$assessment_id}}" />'+
            '</div>' +
            '</div>' +

            '<div class="col-md-9">' +
            '<div class="form-group">' +
            '<label for="address">Answer Type</label>' +
            '<select onchange="return changeddl.call(this)" name="question_type" class="form-control question-type-ddl">' +
            '<option value="Text">Text</option>' +
            '<option value="Multiple">Multiple Choice</option>' +
            '<option value="Video">Video</option>' +
            '<option value="Audio">Audio</option>' +
            '</select>' +
            '</div>' +
            '</div>' +

                                '<div class="col-md-9" >' +
                                    '<div class="form-group multiple-choice-div" style="display:none">' +
                                        '<div class="answerParentDiv">' +
                                            '<div class="row answerDiv">' +
                                                '<div class="col-md-6">' +
                                                    '<input class="form-control Multiple" name="multiple[1]" type="text" placeholder="Enter answer" /><br />' +
                                                '</div>' +
                                                '<div class="col-md-1 removeDivInter">' +

                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                        '<a style="cursor:pointer;color:#0151ce" onclick="addAnswer.call(this)" class="addAnswer"><span class="fa fa-plus"></span> <b>Add Answer</b></a>' +
                                    '</div>' +

                                '</div>' +

                                '<div class="col-md-9">'+
                                '<div class="form-group time_limit" style="display:none">'+
                                '<label for="address">Max Recording time limit (in minutes)</label>'+
                                '<input name="time_limit"  class="form-control" placeholder="e.g. 5"></input>'+
                                '</div>'+
                                '</div>'+

            '<div class="col-md-9">' +
        '<div class="form-group">' +
            '<label for="address">@lang('app.required')</label>' +
            '<select name="required" class="form-control">' +
            '<option value="yes">@lang('app.yes')</option>' +
            '<option value="no">@lang('app.no')</option>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '</div>' +

        '</div><button type="button" onclick="saveForm('+indexs+')" class="btn btn-success "><i class="fa fa-check"></i> @lang('app.save')</button></form>';

        $("#question"+indexs).append(question_content)

        $('#question'+indexs+'-tab').trigger('click');

        window.location.hash = '#question'+indexs+'-tab';
        if (window.location.hash)
            scroll(0,0);
        // takes care of some browsers issue
        setTimeout(function(){scroll(0,0);},1);
    });

    // Remove fields
    function removeBox(index){
        $('#addMoreBox'+index).remove();
        $("#question"+index).remove();
        $("#question"+index+"-tab").remove();
        $("#no_of_q").html("( "+($i) + " Questions" + " )")
        $i = $i-1;
    }


    function saveForm(index) {
        $.easyAjax({
            url: '{{route('admin.assessments.store')}}',
            container: '#createForm',
            type: "POST",
            redirect: false,
            data: $('#createForm'+index).serialize(),
            success: function(){
                window.location.reload(true)
            }
        })
    };

    function updateform(id,index) {
        var url = '/admin/assessments/'+id;
        $.easyAjax({
            url:url,
            container: '#createForm'+index,
            type: "POST",
            redirect: false,
            data: $('#createForm'+index).serialize()
        })
    };


    function changeddl(){

        var ddlVal = $(this).val()
        var parentMultiple = $(this).parent().parent().parent().find(".multiple-choice-div")
        var parentLength = $(this).parent().parent().parent().find(".time_limit")

        if(ddlVal == "Multiple"){
            parentMultiple.css("display","block")
        }else {
            parentMultiple.css("display","none")
        }

        if(ddlVal == "Audio" || ddlVal == "Video"){
            parentLength.css("display","block")
        }else {
            parentLength.css("display","none")
        }


    }


    function addAnswer(){
        debugger
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

</script>
@endpush