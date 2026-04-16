@extends('layouts.admin')

@section('header', 'Gestion des Produits')

@section('breadcrumb')
    <li>
        <i class="fa-solid fa-chevron-right mx-2 text-[10px]"></i>
        <span class="text-slate-900 font-medium">Produits</span>
    </li>
@endsection

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
        <h3 class="text-lg font-bold text-slate-800">Liste des Articles</h3>
        <a href="{{ route('produits.create') }}" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl text-xs font-bold uppercase tracking-widest shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all">
            <i class="fa-solid fa-plus mr-2"></i> Ajouter un Produit
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Article</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Catégorie</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Stock</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Prix</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($produits as $produit)
                    <tr class="hover:bg-indigo-50/20 transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0">
                                    @if($produit->image)
                                        <img src="{{ asset('storage/'.$produit->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                            <i class="fa-solid fa-image"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800">{{ $produit->nom_produit }}</div>
                                    <div class="text-[10px] text-slate-400 font-medium">ID: #{{ $produit->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-[10px] font-bold uppercase">
                                {{ $produit->categorie->nom_categorie ?? 'Général' }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            @if($produit->stock <= 5)
                                <span class="text-rose-600 font-black">{{ $produit->stock }}</span>
                                <div class="text-[8px] text-rose-400 font-bold uppercase">Alerte</div>
                            @else
                                <span class="text-slate-600 font-bold">{{ $produit->stock }}</span>
                            @endif
                        </td>
                        <td class="px-8 py-5 text-right font-black text-slate-900">
                            {{ number_format($produit->prix, 2) }} DH
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('produits.edit', $produit->id) }}" class="p-2.5 text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-600 hover:text-white transition-all">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('produits.destroy', $produit->id) }}" method="POST" onsubmit="return confirm('Supprimer ce produit ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2.5 text-rose-600 bg-rose-50 rounded-lg hover:bg-rose-600 hover:text-white transition-all">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="px-8 py-6 border-t border-slate-50">
        {{ $produits->links() }}
    </div>
</div>
@endsection
