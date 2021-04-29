@extends('layouts.front')

@section('header-text')
    <h1 class="hidden-sm-down">{{ ucwords($job->title) }}</h1>

@endsection

<style>
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
    .form-control{
        background-color:#f5f5f5 !important;
    }
    button, input, optgroup, select, textarea {
        font-family: "Open Sans",sans-serif;
        font-weight: 400 !important;
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
    .tooltip {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black;
}
.tooltip .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  /* Position the tooltip */
  position: absolute;
  z-index: 1;
  top: -5px;
  right: 105%;
}
.tooltip:hover .tooltiptext {
  visibility: visible;
}
.input_label_apply{
    font-size: 18px;
    font-weight:500;
}
video::-webkit-media-controls-volume-slider {  display: none; }
video::-webkit-media-controls-mute-button {  display: none; }
video::-webkit-media-controls-play-button {  display: none; }
audio::-webkit-media-controls-volume-slider {  display: none; }
audio::-webkit-media-controls-mute-button {  display: none; }
audio::-webkit-media-controls-play-button {  display: none; }
</style>


@section('content')


    <form id="createForm" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="job_id_s" name="job_id" value="{{ $job->id }}">

        <div class="container">
        <div class="row gap-y">

            <div class="col-md-12 fs-12 pt-50 pb-10 bb-1 mb-20">
                <a class="text-dark"
                   href="{{ route('jobs.jobOpenings') }}">@lang('modules.front.jobOpenings')</a> &raquo; <a
                        class="text-dark"
                        href="{{ route('jobs.jobDetail', $job->slug) }}">{{ ucwords($job->title) }}</a> &raquo; <span
                        class="theme-color">@lang('modules.front.applicationForm')</span>
            </div>

                <div class="col-md-4 px-20 pb-30 bb-1">
                    <h3>@lang('modules.front.personalInformation')</h3>
                </div>


                <div class="col-md-8 pb-30 bb-1">

                    <div class="form-group">
                    <span class="input_label_apply">Full Name <span style="font-size:12px !important;">(Required)</span></span>
                        <input class="form-control form-control-lg" type="text" name="full_name" placeholder="@lang('modules.front.fullName')">
                    </div>

                    <div class="form-group">
                    <span class="input_label_apply">Email <span style="font-size:12px !important;">(Required)</span></span>
                        <input class="form-control form-control-lg email" type="email" name="email"
                            onkeyup="checkEmail()"   placeholder="@lang('modules.front.email')">
                    </div>

                    <div class="form-group">
                        <span class="input_label_apply">Confirm Email <span style="font-size:12px !important;">(Required)</span></span>
                        <input class="form-control form-control-lg" type="email"
                         onkeyup="checkEmail()"  id="confirm_email" placeholder="Retype Email Address">

                         <div class="alert alert-danger alertMsg" style="display:none">
                            <strong>Email Address Not Matched!! </strong>
                        </div>
                    </div>

                    <div class="form-group">
                    <span class="input_label_apply">Contact Number <span style="font-size:12px !important;">(Required)</span></span>
                        <div class="row">

                            <div class="col-md-4">
                            <select class="form-control form-control-lg" name="countryCode" id="">

		<option data-countryCode="DZ" value="213">Algeria (+213)</option>
		<option data-countryCode="AD" value="376">Andorra (+376)</option>
		<option data-countryCode="AO" value="244">Angola (+244)</option>
		<option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
		<option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
		<option data-countryCode="AR" value="54">Argentina (+54)</option>
		<option data-countryCode="AM" value="374">Armenia (+374)</option>
		<option data-countryCode="AW" value="297">Aruba (+297)</option>
		<option data-countryCode="AU" value="61">Australia (+61)</option>
		<option data-countryCode="AT" value="43">Austria (+43)</option>
		<option data-countryCode="AZ" value="994">Azerbaijan (+994)</option>
		<option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
		<option data-countryCode="BH" value="973">Bahrain (+973)</option>
		<option data-countryCode="BD" value="880">Bangladesh (+880)</option>
		<option data-countryCode="BB" value="1246">Barbados (+1246)</option>
		<option data-countryCode="BY" value="375">Belarus (+375)</option>
		<option data-countryCode="BE" value="32">Belgium (+32)</option>
		<option data-countryCode="BZ" value="501">Belize (+501)</option>
		<option data-countryCode="BJ" value="229">Benin (+229)</option>
		<option data-countryCode="BM" value="1441">Bermuda (+1441)</option>
		<option data-countryCode="BT" value="975">Bhutan (+975)</option>
		<option data-countryCode="BO" value="591">Bolivia (+591)</option>
		<option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option>
		<option data-countryCode="BW" value="267">Botswana (+267)</option>
		<option data-countryCode="BR" value="55">Brazil (+55)</option>
		<option data-countryCode="BN" value="673">Brunei (+673)</option>
		<option data-countryCode="BG" value="359">Bulgaria (+359)</option>
		<option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
		<option data-countryCode="BI" value="257">Burundi (+257)</option>
		<option data-countryCode="KH" value="855">Cambodia (+855)</option>
		<option data-countryCode="CM" value="237">Cameroon (+237)</option>
		<option data-countryCode="CA" value="1">Canada (+1)</option>
		<option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option>
		<option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option>
		<option data-countryCode="CF" value="236">Central African Republic (+236)</option>
		<option data-countryCode="CL" value="56">Chile (+56)</option>
		<option data-countryCode="CN" value="86">China (+86)</option>
		<option data-countryCode="CO" value="57">Colombia (+57)</option>
		<option data-countryCode="KM" value="269">Comoros (+269)</option>
		<option data-countryCode="CG" value="242">Congo (+242)</option>
		<option data-countryCode="CK" value="682">Cook Islands (+682)</option>
		<option data-countryCode="CR" value="506">Costa Rica (+506)</option>
		<option data-countryCode="HR" value="385">Croatia (+385)</option>
		<option data-countryCode="CU" value="53">Cuba (+53)</option>
		<option data-countryCode="CY" value="90392">Cyprus North (+90392)</option>
		<option data-countryCode="CY" value="357">Cyprus South (+357)</option>
		<option data-countryCode="CZ" value="42">Czech Republic (+42)</option>
		<option data-countryCode="DK" value="45">Denmark (+45)</option>
		<option data-countryCode="DJ" value="253">Djibouti (+253)</option>
		<option data-countryCode="DM" value="1809">Dominica (+1809)</option>
		<option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option>
		<option data-countryCode="EC" value="593">Ecuador (+593)</option>
		<option data-countryCode="EG" value="20">Egypt (+20)</option>
		<option data-countryCode="SV" value="503">El Salvador (+503)</option>
		<option data-countryCode="GQ" value="240">Equatorial Guinea (+240)</option>
		<option data-countryCode="ER" value="291">Eritrea (+291)</option>
		<option data-countryCode="EE" value="372">Estonia (+372)</option>
		<option data-countryCode="ET" value="251">Ethiopia (+251)</option>
		<option data-countryCode="FK" value="500">Falkland Islands (+500)</option>
		<option data-countryCode="FO" value="298">Faroe Islands (+298)</option>
		<option data-countryCode="FJ" value="679">Fiji (+679)</option>
		<option data-countryCode="FI" value="358">Finland (+358)</option>
		<option data-countryCode="FR" value="33">France (+33)</option>
		<option data-countryCode="GF" value="594">French Guiana (+594)</option>
		<option data-countryCode="PF" value="689">French Polynesia (+689)</option>
		<option data-countryCode="GA" value="241">Gabon (+241)</option>
		<option data-countryCode="GM" value="220">Gambia (+220)</option>
		<option data-countryCode="GE" value="7880">Georgia (+7880)</option>
		<option data-countryCode="DE" value="49">Germany (+49)</option>
		<option data-countryCode="GH" value="233">Ghana (+233)</option>
		<option data-countryCode="GI" value="350">Gibraltar (+350)</option>
		<option data-countryCode="GR" value="30">Greece (+30)</option>
		<option data-countryCode="GL" value="299">Greenland (+299)</option>
		<option data-countryCode="GD" value="1473">Grenada (+1473)</option>
		<option data-countryCode="GP" value="590">Guadeloupe (+590)</option>
		<option data-countryCode="GU" value="671">Guam (+671)</option>
		<option data-countryCode="GT" value="502">Guatemala (+502)</option>
		<option data-countryCode="GN" value="224">Guinea (+224)</option>
		<option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option>
		<option data-countryCode="GY" value="592">Guyana (+592)</option>
		<option data-countryCode="HT" value="509">Haiti (+509)</option>
		<option data-countryCode="HN" value="504">Honduras (+504)</option>
		<option data-countryCode="HK" value="852">Hong Kong (+852)</option>
		<option data-countryCode="HU" value="36">Hungary (+36)</option>
		<option data-countryCode="IS" value="354">Iceland (+354)</option>
		<option data-countryCode="IN" value="91">India (+91)</option>
		<option data-countryCode="ID" value="62">Indonesia (+62)</option>
		<option data-countryCode="IR" value="98">Iran (+98)</option>
		<option data-countryCode="IQ" value="964">Iraq (+964)</option>
		<option data-countryCode="IE" value="353">Ireland (+353)</option>
		<option data-countryCode="IL" value="972">Israel (+972)</option>
		<option data-countryCode="IT" value="39">Italy (+39)</option>
		<option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
		<option data-countryCode="JP" value="81">Japan (+81)</option>
		<option data-countryCode="JO" value="962">Jordan (+962)</option>
		<option data-countryCode="KZ" value="7">Kazakhstan (+7)</option>
		<option data-countryCode="KE" value="254">Kenya (+254)</option>
		<option data-countryCode="KI" value="686">Kiribati (+686)</option>
		<option data-countryCode="KP" value="850">Korea North (+850)</option>
		<option data-countryCode="KR" value="82">Korea South (+82)</option>
		<option data-countryCode="KW" value="965">Kuwait (+965)</option>
		<option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option>
		<option data-countryCode="LA" value="856">Laos (+856)</option>
		<option data-countryCode="LV" value="371">Latvia (+371)</option>
		<option data-countryCode="LB" value="961">Lebanon (+961)</option>
		<option data-countryCode="LS" value="266">Lesotho (+266)</option>
		<option data-countryCode="LR" value="231">Liberia (+231)</option>
		<option data-countryCode="LY" value="218">Libya (+218)</option>
		<option data-countryCode="LI" value="417">Liechtenstein (+417)</option>
		<option data-countryCode="LT" value="370">Lithuania (+370)</option>
		<option data-countryCode="LU" value="352">Luxembourg (+352)</option>
		<option data-countryCode="MO" value="853">Macao (+853)</option>
		<option data-countryCode="MK" value="389">Macedonia (+389)</option>
		<option data-countryCode="MG" value="261">Madagascar (+261)</option>
		<option data-countryCode="MW" value="265">Malawi (+265)</option>
		<option data-countryCode="MY" value="60">Malaysia (+60)</option>
		<option data-countryCode="MV" value="960">Maldives (+960)</option>
		<option data-countryCode="ML" value="223">Mali (+223)</option>
		<option data-countryCode="MT" value="356">Malta (+356)</option>
		<option data-countryCode="MH" value="692">Marshall Islands (+692)</option>
		<option data-countryCode="MQ" value="596">Martinique (+596)</option>
		<option data-countryCode="MR" value="222">Mauritania (+222)</option>
		<option data-countryCode="YT" value="269">Mayotte (+269)</option>
		<option data-countryCode="MX" value="52">Mexico (+52)</option>
		<option data-countryCode="FM" value="691">Micronesia (+691)</option>
		<option data-countryCode="MD" value="373">Moldova (+373)</option>
		<option data-countryCode="MC" value="377">Monaco (+377)</option>
		<option data-countryCode="MN" value="976">Mongolia (+976)</option>
		<option data-countryCode="MS" value="1664">Montserrat (+1664)</option>
		<option data-countryCode="MA" value="212">Morocco (+212)</option>
		<option data-countryCode="MZ" value="258">Mozambique (+258)</option>
		<option data-countryCode="MN" value="95">Myanmar (+95)</option>
		<option data-countryCode="NA" value="264">Namibia (+264)</option>
		<option data-countryCode="NR" value="674">Nauru (+674)</option>
		<option data-countryCode="NP" value="977">Nepal (+977)</option>
		<option data-countryCode="NL" value="31">Netherlands (+31)</option>
		<option data-countryCode="NC" value="687">New Caledonia (+687)</option>
		<option data-countryCode="NZ" value="64">New Zealand (+64)</option>
		<option data-countryCode="NI" value="505">Nicaragua (+505)</option>
		<option data-countryCode="NE" value="227">Niger (+227)</option>
		<option data-countryCode="NG" value="234">Nigeria (+234)</option>
		<option data-countryCode="NU" value="683">Niue (+683)</option>
		<option data-countryCode="NF" value="672">Norfolk Islands (+672)</option>
		<option data-countryCode="NP" value="670">Northern Marianas (+670)</option>
		<option data-countryCode="NO" value="47">Norway (+47)</option>
		<option data-countryCode="OM" value="968">Oman (+968)</option>
		<option data-countryCode="PW" value="680">Palau (+680)</option>
		<option data-countryCode="PA" value="507">Panama (+507)</option>
		<option data-countryCode="PG" value="675">Papua New Guinea (+675)</option>
		<option data-countryCode="PY" value="595">Paraguay (+595)</option>
		<option data-countryCode="PE" value="51">Peru (+51)</option>
		<option data-countryCode="PH" value="63">Philippines (+63)</option>
		<option data-countryCode="PL" value="48">Poland (+48)</option>
		<option data-countryCode="PT" value="351">Portugal (+351)</option>
		<option data-countryCode="PR" value="1787">Puerto Rico (+1787)</option>
		<option data-countryCode="QA" value="974">Qatar (+974)</option>
		<option data-countryCode="RE" value="262">Reunion (+262)</option>
		<option data-countryCode="RO" value="40">Romania (+40)</option>
		<option data-countryCode="RU" value="7">Russia (+7)</option>
		<option data-countryCode="RW" value="250">Rwanda (+250)</option>
		<option data-countryCode="SM" value="378">San Marino (+378)</option>
		<option data-countryCode="ST" value="239">Sao Tome &amp; Principe (+239)</option>
		<option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
		<option data-countryCode="SN" value="221">Senegal (+221)</option>
		<option data-countryCode="CS" value="381">Serbia (+381)</option>
		<option data-countryCode="SC" value="248">Seychelles (+248)</option>
		<option data-countryCode="SL" value="232">Sierra Leone (+232)</option>
		<option data-countryCode="SG" value="65">Singapore (+65)</option>
		<option data-countryCode="SK" value="421">Slovak Republic (+421)</option>
		<option data-countryCode="SI" value="386">Slovenia (+386)</option>
		<option data-countryCode="SB" value="677">Solomon Islands (+677)</option>
		<option data-countryCode="SO" value="252">Somalia (+252)</option>
		<option data-countryCode="ZA" value="27">South Africa (+27)</option>
		<option data-countryCode="ES" value="34">Spain (+34)</option>
		<option data-countryCode="LK" value="94">Sri Lanka (+94)</option>
		<option data-countryCode="SH" value="290">St. Helena (+290)</option>
		<option data-countryCode="KN" value="1869">St. Kitts (+1869)</option>
		<option data-countryCode="SC" value="1758">St. Lucia (+1758)</option>
		<option data-countryCode="SD" value="249">Sudan (+249)</option>
		<option data-countryCode="SR" value="597">Suriname (+597)</option>
		<option data-countryCode="SZ" value="268">Swaziland (+268)</option>
		<option data-countryCode="SE" value="46">Sweden (+46)</option>
		<option data-countryCode="CH" value="41">Switzerland (+41)</option>
		<option data-countryCode="SI" value="963">Syria (+963)</option>
		<option data-countryCode="TW" value="886">Taiwan (+886)</option>
		<option data-countryCode="TJ" value="7">Tajikstan (+7)</option>
		<option data-countryCode="TH" value="66">Thailand (+66)</option>
		<option data-countryCode="TG" value="228">Togo (+228)</option>
		<option data-countryCode="TO" value="676">Tonga (+676)</option>
		<option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
		<option data-countryCode="TN" value="216">Tunisia (+216)</option>
		<option data-countryCode="TR" value="90">Turkey (+90)</option>
		<option data-countryCode="TM" value="7">Turkmenistan (+7)</option>
		<option data-countryCode="TM" value="993">Turkmenistan (+993)</option>
		<option data-countryCode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option>
		<option data-countryCode="TV" value="688">Tuvalu (+688)</option>
		<option data-countryCode="UG" value="256">Uganda (+256)</option>
		 <option data-countryCode="GB" value="44">UK (+44)</option>
		<option data-countryCode="UA" value="380">Ukraine (+380)</option>
		<option data-countryCode="AE" value="971">United Arab Emirates (+971)</option>
		<option data-countryCode="UY" value="598">Uruguay (+598)</option>
		 <option data-countryCode="US" selected value="1">USA (+1)</option>
		<option data-countryCode="UZ" value="7">Uzbekistan (+7)</option>
		<option data-countryCode="VU" value="678">Vanuatu (+678)</option>
		<option data-countryCode="VA" value="379">Vatican City (+379)</option>
		<option data-countryCode="VE" value="58">Venezuela (+58)</option>
		<option data-countryCode="VN" value="84">Vietnam (+84)</option>
		<option data-countryCode="VG" value="84">Virgin Islands - British (+1284)</option>
		<option data-countryCode="VI" value="84">Virgin Islands - US (+1340)</option>
		<option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option>
		<option data-countryCode="YE" value="969">Yemen (North)(+969)</option>
		<option data-countryCode="YE" value="967">Yemen (South)(+967)</option>
		<option data-countryCode="ZM" value="260">Zambia (+260)</option>
		<option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
