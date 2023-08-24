@php
$configData = Helper::appClasses();
@endphp

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-portal.css')}}">
@endsection


@extends('layouts/blankLayout')
@section('title', 'Portal')

@section('content')
<div class="container__portal">
    <div class="portal__circle__blue"></div>
    <div class="portal__circle__red"></div>
    <div class="container__card">
        <div class="card__portal">
            <p class="card__heading__portal">Marketing</p>
            <p class="card__desc__portal">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nulla,
                assumenda!</p>
            </p>
            <a class="card__btn__portal" href="{{url('/marketing')}}">OPEN</a>
        </div>
        <div class="card__portal card__red">
            <p class="card__heading__portal">Finance</p>
            <p class="card__desc__portal">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Est, ea!</p>
            <a class="card__btn__portal" href="{{url('/finance')}}">OPEN</a>
        </div>
    </div>
</div>
@endsection