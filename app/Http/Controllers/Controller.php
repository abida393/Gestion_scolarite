<?php

namespace App\Http\Controllers;

use App\Models\classe;
use App\Models\emplois_temps;
use App\Models\etudiant;
use App\Models\etudiant_absence;
use App\Models\filiere;
use App\Models\module;
use App\Models\paiement;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\news;
use App\Models\stage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function index()
    {
        //         $absences = DB::table('absences')
        //             ->join('seances', 'absences.seance_id', '=', 'seances.id')
        //             ->join('matieres', 'seances.matiere_id', '=', 'matieres.id')
        //             ->select(
        //                 'absences.id as absence_id',
        //                 'absences.date_justif',
        //                 'absences.justifier',
        //                 'absences.justification',
        //                 'seances.date_seance',
        //                 'seances.heure_debut',
        //                 'seances.heure_fin',
        //                 'matieres.nom_matiere'
        //             )
        //             ->get();
        // // Puis on envoie les données à la vue
        // $absences = etudiant_absence::with('seance')->where('etudiant_id', $etudiantId)->get();
        // return view('absence', compact('absences'));

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

    public function calendrier()
    {
        return view("etudiant.Calendrier");
    }
    public function profile()
    {
        $etudiant = Auth::guard('etudiant')->user();
        $filiere =$etudiant->filiere;
        $classe = $etudiant->classe;
      return view('etudiant.profile', compact('etudiant', 'filiere','classe'));

    }
   


    public function demande_documents(){
        return view("etudiant.Demande_documents");
    }


    public function home()
    {
        $today = now()->locale('fr')->isoFormat('dddd');
        $emploisTemps = emplois_temps::where('jour',$today)->where("classe_id",auth::guard("etudiant")->user()->classes_id)->with(['matiere', 'enseignant', 'classe'])->get();
        return view("etudiant.Home", compact('today', 'emploisTemps'));
    }

    public function notes()
    {
        $etudiant = Auth::guard('etudiant')->user();
        $filiere = $etudiant->filiere;
        $notes = $etudiant->notes;
        return view("etudiant.Notes", compact('etudiant', 'filiere'));
    }

    public function absence_justif()
    {
        $etudiant = Auth::guard('etudiant')->user();
        $absences = $etudiant->etudiant_absences;
        return view("etudiant.Absence_justif", compact('absences'));
    }

    // public function stages(){
    //     return view("etudiant.Stages");
    //     $absences = \App\Models\etudiant_absence::all();
    //     return view("pages.Absence_justif", compact('absences'));
    // }
    public function stages()
    {
        $stages = Stage::all();
        return view("etudiant.stages", compact('stages'));
    }
    public function aide()
    {
        return view("etudiant.Aide");
    }
    public function paiement()
    {
        $etudiant = Auth::guard('etudiant')->user();
        $paiements = $etudiant->paiements;
        $montant_paye = 0;
        foreach ($paiements as $paiement) {
            $montant_paye += $paiement->montant_paye;
        }
        $montant_restant = $paiements[0]->montant_total - $montant_paye;
        return view("etudiant.paiement",compact('paiements',"montant_paye","montant_restant"));
    }
    public function emploi()
    {
        return view("etudiant.emploi");
    }
    public function messagerie()
    {
        return view("etudiant.messagerie");
    }
    /*public function news()
    {
        return view("etudiant.news");
    }*/
    public function news(){
       // return view("pages.news");
       $news = News::orderBy('date_news', 'desc')->get();
       return view('etudiant.news', compact('news'));

}




public function welcome()
{
    return view('authentification.welcome');
}
/*public function show($id)
{
$etudiant = Etudiant::findOrFail($id);
return view('profile', compact('etudiant'));
}*/
}
