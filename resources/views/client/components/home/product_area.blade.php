	<section class="owl-carousel active-product-area section_gap">
		<!-- single product slide -->
		<div class="single-product-slider">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-6 text-center">
						<div class="section-title">
								<h1>Derniers Produits</h1>
								<p>Découvrez nos nouveautés et les produits les plus récents de notre collection, soigneusement sélectionnés pour vous offrir qualité et style.</p>
						</div>
					</div>
				</div>
				@if ($lastProducts->isEmpty())
					<div class="col-12">
						<p class="text-center">Aucun produit à venir pour le moment. Restez à l'écoute pour nos prochaines nouveautés!</p>
					</div>
				@else
				<div class="row">
					<!-- single product -->
					@foreach ($lastProducts as $product)
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
				@endif
			</div>
		</div>
		<!-- single product slide -->
		<div class="single-product-slider">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-6 text-center">
					<div class="section-title">
							<h1>Produits à Venir</h1>
							<p>Nos nouveaux parfums seront bientôt en stock. Préparez-vous à découvrir des fragrances uniques et irrésistibles.</p>
					</div>
					</div>
				</div>
				@if ($comingProducts->isEmpty())
					<div class="col-12">
						<p class="text-center">Aucun produit à venir pour le moment. Restez à l'écoute pour nos prochaines nouveautés!</p>
					</div>
				@else
				<div class="row">
					<!-- single product -->
					@foreach ($comingProducts as $product)
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
				@endif
			</div>
		</div>
	</section>