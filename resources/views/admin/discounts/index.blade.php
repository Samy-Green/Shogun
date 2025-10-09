@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Produits')

@section('page-script')
@vite(['resources/assets/js/tables-datatables-basic.js'])
@endsection

@section('content')
<div class="d-flex justify-content-between">
    <h4 class="py-3">
        <span class="text-muted fw-light"><a class="text-muted fw-light" href="/admin">Accueil</a> / </span> Promotions
    </h4>
    <form action="{{ route('admin.reductions.create') }}" method="get">
        <button class="btn btn-primary waves-effect waves-light">
            <i class="ti ti-plus me-1"></i>
            <span class="align-middle">AJOUTER</span>
        </button>
    </form>
</div>

<div class="card">
    <div class="d-flex justify-content-between">
        <h5 class="card-header">Liste des produits en promotion</h5>
        <form action="#" method="get" class="d-flex p-4">
            <input type="text" name="search_query" class="form-control me-3" placeholder="Rechercher un produit..." value="{{ $old_search['search_query'] }}" />
            <button class="btn btn-primary waves-effect waves-light">
                <i class="ti ti-search me-1 ms-3"></i>
                <span class="align-middle me-4">Rechercher</span>
            </button>
        </form>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Code</th>
                    <th>Catégorie principale</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Disponible</th>
                    <th>Réduction</th>
                    <th>Affaire</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($products as $product)
                <tr>
                    <td>
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" alt="Image produit" class="rounded" width="50" height="50">
                        @else
                            <span class="text-muted">Aucune</span>
                        @endif
                    </td>
                    <td>
                        {{ $product->name }}
                        @if($product->is_active)
                            <span class="badge bg-success ms-1">Actif</span>
                        @else
                            <span class="badge bg-secondary ms-1">Inactif</span>
                        @endif
                    </td>
                    <td>{{ $product->code }}</td>
                    <td>{{ $product->mainCategory ? $product->mainCategory->name : '-' }}</td>
                    <td>{{ number_format($product->price, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $product->quantity }}</td>
                    <td>
                        @if($product->available)
                            <span class="badge bg-label-success">Oui</span>
                        @else
                            <span class="badge bg-label-danger">Non</span>
                        @endif
                    </td>
                    <td>
                        @if($product->reduction > 0)
                            <span class="badge bg-warning text-dark">{{ number_format($product->discount, 0, ',', ' ') }} FCFA</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        @if($product->deal > 0)
                            <span class="badge bg-warning text-dark">{{ number_format($product->deal, 0, ',', ' ') }} FCFA</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('admin.products.show', $product->id) }}">
                                    <i class="ti ti-eye me-1"></i> Voir
                                </a>
                                <a class="dropdown-item" href="{{ route('admin.products.edit', $product->id) }}">
                                    <i class="ti ti-pencil me-1"></i> Modifier
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce produit ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="ti ti-trash me-1"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach

                @if($products->isEmpty())
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">Aucun produit trouvé.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="mt-3 p-5">
        {{ $products->links() }}
    </div>
</div>
@endsection
