<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromoCodeController extends Controller
{
    /**
     * Liste des codes promo
     */
    public function index(Request $request)
    {
        $search = $request->input('search_query', '');

        $query = PromoCode::query();

        if ($search) {
            $query->where('code', 'like', "%{$search}%")->orWhere('owner_name', 'like', "%{$search}%");
        }
        
        $codes = $query->latest()->paginate(10);

        return view('admin.codes.index', compact('codes'));
    }

    /**
     * Formulaire de création d’un code promo
     */
    public function create()
    {
        return view('admin.codes.create');
    }

    /**
     * Formulaire de modification d’un code promo
     */
    public function edit(PromoCode $promo_code)
    {
        return view('admin.codes.edit', ['code' => $promo_code]);
    }

    /**
     * Enregistrement d’un nouveau code promo
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'nullable|string|min:6|max:10|unique:promo_codes,code',
            'owner_name' => 'nullable|string|max:255',
            'owner_phone' => 'nullable|string|max:20',
            'discount' => 'nullable|numeric|min:0|max:10000',
        ]);

        // Si aucun code n'est fourni, on le génère automatiquement
        $code = $request->input('code');
        if (empty($code)) {
            $ownerName = $request->input('owner_name', '');
            $initials = $this->generateInitials($ownerName);
            $random = strtoupper(Str::random(max(1, 8 - strlen($initials))));
            $code = strtoupper($initials . $random);
        }

        PromoCode::create([
            'code' => $code,
            'owner_name' => $request->input('owner_name'),
            'owner_phone' => $request->input('owner_phone'),
            'discount' => $request->input('discount') ?? 0.8,
        ]);

        return redirect()->route('admin.codes.index')
            ->with('success', 'Code promo créé avec succès.');
    }

    public function update(Request $request, PromoCode $promo_code)
    {
        // 1️⃣ Validation des données
        $validated = $request->validate([
            'code' => 'nullable|string|max:8|unique:promo_codes,code,' . $promo_code->id,
            'owner_name' => 'nullable|string|max:100',
            'owner_phone' => 'nullable|string|max:20',
            'discount' => 'nullable|numeric|min:0',
        ], [
            'code.unique' => 'Ce code promo existe déjà.',
            'discount.numeric' => 'La réduction doit être un nombre.',
        ]);


        // 3️⃣ Génération automatique du code si vide
        if (empty($code)) {
            $ownerName = $request->input('owner_name', '');
            $initials = $this->generateInitials($ownerName);
            $random = strtoupper(Str::random(max(1, 8 - strlen($initials))));
            $code = strtoupper($initials . $random);
        }

        $validated['code'] = $code;


        // 4️⃣ Mise à jour des données
        $promo_code->update($validated);

        // 5️⃣ Redirection avec message
        return redirect()
            ->route('admin.codes.index')
            ->with('success', 'Code promo mis à jour avec succès.');
    }


    /**
     * Supprimer un code promo
     */
    public function destroy(PromoCode $code)
    {
        $code->delete();
        return back()->with('success', 'Code promo supprimé avec succès.');
    }

    /**
     * Génère les initiales d’un nom
     */
    private function generateInitials($name)
    {
        if (empty($name)) {
            return '';
        }

        // Supprime les espaces multiples, convertit en majuscules et découpe le nom
        $parts = preg_split('/\s+/', trim($name));
        $initials = '';

        foreach ($parts as $part) {
            $initials .= mb_substr($part, 0, 1);
        }

        return strtoupper($initials);
    }
}
