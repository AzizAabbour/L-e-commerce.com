<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PanierController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = array_reduce($cart, function($carry, $item) {
            return $carry + ($item['prix'] * $item['quantite']);
        }, 0);

        return view('client.panier.index', compact('cart', 'total'));
    }

    public function ajouter(Request $request)
    {
        $produit = \App\Models\Produit::findOrFail($request->produit_id);
        $cart = session()->get('cart', []);

        if(isset($cart[$request->produit_id])) {
            $cart[$request->produit_id]['quantite'] += $request->quantite ?? 1;
        } else {
            $cart[$request->produit_id] = [
                "nom" => $produit->nom_produit,
                "quantite" => $request->quantite ?? 1,
                "prix" => $produit->prix,
                "image" => $produit->image,
                "sous_total" => $produit->prix * ($request->quantite ?? 1)
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produit ajouté au panier !');
    }

    public function modifier(Request $request, $id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            $cart[$id]['quantite'] = $request->quantite;
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Panier mis à jour !');
    }

    public function supprimer($id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Produit retiré du panier !');
    }
}
