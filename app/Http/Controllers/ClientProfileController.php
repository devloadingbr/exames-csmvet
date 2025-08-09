<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateClientProfileRequest;
use App\Models\Client;
use App\Services\DownloadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class ClientProfileController extends Controller
{
    protected DownloadService $downloadService;

    public function __construct(DownloadService $downloadService)
    {
        $this->downloadService = $downloadService;
    }

    /**
     * Mostra perfil do cliente
     */
    public function show()
    {
        $client = auth()->guard('client')->user();
        
        // Carregar relacionamentos
        $client->load(['pets', 'exams.examType']);

        // Estatísticas do cliente
        $stats = Cache::remember("client_profile_stats_{$client->id}", 300, function() use ($client) {
            $downloadStats = $this->downloadService->getClientDownloadStats($client);
            $recentDownloads = $this->downloadService->getRecentDownloads($client, 5);

            return [
                'total_pets' => $client->pets->count(),
                'total_exams' => $client->exams()->where('status', 'ready')->where('is_active', true)->count(),
                'download_stats' => $downloadStats,
                'recent_downloads' => $recentDownloads,
                'member_since' => $client->created_at,
                'last_login' => $client->last_login_at,
            ];
        });

        // Exames por tipo (para gráfico)
        $examsByType = $client->exams()
            ->where('status', 'ready')
            ->where('is_active', true)
            ->with('examType')
            ->get()
            ->groupBy('examType.name')
            ->map(function($exams) {
                return $exams->count();
            })
            ->toArray();

        return view('client.profile.show', compact('client', 'stats', 'examsByType'));
    }

    /**
     * Mostra formulário de edição do perfil
     */
    public function edit()
    {
        $client = auth()->guard('client')->user();
        return view('client.profile.edit', compact('client'));
    }

    /**
     * Atualiza o perfil do cliente
     */
    public function update(UpdateClientProfileRequest $request)
    {
        $client = auth()->guard('client')->user();

        // Verificar se email já existe para outro cliente da mesma clínica
        if ($request->filled('email') && $request->email !== $client->email) {
            $existingClient = Client::where('clinic_id', $client->clinic_id)
                ->where('email', $request->email)
                ->where('id', '!=', $client->id)
                ->first();

            if ($existingClient) {
                throw ValidationException::withMessages([
                    'email' => 'Este email já está sendo usado por outro cliente.',
                ]);
            }
        }

        // Atualizar dados (exceto CPF e data de nascimento)
        $client->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'receive_email_notifications' => $request->boolean('receive_email_notifications'),
            'receive_sms_notifications' => $request->boolean('receive_sms_notifications'),
        ]);

        // Limpar cache do cliente
        $this->downloadService->clearClientCache($client);

        return redirect()
            ->route('client.profile.show')
            ->with('success', 'Perfil atualizado com sucesso!');
    }

    /**
     * Mostra histórico de atividades do cliente
     */
    public function activity()
    {
        $client = auth()->guard('client')->user();

        // Downloads recentes (últimos 50)
        $downloads = $this->downloadService->getRecentDownloads($client, 50);

        // Histórico de logins (se houver tabela de logs)
        $loginHistory = collect([
            [
                'action' => 'Login realizado',
                'datetime' => $client->last_login_at ?? $client->created_at,
                'ip' => request()->ip(),
                'details' => 'Último login registrado',
            ]
        ]);

        // Combinar atividades
        $activities = collect($downloads)->map(function($download) {
            return [
                'action' => 'Download de exame',
                'datetime' => $download['downloaded_at'],
                'ip' => $download['ip_address'],
                'details' => "Exame {$download['exam_code']} - {$download['exam_type']} ({$download['pet_name']})",
                'type' => 'download',
            ];
        })->merge($loginHistory->map(function($login) {
            return array_merge($login, ['type' => 'login']);
        }))->sortByDesc('datetime')->take(100);

        return view('client.profile.activity', compact('client', 'activities'));
    }

    /**
     * API: Retorna dados do cliente para dashboard
     */
    public function getClientData()
    {
        $client = auth()->guard('client')->user();

        return response()->json([
            'client' => [
                'id' => $client->id,
                'name' => $client->name,
                'email' => $client->email,
                'phone' => $client->phone,
                'cpf' => $client->cpf,
                'member_since' => $client->created_at->format('d/m/Y'),
                'last_login' => $client->last_login_at?->format('d/m/Y H:i'),
            ],
            'stats' => $this->downloadService->getClientDownloadStats($client),
        ]);
    }

    /**
     * API: Atualiza preferências de notificação rapidamente
     */
    public function updateNotifications(Request $request)
    {
        $client = auth()->guard('client')->user();

        $request->validate([
            'receive_email_notifications' => 'boolean',
            'receive_sms_notifications' => 'boolean',
        ]);

        $client->update([
            'receive_email_notifications' => $request->boolean('receive_email_notifications'),
            'receive_sms_notifications' => $request->boolean('receive_sms_notifications'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Preferências atualizadas com sucesso!',
        ]);
    }

    /**
     * Mostra política de privacidade e termos
     */
    public function privacy()
    {
        $client = auth()->guard('client')->user();
        return view('client.profile.privacy', compact('client'));
    }

    /**
     * Mostra página de ajuda/suporte
     */
    public function help()
    {
        $client = auth()->guard('client')->user();
        
        // FAQ comum
        $faq = [
            [
                'question' => 'Como fazer download de um exame?',
                'answer' => 'Na página "Meus Exames", clique no botão "Baixar PDF" do exame desejado. O download iniciará automaticamente.',
            ],
            [
                'question' => 'Por que não consigo baixar um exame?',
                'answer' => 'Verifique se o exame está com status "Disponível". Exames em processamento ou expirados não podem ser baixados.',
            ],
            [
                'question' => 'Posso alterar meu CPF ou data de nascimento?',
                'answer' => 'Não, estes dados são usados para login e não podem ser alterados. Entre em contato com a clínica se houver erro.',
            ],
            [
                'question' => 'Como alterar minhas informações pessoais?',
                'answer' => 'Vá em "Meu Perfil" > "Editar Perfil" para alterar nome, email, telefone e endereço.',
            ],
            [
                'question' => 'Recebo muitas notificações, como desativar?',
                'answer' => 'Em "Meu Perfil", você pode desativar notificações por email e SMS conforme sua preferência.',
            ],
        ];

        return view('client.profile.help', compact('client', 'faq'));
    }
}