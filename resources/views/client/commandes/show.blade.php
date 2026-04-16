@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6">
        <div>
            <a href="{{ url('/client/commandes') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 uppercase tracking-widest flex items-center gap-2 mb-4">
                <i class="fa-solid fa-arrow-left"></i> Retour aux commandes
            </a>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-4">
                Commande <span class="text-indigo-600">#{{ str_pad($commande->id, 6, '0', STR_PAD_LEFT) }}</span>
            </h1>
        </div>
        <div class="bg-indigo-50 border border-indigo-100 rounded-2xl px-8 py-4 text-center">
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Montant Payé</div>
            <div class="text-2xl font-black text-indigo-600">{{ number_format($commande->total, 2) }} DH</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Products -->
        <div class="lg:col-span-2 space-y-6">
            <h2 class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em] mb-4">Articles Commandés</h2>
            @foreach($commande->ligneCommandes as $ligne)
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-50 flex items-center gap-6">
                    <div class="w-16 h-16 bg-slate-50 rounded-xl overflow-hidden shadow-sm flex-shrink-0">
                        @if($ligne->produit->image)
                            <img src="{{ asset('storage/' . $ligne->produit->image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-200">
                                <i class="fa-solid fa-image text-xl"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-slate-800">{{ $ligne->produit->nom_produit }}</h4>
                        <div class="text-sm text-slate-400 font-medium">Quantité : {{ $ligne->quantite }}</div>
                    </div>
                    <div class="text-right">
                        <div class="font-black text-slate-900">{{ number_format($ligne->sous_total, 2) }} DH</div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase">{{ number_format($ligne->produit->prix, 2) }} DH / unit</div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-8">
            <div class="bg-slate-900 rounded-[32px] p-8 text-white shadow-2xl">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6">Informations</h3>
                
                <div class="space-y-6">
                    <div>
                        <div class="text-xs font-bold text-indigo-400 uppercase tracking-widest mb-2">Statut</div>
                        <div class="text-lg font-bold">
                            @php
                                $statusLabels = [
                                    'en_attente' => 'En attente ⏳',
                                    'expediee' => 'Expédiée 🚚',
                                    'livree' => 'Livrée ✅',
                                    'annulee' => 'Annulée ❌'
                                ];
                            @endphp
                            {{ $statusLabels[$commande->statut] }}
                        </div>
                    </div>
                    <div class="w-full h-px bg-slate-800"></div>
                    <div>
                        <div class="text-xs font-bold text-indigo-400 uppercase tracking-widest mb-2">Date d'achat</div>
                        <div class="text-lg font-bold">{{ $commande->created_at->format('d F Y') }}</div>
                    </div>
                    <div class="w-full h-px bg-slate-800"></div>
                    <div>
                        <div class="text-xs font-bold text-indigo-400 uppercase tracking-widest mb-2">Adresse de livraison</div>
                        <div class="text-sm text-slate-300 leading-relaxed font-medium">
                            {{ Auth::user()->name }}<br>
                            {{ Auth::user()->address ?? 'Adresse non spécifiée' }}<br>
                            {{ Auth::user()->phone ?? 'Téléphone non spécifié' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-indigo-600 rounded-[32px] p-8 text-white text-center shadow-lg shadow-indigo-100">
                <i class="fa-solid fa-headset text-3xl mb-4"></i>
                <h4 class="font-bold mb-2">Besoin d'aide ?</h4>
                <p class="text-xs text-indigo-100 mb-6 font-medium">Notre équipe est là pour vous aider pour toute question sur votre commande.</p>
                <a href="#" class="inline-block px-6 py-3 bg-white text-indigo-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all">Support Client</a>
            </div>
        </div>
    </div>
</div>
@endsection
