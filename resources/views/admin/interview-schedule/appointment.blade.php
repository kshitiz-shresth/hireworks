@extends('layouts.app')


@section('content')
<style>
    .content-header{
        display:none;
    }
</style>

<iframe src="http://book.hireworks.us/index.php/backend/" width="100%" height="700"></iframe>



@endsection

@push('footer-script')
    <script src="//cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
@endpush