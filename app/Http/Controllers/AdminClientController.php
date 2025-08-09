<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Pet;
use App\Models\Exam;
use App\Models\ExamDownload;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Services\DownloadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::with(['pets'])
            ->where('clinic_id', auth()->user()->clinic_id)
            ->withCount(['pets', 'exams']);

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->whereNull('deleted_at');
            } elseif ($request->status === 'inactive') {
                $query->whereNotNull('deleted_at');
            }
        }

        $clients = $query->latest()->paginate(20);

        // Retornar JSON se solicitado
        if (request()->input('format') === 'json') {
            return response()->json([
                'clients' => $clients->items()
            ]);
        }

        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(StoreClientRequest $request)
    {
        $validated = $request->validated();
        $validated['clinic_id'] = auth()->user()->clinic_id;

        $client = Client::create($validated);

        // Retornar JSON se solicitado via AJAX
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'client' => $client,
                'message' => 'Cliente cadastrado com sucesso!'
            ]);
        }

        return redirect()
            ->route('admin.clients.show', $client)
            ->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function show(Client $client)
    {
        $this->authorize('view', $client);
        
        // Carregar todos os relacionamentos necessários
        $client->load([
            'pets.exams.examType',
            'exams.examType',
            'exams.pet',
            'exams.downloads',
            'createdBy'
        ]);
        
        // Estatísticas completas do cliente
        $stats = [
            // Básicas
            'total_pets' => $client->pets->count(),
            'total_exams' => $client->exams->count(),
            'ready_exams' => $client->exams->where('status', 'ready')->count(),
            'processing_exams' => $client->exams->where('status', 'processing')->count(),
            'pending_exams' => $client->exams->where('status', 'pending')->count(),
            
            // Downloads
            'total_downloads' => ExamDownload::where('client_id', $client->id)->count(),
            'downloads_today' => ExamDownload::where('client_id', $client->id)
                ->whereDate('downloaded_at', today())->count(),
            'downloads_this_month' => ExamDownload::where('client_id', $client->id)
                ->whereMonth('downloaded_at', now()->month)
                ->whereYear('downloaded_at', now()->year)->count(),
            
            // Datas importantes
            'last_exam' => $client->exams->sortByDesc('exam_date')->first(),
            'first_exam' => $client->exams->sortBy('exam_date')->first(),
            'last_download' => ExamDownload::where('client_id', $client->id)
                ->latest('downloaded_at')->first(),
            'member_since' => $client->created_at,
            'last_login' => $client->last_login_at,
            
            // Financeiro (valor total dos exames)
            'total_value' => $client->exams->sum('price'),
            'avg_exam_value' => $client->exams->count() > 0 ? 
                $client->exams->avg('price') : 0,
        ];

        // Exames recentes (últimos 10)
        $recentExams = $client->exams()
            ->with(['examType', 'pet'])
            ->latest('exam_date')
            ->limit(10)
            ->get();

        // Downloads recentes (últimos 10)
        $recentDownloads = ExamDownload::where('client_id', $client->id)
            ->with(['exam.examType', 'exam.pet'])
            ->latest('downloaded_at')
            ->limit(10)
            ->get();

        // Estatísticas por pet
        $petStats = $client->pets->map(function($pet) {
            return [
                'pet' => $pet,
                'exam_count' => $pet->exams->count(),
                'last_exam' => $pet->exams->sortByDesc('exam_date')->first(),
                'exam_types' => $pet->exams->groupBy('exam_type_id')->count(),
            ];
        });

        // Exames por tipo (para gráfico)
        $examsByType = $client->exams
            ->groupBy('examType.name')
            ->map(function($exams, $type) {
                return [
                    'type' => $type,
                    'count' => $exams->count(),
                    'total_value' => $exams->sum('price'),
                ];
            })
            ->sortByDesc('count')
            ->values();

        // Exames por mês (últimos 12 meses para gráfico)
        $examsByMonth = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = $client->exams()
                ->whereYear('exam_date', $date->year)
                ->whereMonth('exam_date', $date->month)
                ->count();
            
            $examsByMonth->push([
                'month' => $date->format('M/Y'),
                'count' => $count,
            ]);
        }

        // Alertas e observações
        $alerts = [];
        
        // Cliente nunca fez download
        if ($stats['total_downloads'] === 0 && $stats['ready_exams'] > 0) {
            $alerts[] = [
                'type' => 'warning',
                'message' => 'Cliente nunca realizou downloads, apesar de ter exames disponíveis.',
            ];
        }

        // Cliente bloqueado
        if ($client->isBlocked()) {
            $alerts[] = [
                'type' => 'danger',
                'message' => 'Cliente está temporariamente bloqueado até ' . 
                           $client->blocked_until->format('d/m/Y H:i'),
            ];
        }

        // Cliente inativo
        if (!$client->is_active) {
            $alerts[] = [
                'type' => 'danger',
                'message' => 'Cliente está inativo no sistema.',
            ];
        }

        // Sem login há muito tempo
        if ($client->last_login_at && $client->last_login_at->diffInDays(now()) > 30) {
            $alerts[] = [
                'type' => 'info',
                'message' => 'Cliente não acessa o portal há mais de 30 dias.',
            ];
        }

        return view('admin.clients.show', compact(
            'client', 
            'stats', 
            'recentExams', 
            'recentDownloads', 
            'petStats', 
            'examsByType', 
            'examsByMonth',
            'alerts'
        ));
    }

    public function edit(Client $client)
    {
        $this->authorize('update', $client);
        
        return view('admin.clients.edit', compact('client'));
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $this->authorize('update', $client);

        $client->update($request->validated());

        return redirect()
            ->route('admin.clients.show', $client)
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy(Client $client)
    {
        $this->authorize('delete', $client);

        // Verificar se tem exames ativos
        $activeExams = $client->exams()->where('status', 'ready')->count();
        
        if ($activeExams > 0) {
            return redirect()
                ->back()
                ->with('error', 'Não é possível excluir cliente com exames ativos. Total: ' . $activeExams);
        }

        $client->delete();

        return redirect()
            ->route('admin.clients.index')
            ->with('success', 'Cliente removido com sucesso!');
    }

    /**
     * Bloqueia temporariamente um cliente
     */
    public function block(Client $client, Request $request)
    {
        $this->authorize('update', $client);

        $request->validate([
            'hours' => 'required|integer|min:1|max:72',
            'reason' => 'nullable|string|max:255',
        ]);

        $client->update([
            'blocked_until' => now()->addHours($request->hours),
            'login_attempts' => 5, // Máximo de tentativas
        ]);

        return redirect()
            ->back()
            ->with('success', "Cliente bloqueado por {$request->hours} horas.");
    }

    /**
     * Desbloqueia um cliente
     */
    public function unblock(Client $client)
    {
        $this->authorize('update', $client);

        $client->update([
            'blocked_until' => null,
            'login_attempts' => 0,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Cliente desbloqueado com sucesso!');
    }

    /**
     * Ativa/desativa um cliente
     */
    public function toggleStatus(Client $client)
    {
        $this->authorize('update', $client);

        $client->update([
            'is_active' => !$client->is_active,
        ]);

        $status = $client->is_active ? 'ativado' : 'desativado';
        
        return redirect()
            ->back()
            ->with('success', "Cliente {$status} com sucesso!");
    }

    /**
     * Mostra histórico de atividades do cliente (para admin)
     */
    public function activity(Client $client)
    {
        $this->authorize('view', $client);

        // Downloads detalhados
        $downloads = ExamDownload::where('client_id', $client->id)
            ->with(['exam.examType', 'exam.pet'])
            ->latest('downloaded_at')
            ->paginate(50);

        // Estatísticas de atividade
        $activityStats = [
            'downloads_by_month' => ExamDownload::where('client_id', $client->id)
                ->selectRaw('DATE_FORMAT(downloaded_at, "%Y-%m") as month, COUNT(*) as count')
                ->groupBy('month')
                ->orderBy('month', 'desc')
                ->limit(12)
                ->pluck('count', 'month'),
                
            'downloads_by_day_of_week' => ExamDownload::where('client_id', $client->id)
                ->selectRaw('DAYOFWEEK(downloaded_at) as day_of_week, COUNT(*) as count')
                ->groupBy('day_of_week')
                ->pluck('count', 'day_of_week'),
                
            'downloads_by_hour' => ExamDownload::where('client_id', $client->id)
                ->selectRaw('HOUR(downloaded_at) as hour, COUNT(*) as count')
                ->groupBy('hour')
                ->pluck('count', 'hour'),
        ];

        return view('admin.clients.activity', compact('client', 'downloads', 'activityStats'));
    }

    /**
     * Reset senha do cliente (gerar nova data de nascimento temporária)
     */
    public function resetAccess(Client $client, Request $request)
    {
        $this->authorize('update', $client);

        // Desbloquear e resetar tentativas
        $client->update([
            'blocked_until' => null,
            'login_attempts' => 0,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Acesso do cliente resetado. Bloqueios removidos.');
    }

    /**
     * API: Buscar clientes para autocomplete
     */
    public function search(Request $request)
    {
        $query = Client::where('clinic_id', auth()->user()->clinic_id)
            ->where('is_active', true);

        if ($request->filled('term')) {
            $term = $request->term;
            $query->where(function($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('cpf', 'like', "%{$term}%");
            });
        }

        $clients = $query->select('id', 'name', 'cpf', 'email')
            ->limit(20)
            ->get()
            ->map(function($client) {
                return [
                    'id' => $client->id,
                    'label' => $client->name . ' (' . $client->cpf . ')',
                    'value' => $client->name,
                    'cpf' => $client->cpf,
                    'email' => $client->email,
                ];
            });

        return response()->json($clients);
    }

    /**
     * API: Estatísticas rápidas para dashboard
     */
    public function getStats()
    {
        $clinicId = auth()->user()->clinic_id;

        $stats = Cache::remember("admin_client_stats_{$clinicId}", 300, function() use ($clinicId) {
            return [
                'total_clients' => Client::where('clinic_id', $clinicId)->count(),
                'active_clients' => Client::where('clinic_id', $clinicId)->where('is_active', true)->count(),
                'blocked_clients' => Client::where('clinic_id', $clinicId)->whereNotNull('blocked_until')->count(),
                'clients_with_downloads' => Client::where('clinic_id', $clinicId)
                    ->whereHas('exams.downloads')->count(),
            ];
        });

        return response()->json($stats);
    }
}