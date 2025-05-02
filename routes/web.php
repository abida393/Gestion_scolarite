<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\EmploiTempsController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\CalendarController;

// ==================== AUTHENTICATION ====================

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('home.welcome');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login');
    Route::get('/mdpwrong', [AuthController::class, 'mdpwrong'])->name('mdpwrong');
    Route::get('/newmdp', [AuthController::class, 'newmdp'])->name('newmdp');
});

Route::middleware('auth.multi:responsable')->group(function () {
    Route::get('/admin', [AuthController::class, 'admin'])->name('admin');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== PASSWORD RESET ====================

Route::get('/change-password', [PasswordResetController::class, 'edit'])->name('password.edit');
Route::put('/update-password', [PasswordResetController::class, 'update'])->name('password.update');

Route::get('/password/forgot', [PasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/password/forgot', [PasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/password/reset/{token}', [PasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [PasswordController::class, 'reset'])->name('password.update');

// ==================== GENERAL PAGES (Etudiant) ====================

Route::middleware('auth.multi:etudiant')->group(function () {
    Route::get('/home', [Controller::class, 'home'])->name('home');
    Route::get('/calendar', [Controller::class, 'calendar'])->name('calendar');
    Route::get('/emploi', [Controller::class, 'emploi'])->name('emploi');
    Route::get('/calendrier', [Controller::class, 'calendrier'])->name('calendrier');
    Route::get('/notes', [Controller::class, 'notes'])->name('notes');
    Route::get('/demande_documents', [Controller::class, 'demande_documents'])->name('demande_documents');
    Route::get('/absence_justif', [Controller::class, 'absence_justif'])->name('absence_justif');
    Route::get('/stages', [Controller::class, 'stages'])->name('stages');
    Route::get('/aide', [Controller::class, 'aide'])->name('aide');
    Route::get('/profile', [Controller::class, 'profile'])->name('profile');
    Route::get('/paiement', [Controller::class, 'paiement'])->name('paiement');
    Route::get('/messagerie', [Controller::class, 'messagerie'])->name('messagerie');
    Route::get('/news', [Controller::class, 'news'])->name('news');
});

// ==================== EMPLOI DU TEMPS ====================

Route::middleware('auth.multi:etudiant')->prefix('emploi')->group(function () {
    Route::get('/create', [EmploiTempsController::class, 'createComplet'])->name('emploi.create');
    Route::get('/create-complet', [EmploiTempsController::class, 'createComplet'])->name('emploi.create_complet');
    Route::post('/', [EmploiTempsController::class, 'store'])->name('emploi.store');
    Route::post('/store-multiple', [EmploiTempsController::class, 'storeMultiple'])->name('emploi.storeMultiple');
    Route::get('/etudiant', [EmploiTempsController::class, 'emploiEtudiant'])->name('emploi.etudiant');
    Route::get('/{timetable}/edit', [EmploiTempsController::class, 'edit_emploi'])->name('emploi.edit');
    Route::put('/{timetable}', [EmploiTempsController::class, 'update'])->name('emploi.update');
    Route::delete('/{timetable}', [EmploiTempsController::class, 'destroy'])->name('emploi.destroy');
    Route::get('/', [EmploiTempsController::class, 'showEmplois'])->name('emploi.show');
    Route::get('/emploi/download', [EmploiTempsController::class, 'download'])->name('emploi.download');
    Route::get('/emploi-etudiant/download', [EmploiTempsController::class, 'downloadForEtudiant'])->name('emploi_etudiant.download');
});

Route::middleware('auth.multi:etudiant')->group(function () {
    Route::get('/filieres-par-formation/{formationId}', [EmploiTempsController::class, 'getFilieresByFormation']);
    Route::get('/classes-par-filiere/{filiereId}', [EmploiTempsController::class, 'getClassesByFiliere']);
    Route::get('/dashboard', [EmploiTempsController::class, 'dashboard'])->name('dashboard');
});

// ==================== EVENTS ====================

Route::middleware('auth.multi:etudiant')->prefix('events')->group(function () {
    Route::get('/', [EvenementController::class, 'index']);
    Route::post('/', [EvenementController::class, 'store']);
    Route::put('/update/{id}', [EvenementController::class, 'update']);
    Route::delete('/{id}', [EvenementController::class, 'destroy']);
});

Route::get('/evenements', [EvenementController::class, 'afficherEvenements'])->name('events')->middleware("auth.multi:etudiant");

// ==================== STAGE ====================

Route::get('/stage', [StageController::class, 'index'])->name('stages.index')->middleware("auth.multi:etudiant");

// ==================== ABSENCES ====================

Route::middleware('auth.multi:etudiant')->group(function () {
    Route::get('/absences', [AbsenceController::class, 'index'])->name('absences.index');
    Route::post('/absences/justify/{id}', [AbsenceController::class, 'justify'])->name('absences.justify');
    Route::post('/justifier-absence', [AbsenceController::class, 'justifier'])->name('justifier-absence');
});

// ==================== NOTES ====================

Route::get('/notes/{etudiantId}', [NoteController::class, 'afficherNotes'])->middleware("auth.multi:etudiant");


// Routes pour la gestion du calendrier
Route::prefix('calendrier')->name('calendar.')->group(function () {
    Route::get('/', [CalendarController::class, 'index'])->name('calendrier'); // Afficher la page du calendrier
    Route::post('/event/store', [CalendarController::class, 'storeEvent'])->name('event.store'); // Créer un événement
    Route::post('/plan/store', [CalendarController::class, 'storePlan'])->name('plan.store'); // Planifier un événement

});





Route::middleware(['auth:etudiant'])->group(function () {
    Route::get('/etudiant/calendrier', [CalendarController::class, 'studentView'])->name('etudiant.calendrier');
    Route::get('/calendrier/events', [CalendarController::class, 'getEvents'])->name('calendrier.events');
});


