@extends('layouts.admin')

@section('header', 'Rapports & Ventes')

@section('breadcrumb')
    <li>
        <i class="fa-solid fa-chevron-right mx-2 text-[10px]"></i>
        <span class="text-slate-900 font-medium">Rapports</span>
    </li>
@endsection

@section('content')
<div class="space-y-8">
    <!-- Summary Card -->
    <div class="bg-indigo-600 rounded-[40px] p-10 text-white shadow-2xl relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
            <div>
                <h2 class="text-xl font-bold opacity-80 uppercase tracking-widest mb-2">Chiffre d'Affaires Global</h2>
                <div class="text-6xl font-black">{{ number_format($revenueTotal, 2) }} DH</div>
            </div>
            <div class="bg-white/10 backdrop-blur-md rounded-3xl p-8 border border-white/20">
                <div class="text-[10px] font-black uppercase tracking-[0.2em] mb-4 text-indigo-200 text-center">Tendance actuelle</div>
                <div class="flex items-center gap-4 text-3xl font-bold">
                    <i class="fa-solid fa-chart-line text-emerald-400"></i>
                    <span>+ 12.5%</span>
                </div>
            </div>
        </div>
        <!-- Decorative blob -->
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Sales Report Table -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-800">Top des Ventes</h3>
                <span class="px-3 py-1 bg-emerald-100 text-emerald-600 rounded-full text-[10px] font-bold uppercase tracking-widest">Performance</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Produit</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Unités Vendues</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">CA Généré</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($ventes as $vente)
                            <tr class="hover:bg-indigo-50/20 transition-colors">
                                <td class="px-8 py-5 font-bold text-slate-800 uppercase tracking-tight">{{ $vente->nom_produit }}</td>
                                <td class="px-8 py-5 text-center">
                                    <span class="font-black text-indigo-600 text-lg">{{ $vente->total_vendu }}</span>
                                </td>
                                <td class="px-8 py-5 text-right font-black text-slate-900">{{ number_format($vente->chiffre_affaires, 2) }} DH</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Inventory Status -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-800">État des Stocks (Alertes)</h3>
                <span class="px-3 py-1 bg-rose-100 text-rose-600 rounded-full text-[10px] font-bold uppercase tracking-widest">Urgent</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Produit</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Stock</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($stockFaible as $stock)
                            <tr>
                                <td class="px-8 py-5 font-bold text-slate-800 truncate max-w-[200px]">{{ $stock->nom_produit }}</td>
                                <td class="px-8 py-5 text-center font-black text-rose-600">{{ $stock->stock }}</td>
                                <td class="px-8 py-5 text-center">
                                    @if($stock->stock == 0)
                                        <span class="px-3 py-1 bg-rose-900 text-white rounded-md text-[10px] font-black uppercase">Rupture totale</span>
                                    @else
                                        <span class="px-3 py-1 bg-rose-400 text-white rounded-md text-[10px] font-black uppercase tracking-widest">Commander</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
