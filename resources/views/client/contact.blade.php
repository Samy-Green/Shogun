
@extends('client/layouts/layoutMaster')

@section('title', 'Contactez nous')

@section('page-styles')
    		<!-- Place your custom styles here -->
	@vite([
        'resources/assets/client/css/linearicons.css',
        'resources/assets/client/css/font-awesome.min.css',
        'resources/assets/client/css/themify-icons.css',
        'resources/assets/client/css/owl.carousel.css',
        'resources/assets/client/css/nice-select.css',
        'resources/assets/client/css/nouislider.min.css',
		'resources/assets/client/css/bootstrap.css',
        'resources/assets/client/css/main.css',
    ])
@endsection

@section("page-scripts")
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
			//'resources/assets/client/js/gmaps.min.js',
			'resources/assets/client/js/main.js',
	])

	{{-- External scripts (non compilés avec Vite) --}}
	{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
			integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
			crossorigin="anonymous"></script>

	<!-- Google Maps API -->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script> --}}

@endsection

@section('page-content')

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="flex-wrap breadcrumb-banner d-flex align-items-center justify-content-end">
				<div class="col-first">
					<h1>Contactez Nous</h1>
					<nav class="d-flex align-items-center">
						<a href="{{ route("site.index") }}">Accueil<span class="lnr lnr-arrow-right"></span></a>
						<a href="#">Contact</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<!--================Contact Area =================-->
	<section class="mt-5 contact_area section_gap_bottom">
		<div class="container mt-5">
			{{-- <div id="mapBox" class="mapBox" data-lat="40.701083" data-lon="-74.1522848" data-zoom="13" data-info="PO Box CT16122 Collins Street West, Victoria 8007, Australia."
			 data-mlat="40.701083" data-mlon="-74.1522848">
			</div> --}}
			<div class="row">
				<div class="col-lg-3">
					<div class="contact_info">
						<div class="info_item">
							<i class="lnr lnr-home"></i>
							<h6>Yaoundé, Cameroun</h6>
							<p>Maetur Nkom - Barrière des pluies</p>
						</div>
						<div class="info_item">
							<i class="lnr lnr-phone-handset"></i>
							<h6><a href="#">(237) 677 924 952</a></h6>
							<p>Disponible 24/7</p>
						</div>
						<div class="info_item">
							<i class="lnr lnr-envelope"></i>
							<h6><a href="#">shogun4952@outlook.com</a></h6>
							<p>Envoyez votre requête n'importe quand!</p>
						</div>
					</div>
				</div>
				<div class="col-lg-9">
				<form class="row contact_form" action="{{ route('site.mail.post') }}" method="post" id="contactForm">
						@csrf
						<div class="col-md-6">
								<div class="form-group">
										<input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
													placeholder="Entrez votre Nom" 
													onfocus="this.placeholder = ''" 
													onblur="this.placeholder = 'Entrez votre Nom'"
													value="{{ old('name') }}" 
													required>
										@error('name')
												<div class="invalid-feedback">
														{{ $message }}
												</div>
										@enderror
								</div>
								<div class="form-group">
										<input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
													placeholder="Entrez votre adresse email" 
													onfocus="this.placeholder = ''" 
													onblur="this.placeholder = 'Entrez votre adresse email'"
													value="{{ old('email') }}" 
													required>
										@error('email')
												<div class="invalid-feedback">
														{{ $message }}
												</div>
										@enderror
								</div>
								<div class="form-group">
										<input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" 
													placeholder="Entrez le sujet" 
													onfocus="this.placeholder = ''" 
													onblur="this.placeholder = 'Entrez le sujet'"
													value="{{ old('subject') }}" 
													required>
										@error('subject')
												<div class="invalid-feedback">
														{{ $message }}
												</div>
										@enderror
								</div>
						</div>
						<div class="col-md-6">
								<div class="form-group">
										<textarea class="form-control @error('message') is-invalid @enderror" name="message" id="message" rows="1" 
															placeholder="Entrez votre message" 
															onfocus="this.placeholder = ''" 
															onblur="this.placeholder = 'Entrez votre message'"
															required>{{ old('message') }}</textarea>
										@error('message')
												<div class="invalid-feedback">
														{{ $message }}
												</div>
										@enderror
								</div>
						</div>
						<div class="text-right col-md-12">
								<button type="submit" value="submit" class="primary-btn">Envoyer votre Message</button>
						</div>
				</form>
				</div>
			</div>
		</div>
	</section>
	<!--================Contact Area =================-->

@endsection

@section('modals')
	<!--================Contact Success and Error message Area =================-->
	<div id="success" class="modal modal-message fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i class="fa fa-close"></i>
					</button>
					<h2>Thank you</h2>
					<p>Your message is successfully sent...</p>
				</div>
			</div>
		</div>
	</div>

	<!-- Modals error -->

	<div id="error" class="modal modal-message fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i class="fa fa-close"></i>
					</button>
					<h2>Sorry !</h2>
					<p> Something went wrong </p>
				</div>
			</div>
		</div>
	</div>
	<!--================End Contact Success and Error message Area =================-->

	<script>
		document.addEventListener('DOMContentLoaded', function() {
				// Vérifier les sessions et afficher les modals
				@if(session('success'))
						var successModal = new bootstrap.Modal(document.getElementById('success'));
						successModal.show();
						
						// Auto-fermeture après 5 secondes
						setTimeout(function() {
								successModal.hide();
						}, 5000);
				@endif

				@if(session('error'))
						var errorModal = new bootstrap.Modal(document.getElementById('error'));
						errorModal.show();
						
						// Auto-fermeture après 5 secondes
						setTimeout(function() {
								errorModal.hide();
						}, 5000);
				@endif
		});
	</script>
@endsection