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
                $cart = session()->get('cart', []);

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
        
        

        return view('client.index', compact('carousels', 'lastProducts', 'lastPromoProducts', 'comingProducts', 'categories', 'latestActivePromo', 'lastDealsProducts', 'cart'));
    }

    // Shop
    public function categories(Request $request)
    {
                $cart = session()->get('cart', []);

        $lastPromoProducts = Product::where('is_active', true)
        ->where('discount', '>', -1)
				->orderBy('created_at', 'desc')
        ->take(9)
        ->get();
			
			$categories = Category::where('parent_id', null)
				->orderBy('name', 'asc')
				->get();

			$category = $request->query('category', 0); // valeur par défaut 0
			$upper_price = $request->query('upper_price', -1); // valeur par défaut 0
			$lower_price = $request->query('lower_price', -1); // valeur par défaut 0
			$weight = $request->query('weight', ''); // valeur par défaut 0
			$luxury = $request->query('luxury', ''); // valeur par défaut 0

			$old_inputs = [
				'upper_price' => $upper_price,
				'lower_price' => $lower_price,
				'weight' => $weight,
				'luxury' => $luxury,
			];


			if ($category) {
				$query = Product::where('is_active', true)
					->whereHas('categories', function ($query) use ($category) {
						$query->where('id', $category);
					});
			}
			else{
				$query = Product::where('is_active', true);
			}
			if ($upper_price >= 0) {
				$query->where('price', '<=', $upper_price);
			}
			if ($lower_price >= 0) {
				$query->where('price', '>=', $lower_price);
			}
			if ($weight) {
				$query->where('weight', $weight);
			}
			if ($luxury) {
				$query->where('luxury', $luxury === 'luxury' ? true : false);
			}

			$products = $query->orderBy('created_at', 'desc')->paginate(12);

			$totalProducts = Product::where('is_active', true)->count();

      return view('client.categories', compact('cart', 'lastPromoProducts', 'categories', 'products', 'totalProducts', 'old_inputs'));
    }

    // Shop
    public function category()
    {
        return view('client.category');
    }

    public function product(int $product_id)
    {
                $cart = session()->get('cart', []);

        $product = Product::findOrFail($product_id);

        $lastPromoProducts = Product::where('is_active', true)
        ->where('discount', '>', -1)
				->orderBy('created_at', 'desc')
        ->take(9)
        ->get();
        
        return view('client.product', compact('product', 'lastPromoProducts', 'cart'));
    }

    public function checkout()
    {
        return view('client.checkout');
    }

    public function cart()
    {
        $products = session()->get('cart', []);

        $cities = \App\Models\City::all();


        return view('client.cart', compact('cities', 'products'));
    }


    public function sendWhatsApp()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Votre panier est vide.');
        }

        $message = "🛒 Salut, j'aimerais passer une commande :\n\n";
        $total = 0;

        foreach ($cart as $item) {
            $lineTotal = $item['price'] * $item['quantity'];
            $total += $lineTotal;

            $message .= "- {$item['name']} ({$item['quantity']} x {$item['price']} FCFA) = {$lineTotal} FCFA\n";
        }

        $message .= "\n💰 Total : {$total} FCFA";

        // Formatage de l’URL WhatsApp
        $phone = "237677924952"; // Numéro au format international (237 = Cameroun)
        $url = "https://wa.me/{$phone}?text=" . urlencode($message);

        return redirect($url);
    }

    public function sendOrMaj(Request $request)
    {
        // dd($request->all());

        $cart = session()->get('cart', []);
        foreach ($request->input('products', []) as $productId => $quantity) {
            if (isset($cart[$productId])) {
                if ($quantity < 1) {
                    unset($cart[$productId]);
                } else {
                    $cart[$productId]['quantity'] =  (int)$quantity;
                }
            }
        }
        session()->put('cart', $cart);
        
        if ($request->has('send')) {
            // Valider la commande
            // Logique de validation de la commande ici
            return $this->sendWhatsApp();
        }
        return redirect()->route('site.cart')->with('success', 'Panier mis à jour avec succès.');

        //return redirect()->back()->with('error', 'Action non reconnue.');
    }


    // Contact
    public function contact()
    {
        return view('client.contact');
    }
}
