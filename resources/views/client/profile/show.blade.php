@extends('layouts.client')

@section('title', 'Meu Perfil')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <div class="profile-avatar">
            <div class="avatar-circle">
                {{ strtoupper(substr($client->name, 0, 1)) }}
            </div>
        </div>
        <div class="profile-info">
            <h1>{{ $client->name }}</h1>
            <p>Cliente desde {{ $stats['member_since']->format('d/m/Y') }}</p>
            @if($stats['last_login'])
                <small>Último acesso: {{ $stats['last_login']->format('d/m/Y H:i') }}</small>
            @endif
        </div>
        <div class="profile-actions">
            <a href="{{ route('client.profile.edit') }}" class="btn-edit-profile">
                ✏️ Editar Perfil
            </a>
        </div>
    </div>

    <div class="profile-grid">
        <!-- Personal Information -->
        <div class="info-card">
            <h3>📋 Informações Pessoais</h3>
            <div class="info-list">
                <div class="info-item">
                    <span class="label">Nome completo:</span>
                    <span class="value">{{ $client->name }}</span>
                </div>
                <div class="info-item">
                    <span class="label">CPF:</span>
                    <span class="value">{{ $client->cpf }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Data de nascimento:</span>
                    <span class="value">{{ $client->birth_date->format('d/m/Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Email:</span>
                    <span class="value">{{ $client->email ?: 'Não informado' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Telefone:</span>
                    <span class="value">{{ $client->phone ?: 'Não informado' }}</span>
                </div>
            </div>
        </div>

        <!-- Address Information -->
        <div class="info-card">
            <h3>🏠 Endereço</h3>
            <div class="info-list">
                <div class="info-item">
                    <span class="label">Endereço:</span>
                    <span class="value">{{ $client->address ?: 'Não informado' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Cidade:</span>
                    <span class="value">{{ $client->city ?: 'Não informado' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Estado:</span>
                    <span class="value">{{ $client->state ?: 'Não informado' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">CEP:</span>
                    <span class="value">{{ $client->zip_code ?: 'Não informado' }}</span>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-card">
            <h3>📊 Estatísticas</h3>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">{{ $stats['total_pets'] }}</div>
                    <div class="stat-label">Pets cadastrados</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $stats['total_exams'] }}</div>
                    <div class="stat-label">Exames disponíveis</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $stats['download_stats']['total_downloads'] }}</div>
                    <div class="stat-label">Downloads realizados</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $stats['download_stats']['downloads_this_month'] }}</div>
                    <div class="stat-label">Downloads este mês</div>
                </div>
            </div>
        </div>

        <!-- Notifications Settings -->
        <div class="settings-card">
            <h3>🔔 Preferências de Notificação</h3>
            <div class="settings-list">
                <div class="setting-item">
                    <label class="setting-label">
                        <input type="checkbox" 
                               id="emailNotifications"
                               {{ $client->receive_email_notifications ? 'checked' : '' }}
                               onchange="updateNotifications()">
                        <span class="setting-text">Receber notificações por email</span>
                    </label>
                </div>
                <div class="setting-item">
                    <label class="setting-label">
                        <input type="checkbox" 
                               id="smsNotifications"
                               {{ $client->receive_sms_notifications ? 'checked' : '' }}
                               onchange="updateNotifications()">
                        <span class="setting-text">Receber notificações por SMS</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Downloads -->
    @if(count($stats['recent_downloads']) > 0)
    <div class="recent-downloads">
        <h3>📥 Downloads Recentes</h3>
        <div class="downloads-table">
            @foreach($stats['recent_downloads'] as $download)
            <div class="download-row">
                <div class="download-info">
                    <div class="download-exam">{{ $download['exam_code'] }}</div>
                    <div class="download-details">
                        {{ $download['exam_type'] }} - {{ $download['pet_name'] }}
                    </div>
                </div>
                <div class="download-date">
                    {{ $download['downloaded_at']->format('d/m/Y H:i') }}
                </div>
            </div>
            @endforeach
        </div>
        <div class="downloads-footer">
            <a href="{{ route('client.profile.activity') }}" class="btn-view-all">
                Ver histórico completo →
            </a>
        </div>
    </div>
    @endif

    <!-- Exams by Type Chart -->
    @if(count($examsByType) > 0)
    <div class="exams-chart">
        <h3>📈 Exames por Tipo</h3>
        <div class="chart-container">
            @php $total = array_sum($examsByType); @endphp
            @foreach($examsByType as $type => $count)
                @php $percentage = $total > 0 ? ($count / $total) * 100 : 0; @endphp
                <div class="chart-bar">
                    <div class="bar-info">
                        <span class="bar-label">{{ $type }}</span>
                        <span class="bar-count">{{ $count }}</span>
                    </div>
                    <div class="bar-container">
                        <div class="bar-fill" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h3>⚡ Ações Rápidas</h3>
        <div class="actions-grid">
            <a href="{{ route('client.dashboard') }}" class="action-card">
                <div class="action-icon">📋</div>
                <div class="action-text">Meus Exames</div>
            </a>
            <a href="{{ route('client.profile.edit') }}" class="action-card">
                <div class="action-icon">✏️</div>
                <div class="action-text">Editar Perfil</div>
            </a>
            <a href="{{ route('client.profile.activity') }}" class="action-card">
                <div class="action-icon">📈</div>
                <div class="action-text">Atividades</div>
            </a>
            <a href="{{ route('client.profile.help') }}" class="action-card">
                <div class="action-icon">❓</div>
                <div class="action-text">Ajuda</div>
            </a>
        </div>
    </div>
</div>

<style>
.profile-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.profile-header {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 2rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
}

.profile-avatar {
    flex-shrink: 0;
}

.avatar-circle {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #74b9ff, #0984e3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    font-weight: bold;
    color: white;
}

.profile-info {
    flex-grow: 1;
}

.profile-info h1 {
    color: #333;
    margin: 0 0 0.5rem 0;
    font-size: 2rem;
}

.profile-info p {
    color: #666;
    margin: 0 0 0.25rem 0;
}

.profile-info small {
    color: #999;
}

.profile-actions {
    flex-shrink: 0;
}

.btn-edit-profile {
    background: #74b9ff;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-edit-profile:hover {
    background: #0984e3;
    transform: translateY(-2px);
}

.profile-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.info-card, .stats-card, .settings-card {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.info-card h3, .stats-card h3, .settings-card h3 {
    color: #333;
    margin-bottom: 1.5rem;
    font-size: 1.1rem;
}

.info-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.info-item:last-child {
    border-bottom: none;
}

.label {
    font-weight: 600;
    color: #666;
    flex: 1;
}

.value {
    color: #333;
    text-align: right;
    flex: 1;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    color: #74b9ff;
    display: block;
}

.stat-label {
    font-size: 0.85rem;
    color: #666;
}

.settings-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.setting-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
}

.setting-label input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: #74b9ff;
}

.setting-text {
    color: #333;
    font-weight: 500;
}

.recent-downloads, .exams-chart, .quick-actions {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.recent-downloads h3, .exams-chart h3, .quick-actions h3 {
    color: #333;
    margin-bottom: 1.5rem;
    font-size: 1.1rem;
}

.downloads-table {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.download-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.download-exam {
    font-weight: bold;
    color: #74b9ff;
}

.download-details {
    font-size: 0.9rem;
    color: #666;
    margin-top: 0.25rem;
}

.download-date {
    color: #999;
    font-size: 0.9rem;
}

.downloads-footer {
    text-align: center;
    margin-top: 1rem;
}

.btn-view-all {
    color: #74b9ff;
    text-decoration: none;
    font-weight: 500;
}

.btn-view-all:hover {
    text-decoration: underline;
}

.chart-container {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.chart-bar {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.bar-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.bar-label {
    color: #333;
    font-weight: 500;
}

.bar-count {
    color: #74b9ff;
    font-weight: bold;
}

.bar-container {
    height: 8px;
    background: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
}

.bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #74b9ff, #0984e3);
    transition: width 0.3s ease;
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
}

.action-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 12px;
    text-decoration: none;
    color: #333;
    transition: all 0.3s;
}

.action-card:hover {
    background: #74b9ff;
    color: white;
    transform: translateY(-2px);
}

.action-icon {
    font-size: 2rem;
}

.action-text {
    font-weight: 500;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .profile-header {
        flex-direction: column;
        text-align: center;
    }
    
    .profile-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .actions-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<script>
function updateNotifications() {
    const emailNotifications = document.getElementById('emailNotifications').checked;
    const smsNotifications = document.getElementById('smsNotifications').checked;
    
    fetch('{{ route("client.profile.notifications") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            receive_email_notifications: emailNotifications,
            receive_sms_notifications: smsNotifications
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mostrar feedback visual temporário
            showNotification('Preferências atualizadas!', 'success');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        showNotification('Erro ao atualizar preferências', 'error');
    });
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        background: ${type === 'success' ? '#00b894' : '#d63031'};
        color: white;
        border-radius: 8px;
        font-weight: 500;
        z-index: 1000;
        animation: slideIn 0.3s ease;
    `;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);
</script>
@endsection