</select>
                            </div>

                            <div class="col-md-8">
                            <input class="form-control form-control-lg" type="tel" name="phone"
                               placeholder="@lang('modules.front.phone')">
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <span class="input_label_apply">Photo <span style="font-size:12px !important;">(Optional)</span></span><br/>
                        <input class="select-file" accept=".png,.jpg,.jpeg" type="file" name="photo"><br>
                        <span class="help-block">@lang('modules.front.photoFileType')</span>
                    </div>

                </div>

                <div class="col-md-4 px-20 py-30 bb-1">
                    <h3>@lang('modules.front.resume') <span style="font-size:12px !important;">(Required)</span></h3>
                </div>


                <div class="col-md-8 py-30 bb-1">

                    <div class="form-group">
                        <input class="select-file" type="file" name="resume"><br>
                        <span class="help-block">We accept DOCX, DOC and PDF files</span>
                    </div>


                </div>

                <div class="col-md-4 px-20 pt-30 mb-50">
                    <h3>@lang('modules.front.coverLetter') <span style="font-size:12px !important;">(Optional)</span></h3>
                </div>


                <div class="col-md-8 pt-30 mb-50">
                    <div class="form-group">
                        <input class="select-file" type="file" name="cover_letter"><br>
                        <span class="help-block">We accept DOCX, DOC and PDF files</span>
                    </div>
                </div>
                @if(count($jobQuestion) > 0)
                    <div class="col-md-4 px-20 pb-30 bb-1">
                        <h3>Assessment</h3>
                    </div>

                    <div class="col-md-8 pb-30 bb-1">
                        <?php $ind = 1; ?>
                        @forelse($jobQuestion as $question)
                            <div class="form-group">
                                <h5>Q{{$ind}}. {{ $question->question }}
                                    @if($question->required == "no")
                                    <span style="font-size:12px">(Optional)</span>
                                    @else
                                    <span style="font-size:12px">(Required)</span>
                                    @endif

                                </h5>


                                @if($question->question_type == "Text")
                                    <textarea class="form-control form-control-lg" type="text" id="answer[{{ $question->id}}]" name="answer[{{ $question->id}}]">{{ $question->type }}</textarea>
                                    <hr />
                                @elseif($question->question_type == "Video")
                                    <button class="btn-start-recording btn btn-danger"><b>Start / Re-Start<i class="fa fa-circle"></i></b></button>
                                    <button disabled class="btn-stop-recording btn btn-danger" ><b>Stop<i class="fa fa-stop"></i></b></button>
                                    <button disabled class="btn-play-recodring btn btn-primary" ><b>Play<i class="fa fa-play"></i></b></button>
                                    <input  type="hidden" id="answer[{{ $question->id}}]" name="answer[{{ $question->id}}]"/>
                                    @if($question->audio_video_length != null)
                                    <a class="pull-right" style="font-weight:600">Time Limit: <span class="time_limit">{{$question->audio_video_length}}</span> min</a>
                                    @else
                                    <a class="pull-right"><span class="time_limit"></span></a>
                                    @endif
                                    <video preload="auto" controls autoplay playsinline id="{{$question->id}}" style="margin-top:10px;" width='800' ></video>

                                    <hr />

                                @elseif($question->question_type == "Audio")
                                    <button class="btn-start-audio btn btn-success"><b>Start / Re-Start<i class="fa fa-play-circle fa-lg"></i></b></button>
                                    <button disabled class="btn-stop-audio btn btn-danger"><b>Stop<i class="fa fa-stop-circle fa-lg"></i></b></button>
                                    <button disabled class="btn-play-audio btn btn-primary" ><b>Play<i class="fa fa-play-circle fa-lg"></i></b></button>
                                    <input   type="hidden" id="answer[{{ $question->id}}]" name="answer[{{ $question->id}}]"/>
                                    @if($question->audio_video_length != null)
                                    <a class="pull-right" style="font-weight:600">Time Limit: <span class="time_limit_audio">{{$question->audio_video_length}}</span> min</a>
                                    @else
                                    <a class="pull-right"><span class="time_limit_audio"></span></a>
                                    @endif
                                    <audio controls autoplay playsinline id="{{$question->id}}" style='width:720px !important;margin-top:10px;' ></audio>
                                    <hr />
                                @elseif($question->question_type == "Multiple")
                                    @foreach($multipleQuestion as $mcqs)

                                        @if($question->id == $mcqs->question_id)
                                            <label class="containerLab">{{ $mcqs->answer }}
                                              <input type="checkbox" class="chkboxMCQ" id="{{$question->id}}-{{ $mcqs->id }}">
                                              <span class="checkmark"></span>
                                            </label>
                                        @endif


                                @endforeach

                                @endif
                            </div>
                            <?php $ind = $ind + 1; ?>
                        @empty
                        @endforelse

                    </div>
                @endif



                <div class="col-md-4 px-20 pt-30 mb-50">
                </div>
                <div class="col-md-8 pt-30 mb-50" >
                <button class="btn btn-lg btn-primary btn-block theme-background" id="save-form" type="button">@lang('modules.front.submitApplication')</button>
                </div>


        </div>
    </div>
    </form>

