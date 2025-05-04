<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reponse;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    public function repondre(Request $request)
    {
        $question = strtolower($request->input('question'));

        $reponseTrouvee = null;
        $reponses = Reponse::all();

        foreach ($reponses as $rep) {
            $motCle = strtolower($rep->mot_cle);
            $motCleSingulier = Str::singular($motCle);
            $motClePluriel = Str::plural($motCle);

            if (
                str_contains($question, $motCle) ||
                str_contains($question, $motCleSingulier) ||
                str_contains($question, $motClePluriel)
            ) {
                $reponseTrouvee = $rep->reponse;
                break;
            }
        }

        if ($reponseTrouvee) {
            $reponse = $reponseTrouvee;
        } else {
            $reponse = "Je suis désolé, je n'ai pas compris votre question.";
        }

        return response()->json(['reponse' => $reponse]);
    }

    public function messages()
    {
        return response()->json([]);
    }
}
