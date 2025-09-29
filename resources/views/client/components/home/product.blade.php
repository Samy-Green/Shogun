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

        @if (isset($cart[$product->id]))
          <a href="{{ route('cart.remove', $product->id) }}" class="social-info">
            <span class="ti-close"></span>
            <p class="hover-text">Retirer du panier</p>
          </a>
        @else
          <a href="{{ route('cart.add', $product->id) }}" class="social-info">
            <span class="ti-bag"></span>
            <p class="hover-text">Ajouter au panier</p>
          </a>
        @endif
        {{-- <a href="" class="social-info">
          <span class="lnr lnr-heart"></span>
          <p class="hover-text">Liste de souhaits</p>
        </a>
        <a href="" class="social-info">
          <span class="lnr lnr-sync"></span>
          <p class="hover-text">Comparer</p>
        </a> --}}
        <a href="{{ route('site.product', $product->id) }}" class="social-info">
          <span class="lnr lnr-move"></span>
          <p class="hover-text">Voir plus</p>
        </a>
      </div>
    </div>
  </div>
</div>