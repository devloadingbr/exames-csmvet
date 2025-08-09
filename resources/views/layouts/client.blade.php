<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Portal do Cliente - VetExams</title>
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
            color: #333;
            min-height: 100vh;
        }
        .header {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            border-bottom: 2px solid rgba(116,185,255,0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
        }
        .client-nav {
            display: flex;
            gap: 1rem;
        }
        .nav-link {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            color: #666;
            font-weight: 500;
            transition: all 0.3s;
        }
        .nav-link:hover {
            background: rgba(116,185,255,0.1);
            color: #74b9ff;
        }
        .nav-link.active {
            background: #74b9ff;
            color: white;
        }
        .logo h1 {
            color: #333;
            font-size: 1.5rem;
            font-weight: 300;
        }
        .logo span {
            color: #74b9ff;
            font-weight: 600;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .badge {
            background: #74b9ff;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .btn-logout {
            background: white;
            color: #74b9ff;
            border: 1px solid #74b9ff;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        .btn-logout:hover {
            background: #74b9ff;
            color: white;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
        }
        .welcome {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .stat-card .number {
            font-size: 2rem;
            font-weight: bold;
            color: #74b9ff;
            display: block;
            margin-bottom: 0.5rem;
        }
        .stat-card .label {
            color: #666;
            font-size: 0.9rem;
        }
        .exams-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        .exam-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .exam-card:hover {
            transform: translateY(-4px);
        }
        .exam-code {
            font-size: 1.1rem;
            font-weight: bold;
            color: #74b9ff;
            margin-bottom: 0.5rem;
        }
        .exam-info {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        .exam-info strong {
            color: #333;
        }
        .btn-download {
            background: #74b9ff;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.3s;
            width: 100%;
        }
        .btn-download:hover {
            background: #0984e3;
        }
        
        /* Mobile Responsive Improvements */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }
            
            .client-nav {
                order: -1;
                width: 100%;
                justify-content: center;
                gap: 0.5rem;
            }
            
            .nav-link {
                flex: 1;
                text-align: center;
                font-size: 0.9rem;
                padding: 0.75rem 0.5rem;
            }
            
            .logo h1 {
                font-size: 1.2rem;
                text-align: center;
            }
            
            .user-info {
                justify-content: center;
                gap: 0.5rem;
                flex-wrap: wrap;
            }
            
            .badge {
                order: 1;
            }
            
            .container {
                padding: 1rem;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }
            
            .stat-card {
                padding: 1rem;
            }
            
            .stat-card .number {
                font-size: 1.5rem;
            }
            
            .exams-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .exam-card {
                padding: 1rem;
            }
            
            .welcome {
                padding: 1.5rem;
            }
        }
        
        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .nav-link {
                font-size: 0.8rem;
                padding: 0.5rem 0.25rem;
            }
            
            .exam-info {
                font-size: 0.85rem;
            }
            
            .exam-code {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <h1><span>Vet</span>Exams <small>Portal do Cliente</small></h1>
        </div>
        
        <nav class="client-nav">
            <a href="{{ route('client.dashboard') }}" class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                📋 Meus Exames
            </a>
            <a href="{{ route('client.profile.show') }}" class="nav-link {{ request()->routeIs('client.profile.*') ? 'active' : '' }}">
                👤 Meu Perfil
            </a>
        </nav>
        
        <div class="user-info">
            <span class="badge">🐕 CLIENTE</span>
            <span>{{ auth()->guard('client')->user()->name }}</span>
            <form method="POST" action="{{ route('client.logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">Sair</button>
            </form>
        </div>
    </div>
    
    <div class="container">
        @yield('content')
    </div>
</body>
</html>