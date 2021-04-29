@extends('layouts.front')

@section('header-text')
    <h1 class="hidden-sm-down"><i class="icon-ribbon"></i> @lang('modules.front.homeHeader') </h1>
    <h4 class="hidden-sm-up"><i class="icon-ribbon"></i> @lang('modules.front.homeHeader') </h4>
@endsection

@section('content')

<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.tagsinput.css') }}" />
<style>
    .text-info, i {
        color: black !important;
    }

    div.tagsinput {
        border: none !important;
        background: #FFF;
        padding: 0px important;
        overflow-y: hidden;
        width: 100% !important;
        height: 100% !important;
    }

    #job_skills_tagsinput{
        min-height:60px !important;
        height:60px !important;
    }

</style>

    <!--
    |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
    | Working at TheThemeio
    |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
    !-->
    <!-- <section class="section bg-gray py-120">
        <div class="container">

            <div class="row gap-y align-items-center">

                <div class="col-12"> -->
                    <!-- <h3>@lang('modules.front.jobOpeningHeading')</h3> -->
                    <!-- <p>@lang('modules.front.jobOpeningText')</p> -->

                <!-- </div>

            </div>

        </div>
    </section> -->





    <!--
    |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
    | Open positions
    |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
    !-->
    <style media="screen">
      .card-bordered:hover{
        box-shadow:1px 2px 10px black;
      }
    </style>
    <section class="section" style="background:#ECF0F1;">
        <div class="container">
                <!-- <header class="section-header">
                    <h2>@lang('modules.front.jobOpenings')</h2>
                </header> -->


            <div data-provide="shuffle">
                {{-- <div class="text-center gap-multiline-items-2 job-filters" data-shuffle="filter">
                    <button class="btn btn-w-md btn-outline btn-round btn-primary active" data-shuffle="button">All
                    </button>

                    <p>&nbsp;</p>
                    @foreach($categories as $category)
                        <button class="btn btn-xs btn-outline btn-round btn-dark" data-shuffle="button"
                                data-group="{{ $category->name }}">{{ ucwords($category->name) }}</button>
                    @endforeach
                </div> --}}

                <br>

                <div class="row gap-y" data-shuffle="list">

                    @foreach($jobs as $job)
                        @if($job->title!=null && $job->category_id!=null && $job->job_type!=null && $job->total_positions!=null && $job->salary_frequency!=null && $job->salary!=null && $job->job_location!=null && $job->job_country!=null && $job->skills!=null || $job->is_remote!=null)
                        <div class="col-6 col-md-6 col-lg-6 portfolio-2" data-shuffle="item" data-groups="{{ $job->category->name }}">
                            <a href="{{ route('jobs.jobDetail', [$job->slug]) }}" class="job-opening-card">
                            <div class="card card-bordered"  >

                                <div class="card-block" style="box-shadow: 1px 2px 3px;padding-top: 10px;padding-bottom: 10px;">
                                        <h1 class="card-title">{{ ucwords($job->title) }}
                                        <span class="pull-right">
                                                @if($job->is_remote == "1")
                                                    <img height="20" width="20" src="{{ asset('remote.png') }}"/>
                                                @endif
                                         </span></h1>
                                         <!-- <h4><i class="fa fa-building"></i> {{$global->company_name}} </h4> -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                          <i class="fa fa-map-marker"></i>
                                            <span class="fw-600 fs-12 text-info">
                                                @if($job->is_remote == "0")
                                                   {{$job->job_location}},{{ $job->job_country}}
                                                @else
                                                    Remote
                                                @endif
                                            </span>
                                        &nbsp; &nbsp; &nbsp;
                                            <i class="fa fa-clock-o"></i>
                                            <span class="fw-600 fs-12 text-info">{{$job->job_type}}</span>
                                            &nbsp; &nbsp; &nbsp;
                                            <i class="fa fa-money"></i>
                                            <span class="fw-600 fs-12 text-info">{{$job->salary}}/{{$job->salary_frequency}}</span>
                                        </div>
                                        <!-- <div class="col-sm-4 text-right">
                                            <span class="fw-600 fs-12 text-info">{{ ucwords($job->category->name) }}</span>

                                        </div> -->

                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <p style="color:black;font-size:14px;">{{$job->skills}}</h4>
                                        </div>
                                        <div class="col-sm-12">
                                        <a class="btn btn-sm btn-primary theme-background my-10 pull-right"
                                                href="{{ route('jobs.jobDetail', [$job->slug]) }}">@lang('Apply')</a>
                                        </div>
                                      </div>

                                </div>
                            </div>
                            </a>
                        </div>
                        @endif
                    @endforeach

                </div>

            </div>


        </div>
    </section>
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.tagsinput.js') }}"></script>
<script>

</script>
@endsection
