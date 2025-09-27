	<section class="banner-area">
		<div class="container">
			<div class="row fullscreen align-items-center justify-content-start">
				<div class="col-lg-12">
					<div class="active-banner-slider owl-carousel">
						<!-- single-slide -->
						@foreach ($carousels as $carousel)
							<div class="row single-slide align-items-center d-flex">
								<div class="col-lg-5 col-md-6">
									<div class="banner-content">
										<h1>{{ $carousel->title }}</h1>
										<p>{{ $carousel->description }}</p>
										<div class="add-bag d-flex align-items-center">
											<a class="add-btn" href=""><span class="{{ $carousel->button_icon }}"></span></a>
											<span class="add-text text-uppercase">Add to Bag</span>
										</div>
									</div>
								</div>
								<div class="col-lg-7">
									<div class="banner-img">
										<img class="img-fluid" src="{{ asset($carousel->image) }}" alt="">
									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</section>