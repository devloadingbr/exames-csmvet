@extends('layouts.admin-new')

@section('title', 'Exame ' . $exam->codigo)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <div class="flex items-center space-x-3 mb-4">
            <a href="{{ route('admin.exams.index') }}" 
               class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">{{ $exam->codigo }}</h1>
                <div class="flex items-center mt-1 space-x-3">
                    @php
                        $statusClasses = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'processing' => 'bg-blue-100 text-blue-800',
                            'ready' => 'bg-green-100 text-green-800',
                            'failed' => 'bg-red-100 text-red-800'
                        ];
                        $statusLabels = [
                            'pending' => 'Pendente',
                            'processing' => 'Processando',
                            'ready' => 'Pronto',
                            'failed' => 'Falhou'
                        ];
                    @endphp
                    <span class="inline-flex px-2 py-1 text-sm font-semibold rounded-full {{ $statusClasses[$exam->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $statusLabels[$exam->status] ?? $exam->status }}
                    </span>
                    <span class="text-sm text-gray-500">
                        Enviado em {{ $exam->created_at->format('d/m/Y \à\s H:i') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-3">
            @if($exam->status === 'ready')
                <a href="{{ route('admin.exams.download', $exam->codigo) }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download PDF
                </a>
            @endif

            <button onclick="window.print()" 
                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Imprimir
            </button>

            <button onclick="shareExam()" 
                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Reenviar Email
            </button>

            <a href="{{ route('admin.exams.edit', $exam->codigo) }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Editar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Exam Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Info -->
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Informações do Exame</h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Tipo</label>
                            <div class="mt-1 flex items-center">
                                <div class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $exam->examType->color }}"></div>
                                <span class="text-sm text-gray-900">{{ $exam->examType->name }}</span>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Data do Exame</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $exam->exam_date->format('d/m/Y') }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Veterinário</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $exam->veterinarian_name }}</p>
                            @if($exam->veterinarian_crmv)
                                <p class="text-xs text-gray-500">CRMV: {{ $exam->veterinarian_crmv }}</p>
                            @endif
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Enviado por</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $exam->uploadedBy->name }}</p>
                        </div>
                    </div>

                    @if($exam->description)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Observações</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $exam->description }}</p>
                        </div>
                    @endif

                    @if($exam->result_summary)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Resumo do Resultado</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $exam->result_summary }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pet & Client Info -->
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Pet e Cliente</h3>
                </div>
                <div class="px-6 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Pet Info -->
                        <div>
                            <h4 class="font-medium text-gray-900 mb-3">{{ $exam->pet->name }}</h4>
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Espécie:</dt>
                                    <dd class="text-sm text-gray-900">{{ $exam->pet->species }}</dd>
                                </div>
                                @if($exam->pet->breed)
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Raça:</dt>
                                        <dd class="text-sm text-gray-900">{{ $exam->pet->breed }}</dd>
                                    </div>
                                @endif
                                @if($exam->pet->gender)
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Sexo:</dt>
                                        <dd class="text-sm text-gray-900">{{ $exam->pet->gender }}</dd>
                                    </div>
                                @endif
                                @if($exam->pet->birth_date)
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Nascimento:</dt>
                                        <dd class="text-sm text-gray-900">{{ $exam->pet->birth_date->format('d/m/Y') }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        <!-- Client Info -->
                        <div>
                            <h4 class="font-medium text-gray-900 mb-3">{{ $exam->client->name }}</h4>
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">CPF:</dt>
                                    <dd class="text-sm text-gray-900">{{ $exam->client->cpf }}</dd>
                                </div>
                                @if($exam->client->phone)
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Telefone:</dt>
                                        <dd class="text-sm text-gray-900">{{ $exam->client->phone }}</dd>
                                    </div>
                                @endif
                                @if($exam->client->email)
                                    <div class="flex justify-between">
                                        <dt class="text-sm text-gray-500">Email:</dt>
                                        <dd class="text-sm text-gray-900">{{ $exam->client->email }}</dd>
                                    </div>
                                @endif
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Último acesso:</dt>
                                    <dd class="text-sm text-gray-900">
                                        @if($exam->client->last_login_at)
                                            {{ $exam->client->last_login_at->format('d/m/Y H:i') }}
                                        @else
                                            Nunca
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Download History -->
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Histórico de Downloads</h3>
                </div>
                <div class="px-6 py-4">
                    @if($exam->downloads->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider py-2">Data/Hora</th>
                                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider py-2">IP</th>
                                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider py-2">Navegador</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($exam->downloads->sortByDesc('downloaded_at') as $download)
                                        <tr>
                                            <td class="py-2 text-sm text-gray-900">
                                                {{ $download->downloaded_at->format('d/m/Y H:i:s') }}
                                            </td>
                                            <td class="py-2 text-sm text-gray-600">
                                                {{ $download->ip_address ?? 'N/A' }}
                                            </td>
                                            <td class="py-2 text-sm text-gray-600">
                                                {{ substr($download->user_agent ?? 'N/A', 0, 50) }}{{ strlen($download->user_agent ?? '') > 50 ? '...' : '' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-6">
                            <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">Este exame ainda não foi baixado pelo cliente</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- File Info -->
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Arquivo</h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $exam->original_filename }}</p>
                            <p class="text-xs text-gray-500">{{ $exam->formatted_size }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Tipo:</span>
                            <span class="text-gray-900">PDF</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Storage:</span>
                            <span class="text-gray-900 capitalize">{{ $exam->storage_disk }}</span>
                        </div>
                        @if($exam->file_hash)
                            <div class="flex justify-between">
                                <span class="text-gray-500">Hash:</span>
                                <span class="text-gray-900 font-mono text-xs">{{ substr($exam->file_hash, 0, 8) }}...</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Estatísticas</h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $exam->downloads->count() }}</div>
                        <div class="text-sm text-gray-500">Downloads totais</div>
                    </div>
                    
                    @if($exam->downloads->count() > 0)
                        <div class="text-center border-t pt-4">
                            <div class="text-sm text-gray-500">Primeiro download</div>
                            <div class="text-sm font-medium text-gray-900">
                                {{ $exam->downloads->min('downloaded_at')->format('d/m/Y H:i') }}
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <div class="text-sm text-gray-500">Último download</div>
                            <div class="text-sm font-medium text-gray-900">
                                {{ $exam->downloads->max('downloaded_at')->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Ações Rápidas</h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <button onclick="copyToClipboard('{{ route('client.login') }}')" 
                            class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md transition-colors">
                        📋 Copiar link do portal
                    </button>
                    
                    <button onclick="copyToClipboard('{{ $exam->codigo }}')" 
                            class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md transition-colors">
                        🔢 Copiar código do exame
                    </button>
                    
                    <a href="https://wa.me/?text=Olá! Seu exame {{ $exam->codigo }} está disponível. Acesse: {{ route('client.login') }}" 
                       target="_blank"
                       class="block w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md transition-colors">
                        💬 Compartilhar no WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function shareExam() {
    alert('Funcionalidade de reenvio de email será implementada em breve!');
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Mostrar feedback visual
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md z-50';
        toast.textContent = 'Copiado para a área de transferência!';
        document.body.appendChild(toast);
        
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 2000);
    });
}
</script>
@endsection