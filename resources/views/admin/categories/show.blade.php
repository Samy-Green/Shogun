@extends('layouts/layoutMaster')

@section('title', 'Détails de la catégorie')

@section('vendor-style')
@vite(['resources/assets/vendor/libs/select2/select2.scss'])
@endsection

@section('vendor-script')
@vite(['resources/assets/vendor/libs/select2/select2.js'])
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="py-3 mb-0">
    <span class="text-muted fw-light">
      <a href="/admin" class="text-muted fw-light">Accueil</a> /
      <a href="{{ route('admin.categories.index') }}" class="text-muted fw-light">Catégories</a> /
    </span>
    {{ $category->name }}
  </h4>

  <div class="d-flex gap-2">
    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary">
      <i class="ti ti-pencil me-1"></i> Modifier
    </a>
    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette catégorie ?');">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-danger">
        <i class="ti ti-trash me-1"></i> Supprimer
      </button>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">{{ $category->name }}</h5>
    @if($category->is_primary)
      <span class="badge bg-label-primary">Catégorie principale</span>
    @endif
  </div>

  <div class="card-body">
    <div class="row g-4">
      <!-- Image -->
      <div class="col-md-4 text-center">
        @if($category->image)
          <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="img-fluid rounded mb-3" style="max-height: 200px; object-fit: cover;">
        @else
          <div class="text-muted fst-italic">Aucune image</div>
        @endif
      </div>

      <!-- Infos principales -->
      <div class="col-md-8">
        <div class="mb-3">
          <strong>Nom :</strong> {{ $category->name }}
        </div>
        <div class="mb-3">
          <strong>Code :</strong> {{ $category->code ?? '—' }}
        </div>
        <div class="mb-3">
          <strong>Catégorie parent :</strong>
          @if($category->parent)
            <a href="{{ route('admin.categories.show', $category->parent->id) }}">
              {{ $category->parent->name }}
            </a>
          @else
            <span class="text-muted">Aucune</span>
          @endif
        </div>
        <div class="mb-3">
          <strong>Couleur :</strong>
          @if($category->color)
            <span class="{{ $category->color }}">{{ $category->color }}</span>
          @else
            <span class="text-muted">Aucune</span>
          @endif
        </div>
        <div class="mb-3">
          <strong>Icône :</strong>
          @if($category->icon)
            <i class="{{ $category->icon }} me-1"></i> <code>{{ $category->icon }}</code>
          @else
            <span class="text-muted">Aucune</span>
          @endif
        </div>
        <div class="mb-3">
          <strong>Description :</strong>
          <div class="text-muted">{!! nl2br(e($category->description ?? '—')) !!}</div>
        </div>
      </div>
    </div>

    <hr class="my-4">

    <!-- Statistiques -->
    <div class="row text-center">
      <div class="col-md-4">
        <div class="text-muted">Sous-catégories</div>
        <h5>{{ $category->count_children }}</h5>
      </div>
      <div class="col-md-4">
        <div class="text-muted">Produits directs</div>
        <h5>{{ $category->count_products }}</h5>
      </div>
      <div class="col-md-4">
        <div class="text-muted">Produits totaux</div>
        <h5>{{ $category->total_products_count }}</h5>
      </div>
    </div>

    <hr class="my-4">

    <!-- Sous-catégories -->
    <div>
      <h6 class="fw-bold mb-3">Sous-catégories</h6>
      @if($category->children->count() > 0)
        <ul class="list-group">
          @foreach($category->children as $child)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <a href="{{ route('admin.categories.show', $child->id) }}">{{ $child->name }}</a>
              <span class="badge bg-label-secondary">{{ $child->count_products }} produits</span>
            </li>
          @endforeach
        </ul>
      @else
        <p class="text-muted fst-italic">Aucune sous-catégorie.</p>
      @endif
    </div>
  </div>
</div>
@endsection
