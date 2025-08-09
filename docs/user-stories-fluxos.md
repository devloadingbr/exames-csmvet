# User Stories Detalhadas - VetExams SaaS
## Fluxos Completos de Tela por Persona

---

## 🌐 **TELAS PÚBLICAS (Sem Login)**

### **US001 - Landing Page Principal**
**Como:** Visitante  
**Quero:** Ver informações sobre o sistema  
**Para:** Decidir se quero usar o serviço  

#### Tela: `/`
**Elementos:**
- Logo "VetExams" (topo esquerda)
- Menu: Home | Preços | Contato | Login
- Hero section: "Exames veterinários digitais para sua clínica"
- 3 cards de planos: Básico (R$ 99), Profissional (R$ 199), Enterprise (R$ 399)
- Botão "Teste Grátis 14 dias" em cada plano
- Footer simples

**Ações:**
- Clicar "Login" → Redireciona para `/login`
- Clicar "Teste Grátis" → Formulário de cadastro da clínica
- Clicar "Contato" → Formulário de contato

---

### **US002 - Página de Login Unificada**
**Como:** Qualquer usuário  
**Quero:** Fazer login no sistema  
**Para:** Acessar minha área  

#### Tela: `/login`
**Elementos:**
- Logo centralizada
- 3 abas: "SuperAdmin" | "Gestor" | "Cliente"

**Aba SuperAdmin:**
- Campo: Email
- Campo: Senha  
- Checkbox: "Lembrar de mim"
- Botão: "Entrar como SuperAdmin"

**Aba Gestor:**
- Campo: Email
- Campo: Senha
- Link: "Esqueci minha senha"
- Botão: "Entrar como Gestor"

**Aba Cliente:**
- Campo: CPF (máscara: 000.000.000-00)
- Campo: Data de nascimento (dd/mm/aaaa)
- Botão: "Acessar meus exames"

**Fluxo de Sucesso:**
- SuperAdmin → `/superadmin/dashboard`
- Gestor → `/admin/dashboard`  
- Cliente → `/client/dashboard`

**Fluxo de Erro:**
- Credenciais inválidas → Mensagem vermelha: "Dados incorretos"
- CPF não encontrado → "CPF não cadastrado nesta clínica"

---

## 👑 **ÁREA SUPERADMIN**

### **US003 - Dashboard SuperAdmin**
**Como:** SuperAdmin  
**Quero:** Ver visão geral do negócio  
**Para:** Monitorar todas as clínicas  

#### Tela: `/superadmin/dashboard`
**Header:**
- Logo + "SuperAdmin"
- Menu: Dashboard | Clínicas | Planos | Financeiro | Logs
- Avatar + "Sair"

**Conteúdo:**
- 4 cards de métricas:
  - "Clínicas Ativas" (número + % mudança mensal)
  - "Receita Mensal" (R$ valor + % mudança)
  - "Exames Processados" (número total)
  - "Uso de Storage" (GB usados / GB total)

- Gráfico: "Receita últimos 6 meses" (linha)
- Tabela: "Últimas 10 clínicas cadastradas"
  - Colunas: Nome | Plano | Status | Data | Ações
  - Ação: "Ver detalhes" | "Suspender"

**Ações:**
- Todos os cards são clicáveis → Relatórios detalhados
- Menu lateral sempre presente em todas as telas

---

### **US004 - Gerenciar Clínicas**
**Como:** SuperAdmin  
**Quero:** Criar e gerenciar clínicas  
**Para:** Controlar os tenants do sistema  

#### Tela: `/superadmin/clinics`
**Elementos:**
- Título: "Clínicas Cadastradas"
- Botão: "+ Nova Clínica"
- Filtros: Status (Todas, Ativas, Suspensas) | Plano (Todos, Básico, Pro, Enterprise)
- Campo busca: "Buscar por nome ou CNPJ"

**Tabela:**
- Colunas: Logo | Nome | CNPJ | Plano | Status | Uso | Ações
- Status: Badge verde "Ativa" ou vermelho "Suspensa"  
- Uso: Barra de progresso (exames/limite)
- Ações: "Ver" | "Editar" | "Suspender" | "Faturar"

