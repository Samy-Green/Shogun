@extends('layouts/layoutMaster')

@section('title', 'Modifier un carousel')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/flatpickr/flatpickr.js',
  'resources/assets/vendor/libs/select2/select2.js',
])
@endsection

@section('page-script')
@vite(['resources/assets/js/form-layouts.js'])
@endsection

@section('content')
<div class="d-flex justify-content-between">
  <h4 class="py-3">
    <span class="text-muted fw-light">
      <a class="text-muted fw-light" href="/admin">Accueil</a> /
      <a class="text-muted fw-light" href="{{ route('admin.carousels.index') }}">Carousels</a> /
    </span>
    Modifier
  </h4>
</div>

<div class="card mb-6">
  <h5 class="card-header">Modifier carousel</h5>
  <form action="{{ route('admin.carousels.update', $carousel->id) }}" method="POST" class="card-body" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-3">
      <!-- Titre -->
      <div class="col-md-6">
        <label class="form-label" for="title">Titre</label>
        <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $carousel->title) }}" required />
      </div>

      <!-- Description -->
      <div class="col-12">
        <label class="form-label" for="description">Description</label>
        <textarea id="description" name="description" class="form-control" rows="3">{{ old('description', $carousel->description) }}</textarea>
      </div>

      <!-- Texte du bouton -->
      <div class="col-md-6">
        <label class="form-label" for="button_text">Texte du bouton</label>
        <input type="text" id="button_text" name="button_text" class="form-control" value="{{ old('button_text', $carousel->button_text) }}" />
      </div>

      <!-- Lien du bouton -->
      <div class="col-md-6">
        <label class="form-label" for="button_link">Lien du bouton</label>
        <input type="text" id="button_link" name="button_link" class="form-control" value="{{ old('button_link', $carousel->button_link) }}" />
      </div>

      <!-- Icône du bouton -->
      <div class="col-md-6">
        <label class="form-label" for="button_icon">Icône du bouton (classe CSS)</label>
        <input type="text" id="button_icon" name="button_icon" class="form-control" value="{{ old('button_icon', $carousel->button_icon) }}" />
      </div>

      <!-- Image depuis fichier -->
      <div class="col-md-6 mb-6">
        <label for="selectFile" class="form-label">Choisir un fichier</label>
        <select id="selectFile" name="image_id" class="select2 form-select form-select-lg" data-allow-clear="true">
          <option value="">Aucun</option>
          @foreach($files as $file)
            <option value="{{ $file->id }}" {{ old('image_id') == $file->id || $carousel->image == $file->path ? 'selected' : '' }}>
              {{ $file->name }} ({{ $file->mime_type }})
            </option>
          @endforeach
        </select>
      </div>

      <!-- Image via URL -->
      <div class="col-md-6">
        <label class="form-label" for="image_url">Chemin d'image</label>
        <input type="text" id="image_url" name="image_url" class="form-control" value="{{ old('image_url', $carousel->image) }}" placeholder="/storage/..." />
      </div>
    </div>

    <div class="pt-4">
      <button type="submit" class="btn btn-primary me-2">Enregistrer</button>
      <a href="{{ route('admin.carousels.index') }}" class="btn btn-secondary">Annuler</a>
    </div>
  </form>
</div>
@endsection
