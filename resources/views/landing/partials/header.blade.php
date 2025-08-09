<header class="fixed top-0 left-0 right-0 bg-white shadow-sm z-50 transition-all duration-300">
    <div class="container">
        <nav class="flex items-center justify-between py-4">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('landing') }}" class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-900">VetExams</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-8">
                <a href="#home" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Home</a>
                <a href="#recursos" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Recursos</a>
                <a href="#precos" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Preços</a>
                <a href="#sobre" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Sobre</a>
                <a href="#contato" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Contato</a>
            </div>

            <!-- Desktop Action Buttons -->
            <div class="hidden lg:flex items-center space-x-3">
                <!-- Dropdown for Admin Access -->
                <div class="relative group">
                    <button class="flex items-center text-gray-700 hover:text-blue-600 font-medium transition-colors px-3 py-2 rounded-lg hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                        </svg>
                        Acesso Admin
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 transform translate-y-2 group-hover:translate-y-0">
                        <div class="py-2">
                            <a href="{{ route('admin.login') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                <svg class="w-4 h-4 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <div>
                                    <div class="font-medium">Gestor de Clínica</div>
                                    <div class="text-xs text-gray-500">Painel administrativo</div>
                                </div>
                            </a>
                            <a href="{{ route('superadmin.login') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                                <svg class="w-4 h-4 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <div>
                                    <div class="font-medium">SuperAdmin</div>
                                    <div class="text-xs text-gray-500">Acesso total ao sistema</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('client.login') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Área do Cliente
                </a>
                <a href="#cta" class="btn btn-primary" data-track="header_cta_click">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Teste Grátis
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="lg:hidden p-2 text-gray-700 hover:text-blue-600 transition-colors">
                <svg class="hamburger w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg class="close w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </nav>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="hidden lg:hidden pb-4 border-t border-gray-200 mt-4">
            <div class="flex flex-col space-y-4 pt-4">
                <a href="#home" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Home</a>
                <a href="#recursos" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Recursos</a>
                <a href="#precos" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Preços</a>
                <a href="#sobre" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Sobre</a>
                <a href="#contato" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Contato</a>
                
                <div class="flex flex-col space-y-3 pt-4 border-t border-gray-200">
                    <!-- Admin Access Section -->
                    <div class="pb-3 border-b border-gray-100">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Acesso Administrativo</p>
                        <div class="space-y-2">
                            <a href="{{ route('admin.login') }}" class="flex items-center p-3 text-sm text-gray-700 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                <svg class="w-4 h-4 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <div>
                                    <div class="font-medium">Gestor de Clínica</div>
                                    <div class="text-xs text-gray-500">Painel administrativo</div>
                                </div>
                            </a>
                            <a href="{{ route('superadmin.login') }}" class="flex items-center p-3 text-sm text-gray-700 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                                <svg class="w-4 h-4 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <div>
                                    <div class="font-medium">SuperAdmin</div>
                                    <div class="text-xs text-gray-500">Acesso total ao sistema</div>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Client Access -->
                    <a href="{{ route('client.login') }}" class="btn btn-secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Área do Cliente
                    </a>
                    <a href="#cta" class="btn btn-primary" data-track="mobile_header_cta_click">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Teste Grátis
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
/* Header specific styles */
header.scrolled {
    background-color: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

/* Mobile menu animation */
#mobile-menu {
    transition: all 0.3s ease;
}

#mobile-menu.hidden {
    max-height: 0;
    opacity: 0;
    overflow: hidden;
}

#mobile-menu:not(.hidden) {
    max-height: 500px;
    opacity: 1;
}
</style>
