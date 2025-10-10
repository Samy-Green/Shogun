@extends('layouts/layoutMaster')

@section('title', 'Créer un produit')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
])
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/41.4.2/ckeditor.css">
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
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#long_description'), {
            toolbar: [
                'heading', '|',
                'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', '|',
                'alignment', 'indent', 'outdent', '|',
                'bulletedList', 'numberedList', 'todoList', 'blockQuote', '|',
                'link', 'insertTable', 'mediaEmbed', 'codeBlock', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                'undo', 'redo'
            ],
            table: {
                contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
            },
            lineHeight: {
                options: ['1', '1.2', '1.5', '2', '2.5', '3']
            }
            })
        .catch(error => console.error(error));
</script>
<style>
    .ck-editor__editable_inline {
        min-height: 400px; /* hauteur plus grande pour l'éditeur */
    }
</style>
@endsection

@section('content')

<div class="d-flex justify-content-between">
  <h4 class="py-3">
    <span class="text-muted fw-light">
      <a class="text-muted fw-light" href="{{ route('admin.index') }}">Accueil</a> /
      <a class="text-muted fw-light" href="{{ route('admin.products.index') }}">Produits</a> /
    </span>
    Nouveau produit
  </h4>
</div>

<div class="card mb-6">
    <h5 class="card-header">Créer un produit</h5>
    <form action="{{ route('admin.products.store') }}" method="POST" class="card-body" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="code">Code</label>
                <input type="text" name="code" class="form-control" value="{{ old('code') }}" required>
            </div>

            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="name">Nom</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="full_name">Nom complet</label>
                <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}">
            </div>

            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="main_category_id">Catégorie principale</label>
                <select name="main_category_id" class="select2 form-select">
                    <option value="">Aucun</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('main_category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="price">Prix (FCFA)</label>
                <input type="number" name="price" step="0.01" class="form-control" value="{{ old('price') }}" required>
            </div>

            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="quantity">Quantité</label>
                <input type="number" name="quantity" class="form-control" value="{{ old('quantity') }}">
            </div>

            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="discount">Remise</label>
                <input type="number" name="discount" class="form-control" value="{{ old('discount') }}">
            </div>

            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="discount_end_date">Fin remise</label>
                <input type="date" name="discount_end_date" class="form-control" value="{{ old('discount_end_date') }}">
            </div>

            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="deal">Affaire</label>
                <input type="number" name="deal" class="form-control" value="{{ old('deal') }}">
            </div>

            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="weight">Poids</label>
                <input type="number" name="weight" step="0.01" class="form-control" value="{{ old('weight') }}">
            </div>

            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="purchase_price">Prix d'achat</label>
                <input type="number" name="purchase_price" step="0.01" class="form-control" value="{{ old('purchase_price') }}">
            </div>

            <div class="col-sm-6 col-md-3">
                <label class="form-label" for="promo_message">Message promo</label>
                <input type="text" name="promo_message" class="form-control" value="{{ old('promo_message') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label" for="image_id">Image</label>
                <select name="image_id" class="select2 form-select">
                    <option value="">Aucun</option>
                    @foreach($files as $file)
                        <option value="{{ $file->id }}" {{ old('image_id') == $file->id ? 'selected' : '' }}>
                            {{ $file->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label" for="image_url">Chemin image</label>
                <input type="text" name="image_url" class="form-control" value="{{ old('image_url') }}">
            </div>

            <div class="col-sm-6 col-md-3">
                <label class="form-label">Disponible</label><br>
                <input type="checkbox" name="available" value="1" {{ old('available') ? 'checked' : '' }}>
            </div>

            <div class="col-sm-6 col-md-3">
                <label class="form-label">Luxe</label><br>
                <input type="checkbox" name="luxury" value="1" {{ old('luxury') ? 'checked' : '' }}>
            </div>

            <div class="col-sm-6 col-md-3">
                <label class="form-label">Actif</label><br>
                <input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
            </div>

            <div class="col-sm-6 col-md-3">
                <label class="form-label">À venir</label><br>
                <input type="checkbox" name="is_coming" value="1" {{ old('is_coming') ? 'checked' : '' }}>
            </div>

            <div class="col-12">
                <label class="form-label" for="description">Description courte</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
            </div>

            <div class="col-12 mt-3">
                <label class="form-label" for="long_description">Description longue</label>
                <textarea id="long_description" name="long_description">{{ old('long_description') }}</textarea>
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="btn btn-primary me-2">Créer</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection
