# Sistema de Exames Veterinários SaaS
## Especificações Técnicas Completas

### 🎯 Visão Geral

**VetExams** é uma plataforma SaaS multi-tenant para gestão e distribuição de exames veterinários, permitindo que clínicas veterinárias ofereçam acesso digital seguro aos resultados de exames para seus clientes.

### 📋 Funcionalidades Principais

#### 🏥 Para Clínicas (Gestores)
- Dashboard administrativo completo
- Upload e gestão de exames em PDF
- Cadastro e gestão de clientes
- Geração automática de códigos de acesso
- Relatórios de utilização e downloads
- Gestão de perfis de veterinários
- Notificações por email/SMS

#### 👥 Para Clientes Pet
- Login seguro com CPF + Data de nascimento
- Visualização de exames do seu pet
- Download de PDFs
- Histórico completo de exames
- Interface responsiva mobile-first

#### 🔧 Para SuperAdmin (Você)
- Painel de controle de todas as clínicas
- Gestão de assinaturas e planos
- Monitoramento de uso e métricas
- Controle de billing e pagamentos
- Suporte técnico e logs de sistema
- Analytics avançadas

### 🏗️ Arquitetura Técnica

#### Stack Principal
```
Backend Framework:    Laravel 11 (PHP 8.2+)
Template Engine:      Blade (nativo Laravel)
Frontend Styling:     Tailwind CSS 3.x
JavaScript:           Alpine.js 3.x
Database:            PostgreSQL 15+
File Storage:        Local (padrão) ou MinIO (opcional)
Web Server:          Nginx + PHP-FPM
Deploy:              VPS via Easypanel
```

#### Arquitetura Multi-Tenant
```
Estratégia: Single Database, Multi-Schema
Isolamento: Por clinic_id em todas as tabelas
Segurança: Row Level Security (RLS) no PostgreSQL
Domínios: Subdomains por clínica (opcional)
```

### 🔐 Sistema de Autenticação

#### Tipos de Usuário

**1. SuperAdmin (Você)**
```php
Autenticação: email + senha
Escopo: Acesso total ao sistema
Middleware: ['auth', 'role:superadmin']
```

**2. Gestor da Clínica**
```php
Autenticação: email + senha
Escopo: Apenas sua clínica (tenant)
Middleware: ['auth', 'role:manager', 'tenant']
```

**3. Cliente/Pet Owner**
```php
Autenticação: CPF + data_nascimento
Escopo: Apenas seus exames
Middleware: ['auth', 'role:client', 'tenant']
```

#### Implementação de Roles

```php
// app/Models/User.php
class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'role', 
        'clinic_id', 'cpf', 'birth_date'
    ];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
    
    public function isSuperAdmin()
    {
        return $this->role === 'superadmin';
    }
    
    public function isManager()
    {
        return $this->role === 'manager';
    }
    
    public function isClient()
    {
        return $this->role === 'client';
    }
}
```

### 🎨 Interface e Componentes

#### Componentes Blade Customizados

**1. Exam Card Component**
```blade
{{-- components/exam-card.blade.php --}}
@props(['exam'])

<div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border border-gray-100">
    <div class="flex items-start justify-between mb-4">
        <div class="flex-1">
            <h3 class="text-lg font-semibold text-gray-900">{{ $exam->codigo }}</h3>
            <p class="text-sm text-gray-600">{{ $exam->pet_name }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ $exam->exam_type }}</p>
        </div>
        
        <x-status-badge :status="$exam->status" />
    </div>
    
    <div class="flex items-center justify-between">
        <span class="text-xs text-gray-500">
            {{ $exam->created_at->format('d/m/Y H:i') }}
        </span>
        
        <div class="flex space-x-2">
            @if($exam->status === 'ready')
                <x-button variant="primary" size="sm" 
                         onclick="downloadExam('{{ $exam->codigo }}')">
                    <x-icon name="download" class="w-4 h-4 mr-1" />
                    Baixar
                </x-button>
            @else
                <span class="text-sm text-amber-600">Processando...</span>
            @endif
        </div>
    </div>
</div>
```

