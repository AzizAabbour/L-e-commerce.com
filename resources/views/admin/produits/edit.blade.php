@extends('layouts.admin')

@section('header', 'Modifier le Produit')

@section('breadcrumb')
    <li>
        <i class="fa-solid fa-chevron-right mx-2 text-[10px]"></i>
        <a href="{{ route('produits.index') }}" class="hover:text-indigo-600">Produits</a>
    </li>
    <li>
        <i class="fa-solid fa-chevron-right mx-2 text-[10px]"></i>
        <span class="text-slate-900 font-medium">Édition</span>
    </li>
@endsection

@section('content')
<div class="max-w-4xl bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <form action="{{ route('produits.update', $produit->id) }}" method="POST" enctype="multipart/form-data" class="p-10">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Nom du Produit</label>
                <input type="text" name="nom_produit" value="{{ old('nom_produit', $produit->nom_produit) }}" required class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-medium text-slate-700">
                @error('nom_produit') <p class="mt-2 text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-6 md:col-span-2 bg-slate-50 p-6 rounded-2xl border border-slate-100">
                <div class="w-24 h-24 bg-white rounded-xl overflow-hidden shadow-sm flex-shrink-0">
                    @if($produit->image)
                        <img src="{{ asset('storage/'.$produit->image) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-200">
                            <i class="fa-solid fa-image text-2xl"></i>
                        </div>
                    @endif
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Nouvelle Image (Optionnel)</label>
                    <input type="file" name="image" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all cursor-pointer">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Catégorie</label>
                <select name="categorie_id" required class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-medium text-slate-700 appearance-none">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('categorie_id', $produit->categorie_id) == $cat->id ? 'selected' : '' }}>{{ $cat->nom_categorie }}</option>
                    @endforeach
                </select>
                @error('categorie_id') <p class="mt-2 text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Prix (€)</label>
                <input type="number" step="0.01" name="prix" value="{{ old('prix', $produit->prix) }}" required class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-medium text-slate-700">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Stock</label>
                <input type="number" name="stock" value="{{ old('stock', $produit->stock) }}" required class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-medium text-slate-700">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Description</label>
                <textarea name="description" rows="4" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-medium text-slate-700">{{ old('description', $produit->description) }}</textarea>
            </div>
        </div>

        <div class="flex justify-end gap-4 border-t border-slate-50 pt-10">
            <a href="{{ route('produits.index') }}" class="px-8 py-4 bg-slate-100 text-slate-500 rounded-2xl font-bold hover:bg-slate-200 transition-all uppercase tracking-widest text-sm">Annuler</a>
            <button type="submit" class="px-10 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all uppercase tracking-widest text-sm">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection
