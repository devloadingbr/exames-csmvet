<?php

namespace App\Policies;

use App\Models\Exam;
use App\Models\User;
use App\Models\Client;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExamPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['superadmin', 'manager', 'veterinarian']);
    }

    public function view(User $user, Exam $exam): bool
    {
        // SuperAdmin pode ver todos os exames
        if ($user->role === 'superadmin') {
            return true;
        }

        // Outros usuários só podem ver exames da mesma clínica
        return $user->clinic_id === $exam->clinic_id;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['manager', 'veterinarian']);
    }

    public function update(User $user, Exam $exam): bool
    {
        // SuperAdmin pode atualizar todos os exames
        if ($user->role === 'superadmin') {
            return true;
        }

        // Outros usuários só podem atualizar exames da mesma clínica
        if ($user->clinic_id !== $exam->clinic_id) {
            return false;
        }

        // Managers podem atualizar todos os exames da clínica
        if ($user->role === 'manager') {
            return true;
        }

        // Veterinários só podem atualizar exames que eles criaram
        if ($user->role === 'veterinarian') {
            return $exam->uploaded_by === $user->id;
        }

        return false;
    }

    public function delete(User $user, Exam $exam): bool
    {
        // SuperAdmin pode deletar todos os exames
        if ($user->role === 'superadmin') {
            return true;
        }

        // Outros usuários só podem deletar exames da mesma clínica
        if ($user->clinic_id !== $exam->clinic_id) {
            return false;
        }

        // Managers podem deletar todos os exames da clínica
        if ($user->role === 'manager') {
            return true;
        }

        // Veterinários só podem deletar exames que eles criaram
        if ($user->role === 'veterinarian') {
            return $exam->uploaded_by === $user->id;
        }

        return false;
    }

    public function download(User $user, Exam $exam): bool
    {
        return $this->view($user, $exam);
    }

    /**
     * Determina se o cliente pode ver um exame (portal do cliente)
     */
    public function viewAsClient(?Client $client, Exam $exam): bool
    {
        if (!$client) {
            return false;
        }

        // Cliente deve ser o dono do exame
        if ($exam->client_id !== $client->id) {
            return false;
        }

        // Cliente deve estar ativo
        if (!$client->is_active) {
            return false;
        }

        // Cliente não deve estar bloqueado
        if ($client->isBlocked()) {
            return false;
        }

        // Exame deve estar disponível
        if (!$exam->isAvailable()) {
            return false;
        }

        return true;
    }

    /**
     * Determina se o cliente pode fazer download de um exame
     */
    public function downloadAsClient(?Client $client, Exam $exam): bool
    {
        // Mesmas regras do viewAsClient
        if (!$this->viewAsClient($client, $exam)) {
            return false;
        }

        // Verificar se não expirou
        if ($exam->isExpired()) {
            return false;
        }

        return true;
    }

    /**
     * Determina se o usuário pode ver logs de download
     */
    public function viewDownloadLogs(User $user, Exam $exam): bool
    {
        // SuperAdmin pode ver todos os logs
        if ($user->role === 'superadmin') {
            return true;
        }

        // Managers podem ver logs dos exames da clínica
        if ($user->role === 'manager' && $user->clinic_id === $exam->clinic_id) {
            return true;
        }

        return false;
    }
}