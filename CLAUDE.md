# VetExams SaaS - Configurações do Projeto

## Resumo do Projeto
Sistema multi-tenant para gerenciamento de exames veterinários, permitindo que clínicas gerenciem exames de pets e clientes acessem resultados através de CPF e data de nascimento.

## Comandos Principais

### Inicialização
```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed
```

### Desenvolvimento
```bash
./vendor/bin/sail artisan serve
./vendor/bin/sail artisan queue:work
./vendor/bin/sail artisan tinker
```

### Testes
```bash
./vendor/bin/sail test
./vendor/bin/sail artisan test --coverage
```

### Cache e Otimização
```bash
./vendor/bin/sail artisan config:cache
./vendor/bin/sail artisan route:cache
./vendor/bin/sail artisan view:cache
./vendor/bin/sail artisan optimize
```

## Estrutura do Projeto

### URLs de Acesso
- **Landing Page**: `http://localhost:8000/`
- **SuperAdmin**: `http://localhost:8000/superadmin/login`
- **Gestores de Clínica**: `http://localhost:8000/admin/login`
- **Clientes**: `http://localhost:8000/client/login`

### Banco de Dados
- **PostgreSQL**: Porta 5433 (Docker)
- **Multi-tenant**: Baseado em `clinic_id`
- **Soft Deletes**: Implementado em todos os models principais

### Autenticação
- **3 Guards Separados**: web (users), client (clients)
- **Roles**: superadmin, manager, veterinarian
- **Login Cliente**: CPF + Data de Nascimento

### Armazenamento
- **Local Storage**: Padrão (storage/app)
- **MinIO**: Opcional (se configurado)
- **Uploads**: Exames em PDF/imagem

## Arquitetura

### Models Principais
- Plan (planos de assinatura)
- Clinic (clínicas)  
- User (superadmin, managers, veterinários)
- Client (clientes/tutores)
- Pet (animais)
- ExamType (tipos de exame)
- Exam (exames)
- ExamDownload (controle de downloads)

### Controllers
- SuperAdminAuthController & SuperAdminController
- AdminAuthController & AdminController  
- ClientAuthController & ClientController

### Middleware
- TenantMiddleware (isolamento por clínica)
- RoleMiddleware (controle de acesso por role)

## Tecnologias

- **Backend**: Laravel 11, PHP 8.2+
- **Frontend**: Blade + Tailwind CSS
- **Banco**: PostgreSQL 15+
- **Container**: Docker + Laravel Sail
- **Storage**: Local/MinIO
- **Queue**: Database driver

## Configurações Importantes

### .env
```
DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=exames_vet
DB_USERNAME=sail  
DB_PASSWORD=password

FILESYSTEM_DISK=local
# Para usar MinIO:
# FILESYSTEM_DISK=minio
# MINIO_ENDPOINT=http://minio:9000
```

### Guards de Autenticação
```php
'guards' => [
    'web' => ['driver' => 'session', 'provider' => 'users'],
    'client' => ['driver' => 'session', 'provider' => 'clients'],
],
```

## Próximas Implementações
1. CRUD completo de exames
2. Upload e processamento de arquivos
3. Sistema de notificações
4. Relatórios e dashboards
5. API REST para mobile