**Modal Nova Clínica:**
- Campo: Nome da clínica*
- Campo: CNPJ* (máscara)
- Campo: Email*
- Campo: Telefone
- Select: Plano (Básico, Profissional, Enterprise)
- Checkbox: "Período de teste 14 dias"
- Botão: "Criar Clínica"

**Fluxo:**
- Criar → Envia email para gestor criar senha → Dashboard clínicas

---

### **US005 - Detalhes da Clínica**
**Como:** SuperAdmin  
**Quero:** Ver informações completas de uma clínica  
**Para:** Monitorar uso e resolver problemas  

#### Tela: `/superadmin/clinics/{id}`
**Seções:**

**Informações Básicas:**
- Nome, CNPJ, email, telefone
- Plano atual + botão "Alterar plano"
- Status + botão toggle "Ativar/Suspender"

**Métricas do Mês:**
- Exames enviados: 150/2000
- Storage usado: 2.5GB/20GB  
- Usuários ativos: 3/10
- Downloads: 89

**Última Atividade:**
- Lista últimos 10 logs: "Dr. João enviou exame para Rex" | "Cliente Maria baixou exame 001"

**Faturamento:**
- Última fatura: R$ 199,00 (paga em 05/01)
- Próxima cobrança: 05/02
- Botão: "Ver todas as faturas"

**Ações Rápidas:**
- Botão: "Enviar email para gestor"
- Botão: "Acessar como gestor" (impersonate)
- Botão: "Gerar fatura avulsa"

---

## 🏥 **ÁREA GESTOR DA CLÍNICA**

### **US006 - Dashboard Gestor**
**Como:** Gestor da clínica  
**Quero:** Ver visão geral da minha clínica  
**Para:** Acompanhar atividades diárias  

#### Tela: `/admin/dashboard`
**Header:**
- Logo da clínica (ou padrão)
- Menu: Dashboard | Exames | Clientes | Pets | Relatórios
- Avatar + nome + "Sair"

**Cards de Métricas:**
- "Exames Este Mês": 45/500 (barra progresso)
- "Downloads Hoje": 12
- "Clientes Ativos": 89
- "Storage Usado": 1.2GB/5GB

**Seção Central:**
- Gráfico: "Exames enviados últimos 30 dias" (barras)
- Lista: "Últimos 10 exames enviados"
  - Pet | Cliente | Tipo | Data | Status | Ações
  - Status: "Novo" (azul) | "Baixado" (verde)
  - Ação: "Ver" | "Download"

**Seção Lateral:**
- Widget: "Clientes com exames hoje" (lista simples)
- Widget: "Lembretes" (lista vazia inicialmente)

**Botão Flutuante:** "+" (para novo exame)

---

### **US007 - Lista de Exames**
**Como:** Gestor  
**Quero:** Ver todos os exames da clínica  
**Para:** Gerenciar e organizar os resultados  

#### Tela: `/admin/exams`
**Cabeçalho:**
- Título: "Exames"
- Botão: "+ Novo Exame"
- Filtros: Status | Período (hoje, 7dias, 30dias, todos) | Tipo de exame

**Tabela Responsiva:**
- Colunas: Código | Pet | Cliente | Tipo | Data | Tamanho | Downloads | Status | Ações
- Código: Link para visualizar (VET2024000001)
- Status: Badge colorido
- Downloads: Número com ícone
- Ações: "Ver" | "Download" | "Reenviar email" | "Excluir"

**Paginação:** 20 itens por página

**Estados:**
- Lista vazia: "Nenhum exame encontrado" + botão "Enviar primeiro exame"
- Carregando: Skeleton das linhas
- Erro: "Erro ao carregar" + botão "Tentar novamente"

---

### **US008 - Upload de Exame**
**Como:** Gestor  
**Quero:** Enviar um novo exame  
**Para:** Disponibilizar resultado para o cliente  

#### Tela: `/admin/exams/create`
**Formulário em Etapas:**

