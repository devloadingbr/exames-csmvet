# Plano: Busca Sequencial Cliente → Pet no Cadastro de Exames

## 📋 Resumo Executivo

O sistema atual de cadastro de exames permite buscar diretamente por pets ou clientes em um campo único, o que pode gerar confusão na seleção. Este plano implementa uma busca sequencial onde:

1. **Primeiro**: Usuário busca e seleciona o cliente (tutor) por CPF, nome, e-mail ou telefone
2. **Depois**: Sistema exibe apenas os pets do cliente selecionado
3. **Finalmente**: Usuário seleciona o pet e continua o cadastro

## 🔍 Análise do Sistema Atual

### Estado Atual (Step 2 do formulário)
- ❌ Busca única que mistura pets e clientes
- ❌ Pode confundir quando há pets com nomes similares de tutores diferentes  
- ❌ Não há relacionamento visual claro entre tutor e pet
- ❌ Busca atual: `searchPets()` em `/admin/api/pets/search`

### Fluxo Atual Identificado
```
ExamController.create() → 
view('admin.exams.create') → 
Step 2: searchPets() via AJAX → 
ExamController.searchPets() → 
Retorna pets com client via JSON
```

### Componentes Atuais Analisados

#### 1. **ExamController.php**
- `create()`: Carrega examTypes + últimos 10 pets (linha 81-85)
- `searchPets()`: Busca pets por nome ou cliente (linha 173-190)
- Rota: `Route::get('/api/pets/search')` → `admin.pets.search`

#### 2. **create.blade.php (Step 2)**
- AlpineJS: `searchPets()` função (linha 572-580)
- Input de busca: `x-model="petSearch"` (linha 188-192)
- Lista de pets: Grid com seleção (linha 203-228)

#### 3. **StoreExamRequest.php**
- Validação: `pet_id` e `client_id` obrigatórios (linha 18-19)
- `prepareForValidation()`: Automaticamente define `client_id` baseado no pet (linha 51-62)

## 🎯 Objetivos da Mudança

### Objetivos Funcionais
1. **Melhor UX**: Fluxo lógico Cliente → Pet
2. **Redução de Erros**: Evitar seleção de pet errado
3. **Clareza Visual**: Relacionamento tutor-pet evidente
4. **Busca Otimizada**: Campos específicos (CPF, nome, email, telefone)

### Objetivos Técnicos
1. **Manter Compatibilidade**: Não quebrar funcionalidades existentes
2. **Reuso de Código**: Aproveitar estruturas atuais
3. **Performance**: Minimizar queries desnecessárias

## 🏗️ Arquitetura da Solução

### Modificações no Step 2

#### **Novo Fluxo Visual:**
```
┌─────────────────────────┐
│    Step 2: Seleções    │
├─────────────────────────┤
│  2.1 - Selecionar      │
│       Cliente          │
├─────────────────────────┤
│  2.2 - Selecionar Pet  │
│      (do cliente)      │
└─────────────────────────┘
```

#### **Estados do Componente:**
- `clientSelected: false` → Mostra busca de cliente
- `clientSelected: true` → Mostra pets do cliente + possibilidade de trocar cliente

## 📝 Plano de Implementação Detalhado

### **FASE 1: Backend - Novas Rotas e Métodos**

#### 1.1 - Nova Rota para Busca de Clientes
```php
// routes/web.php (após linha ~83)
Route::get('/api/clients/search', 'App\Http\Controllers\ExamController@searchClients')
    ->name('admin.clients.search');
```

#### 1.2 - Novo Método no ExamController
```php
// app/Http/Controllers/ExamController.php (após linha 191)
public function searchClients(Request $request)
{
    $search = $request->get('q');
    
    $clients = Client::where('clinic_id', auth()->user()->clinic_id)
        ->where(function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%") 
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
        })
        ->withCount('pets') // Incluir contagem de pets
        ->limit(10)
        ->get();

    return response()->json($clients);
}
```

#### 1.3 - Modificar Método searchPets
```php
// Modificar ExamController.searchPets() para aceitar client_id
public function searchPets(Request $request)
{
    $search = $request->get('q');
    $clientId = $request->get('client_id'); // NOVO
    
    $query = Pet::with('client')
        ->where('clinic_id', auth()->user()->clinic_id);
        
    // NOVO: Filtrar por cliente se especificado
    if ($clientId) {
        $query->where('client_id', $clientId);
    }
    
    if ($search) {
        $query->where('name', 'like', "%{$search}%");
    }
    
    $pets = $query->limit(20)->get();
    
    return response()->json($pets);
}
```

### **FASE 2: Frontend - Modificação do Step 2**

#### 2.1 - Novas Propriedades AlpineJS
```javascript
// Adicionar no objeto examUpload() - linha ~522
clientSearch: '',
availableClients: [],
selectedClient: null,
clientSelected: false,
```

