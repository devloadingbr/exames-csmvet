<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\Plan;
use App\Models\User;
use App\Http\Requests\StoreClinicRequest;
use App\Http\Requests\UpdateClinicRequest;
use App\Services\BillingService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ClinicController extends Controller
{
    protected $billingService;

    public function __construct(BillingService $billingService)
    {
        $this->billingService = $billingService;
    }

    /**
     * Lista todas as clínicas com filtros
     */
    public function index(Request $request)
    {
        $query = Clinic::with(['plan', 'users']);

        // Filtros
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        if ($request->filled('plan')) {
            $query->where('plan_id', $request->plan);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%")
                  ->orWhere('cnpj', 'ILIKE', "%{$search}%")
                  ->orWhere('email', 'ILIKE', "%{$search}%")
                  ->orWhere('city', 'ILIKE', "%{$search}%");
            });
        }

        $clinics = $query->latest()->paginate(20);
        $plans = Plan::where('is_active', true)->get();

        return view('superadmin.clinics.index', compact('clinics', 'plans'));
    }

    /**
     * Mostra formulário de criação de clínica
     */
    public function create()
    {
        $plans = Plan::where('is_active', true)->get();
        return view('superadmin.clinics.create', compact('plans'));
    }

    /**
     * Cria nova clínica
     */
    public function store(StoreClinicRequest $request)
    {
        $data = $request->validated();
        
        // Gerar slug único
        $data['slug'] = $this->generateUniqueSlug($data['name']);
        
        // Definir data de fim do trial (30 dias)
        $data['trial_ends_at'] = now()->addDays(30);
        $data['subscription_status'] = 'trial';
        $data['created_by'] = Auth::id();

        $clinic = Clinic::create($data);

        // Criar usuário gestor para a clínica
        if ($request->filled('manager_name') && $request->filled('manager_email')) {
            $manager = User::create([
                'name' => $request->manager_name,
                'email' => $request->manager_email,
                'password' => Hash::make($request->manager_password ?? 'temp123'),
                'role' => 'manager',
                'clinic_id' => $clinic->id,
                'is_active' => true,
            ]);
        }

        return redirect()->route('superadmin.clinics.show', $clinic)
                        ->with('success', 'Clínica criada com sucesso!');
    }

    /**
     * Mostra detalhes da clínica
     */
    public function show(Clinic $clinic)
    {
        return redirect()->route('superadmin.clinic-details', $clinic);
    }

    /**
     * Mostra formulário de edição
     */
    public function edit(Clinic $clinic)
    {
        $plans = Plan::where('is_active', true)->get();
        return view('superadmin.clinics.edit', compact('clinic', 'plans'));
    }

    /**
     * Atualiza clínica
     */
    public function update(UpdateClinicRequest $request, Clinic $clinic)
    {
        $data = $request->validated();
        
        // Atualizar slug se nome mudou
        if ($data['name'] !== $clinic->name) {
            $data['slug'] = $this->generateUniqueSlug($data['name'], $clinic->id);
        }

        $clinic->update($data);

        return redirect()->route('superadmin.clinics.show', $clinic)
                        ->with('success', 'Clínica atualizada com sucesso!');
    }

    /**
     * Suspende/ativa clínica
     */
    public function toggleStatus(Clinic $clinic)
    {
        $clinic->update([
            'is_active' => !$clinic->is_active
        ]);

        $status = $clinic->is_active ? 'ativada' : 'suspensa';
        
        return back()->with('success', "Clínica {$status} com sucesso!");
    }

    /**
     * Impersonate - acessa como gestor da clínica
     */
    public function impersonate(Clinic $clinic)
    {
        $manager = $clinic->users()->where('role', 'manager')->first();
        
        if (!$manager) {
            return back()->with('error', 'Clínica não possui gestor cadastrado.');
        }

        // Salvar ID do SuperAdmin na sessão
        session(['impersonating_from' => Auth::id()]);
        
        // Fazer login como gestor
        Auth::login($manager);
        
        return redirect()->route('admin.dashboard')
                        ->with('info', "Você está acessando como gestor da clínica {$clinic->name}");
    }

    /**
     * Volta para SuperAdmin após impersonate
     */
    public function stopImpersonating()
    {
        $superAdminId = session('impersonating_from');
        
        if ($superAdminId) {
            session()->forget('impersonating_from');
            $superAdmin = User::find($superAdminId);
            
            if ($superAdmin) {
                Auth::login($superAdmin);
                return redirect()->route('superadmin.dashboard')
                                ->with('success', 'Voltou para área SuperAdmin');
            }
        }
        
        return redirect()->route('superadmin.login');
    }

    /**
     * Gera fatura para clínica
     */
    public function generateBilling(Clinic $clinic, Request $request)
    {
        $month = $request->get('month') ? \Carbon\Carbon::parse($request->get('month')) : now();
        $invoice = $this->billingService->generateInvoice($clinic, $month);
        
        if (isset($invoice['error'])) {
            return back()->with('error', $invoice['error']);
        }
        
        // Aqui poderia salvar a fatura no banco de dados
        // Por enquanto, apenas retorna os dados
        
        return view('superadmin.clinics.invoice', compact('clinic', 'invoice'));
    }

    /**
     * Gera slug único para clínica
     */
    private function generateUniqueSlug(string $name, int $excludeId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (true) {
            $query = Clinic::where('slug', $slug);
            
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
            
            if (!$query->exists()) {
                break;
            }
            
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Exporta dados das clínicas
     */
    public function export(Request $request)
    {
        $query = Clinic::with(['plan', 'users']);

        // Aplicar mesmos filtros da listagem
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        if ($request->filled('plan')) {
            $query->where('plan_id', $request->plan);
        }

        $clinics = $query->get();

        // Retornar CSV simples
        $filename = 'clinicas_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($clinics) {
            $file = fopen('php://output', 'w');
            
            // Cabeçalho
            fputcsv($file, [
                'ID', 'Nome', 'CNPJ', 'Email', 'Cidade', 'Estado', 
                'Plano', 'Status', 'Criada em'
            ]);
            
            // Dados
            foreach ($clinics as $clinic) {
                fputcsv($file, [
                    $clinic->id,
                    $clinic->name,
                    $clinic->cnpj,
                    $clinic->email,
                    $clinic->city,
                    $clinic->state,
                    $clinic->plan->name ?? 'N/A',
                    $clinic->is_active ? 'Ativa' : 'Inativa',
                    $clinic->created_at->format('d/m/Y H:i'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
