@extends('layouts.admin-new')

@section('title', 'Editar Exame ' . $exam->codigo)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.exams.show', $exam->codigo) }}" 
               class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-semibold text-gray-900">Editar Exame {{ $exam->codigo }}</h1>
        </div>
        <p class="mt-2 text-sm text-gray-700">Altere as informações do exame conforme necessário</p>
    </div>

    <!-- Form -->
    <div class="bg-white shadow sm:rounded-lg">
        <form action="{{ route('admin.exams.update', $exam->codigo) }}" method="POST" class="space-y-6 p-6">
            @csrf
            @method('PUT')

            <!-- Exam Type -->
            <div>
                <label for="exam_type_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Tipo de Exame *
                </label>
                <select id="exam_type_id" 
                        name="exam_type_id" 
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('exam_type_id') border-red-300 @enderror"
                        required>
                    <option value="">Selecione o tipo de exame</option>
                    @foreach($examTypes as $type)
                        <option value="{{ $type->id }}" {{ old('exam_type_id', $exam->exam_type_id) == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
                @error('exam_type_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Exam Date -->
            <div>
                <label for="exam_date" class="block text-sm font-medium text-gray-700 mb-2">
                    Data do Exame *
                </label>
                <input type="date" 
                       id="exam_date" 
                       name="exam_date" 
                       value="{{ old('exam_date', $exam->exam_date->format('Y-m-d')) }}"
                       max="{{ date('Y-m-d') }}"
                       class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('exam_date') border-red-300 @enderror"
                       required>
                @error('exam_date')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Veterinarian Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="veterinarian_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Veterinário Responsável *
                    </label>
                    <input type="text" 
                           id="veterinarian_name" 
                           name="veterinarian_name" 
                           value="{{ old('veterinarian_name', $exam->veterinarian_name) }}"
                           class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('veterinarian_name') border-red-300 @enderror"
                           required>
                    @error('veterinarian_name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="veterinarian_crmv" class="block text-sm font-medium text-gray-700 mb-2">
                        CRMV
                    </label>
                    <input type="text" 
                           id="veterinarian_crmv" 
                           name="veterinarian_crmv" 
                           value="{{ old('veterinarian_crmv', $exam->veterinarian_crmv) }}"
                           class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('veterinarian_crmv') border-red-300 @enderror">
                    @error('veterinarian_crmv')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Observações
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="3"
                          class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-300 @enderror">{{ old('description', $exam->description) }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Result Summary -->
            <div>
                <label for="result_summary" class="block text-sm font-medium text-gray-700 mb-2">
                    Resumo do Resultado
                </label>
                <textarea id="result_summary" 
                          name="result_summary" 
                          rows="3"
                          class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('result_summary') border-red-300 @enderror"
                          placeholder="Resumo dos principais achados do exame...">{{ old('result_summary', $exam->result_summary) }}</textarea>
                @error('result_summary')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Este resumo será visível para o cliente junto com o arquivo PDF</p>
            </div>

            <!-- Current File Info -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-900 mb-2">Arquivo Atual</h4>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $exam->original_filename }}</p>
                        <p class="text-xs text-gray-500">
                            {{ $exam->formatted_size }} • Enviado em {{ $exam->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    <strong>Nota:</strong> Para alterar o arquivo PDF, você precisará criar um novo exame.
                </p>
            </div>

            <!-- Pet and Client Info (Read-only) -->
            <div class="bg-blue-50 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-900 mb-2">Pet e Cliente</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="font-medium text-gray-900">{{ $exam->pet->name }}</p>
                        <p class="text-gray-600">{{ $exam->pet->species }}{{ $exam->pet->breed ? ' - ' . $exam->pet->breed : '' }}</p>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $exam->client->name }}</p>
                        <p class="text-gray-600">{{ $exam->client->cpf }}</p>
                    </div>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    <strong>Nota:</strong> Para alterar o pet ou cliente, você precisará criar um novo exame.
                </p>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.exams.show', $exam->codigo) }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>

    <!-- Delete Section -->
    <div class="bg-white shadow sm:rounded-lg border border-red-200">
        <div class="px-6 py-4 border-b border-red-200 bg-red-50">
            <h3 class="text-lg font-medium text-red-900">Zona de Perigo</h3>
        </div>
        <div class="px-6 py-4">
            <p class="text-sm text-gray-700 mb-4">
                Excluir este exame removerá permanentemente todos os dados associados, incluindo o arquivo PDF e histórico de downloads. Esta ação não pode ser desfeita.
            </p>
            <form action="{{ route('admin.exams.destroy', $exam->codigo) }}" 
                  method="POST" 
                  class="inline"
                  onsubmit="return confirm('ATENÇÃO: Tem certeza absoluta que deseja excluir este exame?\n\nEsta ação:\n- Removerá o arquivo PDF permanentemente\n- Apagará todo o histórico de downloads\n- Não pode ser desfeita\n\nDigite \'EXCLUIR\' para confirmar.')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                    Excluir Exame Permanentemente
                </button>
            </form>
        </div>
    </div>
</div>
@endsection