<style>
  @media (min-width: 991px) {
  .header_area .navbar .nav.navbar-nav.menu_nav li.item-none {
    display: none;
  }
}
</style>
<!-- Start Header Area -->
<header class="header_area sticky-header">
  <div class="main_menu">
    <nav class="navbar navbar-expand-lg navbar-light main_box">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <a class="navbar-brand logo_h" href="{{ route('site.index') }}">
          <img src="{{ Vite::asset('resources/assets/client/img/logo.png') }}" style="max-width:50px" alt="Logo"> <span class="title" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight: 500;">KMR CHOGAN</span>
        </a>
        <button id="navbar-burger" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
          <ul class="ml-auto nav navbar-nav menu_nav">
            <li class="nav-item {{ request()->routeIs('site.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('site.index') }}">Accueil</a></li>
            <li class="nav-item {{ request()->routeIs('site.about') ? 'active' : '' }}"><a class="nav-link" href="{{ route('site.about') }}">À propos</a></li>
            <li class="nav-item {{ request()->routeIs('site.products') ? 'active' : '' }}"><a class="nav-link" href="{{ route('site.products') }}">Catalogue</a></li>
            <li class="nav-item  {{ request()->routeIs('site.contact') ? 'active' : '' }}"><a class="nav-link" href="{{ route('site.contact') }}">Contact</a></li>
            <li class="nav-item item-none {{ request()->routeIs('site.cart') ? 'active' : '' }}"><a class="nav-link" href="{{ route('site.cart') }}">Panier</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="nav-item {{ request()->routeIs('site.cart') ? 'active' : '' }}">
              <a href="{{ route('site.cart') }}" class="cart" title="Voir le panier"><span class="ti-bag"></span></a>
            </li>
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
      <form class="d-flex justify-content-between" method="GET" action="{{ route('site.products') }}">
        <input type="text" class="form-control" id="search_input" name="search_query" placeholder="Rechercher ici...">
        <button type="submit" class="btn"></button>
        <span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
      </form>
    </div>
  </div>
</header>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Sélectionne tous les liens de catégories principales
    const navbarBurger = document.querySelector('#navbar-burger');

    navbarBurger.addEventListener('click', function(e) {
        e.preventDefault();

        const targetId = this.getAttribute('data-target').substring(1); // récupère l'id de la cible
        const targetUl = document.getElementById(targetId);

        // Si la sous-catégorie est déjà ouverte, on ferme
        if (targetUl.classList.contains('show')) {
            targetUl.classList.remove('show');
            this.setAttribute('aria-expanded', 'false');
        } else {
            // Sinon, on ouvre
            targetUl.classList.add('show');
            this.setAttribute('aria-expanded', 'true');
        }
    });
});
</script>	
<!-- End Header Area -->
