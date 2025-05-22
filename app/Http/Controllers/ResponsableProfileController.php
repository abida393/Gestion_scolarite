<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ResponsableProfileController extends Controller
{
    public function showProfile()
    {
        $responsable = Auth::guard('responsable')->user();
        $formation = $responsable->formation;
        $profile = $responsable->profile;
        return view('responsable.profile-responsable', compact('responsable', 'formation', 'profile'));
    }

    // Ajoute cette méthode :
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $responsable = Auth::guard('responsable')->user();

        // Vérifie l'ancien mot de passe
        if (!\Hash::check($request->old_password, $responsable->password)) {
            return back()->withErrors(['old_password' => 'L\'ancien mot de passe est incorrect.'])->withInput();
        }

        $responsable->password = \Hash::make($request->password);
        $responsable->save();

        return back()->with('success', 'Mot de passe modifié avec succès.');
    }
}