#### 2.2 - Novas Funções AlpineJS
```javascript
// Adicionar após searchPets() - linha ~580
searchClients() {
    if (this.clientSearch.length >= 2) {
        fetch(`{{ route('admin.clients.search') }}?q=${encodeURIComponent(this.clientSearch)}`)
            .then(response => response.json())
            .then(clients => {
                this.availableClients = clients;
            });
    } else {
        this.availableClients = [];
    }
},

selectClient(client) {
    this.selectedClient = client;
    this.clientSelected = true;
    this.form.client_id = client.id;
    
    // Carregar pets do cliente
    this.loadClientPets(client.id);
    
    // Limpar seleção de pet atual
    this.form.pet_id = '';
},

loadClientPets(clientId) {
    fetch(`{{ route('admin.pets.search') }}?client_id=${clientId}`)
        .then(response => response.json())
        .then(pets => {
            this.availablePets = pets;
        });
},

changeClient() {
    this.selectedClient = null;
    this.clientSelected = false;
    this.form.client_id = '';
    this.form.pet_id = '';
    this.availableClients = [];
    this.availablePets = [];
    this.clientSearch = '';
},
```

#### 2.3 - Nova Estrutura HTML do Step 2
```html
<!-- Step 2: Select Client and Pet -->
<div x-show="step === 2" class="bg-white shadow sm:rounded-lg p-6 space-y-6">
    <h3 class="text-lg font-medium text-gray-900">Selecionar Cliente e Pet</h3>
    
    <!-- 2.1 - Client Selection -->
    <div x-show="!clientSelected">
        <h4 class="text-md font-medium text-gray-800 mb-4">1. Primeiro, selecione o cliente (tutor)</h4>
        
        <!-- Client Search -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Buscar por CPF, Nome, E-mail ou Telefone
            </label>
            <div class="relative">
                <input type="text" 
                       x-model="clientSearch"
                       @input="searchClients()"
                       class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 pr-10"
                       placeholder="Digite CPF, nome, e-mail ou telefone do cliente">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Client Results -->
        <div x-show="availableClients.length > 0" class="mt-4">
            <div class="grid grid-cols-1 gap-3">
                <template x-for="client in availableClients" :key="client.id">
                    <div class="border border-gray-200 rounded-lg p-4 cursor-pointer hover:bg-blue-50 hover:border-blue-300 transition-colors"
                         @click="selectClient(client)">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900" x-text="client.name"></h4>
                                <p class="text-sm text-gray-600" x-text="'CPF: ' + client.cpf"></p>
                                <div class="flex items-center space-x-4 mt-1">
                                    <p class="text-sm text-gray-500" x-show="client.email" x-text="client.email"></p>
                                    <p class="text-sm text-gray-500" x-show="client.phone" x-text="client.phone"></p>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <span x-text="client.pets_count"></span> pet(s)
                                </span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- 2.2 - Pet Selection (after client selected) -->
    <div x-show="clientSelected">
        <!-- Selected Client Info -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-md font-medium text-blue-900">Cliente Selecionado:</h4>
                    <p class="text-blue-800" x-text="selectedClient.name"></p>
                    <p class="text-sm text-blue-700" x-text="'CPF: ' + selectedClient.cpf"></p>
                </div>
                <button type="button" 
                        @click="changeClient()"
                        class="text-sm text-blue-600 hover:text-blue-800 underline">
                    Trocar Cliente
                </button>
            </div>
        </div>

        <h4 class="text-md font-medium text-gray-800 mb-4">2. Agora, selecione o pet do cliente</h4>

        <!-- Pet Selection -->
        <div x-show="availablePets.length > 0">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <template x-for="pet in availablePets" :key="pet.id">
                    <div class="border border-gray-200 rounded-lg p-4 cursor-pointer hover:bg-gray-50 transition-colors"
                         :class="form.pet_id === pet.id ? 'border-blue-500 bg-blue-50' : ''"
                         @click="form.pet_id = pet.id">
                        <div class="flex items-center space-x-3">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900" x-text="pet.name"></h4>
                                <p class="text-sm text-gray-600">
                                    <span x-text="pet.species"></span>
                                    <template x-if="pet.breed">
                                        - <span x-text="pet.breed"></span>
                                    </template>
                                </p>
                                <template x-if="pet.gender">
                                    <p class="text-sm text-gray-500" x-text="pet.gender"></p>
                                </template>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="w-4 h-4 border-2 rounded-full" 
                                     :class="form.pet_id === pet.id ? 'border-blue-500 bg-blue-500' : 'border-gray-300'">
                                    <div x-show="form.pet_id === pet.id" class="w-2 h-2 bg-white rounded-full m-0.5"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- No Pets Message -->
        <div x-show="availablePets.length === 0" class="text-center py-8">
            <p class="text-gray-500 mb-4">Este cliente ainda não possui pets cadastrados.</p>
            <button type="button" 
                    @click="showNewPetModal = true; newPet.client_id = selectedClient.id"
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Cadastrar Pet para este Cliente
            </button>
        </div>
    </div>

    <!-- Navigation Buttons -->
    <div class="flex justify-between pt-6 border-t border-gray-200">
        <button type="button" 
                @click="prevStep()"
                class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
            Anterior
        </button>
        <button type="button" 
                @click="nextStep()"
                :disabled="!form.pet_id"
                class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed transition-colors">
            Próximo
        </button>
    </div>
</div>
```

