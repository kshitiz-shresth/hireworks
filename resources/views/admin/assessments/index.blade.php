@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
@endpush

<style>
    .library-box {
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .library-box span a {
        font-weight: 600;
    }

    .content-header {
        display: none;
    }

    .content-wrapper {
        background: #fff !important;
    }

    .card {
        box-shadow: none !important;
    }

    .up_header {
        padding: 20px 20px 0px 20px;
    }

    #addAssessment .form-control {
        padding: 10 !important;
    }

    .modal {
        margin-top: 5% !important;
    }

    .modal-body {
        padding: 20px !important;
    }

    .modal-header {
        padding: 20px !important;
    }

    .assessment_lists .nav {
        border-top: 3px solid #132639;
    }

</style>


@section('content')

    <div class="row up_header">
        <div class="col-md-12 mb-20 d-flex">
            @if (Auth::user()->email == 'super@super.com')
                <a href="{{ env('HIREWORK_ADMIN_URL') }}/admin" class="btn btn-primary mr-3"><i
                        class="fa fa-arrow-left"></i> Back</a>
            @endif
            <h3>My Assessments</h3>
        </div>
    </div>
    <div class="ml-3 row">
            @permission('add_category')
            <a><button class="btn mr-2 btn-sm btn-primary pull-right" data-toggle="modal" data-target="#addAssessment" type="button">
                    <i class="fa fa-plus-circle"></i> Crete New Assessment
                </button></a>
            @endpermission
            <a class="btn btn-sm btn-primary" href="/admin/library">Import from Library</a>

        </div>
        <hr />
        <div class="row assessment_lists">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            @if (count($assessments) > 0)
                                @foreach ($assessments as $a)
                                    <div class="col-md-4" style="padding:0px 40px 40px 0px;">
                                        <!-- Tabs nav -->
                                        <div class="nav flex-column nav-pills nav-pills-custom" id="v-pills-tab" role="tablist"
                                            aria-orientation="vertical">
                                            <a class="nav-link mb-3 p-3 shadow" id="plusButton"
                                                href="/admin/assessments/show?id={{ $a->id }}">
                                                <span class="font-weight-bold big"><br />
                                                    <h4 style="color:#0151ce">{{ $a->name }}
                                                        <span class="pull-right"><i
                                                                onclick="return deleteAssessment(event,{{ $a->id }})"
                                                                class="fa fa-trash"></i></h2>
                                                            <hr />

                                                            <h5> Summary </h5>
                                                        </span>
                                                        <p style="color:black">{{ $a->summary }}</p>
                                                        <hr />

                                                        <h5> Questions </h5>
                                                </span>
                                                <p style="color:black">{{ $a->count }}</p>
                                                <hr />

                                                <h5> Created <span style="color:black">&nbsp;&nbsp;
                                                        {{ date('d M, Y', strtotime($a->created_at)) }}</span></h5>

                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h4>No Assessments Available.</h4><span><a
                                        style="cursor:pointer;color:#007bff;font-weight:bold;" data-toggle="modal"
                                        data-target="#addAssessment">
                                        &nbsp;Click here</a> to create new Assessment</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{-- @if (Auth::user()->id != 'super@super.com')
        <div class="col-3">
            <div class="card">
                <div class="card-header"><strong>Library</strong></div>
                <div class="card-body">
                    <div style="display: flex; flex-direction: column;">
                        @foreach (\App\Assessment::where('company_id', 0)->get() as $item)
                        <div class="library-box">
                            <span><a href="#">{{ $item->name }}</a></span>
                            <form action="/import-assessments" method="post">
                                @csrf
                                <input type="hidden" name="company_id" value="{{ Auth::user()->company_id }}">
                                <input type="hidden" name="assessment_id" value="{{ $item->id }}">
                                <button type="submit" class="btn btn-success"><i class="fa fa-caret-square-o-left"></i> Import</button>
                            </form>

                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif --}}


            <div class="modal" id="addAssessment">
                <div class="modal-dialog">
                    <form class="ajax-form" method="POST" id="createForm">
                        @csrf
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Add new Skill Assessments</h4>
                                <button type="button" onclick="emptyAssessment()" class="close"
                                    data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="assessment_name">Assessment Name</label>
                                    <input class="form-control" required type="text" name="assessment_name" id="assessment_name" /><br />
                                </div>

                                <div class="form-group">
                                    <label for="summary">Assessment Summary</label>
                                    <textarea class="form-control" type="text" name="summary" id="summary"></textarea>
                                </div>

                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="submit" id="save-form" class="btn btn-success">Create Assessment</button>
                                <button type="button" onclick="emptyAssessment();" class="btn btn-danger"
                                    data-dismiss="modal">Cancel</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        @endsection

        @push('footer-script')
            <script src="//cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
            <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
            <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

            <script>
                function deleteAssessment(event, id) {
                    event.preventDefault()

                    swal({
                        title: "Are You Sure",
                        text: "@lang('errors.deleteWarning')",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "@lang('app.delete')",
                        cancelButtonText: "@lang('app.cancel')",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    }, function(isConfirm) {
                        if (isConfirm) {

                            var url = "{{ route('admin.questions.destroy', ':id') }}";
                            url = url.replace(':id', id);

                            var token = "{{ csrf_token() }}";

                            $.easyAjax({
                                type: 'POST',
                                url: url,
                                data: {
                                    '_token': token,
                                    '_method': 'DELETE'
                                },
                                success: function(response) {
                                    if (response.status == "success") {
                                        $.unblockUI();
                                        window.location.reload();
                                    }
                                }
                            });
                        }
                    });
                }

                function emptyAssessment() {
                    $("#assessment_name").val("")
                    $("#summary").val("")
                }

                function loadLoader(container, message) {
                    debugger
                    if (message == undefined) {
                        message = "Loading...";
                    }

                    var html =
                        '<div class="loading-message"><div class="block-spinner-bar"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>';


                    if (container != undefined) { // element blocking
                        var el = $(container);
                        var centerY = false;
                        if (el.height() <= ($(window).height())) {
                            centerY = true;
                        }
                        el.block({
                            message: html,
                            baseZ: 999999,
                            centerY: centerY,
                            css: {
                                top: '10%',
                                border: '0',
                                padding: '0',
                                backgroundColor: 'none'
                            },
                            overlayCSS: {
                                backgroundColor: 'transparent',
                                opacity: 0.05,
                                cursor: 'wait'
                            }
                        });
                    } else { // page blocking
                        $.blockUI({
                            message: html,
                            baseZ: 999999,
                            css: {
                                border: '0',
                                padding: '0',
                                backgroundColor: 'none'
                            },
                            overlayCSS: {
                                backgroundColor: '#555',
                                opacity: 0.05,
                                cursor: 'wait'
                            }
                        });
                    }
                }



                $('body').on('click', '.sa-params', function() {
                    var id = $(this).data('row-id');
                    swal({
                        title: "@lang('errors.areYouSure')",
                        text: "@lang('errors.deleteWarning')",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "@lang('app.delete')",
                        cancelButtonText: "@lang('app.cancel')",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    }, function(isConfirm) {
                        if (isConfirm) {

                            var url = "{{ route('admin.questions.destroy', ':id') }}";
                            url = url.replace(':id', id);

                            var token = "{{ csrf_token() }}";

                            $.easyAjax({
                                type: 'POST',
                                url: url,
                                data: {
                                    '_token': token,
                                    '_method': 'DELETE'
                                },
                                success: function(response) {
                                    if (response.status == "success") {
                                        $.unblockUI();
                                        //                                    swal("Deleted!", response.message, "success");
                                        table._fnDraw();
                                    }
                                }
                            });
                        }
                    });
                });

                $('#createForm').submit(function(e) {
                    e.preventDefault();
                    loadLoader('#createForm', "Loading...")
                    $.ajax({
                        url: '{{ route('admin.assessments.saveAssessment') }}',
                        container: '#createForm',
                        type: "POST",
                        redirect: true,
                        data: $('#createForm').serialize(),
                        success: function(data) {
                            loadLoader('#createForm', "Loading...")
                            var url = "/admin/assessments/edit?id=" + data;

                            window.location.href = url;
                        }
                    })
                });

            </script>
        @endpush
