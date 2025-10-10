@extends('layouts/layoutMaster')

@section('title', 'Nouvelle newsletter')

@section('vendor-style')
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/41.4.2/ckeditor.css">
@endsection

@section('vendor-script')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
@endsection

@section('page-script')
<script>
    ClassicEditor
        .create(document.querySelector('#content'), {
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.getElementById('toggleEditor');
    const rich_editor = document.getElementById('rich_editor');
    const basic_editor = document.getElementById('basic_editor');
    const content = document.getElementById('content');
    const content0 = document.getElementById('content0');

    toggle.addEventListener('change', function() {
        if (toggle.checked) {
            rich_editor.classList.add('active_editor');
            basic_editor.classList.remove('active_editor');
        } else {
            rich_editor.classList.remove('active_editor');
            basic_editor.classList.add('active_editor');
        }
    });
});
</script>
<style>
    .ck-editor__editable_inline {
        min-height: 300px;
    }

    .editor{
        display: none;
    }
    .active_editor{
        display: block;
    }
</style>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center">
  <h4 class="py-3">
    <span class="text-muted fw-light">
      <a class="text-muted fw-light" href="{{ route('admin.index') }}">Accueil</a> /
      <a class="text-muted fw-light" href="{{ route('admin.newsletters.index') }}">Newsletters</a> /
    </span>
    Nouvelle newsletter
  </h4>
</div>

<div class="mb-6 card">
    <h5 class="card-header">Envoyer une newsletter</h5>

    <form action="{{ route('admin.newsletters.send') }}" method="POST" class="card-body">
        @csrf

        <div class="row g-3">
            <div class="mt-4 col-12">
                <label class="form-label" for="subject">Sujet de la newsletter</label>
                <input type="text" name="subject" id="subject" class="form-control" placeholder="Titre du mail" value="{{ old('subject') }}" required>
                @error('subject')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mt-4 col-12">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="content">Contenu du message</label>
                    <label style="cursor: pointer">Activer/Désactiver l'éditeur riche &nbsp;<input style="cursor: pointer" name="rich_active" value="1" type="checkbox" id="toggleEditor" checked></label>
                </div>
                <div id="rich_editor" class="editor rich_editor active_editor" style="">
                    <textarea id="content" name="rich_content" class="form-control" rows="8">{{ old('content') }}</textarea>
                </div>
                <div id="basic_editor" class="editor basic_editor" style="; width: 100%;">
                    <textarea id="content0" name="basic_content" class="form-control" rows="8">{{ old('content') }}</textarea>
                </div>
                @error('rich_content')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                @error('basic_content')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mt-4 col-12">
                <label class="form-label" for="recipients">Destinataires spécifiques (optionnel)</label>
                <textarea name="recipients" id="recipients" class="form-control" rows="3" placeholder="Séparer les emails par des virgules (ex : email1@ex.com, email2@ex.com)">{{ old('recipients') }}</textarea>
                <small class="text-muted">Laissez vide pour envoyer à tous les abonnés.</small>
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="btn btn-primary me-2">
                <i class="ti ti-send me-1"></i> Envoyer
            </button>
            <a href="{{ route('admin.newsletters.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection
