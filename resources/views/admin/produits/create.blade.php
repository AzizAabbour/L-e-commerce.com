@extends('layouts.admin')

@section('header', 'Ajouter un Produit')

@section('breadcrumb')
    <li>
        <i class="fa-solid fa-chevron-right mx-2 text-[10px]"></i>
        <a href="{{ route('produits.index') }}" class="hover:text-indigo-600">Produits</a>
    </li>
    <li>
        <i class="fa-solid fa-chevron-right mx-2 text-[10px]"></i>
        <span class="text-slate-900 font-medium">Création</span>
    </li>
@endsection

@section('content')
<div class="max-w-4xl bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <form action="{{ route('produits.store') }}" method="POST" enctype="multipart/form-data" class="p-10">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Nom du Produit</label>
                <input type="text" name="nom_produit" value="{{ old('nom_produit') }}" required class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-medium text-slate-700">
                @error('nom_produit') <p class="mt-2 text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Catégorie</label>
                <select name="categorie_id" required class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-medium text-slate-700 appearance-none">
                    <option value="">Choisir une catégorie</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('categorie_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nom_categorie }}</option>
                    @endforeach
                </select>
                @error('categorie_id') <p class="mt-2 text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Prix (€)</label>
                <input type="number" step="0.01" name="prix" value="{{ old('prix') }}" required class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-medium text-slate-700">
                @error('prix') <p class="mt-2 text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Stock Initial</label>
                <input type="number" name="stock" value="{{ old('stock', 0) }}" required class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-medium text-slate-700">
                @error('stock') <p class="mt-2 text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Image du Produit</label>
                <div class="relative group">
                    <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div class="px-5 py-4 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 group-hover:border-indigo-400 transition-all flex items-center justify-center gap-3 text-slate-400 group-hover:text-indigo-600 font-medium">
                        <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                        <span>Sélectionner une image</span>
                    </div>
                </div>
                @error('image') <p class="mt-2 text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Description</label>
                <textarea name="description" rows="4" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-medium text-slate-700">{{ old('description') }}</textarea>
                @error('description') <p class="mt-2 text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex justify-end gap-4 border-t border-slate-50 pt-10">
            <a href="{{ route('produits.index') }}" class="px-8 py-4 bg-slate-100 text-slate-500 rounded-2xl font-bold hover:bg-slate-200 transition-all uppercase tracking-widest text-xs">Annuler</a>
            <button type="submit" class="px-10 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-xl shadow-indigo-100 hover:bg-slate-900 transition-all uppercase tracking-widest text-xs">
                Créer l'article
            </button>
        </div>
    </form>
</div>
@endsection
