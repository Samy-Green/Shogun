  @extends('client/layouts/blankLayout')
  @section('content')

  @if(session('suscribe_success'))
    <script>
      alert("Merci pour votre inscription à notre newsletter !");
    </script>
  @endif
  @if(session('suscribe_error'))
    <script>
      alert("Une erreur est survenue lors de votre inscription à notre newsletter !");
    </script>
  @endif
  <!-- Header -->
  @include('client/layouts/sections/header')

  <!-- Contenu principal -->
  @yield('page-content')

  <!-- Footer -->
  @include('client/layouts/sections/footer')

  @yield('modals')
  
  @endsection