@extends('layouts.admin')

@section('header', 'Gestion des Catégories')

@section('breadcrumb')
    <li>
        <i class="fa-solid fa-chevron-right mx-2 text-[10px]"></i>
        <span class="text-slate-900 font-medium">Catégories</span>
    </li>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Add Category Form -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
            <h3 class="text-lg font-bold text-slate-800 mb-6 uppercase tracking-tight">Nouvelle Catégorie</h3>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Nom de la Catégorie</label>
                    <input type="text" name="nom_categorie" required class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-medium text-slate-700">
                </div>
                <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-slate-900 transition-all uppercase tracking-widest text-xs">
                    Enregistrer
                </button>
            </form>
        </div>
    </div>

    <!-- Categories List -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center w-20">ID</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Désignation</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($categories as $cat)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-5 text-center font-bold text-slate-400">#{{ $cat->id }}</td>
                            <td class="px-8 py-5 font-black text-slate-800 text-lg uppercase tracking-tight">{{ $cat->nom_categorie }}</td>
                            <td class="px-8 py-5">
                                <div class="flex items-center justify-center gap-2">
                                    <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Attention: cela supprimera tous les produits liés à cette catégorie. Continuer ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-3 text-rose-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all">
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
    </div>
</div>
@endsection
