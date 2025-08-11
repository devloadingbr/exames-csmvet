@extends('layouts.client')

@section('title', 'Meus Exames')

@section('content')
<!-- Hero Welcome Section -->
<div class="glass-card p-8 mb-8 bg-gradient-to-r from-client-50/50 via-client-100/30 to-blue-50/50 overflow-hidden relative animate-fade-in-up">
    <!-- Background decoration -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-8 right-8 w-32 h-32 bg-gradient-to-br from-client-400/20 to-blue-400/20 rounded-full blur-2xl"></div>
        <div class="absolute bottom-8 left-8 w-24 h-24 bg-gradient-to-br from-green-400/20 to-client-400/20 rounded-full blur-xl"></div>
    </div>
    
    <div class="relative flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div class="flex-1">
            <div class="flex items-center space-x-4 mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-client-500 to-client-600 rounded-2xl flex items-center justify-center shadow-xl ring-2 ring-client-400/30 border border-client-400/20">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 leading-tight">
                        Olá, <span class="bg-gradient-to-r from-client-600 to-blue-600 bg-clip-text text-transparent">{{ explode(' ', $client->name)[0] }}</span>! 🐕
                    </h1>
                    <p class="text-lg lg:text-xl text-gray-600 mt-2">
                        Seus exames estão prontos para download
                    </p>
                </div>
            </div>
            <p class="text-gray-500 text-lg">
                {{ now()->format('l, d \d\e F \d\e Y') }} • {{ now()->format('H:i') }}
            </p>
        </div>
        
        <!-- Quick stats preview -->
        <div class="flex lg:grid lg:grid-cols-2 gap-4 lg:gap-6 overflow-x-auto lg:overflow-visible">
            <div class="text-center flex-shrink-0">
                <div class="text-2xl lg:text-3xl font-bold text-client-600 tabular-nums">{{ $stats['total_exams'] }}</div>
                <div class="text-xs lg:text-sm text-gray-500 whitespace-nowrap">Total Exames</div>
            </div>
            <div class="text-center flex-shrink-0">
                <div class="text-2xl lg:text-3xl font-bold text-green-600 tabular-nums">{{ $stats['exams_this_month'] }}</div>
                <div class="text-xs lg:text-sm text-gray-500 whitespace-nowrap">Este Mês</div>
            </div>
            <div class="text-center flex-shrink-0">
                <div class="text-2xl lg:text-3xl font-bold text-purple-600 tabular-nums">{{ $stats['pets_with_exams'] }}</div>
                <div class="text-xs lg:text-sm text-gray-500 whitespace-nowrap">Pets</div>
            </div>
            <div class="text-center flex-shrink-0">
                <div class="text-2xl lg:text-3xl font-bold text-orange-600 tabular-nums">{{ $stats['total_downloads'] }}</div>
                <div class="text-xs lg:text-sm text-gray-500 whitespace-nowrap">Downloads</div>
            </div>
        </div>
    </div>
</div>

