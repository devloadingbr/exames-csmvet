<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Pet;
use App\Models\Client;
use App\Models\ExamType;
use App\Http\Requests\StoreExamRequest;
use App\Http\Requests\UpdateExamRequest;
use App\Services\StorageService;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    protected $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
    }

    public function index(Request $request)
    {
        $query = Exam::with(['client', 'pet', 'examType'])
            ->where('clinic_id', auth()->user()->clinic_id);

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('exam_type_id')) {
            $query->where('exam_type_id', $request->exam_type_id);
        }

        if ($request->filled('period')) {
            switch ($request->period) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case '7days':
                    $query->where('created_at', '>=', now()->subDays(7));
                    break;
                case '30days':
                    $query->where('created_at', '>=', now()->subDays(30));
                    break;
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhereHas('pet', function ($petQuery) use ($search) {
                      $petQuery->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('client', function ($clientQuery) use ($search) {
                      $clientQuery->where('name', 'like', "%{$search}%")
                                  ->orWhere('cpf', 'like', "%{$search}%");
                  });
            });
        }

        $exams = $query->latest()->paginate(20);

        // Para os filtros
        $examTypes = ExamType::where('clinic_id', auth()->user()->clinic_id)
            ->orderBy('name')
            ->get();

        return view('admin.exams.index', compact('exams', 'examTypes'));
    }

    public function create()
    {
        $examTypes = ExamType::where('clinic_id', auth()->user()->clinic_id)
            ->orderBy('name')
            ->get();

        $pets = Pet::with('client')
            ->where('clinic_id', auth()->user()->clinic_id)
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.exams.create', compact('examTypes', 'pets'));
    }

    public function store(StoreExamRequest $request)
    {
        try {
            $validated = $request->validated();

            // Log da tentativa de criação
            \Log::info('Tentativa de criação de exame', [
                'user_id' => auth()->id(),
                'clinic_id' => auth()->user()->clinic_id,
                'client_id' => $validated['client_id'],
                'pet_id' => $validated['pet_id'],
                'exam_type_id' => $validated['exam_type_id'],
            ]);

            // Upload do arquivo com validação
            $file = $request->file('exam_file');
            if (!$file || !$file->isValid()) {
                \Log::error('Arquivo inválido no upload', [
                    'file_error' => $file ? $file->getError() : 'null',
                    'user_id' => auth()->id()
                ]);
                return back()
                    ->withInput()
                    ->withErrors(['exam_file' => 'Erro no upload do arquivo. Tente novamente.']);
            }

            $filePath = $this->storageService->store($file, 'exams');

            // Criar o exame (codigo será gerado automaticamente)
            $exam = Exam::create([
                'clinic_id' => auth()->user()->clinic_id,
                'client_id' => $validated['client_id'],
                'pet_id' => $validated['pet_id'],
                'exam_type_id' => $validated['exam_type_id'],
                'description' => $validated['description'],
                'exam_date' => $validated['exam_date'],
                'veterinarian_name' => $validated['veterinarian_name'],
                'veterinarian_crmv' => $validated['veterinarian_crmv'],
                'original_filename' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'file_size_bytes' => $file->getSize(),
                'file_hash' => hash_file('sha256', $file->getRealPath()),
                'storage_disk' => config('filesystems.default'),
                'status' => 'ready',
                'uploaded_by' => auth()->id(),
            ]);

            // Verificar se código foi gerado
            if (empty($exam->codigo)) {
                \Log::error('Exame criado sem código', [
                    'exam_id' => $exam->id,
                    'user_id' => auth()->id(),
                    'clinic_id' => auth()->user()->clinic_id
                ]);
                
                // Tentar regenerar o código
                $exam->codigo = Exam::generateCodigo();
                $exam->save();
                
                if (empty($exam->codigo)) {
                    return back()
                        ->withInput()
                        ->withErrors(['error' => 'Erro interno: não foi possível gerar código do exame.']);
                }
            }

            \Log::info('Exame criado com sucesso', [
                'exam_id' => $exam->id,
                'codigo' => $exam->codigo,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('admin.exams.show', $exam->codigo)
                ->with('success', "Exame {$exam->codigo} criado com sucesso!");

        } catch (\Exception $e) {
            \Log::error('Erro ao criar exame', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
                'clinic_id' => auth()->user()->clinic_id,
                'form_data' => $request->except(['exam_file', '_token'])
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Erro ao criar exame. Verifique os dados e tente novamente.']);
        }
    }

    public function show(Exam $exam)
    {
        $this->authorize('view', $exam);
        
        $exam->load(['client', 'pet', 'examType', 'downloads.client']);

        return view('admin.exams.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        $this->authorize('update', $exam);

        $examTypes = ExamType::where('clinic_id', auth()->user()->clinic_id)
            ->orderBy('name')
            ->get();

        return view('admin.exams.edit', compact('exam', 'examTypes'));
    }

    public function update(UpdateExamRequest $request, Exam $exam)
    {
        $this->authorize('update', $exam);

        $validated = $request->validated();
        $exam->update($validated);

        return redirect()->route('admin.exams.show', $exam->codigo)
            ->with('success', 'Exame atualizado com sucesso!');
    }

    public function destroy(Exam $exam)
    {
        $this->authorize('delete', $exam);

        // Remover arquivo do storage
        $this->storageService->delete($exam->file_path);
        
        $exam->delete();

        return redirect()->route('admin.exams.index')
            ->with('success', 'Exame removido com sucesso!');
    }

    public function download(Exam $exam)
    {
        $this->authorize('view', $exam);

        return $this->storageService->download($exam->file_path, $exam->original_filename);
    }

    // API para busca de pets (AJAX)
    public function searchPets(Request $request)
    {
        $search = $request->get('q');
        $clientId = $request->get('client_id');
        
        $query = Pet::with('client')
            ->where('clinic_id', auth()->user()->clinic_id);
            
        // Filtrar por cliente se especificado
        if ($clientId) {
            $query->where('client_id', $clientId);
        }
        
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('client', function ($clientQuery) use ($search) {
                      $clientQuery->where('name', 'like', "%{$search}%")
                                  ->orWhere('cpf', 'like', "%{$search}%");
                  });
            });
        }
        
        $pets = $query->limit(20)->get();

        return response()->json($pets);
    }

    // API para busca de clientes (AJAX)
    public function searchClients(Request $request)
    {
        $search = $request->get('q');
        
        if (!$search || strlen($search) < 2) {
            return response()->json([]);
        }
        
        $clients = Client::where('clinic_id', auth()->user()->clinic_id)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('cpf', 'like', "%{$search}%") 
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
            })
            ->withCount('pets')
            ->orderBy('name')
            ->limit(10)
            ->get();

        return response()->json($clients);
    }
}