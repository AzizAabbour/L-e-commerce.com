@extends('layouts.admin')

@section('header', 'Tableau de Bord')

@section('breadcrumb')
    <li>
        <i class="fa-solid fa-chevron-right mx-2 text-[10px]"></i>
        <span class="text-slate-900 font-medium">Dashboard</span>
    </li>
@endsection

@section('content')
<div class="space-y-8">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-admin-stat-card title="Produits" :value="$totalProducts" icon="fa-box" color="bg-indigo-500" />
        <x-admin-stat-card title="Clients" :value="$totalClients" icon="fa-users" color="bg-emerald-500" />
        <x-admin-stat-card title="Commandes" :value="$totalOrders" icon="fa-shopping-bag" color="bg-amber-500" />
        <x-admin-stat-card title="CA Total" :value="number_format($totalRevenue, 2) . ' DH'" icon="fa-coins" color="bg-rose-500" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Orders -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-800">Commandes Récentes</h3>
                <a href="{{ route('admin.commandes.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 uppercase tracking-widest">Voir tout</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Client</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Date</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Total</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($recentOrders as $order)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800">{{ $order->user->name }}</div>
                                    <div class="text-xs text-slate-400">{{ $order->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 text-slate-500 text-sm">
                                    {{ $order->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-right font-black text-slate-900">
                                    {{ number_format($order->total, 2) }} DH
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $colors = [
                                            'en_attente' => 'bg-amber-100 text-amber-700',
                                            'expediee' => 'bg-indigo-100 text-indigo-700',
                                            'livree' => 'bg-emerald-100 text-emerald-700',
                                            'annulee' => 'bg-rose-100 text-rose-700',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $colors[$order->statut] }}">
                                        {{ $order->statut }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-rose-500"></i> Stock Faible
            </h3>
            <div class="space-y-4">
                @forelse($lowStock as $prod)
                    <div class="flex items-center gap-4 bg-rose-50/50 p-4 rounded-xl border border-rose-100">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-rose-500 shadow-sm">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-slate-800 text-sm truncate">{{ $prod->nom_produit }}</div>
                            <div class="text-xs text-rose-600 font-bold">Reste: {{ $prod->stock }} unit.</div>
                        </div>
                        <a href="{{ route('produits.edit', $prod->id) }}" class="text-slate-400 hover:text-indigo-600">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </div>
                @empty
                    <p class="text-center text-slate-400 py-8 italic">Tous les stocks sont OK.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Best Sellers -->
    <div class="bg-indigo-900 rounded-[32px] p-8 text-white shadow-2xl">
        <h3 class="text-xl font-bold mb-8">Meilleures Ventes</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            @foreach($topSellers as $top)
                <div class="bg-indigo-800/50 backdrop-blur p-6 rounded-2xl border border-indigo-700/50 text-center">
                    <div class="text-xs font-bold text-indigo-300 uppercase tracking-widest mb-4">Ventes: {{ $top->total_vendu }}</div>
                    <div class="text-lg font-black mb-2 truncate">{{ $top->nom_produit }}</div>
                    <div class="text-2xl font-bold text-emerald-400">{{ number_format($top->chiffre_affaires, 2) }} DH</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
