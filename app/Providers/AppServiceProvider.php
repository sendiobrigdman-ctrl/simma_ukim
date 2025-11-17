<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Lowongan;
use App\Models\Aplikasi;
use App\Models\Logbook;
use App\Policies\LowonganPolicy;
use App\Policies\AplikasiPolicy;
use App\Policies\LogbookPolicy;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Lowongan::class => LowonganPolicy::class,
        Aplikasi::class => AplikasiPolicy::class,
        Logbook::class => LogbookPolicy::class,
    ];

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
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }
}
