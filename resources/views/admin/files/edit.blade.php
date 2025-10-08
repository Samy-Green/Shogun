@extends('layouts/layoutMaster')

@section('title', 'Edit File')

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
    <span class="text-muted fw-light"><a class="text-muted fw-light" href="/admin">Accueil</a> / <a class="text-muted fw-light" href="{{ route('admin.files.index') }}">Fichiers</a> / <a class="text-muted fw-light" href="{{ route('admin.files.show', $file->id) }}">{{ $file->name }}</a> / </span> Modifier
  </h4>
  {{-- <form action="{{ route('admin.files.create') }}" method="get">
    <button class="btn btn-primary waves-effect waves-light" data-repeater-create="">
      <i class="ti ti-plus me-1"></i>
      <span class="align-middle">AJOUTER</span>
    </button>
  </form> --}}
</div>

<div class="card mb-6">
  <h5 class="card-header">Edit File</h5>
  <form action="{{ route('admin.files.update', $file->id) }}" method="POST" class="card-body" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-6">
      <!-- File Name -->
      <div class="col-md-6">
        <label class="form-label" for="file-name">File Name</label>
        <input type="text" id="file-name" name="name" class="form-control" value="{{ old('name', $file->name) }}" placeholder="Enter file name" />
      </div>

      <!-- Current File Preview -->
      <div class="col-md-6">
        <label class="form-label">Current File</label>
        <div class="input-group">
          @if(\Illuminate\Support\Str::startsWith($file->mime_type, 'image'))
            <img src="{{ $file->url }}" alt="{{ $file->name }}" class="rounded me-2" width="60" height="60">
          @else
            <i class="ti ti-file-text ti-md me-2"></i> {{ $file->mime_type }}
          @endif
        </div>
      </div>

      <!-- Upload New File -->
      <div class="col-md-6 mt-3">
        <label class="form-label" for="file-upload">Upload New File</label>
        <input type="file" id="file-upload" name="file" class="form-control" />
        <div class="form-text">Leave empty to keep current file</div>
      </div>

      <!-- MIME Type (optional, read-only) -->
      <div class="col-md-6 mt-3">
        <label class="form-label" for="file-type">MIME Type</label>
        <input type="text" id="file-type" class="form-control" value="{{ $file->mime_type }}" readonly />
      </div>
    </div>

    <div class="pt-6">
      <button type="submit" class="btn btn-primary me-4">Save Changes</button>
      <a href="{{ route('admin.files.index') }}" class="btn btn-label-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
