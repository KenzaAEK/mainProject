<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use App\Models\Devis;
use App\Models\Facture;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
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

        // from verify email
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            $spaUrl = "http://spa.test?email_verify_url=".$url;

            return (new MailMessage)
                ->subject('Vérifier l\'adresse e-mail')
                ->line('Cliquez sur le bouton ci-dessous pour vérifier votre adresse e-mail.')
                ->action('Vérifier l\'adresse e-mail', $spaUrl);
        }); // <- Ajout de cette accolade fermante

        Gate::define('download-facture', function ($user, $factureId) {
            $facture = Facture::findOrFail($factureId);
            return $facture->notification->idUser === $user->idUser;
        });

        Gate::define('manage-devis', function ($user, Devis $devis) {
            return $user->idUser === $devis->demandeInscription->tuteur->idUser;
        });
    }
}
