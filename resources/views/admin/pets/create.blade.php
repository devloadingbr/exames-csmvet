@extends('layouts.admin')

@section('title', 'Novo Pet')

@section('content')
<div class="space-y-8 animate-fade-in-up">
    <!-- Hero Header -->
    <div class="glass-card p-8 bg-gradient-to-r from-green-50/50 via-emerald-50/30 to-teal-50/50 dark:from-gray-800/50 dark:via-gray-700/30 dark:to-slate-800/50 overflow-hidden relative">
        <!-- Background decoration -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-8 right-8 w-32 h-32 bg-gradient-to-br from-green-400/20 to-emerald-400/20 rounded-full blur-2xl"></div>
            <div class="absolute bottom-8 left-8 w-24 h-24 bg-gradient-to-br from-emerald-400/20 to-teal-400/20 rounded-full blur-xl"></div>
        </div>
        
        <div class="relative flex items-center justify-between">
            <div class="flex items-center space-x-4">
                @if($client)
                    <a href="{{ route('admin.clients.show', $client) }}" 
                       class="w-12 h-12 bg-gradient-to-br from-gray-500 to-gray-600 rounded-2xl flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('admin.clients.index') }}" 
                       class="w-12 h-12 bg-gradient-to-br from-gray-500 to-gray-600 rounded-2xl flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                @endif
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white leading-tight">
                        Novo <span class="bg-gradient-to-r from-green-600 to-emerald-600 dark:from-green-400 dark:to-emerald-400 bg-clip-text text-transparent">Pet</span>
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mt-2">
                        @if($client)
                            Cadastrando para <span class="font-bold text-green-600 dark:text-green-400">{{ $client->name }}</span>
                        @else
                            Cadastre um novo companheiro
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="glass-card animate-fade-in-up animation-delay-100">
        <form action="{{ route('admin.pets.store') }}" method="POST" class="space-y-8 p-8">
            @csrf
            @if(request()->has('redirect_to'))
                <input type="hidden" name="redirect_to" value="{{ request('redirect_to') }}">
            @endif
            @if($client)
                <input type="hidden" name="client_id" value="{{ $client->id }}">
            @endif

            <!-- Client Selection Section -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Cliente</h3>
                </div>
                
                <div class="group">
                    <label for="client_id" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v1a2 2 0 002 2h2m0 0h2a2 2 0 012-2V7a2 2 0 00-2-2H9m0 0V5a2 2 0 012-2h2a2 2 0 012 2v.01M9 5a2 2 0 012-2h2a2 2 0 012 2v.01"></path>
                            </svg>
                            <span>Selecionar Cliente *</span>
                        </div>
                    </label>
                    <select id="client_id" 
                            name="client_id" 
                            class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-blue-200/50 dark:border-blue-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white @error('client_id') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                            required
                            @if($client) disabled @endif>
                        <option value="">Selecione um cliente</option>
                        @foreach($clients as $clientOption)
                            <option value="{{ $clientOption->id }}" 
                                    {{ (old('client_id', $client?->id) == $clientOption->id) ? 'selected' : '' }}>
                                {{ $clientOption->name }} - {{ $clientOption->cpf }}
                            </option>
                        @endforeach
                    </select>
                    @error('client_id')
                        <div class="mt-3 flex items-center space-x-2 text-red-600 dark:text-red-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.464 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <span class="text-sm font-medium">{{ $message }}</span>
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Pet Information Section -->
            <div class="space-y-6 pt-8 border-t border-white/20 dark:border-gray-700/20">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Informações do Pet</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="group">
                        <label for="name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a1.994 1.994 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                <span>Nome do Pet *</span>
                            </div>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-green-200/50 dark:border-green-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-green-500/20 focus:border-green-500 dark:focus:border-green-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 @error('name') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="Ex: Rex, Miau, Buddy"
                               required>
                        @error('name')
                            <div class="mt-3 flex items-center space-x-2 text-red-600 dark:text-red-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.464 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <span class="text-sm font-medium">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Species -->
                    <div class="group">
                        <label for="species" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span>Espécie *</span>
                            </div>
                        </label>
                        <select id="species" 
                                name="species" 
                                class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-emerald-200/50 dark:border-emerald-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 dark:focus:border-emerald-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white @error('species') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                required>
                            <option value="">Selecione a espécie</option>
                            <option value="Cão" {{ old('species') === 'Cão' ? 'selected' : '' }}>🐕 Cão</option>
                            <option value="Gato" {{ old('species') === 'Gato' ? 'selected' : '' }}>🐱 Gato</option>
                            <option value="Ave" {{ old('species') === 'Ave' ? 'selected' : '' }}>🐦 Ave</option>
                            <option value="Coelho" {{ old('species') === 'Coelho' ? 'selected' : '' }}>🐰 Coelho</option>
                            <option value="Hamster" {{ old('species') === 'Hamster' ? 'selected' : '' }}>🐹 Hamster</option>
                            <option value="Réptil" {{ old('species') === 'Réptil' ? 'selected' : '' }}>🦎 Réptil</option>
                            <option value="Peixe" {{ old('species') === 'Peixe' ? 'selected' : '' }}>🐠 Peixe</option>
                            <option value="Outros" {{ old('species') === 'Outros' ? 'selected' : '' }}>🐾 Outros</option>
                        </select>
                        @error('species')
                            <div class="mt-3 flex items-center space-x-2 text-red-600 dark:text-red-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.464 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <span class="text-sm font-medium">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Breed -->
                    <div class="group">
                        <label for="breed" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span>Raça</span>
                            </div>
                        </label>
                        <input type="text" 
                               id="breed" 
                               name="breed" 
                               value="{{ old('breed') }}"
                               class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-teal-200/50 dark:border-teal-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 dark:focus:border-teal-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 @error('breed') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="Ex: Labrador, Persa, SRD">
                        @error('breed')
                            <div class="mt-3 flex items-center space-x-2 text-red-600 dark:text-red-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.464 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <span class="text-sm font-medium">{{ $message }}</span>
                            </div>
                        @else
                            <p class="mt-3 flex items-center space-x-2 text-teal-600 dark:text-teal-400 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>SRD = Sem Raça Definida</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div class="group">
                        <label for="gender" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Sexo</span>
                            </div>
                        </label>
                        <select id="gender" 
                                name="gender" 
                                class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-purple-200/50 dark:border-purple-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 dark:focus:border-purple-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white @error('gender') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror">
                            <option value="">Selecione o sexo</option>
                            <option value="Macho" {{ old('gender') === 'Macho' ? 'selected' : '' }}>♂️ Macho</option>
                            <option value="Fêmea" {{ old('gender') === 'Fêmea' ? 'selected' : '' }}>♀️ Fêmea</option>
                        </select>
                        @error('gender')
                            <div class="mt-3 flex items-center space-x-2 text-red-600 dark:text-red-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.464 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <span class="text-sm font-medium">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Birth Date -->
                    <div class="group">
                        <label for="birth_date" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>Data de Nascimento</span>
                            </div>
                        </label>
                        <input type="date" 
                               id="birth_date" 
                               name="birth_date" 
                               value="{{ old('birth_date') }}"
                               max="{{ date('Y-m-d') }}"
                               class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-indigo-200/50 dark:border-indigo-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 dark:focus:border-indigo-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white @error('birth_date') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror">
                        @error('birth_date')
                            <div class="mt-3 flex items-center space-x-2 text-red-600 dark:text-red-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.464 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <span class="text-sm font-medium">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Weight -->
                    <div class="group">
                        <label for="weight" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16l-3-3m3 3l3-3"></path>
                                </svg>
                                <span>Peso (kg)</span>
                            </div>
                        </label>
                        <input type="number" 
                               id="weight" 
                               name="weight" 
                               value="{{ old('weight') }}"
                               step="0.01"
                               min="0"
                               max="999.99"
                               class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-orange-200/50 dark:border-orange-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-orange-500/20 focus:border-orange-500 dark:focus:border-orange-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 @error('weight') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="Ex: 5.5">
                        @error('weight')
                            <div class="mt-3 flex items-center space-x-2 text-red-600 dark:text-red-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.464 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <span class="text-sm font-medium">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Color -->
                    <div class="group">
                        <label for="color" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                                </svg>
                                <span>Cor/Pelagem</span>
                            </div>
                        </label>
                        <input type="text" 
                               id="color" 
                               name="color" 
                               value="{{ old('color') }}"
                               class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-pink-200/50 dark:border-pink-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-pink-500/20 focus:border-pink-500 dark:focus:border-pink-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 @error('color') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="Ex: Marrom, Preto e branco, Tricolor">
                        @error('color')
                            <div class="mt-3 flex items-center space-x-2 text-red-600 dark:text-red-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.464 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <span class="text-sm font-medium">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Microchip -->
                    <div class="group">
                        <label for="microchip" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                </svg>
                                <span>Microchip</span>
                            </div>
                        </label>
                        <input type="text" 
                               id="microchip" 
                               name="microchip" 
                               value="{{ old('microchip') }}"
                               class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-cyan-200/50 dark:border-cyan-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-cyan-500/20 focus:border-cyan-500 dark:focus:border-cyan-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 @error('microchip') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="Número do microchip">
                        @error('microchip')
                            <div class="mt-3 flex items-center space-x-2 text-red-600 dark:text-red-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.464 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <span class="text-sm font-medium">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Notes -->
                <div class="group">
                    <label for="notes" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Observações</span>
                        </div>
                    </label>
                    <textarea id="notes" 
                              name="notes" 
                              rows="4"
                              class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-slate-200/50 dark:border-slate-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-slate-500/20 focus:border-slate-500 dark:focus:border-slate-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 resize-none @error('notes') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                              placeholder="Informações adicionais sobre o pet (temperamento, alergias, histórico médico, etc.)">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="mt-3 flex items-center space-x-2 text-red-600 dark:text-red-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.464 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <span class="text-sm font-medium">{{ $message }}</span>
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-8 border-t border-white/20 dark:border-gray-700/20">
                @if($client)
                    <a href="{{ route('admin.clients.show', $client) }}" 
                       class="group flex items-center space-x-3 px-6 py-3 bg-white/50 dark:bg-gray-800/50 border-2 border-gray-200/50 dark:border-gray-700/30 rounded-2xl shadow-lg hover:shadow-xl focus:ring-4 focus:ring-gray-500/20 focus:border-gray-500 dark:focus:border-gray-400 transition-all duration-300 hover:scale-105 text-gray-700 dark:text-gray-300 font-medium">
                        <svg class="w-5 h-5 text-gray-500 group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span>Cancelar</span>
                    </a>
                @else
                    <a href="{{ route('admin.clients.index') }}" 
                       class="group flex items-center space-x-3 px-6 py-3 bg-white/50 dark:bg-gray-800/50 border-2 border-gray-200/50 dark:border-gray-700/30 rounded-2xl shadow-lg hover:shadow-xl focus:ring-4 focus:ring-gray-500/20 focus:border-gray-500 dark:focus:border-gray-400 transition-all duration-300 hover:scale-105 text-gray-700 dark:text-gray-300 font-medium">
                        <svg class="w-5 h-5 text-gray-500 group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span>Cancelar</span>
                    </a>
                @endif
                <button type="submit" 
                        class="group flex items-center space-x-3 px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 border-2 border-transparent rounded-2xl shadow-lg hover:shadow-xl focus:ring-4 focus:ring-green-500/20 transition-all duration-300 hover:scale-105 text-white font-bold">
                    <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Cadastrar Pet</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Quick Guide -->
    <div class="glass-card p-6 bg-gradient-to-r from-teal-50/50 via-cyan-50/30 to-blue-50/50 dark:from-gray-800/50 dark:via-gray-700/30 dark:to-slate-800/50 animate-fade-in-up animation-delay-200">
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                    💡 <span class="bg-gradient-to-r from-teal-600 to-cyan-600 dark:from-teal-400 dark:to-cyan-400 bg-clip-text text-transparent">Dicas de Preenchimento</span>
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="flex items-start space-x-3 p-3 bg-white/50 dark:bg-gray-800/50 rounded-xl border border-teal-200/30 dark:border-teal-700/20">
                        <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-emerald-500 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a1.994 1.994 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">Nome</p>
                            <p class="text-gray-600 dark:text-gray-300">Use o nome pelo qual o pet é conhecido</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-3 p-3 bg-white/50 dark:bg-gray-800/50 rounded-xl border border-teal-200/30 dark:border-teal-700/20">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">Raça</p>
                            <p class="text-gray-600 dark:text-gray-300">Se não souber, use "SRD" ou "Vira-lata"</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-3 p-3 bg-white/50 dark:bg-gray-800/50 rounded-xl border border-teal-200/30 dark:border-teal-700/20">
                        <div class="w-8 h-8 bg-gradient-to-br from-orange-400 to-red-500 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16l-3-3m3 3l3-3"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">Peso</p>
                            <p class="text-gray-600 dark:text-gray-300">Peso aproximado atual (pode ser atualizado)</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-3 p-3 bg-white/50 dark:bg-gray-800/50 rounded-xl border border-teal-200/30 dark:border-teal-700/20">
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">Observações</p>
                            <p class="text-gray-600 dark:text-gray-300">Anote alergias, comportamento, medicamentos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// If client is preselected, disable the select
@if($client)
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('client_id').disabled = true;
});
@endif
</script>
@endsection