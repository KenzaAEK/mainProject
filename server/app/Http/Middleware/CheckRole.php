<?php

namespace App\Http\Middleware;

use App\Traits\HttpResponses;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    use HttpResponses;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role == $role) {
                return $next($request);
            }
        }

        // Rediriger ou renvoyer une réponse d'erreur si l'utilisateur n'est pas adiministrateur
        return $this->error('','ACCES INTERDIT ',403);
    }
}
