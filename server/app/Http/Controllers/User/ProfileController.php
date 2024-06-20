<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Requests\Auth\UploadImageRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ProfileController extends Controller
{
    use HttpResponses;
    public function profile()
    {
        $user = Auth::user();
        return response()->json([
            'user' => $user,
        ]);
    }

    public function updateProfile( UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->tel = $request->tel;
        $user->save();

        return response()->json([
            'message' => 'Profil mis à jour avec succès.',
            'user' => $user,
        ]);
    }

    public function uploadImage(UploadImageRequest $request)
{
    $user = auth()->user();

    if ($request->hasFile('image')) {
        $file = $request->image;
        $image_name = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $image_name);

        if ($user->photo) {
            $oldImagePath = public_path('uploads/' . $user->photo);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        $user->photo = $image_name;
        $result = $user->save();

        if ($result) {
            return $this->success("", "Image uploadée avec succès.");
        }
    }

    return $this->error('', 'Aucune image fournie.', 400);
}

   

    
}