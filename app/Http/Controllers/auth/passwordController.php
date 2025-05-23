<?php

namespace App\Http\Controllers\Auth;

use App\Models\Etudiant;
use App\Models\Responsable;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class PasswordController extends Controller
{

    public function showForgotForm()
    {
        return view('authentification.mdpwrong');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = $request->email;
        $user = null;
        $broker = null;

        // Check both models with email_ecole
        if ($user = Etudiant::where('email_ecole', $email)->first()) {
            $broker = 'etudiants';
        } elseif ($user = Responsable::where('email_ecole', $email)->first()) {
            $broker = 'responsables';
        }

        if (!$user) {
            return back()->with(
                'status',
                'Si cet email existe dans notre système, un lien de réinitialisation a été envoyé.'
            );
        }

        // Manually handle token creation
        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        // Send notification with the plain token
        $user->sendPasswordResetNotification($token);

        return back()->with('status', 'Nous avons envoyé votre lien de réinitialisation par e-mail!');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('authentification.newmdp', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Find the token record
        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'Token invalide ou expiré']);
        }

        // Find user
        $user = Etudiant::where('email_ecole', $request->email)->first() ??
            Responsable::where('email_ecole', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Utilisateur non trouvé']);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('home.welcome')->with('status', 'Votre mot de passe a été réinitialisé!');
    }


}
