@extends('layouts.front')

@section('header-text')
    <h1 class="hidden-sm-down">{{ ucwords($job->title) }}</h1>
@endsection

@section('content')

    <div class="container">
        <div class="alert alert-success alert-dismissible" id="alertDiv" style="margin-top:5px;display:none;">

                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Job Link Copied!!</strong>
        </div>
        <div class="row">
            <div class="col-md-12 fs-12 pt-50 pb-10 bb-1 mb-20">
                <a class="text-dark"href="{{ url('/openings/'.$global->id.'') }}">
                @lang('modules.front.jobOpenings')</a> &raquo; <span
                        class="theme-color">{{ ucwords($job->title) }}</span>
            </div>


            <div class="col-md-8">
                <div class="row gap-y">
                    <div class="col-md-12">
                        <h2>{{ ucwords($job->title) }}</h2>
                        @if($job->company->show_in_frontend == 'true')
                            <small class="company-title">@lang('app.by') {{ ucwords($job->company->company_name) }}</small>
                        @endif
                        <p>{{ ucwords($job->category->name) }}</p>

                        <h4 class="theme-color mt-20">General Info</h4>

                        <div class="row">
                            <div class="col-md-6">
                                <b>Company Name:</b> <a target="_blank" href="http://{{$company_website}}">{{$company_name}}</a>
                            </div>
                            <div class="col-md-6">
                                @if($job->is_remote != 1)
                                    <b>Job Location:</b> {!! $job->job_location !!},{!! $job->job_country !!}
                                @else
                                    <b>Job Location:</b> Remote</b>
                                @endif
                            </div>
                            <div class="col-md-6">
                            <br/><b>Job Type:</b> {!! $job->job_type !!}
                            </div>
                            <div class="col-md-6">
                            <br/><b>Salary:</b> {!! $job->salary !!}/{!! $job->salary_frequency!!}
                            </div>
                        </div>
                        <br/>
                        <h4 class="theme-color mt-20">Job Description / Requirement</h4>

                        <div>
                            {!! $job->job_description !!}
                        </div>

                        {{-- <h4 class="theme-color mt-20">@lang('modules.jobs.jobRequirement')</h4>

                        <div>
                            {!! $job->job_requirement !!}
                        </div> --}}



                    </div>

                </div>

            </div>

            <div class="col-md-4 col-sm-12">
                <div class="sidebar">

                    <a class="btn btn-block btn-primary theme-background my-10"
                       href="{{ route('jobs.jobApply', $job->id) }}">@lang('modules.front.applyForJob')</a>

                    <div class="b-1 border-light mt-20 text-center">
                        <span class="fs-12 fw-600">@lang('modules.front.shareJob')</span>

                        <div class="social social-boxed social-colored social-cycling text-center my-10">
                            <a title="copy" class="social-linkedin" href="#" onclick="copyUrl(event)">
                            <i class="fa fa-clipboard" aria-hidden="true" ></i></a>
                            <a class="social-linkedin"
                            href="https://www.linkedin.com/shareArticle?mini=true&url={{ route('jobs.jobDetail', [$job->slug]) }}&title={{ urlencode(ucwords($job->title)) }}&source=LinkedIn"
                            ><i class="fa fa-linkedin"></i></a>
                            <a class="social-facebook"
                               href="https://www.facebook.com/sharer/sharer.php?u={{ route('jobs.jobDetail', [$job->slug]) }}"
                            ><i class="fa fa-facebook"></i></a>
                            <a class="social-twitter"
                               href="https://twitter.com/home?status={{ route('jobs.jobDetail', [$job->slug]) }}"
                            ><i class="fa fa-twitter"></i></a>
                            <a class="social-gplus"
                               href="https://plus.google.com/share?url={{ route('jobs.jobDetail', [$job->slug]) }}"
                            ><i class="fa fa-google-plus"></i></a>
                        </div>

                    </div>


                </div>
            </div>

        </div>
    </div>
<script>
function copyUrl(event) {

    event.preventDefault()
  /* Get the text field */

  navigator.clipboard.writeText(window.location.href);

  $("#alertDiv").css("display","block")

  $('#alertDiv').delay(1000).fadeOut();
}


</script>

@endsection
