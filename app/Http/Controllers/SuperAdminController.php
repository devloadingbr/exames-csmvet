<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\User;
use App\Models\Client;
use App\Models\Exam;
use App\Models\Plan;
use App\Services\MetricsService;
use App\Services\BillingService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SuperAdminController extends Controller
{
    protected $metricsService;
    protected $billingService;

    public function __construct(MetricsService $metricsService, BillingService $billingService)
    {
        $this->metricsService = $metricsService;
        $this->billingService = $billingService;
    }

    public function dashboard()
    {
        // Métricas avançadas com mudanças percentuais
        $metrics = $this->metricsService->getDashboardMetrics();
        
        // Dados para gráfico de receita
        $revenueChart = $this->metricsService->getRevenueChartData();
        
        // Estatísticas do sistema
        $systemStats = $this->metricsService->getSystemStats();
        
        // Clínicas com maior uso no mês
        $topClinics = $this->metricsService->getTopClinicsThisMonth();
        
        // Alertas de uso
        $usageAlerts = $this->metricsService->getUsageAlerts();
        
        // Clínicas mais recentes
        $recent_clinics = Clinic::with('plan')
                                ->latest()
                                ->take(5)
                                ->get();

        // Distribuição por planos
        $plans_distribution = Plan::withCount('clinics')->get();
        
        // Clínicas próximas dos limites
        $clinicsNearLimits = $this->billingService->getClinicsNearLimits();

        return view('superadmin.dashboard', compact(
            'metrics', 
            'revenueChart', 
            'systemStats', 
            'topClinics', 
            'usageAlerts',
            'recent_clinics', 
            'plans_distribution',
            'clinicsNearLimits'
        ));
    }

    /**
     * Relatório de faturamento mensal
     */
    public function billingReport(Request $request)
    {
        $month = $request->get('month') ? Carbon::parse($request->get('month')) : now();
        $report = $this->billingService->getMonthlyBillingReport($month);
        
        return view('superadmin.billing-report', compact('report', 'month'));
    }

    /**
     * Detalhes de uma clínica específica
     */
    public function clinicDetails(Clinic $clinic)
    {
        $clinic->load(['plan', 'users', 'clients', 'exams' => function($query) {
            $query->latest()->take(10);
        }]);
        
        // Verificar limites do plano
        $planLimits = $this->billingService->checkPlanLimits($clinic);
        
        // Métricas da clínica no mês atual
        $monthlyStats = [
            'exams_count' => $clinic->exams()->whereMonth('created_at', now()->month)->count(),
            'clients_count' => $clinic->clients()->count(),
            'users_count' => $clinic->users()->count(),
            'revenue' => $clinic->plan ? $clinic->plan->price_monthly : 0,
        ];
        
        // Atividades recentes (simulado - pode ser implementado com logs reais)
        $recentActivities = $this->getClinicRecentActivities($clinic);
        
        return view('superadmin.clinic-details', compact(
            'clinic', 
            'planLimits', 
            'monthlyStats', 
            'recentActivities'
        ));
    }

    /**
     * Simula atividades recentes da clínica
     */
    private function getClinicRecentActivities(Clinic $clinic): array
    {
        $activities = [];
        
        // Últimos exames
        $recentExams = $clinic->exams()->latest()->take(5)->get();
        foreach ($recentExams as $exam) {
            $activities[] = [
                'type' => 'exam_created',
                'description' => "Exame {$exam->codigo} criado para {$exam->pet->name}",
                'created_at' => $exam->created_at,
                'icon' => '🔬'
            ];
        }
        
        // Últimos clientes
        $recentClients = $clinic->clients()->latest()->take(3)->get();
        foreach ($recentClients as $client) {
            $activities[] = [
                'type' => 'client_registered',
                'description' => "Cliente {$client->name} cadastrado",
                'created_at' => $client->created_at,
                'icon' => '👤'
            ];
        }
        
        // Ordenar por data
        usort($activities, function($a, $b) {
            return $b['created_at'] <=> $a['created_at'];
        });
        
        return array_slice($activities, 0, 10);
    }
}