### **FASE 3: Ajustes e Melhorias**

#### 3.1 - Modificar Modal de Novo Pet
- Pré-selecionar cliente quando vier do fluxo de exame
- Atualizar lista de pets após criação

#### 3.2 - Melhorar Validações
- Adicionar validação visual de cliente selecionado
- Feedback quando não encontrar resultados

#### 3.3 - Responsividade
- Ajustar grid para mobile
- Otimizar cards de cliente/pet

## 🧪 Plano de Testes

### Testes Funcionais
1. **Busca de Clientes**: CPF, nome, e-mail, telefone
2. **Seleção de Cliente**: Carregamento correto de pets
3. **Troca de Cliente**: Limpeza de dados anteriores  
4. **Validações**: Obrigatoriedade de seleções
5. **Modal Novo Pet**: Pré-seleção de cliente

### Testes de Edge Cases
1. Cliente sem pets cadastrados
2. Busca sem resultados
3. Cliente com muitos pets
4. Caracteres especiais na busca

### Testes de Performance
1. Tempo de resposta da busca
2. Quantidade de requisições AJAX
3. Rendering com muitos resultados

## 📋 Checklist de Implementação

### Backend ✅
- [ ] Nova rota `admin.clients.search`
- [ ] Método `searchClients()` no ExamController
- [ ] Modificar método `searchPets()` para filtrar por client_id
- [ ] Testar retornos JSON

### Frontend ✅
- [ ] Novas propriedades AlpineJS
- [ ] Funções de busca e seleção de cliente
- [ ] Nova estrutura HTML do Step 2
- [ ] Modificar modal de novo pet
- [ ] Ajustar validações do formulário

### Testes ✅
- [ ] Testes unitários backend
- [ ] Testes funcionais frontend
- [ ] Testes de integração
- [ ] Testes de performance

### Documentação ✅
- [ ] Atualizar documentação de API
- [ ] Documentar novos fluxos UX
- [ ] Manual de usuário atualizado

## 🚀 Cronograma Estimado

| Fase | Atividade | Tempo Estimado |
|------|-----------|----------------|
| **Fase 1** | Backend - Rotas e Métodos | 2-3 horas |
| **Fase 2** | Frontend - Interface | 4-5 horas |
| **Fase 3** | Ajustes e Melhorias | 2-3 horas |
| **Testes** | Testes Completos | 3-4 horas |
| **Total** | **Implementação Completa** | **11-15 horas** |

## ⚠️ Riscos e Contingências

### Riscos Identificados
1. **Quebra de funcionalidade existente**: Modificações podem afetar outras partes
2. **Performance**: Muitas requisições AJAX podem impactar UX
3. **Compatibilidade**: AlpineJS pode ter conflitos

### Planos de Contingência
1. **Branch separada**: Desenvolver em branch feature/client-pet-search
2. **Rollback rápido**: Manter versão anterior funcional
3. **Testes incrementais**: Testar cada fase antes de continuar

## 📊 Métricas de Sucesso

### Métricas Funcionais
- ✅ 100% dos casos de uso funcionando
- ✅ Tempo de seleção cliente+pet < 30 segundos
- ✅ Zero erros de seleção incorreta
- ✅ Busca retorna resultados em < 2 segundos

### Métricas Técnicas  
- ✅ Cobertura de testes > 90%
- ✅ Performance sem degradação
- ✅ Zero bugs críticos em produção

---

## 🔗 Arquivos Impactados

### Modificações Necessárias
- `routes/web.php` - Nova rota de busca de clientes
- `app/Http/Controllers/ExamController.php` - Novos métodos
- `resources/views/admin/exams/create.blade.php` - Nova interface Step 2
- Possível: `app/Http/Requests/StoreExamRequest.php` - Validações adicionais

### Arquivos de Teste  
- `tests/Feature/ExamCreationTest.php` (novo)
- `tests/Unit/ExamControllerTest.php` (novo)

---

**📝 Documento criado em:** 2025-08-10  
**👤 Responsável:** Sistema de Gerenciamento VetExams  
**🎯 Objetivo:** Implementar busca sequencial Cliente → Pet no cadastro de exames  
**📋 Status:** Plano aprovado, aguardando implementação