**2. Upload Zone Component**
```blade
{{-- components/upload-zone.blade.php --}}
<div x-data="uploadZone()" 
     @dragover.prevent="dragover = true"
     @dragleave="dragover = false"
     @drop.prevent="handleDrop($event)"
     class="upload-zone">
     
    <div :class="{ 
        'border-blue-500 bg-blue-50': dragover,
        'border-gray-300': !dragover 
    }" 
         class="border-2 border-dashed rounded-lg p-8 text-center transition-colors">
        
        <template x-if="!selectedFile">
            <div class="space-y-4">
                <x-icon name="cloud-upload" class="w-16 h-16 text-gray-400 mx-auto" />
                
                <div>
                    <p class="text-lg font-medium text-gray-700">
                        Arraste um PDF aqui
                    </p>
                    <p class="text-sm text-gray-500">
                        ou clique para selecionar
                    </p>
                </div>
                
                <input type="file" 
                       x-ref="fileInput" 
                       @change="handleFile($event)"
                       accept=".pdf" 
                       class="hidden">
                       
                <x-button @click="$refs.fileInput.click()" variant="outline">
                    Selecionar Arquivo
                </x-button>
            </div>
        </template>
        
        <template x-if="selectedFile">
            <div class="space-y-4">
                <x-icon name="document-text" class="w-16 h-16 text-red-500 mx-auto" />
                
                <div>
                    <p class="font-medium text-gray-900" x-text="selectedFile.name"></p>
                    <p class="text-sm text-gray-500" 
                       x-text="formatFileSize(selectedFile.size)"></p>
                </div>
                
                <div x-show="uploading" class="w-full">
                    <div class="bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                             :style="`width: ${progress}%`"></div>
                    </div>
                    <p class="text-sm text-gray-600 mt-2" x-text="`${progress}% enviado`"></p>
                </div>
                
                <div class="flex space-x-3">
                    <x-button @click="uploadFile()" 
                             :disabled="uploading"
                             variant="primary">
                        <span x-show="!uploading">Enviar Exame</span>
                        <span x-show="uploading">Enviando...</span>
                    </x-button>
                    
                    <x-button @click="resetUpload()" 
                             variant="outline">
                        Cancelar
                    </x-button>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
function uploadZone() {
    return {
        selectedFile: null,
        dragover: false,
        uploading: false,
        progress: 0,
        
        handleFile(event) {
            const file = event.target.files[0];
            if (file && file.type === 'application/pdf') {
                this.selectedFile = file;
            }
        },
        
        handleDrop(event) {
            this.dragover = false;
            const file = event.dataTransfer.files[0];
            if (file && file.type === 'application/pdf') {
                this.selectedFile = file;
            }
        },
        
        async uploadFile() {
            if (!this.selectedFile) return;
            
            this.uploading = true;
            this.progress = 0;
            
            const formData = new FormData();
            formData.append('exam', this.selectedFile);
            formData.append('pet_name', document.getElementById('pet_name').value);
            formData.append('client_id', document.getElementById('client_id').value);
            formData.append('exam_type', document.getElementById('exam_type').value);
            
            try {
                const xhr = new XMLHttpRequest();
                
                xhr.upload.addEventListener('progress', (e) => {
                    if (e.lengthComputable) {
                        this.progress = Math.round((e.loaded / e.total) * 100);
                    }
                });
                
                xhr.onload = () => {
                    if (xhr.status === 200) {
                        window.location.href = '/admin/exams?success=upload';
                    } else {
                        alert('Erro no upload');
                        this.uploading = false;
                    }
                };
                
                xhr.open('POST', '/admin/exams');
                xhr.setRequestHeader('X-CSRF-TOKEN', 
                    document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                xhr.send(formData);
                
            } catch (error) {
                alert('Erro no upload');
                this.uploading = false;
            }
        },
        
        resetUpload() {
            this.selectedFile = null;
            this.uploading = false;
            this.progress = 0;
            this.$refs.fileInput.value = '';
        },
        
        formatFileSize(bytes) {
            return (bytes / 1024 / 1024).toFixed(2) + ' MB';
        }
    }
}
</script>
```

**3. Dashboard Stats Component**
```blade
{{-- components/dashboard-stats.blade.php --}}
@props(['stats'])

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <x-stat-card 
        title="Exames Este Mês"
        :value="$stats['exams_this_month']"
        :change="$stats['exams_change']"
        color="blue"
        icon="document-text" />
        
    <x-stat-card 
        title="Downloads Hoje"
        :value="$stats['downloads_today']"
        :change="$stats['downloads_change']"
        color="green"
        icon="arrow-down-tray" />
        
    <x-stat-card 
        title="Clientes Ativos"
        :value="$stats['active_clients']"
        :change="$stats['clients_change']"
        color="purple"
        icon="users" />
        
    <x-stat-card 
        title="Armazenamento Usado"
        :value="$stats['storage_used']"
        :change="$stats['storage_change']"
        color="amber"
        icon="server" />
</div>
```

### 🔄 Fluxos Principais

#### Fluxo de Upload de Exame
```
1. Gestor acessa /admin/exams/create
2. Seleciona cliente ou cadastra novo
3. Upload do PDF via drag-and-drop
4. Sistema gera código único
5. Arquivo é salvo (local ou MinIO conforme configuração)
6. Registro salvo no banco
7. Email enviado para cliente (opcional)
8. Redirect para lista com sucesso
```