**Etapa 1: Informações do Exame**
- Campo: Tipo de exame* (select: Hemograma, Raio-X, etc.)
- Campo: Data do exame* (date picker)
- Campo: Veterinário responsável*
- Campo: CRMV do veterinário
- Campo: Observações (textarea)
- Botão: "Próximo"

**Etapa 2: Selecionar Pet**
- Campo busca: "Buscar por nome do pet ou cliente"
- Lista de pets recentes (últimos 10)
- Ou botão: "+ Cadastrar novo pet"
- Botão: "Anterior" | "Próximo"

**Etapa 3: Upload do Arquivo**
- Drag & drop zone: "Arraste o PDF aqui ou clique para selecionar"
- Validações: Só PDF, máx 50MB
- Preview: Nome do arquivo, tamanho
- Progress bar durante upload
- Botão: "Anterior" | "Finalizar"

**Modal Cadastrar Pet:**
- Campo: Nome do pet*
- Select: Cliente* (busca)
- Campo: Espécie* (cão, gato, outros)
- Campo: Raça
- Select: Sexo (macho, fêmea)
- Campo: Data nascimento
- Botão: "Cancelar" | "Salvar pet"

**Fluxo de Sucesso:**
- Upload → Processamento → Código gerado → "Exame VET2024000123 enviado com sucesso!"
- Botão: "Ver exame" | "Enviar outro"

---

### **US009 - Detalhes do Exame**
**Como:** Gestor  
**Quero:** Ver informações completas de um exame  
**Para:** Verificar dados e acompanhar downloads  

#### Tela: `/admin/exams/{codigo}`
**Cabeçalho:**
- Código do exame: VET2024000123
- Status badge
- Botões: "Download PDF" | "Reenviar email" | "Editar"

**Informações do Exame:**
- Tipo: Hemograma Completo
- Data: 15/01/2024
- Pet: Rex (Cão, Labrador)
- Cliente: Maria Santos (123.456.789-00)
- Veterinário: Dr. João Silva (CRMV: 1234)
- Tamanho: 2.5 MB
- Enviado em: 15/01/2024 às 14:30

**Histórico de Downloads:**
- Tabela: Data | Hora | IP | User Agent
- Se vazio: "Este exame ainda não foi baixado"

**Log de Atividades:**
- Timeline: "Exame enviado" → "Email enviado" → "Cliente acessou" → "PDF baixado"

---

### **US010 - Gerenciar Clientes**
**Como:** Gestor  
**Quero:** Cadastrar e gerenciar clientes  
**Para:** Organizar a base de dados  

#### Tela: `/admin/clients`
**Cabeçalho:**
- Título: "Clientes"  
- Botão: "+ Novo Cliente"
- Campo busca: "Buscar por nome ou CPF"

**Tabela:**
- Colunas: Nome | CPF | Telefone | Email | Pets | Último acesso | Ações
- Pets: Número de pets cadastrados
- Ações: "Ver" | "Editar" | "Desativar"

**Modal Novo Cliente:**
- Campo: Nome completo*
- Campo: CPF* (com máscara e validação)
- Campo: Data de nascimento*
- Campo: Email
- Campo: Telefone (WhatsApp)
- Campo: Endereço completo
- Checkbox: "Receber notificações por email"
- Botão: "Cancelar" | "Salvar cliente"

---

### **US011 - Perfil do Cliente**
**Como:** Gestor  
**Quero:** Ver histórico completo do cliente  
**Para:** Ter visão 360º do relacionamento  

#### Tela: `/admin/clients/{id}`
**Dados do Cliente:**
- Nome, CPF, nascimento, contato
- Botão: "Editar dados"

**Pets do Cliente:**
- Cards com: Nome | Espécie | Idade | Foto
- Botão: "+ Adicionar pet"

**Histórico de Exames:**
- Lista ordenada por data (mais recentes primeiro)
- Cada item: Data | Pet | Tipo | Status | Downloads
- Se vazio: "Nenhum exame enviado ainda"

