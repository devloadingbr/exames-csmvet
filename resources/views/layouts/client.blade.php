<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Portal do Cliente - VetExams</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gradient-to-br from-client-50 via-client-100/30 to-blue-50/20 font-sans antialiased" x-data="{ mobileMenuOpen: false }">
    <!-- Fixed Header -->
    <header class="glass-card sticky top-0 z-50 m-4">
        <div class="container-app">
            <div class="flex items-center justify-between py-4">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-client-500 to-client-600 rounded-2xl flex items-center justify-center shadow-lg ring-2 ring-client-400/30 border border-client-400/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">
                            <span class="text-client-600">Vet</span>Exams
                        </h1>
                        <p class="text-sm text-gray-500">Portal do Cliente</p>
                    </div>
                </div>
                
                <!-- Desktop Navigation -->
                <nav class="hidden md:flex space-x-1" x-data="{ activeRoute: '{{ request()->route()->getName() }}' }">
                    <a href="{{ route('client.dashboard') }}" 
                       class="nav-link {{ request()->routeIs('client.dashboard') ? 'nav-link-active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Meus Exames
                    </a>
                    <a href="{{ route('client.profile.show') }}" 
                       class="nav-link {{ request()->routeIs('client.profile.*') ? 'nav-link-active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Meu Perfil
                    </a>
                </nav>
                
                <!-- User Info & Actions -->
                <div class="flex items-center space-x-3">
                    <!-- Badge Cliente -->
                    <span class="badge badge-info hidden sm:flex">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path>
                        </svg>
                        CLIENTE
                    </span>
                    
                    <!-- Nome do usuário -->
                    <span class="text-sm font-medium text-gray-700 hidden sm:block">
                        {{ auth()->guard('client')->user()->name }}
                    </span>
                    
                    <!-- Logout Button -->
                    <div x-data="logoutHandler">
                        <button @click="logout()" class="btn btn-secondary btn-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="hidden sm:inline">Sair</span>
                        </button>
                        
                        <!-- Hidden Logout Form -->
                        <form id="logout-form" method="POST" action="{{ route('client.logout') }}" class="hidden">
                            @csrf
                        </form>
                    </div>
                    
                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                 class="md:hidden border-t border-gray-200 pt-4 pb-2">
                <nav class="space-y-2">
                    <a href="{{ route('client.dashboard') }}" 
                       class="nav-link block {{ request()->routeIs('client.dashboard') ? 'nav-link-active' : '' }}"
                       @click="mobileMenuOpen = false">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Meus Exames
                    </a>
                    <a href="{{ route('client.profile.show') }}" 
                       class="nav-link block {{ request()->routeIs('client.profile.*') ? 'nav-link-active' : '' }}"
                       @click="mobileMenuOpen = false">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Meu Perfil
                    </a>
                    
                    <!-- Mobile User Info -->
                    <div class="pt-2 border-t border-gray-200 mt-2">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="badge badge-info">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path>
                                </svg>
                                CLIENTE
                            </span>
                            <span class="text-sm text-gray-600">
                                {{ auth()->guard('client')->user()->name }}
                            </span>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="container-app pb-8">
        @yield('content')
    </main>
    
    <!-- Global Toast System -->
    <div x-data="toastSystem" 
         x-show="$store.toast.show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-x-full"
         x-transition:enter-end="opacity-100 transform translate-x-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform translate-x-0"
         x-transition:leave-end="opacity-0 transform translate-x-full"
         class="fixed top-4 right-4 z-50 max-w-sm">
        <div class="glass-card p-4 border-2" 
             :class="{
                 'border-green-300/50 bg-green-50/80': $store.toast.type === 'success',
                 'border-red-300/50 bg-red-50/80': $store.toast.type === 'error',
                 'border-blue-300/50 bg-blue-50/80': $store.toast.type === 'info',
                 'border-yellow-300/50 bg-yellow-50/80': $store.toast.type === 'warning'
             }">
            <div class="flex items-center">
                <template x-if="$store.toast.type === 'success'">
                    <svg class="w-5 h-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </template>
                <template x-if="$store.toast.type === 'error'">
                    <svg class="w-5 h-5 text-red-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </template>
                <template x-if="$store.toast.type === 'info'">
                    <svg class="w-5 h-5 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </template>
                <template x-if="$store.toast.type === 'warning'">
                    <svg class="w-5 h-5 text-yellow-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </template>
                <span class="text-sm font-medium" 
                      :class="{
                          'text-green-800': $store.toast.type === 'success',
                          'text-red-800': $store.toast.type === 'error',
                          'text-blue-800': $store.toast.type === 'info',
                          'text-yellow-800': $store.toast.type === 'warning'
                      }" 
                      x-text="$store.toast.message"></span>
                <button @click="$store.toast.hide()" class="ml-4 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Alpine.js Components -->
    <script>
        // Logout handler component
        Alpine.data('logoutHandler', () => ({
            async logout() {
                if (confirm('Deseja realmente sair do portal?')) {
                    const form = document.getElementById('logout-form');
                    form.submit();
                }
            }
        }));
    </script>
</body>
</html>