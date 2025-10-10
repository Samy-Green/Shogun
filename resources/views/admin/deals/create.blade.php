@extends('layouts/layoutMaster')

@section('title', 'Ajouter une période promotionnelle')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/flatpickr/flatpickr.js',
])
@endsection

<!-- Page Scripts -->
@section('page-script')
@vite(['resources/assets/js/form-layouts.js'])
<script>
    // Initialisation du flatpickr pour les dates
    flatpickr("#start_date", { dateFormat: "Y-m-d" });
    flatpickr("#end_date", { dateFormat: "Y-m-d" });
</script>
@endsection

@section('content')
<div class="d-flex justify-content-between">
  <h4 class="py-3">
    <span class="text-muted fw-light">
      <a class="text-muted fw-light" href="{{ route('admin.index') }}">Accueil</a> /
      <a class="text-muted fw-light" href="{{ route('admin.deals.index') }}">Périodes promotionnelles</a> /
    </span>
    Ajouter
  </h4>
</div>

<div class="card mb-6">
  <h5 class="card-header">Nouvelle période promotionnelle</h5>
  <form action="{{ route('admin.deals.store') }}" method="POST" class="card-body">
    @csrf
    <div class="row g-3">

      <!-- Nom -->
      <div class="col-md-6">
        <label class="form-label" for="name">Nom</label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="Nom de la période" required>
      </div>

      <!-- Description -->
      <div class="col-md-6">
        <label class="form-label" for="description">Description</label>
        <input type="text" id="description" name="description" class="form-control" value="{{ old('description') }}" placeholder="Description courte">
      </div>

      <!-- Date de début -->
      <div class="col-md-3">
        <label class="form-label" for="start_date">Date de début</label>
        <input type="date" id="start_date" name="start_date" class="form-control" value="{{ old('start_date') }}" placeholder="YYYY-MM-DD" required>
      </div>

      <!-- Date de fin -->
      <div class="col-md-3">
        <label class="form-label" for="end_date">Date de fin</label>
        <input type="date" id="end_date" name="end_date" class="form-control" value="{{ old('end_date') }}" placeholder="YYYY-MM-DD" required>
      </div>
      

      <!-- Actif -->
      <div class="col-md-3 mt-4">
        <div class="form-check mt-2">
          <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
          <label class="form-check-label" for="is_active">Actif</label>
        </div>
      </div>
            <!-- Image depuis fichier -->
      <div class="col-md-6 mb-6">
        <label for="selectFile" class="form-label">Choisir un fichier</label>
        <select id="selectFile" name="image_id" class="select2 form-select form-select-lg" data-allow-clear="true">
          <option value="">Aucun</option>
          @foreach($files as $file)
            <option value="{{ $file->id }}" {{ old('image_id') == $file->id ? 'selected' : '' }}>
              {{ $file->name }} ({{ $file->mime_type }})
            </option>
          @endforeach
        </select>
      </div>

      <!-- Image via URL -->
      <div class="col-md-6">
        <label class="form-label" for="image_url">Chemin d'image</label>
        <input type="text" id="image_url" name="image_url" class="form-control" value="{{ old('image_url') }}" placeholder="/storage/..." />
      </div>

    </div>

    <div class="pt-4">
      <button type="submit" class="btn btn-primary me-2">Enregistrer</button>
      <a href="{{ route('admin.deals.index') }}" class="btn btn-secondary">Annuler</a>
    </div>
  </form>
</div>
@endsection
