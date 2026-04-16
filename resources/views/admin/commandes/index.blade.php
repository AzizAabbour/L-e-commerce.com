@extends('layouts.admin')

@section('header', 'Gestion des Commandes')

@section('breadcrumb')
    <li>
        <i class="fa-solid fa-chevron-right mx-2 text-[10px]"></i>
        <span class="text-slate-900 font-medium">Commandes</span>
    </li>
@endsection

@section('content')
<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/20">
        <form action="{{ route('admin.commandes.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Statut</label>
                <select name="statut" class="px-5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500">
                    <option value="">Tous les statuts</option>
                    <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="expediee" {{ request('statut') == 'expediee' ? 'selected' : '' }}>Expédiée</option>
                    <option value="livree" {{ request('statut') == 'livree' ? 'selected' : '' }}>Livrée</option>
                    <option value="annulee" {{ request('statut') == 'annulee' ? 'selected' : '' }}>Annulée</option>
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Date</label>
                <input type="date" name="date" value="{{ request('date') }}" class="px-5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700">
            </div>
            <button type="submit" class="px-8 py-2.5 bg-slate-900 text-white rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-indigo-600 transition-all">Filtrer</button>
            <a href="{{ route('admin.commandes.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-400 rounded-xl text-xs font-bold uppercase hover:bg-slate-200 transition-all">Reset</a>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50">
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">ID</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Client</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Date</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Statut</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Montant</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($commandes as $cmd)
                    <tr class="hover:bg-indigo-50/20 transition-colors">
                        <td class="px-8 py-5 font-black text-indigo-600">#{{ str_pad($cmd->id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-8 py-5">
                            <div class="font-bold text-slate-800">{{ $cmd->user->name }}</div>
                            <div class="text-[10px] text-slate-400 font-bold uppercase">{{ $cmd->user->email }}</div>
                        </td>
                        <td class="px-8 py-5 text-sm text-slate-500 font-medium">
                            {{ $cmd->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-8 py-5 text-center">
                            @php
                                $colors = [
                                    'en_attente' => 'bg-amber-100 text-amber-600 border-amber-200',
                                    'expediee' => 'bg-blue-100 text-blue-600 border-blue-200',
                                    'livree' => 'bg-emerald-100 text-emerald-600 border-emerald-200',
                                    'annulee' => 'bg-rose-100 text-rose-600 border-rose-200',
                                ];
                            @endphp
                            <span class="px-3 py-1.5 border rounded-full text-[10px] font-black uppercase {{ $colors[$cmd->statut] }}">
                                {{ str_replace('_', ' ', $cmd->statut) }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right font-black text-slate-900 text-lg">
                            {{ number_format($cmd->total, 2) }} DH
                        </td>
                        <td class="px-8 py-5 text-center">
                            <a href="{{ route('admin.commandes.show', $cmd->id) }}" class="p-3 text-indigo-600 bg-indigo-100 rounded-xl hover:bg-slate-900 hover:text-white transition-all">
                                <i class="fa-solid fa-eye text-sm"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="px-8 py-6 border-t border-slate-50">
        {{ $commandes->links() }}
    </div>
</div>
@endsection
