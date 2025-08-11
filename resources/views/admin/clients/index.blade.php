@extends('layouts.admin')

@section('title', 'Clientes')
@section('breadcrumb', 'Dashboard → Clientes & Pets')

@section('content')
<div class="space-y-8 animate-fade-in-up">
    <!-- Hero Header -->
    <div class="glass-card p-8 bg-gradient-to-r from-purple-50/50 via-pink-50/30 to-orange-50/50 dark:from-gray-800/50 dark:via-gray-700/30 dark:to-slate-800/50 overflow-hidden relative">
        <!-- Background decoration -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-8 right-8 w-32 h-32 bg-gradient-to-br from-purple-400/20 to-pink-400/20 rounded-full blur-2xl"></div>
            <div class="absolute bottom-8 left-8 w-24 h-24 bg-gradient-to-br from-orange-400/20 to-red-400/20 rounded-full blur-xl"></div>
        </div>
        
        <div class="relative flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white leading-tight">
                        Gerenciar <span class="bg-gradient-to-r from-purple-600 to-pink-600 dark:from-purple-400 dark:to-pink-400 bg-clip-text text-transparent">Clientes</span>
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mt-2">
                        Visualize e organize todos os tutores cadastrados
                    </p>
                </div>
            </div>
            
            <div class="hidden lg:block">
                <a href="{{ route('admin.clients.create') }}" 
                   class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold rounded-2xl hover:from-purple-600 hover:to-purple-700 transition-all duration-300 shadow-xl hover:shadow-2xl hover:shadow-purple-500/25 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-3 transform group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Novo Cliente
                </a>
            </div>
        </div>
        
        <!-- Mobile button -->
        <div class="lg:hidden mt-6">
            <a href="{{ route('admin.clients.create') }}" 
               class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold rounded-2xl hover:from-purple-600 hover:to-purple-700 transition-colors shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Novo Cliente
            </a>
        </div>
    </div>


    <!-- Search & Filters -->
    <div class="glass-card animate-fade-in-up animation-delay-100">
        <div class="p-8 border-b border-white/20 dark:border-gray-700/20">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Pesquisa & Filtros</h3>
            </div>
            
            <form method="GET" class="space-y-6">
                <!-- Search Row -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Buscar Clientes</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" 
                                   id="search" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-200/50 dark:border-gray-600/50 rounded-2xl bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:focus:ring-purple-400 transition-all text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                                   placeholder="Nome do cliente, CPF ou email...">
                        </div>
                    </div>
                    
                    <div class="flex items-end">
                        <button type="submit" 
                                class="w-full px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold rounded-2xl hover:from-purple-600 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-purple-500/25 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Pesquisar
                        </button>
                    </div>
                </div>
                
                <!-- Filter Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                        <select id="status" 
                                name="status" 
                                class="block w-full py-3 px-4 border border-gray-200/50 dark:border-gray-600/50 rounded-2xl bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:focus:ring-purple-400 transition-all text-gray-900 dark:text-white">
                            <option value="">Todos os status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Clientes Ativos</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Clientes Inativos</option>
                        </select>
                    </div>
                    
                    <div class="flex items-end">
                        <a href="{{ route('admin.clients.index') }}" 
                           class="w-full text-center px-4 py-3 border-2 border-dashed border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 rounded-2xl hover:border-gray-400 dark:hover:border-gray-500 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all font-medium">
                            Limpar Filtros
                        </a>
                    </div>
                </div>
            </form>
        </div>

        @if($clients->count() > 0)
            <!-- Results count -->
            <div class="px-8 py-4 bg-gradient-to-r from-purple-50/30 to-pink-50/30 dark:from-gray-800/30 dark:to-gray-700/30 border-b border-white/20 dark:border-gray-700/20">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $clients->total() }} {{ $clients->total() === 1 ? 'cliente encontrado' : 'clientes encontrados' }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Mostrando {{ $clients->firstItem() }}-{{ $clients->lastItem() }} de {{ $clients->total() }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="hidden sm:flex items-center space-x-4 text-xs text-gray-500 dark:text-gray-400">
                        <div class="flex items-center space-x-1">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            <span>Ativos</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <div class="w-2 h-2 bg-orange-500 rounded-full"></div>
                            <span>Com pets</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                            <span>Com exames</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Desktop Cards -->
            <div class="hidden lg:block px-8 py-6">
                <div class="grid gap-4">
                        @foreach($clients as $client)
                            <!-- Modern Client Card -->
                            <div class="group glass-card p-6 hover:shadow-2xl transition-all duration-500 transform hover:scale-[1.02]">
                                <div class="flex items-start justify-between mb-4">
                                    <!-- Left Section: Client Info -->
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-4 mb-3">
                                            <!-- Client avatar -->
                                            <div class="w-14 h-14 bg-gradient-to-br from-purple-100 to-purple-200 dark:from-purple-700 dark:to-purple-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                                <span class="text-xl font-bold text-purple-600 dark:text-purple-300">
                                                    {{ strtoupper(substr($client->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-3 mb-2">
                                                    <a href="{{ route('admin.clients.show', $client) }}" 
                                                       class="text-xl font-bold text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 transition-colors">
                                                        {{ $client->name }}
                                                    </a>
                                                    
                                                    @if($client->pets_count > 0 || $client->exams_count > 0)
                                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                            <div class="w-2 h-2 bg-green-500 rounded-full mr-1 animate-pulse"></div>
                                                            Ativo
                                                        </span>
                                                    @endif
                                                </div>
                                                
                                                <div class="space-y-1">
                                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                                        </svg>
                                                        <span class="font-medium">{{ $client->cpf }}</span>
                                                    </div>
                                                    @if($client->email)
                                                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                                                            <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                            </svg>
                                                            <span>{{ $client->email }}</span>
                                                        </div>
                                                    @endif
                                                    @if($client->phone)
                                                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                                                            <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                            </svg>
                                                            <span>{{ $client->phone }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Right Section: Actions -->
                                    <div class="flex items-center space-x-2 ml-4">
                                        <a href="{{ route('admin.clients.show', $client) }}" 
                                           class="p-2 text-blue-600 dark:text-blue-400 hover:text-white hover:bg-blue-500 rounded-xl transition-all duration-200 shadow-sm hover:shadow-lg" title="Ver detalhes">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        
                                        <a href="{{ route('admin.clients.edit', $client) }}" 
                                           class="p-2 text-indigo-600 dark:text-indigo-400 hover:text-white hover:bg-indigo-500 rounded-xl transition-all duration-200 shadow-sm hover:shadow-lg" title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        
                                        <a href="{{ route('admin.pets.create', ['client_id' => $client->id]) }}" 
                                           class="p-2 text-orange-600 dark:text-orange-400 hover:text-white hover:bg-orange-500 rounded-xl transition-all duration-200 shadow-sm hover:shadow-lg" title="Adicionar Pet">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.clients.destroy', $client) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este cliente?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 dark:text-red-400 hover:text-white hover:bg-red-500 rounded-xl transition-all duration-200 shadow-sm hover:shadow-lg" title="Excluir">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                
                                <!-- Bottom info row -->
                                <div class="grid grid-cols-3 gap-4 pt-4 border-t border-white/20 dark:border-gray-700/20">
                                    <div class="text-center">
                                        <div class="flex items-center justify-center mb-1">
                                            <svg class="w-4 h-4 text-orange-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                            <span class="text-lg font-bold text-orange-600 dark:text-orange-400">{{ $client->pets_count }}</span>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Pets</p>
                                    </div>
                                    <div class="text-center">
                                        <div class="flex items-center justify-center mb-1">
                                            <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ $client->exams_count }}</span>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Exames</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $client->created_at->format('d/m/Y') }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Cadastro</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                </div>
            </div>

            <!-- Mobile/Tablet Cards -->
            <div class="block lg:hidden px-6 py-6">
                <div class="space-y-6">
                    @foreach($clients as $client)
                        <div class="glass-card p-6 space-y-4">
                            <!-- Header -->
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <div class="w-10 h-10 bg-gradient-to-br from-purple-100 to-purple-200 dark:from-purple-700 dark:to-purple-600 rounded-xl flex items-center justify-center">
                                            <span class="text-lg font-bold text-purple-600 dark:text-purple-300">
                                                {{ strtoupper(substr($client->name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.clients.show', $client) }}" 
                                               class="text-lg font-bold text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300">
                                                {{ $client->name }}
                                            </a>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $client->cpf }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($client->pets_count > 0 || $client->exams_count > 0)
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        <div class="w-2 h-2 bg-green-500 rounded-full mr-1 animate-pulse"></div>
                                        Ativo
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Contact Details -->
                            @if($client->email || $client->phone)
                                <div class="space-y-2">
                                    @if($client->email)
                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                            <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>{{ $client->email }}</span>
                                        </div>
                                    @endif
                                    @if($client->phone)
                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                            <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            <span>{{ $client->phone }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            
                            <!-- Stats -->
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <div class="text-center">
                                    <div class="flex items-center justify-center text-orange-600 dark:text-orange-400 mb-1">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                        <span class="font-bold">{{ $client->pets_count }}</span>
                                    </div>
                                    <span class="text-gray-500 dark:text-gray-400">Pets</span>
                                </div>
                                <div class="text-center">
                                    <div class="flex items-center justify-center text-green-600 dark:text-green-400 mb-1">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span class="font-bold">{{ $client->exams_count }}</span>
                                    </div>
                                    <span class="text-gray-500 dark:text-gray-400">Exames</span>
                                </div>
                                <div class="text-center">
                                    <div class="text-gray-900 dark:text-white font-bold mb-1">{{ $client->created_at->format('d/m/Y') }}</div>
                                    <span class="text-gray-500 dark:text-gray-400">Cadastro</span>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex items-center justify-between pt-4 border-t border-white/20 dark:border-gray-700/20">
                                <div class="flex space-x-4">
                                    <a href="{{ route('admin.clients.show', $client) }}" 
                                       class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium text-sm">
                                        Ver Detalhes
                                    </a>
                                    <a href="{{ route('admin.clients.edit', $client) }}" 
                                       class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-medium text-sm">
                                        Editar
                                    </a>
                                </div>
                                
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.pets.create', ['client_id' => $client->id]) }}" 
                                       class="p-2 text-orange-600 dark:text-orange-400 hover:bg-orange-100 dark:hover:bg-orange-900/30 rounded-lg transition-colors" title="Adicionar Pet">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Pagination -->
            @if($clients->hasPages())
                <div class="px-8 py-6 border-t border-white/20 dark:border-gray-700/20">
                    <div class="flex items-center justify-center">
                        {{ $clients->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="px-8 py-16">
                <div class="text-center">
                    <div class="w-32 h-32 bg-gradient-to-br from-purple-100 to-purple-200 dark:from-gray-800 dark:to-gray-700 rounded-3xl mx-auto mb-8 flex items-center justify-center">
                        <svg class="w-16 h-16 text-purple-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        @if(request()->hasAny(['search', 'status']))
                            Nenhum cliente encontrado
                        @else
                            Ainda não há clientes
                        @endif
                    </h3>
                    
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">
                        @if(request()->hasAny(['search', 'status']))
                            Tente ajustar os filtros de busca para encontrar os clientes desejados.
                        @else
                            Comece cadastrando o primeiro cliente da clínica para gerenciar tutores e pets.
                        @endif
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 items-center justify-center">
                        @if(request()->hasAny(['search', 'status']))
                            <a href="{{ route('admin.clients.index') }}" 
                               class="inline-flex items-center px-6 py-3 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-2xl hover:border-gray-400 dark:hover:border-gray-500 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Limpar Filtros
                            </a>
                        @endif
                        
                        <a href="{{ route('admin.clients.create') }}" 
                           class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-bold rounded-2xl hover:from-purple-600 hover:to-purple-700 transition-all shadow-xl hover:shadow-2xl hover:shadow-purple-500/25 transform hover:scale-105">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            {{ request()->hasAny(['search', 'status']) ? 'Novo Cliente' : 'Cadastrar Primeiro Cliente' }}
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection