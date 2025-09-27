	<section class="related-product-area section_gap_bottom">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-6 text-center">
					<h2 class="text-center mb-4">Offres de la semaine</h2>
					<p class="text-muted text-center">
						Découvrez nos promotions exclusives sur une sélection de parfums raffinés.  
						Profitez dès maintenant de réductions spéciales et laissez-vous séduire par des fragrances uniques.
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-9">
					<div class="row">
						@foreach ($lastPromoProducts as $product)	
						<div class="col-lg-4 col-md-4 col-sm-6 mb-20">
							<div class="single-related-product d-flex">
								<a href="#"><img class="img-fluid" style="max-width:60px " src="{{ asset($product->image) }}" alt=""></a>
								<div class="desc">
									<a href="#" class="title" style="">{{$product->name}} ({{$product->code}})</a>
									<div class="price">
										<h6>{{ number_format($product->price - $product->reduction) }} FCFA</h6>
										<h6 class="l-through">{{ number_format($product->price) }} FCFA</h6>
									</div>
								</div>
							</div>
						</div>				
						@endforeach
					</div>
				</div>
				<div class="col-lg-3">
					<div class="ctg-right">
						<a href="#" target="_blank">
							<img class="img-fluid d-block mx-auto" src="{{ asset('client/img/promo/default.jpg') }}" alt="">
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>