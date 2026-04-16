@extends('layouts.app')

@section('content')
<div class="bg-indigo-600 py-16">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h1 class="text-4xl font-extrabold text-white mb-4 uppercase tracking-[0.2em]">Mes Commandes</h1>
        <p class="text-indigo-100 italic opacity-80">Retrouvez ici l'historique de tous vos achats.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-6 -mt-10 mb-20">
    <div class="bg-white rounded-[40px] shadow-2xl overflow-hidden border border-slate-50">
        @if($commandes->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">ID Commande</th>
                            <th class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Date</th>
                            <th class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Statut</th>
                            <th class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Montant Total</th>
                            <th class="px-8 py-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($commandes as $commande)
                            <tr class="hover:bg-indigo-50/30 transition-colors group">
                                <td class="px-8 py-6">
                                    <span class="font-black text-slate-800">#{{ str_pad($commande->id, 6, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="px-8 py-6 text-slate-500 font-medium whitespace-nowrap">
                                    {{ $commande->created_at->format('d M Y') }}
                                </td>
                                <td class="px-8 py-6 text-center">
                                    @php
                                        $statusClasses = [
                                            'en_attente' => 'bg-amber-100 text-amber-600 border-amber-200',
                                            'expediee' => 'bg-blue-100 text-blue-600 border-blue-200',
                                            'livree' => 'bg-emerald-100 text-emerald-600 border-emerald-200',
                                            'annulee' => 'bg-rose-100 text-rose-600 border-rose-200'
                                        ];
                                        $statusLabels = [
                                            'en_attente' => 'En attente',
                                            'expediee' => 'Expédiée',
                                            'livree' => 'Livrée',
                                            'annulee' => 'Annulée'
                                        ];
                                    @endphp
                                    <span class="px-4 py-1.5 rounded-full text-[10px] font-bold uppercase border {{ $statusClasses[$commande->statut] }}">
                                        {{ $statusLabels[$commande->statut] }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right font-black text-slate-900 text-lg">
                                    {{ number_format($commande->total, 2) }} DH
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <a href="{{ url('/client/commandes/'.$commande->id) }}" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl text-xs font-bold uppercase tracking-widest shadow-lg shadow-indigo-100 hover:bg-slate-900 transition-all">
                                        Voir Détails
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="py-32 text-center text-slate-300">
                <i class="fa-solid fa-receipt text-6xl mb-6 opacity-20"></i>
                <p class="text-xl font-bold uppercase tracking-widest">Aucune commande passée</p>
                <a href="{{ url('/client/produits') }}" class="mt-8 inline-block text-indigo-600 font-bold hover:underline">Découvrir nos produits <i class="fa-solid fa-arrow-right ml-2 text-xs"></i></a>
            </div>
        @endif
    </div>
</div>
@endsection
