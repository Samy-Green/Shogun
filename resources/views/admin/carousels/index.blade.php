@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Carousels')

@section('page-script')
@vite(['resources/assets/js/tables-datatables-basic.js'])
@endsection

@section('content')
<div class="d-flex justify-content-between">
    <h4 class="py-3">
        <span class="text-muted fw-light"><a class="text-muted fw-light" href="/admin">Accueil</a> / </span> Carousels
    </h4>
    <form action="{{ route('admin.carousels.create') }}" method="get">
        <button class="btn btn-primary waves-effect waves-light">
            <i class="ti ti-plus me-1"></i>
            <span class="align-middle">AJOUTER</span>
        </button>
    </form>
</div>

<div class="card">
    <h5 class="card-header">Liste des carousels</h5>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Bouton</th>
                    <th>Lien</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($carousels as $carousel)
                <tr>
                    <td>
                        @if($carousel->image)
                            <img src="{{ asset( $carousel->image) }}" alt="Image carousel" class="rounded" width="50" height="50">
                        @else
                            <span class="text-muted">Aucune</span>
                        @endif
                    </td>
                    <td>{{ $carousel->title }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($carousel->description, 50) }}</td>
                    <td>{{ $carousel->button_text ?? '-' }}</td>
                    <td>{{ $carousel->button_link ?? '-' }}</td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('admin.carousels.edit', $carousel->id) }}">
                                    <i class="ti ti-pencil me-1"></i> Modifier
                                </a>
                                <form action="{{ route('admin.carousels.destroy', $carousel->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce carousel ?');">
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

                @if($carousels->isEmpty())
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Aucun carousel trouvé.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="mt-3 p-5">
        {{ $carousels->links() }}
    </div>
</div>
@endsection
