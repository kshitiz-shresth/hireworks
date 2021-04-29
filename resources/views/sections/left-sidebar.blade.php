<style>
    .sidebar-dark-primary {
        background-color: {{$global->side_bar_color}} !important;
    }
    .sidebar-dark-primary .sidebar a{
        color:{{$global->side_bar_text_color}} !important;
    }
    .nav-header{
        color:{{$global->side_bar_text_color}} !important;
    }
    
    .sidebar-dark-primary .nav-treeview>.nav-item>.nav-link.active {
        background-color: rgba(255,255,255,.1) !important;
    }
</style>


<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" >
    <!-- Brand Logo  -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link text-center">
        @if(empty($global->logo))
        <img src="{{ asset('app-logo.png') }}" alt="AdminLTE Logo"
             class="brand-image img-fluid">
        @else
        <img src="{{ asset('user-uploads/company-logo/'.$global->logo.'') }}" alt="AdminLTE Logo"
             class="brand-image img-fluid">
        @endif
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ $user->profile_image_url  }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('admin.profile.index') }}" class="d-block">{{ ucwords($user->name) }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" id="sidebarnav" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon icon-home"></i>
                        <p>
                            Home
                        </p>
                    </a>
                </li>

              <!--
              @permission('view_company')
                <li class="nav-item">
                    <a href="{{ route('admin.company.index') }}" class="nav-link">
                        <i class="nav-icon icon-film"></i>
                        <p>
                            @lang('menu.companies')
                        </p>
                    </a>
                </li>
                @endpermission

                @permission('view_category')
                <li class="nav-item">
                    <a href="{{ route('admin.job-categories.index') }}" class="nav-link">
                        <i class="nav-icon icon-grid"></i>
                        <p>
                            @lang('menu.jobCategories')
                        </p>
                    </a>
                </li>
                @endpermission

                @permission('view_skills')
                <li class="nav-item">
                    <a href="{{ route('admin.skills.index') }}" class="nav-link">
                        <i class="nav-icon icon-grid"></i>
                        <p>
                            @lang('menu.skills')
                        </p>
                    </a>
                </li>
                @endpermission

                 @permission('view_company')
                <li class="nav-item">
                    <a href="{{ route('admin.company.index') }}" class="nav-link">
                        <i class="nav-icon icon-film"></i>
                        <p>
                            @lang('menu.companies')
                        </p>
                    </a>
                </li>
                @endpermission

                @permission('view_locations')
                <li class="nav-item">
                    <a href="{{ route('admin.locations.index') }}" class="nav-link">
                        <i class="nav-icon icon-location-pin"></i>
                        <p>
                            @lang('menu.locations')
                        </p>
                    </a>
                </li>
                @endpermission -->

                @permission('view_question')
                <li class="nav-item">
                    <a href="{{ route('admin.assessments.index') }}" class="nav-link">
                        <i class="nav-icon icon-grid"></i>
                        <p>
                            Assessments
                        </p>
                    </a>
                </li>
                @endpermission

                @permission('view_jobs')
                <li class="nav-item">
                    <a href="{{ route('admin.jobs.index') }}" class="nav-link">
                        <i class="nav-icon icon-badge"></i>
                        <p>
                            @lang('menu.jobs')
                        </p>
                    </a>
                </li>
                @endpermission


                @permission('view_job_applications')
                <li class="nav-item">
                    <a href="{{ route('admin.job-applications.table') }}" class="nav-link">
                        <i class="nav-icon icon-user"></i>
                        <p>
                            Candidates
                        </p>
                    </a>
                </li>
                @endpermission

                @permission('view_schedule')
              <li class="nav-item">
                    <a href="{{ route('admin.interview-schedule.index') }}" class="nav-link">
                        <i class="nav-icon icon-calendar"></i>
                        <p>
                            @lang('menu.interviewSchedule')
                        </p>
                    </a>
                </li> 
                @endpermission

                @permission('view_schedule')
                 <!-- <li class="nav-item">
                    <a href="{{ route('admin.interview-schedule.appointment') }}" class="nav-link">
                        <i class="nav-icon icon-calendar"></i>
                        <p>
                           Interview Schedule
                        </p>
                    </a>
                </li> -->
                @endpermission

                @permission('view_team')
                <li class="nav-item">
                    <a href="{{ route('admin.team.index') }}" class="nav-link">
                        <i class="nav-icon icon-people"></i>
                        <p>
                            @lang('menu.team')
                        </p>
                    </a>
                </li>
                @endpermission

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon icon-settings"></i>
                        <p>
                            @lang('menu.settings')
                            <i class="right fa fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.profile.index') }}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p> @lang('menu.myProfile')</p>
                            </a>
                        </li>
                        @permission('manage_settings')
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.index') }}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.businessSettings')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.role-permission.index') }}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.rolesPermission')</p>
                            </a>
                        </li>
                       <!-- <li class="nav-item">
                            <a href="{{ route('admin.language-settings.index') }}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('app.language') @lang('menu.settings')</p>
                            </a>
                        </li> 


                        <li class="nav-item">
                            <a href="{{ route('admin.smtp-settings.index') }}" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>@lang('menu.mailSetting')</p>
                            </a>
                        </li>-->
                        @endpermission

                    </ul>
                </li>

                <li class="nav-header"><b>MISCELLANEOUS</b></li>
                <li class="nav-item">
                    <a href="{{ url('/openings/'.$global->id.'') }}" target="_blank" class="nav-link">
                        <i class="nav-icon fa fa-external-link"></i>
                        <p>Career Site</p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
