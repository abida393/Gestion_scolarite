<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\etudiant;
use App\Models\news;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
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
    public function profile()
    {
        //$etudiant = Etudiant::findOrFail(1);
        $etudiant = etudiant::where('id', 1)->first();
        //dd($etudiant);
      return view('pages.profile', compact('etudiant'));

       
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
        return view("pages.Absence_justif");
    }
    public function stages(){
        return view("pages.Stages");
    }
    public function aide(){
        return view("pages.Aide");
    }
    public function paiement(){
        return view("pages.paiement");
    }
    public function emploi(){
        return view("pages.emploi");
    }
    public function messagerie(){
        return view("pages.messagerie");
    }
    public function news(){
       // return view("pages.news");
       $news = News::orderBy('date_news', 'desc')->get();
       return view('pages.news', compact('news'));

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
