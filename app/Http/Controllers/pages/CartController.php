<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Neighborhood;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\PromoCode;

class CartController extends Controller
{
    // Afficher le panier
    public function index(Request $request)
    {
        $products = session()->get('cart', []);

        $cities = \App\Models\City::all();


        $promoCode = null;
        if ($request->has('promo_code')) {
            $promoCode = PromoCode::where("code", $request->input("promo_code"))->first();
        }
        


        return view('client.cart', compact('cities', 'products', 'promoCode'));
    }

    // Ajouter au panier
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        $quantity = $request->input('quantity', -1);

        if (isset($cart[$id])) {
            if($quantity == 0){
                unset($cart[$id]);
            }else if($quantity < 0){
                $cart[$id]['quantity'] += 1;
            }
            else{
                $cart[$id]['quantity'] = $quantity;
            }
        } else {
            $cart[$id] = [
                "id" => $product->id,
                "name" => $product->name . ' (' . $product->code . ')',
                "price" => $product->price - $product->reduction,
                "quantity" => $quantity > 0 ? $quantity : 1,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Produit ajouté au panier.');
    }

    // Retirer un produit du panier
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Produit retiré du panier.');
    }

    // Vider le panier
    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Panier vidé.');
    }

    public function sendWhatsApp(Request $request, $promo_code=null)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Votre panier est vide.');
        }

        $message = "🛒 Salut, j'aimerais passer une commande :\n\n";
        $total = 0;
        $totalDiscount =0;

        /**
         * @var PromoCode $promoCode
         */
        
        $promoDiscount= 0;
        if ($promo_code) {
            $promoCode = PromoCode::where("code", $promo_code)->first();
            $promoDiscount = $promoCode->discount;
        }
       

        foreach ($cart as $item) {
            $lineTotal = $item['price'] * $item['quantity'];

            if ($promoDiscount > 1) {
                $totalDiscount += $promoDiscount * $item['quantity'];
            }else{
                $totalDiscount += $promoDiscount * $lineTotal;
            }

            $total += $lineTotal;

            $message .= "- {$item['name']} ({$item['quantity']} x {$item['price']} FCFA) = {$lineTotal} FCFA\n";
        }

        if ($promoDiscount) {
            $message .= "\n🎉 Code promo appliqué : {$promoCode->code} (-{$totalDiscount} FCFA)";
            $total -= $totalDiscount;
        }

        $message .= "\n💰 Total : {$total} FCFA";
        
        $message .= "\n\n📍 Adresse de livraison : ";

        if ($request->has('city')) {
            $city = City::find($request->input('city'));
            $message .= $city->name;
        }
        if ($request->has('neighborhood')) {
            $neighborhood = Neighborhood::find($request->input('neighborhood'));
            $message .= " - " . $neighborhood->name;
        }
        if ($request->has('no_delivery')) {
            $message .= "Pas de livraison";
        }
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

        $data = $request->validate(
            [
                "promo_code" => "nullable|string|exists:promo_codes,code",
            ],
            [
                "promo_code.exists" => "Le code promo saisi n'est pas valide.",
            ]
        );

        $promoCode = isset($data["promo_code"]) ? $data["promo_code"] : "";

        if ($request->has('send')) {
            // Valider la commande
            // Logique de validation de la commande ici
            return $this->sendWhatsApp($request, $promoCode);
        }
        return redirect()->route('site.cart', ['promo_code' => $promoCode])->with('success', 'Panier mis à jour avec succès.');

        //return redirect()->back()->with('error', 'Action non reconnue.');
    }
    
}
