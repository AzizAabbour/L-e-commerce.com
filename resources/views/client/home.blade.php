@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="relative bg-white pt-16 pb-32 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <div>
            <span class="inline-block px-4 py-2 bg-indigo-50 text-indigo-600 rounded-full text-xs font-bold uppercase tracking-widest mb-6">Nouvelle Collection 2026</span>
            <h1 class="text-6xl font-extrabold text-slate-800 leading-[1.1] mb-8">
                Plus qu'un magasin, <br>
                <span class="text-indigo-600 italic">votre style</span> de vie.
            </h1>
            <p class="text-lg text-slate-500 mb-10 max-w-lg leading-relaxed">
                Découvrez notre sélection exclusive de produits haut de gamme conçus pour améliorer votre quotidien. La qualité sans compromis, livrée chez vous.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ url('/client/produits') }}" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:shadow-indigo-200 transition-all flex items-center gap-3">
                    Découvrir Boutique <i class="fa-solid fa-arrow-right"></i>
                </a>
                <a href="#featured" class="px-8 py-4 bg-white text-slate-700 border border-slate-200 rounded-2xl font-bold hover:bg-slate-50 transition-all">
                    Voir les tendances
                </a>
            </div>
            <div class="mt-12 flex items-center gap-8 border-t border-slate-100 pt-12">
                <div>
                    <div class="text-2xl font-bold text-slate-800">15k+</div>
                    <div class="text-sm text-slate-400 font-medium">Clients satisfaits</div>
                </div>
                <div class="w-px h-8 bg-slate-100"></div>
                <div>
                    <div class="text-2xl font-bold text-slate-800">500+</div>
                    <div class="text-sm text-slate-400 font-medium">Articles Premium</div>
                </div>
            </div>
        </div>
        <div class="relative lg:block hidden">
            <div class="absolute -top-20 -right-20 w-96 h-96 bg-indigo-100 rounded-full blur-3xl opacity-50"></div>
            <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-blue-100 rounded-full blur-3xl opacity-50"></div>
            <div class="relative rounded-3xl overflow-hidden shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-500 border-8 border-white">
                <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Hero Image" class="w-full h-auto">
            </div>
        </div>
    </div>
</div>

<!-- Featured Products -->
<section id="featured" class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-end mb-16">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 mb-4">Produits Vedettes</h2>
                <div class="w-20 h-1.5 bg-indigo-600 rounded-full"></div>
            </div>
            <a href="{{ url('/client/produits') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 uppercase tracking-widest flex items-center gap-2">
                Voir tout le catalogue <i class="fa-solid fa-chevron-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($produits as $produit)
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group">
                    <div class="relative aspect-square overflow-hidden">
                        @if($produit->image)
                            <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom_produit }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
                                <i class="fa-solid fa-image text-5xl"></i>
                            </div>
                        @endif
                        
                        <!-- Actions Info -->
                        <div class="absolute top-4 right-4 flex flex-col gap-2 translate-x-12 group-hover:translate-x-0 transition-transform">
                            <form action="{{ url('/client/souhaits/ajouter/'.$produit->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-10 h-10 bg-white rounded-xl shadow-lg flex items-center justify-center text-slate-400 hover:text-rose-500 transition-colors">
                                    <i class="fa-solid fa-heart"></i>
                                </button>
                            </form>
                            <a href="{{ url('/client/produits/'.$produit->id) }}" class="w-10 h-10 bg-white rounded-xl shadow-lg flex items-center justify-center text-slate-400 hover:text-indigo-600 transition-colors">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </div>

                        <div class="absolute bottom-4 left-4">
                            @if($produit->stock > 0)
                                <span class="px-3 py-1 bg-emerald-500 text-white text-[10px] font-bold uppercase rounded-lg shadow-lg">En Stock</span>
                            @else
                                <span class="px-3 py-1 bg-rose-500 text-white text-[10px] font-bold uppercase rounded-lg shadow-lg">Rupture</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="text-xs font-bold text-indigo-500 uppercase tracking-widest mb-2">{{ $produit->categorie->nom_categorie ?? 'Général' }}</div>
                        <h3 class="text-lg font-bold text-slate-800 mb-3 truncate">{{ $produit->nom_produit }}</h3>
                        <div class="flex items-center justify-between">
                            <div class="text-xl font-black text-slate-900">{{ number_format($produit->prix, 2) }} DH</div>
                            <form action="{{ url('/client/panier/ajouter') }}" method="POST">
                                @csrf
                                <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                                <input type="hidden" name="quantite" value="1">
                                <button type="submit" @if($produit->stock <= 0) disabled @endif class="p-3 bg-slate-900 text-white rounded-xl hover:bg-indigo-600 transition-all disabled:opacity-50 disabled:bg-slate-300">
                                    <i class="fa-solid fa-cart-plus"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 bg-white rounded-3xl border-2 border-dashed border-slate-200">
                    <i class="fa-solid fa-box-open text-6xl text-slate-200 mb-6"></i>
                    <p class="text-slate-400 font-medium italic">Aucun produit disponible pour le moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