@endsection

@push('footer-script')
<script>
        function checkEmail(){
            var email= $(".email").val()
            var cemail = $("#confirm_email").val()
            if(cemail != ""){
                if(email != cemail){
                    $("#save-form").attr("disabled","disabled")
                    $(".alertMsg").css("display","block")
                }else{
                    $("#save-form").removeAttr("disabled")
                    $(".alertMsg").css("display","none")
                }
            }
        }
        $('#save-form').click(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.easyAjax({
                url: '{{route('jobs.saveApplication')}}',
                container: '#createForm',
                type: "POST",
                file:true,
                redirect: true,
                // data: $('#createForm').serialize(),
                success: function (response) {
                        var job_application_id = response
                        //save mcqs answers
                        var mcqLength = $(".chkboxMCQ").length
                        if(mcqLength > 1){
                            debugger
                            var allData = []
                            $('.chkboxMCQ').each(function() {
                                debugger
                                var data = {};
                                var value = $(this).attr("id")
                                //check if checkbox is checked
                                var isChecked = $('#'+value+':checkbox:checked').length > 0;
                                if(isChecked == true)
                                {
                                    var splitVal = value.split('-')
                                    data.question_id = splitVal[0]
                                    data.answer_id = splitVal[1]
                                    data.job_id = $("#job_id_s").val()
                                    data.job_application_id = job_application_id
                                    allData.push(data)
                                }
                            });
                            var jsonData = JSON.stringify(allData)
                            $.ajax({
                                type: 'POST',
                                url: '{{route('jobs.saveMCQs')}}', // replace with your own server URL
                                data: jsonData,
                                contentType: "json",
                                processData: false,
                                success: function(response) {
                                }
                            });
                        }
                        var successMsg = '<div class="alert alert-success my-100" role="alert">' +
                            ' <a class="" href="/job/{{$job->slug}}">Your Application has been Submitted!  @lang("modules.front.jobOpenings") <i class="fa fa-arrow-right"></i></a>'
                            '</div>';
                        $('.main-content .container').html(successMsg);
                },
                error: function (response) {
                   // console.log(response.responseText);
                    handleFails(response);
                }
            })
        });
        function handleFails(response) {
            console.log(response);
            if (typeof response.responseJSON.errors != "undefined") {
                var keys = Object.keys(response.responseJSON.errors);
                console.log(keys);
                $('#createForm').find(".has-error").find(".help-block").remove();
                $('#createForm').find(".has-error").removeClass("has-error");
                    for (var i = 0; i < keys.length; i++) {
                        // Escape dot that comes with error in array fields
                        var key = keys[i].replace(".", '\\.');
                        var formarray = keys[i];
                        // If the response has form array
                        if(formarray.indexOf('.') >0){
                            var array = formarray.split('.');
                            response.responseJSON.errors[keys[i]] = response.responseJSON.errors[keys[i]];
                            key = array[0]+'['+array[1]+']';
                        }
                        var ele = $('#createForm').find("[name='" + key + "']");
                        var grp = ele.closest(".form-group");
                        $(grp).find(".help-block").remove();
                        //check if wysihtml5 editor exist
                        var wys = $(grp).find(".wysihtml5-toolbar").length;
                        if(wys > 0){
                            var helpBlockContainer = $(grp);
                        }
                        else{
                            var helpBlockContainer = $(grp).find("div:first");
                        }
                        if($(ele).is(':radio')){
                            helpBlockContainer = $(grp).find("div:eq(2)");
                        }
                        if (helpBlockContainer.length == 0) {
                            helpBlockContainer = $(grp);
                        }
                        helpBlockContainer.append('<div class="help-block">' + response.responseJSON.errors[keys[i]] + '</div>');
                        $(grp).addClass("has-error");
                    }
                    if (keys.length > 0) {
                        var element = $("[name='" + keys[0] + "']");
                        if (element.length > 0) {
                            $("html, body").animate({scrollTop: element.offset().top - 150}, 200);
                        }
                    }
            }
        }
    </script>

