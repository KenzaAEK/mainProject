<?php

namespace App\Providers;

use App\Models\Devis;
use App\Models\Facture;
use App\Models\Notification;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('download-facture', function ($user, $factureId) {
            $facture = Facture::findOrFail($factureId);
            return $facture->notification->idUser === $user->idUser;
        });
        
        
        Gate::define('manage-devis', function ($user, Devis $devis) {
            return $user->idUser === $devis->demandeInscription->tuteur->idUser;
        });
    }
}
