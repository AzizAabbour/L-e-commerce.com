@extends('layouts.app')

@section('content')
<div class="bg-indigo-600 py-16">
    <div class="max-w-7xl mx-auto px-6">
        <h1 class="text-4xl font-extrabold text-white mb-4">Notre Boutique</h1>
        <p class="text-indigo-100 text-lg">Parcourez notre collection complète d'articles exceptionnels.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-6 -mt-8">
    <div class="bg-white rounded-3xl shadow-xl p-8 mb-12">
        <form action="{{ url('/client/produits') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-6 items-end">
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Rechercher</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom du produit..." class="w-full pl-12 pr-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-slate-700">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                </div>
            </div>
            
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Catégorie</label>
                <select name="category" class="w-full py-3 px-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-slate-700 appearance-none">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->nom_categorie }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Budget Max</label>
                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Prix max €" class="w-full py-3 px-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-slate-700">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all">
                    Filtrer
                </button>
                <a href="{{ url('/client/produits') }}" class="p-3 bg-slate-100 text-slate-400 rounded-2xl hover:bg-slate-200 transition-all">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @forelse($produits as $produit)
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col h-full border border-slate-50">
                <div class="relative aspect-square overflow-hidden">
                    @if($produit->image)
                        <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom_produit }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
                            <i class="fa-solid fa-image text-4xl"></i>
                        </div>
                    @endif

                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1.5 bg-white/90 backdrop-blur rounded-xl text-[10px] font-bold text-slate-700 uppercase tracking-tight shadow-sm">{{ $produit->categorie->nom_categorie ?? 'Standard' }}</span>
                    </div>

                    <div class="absolute bottom-4 right-4 translate-y-20 group-hover:translate-y-0 transition-transform flex flex-col gap-2">
                        <form action="{{ url('/client/souhaits/ajouter/'.$produit->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-10 h-10 bg-rose-500 text-white rounded-xl shadow-xl flex items-center justify-center hover:bg-rose-600 transition-all">
                                <i class="fa-solid fa-heart"></i>
                            </button>
                        </form>
                        <a href="{{ url('/client/produits/'.$produit->id) }}" class="w-10 h-10 bg-white text-slate-700 rounded-xl shadow-xl flex items-center justify-center hover:bg-slate-50 transition-all">
                            <i class="fa-solid fa-expand"></i>
                        </a>
                    </div>
                </div>
                
                <div class="p-6 flex flex-col flex-1">
                    <h3 class="text-lg font-bold text-slate-800 mb-2 truncate">{{ $produit->nom_produit }}</h3>
                    <p class="text-sm text-slate-400 mb-6 truncate-2-lines">{{ Str::limit($produit->description, 60) }}</p>
                    
                    <div class="mt-auto flex items-center justify-between">
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase mb-1">Prix Unitaire</div>
                            <div class="text-xl font-black text-indigo-600">{{ number_format($produit->prix, 2) }} <span class="text-xs">DH</span></div>
                        </div>
                        <form action="{{ url('/client/panier/ajouter') }}" method="POST">
                            @csrf
                            <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                            <input type="hidden" name="quantite" value="1">
                            <button type="submit" @if($produit->stock <= 0) disabled @endif class="flex items-center gap-2 px-5 py-3 bg-slate-900 text-white text-xs font-bold rounded-xl hover:bg-indigo-600 transition-all disabled:opacity-50 disabled:bg-slate-200">
                                <i class="fa-solid fa-cart-plus"></i> AJOUTER
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-32 text-center bg-white rounded-[40px] shadow-sm border border-slate-100">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-200">
                    <i class="fa-solid fa-magnifying-glass text-4xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Aucun résultat trouvé</h3>
                <p class="text-slate-400 max-w-xs mx-auto">Nous n'avons trouvé aucun produit correspondant à vos critères de recherche.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-16 mb-24">
        {{ $produits->links() }}
    </div>
</div>
@endsection
