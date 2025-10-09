<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ReductionController extends Controller
{
    public function index()
    {
        $query_search = request()->input('search_query', '');
        $old_search['search_query'] = $query_search;

        $query = Product::with('mainCategory')
            ->where(function ($q) {
                $q->where('discount', '>', 0)
                  ->orWhere('deal', '>', 0);
            }); // Récupère les produits avec réduction ou deal

        // 🔍 Filtrage par mot-clé
        if ($query_search) {
            $query->where(function ($q) use ($query_search) {
                $q->where('name', 'like', "%{$query_search}%")
                  ->orWhere('code', 'like', "%{$query_search}%")
                  ->orWhere('description', 'like', "%{$query_search}%")
                  ->orWhereHas('categories', function ($q2) use ($query_search) {
                      $q2->where('name', 'like', "%{$query_search}%")
                         ->orWhere('code', 'like', "%{$query_search}%");
                  });
            });
        }

        $products = $query->paginate(10);

        return view('admin.discounts.index', compact('products', 'old_search'));
    }
}
