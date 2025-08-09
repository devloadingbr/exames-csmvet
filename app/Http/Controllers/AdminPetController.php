<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Client;
use App\Http\Requests\StorePetRequest;
use App\Http\Requests\UpdatePetRequest;
use Illuminate\Http\Request;

class AdminPetController extends Controller
{
    public function index(Request $request)
    {
        $query = Pet::with(['client'])
            ->where('clinic_id', auth()->user()->clinic_id)
            ->withCount(['exams']);

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('species', 'like', "%{$search}%")
                  ->orWhere('breed', 'like', "%{$search}%")
                  ->orWhereHas('client', function ($clientQuery) use ($search) {
                      $clientQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('species')) {
            $query->where('species', $request->species);
        }

        $pets = $query->latest()->paginate(20);

        // Para filtros
        $species = Pet::where('clinic_id', auth()->user()->clinic_id)
            ->distinct()
            ->pluck('species')
            ->filter()
            ->sort();

        return view('admin.pets.index', compact('pets', 'species'));
    }

    public function create(Request $request)
    {
        $clientId = $request->get('client_id');
        $client = null;
        
        if ($clientId) {
            $client = Client::where('clinic_id', auth()->user()->clinic_id)
                ->findOrFail($clientId);
        }

        $clients = Client::where('clinic_id', auth()->user()->clinic_id)
            ->orderBy('name')
            ->get();

        return view('admin.pets.create', compact('clients', 'client'));
    }

    public function store(StorePetRequest $request)
    {
        $validated = $request->validated();
        $validated['clinic_id'] = auth()->user()->clinic_id;

        $pet = Pet::create($validated);

        // Retornar JSON se solicitado via AJAX
        if (request()->wantsJson()) {
            $pet->load('client');
            return response()->json([
                'success' => true,
                'pet' => $pet,
                'message' => 'Pet cadastrado com sucesso!'
            ]);
        }

        if ($request->filled('redirect_to')) {
            return redirect($request->redirect_to)
                ->with('success', 'Pet cadastrado com sucesso!');
        }

        return redirect()
            ->route('admin.clients.show', $pet->client)
            ->with('success', 'Pet cadastrado com sucesso!');
    }

    public function show(Pet $pet)
    {
        $this->authorize('view', $pet);
        
        $pet->load(['client', 'exams.examType']);
        
        return view('admin.pets.show', compact('pet'));
    }

    public function edit(Pet $pet)
    {
        $this->authorize('update', $pet);
        
        $clients = Client::where('clinic_id', auth()->user()->clinic_id)
            ->orderBy('name')
            ->get();

        return view('admin.pets.edit', compact('pet', 'clients'));
    }

    public function update(UpdatePetRequest $request, Pet $pet)
    {
        $this->authorize('update', $pet);

        $pet->update($request->validated());

        return redirect()
            ->route('admin.clients.show', $pet->client)
            ->with('success', 'Pet atualizado com sucesso!');
    }

    public function destroy(Pet $pet)
    {
        $this->authorize('delete', $pet);

        // Verificar se tem exames
        $examCount = $pet->exams()->count();
        
        if ($examCount > 0) {
            return redirect()
                ->back()
                ->with('error', "Não é possível excluir pet com exames cadastrados. Total: {$examCount}");
        }

        $client = $pet->client;
        $pet->delete();

        return redirect()
            ->route('admin.clients.show', $client)
            ->with('success', 'Pet removido com sucesso!');
    }

    public function createForClient(Client $client)
    {
        $this->authorize('view', $client);
        
        $clients = Client::where('clinic_id', auth()->user()->clinic_id)
            ->orderBy('name')
            ->get();

        return view('admin.pets.create', compact('clients', 'client'));
    }

    // API para busca AJAX
    public function search(Request $request)
    {
        $search = $request->get('q', '');
        $clientId = $request->get('client_id');
        
        $query = Pet::with('client')
            ->where('clinic_id', auth()->user()->clinic_id);
            
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
}