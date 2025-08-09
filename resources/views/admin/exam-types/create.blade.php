@extends('layouts.admin-new')

@section('title', 'Novo Tipo de Exame')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.exam-types.index') }}" 
               class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-semibold text-gray-900">Novo Tipo de Exame</h1>
        </div>
        <p class="mt-2 text-sm text-gray-700">Crie um novo tipo de exame para sua clínica</p>
    </div>

    <!-- Form -->
    <div class="bg-white shadow sm:rounded-lg">
        <form action="{{ route('admin.exam-types.store') }}" method="POST" class="space-y-6 p-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nome do Tipo de Exame *
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
                       class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-300 @enderror"
                       placeholder="Ex: Hemograma Completo"
                       required>
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Descrição
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="3"
                          class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-300 @enderror"
                          placeholder="Descrição detalhada do tipo de exame">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price -->
            <div>
                <label for="default_price" class="block text-sm font-medium text-gray-700 mb-2">
                    Preço Padrão (R$)
                </label>
                <input type="number" 
                       id="default_price" 
                       name="default_price" 
                       value="{{ old('default_price') }}"
                       step="0.01"
                       min="0"
                       class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('default_price') border-red-300 @enderror"
                       placeholder="0,00">
                @error('default_price')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Deixe vazio se não quiser definir um preço padrão</p>
            </div>

            <!-- Color -->
            <div>
                <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                    Cor do Tipo
                </label>
                <div class="flex items-center space-x-3">
                    <input type="color" 
                           id="color" 
                           name="color" 
                           value="{{ old('color', '#6B7280') }}"
                           class="h-10 w-16 border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <span class="text-sm text-gray-500">Cor para identificação visual</span>
                </div>
                @error('color')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.exam-types.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    Criar Tipo de Exame
                </button>
            </div>
        </form>
    </div>

    <!-- Quick Types Suggestions -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <h3 class="text-sm font-medium text-blue-800 mb-2">Tipos Comuns de Exame</h3>
        <div class="flex flex-wrap gap-2">
            @php
            $commonTypes = [
                'Hemograma Completo',
                'Raio-X',
                'Ultrassom',
                'Exame de Urina',
                'Exame de Fezes',
                'Ecocardiograma',
                'Eletrocardiograma',
                'Bioquímico'
            ];
            @endphp
            @foreach($commonTypes as $type)
                <button type="button" 
                        onclick="document.getElementById('name').value = '{{ $type }}'"
                        class="px-3 py-1 bg-white border border-blue-200 rounded-full text-sm text-blue-800 hover:bg-blue-100 transition-colors">
                    {{ $type }}
                </button>
            @endforeach
        </div>
    </div>
</div>
@endsection