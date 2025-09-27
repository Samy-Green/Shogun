<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\PromoPeriod;
use Illuminate\Http\Request;
use Termwind\Components\Raw;

class SiteController extends Controller
{
    // Page d’accueil
    public function index()
    {
        $carousels = \App\Models\Carousel::all();

        $categories = \App\Models\Category::where('is_primary', true)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $lastProducts = Product::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
        

        $lastDealsProducts = Product::where('is_active', true)
            ->where('deal', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
        
        $lastPromoProducts = Product::where('is_active', true)
            ->where('discount', '>', -1)
            ->orderBy('created_at', 'desc')
            ->take(9)
            ->get();
        
        $comingProducts = Product::where('is_active', true)
            ->where('is_coming', true)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        $latestActivePromo = PromoPeriod::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('end_date', 'desc')
            ->first();
        
        

        return view('client.index', compact('carousels', 'lastProducts', 'lastPromoProducts', 'comingProducts', 'categories', 'latestActivePromo', 'lastDealsProducts'));
    }

    // Shop
    public function categories(Request $request)
    {
      $lastPromoProducts = Product::where('is_active', true)
        ->where('discount', '>', -1)
				->orderBy('created_at', 'desc')
        ->take(9)
        ->get();
			
			$categories = Category::where('parent_id', null)
					->orderBy('name', 'asc')
					->get();

			$category = $request->query('category', 0); // valeur par défaut 0



			if ($category) {
				$products = Product::where('is_active', true)
					->whereHas('categories', function ($query) use ($category) {
						$query->where('id', $category);
					})
					->orderBy('created_at', 'desc')
					->paginate(6);
			}
			else{
				$products = Product::where('is_active', true)
					->orderBy('created_at', 'desc')
					->paginate(1);
			}

			$totalProducts = Product::where('is_active', true)->count();

      return view('client.categories', compact('lastPromoProducts', 'categories', 'products', 'totalProducts'));
    }

    // Shop
    public function category()
    {
        return view('client.category');
    }

    public function singleProduct()
    {
        return view('client.single-product');
    }

    public function checkout()
    {
        return view('client.checkout');
    }

    public function cart()
    {
        return view('client.cart');
    }

    public function confirmation()
    {
        return view('client.confirmation');
    }

    // Blog
    public function blog()
    {
        return view('client.blog');
    }

    public function singleBlog()
    {
        return view('client.single-blog');
    }

    // Pages
    public function login()
    {
        return view('client.login');
    }

    public function tracking()
    {
        return view('client.tracking');
    }

    public function elements()
    {
        return view('client.elements');
    }

    // Contact
    public function contact()
    {
        return view('client.contact');
    }
}
