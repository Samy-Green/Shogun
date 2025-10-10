@extends('layouts/layoutMaster')

@section('title', 'Modifier un code promo')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/flatpickr/flatpickr.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/flatpickr/flatpickr.js'
])
@endsection

@section('page-script')
@vite(['resources/assets/js/form-layouts.js'])
@endsection

@section('content')
<div class="d-flex justify-content-between">
  <h4 class="py-3">
    <span class="text-muted fw-light">
      <a class="text-muted fw-light" href="{{ route('admin.index') }}">Accueil</a> /
      <a class="text-muted fw-light" href="{{ route('admin.codes.index') }}">Codes promo</a> /
    </span>
    Modifier le code promo
  </h4>
</div>

<div class="mb-6 card">
  <h5 class="card-header">Modifier le code promo</h5>

  <form action="{{ route('admin.codes.update', $code->id) }}" method="POST" class="card-body">
    @csrf
    @method('PUT')

    <div class="row g-3">

      {{-- Code promo --}}
      <div class="col-md-6">
        <label class="form-label" for="code">Code</label>
        <input
          type="text"
          name="code"
          id="code"
          class="form-control"
          value="{{ old('code', $code->code) }}"
          placeholder="Laisser vide pour régénérer automatiquement"
        >
        @error('code')
          <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      {{-- Nom du propriétaire --}}
      <div class="col-md-6">
        <label class="form-label" for="owner_name">Nom du propriétaire</label>
        <input
          type="text"
          name="owner_name"
          id="owner_name"
          class="form-control"
          value="{{ old('owner_name', $code->owner_name) }}"
          placeholder="Facultatif"
        >
        @error('owner_name')
          <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      {{-- Numéro du propriétaire --}}
      <div class="col-md-6">
        <label class="form-label" for="owner_phone">Numéro du propriétaire</label>
        <input
          type="text"
          name="owner_phone"
          id="owner_phone"
          class="form-control"
          value="{{ old('owner_phone', $code->owner_phone) }}"
          placeholder="Facultatif"
        >
        @error('owner_phone')
          <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      {{-- Réduction --}}
      <div class="col-md-6">
        <label class="form-label" for="discount">Réduction (entre 0 et 1 pour % et > 1 pour FCFA)</label>
        <input
          type="number"
          name="discount"
          id="discount"
          step="0.01"
          class="form-control"
          value="{{ old('discount', $code->discount ?? 0.8) }}"
        >
        @error('discount')
          <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

    </div>

    <div class="pt-4">
      <button type="submit" class="btn btn-primary me-2">Mettre à jour</button>
      <a href="{{ route('admin.codes.index') }}" class="btn btn-secondary">Annuler</a>
    </div>
  </form>
</div>
@endsection