<!-- Premium Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Exames Card -->
    <div class="dashboard-stat-card group animate-fade-in-up animation-delay-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 bg-gradient-to-br from-client-500 to-client-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-client-500/25 group-hover:scale-110 transition-all duration-300 ring-2 ring-client-400/30 border border-client-400/20 group-hover:animate-pulse-glow">
                <svg class="w-7 h-7 text-white transition-transform duration-300 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div class="text-right">
                <div class="text-3xl font-bold text-client-600 group-hover:text-client-700 group-hover:scale-110 tabular-nums transition-all duration-300">{{ $stats['total_exams'] }}</div>
                <div class="text-sm text-gray-500 transition-all duration-300 group-hover:text-green-500">
                    {{ $stats['exams_this_month'] > 0 ? '+' . $stats['exams_this_month'] . ' este mês' : 'Nenhum este mês' }}
                </div>
            </div>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-client-700 transition-colors">Exames Disponíveis</h3>
        <p class="text-sm text-gray-600 group-hover:text-gray-700 transition-colors">Prontos para download</p>
    </div>
    
    <!-- Este Mês Card -->
    <div class="dashboard-stat-card group animate-fade-in-up animation-delay-200">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-green-500/25 group-hover:scale-110 transition-all duration-300 ring-2 ring-green-400/30 border border-green-400/20 group-hover:animate-pulse-glow">
                <svg class="w-7 h-7 text-white transition-transform duration-300 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div class="text-right">
                <div class="text-3xl font-bold text-green-600 group-hover:text-green-700 group-hover:scale-110 tabular-nums transition-all duration-300">{{ $stats['exams_this_month'] }}</div>
                <div class="text-sm text-gray-500 transition-all duration-300 group-hover:text-blue-500">
                    {{ date('F Y') }}
                </div>
            </div>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-green-700 transition-colors">Este Mês</h3>
        <p class="text-sm text-gray-600 group-hover:text-gray-700 transition-colors">Exames recentes</p>
    </div>
    
    <!-- Pets Card -->
    <div class="dashboard-stat-card group animate-fade-in-up animation-delay-300">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-purple-500/25 group-hover:scale-110 transition-all duration-300 ring-2 ring-purple-400/30 border border-purple-400/20 group-hover:animate-pulse-glow">
                <svg class="w-7 h-7 text-white transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </div>
            <div class="text-right">
                <div class="text-3xl font-bold text-purple-600 group-hover:text-purple-700 group-hover:scale-110 tabular-nums transition-all duration-300">{{ $stats['pets_with_exams'] }}</div>
                <div class="text-sm text-gray-500 transition-all duration-300 group-hover:text-pink-500">
                    Com exames
                </div>
            </div>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-purple-700 transition-colors">Pets</h3>
        <p class="text-sm text-gray-600 group-hover:text-gray-700 transition-colors">Seus companheiros</p>
    </div>
    
    <!-- Downloads Card -->
    <div class="dashboard-stat-card group animate-fade-in-up animation-delay-400">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-orange-500/25 group-hover:scale-110 transition-all duration-300 ring-2 ring-orange-400/30 border border-orange-400/20 group-hover:animate-pulse-glow">
                <svg class="w-7 h-7 text-white transition-transform duration-300 group-hover:-rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div class="text-right">
                <div class="text-3xl font-bold text-orange-600 group-hover:text-orange-700 group-hover:scale-110 tabular-nums transition-all duration-300">{{ $stats['total_downloads'] }}</div>
                <div class="text-sm text-gray-500 transition-all duration-300 group-hover:text-indigo-500">
                    Total realizados
                </div>
            </div>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-orange-700 transition-colors">Downloads</h3>
        <p class="text-sm text-gray-600 group-hover:text-gray-700 transition-colors">Arquivos baixados</p>
    </div>
</div>

<!-- Modern Filters Section -->
<div class="glass-card mb-8 animate-fade-in-up animation-delay-500" x-data="clientFilters">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg ring-2 ring-indigo-400/30 border border-indigo-400/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Filtrar Exames</h3>
                @if(count(array_filter($currentFilters)) > 0)
                    <span class="badge badge-info">
                        {{ count(array_filter($currentFilters)) }} {{ count(array_filter($currentFilters)) == 1 ? 'filtro ativo' : 'filtros ativos' }}
                    </span>
                @endif
            </div>
            <button @click="toggleFilters()" class="btn btn-secondary btn-sm">
                <svg class="w-4 h-4 mr-2 transition-transform duration-200" :class="{ 'rotate-180': filtersOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
                <span x-text="filtersOpen ? 'Ocultar Filtros' : 'Mostrar Filtros'"></span>
            </button>
        </div>
        
        <form id="filtersForm" method="GET" x-show="filtersOpen" 
              x-transition:enter="transition ease-out duration-300"
              x-transition:enter-start="opacity-0 transform -translate-y-2"
              x-transition:enter-end="opacity-100 transform translate-y-0"
              x-transition:leave="transition ease-in duration-200"
              x-transition:leave-start="opacity-100 transform translate-y-0"
              x-transition:leave-end="opacity-0 transform -translate-y-2"
              class="space-y-6">
            
            <!-- Search com ícone -->
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-client-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" name="search" 
                       class="form-input pl-12 transition-all duration-200 hover:border-client-300 focus:border-client-500 focus:ring-client-500" 
                       placeholder="Buscar por código, pet ou descrição..."
                       value="{{ $currentFilters['search'] }}">
            </div>
            
            <!-- Grid de filtros -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Pet Filter -->
                <div class="space-y-2">
                    <label class="form-label flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        Pet
                    </label>
                    <select name="pet_id" class="form-select transition-all duration-200 hover:border-client-300 focus:border-client-500 focus:ring-client-500">
                        <option value="">Todos os pets</option>
                        @foreach($filterOptions['pets'] as $pet)
                            <option value="{{ $pet->id }}" {{ $currentFilters['pet_id'] == $pet->id ? 'selected' : '' }}>
                                {{ $pet->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Exam Type Filter -->
                <div class="space-y-2">
                    <label class="form-label flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                        Tipo de Exame
                    </label>
                    <select name="exam_type_id" class="form-select transition-all duration-200 hover:border-client-300 focus:border-client-500 focus:ring-client-500">
                        <option value="">Todos os tipos</option>
                        @foreach($filterOptions['examTypes'] as $type)
                            <option value="{{ $type->id }}" {{ $currentFilters['exam_type_id'] == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Sort Options -->
                <div class="space-y-2">
                    <label class="form-label flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                        </svg>
                        Ordenar por
                    </label>
                    <select name="sort_by" class="form-select transition-all duration-200 hover:border-client-300 focus:border-client-500 focus:ring-client-500">
                        <option value="exam_date" {{ $currentFilters['sort_by'] == 'exam_date' ? 'selected' : '' }}>Data do Exame</option>
                        <option value="codigo" {{ $currentFilters['sort_by'] == 'codigo' ? 'selected' : '' }}>Código</option>
                        <option value="created_at" {{ $currentFilters['sort_by'] == 'created_at' ? 'selected' : '' }}>Data de Criação</option>
                    </select>
                </div>
            </div>
            
            <!-- Linha adicional de filtros -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Date From -->
                <div class="space-y-2">
                    <label class="form-label flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Data inicial
                    </label>
                    <input type="date" name="date_from" 
                           class="form-input transition-all duration-200 hover:border-client-300 focus:border-client-500 focus:ring-client-500"
                           value="{{ $currentFilters['date_from'] }}">
                </div>
                
                <!-- Date To -->
                <div class="space-y-2">
                    <label class="form-label flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Data final
                    </label>
                    <input type="date" name="date_to" 
                           class="form-input transition-all duration-200 hover:border-client-300 focus:border-client-500 focus:ring-client-500"
                           value="{{ $currentFilters['date_to'] }}">
                </div>
                
                <!-- Sort Direction -->
                <div class="space-y-2">
                    <label class="form-label flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                        </svg>
                        Direção
                    </label>
                    <select name="sort_direction" class="form-select transition-all duration-200 hover:border-client-300 focus:border-client-500 focus:ring-client-500">
                        <option value="desc" {{ $currentFilters['sort_direction'] == 'desc' ? 'selected' : '' }}>Mais Recente</option>
                        <option value="asc" {{ $currentFilters['sort_direction'] == 'asc' ? 'selected' : '' }}>Mais Antigo</option>
                    </select>
                </div>
                
                <!-- Items Per Page -->
                <div class="space-y-2">
                    <label class="form-label flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        Itens por página
                    </label>
                    <select name="per_page" class="form-select transition-all duration-200 hover:border-client-300 focus:border-client-500 focus:ring-client-500">
                        <option value="12" {{ $currentFilters['per_page'] == 12 ? 'selected' : '' }}>12 itens</option>
                        <option value="24" {{ $currentFilters['per_page'] == 24 ? 'selected' : '' }}>24 itens</option>
                    </select>
                </div>
            </div>
            
            <!-- Actions com animação hover -->
            <div class="flex justify-center gap-4 pt-6 border-t border-gray-200">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Filtrar Exames
                </button>
                <a href="{{ route('client.dashboard') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Limpar Filtros
                </a>
            </div>
        </form>
    </div>
</div>

@if($exams->count() > 0)
    <!-- Results Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 animate-fade-in-up animation-delay-600">
        <div class="mb-4 md:mb-0">
            <h3 class="text-2xl font-bold text-gray-900 mb-2">
                <span class="bg-gradient-to-r from-client-600 to-blue-600 bg-clip-text text-transparent">
                    Seus Exames
                </span>
                <span class="text-gray-600 text-lg font-normal">({{ $exams->total() }} {{ $exams->total() == 1 ? 'resultado' : 'resultados' }})</span>
            </h3>
            <p class="text-gray-500">
                Mostrando {{ $exams->firstItem() }}-{{ $exams->lastItem() }} de {{ $exams->total() }} exames
            </p>
        </div>
        <div class="flex items-center space-x-2 text-sm text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Clique em um cartão para ver detalhes
        </div>
    </div>
    
    <!-- Premium Exams Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($exams as $index => $exam)
        <article class="glass-card hover-lift hover-glow cursor-pointer group transition-all duration-500 animate-fade-in-up"
                 style="animation-delay: {{ (($index % 9) + 1) * 100 }}ms"
                 onclick="viewExam('{{ $exam->codigo }}')"
                 x-data="clientDownloads">
            
            <!-- Card Header -->
            <div class="relative p-6 pb-4">
                <!-- Badge flutuante -->
                <div class="absolute top-4 right-4 z-10">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-white shadow-lg transition-transform duration-200 group-hover:scale-110"
                          style="background: {{ $exam->examType->color ?? 'rgb(116 185 255)' }}">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                        {{ $exam->examType->name }}
                    </span>
                </div>
                
                <!-- Código do exame com gradiente -->
                <div class="mb-4">
                    <div class="text-2xl font-bold bg-gradient-to-r from-client-600 to-blue-600 bg-clip-text text-transparent transition-all duration-300 group-hover:scale-105">
                        {{ $exam->codigo }}
                    </div>
                    <div class="text-sm text-gray-500 flex items-center mt-1">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $exam->exam_date->format('d/m/Y') }}
                    </div>
                </div>
            </div>
            
            <!-- Card Content -->
            <div class="px-6 pb-4">
                <div class="space-y-3 text-sm text-gray-600">
                    <!-- Pet Info -->
                    <div class="flex items-center group/item">
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-100 to-purple-200 rounded-full flex items-center justify-center mr-3 transition-all duration-300 group-hover/item:scale-110">
                            <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">{{ $exam->pet->name }}</div>
                            <div class="text-xs text-gray-500">Pet</div>
                        </div>
                    </div>
                    
                    @if($exam->veterinarian_name)
                    <!-- Veterinarian Info -->
                    <div class="flex items-center group/item">
                        <div class="w-8 h-8 bg-gradient-to-br from-green-100 to-green-200 rounded-full flex items-center justify-center mr-3 transition-all duration-300 group-hover/item:scale-110">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">Dr. {{ $exam->veterinarian_name }}</div>
                            <div class="text-xs text-gray-500">Veterinário</div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- File Size Info -->
                    <div class="flex items-center group/item">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center mr-3 transition-all duration-300 group-hover/item:scale-110">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">{{ $exam->formatted_size }}</div>
                            <div class="text-xs text-gray-500">Tamanho do arquivo</div>
                        </div>
                    </div>
                </div>
                
                @if($exam->description)
                <!-- Description -->
                <div class="mt-4 p-3 bg-gradient-to-r from-gray-50 to-gray-100/50 rounded-lg border border-gray-200/50">
                    <p class="text-xs text-gray-600 italic leading-relaxed">
                        {{ \Str::limit($exam->description, 120) }}
                    </p>
                </div>
                @endif
            </div>
            
            <!-- Card Actions -->
            <div class="px-6 pb-6">
                <div class="flex gap-3">
                    <button @click.stop="downloadExam('{{ $exam->codigo }}')"
                            :disabled="isDownloading('{{ $exam->codigo }}')"
                            :class="{ 'opacity-50 cursor-not-allowed': isDownloading('{{ $exam->codigo }}') }"
                            class="btn btn-primary btn-sm flex-1 group-hover:shadow-lg transition-all duration-300 relative overflow-hidden">
                        <!-- Loading shimmer effect -->
                        <div x-show="isDownloading('{{ $exam->codigo }}')" class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent animate-shimmer"></div>
                        <svg class="w-4 h-4 mr-2 transition-transform duration-200" :class="{ 'animate-spin': isDownloading('{{ $exam->codigo }}') }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!isDownloading('{{ $exam->codigo }}')" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            <path x-show="isDownloading('{{ $exam->codigo }}')" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span x-text="isDownloading('{{ $exam->codigo }}') ? 'Baixando...' : 'Baixar PDF'"></span>
                    </button>
                    
                    <button @click.stop="viewExam('{{ $exam->codigo }}')"
                            class="btn btn-secondary btn-sm flex-1 group-hover:shadow-md transition-all duration-300">
                        <svg class="w-4 h-4 mr-2 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Ver Detalhes
                    </button>
                </div>
            </div>
        </article>
        @endforeach
    </div>

    <!-- Modern Pagination -->
    <div class="flex justify-center animate-fade-in-up animation-delay-1000">
        <div class="glass-card p-4">
            {{ $exams->links() }}
        </div>
    </div>
@else
    <!-- Premium Empty State -->
    <div class="glass-card p-12 text-center animate-fade-in-up">
        <div class="max-w-md mx-auto">
            <!-- Empty state illustration -->
            <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if(array_filter($currentFilters))
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    @endif
                </svg>
            </div>
            
            <h3 class="text-2xl font-bold text-gray-900 mb-4">
                @if(array_filter($currentFilters))
                    Nenhum exame encontrado
                @else
                    Ainda não há exames
                @endif
            </h3>
            
            <p class="text-gray-600 mb-6 leading-relaxed">
                @if(array_filter($currentFilters))
                    Nenhum exame corresponde aos filtros selecionados.<br>
                    Tente ajustar os critérios de busca ou remova alguns filtros.
                @else
                    Não há exames disponíveis para download no momento.<br>
                    Entre em contato com a clínica para mais informações.
                @endif
            </p>
            
            @if(array_filter($currentFilters))
                <a href="{{ route('client.dashboard') }}" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Limpar Todos os Filtros
                </a>
            @else
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('client.profile.show') }}" class="btn btn-secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Ver Meu Perfil
                    </a>
                    <button onclick="window.location.reload()" class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Atualizar Página
                    </button>
                </div>
            @endif
        </div>
    </div>
