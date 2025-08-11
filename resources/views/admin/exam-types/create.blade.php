@extends('layouts.admin')

@section('title', 'Novo Tipo de Exame')
@section('breadcrumb', 'Dashboard → Tipos de Exame → Criar')

@section('content')
<div class="space-y-8 animate-fade-in-up">
    <!-- Hero Header -->
    <div class="glass-card p-8 bg-gradient-to-r from-indigo-50/50 via-purple-50/30 to-pink-50/50 dark:from-gray-800/50 dark:via-gray-700/30 dark:to-slate-800/50 overflow-hidden relative">
        <!-- Background decoration -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-8 right-8 w-32 h-32 bg-gradient-to-br from-indigo-400/20 to-purple-400/20 rounded-full blur-2xl"></div>
            <div class="absolute bottom-8 left-8 w-24 h-24 bg-gradient-to-br from-purple-400/20 to-pink-400/20 rounded-full blur-xl"></div>
        </div>
        
        <div class="relative flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.exam-types.index') }}" 
                   class="w-12 h-12 bg-gradient-to-br from-gray-500 to-gray-600 rounded-2xl flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a1.994 1.994 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white leading-tight">
                        Novo <span class="bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400 bg-clip-text text-transparent">Tipo de Exame</span>
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mt-2">
                        Crie uma nova categoria para organizar seus exames
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="glass-card animate-fade-in-up animation-delay-100">
        <form action="{{ route('admin.exam-types.store') }}" method="POST" class="space-y-8 p-8">
            @csrf

            <!-- Basic Information Section -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
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
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a1.994 1.994 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <span>Nome do Tipo de Exame *</span>
                        </div>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-indigo-200/50 dark:border-indigo-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 dark:focus:border-indigo-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 @error('name') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
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
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Descrição</span>
                        </div>
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4"
                              class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-purple-200/50 dark:border-purple-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 dark:focus:border-purple-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 resize-none @error('description') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                              placeholder="Descrição detalhada do tipo de exame, indicações, preparo necessário...">{{ old('description') }}</textarea>
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
                           value="{{ old('default_price') }}"
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
                            <span>Deixe vazio se não quiser definir um preço padrão</span>
                        </p>
                    @enderror
                </div>

                <!-- Color -->
                <div class="group">
                    <label for="color" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                   value="{{ old('color', '#6366f1') }}"
                                   class="w-20 h-12 bg-white/50 dark:bg-gray-800/50 border-2 border-pink-200/50 dark:border-pink-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-pink-500/20 focus:border-pink-500 dark:focus:border-pink-400 transition-all duration-300 cursor-pointer">
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center space-x-2">
                                <div class="w-4 h-4 rounded-full shadow-lg" 
                                     style="background-color: {{ old('color', '#6366f1') }}" 
                                     id="color-preview"></div>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Preview da cor selecionada</span>
                            </div>
                            <p class="mt-2 text-xs text-pink-600 dark:text-pink-400">
                                Esta cor será usada para identificação visual nos relatórios e listas
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

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-8 border-t border-white/20 dark:border-gray-700/20">
                <a href="{{ route('admin.exam-types.index') }}" 
                   class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-2xl hover:from-gray-200 hover:to-gray-300 dark:hover:from-gray-600 dark:hover:to-gray-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancelar
                </a>
                <button type="submit" 
                        class="group inline-flex items-center px-8 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-2xl hover:from-indigo-600 hover:to-purple-700 transition-all duration-300 shadow-xl hover:shadow-2xl hover:shadow-indigo-500/25 transform hover:scale-105">
                    <svg class="w-4 h-4 mr-2 transform group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Criar Tipo de Exame
                </button>
            </div>
        </form>
    </div>

    <!-- Quick Types Suggestions -->
    <div class="glass-card p-6 bg-gradient-to-r from-blue-50/80 via-indigo-50/60 to-purple-50/80 dark:from-blue-900/30 dark:via-indigo-900/20 dark:to-purple-900/30 animate-fade-in-up animation-delay-200">
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-blue-800 dark:text-blue-200 mb-2">Sugestões Rápidas</h3>
                <p class="text-sm text-blue-700 dark:text-blue-300 mb-4">
                    Clique em um dos tipos abaixo para preencher automaticamente o campo nome:
                </p>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    @php
                    $commonTypes = [
                        ['name' => 'Hemograma Completo', 'color' => '#ef4444'],
                        ['name' => 'Raio-X Tórax', 'color' => '#f97316'],
                        ['name' => 'Ultrassom Abdominal', 'color' => '#eab308'],
                        ['name' => 'Exame de Urina', 'color' => '#22c55e'],
                        ['name' => 'Exame de Fezes', 'color' => '#06b6d4'],
                        ['name' => 'Ecocardiograma', 'color' => '#3b82f6'],
                        ['name' => 'Eletrocardiograma', 'color' => '#6366f1'],
                        ['name' => 'Bioquímico', 'color' => '#8b5cf6'],
                        ['name' => 'Citologia', 'color' => '#a855f7'],
                        ['name' => 'Histopatológico', 'color' => '#d946ef'],
                        ['name' => 'Endoscopia', 'color' => '#ec4899'],
                        ['name' => 'Tomografia', 'color' => '#f43f5e']
                    ];
                    @endphp
                    @foreach($commonTypes as $index => $type)
                        <button type="button" 
                                onclick="fillExamType('{{ $type['name'] }}', '{{ $type['color'] }}')"
                                class="group flex items-center space-x-2 px-3 py-2 bg-white/60 dark:bg-gray-800/40 border-2 border-blue-200/50 dark:border-blue-700/30 rounded-2xl text-sm font-medium text-blue-800 dark:text-blue-200 hover:bg-blue-100/80 dark:hover:bg-blue-900/40 hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-lg transition-all duration-300 transform hover:scale-105 animate-fade-in-up animation-delay-{{ min($index * 50 + 300, 900) }}">
                            <div class="w-3 h-3 rounded-full shadow-sm" style="background-color: {{ $type['color'] }}"></div>
                            <span class="truncate">{{ $type['name'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Função para preencher campos com sugestões
function fillExamType(name, color) {
    document.getElementById('name').value = name;
    document.getElementById('color').value = color;
    document.getElementById('color-preview').style.backgroundColor = color;
    
    // Toast de feedback
    if (typeof window.showToast === 'function') {
        window.showToast(`Tipo "${name}" preenchido automaticamente!`, 'success');
    }
    
    // Foco no campo descrição
    document.getElementById('description').focus();
}

// Atualizar preview da cor quando o usuário alterar
document.getElementById('color').addEventListener('change', function() {
    document.getElementById('color-preview').style.backgroundColor = this.value;
});
</script>
@endsection