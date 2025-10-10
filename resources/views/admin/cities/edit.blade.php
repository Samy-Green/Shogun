@extends('layouts/layoutMaster')

@section('title', 'Modifier une ville')

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
    Modifier la ville
  </h4>
</div>

<div class="mb-6 card">
  <h5 class="card-header">Modifier la ville</h5>

  <form action="{{ route('admin.cities.update', $city->id) }}" method="POST" class="card-body">
    @csrf
    @method('PUT')

    <div class="row g-3">

      {{-- Nom de la ville --}}
      <div class="col-md-6">
        <label class="form-label" for="name">Nom de la ville</label>
        <input
          type="text"
          name="name"
          id="name"
          class="form-control"
          value="{{ old('name', $city->name) }}"
          placeholder="Nom de la ville"
        >
        @error('name')
          <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      {{-- Type de livraison --}}
      <div class="col-md-6">
        <label class="form-label" for="delivery">Livraison</label>
        <select name="delivery" id="delivery" class="form-control select2">
            <option value="">Choisir le type de livraison</option>
            <option value="shipping" {{ old('delivery', $city->delivery)=='shipping' ? 'selected' : '' }}>Expédition</option>
            <option value="home" {{ old('delivery', $city->delivery)=='home' ? 'selected' : '' }}>A domicile</option>
            <option value="none" {{ old('delivery', $city->delivery)=='none' ? 'selected' : '' }}>Non pris en charge</option>
        </select>
        @error('delivery')
            <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      {{-- Coût de livraison --}}
      <div class="col-md-6">
        <label class="form-label" for="cost">Coût de livraison (FCFA)</label>
        <input
          type="number"
          name="cost"
          id="cost"
          step="0.01"
          class="form-control"
          value="{{ old('cost', $city->cost) }}"
          placeholder="Coût de livraison"
        >
        @error('cost')
          <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

    </div>

    <div class="pt-4">
      <button type="submit" class="btn btn-primary me-2">Mettre à jour</button>
      <a href="{{ route('admin.cities.index') }}" class="btn btn-secondary">Annuler</a>
    </div>
  </form>
</div>
@endsection
