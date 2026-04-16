<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Produit::query();

        if ($request->has('search')) {
            $query->where('nom_produit', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category')) {
            $query->where('categorie_id', $request->category);
        }

        if ($request->has('min_price')) {
            $query->where('prix', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('prix', '<=', $request->max_price);
        }

        $produits = $query->paginate(12);
        $categories = \App\Models\Categorie::all();

        return view('client.produits.index', compact('produits', 'categories'));
    }

    public function show($id)
    {
        $produit = \App\Models\Produit::with('categorie')->findOrFail($id);
        return view('client.produits.show', compact('produit'));
    }
}
