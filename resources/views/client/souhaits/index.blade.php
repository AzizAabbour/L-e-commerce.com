@extends('layouts.app')

@section('content')
<div class="bg-indigo-600 py-16">
    <div class="max-w-7xl mx-auto px-6">
        <h1 class="text-4xl font-extrabold text-white mb-4">Mes Souhaits <i class="fa-solid fa-heart ml-3 text-rose-300"></i></h1>
        <p class="text-indigo-100 text-lg">Gardez une trace de vos articles préférés et commandez-les plus tard.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-6 py-12">
    @if($souhaits->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($souhaits as $souhait)
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col h-full border border-slate-50">
                    <div class="relative aspect-square overflow-hidden">
                        @if($souhait->produit->image)
                            <img src="{{ asset('storage/' . $souhait->produit->image) }}" alt="{{ $souhait->produit->nom_produit }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
                                <i class="fa-solid fa-image text-4xl"></i>
                            </div>
                        @endif

                        <div class="absolute top-4 right-4 translate-x-12 group-hover:translate-x-0 transition-transform">
                            <form action="{{ url('/client/souhaits/supprimer/'.$souhait->produit->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-10 h-10 bg-white text-rose-500 rounded-xl shadow-xl flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="p-6 flex flex-col flex-1">
                        <div class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mb-2">{{ $souhait->produit->categorie->nom_categorie ?? 'Général' }}</div>
                        <h3 class="text-lg font-bold text-slate-800 mb-6 truncate">{{ $souhait->produit->nom_produit }}</h3>
                        
                        <div class="mt-auto flex items-center justify-between">
                            <div class="text-xl font-black text-slate-900">{{ number_format($souhait->produit->prix, 2) }} DH</div>
                            <form action="{{ url('/client/panier/ajouter') }}" method="POST">
                                @csrf
                                <input type="hidden" name="produit_id" value="{{ $souhait->produit->id }}">
                                <input type="hidden" name="quantite" value="1">
                                <button type="submit" @if($souhait->produit->stock <= 0) disabled @endif class="px-6 py-3 bg-slate-900 text-white text-xs font-bold rounded-xl hover:bg-indigo-600 transition-all disabled:opacity-50">
                                    ACHETER
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-40 bg-white rounded-[40px] shadow-sm border border-slate-50">
            <div class="w-24 h-24 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-8 text-rose-300">
                <i class="fa-solid fa-heart-crack text-5xl"></i>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-800 mb-4">Votre liste est vide</h2>
            <p class="text-slate-400 max-w-sm mx-auto mb-12 italic">Pas encore de coups de cœur ? Explorez notre boutique et sauvegardez les pépites qui vous font envie !</p>
            <a href="{{ url('/client/produits') }}" class="inline-flex items-center gap-3 px-10 py-5 bg-indigo-600 text-white rounded-2xl font-bold shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all uppercase tracking-widest text-sm">
                Voir tous les produits
            </a>
        </div>
    @endif
</div>
@endsection
