@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Catégories')

@section('page-script')
@vite(['resources/assets/js/tables-datatables-basic.js'])
@endsection

@section('content')
<div class="d-flex justify-content-between">
    <h4 class="py-3">
        <span class="text-muted fw-light"><a class="text-muted fw-light" href="{{ route('admin.index') }}">Accueil</a> / </span> Catégories
    </h4>
    <form action="{{ route('admin.categories.create') }}" method="get">
        <button class="btn btn-primary waves-effect waves-light">
            <i class="ti ti-plus me-1"></i>
            <span class="align-middle">AJOUTER</span>
        </button>
    </form>
</div>

<div class="card">
    <div class="d-flex justify-content-between">
        <h5 class="card-header">Liste des catégories</h5>
        <form action="#" method="get" class="p-4 d-flex">
            <input type="text" name="search_query" class="form-control me-3" placeholder="Rechercher une catégorie..." value="{{ $old_search['search_query'] }}" />
            <button class="btn btn-primary waves-effect waves-light">
                <i class="ti ti-search me-1 ms-3"></i>
                <span class="align-middle me-4">Rechercher</span>
            </button>
        </form>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Nom</th>
                    <th>Code</th>
                    <th>Parent</th>
                    <th>Enfants</th>
                    <th>Produits</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($categories as $category)
                <tr>
                    <th>{{ $category->id }}</th>
                    <td>
                        @if($category->icon)
                            <i class="{{ $category->icon }} {{ $category->color }}"></i>
                        @endif
                        {{ $category->name }}
                        @if($category->is_primary)
                            <span class="badge bg-primary ms-1">Principale</span>
                        @endif
                    </td>
                    <td>{{ $category->code }}</td>
                    <td>{{ $category->parent ? $category->parent->name : '-' }}</td>
                    <td>{{ $category->count_children }}</td>
                    <td>{{ $category->total_products_count }}</td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="p-0 btn dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('admin.categories.show', $category->id) }}">
                                    <i class="ti ti-eye me-1"></i> Voir
                                </a>
                                <a class="dropdown-item" href="{{ route('admin.categories.edit', $category->id) }}">
                                    <i class="ti ti-pencil me-1"></i> Modifier
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette catégorie ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item">
                                        <i class="ti ti-trash me-1"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr></tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-5 mt-3">
        {{ $categories->links() }}
    </div>

</div>
@endsection