@endif

<!-- Legacy Alpine.js Components - DEPRECATED -->
<script>
    // Note: These components are deprecated and replaced by modular Alpine.js
    // Keeping for backward compatibility during migration
    
    // Legacy download wrapper
    Alpine.data('legacyExamCard', () => ({
        // Redirect to new modular component
        downloadExam(codigo) {
            // Use global store from new architecture
            if (window.Alpine?.store) {
                const clientDownloads = window.Alpine.evaluate(document.body, '{}', { $el: document.body });
                return window.Alpine._x_dataStack[0]?.downloadExam?.(codigo);
            }
        }
    }));
</script>

<!-- Auto-submit functionality -->
<script>
    // Global functions for backward compatibility
    function downloadExam(codigo) {
        // Use new modular Alpine.js component
        const examCard = document.querySelector('[x-data="clientDownloads"]');
        if (examCard && window.Alpine) {
            const component = window.Alpine.getScope(examCard);
            if (component && component.downloadExam) {
                component.downloadExam(codigo);
            } else {
                // Fallback to direct download
                window.open(`/client/exams/${codigo}/download`, '_blank');
            }
        } else {
            // Fallback
            window.open(`/client/exams/${codigo}/download`, '_blank');
        }
    }
    
    function viewExam(codigo) {
        window.location.href = `/client/exams/${codigo}`;
    }
    
    // Enhanced auto-submit with better UX
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('filtersForm');
        if (!form) return;
        
        const inputs = form.querySelectorAll('select, input[type="date"]');
        const searchInput = form.querySelector('input[name="search"]');
        
        // Auto-submit for selects and date inputs
        inputs.forEach(input => {
            input.addEventListener('change', function() {
                // Add loading state
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>Filtrando...';
                }
                
                form.submit();
            });
        });
        
        // Search input with improved debounce
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value;
                
                // Visual feedback
                this.style.borderColor = '#f59e0b';
                
                searchTimeout = setTimeout(() => {
                    this.style.borderColor = '';
                    form.submit();
                }, 800); // Increased timeout for better UX
            });
        }
    });
</script>
</script>
@endsection