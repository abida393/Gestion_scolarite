<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stage;

class StageController extends Controller
{
    //
public function index()
{
    $stages = Stage::all();
    return view('stages.index', compact('stages'));
}
}