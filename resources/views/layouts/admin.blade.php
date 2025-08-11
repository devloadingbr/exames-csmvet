<!DOCTYPE html>
<html lang="pt-BR" class="h-full" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches) }" x-bind:class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Gestor - VetExams</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/50 dark:from-gray-900 dark:via-gray-800/50 dark:to-slate-900 font-sans antialiased" x-data="{ sidebarOpen: false, mobileMenuOpen: false }">
    <!-- Fixed Sidebar -->
    <aside class="hidden lg:flex lg:flex-col fixed inset-y-0 left-0 z-40 w-80 p-4">
        <!-- Sidebar content -->
        <div class="flex flex-col h-full pt-6 pb-4 glass-sidebar rounded-3xl w-full">
                    <!-- Logo -->
                    <div class="flex items-center justify-center px-6 pb-6 mb-4 border-b-2 border-white/30 dark:border-gray-600/30 mx-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg ring-2 ring-blue-400/30 border border-blue-400/20">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                                    <span class="text-blue-600 dark:text-blue-400">Vet</span>Exams
                                </h1>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Gestor</p>
                            </div>
                        </div>
                    </div>

                    <!-- Clinic info -->
                    <div class="px-6 py-4 mx-4 mb-4 glass-section rounded-2xl border-2">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center ring-2 ring-green-400/30 border border-green-400/20">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                    {{ auth()->user()->clinic->name ?? 'Clínica' }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Plano Professional
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <nav class="px-4 py-4 space-y-3">
                        <a href="{{ route('admin.dashboard') }}" 
                           class="group flex items-center px-4 py-3 mx-2 text-sm font-medium rounded-2xl transition-all duration-200 glass-nav-item @if(request()->routeIs('admin.dashboard')) bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg border-blue-400/30 ring-blue-400/20 @else text-gray-700 dark:text-gray-200 hover:bg-white/50 dark:hover:bg-gray-700/50 @endif">
                            <svg class="mr-4 h-6 w-6 @if(request()->routeIs('admin.dashboard')) text-white @else text-gray-400 group-hover:text-blue-500 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h2a2 2 0 012 2v0a2 2 0 002 2H7a2 2 0 001-2z"/>
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('admin.exams.index') }}" 
                           class="group flex items-center px-4 py-3 mx-2 text-sm font-medium rounded-2xl transition-all duration-200 glass-nav-item @if(request()->routeIs('admin.exams.*')) bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg border-blue-400/30 ring-blue-400/20 @else text-gray-700 dark:text-gray-200 hover:bg-white/50 dark:hover:bg-gray-700/50 @endif">
                            <svg class="mr-4 h-6 w-6 @if(request()->routeIs('admin.exams.*')) text-white @else text-gray-400 group-hover:text-blue-500 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Exames
                        </a>

                        <a href="{{ route('admin.clients.index') }}" 
                           class="group flex items-center px-4 py-3 mx-2 text-sm font-medium rounded-2xl transition-all duration-200 glass-nav-item @if(request()->routeIs('admin.clients.*') || request()->routeIs('admin.pets.*')) bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg border-blue-400/30 ring-blue-400/20 @else text-gray-700 dark:text-gray-200 hover:bg-white/50 dark:hover:bg-gray-700/50 @endif">
                            <svg class="mr-4 h-6 w-6 @if(request()->routeIs('admin.clients.*') || request()->routeIs('admin.pets.*')) text-white @else text-gray-400 group-hover:text-blue-500 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Clientes & Pets
                        </a>

                        <a href="{{ route('admin.exam-types.index') }}" 
                           class="group flex items-center px-4 py-3 mx-2 text-sm font-medium rounded-2xl transition-all duration-200 glass-nav-item @if(request()->routeIs('admin.exam-types.*')) bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg border-blue-400/30 ring-blue-400/20 @else text-gray-700 dark:text-gray-200 hover:bg-white/50 dark:hover:bg-gray-700/50 @endif">
                            <svg class="mr-4 h-6 w-6 @if(request()->routeIs('admin.exam-types.*')) text-white @else text-gray-400 group-hover:text-blue-500 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a1.994 1.994 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Tipos de Exame
                        </a>
                    </nav>

                    <!-- User section -->
                    <div class="px-4 py-4 mx-4 mt-4 glass-section rounded-2xl border-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center ring-2 ring-indigo-400/30 border border-indigo-400/20">
                                    <span class="text-white font-semibold text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                        {{ auth()->user()->name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ ucfirst(auth()->user()->role) }}
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Enhanced Theme toggle -->
                            <div class="relative">
                                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                                        class="relative p-2 w-12 h-12 rounded-xl glass-nav-item hover:bg-white/50 dark:hover:bg-gray-700/50 transition-all duration-500 border hover:border-white/30 dark:hover:border-gray-600/30 overflow-hidden group">
                                    
                                    <!-- Sun Icon -->
                                    <div x-show="!darkMode" 
                                         x-transition:enter="transition-all duration-500 ease-out"
                                         x-transition:enter-start="opacity-0 rotate-180 scale-0"
                                         x-transition:enter-end="opacity-100 rotate-0 scale-100"
                                         x-transition:leave="transition-all duration-300 ease-in"
                                         x-transition:leave-start="opacity-100 rotate-0 scale-100"
                                         x-transition:leave-end="opacity-0 -rotate-90 scale-0"
                                         class="absolute inset-0 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-amber-500 group-hover:text-amber-400 transition-colors duration-300" 
                                             fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.591-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.591z"/>
                                        </svg>
                                    </div>
                                    
                                    <!-- Moon Icon -->
                                    <div x-show="darkMode" 
                                         x-transition:enter="transition-all duration-500 ease-out"
                                         x-transition:enter-start="opacity-0 -rotate-180 scale-0"
                                         x-transition:enter-end="opacity-100 rotate-0 scale-100"
                                         x-transition:leave="transition-all duration-300 ease-in"
                                         x-transition:leave-start="opacity-100 rotate-0 scale-100"
                                         x-transition:leave-end="opacity-0 rotate-90 scale-0"
                                         class="absolute inset-0 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-indigo-400 group-hover:text-indigo-300 transition-colors duration-300" 
                                             fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M9.528 1.718a.75.75 0 01.162.819A8.97 8.97 0 009 6a9 9 0 009 9 8.97 8.97 0 003.463-.69.75.75 0 01.981.98 10.503 10.503 0 01-9.694 6.46c-5.799 0-10.5-4.701-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 01.818.162z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    
                                    <!-- Hover glow effect -->
                                    <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-amber-400/20 to-indigo-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 blur-sm"></div>
                                </button>
                                
                                <!-- Status indicator -->
                                <div class="absolute -top-1 -right-1 w-3 h-3 rounded-full transition-all duration-300"
                                     :class="darkMode ? 'bg-indigo-400 ring-2 ring-indigo-400/30' : 'bg-amber-400 ring-2 ring-amber-400/30'"></div>
                            </div>
                        </div>
                    </div>
        </div>
    </aside>

    <!-- Main content wrapper -->
    <div class="min-h-screen main-content-area">
        <!-- Mobile sidebar overlay -->
        <div x-show="mobileMenuOpen" x-transition class="lg:hidden fixed inset-0 z-50 flex">
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75" @click="mobileMenuOpen = false"></div>
            <div class="relative flex flex-col w-full max-w-xs glass-card">
                <!-- Mobile navigation content -->
                <div class="flex-1 h-0 pt-8 pb-4 overflow-y-auto">
                    <div class="flex items-center justify-center px-6 pb-6 mb-4 border-b-2 border-white/30 dark:border-gray-600/30 mx-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg ring-2 ring-blue-400/30 border border-blue-400/20">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                                    <span class="text-blue-600 dark:text-blue-400">Vet</span>Exams
                                </h1>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Gestor</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile Navigation -->
                    <nav class="px-4 py-4 space-y-3">
                        <a href="{{ route('admin.dashboard') }}" @click="mobileMenuOpen = false"
                           class="group flex items-center px-4 py-3 mx-2 text-sm font-medium rounded-2xl transition-all duration-200 glass-nav-item @if(request()->routeIs('admin.dashboard')) bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg border-blue-400/30 ring-blue-400/20 @else text-gray-700 dark:text-gray-200 hover:bg-white/50 dark:hover:bg-gray-700/50 @endif">
                            <svg class="mr-4 h-6 w-6 @if(request()->routeIs('admin.dashboard')) text-white @else text-gray-400 group-hover:text-blue-500 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h2a2 2 0 012 2v0a2 2 0 002 2H7a2 2 0 001-2z"/>
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('admin.exams.index') }}" @click="mobileMenuOpen = false"
                           class="group flex items-center px-4 py-3 mx-2 text-sm font-medium rounded-2xl transition-all duration-200 glass-nav-item @if(request()->routeIs('admin.exams.*')) bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg border-blue-400/30 ring-blue-400/20 @else text-gray-700 dark:text-gray-200 hover:bg-white/50 dark:hover:bg-gray-700/50 @endif">
                            <svg class="mr-4 h-6 w-6 @if(request()->routeIs('admin.exams.*')) text-white @else text-gray-400 group-hover:text-blue-500 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Exames
                        </a>

                        <a href="{{ route('admin.clients.index') }}" @click="mobileMenuOpen = false"
                           class="group flex items-center px-4 py-3 mx-2 text-sm font-medium rounded-2xl transition-all duration-200 glass-nav-item @if(request()->routeIs('admin.clients.*') || request()->routeIs('admin.pets.*')) bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg border-blue-400/30 ring-blue-400/20 @else text-gray-700 dark:text-gray-200 hover:bg-white/50 dark:hover:bg-gray-700/50 @endif">
                            <svg class="mr-4 h-6 w-6 @if(request()->routeIs('admin.clients.*') || request()->routeIs('admin.pets.*')) text-white @else text-gray-400 group-hover:text-blue-500 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Clientes & Pets
                        </a>

                        <a href="{{ route('admin.exam-types.index') }}" @click="mobileMenuOpen = false"
                           class="group flex items-center px-4 py-3 mx-2 text-sm font-medium rounded-2xl transition-all duration-200 glass-nav-item @if(request()->routeIs('admin.exam-types.*')) bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg border-blue-400/30 ring-blue-400/20 @else text-gray-700 dark:text-gray-200 hover:bg-white/50 dark:hover:bg-gray-700/50 @endif">
                            <svg class="mr-4 h-6 w-6 @if(request()->routeIs('admin.exam-types.*')) text-white @else text-gray-400 group-hover:text-blue-500 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a1.994 1.994 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Tipos de Exame
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex flex-col min-h-screen">
            <!-- Top bar with wrapper -->
            <div class="header-wrapper">
                <header class="glass-header">
                    <div class="px-6 py-4 flex items-center justify-between">
                    <!-- Mobile menu button -->
                    <button @click="mobileMenuOpen = true" class="lg:hidden p-2 rounded-xl glass-nav-item hover:bg-white/50 dark:hover:bg-gray-700/50 border hover:border-white/30 dark:hover:border-gray-600/30 transition-all duration-300">
                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- Breadcrumb -->
                    <div class="flex items-center space-x-2">
                        <nav class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                            </svg>
                            <span class="font-medium text-gray-900 dark:text-white">@yield('breadcrumb', 'Dashboard')</span>
                        </nav>
                    </div>

                    <!-- User actions -->
                    <div class="flex items-center space-x-4">
                        <!-- Quick add button -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="p-2 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 text-white hover:from-blue-600 hover:to-blue-700 transition-colors shadow-lg ring-2 ring-blue-400/30 border border-blue-400/20 hover:ring-blue-400/40">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </button>
                            
                            <!-- Dropdown -->
                            <div x-show="open" x-transition @click.away="open = false" class="absolute right-0 mt-2 w-56 glass-card py-2 z-50">
                                <a href="{{ route('admin.exams.create') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-white/50 dark:hover:bg-gray-700/50 transition-colors">
                                    <svg class="w-4 h-4 mr-3 inline text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Novo Exame
                                </a>
                                <a href="{{ route('admin.clients.create') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-white/50 dark:hover:bg-gray-700/50 transition-colors">
                                    <svg class="w-4 h-4 mr-3 inline text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Novo Cliente
                                </a>
                            </div>
                        </div>

                        <!-- User menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-3 p-2 rounded-xl glass-nav-item hover:bg-white/50 dark:hover:bg-gray-700/50 transition-all duration-300 border hover:border-white/30 dark:hover:border-gray-600/30">
                                <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center ring-2 ring-indigo-400/30 border border-indigo-400/20">
                                    <span class="text-white font-semibold text-xs">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                </div>
                                <span class="text-sm font-medium text-gray-900 dark:text-white hidden sm:block">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- User dropdown -->
                            <div x-show="open" x-transition @click.away="open = false" class="absolute right-0 mt-2 w-48 glass-card py-3 z-50 border-2">
                                <div class="px-4 py-3 mb-2 border-b-2 border-white/30 dark:border-gray-600/30 mx-2">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                                </div>
                                
                                <form method="POST" action="{{ route('admin.logout') }}" class="mt-2">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-white/50 dark:hover:bg-gray-700/50 transition-colors">
                                        <svg class="w-4 h-4 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Sair
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </header>
            </div>

            <!-- Page content -->
            <main class="flex-1 p-6 overflow-y-auto scrollbar-thin">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Unified Toast System -->
    <div x-data="{}" 
         x-show="$store.toast.show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-x-full"
         x-transition:enter-end="opacity-100 transform translate-x-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform translate-x-0"
         x-transition:leave-end="opacity-0 transform translate-x-full"
         class="fixed top-4 right-4 z-50 max-w-sm">
        <div class="glass-card px-6 py-4 border-2 shadow-lg" 
             :class="{
                 'border-green-300/50 bg-green-50/80 text-green-800': $store.toast.type === 'success',
                 'border-red-300/50 bg-red-50/80 text-red-800': $store.toast.type === 'error',
                 'border-blue-300/50 bg-blue-50/80 text-blue-800': $store.toast.type === 'info',
                 'border-yellow-300/50 bg-yellow-50/80 text-yellow-800': $store.toast.type === 'warning'
             }">
            <div class="flex items-center">
                <!-- Success Icon -->
                <template x-if="$store.toast.type === 'success'">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </template>
                
                <!-- Error Icon -->
                <template x-if="$store.toast.type === 'error'">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </template>
                
                <!-- Warning Icon -->
                <template x-if="$store.toast.type === 'warning'">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </template>
                
                <!-- Info Icon -->
                <template x-if="$store.toast.type === 'info'">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </template>
                
                <span class="text-sm font-medium flex-1" x-text="$store.toast.message"></span>
                
                <button @click="$store.toast.hide()" class="ml-4 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        // Alpine.js Integration - Essential inline code only
        document.addEventListener('keydown', function(e) {
            // Escape to close Alpine.js modals/dropdowns
            if (e.key === 'Escape') {
                document.querySelectorAll('[x-data]').forEach(el => {
                    const alpine = Alpine.getScope(el);
                    if (alpine && alpine.open) {
                        alpine.open = false;
                    }
                });
            }
        });

        // Blade session message integration with toast system
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                showToast('{{ session('success') }}', 'success');
            @endif
            
            @if(session('error'))
                showToast('{{ session('error') }}', 'error');
            @endif
            
            @if(session('warning'))
                showToast('{{ session('warning') }}', 'warning');
            @endif
            
            @if(session('info'))
                showToast('{{ session('info') }}', 'info');
            @endif
        });
    </script>
</body>
</html>