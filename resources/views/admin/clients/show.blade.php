@extends('layouts.admin')

@section('title', 'Cliente: ' . $client->name)
@section('breadcrumb', 'Dashboard → Clientes → ' . $client->name)

@section('content')
<div class="space-y-8 animate-fade-in-up">
    <!-- Hero Header -->
    <div class="glass-card p-8 bg-gradient-to-r from-blue-50/50 via-indigo-50/30 to-purple-50/50 dark:from-gray-800/50 dark:via-gray-700/30 dark:to-slate-800/50 overflow-hidden relative">
        <!-- Background decoration -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-8 right-8 w-32 h-32 bg-gradient-to-br from-blue-400/20 to-indigo-400/20 rounded-full blur-2xl"></div>
            <div class="absolute bottom-8 left-8 w-24 h-24 bg-gradient-to-br from-indigo-400/20 to-purple-400/20 rounded-full blur-xl"></div>
        </div>
        
        <div class="relative flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.clients.index') }}" 
                   class="w-12 h-12 bg-gradient-to-br from-gray-500 to-gray-600 rounded-2xl flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white leading-tight">
                        {{ $client->name }}
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mt-2">
                        CPF: {{ $client->cpf }}
                    </p>
                </div>
            </div>
            
            <div class="hidden lg:flex space-x-3">
                <a href="{{ route('admin.clients.edit', $client) }}" 
                   class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-2xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 shadow-xl hover:shadow-2xl hover:shadow-blue-500/25 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2 transform group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar
                </a>

                <a href="{{ route('admin.pets.create', ['client_id' => $client->id]) }}" 
                   class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-2xl hover:from-green-600 hover:to-green-700 transition-all duration-300 shadow-xl hover:shadow-2xl hover:shadow-green-500/25 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2 transform group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Pet
                </a>

                <a href="{{ route('admin.exams.create', ['client_id' => $client->id]) }}" 
                   class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold rounded-2xl hover:from-purple-600 hover:to-purple-700 transition-all duration-300 shadow-xl hover:shadow-2xl hover:shadow-purple-500/25 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2 transform group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Exame
                </a>
            </div>
        </div>
        
        <!-- Mobile buttons -->
        <div class="lg:hidden mt-6 flex flex-wrap gap-3">
            <a href="{{ route('admin.clients.edit', $client) }}" 
               class="inline-flex items-center px-4 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-2xl hover:from-blue-600 hover:to-indigo-700 transition-colors shadow-lg">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Editar
            </a>
            <a href="{{ route('admin.pets.create', ['client_id' => $client->id]) }}" 
               class="inline-flex items-center px-4 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-2xl hover:from-green-600 hover:to-green-700 transition-colors shadow-lg">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Pet
            </a>
            <a href="{{ route('admin.exams.create', ['client_id' => $client->id]) }}" 
               class="inline-flex items-center px-4 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold rounded-2xl hover:from-purple-600 hover:to-purple-700 transition-colors shadow-lg">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Exame
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="glass-card p-6 bg-gradient-to-r from-green-50/80 via-emerald-50/60 to-teal-50/80 dark:from-green-900/30 dark:via-emerald-900/20 dark:to-teal-900/30 animate-fade-in-up animation-delay-100">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-green-800 dark:text-green-200">Sucesso!</h3>
                    <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Client Information -->
            <div class="glass-card animate-fade-in-up animation-delay-200">
                <div class="px-8 py-6 border-b border-white/20 dark:border-gray-700/20">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Informações do Cliente</h3>
                    </div>
                </div>
                <div class="px-8 py-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nome</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $client->name }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">CPF</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $client->cpf }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $client->email ?: 'Não informado' }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Telefone</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $client->phone ?: 'Não informado' }}</dd>
                        </div>
                        
                        @if($client->birth_date)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Data de Nascimento</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $client->birth_date->format('d/m/Y') }}</dd>
                            </div>
                        @endif
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Cliente desde</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $client->created_at->format('d/m/Y') }}</dd>
                        </div>
                        
                        @if($client->last_login_at)
                            <div class="md:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Último acesso</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $client->last_login_at->format('d/m/Y H:i') }}</dd>
                            </div>
                        @endif
                    </dl>

                    @if($client->address)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <dt class="text-sm font-medium text-gray-500 mb-2">Endereço</dt>
                            <dd class="text-sm text-gray-900">{{ $client->address }}</dd>
                        </div>
                    @endif

                    @if($client->notes)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <dt class="text-sm font-medium text-gray-500 mb-2">Observações</dt>
                            <dd class="text-sm text-gray-900">{{ $client->notes }}</dd>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pets -->
            <div class="glass-card animate-fade-in-up animation-delay-300">
                <div class="px-8 py-6 border-b border-white/20 dark:border-gray-700/20 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Pets</h3>
                        <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-full text-sm font-semibold">
                            {{ $client->pets->count() }}
                        </span>
                    </div>
                    <a href="{{ route('admin.pets.create', ['client_id' => $client->id]) }}" 
                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-emerald-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Adicionar
                    </a>
                </div>
                <div class="px-8 py-6">
                    @if($client->pets->count() > 0)
                        <div class="grid grid-cols-1 gap-4">
                            @foreach($client->pets as $index => $pet)
                                <div class="group glass-card p-6 hover:shadow-2xl hover:shadow-green-500/10 transform hover:scale-105 transition-all duration-500 animate-fade-in-up animation-delay-{{ min($index * 100 + 400, 900) }}">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-3">
                                                <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 rounded-2xl flex items-center justify-center shadow-lg mr-4">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h4 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                                                        {{ $pet->name }}
                                                    </h4>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                                        {{ $pet->species }}
                                                        @if($pet->breed) - {{ $pet->breed }} @endif
                                                        @if($pet->gender) • {{ $pet->gender }} @endif
                                                    </p>
                                                </div>
                                            </div>
                                            
                                            <div class="flex items-center justify-between">
                                                <div class="space-y-1">
                                                    @if($pet->birth_date)
                                                        <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                            {{ $pet->birth_date->format('d/m/Y') }}
                                                        </p>
                                                    @endif
                                                    <p class="text-xs text-green-600 dark:text-green-400 font-semibold flex items-center">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                        </svg>
                                                        {{ $pet->exams->count() }} exames
                                                    </p>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('admin.pets.edit', $pet) }}" 
                                                       class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl transition-all duration-200"
                                                       title="Editar">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('admin.pets.destroy', $pet) }}" 
                                                          method="POST" 
                                                          class="inline"
                                                          onsubmit="return confirm('Tem certeza que deseja excluir este pet?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all duration-200"
                                                                title="Excluir">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="w-24 h-24 bg-gradient-to-br from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 rounded-3xl mx-auto mb-6 flex items-center justify-center">
                                <svg class="w-12 h-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Nenhum pet cadastrado</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">
                                Cadastre o primeiro pet para começar o acompanhamento veterinário.
                            </p>
                            <a href="{{ route('admin.pets.create', ['client_id' => $client->id]) }}" 
                               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-2xl hover:from-green-600 hover:to-emerald-700 transition-all duration-300 shadow-xl hover:shadow-2xl hover:shadow-green-500/25 transform hover:scale-105">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Cadastrar Primeiro Pet
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Exams History -->
            <div class="glass-card animate-fade-in-up animation-delay-400">
                <div class="px-8 py-6 border-b border-white/20 dark:border-gray-700/20">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Histórico de Exames</h3>
                        <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 rounded-full text-sm font-semibold">
                            {{ $client->exams->count() }}
                        </span>
                    </div>
                </div>
                <div class="px-8 py-6">
                    @if($client->exams->count() > 0)
                        <div class="overflow-x-auto">
                            <div class="glass-card p-6 bg-gradient-to-r from-gray-50/80 via-white/60 to-gray-50/80 dark:from-gray-800/50 dark:via-gray-700/30 dark:to-gray-800/50">
                                <div class="overflow-hidden">
                                    <table class="min-w-full">
                                        <thead>
                                            <tr class="border-b border-purple-200/50 dark:border-purple-700/30">
                                                <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 dark:text-purple-300 uppercase tracking-wider">Código</th>
                                                <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 dark:text-purple-300 uppercase tracking-wider">Pet</th>
                                                <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 dark:text-purple-300 uppercase tracking-wider">Tipo</th>
                                                <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 dark:text-purple-300 uppercase tracking-wider">Data</th>
                                                <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 dark:text-purple-300 uppercase tracking-wider">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/30">
                                            @foreach($client->exams->sortByDesc('exam_date')->take(10) as $index => $exam)
                                                <tr class="hover:bg-purple-50/50 dark:hover:bg-purple-900/10 transition-all duration-300 animate-fade-in-up animation-delay-{{ min($index * 50 + 500, 900) }}">
                                                    <td class="px-6 py-4">
                                                        <a href="{{ route('admin.exams.show', $exam->codigo) }}" 
                                                           class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-bold rounded-xl hover:from-purple-600 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 text-sm">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                            </svg>
                                                            {{ $exam->codigo }}
                                                        </a>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $exam->pet->name }}</td>
                                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $exam->examType->name }}</td>
                                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $exam->exam_date->format('d/m/Y') }}</td>
                                                    <td class="px-6 py-4">
                                                        <x-status-badge :status="$exam->status" />
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @if($client->exams->count() > 10)
                            <div class="mt-6 text-center">
                                <a href="{{ route('admin.exams.index', ['search' => $client->cpf]) }}" 
                                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-100 to-purple-200 dark:from-purple-900/30 dark:to-purple-800/40 text-purple-700 dark:text-purple-300 font-semibold rounded-2xl hover:from-purple-200 hover:to-purple-300 dark:hover:from-purple-800/40 dark:hover:to-purple-700/50 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Ver todos os {{ $client->exams->count() }} exames
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-16">
                            <div class="w-24 h-24 bg-gradient-to-br from-purple-100 to-purple-200 dark:from-purple-900/30 dark:to-purple-800/40 rounded-3xl mx-auto mb-6 flex items-center justify-center">
                                <svg class="w-12 h-12 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Nenhum exame registrado</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">
                                O histórico de exames aparecerá aqui quando houver registros.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-8">
            <!-- Statistics -->
            <div class="glass-card animate-fade-in-up animation-delay-500">
                <div class="px-8 py-6 border-b border-white/20 dark:border-gray-700/20">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Estatísticas</h3>
                    </div>
                </div>
                <div class="px-8 py-6 space-y-6">
                    <div class="grid grid-cols-1 gap-6">
                        <div class="group text-center p-4 bg-gradient-to-br from-blue-50/80 to-indigo-50/60 dark:from-blue-900/20 dark:to-indigo-900/10 rounded-2xl hover:shadow-lg transition-all duration-300">
                            <div class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">{{ $stats['total_pets'] }}</div>
                            <div class="text-sm font-medium text-blue-700 dark:text-blue-300">Pets cadastrados</div>
                        </div>
                        
                        <div class="group text-center p-4 bg-gradient-to-br from-green-50/80 to-emerald-50/60 dark:from-green-900/20 dark:to-emerald-900/10 rounded-2xl hover:shadow-lg transition-all duration-300">
                            <div class="text-4xl font-bold text-green-600 dark:text-green-400 mb-2">{{ $stats['total_exams'] }}</div>
                            <div class="text-sm font-medium text-green-700 dark:text-green-300">Exames realizados</div>
                        </div>

                        <div class="group text-center p-4 bg-gradient-to-br from-purple-50/80 to-purple-100/60 dark:from-purple-900/20 dark:to-purple-800/10 rounded-2xl hover:shadow-lg transition-all duration-300">
                            <div class="text-4xl font-bold text-purple-600 dark:text-purple-400 mb-2">{{ $stats['ready_exams'] }}</div>
                            <div class="text-sm font-medium text-purple-700 dark:text-purple-300">Exames prontos</div>
                        </div>

                        @if($stats['last_exam'])
                            <div class="group text-center p-4 bg-gradient-to-br from-amber-50/80 to-yellow-50/60 dark:from-amber-900/20 dark:to-yellow-900/10 rounded-2xl hover:shadow-lg transition-all duration-300">
                                <div class="text-sm font-medium text-amber-700 dark:text-amber-300 mb-2">Último exame</div>
                                <div class="text-lg font-bold text-amber-600 dark:text-amber-400">
                                    {{ $stats['last_exam']->exam_date->format('d/m/Y') }}
                                </div>
                            </div>
                        @endif

                        <div class="group text-center p-4 bg-gradient-to-br from-orange-50/80 to-red-50/60 dark:from-orange-900/20 dark:to-red-900/10 rounded-2xl hover:shadow-lg transition-all duration-300">
                            <div class="text-4xl font-bold text-orange-600 dark:text-orange-400 mb-2">{{ $stats['total_downloads'] }}</div>
                            <div class="text-sm font-medium text-orange-700 dark:text-orange-300">Downloads realizados</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="glass-card animate-fade-in-up animation-delay-600">
                <div class="px-8 py-6 border-b border-white/20 dark:border-gray-700/20">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Ações Rápidas</h3>
                    </div>
                </div>
                <div class="px-8 py-6 space-y-4">
                    <button onclick="copyToClipboard('{{ $client->cpf }}')" 
                            class="group w-full flex items-center px-4 py-3 bg-gradient-to-r from-gray-50/80 to-gray-100/60 dark:from-gray-800/50 dark:to-gray-700/30 text-gray-700 dark:text-gray-300 hover:from-blue-50 hover:to-blue-100 dark:hover:from-blue-900/20 dark:hover:to-blue-800/30 rounded-2xl transition-all duration-300 shadow-sm hover:shadow-lg transform hover:scale-105">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-2m-4 0V3a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 0h4v2H8V5z"></path>
                            </svg>
                        </div>
                        <span class="font-medium text-sm">Copiar CPF</span>
                    </button>
                    
                    @if($client->email)
                        <button onclick="copyToClipboard('{{ $client->email }}')" 
                                class="group w-full flex items-center px-4 py-3 bg-gradient-to-r from-gray-50/80 to-gray-100/60 dark:from-gray-800/50 dark:to-gray-700/30 text-gray-700 dark:text-gray-300 hover:from-purple-50 hover:to-purple-100 dark:hover:from-purple-900/20 dark:hover:to-purple-800/30 rounded-2xl transition-all duration-300 shadow-sm hover:shadow-lg transform hover:scale-105">
                            <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <span class="font-medium text-sm">Copiar Email</span>
                        </button>
                    @endif

                    @if($client->phone)
                        <a href="https://wa.me/55{{ preg_replace('/[^0-9]/', '', $client->phone) }}?text=Olá {{ $client->name }}!" 
                           target="_blank"
                           class="group w-full flex items-center px-4 py-3 bg-gradient-to-r from-gray-50/80 to-gray-100/60 dark:from-gray-800/50 dark:to-gray-700/30 text-gray-700 dark:text-gray-300 hover:from-green-50 hover:to-green-100 dark:hover:from-green-900/20 dark:hover:to-green-800/30 rounded-2xl transition-all duration-300 shadow-sm hover:shadow-lg transform hover:scale-105">
                            <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <span class="font-medium text-sm">WhatsApp</span>
                        </a>
                    @endif
                    
                    <a href="{{ route('client.login') }}" 
                       target="_blank"
                       class="group w-full flex items-center px-4 py-3 bg-gradient-to-r from-gray-50/80 to-gray-100/60 dark:from-gray-800/50 dark:to-gray-700/30 text-gray-700 dark:text-gray-300 hover:from-teal-50 hover:to-teal-100 dark:hover:from-teal-900/20 dark:hover:to-teal-800/30 rounded-2xl transition-all duration-300 shadow-sm hover:shadow-lg transform hover:scale-105">
                        <div class="w-8 h-8 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </div>
                        <span class="font-medium text-sm">Portal do Cliente</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        if (typeof window.showToast === 'function') {
            window.showToast('Copiado para a área de transferência!', 'success');
        }
    }).catch(function() {
        if (typeof window.showToast === 'function') {
            window.showToast('Erro ao copiar. Tente novamente.', 'error');
        }
    });
}
</script>
@endsection