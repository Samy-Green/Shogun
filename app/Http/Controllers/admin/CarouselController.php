<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Carousel;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class CarouselController extends Controller
{
    /**
     * Afficher la liste des carousels
     */
    public function index()
    {
        $carousels = Carousel::paginate(10);
        return view('admin.carousels.index', compact('carousels'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $files = File::all();
        return view('admin.carousels.create', compact('files'));
    }

    /**
     * Enregistrer un nouveau carousel
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'button_icon' => 'nullable|string|max:50',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|string|max:255',
            'image_id' => 'nullable|integer|exists:files,id',
            'image_url' => 'nullable|string|max:255',
        ]);

        $data = $request->only([
            'title',
            'description',
            'button_icon',
            'button_text',
            'button_link',
        ]);


        // Gestion de l'image
        // Déterminer l'image
        if ($request->filled('image_id')) {
            $file = File::find($request->input('image_id'));
            $data['image'] = $file->path;
        } elseif ($request->filled('image_url')) {
            $data['image'] = $request->input('image_url');
        }
        else {
            $data['image'] = null;
        }

        Carousel::create($data);

        return redirect()->route('admin.carousels.index')->with('success', 'Carousel créé avec succès.');
    }

    /**
     * Afficher le formulaire de modification
     */
    public function edit(Carousel $carousel)
    {
        $files = File::all();

        return view('admin.carousels.edit', compact('carousel', 'files'));
    }

    /**
     * Mettre à jour un carousel
     */
    public function update(Request $request, Carousel $carousel)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'button_icon' => 'nullable|string|max:50',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|string|max:255',
            'image_id' => 'nullable|integer|exists:files,id',
            'image_url' => 'nullable|string|max:255',
        ]);
        //dd($carousel, $request->all());
        
        $data = $request->only([
            'title',
            'description',
            'button_icon',
            'button_text',
            'button_link',
        ]);


        // Gestion de l'image
        // Déterminer l'image
        if ($request->filled('image_id')) {
            $file = File::find($request->input('image_id'));
            $data['image'] = $file->path;
        } elseif ($request->filled('image_url')) {
            $data['image'] = $request->input('image_url');
        }
        else {
            $data['image'] = null;
        }

        $carousel->update($data);

        return redirect()->route('admin.carousels.index')->with('success', 'Carousel mis à jour avec succès.');
    }

    /**
     * Supprimer un carousel
     */
    public function destroy(Carousel $carousel)
    {
        $carousel->delete();

        return redirect()->route('admin.carousels.index')->with('success', 'Carousel supprimé avec succès.');
    }
}
