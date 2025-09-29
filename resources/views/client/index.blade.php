
@extends('client/layouts/layoutMaster')

@section('title', 'Accueil')

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

    <!-- Script externe Google Maps (pas dans Vite, donc garder en CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
            integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
            crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
@endsection

@section(section: 'page-content')

<style>
	.single-deal.fixed-height {
    height: 300px;        /* hauteur fixe que tu peux ajuster */
    overflow: hidden;     /* coupe les débordements */
    position: relative;
}

.single-deal.fixed-height img {
    width: 100%;
    height: 100%;
    object-fit: cover;    /* adapte l'image à la div sans la déformer */
}

</style>

	<!-- start banner Area -->
	@include('client.components.home.banner', ['carousels' => $carousels])
	<!-- End banner Area -->

	<!-- start features Area -->
	<section class="features-area section_gap">
			<div class="container">
					<div class="row features-inner">
							<!-- fonctionnalité 1 -->
							<div class="col-lg-3 col-md-6 col-sm-6">
									<div class="single-features">
											<div class="f-icon">
													<img src="{{ Vite::asset('resources/assets/client/img/features/f-icon1.png') }}" alt="">
											</div>
											<h6>Livraison rapide</h6>
											<p>Recevez vos produits rapidement et en toute sécurité</p>
									</div>
							</div>
							<!-- fonctionnalité 2 -->
							<div class="col-lg-3 col-md-6 col-sm-6">
									<div class="single-features">
											<div class="f-icon">
													<img src="{{ Vite::asset('resources/assets/client/img/features/f-icon2.png') }}" alt="">
											</div>
											<h6>Produits de qualité</h6>
											<p>Nous garantissons des produits soigneusement sélectionnés</p>
									</div>
							</div>
							<!-- fonctionnalité 3 -->
							<div class="col-lg-3 col-md-6 col-sm-6">
									<div class="single-features">
											<div class="f-icon">
													<img src="{{ Vite::asset('resources/assets/client/img/features/f-icon3.png') }}" alt="">
											</div>
											<h6>Support 24/7</h6>
											<p>Une assistance disponible à tout moment pour vous aider</p>
									</div>
							</div>
							<!-- fonctionnalité 4 -->
							<div class="col-lg-3 col-md-6 col-sm-6">
									<div class="single-features">
											<div class="f-icon">
													<img src="{{ Vite::asset('resources/assets/client/img/features/f-icon4.png') }}" alt="">
											</div>
											<h6>Paiement à la livraison</h6>
											<p>Paiement simple et sécurisé lors de la livraison</p>
									</div>
							</div>
					</div>
			</div>
	</section>
	<!-- end features Area -->

	<!-- Start category Area -->
	<section class="category-area">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-12 text-center">
					<div class="row">
						@foreach($categories as $category)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="single-deal fixed-height">
                        <div class="overlay"></div>
                        <img class="img-fluid w-100" src="{{ asset($category->image) }}" alt="{{ $category->name }}">
                        <a href="{{ route('site.categories', ["category" => $category->id]) }}" >
                            <div class="deal-details">
                                <h6 class="deal-title">{{ $category->name }}</h6>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End category Area -->

	<!-- start product Area -->
	@include('client.components.home.product_area', ['lastProducts' => $lastProducts, 'comingProducts' => $comingProducts])
	<!-- end product Area -->

	<!-- Start exclusive deal Area -->
	@if ($latestActivePromo && $lastDealsProducts->isNotEmpty())		
	<section class="exclusive-deal-area">
		<div class="container-fluid">
			<div class="row justify-content-center align-items-center">
				<div class="col-lg-6 no-padding exclusive-left" style="background: url({{ asset($latestActivePromo->image) }}) center center no-repeat; background-size: cover;">
					<div class="row clock_sec clockdiv" id="clockdiv">
						<div class="col-lg-12">
							<h1>{{ $latestActivePromo->name }}</h1>
							<p>{{ $latestActivePromo->descripption }}</p>
						</div>
						<div class="col-lg-12">
							<div class="row clock-wrap">
								<div class="col clockinner1 clockinner">
									<h1 class="days">00</h1>
									<span class="smalltext">Days</span>
								</div>
								<div class="col clockinner clockinner1">
									<h1 class="hours">00</h1>
									<span class="smalltext">Hours</span>
								</div>
								<div class="col clockinner clockinner1">
									<h1 class="minutes">00</h1>
									<span class="smalltext">Mins</span>
								</div>
								<div class="col clockinner clockinner1">
									<h1 class="seconds">00</h1>
									<span class="smalltext">Secs</span>
								</div>
							</div>
						</div>
					</div>
					<a href="" class="primary-btn">Acheter maintenant</a>
				</div>
				<div class="col-lg-6 no-padding exclusive-right">
					<div class="active-exclusive-product-slider">
						@foreach ($lastDealsProducts as $product )
						<!-- single exclusive carousel -->
						<div class="single-exclusive-slider">
							<img class="img-fluid" src="{{ asset($product->image) }}" alt="">
							<div class="product-details">
								<div class="price">
									<h6>{{ number_format($product->price - $product->reduction) }} FCFA</h6>
									<h6 class="l-through">{{ number_format($product->price) }} FCFA</h6>
								</div>
								<h4>{{$product->name}} ({{$product->code}})</h4>
								<div class="add-bag d-flex align-items-center justify-content-center">
									@if (isset($cart[$product->id]))
										<a class="add-btn" href="{{ route('cart.remove', $product->id) }}"><span class="ti-close"></span></a>
									@else
										<a class="add-btn" href="{{ route('cart.add', $product->id) }}"><span class="ti-bag"></span></a>
									@endif
									<span class="add-text text-uppercase">Ajouter au panier</span>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</section>

	<script>
		var deadline = new Date("<?php echo $latestActivePromo->end_date; ?>");
	</script>
	@endif
	<!-- End exclusive deal Area -->

	<!-- Start brand Area -->
	{{-- <section class="brand-area section_gap">
		<div class="container">
			<div class="row">
				@for ($i = 1; $i <= 5; $i++)
					<a class="col single-img" href="#">
					<img class="img-fluid d-block mx-auto" src="{{asset('client/img/brand/'.$i.'.png')}}" alt="">
					</a>
				@endfor
			</div>
		</div>
	</section> --}}
	<!-- End brand Area -->

	<!-- Start related-product Area -->
	@include('client.components.related_products', ['lastPromoProducts' => $lastPromoProducts])
	<!-- End related-product Area -->

@endsection
