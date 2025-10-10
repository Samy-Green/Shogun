@extends('layouts/layoutMaster')

@section('title', 'Add File')

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
    <span class="text-muted fw-light"><a class="text-muted fw-light" href="{{ route('admin.index') }}">Accueil</a> / </span> Ajouter un fichier
  </h4>
</div>

<div class="card mb-6">
  <h5 class="card-header">Add New File</h5>
  <form action="{{ route('admin.files.store') }}" method="POST" class="card-body" enctype="multipart/form-data">
    @csrf

    <div class="row g-6">
      <!-- File Name -->
      <div class="col-md-6">
        <label class="form-label" for="file-name">File Name</label>
        <input type="text" id="file-name" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter file name" />
      </div>

      <!-- Upload File -->
      <div class="col-md-6">
        <label class="form-label" for="file-upload">Upload File</label>
        <input type="file" id="file-upload" name="file" class="form-control" required />
        <div class="form-text">Max file size: 10MB</div>
      </div>

      <!-- MIME Type (read-only, auto after upload) -->
      {{-- <div class="col-md-6 mt-3">
        <label class="form-label" for="file-type">MIME Type</label>
        <input type="text" id="file-type" class="form-control" placeholder="Auto after upload" readonly />
      </div> --}}
    </div>

    <div class="pt-6">
      <button type="submit" class="btn btn-primary me-4">Save File</button>
      <a href="{{ route('admin.files.index') }}" class="btn btn-label-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
