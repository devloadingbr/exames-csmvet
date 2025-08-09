@extends('layouts.client')

@section('title', 'Meus Exames')

@section('content')
<div class="welcome">
    <h2 style="color: #74b9ff; margin-bottom: 1rem;">🐕 Olá, {{ $client->name }}!</h2>
    <p style="color: #666;">Aqui estão os exames dos seus pets. Use os filtros para encontrar exames específicos.</p>
</div>

<!-- Enhanced Statistics Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <span class="number">{{ $stats['total_exams'] }}</span>
        <div class="label">Exames Disponíveis</div>
    </div>
    
    <div class="stat-card">
        <span class="number">{{ $stats['exams_this_month'] }}</span>
        <div class="label">Este Mês</div>
    </div>
    
    <div class="stat-card">
        <span class="number">{{ $stats['pets_with_exams'] }}</span>
        <div class="label">Pets com Exames</div>
    </div>
    
    <div class="stat-card">
        <span class="number">{{ $stats['total_downloads'] }}</span>
        <div class="label">Downloads Realizados</div>
    </div>
</div>

<!-- Search and Filters Section -->
<div class="filters-section">
    <form id="filtersForm" method="GET" class="filters-form">
        <div class="filters-row">
            <!-- Search Input -->
            <div class="filter-item search-filter">
                <input type="text" 
                       name="search" 
                       value="{{ $currentFilters['search'] }}" 
                       placeholder="🔍 Buscar por código ou descrição..."
                       class="search-input">
            </div>
            
            <!-- Pet Filter -->
            <div class="filter-item">
                <select name="pet_id" class="filter-select">
                    <option value="">🐕 Todos os Pets</option>
                    @foreach($filterOptions['pets'] as $pet)
                        <option value="{{ $pet->id }}" {{ $currentFilters['pet_id'] == $pet->id ? 'selected' : '' }}>
                            {{ $pet->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Exam Type Filter -->
            <div class="filter-item">
                <select name="exam_type_id" class="filter-select">
                    <option value="">🔬 Todos os Tipos</option>
                    @foreach($filterOptions['examTypes'] as $type)
                        <option value="{{ $type->id }}" {{ $currentFilters['exam_type_id'] == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="filters-row">
            <!-- Date Range -->
            <div class="filter-item">
                <input type="date" 
                       name="date_from" 
                       value="{{ $currentFilters['date_from'] }}" 
                       class="date-input"
                       placeholder="Data inicial">
            </div>
            
            <div class="filter-item">
                <input type="date" 
                       name="date_to" 
                       value="{{ $currentFilters['date_to'] }}" 
                       class="date-input"
                       placeholder="Data final">
            </div>
            
            <!-- Sort Options -->
            <div class="filter-item">
                <select name="sort_by" class="filter-select">
                    <option value="exam_date" {{ $currentFilters['sort_by'] == 'exam_date' ? 'selected' : '' }}>📅 Data do Exame</option>
                    <option value="codigo" {{ $currentFilters['sort_by'] == 'codigo' ? 'selected' : '' }}>🔤 Código</option>
                    <option value="created_at" {{ $currentFilters['sort_by'] == 'created_at' ? 'selected' : '' }}>📝 Data de Criação</option>
                </select>
            </div>
            
            <div class="filter-item">
                <select name="sort_direction" class="filter-select">
                    <option value="desc" {{ $currentFilters['sort_direction'] == 'desc' ? 'selected' : '' }}>↓ Mais Recente</option>
                    <option value="asc" {{ $currentFilters['sort_direction'] == 'asc' ? 'selected' : '' }}>↑ Mais Antigo</option>
                </select>
            </div>
            
            <!-- Items Per Page -->
            <div class="filter-item">
                <select name="per_page" class="filter-select">
                    <option value="12" {{ $currentFilters['per_page'] == 12 ? 'selected' : '' }}>12 itens</option>
                    <option value="24" {{ $currentFilters['per_page'] == 24 ? 'selected' : '' }}>24 itens</option>
                </select>
            </div>
        </div>
        
        <div class="filters-actions">
            <button type="submit" class="btn-filter">🔍 Filtrar</button>
            <a href="{{ route('client.dashboard') }}" class="btn-clear">🗑️ Limpar Filtros</a>
        </div>
    </form>
</div>

@if($exams->count() > 0)
    <div class="results-header">
        <h3>📋 Seus Exames ({{ $exams->total() }} resultados)</h3>
        <div class="results-info">
            Mostrando {{ $exams->firstItem() }}-{{ $exams->lastItem() }} de {{ $exams->total() }} exames
        </div>
    </div>
    
    <div class="exams-grid">
        @foreach($exams as $exam)
        <div class="exam-card" onclick="viewExam('{{ $exam->codigo }}')">
            <div class="exam-code">{{ $exam->codigo }}</div>
            
            <div class="exam-type-badge" style="background-color: {{ $exam->examType->color ?? '#74b9ff' }}">
                {{ $exam->examType->name }}
            </div>
            
            <div class="exam-info">
                <div><strong>🐕 Pet:</strong> {{ $exam->pet->name }}</div>
                <div><strong>📅 Data:</strong> {{ $exam->exam_date->format('d/m/Y') }}</div>
                @if($exam->veterinarian_name)
                    <div><strong>👨‍⚕️ Veterinário:</strong> {{ $exam->veterinarian_name }}</div>
                @endif
                <div><strong>📄 Arquivo:</strong> {{ $exam->formatted_size }}</div>
                @if($exam->description)
                    <div class="exam-description">{{ \Str::limit($exam->description, 100) }}</div>
                @endif
            </div>
            
            <div class="exam-actions">
                <button class="btn-download" onclick="event.stopPropagation(); downloadExam('{{ $exam->codigo }}')">
                    📄 Baixar PDF
                </button>
                <button class="btn-view" onclick="event.stopPropagation(); viewExam('{{ $exam->codigo }}')">
                    👁️ Ver Detalhes
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="pagination-section">
        {{ $exams->links() }}
    </div>
@else
    <div class="empty-state">
        <div class="empty-icon">🔍</div>
        <h3>Nenhum exame encontrado</h3>
        @if(array_filter($currentFilters))
            <p>Nenhum exame corresponde aos filtros selecionados. Tente ajustar os critérios de busca.</p>
            <a href="{{ route('client.dashboard') }}" class="btn-clear-empty">🗑️ Limpar Filtros</a>
        @else
            <p>Ainda não há exames disponíveis para download. Entre em contato com a clínica para mais informações.</p>
        @endif
    </div>
@endif

<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.filters-section {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
}

.filters-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.filters-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    align-items: end;
}

.search-filter {
    grid-column: 1 / -1;
}

.search-input, .filter-select, .date-input {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e0e6ed;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: all 0.3s;
}

.search-input:focus, .filter-select:focus, .date-input:focus {
    border-color: #74b9ff;
    outline: none;
    box-shadow: 0 0 0 3px rgba(116, 185, 255, 0.1);
}

.filters-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.btn-filter, .btn-clear {
    padding: 0.75rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
    border: none;
    cursor: pointer;
}

.btn-filter {
    background: #74b9ff;
    color: white;
}

.btn-filter:hover {
    background: #0984e3;
    transform: translateY(-2px);
}

.btn-clear {
    background: white;
    color: #666;
    border: 2px solid #e0e6ed;
}

.btn-clear:hover {
    background: #f8f9fa;
    border-color: #74b9ff;
    color: #74b9ff;
}

.results-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.results-header h3 {
    color: white;
    font-size: 1.3rem;
    margin: 0;
}

.results-info {
    color: rgba(255,255,255,0.8);
    font-size: 0.9rem;
}

.exams-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.exam-card {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
}

.exam-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
}

.exam-type-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    padding: 0.25rem 0.75rem;
    border-radius: 16px;
    color: white;
    font-size: 0.75rem;
    font-weight: 600;
}

.exam-code {
    font-size: 1.1rem;
    font-weight: bold;
    color: #74b9ff;
    margin-bottom: 1rem;
}

.exam-info {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
    line-height: 1.5;
}

.exam-info strong {
    color: #333;
}

.exam-description {
    margin-top: 0.5rem;
    font-style: italic;
    color: #888;
}

.exam-actions {
    display: flex;
    gap: 0.75rem;
}

.btn-download, .btn-view {
    flex: 1;
    padding: 0.75rem;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s;
    border: none;
}

.btn-download {
    background: #74b9ff;
    color: white;
}

.btn-download:hover {
    background: #0984e3;
}

.btn-view {
    background: white;
    color: #74b9ff;
    border: 1px solid #74b9ff;
}

.btn-view:hover {
    background: #74b9ff;
    color: white;
}

.empty-state {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 3rem;
    text-align: center;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.empty-state h3 {
    color: #74b9ff;
    margin-bottom: 1rem;
}

.empty-state p {
    color: #666;
    margin-bottom: 1.5rem;
}

.btn-clear-empty {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    background: #74b9ff;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-clear-empty:hover {
    background: #0984e3;
    transform: translateY(-2px);
}

.pagination-section {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .filters-row {
        grid-template-columns: 1fr;
    }
    
    .search-filter {
        grid-column: 1;
    }
    
    .results-header {
        flex-direction: column;
        gap: 0.5rem;
        text-align: center;
    }
    
    .exams-grid {
        grid-template-columns: 1fr;
    }
    
    .filters-actions {
        flex-direction: column;
    }
}
</style>

<script>
function downloadExam(codigo) {
    // Encontrar o exame pelo código
    window.location.href = `/client/exams/${codigo}/download`;
}

function viewExam(codigo) {
    // Navegar para página de detalhes
    window.location.href = `/client/exams/${codigo}`;
}

// Auto-submit form when filters change
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('filtersForm');
    const inputs = form.querySelectorAll('select, input[type="date"]');
    
    inputs.forEach(input => {
        input.addEventListener('change', function() {
            form.submit();
        });
    });
    
    // Search input com debounce
    const searchInput = form.querySelector('input[name="search"]');
    let searchTimeout;
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            form.submit();
        }, 500);
    });
});
</script>
@endsection