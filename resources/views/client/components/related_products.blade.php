@if (count($lastPromoProducts))
	<section class="related-product-area section_gap_bottom">
		<div class="container">
			<div class="row justify-content-center">
				<div class="text-center col-lg-6">
					<h2 class="mb-4 text-center">Offres de la semaine</h2>
					<p class="text-center text-muted">
						Découvrez nos promotions exclusives sur une sélection de parfums raffinés.  
						Profitez dès maintenant de réductions spéciales et laissez-vous séduire par des fragrances uniques.
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-9">
					<div class="row">
						@foreach ($lastPromoProducts as $product)	
						<div class="mb-20 col-lg-4 col-md-4 col-sm-6">
							<div class="single-related-product d-flex">
								<a href="{{ route('site.product', ["product_id" => $product->id]) }}"><img class="img-fluid" style="max-width:60px " src="{{ asset($product->image) }}" alt=""></a>
								<div class="desc">
									<a href="{{ route('site.product', ["product_id" => $product->id]) }}" class="title" style="">{{$product->name}} ({{$product->code}})</a>
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
						<a href="javascript:void(0);">
							<img class="mx-auto img-fluid d-block" src="{{ asset('client/img/promo/default.png') }}" alt="">
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>
@endif