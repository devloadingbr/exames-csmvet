@extends('layouts.admin')

@section('title', 'Editar Tipo de Exame')
@section('breadcrumb', 'Dashboard → Tipos de Exame → ' . $examType->name . ' → Editar')

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
                <a href="{{ route('admin.exam-types.index') }}" 
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
                        Editar <span class="bg-gradient-to-r from-amber-600 to-orange-600 dark:from-amber-400 dark:to-orange-400 bg-clip-text text-transparent">Tipo</span>
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mt-2">
                        {{ $examType->name }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="glass-card animate-fade-in-up animation-delay-100">
        <form action="{{ route('admin.exam-types.update', $examType) }}" method="POST" class="space-y-8 p-8">
            @csrf
            @method('PUT')

            <!-- Basic Information Section -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a1.994 1.994 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Informações Básicas</h3>
                </div>

                <!-- Name -->
                <div class="group">
                    <label for="name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a1.994 1.994 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <span>Nome do Tipo de Exame *</span>
                        </div>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $examType->name) }}"
                           class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-amber-200/50 dark:border-amber-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500 dark:focus:border-amber-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 @error('name') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                           placeholder="Ex: Hemograma Completo, Raio-X Tórax, Ultrassom Abdominal"
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

                <!-- Description -->
                <div class="group">
                    <label for="description" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Descrição</span>
                        </div>
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4"
                              class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-orange-200/50 dark:border-orange-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-orange-500/20 focus:border-orange-500 dark:focus:border-orange-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 resize-none @error('description') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                              placeholder="Descrição detalhada do tipo de exame, indicações, preparo necessário...">{{ old('description', $examType->description) }}</textarea>
                    @error('description')
                        <div class="mt-3 flex items-center space-x-2 text-red-600 dark:text-red-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.464 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <span class="text-sm font-medium">{{ $message }}</span>
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Configuration Section -->
            <div class="space-y-6 pt-8 border-t border-white/20 dark:border-gray-700/20">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Configurações</h3>
                </div>

                <!-- Price -->
                <div class="group">
                    <label for="default_price" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Preço Padrão (R$)</span>
                        </div>
                    </label>
                    <input type="number" 
                           id="default_price" 
                           name="default_price" 
                           value="{{ old('default_price', $examType->default_price) }}"
                           step="0.01"
                           min="0"
                           class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-green-200/50 dark:border-green-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-green-500/20 focus:border-green-500 dark:focus:border-green-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 @error('default_price') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                           placeholder="150,00">
                    @error('default_price')
                        <div class="mt-3 flex items-center space-x-2 text-red-600 dark:text-red-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.464 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <span class="text-sm font-medium">{{ $message }}</span>
                        </div>
                    @else
                        <p class="mt-3 flex items-center space-x-2 text-green-600 dark:text-green-400 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Deixe vazio para manter sem preço padrão</span>
                        </p>
                    @enderror
                </div>

                <!-- Color -->
                <div class="group">
                    <label for="color" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                            </svg>
                            <span>Cor do Tipo</span>
                        </div>
                    </label>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="color" 
                                   id="color" 
                                   name="color" 
                                   value="{{ old('color', $examType->color) }}"
                                   class="w-16 h-12 bg-white/50 dark:bg-gray-800/50 border-2 border-purple-200/50 dark:border-purple-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 dark:focus:border-purple-400 transition-all duration-300 cursor-pointer @error('color') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror">
                        </div>
                        <div class="flex-1">
                            <div id="color-preview" 
                                 class="w-full h-3 rounded-xl shadow-inner"
                                 style="background-color: {{ old('color', $examType->color) }}"></div>
                            <p class="mt-2 flex items-center space-x-2 text-purple-600 dark:text-purple-400 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Cor para identificação visual dos exames</span>
                            </p>
                        </div>
                    </div>
                    @error('color')
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
                <a href="{{ route('admin.exam-types.index') }}" 
                   class="group flex items-center space-x-3 px-6 py-3 bg-white/50 dark:bg-gray-800/50 border-2 border-gray-200/50 dark:border-gray-700/30 rounded-2xl shadow-lg hover:shadow-xl focus:ring-4 focus:ring-gray-500/20 focus:border-gray-500 dark:focus:border-gray-400 transition-all duration-300 hover:scale-105 text-gray-700 dark:text-gray-300 font-medium">
                    <svg class="w-5 h-5 text-gray-500 group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>Cancelar</span>
                </a>
                <button type="submit" 
                        class="group flex items-center space-x-3 px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 border-2 border-transparent rounded-2xl shadow-lg hover:shadow-xl focus:ring-4 focus:ring-amber-500/20 transition-all duration-300 hover:scale-105 text-white font-bold">
                    <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Salvar Alterações</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Color picker preview functionality
    const colorInput = document.getElementById('color');
    const colorPreview = document.getElementById('color-preview');
    
    if (colorInput && colorPreview) {
        colorInput.addEventListener('input', function(e) {
            colorPreview.style.backgroundColor = e.target.value;
        });
    }
});
</script>
@endsection