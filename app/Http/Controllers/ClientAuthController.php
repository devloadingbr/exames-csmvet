<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class ClientAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'cpf' => 'required|string',
            'birth_date' => 'required|date_format:d/m/Y',
        ]);

        // Formatar CPF (remover pontos e traços se houver)
        $cpf = preg_replace('/[^0-9]/', '', $request->cpf);
        $cpf = substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);

        // Converter data de nascimento
        $birthDate = Carbon::createFromFormat('d/m/Y', $request->birth_date)->format('Y-m-d');

        // Buscar cliente
        $client = Client::where('cpf', $cpf)
                       ->where('birth_date', $birthDate)
                       ->where('is_active', true)
                       ->first();

        if (!$client) {
            throw ValidationException::withMessages([
                'cpf' => 'CPF e/ou data de nascimento incorretos.',
            ]);
        }

        // Verificar se está bloqueado
        if ($client->isBlocked()) {
            throw ValidationException::withMessages([
                'cpf' => 'Cliente temporariamente bloqueado. Tente novamente mais tarde.',
            ]);
        }

        // Resetar tentativas de login em caso de sucesso
        $client->update([
            'login_attempts' => 0,
            'blocked_until' => null,
            'last_login_at' => now(),
        ]);

        // Fazer login no guard 'client'
        Auth::guard('client')->login($client);

        $request->session()->regenerate();

        return redirect()->intended(route('client.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::guard('client')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('client.login');
    }
}