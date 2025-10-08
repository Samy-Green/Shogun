<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Liste tous les fichiers.
     */
    public function index()
    {
        $files = File::latest()->paginate(10);
        return view('admin.files.index', compact('files'));
    }

    /**
     * Formulaire de création d’un fichier.
     */
    public function create()
    {
        return view('admin.files.create');
    }

    /**
     * Enregistre un nouveau fichier.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // max 10 Mo
        ], [
            'file.required' => 'Veuillez sélectionner un fichier à télécharger.',
            'file.file' => 'Le fichier doit être valide.',
            'file.max' => 'La taille maximale du fichier est de 10 Mo.',
        ]);

        $uploadedFile = $request->file('file');
        $path = $uploadedFile->store('uploads/files', 'public');

        File::create([
            'name' => $uploadedFile->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $uploadedFile->getClientMimeType(),
            'size' => $uploadedFile->getSize(),
        ]);

        return redirect()->route('admin.files.index')->with('success', 'Fichier ajouté avec succès.');
    }

    /**
     * Affiche un fichier spécifique.
     */
    public function show(File $file)
    {
        return view('admin.files.show', compact('file'));
    }

    /**
     * Formulaire d’édition d’un fichier.
     */
    public function edit(File $file)
    {
        return view('admin.files.edit', compact('file'));
    }

    /**
     * Met à jour les informations d’un fichier.
     */
    public function update(Request $request, File $file)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $file->update([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('admin.files.index')->with('success', 'Fichier mis à jour avec succès.');
    }

    /**
     * Supprime un fichier.
     */
    public function destroy(File $file)
    {
        // Supprimer le fichier physique s’il existe
        if (Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
        }

        $file->delete();

        return redirect()->route('admin.files.index')->with('success', 'Fichier supprimé avec succès.');
    }
}
