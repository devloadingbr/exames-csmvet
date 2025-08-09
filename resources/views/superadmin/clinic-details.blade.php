@extends('layouts.superadmin')

@section('title', 'Detalhes da Clínica - ' . $clinic->name)

@section('content')
<div class="page-header">
    <div class="header-content">
        <div class="clinic-header">
            <h2 style="color: #e94560; margin-bottom: 0.5rem; font-size: 2rem;">
                🏥 {{ $clinic->name }}
            </h2>
            <div class="clinic-meta">
                <span class="status-badge {{ $clinic->is_active ? 'active' : 'inactive' }}">
                    {{ $clinic->is_active ? '✅ Ativa' : '❌ Inativa' }}
                </span>
                <span class="subscription-badge {{ $clinic->subscription_status }}">
                    {{ ucfirst($clinic->subscription_status ?? 'N/A') }}
                </span>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('superadmin.clinics.index') }}" class="btn btn-secondary">← Voltar</a>
            <a href="{{ route('superadmin.clinics.edit', $clinic) }}" class="btn btn-primary">✏️ Editar</a>
            @if($clinic->is_active && $clinic->users->where('role', 'manager')->count() > 0)
                <form method="POST" action="{{ route('superadmin.clinics.impersonate', $clinic) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-warning">🔄 Acessar como Gestor</button>
                </form>
            @endif
        </div>
    </div>
</div>

<!-- Métricas da Clínica -->
<div class="clinic-metrics">
    <div class="metric-card">
        <div class="metric-icon">👥</div>
        <div class="metric-content">
            <div class="metric-value">{{ $monthlyStats['clients_count'] }}</div>
            <div class="metric-label">Clientes</div>
        </div>
    </div>
    
    <div class="metric-card">
        <div class="metric-icon">🔬</div>
        <div class="metric-content">
            <div class="metric-value">{{ $monthlyStats['exams_count'] }}</div>
            <div class="metric-label">Exames Este Mês</div>
        </div>
    </div>
    
    <div class="metric-card">
        <div class="metric-icon">👨‍💼</div>
        <div class="metric-content">
            <div class="metric-value">{{ $monthlyStats['users_count'] }}</div>
            <div class="metric-label">Usuários</div>
        </div>
    </div>
    
    <div class="metric-card">
        <div class="metric-icon">💰</div>
        <div class="metric-content">
            <div class="metric-value">R$ {{ number_format($monthlyStats['revenue'], 2, ',', '.') }}</div>
            <div class="metric-label">Receita Mensal</div>
        </div>
    </div>
</div>

<div class="content-grid">
    <!-- Informações da Clínica -->
    <div class="card">
        <h3>📋 Informações da Clínica</h3>
        <div class="info-grid">
            <div class="info-item">
                <label>CNPJ:</label>
                <span>{{ $clinic->cnpj }}</span>
            </div>
            <div class="info-item">
                <label>Email:</label>
                <span>{{ $clinic->email }}</span>
            </div>
            <div class="info-item">
                <label>Telefone:</label>
                <span>{{ $clinic->phone ?? 'Não informado' }}</span>
            </div>
            <div class="info-item">
                <label>Endereço:</label>
                <span>{{ $clinic->address ?? 'Não informado' }}</span>
            </div>
            <div class="info-item">
                <label>Cidade/Estado:</label>
                <span>{{ $clinic->city }}, {{ $clinic->state }}</span>
            </div>
            <div class="info-item">
                <label>CEP:</label>
                <span>{{ $clinic->zip_code ?? 'Não informado' }}</span>
            </div>
            <div class="info-item">
                <label>Plano:</label>
                <span class="plan-info">
                    {{ $clinic->plan->name ?? 'N/A' }}
                    @if($clinic->plan)
                        <small>(R$ {{ number_format($clinic->plan->price_monthly, 2, ',', '.') }}/mês)</small>
                    @endif
                </span>
            </div>
            <div class="info-item">
                <label>Criada em:</label>
                <span>{{ $clinic->created_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>
    </div>

    <!-- Limites do Plano -->
    @if($planLimits['status'] !== 'no_plan')
    <div class="card">
        <h3>📊 Uso vs Limites do Plano</h3>
        <div class="limits-grid">
            @foreach($planLimits['limits'] as $type => $limit)
            <div class="limit-item {{ $limit['exceeded'] ? 'exceeded' : ($limit['percentage'] >= 90 ? 'warning' : 'normal') }}">
                <div class="limit-header">
                    <span class="limit-type">
                        @switch($type)
                            @case('exams') 🔬 Exames @break
                            @case('users') 👨‍💼 Usuários @break
                            @case('clients') 👥 Clientes @break
                            @case('storage') 💾 Armazenamento @break
                        @endswitch
                    </span>
                    <span class="limit-percentage">{{ $limit['percentage'] }}%</span>
                </div>
                <div class="limit-bar">
                    <div class="limit-progress" style="width: {{ min($limit['percentage'], 100) }}%"></div>
                </div>
                <div class="limit-details">
                    {{ $limit['current'] }} / {{ $limit['limit'] }}
                    @if($type === 'storage') GB @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Atividades Recentes -->
    <div class="card">
        <h3>📝 Atividades Recentes</h3>
        @if(count($recentActivities) > 0)
            <div class="activities-list">
                @foreach($recentActivities as $activity)
                <div class="activity-item">
                    <div class="activity-icon">{{ $activity['icon'] }}</div>
                    <div class="activity-content">
                        <div class="activity-description">{{ $activity['description'] }}</div>
                        <div class="activity-time">{{ $activity['created_at']->diffForHumans() }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-activities">
                <p>Nenhuma atividade recente registrada.</p>
            </div>
        @endif
    </div>

    <!-- Usuários da Clínica -->
    <div class="card">
        <h3>👨‍💼 Usuários da Clínica</h3>
        @if($clinic->users->count() > 0)
            <div class="users-list">
                @foreach($clinic->users as $user)
                <div class="user-item">
                    <div class="user-avatar">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ $user->name }}</div>
                        <div class="user-email">{{ $user->email }}</div>
                        <div class="user-role">
                            @switch($user->role)
                                @case('manager') 👨‍💼 Gestor @break
                                @case('veterinarian') 👨‍⚕️ Veterinário @break
                                @default {{ ucfirst($user->role) }}
                            @endswitch
                        </div>
                    </div>
                    <div class="user-status">
                        @if($user->is_active)
                            <span class="status-active">✅ Ativo</span>
                        @else
                            <span class="status-inactive">❌ Inativo</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-users">
                <p>Nenhum usuário cadastrado para esta clínica.</p>
            </div>
        @endif
    </div>

    <!-- Exames Recentes -->
    <div class="card">
        <h3>🔬 Exames Recentes</h3>
        @if($clinic->exams->count() > 0)
            <div class="exams-list">
                @foreach($clinic->exams as $exam)
                <div class="exam-item">
                    <div class="exam-code">{{ $exam->codigo }}</div>
                    <div class="exam-info">
                        <div class="exam-pet">{{ $exam->pet->name ?? 'Pet não encontrado' }}</div>
                        <div class="exam-type">{{ $exam->examType->name ?? 'Tipo não definido' }}</div>
                        <div class="exam-date">{{ $exam->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="exam-status">
                        <span class="status-{{ $exam->status }}">
                            @switch($exam->status)
                                @case('ready') ✅ Pronto @break
                                @case('processing') ⏳ Processando @break
                                @case('pending') 🕐 Pendente @break
                                @default {{ ucfirst($exam->status) }}
                            @endswitch
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-exams">
                <p>Nenhum exame cadastrado para esta clínica.</p>
            </div>
        @endif
    </div>
</div>

<style>
/* Page Header */
.page-header {
    margin-bottom: 2rem;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 1rem;
}

.clinic-header h2 {
    margin: 0;
}

.clinic-meta {
    display: flex;
    gap: 1rem;
    margin-top: 0.5rem;
}

.status-badge, .subscription-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 6px;
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

.subscription-badge {
    background: rgba(59, 130, 246, 0.2);
    color: #3B82F6;
}

.subscription-badge.trial {
    background: rgba(245, 158, 11, 0.2);
    color: #F59E0B;
}

.subscription-badge.suspended {
    background: rgba(239, 68, 68, 0.2);
    color: #EF4444;
}

.header-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.btn-warning {
    background: #F59E0B;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-warning:hover {
    background: #D97706;
    transform: translateY(-2px);
}

/* Métricas */
.clinic-metrics {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.metric-card {
    background: #16213e;
    padding: 1.5rem;
    border-radius: 12px;
    border: 1px solid #0f1419;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.metric-icon {
    font-size: 2rem;
    width: 60px;
    height: 60px;
    background: rgba(59, 130, 246, 0.1);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.metric-value {
    font-size: 2rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 0.25rem;
}

.metric-label {
    color: #9CA3AF;
    font-size: 0.9rem;
}

/* Content Grid */
.content-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
}

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.info-item label {
    font-weight: 600;
    color: #9CA3AF;
    font-size: 0.9rem;
}

.info-item span {
    color: #fff;
}

.plan-info small {
    color: #9CA3AF;
    display: block;
    margin-top: 0.25rem;
}

/* Limits */
.limits-grid {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.limit-item {
    padding: 1rem;
    border-radius: 8px;
    border: 1px solid #374151;
}

.limit-item.normal {
    border-color: #10B981;
    background: rgba(16, 185, 129, 0.05);
}

.limit-item.warning {
    border-color: #F59E0B;
    background: rgba(245, 158, 11, 0.05);
}

.limit-item.exceeded {
    border-color: #EF4444;
    background: rgba(239, 68, 68, 0.05);
}

.limit-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.limit-type {
    font-weight: 600;
    color: #fff;
}

.limit-percentage {
    font-weight: 700;
    color: #fff;
}

.limit-bar {
    height: 8px;
    background: #374151;
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.limit-progress {
    height: 100%;
    background: #10B981;
    transition: width 0.3s ease;
}

.limit-item.warning .limit-progress {
    background: #F59E0B;
}

.limit-item.exceeded .limit-progress {
    background: #EF4444;
}

.limit-details {
    color: #9CA3AF;
    font-size: 0.9rem;
}

/* Activities */
.activities-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.activity-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    background: rgba(59, 130, 246, 0.05);
    border-radius: 8px;
}

.activity-icon {
    font-size: 1.5rem;
    width: 40px;
    height: 40px;
    background: rgba(59, 130, 246, 0.2);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.activity-description {
    color: #fff;
    margin-bottom: 0.25rem;
}

.activity-time {
    color: #9CA3AF;
    font-size: 0.8rem;
}

/* Users */
.users-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.user-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(59, 130, 246, 0.05);
    border-radius: 8px;
}

.user-avatar {
    width: 50px;
    height: 50px;
    background: #3B82F6;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
}

.user-info {
    flex: 1;
}

.user-name {
    color: #fff;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.user-email {
    color: #9CA3AF;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.user-role {
    color: #3B82F6;
    font-size: 0.8rem;
}

.status-active {
    color: #10B981;
}

.status-inactive {
    color: #EF4444;
}

/* Exams */
.exams-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.exam-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(59, 130, 246, 0.05);
    border-radius: 8px;
}

.exam-code {
    font-family: 'Courier New', monospace;
    font-weight: 600;
    color: #3B82F6;
    background: rgba(59, 130, 246, 0.1);
    padding: 0.5rem;
    border-radius: 4px;
}

.exam-info {
    flex: 1;
}

.exam-pet {
    color: #fff;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.exam-type {
    color: #9CA3AF;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.exam-date {
    color: #9CA3AF;
    font-size: 0.8rem;
}

.exam-status span {
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: 500;
}

.status-ready {
    background: rgba(16, 185, 129, 0.2);
    color: #10B981;
}

.status-processing {
    background: rgba(245, 158, 11, 0.2);
    color: #F59E0B;
}

.status-pending {
    background: rgba(156, 163, 175, 0.2);
    color: #9CA3AF;
}

/* Empty States */
.empty-activities, .empty-users, .empty-exams {
    text-align: center;
    padding: 2rem;
    color: #9CA3AF;
}

/* Responsivo */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: stretch;
    }
    
    .clinic-metrics {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .content-grid {
        grid-template-columns: 1fr;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
