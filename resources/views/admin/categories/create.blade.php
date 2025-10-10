@extends('layouts/layoutMaster')

@section('title', 'Ajouter une catégorie')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
  'resources/assets/vendor/libs/select2/select2.scss'
])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/flatpickr/flatpickr.js',
  'resources/assets/vendor/libs/select2/select2.js'
])
@endsection

<!-- Page Scripts -->
@section('page-script')
@vite(['resources/assets/js/form-layouts.js'])
@endsection

@section('content')
<div class="d-flex justify-content-between">
  <h4 class="py-3">
    <span class="text-muted fw-light"><a class="text-muted fw-light" href="{{ route('admin.index') }}">Accueil</a> / </span> Ajouter une catégorie
  </h4>
</div>

<div class="card mb-6">
  <h5 class="card-header">Nouvelle catégorie</h5>
  <form action="{{ route('admin.categories.store') }}" method="POST" class="card-body" enctype="multipart/form-data">
    @csrf

    <div class="row g-6">
      <!-- Nom -->
      <div class="col-md-6">
        <label class="form-label" for="name">Nom</label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="Nom de la catégorie" required />
      </div>

      <!-- Code -->
      <div class="col-md-6">
        <label class="form-label" for="code">Code</label>
        <input type="text" id="code" name="code" class="form-control" value="{{ old('code') }}" placeholder="Code unique" />
      </div>

      <!-- Parent -->
      <div class="col-md-6">
        <label class="form-label" for="parent_id">Catégorie parent</label>
        <select id="parent_id" name="parent_id" class="form-select">
          <option value="">Aucune</option>
          @foreach($categories as $parent)
            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
              {{ $parent->name }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Couleur -->
      <div class="col-md-3 col-6">
        <label class="form-label" for="color">Couleur (classe CSS)</label>
        <input type="text" id="color" name="color" class="form-control" value="{{ old('color') }}" placeholder="text-primary, text-success..." />
      </div>

      <!-- Icone -->
      <div class="col-md-3 col-6">
        <label class="form-label" for="icon">Icône (classe CSS)</label>
        <input type="text" id="icon" name="icon" class="form-control" value="{{ old('icon') }}" placeholder="ti ti-folder, ti ti-star..." />
      </div>

      <!-- Image -->
      <div class="col-md-6 mb-6">
        <label for="selectFile" class="form-label">Choisir un fichier</label>
        <select id="selectFile" name="image_id" class="select2 form-select form-select-lg" data-allow-clear="true">
          <option value="">Aucun</option>
          @foreach($files as $file)
            <option value="{{ $file->id }}" {{ old('image_id') == $file->id ? 'selected' : '' }}>
              {{ $file->name }} ( {{ $file->mime_type }} )
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label" for="image_url">Chemin d'image</label>
        <input type="text" id="image_url" name="image_url" class="form-control" value="{{ old('image_url') }}" placeholder="/storage/..." />
      </div>
      
      <!-- Description -->
      <div class="col-12">
        <label class="form-label" for="description">Description</label>
        <textarea id="description" name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
      </div>

      <!-- Catégorie principale -->
      <div class="col-md-6 mt-3">
        <div class="form-check mt-2">
          <input class="form-check-input" type="checkbox" id="is_primary" name="is_primary" value="1" {{ old('is_primary') ? 'checked' : '' }}>
          <label class="form-check-label" for="is_primary">Catégorie principale</label>
        </div>
      </div>
    </div>

    <div class="pt-6">
      <button type="submit" class="btn btn-primary me-4">Enregistrer</button>
      <a href="{{ route('admin.categories.index') }}" class="btn btn-label-secondary">Annuler</a>
    </div>
  </form>
</div>
@endsection
