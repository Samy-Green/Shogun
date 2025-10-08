@php

@endphp
<!-- Start Header Area -->
<header class="header_area sticky-header">
  <div class="main_menu">
    <nav class="navbar navbar-expand-lg navbar-light main_box">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <a class="navbar-brand logo_h" href="{{ route('site.index') }}">
          <img src="{{ Vite::asset('resources/assets/client/img/logo.png') }}" style="max-width:75px" alt="Logo"> <span class="title" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: bolder;">KMR CHOGAN</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
          <ul class="nav navbar-nav menu_nav ml-auto">
            <li class="nav-item {{ request()->routeIs('site.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('site.index') }}">Accueil</a></li>
            <li class="nav-item {{ request()->routeIs('site.categories') ? 'active' : '' }}"><a class="nav-link" href="{{ route('site.categories') }}">Produits</a></li>
            {{-- <li class="nav-item submenu dropdown">
              <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                 aria-expanded="false">Shop</a>
              <ul class="dropdown-menu">
                <li class="nav-item"><a class="nav-link" href="{{ route('site.checkout') }}">Product Checkout</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('site.cart') }}">Shopping Cart</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('site.confirmation') }}">Confirmation</a></li>
              </ul>
            </li> --}}
            {{-- <li class="nav-item submenu dropdown">
              <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                 aria-expanded="false">Blog</a>
              <ul class="dropdown-menu">
                <li class="nav-item"><a class="nav-link" href="{{ route('site.blog') }}">Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('site.single-blog') }}">Blog Details</a></li>
              </ul>
            </li> --}}
            {{-- <li class="nav-item submenu dropdown">
              <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                 aria-expanded="false">Pages</a>
              <ul class="dropdown-menu">
                <li class="nav-item"><a class="nav-link" href="{{ route('site.login') }}">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('site.tracking') }}">Tracking</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('site.elements') }}">Elements</a></li>
              </ul>
            </li> --}}
            <li class="nav-item  {{ request()->routeIs('site.contact') ? 'active' : '' }}"><a class="nav-link" href="{{ route('site.contact') }}">Contact</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="nav-item {{ request()->routeIs('site.cart') ? 'active' : '' }}"><a href="{{ route('site.cart') }}" class="cart" title="Voir le panier"><span class="ti-bag"></span></a></li>
            <li class="nav-item">
              <button class="search"><span class="lnr lnr-magnifier" id="search"></span></button>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
  <div class="search_input" id="search_input_box">
    <div class="container">
      <form class="d-flex justify-content-between" method="GET" action="{{ route('site.categories') }}">
        <input type="text" class="form-control" id="search_input" name="search_query" placeholder="Rechercher ici...">
        <button type="submit" class="btn"></button>
        <span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
      </form>
    </div>
  </div>
</header>
<!-- End Header Area -->
