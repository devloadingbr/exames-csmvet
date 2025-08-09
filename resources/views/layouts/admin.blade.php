<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Gestor - VetExams</title>
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: #f8f9fa;
            color: #333;
            min-height: 100vh;
        }
        .header {
            background: white;
            padding: 1rem 2rem;
            border-bottom: 2px solid #e9ecef;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo h1 {
            color: #333;
            font-size: 1.5rem;
            font-weight: 300;
        }
        .logo span {
            color: #007bff;
            font-weight: 600;
        }
        .clinic-name {
            color: #666;
            font-size: 0.9rem;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .badge {
            background: #007bff;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .btn-logout {
            background: white;
            color: #007bff;
            border: 1px solid #007bff;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        .btn-logout:hover {
            background: #007bff;
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
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stat-card .number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #007bff;
            display: block;
            margin-bottom: 0.5rem;
        }
        .stat-card .label {
            color: #666;
            font-size: 0.9rem;
        }
        .card {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .card h3 {
            color: #007bff;
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
            border-bottom: 1px solid #e9ecef;
        }
        .table th {
            color: #007bff;
            font-weight: 600;
        }
        .table td {
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <h1><span>Vet</span>Exams <small>Gestor</small></h1>
            <div class="clinic-name">{{ auth()->user()->clinic->name ?? 'Clínica' }}</div>
        </div>
        
        <div class="user-info">
            <span class="badge">🏥 GESTOR</span>
            <span>{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('admin.logout') }}" style="display: inline;">
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