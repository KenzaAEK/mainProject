<?php

namespace App\Http\Controllers\api\password;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdatePasswordRequest as AuthUpdatePasswordRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordController extends Controller
{
    use HttpResponses;

    public function UpdatePassword(AuthUpdatePasswordRequest $request)
    {
        $user = auth()->user();
        if (!Hash::check($request->old_password, $user->password)) {
            return $this->error("", "Le mot de passe actuel est incorrect. Veuillez vérifier votre saisie.", 401);
        }
        $user->password = Hash::make($request->password);
        $user->save();
    
        return $this->success("", "Le mot de passe a été mis à jour avec succès.");
    }
}
