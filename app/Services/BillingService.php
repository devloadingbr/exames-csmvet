<?php

namespace App\Services;

use App\Models\Clinic;
use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BillingService
{
    /**
     * Verifica se uma clínica excedeu os limites do plano
     */
    public function checkPlanLimits(Clinic $clinic): array
    {
        $plan = $clinic->plan;
        if (!$plan) {
            return ['status' => 'no_plan', 'limits' => []];
        }

        $currentMonth = now();
        $limits = [];

        // Verifica limite de exames
        if ($plan->max_exams_per_month > 0) {
            $monthlyExams = $clinic->exams()
                                  ->whereMonth('created_at', $currentMonth->month)
                                  ->whereYear('created_at', $currentMonth->year)
                                  ->count();

            $limits['exams'] = [
                'current' => $monthlyExams,
                'limit' => $plan->max_exams_per_month,
                'percentage' => round(($monthlyExams / $plan->max_exams_per_month) * 100, 1),
                'exceeded' => $monthlyExams > $plan->max_exams_per_month
            ];
        }

        // Verifica limite de usuários
        if ($plan->max_users > 0) {
            $userCount = $clinic->users()->count();
            
            $limits['users'] = [
                'current' => $userCount,
                'limit' => $plan->max_users,
                'percentage' => round(($userCount / $plan->max_users) * 100, 1),
                'exceeded' => $userCount > $plan->max_users
            ];
        }

        // Verifica limite de clientes
        if ($plan->max_clients > 0) {
            $clientCount = $clinic->clients()->count();
            
            $limits['clients'] = [
                'current' => $clientCount,
                'limit' => $plan->max_clients,
                'percentage' => round(($clientCount / $plan->max_clients) * 100, 1),
                'exceeded' => $clientCount > $plan->max_clients
            ];
        }

        // Verifica limite de armazenamento (simulado)
        if ($plan->max_storage_gb > 0) {
            $storageUsed = $this->calculateClinicStorage($clinic);
            
            $limits['storage'] = [
                'current' => $storageUsed,
                'limit' => $plan->max_storage_gb,
                'percentage' => round(($storageUsed / $plan->max_storage_gb) * 100, 1),
                'exceeded' => $storageUsed > $plan->max_storage_gb
            ];
        }

        $hasExceeded = collect($limits)->contains('exceeded', true);

        return [
            'status' => $hasExceeded ? 'exceeded' : 'within_limits',
            'limits' => $limits
        ];
    }

    /**
     * Calcula armazenamento usado por uma clínica
     */
    private function calculateClinicStorage(Clinic $clinic): float
    {
        // Simulação - em produção, seria calculado baseado nos arquivos reais
        $examCount = $clinic->exams()->count();
        return round($examCount * 2.5, 2); // Estima 2.5MB por exame
    }

    /**
     * Gera fatura para uma clínica
     */
    public function generateInvoice(Clinic $clinic, Carbon $month = null): array
    {
        $month = $month ?? now();
        $plan = $clinic->plan;

        if (!$plan) {
            return ['error' => 'Clínica não possui plano ativo'];
        }

        $baseAmount = $plan->price_monthly;
        $overageCharges = $this->calculateOverageCharges($clinic, $month);
        
        $invoice = [
            'clinic_id' => $clinic->id,
            'clinic_name' => $clinic->name,
            'month' => $month->format('Y-m'),
            'plan_name' => $plan->name,
            'base_amount' => $baseAmount,
            'overage_charges' => $overageCharges,
            'total_amount' => $baseAmount + array_sum($overageCharges),
            'generated_at' => now(),
            'due_date' => now()->addDays(30),
        ];

        return $invoice;
    }

    /**
     * Calcula taxas de excesso de uso
     */
    private function calculateOverageCharges(Clinic $clinic, Carbon $month): array
    {
        $charges = [];
        $plan = $clinic->plan;
        
        // Taxa por excesso de exames (R$ 2,00 por exame extra)
        if ($plan->max_exams_per_month > 0) {
            $monthlyExams = $clinic->exams()
                                  ->whereMonth('created_at', $month->month)
                                  ->whereYear('created_at', $month->year)
                                  ->count();

            if ($monthlyExams > $plan->max_exams_per_month) {
                $extraExams = $monthlyExams - $plan->max_exams_per_month;
                $charges['extra_exams'] = $extraExams * 2.00;
            }
        }

        // Taxa por excesso de armazenamento (R$ 5,00 por GB extra)
        if ($plan->max_storage_gb > 0) {
            $storageUsed = $this->calculateClinicStorage($clinic);
            
            if ($storageUsed > $plan->max_storage_gb) {
                $extraStorage = $storageUsed - $plan->max_storage_gb;
                $charges['extra_storage'] = ceil($extraStorage) * 5.00;
            }
        }

        return $charges;
    }

    /**
     * Obtém relatório de faturamento mensal
     */
    public function getMonthlyBillingReport(Carbon $month = null): array
    {
        $month = $month ?? now();
        
        $clinics = Clinic::with('plan')
                        ->where('is_active', true)
                        ->get();

        $totalRevenue = 0;
        $totalOverage = 0;
        $clinicReports = [];

        foreach ($clinics as $clinic) {
            $invoice = $this->generateInvoice($clinic, $month);
            
            if (!isset($invoice['error'])) {
                $totalRevenue += $invoice['base_amount'];
                $totalOverage += array_sum($invoice['overage_charges']);
                $clinicReports[] = $invoice;
            }
        }

        return [
            'month' => $month->format('Y-m'),
            'total_revenue' => $totalRevenue,
            'total_overage' => $totalOverage,
            'grand_total' => $totalRevenue + $totalOverage,
            'clinic_count' => count($clinicReports),
            'clinics' => $clinicReports
        ];
    }

    /**
     * Obtém clínicas próximas dos limites (90%+)
     */
    public function getClinicsNearLimits(): array
    {
        $clinics = Clinic::with('plan')->where('is_active', true)->get();
        $nearLimits = [];

        foreach ($clinics as $clinic) {
            $limits = $this->checkPlanLimits($clinic);
            
            if ($limits['status'] !== 'no_plan') {
                foreach ($limits['limits'] as $type => $limit) {
                    if ($limit['percentage'] >= 90) {
                        $nearLimits[] = [
                            'clinic' => $clinic->name,
                            'limit_type' => $type,
                            'percentage' => $limit['percentage'],
                            'current' => $limit['current'],
                            'limit' => $limit['limit'],
                            'exceeded' => $limit['exceeded']
                        ];
                    }
                }
            }
        }

        return $nearLimits;
    }
}