<script src="https://www.WebRTC-Experiment.com/RecordRTC.js"></script>
<script>
var video = "";
function captureCamera(callback) {
    navigator.mediaDevices.getUserMedia({ audio: true, video: true }).then(function(camera) {
        callback(camera);
    }).catch(function(error) {
        //alert('Unable to capture your camera. Please check console logs.');
        console.error(error);
    });
}
function stopRecordingCallback() {
    debugger;
    video.src = null;
    video.srcObject = null
    video.muted = false;
    video.volume = 1;
    video.src = URL.createObjectURL(recorder.getBlob());
    video.controls = true;
    video.autoplay = false;
    recorder.camera.stop();
    // get recorded blob
                        var blob = recorder.getBlob();
                        // generating a random file name
                        var fileName = getFileName('webm');
                        // we need to upload "File" --- not "Blob"
                        var fileObject = new File([blob], fileName, {
                            type: 'video/webm'
                        });
                        var formData = new FormData();
                        // recorded data
                        formData.append('video-blob', fileObject);
                        // file name
                        formData.append('video-filename', fileObject.name);
                       debugger
                       $('input[name="'+answerId+'"]').attr('value',fileName);
                        // var upload_directory = 'RecordRTC-to-PHP/uploads/';
                        $.ajaxSetup({
                              headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                            });
                        // upload using jQuery
                        $.ajax({
                            url: '{{route('jobs.saveVideo')}}', // replace with your own server URL
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            type: 'POST',
                            success: function(response) {
                            }
                        });
    recorder.destroy();
    recorder = null;
}
var recorder; // globally accessible
var answerId;
var timeout;
function playVideo(id){
    var videoId = id
    $("#"+videoId).get(0).play()
}
$(".btn-play-recodring").on('click',function(event){
    event.preventDefault();
    var videoId = $(this).next().next().next('video').attr("id")
    video.controls = true;
    $("#"+videoId).get(0).play()
    $("<style> video::-webkit-media-controls-play-button {  display: block; }</style>").appendTo('head');
})
$(".btn-start-recording").on('click',function(){
    debugger
    var videoId =  $(this).next().next().next().next().next('video').attr('id')
    var time = $("#"+videoId).prev().find('.time_limit').text()
    $("<style> video::-webkit-media-controls-play-button {  display: none; }</style>").appendTo('head');
    timeInMilli = (Number(time)+ 0.01 )*60000;
    video = document.getElementById(videoId);
    var playBtnV = $(this);
    var stopBtnV = $(this).next('button');
    var playRecV = $(this).next().next('button');
    $(this).next('button').removeAttr("disabled")
    $(this).next().next('button').prop('disabled', true)
    this.disabled = true;
    captureCamera(function(camera) {
        video.muted = false;
        video.volume = 0;
        video.srcObject = camera;
        video.controls = true;
        video.play();
        recorder = RecordRTC(camera, {
            type: 'video'
        });
        recorder.startRecording();
        if(time != null && time != ""){
            timeout = setTimeout(function(){
                stopBtnV.prop('disabled', true);
                playBtnV.removeAttr("disabled");
                playRecV.removeAttr("disabled");
                $("<style> video::-webkit-media-controls-play-button {  display: block; }</style>").appendTo('head');
                recorder.stopRecording(stopRecordingCallback);
         }, timeInMilli);
        }
        // release camera on stopRecording
        recorder.camera = camera;
        //document.getElementById('btn-stop-recording').disabled = false;
    });
})
$(".btn-stop-recording").on('click',function(){
    debugger;
    this.disabled = true;
    clearTimeout(timeout);
    $("<style> video::-webkit-media-controls-play-button {  display: block; }</style>").appendTo('head');
    $(this).prev('button').removeAttr("disabled")
    $(this).next('button').removeAttr("disabled")
    var a = $(this).next().next().next('video').attr("id")
    //$("#btn-start-recording").removeAttr("disabled")
    answerId = $(this).next().next('input').attr('id');
    recorder.stopRecording(stopRecordingCallback);
});
function getFileName(fileExtension) {
    var d = new Date();
    var year = d.getUTCFullYear();
    var month = d.getUTCMonth();
    var date = d.getUTCDate();
    return 'RecordRTC-' + year + month + date + '-' + getRandomString() + '.' + fileExtension;
}
function getRandomString() {
    if (window.crypto && window.crypto.getRandomValues && navigator.userAgent.indexOf('Safari') === -1) {
        var a = window.crypto.getRandomValues(new Uint32Array(3)),
            token = '';
        for (var i = 0, l = a.length; i < l; i++) {
            token += a[i].toString(36);
        }
        return token;
    } else {
        return (Math.random() * new Date().getTime()).toString(36).replace(/\./g, '');
    }
}
</script>

