@extends('client/layouts/layoutMaster')

@section('title', 'À propos')

@section('page-styles')
<!-- Place your custom styles here -->
@vite([
    'resources/assets/client/css/linearicons.css',
    'resources/assets/client/css/font-awesome.min.css',
    'resources/assets/client/css/themify-icons.css',
    'resources/assets/client/css/owl.carousel.css',
    'resources/assets/client/css/nice-select.css',
    'resources/assets/client/css/nouislider.min.css',
    'resources/assets/client/css/ion.rangeSlider.css',
    'resources/assets/client/css/ion.rangeSlider.skinFlat.css',
    'resources/assets/client/css/magnific-popup.css',
    'resources/assets/client/css/bootstrap.css',
    'resources/assets/client/css/main.css',
])
<style>
.about-section {
    padding: 60px 0;
 text-align: justify;
}
.about-section h2 {
    font-weight: 700;
    margin-bottom: 20px;
}
.about-section p {
    font-size: 16px;
    line-height: 1.8;
    margin-bottom: 20px;
}
</style>
@endsection

@section('page-content')
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="flex-wrap breadcrumb-banner d-flex align-items-center justify-content-end">
            <div class="col-first">
                <h1>À propos de KMR Chogan</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ route('site.index') }}">Accueil<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">À propos</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<section class="about-section">
    <div class="container">
        <div class="mb-5 text-center">
            <h2>A propos de KMR Chogan</h2>
          </div>
          
          <div class="row justify-content-center">
            <div class="col-lg-10">
                <p>La boutique en ligne de <strong>KMR Chogan by Shogun.cm</strong> est spécialisée dans la commercialisation de produits Chogan, notamment les parfums. Nous ne fabriquons pas nos propres produits et nous nous concentrons sur la distribution de produits de qualité aux prix abordables.</p>
                <p>Nous sélectionnons chaque parfum pour offrir une expérience olfactive proche des grandes marques, mais à un prix accessible. La qualité des produits et la satisfaction de nos clients sont nos priorités.</p>

                <p>La boutique se réserve le droit d'annuler une commande pour diverses raisons, notamment :</p>
                <ul>
                    <li>Un produit est temporairement indisponible.</li>
                    <li>Le prix d'un produit a changé depuis sa dernière mise à jour et n'était pas encore en stock.</li>
                </ul>

                <p>Pour le moment, nous ne permettons pas encore le paiement en ligne via Orange Money, MTN Mobile Money ou carte bancaire. Les commandes se font uniquement via le canal WhatsApp, où vous êtes redirigé après validation de votre panier, et nous nous assurons que chaque commande est validée avant expédition.</p>

                <p>Notre objectif est de rendre les parfums Chogan accessibles à tous, tout en garantissant un service fiable et professionnel.</p>
            </div>
        </div>
    </div>
</section>
@endsection

@section('page-scripts')
	<!-- Place your custom scripts here -->
	@vite([
		'resources/assets/client/js/vendor/jquery-2.2.4.min.js',
		'resources/assets/client/js/jquery.ajaxchimp.min.js',
		'resources/assets/client/js/jquery.nice-select.min.js',
		'resources/assets/client/js/jquery.sticky.js',
		'resources/assets/client/js/nouislider.min.js',
		'resources/assets/client/js/countdown.js',
		'resources/assets/client/js/jquery.magnific-popup.min.js',
		'resources/assets/client/js/owl.carousel.min.js',
		'resources/assets/client/js/gmaps.min.js',
	  'resources/assets/client/js/vendor/jquery-2.2.4.min.js',
    'resources/assets/client/js/vendor/bootstrap.min.js',
    'resources/assets/client/js/main.js',
	])

@endsection
