@extends('layouts/layoutMaster')

@section('title', 'Modifier un quartier')

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
      <a class="text-muted fw-light" href="{{ route('admin.neighborhoods.index') }}">Quartiers</a> /
    </span>
    Modifier le quartier
  </h4>
</div>

<div class="mb-6 card">
  <h5 class="card-header">Modifier le quartier</h5>

  <form action="{{ route('admin.neighborhoods.update', $neighborhood->id) }}" method="POST" class="card-body">
    @csrf
    @method('PUT')

    <div class="row g-3">

      {{-- Nom du quartier --}}
      <div class="col-md-6">
        <label class="form-label" for="name">Nom du quartier</label>
        <input
          type="text"
          name="name"
          id="name"
          class="form-control"
          value="{{ old('name', $neighborhood->name) }}"
          placeholder="Nom du quartier"
        >
        @error('name')
          <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      {{-- Ville --}}
      <div class="col-md-6">
        <label class="form-label" for="city_id">Ville</label>
        <select name="city_id" id="city_id" class="form-control select2">
          <option value="">Choisir une ville</option>
          @foreach($cities as $city)
            <option value="{{ $city->id }}" {{ old('city_id', $neighborhood->city_id) == $city->id ? 'selected' : '' }}>
              {{ $city->name }}
            </option>
          @endforeach
        </select>
        @error('city_id')
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
          value="{{ old('cost', $neighborhood->cost ?? 0) }}"
          placeholder="Ex : 500"
        >
        @error('cost')
          <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

    </div>

    <div class="pt-4">
      <button type="submit" class="btn btn-primary me-2">Mettre à jour</button>
      <a href="{{ route('admin.neighborhoods.index') }}" class="btn btn-secondary">Annuler</a>
    </div>
  </form>
</div>
@endsection
