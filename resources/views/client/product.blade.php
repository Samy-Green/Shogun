@extends('client/layouts/layoutMaster')
@section('title', 'Détails du produit')

@section('page-styles')
    @vite([
        'resources/assets/client/css/linearicons.css',
        'resources/assets/client/css/font-awesome.min.css',
        'resources/assets/client/css/themify-icons.css',
        'resources/assets/client/css/bootstrap.css',
        'resources/assets/client/css/owl.carousel.css',
        'resources/assets/client/css/nice-select.css',
        'resources/assets/client/css/nouislider.min.css',
        'resources/assets/client/css/ion.rangeSlider.css',
        'resources/assets/client/css/ion.rangeSlider.skinFlat.css',
        'resources/assets/client/css/main.css',
    ])
@endsection

@section('page-scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-link');
    const tabPanes = document.querySelectorAll('.tab-pane');

    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault(); // Empêche le rechargement de la page

            // Retirer active de tous les liens
            navLinks.forEach(l => l.classList.remove('active'));

            // Retirer show/active de tous les tab-panes
            tabPanes.forEach(pane => {
                pane.classList.remove('show', 'active');
            });

            // Ajouter active au lien cliqué
            this.classList.add('active');

            // Récupérer l'id du pane correspondant
            const targetId = this.getAttribute('href').substring(1);
            const targetPane = document.getElementById(targetId);

            // Ajouter show/active au pane correspondant
            if (targetPane) {
                targetPane.classList.add('show', 'active');
            }
        });
    });
});
</script>

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

    <!-- Scripts externes (non gérés par Vite) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
            integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
            crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
@endsection

@section('page-content')

<style>
	.s_product_text .price h6 {
		font-size: 16px;
		display: inline-block;
		padding-right: 15px;
		margin: 0;
	}
	.s_product_text .price .l-through {
		text-decoration: line-through;
		color: #cccccc;
		margin-bottom: 0;
	}

	/* Conteneur principal de la description */
.product-long-description {
    font-family: 'Helvetica Neue', Arial, sans-serif;
    color: #333;
    line-height: 1.6;
    font-size: 15px;
    margin: 20px 0;
}

/* Titres */
.product-long-description h1,
.product-long-description h2,
.product-long-description h3,
.product-long-description h4,
.product-long-description h5,
.product-long-description h6 {
    color: #222;
    margin-top: 20px;
    margin-bottom: 10px;
    font-weight: 600;
}

.product-long-description h1 { font-size: 26px; }
.product-long-description h2 { font-size: 22px; }
.product-long-description h3 { font-size: 18px; }
.product-long-description h4 { font-size: 16px; }
.product-long-description h5 { font-size: 15px; }
.product-long-description h6 { font-size: 14px; }

/* Paragraphes */
.product-long-description p {
    margin-bottom: 12px;
    line-height: 1.6;
    color: #444;
}

/* Listes */
.product-long-description ul,
.product-long-description ol {
    padding-left: 20px;
    margin-bottom: 15px;
}

.product-long-description ul li,
.product-long-description ol li {
    margin-bottom: 6px;
}

/* Gras, italique, souligné */
.product-long-description strong { font-weight: 600; }
.product-long-description em { font-style: italic; }
.product-long-description u { text-decoration: underline; }

/* Tableaux */
.product-long-description table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
}

.product-long-description th,
.product-long-description td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
    vertical-align: top;
}

.product-long-description th {
    background-color: #f8f8f8;
    font-weight: 600;
}

/* Images */
.product-long-description img {
    max-width: 100%;
    height: auto;
    display: block;
    margin: 10px 0;
    border-radius: 4px;
}

/* Liens */
.product-long-description a {
    color: #007bff;
    text-decoration: none;
}

.product-long-description a:hover {
    text-decoration: underline;
}

/* Citations / blockquote */
.product-long-description blockquote {
    border-left: 4px solid #ddd;
    padding-left: 12px;
    color: #666;
    margin: 10px 0;
    font-style: italic;
}

/* Code / préformaté */
.product-long-description pre,
.product-long-description code {
    background-color: #f5f5f5;
    padding: 4px 8px;
    border-radius: 4px;
    font-family: monospace;
}

