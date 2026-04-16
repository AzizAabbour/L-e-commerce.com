<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = \App\Models\Produit::count();
        $totalClients = \App\Models\User::where('role', 'client')->count();
        $totalOrders = \App\Models\Commande::count();
        $totalRevenue = \App\Models\Commande::sum('total');

        $recentOrders = \App\Models\Commande::with('user')->latest()->take(5)->get();
        
        // Use stored procedure for low stock
        $lowStock = DB::select('CALL get_stock_faible(5)');
        
        // Use stored procedure for top sellers
        $topSellers = DB::select('CALL get_rapport_ventes()');
        $topSellers = array_slice($topSellers, 0, 5);

        return view('admin.dashboard', compact(
            'totalProducts', 'totalClients', 'totalOrders', 'totalRevenue',
            'recentOrders', 'lowStock', 'topSellers'
        ));
    }
}
