@extends('layouts.admin-new')

@section('title', 'Cliente: ' . $client->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <div class="flex items-center space-x-3 mb-4">
            <a href="{{ route('admin.clients.index') }}" 
               class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">{{ $client->name }}</h1>
                <p class="text-sm text-gray-500">{{ $client->cpf }}</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.clients.edit', $client) }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Editar Cliente
            </a>

            <a href="{{ route('admin.pets.create', ['client_id' => $client->id]) }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Adicionar Pet
            </a>

            <a href="{{ route('admin.exams.create', ['client_id' => $client->id]) }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Novo Exame
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-md p-4">
            <div class="flex">
                <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <p class="ml-3 text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Client Information -->
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Informações do Cliente</h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nome</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $client->name }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">CPF</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $client->cpf }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $client->email ?: 'Não informado' }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Telefone</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $client->phone ?: 'Não informado' }}</dd>
                        </div>
                        
                        @if($client->birth_date)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Data de Nascimento</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $client->birth_date->format('d/m/Y') }}</dd>
                            </div>
                        @endif
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Cliente desde</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $client->created_at->format('d/m/Y') }}</dd>
                        </div>
                        
                        @if($client->last_login_at)
                            <div class="md:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Último acesso</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $client->last_login_at->format('d/m/Y H:i') }}</dd>
                            </div>
                        @endif
                    </dl>

                    @if($client->address)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <dt class="text-sm font-medium text-gray-500 mb-2">Endereço</dt>
                            <dd class="text-sm text-gray-900">{{ $client->address }}</dd>
                        </div>
                    @endif

                    @if($client->notes)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <dt class="text-sm font-medium text-gray-500 mb-2">Observações</dt>
                            <dd class="text-sm text-gray-900">{{ $client->notes }}</dd>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pets -->
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Pets ({{ $client->pets->count() }})</h3>
                    <a href="{{ route('admin.pets.create', ['client_id' => $client->id]) }}" 
                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        + Adicionar Pet
                    </a>
                </div>
                <div class="px-6 py-4">
                    @if($client->pets->count() > 0)
                        <div class="space-y-4">
                            @foreach($client->pets as $pet)
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900">{{ $pet->name }}</h4>
                                            <p class="text-sm text-gray-600">
                                                {{ $pet->species }}
                                                @if($pet->breed) - {{ $pet->breed }} @endif
                                                @if($pet->gender) • {{ $pet->gender }} @endif
                                            </p>
                                            @if($pet->birth_date)
                                                <p class="text-xs text-gray-500">
                                                    Nascido em {{ $pet->birth_date->format('d/m/Y') }}
                                                </p>
                                            @endif
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $pet->exams->count() }} exames cadastrados
                                            </p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.pets.edit', $pet) }}" 
                                               class="text-blue-600 hover:text-blue-800 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.pets.destroy', $pet) }}" 
                                                  method="POST" 
                                                  class="inline"
                                                  onsubmit="return confirm('Tem certeza que deseja excluir este pet?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6">
                            <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">Nenhum pet cadastrado</p>
                            <div class="mt-4">
                                <a href="{{ route('admin.pets.create', ['client_id' => $client->id]) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                    Cadastrar Primeiro Pet
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Exams History -->
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Histórico de Exames ({{ $client->exams->count() }})</h3>
                </div>
                <div class="px-6 py-4">
                    @if($client->exams->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Pet</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($client->exams->sortByDesc('exam_date')->take(10) as $exam)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2">
                                                <a href="{{ route('admin.exams.show', $exam->codigo) }}" 
                                                   class="text-blue-600 hover:text-blue-800 font-medium">
                                                    {{ $exam->codigo }}
                                                </a>
                                            </td>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $exam->pet->name }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $exam->examType->name }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $exam->exam_date->format('d/m/Y') }}</td>
                                            <td class="px-4 py-2">
                                                <x-status-badge :status="$exam->status" />
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($client->exams->count() > 10)
                            <div class="mt-4 text-center">
                                <a href="{{ route('admin.exams.index', ['search' => $client->cpf]) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Ver todos os exames ({{ $client->exams->count() }})
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-6">
                            <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">Nenhum exame registrado</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Statistics -->
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Estatísticas</h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $stats['total_pets'] }}</div>
                        <div class="text-sm text-gray-500">Pets cadastrados</div>
                    </div>
                    
                    <div class="text-center border-t pt-4">
                        <div class="text-3xl font-bold text-green-600">{{ $stats['total_exams'] }}</div>
                        <div class="text-sm text-gray-500">Exames realizados</div>
                    </div>

                    <div class="text-center border-t pt-4">
                        <div class="text-3xl font-bold text-purple-600">{{ $stats['ready_exams'] }}</div>
                        <div class="text-sm text-gray-500">Exames prontos</div>
                    </div>

                    @if($stats['last_exam'])
                        <div class="text-center border-t pt-4">
                            <div class="text-sm text-gray-500">Último exame</div>
                            <div class="text-sm font-medium text-gray-900">
                                {{ $stats['last_exam']->exam_date->format('d/m/Y') }}
                            </div>
                        </div>
                    @endif

                    <div class="text-center border-t pt-4">
                        <div class="text-2xl font-bold text-orange-600">{{ $stats['total_downloads'] }}</div>
                        <div class="text-sm text-gray-500">Downloads realizados</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Ações Rápidas</h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <button onclick="copyToClipboard('{{ $client->cpf }}')" 
                            class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md transition-colors">
                        📋 Copiar CPF
                    </button>
                    
                    @if($client->email)
                        <button onclick="copyToClipboard('{{ $client->email }}')" 
                                class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md transition-colors">
                            📧 Copiar Email
                        </button>
                    @endif

                    @if($client->phone)
                        <a href="https://wa.me/55{{ preg_replace('/[^0-9]/', '', $client->phone) }}?text=Olá {{ $client->name }}!" 
                           target="_blank"
                           class="block w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md transition-colors">
                            💬 Contatar no WhatsApp
                        </a>
                    @endif
                    
                    <a href="{{ route('client.login') }}" 
                       target="_blank"
                       class="block w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md transition-colors">
                        🔗 Portal do Cliente
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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