@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset
@php
$configData = Helper::appClasses();

/* Display elements */
$customizerHidden = ($customizerHidden ?? '');

@endphp

@extends('layouts/commonMaster' )

@include('_partials/alerts/alert')

@section('layoutContent')

<!-- Content -->
@yield('content')
<!--/ Content -->

@endsection
