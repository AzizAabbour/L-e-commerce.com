<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = auth()->user()->commandes()->latest()->get();
        return view('client.commandes.index', compact('commandes'));
    }

    public function show($id)
    {
        $commande = auth()->user()->commandes()->with('ligneCommandes.produit')->findOrFail($id);
        return view('client.commandes.show', compact('commande'));
    }

    public function valider()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Votre panier est vide.');
        }

        try {
            DB::beginTransaction();

            // Call stored procedure to create order
            $result = DB::select('CALL creer_commande(?)', [auth()->id()]);
            $commandeId = $result[0]->commande_id;

            foreach ($cart as $id => $details) {
                // Call stored procedure to add product to order
                DB::statement('CALL ajouter_produit_commande(?, ?, ?)', [
                    $commandeId,
                    $id,
                    $details['quantite']
                ]);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('client.commandes.show', $commandeId)->with('success', 'Commande validée avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
