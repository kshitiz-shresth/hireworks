@extends('layouts.app') @push('head-script')
<link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
<style>
    .mb-20 {
        margin-bottom: 20px
    }

    .card{
        margin-top:10px;
    }

    .content-header{
        display:none;
    }
</style>


@endpush




@section('content')

<div class="row">
    <div class="col-2">
            <div class="card">
                <div class="card-body">
                    <div id="create-new-button">
                        @permission('add_jobs')
                            <button data-toggle="modal" data-target="#addJob" class="btn btn-sm btn-primary pull-right" type="button">
                                <img src="/assets/create.png" alt="">
                                   Create New
                            </button>
                        @endpermission
                    </div>
                    <hr>
                    <div id="jobs-sidemenu">
                        <button class="buttons {{ Request::segment(2)=='jobs' ? 'active' : '' }}" >
                            <a href="/admin/jobs">
                                <i class="fa fa-suitcase fa-lg main-icon-1"></i>
                                <p class="main_text">All Jobs</p>
                            </a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <div class="col-10">
        <div class="card">
            <div class="card-body">
                <div class="row clearfix">
                    <div class="col-md-12 mb-20">
                        <h3 class="pull-left">All Jobs</h3>




                    </div>
                </div>

                <div class="table-responsive m-t-40">
                    <table id="myTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>@lang('menu.locations')</th>
                                {{-- <th>@lang('app.startDate')</th>
                                <th>@lang('app.endDate')</th> --}}
                                <th>Hiring Team</th>
                                <th>@lang('app.status')</th>
                                <th>@lang('app.action')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="addJob">
        <div class="modal-dialog">
        <form class="ajax-form" method="POST" id="createForm">
        @csrf
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Job</h4>
                        <button type="button" onclick="emptyAssessment()" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="assessment_name">Job Title</label>
                            <textarea class="form-control" type="text" name="job_name" id="job_name" ></textarea><br/>
                        </div>
                        <input type="hidden" name="company_id" id="company_id" value="{{ \Auth::user()->company_id }}">


                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" id="save-form" class="btn btn-success" >Create Job</button>
                        <button type="button"  onclick="emptyAssessment();" class="btn btn-danger" data-dismiss="modal">Cancel</button>
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

    var table = $('#myTable').dataTable({
            responsive: true,
            // processing: true,
            serverSide: true,
            ajax: {'url' : '{!! route('admin.jobs.data') !!}',
                    "data": function ( d ) {
                        return $.extend( {}, d, {
                            "filter_company": $('#filter-company').val(),
                            "filter_status": $('#filter-status').val(),
                        } );
                    }
                },
            language: {
                "url": "<?php echo __("app.datatable") ?>"
            },
            "fnDrawCallback": function( oSettings ) {
                $("body").tooltip({
                    selector: '[data-toggle="tooltip"]'
                });
            },
            columns: [
                { data: 'title', name: 'title' },
                { data: 'job_location', name: 'job_location' },
                // { data: 'start_date', name: 'start_date' },
                // { data: 'end_date', name: 'end_date' },
                { data: 'hiring_team', name: 'hiring_team' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', width: '20%' }
            ]
        });

        new $.fn.dataTable.FixedHeader( table );

        $('#filter-company, #filter-status').change(function () {
            table._fnDraw();
        })


        $('body').on('click', '.sa-params', function(){
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
            }, function(isConfirm){
                if (isConfirm) {

                    var url = "{{ route('admin.jobs.destroy',':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {'_token': token, '_method': 'DELETE'},
                        success: function (response) {
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

    $('#save-form').click(function () {
        var job_name = $("#job_name").val();
        var company_id = $("#company_id").val();
        $.ajax({
            url: '/admin/jobs/saveJob?name='+job_name+'&company_id='+company_id,
                container: '#createForm',
                type: "POST",
                redirect: true,
                data: $('#createForm').serialize(),
                success:function(data){
                    var url = "/admin/jobs/show?id="+data+"&page=1";

                    window.location.href = url;
            }
        })
    });

    $(document).on('click', '.jobCheckBox', function() {
        var jobChecked=$(this).prop("checked");
        var jobID = $(this).data('id');
        $.easyAjax({
                url: '/admin/jobs/changeStatus',
                type: "GET",
                data: { 'id' : $(this).data('id'), 'checked': $(this).prop("checked") },
                success: function(data){

                    if(!jobChecked){
                        $(`#activeOrInactive${jobID}`).text('InActive');
                    }
                    else{
                        $(`#activeOrInactive${jobID}`).text('Active');
                    }
            }
        });

        // if ($(this).prop("checked")) {
        //     console.log(`checked ${$(this).data('id')}`);
        // }
    });


    function emptyAssessment(){
        $("#job_name").val("")
    }

</script>


@endpush
