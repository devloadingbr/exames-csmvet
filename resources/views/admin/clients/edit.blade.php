@extends('layouts.admin')

@section('title', 'Editar Cliente')
@section('breadcrumb', 'Dashboard → Clientes → ' . $client->name . ' → Editar')

@section('content')
<div class="space-y-8 animate-fade-in-up">
    <!-- Hero Header -->
    <div class="glass-card p-8 bg-gradient-to-r from-amber-50/50 via-orange-50/30 to-red-50/50 dark:from-gray-800/50 dark:via-gray-700/30 dark:to-slate-800/50 overflow-hidden relative">
        <!-- Background decoration -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-8 right-8 w-32 h-32 bg-gradient-to-br from-amber-400/20 to-orange-400/20 rounded-full blur-2xl"></div>
            <div class="absolute bottom-8 left-8 w-24 h-24 bg-gradient-to-br from-orange-400/20 to-red-400/20 rounded-full blur-xl"></div>
        </div>
        
        <div class="relative flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.clients.show', $client) }}" 
                   class="w-12 h-12 bg-gradient-to-br from-gray-500 to-gray-600 rounded-2xl flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white leading-tight">
                        Editar <span class="bg-gradient-to-r from-amber-600 to-orange-600 dark:from-amber-400 dark:to-orange-400 bg-clip-text text-transparent">Cliente</span>
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mt-2">
                        {{ $client->name }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="glass-card animate-fade-in-up animation-delay-100">
        <form action="{{ route('admin.clients.update', $client) }}" method="POST" class="space-y-8 p-8">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="border-b border-white/20 dark:border-gray-700/20 pb-8">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Informações Básicas</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="group">
                        <label for="name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Nome Completo *</span>
                            </div>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $client->name) }}"
                               class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-blue-200/50 dark:border-blue-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 @error('name') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="Digite o nome completo do cliente"
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

                    <!-- CPF -->
                    <div class="group">
                        <label for="cpf" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span>CPF *</span>
                            </div>
                        </label>
                        <input type="text" 
                               id="cpf" 
                               name="cpf" 
                               value="{{ old('cpf', $client->cpf) }}"
                               class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-green-200/50 dark:border-green-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-green-500/20 focus:border-green-500 dark:focus:border-green-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 @error('cpf') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               maxlength="14"
                               placeholder="000.000.000-00"
                               required>
                        @error('cpf')
                            <div class="mt-3 flex items-center space-x-2 text-red-600 dark:text-red-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.464 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <span class="text-sm font-medium">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="group">
                        <label for="email" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span>Email</span>
                            </div>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $client->email) }}"
                               class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-purple-200/50 dark:border-purple-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 dark:focus:border-purple-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 @error('email') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="cliente@email.com">
                        @error('email')
                            <div class="mt-3 flex items-center space-x-2 text-red-600 dark:text-red-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.464 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <span class="text-sm font-medium">{{ $message }}</span>
                            </div>
                        @else
                            <p class="mt-3 flex items-center space-x-2 text-purple-600 dark:text-purple-400 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>O cliente usará este email para acessar o portal</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="group">
                        <label for="phone" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span>Telefone</span>
                            </div>
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone', $client->phone) }}"
                               class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-teal-200/50 dark:border-teal-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 dark:focus:border-teal-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 @error('phone') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="(00) 00000-0000">
                        @error('phone')
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
                               value="{{ old('birth_date', $client->birth_date?->format('Y-m-d')) }}"
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
                </div>
            </div>

            <!-- Additional Information -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Informações Adicionais</h3>
                </div>
                
                <!-- Address -->
                <div class="group">
                    <label for="address" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Endereço Completo</span>
                        </div>
                    </label>
                    <textarea id="address" 
                              name="address" 
                              rows="4"
                              class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-emerald-200/50 dark:border-emerald-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 dark:focus:border-emerald-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 resize-none @error('address') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                              placeholder="Rua, número, bairro, cidade, estado, CEP">{{ old('address', $client->address) }}</textarea>
                    @error('address')
                        <div class="mt-3 flex items-center space-x-2 text-red-600 dark:text-red-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.464 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <span class="text-sm font-medium">{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="group">
                    <label for="notes" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span>Observações</span>
                        </div>
                    </label>
                    <textarea id="notes" 
                              name="notes" 
                              rows="4"
                              class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-amber-200/50 dark:border-amber-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500 dark:focus:border-amber-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 resize-none @error('notes') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                              placeholder="Informações adicionais sobre o cliente, histórico, preferências...">{{ old('notes', $client->notes) }}</textarea>
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

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-8 border-t border-white/20 dark:border-gray-700/20">
                <a href="{{ route('admin.clients.show', $client) }}" 
                   class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-2xl hover:from-gray-200 hover:to-gray-300 dark:hover:from-gray-600 dark:hover:to-gray-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancelar
                </a>
                <button type="submit" 
                        class="group inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-2xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 shadow-xl hover:shadow-2xl hover:shadow-blue-500/25 transform hover:scale-105">
                    <svg class="w-4 h-4 mr-2 transform group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>

    <!-- Current Stats -->
    <div class="glass-card p-6 bg-gradient-to-r from-blue-50/80 via-indigo-50/60 to-purple-50/80 dark:from-blue-900/30 dark:via-indigo-900/20 dark:to-purple-900/30 animate-fade-in-up animation-delay-200">
        <div class="flex items-start space-x-4">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-blue-800 dark:text-blue-200 mb-4">Estatísticas do Cliente</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center p-3 bg-white/50 dark:bg-gray-800/30 rounded-2xl">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $client->pets->count() }}</div>
                        <div class="text-xs font-medium text-green-700 dark:text-green-300">Pets</div>
                    </div>
                    <div class="text-center p-3 bg-white/50 dark:bg-gray-800/30 rounded-2xl">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $client->exams->count() }}</div>
                        <div class="text-xs font-medium text-purple-700 dark:text-purple-300">Exames</div>
                    </div>
                </div>
                <div class="mt-4 space-y-2 text-sm text-blue-700 dark:text-blue-300">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Cliente desde {{ $client->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>
                            @if($client->last_login_at)
                                Último acesso: {{ $client->last_login_at->format('d/m/Y H:i') }}
                            @else
                                Nunca acessou o portal
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
            <div class="mb-6">
                <p class="text-sm text-red-700 dark:text-red-300 mb-4 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>
                        Excluir este cliente removerá <strong>permanentemente</strong> todos os dados, incluindo pets e histórico de exames. Esta ação não pode ser desfeita.
                    </span>
                </p>
                @if($client->exams->where('status', 'ready')->count() > 0)
                    <div class="glass-card p-4 bg-gradient-to-r from-yellow-50/80 via-amber-50/60 to-orange-50/80 dark:from-yellow-900/30 dark:via-amber-900/20 dark:to-orange-900/30 border-2 border-yellow-300/50 dark:border-yellow-600/30">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-yellow-500 to-amber-600 rounded-xl flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-yellow-800 dark:text-yellow-200 mb-1">Atenção!</h4>
                                <p class="text-sm text-yellow-700 dark:text-yellow-300">
                                    Este cliente possui <strong>{{ $client->exams->where('status', 'ready')->count() }} exames ativos</strong>. A exclusão não será permitida enquanto houver exames prontos.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <form action="{{ route('admin.clients.destroy', $client) }}" 
                  method="POST" 
                  class="inline"
                  onsubmit="return confirm('ATENÇÃO: Tem certeza absoluta que deseja excluir este cliente?\n\nEsta ação:\n- Removerá todos os dados do cliente\n- Excluirá todos os pets vinculados\n- Apagará o histórico de exames\n- Não pode ser desfeita\n\nDigite \'EXCLUIR\' para confirmar.')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-2xl hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow-xl hover:shadow-2xl hover:shadow-red-500/25 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-lg"
                        @if($client->exams->where('status', 'ready')->count() > 0) disabled @endif>
                    <svg class="w-4 h-4 mr-2 transform group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Excluir Cliente Permanentemente
                </button>
            </form>
        </div>
    </div>
</div>

<script>
// Mask for CPF
document.getElementById('cpf').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 11) {
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        e.target.value = value;
    }
});

// Mask for phone
document.getElementById('phone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 11) {
        if (value.length > 10) {
            value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
        } else {
            value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
        }
        e.target.value = value;
    }
});
</script>
@endsection