@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Liste des Emails')

@section('content')
<div class="d-flex justify-content-between">
    <h4 class="py-3">
        <span class="text-muted fw-light">
            <a class="text-muted fw-light" href="{{ route('admin.index') }}">Accueil</a> /
        </span> Emails
    </h4>

    <form action="{{ route('admin.newsletters.create') }}" method="get">
        <button class="btn btn-primary waves-effect waves-light">
            <i class="ti ti-plus me-1"></i>
            <span class="align-middle">NOUVELLE NEWS</span>
        </button>
    </form>
</div>

<div class="card">
    <div class="d-flex justify-content-between">
        <h5 class="card-header">Liste des emails enregistrés</h5>

        <form action="{{ route('admin.newsletters.index') }}" method="get" class="p-4 d-flex">
            <input type="text" name="search_query" class="form-control me-3" placeholder="Rechercher un email..." value="{{ request('search_query') }}" />
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
                    <th>#</th>
                    <th>Email</th>
                    <th>Date d’inscription</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($emails as $index => $email)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $email->email }}</td>
                    <td>{{ $email->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <form action="{{ route('admin.newsletters.destroy', $email->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cet email ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="ti ti-trash"></i> Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-4 text-center text-muted">Aucun email enregistré.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-5 mt-3">
        {{ $emails->links() }}
    </div>
</div>
@endsection
