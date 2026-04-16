<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VirtualStore') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full flex flex-col font-sans antialiased text-slate-900 border-t-4 border-indigo-600">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50 px-6 py-4" x-data="{ mobileMenu: false }">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <!-- Logo -->
            <a href="/" class="flex items-center gap-2 group">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-200 group-hover:bg-indigo-700 transition-all">
                    <i class="fa-solid fa-bolt text-xl"></i>
                </div>
                <span class="text-2xl font-extrabold tracking-tight text-slate-800">VIRTUAL<span class="text-indigo-600 uppercase">Store</span></span>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center space-x-8">
                <a href="{{ url('/client/home') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors uppercase tracking-widest">Accueil</a>
                <a href="{{ url('/client/produits') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors uppercase tracking-widest">Boutique</a>
                <a href="{{ url('/client/souhaits') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors uppercase tracking-widest">Mes Souhaits</a>
            </div>

            <!-- Icons/Profile -->
            <div class="flex items-center space-x-5">
                <!-- Search (Desktop) -->
                <button class="hidden sm:block p-2 text-slate-400 hover:text-indigo-600 transition-colors">
                    <i class="fa-solid fa-magnifying-glass text-lg"></i>
                </button>

                <!-- Cart -->
                <a href="{{ url('/client/panier') }}" class="relative p-2.5 bg-slate-50 rounded-xl text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all group">
                    <i class="fa-solid fa-bag-shopping text-xl"></i>
                    @php $cartCount = count(session('cart', [])); @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white group-hover:scale-110 transition-transform shadow-sm">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <!-- User Dropdown (Breeze Style) -->
                @auth
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center px-4 py-2 border border-slate-200 text-sm font-medium rounded-xl text-slate-700 bg-white hover:bg-slate-50 focus:outline-none transition-all">
                                    <div class="w-7 h-7 bg-indigo-100 rounded-full flex items-center justify-center mr-2 text-indigo-700">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="url('/client/commandes')">
                                    {{ __('Mes Commandes') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profil') }}
                                </x-dropdown-link>
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Déconnexion') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:inline-block px-5 py-2.5 text-sm font-bold text-indigo-600 hover:text-indigo-700 transition-colors uppercase tracking-widest">Se connecter</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 hover:shadow-indigo-200 transition-all uppercase tracking-widest">S'inscrire</a>
                @endauth

                <!-- Mobile Menu Button -->
                <button @click="mobileMenu = !mobileMenu" class="lg:hidden p-2 text-slate-600 hover:text-indigo-600">
                    <i class="fa-solid fa-bars-staggered text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenu" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="lg:hidden mt-6 pb-4 border-t border-slate-100">
            <div class="flex flex-col space-y-4 pt-6">
                <a href="{{ url('/client/home') }}" class="text-sm font-bold text-slate-700 hover:text-indigo-600 uppercase tracking-widest">Accueil</a>
                <a href="{{ url('/client/produits') }}" class="text-sm font-bold text-slate-700 hover:text-indigo-600 uppercase tracking-widest">Boutique</a>
                <a href="{{ url('/client/souhaits') }}" class="text-sm font-bold text-slate-700 hover:text-indigo-600 uppercase tracking-widest">Mes Souhaits</a>
                @auth
                    <a href="{{ url('/client/commandes') }}" class="text-sm font-bold text-slate-700 hover:text-indigo-600 uppercase tracking-widest">Mes Commandes</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-6 mt-6">
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-2xl flex items-center gap-4">
                    <i class="fa-solid fa-circle-check text-xl text-emerald-400"></i>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-6 mt-6">
                <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-2xl flex items-center gap-4">
                    <i class="fa-solid fa-circle-exclamation text-xl text-red-400"></i>
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-100 mt-20 py-12">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="col-span-2">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white">
                        <i class="fa-solid fa-bolt text-sm"></i>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-800 uppercase">VirtualStore</span>
                </div>
                <p class="text-slate-500 leading-relaxed max-w-sm">La meilleure expérience d'achat en ligne avec une sélection pointue des meilleurs articles pour votre quotidien.</p>
            </div>
            <div>
                <h4 class="font-bold text-slate-800 mb-6 uppercase tracking-widest text-sm">Navigation</h4>
                <ul class="space-y-4">
                    <li><a href="/" class="text-slate-500 hover:text-indigo-600 transition-colors">Accueil</a></li>
                    <li><a href="/client/produits" class="text-slate-500 hover:text-indigo-600 transition-colors">Produits</a></li>
                    <li><a href="/client/panier" class="text-slate-500 hover:text-indigo-600 transition-colors">Panier</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-slate-800 mb-6 uppercase tracking-widest text-sm">Contact</h4>
                <ul class="space-y-4">
                    <li class="flex items-center gap-3 text-slate-500"><i class="fa-solid fa-phone text-indigo-400"></i> +212 522 00 00 00</li>
                    <li class="flex items-center gap-3 text-slate-500"><i class="fa-solid fa-envelope text-indigo-400"></i> contact@virtualstore.com</li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 pt-12 mt-12 border-t border-slate-50 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-slate-400 text-sm">© {{ date('Y') }} VirtualStore. Tous droits réservés.</p>
            <div class="flex gap-6">
                <a href="#" class="text-slate-400 hover:text-indigo-600 transition-colors"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" class="text-slate-400 hover:text-indigo-600 transition-colors"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="text-slate-400 hover:text-indigo-600 transition-colors"><i class="fa-brands fa-twitter"></i></a>
            </div>
        </div>
    </footer>
</body>
</html>
