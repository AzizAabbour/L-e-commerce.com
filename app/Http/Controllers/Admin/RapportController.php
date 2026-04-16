<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Commande;

class RapportController extends Controller
{
    public function index()
    {
        // Procedure for sales report
        $ventes = DB::select('CALL get_rapport_ventes()');
        
        // Total revenue
        $revenueTotal = Commande::sum('total');
        
        // Stored procedure for low stock (seuil = 5 as per prompt)
        $stockFaible = DB::select('CALL get_stock_faible(?)', [5]);

        return view('admin.rapports.index', compact('ventes', 'revenueTotal', 'stockFaible'));
    }
}
