<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\stage;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    
    public function index()
    {
        $absences = DB::table('absences')
            ->join('seances', 'absences.seance_id', '=', 'seances.id')
            ->join('matieres', 'seances.matiere_id', '=', 'matieres.id')
            ->select(
                'absences.id as absence_id',
                'absences.date_justif',
                'absences.justifier',
                'absences.justification',
                'seances.date_seance',
                'seances.heure_debut',
                'seances.heure_fin',
                'matieres.nom_matiere'
            )
            ->get();
// Puis on envoie les données à la vue
return view('absence', compact('absences'));
        return view("authentification.welcome");
    }

    public function mdpwrong()
    {
        return view("authentification.mdpwrong");
    }

    public function newmdp()
    {
        return view("authentification.newmdp");
    }

    public function calendar()
    {
        return view("calender.calendar");
    }

    public function home(){
        return view("pages.Home");
    }
    public function calendrier(){
        return view("pages.Calendrier");
    }
    public function notes(){
        return view("pages.Notes");
    }
    public function demande_documents(){
        return view("pages.Demande_documents");
    }
    public function absence_justif(){
        $absences = \App\Models\etudiant_absence::all();
        return view("pages.Absence_justif", compact('absences'));
    }
    public function stages(){
        $stages = Stage::all();
        return view("pages.Stages", compact('stages'));
    }
    public function aide(){
        return view("pages.Aide");
    }
}

class HomeController extends Controller
{
    public function welcome()
    {
        return view('authentification.welcome');
    }
}
