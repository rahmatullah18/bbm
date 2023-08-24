@php
$configData = Helper::appClasses();
@endphp
@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-arus-kas.css')}}">
@endsection

@extends('layouts/layoutMaster')

@section('title', 'Arus Kas')

@section('vendor-style')
{{-- <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" /> --}}
@endsection

@section('vendor-script')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.3/dist/cdn.min.js"></script>
<script src="{{asset('assets/vendor/libs/datatables/jquery.dataTables.js')}}"></script>
{{-- <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-responsive/datatables.responsive.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js')}}"></script> --}}
<!-- Flat Picker -->
{{-- <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script> --}}

@endsection

@section('page-script')
{{-- <script>
    $(document).ready(function() {
        $('#arus-kas-table-operasional').DataTable({
            responsive: true
            , autoWidth: false
            , columnDefs: [{
                orderable: false
                , width: 100
                , targets: [0]
            }]
            , order: [
                [0, 'asc']
            ]
        });

        $('#arus-kas-table-lainnya').DataTable({
            responsive: true
            , autoWidth: false
            , columnDefs: [{
                orderable: false
                , width: 100
                , targets: [0]
            }]
            , order: [
                [0, 'asc']
            ]
        });
    });

    $(document).ready(function() {
        $('#arus-kas-table-financial').DataTable({
            responsive: true
            , autoWidth: false
            , columnDefs: [{
                orderable: false
                , width: 100
                , targets: [0]
            }]
            , order: [
                [0, 'asc']
            ]
        });
        $('#arus-kas-table-investasi').DataTable({
            responsive: true
            , autoWidth: false
            , columnDefs: [{
                orderable: false
                , width: 100
                , targets: [0]
            }]
            , order: [
                [0, 'asc']
            ]
        });
    }); --}}

</script>
@endsection

@section('content')
<div class="container__aruskas">
    {{-- title --}}
    <div class="header__aruskas">
        <h3 class="">Arus Kas</h3>
    </div>
    {{-- filter by tanggal dan button cetak excel --}}
    <x-arus-kas.filter-arus-kas />
    {{-- table horizontal --}}
    <div class="card">
        {{-- heading --}}
        <div class=" py-2 px-3">Akun dan Kategori</div>

        {{-- table aktivitas operasional --}}
        <x-arus-kas.table-aktivitas-operasional :dummyData="$aktivitasOperasional" />

        {{-- table aktivitas investasi --}}
        <x-arus-kas.table-aktivitas-investasi :dummyData="$aktivitasInvestasi" />

        {{-- table aktivitas financial --}}
        <x-arus-kas.table-aktivitas-financial :dummyData="$aktivitasPendanaan" />

        {{-- table aktivitas lalinnya --}}
        <x-arus-kas.table-aktivitas-lainnya :dummyData="$aktivitasLainnya" />

        {{-- list kas --}}
        <x-arus-kas.list-kas :aruskasBertambah="$aruskasBertambah" :aruskasBerkurang="$aruskasBerkurang" />

        {{-- end aktivitas operasional --}}

        @endsection
