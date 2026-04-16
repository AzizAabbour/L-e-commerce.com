<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SouhaitsController extends Controller
{
    public function index()
    {
        $souhaits = auth()->user()->souhaits()->with('produit')->get();
        return view('client.souhaits.index', compact('souhaits'));
    }

    public function ajouter($id)
    {
        try {
            \App\Models\ListeSouhait::create([
                'user_id' => auth()->id(),
                'produit_id' => $id
            ]);
            return redirect()->back()->with('success', 'Produit ajouté aux souhaits !');
        } catch (\Exception $e) {
            return redirect()->back()->with('info', 'Produit déjà dans vos souhaits.');
        }
    }

    public function supprimer($id)
    {
        auth()->user()->souhaits()->where('produit_id', $id)->delete();
        return redirect()->back()->with('success', 'Produit retiré des souhaits.');
    }
}
