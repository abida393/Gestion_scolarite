<?php
use App\Http\Controllers\AbsenceResponsableController;
use App\Models\etudiant;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\EmploiTempsController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\MessageController;

//=============Ajouter par imad===============
use App\Http\Controllers\NewsController;
// ===========================================

use App\Exports\AbsencesExport;
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
Route::put('/update-password', [PasswordResetController::class, 'update'])->name('password.change');

Route::get('/password/forgot', [PasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/password/forgot', [PasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/password/reset/{token}', [PasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [PasswordController::class, 'reset'])->name('password.update');

// ==================== ETUDIANT PAGES ====================
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
    // Route::get('/messagerie', [MessageController::class, 'index'])->name('messagerie');
    // Étudiant
Route::get('/etudiant/news', [Controller::class, 'news'])->name('news');

});
// ==================== messagerie ===========================
Route::middleware(['auth:etudiant'])->group(function () {
    Route::get('/messagerie-etudiant', [MessageController::class, 'index'])->name('messagerie-etudiant');
    Route::get('/messages/{responsable}', [MessageController::class, 'getMessages']);
    Route::post('/messages', [MessageController::class, 'sendMessage']);
});
Route::middleware('auth:responsable')->group(function () {
    Route::get('/messagerie', [MessageController::class, 'indexResponsable'])->name('messagerie');
    Route::get('/responsable/messages/{etudiant}', [MessageController::class, 'getEtudiantMessages']);
    Route::post('/responsable/messages', [MessageController::class, 'sendResponsableMessage']);
});

// ==================== EMPLOI DU TEMPS ====================
Route::middleware('auth.multi:etudiant')->prefix('emploi')->group(function () {
    Route::get('/etudiant', [EmploiTempsController::class, 'emploiEtudiant'])->name('emploi.etudiant');
    Route::get('/download', [EmploiTempsController::class, 'download'])->name('emploi.download');
    Route::get('/etudiant/download', [EmploiTempsController::class, 'downloadForEtudiant'])->name('emploi_etudiant.download');
    Route::get('/emploi', [EmploiTempsController::class, 'emploiEtudiant'])->name('etudiant.emploi');

});
// ==================== EVENEMENTS ====================
Route::middleware('auth.multi:etudiant')->prefix('events')->group(function () {
    Route::get('/', [EvenementController::class, 'index']);
    Route::post('/', [EvenementController::class, 'store']);
    Route::put('/update/{id}', [EvenementController::class, 'update']);
    Route::delete('/{id}', [EvenementController::class, 'destroy']);
    Route::get('/list', [EvenementController::class, 'afficherEvenements'])->name('events');
});
// ==================== EVENEMENTS RESPONSABLE ==================== (Imad)
Route::middleware('auth.multi:responsable')->prefix('responsable/evenements')->group(function () {
    Route::get('/', [EvenementController::class, 'afficherEvenementsResponsable'])->name('responsable.events');
    Route::post('/', [EvenementController::class, 'addEvent'])->name('responsable.events.store');
    Route::put('/update/{id}', [EvenementController::class, 'updateEvent'])->name('responsable.events.update');
    Route::delete('/{id}', [EvenementController::class, 'deleteEvent'])->name('responsable.events.destroy');
});



// ==================== STAGES ====================
Route::get('/stage', [StageController::class, 'index'])->name('stages.index');
Route::get('/stage', [StageController::class, 'index'])->name('stages.index')->middleware("auth.multi:etudiant");


// ==================== STAGES RESPONSABLE ==================== (Imad)
Route::middleware(['auth:responsable'])->group(function () {
    // Afficher la liste des stages et le formulaire d'ajout
    Route::get('/stages', [StageController::class, 'indexResponsable'])->name('stages-responsable');
 
    // Ajouter un stage (traité par POST)
    Route::post('/stages', [StageController::class, 'store'])->name('stages.store');
 
    // Afficher le formulaire de modification d'un stage
    Route::get('/stages/edit/{id}', [StageController::class, 'edit'])->name('stages.edit');
 
    // Mettre à jour un stage
    Route::put('/stages/{id}', [StageController::class, 'update'])->name('stages.update');
 
    // Supprimer un stage
    Route::delete('/stages/{id}', [StageController::class, 'destroy'])->name('stages.destroy');
});
// ==================== NOTES ====================
Route::get('/notes/{etudiantId}', [NoteController::class, 'afficherNotes'])->middleware("auth.multi:etudiant");

