<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

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
}

