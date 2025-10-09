<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    /**
     * Liste tous les fichiers.
     */
    public function index()
    {
        // $files = File::latest()->paginate(10);
        $query_search = request()->input('search_query', '');
        $query = File::query();
        
        $old_search['search_query'] = $query_search;

        if($query_search) {
            $query->where('name', 'like', "%{$query_search}%")
            ->orWhere('mime_type', 'like', "%{$query_search}%")
            ->orWhere('path', 'like', "%{$query_search}%");
        }
        
        $files =  $query->paginate(10);
        return view('admin.files.index', compact('files', 'old_search'));
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

        // Stocker dans le répertoire 'files' sur le disque 'public'
        $filename = time() . '_' . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
        $storedPath = $uploadedFile->storeAs('files', $filename, 'public');

        File::create([
            'name' => $request->input('name') ?: $uploadedFile->getClientOriginalName(),
            'path' => 'storage/' . $storedPath,
            'mime_type' => $uploadedFile->getMimeType(),
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
            'file' => 'nullable|file|max:10240', // max 10MB
        ]);

        // Mettre à jour le nom
        $file->name = $request->input('name');

        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');

            // Supprimer l'ancien fichier
            if (Storage::disk('public')->exists($file->path)) {
                Storage::disk('public')->delete($file->path);
            }

            // Générer un nouveau nom de fichier unique
            $filename = time() . '_' . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
            $path = $uploadedFile->storeAs('files', $filename, 'public');

            // Mettre à jour le chemin, type MIME et taille
            $file->path = 'storage/' . $path;
            $file->mime_type = $uploadedFile->getMimeType();
            $file->size = $uploadedFile->getSize();
        }

        $file->save();

        return redirect()->route('admin.files.index')->with('success', 'Fichier mis à jour avec succès.');
    }


    /**
     * Supprime un fichier.
     */
    public function destroy(File $file)
    {
        // Supprimer le fichier physique s’il existe
        $relativePath = Str::replaceFirst('storage/', '', $file->path);

        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }

        $file->delete();

        return redirect()->route('admin.files.index')->with('success', 'Fichier supprimé avec succès.');
    }

}