#### Fluxo de Acesso do Cliente
```
1. Cliente acessa portal da clínica
2. Insere CPF + Data de nascimento
3. Sistema valida e faz login
4. Dashboard mostra exames disponíveis
5. Cliente clica em "Baixar"
6. Sistema serve arquivo (local ou MinIO)
7. Download seguro do PDF
8. Log de download registrado
```

#### Fluxo Multi-tenant
```
1. SuperAdmin cria nova clínica
2. Define plano e limites
3. Gestor da clínica é criado
4. Clínica fica isolada por clinic_id
5. Todos os dados respeitam o tenant
6. Billing e métricas são calculadas
```

### 📊 Middleware e Segurança

#### Tenant Middleware
```php
// app/Http/Middleware/TenantMiddleware.php
class TenantMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role === 'superadmin') {
            return $next($request);
        }
        
        $clinicId = auth()->user()->clinic_id;
        
        if (!$clinicId) {
            abort(403, 'Acesso negado');
        }
        
        // Definir tenant global para queries
        app()->instance('current_clinic_id', $clinicId);
        
        return $next($request);
    }
}
```

#### Global Scopes para Isolamento
```php
// app/Models/Traits/BelongsToClinic.php
trait BelongsToClinic
{
    protected static function booted()
    {
        static::addGlobalScope('clinic', function (Builder $builder) {
            if (app()->has('current_clinic_id')) {
                $builder->where('clinic_id', app('current_clinic_id'));
            }
        });
        
        static::creating(function ($model) {
            if (app()->has('current_clinic_id')) {
                $model->clinic_id = app('current_clinic_id');
            }
        });
    }
}
```

### 🚀 Deploy e Infraestrutura

#### Estrutura de Deployment
```yaml
# docker-compose.yml para Easypanel
version: '3.8'
services:
  app:
    build: .
    environment:
      - APP_ENV=production
      - DB_HOST=postgres
      - FILESYSTEM_DISK=local
    depends_on:
      - postgres
    volumes:
      - storage_data:/var/www/html/storage/app/private
      
  postgres:
    image: postgres:15
    environment:
      POSTGRES_DB: vetexams
      POSTGRES_USER: vetuser
      POSTGRES_PASSWORD: ${DB_PASSWORD}
    volumes:
      - postgres_data:/var/lib/postgresql/data

volumes:
  postgres_data:
  storage_data:
```

```yaml
# docker-compose.yml com MinIO (opcional)
version: '3.8'
services:
  app:
    build: .
    environment:
      - APP_ENV=production
      - DB_HOST=postgres
      - FILESYSTEM_DISK=minio
      - MINIO_ENDPOINT=http://minio:9000
    depends_on:
      - postgres
      - minio
      
  postgres:
    image: postgres:15
    environment:
      POSTGRES_DB: vetexams
      POSTGRES_USER: vetuser
      POSTGRES_PASSWORD: ${DB_PASSWORD}
    volumes:
      - postgres_data:/var/lib/postgresql/data
      
  minio:
    image: minio/minio:latest
    environment:
      MINIO_ROOT_USER: ${MINIO_USER}
      MINIO_ROOT_PASSWORD: ${MINIO_PASSWORD}
    volumes:
      - minio_data:/data
    command: server /data --console-address ":9001"
    ports:
      - "9000:9000"
      - "9001:9001"

volumes:
  postgres_data:
  minio_data:
```

#### Configuração .env

**Setup Básico (Storage Local):**
```bash
APP_NAME="VetExams SaaS"
APP_ENV=production
APP_KEY=base64:...
APP_DEBUG=false
APP_URL=https://vetexams.com.br

DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=vetexams
DB_USERNAME=vetuser
DB_PASSWORD=strong_password

# Storage local (padrão)
FILESYSTEM_DISK=local

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=sistema@vetexams.com.br
MAIL_PASSWORD=app_password

# Multi-tenancy
TENANT_DEFAULT_PLAN=basic
TENANT_MAX_STORAGE_GB=10
TENANT_MAX_EXAMS_MONTH=1000
```

**Setup com MinIO (Opcional):**
```bash
# Adicionar estas configurações ao .env acima
FILESYSTEM_DISK=minio

MINIO_ENDPOINT=http://minio:9000
MINIO_KEY=minio_user
MINIO_SECRET=minio_password
MINIO_REGION=us-east-1
MINIO_BUCKET=exam-files
```

### 💾 Sistema de Storage Flexível

#### Configuração Adaptável
O sistema detecta automaticamente o tipo de storage configurado:

**Storage Local (Padrão):**
```php
// config/filesystems.php
'default' => env('FILESYSTEM_DISK', 'local'),

'disks' => [
    'local' => [
        'driver' => 'local',
        'root' => storage_path('app/private'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'private',
    ],
],
```

