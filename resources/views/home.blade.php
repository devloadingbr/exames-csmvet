<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetExams SaaS - Sistema de Gestão de Exames Veterinários</title>
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
            padding: 3rem 2rem;
            width: 100%;
            max-width: 600px;
            margin: 1rem;
            text-align: center;
        }
        .logo {
            margin-bottom: 2rem;
        }
        .logo h1 {
            color: #333;
            font-size: 3rem;
            font-weight: 300;
            margin-bottom: 0.5rem;
        }
        .logo span {
            color: #667eea;
            font-weight: 600;
        }
        .subtitle {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 3rem;
            line-height: 1.5;
        }
        .login-options {
            display: grid;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .login-card {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 2rem;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .login-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border-color: #667eea;
        }
        .login-card .icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            display: block;
        }
        .login-card .title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .login-card .description {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.4;
        }
        .footer {
            color: #999;
            font-size: 0.9rem;
            border-top: 1px solid #eee;
            padding-top: 2rem;
            margin-top: 2rem;
        }
        @media (min-width: 768px) {
            .login-options {
                grid-template-columns: repeat(3, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <h1><span>Vet</span>Exams</h1>
        </div>
        
        <p class="subtitle">
            Sistema completo de gestão e distribuição de exames veterinários.<br>
            Escolha sua área de acesso abaixo:
        </p>
        
        <div class="login-options">
            <a href="{{ route('superadmin.login') }}" class="login-card">
                <span class="icon">🔧</span>
                <div class="title">SuperAdmin</div>
                <div class="description">
                    Gestão completa do sistema, clínicas e relatórios globais
                </div>
            </a>
            
            <a href="{{ route('admin.login') }}" class="login-card">
                <span class="icon">🏥</span>
                <div class="title">Gestor de Clínica</div>
                <div class="description">
                    Administração da clínica, upload de exames e gestão de clientes
                </div>
            </a>
            
            <a href="{{ route('client.login') }}" class="login-card">
                <span class="icon">🐕</span>
                <div class="title">Portal do Cliente</div>
                <div class="description">
                    Acesso aos exames do seu pet com CPF e data de nascimento
                </div>
            </a>
        </div>
        
        <div class="footer">
            <strong>Credenciais de Teste:</strong><br>
            SuperAdmin: admin@vetexams.com.br / password<br>
            Gestor: joao@clinicasaojose.com.br / password<br>
            Cliente: CPF 123.456.789-00 + Data 15/05/1985
        </div>
    </div>
</body>
</html>