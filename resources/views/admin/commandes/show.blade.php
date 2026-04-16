@extends('layouts.admin')

@section('header', 'Détails Commande')

@section('breadcrumb')
    <li>
        <i class="fa-solid fa-chevron-right mx-2 text-[10px]"></i>
        <a href="{{ route('admin.commandes.index') }}" class="hover:text-indigo-600">Commandes</a>
    </li>
    <li>
        <i class="fa-solid fa-chevron-right mx-2 text-[10px]"></i>
        <span class="text-slate-900 font-medium">#{{ $commande->id }}</span>
    </li>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-8">
        <!-- Products Table -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-8 py-5 border-b border-slate-50 bg-slate-50/50">
                <h3 class="font-bold text-slate-800">Articles Commandés</h3>
            </div>
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/20">
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Produit</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Quantité</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Sous-total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($commande->ligneCommandes as $ligne)
                        <tr>
                            <td class="px-8 py-5 flex items-center gap-4">
                                <div class="w-12 h-12 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0">
                                    @if($ligne->produit->image)
                                        <img src="{{ asset('storage/'.$ligne->produit->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                            <i class="fa-solid fa-image"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="font-bold text-slate-800">{{ $ligne->produit->nom_produit }}</div>
                            </td>
                            <td class="px-8 py-5 text-center font-bold text-slate-600">x{{ $ligne->quantite }}</td>
                            <td class="px-8 py-5 text-right font-black text-slate-900">{{ number_format($ligne->sous_total, 2) }} DH</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-indigo-50/50">
                        <td colspan="2" class="px-8 py-6 text-right font-bold text-slate-500 uppercase tracking-widest text-xs">Total de la commande</td>
                        <td class="px-8 py-6 text-right font-black text-indigo-600 text-2xl">{{ number_format($commande->total, 2) }} DH</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="space-y-8">
        <!-- Customer Info -->
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6">Informations Client</h3>
            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white text-xl">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div>
                    <div class="font-bold text-slate-800">{{ $commande->user->name }}</div>
                    <div class="text-xs text-slate-400 font-bold uppercase tracking-tight">{{ $commande->user->email }}</div>
                </div>
            </div>
            <div class="space-y-4">
                <div class="text-sm text-slate-600 flex items-start gap-3 italic">
                    <i class="fa-solid fa-location-dot mt-1 text-slate-300"></i>
                    {{ $commande->user->address ?? 'Pas d\'adresse renseignée' }}
                </div>
                <div class="text-sm text-slate-600 flex items-center gap-3">
                    <i class="fa-solid fa-phone text-slate-300"></i>
                    {{ $commande->user->phone ?? 'N/A' }}
                </div>
            </div>
        </div>

        <!-- Status Update -->
        <div class="bg-slate-900 rounded-3xl p-8 text-white shadow-xl">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6">Statut de livraison</h3>
            <form action="{{ route('admin.commandes.updateStatut', $commande->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-6">
                    <select name="statut" class="w-full bg-slate-800 border-none rounded-2xl p-4 text-sm font-bold text-white focus:ring-2 focus:ring-indigo-500">
                        <option value="en_attente" {{ $commande->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="expediee" {{ $commande->statut == 'expediee' ? 'selected' : '' }}>Expédiée</option>
                        <option value="livree" {{ $commande->statut == 'livree' ? 'selected' : '' }}>Livrée</option>
                        <option value="annulee" {{ $commande->statut == 'annulee' ? 'selected' : '' }}>Annulée</option>
                    </select>
                </div>
                <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-white hover:text-indigo-600 transition-all uppercase tracking-widest text-xs">
                    Mettre à jour
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
