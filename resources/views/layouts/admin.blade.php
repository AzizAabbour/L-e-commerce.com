<!DOCTYPE html>
<html lang="fr" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel Admin') }} - Espace Admin</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="h-full overflow-hidden" x-data="{ sidebarOpen: false }">
    <div class="flex h-full">
        <!-- Sidebar for Mobile -->
        <div x-show="sidebarOpen" class="fixed inset-0 z-40 flex md:hidden" role="dialog" aria-modal="true">
            <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-600 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            
            <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative flex w-full max-w-xs flex-1 flex-col bg-slate-900 pt-5 pb-4">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button @click="sidebarOpen = false" type="button" class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Close sidebar</span>
                        <i class="fa-solid fa-xmark text-white text-xl"></i>
                    </button>
                </div>
                
                <div class="flex flex-shrink-0 items-center px-4">
                    <span class="text-white text-2xl font-bold italic tracking-wider">STORE<span class="text-indigo-400">ADMIN</span></span>
                </div>
                <div class="mt-5 h-0 flex-1 overflow-y-auto">
                    <nav class="space-y-1 px-2">
                        <x-admin-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" icon="fa-gauge">Dashboard</x-admin-nav-link>
                        <x-admin-nav-link :href="route('produits.index')" :active="request()->routeIs('produits.*')" icon="fa-box">Produits</x-admin-nav-link>
                        <x-admin-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')" icon="fa-tags">Catégories</x-admin-nav-link>
                        <x-admin-nav-link :href="route('admin.clients.index')" :active="request()->routeIs('admin.clients.*')" icon="fa-users">Clients</x-admin-nav-link>
                        <x-admin-nav-link :href="route('admin.commandes.index')" :active="request()->routeIs('admin.commandes.*')" icon="fa-shopping-bag">Commandes</x-admin-nav-link>
                        <x-admin-nav-link :href="route('admin.rapports.index')" :active="request()->routeIs('admin.rapports.*')" icon="fa-chart-line">Rapports</x-admin-nav-link>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Static Sidebar for Desktop -->
        <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
            <div class="flex flex-col flex-grow bg-slate-900 pt-5 overflow-y-auto">
                <div class="flex items-center flex-shrink-0 px-4 mb-6">
                    <span class="text-white text-2xl font-bold italic tracking-wider">STORE<span class="text-indigo-400">ADMIN</span></span>
                </div>
                <div class="flex-grow flex flex-col">
                    <nav class="flex-1 px-2 pb-4 space-y-1">
                        <x-admin-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" icon="fa-gauge">Dashboard</x-admin-nav-link>
                        <x-admin-nav-link :href="route('produits.index')" :active="request()->routeIs('produits.*')" icon="fa-box">Produits</x-admin-nav-link>
                        <x-admin-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')" icon="fa-tags">Catégories</x-admin-nav-link>
                        <x-admin-nav-link :href="route('admin.clients.index')" :active="request()->routeIs('admin.clients.*')" icon="fa-users">Clients</x-admin-nav-link>
                        <x-admin-nav-link :href="route('admin.commandes.index')" :active="request()->routeIs('admin.commandes.*')" icon="fa-shopping-bag">Commandes</x-admin-nav-link>
                        <x-admin-nav-link :href="route('admin.rapports.index')" :active="request()->routeIs('admin.rapports.*')" icon="fa-chart-line">Rapports</x-admin-nav-link>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 md:pl-64 h-full">
            <div class="sticky top-0 z-10 flex h-16 flex-shrink-0 bg-white shadow">
                <button @click="sidebarOpen = true" type="button" class="border-r border-slate-200 px-4 text-slate-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden">
                    <span class="sr-only">Open sidebar</span>
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                
                <div class="flex flex-1 justify-between px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-1 items-center">
                        <h1 class="text-xl font-semibold text-slate-800">
                            @yield('header', 'Administration')
                        </h1>
                    </div>
                    <div class="ml-4 flex items-center md:ml-6">
                        <div class="flex items-center gap-3">
                            <span class="hidden md:inline-block text-sm font-medium text-slate-700">{{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="rounded-full bg-indigo-100 p-2 text-indigo-600 hover:text-indigo-900 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <main class="flex-1 overflow-y-auto focus:outline-none">
                <div class="py-6 px-4 sm:px-6 lg:px-8">
                    <!-- Breadcrumbs Placeholder -->
                    <div class="mb-6 flex" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2 text-sm text-slate-500">
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600">Admin</a>
                            </li>
                            @yield('breadcrumb')
                        </ol>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 rounded-md bg-emerald-50 p-4 border border-emerald-200">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fa-solid fa-circle-check text-emerald-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 rounded-md bg-red-50 p-4 border border-red-200">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fa-solid fa-circle-xmark text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
