<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ReductionController extends Controller
{
    public function index()
    {
        $products = Product::where('discount', '>', 0)->orWhere("deal", '>', 0)->paginate(10); // Récupérez les produits avec leurs réductions depuis la base de données
        return view('admin.discounts.index', compact('products'));
    }
}
