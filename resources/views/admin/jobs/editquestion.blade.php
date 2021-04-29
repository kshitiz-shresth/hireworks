<form class="ajax-form" method="POST" id="createFormEdit">
                        @csrf

                        <input name="_method" type="hidden" value="PUT">
                        <div class="row">

                            <div id="addMoreBox1" class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                    <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address">Write your question here</label>
                                        <input name="question" id="equestion" value="{{$aq->question}}" class="form-control" placeholder="Write your question here"></textarea>
                                        <input type="hidden" name="id" value="{{$aq->id}}" />
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address">Answer Type</label>
                                        <select id="equestiontype" select onchange="changeddlEdit.call(this)" name="question_type" class="form-control question-type-ddl">
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

                                <div class="col-md-12">
                                    <div class="form-group multiple-choice-div2">
                                        <div class="answerParentDiv">
                                        @foreach($assessmentMultiple as $am)
                                            <div class="row answerDiv">
                                                <div class="col-md-6">
                                                    <input class="form-control Multiple" value="{{$am->answer}}" name="multiple[]" type="text" placeholder="Enter answer" /> <br />
                                                </div>
                                                <div class="col-md-1 removeDivInter">
                                                <span style="font-size:30px;margin-top:7px;cursor:pointer;color:red;" onclick="removeAnswer($(this))" class="fa fa-times-circle-o fa-lg removeAnswer"></span>
                                                </div>
                                            </div>
                                        @endforeach
                                        </div>
                                        <a style="cursor:pointer;color:#0151ce" onclick="addAnswer.call(this)" class="addAnswer"><span class="fa fa-plus"></span> <b>Add Answer</b></a>
                                     </div>

                                </div>

                                @elseif ($aq->question_type=="Audio" || $aq->question_type=="Video")
                                    <div class="col-md-12">
                                        <div class="form-group time_limit2">
                                            <label for="address">Max Recording time limit (in minutes)</label>
                                            <input type="number" name="time_limit" value="{{$aq->audio_video_length}}"  class="form-control"></input>
                                        </div>
                                    </div>

                                    <div class="col-md-12" >
                                    <div class="form-group multiple-choice-div2" style="display:none">
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
                                @else
                                <div class="col-md-12" >
                                    <div class="form-group multiple-choice-div2" style="display:none">
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

                                <div class="col-md-12">
                                        <div class="form-group time_limit2" style="display:none">
                                            <label for="address">Max Recording time limit (in minutes)</label>
                                            <input type="number" value="{{$aq->audio_video_length}}"  name="time_limit"  class="form-control" placeholder="e.g. 5"></input>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-12">
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


                            <button type="button" onclick="updateform({{$aq->id}})" class="btn btn-success "><i class="fa fa-check"></i> Update</button>
                            </form>
<script>


function changeddlEdit(){
            debugger;
            var ddlVal = $(this).val()
            var parentMultiple = $(this).parent().parent().parent().find(".multiple-choice-div2")
            var parentLength = $(this).parent().parent().parent().find(".time_limit2")

            if(ddlVal == "Multiple"){
                $(".multiple-choice-div2").css("display","block")
            }else {
                $(".multiple-choice-div2").css("display","none")
            }

            if(ddlVal == "Audio" || ddlVal == "Video"){
                $(".time_limit2").css("display","block")
            }else {
                $(".time_limit2").css("display","none")
            }

        }
</script>
