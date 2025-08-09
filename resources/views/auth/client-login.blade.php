@extends('layouts.auth')

@section('title', 'Acesso do Cliente')

@section('content')
<div class="user-type">
    🐕 Portal do Cliente - Acesso aos Exames
</div>

@if ($errors->any())
    <div class="alert">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ url('/client/login') }}">
    @csrf
    
    <div class="form-group">
        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" value="{{ old('cpf') }}" 
               placeholder="000.000.000-00" required autofocus
               oninput="formatCPF(this)">
    </div>
    
    <div class="form-group">
        <label for="birth_date">Data de Nascimento:</label>
        <input type="text" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" 
               placeholder="dd/mm/aaaa" required
               oninput="formatDate(this)">
    </div>
    
    <button type="submit" class="btn">Acessar Meus Exames</button>
</form>

<div class="text-center mt-2">
    <a href="/" class="link">← Voltar à página inicial</a>
</div>

<script>
function formatCPF(input) {
    let value = input.value.replace(/\D/g, '');
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    input.value = value;
}

function formatDate(input) {
    let value = input.value.replace(/\D/g, '');
    value = value.replace(/(\d{2})(\d)/, '$1/$2');
    value = value.replace(/(\d{2})(\d{4})/, '$1/$2');
    input.value = value;
}
</script>
@endsection