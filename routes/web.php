<?php

use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', [App\Http\Controllers\LandingController::class, 'index'])->name('landing');
Route::post('/trial-signup', [App\Http\Controllers\LandingController::class, 'trialSignup'])->name('landing.trial');

// SuperAdmin Routes
Route::prefix('superadmin')->group(function () {
    Route::get('/login', function () {
        return view('auth.superadmin-login');
    })->name('superadmin.login');
    
    Route::post('/login', 'App\Http\Controllers\SuperAdminAuthController@login');
    
    Route::middleware(['auth', 'role:superadmin'])->group(function () {
        Route::get('/dashboard', 'App\Http\Controllers\SuperAdminController@dashboard')->name('superadmin.dashboard');
        Route::post('/logout', 'App\Http\Controllers\SuperAdminAuthController@logout')->name('superadmin.logout');
        
        // Gestão de Clínicas
        Route::resource('clinics', 'App\Http\Controllers\ClinicController', [
            'as' => 'superadmin'
        ]);
        
        // Rotas adicionais para clínicas
        Route::post('/clinics/{clinic}/toggle-status', 'App\Http\Controllers\ClinicController@toggleStatus')
            ->name('superadmin.clinics.toggle-status');
        Route::post('/clinics/{clinic}/impersonate', 'App\Http\Controllers\ClinicController@impersonate')
            ->name('superadmin.clinics.impersonate');
        Route::get('/clinics/{clinic}/billing', 'App\Http\Controllers\ClinicController@generateBilling')
            ->name('superadmin.clinics.billing');
        Route::get('/clinics/export', 'App\Http\Controllers\ClinicController@export')
            ->name('superadmin.clinics.export');
        
        // Detalhes da clínica
        Route::get('/clinic-details/{clinic}', 'App\Http\Controllers\SuperAdminController@clinicDetails')
            ->name('superadmin.clinic-details');
        
        // Relatórios
        Route::get('/billing-report', 'App\Http\Controllers\SuperAdminController@billingReport')
            ->name('superadmin.billing-report');
        
        // Voltar do impersonate
        Route::post('/stop-impersonating', 'App\Http\Controllers\ClinicController@stopImpersonating')
            ->name('superadmin.stop-impersonating');
    });
});

// Admin/Gestor Routes  
Route::prefix('admin')->group(function () {
    Route::get('/login', function () {
        return view('auth.admin-login');
    })->name('admin.login');
    
    Route::post('/login', 'App\Http\Controllers\AdminAuthController@login');
    
    Route::middleware(['auth', 'tenant', 'role:manager'])->group(function () {
        Route::get('/dashboard', 'App\Http\Controllers\AdminController@dashboard')->name('admin.dashboard');
        Route::post('/logout', 'App\Http\Controllers\AdminAuthController@logout')->name('admin.logout');
        
        // Tipos de Exame
        Route::resource('exam-types', 'App\Http\Controllers\ExamTypeController', [
            'as' => 'admin'
        ]);
        
        // Exames
        Route::resource('exams', 'App\Http\Controllers\ExamController', [
            'as' => 'admin',
            'parameters' => ['exams' => 'exam:codigo']
        ]);
        
        // Rotas adicionais para exames
        Route::get('/exams/{exam:codigo}/download', 'App\Http\Controllers\ExamController@download')
            ->name('admin.exams.download');
        Route::get('/api/pets/search', 'App\Http\Controllers\ExamController@searchPets')
            ->name('admin.pets.search');
        Route::get('/api/clients/search', 'App\Http\Controllers\ExamController@searchClients')
            ->name('admin.clients.search');
            
        // Clientes
        Route::resource('clients', 'App\Http\Controllers\AdminClientController', [
            'as' => 'admin'
        ]);
        
        // Client management actions
        Route::post('/clients/{client}/block', 'App\Http\Controllers\AdminClientController@block')->name('admin.clients.block');
        Route::post('/clients/{client}/unblock', 'App\Http\Controllers\AdminClientController@unblock')->name('admin.clients.unblock');
        Route::post('/clients/{client}/toggle-status', 'App\Http\Controllers\AdminClientController@toggleStatus')->name('admin.clients.toggle-status');
        Route::post('/clients/{client}/reset-access', 'App\Http\Controllers\AdminClientController@resetAccess')->name('admin.clients.reset-access');
        Route::get('/clients/{client}/activity', 'App\Http\Controllers\AdminClientController@activity')->name('admin.clients.activity');
        
        // Client API endpoints
        Route::get('/api/clients/search', 'App\Http\Controllers\AdminClientController@search')->name('admin.clients.search');
        Route::get('/api/clients/stats', 'App\Http\Controllers\AdminClientController@getStats')->name('admin.clients.stats');
        
        // Pets
        Route::resource('pets', 'App\Http\Controllers\AdminPetController', [
            'as' => 'admin'
        ]);
        Route::get('/clients/{client}/pets/create', 'App\Http\Controllers\AdminPetController@createForClient')
            ->name('admin.clients.pets.create');
        Route::get('/api/pets/search-ajax', 'App\Http\Controllers\AdminPetController@search')
            ->name('admin.pets.search-ajax');
    });
});

// Client Routes
Route::prefix('client')->group(function () {
    Route::get('/login', function () {
        return view('auth.client-login');
    })->name('client.login');
    
    Route::post('/login', 'App\Http\Controllers\ClientAuthController@login');
    
    Route::middleware(['auth:client'])->group(function () {
        // Dashboard
        Route::get('/dashboard', 'App\Http\Controllers\ClientController@dashboard')->name('client.dashboard');
        Route::post('/logout', 'App\Http\Controllers\ClientAuthController@logout')->name('client.logout');
        
        // Exams
        Route::get('/exams/{exam:codigo}', 'App\Http\Controllers\ClientExamController@show')->name('client.exams.show');
        Route::get('/exams/{exam:codigo}/download', 'App\Http\Controllers\ClientExamController@download')->name('client.exams.download');
        Route::get('/exams/{exam:codigo}/status', 'App\Http\Controllers\ClientExamController@checkDownloadStatus')->name('client.exams.status');
        
        // API routes for AJAX
        Route::get('/api/exams/search', 'App\Http\Controllers\ClientExamController@search')->name('client.api.exams.search');
        Route::get('/api/pets', 'App\Http\Controllers\ClientExamController@getPets')->name('client.api.pets');
        Route::get('/api/stats', 'App\Http\Controllers\ClientExamController@getStats')->name('client.api.stats');
        
        // Profile
        Route::get('/profile', 'App\Http\Controllers\ClientProfileController@show')->name('client.profile.show');
        Route::get('/profile/edit', 'App\Http\Controllers\ClientProfileController@edit')->name('client.profile.edit');
        Route::put('/profile', 'App\Http\Controllers\ClientProfileController@update')->name('client.profile.update');
        Route::get('/profile/activity', 'App\Http\Controllers\ClientProfileController@activity')->name('client.profile.activity');
        Route::get('/profile/help', 'App\Http\Controllers\ClientProfileController@help')->name('client.profile.help');
        Route::get('/profile/privacy', 'App\Http\Controllers\ClientProfileController@privacy')->name('client.profile.privacy');
        
        // Profile API routes
        Route::get('/api/profile', 'App\Http\Controllers\ClientProfileController@getClientData')->name('client.api.profile');
        Route::post('/api/profile/notifications', 'App\Http\Controllers\ClientProfileController@updateNotifications')->name('client.profile.notifications');
    });
});
