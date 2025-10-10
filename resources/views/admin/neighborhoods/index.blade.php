@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Quartiers')

@section('page-script')
@vite(['resources/assets/js/tables-datatables-basic.js'])
@endsection

@section('content')
<div class="d-flex justify-content-between">
    <h4 class="py-3">
        <span class="text-muted fw-light">
            <a class="text-muted fw-light" href="{{ route('admin.index') }}">Accueil</a> /
        </span>
        Quartiers
    </h4>
    <form action="{{ route('admin.neighborhoods.create') }}" method="get">
        <button class="btn btn-primary waves-effect waves-light">
            <i class="ti ti-plus me-1"></i>
            <span class="align-middle">AJOUTER</span>
        </button>
    </form>
</div>

<div class="card">
    <div class="d-flex justify-content-between">
        <h5 class="card-header">Liste des quartiers</h5>
        <form action="#" method="get" class="p-4 d-flex">
            <input type="text" name="search_query" class="form-control me-3" value="{{ request('search_query') }}" placeholder="Rechercher un quartier ou une ville..." />
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
                    <th>Nom du quartier</th>
                    <th>Ville</th>
                    <th>Coût de livraison (FCFA)</th>
                    <th>Date de création</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($neighborhoods as $neighborhood)
                <tr>
                    <td><strong>{{ $neighborhood->name }}</strong></td>
                    <td>{{ $neighborhood->city->name ?? '-' }}</td>
                    <td>{{ number_format($neighborhood->cost, 0, ',', ' ') }}</td>
                    <td>{{ $neighborhood->created_at ? $neighborhood->created_at->format('d/m/Y') : '-' }}</td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="p-0 btn dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                <form action="{{ route('admin.neighborhoods.edit', $neighborhood->id) }}" method="GET">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-primary">
                                        <i class="ti ti-edit me-1"></i> Modifier
                                    </button>
                                </form>
                                <form action="{{ route('admin.neighborhoods.destroy', $neighborhood->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce quartier ?');">
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
                @empty
                <tr>
                    <td colspan="5" class="py-4 text-center text-muted">Aucun quartier trouvé.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
