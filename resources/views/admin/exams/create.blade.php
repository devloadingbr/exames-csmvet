@extends('layouts.admin-new')

@section('title', 'Novo Exame')

@section('content')
<div class="space-y-6" x-data="examUpload()">
    <!-- Header -->
    <div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.exams.index') }}" 
               class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-semibold text-gray-900">Novo Exame</h1>
        </div>
        <p class="mt-2 text-sm text-gray-700">Faça upload de um novo exame para disponibilizar ao cliente</p>
    </div>

    <!-- Progress Steps -->
    <div class="bg-white shadow sm:rounded-lg p-6">
        <nav aria-label="Progress">
            <ol class="flex items-center">
                <li class="relative">
                    <div class="flex items-center">
                        <div :class="step >= 1 ? 'bg-blue-600' : 'bg-gray-300'" 
                             class="flex items-center justify-center w-8 h-8 rounded-full text-white text-sm font-medium">
                            1
                        </div>
                        <span class="ml-3 text-sm font-medium" :class="step >= 1 ? 'text-gray-900' : 'text-gray-500'">
                            Informações do Exame
                        </span>
                    </div>
                    <div class="absolute top-4 left-4 w-full h-0.5 bg-gray-300" x-show="step > 1"></div>
                </li>
                
                <li class="relative ml-8">
                    <div class="flex items-center">
                        <div :class="step >= 2 ? 'bg-blue-600' : 'bg-gray-300'" 
                             class="flex items-center justify-center w-8 h-8 rounded-full text-white text-sm font-medium">
                            2
                        </div>
                        <span class="ml-3 text-sm font-medium" :class="step >= 2 ? 'text-gray-900' : 'text-gray-500'">
                            Selecionar Pet
                        </span>
                    </div>
                    <div class="absolute top-4 left-4 w-full h-0.5 bg-gray-300" x-show="step > 2"></div>
                </li>
                
                <li class="relative ml-8">
                    <div class="flex items-center">
                        <div :class="step >= 3 ? 'bg-blue-600' : 'bg-gray-300'" 
                             class="flex items-center justify-center w-8 h-8 rounded-full text-white text-sm font-medium">
                            3
                        </div>
                        <span class="ml-3 text-sm font-medium" :class="step >= 3 ? 'text-gray-900' : 'text-gray-500'">
                            Upload do Arquivo
                        </span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Form Steps -->
    <form action="{{ route('admin.exams.store') }}" method="POST" enctype="multipart/form-data" @submit.prevent="submitForm">
        @csrf
        
        <!-- Step 1: Exam Info -->
        <div x-show="step === 1" class="bg-white shadow sm:rounded-lg p-6 space-y-6">
            <h3 class="text-lg font-medium text-gray-900">Informações do Exame</h3>
            
            <!-- Exam Type -->
            <div>
                <label for="exam_type_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Tipo de Exame *
                </label>
                <select id="exam_type_id" 
                        name="exam_type_id" 
                        x-model="form.exam_type_id"
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                    <option value="">Selecione o tipo de exame</option>
                    @foreach($examTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Exam Date -->
            <div>
                <label for="exam_date" class="block text-sm font-medium text-gray-700 mb-2">
                    Data do Exame *
                </label>
                <input type="date" 
                       id="exam_date" 
                       name="exam_date" 
                       x-model="form.exam_date"
                       max="{{ date('Y-m-d') }}"
                       class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                       required>
            </div>

            <!-- Veterinarian -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="veterinarian_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Veterinário Responsável *
                    </label>
                    <input type="text" 
                           id="veterinarian_name" 
                           name="veterinarian_name" 
                           x-model="form.veterinarian_name"
                           class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Dr. João Silva"
                           required>
                </div>
                
                <div>
                    <label for="veterinarian_crmv" class="block text-sm font-medium text-gray-700 mb-2">
                        CRMV
                    </label>
                    <input type="text" 
                           id="veterinarian_crmv" 
                           name="veterinarian_crmv" 
                           x-model="form.veterinarian_crmv"
                           class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           placeholder="1234/SP">
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Observações
                </label>
                <textarea id="description" 
                          name="description" 
                          x-model="form.description"
                          rows="3"
                          class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Observações sobre o exame..."></textarea>
            </div>

            <div class="flex justify-end">
                <button type="button" 
                        @click="nextStep()"
                        :disabled="!canGoToStep2"
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed transition-colors">
                    Próximo
                </button>
            </div>
        </div>

        <!-- Step 2: Select Pet -->
        <div x-show="step === 2" class="bg-white shadow sm:rounded-lg p-6 space-y-6">
            <h3 class="text-lg font-medium text-gray-900">Selecionar Pet</h3>
            
            <!-- Pet Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Buscar Pet ou Cliente
                </label>
                <div class="relative">
                    <input type="text" 
                           x-model="petSearch"
                           @input="searchPets()"
                           class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 pr-10"
                           placeholder="Digite o nome do pet ou cliente">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pet Selection -->
            <div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" x-show="availablePets.length > 0">
                    <template x-for="pet in availablePets" :key="pet.id">
                        <div class="border border-gray-200 rounded-lg p-4 cursor-pointer hover:bg-gray-50 transition-colors"
                             :class="form.pet_id === pet.id ? 'border-blue-500 bg-blue-50' : ''"
                             @click="selectPet(pet)">
                            <div class="flex items-center space-x-3">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900" x-text="pet.name"></h4>
                                    <p class="text-sm text-gray-600">
                                        <span x-text="pet.species"></span>
                                        <template x-if="pet.breed">
                                            - <span x-text="pet.breed"></span>
                                        </template>
                                    </p>
                                    <p class="text-sm text-gray-500" x-text="pet.client.name"></p>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="w-4 h-4 border-2 rounded-full" 
                                         :class="form.pet_id === pet.id ? 'border-blue-500 bg-blue-500' : 'border-gray-300'">
                                        <div x-show="form.pet_id === pet.id" class="w-2 h-2 bg-white rounded-full m-0.5"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- New Pet Button -->
                <div class="mt-4">
                    <button type="button" 
                            @click="showNewPetModal = true"
                            class="w-full border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-gray-400 transition-colors">
                        <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">Cadastrar novo pet</p>
                    </button>
                </div>
            </div>

            <div class="flex justify-between">
                <button type="button" 
                        @click="prevStep()"
                        class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                    Anterior
                </button>
                <button type="button" 
                        @click="nextStep()"
                        :disabled="!form.pet_id"
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed transition-colors">
                    Próximo
                </button>
            </div>
        </div>

        <!-- Step 3: File Upload -->
        <div x-show="step === 3" class="bg-white shadow sm:rounded-lg p-6 space-y-6">
            <h3 class="text-lg font-medium text-gray-900">Upload do Arquivo</h3>
            
            <!-- Upload Zone -->
            <div class="upload-zone" 
                 @dragover.prevent="dragover = true"
                 @dragleave="dragover = false"
                 @drop.prevent="handleDrop($event)">
                <div :class="{ 
                    'border-blue-500 bg-blue-50': dragover,
                    'border-gray-300': !dragover 
                }" 
                     class="border-2 border-dashed rounded-lg p-8 text-center transition-colors">
                    
                    <template x-if="!selectedFile">
                        <div class="space-y-4">
                            <svg class="w-16 h-16 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            
                            <div>
                                <p class="text-lg font-medium text-gray-700">
                                    Arraste um PDF aqui
                                </p>
                                <p class="text-sm text-gray-500">
                                    ou clique para selecionar
                                </p>
                            </div>
                            
                            <input type="file" 
                                   x-ref="fileInput" 
                                   @change="handleFile($event)"
                                   accept=".pdf" 
                                   name="exam_file"
                                   class="hidden"
                                   required>
                                   
                            <button type="button" 
                                    @click="$refs.fileInput.click()" 
                                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                                Selecionar Arquivo
                            </button>
                        </div>
                    </template>
                    
                    <template x-if="selectedFile">
                        <div class="space-y-4">
                            <svg class="w-16 h-16 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            
                            <div>
                                <p class="font-medium text-gray-900" x-text="selectedFile.name"></p>
                                <p class="text-sm text-gray-500" x-text="formatFileSize(selectedFile.size)"></p>
                            </div>
                            
                            <div x-show="uploading" class="w-full">
                                <div class="bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                                         :style="`width: ${uploadProgress}%`"></div>
                                </div>
                                <p class="text-sm text-gray-600 mt-2" x-text="`${uploadProgress}% enviado`"></p>
                            </div>
                            
                            <div class="flex space-x-3">
                                <button type="button" 
                                        @click="resetUpload()" 
                                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                                    Trocar Arquivo
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="flex justify-between">
                <button type="button" 
                        @click="prevStep()"
                        class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                    Anterior
                </button>
                <button type="submit" 
                        :disabled="!selectedFile || uploading"
                        class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 disabled:bg-gray-300 disabled:cursor-not-allowed transition-colors">
                    <span x-show="!uploading">Finalizar e Enviar</span>
                    <span x-show="uploading">Enviando...</span>
                </button>
            </div>
        </div>

        <!-- Hidden inputs for form data -->
        <input type="hidden" name="pet_id" x-model="form.pet_id">
        <input type="hidden" name="client_id" x-model="form.client_id">
    </form>

    <!-- New Pet Modal -->
    <div x-show="showNewPetModal" 
         x-transition
         class="fixed inset-0 z-10 overflow-y-auto" 
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Cadastrar Novo Pet</h3>
                    
                    <div class="space-y-4">
                        <!-- Pet Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nome do Pet *</label>
                            <input type="text" 
                                   x-model="newPet.name"
                                   class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                   required>
                        </div>

                        <!-- Client -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cliente *</label>
                            <select x-model="newPet.client_id" 
                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="">Selecione um cliente</option>
                                <template x-for="client in availableClients" :key="client.id">
                                    <option :value="client.id" x-text="`${client.name} - ${client.cpf}`"></option>
                                </template>
                            </select>
                            <div class="mt-2">
                                <button type="button" 
                                        @click="showNewClientModal = true"
                                        class="text-sm text-blue-600 hover:text-blue-800">
                                    + Cadastrar novo cliente
                                </button>
                            </div>
                        </div>

                        <!-- Species -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Espécie *</label>
                            <select x-model="newPet.species" 
                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="">Selecione a espécie</option>
                                <option value="Cão">Cão</option>
                                <option value="Gato">Gato</option>
                                <option value="Ave">Ave</option>
                                <option value="Coelho">Coelho</option>
                                <option value="Outros">Outros</option>
                            </select>
                        </div>

                        <!-- Breed -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Raça</label>
                            <input type="text" 
                                   x-model="newPet.breed"
                                   class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Gender -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sexo</label>
                            <select x-model="newPet.gender" 
                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Selecione o sexo</option>
                                <option value="Macho">Macho</option>
                                <option value="Fêmea">Fêmea</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" 
                            @click="savePet()"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Salvar Pet
                    </button>
                    <button type="button" 
                            @click="showNewPetModal = false"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- New Client Modal -->
    <div x-show="showNewClientModal" 
         x-transition
         class="fixed inset-0 z-20 overflow-y-auto" 
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Cadastrar Novo Cliente</h3>
                    
                    <div class="space-y-4">
                        <!-- Client Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nome Completo *</label>
                            <input type="text" 
                                   x-model="newClient.name"
                                   class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                   required>
                        </div>

                        <!-- CPF -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">CPF *</label>
                            <input type="text" 
                                   x-model="newClient.cpf"
                                   @input="formatCPF($event)"
                                   class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="000.000.000-00"
                                   maxlength="14"
                                   required>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" 
                                   x-model="newClient.email"
                                   class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Telefone</label>
                            <input type="tel" 
                                   x-model="newClient.phone"
                                   @input="formatPhone($event)"
                                   class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="(11) 99999-9999">
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" 
                            @click="saveClient()"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Salvar Cliente
                    </button>
                    <button type="button" 
                            @click="showNewClientModal = false"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function examUpload() {
    return {
        step: 1,
        form: {
            exam_type_id: '',
            exam_date: '',
            veterinarian_name: '',
            veterinarian_crmv: '',
            description: '',
            pet_id: '',
            client_id: ''
        },
        petSearch: '',
        availablePets: @json($pets),
        availableClients: [],
        selectedFile: null,
        dragover: false,
        uploading: false,
        uploadProgress: 0,
        showNewPetModal: false,
        showNewClientModal: false,
        newPet: {
            name: '',
            client_id: '',
            species: '',
            breed: '',
            gender: ''
        },
        newClient: {
            name: '',
            cpf: '',
            email: '',
            phone: ''
        },

        get canGoToStep2() {
            return this.form.exam_type_id && this.form.exam_date && this.form.veterinarian_name;
        },

        nextStep() {
            if (this.step < 3) {
                this.step++;
            }
        },

        prevStep() {
            if (this.step > 1) {
                this.step--;
            }
        },

        searchPets() {
            if (this.petSearch.length >= 2) {
                fetch(`{{ route('admin.pets.search') }}?q=${encodeURIComponent(this.petSearch)}`)
                    .then(response => response.json())
                    .then(pets => {
                        this.availablePets = pets;
                    });
            }
        },

        selectPet(pet) {
            this.form.pet_id = pet.id;
            this.form.client_id = pet.client_id;
        },

        handleFile(event) {
            const file = event.target.files[0];
            if (file && file.type === 'application/pdf') {
                this.selectedFile = file;
            } else {
                alert('Por favor, selecione apenas arquivos PDF.');
                event.target.value = '';
            }
        },

        handleDrop(event) {
            this.dragover = false;
            const file = event.dataTransfer.files[0];
            if (file && file.type === 'application/pdf') {
                this.selectedFile = file;
                this.$refs.fileInput.files = event.dataTransfer.files;
            } else {
                alert('Por favor, selecione apenas arquivos PDF.');
            }
        },

        resetUpload() {
            this.selectedFile = null;
            this.uploading = false;
            this.uploadProgress = 0;
            this.$refs.fileInput.value = '';
        },

        formatFileSize(bytes) {
            return (bytes / 1024 / 1024).toFixed(2) + ' MB';
        },

        submitForm(event) {
            if (!this.selectedFile) {
                alert('Por favor, selecione um arquivo PDF.');
                return;
            }

            // Simular progresso de upload
            this.uploading = true;
            this.uploadProgress = 0;

            const interval = setInterval(() => {
                this.uploadProgress += 10;
                if (this.uploadProgress >= 90) {
                    clearInterval(interval);
                }
            }, 200);

            // Submit real form
            event.target.submit();
        },

        async savePet() {
            if (!this.newPet.name || !this.newPet.client_id || !this.newPet.species) {
                alert('Preencha os campos obrigatórios');
                return;
            }

            try {
                const response = await fetch('{{ route("admin.pets.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify(this.newPet)
                });

                const data = await response.json();

                if (response.ok) {
                    // Adicionar o novo pet à lista
                    this.availablePets.unshift(data.pet);
                    
                    // Selecionar automaticamente o novo pet
                    this.selectPet(data.pet);
                    
                    // Limpar formulário e fechar modal
                    this.newPet = { name: '', client_id: '', species: '', breed: '', gender: '' };
                    this.showNewPetModal = false;
                    
                    alert('Pet cadastrado com sucesso!');
                } else {
                    alert(data.message || 'Erro ao cadastrar pet');
                }
            } catch (error) {
                alert('Erro ao cadastrar pet');
                console.error(error);
            }
        },

        async saveClient() {
            if (!this.newClient.name || !this.newClient.cpf) {
                alert('Preencha os campos obrigatórios');
                return;
            }

            try {
                const response = await fetch('{{ route("admin.clients.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify(this.newClient)
                });

                const data = await response.json();

                if (response.ok) {
                    // Adicionar o novo cliente à lista
                    this.availableClients.unshift(data.client);
                    
                    // Selecionar automaticamente o novo cliente no modal de pet
                    this.newPet.client_id = data.client.id;
                    
                    // Limpar formulário e fechar modal
                    this.newClient = { name: '', cpf: '', email: '', phone: '' };
                    this.showNewClientModal = false;
                    
                    alert('Cliente cadastrado com sucesso!');
                } else {
                    alert(data.message || 'Erro ao cadastrar cliente');
                }
            } catch (error) {
                alert('Erro ao cadastrar cliente');
                console.error(error);
            }
        },

        formatCPF(event) {
            let value = event.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                this.newClient.cpf = value;
            }
        },

        formatPhone(event) {
            let value = event.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                if (value.length > 10) {
                    value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                } else {
                    value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
                }
                this.newClient.phone = value;
            }
        },

        async loadClients() {
            try {
                const response = await fetch('{{ route("admin.clients.index") }}?format=json');
                const data = await response.json();
                this.availableClients = data.clients || [];
            } catch (error) {
                console.error('Erro ao carregar clientes:', error);
            }
        },

        // Inicialização
        init() {
            this.loadClients();
        }
    }
}
</script>
@endsection