
@extends('client/layouts/layoutMaster')

@section('title', 'Panier')

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
        document.getElementById('citySearch').addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const items = document.querySelectorAll('#cityList .city-dropdown-item');
            
            // alert(items[0]);
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(filter) ? 'block' : 'none';
            });
        });

        document.querySelector('#citySearch').addEventListener("blur", function() {
            const checkedRadio = document.querySelector('input[name="city"]:checked');
            if (checkedRadio) {
                this.value = checkedRadio.parentElement.textContent.trim(); // affiche le nom dans l’input
            }
        });


        document.querySelectorAll('.city-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                const city = JSON.parse(this.getAttribute('data-city'));
                document.getElementById('citySearch').value = city.name;
                const neighborhoodSelect = document.querySelector('.neighborhood-dropdown');
                document.querySelectorAll('.exp-li').forEach(li => li.classList.remove('active'));
                document.querySelector('#neighborhoodSearch').value = '';
                if (city.delivery !== 'home') {
                    neighborhoodSelect.style.display = 'none';
                    document.querySelector('#expedition_delivery').classList.add('active');
                    document.getElementById('no_delivery').checked = false;
                    document.querySelector('#expedition_delivery span').innerText = city.cost + ' FCFA';
                    return;
                } else {
                    const neighborhoods = JSON.parse(this.getAttribute('data-neighborhoods'));
                    console.log('neighborhoods');
                    
                    if (!neighborhoods || neighborhoods.length === 0) {
                        neighborhoodSelect.style.display = 'none';
                        return;
                    };
                    
                    const neighborhoodList = document.getElementById('neighborhoodList');                
                    // Clear existing options
                    neighborhoodList.innerHTML = '';

                    // Populate new options
                    neighborhoods.forEach(neighborhood => {
                        const option = `<label class="neighborhood-dropdown-item">
                            <input type="radio" class="neighborhood-radio" form="cart-form" name="neighborhood" value="${ neighborhood.id }" data-neighborhood='${ JSON.stringify(neighborhood) }'>
                            ${ neighborhood.name }
                            </label> `;
                            neighborhoodList.innerHTML += option;
                        });
                    neighborhoodSelect.style.display = 'block';


                    document.querySelectorAll('.neighborhood-radio').forEach(radio => {
                        radio.addEventListener('change', function() {
                            document.querySelectorAll('.exp-li').forEach(li => li.classList.remove('active'));
                            document.querySelector('#local_delivery').classList.add('active');
                            document.getElementById('no_delivery').checked = false;
                            document.querySelector('#local_delivery span').innerText = city.cost + ' FCFA';
                            const neighborhood = JSON.parse(this.getAttribute('data-neighborhood'));
                            document.getElementById('neighborhoodSearch').value = neighborhood.name;
                        });
                    });
                }
            });
        });

        document.querySelector('#neighborhoodSearch').addEventListener("blur", function() {
            const checkedRadio = document.querySelector('input[name="neighborhood"]:checked');
            if (checkedRadio) {
                this.value = checkedRadio.parentElement.textContent.trim(); // affiche le nom dans l’input
            }
        });

        document.getElementById('no_delivery').addEventListener('change', function() {
            if (this.checked) {
                document.querySelectorAll('.exp-li').forEach(li => li.classList.remove('active'));
                document.querySelector('#on_site_delivery').classList.add('active');
                document.querySelector('#citySearch').value = '';
                document.querySelector('#neighborhoodSearch').value = '';
                document.querySelector('.neighborhood-dropdown').style.display = 'none';

                document.querySelector('input[name="city"]:checked').checked = false;
            }
            else{
                document.querySelector('#on_site_delivery').classList.remove('active');
            }
        });

    </script>

@endsection

@section('page-content')

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Contact Us</h1>
					<nav class="d-flex align-items-center">
						<a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="category.html">Contact</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<!--================Contact Area =================-->
	<section class="contact_area section_gap_bottom">
		<div class="container">
			<div id="mapBox" class="mapBox" data-lat="40.701083" data-lon="-74.1522848" data-zoom="13" data-info="PO Box CT16122 Collins Street West, Victoria 8007, Australia."
			 data-mlat="40.701083" data-mlon="-74.1522848">
			</div>
			<div class="row">
				<div class="col-lg-3">
					<div class="contact_info">
						<div class="info_item">
							<i class="lnr lnr-home"></i>
							<h6>California, United States</h6>
							<p>Santa monica bullevard</p>
						</div>
						<div class="info_item">
							<i class="lnr lnr-phone-handset"></i>
							<h6><a href="#">00 (440) 9865 562</a></h6>
							<p>Mon to Fri 9am to 6 pm</p>
						</div>
						<div class="info_item">
							<i class="lnr lnr-envelope"></i>
							<h6><a href="#">support@colorlib.com</a></h6>
							<p>Send us your query anytime!</p>
						</div>
					</div>
				</div>
				<div class="col-lg-9">
					<form class="row contact_form" action="contact_process.php" method="post" id="contactForm" novalidate="novalidate">
						<div class="col-md-6">
							<div class="form-group">
								<input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'">
							</div>
							<div class="form-group">
								<input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'">
							</div>
							<div class="form-group">
								<input type="text" class="form-control" id="subject" name="subject" placeholder="Enter Subject" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Subject'">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<textarea class="form-control" name="message" id="message" rows="1" placeholder="Enter Message" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Message'"></textarea>
							</div>
						</div>
						<div class="col-md-12 text-right">
							<button type="submit" value="submit" class="primary-btn">Send Message</button>
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
@endsection