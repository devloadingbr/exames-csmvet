@extends('layouts.auth')

@section('title', 'Login Gestor')

@section('content')
<div class="user-type">
    🏥 Gestor de Clínica - Área Administrativa
</div>

@if ($errors->any())
    <div class="alert">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ url('/admin/login') }}">
    @csrf
    
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
    </div>
    
    <div class="form-group">
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required>
    </div>
    
    <button type="submit" class="btn">Entrar como Gestor</button>
</form>

<div class="text-center mt-2">
    <a href="/" class="link">← Voltar à página inicial</a>
</div>
@endsection