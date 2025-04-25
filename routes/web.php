<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/',[Controller::class,'index']);
use App\Models\Etudiant;

Route::get('/profil/{id}', function ($id) {
    $etudiant = Etudiant::find($id);

    if (!$etudiant) {
        abort(404, 'Étudiant introuvable');
    }

    return view('profile', compact('etudiant'));
});

use App\Http\Controllers\PasswordController;

Route::get('/change-password', [PasswordController::class, 'edit'])->name('password.edit');
Route::post('/change-password', [PasswordController::class, 'update'])->name('password.update');
