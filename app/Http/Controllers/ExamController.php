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
        $validated = $request->validated();

        // Upload do arquivo
        $file = $request->file('exam_file');
        $filePath = $this->storageService->store($file, 'exams');

        // Criar o exame
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

        return redirect()->route('admin.exams.show', $exam->codigo)
            ->with('success', "Exame {$exam->codigo} enviado com sucesso!");
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
        
        $pets = Pet::with('client')
            ->where('clinic_id', auth()->user()->clinic_id)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhereHas('client', function ($clientQuery) use ($search) {
                          $clientQuery->where('name', 'like', "%{$search}%")
                                      ->orWhere('cpf', 'like', "%{$search}%");
                      });
            })
            ->limit(10)
            ->get();

        return response()->json($pets);
    }
}