**Logs de Acesso:**
- Últimos 10 acessos: Data | Hora | IP
- Para controle de segurança

---

## 🐕 **ÁREA DO CLIENTE**

### **US012 - Dashboard Cliente**
**Como:** Cliente (dono do pet)  
**Quero:** Ver os exames dos meus pets  
**Para:** Acompanhar a saúde deles  

#### Tela: `/client/dashboard`
**Header Simples:**
- Logo da clínica
- Texto: "Olá, Maria! Aqui estão os exames do(s) seu(s) pet(s)"
- Botão: "Sair"

**Lista de Exames:**
- Cards responsivos para cada exame:
  - Pet: Rex (com foto se tiver)
  - Tipo: Hemograma Completo  
  - Data: 15/01/2024
  - Status: "Disponível" (verde) ou "Processando" (amarelo)
  - Botão: "Baixar PDF" (se disponível)

**Filtros Simples:**
- Select: Todos os pets | Rex | Mimi | etc.
- Select: Período: Último mês | Últimos 3 meses | Todos

**Estados:**
- Lista vazia: "Nenhum exame disponível"
- Carregando: Cards skeleton
- Erro de conexão: "Erro ao carregar. Tente novamente."

---

### **US013 - Visualizar Exame (Cliente)**
**Como:** Cliente  
**Quero:** Ver detalhes de um exame específico  
**Para:** Entender as informações  

#### Tela: `/client/exams/{codigo}`
**Cabeçalho:**
- Nome do pet: Rex
- Tipo de exame: Hemograma Completo
- Data: 15/01/2024

**Informações Básicas:**
- Veterinário: Dr. João Silva
- Clínica: Clínica Veterinária São José
- Observações: "Jejum de 12h foi respeitado"

**Ação Principal:**
- Botão grande: "📄 Baixar Resultado em PDF"
- Texto: "Tamanho: 2.5 MB"

**Informações de Acesso:**
- "Você já baixou este exame 2 vezes"
- "Primeiro acesso: 16/01/2024 às 09:30"

**Botão Secundário:**
- "Voltar aos meus exames"

---

### **US014 - Download de PDF**
**Como:** Cliente  
**Quero:** Baixar o arquivo do exame  
**Para:** Salvar ou imprimir  

#### Fluxo: Clicar "Baixar PDF"
**Validações:**
- Verificar se cliente está logado
- Verificar se exame pertence ao cliente  
- Verificar se exame está "disponível"

**Ação:**
- Gerar URL ou stream do arquivo (local/MinIO conforme configuração)
- Registrar download no log
- Iniciar download automático do PDF

**Estados:**
- Carregando: "Preparando download..."
- Erro: "Erro no download. Tente novamente."
- Sucesso: Download iniciado + mensagem "Download concluído"

---

## 🚨 **FLUXOS DE ERRO GLOBAIS**

### **US015 - Tratamento de Erros**

**Erro 404:**
- Página: "Oops! Página não encontrada"
- Botão: "Voltar ao Dashboard"

**Erro 403:**
- Página: "Acesso negado"
- Texto: "Você não tem permissão para acessar esta página"

**Erro 500:**
- Página: "Algo deu errado"
- Texto: "Nossa equipe foi notificada. Tente novamente em alguns minutos."

**Sessão Expirada:**
- Modal: "Sua sessão expirou. Faça login novamente."
- Botão: "Fazer login"

**Sem Internet:**
- Banner no topo: "⚠️ Conectividade perdida. Tentando reconectar..."

---

## 📱 **RESPONSIVIDADE**

### **US016 - Experiência Mobile**

**Celular (até 768px):**
- Menu hambúrguer
- Cards empilhados (1 coluna)
- Tabelas se transformam em cards
- Upload por toque na tela
- Botões maiores (min 44px altura)

**Tablet (768px - 1024px):**
- 2 colunas nos cards
- Menu lateral colapsável
- Tabelas com scroll horizontal

**Desktop (1024px+):**
- Layout completo conforme especificado
- Hover effects
- Tooltips informativos

---

## ⚙️ **CONFIGURAÇÕES E PERFIS**

