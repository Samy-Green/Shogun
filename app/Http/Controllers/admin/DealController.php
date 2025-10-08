<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use App\Models\PromoPeriod;

class DealController extends Controller
{
    /**
     * Affiche la liste des périodes promotionnelles.
     */
    public function index()
    {
        $deals = PromoPeriod::orderBy('start_date', 'desc')->paginate(10);
        return view('admin.deals.index', compact('deals'));
    }

    /**
     * Affiche le formulaire de création d'une nouvelle période.
     */
    public function create()
    {

        $files = File::all();   
        return view('admin.deals.create', compact('files'));
    }

    /**
     * Enregistre une nouvelle période promotionnelle.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'description'=> 'nullable|string',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'is_active'  => 'nullable|boolean',
            'image_url' => 'nullable|string|max:255',
            'image_id' => 'nullable|integer|exists:files,id',
        ]);

                // Gestion de l'image
        // Déterminer l'image
        if ($request->filled('image_id')) {
            $file = File::find($request->input('image_id'));
            $image = $file->path;
        } elseif ($request->filled('image_url')) {
            $image = $request->input('image_url');
        }
        else {
            $image = null;
        }


        PromoPeriod::create([
            'name'        => $request->name,
            'description' => $request->description,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'is_active'   => $request->has('is_active'),
            'image'      => $image,
        ]);

        return redirect()->route('admin.deals.index')
            ->with('success', 'Période promotionnelle créée avec succès.');
    }

    /**
     * Affiche le formulaire d'édition pour une période existante.
     */
    public function edit(PromoPeriod $deal)
    {
        $files = File::all();  
        return view('admin.deals.edit', compact('deal', 'files'));
    }

    /**
     * Met à jour une période promotionnelle existante.
     */
    public function update(Request $request, PromoPeriod $deal)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'description'=> 'nullable|string',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'is_active'  => 'nullable|boolean',
            'image_url' => 'nullable|string|max:255',
            'image_id' => 'nullable|integer|exists:files,id',
        ]);

        // Gestion de l'image
        // Déterminer l'image
        if ($request->filled('image_id')) {
            $file = File::find($request->input('image_id'));
            $image = $file->path;
        } elseif ($request->filled('image_url')) {
            $image = $request->input('image_url');
        }
        else {
            $image = null;
        }

        $deal->update([
            'name'        => $request->name,
            'description' => $request->description,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'is_active'   => $request->has('is_active'),
            'image'      => $image,
        ]);

        return redirect()->route('admin.deals.index')
            ->with('success', 'Période promotionnelle mise à jour avec succès.');
    }

    /**
     * Supprime une période promotionnelle.
     */
    public function destroy(PromoPeriod $deal)
    {
        $deal->delete();

        return redirect()->route('admin.deals.index')
            ->with('success', 'Période promotionnelle supprimée avec succès.');
    }
}
