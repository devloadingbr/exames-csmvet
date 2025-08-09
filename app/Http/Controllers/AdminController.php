<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Exam;
use App\Models\Pet;
use App\Models\ExamDownload;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $clinicId = auth()->user()->clinic_id;
        
        // Estatísticas da clínica
        $stats = [
            'total_clients' => Client::where('clinic_id', $clinicId)->count(),
            'total_pets' => Pet::where('clinic_id', $clinicId)->count(),
            'total_exams' => Exam::where('clinic_id', $clinicId)->count(),
            'exams_this_month' => Exam::where('clinic_id', $clinicId)
                                     ->whereMonth('created_at', now()->month)
                                     ->count(),
            'downloads_today' => ExamDownload::where('clinic_id', $clinicId)
                                             ->whereDate('downloaded_at', today())
                                             ->count(),
        ];

        // Exames recentes
        $recent_exams = Exam::with(['client', 'pet', 'examType'])
                           ->where('clinic_id', $clinicId)
                           ->latest()
                           ->take(5)
                           ->get();

        // Clínica atual
        $clinic = auth()->user()->clinic;

        return view('admin.dashboard', compact('stats', 'recent_exams', 'clinic'));
    }
}