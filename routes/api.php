<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/





use App\Http\Controllers\ChatbotController;

Route::get('/chatbot/messages', [ChatbotController::class, 'messages']);

use App\Models\Etudiant;

Route::get('/etudiants', function (Request $request) {
    return Etudiant::where('classes_id', $request->classe_id)->get(['id', 'etudiant_nom', 'etudiant_prenom']);
});
