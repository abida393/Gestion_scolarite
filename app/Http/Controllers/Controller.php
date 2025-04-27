<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function calendar()
    {
        return view("calender.calendar");
    }

    public function home(){
        return view("etudiant.Home");
    }
    public function calendrier(){
        return view("etudiant.Calendrier");
    }
    public function notes(){
        return view("etudiant.Notes");
    }
    public function demande_documents(){
        return view("etudiant.Demande_documents");
    }
    public function absence_justif(){
        return view("etudiant.Absence_justif");
    }
    public function stages(){
        return view("etudiant.Stages");
    }
    public function aide(){
        return view("etudiant.Aide");
    }
    public function paiement(){
        return view("etudiant.paiement");
    }
    public function emploi(){
        return view("etudiant.emploi");
    }
    public function messagerie(){
        return view("etudiant.messagerie");
    }
    public function news(){
        return view("etudiant.news");
}

}
