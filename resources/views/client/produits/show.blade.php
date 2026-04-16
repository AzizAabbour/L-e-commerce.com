@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <!-- Breadcrumbs -->
    <nav class="flex mb-8 items-center gap-3 text-sm font-medium">
        <a href="{{ url('/client/home') }}" class="text-slate-400 hover:text-indigo-600">Boutique</a>
        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
        <span class="text-slate-400 hover:text-indigo-600">{{ $produit->categorie->nom_categorie ?? 'Général' }}</span>
        <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
        <span class="text-slate-900">{{ $produit->nom_produit }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
        <!-- Image Section -->
        <div class="relative group">
            <div class="absolute -inset-4 bg-indigo-50 rounded-[40px] opacity-50 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative bg-white rounded-[40px] overflow-hidden shadow-2xl border-4 border-white aspect-square">
                @if($produit->image)
                    <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom_produit }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-200">
                        <i class="fa-solid fa-image text-8xl"></i>
                    </div>
                @endif
            </div>
            
            <div class="absolute top-8 left-8">
                @if($produit->stock > 0)
                    <span class="px-6 py-2 bg-emerald-500 text-white text-xs font-bold uppercase rounded-xl shadow-xl shadow-emerald-200 tracking-widest">En Stock</span>
                @else
                    <span class="px-6 py-2 bg-rose-500 text-white text-xs font-bold uppercase rounded-xl shadow-xl shadow-rose-200 tracking-widest">Épuisé</span>
                @endif
            </div>
        </div>

        <!-- Info Section -->
        <div class="py-4">
            <div class="text-indigo-600 font-bold uppercase tracking-[0.2em] text-sm mb-4">{{ $produit->categorie->nom_categorie ?? 'Général' }}</div>
            <h1 class="text-5xl font-extrabold text-slate-900 mb-6 leading-tight">{{ $produit->nom_produit }}</h1>
            
            <div class="flex items-center gap-6 mb-10">
                <div class="text-4xl font-black text-slate-900">{{ number_format($produit->prix, 2) }} DH</div>
                <div class="flex items-center gap-1 text-amber-400">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                    <span class="text-slate-400 text-sm font-bold ml-2">(48 avis)</span>
                </div>
            </div>

            <p class="text-slate-500 text-lg leading-relaxed mb-10 pb-10 border-b border-slate-100 italic">
                "{{ $produit->description ?? 'Aucune description disponible pour ce produit.' }}"
            </p>

            <form action="{{ url('/client/panier/ajouter') }}" method="POST">
                @csrf
                <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                
                <div class="mb-10">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Quantité</label>
                    <div class="flex items-center gap-4" x-data="{ qty: 1 }">
                        <div class="inline-flex items-center bg-slate-100 rounded-2xl p-1">
                            <button @click.prevent="if(qty > 1) qty--" class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-slate-600 hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                            <input type="number" name="quantite" x-model="qty" readonly class="w-16 bg-transparent border-none text-center font-bold text-lg text-slate-800 focus:ring-0">
                            <button @click.prevent="if(qty < {{ $produit->stock }}) qty++" class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-slate-600 hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                        <span class="text-sm font-bold text-slate-400 italic">Uniquement {{ $produit->stock }} disponibles</span>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" @if($produit->stock <= 0) disabled @endif class="flex-1 py-5 bg-indigo-600 text-white rounded-[20px] font-bold text-lg shadow-2xl shadow-indigo-100 hover:bg-indigo-700 transition-all disabled:opacity-50 disabled:bg-slate-300">
                        <i class="fa-solid fa-bag-shopping mr-3"></i> Ajouter au panier
                    </button>
                </form>
                
                <form action="{{ url('/client/souhaits/ajouter/'.$produit->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full sm:w-20 h-20 bg-rose-50 text-rose-500 rounded-[24px] flex items-center justify-center text-2xl hover:bg-rose-500 hover:text-white transition-all">
                        <i class="fa-solid fa-heart"></i>
                    </button>
                </form>
                </div>
            </div>

            <!-- Perks -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-16 p-8 bg-indigo-50 rounded-[32px]">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <div>
                        <div class="font-bold text-slate-800 text-sm">Livraison Gratuite</div>
                        <div class="text-xs text-slate-500 font-medium">Pour toute commande > 500 DH</div>
                    </div>
                </div>
                <div class="flex items-center gap-4 border-l border-indigo-100 pl-6">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <div class="font-bold text-slate-800 text-sm">Garantie 2 ans</div>
                        <div class="text-xs text-slate-500 font-medium">Protection premium incluse</div>
                    </div>
                </div>
                <div class="flex items-center gap-4 border-l border-indigo-100 pl-6">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm">
                        <i class="fa-solid fa-rotate-left"></i>
                    </div>
                    <div>
                        <div class="font-bold text-slate-800 text-sm">Retour sous 30j</div>
                        <div class="text-xs text-slate-500 font-medium">Satisfait ou remboursé</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
