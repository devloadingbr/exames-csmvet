@extends('layouts.admin')

@section('title', 'Editar Pet')
@section('breadcrumb', 'Dashboard → Clientes → ' . $pet->client->name . ' → Pets → ' . $pet->name . ' → Editar')

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
                <a href="{{ route('admin.clients.show', $pet->client) }}" 
                   class="w-12 h-12 bg-gradient-to-br from-gray-500 to-gray-600 rounded-2xl flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white leading-tight">
                        Editar <span class="bg-gradient-to-r from-green-600 to-emerald-600 dark:from-green-400 dark:to-emerald-400 bg-clip-text text-transparent">Pet</span>
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mt-2">
                        <span class="font-bold text-green-600 dark:text-green-400">{{ $pet->name }}</span> 
                        <span class="text-gray-500 dark:text-gray-400">de</span> 
                        <span class="font-semibold">{{ $pet->client->name }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="glass-card animate-fade-in-up animation-delay-100">
        <form action="{{ route('admin.pets.update', $pet) }}" method="POST" class="space-y-8 p-8">
            @csrf
            @method('PUT')

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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>Proprietário *</span>
                        </div>
                    </label>
                    <select id="client_id" 
                            name="client_id" 
                            class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-blue-200/50 dark:border-blue-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white @error('client_id') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                            required>
                        <option value="">Selecione um cliente</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" 
                                    {{ (old('client_id', $pet->client_id) == $client->id) ? 'selected' : '' }}>
                                {{ $client->name }} - {{ $client->cpf }}
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
                               value="{{ old('name', $pet->name) }}"
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
                            <option value="Cão" {{ old('species', $pet->species) === 'Cão' ? 'selected' : '' }}>🐕 Cão</option>
                            <option value="Gato" {{ old('species', $pet->species) === 'Gato' ? 'selected' : '' }}>🐱 Gato</option>
                            <option value="Ave" {{ old('species', $pet->species) === 'Ave' ? 'selected' : '' }}>🐦 Ave</option>
                            <option value="Coelho" {{ old('species', $pet->species) === 'Coelho' ? 'selected' : '' }}>🐰 Coelho</option>
                            <option value="Hamster" {{ old('species', $pet->species) === 'Hamster' ? 'selected' : '' }}>🐹 Hamster</option>
                            <option value="Réptil" {{ old('species', $pet->species) === 'Réptil' ? 'selected' : '' }}>🦎 Réptil</option>
                            <option value="Peixe" {{ old('species', $pet->species) === 'Peixe' ? 'selected' : '' }}>🐠 Peixe</option>
                            <option value="Outros" {{ old('species', $pet->species) === 'Outros' ? 'selected' : '' }}>🐾 Outros</option>
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
                               value="{{ old('breed', $pet->breed) }}"
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
                            <option value="Macho" {{ old('gender', $pet->gender) === 'Macho' ? 'selected' : '' }}>♂️ Macho</option>
                            <option value="Fêmea" {{ old('gender', $pet->gender) === 'Fêmea' ? 'selected' : '' }}>♀️ Fêmea</option>
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
                               value="{{ old('birth_date', $pet->birth_date?->format('Y-m-d')) }}"
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
                               value="{{ old('weight', $pet->weight) }}"
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
                               value="{{ old('color', $pet->color) }}"
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
                               value="{{ old('microchip', $pet->microchip) }}"
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
                              placeholder="Informações adicionais sobre o pet (temperamento, alergias, histórico médico, etc.)">{{ old('notes', $pet->notes) }}</textarea>
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
                <a href="{{ route('admin.clients.show', $pet->client) }}" 
                   class="group flex items-center space-x-3 px-6 py-3 bg-white/50 dark:bg-gray-800/50 border-2 border-gray-200/50 dark:border-gray-700/30 rounded-2xl shadow-lg hover:shadow-xl focus:ring-4 focus:ring-gray-500/20 focus:border-gray-500 dark:focus:border-gray-400 transition-all duration-300 hover:scale-105 text-gray-700 dark:text-gray-300 font-medium">
                    <svg class="w-5 h-5 text-gray-500 group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>Cancelar</span>
                </a>
                <button type="submit" 
                        class="group flex items-center space-x-3 px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 border-2 border-transparent rounded-2xl shadow-lg hover:shadow-xl focus:ring-4 focus:ring-green-500/20 transition-all duration-300 hover:scale-105 text-white font-bold">
                    <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Salvar Alterações</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Pet Stats -->
    <div class="glass-card p-6 bg-gradient-to-r from-blue-50/80 via-indigo-50/60 to-purple-50/80 dark:from-blue-900/30 dark:via-indigo-900/20 dark:to-purple-900/30 animate-fade-in-up animation-delay-200">
        <div class="flex items-start space-x-4">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-blue-800 dark:text-blue-200 mb-4">
                    📊 <span class="bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400 bg-clip-text text-transparent">Estatísticas do Pet</span>
                </h3>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="text-center p-3 bg-white/50 dark:bg-gray-800/30 rounded-2xl">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $pet->exams->count() }}</div>
                        <div class="text-xs font-medium text-green-700 dark:text-green-300">Exames</div>
                    </div>
                    <div class="text-center p-3 bg-white/50 dark:bg-gray-800/30 rounded-2xl">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                            @if($pet->birth_date)
                                @php
                                    $age = $pet->birth_date->diff(now());
                                    if ($age->y > 0) echo $age->y;
                                    elseif ($age->m > 0) echo $age->m;
                                    else echo '<1';
                                @endphp
                            @else
                                -
                            @endif
                        </div>
                        <div class="text-xs font-medium text-purple-700 dark:text-purple-300">
                            @if($pet->birth_date)
                                @php
                                    $age = $pet->birth_date->diff(now());
                                    if ($age->y > 0) echo $age->y > 1 ? 'Anos' : 'Ano';
                                    elseif ($age->m > 0) echo $age->m > 1 ? 'Meses' : 'Mês';
                                    else echo 'Mês';
                                @endphp
                            @else
                                Idade
                            @endif
                        </div>
                    </div>
                </div>
                <div class="space-y-2 text-sm text-blue-700 dark:text-blue-300">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Cadastrado em {{ $pet->created_at->format('d/m/Y') }}</span>
                    </div>
                    @if($pet->weight)
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16l-3-3m3 3l3-3"></path>
                            </svg>
                            <span>Peso atual: {{ number_format($pet->weight, 2, ',', '.') }} kg</span>
                        </div>
                    @endif
                    @if($pet->birth_date)
                        @php
                            $age = $pet->birth_date->diff(now());
                            $ageText = '';
                            if ($age->y > 0) $ageText .= $age->y . ' ano' . ($age->y > 1 ? 's' : '');
                            if ($age->m > 0) $ageText .= ($ageText ? ' e ' : '') . $age->m . ' mês' . ($age->m > 1 ? 'es' : '');
                            if (!$ageText) $ageText = $age->d . ' dia' . ($age->d > 1 ? 's' : '');
                        @endphp
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Idade aproximada: {{ $ageText }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete/Warning Section -->
    @if($pet->exams->count() === 0)
        <!-- Delete Section -->
        <div class="glass-card border-2 border-red-200/50 dark:border-red-700/30 animate-fade-in-up animation-delay-300">
            <div class="px-8 py-6 border-b border-red-200/50 dark:border-red-700/30 bg-gradient-to-r from-red-50/80 via-red-100/60 to-orange-50/80 dark:from-red-900/30 dark:via-red-800/20 dark:to-orange-900/30">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.464 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-red-900 dark:text-red-200">Zona de Perigo</h3>
                </div>
            </div>
            <div class="px-8 py-6">
                <p class="text-sm text-red-700 dark:text-red-300 mb-6 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>
                        Excluir este pet removerá <strong>permanentemente</strong> todos os seus dados. Esta ação não pode ser desfeita.
                    </span>
                </p>
                
                <form action="{{ route('admin.pets.destroy', $pet) }}" 
                      method="POST" 
                      class="inline"
                      onsubmit="return confirm('ATENÇÃO: Tem certeza absoluta que deseja excluir este pet?\n\nEsta ação:\n- Removerá todos os dados do pet\n- Não pode ser desfeita\n\nDigite \'EXCLUIR\' para confirmar.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-2xl hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow-xl hover:shadow-2xl hover:shadow-red-500/25 transform hover:scale-105">
                        <svg class="w-4 h-4 mr-2 transform group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Excluir Pet Permanentemente
                    </button>
                </form>
            </div>
        </div>
    @else
        <!-- Warning Section -->
        <div class="glass-card p-6 bg-gradient-to-r from-yellow-50/80 via-amber-50/60 to-orange-50/80 dark:from-yellow-900/30 dark:via-amber-900/20 dark:to-orange-900/30 border-2 border-yellow-300/50 dark:border-yellow-600/30 animate-fade-in-up animation-delay-300">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-amber-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-yellow-800 dark:text-yellow-200 mb-2">
                        ⚠️ <span class="bg-gradient-to-r from-yellow-600 to-amber-600 dark:from-yellow-400 dark:to-amber-400 bg-clip-text text-transparent">Pet não pode ser excluído</span>
                    </h3>
                    <p class="text-sm text-yellow-700 dark:text-yellow-300">
                        Este pet possui <strong>{{ $pet->exams->count() }} exame{{ $pet->exams->count() > 1 ? 's' : '' }}</strong> cadastrado{{ $pet->exams->count() > 1 ? 's' : '' }} e não pode ser excluído. 
                        Para excluir este pet, primeiro é necessário remover todos os exames associados.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection