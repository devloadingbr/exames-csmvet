@extends('layouts.superadmin')

@section('title', 'Dashboard SuperAdmin')

@section('content')
<div class="dashboard-header">
    <h2 style="color: #e94560; margin-bottom: 1rem; font-size: 2rem;">📊 Dashboard Global</h2>
    <div class="dashboard-actions">
        <a href="{{ route('superadmin.clinics.index') }}" class="btn btn-primary">🏥 Gerenciar Clínicas</a>
        <a href="{{ route('superadmin.billing-report') }}" class="btn btn-secondary">💰 Relatório Financeiro</a>
    </div>
</div>

<!-- Métricas Principais com Mudanças Percentuais -->
<div class="metrics-grid">
    <div class="metric-card {{ $metrics['total_clinics']['trend'] }}">
        <div class="metric-header">
            <span class="metric-icon">🏥</span>
            <span class="metric-change {{ $metrics['total_clinics']['trend'] }}">
                @if($metrics['total_clinics']['change'] > 0)
                    ↗ +{{ $metrics['total_clinics']['change'] }}%
                @elseif($metrics['total_clinics']['change'] < 0)
                    ↘ {{ $metrics['total_clinics']['change'] }}%
                @else
                    → 0%
                @endif
            </span>
        </div>
        <div class="metric-value">{{ $metrics['total_clinics']['value'] }}</div>
        <div class="metric-label">Total de Clínicas</div>
    </div>
    
    <div class="metric-card {{ $metrics['active_clinics']['trend'] }}">
        <div class="metric-header">
            <span class="metric-icon">✅</span>
            <span class="metric-change {{ $metrics['active_clinics']['trend'] }}">
                @if($metrics['active_clinics']['change'] > 0)
                    ↗ +{{ $metrics['active_clinics']['change'] }}%
                @elseif($metrics['active_clinics']['change'] < 0)
                    ↘ {{ $metrics['active_clinics']['change'] }}%
                @else
                    → 0%
                @endif
            </span>
        </div>
        <div class="metric-value">{{ $metrics['active_clinics']['value'] }}</div>
        <div class="metric-label">Clínicas Ativas</div>
    </div>
    
    <div class="metric-card {{ $metrics['total_revenue']['trend'] }}">
        <div class="metric-header">
            <span class="metric-icon">💰</span>
            <span class="metric-change {{ $metrics['total_revenue']['trend'] }}">
                @if($metrics['total_revenue']['change'] > 0)
                    ↗ +{{ $metrics['total_revenue']['change'] }}%
                @elseif($metrics['total_revenue']['change'] < 0)
                    ↘ {{ $metrics['total_revenue']['change'] }}%
                @else
                    → 0%
                @endif
            </span>
        </div>
        <div class="metric-value">R$ {{ number_format($metrics['total_revenue']['value'], 2, ',', '.') }}</div>
        <div class="metric-label">Receita Mensal</div>
    </div>
    
    <div class="metric-card {{ $metrics['total_exams']['trend'] }}">
        <div class="metric-header">
            <span class="metric-icon">🔬</span>
            <span class="metric-change {{ $metrics['total_exams']['trend'] }}">
                @if($metrics['total_exams']['change'] > 0)
                    ↗ +{{ $metrics['total_exams']['change'] }}%
                @elseif($metrics['total_exams']['change'] < 0)
                    ↘ {{ $metrics['total_exams']['change'] }}%
                @else
                    → 0%
                @endif
            </span>
        </div>
        <div class="metric-value">{{ $metrics['total_exams']['value'] }}</div>
        <div class="metric-label">Exames Este Mês</div>
    </div>
</div>

<!-- Alertas de Uso -->
@if(count($usageAlerts) > 0)
<div class="alerts-section">
    <h3 style="color: #e94560; margin-bottom: 1rem;">⚠️ Alertas de Uso</h3>
    <div class="alerts-grid">
        @foreach($usageAlerts as $alert)
        <div class="alert-card {{ $alert['severity'] }}">
            <div class="alert-header">
                <span class="alert-icon">
                    @if($alert['severity'] === 'critical')
                        🔴
                    @else
                        🟡
                    @endif
                </span>
                <span class="alert-clinic">{{ $alert['clinic_name'] }}</span>
            </div>
            <div class="alert-content">
                <div class="alert-usage">{{ $alert['usage_percent'] }}% do limite</div>
                <div class="alert-details">{{ $alert['current_usage'] }}/{{ $alert['limit'] }} exames</div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Gráfico de Receita -->
<div class="revenue-section">
    <div class="card">
        <h3>📈 Receita Últimos 6 Meses</h3>
        <div class="chart-container">
            <canvas id="revenueChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>

<!-- Estatísticas do Sistema -->
<div class="system-stats">
    <h3 style="color: #e94560; margin-bottom: 1rem;">📊 Estatísticas do Sistema</h3>
    <div class="stats-grid">
        <div class="stat-card">
            <span class="number">{{ $systemStats['total_users'] }}</span>
            <div class="label">Usuários Gestores</div>
        </div>
        
        <div class="stat-card">
            <span class="number">{{ $systemStats['total_clients'] }}</span>
            <div class="label">Total de Clientes</div>
        </div>
        
        <div class="stat-card">
            <span class="number">{{ $systemStats['total_pets'] }}</span>
            <div class="label">Pets Cadastrados</div>
        </div>
        
        <div class="stat-card">
            <span class="number">{{ $systemStats['storage_used_gb'] }} GB</span>
            <div class="label">Armazenamento Usado</div>
        </div>
        
        <div class="stat-card">
            <span class="number">{{ $systemStats['downloads_this_month'] }}</span>
            <div class="label">Downloads Este Mês</div>
        </div>
    </div>
</div>

<!-- Clínicas Top do Mês -->
@if(count($topClinics) > 0)
<div class="card">
    <h3>🏆 Clínicas com Maior Uso Este Mês</h3>
    
    <table class="table">
        <thead>
            <tr>
                <th>Clínica</th>
                <th>Cidade</th>
                <th>Plano</th>
                <th>Exames</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topClinics as $clinic)
            <tr>
                <td>{{ $clinic['name'] }}</td>
                <td>{{ $clinic['city'] }}</td>
                <td>{{ $clinic['plan'] }}</td>
                <td><strong>{{ $clinic['exams_count'] }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<div class="card">
    <h3>🏥 Clínicas Mais Recentes</h3>
    
    @if($recent_clinics->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Plano</th>
                    <th>Status</th>
                    <th>Criada em</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recent_clinics as $clinic)
                <tr>
                    <td>{{ $clinic->name }}</td>
                    <td>{{ $clinic->plan->name }}</td>
                    <td>
                        @if($clinic->is_active)
                            <span style="color: #28a745;">● Ativa</span>
                        @else
                            <span style="color: #dc3545;">● Inativa</span>
                        @endif
                    </td>
                    <td>{{ $clinic->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="color: #ccc; text-align: center; padding: 2rem;">Nenhuma clínica cadastrada ainda.</p>
    @endif
</div>

<div class="card">
    <h3>📊 Distribuição por Planos</h3>
    
    <table class="table">
        <thead>
            <tr>
                <th>Plano</th>
                <th>Clínicas</th>
                <th>Preço Mensal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($plans_distribution as $plan)
            <tr>
                <td>{{ $plan->name }}</td>
                <td>{{ $plan->clinics_count }}</td>
                <td>R$ {{ number_format($plan->price_monthly, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<style>
/* Dashboard Header */
.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.dashboard-actions {
    display: flex;
    gap: 1rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background: #3B82F6;
    color: white;
}

.btn-primary:hover {
    background: #2563EB;
    transform: translateY(-2px);
}

.btn-secondary {
    background: #6B7280;
    color: white;
}

.btn-secondary:hover {
    background: #4B5563;
    transform: translateY(-2px);
}

/* Métricas Grid */
.metrics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.metric-card {
    background: #16213e;
    padding: 1.5rem;
    border-radius: 12px;
    border: 1px solid #0f1419;
    transition: all 0.3s ease;
}

.metric-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(233, 69, 96, 0.2);
}

.metric-card.up {
    border-left: 4px solid #10B981;
}

.metric-card.down {
    border-left: 4px solid #EF4444;
}

.metric-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.metric-icon {
    font-size: 1.5rem;
}

.metric-change {
    font-size: 0.9rem;
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
}

.metric-change.up {
    color: #10B981;
    background: rgba(16, 185, 129, 0.1);
}

.metric-change.down {
    color: #EF4444;
    background: rgba(239, 68, 68, 0.1);
}

.metric-value {
    font-size: 2.5rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 0.5rem;
}

.metric-label {
    color: #9CA3AF;
    font-size: 0.9rem;
}

/* Alertas */
.alerts-section {
    margin-bottom: 2rem;
}

.alerts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1rem;
}

.alert-card {
    background: #16213e;
    padding: 1rem;
    border-radius: 8px;
    border-left: 4px solid #F59E0B;
}

.alert-card.critical {
    border-left-color: #EF4444;
    background: rgba(239, 68, 68, 0.05);
}

.alert-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}

.alert-clinic {
    font-weight: 600;
    color: #fff;
}

.alert-usage {
    font-size: 1.2rem;
    font-weight: 600;
    color: #F59E0B;
}

.alert-card.critical .alert-usage {
    color: #EF4444;
}

.alert-details {
    color: #9CA3AF;
    font-size: 0.9rem;
}

/* Gráfico */
.revenue-section {
    margin-bottom: 2rem;
}

.chart-container {
    position: relative;
    height: 300px;
    margin-top: 1rem;
}

/* Sistema Stats */
.system-stats {
    margin-bottom: 2rem;
}

/* Responsivo */
@media (max-width: 768px) {
    .dashboard-header {
        flex-direction: column;
        align-items: stretch;
    }
    
    .dashboard-actions {
        flex-direction: column;
    }
    
    .metrics-grid {
        grid-template-columns: 1fr;
    }
    
    .alerts-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de Receita
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($revenueChart['labels']),
            datasets: [{
                label: 'Receita Mensal (R$)',
                data: @json($revenueChart['data']),
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#3B82F6',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#9CA3AF',
                        callback: function(value) {
                            return 'R$ ' + value.toLocaleString('pt-BR');
                        }
                    },
                    grid: {
                        color: 'rgba(156, 163, 175, 0.1)'
                    }
                },
                x: {
                    ticks: {
                        color: '#9CA3AF'
                    },
                    grid: {
                        color: 'rgba(156, 163, 175, 0.1)'
                    }
                }
            },
            elements: {
                point: {
                    hoverBackgroundColor: '#3B82F6'
                }
            }
        }
    });
});
</script>
@endsection