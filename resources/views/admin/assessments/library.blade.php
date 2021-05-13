@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
@endpush

<style>
    .library-box{
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .library-box span a{
        font-weight: 600;
    }
    .content-header{
        display:none;
    }

    .content-wrapper {
        background: #fff !important;
    }
    .card {
        box-shadow: none !important;
    }

    .up_header{
        padding:20px 20px 0px 20px;
    }

    #addAssessment .form-control {
        padding: 10 !important;
    }

    .modal{
        margin-top:5% !important;
    }
    .modal-body{
        padding:20px !important;
    }

    .modal-header{
        padding:20px !important;
    }

    .assessment_lists .nav {
        border-top:3px solid #132639;
    }
</style>


@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <a   href="/admin/assessments"> <i class="fa fa-arrow-left"></i></a>
            <h4 class="mb-0 ml-2">Assessment Library</h4></div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column;">
                @foreach (\App\Assessment::where('company_id',0)->get() as $item)
                <div class="library-box">
                    <span><a href="/admin/assessments/show?id={{ $item->id }}">{{ $item->name }}</a></span>
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
@endsection

@push('footer-script')
    <script src="//cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

    <script>
        function deleteAssessment(event,id){
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
                                window.location.reload();
                            }
                        }
                    });
                }
            });
        }

        function emptyAssessment(){
            $("#assessment_name").val("")
            $("#summary").val("")
        }

        function loadLoader(container,message){
            debugger
            if (message == undefined) {
                message = "Loading...";
            }

            var html = '<div class="loading-message"><div class="block-spinner-bar"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>';


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

        $('#save-form').click(function () {
            loadLoader('#createForm',"Loading...")
            $.ajax({
                url: '{{route('admin.assessments.saveAssessment')}}',
                container: '#createForm',
                type: "POST",
                redirect: true,
                data: $('#createForm').serialize(),
                success:function(data){
                    loadLoader('#createForm',"Loading...")
                    var url = "/admin/assessments/edit?id="+data;

                    window.location.href = url;
                }
            })
        });

    </script>
@endpush