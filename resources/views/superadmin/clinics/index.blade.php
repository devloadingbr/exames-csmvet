@extends('layouts.superadmin')

@section('title', 'Gestão de Clínicas')

@section('content')
<div class="page-header">
    <div class="header-content">
        <h2 style="color: #e94560; margin-bottom: 1rem; font-size: 2rem;">🏥 Gestão de Clínicas</h2>
        <div class="header-actions">
            <a href="{{ route('superadmin.clinics.create') }}" class="btn btn-primary">➕ Nova Clínica</a>
            <a href="{{ route('superadmin.clinics.export', request()->query()) }}" class="btn btn-secondary">📊 Exportar</a>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="filters-section">
    <form method="GET" class="filters-form">
        <div class="filter-group">
            <input type="text" name="search" placeholder="Buscar por nome, CNPJ, email ou cidade..." 
                   value="{{ request('search') }}" class="filter-input">
        </div>
        
        <div class="filter-group">
            <select name="status" class="filter-select">
                <option value="">Todos os Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Ativas</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inativas</option>
            </select>
        </div>
        
        <div class="filter-group">
            <select name="plan" class="filter-select">
                <option value="">Todos os Planos</option>
                @foreach($plans as $plan)
                    <option value="{{ $plan->id }}" {{ request('plan') == $plan->id ? 'selected' : '' }}>
                        {{ $plan->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="filter-actions">
            <button type="submit" class="btn btn-primary">🔍 Filtrar</button>
            <a href="{{ route('superadmin.clinics.index') }}" class="btn btn-outline">🔄 Limpar</a>
        </div>
    </form>
</div>

<!-- Resultados -->
<div class="results-info">
    <p>Mostrando {{ $clinics->count() }} de {{ $clinics->total() }} clínicas</p>
</div>

<!-- Tabela de Clínicas -->
<div class="card">
    @if($clinics->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Clínica</th>
                        <th>Localização</th>
                        <th>Plano</th>
                        <th>Status</th>
                        <th>Usuários</th>
                        <th>Criada em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clinics as $clinic)
                    <tr>
                        <td>
                            <div class="clinic-info">
                                <div class="clinic-name">{{ $clinic->name }}</div>
                                <div class="clinic-details">
                                    <small>{{ $clinic->cnpj }}</small><br>
                                    <small>{{ $clinic->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="location-info">
                                <div>{{ $clinic->city }}, {{ $clinic->state }}</div>
                                @if($clinic->zip_code)
                                    <small>CEP: {{ $clinic->zip_code }}</small>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="plan-info">
                                <span class="plan-name">{{ $clinic->plan->name ?? 'N/A' }}</span>
                                @if($clinic->plan)
                                    <small>R$ {{ number_format($clinic->plan->price_monthly, 2, ',', '.') }}/mês</small>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="status-info">
                                @if($clinic->is_active)
                                    <span class="status-badge active">✅ Ativa</span>
                                @else
                                    <span class="status-badge inactive">❌ Inativa</span>
                                @endif
                                
                                @if($clinic->subscription_status)
                                    <small class="subscription-status {{ $clinic->subscription_status }}">
                                        {{ ucfirst($clinic->subscription_status) }}
                                    </small>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="users-info">
                                <span class="users-count">{{ $clinic->users->count() }}</span>
                                <small>usuários</small>
                            </div>
                        </td>
                        <td>
                            <div class="date-info">
                                <div>{{ $clinic->created_at->format('d/m/Y') }}</div>
                                <small>{{ $clinic->created_at->format('H:i') }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="actions-dropdown">
                                <button class="btn-actions" onclick="toggleDropdown({{ $clinic->id }})">
                                    ⚙️ Ações
                                </button>
                                <div class="dropdown-menu" id="dropdown-{{ $clinic->id }}">
                                    <a href="{{ route('superadmin.clinic-details', $clinic) }}" class="dropdown-item">
                                        👁️ Ver Detalhes
                                    </a>
                                    <a href="{{ route('superadmin.clinics.edit', $clinic) }}" class="dropdown-item">
                                        ✏️ Editar
                                    </a>
                                    <form method="POST" action="{{ route('superadmin.clinics.toggle-status', $clinic) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="dropdown-item" 
                                                onclick="return confirm('Confirma alteração de status?')">
                                            @if($clinic->is_active)
                                                ⏸️ Suspender
                                            @else
                                                ▶️ Ativar
                                            @endif
                                        </button>
                                    </form>
                                    @if($clinic->is_active && $clinic->users->where('role', 'manager')->count() > 0)
                                        <form method="POST" action="{{ route('superadmin.clinics.impersonate', $clinic) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                🔄 Acessar como Gestor
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('superadmin.clinics.billing', $clinic) }}" class="dropdown-item">
                                        💰 Gerar Fatura
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Paginação -->
        <div class="pagination-wrapper">
            {{ $clinics->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">🏥</div>
            <h3>Nenhuma clínica encontrada</h3>
            <p>Não há clínicas que correspondam aos filtros aplicados.</p>
            <a href="{{ route('superadmin.clinics.create') }}" class="btn btn-primary">➕ Criar Primeira Clínica</a>
        </div>
    @endif
</div>

<style>
/* Page Header */
.page-header {
    margin-bottom: 2rem;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.header-actions {
    display: flex;
    gap: 1rem;
}

/* Filtros */
.filters-section {
    background: #16213e;
    padding: 1.5rem;
    border-radius: 8px;
    margin-bottom: 2rem;
}

.filters-form {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr auto;
    gap: 1rem;
    align-items: end;
}

.filter-group {
    display: flex;
    flex-direction: column;
}

.filter-input, .filter-select {
    background: #0f1419;
    border: 1px solid #374151;
    color: #fff;
    padding: 0.75rem;
    border-radius: 6px;
    font-size: 0.9rem;
}

.filter-input:focus, .filter-select:focus {
    outline: none;
    border-color: #3B82F6;
}

.filter-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-outline {
    background: transparent;
    border: 1px solid #6B7280;
    color: #6B7280;
    padding: 0.75rem 1rem;
    border-radius: 6px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-outline:hover {
    background: #6B7280;
    color: white;
}

/* Results Info */
.results-info {
    margin-bottom: 1rem;
    color: #9CA3AF;
}

/* Tabela */
.table-responsive {
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th, .table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #374151;
}

.table th {
    background: #0f1419;
    color: #9CA3AF;
    font-weight: 600;
    font-size: 0.9rem;
}

/* Clinic Info */
.clinic-info .clinic-name {
    font-weight: 600;
    color: #fff;
    margin-bottom: 0.25rem;
}

.clinic-details small {
    color: #9CA3AF;
    display: block;
}

/* Plan Info */
.plan-info .plan-name {
    font-weight: 500;
    color: #3B82F6;
}

.plan-info small {
    color: #9CA3AF;
    display: block;
}

/* Status */
.status-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: 500;
}

.status-badge.active {
    background: rgba(16, 185, 129, 0.2);
    color: #10B981;
}

.status-badge.inactive {
    background: rgba(239, 68, 68, 0.2);
    color: #EF4444;
}

.subscription-status {
    display: block;
    margin-top: 0.25rem;
    font-size: 0.75rem;
    color: #9CA3AF;
}

.subscription-status.trial {
    color: #F59E0B;
}

.subscription-status.active {
    color: #10B981;
}

.subscription-status.suspended {
    color: #EF4444;
}

/* Actions Dropdown */
.actions-dropdown {
    position: relative;
}

.btn-actions {
    background: #374151;
    color: #fff;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.9rem;
}

.btn-actions:hover {
    background: #4B5563;
}

.dropdown-menu {
    display: none;
    position: absolute;
    right: 0;
    top: 100%;
    background: #16213e;
    border: 1px solid #374151;
    border-radius: 6px;
    min-width: 180px;
    z-index: 1000;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
}

.dropdown-menu.show {
    display: block;
}

.dropdown-item {
    display: block;
    padding: 0.75rem 1rem;
    color: #fff;
    text-decoration: none;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
    font-size: 0.9rem;
}

.dropdown-item:hover {
    background: #374151;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.empty-state h3 {
    color: #fff;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #9CA3AF;
    margin-bottom: 2rem;
}

/* Responsivo */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filters-form {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .filter-actions {
        justify-content: center;
    }
    
    .table-responsive {
        font-size: 0.8rem;
    }
    
    .table th, .table td {
        padding: 0.5rem;
    }
}
</style>

<script>
function toggleDropdown(clinicId) {
    // Fechar todos os dropdowns
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        menu.classList.remove('show');
    });
    
    // Abrir o dropdown clicado
    const dropdown = document.getElementById('dropdown-' + clinicId);
    dropdown.classList.add('show');
}

// Fechar dropdown ao clicar fora
document.addEventListener('click', function(event) {
    if (!event.target.closest('.actions-dropdown')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.classList.remove('show');
        });
    }
});
</script>
@endsection
