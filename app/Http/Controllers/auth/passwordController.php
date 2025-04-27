<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\etudiant;
use App\Models\responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;


class passwordController extends Controller
{
    public function showForgotForm()
    {
        return view('authentification.mdpwrong');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;
        // Check if the email belongs to an Etudiant
        if (etudiant::where('email_ecole', $email)->exists()) {
            $broker = 'etudiants';
            $emailField = 'email_ecole';
        }
        // Check if the email belongs to a Responsable
        elseif (responsable::where('email_ecole', $email)->exists()) {
            $broker = 'responsables';
            $emailField = 'email_ecole';
        } else {
            // Email not found
            return back()->withErrors(['email' => 'Aucun compte trouvé avec cet email.']);
        }

        $status = Password::broker($broker)->sendResetLink(
            ["email" => $email]
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}