<script>
var answerIds;
var audio = "";
var timeoutA;
function captureMicrophone(callback) {
     navigator.mediaDevices.getUserMedia({ audio: true}).then(function(mic) {
        callback(mic);
    }).catch(function(error) {
       // alert('Unable to capture your mic. Please check console logs.');
        console.error(error);
    });
}
$(".btn-play-audio").on('click',function(event){
    debugger;
    event.preventDefault();
    var audioId = $(this).next().next().next('audio').attr("id")
    $("#"+audioId).get(0).play()
    $("<style> audio::-webkit-media-controls-play-button {  display: block; }</style>").appendTo('head');
})
$(".btn-start-audio").on('click',function(){
    debugger;
    var audioId =  $(this).next().next().next().next().next('audio').attr('id')
    audio = document.getElementById(audioId);
    $("<style> audio::-webkit-media-controls-play-button {  display: none; }</style>").appendTo('head');
    var time = $("#"+audioId).prev().find('.time_limit_audio').text()
    timeInMilli = (Number(time)+ 0.01 )*60000
    $(this).next('button').removeAttr("disabled")
    $(this).next().next('button').prop('disabled', true)
    var playBtnA = $(this);
    var stopBtnA = $(this).next('button');
    var playRecA = $(this).next().next('button');
    this.disabled = true;
    captureMicrophone(function(mic) {
        microphone = mic;
        audio.muted = true;
        audio.srcObject = microphone;
        audio.play();
        var options = {
            type: 'audio',
            numberOfAudioChannels: isEdge ? 1 : 2,
            checkForInactiveTracks: true,
            bufferSize: 16384
        };
        recorder = RecordRTC(microphone, {
            type: 'audio'
        });
        if(recorder) {
            recorder.destroy();
            recorder = null;
        }
        recorder = RecordRTC(microphone, options);
        recorder.startRecording();
        if(time != null && time != ""){
            timeoutA = setTimeout(function(){
                stopBtnA.prop('disabled', true);
                playBtnA.removeAttr("disabled");
                playRecA.removeAttr("disabled");
                $("<style> audio::-webkit-media-controls-play-button {  display: block; }</style>").appendTo('head');
                recorder.stopRecording(stopRecordingCallbackAudio);
         }, timeInMilli);
        }
    });
})
$(".btn-stop-audio").on('click',function(){
    this.disabled = true;
    clearTimeout(timeoutA);
    $("<style> audio::-webkit-media-controls-play-button {  display: block; }</style>").appendTo('head');
    $(this).prev('button').removeAttr("disabled")
    $(this).next('button').removeAttr("disabled")
    answerIds = $(this).next().next('input').attr('id');
    recorder.stopRecording(stopRecordingCallbackAudio);
});
function stopRecordingCallbackAudio() {
    audio.src = audio.srcObject = null;
    audio.autoplay = false;
    audio.muted = false;
    audio.volume = 1;
    audio.src = URL.createObjectURL(recorder.getBlob());
    microphone.stop();
     var blob = recorder.getBlob();
                        // generating a random file name
                        var fileName = getFileName('mp3');
                        // we need to upload "File" --- not "Blob"
                        var fileObject = new File([blob], fileName, {
                            type: 'audio/mp3'
                        });
                        var formData = new FormData();
                        // recorded data
                        formData.append('audio-blob', fileObject);
                        // file name
                        formData.append('audio-filename', fileObject.name);
                       $('input[name="'+answerIds+'"]').attr('value',fileName);
                        var upload_url = 'https://webrtcweb.com/f/';
                        // var upload_url = 'RecordRTC-to-PHP/save.php';
                        var upload_directory = upload_url;
                        // var upload_directory = 'RecordRTC-to-PHP/uploads/';
                        $.ajaxSetup({
                              headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                            });
                        // upload using jQuery
                        $.ajax({
                            url: '{{route('jobs.saveVideo')}}', // replace with your own server URL
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            type: 'POST',
                            success: function(response) {
                            }
                        });
    recorder.destroy();
    recorder = null;
}
var recorder; // globally accessible
var microphone;
function getFileName(fileExtension) {
                var d = new Date();
                var year = d.getUTCFullYear();
                var month = d.getUTCMonth();
                var date = d.getUTCDate();
                return 'RecordRTC-' + year + month + date + '-' + getRandomString() + '.' + fileExtension;
            }
function getRandomString() {
                if (window.crypto && window.crypto.getRandomValues && navigator.userAgent.indexOf('Safari') === -1) {
                    var a = window.crypto.getRandomValues(new Uint32Array(3)),
                        token = '';
                    for (var i = 0, l = a.length; i < l; i++) {
                        token += a[i].toString(36);
                    }
                    return token;
                } else {
                    return (Math.random() * new Date().getTime()).toString(36).replace(/\./g, '');
                }
            }
</script>

<script src="https://www.webrtc-experiment.com/common.js"></script>
@endpush