@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/node_modules/dropify/dist/css/dropify.min.css') }}">
    <!-- One of the following themes -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css" />
    <!-- 'classic' theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/monolith.min.css" />
    <!-- 'monolith' theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/nano.min.css" />
    <!-- 'nano' theme -->

    <!-- Modern or es5 bundle -->
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.es5.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endpush

@section('content')
@php
$price = [
    'plus' => '$29 USD',
    'premium' => '$79 USD',
];
@endphp
    <style>
        .pickr .pcr-button {
            border: 1px solid black !important;
            padding: 10px !important;
            width: 50% !important;
        }

        #side_bar_color {
            width: 50% !important;
        }

        #side_bar_text_color {
            width: 50% !important;
        }

    </style>

    <div class="row">
        <div class="col-2">
            <div class="card">
                <div class="card-body">
                    <div id="jobs-sidemenu">
                        <button class="buttons {{ Request::segment(2) == 'profile' ? 'active' : '' }}">
                            <a href="/admin/profile">
                                <i class="fa fa-suitcase fa-lg main-icon-1"></i>
                                <p class="main_text">My Profile</p>
                            </a>
                        </button>
                        <button class="buttons {{ Request::segment(3) == 'settings' ? 'active' : '' }}">
                            <a href="{{ route('admin.settings.index') }}">
                                <i class="fa fa-cog fa-lg main-icon-1"></i>
                                <p class="main_text">@lang('menu.businessSettings')</p>
                            </a>
                        </button>
                        <hr>
                        <button class="buttons {{ Request::segment(3) == 'role-permission' ? 'active' : '' }}">
                            <a href="{{ route('admin.role-permission.index') }}">
                                <i class="fa fa-key fa-lg main-icon-1"></i>
                                <p class="main_text">@lang('menu.rolesPermission')</p>
                            </a>
                        </button>
                        <button class="buttons {{ Request::segment(3) == 'payment-settings' ? 'active' : '' }}">
                            <a href="{{ route('admin.payment-setting.index') }}">
                                <i class="fa fa-dollar fa-lg main-icon-1"></i>
                                <p class="main_text">Payment & Methods</p>
                            </a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-10">
            <div class="card" id="cardBody">
                @if (!$user->trial_ends_at)
                    <div class="card-body">
                        <p><strong class="font-weight-normal">Card Brand</strong>: {{ $user->card_brand }}</p>
                        <p><strong class="font-weight-normal">Card Number</strong>: **** **** **** ****
                            {{ $user->card_last_four }} <a class="text-success font-weight-normal" href="#">Update
                                Card</a></p>
                        @if ($user->ends_at)
                            You have canceled your plan. Your plan will get expired on
                            {{ date('M d, Y ', strtotime($user->ends_at)) }}. If you want to re-subscribe then, <a
                                id="reSubscribe" href="#">Re-Subscribe</a>
                        @else
                            <p><strong class="font-weight-normal">Subscribed Plan</strong>: {{ ucfirst($user->package) }} ({{ $price[$user->package] }})
                                <a class="text-primary " class="btn btn-primary" id="upgradePlan" href="#">Upgrade Plan</a>
                                <a href="#" id="cancelPlan" class="text-danger">Cancel Plan</a></p>
                        @endif
                    </div>
                    
                @else
                    <div class="card-body">
                        <p>Seems like you haven't subscribed any plan yet. Please <a data-toggle="modal"
                                data-target="#upgradePlanFromFreeToOthers" href="#">Subscribe</a>.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="modal" id="changePlan">
        <div class="modal-dialog">
            <form class="ajax-form" action="/upgrade-from-free-to-others" method="GET" id="changePlanForm">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Change Your Plan</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="assessment_name">Plan</label>
                            <select name="plan" class="custom-select" id="myPlan">
                                <option value="plus" @if ($user->package == 'plus') disabled @endif>Plus Plan</option>
                                <option value="premium" @if ($user->package == 'premium') disabled @endif>Premium Plan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" id="myPlanSubmit" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('footer-script')
    <script>
        @if(session('success'))
            console.log('{{ session("success") }}');
        @endif
        $('#upgradePlan').on('click', function(e) {
            e.preventDefault();
            $('#changePlan').modal('show');
        })

        $('#reSubscribe').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure that, you want to resubscribe your plan?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: `Yes`,
                denyButtonText: `No`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $('#cardBody').hide();
                    $('<div id="pleaseWait" class="card-body">Please Wait...</div>').insertAfter($('#cardBody'));

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "/admin/resubscribe-plan",
                        type: "POST",
                        success: function(data) {
                            console.log(data);
                            Swal.fire({
                                title: 'Success!',
                                text: "You Have Re-subscribed Your Plan",
                                icon: 'success',

                            }).then(function() {
                                window.location.replace(
                                    '/admin/settings/payment-settings');
                            });
                        },
                        error: function(error) {
                            $('#cardBody').show();
                            $('#pleaseWait').hide();
                            Swal.fire({
                                title: 'Error!',
                                text: "There is an error",
                                icon: 'error',
                            })
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('Plan Not Changed', '', 'info')
                }
            })
        });

        $('#cancelPlan').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure that, you want to cancel your plan?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: `Yes, Cancel it.`,
                denyButtonText: `No`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $('#cardBody').hide();
                    $('<div id="pleaseWait" class="card-body">Please Wait...</div>').insertAfter($('#cardBody'));
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "/admin/cancel-plan",
                        type: "POST",
                        success: function(data) {
                            console.log(data);
                            Swal.fire({
                                title: 'Success!',
                                text: "You Have Canceled Your Plan",
                                icon: 'success',

                            }).then(function() {
                                window.location.replace(
                                    '/admin/settings/payment-settings');
                            });
                        },
                        error: function(error) {
                            $('#cardBody').show();
                            $('#pleaseWait').hide();
                            Swal.fire({
                                title: 'Error!',
                                text: "There is an error",
                                icon: 'error',
                            })
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('Plan Not Changed', '', 'info')
                }
            })
        });
        $('#myPlanSubmit').on('click', function(e) {
            e.preventDefault();
            $('#myPlanSubmit').prop('disabled', true);
            $('#myPlanSubmit').html('Please Wait..');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/admin/change-plan",
                type: "POST",
                data: {
                    plan: $('#myPlan').val()
                },
                success: function(data) {
                    $('#myPlanSubmit').prop('disabled', false);
                    $('#myPlanSubmit').html('Submit');
                    $('#changePlan').modal('hide');
                    Swal.fire({
                        title: 'Success!',
                        text: "You Have Upgraded Your Plan",
                        icon: 'success',

                    }).then(function() {
                        window.location.replace('/admin/settings/payment-settings');
                    });
                },
                error: function(error) {
                    Swal.fire({
                        title: 'Error!',
                        text: "There is an error",
                        icon: 'error',
                    })
                    $('#confirm-purchase').prop('disabled', false);
                    $("#confirm-purchase").html("Submit");
                }
            });
        })

    </script>

    <script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/node_modules/dropify/dist/js/dropify.min.js') }}" type="text/javascript"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDw9cQQsGxYkPicGbigZG1koUGRC4TAbSs&libraries=places">
    </script>


@endpush