// ==================== DOCUMENTS ====================
Route::middleware('auth.multi:etudiant')->prefix('documents')->group(function () {
    Route::post('/', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/', [DocumentController::class, 'documents'])->name('documents.index');
    Route::get('/download/{id}', [DocumentController::class, 'download'])->name('documents.download');
    Route::get('/{filename}', function ($filename) {
        return Storage::disk('documents')->download($filename);
    })->name('documents.file');
    Route::get('/{filename}/download', [DocumentController::class, 'downloadFile']);
});

Route::get('/demandes/{id}/download', [DocumentController::class, 'download'])->name('demandes.download');
// ==================== DOCUMENTS - RESPONSABLE ==================== (Imad)
Route::middleware('auth.multi:responsable')->prefix('responsable/documents')->group(function () {
    // Afficher toutes les demandes (responsable)
    Route::get('/', [DocumentController::class, 'indexResponsable'])->name('responsable.documents.index');

    // Modifier une demande (par exemple, modifier l'état)
    Route::get('/modifier/{id}', [DocumentController::class, 'modifier'])->name('responsable.demande.modifier');

    // Supprimer une demande
    Route::delete('/delete/{id}', [DocumentController::class, 'destroy'])->name('responsable.demande.supprimer');

    // Autres routes pour télécharger, ajouter un fichier, etc.
    Route::put('/update-etat/{id}', [DocumentController::class, 'updateEtat'])->name('responsable.demande.updateEtat');
    Route::get('/download/{id}', [DocumentController::class, 'downloadFile'])->name('documents.download');
    Route::post('/upload/{id}', [DocumentController::class, 'uploadDocument'])->name('responsable.demande.upload');
    Route::get('/modifier/{id}', [DocumentController::class, 'modifier'])->name('responsable.demande.modifier');

});




// ==================== CALENDRIER ====================
Route::prefix('calendrier')->name('calendar.')->group(function () {
    Route::get('/', [CalendarController::class, 'index'])->name('calendrier');
    Route::post('/event/store', [CalendarController::class, 'storeEvent'])->name('event.store');
    Route::post('/plan/store', [CalendarController::class, 'storePlan'])->name('plan.store');
    
});
Route::middleware('auth:responsable')->group(function () {
    Route::get('/calendrier', [CalendarController::class, 'index'])->name('responsable.calendrier');
    Route::post('/responsable/event/store', [CalendarController::class, 'storeEvent'])->name('responsable.calendar.event.store');
    Route::post('/responsable/plan/store', [CalendarController::class, 'storePlan'])->name('responsable.calendar.plan.store');
    Route::get('/responsable/calendar/events', [CalendarController::class, 'getEvents'])->name('responsable.calendar.events');
    Route::put('/responsable/event/update/{id}', [CalendarController::class, 'update'])->name('responsable.calendar.event.update');
    Route::get('/responsable/calendar/{id}/json', [CalendarController::class, 'getEventJson']);Route::delete('/responsable/calendar/{id}', [CalendarController::class, 'delete'])->name('responsable.calendar.delete');

    Route::delete('/calendar/{id}', [CalendarController::class, 'delete']);
  });  
    Route::middleware(['auth.multi:etudiant'])->group(function () {
    Route::get('/etudiant/calendrier', [CalendarController::class, 'studentView'])->name('etudiant.calendrier');
    Route::get('/etudiant/events', [CalendarController::class, 'studentEvents'])->name('etudiant.events');
});

// ==================== CHATBOT ====================
Route::post('/chatbot/repondre', [ChatbotController::class, 'repondre'])->name('chatbot.repondre');
Route::get('/api/chatbot/messages', [ChatbotController::class, 'messages']);
Route::get('/chatbot', fn() => view('chatbot'));


use App\Http\Controllers\AdminChatbotController;

Route::get('/chatbot-responsable', [AdminChatbotController::class, 'index'])->name('chatbot');
Route::post('/chatbot-responsable', [AdminChatbotController::class, 'store'])->name('chatbot.store');
Route::delete('/chatbot-responsable/{id}', [AdminChatbotController::class, 'destroy'])->name('chatbot.destroy');
Route::put('/chatbot-responsable/{id}', [AdminChatbotController::class, 'update'])->name('chatbot.update');

//paiement administrateur
use App\Http\Controllers\PaiementController;


Route::get('/paiements', [PaiementController::class, 'index'])->name('paiements.index');
Route::post('/paiements', [PaiementController::class, 'store'])->name('paiements.store');
Route::get('/admin/paiements', [PaiementController::class, 'search'])->name('paiements.index');
Route::post('/admin/paiements/{paiement}/changer-statut', [PaiementController::class, 'changerStatut'])->name('paiements.changer-statut');

//paiement administrateur
use App\Http\Controllers\NoteSaisieController;



Route::get('/notes-admin', [NoteSaisieController::class, 'notesAdmin'])->name('notes-admin');
Route::post('/note', [NoteSaisieController::class, 'store'])->name('notes.store');
Route::get('/affiche-notes/{classe_id}/{matiere_id}', [NoteSaisieController::class, 'afficheNotes']);


Route::get('/get-classes/{filiere_id}', [NoteSaisieController::class, 'getClasses']);
Route::get('/get-modules/{classe_id}', [NoteSaisieController::class, 'getModules']);
Route::get('/get-matieres-from-module/{module_id}', [NoteSaisieController::class, 'getMatieres']);
Route::get('/get-etudiants/{classe_id}', [NoteSaisieController::class, 'getEtudiants']);

Route::get('/absences/create', [AbsenceController::class, 'create'])->name('absences.create');
Route::post('/absences/store', [AbsenceController::class, 'store'])->name('absences.store');
// ==================== NEWS ==================== (Imad)
Route::middleware(['auth:responsable'])->group(function () {
    // Route pour afficher toutes les news
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');

    // Route pour ajouter une news
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');

    // Route pour afficher le formulaire d'édition d'une news
    Route::get('/news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit');

    // Route pour mettre à jour une news
    Route::put('/news/{id}', [NewsController::class, 'update'])->name('news.update');

    // Route pour supprimer une news
    Route::delete('/news/{id}', [NewsController::class, 'destroy'])->name('news.destroy');
});
// ==================== TEST EMPLOI ====================
Route::prefix('responsable')->middleware(['auth:responsable'])->group(function() {
    // Emplois du temps
    Route::get('/emplois', [EmploiTempsController::class, 'affich'])->name('responsable.emploi');
    Route::get('/emplois/create', [EmploiTempsController::class, 'create'])->name('responsable.create');
    Route::post('/emplois', [EmploiTempsController::class, 'store'])->name('responsable.store');
    Route::get('/emploi/{id}/edit', [EmploiTempsController::class, 'edit'])->name('responsable.edit');
Route::put('/responsable/emploi/{id}', [EmploiTempsController::class, 'update'])->name('responsable.update');
    Route::delete('/emplois/{timetable}', [EmploiTempsController::class, 'destroy'])->name('responsable.destroy');
    Route::get('/emplois/pdf/{classeId}', [EmploiTempsController::class, 'emploiPdf'])->name('responsable.emploi_pdf');
    Route::post('/emplois', [EmploiTempsController::class, 'store'])->name('responsable.emploi.store');
    Route::post('/check-conflits', [EmploiTempsController::class, 'checkConflits'])->name('responsable.checkConflits');
    // Emploi complet
    Route::get('/emplois/complet', [EmploiTempsController::class, 'createComplet'])->name('responsable.create_emploi_complet');
    Route::post('/emplois/complet', [EmploiTempsController::class, 'storeMultiple'])->name('responsable.storeMultiple');
    // API pour les dépendances
    Route::get('/api/filieres', function(Request $request) {
        return \App\Models\Filiere::where('formation_id', $request->formation_id)
            ->orderBy('nom_filiere')
            ->get();
           

    });
    Route::get('/api/classes', function(Request $request) {
        return \App\Models\Classe::where('filiere_id', $request->filiere_id)
            ->orderBy('nom_classe')
            ->get();
    });
});
// ==================== absence ====================
// Routes étudiant
Route::middleware(['auth:etudiant'])->group(function() {
    Route::post('/etudiant/absences/justifier', [AbsenceController::class, 'justifier'])
         ->name('etudiant.absences.justifier');
             Route::get('/absence_justif', [AbsenceController::class, 'index'])->name('absence_justif');

         
    Route::get('/etudiant/absences/download/{id}', [AbsenceController::class, 'downloadJustificatif'])
         ->name('etudiant.absences.download');
});

// Routes responsable


Route::middleware(['auth:responsable'])->prefix('responsable/absences')->group(function () {
    Route::get('/', [AbsenceResponsableController::class, 'index'])->name('responsable.absences');
    Route::get('/justifications', [AbsenceResponsableController::class, 'justificationsEnAttente'])->name('responsable.absences.justifications');
    Route::post('/validate/{absence}', [AbsenceResponsableController::class, 'validerJustification'])->name('responsable.absences.validate');
    Route::get('/download/{id}', [AbsenceResponsableController::class, 'downloadJustificatif'])->name('responsable.absences.download');
    Route::get('/create', [AbsenceResponsableController::class, 'create'])->name('responsable.absences.create');
    Route::post('/store', [AbsenceResponsableController::class, 'store'])->name('responsable.absences.store');
    Route::get('/edit/{absence}', [AbsenceResponsableController::class, 'edit'])->name('responsable.absences.edit');
    Route::put('/update/{absence}', [AbsenceResponsableController::class, 'update'])->name('responsable.absences.update');
    Route::delete('/destroy/{absence}', [AbsenceResponsableController::class, 'destroy'])->name('responsable.absences.destroy');
    Route::get('/export', [AbsenceResponsableController::class, 'export'])->name('responsable.absences.export');
});

//  pour chargement dynamique 
Route::get('/absences/etudiants-par-classe/{classeId}', [AbsenceResponsableController::class, 'getEtudiantsParClasse']);
Route::get('/absences/seances-par-classe/{classeId}', [AbsenceResponsableController::class, 'getSeancesParClasse']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

