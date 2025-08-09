@extends('layouts.client')

@section('title', 'Detalhes do Exame')

@section('content')
<div class="exam-detail-container">
    <!-- Header with exam code -->
    <div class="exam-header">
        <div class="exam-code-large">{{ $exam->codigo }}</div>
        <div class="exam-status">
            @if($exam->status === 'ready')
                <span class="status-badge status-ready">✅ Disponível</span>
            @elseif($exam->status === 'processing')
                <span class="status-badge status-processing">⏳ Processando</span>
            @else
                <span class="status-badge status-pending">⏸️ Pendente</span>
            @endif
        </div>
    </div>

    <div class="exam-detail-grid">
        <!-- Left Column: Exam Information -->
        <div class="exam-info-card">
            <h3>📋 Informações do Exame</h3>
            
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
    </div>

    <!-- Download History -->
    @if($downloads->count() > 0)
    <div class="download-history">
        <h3>📜 Histórico de Downloads</h3>
        
        <div class="history-table">
            @foreach($downloads as $download)
            <div class="history-item">
                <div class="history-date">
                    {{ $download->downloaded_at->format('d/m/Y H:i') }}
                </div>
                <div class="history-details">
                    <small>IP: {{ $download->ip_address }}</small>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Back Button -->
    <div class="back-section">
        <a href="{{ route('client.dashboard') }}" class="btn-back">
            ← Voltar aos Meus Exames
        </a>
    </div>
</div>

<style>
.exam-detail-container {
    max-width: 1000px;
    margin: 0 auto;
}

.exam-header {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
}

.exam-code-large {
    font-size: 2rem;
    font-weight: bold;
    color: #74b9ff;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
}

.status-ready { background: #00b894; color: white; }
.status-processing { background: #fdcb6e; color: #333; }
.status-pending { background: #6c5ce7; color: white; }

.exam-detail-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

.exam-info-card, .download-section > div {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.exam-info-card h3, .download-section h3 {
    color: #333;
    margin-bottom: 1.5rem;
    font-size: 1.2rem;
}

.info-grid {
    display: grid;
    gap: 1rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.info-item label {
    font-weight: 600;
    color: #666;
    font-size: 0.9rem;
}

.info-item span {
    color: #333;
}

.exam-type-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 16px;
    color: white;
    font-size: 0.85rem;
    font-weight: 500;
    width: fit-content;
}

.exam-description, .exam-summary {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #eee;
}

.exam-description h4, .exam-summary h4 {
    color: #666;
    font-size: 1rem;
    margin-bottom: 0.5rem;
}

.download-section {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.btn-download-primary {
    width: 100%;
    background: #74b9ff;
    color: white;
    border: none;
    padding: 1rem;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    margin-bottom: 1rem;
}

.btn-download-primary:hover {
    background: #0984e3;
    transform: translateY(-2px);
}

.btn-download-disabled {
    width: 100%;
    background: #ddd;
    color: #999;
    border: none;
    padding: 1rem;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 1rem;
    cursor: not-allowed;
}

.download-info {
    background: #d1edff;
    padding: 0.75rem;
    border-radius: 6px;
    color: #0984e3;
}

.download-error {
    background: #ffe0e0;
    padding: 0.75rem;
    border-radius: 6px;
    color: #d63031;
}

.stats-card {
    text-align: center;
}

.stat-item {
    margin-bottom: 1rem;
}

.stat-number {
    display: block;
    font-size: 2rem;
    font-weight: bold;
    color: #74b9ff;
}

.stat-date {
    display: block;
    font-size: 1rem;
    font-weight: 600;
    color: #333;
}

.stat-label {
    font-size: 0.85rem;
    color: #666;
}

.download-history {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.download-history h3 {
    color: #333;
    margin-bottom: 1rem;
}

.history-table {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.history-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    background: #f8f9fa;
    border-radius: 6px;
}

.history-date {
    font-weight: 600;
    color: #333;
}

.history-details {
    color: #666;
}

.back-section {
    text-align: center;
}

.btn-back {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    background: rgba(255,255,255,0.95);
    color: #74b9ff;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.btn-back:hover {
    background: #74b9ff;
    color: white;
    transform: translateY(-2px);
}

.text-danger { color: #d63031; }
.text-warning { color: #e17055; }

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .exam-detail-grid {
        grid-template-columns: 1fr;
    }
    
    .exam-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .exam-code-large {
        font-size: 1.5rem;
    }
}
</style>

<script>
function downloadExam(codigo) {
    const btn = document.getElementById('downloadBtn');
    if (!btn) return;
    
    // Mostrar loading
    btn.innerHTML = '⏳ Baixando...';
    btn.disabled = true;
    
    // Criar link temporário para download
    const link = document.createElement('a');
    link.href = '{{ route("client.exams.download", $exam) }}';
    link.style.display = 'none';
    document.body.appendChild(link);
    link.click();
    
    // Restaurar botão após delay
    setTimeout(() => {
        btn.innerHTML = '📄 Baixar Resultado PDF';
        btn.disabled = false;
        document.body.removeChild(link);
    }, 2000);
}
</script>
@endsection