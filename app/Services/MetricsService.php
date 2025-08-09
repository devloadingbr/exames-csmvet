<?php

namespace App\Services;

use App\Models\Clinic;
use App\Models\User;
use App\Models\Client;
use App\Models\Exam;
use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MetricsService
{
    /**
     * Obtém métricas do dashboard com mudanças percentuais
     */
    public function getDashboardMetrics(): array
    {
        $currentMonth = now();
        $previousMonth = now()->subMonth();

        // Métricas atuais
        $current = [
            'total_clinics' => Clinic::count(),
            'active_clinics' => Clinic::where('is_active', true)->count(),
            'total_revenue' => $this->calculateMonthlyRevenue($currentMonth),
            'total_exams' => Exam::whereMonth('created_at', $currentMonth->month)
                                ->whereYear('created_at', $currentMonth->year)
                                ->count(),
        ];

        // Métricas do mês anterior
        $previous = [
            'total_clinics' => Clinic::whereDate('created_at', '<=', $previousMonth->endOfMonth())->count(),
            'active_clinics' => Clinic::where('is_active', true)
                                     ->whereDate('created_at', '<=', $previousMonth->endOfMonth())
                                     ->count(),
            'total_revenue' => $this->calculateMonthlyRevenue($previousMonth),
            'total_exams' => Exam::whereMonth('created_at', $previousMonth->month)
                                ->whereYear('created_at', $previousMonth->year)
                                ->count(),
        ];

        // Calcula mudanças percentuais
        $metrics = [];
        foreach ($current as $key => $value) {
            $previousValue = $previous[$key] ?? 0;
            $change = $previousValue > 0 ? (($value - $previousValue) / $previousValue) * 100 : 0;
            
            $metrics[$key] = [
                'value' => $value,
                'change' => round($change, 1),
                'trend' => $change >= 0 ? 'up' : 'down'
            ];
        }

        return $metrics;
    }

    /**
     * Calcula receita mensal baseada nos planos das clínicas
     */
    private function calculateMonthlyRevenue(Carbon $month): float
    {
        return Clinic::where('clinics.is_active', true)
                    ->whereMonth('clinics.created_at', '<=', $month->month)
                    ->whereYear('clinics.created_at', '<=', $month->year)
                    ->join('plans', 'clinics.plan_id', '=', 'plans.id')
                    ->where('plans.is_active', true)
                    ->sum('plans.price_monthly');
    }

    /**
     * Obtém dados de receita dos últimos 6 meses para gráfico
     */
    public function getRevenueChartData(): array
    {
        $months = [];
        $revenues = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $months[] = $month->format('M/Y');
            $revenues[] = $this->calculateMonthlyRevenue($month);
        }

        return [
            'labels' => $months,
            'data' => $revenues
        ];
    }

    /**
     * Obtém estatísticas gerais do sistema
     */
    public function getSystemStats(): array
    {
        return [
            'total_users' => User::where('role', '!=', 'superadmin')->count(),
            'total_clients' => Client::count(),
            'total_pets' => DB::table('pets')->count(),
            'storage_used_gb' => $this->calculateStorageUsed(),
            'exams_this_month' => Exam::whereMonth('created_at', now()->month)->count(),
            'downloads_this_month' => DB::table('exam_downloads')
                                       ->whereMonth('downloaded_at', now()->month)
                                       ->count(),
        ];
    }

    /**
     * Calcula armazenamento usado (simulado - pode ser implementado com storage real)
     */
    private function calculateStorageUsed(): float
    {
        // Por enquanto, estima baseado no número de exames
        $examCount = Exam::count();
        return round($examCount * 2.5, 2); // Estima 2.5MB por exame
    }

    /**
     * Obtém clínicas com maior uso no mês
     */
    public function getTopClinicsThisMonth(): array
    {
        return Clinic::withCount(['exams' => function ($query) {
                        $query->whereMonth('created_at', now()->month);
                    }])
                    ->where('is_active', true)
                    ->orderBy('exams_count', 'desc')
                    ->take(5)
                    ->get()
                    ->map(function ($clinic) {
                        return [
                            'name' => $clinic->name,
                            'exams_count' => $clinic->exams_count,
                            'plan' => $clinic->plan->name ?? 'N/A',
                            'city' => $clinic->city,
                        ];
                    })
                    ->toArray();
    }

    /**
     * Obtém alertas de uso excessivo
     */
    public function getUsageAlerts(): array
    {
        $alerts = [];

        $clinics = Clinic::with('plan')->where('is_active', true)->get();

        foreach ($clinics as $clinic) {
            $monthlyExams = $clinic->exams()
                                  ->whereMonth('created_at', now()->month)
                                  ->count();

            $plan = $clinic->plan;
            if ($plan && $plan->max_exams_per_month > 0) {
                $usagePercent = ($monthlyExams / $plan->max_exams_per_month) * 100;

                if ($usagePercent >= 90) {
                    $alerts[] = [
                        'clinic_name' => $clinic->name,
                        'type' => 'exams_limit',
                        'usage_percent' => round($usagePercent, 1),
                        'current_usage' => $monthlyExams,
                        'limit' => $plan->max_exams_per_month,
                        'severity' => $usagePercent >= 100 ? 'critical' : 'warning'
                    ];
                }
            }
        }

        return $alerts;
    }
}
