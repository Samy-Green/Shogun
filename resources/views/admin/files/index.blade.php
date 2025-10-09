@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Files')

@section('page-script')
@vite(['resources/assets/js/tables-datatables-basic.js'])
<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.copy-url').forEach(function(button) {
      button.addEventListener('click', function() {
        const url = this.dataset.url;
        navigator.clipboard.writeText(url).then(function() {
          alert('URL copiée dans le presse-papiers !');
        }).catch(function(err) {
          console.error('Erreur lors de la copie :', err);
        });
      });
    });
  });
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.copy-path').forEach(function(button) {
      button.addEventListener('click', function() {
        const path = this.dataset.path;
        navigator.clipboard.writeText(path).then(function() {
          alert('Chemin copié dans le presse-papiers !');
        }).catch(function(err) {
          console.error('Erreur lors de la copie :', err);
        });
      });
    });
  });
</script>
@endsection



@section('content')
<div class="d-flex justify-content-between">
  <h4 class="py-3">
    <span class="text-muted fw-light"><a class="text-muted fw-light" href="/admin">Accueil</a> / </span> Fichiers
  </h4>
  <form action="{{ route('admin.files.create') }}" method="get">
    <button class="btn btn-primary waves-effect waves-light" data-repeater-create="">
      <i class="ti ti-plus me-1"></i>
      <span class="align-middle">AJOUTER</span>
    </button>
  </form>
</div>
<!-- Hoverable Table rows -->
<div class="card">
  <div class="d-flex justify-content-between">
      <h5 class="card-header">Liste des fichiers</h5>
      <form action="#" method="get" class="d-flex p-4">
          <input type="text" name="search_query" class="form-control me-3" placeholder="Rechercher un fichier..." value="{{ $old_search['search_query'] }}" />
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
          <th>Name</th>
          <th>Preview</th>
          <th>Type</th>
          <th>Size (KB)</th>
          <th>Uploaded At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach($files as $file)
        <tr>
          <td><i class="{{ $file->icon['icon'] }} {{ $file->icon['color'] }}"></i> <span class="fw-medium">{{ $file->name }}</span></td>
          <td>
            @if(\Illuminate\Support\Str::startsWith($file->mime_type, 'image'))
              <img src="{{ $file->url }}" alt="{{ $file->name }}" class="rounded-circle avatar" width="40" height="40">
            @else
              <i class="ti ti-file-text ti-md"></i> {{ $file->mime_type }}
            @endif
          </td>
          <td>{{ $file->mime_type }}</td>
          <td>{{ number_format($file->size / 1024, 2) }}</td>
          <td>{{ $file->created_at->format('d M Y') }}</td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="ti ti-dots-vertical"></i>
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ $file->url }}" target="_blank">
                  <i class="ti ti-eye me-1"></i> Voir
                </a>
                <a class="dropdown-item" href="{{ $file->url }}" download>
                  <i class="ti ti-download me-1"></i> Télécharger
                </a>
                <a class="dropdown-item" href="{{ route('admin.files.edit', $file->id) }}">
                  <i class="ti ti-pencil me-1"></i> Modifier
                </a>
                <a class="dropdown-item copy-url" href="javascript:void(0);" data-url="{{ $file->url }}">
                  <i class="ti ti-copy me-1"></i> Copier l'URL
                </a>
                <a class="dropdown-item copy-path" href="javascript:void(0);" data-path="{{ $file->path }}">
                  <i class="ti ti-copy me-1"></i> Copier le chemin
                </a>
                <form action="{{ route('admin.files.destroy', $file->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this file?');">
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
    <div class="mt-3 p-5">
        {{ $files->links() }}
    </div>
</div>
<!--/ Hoverable Table rows -->
@endsection
