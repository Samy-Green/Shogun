<!DOCTYPE html>
<html lang="fr" class="no-js">
<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('img/fav.png') }}">
    <!-- Author Meta -->
    <meta name="author" content="CodePixar">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>@yield('title', 'Kamer Chogan')</title>

    <!-- Styles -->
    @yield('page-styles')
    
</head>
<body @yield('body-attributes')>
    
    <!-- Contenu principal -->
    @yield('content')


    <!-- Scripts -->
    @yield('page-scripts')
    
</body>
</html>
