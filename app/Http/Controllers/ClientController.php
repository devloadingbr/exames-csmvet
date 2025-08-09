<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamDownload;
use App\Models\ExamType;
use App\Services\DownloadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ClientController extends Controller
{
    protected DownloadService $downloadService;

    public function __construct(DownloadService $downloadService)
    {
        $this->downloadService = $downloadService;
    }

    public function dashboard(Request $request)
    {
        $client = auth()->guard('client')->user();
        
        // Build query with filters
        $query = Exam::with(['pet', 'examType'])
            ->where('client_id', $client->id)
            ->where('status', 'ready')
            ->where('is_active', true);

        // Apply filters
        if ($request->filled('pet_id')) {
            $query->where('pet_id', $request->pet_id);
        }

        if ($request->filled('exam_type_id')) {
            $query->where('exam_type_id', $request->exam_type_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('exam_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('exam_date', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('result_summary', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'exam_date');
        $sortDirection = $request->get('sort_direction', 'desc');

        if (in_array($sortBy, ['exam_date', 'codigo', 'created_at'])) {
            $query->orderBy($sortBy, $sortDirection);
        } else {
            $query->latest('exam_date');
        }

        // Pagination
        $perPage = min($request->get('per_page', 12), 24);
        $exams = $query->paginate($perPage);
        $exams->withQueryString(); // Preserve filter parameters in pagination

        // Enhanced statistics
        $stats = Cache::remember("client_dashboard_stats_{$client->id}", 300, function() use ($client) {
            $allExams = $client->exams()->where('status', 'ready')->where('is_active', true);
            $downloadStats = $this->downloadService->getClientDownloadStats($client);
            
            return [
                'total_exams' => $allExams->count(),
                'exams_this_month' => $allExams->whereMonth('exam_date', now()->month)
                                            ->whereYear('exam_date', now()->year)
                                            ->count(),
                'pets_with_exams' => $allExams->distinct('pet_id')->count('pet_id'),
                'total_downloads' => $downloadStats['total_downloads'],
                'downloads_today' => $downloadStats['downloads_today'],
                'downloads_this_month' => $downloadStats['downloads_this_month'],
                'last_download' => $downloadStats['last_download'],
            ];
        });

        // Get filter options
        $filterOptions = [
            'pets' => $client->pets()->orderBy('name')->get(['id', 'name']),
            'examTypes' => ExamType::where('clinic_id', $client->clinic_id)
                                  ->orderBy('name')
                                  ->get(['id', 'name', 'color']),
        ];

        // Get current filters for display
        $currentFilters = [
            'pet_id' => $request->get('pet_id'),
            'exam_type_id' => $request->get('exam_type_id'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
            'search' => $request->get('search'),
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'per_page' => $perPage,
        ];

        return view('client.dashboard', compact(
            'exams', 
            'stats', 
            'client', 
            'filterOptions', 
            'currentFilters'
        ));
    }
}