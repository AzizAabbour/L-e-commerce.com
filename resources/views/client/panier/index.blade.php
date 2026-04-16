@extends('layouts.app')

@section('content')
<div class="bg-indigo-600 py-16">
    <div class="max-w-7xl mx-auto px-6">
        <h1 class="text-4xl font-extrabold text-white mb-4">Votre Panier</h1>
        <p class="text-indigo-100 text-lg">Finalisez vos achats et profitez de nos meilleurs produits.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-6 py-12">
    @if(count($cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-6">
                @foreach($cart as $id => $details)
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-50 flex flex-col md:flex-row items-center gap-8 group">
                        <div class="w-24 h-24 bg-slate-50 rounded-2xl overflow-hidden shadow-sm group-hover:scale-105 transition-transform">
                            @if($details['image'])
                                <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['nom'] }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-200">
                                    <i class="fa-solid fa-image text-2xl"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex-1 text-center md:text-left">
                            <h3 class="text-lg font-bold text-slate-800 mb-1">{{ $details['nom'] }}</h3>
                            <div class="text-indigo-600 font-black">{{ number_format($details['prix'], 2) }} DH</div>
                        </div>

                        <div class="flex items-center gap-4 bg-slate-50 rounded-xl p-1">
                            <form action="{{ url('/client/panier/modifier/'.$id) }}" method="POST" class="flex items-center">
                                @csrf
                                @method('PUT')
                                <button type="submit" name="quantite" value="{{ $details['quantite'] - 1 }}" @if($details['quantite'] <= 1) disabled @endif class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-slate-400 hover:text-indigo-600 shadow-sm disabled:opacity-0">
                                    <i class="fa-solid fa-minus text-xs"></i>
                                </button>
                                <span class="w-12 text-center font-bold text-slate-800">{{ $details['quantite'] }}</span>
                                <button type="submit" name="quantite" value="{{ $details['quantite'] + 1 }}" class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-slate-400 hover:text-indigo-600 shadow-sm">
                                    <i class="fa-solid fa-plus text-xs"></i>
                                </button>
                            </form>
                        </div>

                        <div class="text-lg font-black text-slate-900 w-28 text-center md:text-right">
                            {{ number_format($details['prix'] * $details['quantite'], 2) }} DH
                        </div>

                        <form action="{{ url('/client/panier/supprimer/'.$id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-3 text-slate-300 hover:text-rose-500 transition-colors">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                @endforeach

                <div class="flex justify-between items-center pt-8">
                    <a href="{{ url('/client/produits') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i> Continuer mes achats
                    </a>
                </div>
            </div>

            <!-- Summary -->
            <div class="bg-white rounded-[40px] p-10 shadow-xl shadow-indigo-50 border border-slate-50">
                <h2 class="text-2xl font-extrabold text-slate-900 mb-8 uppercase tracking-tight">Récapitulatif</h2>
                
                <div class="space-y-6 mb-10 pb-10 border-b border-slate-100">
                    <div class="flex justify-between text-slate-500 font-medium">
                        <span>Sous-total</span>
                        <span class="text-slate-900 font-bold">{{ number_format($total, 2) }} DH</span>
                    </div>
                    <div class="flex justify-between text-slate-500 font-medium">
                        <span>Livraison</span>
                        <span class="text-emerald-500 font-bold tracking-widest uppercase text-xs">Gratuit</span>
                    </div>
                    @if($total > 1000)
                        <div class="flex justify-between text-slate-500 font-medium bg-indigo-50 p-4 rounded-2xl">
                            <span class="text-indigo-600">Remise (VIP)</span>
                            <span class="text-indigo-600 font-bold">- 50.00 DH</span>
                        </div>
                    @endif
                </div>

                <div class="flex justify-between text-3xl font-black text-slate-900 mb-10">
                    <span>Total</span>
                    <span>{{ number_format($total > 1000 ? $total - 50 : $total, 2) }} DH</span>
                </div>

                <form action="{{ url('/client/commande/valider') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-6 bg-indigo-600 text-white rounded-3xl font-bold text-lg shadow-2xl shadow-indigo-100 hover:bg-slate-900 transition-all uppercase tracking-widest">
                        Passer la commande
                    </button>
                </form>
                
                <div class="mt-8 flex items-center justify-center gap-4 grayscale opacity-40">
                    <i class="fa-brands fa-cc-visa text-3xl"></i>
                    <i class="fa-brands fa-cc-mastercard text-3xl"></i>
                    <i class="fa-brands fa-cc-apple-pay text-3xl"></i>
                    <i class="fa-brands fa-cc-paypal text-3xl"></i>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-40">
            <div class="relative inline-block mb-12">
                <div class="absolute inset-0 bg-indigo-50 rounded-full scale-150 animate-pulse"></div>
                <div class="relative w-32 h-32 bg-white rounded-full flex items-center justify-center text-indigo-600 shadow-xl border border-indigo-100">
                    <i class="fa-solid fa-cart-arrow-down text-5xl"></i>
                </div>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-800 mb-4">Votre panier est vide</h2>
            <p class="text-slate-400 max-w-sm mx-auto mb-12 leading-relaxed">Il semble que vous n'ayez pas encore craqué pour nos superbes articles. On parie que vous allez trouver votre bonheur ?</p>
            <a href="{{ url('/client/produits') }}" class="inline-flex items-center gap-3 px-10 py-5 bg-indigo-600 text-white rounded-2xl font-bold shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all uppercase tracking-widest text-sm">
                Découvrir la collection
            </a>
        </div>
    @endif
</div>
@endsection
