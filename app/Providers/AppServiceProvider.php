<?php

namespace App\Providers;

use App\Models\etudiant;
use App\Models\responsable;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

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
        Relation::morphMap([
            'etudiant' => etudiant::class,
            'responsable' => responsable::class,
        ]);
    }
}
