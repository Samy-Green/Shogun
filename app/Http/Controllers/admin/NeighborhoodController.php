<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Neighborhood;
use App\Models\City;
use Illuminate\Http\Request;

class NeighborhoodController extends Controller
{
    /**
     * Liste des quartiers
     */
    public function index(Request $request)
    {
        $search = $request->input('search_query', '');
        $query = Neighborhood::with('city');

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhereHas('city', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $neighborhoods = $query->latest()->paginate(10);

        return view('admin.neighborhoods.index', compact('neighborhoods'));
    }

    /**
     * Formulaire de création d’un quartier
     */
    public function create()
    {
        $cities = City::all();
        return view('admin.neighborhoods.create', compact('cities'));
    }

    /**
     * Formulaire de modification d’un quartier
     */
    public function edit(Neighborhood $neighborhood)
    {
        $cities = City::all();
        return view('admin.neighborhoods.edit', [
            'neighborhood' => $neighborhood,
            'cities' => $cities
        ]);
    }

    /**
     * Enregistrement d’un nouveau quartier
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'city_id' => 'required|exists:cities,id',
        ], [
            'name.required' => 'Le nom du quartier est obligatoire.',
            'cost.required' => 'Le coût de livraison est obligatoire.',
            'city_id.required' => 'La ville est obligatoire.',
            'city_id.exists' => 'La ville sélectionnée n\'existe pas.',
        ]);

        Neighborhood::create($validated);

        return redirect()->route('admin.neighborhoods.index')
            ->with('success', 'Quartier créé avec succès.');
    }

    /**
     * Mise à jour d’un quartier existant
     */
    public function update(Request $request, Neighborhood $neighborhood)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'city_id' => 'required|exists:cities,id',
        ], [
            'name.required' => 'Le nom du quartier est obligatoire.',
            'cost.required' => 'Le coût de livraison est obligatoire.',
            'city_id.required' => 'La ville est obligatoire.',
            'city_id.exists' => 'La ville sélectionnée n\'existe pas.',
        ]);

        $neighborhood->update($validated);

        return redirect()->route('admin.neighborhoods.index')
            ->with('success', 'Quartier mis à jour avec succès.');
    }

    /**
     * Supprimer un quartier
     */
    public function destroy(Neighborhood $neighborhood)
    {
        $neighborhood->delete();
        return back()->with('success', 'Quartier supprimé avec succès.');
    }
}
