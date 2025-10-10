@extends('layouts/layoutMaster')

@section('title', 'Créer une ville')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/select2/select2.scss',
])
@endsection

@section('vendor-script')
@vite([
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
      <a class="text-muted fw-light" href="{{ route('admin.index') }}">Accueil</a> /
      <a class="text-muted fw-light" href="{{ route('admin.cities.index') }}">Villes</a> /
    </span>
    Nouvelle ville
  </h4>
</div>

<div class="mb-6 card">
  <h5 class="card-header">Créer une ville</h5>

  <form action="{{ route('admin.cities.store') }}" method="POST" class="card-body">
    @csrf
    <div class="row g-3">

      <div class="col-md-6">
        <label class="form-label" for="name">Nom de la ville</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Nom de la ville">
        @error("name")
            <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      <div class="col-md-6">
        <label class="form-label" for="delivery">Livraison</label>
        <select name="delivery" id="delivery" class="form-control select2">
            <option value="">Choisir le type de livraison</option>
            <option value="shipping" {{ old('delivery')=='shipping' ? 'selected' : '' }}>Expédition</option>
            <option value="home" {{ old('delivery')=='home' ? 'selected' : '' }}>A domicile</option>
            <option value="none" {{ old('delivery')=='none' ? 'selected' : '' }}>Non pris en charge</option>
        </select>
        @error("delivery")
            <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      <div class="col-md-6">
        <label class="form-label" for="cost">Coût de livraison (FCFA)</label>
        <input type="number" name="cost" id="cost" step="0.01" class="form-control" value="{{ old('cost') }}" placeholder="Coût de livraison">
        @error("cost")
            <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

    </div>

    <div class="pt-4">
      <button type="submit" class="btn btn-primary me-2">Créer</button>
      <a href="{{ route('admin.cities.index') }}" class="btn btn-secondary">Annuler</a>
    </div>
  </form>
</div>
@endsection
