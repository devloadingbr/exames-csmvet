<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamDownload;
use App\Services\DownloadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ClientExamController extends Controller
{
    protected DownloadService $downloadService;

    public function __construct(DownloadService $downloadService)
    {
        $this->downloadService = $downloadService;
    }

    /**
     * Mostra detalhes de um exame específico
     */
    public function show(Exam $exam)
    {
        $client = auth()->guard('client')->user();

        // Verificar se cliente tem acesso ao exame
        if ($exam->client_id !== $client->id) {
            abort(403, 'Você não tem permissão para acessar este exame.');
        }

        // Carregar relacionamentos
        $exam->load(['pet', 'examType', 'uploadedBy']);

        // Buscar histórico de downloads deste exame pelo cliente
        $downloads = ExamDownload::where('exam_id', $exam->id)
            ->where('client_id', $client->id)
            ->latest('downloaded_at')
            ->get();

        // Verificar se pode fazer download
        $downloadStatus = $this->downloadService->canClientDownload($exam, $client);

        // Estatísticas do exame
        $stats = [
            'total_downloads' => $downloads->count(),
            'first_download' => $downloads->last()?->downloaded_at,
            'last_download' => $downloads->first()?->downloaded_at,
        ];

        return view('client.exams.show', compact('exam', 'downloads', 'downloadStatus', 'stats'));
    }

    /**
     * Realiza download do exame
     */
    public function download(Exam $exam, Request $request): StreamedResponse
    {
        $client = auth()->guard('client')->user();

        try {
            return $this->downloadService->downloadForClient($exam, $client, $request);
        } catch (\Exception $e) {
            // Log do erro para debugging
            \Log::error('Erro no download do exame', [
                'exam_id' => $exam->id,
                'client_id' => $client->id,
                'error' => $e->getMessage(),
                'ip' => $request->ip(),
            ]);

            // Retornar erro apropriado
            if ($e->getCode() === 403) {
                abort(403, $e->getMessage());
            } elseif ($e->getCode() === 429) {
                abort(429, $e->getMessage());
            } else {
                abort(500, 'Erro interno do servidor. Tente novamente mais tarde.');
            }
        }
    }

    /**
     * API: Busca exames do cliente com filtros
     */
    public function search(Request $request)
    {
        $client = auth()->guard('client')->user();

        $query = Exam::with(['pet', 'examType'])
            ->where('client_id', $client->id)
            ->where('status', 'ready')
            ->where('is_active', true);

        // Filtro por pet
        if ($request->filled('pet_id')) {
            $query->where('pet_id', $request->pet_id);
        }

        // Filtro por tipo de exame
        if ($request->filled('exam_type_id')) {
            $query->where('exam_type_id', $request->exam_type_id);
        }

        // Filtro por período
        if ($request->filled('date_from')) {
            $query->whereDate('exam_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('exam_date', '<=', $request->date_to);
        }

        // Busca por código ou observações
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('result_summary', 'like', "%{$search}%");
            });
        }

        // Ordenação
        $sortBy = $request->get('sort_by', 'exam_date');
        $sortDirection = $request->get('sort_direction', 'desc');

        if (in_array($sortBy, ['exam_date', 'codigo', 'created_at'])) {
            $query->orderBy($sortBy, $sortDirection);
        } else {
            $query->latest('exam_date');
        }

        // Paginação
        $perPage = min($request->get('per_page', 12), 50); // Max 50 items
        $exams = $query->paginate($perPage);

        // Se for requisição AJAX, retornar apenas os dados
        if ($request->expectsJson()) {
            return response()->json([
                'exams' => $exams->items(),
                'pagination' => [
                    'current_page' => $exams->currentPage(),
                    'last_page' => $exams->lastPage(),
                    'per_page' => $exams->perPage(),
                    'total' => $exams->total(),
                ],
            ]);
        }

        return $exams;
    }

    /**
     * API: Retorna lista de pets do cliente para filtros
     */
    public function getPets()
    {
        $client = auth()->guard('client')->user();

        $pets = $client->pets()
            ->select('id', 'name', 'species', 'breed')
            ->orderBy('name')
            ->get();

        return response()->json($pets);
    }

    /**
     * API: Retorna estatísticas rápidas
     */
    public function getStats()
    {
        $client = auth()->guard('client')->user();

        // Cache das estatísticas por 5 minutos
        $stats = Cache::remember("client_stats_{$client->id}", 300, function() use ($client) {
            $exams = $client->exams()->where('status', 'ready')->where('is_active', true);

            return [
                'total_exams' => $exams->count(),
                'exams_this_month' => $exams->whereMonth('exam_date', now()->month)
                                           ->whereYear('exam_date', now()->year)
                                           ->count(),
                'pets_with_exams' => $exams->distinct('pet_id')->count('pet_id'),
                'download_stats' => $this->downloadService->getClientDownloadStats($client),
            ];
        });

        return response()->json($stats);
    }

    /**
     * API: Verificar status de download de um exame
     */
    public function checkDownloadStatus(Exam $exam)
    {
        $client = auth()->guard('client')->user();

        // Verificar se cliente tem acesso
        if ($exam->client_id !== $client->id) {
            return response()->json(['error' => 'Acesso negado'], 403);
        }

        $status = $this->downloadService->canClientDownload($exam, $client);

        return response()->json($status);
    }
}