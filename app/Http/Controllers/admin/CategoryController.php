<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    // Liste toutes les catégories
    public function index()
    {
        // 10 catégories par page
        $categories = Category::with('parent')->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    // Affiche le formulaire d'édition
    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    // Affiche le formulaire de création
    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        $files = File::all();
        return view('admin.categories.create', compact('categories', 'files'));
    }

    // Affiche le formulaire d'édition
    public function edit(Category $category)
    {
        $categories = Category::whereNull('parent_id')->where('id', '!=', $category->id)->get();
        $files = File::all();

        return view('admin.categories.edit', compact('category', 'categories', 'files'));
    }

    // store
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:categories,code',
            'name' => 'required|string|max:255',
            'image_id' => 'nullable|exists:files,id',
            'image_url' => 'nullable|string|max:2048',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $data = $request->only(['code','name', 'parent_id', 'icon', 'color', 'description']);
        $data['is_primary'] = !!$request->input('is_primary', false);

        // Déterminer l'image
        if ($request->filled('image_id')) {
            $file = \App\Models\File::find($request->input('image_id'));
            $data['image'] = $file->path;
        } elseif ($request->filled('image_url')) {
            $data['image'] = $request->input('image_url');
        }

        \App\Models\Category::create($data);

        return redirect()->back()->with('success', 'Catégorie ajoutée avec succès.');
    }

    // update
    public function update(Request $request, \App\Models\Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:categories,code,' . $category->id,
            'image_id' => 'nullable|exists:files,id',
            'image_url' => 'nullable|string|max:2048',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_primary' => 'nullable|boolean',

        ]);

        $data = $request->only(['name', 'parent_id', 'icon', 'color', 'description', 'code', 'is_primary']);
        $data['is_primary'] = !!$request->input('is_primary', false);

        // Déterminer l'image
        if ($request->filled('image_id')) {
            $file = \App\Models\File::find($request->input('image_id'));
            $data['image'] = $file->path;
        } elseif ($request->filled('image_url')) {
            $data['image'] = $request->input('image_url');
        }

        $category->update($data);

        return redirect()->back()->with('success', 'Catégorie mise à jour avec succès.');
    }

    // Supprime une catégorie
    public function destroy(Category $category)
    {

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée avec succès.');
    }
}
