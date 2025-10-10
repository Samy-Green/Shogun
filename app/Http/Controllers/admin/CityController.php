<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Liste des villes
     */
    public function index(Request $request)
    {
        $search = $request->input('search_query', '');

        $query = City::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $cities = $query->latest()->paginate(10);

        return view('admin.cities.index', compact('cities'));
    }

    /**
     * Formulaire de création d'une ville
     */
    public function create()
    {
        return view('admin.cities.create');
    }

    /**
     * Formulaire de modification d'une ville
     */
    public function edit(City $city)
    {
        return view('admin.cities.edit', ['city' => $city]);
    }

    /**
     * Enregistrement d'une nouvelle ville
     */
    public function store(Request $request)
    {
        // 1️⃣ Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cities,name',
            'delivery' => 'nullable|string|max:255',
            'cost' => 'nullable|numeric|min:0',
        ], [
            'name.required' => 'Le nom de la ville est obligatoire.',
            'name.unique' => 'Cette ville existe déjà.',
            'cost.numeric' => 'Le coût doit être un nombre.',
            'cost.min' => 'Le coût doit être supérieur ou égal à 0.',
        ]);

        // 2️⃣ Création de la ville
        City::create($validated);

        // 3️⃣ Redirection
        return redirect()->route('admin.cities.index')
            ->with('success', 'Ville créée avec succès.');
    }

    /**
     * Mise à jour d'une ville existante
     */
    public function update(Request $request, City $city)
    {
        // 1️⃣ Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cities,name,' . $city->id,
            'delivery' => 'nullable|string|max:255',
            'cost' => 'nullable|numeric|min:0',
        ], [
            'name.required' => 'Le nom de la ville est obligatoire.',
            'name.unique' => 'Cette ville existe déjà.',
            'cost.numeric' => 'Le coût doit être un nombre.',
            'cost.min' => 'Le coût doit être supérieur ou égal à 0.',
        ]);

        // 2️⃣ Mise à jour
        $city->update($validated);

        // 3️⃣ Redirection
        return redirect()->route('admin.cities.index')
            ->with('success', 'Ville mise à jour avec succès.');
    }

    /**
     * Supprimer une ville
     */
    public function destroy(City $city)
    {
        // Vérifier s'il y a des quartiers liés avant suppression si nécessaire
        if ($city->neighborhoods()->exists()) {
            return back()->with('error', 'Impossible de supprimer cette ville car elle contient des quartiers.');
        }

        $city->delete();

        return back()->with('success', 'Ville supprimée avec succès.');
    }
}
