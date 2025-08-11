@extends('layouts.admin')

@section('title', 'Exames')
@section('breadcrumb', 'Dashboard → Exames')

@section('content')
<div class="space-y-8 animate-fade-in-up">
    <!-- Hero Header -->
    <div class="glass-card p-8 bg-gradient-to-r from-blue-50/50 via-indigo-50/30 to-green-50/50 dark:from-gray-800/50 dark:via-gray-700/30 dark:to-slate-800/50 overflow-hidden relative">
        <!-- Background decoration -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-8 right-8 w-32 h-32 bg-gradient-to-br from-blue-400/20 to-indigo-400/20 rounded-full blur-2xl"></div>
            <div class="absolute bottom-8 left-8 w-24 h-24 bg-gradient-to-br from-green-400/20 to-blue-400/20 rounded-full blur-xl"></div>
        </div>
        
        <div class="relative flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white leading-tight">
                        Gerenciar <span class="bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400 bg-clip-text text-transparent">Exames</span>
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mt-2">
                        Visualize e organize todos os exames da clínica
                    </p>
                </div>
            </div>
            
            <div class="hidden lg:block">
                <a href="{{ route('admin.exams.create') }}" 
                   class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-2xl hover:from-green-600 hover:to-green-700 transition-all duration-300 shadow-xl hover:shadow-2xl hover:shadow-green-500/25 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-3 transform group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Novo Exame
                </a>
            </div>
        </div>
        
        <!-- Mobile button -->
        <div class="lg:hidden mt-6">
            <a href="{{ route('admin.exams.create') }}" 
               class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-2xl hover:from-green-600 hover:to-green-700 transition-colors shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Novo Exame
            </a>
        </div>
    </div>


    <!-- Search & Filters -->
    <div class="glass-card animate-fade-in-up animation-delay-100">
        <div class="p-8 border-b border-white/20 dark:border-gray-700/20">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
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
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Buscar Exames</label>
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
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-200/50 dark:border-gray-600/50 rounded-2xl bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 transition-all text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                                   placeholder="Código do exame, nome do pet ou cliente...">
                        </div>
                    </div>
                    
                    <div class="flex items-end">
                        <button type="submit" 
                                class="w-full px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-2xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-blue-500/25 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Pesquisar
                        </button>
                    </div>
                </div>
                
                <!-- Filter Row -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                        <select id="status" 
                                name="status" 
                                class="block w-full py-3 px-4 border border-gray-200/50 dark:border-gray-600/50 rounded-2xl bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 transition-all text-gray-900 dark:text-white">
                            <option value="">Todos os status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendente</option>
                            <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processando</option>
                            <option value="ready" {{ request('status') === 'ready' ? 'selected' : '' }}>Pronto</option>
                            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Falhou</option>
                        </select>
                    </div>

                    <div>
                        <label for="period" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Período</label>
                        <select id="period" 
                                name="period" 
                                class="block w-full py-3 px-4 border border-gray-200/50 dark:border-gray-600/50 rounded-2xl bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 transition-all text-gray-900 dark:text-white">
                            <option value="">Todos os períodos</option>
                            <option value="today" {{ request('period') === 'today' ? 'selected' : '' }}>Hoje</option>
                            <option value="7days" {{ request('period') === '7days' ? 'selected' : '' }}>Últimos 7 dias</option>
                            <option value="30days" {{ request('period') === '30days' ? 'selected' : '' }}>Últimos 30 dias</option>
                        </select>
                    </div>

                    <div>
                        <label for="exam_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipo</label>
                        <select id="exam_type_id" 
                                name="exam_type_id" 
                                class="block w-full py-3 px-4 border border-gray-200/50 dark:border-gray-600/50 rounded-2xl bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 transition-all text-gray-900 dark:text-white">
                            <option value="">Todos os tipos</option>
                            @foreach($examTypes as $type)
                                <option value="{{ $type->id }}" {{ request('exam_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="flex items-end">
                        <a href="{{ route('admin.exams.index') }}" 
                           class="w-full text-center px-4 py-3 border-2 border-dashed border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 rounded-2xl hover:border-gray-400 dark:hover:border-gray-500 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all font-medium">
                            Limpar Filtros
                        </a>
                    </div>
                </div>
            </form>
        </div>

        @if($exams->count() > 0)
            <!-- Results count -->
            <div class="px-8 py-4 bg-gradient-to-r from-blue-50/30 to-indigo-50/30 dark:from-gray-800/30 dark:to-gray-700/30 border-b border-white/20 dark:border-gray-700/20">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $exams->total() }} {{ $exams->total() === 1 ? 'exame encontrado' : 'exames encontrados' }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Mostrando {{ $exams->firstItem() }}-{{ $exams->lastItem() }} de {{ $exams->total() }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="hidden sm:flex items-center space-x-4 text-xs text-gray-500 dark:text-gray-400">
                        <div class="flex items-center space-x-1">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            <span>Prontos</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                            <span>Processando</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                            <span>Pendentes</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Desktop Table -->
            <div class="hidden lg:block px-8 py-6">
                <div class="overflow-hidden rounded-2xl">
                    <div class="grid gap-4">
                        @foreach($exams as $exam)
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                    'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                    'ready' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                    'failed' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'
                                ];
                                $statusLabels = [
                                    'pending' => 'Pendente',
                                    'processing' => 'Processando',
                                    'ready' => 'Pronto',
                                    'failed' => 'Falhou'
                                ];
                                $statusIcons = [
                                    'pending' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                                    'processing' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15',
                                    'ready' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                                    'failed' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'
                                ];
                            @endphp
                            
                            <!-- Modern Card Layout -->
                            <div class="group glass-card p-6 hover:shadow-2xl transition-all duration-500 transform hover:scale-[1.02]">
                                <div class="flex items-start justify-between mb-4">
                                    <!-- Left Section: Code + Pet/Client -->
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-4 mb-3">
                                            <!-- Exam icon -->
                                            <div class="w-14 h-14 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                                <svg class="w-7 h-7 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-3">
                                                    <a href="{{ route('admin.exams.show', $exam->codigo) }}" 
                                                       class="text-xl font-bold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                                                        {{ $exam->codigo }}
                                                    </a>
                                                    
                                                    <!-- Status badge -->
                                                    <span class="inline-flex items-center px-3 py-1 text-sm font-semibold rounded-full {{ $statusClasses[$exam->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300' }}">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusIcons[$exam->status] ?? 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' }}"></path>
                                                        </svg>
                                                        {{ $statusLabels[$exam->status] ?? $exam->status }}
                                                    </span>
                                                </div>
                                                
                                                <div class="mt-2 space-y-1">
                                                    <div class="flex items-center text-gray-900 dark:text-white">
                                                        <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                        </svg>
                                                        <span class="font-semibold">{{ $exam->pet->name }}</span>
                                                    </div>
                                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                                        <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                        </svg>
                                                        <span>{{ $exam->client->name }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Right Section: Actions -->
                                    <div class="flex items-center space-x-2 ml-4">
                                        <a href="{{ route('admin.exams.show', $exam->codigo) }}" 
                                           class="p-2 text-blue-600 dark:text-blue-400 hover:text-white hover:bg-blue-500 rounded-xl transition-all duration-200 shadow-sm hover:shadow-lg" title="Ver detalhes">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        
                                        @if($exam->status === 'ready')
                                            <a href="{{ route('admin.exams.download', $exam->codigo) }}" 
                                               class="p-2 text-green-600 dark:text-green-400 hover:text-white hover:bg-green-500 rounded-xl transition-all duration-200 shadow-sm hover:shadow-lg" title="Download">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </a>
                                        @endif
                                        
                                        <a href="{{ route('admin.exams.edit', $exam->codigo) }}" 
                                           class="p-2 text-indigo-600 dark:text-indigo-400 hover:text-white hover:bg-indigo-500 rounded-xl transition-all duration-200 shadow-sm hover:shadow-lg" title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        
                                        <form action="{{ route('admin.exams.destroy', $exam->codigo) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este exame?')">
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
                                <div class="grid grid-cols-4 gap-4 pt-4 border-t border-white/20 dark:border-gray-700/20">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $exam->examType->color }}"></div>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $exam->examType->name }}</span>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Data</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $exam->exam_date->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Tamanho</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $exam->formatted_size }}</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Downloads</p>
                                        <div class="flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $exam->downloads->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Mobile/Tablet Cards -->
            <div class="block lg:hidden px-6 py-6">
                <div class="space-y-6">
                    @foreach($exams as $exam)
                        @php
                            $statusClasses = [
                                'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                'ready' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                'failed' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'
                            ];
                            $statusLabels = [
                                'pending' => 'Pendente',
                                'processing' => 'Processando',
                                'ready' => 'Pronto',
                                'failed' => 'Falhou'
                            ];
                        @endphp
                        
                        <div class="glass-card p-6 space-y-4">
                            <!-- Header -->
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <div class="w-10 h-10 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 rounded-xl flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.exams.show', $exam->codigo) }}" 
                                               class="text-lg font-bold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                                                {{ $exam->codigo }}
                                            </a>
                                            <div class="flex items-center space-x-2 mt-1">
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $exam->pet->name }}</span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">•</span>
                                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $exam->client->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full {{ $statusClasses[$exam->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300' }}">
                                    {{ $statusLabels[$exam->status] ?? $exam->status }}
                                </span>
                            </div>
                            
                            <!-- Details -->
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <div class="flex items-center text-gray-600 dark:text-gray-400 mb-1">
                                        <div class="w-2 h-2 rounded-full mr-2" style="background-color: {{ $exam->examType->color }}"></div>
                                        <span>{{ $exam->examType->name }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $exam->exam_date->format('d/m/Y') }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-gray-600 dark:text-gray-400 mb-1">Tamanho: {{ $exam->formatted_size }}</div>
                                    <div class="flex items-center text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        {{ $exam->downloads->count() }} downloads
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex items-center justify-between pt-4 border-t border-white/20 dark:border-gray-700/20">
                                <div class="flex space-x-4">
                                    <a href="{{ route('admin.exams.show', $exam->codigo) }}" 
                                       class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium text-sm">
                                        Ver Detalhes
                                    </a>
                                    @if($exam->status === 'ready')
                                        <a href="{{ route('admin.exams.download', $exam->codigo) }}" 
                                           class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 font-medium text-sm">
                                            Download
                                        </a>
                                    @endif
                                </div>
                                
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.exams.edit', $exam->codigo) }}" 
                                       class="p-2 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-900/30 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Pagination -->
            @if($exams->hasPages())
                <div class="px-8 py-6 border-t border-white/20 dark:border-gray-700/20">
                    <div class="flex items-center justify-center">
                        {{ $exams->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="px-8 py-16">
                <div class="text-center">
                    <div class="w-32 h-32 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-3xl mx-auto mb-8 flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        @if(request()->hasAny(['search', 'status', 'period', 'exam_type_id']))
                            Nenhum exame encontrado
                        @else
                            Ainda não há exames
                        @endif
                    </h3>
                    
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">
                        @if(request()->hasAny(['search', 'status', 'period', 'exam_type_id']))
                            Tente ajustar os filtros de busca para encontrar os exames desejados.
                        @else
                            Comece enviando o primeiro exame da clínica para ver o histórico aqui.
                        @endif
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 items-center justify-center">
                        @if(request()->hasAny(['search', 'status', 'period', 'exam_type_id']))
                            <a href="{{ route('admin.exams.index') }}" 
                               class="inline-flex items-center px-6 py-3 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-2xl hover:border-gray-400 dark:hover:border-gray-500 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Limpar Filtros
                            </a>
                        @endif
                        
                        <a href="{{ route('admin.exams.create') }}" 
                           class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-green-500 to-green-600 text-white font-bold rounded-2xl hover:from-green-600 hover:to-green-700 transition-all shadow-xl hover:shadow-2xl hover:shadow-green-500/25 transform hover:scale-105">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            {{ request()->hasAny(['search', 'status', 'period', 'exam_type_id']) ? 'Novo Exame' : 'Enviar Primeiro Exame' }}
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection