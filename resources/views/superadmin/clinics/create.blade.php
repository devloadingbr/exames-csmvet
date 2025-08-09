@extends('layouts.superadmin')

@section('title', 'Nova Clínica')

@section('content')
<div class="page-header">
    <div class="header-content">
        <h2 style="color: #e94560; margin-bottom: 1rem; font-size: 2rem;">➕ Nova Clínica</h2>
        <div class="header-actions">
            <a href="{{ route('superadmin.clinics.index') }}" class="btn btn-secondary">← Voltar</a>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('superadmin.clinics.store') }}" class="clinic-form">
    @csrf
    
    <div class="form-sections">
        <!-- Informações da Clínica -->
        <div class="card">
            <h3>🏥 Informações da Clínica</h3>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="name">Nome da Clínica *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" 
                           class="form-input @error('name') error @enderror" required>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="cnpj">CNPJ *</label>
                    <input type="text" id="cnpj" name="cnpj" value="{{ old('cnpj') }}" 
                           class="form-input @error('cnpj') error @enderror" 
                           placeholder="00.000.000/0000-00" maxlength="18" required>
                    @error('cnpj')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" 
                           class="form-input @error('email') error @enderror" required>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="phone">Telefone</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" 
                           class="form-input @error('phone') error @enderror" 
                           placeholder="(11) 99999-9999">
                    @error('phone')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label for="address">Endereço</label>
                <input type="text" id="address" name="address" value="{{ old('address') }}" 
                       class="form-input @error('address') error @enderror" 
                       placeholder="Rua, número, bairro">
                @error('address')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="city">Cidade *</label>
                    <input type="text" id="city" name="city" value="{{ old('city') }}" 
                           class="form-input @error('city') error @enderror" required>
                    @error('city')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="state">Estado *</label>
                    <select id="state" name="state" class="form-select @error('state') error @enderror" required>
                        <option value="">Selecione</option>
                        <option value="SP" {{ old('state') === 'SP' ? 'selected' : '' }}>São Paulo</option>
                        <option value="RJ" {{ old('state') === 'RJ' ? 'selected' : '' }}>Rio de Janeiro</option>
                        <option value="MG" {{ old('state') === 'MG' ? 'selected' : '' }}>Minas Gerais</option>
                        <option value="RS" {{ old('state') === 'RS' ? 'selected' : '' }}>Rio Grande do Sul</option>
                        <option value="PR" {{ old('state') === 'PR' ? 'selected' : '' }}>Paraná</option>
                        <option value="SC" {{ old('state') === 'SC' ? 'selected' : '' }}>Santa Catarina</option>
                        <!-- Outros estados podem ser adicionados -->
                    </select>
                    @error('state')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="zip_code">CEP</label>
                    <input type="text" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" 
                           class="form-input @error('zip_code') error @enderror" 
                           placeholder="00000-000" maxlength="9">
                    @error('zip_code')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Plano e Configurações -->
        <div class="card">
            <h3>📋 Plano e Configurações</h3>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="plan_id">Plano *</label>
                    <select id="plan_id" name="plan_id" class="form-select @error('plan_id') error @enderror" required>
                        <option value="">Selecione um plano</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                                {{ $plan->name }} - R$ {{ number_format($plan->price_monthly, 2, ',', '.') }}/mês
                            </option>
                        @endforeach
                    </select>
                    @error('plan_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="custom_domain">Domínio Personalizado</label>
                    <input type="text" id="custom_domain" name="custom_domain" value="{{ old('custom_domain') }}" 
                           class="form-input @error('custom_domain') error @enderror" 
                           placeholder="clinica.exemplo.com">
                    @error('custom_domain')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="primary_color">Cor Primária</label>
                    <input type="color" id="primary_color" name="primary_color" value="{{ old('primary_color', '#3B82F6') }}" 
                           class="form-color @error('primary_color') error @enderror">
                    @error('primary_color')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="secondary_color">Cor Secundária</label>
                    <input type="color" id="secondary_color" name="secondary_color" value="{{ old('secondary_color', '#10B981') }}" 
                           class="form-color @error('secondary_color') error @enderror">
                    @error('secondary_color')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" id="is_active" name="is_active" value="1" 
                           {{ old('is_active', true) ? 'checked' : '' }}>
                    <label for="is_active">Clínica ativa</label>
                </div>
            </div>
        </div>

        <!-- Gestor da Clínica -->
        <div class="card">
            <h3>👨‍💼 Gestor da Clínica (Opcional)</h3>
            <p class="form-description">Se não preenchido, o gestor pode ser criado posteriormente.</p>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="manager_name">Nome do Gestor</label>
                    <input type="text" id="manager_name" name="manager_name" value="{{ old('manager_name') }}" 
                           class="form-input @error('manager_name') error @enderror">
                    @error('manager_name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="manager_email">Email do Gestor</label>
                    <input type="email" id="manager_email" name="manager_email" value="{{ old('manager_email') }}" 
                           class="form-input @error('manager_email') error @enderror">
                    @error('manager_email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="manager_password">Senha do Gestor</label>
                    <input type="password" id="manager_password" name="manager_password" 
                           class="form-input @error('manager_password') error @enderror" 
                           placeholder="Deixe em branco para senha temporária">
                    @error('manager_password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Ações do Formulário -->
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">✅ Criar Clínica</button>
        <a href="{{ route('superadmin.clinics.index') }}" class="btn btn-secondary">❌ Cancelar</a>
    </div>
</form>

<style>
.form-sections {
    display: flex;
    flex-direction: column;
    gap: 2rem;
    margin-bottom: 2rem;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group label {
    font-weight: 600;
    color: #9CA3AF;
    font-size: 0.9rem;
}

.form-input, .form-select {
    background: #0f1419;
    border: 1px solid #374151;
    color: #fff;
    padding: 0.75rem;
    border-radius: 6px;
    font-size: 0.9rem;
    transition: border-color 0.3s ease;
}

.form-input:focus, .form-select:focus {
    outline: none;
    border-color: #3B82F6;
}

.form-input.error, .form-select.error {
    border-color: #EF4444;
}

.form-color {
    background: #0f1419;
    border: 1px solid #374151;
    padding: 0.5rem;
    border-radius: 6px;
    width: 80px;
    height: 40px;
    cursor: pointer;
}

.checkbox-group {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.checkbox-group input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: #3B82F6;
}

.checkbox-group label {
    color: #fff;
    margin: 0;
    cursor: pointer;
}

.form-description {
    color: #9CA3AF;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.error-message {
    color: #EF4444;
    font-size: 0.8rem;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    padding: 2rem 0;
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
}
</style>

<script>
// Máscara para CNPJ
document.getElementById('cnpj').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    value = value.replace(/^(\d{2})(\d)/, '$1.$2');
    value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
    value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
    value = value.replace(/(\d{4})(\d)/, '$1-$2');
    e.target.value = value;
});

// Máscara para CEP
document.getElementById('zip_code').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    value = value.replace(/^(\d{5})(\d)/, '$1-$2');
    e.target.value = value;
});

// Máscara para telefone
document.getElementById('phone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    value = value.replace(/^(\d{2})(\d)/, '($1) $2');
    value = value.replace(/(\d{5})(\d)/, '$1-$2');
    e.target.value = value;
});
</script>
@endsection
