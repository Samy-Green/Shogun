
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
			//'resources/assets/client/js/gmaps.min.js',
			'resources/assets/client/js/main.js',
	])

	{{-- External scripts (non compilés avec Vite) --}}
	{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
			integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
			crossorigin="anonymous"></script>

	<!-- Google Maps API -->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script> --}}

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
<style>
    .city-dropdown, .neighborhood-dropdown {
        position: relative;
        max-height: 300px;
    }
    
    
    .city-dropdown-list, .neighborhood-dropdown-list {
        border: 1px solid #ccc;
        max-height: 200px;
        overflow-y: auto;
        display: none;
        background-color: #fff;
        text-align: left;
        justify-content: start;
    }

    .city-dropdown:hover .city-dropdown-list, .neighborhood-dropdown:hover .neighborhood-dropdown-list {
        display: block;
        z-index: 1;
        position: absolute;
        top: 100%;
        width: 100%;
    }

    .city-dropdown:hover .city-dropdown-list, .city-dropdown-input:focus + .city-dropdown-list,
    .neighborhood-dropdown:hover .neighborhood-dropdown-list, .neighborhood-dropdown-input:focus + .neighborhood-dropdown-list {
        display: block;
        z-index: 1000;
        position: absolute;
        top: 100%;
        width: 100%;
    }

    .city-dropdown-item,.neighborhood-dropdown-item {
        display: block;
        padding: 5px;
        cursor: pointer;
    }


    .city-dropdown-item:hover, .neighborhood-dropdown-item:hover {
        background-color: #f0f0f0;
    }

    .city-radio,.neighborhood-radio {
        margin-left: 20px; 
        margin-right: 10px;
        max-width: 20px;
    }

    .shipping_box input[type="checkbox"] {
        margin-left: 20px; 
        margin-right: 10px;
        max-width: 15px;
        margin-bottom: 0;

    }

    .no_delivery_box {
        vertical-align: middle;
        padding: 0;
        cursor: pointer;
    }
    .no_delivery_box input[type="checkbox"] {
        vertical-align: middle;
        padding: 0;
        cursor: pointer;
    }

    .city-dropdown-item *, .neighborhood-dropdown-item * {
        vertical-align: middle;
        padding: 0;
    }

    .cart_inner .table tbody tr.shipping_area .shipping_box input[type="radio"], .cart_inner .table tbody tr.shipping_area .shipping_box input[type="checkbox"]{
        margin-bottom: 0;
    }

    .btn{
        outline: none;
    }

    /* .cupon_text{
        margin-left: 0;
    } */

