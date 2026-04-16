<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $produits = \App\Models\Produit::latest()->take(8)->get();
        return view('client.home', compact('produits'));
    }
}
