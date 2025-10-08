@php
$configData = Helper::appClasses();
$isFront = true;
@endphp

@section('layoutContent')

@extends('layouts/commonMaster' )

@include('layouts/sections/navbar/navbar-front')

<!-- Sections:Start -->
@include('_partials/alerts/alert')

@yield('content')
<!-- / Sections:End -->

@include('layouts/sections/footer/footer-front')
@endsection
