@extends('layouts.client')

@section('title', 'Detalhes do Exame')

@section('content')
<div class="container-app py-8" x-data="examViewer">
    <!-- Hero Header with Dynamic Status -->
    <div class="glass-card p-8 mb-8 bg-gradient-to-r from-client-50/50 via-client-100/30 to-blue-50/50 overflow-hidden relative animate-fade-in-up">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex-1">
                <h1 class="text-5xl font-bold text-gradient mb-3">{{ $exam->codigo }}</h1>
                <p class="text-client-600 mb-2 font-medium flex items-center">
                    <svg class="w-5 h-5 mr-2 text-client-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                    Exame realizado em {{ $exam->exam_date->format('d/m/Y') }}
                </p>
                <p class="text-gray-500 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12a1 1 0 01-1-1V8a1 1 0 011-1h2a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 01-1 1H9zm-2 0a1 1 0 01-1-1V8a1 1 0 011-1h2a1 1 0 011 1v1h1a1 1 0 110 2H9a1 1 0 01-1-1V9H7a1 1 0 01-1 1z"></path>
                    </svg>
                    Criado em {{ $exam->created_at->format('d/m/Y H:i') }}
                </p>
            </div>
            
            <div class="flex items-center gap-3">
                @if($exam->status === 'ready')
                    <div class="badge badge-success animate-pulse-glow flex items-center px-4 py-2">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Disponível
                    </div>
                @elseif($exam->status === 'processing')
                    <div class="badge badge-warning animate-shimmer flex items-center px-4 py-2">
                        <svg class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Processando
                    </div>
                @else
                    <div class="badge badge-info flex items-center px-4 py-2">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        Pendente
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Background decorative elements -->
        <div class="absolute -top-6 -right-6 w-32 h-32 bg-gradient-to-br from-client-400/20 to-blue-400/20 rounded-full blur-xl"></div>
        <div class="absolute -bottom-6 -left-6 w-40 h-40 bg-gradient-to-tr from-purple-400/10 to-client-400/10 rounded-full blur-2xl"></div>
    </div>

    <!-- Two-Column Layout -->
    <div class="grid lg:grid-cols-3 gap-8 mb-8">
        <!-- Main Content Area -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Exam Information Card -->
            <div class="glass-card p-6 animate-fade-in-up animation-delay-100 hover-lift">
                <h3 class="title-card mb-6 flex items-center text-client-700">
                    <div class="w-10 h-10 bg-gradient-primary rounded-xl flex items-center justify-center mr-3 shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    Informações do Exame
                </h3>
            
            <div class="info-grid">
                <div class="info-item">
                    <label>🐕 Pet:</label>
                    <span>{{ $exam->pet->name }}</span>
                </div>
                
                <div class="info-item">
                    <label>🔬 Tipo:</label>
                    <span class="exam-type-badge" style="background-color: {{ $exam->examType->color ?? '#74b9ff' }}">
                        {{ $exam->examType->name }}
                    </span>
                </div>
                
                <div class="info-item">
                    <label>📅 Data do Exame:</label>
                    <span>{{ $exam->exam_date->format('d/m/Y') }}</span>
                </div>
                
                @if($exam->veterinarian_name)
                <div class="info-item">
                    <label>👨‍⚕️ Veterinário:</label>
                    <span>{{ $exam->veterinarian_name }}</span>
                    @if($exam->veterinarian_crmv)
                        <small>(CRMV: {{ $exam->veterinarian_crmv }})</small>
                    @endif
                </div>
                @endif
                
                <div class="info-item">
                    <label>📄 Arquivo:</label>
                    <span>{{ $exam->formatted_size }}</span>
                </div>
                
                @if($exam->expires_at)
                <div class="info-item">
                    <label>⏰ Expira em:</label>
                    <span class="{{ $exam->isExpired() ? 'text-danger' : 'text-warning' }}">
                        {{ $exam->expires_at->format('d/m/Y H:i') }}
                        @if($exam->isExpired())
                            <small>(EXPIRADO)</small>
                        @endif
                    </span>
                </div>
                @endif
                
                <div class="info-item">
                    <label>📊 Criado em:</label>
                    <span>{{ $exam->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>

            @if($exam->description)
            <div class="exam-description">
                <h4>📝 Observações:</h4>
                <p>{{ $exam->description }}</p>
            </div>
            @endif

            @if($exam->result_summary)
            <div class="exam-summary">
                <h4>📋 Resumo do Resultado:</h4>
                <p>{{ $exam->result_summary }}</p>
            </div>
            @endif
        </div>

        <!-- Right Column: Download and Stats -->
        <div class="download-section">
            <div class="download-card">
                <h3>💾 Download</h3>
                
                @if($downloadStatus['can_download'])
                    <button id="downloadBtn" class="btn-download-primary" onclick="downloadExam('{{ $exam->codigo }}')">
                        📄 Baixar Resultado PDF
                    </button>
                    
                    <div class="download-info">
                        <small>
                            ✅ Disponível para download<br>
                            📦 Tamanho: {{ $downloadStatus['file_size'] }}
                            @if($downloadStatus['expires_at'])
                                <br>⏰ Expira: {{ $downloadStatus['expires_at'] }}
                            @endif
                        </small>
                    </div>
                @else
                    <button class="btn-download-disabled" disabled>
                        ❌ Download Indisponível
                    </button>
                    
                    <div class="download-error">
                        <small>{{ $downloadStatus['reason'] }}</small>
                    </div>
                @endif
            </div>

            <!-- Download Statistics -->
            <div class="stats-card">
                <h3>📊 Estatísticas</h3>
                
                <div class="stat-item">
                    <span class="stat-number">{{ $stats['total_downloads'] }}</span>
                    <span class="stat-label">Downloads Realizados</span>
                </div>
                
                @if($stats['first_download'])
                <div class="stat-item">
                    <span class="stat-date">{{ $stats['first_download']->format('d/m/Y H:i') }}</span>
                    <span class="stat-label">Primeiro Download</span>
                </div>
                @endif
                
                @if($stats['last_download'])
                <div class="stat-item">
                    <span class="stat-date">{{ $stats['last_download']->format('d/m/Y H:i') }}</span>
                    <span class="stat-label">Último Download</span>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6" x-data="{ downloadCount: {{ $stats['total_downloads'] }} }">
            <!-- Download Card -->
            <div class="glass-card p-6 animate-fade-in-up animation-delay-200" x-data="examDownloader">
                <h3 class="title-card mb-4 flex items-center text-client-700">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    Download
                </h3>
                
                @if($downloadStatus['can_download'])
                    <button @click="downloadExam('{{ $exam->codigo }}')"
                            :disabled="downloading"
                            class="btn btn-primary w-full mb-4 hover-lift"
                            :class="{ 'opacity-50 cursor-not-allowed': downloading }">
                        
                        <template x-if="!downloading">
                            <div class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Baixar Resultado PDF
                            </div>
                        </template>
                        
                        <template x-if="downloading">
                            <div class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Baixando...
                            </div>
                        </template>
                    </button>
                @else
                    <button disabled class="btn w-full mb-4 bg-gray-300 text-gray-500 cursor-not-allowed">
                        Download Indisponível
                    </button>
                @endif
                
                <!-- Statistics -->
                <div class="text-center">
                    <div class="text-3xl font-bold text-gradient mb-2" x-text="downloadCount">{{ $stats['total_downloads'] }}</div>
                    <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Downloads Realizados</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Download History -->
    @if($downloads->count() > 0)
    <div class="glass-card p-6 mb-8 animate-fade-in-up animation-delay-400">
        <h3 class="title-card mb-6 flex items-center text-client-700">
            <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            Histórico de Downloads
        </h3>
        
        <div class="space-y-3">
            @foreach($downloads as $download)
            <div class="flex items-center justify-between p-4 bg-white/50 dark:bg-gray-800/50 rounded-xl border border-gray-100 dark:border-gray-700 hover:bg-white/70 dark:hover:bg-gray-800/70 transition-all duration-300">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900 dark:text-gray-100">
                            {{ $download->downloaded_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            IP: {{ $download->ip_address }}
                        </div>
                    </div>
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $download->downloaded_at->diffForHumans() }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Back Button -->
    <div class="text-center">
        <a href="{{ route('client.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-white/90 dark:bg-gray-800/90 border border-gray-200 dark:border-gray-700 rounded-xl text-client-600 hover:text-white hover:bg-client-500 hover:border-client-500 font-medium transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Voltar aos Meus Exames
        </a>
    </div>
</div>


<script>
// Alpine.js Components for Exam Details
document.addEventListener('alpine:init', () => {
    // Exam Viewer Main Component
    Alpine.data('examViewer', () => ({
        // Main exam viewer state
    }))
    
    // Download Handler Component
    Alpine.data('examDownloader', () => ({
        downloading: false,
        progress: 0,
        
        async downloadExam(examCode) {
            this.downloading = true;
            this.progress = 0;
            
            try {
                // Simulate progress
                const progressInterval = setInterval(() => {
                    if (this.progress < 90) {
                        this.progress += 10;
                    }
                }, 200);
                
                // Create download link
                const link = document.createElement('a');
                link.href = '{{ route("client.exams.download", $exam) }}';
                link.style.display = 'none';
                document.body.appendChild(link);
                link.click();
                
                // Complete progress
                setTimeout(() => {
                    clearInterval(progressInterval);
                    this.progress = 100;
                    
                    // Show success message
                    Alpine.store('toast').show('Download iniciado com sucesso!', 'success');
                    
                    // Reset state
                    setTimeout(() => {
                        this.downloading = false;
                        this.progress = 0;
                        document.body.removeChild(link);
                    }, 1000);
                }, 1500);
                
            } catch (error) {
                console.error('Download error:', error);
                Alpine.store('toast').show('Erro ao fazer download do exame', 'error');
                this.downloading = false;
                this.progress = 0;
            }
        }
    }))
    
    // Statistics Component with Animated Counters
    Alpine.data('examStats', () => ({
        downloadCount: 0,
        targetCount: {{ $stats['total_downloads'] }},
        
        animateCounters() {
            if (this.targetCount === 0) return;
            
            const duration = 1500;
            const increment = this.targetCount / (duration / 50);
            const timer = setInterval(() => {
                this.downloadCount += increment;
                
                if (this.downloadCount >= this.targetCount) {
                    this.downloadCount = this.targetCount;
                    clearInterval(timer);
                }
            }, 50);
        }
    }))
    
    // Toast System Store (if not already defined)
    if (!Alpine.store('toast')) {
        Alpine.store('toast', {
            show: false,
            message: '',
            type: 'success',
            
            show(message, type = 'success') {
                this.message = message;
                this.type = type;
                this.show = true;
                
                setTimeout(() => {
                    this.show = false;
                }, 4000);
            }
        });
    }
});
</script>
@endsection