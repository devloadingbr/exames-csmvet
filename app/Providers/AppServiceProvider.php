<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Exam;
use App\Models\ExamType;
use App\Models\Client;
use App\Models\Pet;
use App\Policies\ExamPolicy;
use App\Policies\ExamTypePolicy;
use App\Policies\ClientPolicy;
use App\Policies\PetPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Exam::class => ExamPolicy::class,
        ExamType::class => ExamTypePolicy::class,
        Client::class => ClientPolicy::class,
        Pet::class => PetPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register Storage Service
        $this->app->singleton(\App\Services\StorageService::class, function ($app) {
            return new \App\Services\StorageService();
        });

        // Register Download Service
        $this->app->singleton(\App\Services\DownloadService::class, function ($app) {
            return new \App\Services\DownloadService(
                $app->make(\App\Services\StorageService::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register policies
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }
}
