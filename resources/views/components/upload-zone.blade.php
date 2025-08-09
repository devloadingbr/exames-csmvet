@props(['name' => 'file', 'accept' => '.pdf', 'maxSize' => '50MB', 'required' => false])

<div x-data="uploadZone()" 
     @dragover.prevent="dragover = true"
     @dragleave="dragover = false"
     @drop.prevent="handleDrop($event)"
     class="upload-zone">
     
    <div :class="{ 
        'border-blue-500 bg-blue-50': dragover,
        'border-gray-300': !dragover,
        'border-red-300': error
    }" 
         class="border-2 border-dashed rounded-lg p-8 text-center transition-colors">
        
        <!-- Empty State -->
        <template x-show="!selectedFile && !error">
            <div class="space-y-4">
                <svg class="w-16 h-16 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                
                <div>
                    <p class="text-lg font-medium text-gray-700">
                        Arraste {{ $accept === '.pdf' ? 'um PDF' : 'arquivos' }} aqui
                    </p>
                    <p class="text-sm text-gray-500">
                        ou clique para selecionar
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        Máximo: {{ $maxSize }}
                    </p>
                </div>
                
                <input type="file" 
                       x-ref="fileInput" 
                       @change="handleFile($event)"
                       accept="{{ $accept }}" 
                       name="{{ $name }}"
                       {{ $required ? 'required' : '' }}
                       class="hidden">
                       
                <button type="button" 
                        @click="$refs.fileInput.click()" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                    Selecionar Arquivo
                </button>
            </div>
        </template>
        
        <!-- File Selected -->
        <template x-show="selectedFile && !error">
            <div class="space-y-4">
                <svg class="w-16 h-16 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                
                <div>
                    <p class="font-medium text-gray-900" x-text="selectedFile?.name"></p>
                    <p class="text-sm text-gray-500" x-text="formatFileSize(selectedFile?.size)"></p>
                </div>
                
                <!-- Upload Progress -->
                <div x-show="uploading" class="w-full">
                    <div class="bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                             :style="`width: ${uploadProgress}%`"></div>
                    </div>
                    <p class="text-sm text-gray-600 mt-2" x-text="`${uploadProgress}% enviado`"></p>
                </div>
                
                <div class="flex space-x-3" x-show="!uploading">
                    <button type="button" 
                            @click="resetUpload()" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                        Trocar Arquivo
                    </button>
                </div>
            </div>
        </template>
        
        <!-- Error State -->
        <template x-show="error">
            <div class="space-y-4">
                <svg class="w-16 h-16 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                
                <div>
                    <p class="font-medium text-red-900">Erro no arquivo</p>
                    <p class="text-sm text-red-600" x-text="errorMessage"></p>
                </div>
                
                <button type="button" 
                        @click="resetUpload()" 
                        class="px-4 py-2 bg-red-100 text-red-800 rounded-md hover:bg-red-200 transition-colors">
                    Tentar Novamente
                </button>
            </div>
        </template>
    </div>
</div>

<script>
function uploadZone() {
    return {
        selectedFile: null,
        dragover: false,
        uploading: false,
        uploadProgress: 0,
        error: false,
        errorMessage: '',

        handleFile(event) {
            const file = event.target.files[0];
            this.validateAndSetFile(file);
        },

        handleDrop(event) {
            this.dragover = false;
            const file = event.dataTransfer.files[0];
            this.validateAndSetFile(file);
            
            // Sync with file input
            if (file && !this.error) {
                this.$refs.fileInput.files = event.dataTransfer.files;
            }
        },

        validateAndSetFile(file) {
            this.error = false;
            this.errorMessage = '';

            if (!file) {
                return;
            }

            // Validate file type
            const accept = '{{ $accept }}';
            if (accept === '.pdf' && file.type !== 'application/pdf') {
                this.error = true;
                this.errorMessage = 'Apenas arquivos PDF são aceitos.';
                return;
            }

            // Validate file size (50MB default)
            const maxSizeBytes = 50 * 1024 * 1024; // 50MB
            if (file.size > maxSizeBytes) {
                this.error = true;
                this.errorMessage = 'Arquivo muito grande. Máximo permitido: {{ $maxSize }}.';
                return;
            }

            this.selectedFile = file;
        },

        resetUpload() {
            this.selectedFile = null;
            this.uploading = false;
            this.uploadProgress = 0;
            this.error = false;
            this.errorMessage = '';
            this.$refs.fileInput.value = '';
        },

        formatFileSize(bytes) {
            if (!bytes) return '0 bytes';
            
            if (bytes >= 1073741824) {
                return (bytes / 1073741824).toFixed(2) + ' GB';
            } else if (bytes >= 1048576) {
                return (bytes / 1048576).toFixed(2) + ' MB';
            } else if (bytes >= 1024) {
                return (bytes / 1024).toFixed(2) + ' KB';
            } else {
                return bytes + ' bytes';
            }
        },

        // Simulate upload progress (called externally)
        startUploadProgress() {
            this.uploading = true;
            this.uploadProgress = 0;

            const interval = setInterval(() => {
                this.uploadProgress += 10;
                if (this.uploadProgress >= 90) {
                    clearInterval(interval);
                }
            }, 200);

            return interval;
        }
    }
}
</script>