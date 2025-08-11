@extends('layouts.admin')

@section('title', 'Editar Exame ' . $exam->codigo)
@section('breadcrumb', 'Dashboard → Exames → ' . $exam->codigo . ' → Editar')

@section('content')
<div class="space-y-8 animate-fade-in-up">
    <!-- Hero Header -->
    <div class="glass-card p-8 bg-gradient-to-r from-purple-50/50 via-indigo-50/30 to-blue-50/50 dark:from-gray-800/50 dark:via-gray-700/30 dark:to-slate-800/50 overflow-hidden relative">
        <!-- Background decoration -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-8 right-8 w-32 h-32 bg-gradient-to-br from-purple-400/20 to-indigo-400/20 rounded-full blur-2xl"></div>
            <div class="absolute bottom-8 left-8 w-24 h-24 bg-gradient-to-br from-indigo-400/20 to-blue-400/20 rounded-full blur-xl"></div>
        </div>
        
        <div class="relative flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.exams.show', $exam->codigo) }}" 
                   class="w-12 h-12 bg-gradient-to-br from-gray-500 to-gray-600 rounded-2xl flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white leading-tight">
                        Editar <span class="bg-gradient-to-r from-purple-600 to-indigo-600 dark:from-purple-400 dark:to-indigo-400 bg-clip-text text-transparent">Exame</span>
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mt-2">
                        Código: <span class="font-bold text-purple-600 dark:text-purple-400">{{ $exam->codigo }}</span>
                        @php
                            $statusClasses = [
                                'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                'ready' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                'failed' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300'
                            ];
                            $statusLabels = [
                                'pending' => 'Pendente',
                                'processing' => 'Processando',
                                'ready' => 'Pronto',
                                'failed' => 'Falhou'
                            ];
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 text-sm font-semibold rounded-2xl ml-3 {{ $statusClasses[$exam->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700/30 dark:text-gray-300' }}">
                            {{ $statusLabels[$exam->status] ?? $exam->status }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="glass-card animate-fade-in-up animation-delay-100">
        <form action="{{ route('admin.exams.update', $exam->codigo) }}" method="POST" class="space-y-8 p-8">
            @csrf
            @method('PUT')

            <!-- Exam Information Section -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Informações do Exame</h3>
                </div>

                <!-- Exam Type -->
                <div class="group">
                    <label for="exam_type_id" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                            <span>Tipo de Exame *</span>
                        </div>
                    </label>
                    <select id="exam_type_id" 
                            name="exam_type_id" 
                            class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-purple-200/50 dark:border-purple-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 dark:focus:border-purple-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white @error('exam_type_id') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                            required>
                        <option value="">Selecione o tipo de exame</option>
                        @foreach($examTypes as $type)
                            <option value="{{ $type->id }}" {{ old('exam_type_id', $exam->exam_type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('exam_type_id')
                        <div class="mt-3 flex items-center space-x-2 text-red-600 dark:text-red-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.464 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <span class="text-sm font-medium">{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Exam Date -->
                <div class="group">
                    <label for="exam_date" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>Data do Exame *</span>
                        </div>
                    </label>
                    <input type="date" 
                           id="exam_date" 
                           name="exam_date" 
                           value="{{ old('exam_date', $exam->exam_date->format('Y-m-d')) }}"
                           max="{{ date('Y-m-d') }}"
                           class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-indigo-200/50 dark:border-indigo-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 dark:focus:border-indigo-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white @error('exam_date') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                           required>
                    @error('exam_date')
                        <div class="mt-3 flex items-center space-x-2 text-red-600 dark:text-red-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.464 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <span class="text-sm font-medium">{{ $message }}</span>
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Veterinarian Information Section -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Informações do Veterinário</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Veterinarian Name -->
                    <div class="group">
                        <label for="veterinarian_name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Veterinário Responsável *</span>
                            </div>
                        </label>
                        <input type="text" 
                               id="veterinarian_name" 
                               name="veterinarian_name" 
                               value="{{ old('veterinarian_name', $exam->veterinarian_name) }}"
                               class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-blue-200/50 dark:border-blue-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white @error('veterinarian_name') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               required>
                        @error('veterinarian_name')
                            <div class="mt-3 flex items-center space-x-2 text-red-600 dark:text-red-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.464 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <span class="text-sm font-medium">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    
                    <!-- CRMV -->
                    <div class="group">
                        <label for="veterinarian_crmv" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                                <span>CRMV</span>
                            </div>
                        </label>
                        <input type="text" 
                               id="veterinarian_crmv" 
                               name="veterinarian_crmv" 
                               value="{{ old('veterinarian_crmv', $exam->veterinarian_crmv) }}"
                               class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-teal-200/50 dark:border-teal-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 dark:focus:border-teal-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white @error('veterinarian_crmv') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror">
                        @error('veterinarian_crmv')
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

            <!-- Additional Information Section -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Informações Adicionais</h3>
                </div>

                <!-- Description -->
                <div class="group">
                    <label for="description" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Observações</span>
                        </div>
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="3"
                              class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-green-200/50 dark:border-green-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-green-500/20 focus:border-green-500 dark:focus:border-green-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white resize-none @error('description') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror">{{ old('description', $exam->description) }}</textarea>
                    @error('description')
                        <div class="mt-3 flex items-center space-x-2 text-red-600 dark:text-red-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.464 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <span class="text-sm font-medium">{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Result Summary -->
                <div class="group">
                    <label for="result_summary" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <span>Resumo do Resultado</span>
                        </div>
                    </label>
                    <textarea id="result_summary" 
                              name="result_summary" 
                              rows="4"
                              class="block w-full bg-white/50 dark:bg-gray-800/50 border-2 border-amber-200/50 dark:border-amber-700/30 rounded-2xl shadow-lg focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500 dark:focus:border-amber-400 transition-all duration-300 px-4 py-3 text-gray-900 dark:text-white resize-none @error('result_summary') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                              placeholder="Resumo dos principais achados do exame...">{{ old('result_summary', $exam->result_summary) }}</textarea>
                    @error('result_summary')
                        <div class="mt-3 flex items-center space-x-2 text-red-600 dark:text-red-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.464 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <span class="text-sm font-medium">{{ $message }}</span>
                        </div>
                    @enderror
                    <div class="mt-3 flex items-center space-x-2 text-amber-600 dark:text-amber-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-medium">Este resumo será visível para o cliente junto com o arquivo PDF</span>
                    </div>
                </div>
            </div>

        </form>
    </div>

    <!-- Information Cards -->
    <div class="space-y-6 animate-fade-in-up animation-delay-200">
        <!-- Current File Info Card -->
        <div class="glass-card p-6 bg-gradient-to-r from-red-50/50 via-pink-50/30 to-rose-50/50 dark:from-gray-800/50 dark:via-gray-700/30 dark:to-slate-800/50 overflow-hidden relative">
            <!-- Background decoration -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-4 right-4 w-16 h-16 bg-gradient-to-br from-red-400/20 to-pink-400/20 rounded-full blur-xl"></div>
                <div class="absolute bottom-4 left-4 w-12 h-12 bg-gradient-to-br from-pink-400/20 to-rose-400/20 rounded-full blur-lg"></div>
            </div>
            
            <div class="relative">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white">Arquivo Atual</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Documento PDF do exame</p>
                    </div>
                </div>
                
                <div class="bg-white/60 dark:bg-gray-800/60 rounded-2xl p-4 border border-red-200/50 dark:border-red-700/30">
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-red-400 to-pink-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-gray-900 dark:text-white mb-1">{{ $exam->original_filename }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                <span class="inline-flex items-center space-x-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.79 4 8.5 4s8.5-1.79 8.5-4V7c0 2.21-3.79 4-8.5 4S4 9.21 4 7z"></path>
                                    </svg>
                                    <span>{{ $exam->formatted_size }}</span>
                                </span>
                                <span class="mx-2">•</span>
                                <span class="inline-flex items-center space-x-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Enviado em {{ $exam->created_at->format('d/m/Y H:i') }}</span>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 flex items-start space-x-2 text-red-600 dark:text-red-400">
                    <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-xs font-medium">
                        <strong>Nota:</strong> Para alterar o arquivo PDF, você precisará criar um novo exame.
                    </p>
                </div>
            </div>
        </div>

        <!-- Pet and Client Info Card -->
        <div class="glass-card p-6 bg-gradient-to-r from-blue-50/50 via-cyan-50/30 to-sky-50/50 dark:from-gray-800/50 dark:via-gray-700/30 dark:to-slate-800/50 overflow-hidden relative">
            <!-- Background decoration -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-4 right-4 w-20 h-20 bg-gradient-to-br from-blue-400/20 to-cyan-400/20 rounded-full blur-2xl"></div>
                <div class="absolute bottom-4 left-4 w-16 h-16 bg-gradient-to-br from-cyan-400/20 to-sky-400/20 rounded-full blur-xl"></div>
            </div>
            
            <div class="relative">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 dark:text-white">Pet e Cliente</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Informações vinculadas ao exame</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Pet Info -->
                    <div class="bg-white/60 dark:bg-gray-800/60 rounded-2xl p-4 border border-blue-200/50 dark:border-blue-700/30">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-900 dark:text-white mb-1">{{ $exam->pet->name }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    {{ $exam->pet->species }}{{ $exam->pet->breed ? ' - ' . $exam->pet->breed : '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Client Info -->
                    <div class="bg-white/60 dark:bg-gray-800/60 rounded-2xl p-4 border border-blue-200/50 dark:border-blue-700/30">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-900 dark:text-white mb-1">{{ $exam->client->name }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ $exam->client->cpf }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 flex items-start space-x-2 text-blue-600 dark:text-blue-400">
                    <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-xs font-medium">
                        <strong>Nota:</strong> Para alterar o pet ou cliente, você precisará criar um novo exame.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Danger Zone -->
    <div class="glass-card p-8 bg-gradient-to-r from-red-50/50 via-rose-50/30 to-pink-50/50 dark:from-gray-800/50 dark:via-gray-700/30 dark:to-slate-800/50 overflow-hidden relative animate-fade-in-up animation-delay-300">
        <!-- Background decoration -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-6 right-6 w-20 h-20 bg-gradient-to-br from-red-500/20 to-rose-500/20 rounded-full blur-2xl"></div>
            <div class="absolute bottom-6 left-6 w-16 h-16 bg-gradient-to-br from-rose-500/20 to-pink-500/20 rounded-full blur-xl"></div>
        </div>
        
        <div class="relative">
            <div class="flex items-center space-x-4 mb-6">
                <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-rose-600 rounded-2xl flex items-center justify-center shadow-xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.464 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white leading-tight">
                        Zona de <span class="bg-gradient-to-r from-red-600 to-rose-600 dark:from-red-400 dark:to-rose-400 bg-clip-text text-transparent">Perigo</span>
                    </h3>
                    <p class="text-lg text-red-600 dark:text-red-400 font-medium mt-1">Ações irreversíveis</p>
                </div>
            </div>
            
            <div class="bg-white/60 dark:bg-gray-800/60 rounded-2xl p-6 border-2 border-red-200/50 dark:border-red-700/30 mb-6">
                <div class="flex items-start space-x-3">
                    <div class="w-6 h-6 text-red-500 dark:text-red-400 flex-shrink-0 mt-0.5">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-700 dark:text-gray-300 font-medium leading-relaxed">
                            Excluir este exame removerá <strong>permanentemente</strong> todos os dados associados, incluindo o arquivo PDF e histórico de downloads. 
                            <span class="text-red-600 dark:text-red-400 font-bold">Esta ação não pode ser desfeita.</span>
                        </p>
                        
                        <div class="mt-4 space-y-2">
                            <div class="flex items-center space-x-2 text-xs text-gray-600 dark:text-gray-400">
                                <div class="w-1.5 h-1.5 bg-red-400 rounded-full"></div>
                                <span>Arquivo PDF será removido permanentemente</span>
                            </div>
                            <div class="flex items-center space-x-2 text-xs text-gray-600 dark:text-gray-400">
                                <div class="w-1.5 h-1.5 bg-red-400 rounded-full"></div>
                                <span>Todo o histórico de downloads será apagado</span>
                            </div>
                            <div class="flex items-center space-x-2 text-xs text-gray-600 dark:text-gray-400">
                                <div class="w-1.5 h-1.5 bg-red-400 rounded-full"></div>
                                <span>Dados não poderão ser recuperados</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <form action="{{ route('admin.exams.destroy', $exam->codigo) }}" 
                  method="POST" 
                  class="inline-block"
                  onsubmit="return confirm('ATENÇÃO: Tem certeza absoluta que deseja excluir este exame?\n\nEsta ação:\n- Removerá o arquivo PDF permanentemente\n- Apagará todo o histórico de downloads\n- Não pode ser desfeita\n\nDigite \'EXCLUIR\' para confirmar.')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="group px-8 py-4 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 border-2 border-red-500/50 rounded-2xl text-sm font-bold text-white hover:scale-105 hover:shadow-xl hover:shadow-red-500/25 transition-all duration-300 flex items-center space-x-3">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    <span>Excluir Exame Permanentemente</span>
                    <svg class="w-4 h-4 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.464 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection