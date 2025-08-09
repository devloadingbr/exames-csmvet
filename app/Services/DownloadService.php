<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\ExamDownload;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadService
{
    protected StorageService $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
    }

    /**
     * Realiza download seguro de exame para cliente
     */
    public function downloadForClient(Exam $exam, Client $client, Request $request): StreamedResponse
    {
        // Verificar se cliente pode baixar este exame
        $this->validateClientAccess($exam, $client);

        // Aplicar rate limiting
        $this->checkRateLimit($client, $request);

        // Registrar download
        $this->logDownload($exam, $client, $request);

        // Realizar download
        return $this->storageService->download($exam->file_path, $exam->original_filename);
    }

    /**
     * Valida se cliente tem acesso ao exame
     */
    protected function validateClientAccess(Exam $exam, Client $client): void
    {
        // Verificar se exame pertence ao cliente
        if ($exam->client_id !== $client->id) {
            abort(403, 'Você não tem permissão para acessar este exame.');
        }

        // Verificar se exame está ativo e disponível
        if (!$exam->isAvailable()) {
            abort(404, 'Exame não está disponível para download.');
        }

        // Verificar se exame expirou
        if ($exam->isExpired()) {
            abort(410, 'Este exame já expirou e não está mais disponível.');
        }

        // Verificar se arquivo existe
        if (!$this->storageService->exists($exam->file_path)) {
            abort(500, 'Arquivo não encontrado no servidor. Contate a clínica.');
        }

        // Verificar se cliente está ativo
        if (!$client->is_active) {
            abort(403, 'Sua conta está inativa. Contate a clínica.');
        }

        // Verificar se cliente não está bloqueado
        if ($client->isBlocked()) {
            abort(429, 'Sua conta está temporariamente bloqueada.');
        }
    }

    /**
     * Aplica rate limiting para downloads
     */
    protected function checkRateLimit(Client $client, Request $request): void
    {
        $key = 'download_limit_client_' . $client->id;
        
        // Limite: 10 downloads por minuto por cliente
        if (!RateLimiter::attempt($key, 10, function() {}, 60)) {
            abort(429, 'Muitos downloads. Tente novamente em alguns minutos.');
        }

        // Limite adicional por IP (prevenir abuso)
        $ipKey = 'download_limit_ip_' . $request->ip();
        if (!RateLimiter::attempt($ipKey, 20, function() {}, 60)) {
            abort(429, 'Limite de downloads por IP excedido.');
        }
    }

    /**
     * Registra log do download
     */
    protected function logDownload(Exam $exam, Client $client, Request $request): void
    {
        ExamDownload::create([
            'clinic_id' => $exam->clinic_id,
            'exam_id' => $exam->id,
            'client_id' => $client->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'download_method' => 'client_portal',
            'downloaded_at' => now(),
        ]);
    }

    /**
     * Retorna estatísticas de downloads de um cliente
     */
    public function getClientDownloadStats(Client $client): array
    {
        $downloads = ExamDownload::where('client_id', $client->id);

        return [
            'total_downloads' => $downloads->count(),
            'downloads_today' => $downloads->whereDate('downloaded_at', today())->count(),
            'downloads_this_month' => $downloads->whereMonth('downloaded_at', now()->month)
                                               ->whereYear('downloaded_at', now()->year)
                                               ->count(),
            'last_download' => $downloads->latest('downloaded_at')->first()?->downloaded_at,
            'most_downloaded_exam' => $this->getMostDownloadedExam($client),
        ];
    }

    /**
     * Retorna exame mais baixado pelo cliente
     */
    protected function getMostDownloadedExam(Client $client): ?array
    {
        $mostDownloaded = ExamDownload::where('client_id', $client->id)
            ->selectRaw('exam_id, COUNT(*) as download_count')
            ->groupBy('exam_id')
            ->orderBy('download_count', 'desc')
            ->with('exam.examType', 'exam.pet')
            ->first();

        if (!$mostDownloaded || !$mostDownloaded->exam) {
            return null;
        }

        return [
            'exam' => $mostDownloaded->exam,
            'download_count' => $mostDownloaded->download_count,
        ];
    }

    /**
     * Verifica se cliente pode baixar um exame (preview de permissão)
     */
    public function canClientDownload(Exam $exam, Client $client): array
    {
        $canDownload = true;
        $reason = '';

        try {
            $this->validateClientAccess($exam, $client);
        } catch (\Exception $e) {
            $canDownload = false;
            $reason = $e->getMessage();
        }

        return [
            'can_download' => $canDownload,
            'reason' => $reason,
            'file_size' => $exam->formatted_size,
            'expires_at' => $exam->expires_at?->format('d/m/Y H:i'),
        ];
    }

    /**
     * Retorna lista de downloads recentes do cliente
     */
    public function getRecentDownloads(Client $client, int $limit = 10): array
    {
        return ExamDownload::where('client_id', $client->id)
            ->with(['exam.examType', 'exam.pet'])
            ->latest('downloaded_at')
            ->limit($limit)
            ->get()
            ->map(function ($download) {
                return [
                    'exam_code' => $download->exam->codigo,
                    'exam_type' => $download->exam->examType->name,
                    'pet_name' => $download->exam->pet->name,
                    'downloaded_at' => $download->downloaded_at,
                    'ip_address' => $download->ip_address,
                ];
            })
            ->toArray();
    }

    /**
     * Limpa cache relacionado ao cliente
     */
    public function clearClientCache(Client $client): void
    {
        Cache::forget('client_stats_' . $client->id);
        Cache::forget('client_downloads_' . $client->id);
        Cache::forget('client_exams_' . $client->id);
    }
}