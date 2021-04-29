@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
@endpush



@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                        <div class="row clearfix">
                                <div class="col-md-12 mb-20">
                                    @permission('add_category')
                                    <a href="{{ route('admin.questions.create') }}"><button class="btn btn-sm btn-primary" type="button">
                                                <i class="fa fa-plus-circle"></i>  @lang('app.createNew')
                                        </button></a> 
                                    @endpermission
                                    
                                    @permission('view_jobs')
                                    <a href="{{ route('admin.jobs.index') }}"><button class="btn btn-sm btn-warning" type="button">
                                                <i class="fa fa-plus-circle"></i> @lang('menu.jobs')
                                        </button></a> 
                                    @endpermission
                                    
                                    @permission('view_category')
                                    <a href="{{ route('admin.job-categories.index') }}">
                                        <button class="btn btn-sm btn-warning" type="button">
                                                <i class="fa fa-plus-circle"></i> @lang('menu.jobCategories')
                                        </button>
                                    </a> 
                                    @endpermission
                                </div>
                            </div>
                    <div class="table-responsive mt-2">
                        <table id="myTable" class="table table-bordered table-striped ">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('app.question')</th>
                                <th>Type</th>
                                <th>@lang('app.required')</th>
                                <th>@lang('app.action')</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
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
            ajax: '{!! route('admin.questions.data') !!}',
            language: {
                "url": "<?php echo __("app.datatable") ?>"
            },
            "fnDrawCallback": function( oSettings ) {
                $("body").tooltip({
                    selector: '[data-toggle="tooltip"]'
                });
            },
            columns: [
                { data: 'DT_Row_Index'},
                { data: 'question', name: 'question' },
                 { data: 'question_type', name: 'Type' },
                { data: 'required', name: 'required' },
                { data: 'action', name: 'action', width: '20%' }
            ]
        });

        new $.fn.dataTable.FixedHeader( table );

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

                    var url = "{{ route('admin.questions.destroy',':id') }}";
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

    </script>
@endpush