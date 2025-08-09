# Database Schema - VetExams SaaS
## Schema Completo Multi-Tenant PostgreSQL

### 🏗️ Estrutura de Tabelas

```sql
-- =================================================================
-- TABELAS DE CONFIGURAÇÃO E PLANOS
-- =================================================================

-- Planos de assinatura disponíveis
CREATE TABLE plans (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(50) UNIQUE NOT NULL,
    description TEXT,
    price_monthly DECIMAL(10,2) NOT NULL DEFAULT 0,
    price_yearly DECIMAL(10,2) NOT NULL DEFAULT 0,
    max_exams_per_month INTEGER NOT NULL DEFAULT 1000,
    max_storage_gb INTEGER NOT NULL DEFAULT 10,
    max_users INTEGER NOT NULL DEFAULT 5,
    max_clients INTEGER NOT NULL DEFAULT 1000,
    features JSONB DEFAULT '{}',
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Dados iniciais dos planos
INSERT INTO plans (name, slug, price_monthly, price_yearly, max_exams_per_month, max_storage_gb, max_users, max_clients, features) VALUES
('Básico', 'basic', 99.00, 990.00, 500, 5, 3, 500, '{"email_notifications": true, "sms_notifications": false, "api_access": false}'),
('Profissional', 'professional', 199.00, 1990.00, 2000, 20, 10, 2000, '{"email_notifications": true, "sms_notifications": true, "api_access": true, "custom_branding": true}'),
('Enterprise', 'enterprise', 399.00, 3990.00, -1, 100, -1, -1, '{"email_notifications": true, "sms_notifications": true, "api_access": true, "custom_branding": true, "priority_support": true, "white_label": true}');

-- =================================================================
-- TABELAS PRINCIPAIS - TENANTS E USUÁRIOS
-- =================================================================

-- Clínicas (Tenants)
CREATE TABLE clinics (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    cnpj VARCHAR(18) UNIQUE,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    city VARCHAR(100),
    state VARCHAR(2),
    zip_code VARCHAR(10),
    
    -- Configurações da clínica
    logo_url VARCHAR(500),
    primary_color VARCHAR(7) DEFAULT '#3B82F6',
    secondary_color VARCHAR(7) DEFAULT '#1E40AF',
    custom_domain VARCHAR(255),
    
    -- Assinatura e billing
    plan_id BIGINT NOT NULL REFERENCES plans(id),
    subscription_status VARCHAR(20) DEFAULT 'active', -- active, suspended, cancelled, trial
    trial_ends_at TIMESTAMP,
    subscription_ends_at TIMESTAMP,
    
    -- Configurações do sistema
    settings JSONB DEFAULT '{}',
    is_active BOOLEAN DEFAULT true,
    
    -- Auditoria
    created_by BIGINT, -- Referência ao SuperAdmin que criou
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);

-- Usuários do sistema (Gestores e SuperAdmin)
CREATE TABLE users (
    id BIGSERIAL PRIMARY KEY,
    clinic_id BIGINT NULL REFERENCES clinics(id) ON DELETE CASCADE,
    
    -- Dados pessoais
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    
    -- Roles: superadmin, manager, veterinarian
    role VARCHAR(50) NOT NULL DEFAULT 'manager',
    
    -- Configurações
    avatar_url VARCHAR(500),
    phone VARCHAR(20),
    is_active BOOLEAN DEFAULT true,
    last_login_at TIMESTAMP,
    
    -- Auditoria
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);

-- Clientes (Pet owners) - Login com CPF + Data nascimento
CREATE TABLE clients (
    id BIGSERIAL PRIMARY KEY,
    clinic_id BIGINT NOT NULL REFERENCES clinics(id) ON DELETE CASCADE,
    
    -- Dados do cliente
    name VARCHAR(255) NOT NULL,
    cpf VARCHAR(14) NOT NULL, -- Com formatação: 000.000.000-00
    birth_date DATE NOT NULL,
    email VARCHAR(255),
    phone VARCHAR(20),
    
    -- Endereço
    address TEXT,
    city VARCHAR(100),
    state VARCHAR(2),
    zip_code VARCHAR(10),
    
    -- Configurações
    receive_email_notifications BOOLEAN DEFAULT true,
    receive_sms_notifications BOOLEAN DEFAULT false,
    last_login_at TIMESTAMP,
    is_active BOOLEAN DEFAULT true,
    
    -- Controle de segurança
    login_attempts INTEGER DEFAULT 0,
    blocked_until TIMESTAMP NULL,
    
    -- Auditoria
    created_by BIGINT REFERENCES users(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    
    -- Unique por clínica
    UNIQUE(clinic_id, cpf)
);

-- =================================================================
-- TABELAS DE PETS E EXAMES
-- =================================================================

-- Pets dos clientes
CREATE TABLE pets (
    id BIGSERIAL PRIMARY KEY,
    clinic_id BIGINT NOT NULL REFERENCES clinics(id) ON DELETE CASCADE,
    client_id BIGINT NOT NULL REFERENCES clients(id) ON DELETE CASCADE,
    
    -- Dados do pet
    name VARCHAR(255) NOT NULL,
    species VARCHAR(100) NOT NULL, -- cão, gato, etc
    breed VARCHAR(100),
    gender VARCHAR(10), -- macho, fêmea
    birth_date DATE,
    weight DECIMAL(5,2),
    color VARCHAR(100),
    
    -- Configurações
    photo_url VARCHAR(500),
    observations TEXT,
    is_active BOOLEAN DEFAULT true,
    
    -- Auditoria
    created_by BIGINT REFERENCES users(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);

-- Tipos de exames disponíveis
CREATE TABLE exam_types (
    id BIGSERIAL PRIMARY KEY,
    clinic_id BIGINT NOT NULL REFERENCES clinics(id) ON DELETE CASCADE,
    
    name VARCHAR(255) NOT NULL,
    description TEXT,
    default_price DECIMAL(10,2),
    color VARCHAR(7) DEFAULT '#6B7280',
    is_active BOOLEAN DEFAULT true,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    UNIQUE(clinic_id, name)
);

-- Exames realizados
CREATE TABLE exams (
    id BIGSERIAL PRIMARY KEY,
    clinic_id BIGINT NOT NULL REFERENCES clinics(id) ON DELETE CASCADE,
    client_id BIGINT NOT NULL REFERENCES clients(id) ON DELETE CASCADE,
    pet_id BIGINT NOT NULL REFERENCES pets(id) ON DELETE CASCADE,
    exam_type_id BIGINT NOT NULL REFERENCES exam_types(id),
    
    -- Identificação única
    codigo VARCHAR(20) UNIQUE NOT NULL, -- Ex: VET2024001, VET2024002
    
    -- Dados do exame
    description TEXT,
    exam_date DATE NOT NULL,
    result_summary TEXT,
    veterinarian_name VARCHAR(255),
    veterinarian_crmv VARCHAR(20),
    
    -- Arquivo
    original_filename VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL, -- Caminho no storage (local ou MinIO)
    file_size_bytes BIGINT NOT NULL,
    file_hash VARCHAR(64), -- SHA256 para integridade
    storage_disk VARCHAR(20) DEFAULT 'local', -- Tipo: local, minio
    
    -- Status: pending, processing, ready, failed
    status VARCHAR(20) DEFAULT 'ready',
    
    -- Configurações
    price DECIMAL(10,2),
    is_active BOOLEAN DEFAULT true,
    expires_at TIMESTAMP NULL, -- Para exames temporários
    
    -- Auditoria
    uploaded_by BIGINT NOT NULL REFERENCES users(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);

-- =================================================================
-- TABELAS DE AUTENTICAÇÃO E RECUPERAÇÃO
-- =================================================================

-- Recuperação de senhas para gestores
CREATE TABLE password_resets (
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX(email),
    INDEX(token)
);

-- =================================================================
-- TABELAS DE LOGS E AUDITORIA
-- =================================================================

-- Log de downloads dos exames
CREATE TABLE exam_downloads (
    id BIGSERIAL PRIMARY KEY,
    clinic_id BIGINT NOT NULL REFERENCES clinics(id) ON DELETE CASCADE,
    exam_id BIGINT NOT NULL REFERENCES exams(id) ON DELETE CASCADE,
    client_id BIGINT NOT NULL REFERENCES clients(id) ON DELETE CASCADE,
    
    -- Dados do download
    ip_address INET,
    user_agent TEXT,
    download_method VARCHAR(50), -- web, api, email_link
    
    -- Auditoria
    downloaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Log de atividades do sistema
CREATE TABLE activity_logs (
    id BIGSERIAL PRIMARY KEY,
    clinic_id BIGINT NULL REFERENCES clinics(id) ON DELETE CASCADE,
    
    -- Quem fez a ação
    user_id BIGINT NULL REFERENCES users(id) ON DELETE SET NULL,
    client_id BIGINT NULL REFERENCES clients(id) ON DELETE SET NULL,
    
    -- O que foi feito
    action VARCHAR(100) NOT NULL, -- login, upload, download, create, update, delete
    entity_type VARCHAR(100), -- exam, client, user, clinic
    entity_id BIGINT,
    
    -- Detalhes
    description TEXT,
    metadata JSONB DEFAULT '{}',
    ip_address INET,
    user_agent TEXT,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =================================================================
-- TABELAS DE BILLING E PAGAMENTOS
-- =================================================================

-- Invoices/Faturas das clínicas
CREATE TABLE invoices (
    id BIGSERIAL PRIMARY KEY,
    clinic_id BIGINT NOT NULL REFERENCES clinics(id) ON DELETE CASCADE,
    
    -- Dados da fatura
    invoice_number VARCHAR(50) UNIQUE NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    tax_amount DECIMAL(10,2) DEFAULT 0,
    total_amount DECIMAL(10,2) NOT NULL,
    
    -- Período cobrado
    period_start DATE NOT NULL,
    period_end DATE NOT NULL,
    
    -- Status: pending, paid, overdue, cancelled
    status VARCHAR(20) DEFAULT 'pending',
    
    -- Datas importantes
    due_date DATE NOT NULL,
    paid_at TIMESTAMP NULL,
    
    -- Detalhes do pagamento
    payment_method VARCHAR(50), -- pix, card, bank_transfer
    payment_reference VARCHAR(255),
    
    -- Dados da cobrança
    billing_details JSONB DEFAULT '{}',
    line_items JSONB DEFAULT '[]', -- Itens da fatura
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Controle de uso/métricas para billing
CREATE TABLE usage_metrics (
    id BIGSERIAL PRIMARY KEY,
    clinic_id BIGINT NOT NULL REFERENCES clinics(id) ON DELETE CASCADE,
    
    -- Período da métrica
    year INTEGER NOT NULL,
    month INTEGER NOT NULL,
    
    -- Métricas de uso
    exams_uploaded INTEGER DEFAULT 0,
    storage_used_bytes BIGINT DEFAULT 0,
    downloads_count INTEGER DEFAULT 0,
    active_clients INTEGER DEFAULT 0,
    active_users INTEGER DEFAULT 0,
    
    -- Dados calculados
    calculated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    UNIQUE(clinic_id, year, month)
);

-- =================================================================
-- TABELAS DE CONFIGURAÇÃO DO SISTEMA
-- =================================================================

-- Configurações globais do sistema
CREATE TABLE system_settings (
    id BIGSERIAL PRIMARY KEY,
    key VARCHAR(255) UNIQUE NOT NULL,
    value TEXT,
    type VARCHAR(50) DEFAULT 'string', -- string, integer, boolean, json
    description TEXT,
    is_public BOOLEAN DEFAULT false, -- Se pode ser acessado via API pública
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Dados iniciais das configurações
INSERT INTO system_settings (key, value, type, description) VALUES
('app_name', 'VetExams SaaS', 'string', 'Nome da aplicação'),
('default_timezone', 'America/Sao_Paulo', 'string', 'Timezone padrão'),
('max_file_size_mb', '50', 'integer', 'Tamanho máximo de arquivo em MB'),
('allowed_file_types', '["pdf"]', 'json', 'Tipos de arquivo permitidos'),
('email_from_address', 'noreply@vetexams.com.br', 'string', 'E-mail remetente padrão'),
('trial_period_days', '14', 'integer', 'Período de trial em dias'),
('storage_type', 'local', 'string', 'Tipo de storage: local ou minio'),
('storage_path', 'exams', 'string', 'Pasta base para arquivos');

-- =================================================================
-- ÍNDICES PARA PERFORMANCE
-- =================================================================

-- Índices principais para tenancy
CREATE INDEX idx_users_clinic_id ON users(clinic_id) WHERE deleted_at IS NULL;
CREATE INDEX idx_clients_clinic_id ON clients(clinic_id) WHERE deleted_at IS NULL;
CREATE INDEX idx_exams_clinic_id ON exams(clinic_id) WHERE deleted_at IS NULL;
CREATE INDEX idx_pets_clinic_id ON pets(clinic_id) WHERE deleted_at IS NULL;

-- Índices para busca
CREATE INDEX idx_clients_cpf ON clients(clinic_id, cpf) WHERE deleted_at IS NULL;
CREATE INDEX idx_exams_codigo ON exams(codigo);
CREATE INDEX idx_exams_status ON exams(status) WHERE deleted_at IS NULL;
CREATE INDEX idx_exams_date ON exams(exam_date DESC);

-- Índices para relacionamentos
CREATE INDEX idx_exams_client_id ON exams(client_id) WHERE deleted_at IS NULL;
CREATE INDEX idx_exams_pet_id ON exams(pet_id) WHERE deleted_at IS NULL;
CREATE INDEX idx_pets_client_id ON pets(client_id) WHERE deleted_at IS NULL;
CREATE INDEX idx_exams_storage_disk ON exams(storage_disk);

-- Índices para logs e auditoria
CREATE INDEX idx_activity_logs_clinic_id ON activity_logs(clinic_id);
CREATE INDEX idx_activity_logs_created_at ON activity_logs(created_at DESC);
CREATE INDEX idx_exam_downloads_exam_id ON exam_downloads(exam_id);
CREATE INDEX idx_exam_downloads_client_id ON exam_downloads(client_id);
CREATE INDEX idx_clients_blocked ON clients(blocked_until) WHERE blocked_until IS NOT NULL;

-- Índices para billing
CREATE INDEX idx_invoices_clinic_id ON invoices(clinic_id);
CREATE INDEX idx_invoices_status ON invoices(status);
CREATE INDEX idx_invoices_due_date ON invoices(due_date) WHERE status = 'pending';
CREATE INDEX idx_usage_metrics_clinic_month ON usage_metrics(clinic_id, year, month);

-- =================================================================
-- TRIGGERS E FUNÇÕES
-- =================================================================

-- Função para atualizar updated_at automaticamente
CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ language 'plpgsql';

-- Triggers para updated_at
CREATE TRIGGER update_clinics_updated_at BEFORE UPDATE ON clinics 
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_users_updated_at BEFORE UPDATE ON users 
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_clients_updated_at BEFORE UPDATE ON clients 
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_exams_updated_at BEFORE UPDATE ON exams 
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_pets_updated_at BEFORE UPDATE ON pets 
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

-- Função para gerar código único de exame
CREATE OR REPLACE FUNCTION generate_exam_code()
RETURNS TRIGGER AS $$
DECLARE
    new_code VARCHAR(20);
    prefix VARCHAR(3);
    year_suffix VARCHAR(4);
    sequence_num INTEGER;
BEGIN
    -- Prefixo baseado na clínica ou geral
    prefix := 'VET';
    year_suffix := EXTRACT(YEAR FROM CURRENT_DATE)::TEXT;
    
    -- Buscar próximo número da sequência
    SELECT COALESCE(MAX(CAST(RIGHT(codigo, 6) AS INTEGER)), 0) + 1
    INTO sequence_num
    FROM exams 
    WHERE codigo LIKE prefix || year_suffix || '%'
    AND clinic_id = NEW.clinic_id;
    
    -- Gerar código: VET2024000001
    new_code := prefix || year_suffix || LPAD(sequence_num::TEXT, 6, '0');
    
    NEW.codigo := new_code;
    RETURN NEW;
END;
$$ language 'plpgsql';

-- Trigger para gerar código automaticamente
CREATE TRIGGER generate_exam_code_trigger BEFORE INSERT ON exams 
    FOR EACH ROW EXECUTE FUNCTION generate_exam_code();

-- =================================================================
-- CONSTRAINTS E VALIDAÇÕES
-- =================================================================

-- Validações de CPF (formato básico)
ALTER TABLE clients ADD CONSTRAINT check_cpf_format 
    CHECK (cpf ~ '^\d{3}\.\d{3}\.\d{3}-\d{2}$');

-- Validações de roles
ALTER TABLE users ADD CONSTRAINT check_user_role 
    CHECK (role IN ('superadmin', 'manager', 'veterinarian'));

-- Validações de status
ALTER TABLE exams ADD CONSTRAINT check_exam_status 
    CHECK (status IN ('pending', 'processing', 'ready', 'failed'));

ALTER TABLE clinics ADD CONSTRAINT check_subscription_status 
    CHECK (subscription_status IN ('active', 'suspended', 'cancelled', 'trial'));

ALTER TABLE invoices ADD CONSTRAINT check_invoice_status 
    CHECK (status IN ('pending', 'paid', 'overdue', 'cancelled'));

-- Validações de datas
ALTER TABLE invoices ADD CONSTRAINT check_period_dates 
    CHECK (period_end > period_start);

-- Validações de valores monetários
ALTER TABLE invoices ADD CONSTRAINT check_positive_amounts 
    CHECK (amount >= 0 AND tax_amount >= 0 AND total_amount >= 0);

ALTER TABLE plans ADD CONSTRAINT check_positive_prices 
    CHECK (price_monthly >= 0 AND price_yearly >= 0);

-- =================================================================
-- VIEWS ÚTEIS PARA RELATÓRIOS
-- =================================================================

-- View de estatísticas por clínica
CREATE VIEW clinic_stats AS
SELECT 
    c.id,
    c.name AS clinic_name,
    c.subscription_status,
    p.name AS plan_name,
    COUNT(DISTINCT cl.id) AS total_clients,
    COUNT(DISTINCT e.id) AS total_exams,
    COUNT(DISTINCT CASE WHEN e.created_at >= CURRENT_DATE - INTERVAL '30 days' THEN e.id END) AS exams_last_30_days,
    SUM(CASE WHEN e.created_at >= CURRENT_DATE - INTERVAL '30 days' THEN e.file_size_bytes ELSE 0 END) AS storage_used_last_30_days,
    COUNT(DISTINCT ed.id) AS total_downloads,
    COUNT(DISTINCT CASE WHEN ed.downloaded_at >= CURRENT_DATE - INTERVAL '30 days' THEN ed.id END) AS downloads_last_30_days
FROM clinics c
LEFT JOIN plans p ON c.plan_id = p.id
LEFT JOIN clients cl ON c.id = cl.clinic_id AND cl.deleted_at IS NULL
LEFT JOIN exams e ON c.id = e.clinic_id AND e.deleted_at IS NULL
LEFT JOIN exam_downloads ed ON c.id = ed.clinic_id
WHERE c.deleted_at IS NULL
GROUP BY c.id, c.name, c.subscription_status, p.name;

-- View de exames com informações completas
CREATE VIEW exam_details AS
SELECT 
    e.id,
    e.codigo,
    e.description,
    e.exam_date,
    e.status,
    e.file_size_bytes,
    c.name AS clinic_name,
    cl.name AS client_name,
    cl.cpf AS client_cpf,
    p.name AS pet_name,
    p.species AS pet_species,
    et.name AS exam_type_name,
    u.name AS uploaded_by_name,
    e.created_at,
    COUNT(ed.id) AS download_count,
    MAX(ed.downloaded_at) AS last_download_at
FROM exams e
JOIN clinics c ON e.clinic_id = c.id
JOIN clients cl ON e.client_id = cl.id
JOIN pets p ON e.pet_id = p.id
JOIN exam_types et ON e.exam_type_id = et.id
JOIN users u ON e.uploaded_by = u.id
LEFT JOIN exam_downloads ed ON e.id = ed.exam_id
WHERE e.deleted_at IS NULL
GROUP BY e.id, e.codigo, e.description, e.exam_date, e.status, e.file_size_bytes,
         c.name, cl.name, cl.cpf, p.name, p.species, et.name, u.name, e.created_at;

-- =================================================================
-- COMENTÁRIOS NAS TABELAS
-- =================================================================

COMMENT ON TABLE clinics IS 'Clínicas veterinárias (tenants do sistema)';
COMMENT ON TABLE users IS 'Usuários gestores e superadmin';
COMMENT ON TABLE clients IS 'Clientes/donos dos pets que acessam via CPF + data nascimento';
COMMENT ON TABLE pets IS 'Pets cadastrados no sistema';
COMMENT ON TABLE exams IS 'Exames realizados e seus arquivos PDF';
COMMENT ON TABLE exam_downloads IS 'Log de todos os downloads de exames';
COMMENT ON TABLE activity_logs IS 'Log de todas as atividades do sistema';
COMMENT ON TABLE invoices IS 'Faturas das assinaturas das clínicas';
COMMENT ON TABLE usage_metrics IS 'Métricas de uso para controle de billing';
COMMENT ON TABLE plans IS 'Planos de assinatura disponíveis';

-- Comentários em campos importantes
-- Comentários em campos importantes
COMMENT ON COLUMN exams.codigo IS 'Código único do exame (ex: VET2024000001)';
COMMENT ON COLUMN clients.cpf IS 'CPF formatado: 000.000.000-00';
COMMENT ON COLUMN clients.login_attempts IS 'Contador de tentativas de login falhadas';
COMMENT ON COLUMN clients.blocked_until IS 'Data/hora até quando o cliente está bloqueado';
COMMENT ON COLUMN exams.file_path IS 'Caminho do arquivo no storage (local ou MinIO)';
COMMENT ON COLUMN clinics.subscription_status IS 'Status da assinatura: active, suspended, cancelled, trial';
COMMENT ON COLUMN usage_metrics.storage_used_bytes IS 'Bytes de storage utilizados no mês';

-- =================================================================
-- DADOS DE EXEMPLO PARA DESENVOLVIMENTO
-- =================================================================

-- SuperAdmin user (você)
INSERT INTO users (name, email, password, role, clinic_id) VALUES
('SuperAdmin', 'admin@vetexams.com.br', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'superadmin', NULL);

-- Clínica de exemplo
INSERT INTO clinics (name, slug, email, plan_id, created_by) VALUES
('Clínica Veterinária São José', 'clinica-sao-jose', 'contato@clinicasaojose.com.br', 1, 1);

-- Gestor da clínica de exemplo
INSERT INTO users (name, email, password, role, clinic_id) VALUES
('Dr. João Silva', 'joao@clinicasaojose.com.br', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'manager', 1);

-- Cliente de exemplo
INSERT INTO clients (clinic_id, name, cpf, birth_date, email, created_by) VALUES
(1, 'Maria Santos', '123.456.789-00', '1985-05-15', 'maria@email.com', 2);

-- Pet de exemplo
INSERT INTO pets (clinic_id, client_id, name, species, breed, created_by) VALUES
(1, 1, 'Rex', 'Cão', 'Labrador', 2);

-- Tipo de exame de exemplo
INSERT INTO exam_types (clinic_id, name, description) VALUES
(1, 'Hemograma Completo', 'Análise completa do sangue'),
(1, 'Raio-X', 'Exame radiológico'),
(1, 'Ultrassom', 'Exame ultrassonográfico');
```

