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
        <span class="text-muted fw-light"><a class="text-muted fw-light" href="/admin">Accueil</a> / </span> Produits
    </h4>
    <form action="{{ route('admin.products.create') }}" method="get">
        <button class="btn btn-primary waves-effect waves-light">
            <i class="ti ti-plus me-1"></i>
            <span class="align-middle">AJOUTER</span>
        </button>
    </form>
</div>

<div class="card">
    <div class="d-flex justify-content-between">
        <h5 class="card-header">Liste des produits</h5>
        <form action="#" method="get" class="p-4 d-flex">
            <input type="text" name="search_query" class="form-control me-3" placeholder="Rechercher un produit..." value="{{ $old_search['search_query'] }}" />
            <button class="btn btn-primary waves-effect waves-light">
                <i class="ti ti-search me-1 ms-3"></i>
                <span class="align-middle me-4">Rechercher</span>
            </button>
        </form>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table align-middle table-hover">
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
                            <span class="badge bg-warning text-dark">{{ $product->reduction }} FCFA</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="p-0 btn dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
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
                    <td colspan="9" class="py-4 text-center text-muted">Aucun produit trouvé.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="p-5 mt-3">
        {{ $products->links() }}
    </div>
</div>

<div class="mt-5 mb-5 card">
    <h5 class="card-header">Importer des produits</h5>
    <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data" class="mb-3 card-body">
        @csrf
        <div class="gap-2 d-flex align-items-center">
            <input type="file" name="file" accept=".csv,.txt,.xlsx,.xls" class="w-auto form-control" required>
            <button type="submit" class="btn btn-primary">Importer un fichier (CSV, XLSX, XLS)</button>
            <div class="dropdown ms-2">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                    Templates {{-- <i class="ti ti-dots-vertical ms-2"></i>  --}}
                </button>
                <div class="dropdown-menu">
                    
                    {{-- CSV (Couleur standard, Icône de téléchargement) --}}
                    <a class="dropdown-item text-primary" 
                    href="{{ asset('templates/import-products-template.csv') }}" 
                    download="products_import_template.csv">
                        <i class="ti ti-file-type-csv me-1"></i> CSV
                    </a>
                    
                    {{-- TXT (Couleur standard, Icône de téléchargement) --}}
                    <a class="dropdown-item text-secondary" 
                    href="{{ asset('templates/import-products-template.txt') }}" 
                    download="products_import_template.txt">
                        <i class="ti ti-file-text me-1"></i> TXT
                    </a>
                    
                    {{-- XLSX (Couleur verte pour Excel, Icône de téléchargement) --}}
                    <a class="dropdown-item text-success" 
                    href="{{ asset('templates/import-products-template.xlsx') }}" 
                    download="products-import-template.xlsx">
                        <i class="ti ti-file-type-xls me-1"></i> XLSX
                    </a>
                    
                </div>
            </div>
        </div>
    </form>
    @if (session('import_success'))
        <div class="mt-3 alert alert-success">
            {{ session('import_success') }}
        </div>
    @endif

    @if (session('import_errors'))
        <div class="mt-3 alert alert-danger">
            <ul>
                @foreach (session('import_errors') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