</style>
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="flex-wrap breadcrumb-banner d-flex align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Pannier</h1>
                    <nav class="d-flex align-items-center">
                        <a href="{{ route('site.index') }}">Accueil<span class="lnr lnr-arrow-right"></span></a>
                        <a href="{{ route('site.cart') }}">Pannier</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--==========Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Produit</th>
                                <th scope="col">Prix</th>
                                <th scope="col">Quantité</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        @php
                            $sumTotal = 0;
                        @endphp
                        <tbody>
                            @foreach ($products as $product)
                            @php
                                $productPrice = $product["price"];
                                
                                $promoDiscount = 0;
                                if ($promoCode) {
                                    $promoDiscount =  $promoCode->discount >1 ? $promoCode->discount : $promoCode->discount * $productPrice;
                                }

                                $miTotal = ($productPrice - $promoDiscount) * $product["quantity"];
                                $sumTotal += $miTotal;
                            @endphp
                            <tr>
                                <td>
                                    <div class="media">
                                        <div class="d-flex">
                                            <img style="max-width: 60px" src="{{ asset($product["image"]) }}" alt="">
                                        </div>
                                        <div class="media-body">
                                            <span style="color: black">{{ $product["name"] }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span style="color: black">{{ $productPrice }} FCFA</span>
                                    <span>{{ $promoDiscount ? 'Réduction : (- ' . $promoDiscount . ')' : '' }}</span> 
                                </td>
                                <td>
                                    <div class="product_count">
                                        <input type="text" form="cart-form" name="products[{{ $product["id"] }}]" id="sst{{ $product["id"] }}" maxlength="12" value="{{ $product["quantity"] }}" title="Quantité"
                                        class="input-text qty">
                                        <button onclick="var result = document.getElementById('sst{{ $product['id'] }}'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                                        class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                                        <button onclick="var result = document.getElementById('sst{{ $product['id'] }}'); var sst = result.value; if( !isNaN( sst ) && sst > 0 ) result.value--;return false;"
                                            class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
                                        </div>
                                    </td>
                                    <td>
                                        <h5>{{ number_format($miTotal, 0, ",", ".") }} FCFA</h5>
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="bottom_button">
                                <td colspan="4">
                                    <div class="flex-wrap d-flex justify-content-between">
                                        <button form="cart-form" name="maj" value="maj" type="submit" class="mt-2 btn gray_btn">Mettre à jour le panier</button>
                                    {{-- </td>
                                    <td></td>
                                    <td></td>
                                    <td> --}}
                                        <div class="flex-wrap cupon_text d-flex align-items-center">
                                            <input class="mt-2 " type="text" form="cart-form" placeholder="Code promo" id="promo_code" name="promo_code" value="{{ old('promo_code', request('promo_code', '')) }}">
                                            <button class="mt-2 btn primary-btn" form="cart-form" name="send_code" value="send_code" type="submit">Appliquer</button>
                                            <button class="mt-2 btn gray_btn" onclick="document.getElementById('promo_code').value='';">ANNULER</button>
                                        </div>
                                    </div>                                
                                    @error("promo_code")
                                        <div class="" style="min-width: 100px;">
                                            <span class="text-danger">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <h5>Sous-total</h5>
                                </td>
                                <td>
                                    <h5>{{ number_format($sumTotal, 0, ",", ".") }} FCFA</h5>
                                </td>
                            </tr>
                            <tr class="shipping_area">
                                <td></td>
                                <td></td>
                                <td>
                                    <h5>Livraison</h5>
                                </td>
                                <td>
                                    <div class="shipping_box">
                                        <ul class="list">
                                            <li class="exp-li" id="local_delivery"><a href="javascript:void(0);">Livraison locale : <span>1000 FCFA</span></a></li>
                                            <li class="exp-li" id="expedition_delivery"><a href="javascript:void(0);">Expédition : <span>2500 FCFA</span></a></li>
                                            <li class="exp-li" id="free_delivery"><a href="javascript:void(0);">Livraison gratuite</a></li>
                                            <li class="exp-li active" id="on_site_delivery"><a href="javascript:void(0);">Sur place (Maetur Nkomo)</a></li>
                                        </ul>
                                        <h6>Calculer la livraison <i class="fa fa-caret-down" aria-hidden="true"></i></h6>
                                        <label class="no_delivery_box" for="no_delivery">
                                            <input type="checkbox" form="cart-form" name="no_delivery" id="no_delivery" value="1" checked>Récupérer sur place ? &nbsp;&nbsp;
                                        </label>
                                        <div class="city-dropdown">
                                            <input type="text" id="citySearch" placeholder="Rechercher une ville..." class="mb-2 city-dropdown-input form-control">
                                            <div id="cityList" class="city-dropdown-list">
                                                @foreach($cities as $city)
                                                <label class="city-dropdown-item">
                                                    <input type="radio" form="cart-form" class="city-radio" name="city" value="{{ $city->id }}" data-neighborhoods='{{ json_encode($city->neighborhoods) }}' data-city='{{ json_encode($city) }}'>
                                                    {{ $city->name }}
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="neighborhood-dropdown" style="display: none;">
                                            <input type="text" id="neighborhoodSearch" placeholder="Rechercher un quartier..." class="mb-2 neighborhood-dropdown-input form-control">
                                            <div id="neighborhoodList" class="neighborhood-dropdown-list">
                                                {{-- Options de quartier seront ajoutées ici dynamiquement --}}
                                            </div>
                                        </div>
                                        {{-- <select class="shipping_select">
                                            <option value="">Sélectionner un quartier</option>
                                            <option value="2">Sélectionner un État</option>
                                            <option value="4">Sélectionner un État</option>
                                        </select>
                                        <input type="text" placeholder="Précisions">
                                        <a class="gray_btn" href="#">Mettre à jour</a> --}}
                                    </div>
                                </td>
                            </tr>
                            <tr class="out_button_area">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="checkout_btn_inner d-flex align-items-center">
                                        <a class="gray_btn" href="#">Continuer</a>
                                        <button form="cart-form" name="send" value="send" type="submit" class="btn primary-btn">Valider</button>
                                    </div>
                                    <form action="{{ route('site.send-or-maj') }}" method="post" id="cart-form">
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->

@endsection
