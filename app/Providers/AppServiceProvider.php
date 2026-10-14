<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\MedicalCase;
use App\Policies\MedicalCasePolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(MedicalCase::class, MedicalCasePolicy::class);
        Paginator::useTailwind();
    }
}
