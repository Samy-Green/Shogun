<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\File;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel; // si tu as installé maatwebsite/excel
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Affiche la liste des produits.
     */
    public function index()
    {
        $query_search = request()->input('search_query', '');
        $query = Product::with('mainCategory');

        $old_search['search_query'] = $query_search;

        if($query_search) {
            $query->where('name', 'like', "%{$query_search}%")
            ->orWhere('code', 'like', "%{$query_search}%")
            ->orWhere('description', 'like', "%{$query_search}%")
            ->orWhereHas('categories', function($q) use ($query_search) {
                $q->where('name', 'like', "%{$query_search}%")
                ->orWhere('code', 'like', "%{$query_search}%");
            });
        }
        
        $products =  $query->paginate(10);

        return view('admin.products.index', compact('products', 'old_search'));
    }

    /**
     * Affiche les détails d’un produit.
     */
    public function show(Product $product)
    {
        $product->load(['mainCategory', 'categories', 'files']);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create()
    {
        $categories = Category::all();
        $files = File::all();
        return view('admin.products.create', compact('categories', 'files'));
    }

    /**
     * Stocke un nouveau produit.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:20|unique:products,code',
            'name' => 'required|string|max:255',
            'full_name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'main_category_id' => 'nullable|exists:categories,id',
            'available' => 'nullable|boolean',
            'discount' => 'nullable|numeric|min:0|max:100',
            'discount_end_date' => 'nullable|date',
            'deal' => 'nullable|numeric|min:0|max:100',
            'luxury' => 'nullable|boolean',
            'image_id' => 'nullable|exists:files,id',
            'image_url' => 'nullable|string|max:2048',
            'weight' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|max:50',
            'promo_message' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'is_coming' => 'nullable|boolean',
            'purchase_price' => 'nullable|numeric|min:0',
            'long_description' => 'nullable|string',
        ]);

        $data = $request->only([
            'code', 'name', 'full_name', 'description', 'price', 'quantity',
            'main_category_id', 'available', 'discount', 'discount_end_date',
            'deal', 'luxury', 'weight', 'status', 'promo_message',
            'is_active', 'is_coming', 'purchase_price', 'long_description'
        ]);

        // Déterminer l'image
        if ($request->filled('image_id')) {
            $file = File::find($request->input('image_id'));
            $data['image'] = $file->path;
        } elseif ($request->filled('image_url')) {
            $data['image'] = $request->input('image_url');
        }

        $product = Product::create($data);

        // Associer plusieurs catégories (optionnel)
        if ($request->has('categories')) {
            $product->categories()->sync($request->input('categories'));
        }

        return redirect()->route('admin.products.index')->with('success', 'Produit ajouté avec succès.');
    }

    /**
     * Affiche le formulaire d’édition d’un produit.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $files = File::all();
        $product->load('categories');

        return view('admin.products.edit', compact('product', 'categories', 'files'));
    }

    /**
     * Met à jour un produit existant.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'code' => 'required|string|max:20|unique:products,code,' . $product->id,
            'name' => 'required|string|max:255',
            'full_name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'main_category_id' => 'nullable|exists:categories,id',
            'available' => 'nullable|boolean',
            'discount' => 'nullable|numeric|min:0|max:100',
            'discount_end_date' => 'nullable|date',
            'deal' => 'nullable|numeric|min:0|max:100',
            'luxury' => 'nullable|boolean',
            'image_id' => 'nullable|exists:files,id',
            'image_url' => 'nullable|string|max:2048',
            'weight' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|max:50',
            'promo_message' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'is_coming' => 'nullable|boolean',
            'purchase_price' => 'nullable|numeric|min:0',
            'long_description' => 'nullable|string',
        ]);

        $data = $request->only([
            'code', 'name', 'full_name', 'description', 'price', 'quantity',
            'main_category_id', 'available', 'discount', 'discount_end_date',
            'deal', 'luxury', 'weight', 'status', 'promo_message',
            'is_active', 'is_coming', 'purchase_price', 'long_description'
        ]);

        // Déterminer l'image
        if ($request->filled('image_id')) {
            $file = File::find($request->input('image_id'));
            $data['image'] = $file->path;
        } elseif ($request->filled('image_url')) {
            $data['image'] = $request->input('image_url');
        }

        $product->update($data);

        // Synchroniser les catégories (si présentes)
        if ($request->has('categories')) {
            $product->categories()->sync($request->input('categories'));
        }

        return redirect()->back()->with('success', 'Produit mis à jour avec succès.');
    }

    /**
     * Supprime un produit.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produit supprimé avec succès.');
    }
    
    
    //////////////////////////////////////


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xls,xlsx|max:5120', // 5 MB
        ]);

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());

        // Lire les lignes en tableau associatif [header => value]
        $rows = [];
        try {
            if (in_array($extension, ['xls', 'xlsx'])) {
                // Excel -> toArray renvoie tableau de sheets => on prend la première feuille
                $sheets = Excel::toArray(null, $file);
                $sheet = $sheets[0] ?? [];
                if (count($sheet) < 1) {
                    return back()->with('import_error', 'Fichier Excel vide ou mal formaté.');
                }
                // Transformer : première ligne header
                $header = array_map(function($h){ return (string)$h; }, $sheet[0]);
                for ($i = 1; $i < count($sheet); $i++) {
                    if (empty(array_filter($sheet[$i], fn($c) => $c !== null && $c !== ''))) continue;
                    $rows[] = array_combine($header, $sheet[$i]);
                }
            } else {
                // CSV
                $handle = fopen($file->getRealPath(), 'r');
                if ($handle === false) {
                    return back()->with('import_error', 'Impossible d\'ouvrir le fichier CSV.');
                }
                $header = null;
                while (($line = fgetcsv($handle, 0, ',')) !== false) {
                    // skip empty lines
                    if ($header === null) {
                        $header = $line;
                        continue;
                    }
                    // ignore empty rows
                    if (count(array_filter($line, fn($c) => $c !== null && $c !== '')) === 0) continue;
                    // si row length diffère de header, on complète ou tronque
                    if (count($line) < count($header)) {
                        $line = array_pad($line, count($header), null);
                    } elseif (count($line) > count($header)) {
                        $line = array_slice($line, 0, count($header));
                    }
                    $rows[] = array_combine($header, $line);
                }
                fclose($handle);
            }
        } catch (\Exception $e) {
            return back()->with('import_error', 'Erreur lecture fichier : ' . $e->getMessage());
        }

        if (empty($rows)) {
            return back()->with('import_error', 'Aucune ligne de données trouvée dans le fichier.');
        }

        // règles de validation (mêmes que ton store())
        $rules = [
            'code' => ['required','string','max:20', Rule::unique('products','code')],
            'name' => 'required|string|max:255',
            'full_name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'main_category_id' => 'nullable|exists:categories,id',
            'available' => 'nullable|boolean',
            'discount' => 'nullable|numeric|min:0|max:100',
            'discount_end_date' => 'nullable|date',
            'deal' => 'nullable|numeric|min:0|max:100',
            'luxury' => 'nullable|boolean',
            'image_id' => 'nullable|exists:files,id',
            'image_url' => 'nullable|string|max:2048',
            'weight' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|max:50',
            'promo_message' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'is_coming' => 'nullable|boolean',
            'purchase_price' => 'nullable|numeric|min:0',
            'long_description' => 'nullable|string',
            'categories' => 'nullable|string', // colonne free-text : ids ou names séparés par , ou ;
        ];

        $messages = [
            'code.required' => 'Le champ code est obligatoire.',
            'code.unique' => 'Le code existe déjà en base.',
            'name.required' => 'Le nom est obligatoire.',
            'price.required' => 'Le prix est obligatoire.',
            'main_category_id.exists' => 'La catégorie principale est invalide.',
            'image_id.exists' => 'L\'ID de fichier (image_id) est invalide.',
            // tu peux ajouter d'autres messages personnalisés si besoin
        ];

        $errors = [];
        $imported = 0;
        $seenCodesInFile = [];

        foreach ($rows as $index => $rawRow) {
            $rowNumber = $index + 2; // +2 : header + base 1
            // 1) Normaliser les clés d'en-tête en snake_case attendu
            $row = [];
            foreach ($rawRow as $k => $v) {
                $field = $this->normalizeHeader((string)$k);
                $row[$field] = $v === '' ? null : $v; // empty string => null
            }
            
            // 2) Pré-traitements : booleans, dates, trim
            foreach (['available','luxury','is_active','is_coming'] as $b) {
                if (array_key_exists($b, $row) && !is_null($row[$b])) {
                    $row[$b] = $this->toBoolean($row[$b]);
                }
            }
            
            // discount_end_date -> try parse
            if (!empty($row['discount_end_date'])) {
                try {
                    $d = Carbon::parse($row['discount_end_date']);
                    $row['discount_end_date'] = $d->format('Y-m-d');
                } catch (\Exception $e) {
                    // laisser la valeur brute pour validation (échouera)
                }
            }
            
            // categories sera traité après création
            $categoriesRaw = $row['categories'] ?? null;
            
            // 3) Vérifier doublon dans le fichier
            $codeVal = $row['code'] ?? null;
            if (empty($codeVal)) {
                $errors[$rowNumber][] = 'Code manquant.';
                continue;
            }
            $codeVal = trim((string)$codeVal);
            if (in_array(strtoupper($codeVal), $seenCodesInFile, true)) {
                $errors[$rowNumber][] = "Code '{$codeVal}' dupliqué dans le fichier.";
                continue;
            }
            $seenCodesInFile[] = strtoupper($codeVal);
            
            // 4) Valider la ligne
            $validator = Validator::make($row, $rules, $messages);
            if ($validator->fails()) {
                $errors[$rowNumber] = $validator->errors()->all();
                continue;
            }

            // 5) Vérifier existence code en base (sécurité supplémentaire)
            if (Product::where('code', $row['code'])->exists()) {
                $errors[$rowNumber][] = "Le code '{$row['code']}' existe déjà en base.";
                continue;
            }

            // 6) Préparer données pour insertion
            $data = [
                'code' => $row['code'],
                'name' => $row['name'],
                'full_name' => $row['full_name'] ?? null,
                'description' => $row['description'] ?? null,
                'price' => $row['price'],
                'quantity' => isset($row['quantity']) ? (int)$row['quantity'] : 0,
                'main_category_id' => $row['main_category_id'] ?? null,
                'available' => $row['available'] ?? 0,
                'discount' => $row['discount'] ?? 0,
                'discount_end_date' => $row['discount_end_date'] ?? null,
                'deal' => $row['deal'] ?? 0,
                'luxury' => $row['luxury'] ?? 0,
                'weight' => $row['weight'] ?? null,
                'status' => $row['status'] ?? null,
                'promo_message' => $row['promo_message'] ?? null,
                'is_active' => $row['is_active'] ?? 0,
                'is_coming' => $row['is_coming'] ?? 0,
                'purchase_price' => $row['purchase_price'] ?? null,
                'long_description' => $row['long_description'] ?? null,
            ];

            // gérer image
            if (!empty($row['image_id'])) {
                $fileRec = File::find($row['image_id']);
                if ($fileRec) {
                    $data['image'] = $fileRec->path;
                } else {
                    // en théorie validateur a vérifié image_id.exists
                    $data['image'] = null;
                }
            } elseif (!empty($row['image_url'])) {
                $data['image'] = $row['image_url'];
            }

            // 7) Créer le produit (dans transaction pour sécurité optionnelle)
            try {
                DB::beginTransaction();
                $product = Product::create($data);

                // 8) gérer categories (colonne 'categories')
                if (!empty($categoriesRaw)) {
                    $catIds = $this->parseCategories($categoriesRaw);
                    if (!empty($catIds)) {
                        $product->categories()->sync($catIds);
                    }
                }

                DB::commit();
                $imported++;
            } catch (\Exception $e) {
                DB::rollBack();
                // log si nécessaire
                $errors[$rowNumber][] = 'Erreur création produit: ' . $e->getMessage();
            }
        } // foreach rows

        // Préparer message de retour
        $msg = "{$imported} produit(s) importé(s).";
        if (!empty($errors)) {
            // on renvoie les 10 premières erreurs dans la session et un résumé
            $summary = [];
            foreach ($errors as $line => $errs) {
                $summary[] = "Ligne {$line} : " . implode(' ; ', $errs);
            }
            // stocker en session (string) — tu peux aussi stocker en fichier pour téléchargement
            return redirect()->back()
                ->with('import_success', $msg)
                ->with('import_errors', $summary);
        }

        return redirect()->back()->with('import_success', $msg);
    }

    /**
     * Normalise un header (ex: "Image URL" -> "image_url")
     */
    private function normalizeHeader(string $header): string
    {
        $h = trim(mb_strtolower($header));
        // remplace espaces et séparateurs par underscore
        $h = str_replace([' ', '/', '\\', '-', '.', ';', ':'], '_', $h);
        // garde lettres, chiffres et underscores
        $h = preg_replace('/[^a-z0-9_]/', '', $h);

        // mapping d'alias courants vers noms de champs
        $map = [
            'imageurl' => 'image_url',
            'image_url' => 'image_url',
            'imageid' => 'image_id',
            'image_id' => 'image_id',
            'fullname' => 'full_name',
            'full_name' => 'full_name',
            'purchaseprice' => 'purchase_price',
            'purchase_price' => 'purchase_price',
            'discountenddate' => 'discount_end_date',
            'discount_end_date' => 'discount_end_date',
            'promo_message' => 'promo_message',
            'promomessage' => 'promo_message',
            'isactive' => 'is_active',
            'is_active' => 'is_active',
            'iscoming' => 'is_coming',
            'is_coming' => 'is_coming',
            'maincategoryid' => 'main_category_id',
            'main_category_id' => 'main_category_id',
            'categories' => 'categories',
        ];

        $hKey = str_replace('_', '', $h); // pour chercher map moins strict
        foreach ($map as $k => $v) {
            if ($h === $k || str_replace('_','',$h) === $k) {
                return $v;
            }
        }

        return $h;
    }

    /**
     * Convertit diverses valeurs texte en boolean (1/0)
     */
    private function toBoolean($value)
    {
        if (is_null($value)) return null;
        if (is_bool($value)) return $value ? 1 : 0;
        $v = mb_strtolower(trim((string)$value));
        if (in_array($v, ['1','true','yes','y','oui','o'], true)) return 1;
        if (in_array($v, ['0','false','no','n','non'], true)) return 0;
        return null;
    }

    /**
     * Parse la colonne categories (ex: "1,2,3" or "Parfums;Homme") -> retourne array d'ids existants
     */
    private function parseCategories(string $raw): array
    {
        $items = preg_split('/[,;|]+/', $raw);
        $ids = [];
        foreach ($items as $it) {
            $it = trim($it);
            if ($it === '') continue;
            // si numérique on prend id
            if (ctype_digit($it)) {
                if ($cat = Category::find((int)$it)) {
                    $ids[] = $cat->id;
                }
                continue;
            }
            // sinon on cherche par code ou nom (case-insensitive)
            $cat = Category::where('code', $it)
                    ->orWhereRaw('LOWER(name) = ?', [mb_strtolower($it)])
                    ->first();
            if ($cat) $ids[] = $cat->id;
        }
        return array_unique($ids);
    }

}
