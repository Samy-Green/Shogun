<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
}
