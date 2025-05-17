<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reponse;

class AdminChatbotController extends Controller
{
    public function index()
    {
        $reponses = Reponse::latest()->get();
        return view('responsable.chatbot', compact('reponses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mot_cle' => 'required|string|max:255',
            'reponse' => 'required|string',
        ]);

        Reponse::create([
            'mot_cle' => $request->mot_cle,
            'reponse' => $request->reponse,
        ]);

        return redirect()->route('chatbot')->with('success', 'Réponse ajoutée avec succès.');
    }

    public function destroy($id)
    {
        Reponse::findOrFail($id)->delete();
        return redirect()->route('chatbot')->with('success', 'Réponse supprimée avec succès.');
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'mot_cle' => 'required|string',
        'reponse' => 'required|string',
    ]);

    $reponse = Reponse::findOrFail($id);
    $reponse->mot_cle = $request->mot_cle;
    $reponse->reponse = $request->reponse;
    $reponse->save();

    return redirect()->route('chatbot')->with('success', 'Réponse mise à jour avec succès.');
}

}
