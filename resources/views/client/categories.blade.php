@extends('client/layouts/layoutMaster')

@section('page-styles')
	<!-- Place your custom styles here -->
	@vite([
			'resources/assets/client/css/linearicons.css',
			'resources/assets/client/css/owl.carousel.css',
			'resources/assets/client/css/font-awesome.min.css',
			'resources/assets/client/css/themify-icons.css',
			'resources/assets/client/css/nice-select.css',
			'resources/assets/client/css/nouislider.min.css',
			'resources/assets/client/css/bootstrap.css',
			'resources/assets/client/css/main.css',
	])
@endsection

@section('page-scripts')
	<!-- Place your custom scripts here -->
	@vite([
			'resources/assets/client/js/vendor/jquery-2.2.4.min.js',
			'resources/assets/client/js/vendor/bootstrap.min.js',
			'resources/assets/client/js/jquery.ajaxchimp.min.js',
			'resources/assets/client/js/jquery.nice-select.min.js',
			'resources/assets/client/js/jquery.sticky.js',
			'resources/assets/client/js/nouislider.min.js',
			'resources/assets/client/js/jquery.magnific-popup.min.js',
			'resources/assets/client/js/owl.carousel.min.js',
			'resources/assets/client/js/gmaps.min.js',
			'resources/assets/client/js/main.js',
	])

	{{-- External scripts (non compilés avec Vite) --}}
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
			integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
			crossorigin="anonymous"></script>

	<!-- Google Maps API -->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Sélectionne tous les liens de catégories principales
    const categoryLinks = document.querySelectorAll('.main-nav-list > a[data-toggle="collapse"]');

    categoryLinks.forEach(link => {
        // Empêche le rechargement de la page au clic
        link.addEventListener('click', function(e) {
            e.preventDefault();

            const targetId = this.getAttribute('href').substring(1); // récupère l'id de la cible
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
});
</script>	
@endsection


@section('title', 'Catégories')

@section('body-attributes', 'id=category')

@section('page-content')

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Page Produits</h1>
					<nav class="d-flex align-items-center">
						<a href="index.html">Acceuil<span class="lnr lnr-arrow-right"></span></a>
						<a href="#">Produits</a>
						{{-- <a href="category.html">Fashon Category</a> --}}
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->
	<div class="container">
		<div class="row">
			<div class="col-xl-3 col-lg-4 col-md-5">
				<div class="sidebar-categories">
					<div class="head">Browse Categories</div>
					<ul class="main-categories">
						<li class="main-nav-list"><a href="?category=0">Toutes catégories<span class="number">({{ 20 }})</span></a></li>
						@foreach ($categories as $category)
							@if ($category->count_children > 0)
								@php
									$subcategories = $category->children;
								@endphp
								<li class="main-nav-list"><a data-toggle="collapse" href="#c{{ $category->id }}" aria-expanded="false" aria-controls="c{{ $category->id }}"><span
								class="lnr lnr-arrow-right"></span>{{ $category->name }}<span class="number">({{ $category->count_children }})</span></a>
									<ul class="collapse" id="c{{ $category->id }}" data-toggle="collapse" aria-expanded="false" aria-controls="c{{ $category->id }}">
										<li class="main-nav-list child"><a href="?category={{$category->id}}">Tout<span class="number">({{ $category->count_products }})</span></a></li>

										@foreach ($subcategories as $subcategory)
											<li class="main-nav-list child"><a href="?category={{ $subcategory->id }}">{{ $subcategory->name }}<span class="number">({{ $subcategory->count_products }})</span></a></li>
										@endforeach
									</ul>
								</li>
							@else
								<li class="main-nav-list"><a href="?category={{ $category->id }}">{{ $category->name }}<span class="number">({{ $category->count_products }})</span></a></li>
							@endif
						@endforeach
					</ul>
				</div>
				<div class="sidebar-filter mt-50">
					<div class="top-filter-head">Product Filters</div>
					<div class="common-filter">
						<div class="head">Brands</div>
						<form action="#">
							<ul>
								<li class="filter-list"><input class="pixel-radio" type="radio" id="apple" name="brand"><label for="apple">Apple<span>(29)</span></label></li>
								<li class="filter-list"><input class="pixel-radio" type="radio" id="asus" name="brand"><label for="asus">Asus<span>(29)</span></label></li>
								<li class="filter-list"><input class="pixel-radio" type="radio" id="gionee" name="brand"><label for="gionee">Gionee<span>(19)</span></label></li>
								<li class="filter-list"><input class="pixel-radio" type="radio" id="micromax" name="brand"><label for="micromax">Micromax<span>(19)</span></label></li>
								<li class="filter-list"><input class="pixel-radio" type="radio" id="samsung" name="brand"><label for="samsung">Samsung<span>(19)</span></label></li>
							</ul>
						</form>
					</div>
					<div class="common-filter">
						<div class="head">Color</div>
						<form action="#">
							<ul>
								<li class="filter-list"><input class="pixel-radio" type="radio" id="black" name="color"><label for="black">Black<span>(29)</span></label></li>
								<li class="filter-list"><input class="pixel-radio" type="radio" id="balckleather" name="color"><label for="balckleather">Black
										Leather<span>(29)</span></label></li>
								<li class="filter-list"><input class="pixel-radio" type="radio" id="blackred" name="color"><label for="blackred">Black
										with red<span>(19)</span></label></li>
								<li class="filter-list"><input class="pixel-radio" type="radio" id="gold" name="color"><label for="gold">Gold<span>(19)</span></label></li>
								<li class="filter-list"><input class="pixel-radio" type="radio" id="spacegrey" name="color"><label for="spacegrey">Spacegrey<span>(19)</span></label></li>
							</ul>
						</form>
					</div>
					<div class="common-filter">
						<div class="head">Price</div>
						<div class="price-range-area">
							<div id="price-range"></div>
							<div class="value-wrapper d-flex">
								<div class="price">Price:</div>
								<span>$</span>
								<div id="lower-value"></div>
								<div class="to">to</div>
								<span>$</span>
								<div id="upper-value"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-9 col-lg-8 col-md-7">
				<!-- Start Filter Bar -->
					@include('client.components.pagination', ['element' => $products])
				<!-- End Filter Bar -->
				<!-- Start Best Seller -->
				<section class="lattest-product-area pb-40 category-list">
					<div class="row">
						<!-- single product -->
						@foreach ($products as $product)
						<div class="col-lg-3 col-md-6">
							<div class="single-product">
								<img class="img-fluid" src="{{ asset($product->image) }}" alt="">
								<div class="product-details">
										<h6>{{$product->name}} ({{$product->code}})</h6>
									<div class="price">
										<h6>{{number_format($product->price - $product->reduction, 0)}} FCFA</h6>
										@if ($product->reduction > 0)
											<h6 class="l-through">{{number_format($product->price, 0)}} FCFA</h6>
										@endif
									</div>
									<div class="prd-bottom">

										<a href="" class="social-info">
											<span class="ti-bag"></span>
											<p class="hover-text">Ajouter au panier</p>
										</a>
										{{-- <a href="" class="social-info">
											<span class="lnr lnr-heart"></span>
											<p class="hover-text">Liste de souhaits</p>
										</a>
										<a href="" class="social-info">
											<span class="lnr lnr-sync"></span>
											<p class="hover-text">Comparer</p>
										</a> --}}
										<a href="" class="social-info">
											<span class="lnr lnr-move"></span>
											<p class="hover-text">Voir plus</p>
										</a>
									</div>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</section>
				<!-- End Best Seller -->
				<!-- Start Filter Bar -->
					@include('client.components.pagination', ['element' => $products])
				<!-- End Filter Bar -->
			</div>
		</div>
	</div>

	<div class="mt-3 pt-3"></div>
	<!-- Start related-product Area -->
	@include('client.components.related_products', ['lastPromoProducts' => $lastPromoProducts])
	<!-- End related-product Area -->


@endsection

@section('modals')

	<!-- Modal Quick Product View -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="container relative">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="product-quick-view">
					<div class="row align-items-center">
						<div class="col-lg-6">
							<div class="quick-view-carousel">
								<div class="item" style="background: url(img/organic-food/q1.jpg);">

								</div>
								<div class="item" style="background: url(img/organic-food/q1.jpg);">

								</div>
								<div class="item" style="background: url(img/organic-food/q1.jpg);">

								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="quick-view-content">
								<div class="top">
									<h3 class="head">Mill Oil 1000W Heater, White</h3>
									<div class="price d-flex align-items-center"><span class="lnr lnr-tag"></span> <span class="ml-10">$149.99</span></div>
									<div class="category">Category: <span>Household</span></div>
									<div class="available">Availibility: <span>In Stock</span></div>
								</div>
								<div class="middle">
									<p class="content">Mill Oil is an innovative oil filled radiator with the most modern technology. If you are
										looking for something that can make your interior look awesome, and at the same time give you the pleasant
										warm feeling during the winter.</p>
									<a href="#" class="view-full">View full Details <span class="lnr lnr-arrow-right"></span></a>
								</div>
								<div class="bottom">
									<div class="color-picker d-flex align-items-center">Color:
										<span class="single-pick"></span>
										<span class="single-pick"></span>
										<span class="single-pick"></span>
										<span class="single-pick"></span>
										<span class="single-pick"></span>
									</div>
									<div class="quantity-container d-flex align-items-center mt-15">
										Quantity:
										<input type="text" class="quantity-amount ml-15" value="1" />
										<div class="arrow-btn d-inline-flex flex-column">
											<button class="increase arrow" type="button" title="Increase Quantity"><span class="lnr lnr-chevron-up"></span></button>
											<button class="decrease arrow" type="button" title="Decrease Quantity"><span class="lnr lnr-chevron-down"></span></button>
										</div>

									</div>
									<div class="d-flex mt-20">
										<a href="#" class="view-btn color-2"><span>Add to Cart</span></a>
										<a href="#" class="like-btn"><span class="lnr lnr-layers"></span></a>
										<a href="#" class="like-btn"><span class="lnr lnr-heart"></span></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection