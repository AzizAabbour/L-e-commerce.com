@extends('layouts.admin')

@section('header', 'Gestion des Clients')

@section('breadcrumb')
    <li>
        <i class="fa-solid fa-chevron-right mx-2 text-[10px]"></i>
        <span class="text-slate-900 font-medium">Clients</span>
    </li>
@endsection

@section('content')
<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="px-8 py-6 border-b border-slate-50 flex flex-col md:flex-row justify-between items-center gap-4">
        <h3 class="text-lg font-bold text-slate-800">Base Clients</h3>
        <form action="{{ route('admin.clients.index') }}" method="GET" class="relative w-full md:w-96">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom ou email..." class="w-full pl-12 pr-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-medium text-slate-700">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
        </form>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Identité</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Contact</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Localisation</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Inscrit le</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($clients as $client)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold">
                                    {{ substr($client->name, 0, 1) }}
                                </div>
                                <span class="font-bold text-slate-800">{{ $client->name }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="text-sm font-medium text-slate-600">{{ $client->email }}</div>
                            <div class="text-[10px] text-slate-400 font-bold">{{ $client->phone ?? 'N/A' }}</div>
                        </td>
                        <td class="px-8 py-5">
                            <p class="text-xs text-slate-500 max-w-[200px] truncate">{{ $client->address ?? 'Aucune adresse' }}</p>
                        </td>
                        <td class="px-8 py-5 text-center text-sm text-slate-500">
                            {{ $client->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-8 py-5 text-center">
                            <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Supprimer ce compte client définitivement ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-3 text-rose-300 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all">
                                    <i class="fa-solid fa-user-slash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="px-8 py-6 border-t border-slate-50">
        {{ $clients->links() }}
    </div>
</div>
@endsection
