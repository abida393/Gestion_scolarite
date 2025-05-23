<?php

namespace App\Http\Controllers;

use App\Models\etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index()
    {
        return view("authentification.welcome");
    }

    public function authenticate(Request $request){
        $credentials =  $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if(Auth::guard('etudiant')->attempt(['email_ecole' => $credentials['email'], 'password' => $credentials['password']])){
            $request->session()->regenerate();
            return redirect()->route('home');
        }elseif(Auth::guard('responsable')->attempt(['email_ecole' => $credentials['email'], 'password' => $credentials['password']])){
            $request->session()->regenerate();
            return redirect()->route('responsable.afficher_etudiant');
    }else{
        return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }
}
    public function mdpwrong()
    {
        return view("authentification.mdpwrong");
    }

    public function newmdp()
    {
        return view("authentification.newmdp");
    }
    public function admin()
    {
        return view("responsable.home");
    }
    public function logout(Request $request)
    {
        if (Auth::guard('etudiant')->check()) {
            Auth::guard('etudiant')->logout();
        } elseif (Auth::guard('responsable')->check()) {
            Auth::guard('responsable')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