### **US017 - Configurações da Clínica**
**Como:** Gestor  
**Quero:** Personalizar configurações  
**Para:** Adequar às necessidades da clínica  

#### Tela: `/admin/settings`
**Abas:**

**Aba Geral:**
- Nome da clínica
- Logo (upload)
- Cores primária/secundária (color picker)
- Endereço completo

**Aba Usuários:**
- Lista de usuários da clínica
- Botão: "+ Adicionar veterinário"
- Ações: Editar | Desativar

**Aba Notificações:**
- Checkbox: "Enviar email quando cliente baixar exame"  
- Checkbox: "Notificar quando storage atingir 80%"
- Campo: Email para notificações

**Aba Integrações:**
- WhatsApp Business (futuro)
- API Keys (se habilitado no plano)

---

## 🔍 **BUSCA E FILTROS**

### **US018 - Sistema de Busca**

**Busca Global (Header):**
- Campo: "Buscar exames, clientes ou pets"
- Busca em tempo real (após 3 caracteres)
- Resultados agrupados por tipo
- Máximo 5 resultados por tipo

**Filtros Avançados:**
- Disponível em: Exames, Clientes, Downloads
- Sidebar com: Período, Status, Tipo, etc.
- Botão: "Limpar filtros"
- Contador: "Mostrando 25 de 150 resultados"

---

## 📊 **RELATÓRIOS SIMPLES**

### **US019 - Relatórios para Gestor**
**Como:** Gestor  
**Quero:** Gerar relatórios básicos  
**Para:** Acompanhar desempenho da clínica  

#### Tela: `/admin/reports`
**Relatórios Disponíveis:**
- "Exames por mês" (último ano)
- "Top 10 clientes" (mais exames)
- "Downloads por período"
- "Uso de storage"

**Cada relatório:**
- Gráfico simples
- Tabela resumida
- Botão: "Exportar CSV"
- Período configurável

---

## 🔐 **SEGURANÇA E VALIDAÇÕES**

### **US020 - Validações de Segurança**

**Upload de Arquivo:**
- ✅ Só PDFs permitidos
- ✅ Máximo 50MB
- ✅ Scan de vírus (futuro)
- ✅ Verificação de integridade

**Autenticação Cliente:**
- ✅ CPF válido + data nascimento
- ✅ Rate limiting: 5 tentativas/minuto
- ✅ Log de tentativas inválidas

**Proteção CSRF:**
- ✅ Token em todos os formulários
- ✅ Headers de segurança
- ✅ Sanitização de inputs

---

## 📝 **CRITÉRIOS DE ACEITAÇÃO GLOBAIS**

### **Performance:**
- ⏱️ Páginas carregam em < 2 segundos
- ⏱️ Upload de 10MB em < 30 segundos
- ⏱️ Download de PDF em < 5 segundos

### **Usabilidade:**
- 📱 Funciona bem no mobile
- ♿ Textos legíveis (contraste adequado)
- 🎯 Botões clicáveis facilmente
- 📊 Estados de loading visíveis

### **Segurança:**
- 🔐 Dados isolados por clínica
- 🔒 Downloads só para donos dos exames
- 📋 Logs de todas as ações sensíveis
- 🛡️ Validação de todos os inputs

---

## ✅ **CHECKLIST DE VALIDAÇÃO**

Antes de marcar uma história como "pronta":

**Funcionalidade:**
- [ ] Fluxo principal funciona
- [ ] Fluxos de erro tratados
- [ ] Validações implementadas
- [ ] Responsivo mobile/desktop

**Qualidade:**
- [ ] Código revisado
- [ ] Testado manualmente
- [ ] Performance adequada
- [ ] Logs de auditoria funcionando

**UX:**
- [ ] Interface intuitiva
- [ ] Mensagens de feedback claras
- [ ] Estados de loading/erro
- [ ] Navegação fluida

**Segurança:**
- [ ] Autorização verificada
- [ ] Inputs sanitizados
- [ ] CSRF protegido
- [ ] Tenant isolation funcionando