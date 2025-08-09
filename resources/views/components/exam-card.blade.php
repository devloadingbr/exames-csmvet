@props(['exam'])

<div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border border-gray-100">
    <div class="flex items-start justify-between mb-4">
        <div class="flex-1">
            <a href="{{ route('admin.exams.show', $exam->codigo) }}" 
               class="text-lg font-semibold text-gray-900 hover:text-blue-600 transition-colors">
                {{ $exam->codigo }}
            </a>
            <p class="text-sm text-gray-600 mt-1">{{ $exam->pet->name }}</p>
            <p class="text-xs text-gray-500">{{ $exam->client->name }}</p>
            
            <div class="flex items-center mt-2">
                <div class="w-2 h-2 rounded-full mr-2" style="background-color: {{ $exam->examType->color }}"></div>
                <span class="text-xs text-gray-500">{{ $exam->examType->name }}</span>
            </div>
        </div>
        
        <x-status-badge :status="$exam->status" />
    </div>
    
    <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
        <span>{{ $exam->exam_date->format('d/m/Y') }}</span>
        <span>{{ $exam->formatted_size }}</span>
    </div>
    
    <div class="flex items-center justify-between">
        <div class="flex items-center text-xs text-gray-500">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            {{ $exam->downloads->count() }}
            <span class="ml-1">{{ $exam->downloads->count() === 1 ? 'download' : 'downloads' }}</span>
        </div>
        
        <div class="flex space-x-2">
            @if($exam->status === 'ready')
                <a href="{{ route('admin.exams.download', $exam->codigo) }}" 
                   class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full hover:bg-green-200 transition-colors">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Baixar
                </a>
            @else
                <span class="text-xs text-amber-600 font-medium">
                    {{ $exam->status === 'processing' ? 'Processando...' : 'Aguardando' }}
                </span>
            @endif
            
            <a href="{{ route('admin.exams.show', $exam->codigo) }}" 
               class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full hover:bg-blue-200 transition-colors">
                Ver detalhes
            </a>
        </div>
    </div>
</div>