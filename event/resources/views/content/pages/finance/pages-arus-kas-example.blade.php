@php
$configData = Helper::appClasses();
@endphp
@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-arus-kas.css')}}">
@endsection

@extends('layouts/layoutMaster')

@section('title', 'Arus Kas')
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
        {{-- <x-arus-kas.table-aktivitas-investasi :dummyData="$dummyData" /> --}}

        {{-- table aktivitas financial --}}
        {{-- <x-arus-kas.table-aktivitas-financial :dummyData="$dummyData" /> --}}

        {{-- table aktivitas lalinnya --}}
        {{-- <x-arus-kas.table-aktivitas-lainnya :dummyData="$dummyData" /> --}}

        {{-- list kas --}}
        {{-- <x-arus-kas.list-kas /> --}}

        {{-- end aktivitas operasional --}}

        @endsection
