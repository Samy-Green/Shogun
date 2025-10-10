@extends('layouts/layoutMaster')

@section('title', 'Détails du produit')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="py-3 mb-0">
    <span class="text-muted fw-light"><a class="text-muted fw-light" href="{{ route('admin.index') }}">Accueil</a> / </span>
    <a class="text-muted fw-light" href="{{ route('admin.products.index') }}">Produits</a> / 
    <span class="text-dark">{{ $product->name }}</span>
  </h4>

  <div>
    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary me-2">
      <i class="ti ti-pencil me-1"></i> Modifier
    </a>
    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Voulez-vous vraiment supprimer ce produit ?');">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-danger">
        <i class="ti ti-trash me-1"></i> Supprimer
      </button>
    </form>
  </div>
</div>

<div class="card">
  <div class="row g-0">
    <!-- Image du produit -->
    <div class="col-md-4 text-center p-4 border-end">
      @if($product->image)
        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded" style="max-height: 300px; object-fit: contain;">
      @else
        <div class="bg-light d-flex justify-content-center align-items-center rounded" style="height: 300px;">
          <span class="text-muted">Aucune image</span>
        </div>
      @endif

      <div class="mt-3">
        <h5 class="fw-bold">{{ $product->name }}</h5>
        <p class="text-muted mb-0">{{ $product->full_name }}</p>
      </div>
    </div>

    <!-- Détails -->
    <div class="col-md-8 p-4">
      <h5 class="mb-4">Informations générales</h5>
      <div class="row mb-3">
        <div class="col-md-6">
          <strong>Code :</strong>
          <p>{{ $product->code }}</p>
        </div>
        <div class="col-md-6">
          <strong>Prix de vente :</strong>
          <p>{{ $product->price ? number_format($product->price, 0, ',', ' ') . ' FCFA' : '—' }}</p>
        </div>
        <div class="col-md-6">
          <strong>Prix d'achat :</strong>
          <p>{{ $product->purchase_price ? number_format($product->purchase_price, 0, ',', ' ') . ' FCFA' : '—' }}</p>
        </div>
        <div class="col-md-6">
          <strong>Quantité :</strong>
          <p>{{ $product->quantity ?? '—' }}</p>
        </div>
        <div class="col-md-6">
          <strong>Poids :</strong>
          <p>{{ $product->weight ? $product->weight . ' g' : '—' }}</p>
        </div>
        <div class="col-md-6">
          <strong>Catégorie principale :</strong>
          <p>{{ $product->mainCategory?->name ?? '—' }}</p>
        </div>
        <div class="col-md-6">
          <strong>Catégories associées :</strong>
          <p>
            @if($product->categories->count())
              @foreach($product->categories as $cat)
                <span class="badge bg-label-primary me-1">{{ $cat->name }}</span>
              @endforeach
            @else
              —
            @endif
          </p>
        </div>
      </div>

      <h5 class="mt-4 mb-3">Statut & Offres</h5>
      <div class="row mb-3">
        <div class="col-md-6">
          <strong>Disponible :</strong>
          <p>{{ $product->available ? 'Oui' : 'Non' }}</p>
        </div>
        <div class="col-md-6">
          <strong>Actif :</strong>
          <p>{{ $product->is_active ? 'Oui' : 'Non' }}</p>
        </div>
        <div class="col-md-6">
          <strong>À venir :</strong>
          <p>{{ $product->is_coming ? 'Oui' : 'Non' }}</p>
        </div>
        <div class="col-md-6">
          <strong>Status :</strong>
          <span class="badge {{ $product->status == 'new' ? 'bg-primary' : ($product->status == 'active' ? 'bg-success' : 'bg-secondary') }}">
            {{ ucfirst($product->status) ?? '—' }}
          </span>
        </div>
        <div class="col-md-6">
          <strong>Réduction :</strong>
          <p>{{ $product->discount ? $product->discount . ' FCFA' : 'Aucune' }}</p>
        </div>
        <div class="col-md-6">
          <strong>Date de fin de réduction :</strong>
          <p>{{ $product->discount_end_date ? \Carbon\Carbon::parse($product->discount_end_date)->format('d/m/Y') : '—' }}</p>
        </div>
        <div class="col-md-6">
          <strong>Deal spécial :</strong>
          <p>{{ $product->deal ? $product->deal . ' FCFA' : '—' }}</p>
        </div>
        <div class="col-md-6">
          <strong>Produit de luxe :</strong>
          <p>{{ $product->luxury ? 'Oui' : 'Non' }}</p>
        </div>
      </div>

      <h5 class="mt-4 mb-3">Descriptions</h5>
      <div class="mb-3">
        <strong>Description courte :</strong>
        <p>{{ $product->description ?? '—' }}</p>
      </div>
      <div class="mb-3">
        <strong>Description longue :</strong>
        <p>{!! $product->long_description !!}</p>
      </div>

      @if($product->promo_message)
      <div class="alert alert-info mt-4">
        <i class="ti ti-megaphone me-2"></i>
        <strong>Message promotionnel :</strong> {{ $product->promo_message }}
      </div>
      @endif

      <div class="mt-4">
        <strong>Chemin image :</strong>
        <p>{{ $product->image_url ?? '—' }}</p>
      </div>

    </div>
  </div>
</div>
@endsection
