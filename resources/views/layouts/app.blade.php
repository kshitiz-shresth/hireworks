<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hire Works | {{ $pageTitle }}</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/font-awesome/css/font-awesome.min.css">

    {{-- old css --}}
    <!-- Font Awesome -->

    <!-- Simple line icons -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">

    <!-- Themify icons -->
    <link rel="stylesheet" href="{{ asset('assets/icons/themify-icons/themify-icons.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->

    <link href="{{ asset('froiden-helper/helper.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/node_modules/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/node_modules/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <link rel='stylesheet prefetch'
        href='//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css'>

    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link href="{{ asset('assets/node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/node_modules/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <link rel="shortcut icon" href="/favicon/favicon-32x32.png" />

    @stack('head-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.3.0/alpine-ie11.min.js"
        integrity="sha512-Atu8sttM7mNNMon28+GHxLdz4Xo2APm1WVHwiLW9gW4bmHpHc/E2IbXrj98SmefTmbqbUTOztKl5PDPiu0LD/A=="
        crossorigin="anonymous"></script>
    <link rel='stylesheet prefetch' href='//cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css'>

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <style>
        :root {
            --main-color: {{ $adminTheme->primary_color }};
        }

        {!! $adminTheme->admin_custom_css !!}

    </style>

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body onload="greet()" @if (Auth::user()->id != 104) class="menu-open" @endif>
    <!-- header -->

    <div class="" id="header-container">

        <div class="menu-logo">
            @if (Auth::user()->id != 104)
                <a href="" id="menu-trigger">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </a>
            @endif
            <div class="menu-img">
                @if (empty($global->logo))
                    <img src="{{ asset('app-logo.png') }}" style="max-width:150px"
                        alt="{{ $global->company_name }}">
                @else
                    <img src="{{ asset('user-uploads/company-logo/' . $global->logo . '') }}"
                        style="max-width:100%;height:50px;" alt="{{ $global->company_name }}">
                @endif
            </div>
        </div>

        <div class="search-avatar">
            {{-- <div class="input-search">
                <input type="text" placeholder="Search">
                <a href="#" class="search-btn"><i class="fa fa-search"></i></a>
            </div> --}}
            <img src="/img/avatar.png" alt="avatar">
            @if (Auth::user()->id != 104)
                <a class="nav-link" style='color:white;' href="{{ route('logout') }}" title="Logout" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </a>
            @endif
        </div>
    </div>

    <!-- side menu -->
    <div id="side-menu">
        <div class="side-menu-wrapper">

            <ul class="menu-main">
                <li class="{{ Request::segment(2) == 'dashboard' ? 'active-link' : '' }}">
                    <a href="/admin/dashboard?first=true">
                        <i class="fa fa-home fa-2x"></i>
                        <p class="label_before">Home</p>
                    </a>
                </li>
                <li class="{{ Request::segment(2) == 'assessments' ? 'active-link' : '' }}">
                    <a href="/admin/assessments">
                        <i class="fa fa-th fa-2x"></i>
                        <p class="label_before">Assessments</p>
                    </a>
                </li>
                <li class="{{ Request::segment(2) == 'jobs' ? 'active-link' : '' }}">
                    <a href="/admin/jobs">
                        <i class="fa fa-trophy fa-2x"></i>
                        <p class="label_before">Jobs</p>
                    </a>
                </li>
                <li
                    class="{{ Request::segment(2) == 'job-applications' && Request::segment(3) == 'table-view' ? 'active-link' : '' }}">
                    <a href="/admin/job-applications/table-view">
                        <i class="fa fa-user fa-2x"></i>
                        <p class="label_before">Candidates</p>
                    </a>
                </li>
                <li class="{{ Request::segment(2) == 'interview-schedule' ? 'active-link' : '' }}">
                    <a href="{{ route('admin.interview-schedule.index') }}">
                        <i class="fa fa-calendar fa-2x"></i>
                        <p class="label_before">Calendar</p>
                    </a>
                </li>
                <li class="{{ Request::segment(2) == 'team' ? 'active-link' : '' }}">
                    <a href="{{ route('admin.team.index') }}">
                        <i class="fa fa-users fa-2x"></i>
                        <p class="label_before">Teams</p>
                    </a>
                </li>
                @permission('manage_settings')
                    <li
                        class="{{ Request::segment(2) == 'profile' || Request::segment('2') == 'settings' ? 'active-link' : '' }}">
                        <a href="/admin/profile">
                            <i class="fa fa-cog fa-2x"></i>
                            <p class="label_before">Setting</p>
                        </a>
                    </li>
                    @endpermission
                    {{-- @permission('manage_settings')
                <li x-data="{menuOpen: {{ Request::segment('2')=='settings' || Request::segment('2')=='profile'  ? 'true' : 'false'  }}}" :class="menuOpen==true ? 'open' : ''">
                    <p  x-on:click="menuOpen = !menuOpen">Setting</p>
                         <ul :class="menuOpen==true ? 'own__sub-active' : 'own__sub'">
                            <li class="{{  Request::segment(2)=="profile" ? 'active-link' : '' }}">
                                <a href="/admin/profile">
                                    <i class="fa fa-user fa-2x"></i>
                                    <p>My profile</p>
                                </a>
                            </li>
                            <li class="{{  Request::segment(3)=="settings" ? 'active-link' : '' }}">
                                <a href="{{ route('admin.settings.index') }}">
                                    <i class="fa fa-cog fa-2x"></i>
                                    <p>@lang('menu.businessSettings')</p>
                                </a>
                            </li>
                            <li class="{{  Request::segment(3)=="role-permission" ? 'active-link' : '' }}">
                                <a href="{{ route('admin.role-permission.index') }}">
                                    <i class="fa fa-key fa-2x"></i>
                                    <p>@lang('menu.rolesPermission')</p>
                                </a>
                            </li>
                        </ul>
                </li>

                @endpermission --}}
                    <hr>
                    <li>
                        <a target='_blank' href="/openings/{{ $global->id }}">
                            <i class="fa fa-link fa-2x"></i>
                            <p class="label_before">Openings</p>
                        </a>
                    </li>
                    <br>
                    <br>
                    <br>



                </ul>
            </div>
        </div>
        <div class="modal" id="upgradePlanFromFreeToOthers">
            <div class="modal-dialog">
                <form class="ajax-form" action="/upgrade-from-free-to-others" method="GET"
                    id="upgradePlanFromFreeToOthersForm">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Upgrade Your Plan</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="assessment_name">Plan</label>
                                <select name="plan" class="custom-select" id="planValue">
                                    <option value="plus">Plus Plan</option>
                                    <option value="premium">Premium Plan</option>
                                </select>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" id="upgradePlanFromFreeToOthersFormSubmit"
                                class="btn btn-success">Submit</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- main container -->
        <div id="main-container" style="margin-top:65px !important;">
            @php
                function isFuture($date)
                {
                    if (strtotime(now()) <= strtotime($date)) {
                        return 1;
                    }
                    return 0;
                }
                if ($user->trial_ends_at) {
                    // if trial hasBeen Ended
                    $trialHasEnded = isFuture($user->trial_ends_at);
                    $remainingDays = now()->diffInDays($user->trial_ends_at, false) + 1;
                }
            @endphp
            @if ($user->package == 'free')
                <div class="alert alert-warning mb-0" role="alert">
                    You have {{ $remainingDays }} days Free Trial left, Please <a data-toggle="modal"
                        data-target="#upgradePlanFromFreeToOthers" href="#">upgrade</a> your plan.
                </div>
            @endif
            <div class="greetings-box">
                <div class="d-flex flex-column">
                    <h4 class="text-light" id="greeting">Good Afternoon !</h4>
                    <h4 class="text-light">{{ Auth::user()->name }}</h4>
                </div>

                <h4 class="text-light"> {{ date('l') }}, {{ date('d M ') }}</h4>
            </div>
            <div class="box" style='padding:10px 20px 10px 20px;'>
                @yield('content')
            </div>
        </div>

        @include('sections.right-sidebar')
        <script>
            const menuTrigger = document.getElementById('menu-trigger'),
                body = document.querySelector('body');
            menuTrigger.addEventListener('click', toggleSideMenu);

            function toggleSideMenu(e) {
                e.preventDefault();
                body.classList.toggle('menu-open');
            }

            function greet() {
                var now = new Date();
                var hrs = now.getHours();

                if (hrs < 12)
                    document.getElementById("greeting").innerHTML = "Good Morning !"
                if (hrs >= 12 && hrs < 17)
                    document.getElementById("greeting").innerHTML = "Good Afternoon !"
                if (hrs >= 17)
                    document.getElementById("greeting").innerHTML = "Good Evening !"
            }

        </script>

        <!-- jQuery -->
        <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('assets/node_modules/popper/popper.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.js') }}"></script>

        <!-- SlimScroll -->
        <script src="{{ asset('assets/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
        <!-- FastClick -->
        <script src="{{ asset('assets/plugins/fastclick/fastclick.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>

        <script src="{{ asset('js/sidebarmenu.js') }}"></script>
        <script src='//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/js/bootstrap-select.min.js'></script>
        <script src="{{ asset('assets/node_modules/sweetalert/sweetalert.min.js') }}"></script>
        <script src="{{ asset('froiden-helper/helper.js') }}"></script>
        <script src="{{ asset('assets/node_modules/toast-master/js/jquery.toast.js') }}"></script>

        <script>
            $('body').on('click', '.right-side-toggle', function() {
                $("body").removeClass("control-sidebar-slide-open");
            })
            $('#upgradePlanFromFreeToOthersFormSubmit').click(function() {
                $('#upgradePlanFromFreeToOthersForm').submit();
            });
            $(function() {
                $('.selectpicker').selectpicker();
            });

            $('.language-switcher').change(function() {
                var lang = $(this).val();
                $.easyAjax({
                    url: '{{ route('admin.language-settings.change-language') }}',
                    data: {
                        'lang': lang
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            window.location.reload();
                        }
                    }
                });
            });

            $('#mark-notification-read').click(function() {
                var token = '{{ csrf_token() }}';
                $.easyAjax({
                    type: 'POST',
                    url: '{{ route('mark-notification-read') }}',
                    data: {
                        '_token': token
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            $('.top-notifications').remove();
                            $('#top-notification-dropdown .notify').remove();
                            window.location.reload();
                        }
                    }
                });

            });

        </script>

        @stack('footer-script')
    </body>

    </html>
