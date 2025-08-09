@extends('layouts.admin-new')

@section('title', 'Editar Pet')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.clients.show', $pet->client) }}" 
               class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-semibold text-gray-900">Editar Pet</h1>
        </div>
        <p class="mt-2 text-sm text-gray-700">
            Editando: <span class="font-medium">{{ $pet->name }}</span> 
            ({{ $pet->client->name }})
        </p>
    </div>

    <!-- Form -->
    <div class="bg-white shadow sm:rounded-lg">
        <form action="{{ route('admin.pets.update', $pet) }}" method="POST" class="space-y-6 p-6">
            @csrf
            @method('PUT')

            <!-- Client Selection -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Cliente</h3>
                
                <div>
                    <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Proprietário *
                    </label>
                    <select id="client_id" 
                            name="client_id" 
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('client_id') border-red-300 @enderror"
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
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Pet Information -->
            <div class="space-y-6">
                <h3 class="text-lg font-medium text-gray-900">Informações do Pet</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nome do Pet *
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $pet->name) }}"
                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-300 @enderror"
                               required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Species -->
                    <div>
                        <label for="species" class="block text-sm font-medium text-gray-700 mb-2">
                            Espécie *
                        </label>
                        <select id="species" 
                                name="species" 
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('species') border-red-300 @enderror"
                                required>
                            <option value="">Selecione a espécie</option>
                            <option value="Cão" {{ old('species', $pet->species) === 'Cão' ? 'selected' : '' }}>Cão</option>
                            <option value="Gato" {{ old('species', $pet->species) === 'Gato' ? 'selected' : '' }}>Gato</option>
                            <option value="Ave" {{ old('species', $pet->species) === 'Ave' ? 'selected' : '' }}>Ave</option>
                            <option value="Coelho" {{ old('species', $pet->species) === 'Coelho' ? 'selected' : '' }}>Coelho</option>
                            <option value="Hamster" {{ old('species', $pet->species) === 'Hamster' ? 'selected' : '' }}>Hamster</option>
                            <option value="Réptil" {{ old('species', $pet->species) === 'Réptil' ? 'selected' : '' }}>Réptil</option>
                            <option value="Peixe" {{ old('species', $pet->species) === 'Peixe' ? 'selected' : '' }}>Peixe</option>
                            <option value="Outros" {{ old('species', $pet->species) === 'Outros' ? 'selected' : '' }}>Outros</option>
                        </select>
                        @error('species')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Breed -->
                    <div>
                        <label for="breed" class="block text-sm font-medium text-gray-700 mb-2">
                            Raça
                        </label>
                        <input type="text" 
                               id="breed" 
                               name="breed" 
                               value="{{ old('breed', $pet->breed) }}"
                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('breed') border-red-300 @enderror"
                               placeholder="Ex: Labrador, Persa, SRD">
                        @error('breed')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                            Sexo
                        </label>
                        <select id="gender" 
                                name="gender" 
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('gender') border-red-300 @enderror">
                            <option value="">Selecione o sexo</option>
                            <option value="Macho" {{ old('gender', $pet->gender) === 'Macho' ? 'selected' : '' }}>Macho</option>
                            <option value="Fêmea" {{ old('gender', $pet->gender) === 'Fêmea' ? 'selected' : '' }}>Fêmea</option>
                        </select>
                        @error('gender')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Birth Date -->
                    <div>
                        <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Data de Nascimento
                        </label>
                        <input type="date" 
                               id="birth_date" 
                               name="birth_date" 
                               value="{{ old('birth_date', $pet->birth_date?->format('Y-m-d')) }}"
                               max="{{ date('Y-m-d') }}"
                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('birth_date') border-red-300 @enderror">
                        @error('birth_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Weight -->
                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">
                            Peso (kg)
                        </label>
                        <input type="number" 
                               id="weight" 
                               name="weight" 
                               value="{{ old('weight', $pet->weight) }}"
                               step="0.01"
                               min="0"
                               max="999.99"
                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('weight') border-red-300 @enderror">
                        @error('weight')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Color -->
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                            Cor/Pelagem
                        </label>
                        <input type="text" 
                               id="color" 
                               name="color" 
                               value="{{ old('color', $pet->color) }}"
                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('color') border-red-300 @enderror"
                               placeholder="Ex: Marrom, Preto e branco, Tricolor">
                        @error('color')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Microchip -->
                    <div>
                        <label for="microchip" class="block text-sm font-medium text-gray-700 mb-2">
                            Microchip
                        </label>
                        <input type="text" 
                               id="microchip" 
                               name="microchip" 
                               value="{{ old('microchip', $pet->microchip) }}"
                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('microchip') border-red-300 @enderror"
                               placeholder="Número do microchip">
                        @error('microchip')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Observações
                    </label>
                    <textarea id="notes" 
                              name="notes" 
                              rows="3"
                              class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-300 @enderror"
                              placeholder="Informações adicionais sobre o pet (temperamento, alergias, histórico médico, etc.)">{{ old('notes', $pet->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.clients.show', $pet->client) }}" 
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

    <!-- Pet Stats -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <div>
                <h3 class="text-sm font-medium text-blue-800">Estatísticas do Pet</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <ul class="list-disc list-inside space-y-1">
                        <li>{{ $pet->exams->count() }} exames realizados</li>
                        <li>Pet cadastrado em {{ $pet->created_at->format('d/m/Y') }}</li>
                        @if($pet->birth_date)
                            @php
                                $age = $pet->birth_date->diff(now());
                                $ageText = '';
                                if ($age->y > 0) $ageText .= $age->y . ' ano' . ($age->y > 1 ? 's' : '');
                                if ($age->m > 0) $ageText .= ($ageText ? ' e ' : '') . $age->m . ' mês' . ($age->m > 1 ? 'es' : '');
                                if (!$ageText) $ageText = $age->d . ' dia' . ($age->d > 1 ? 's' : '');
                            @endphp
                            <li>Idade aproximada: {{ $ageText }}</li>
                        @endif
                        @if($pet->weight)
                            <li>Peso atual: {{ number_format($pet->weight, 2, ',', '.') }} kg</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Section -->
    @if($pet->exams->count() === 0)
        <div class="bg-white shadow sm:rounded-lg border border-red-200">
            <div class="px-6 py-4 border-b border-red-200 bg-red-50">
                <h3 class="text-lg font-medium text-red-900">Excluir Pet</h3>
            </div>
            <div class="px-6 py-4">
                <p class="text-sm text-gray-700 mb-4">
                    Excluir este pet removerá permanentemente todos os seus dados. 
                    Esta ação não pode ser desfeita.
                </p>
                
                <form action="{{ route('admin.pets.destroy', $pet) }}" 
                      method="POST" 
                      class="inline"
                      onsubmit="return confirm('Tem certeza que deseja excluir este pet?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                        Excluir Pet
                    </button>
                </form>
            </div>
        </div>
    @else
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
                <svg class="w-5 h-5 text-yellow-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-yellow-800">Pet não pode ser excluído</h3>
                    <p class="mt-2 text-sm text-yellow-700">
                        Este pet possui {{ $pet->exams->count() }} exame{{ $pet->exams->count() > 1 ? 's' : '' }} cadastrado{{ $pet->exams->count() > 1 ? 's' : '' }} e não pode ser excluído.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection