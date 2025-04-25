<?php

namespace App\Http\Controllers;

use App\Models\emplois_temps;
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
}