</style>


	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Détails de produit</h1>
					<nav class="d-flex align-items-center">
						<a href="{{ route('site.index') }}">Accueil<span class="lnr lnr-arrow-right"></span></a>
						<a href="{{ route('site.categories') }}">Boutique<span class="lnr lnr-arrow-right"></span></a>
						<a href="{{ route('site.product', $product->id) }}">Détails du produit</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<!--================Single Product Area =================-->
	<div class="product_image_area">
		<div class="container">
			<div class="row s_product_inner">
				<div class="col-lg-6">
					<div class="s_Product_carousel">
						<div class="single-prd-item">
							<img class="img-fluid" src="{{ asset($product->image) }}" alt="">
						</div>
						@foreach ($product->files as $file)
							<div class="single-prd-item">
								<img class="img-fluid" src="{{  asset($file->path) }}" alt="">
							</div>
						@endforeach
					</div>
				</div>
				<div class="col-lg-5 offset-lg-1">
					<div class="s_product_text">
						<h3>{{ $product->name }} ({{ $product->code }})</h3>
						<div class="price mt-2">
							<h6>{{number_format($product->price - $product->reduction, 0)}} FCFA</h6>
							@if ($product->reduction > 0)
								<h6 class="l-through">{{number_format($product->price, 0)}} FCFA</h6>
							@endif
						</div>
						<ul class="list mt-2">
							<li><a class="active" href="#"><span>Catégorie</span> : {{ $product->mainCategory->name }}</a></li>
							<li><a href="#"><span>Disponibilité</span> : {{ $product->quantity ? 'En stock' : ($product->available ? 'Sur commande' : 'non disponible') }}</a></li>
						</ul>
						<p>{{$product->description}}</p>
						<div class="product_count">
							<label for="qty">Quantité :</label>
							<input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
							<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
							 class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
							<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
							 class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
						</div>
						<div class="card_area d-flex align-items-center">
							<a class="primary-btn" href="#">Ajouter au panier</a>
							{{-- <a class="icon_btn" href="#"><i class="lnr lnr lnr-diamond"></i></a>
							<a class="icon_btn" href="#"><i class="lnr lnr lnr-heart"></i></a> --}}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--================End Single Product Area =================-->

	<!--================Product Description Area =================-->
	<section class="product_description_area">
		<div class="container">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Description</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
					 aria-selected="false">Specifications</a>
				</li>
				{{-- <li class="nav-item">
					<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact"
					 aria-selected="false">Comments</a>
				</li> --}}
				{{-- <li class="nav-item">
					<a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review"
					 aria-selected="false">Reviews</a>
				</li> --}}
			</ul>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
						<div class="product-long-descriptio">
    					{!! $product->long_description !!}						
						</div>
				</div>
				<div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
					<div class="table-responsive">
						<table class="table">
							<tbody>
									@if($product->luxury !== null)
									<tr>
											<td><h5>Luxe</h5></td>
											<td><h5>{{ $product->luxury ? 'Oui' : 'Non' }}</h5></td>
									</tr>
									@endif

									@if($product->weight)
									<tr>
											<td><h5>Contenance</h5></td>
											<td><h5>{{ $product->weight }} ml</h5></td>
									</tr>
									@endif

									@if($product->price)
									<tr>
											<td><h5>Prix</h5></td>
											<td><h5>{{ number_format($product->price, 0, ',', ' ') }} FCFA</h5></td>
									</tr>
									@endif

									@if($product->quantity !== null)
									<tr>
											<td><h5>Quantité disponible</h5></td>
											<td><h5>{{ $product->quantity }}</h5></td>
									</tr>
									@endif

									@if($product->discount)
									<tr>
											<td><h5>Remise</h5></td>
											<td><h5>{{ $product->discount }} FCFA</h5></td>
									</tr>
									@endif

									<tr>
											<td><h5>Contrôle qualité</h5></td>
											<td><h5>Oui</h5></td>
									</tr>
							</tbody>
						</table>
					</div>
				</div>
				{{-- <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
					<div class="row">
						<div class="col-lg-6">
							<div class="comment_list">
								<div class="review_item">
									<div class="media">
										<div class="d-flex">
											<img src="img/product/review-1.png" alt="">
										</div>
										<div class="media-body">
											<h4>Blake Ruiz</h4>
											<h5>12th Feb, 2018 at 05:56 pm</h5>
											<a class="reply_btn" href="#">Reply</a>
										</div>
									</div>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
										dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
										commodo</p>
								</div>
								<div class="review_item reply">
									<div class="media">
										<div class="d-flex">
											<img src="img/product/review-2.png" alt="">
										</div>
										<div class="media-body">
											<h4>Blake Ruiz</h4>
											<h5>12th Feb, 2018 at 05:56 pm</h5>
											<a class="reply_btn" href="#">Reply</a>
										</div>
									</div>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
										dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
										commodo</p>
								</div>
								<div class="review_item">
									<div class="media">
										<div class="d-flex">
											<img src="img/product/review-3.png" alt="">
										</div>
										<div class="media-body">
											<h4>Blake Ruiz</h4>
											<h5>12th Feb, 2018 at 05:56 pm</h5>
											<a class="reply_btn" href="#">Reply</a>
										</div>
									</div>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
										dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
										commodo</p>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="review_box">
								<h4>Post a comment</h4>
								<form class="row contact_form" action="contact_process.php" method="post" id="contactForm" novalidate="novalidate">
									<div class="col-md-12">
										<div class="form-group">
											<input type="text" class="form-control" id="name" name="name" placeholder="Your Full name">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<input type="text" class="form-control" id="number" name="number" placeholder="Phone Number">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<textarea class="form-control" name="message" id="message" rows="1" placeholder="Message"></textarea>
										</div>
									</div>
									<div class="col-md-12 text-right">
										<button type="submit" value="submit" class="btn primary-btn">Submit Now</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div> --}}
				{{-- <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
					<div class="row">
						<div class="col-lg-6">
							<div class="row total_rate">
								<div class="col-6">
									<div class="box_total">
										<h5>Overall</h5>
										<h4>4.0</h4>
										<h6>(03 Reviews)</h6>
									</div>
								</div>
								<div class="col-6">
									<div class="rating_list">
										<h3>Based on 3 Reviews</h3>
										<ul class="list">
											<li><a href="#">5 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
													 class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
											<li><a href="#">4 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
													 class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
											<li><a href="#">3 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
													 class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
											<li><a href="#">2 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
													 class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
											<li><a href="#">1 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
													 class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="review_list">
								<div class="review_item">
									<div class="media">
										<div class="d-flex">
											<img src="img/product/review-1.png" alt="">
										</div>
										<div class="media-body">
											<h4>Blake Ruiz</h4>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
										</div>
									</div>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
										dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
										commodo</p>
								</div>
								<div class="review_item">
									<div class="media">
										<div class="d-flex">
											<img src="img/product/review-2.png" alt="">
										</div>
										<div class="media-body">
											<h4>Blake Ruiz</h4>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
										</div>
									</div>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
										dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
										commodo</p>
								</div>
								<div class="review_item">
									<div class="media">
										<div class="d-flex">
											<img src="img/product/review-3.png" alt="">
										</div>
										<div class="media-body">
											<h4>Blake Ruiz</h4>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
										</div>
									</div>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
										dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
										commodo</p>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="review_box">
								<h4>Add a Review</h4>
								<p>Your Rating:</p>
								<ul class="list">
									<li><a href="#"><i class="fa fa-star"></i></a></li>
									<li><a href="#"><i class="fa fa-star"></i></a></li>
									<li><a href="#"><i class="fa fa-star"></i></a></li>
									<li><a href="#"><i class="fa fa-star"></i></a></li>
									<li><a href="#"><i class="fa fa-star"></i></a></li>
								</ul>
								<p>Outstanding</p>
								<form class="row contact_form" action="contact_process.php" method="post" id="contactForm" novalidate="novalidate">
									<div class="col-md-12">
										<div class="form-group">
											<input type="text" class="form-control" id="name" name="name" placeholder="Your Full name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your Full name'">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<input type="email" class="form-control" id="email" name="email" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<input type="text" class="form-control" id="number" name="number" placeholder="Phone Number" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Phone Number'">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<textarea class="form-control" name="message" id="message" rows="1" placeholder="Review" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Review'"></textarea></textarea>
										</div>
									</div>
									<div class="col-md-12 text-right">
										<button type="submit" value="submit" class="primary-btn">Submit Now</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div> --}}
			</div>
		</div>
	</section>
	<!--================End Product Description Area =================-->

	<!-- Start related-product Area -->
	@include('client.components.related_products', ['lastPromoProducts' => $lastPromoProducts])
	<!-- End related-product Area -->
	
@endsection