**Storage MinIO (Opcional):**
```php
// config/filesystems.php
'disks' => [
    'minio' => [
        'driver' => 's3',
        'key' => env('MINIO_KEY'),
        'secret' => env('MINIO_SECRET'),
        'region' => env('MINIO_REGION'),
        'bucket' => env('MINIO_BUCKET'),
        'endpoint' => env('MINIO_ENDPOINT'),
        'use_path_style_endpoint' => true,
        'visibility' => 'private',
    ],
],
```

#### Service Storage Abstrato
```php
// app/Services/StorageService.php
class StorageService
{
    public function store(UploadedFile $file, string $path): string
    {
        $disk = config('filesystems.default');
        return Storage::disk($disk)->putFile($path, $file);
    }
    
    public function download(string $filePath): Response
    {
        $disk = config('filesystems.default');
        
        if ($disk === 'minio') {
            return $this->downloadFromMinIO($filePath);
        }
        
        return $this->downloadFromLocal($filePath);
    }
}
```

#### Implementação Prática

**Controller de Upload:**
```php
// app/Http/Controllers/Admin/ExamController.php
class ExamController extends Controller
{
    public function store(StoreExamRequest $request)
    {
        $file = $request->file('exam');
        $storageService = app(StorageService::class);
        
        // Upload flexível (local ou MinIO)
        $filePath = $storageService->store($file, 'exams');
        
        Exam::create([
            'file_path' => $filePath,
            'storage_disk' => config('filesystems.default'),
            'original_filename' => $file->getClientOriginalName(),
            'file_size_bytes' => $file->getSize(),
            // ... outros campos
        ]);
        
        return redirect()->route('admin.exams.index')
            ->with('success', 'Exame enviado com sucesso!');
    }
}
```

**Controller de Download:**
```php
public function download(Exam $exam)
{
    $storageService = app(StorageService::class);
    
    // Download automático baseado no tipo de storage
    return $storageService->download($exam->file_path, $exam->storage_disk);
}
```

**Migração Automática entre Storages:**
```php
// app/Console/Commands/MigrateStorage.php
class MigrateStorage extends Command
{
    public function handle()
    {
        $exams = Exam::where('storage_disk', 'local')->get();
        
        foreach ($exams as $exam) {
            $this->migrateExamToMinIO($exam);
        }
    }
}
```

#### Quando Usar Cada Storage

**Storage Local (Recomendado para início):**
- ✅ Setup mais simples
- ✅ Sem custos adicionais
- ✅ Performance boa para até 1000 exames
- ✅ Backup via rsync/snapshot VPS
- ⚠️ Limitado pelo espaço do servidor
- ⚠️ Não escala horizontalmente

**Storage MinIO (Para escala):**
- ✅ Escalabilidade ilimitada
- ✅ Backup e replicação nativos
- ✅ CDN e distribuição global
- ✅ URLs assinadas para segurança
- ⚠️ Complexidade adicional
- ⚠️ Custos de infraestrutura

**Migração Transparente:**
O sistema permite migrar de local para MinIO sem downtime, mantendo referências antigas funcionando.

### 📈 Escalabilidade e Performance

#### Otimizações Implementadas
- **Eager Loading**: Evita N+1 queries
- **Database Indexing**: Índices otimizados para queries frequentes
- **File Storage**: Local ou MinIO para performance de I/O
- **Streaming**: Downloads diretos sem carregar arquivo na memória
- **Validation**: Validação de arquivos antes do upload

#### Métricas e Monitoramento
- Dashboard de métricas por clínica
- Alertas de uso de storage
- Monitoramento de performance de uploads
- Logs de segurança e auditoria
- Relatórios de billing automatizados

### 💰 Modelo de Negócio SaaS

#### Planos Sugeridos
```
Básico:     R$ 99/mês  - 500 exames, 5GB storage
Profissional: R$ 199/mês - 2000 exames, 20GB storage
Enterprise:   R$ 399/mês - Ilimitado, 100GB storage
```

#### Controle de Limites
```php
// app/Services/BillingService.php
class BillingService
{
    public function checkLimits(Clinic $clinic, string $action)
    {
        $usage = $this->getCurrentUsage($clinic);
        $limits = $clinic->plan->limits;
        
        switch ($action) {
            case 'upload_exam':
                return $usage['exams_this_month'] < $limits['max_exams'];
            case 'storage':
                return $usage['storage_gb'] < $limits['max_storage'];
        }
        
        return false;
    }
}
```

---

## 🎯 Conclusão

Este sistema oferece uma solução completa e escalável para clínicas veterinárias, combinando simplicidade de desenvolvimento com recursos avançados de SaaS multi-tenant. A stack Laravel monolítica garante desenvolvimento rápido, manutenibilidade e performance adequada para o modelo de negócio proposto.

A arquitetura permite evolução gradual, desde MVP até sistema enterprise, mantendo sempre a simplicidade operacional e a experiência do usuário em primeiro lugar.