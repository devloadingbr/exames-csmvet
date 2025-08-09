<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - SuperAdmin - VetExams</title>
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: #1a1a2e;
            color: #fff;
            min-height: 100vh;
        }
        .header {
            background: #16213e;
            padding: 1rem 2rem;
            border-bottom: 2px solid #0f1419;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo h1 {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 300;
        }
        .logo span {
            color: #e94560;
            font-weight: 600;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .badge {
            background: #e94560;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .btn-logout {
            background: #0f1419;
            color: #fff;
            border: 1px solid #e94560;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        .btn-logout:hover {
            background: #e94560;
            color: white;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: #16213e;
            border: 1px solid #0f1419;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
        }
        .stat-card .number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #e94560;
            display: block;
            margin-bottom: 0.5rem;
        }
        .stat-card .label {
            color: #ccc;
            font-size: 0.9rem;
        }
        .card {
            background: #16213e;
            border: 1px solid #0f1419;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .card h3 {
            color: #e94560;
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th,
        .table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #0f1419;
        }
        .table th {
            color: #e94560;
            font-weight: 600;
        }
        .table td {
            color: #ccc;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <h1><span>Vet</span>Exams <small>SuperAdmin</small></h1>
        </div>
        
        <div class="user-info">
            <span class="badge">🔧 SUPERADMIN</span>
            <span>{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('superadmin.logout') }}" style="display: inline;">
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