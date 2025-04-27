<?php

namespace App\Http\Controllers;

use App\Models\etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $etudiant = Auth::guard('etudiant')->id();
            return redirect()->route('home')->with('etudiant', $etudiant);
        }elseif(Auth::guard('responsable')->attempt(['email_ecole' => $credentials['email'], 'password' => $credentials['password']])){
            $request->session()->regenerate();
            return redirect()->route('admin');
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
}
