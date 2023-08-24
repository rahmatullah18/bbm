@php
$configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')

@section('title', 'COA')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />

@endsection

@section('vendor-script')

<script src="{{asset('assets/vendor/libs/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-responsive/datatables.responsive.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js')}}"></script>
<!-- Flat Picker -->
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>

@endsection

@section('page-script')
{{-- <script src="{{asset('assets/js/tables-datatables-advanced.js')}}"></script> --}}
<script>
    $(document).ready(function() {
        $('#coa-table').DataTable({
            responsive: true
            , autoWidth: false
            , columnDefs: [{
                orderable: false
                , width: 100
                , targets: [0]
            }]
            , order: [
                [1, 'desc']
            ]
        });
    });

</script>
@endsection

@section('content')
{{-- alert --}}
@if (session('success'))
<div class="alert alert-success alert-dismissible d-flex align-items-center" role="alert">
    <i class="bx bx-xs bx-command me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </button>
</div>
@elseif(session('error'))
<div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
    <i class="bx bx-xs bx-command me-2"></i>
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </button>
    @endif
    {{-- end alert --}}
    <div class="card">
        <h5 class="card-header">
            COA
        </h5>
        <div class="table-responsive text-nowrap px-4">
            <x-coa.table-coa :dataAkun="$dataAkun" />
        </div>

    </div>
    @endsection
