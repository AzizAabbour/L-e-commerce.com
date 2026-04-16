<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Commande;

class CommandeController extends Controller
{
    public function index(Request $request)
    {
        $query = Commande::with('user');

        if ($request->has('statut') && $request->statut != '') {
            $query->where('statut', $request->statut);
        }

        if ($request->has('date') && $request->date != '') {
            $query->whereDate('date_commande', $request->date);
        }

        $commandes = $query->latest()->paginate(20);
        return view('admin.commandes.index', compact('commandes'));
    }

    public function show($id)
    {
        $commande = Commande::with(['user', 'ligneCommandes.produit'])->findOrFail($id);
        return view('admin.commandes.show', compact('commande'));
    }

    public function updateStatut(Request $request, $id)
    {
        $commande = Commande::findOrFail($id);
        $request->validate([
            'statut' => 'required|in:en_attente,expediee,livree,annulee'
        ]);

        $commande->update(['statut' => $request->statut]);

        return redirect()->back()->with('success', 'Statut de la commande mis à jour.');
    }
}
