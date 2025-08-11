<header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('landing') }}" class="flex items-center space-x-3 group">
                    <div class="relative">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                    </div>
                    <div class="hidden sm:block">
                        <span class="logo-text text-xl font-bold text-white group-hover:text-blue-400 transition-colors">
                            Vet<span class="text-blue-400">Exams</span>
                        </span>
                        <div class="logo-subtext text-xs text-white/80 -mt-1">Exames Digitais</div>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-8">
                <a href="#home" class="nav-link relative group text-white hover:text-blue-300 font-medium transition-colors">
                    Home
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-400 to-blue-500 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#recursos" class="nav-link relative group text-white hover:text-blue-300 font-medium transition-colors">
                    Recursos
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-400 to-blue-500 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#precos" class="nav-link relative group text-white hover:text-blue-300 font-medium transition-colors">
                    Preços
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-400 to-blue-500 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#sobre" class="nav-link relative group text-white hover:text-blue-300 font-medium transition-colors">
                    Sobre
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-400 to-blue-500 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#contato" class="nav-link relative group text-white hover:text-blue-300 font-medium transition-colors">
                    Contato
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-400 to-blue-500 group-hover:w-full transition-all duration-300"></span>
                </a>
            </div>

            <!-- Desktop Action Buttons -->
            <div class="hidden lg:flex items-center space-x-4">
                <!-- Admin Access Dropdown -->
                <div class="relative group">
                    <button class="admin-dropdown-btn flex items-center px-4 py-2 text-white hover:text-blue-300 font-medium transition-all duration-200 rounded-lg hover:bg-white/10 backdrop-blur-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                        </svg>
                        <span>Acesso Admin</span>
                        <svg class="w-4 h-4 ml-1 transform group-hover:rotate-180 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu with Glass Effect -->
                    <div class="absolute right-0 mt-2 w-64 opacity-0 invisible group-hover:opacity-100 group-hover:visible transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                        <div class="backdrop-blur-lg bg-white/95 rounded-xl shadow-2xl border border-white/20 overflow-hidden">
                            <div class="p-2">
                                <a href="{{ route('admin.login') }}" class="flex items-center px-4 py-3 text-sm hover:bg-blue-50/80 rounded-lg transition-all duration-200 group">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 group-hover:text-blue-600">Gestor de Clínica</div>
                                        <div class="text-xs text-gray-500">Painel administrativo</div>
                                    </div>
                                </a>
                                
                                <a href="{{ route('superadmin.login') }}" class="flex items-center px-4 py-3 text-sm hover:bg-red-50/80 rounded-lg transition-all duration-200 group">
                                    <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 group-hover:text-red-600">SuperAdmin</div>
                                        <div class="text-xs text-gray-500">Acesso total ao sistema</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Client Login Button -->
                <a href="{{ route('client.login') }}" class="client-login-btn btn-secondary inline-flex items-center px-4 py-2 border border-white/30 rounded-lg text-white bg-white/10 backdrop-blur-sm hover:bg-white/20 hover:border-white/50 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Área do Cliente
                </a>
                
                <!-- Main CTA Button -->
                <a href="#cta" class="btn-primary inline-flex items-center px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg font-medium shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200" data-track="header_cta_click">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Teste Grátis
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="mobile-menu-btn lg:hidden p-2 rounded-lg text-white hover:text-blue-300 hover:bg-white/10 backdrop-blur-sm transition-all duration-200">
                <svg class="hamburger w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg class="close w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="hidden lg:hidden pb-6 border-t border-gray-200/50 mt-4">
            <div class="backdrop-blur-lg bg-white/95 rounded-xl mt-4 p-4 shadow-xl border border-white/20">
                <div class="flex flex-col space-y-4">
                    <a href="#home" class="nav-link text-gray-700 hover:text-blue-600 font-medium py-2 transition-colors">Home</a>
                    <a href="#recursos" class="nav-link text-gray-700 hover:text-blue-600 font-medium py-2 transition-colors">Recursos</a>
                    <a href="#precos" class="nav-link text-gray-700 hover:text-blue-600 font-medium py-2 transition-colors">Preços</a>
                    <a href="#sobre" class="nav-link text-gray-700 hover:text-blue-600 font-medium py-2 transition-colors">Sobre</a>
                    <a href="#contato" class="nav-link text-gray-700 hover:text-blue-600 font-medium py-2 transition-colors">Contato</a>
                    
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <div class="space-y-3">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Acesso Administrativo</p>
                            
                            <a href="{{ route('admin.login') }}" class="flex items-center p-3 bg-blue-50/80 backdrop-blur-sm rounded-lg hover:bg-blue-100/80 transition-colors">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">Gestor de Clínica</div>
                                    <div class="text-xs text-gray-500">Painel administrativo</div>
                                </div>
                            </a>
                            
                            <a href="{{ route('superadmin.login') }}" class="flex items-center p-3 bg-red-50/80 backdrop-blur-sm rounded-lg hover:bg-red-100/80 transition-colors">
                                <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">SuperAdmin</div>
                                    <div class="text-xs text-gray-500">Acesso total</div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-gray-200 space-y-3">
                            <a href="{{ route('client.login') }}" class="btn-secondary w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white/80 backdrop-blur-sm hover:bg-gray-50/80 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Área do Cliente
                            </a>
                            
                            <a href="#cta" class="btn-primary w-full flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg font-medium shadow-lg" data-track="mobile_header_cta_click">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Teste Grátis
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>