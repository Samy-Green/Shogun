@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Périodes promotionnelles')

@section('page-script')
@vite(['resources/assets/js/tables-datatables-basic.js'])
@endsection

@section('content')
<div class="d-flex justify-content-between">
    <h4 class="py-3">
        <span class="text-muted fw-light">
            <a class="text-muted fw-light" href="{{ route('admin.index') }}">Accueil</a> /
        </span> Périodes promotionnelles
    </h4>
    <form action="{{ route('admin.deals.create') }}" method="get">
        <button class="btn btn-primary waves-effect waves-light">
            <i class="ti ti-plus me-1"></i>
            <span class="align-middle">AJOUTER</span>
        </button>
    </form>
</div>

<div class="card">
    <h5 class="card-header">Liste des périodes promotionnelles</h5>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Actif</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($deals as $deal)
                <tr>
                    <td>{{ $deal->name }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($deal->description, 50) }}</td>
                    <td>{{ $deal->start_date->format('d/m/Y') }}</td>
                    <td>{{ $deal->end_date->format('d/m/Y') }}</td>
                    <td>
                        @if($deal->is_active)
                            <span class="badge bg-success">Oui</span>
                        @else
                            <span class="badge bg-secondary">Non</span>
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('admin.deals.edit', $deal->id) }}">
                                    <i class="ti ti-pencil me-1"></i> Modifier
                                </a>
                                <form action="{{ route('admin.deals.destroy', $deal->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette période ?');">
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
                    <td colspan="6" class="text-center text-muted py-4">Aucune période trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3 p-5">
        {{ $deals->links() }}
    </div>
</div>
@endsection
