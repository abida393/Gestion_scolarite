<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reponse;

class ChatbotController extends Controller
{
    public function repondre(Request $request)
    {
        $question = strtolower($request->input('question'));

        // Récupération de la réponse depuis la table "reponses"
        $reponseTrouvee = null;
        $reponses = Reponse::all();

        foreach ($reponses as $rep) {
            if (str_contains($question, strtolower($rep->mot_cle))) {
                $reponseTrouvee = $rep->reponse;
                break;
            }
        }

        if ($reponseTrouvee) {
            $reponse = $reponseTrouvee;
        } else {
            $reponse = "Je suis désolé, je n'ai pas compris votre question.";
        }

        // NE PAS enregistrer les messages dans la base
        return response()->json(['reponse' => $reponse]);
    }

    // Optionnel : si tu veux toujours voir l'historique (désactivé ici)
    public function messages()
    {
        return response()->json([]); // Renvoie une liste vide
    }
}
