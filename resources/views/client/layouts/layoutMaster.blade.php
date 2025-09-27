  @extends('client/layouts/blankLayout')
  @section('content')
  <!-- Header -->
  @include('client/layouts/sections/header')

  <!-- Contenu principal -->
  @yield('page-content')

  <!-- Footer -->
  @include('client/layouts/sections/footer')

  @yield('modals')
  
  @endsection