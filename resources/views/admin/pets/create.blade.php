@extends('layouts.admin-new')

@section('title', 'Novo Pet')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <div class="flex items-center space-x-3">
            @if($client)
                <a href="{{ route('admin.clients.show', $client) }}" 
                   class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
            @else
                <a href="{{ route('admin.clients.index') }}" 
                   class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
            @endif
            <h1 class="text-2xl font-semibold text-gray-900">Novo Pet</h1>
        </div>
        @if($client)
            <p class="mt-2 text-sm text-gray-700">Cadastrando pet para: <span class="font-medium">{{ $client->name }}</span></p>
        @else
            <p class="mt-2 text-sm text-gray-700">Cadastre um novo pet para um cliente</p>
        @endif
    </div>

    <!-- Form -->
    <div class="bg-white shadow sm:rounded-lg">
        <form action="{{ route('admin.pets.store') }}" method="POST" class="space-y-6 p-6">
            @csrf
            @if(request()->has('redirect_to'))
                <input type="hidden" name="redirect_to" value="{{ request('redirect_to') }}">
            @endif

            <!-- Client Selection -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Cliente</h3>
                
                <div>
                    <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Selecionar Cliente *
                    </label>
                    <select id="client_id" 
                            name="client_id" 
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('client_id') border-red-300 @enderror"
                            required
                            @if($client) readonly @endif>
                        <option value="">Selecione um cliente</option>
                        @foreach($clients as $clientOption)
                            <option value="{{ $clientOption->id }}" 
                                    {{ (old('client_id', $client?->id) == $clientOption->id) ? 'selected' : '' }}>
                                {{ $clientOption->name }} - {{ $clientOption->cpf }}
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
                               value="{{ old('name') }}"
                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-300 @enderror"
                               placeholder="Ex: Rex, Miau, Buddy"
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
                            <option value="Cão" {{ old('species') === 'Cão' ? 'selected' : '' }}>Cão</option>
                            <option value="Gato" {{ old('species') === 'Gato' ? 'selected' : '' }}>Gato</option>
                            <option value="Ave" {{ old('species') === 'Ave' ? 'selected' : '' }}>Ave</option>
                            <option value="Coelho" {{ old('species') === 'Coelho' ? 'selected' : '' }}>Coelho</option>
                            <option value="Hamster" {{ old('species') === 'Hamster' ? 'selected' : '' }}>Hamster</option>
                            <option value="Réptil" {{ old('species') === 'Réptil' ? 'selected' : '' }}>Réptil</option>
                            <option value="Peixe" {{ old('species') === 'Peixe' ? 'selected' : '' }}>Peixe</option>
                            <option value="Outros" {{ old('species') === 'Outros' ? 'selected' : '' }}>Outros</option>
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
                               value="{{ old('breed') }}"
                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('breed') border-red-300 @enderror"
                               placeholder="Ex: Labrador, Persa, SRD">
                        @error('breed')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">SRD = Sem Raça Definida</p>
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
                            <option value="Macho" {{ old('gender') === 'Macho' ? 'selected' : '' }}>Macho</option>
                            <option value="Fêmea" {{ old('gender') === 'Fêmea' ? 'selected' : '' }}>Fêmea</option>
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
                               value="{{ old('birth_date') }}"
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
                               value="{{ old('weight') }}"
                               step="0.01"
                               min="0"
                               max="999.99"
                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('weight') border-red-300 @enderror"
                               placeholder="Ex: 5.5">
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
                               value="{{ old('color') }}"
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
                               value="{{ old('microchip') }}"
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
                              placeholder="Informações adicionais sobre o pet (temperamento, alergias, histórico médico, etc.)">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                @if($client)
                    <a href="{{ route('admin.clients.show', $client) }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Cancelar
                    </a>
                @else
                    <a href="{{ route('admin.clients.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Cancelar
                    </a>
                @endif
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    Cadastrar Pet
                </button>
            </div>
        </form>
    </div>

    <!-- Quick Species Guide -->
    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex">
            <svg class="w-5 h-5 text-green-600 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <div>
                <h3 class="text-sm font-medium text-green-800">Dicas de preenchimento</h3>
                <div class="mt-2 text-sm text-green-700">
                    <ul class="list-disc list-inside space-y-1">
                        <li><strong>Nome:</strong> Use o nome pelo qual o pet é conhecido</li>
                        <li><strong>Raça:</strong> Se não souber, use "SRD" (Sem Raça Definida) ou "Vira-lata"</li>
                        <li><strong>Peso:</strong> Peso aproximado atual (pode ser atualizado depois)</li>
                        <li><strong>Observações:</strong> Anote alergias, comportamento, medicamentos, etc.</li>
                    </ul>
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
    // Add hidden input with client_id
    const form = document.querySelector('form');
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'client_id';
    hiddenInput.value = '{{ $client->id }}';
    form.appendChild(hiddenInput);
});
@endif
</script>
@endsection