### 📊 Resumo das Tabelas

| Tabela | Finalidade | Registros Estimados |
|--------|------------|-------------------|
| **clinics** | Tenants do sistema | 100-1000 |
| **users** | Gestores/SuperAdmin | 500-5000 |
| **clients** | Donos dos pets | 10K-100K |
| **pets** | Pets cadastrados | 15K-150K |
| **exams** | Exames realizados | 50K-1M |
| **exam_downloads** | Log de downloads | 100K-5M |
| **activity_logs** | Auditoria completa | 1M-10M |
| **invoices** | Controle financeiro | 1K-10K |
| **password_resets** | Recuperação de senha | 100-1K |

### 🔐 Segurança e Isolamento

1. **Row Level Security**: Todas as queries respeitam o `clinic_id`
2. **Soft Deletes**: Campo `deleted_at` para recuperação
3. **Auditoria Completa**: Logs de todas as ações
4. **Integridade**: Foreign keys e constraints rígidos
5. **Performance**: Índices otimizados para queries multi-tenant
6. **Controle de Acesso**: Rate limiting e bloqueio automático
7. **Recuperação de Senha**: Sistema seguro para gestores

### 📈 Escalabilidade

- **Particionamento**: Tabelas de logs podem ser particionadas por data
- **Índices**: Otimizados para queries por tenant
- **Views**: Pré-calculadas para relatórios complexos
- **Triggers**: Automação de tarefas repetitivas