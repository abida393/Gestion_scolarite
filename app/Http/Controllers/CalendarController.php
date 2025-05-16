<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\annee;
use App\Models\annee_formation;
use App\Models\Calendar;
use App\Models\CalendarEvent;
use App\Models\calender;
use App\Models\calender_events;
// use App\Models\CalendarEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 \App\Http\Middleware\VerifyCsrfToken::class; // doit être ici

class CalendarController extends Controller
{
    
    public function index()
    {
    $events = calender_events::all(); // Tous les événements
    $plans = calender::with('event')->get(); // Planifications avec les relations

    return view('responsable.calendrier', compact('events', 'plans'));
}

    // Crée un nouvel événement
    public function storeEvent(Request $request)
    {
        dd($request->all());
        $request->validate([
            'title' => 'required|string|max:255',
            'is_fixed' => 'nullable|boolean',
        ]);
    
        calender_events::create([
            'title' => $request->title,
            'is_fixed' => $request->has('is_fixed') ? 1 : 0,
        ]);
    
        return redirect()->back()->with('success', 'Événement créé avec succès.');
    }
    
    public function storePlan(Request $request)
{
    
    $request->validate([
        'event_type' => 'required|in:existing,new',
        'calendar_event_id' => 'nullable|exists:calender_events,id',
        'title' => 'nullable|string|max:255',
        'is_fixed' => 'nullable|boolean',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    // Si un nouvel événement est créé
    if ($request->event_type === 'new') {
        $event = calender_events::create([
            'title' => $request->title,
            'is_fixed' => $request->has('is_fixed') ? 1 : 0,
        ]);
        $calendarEventId = $event->id;
    } else {
        $calendarEventId = $request->calendar_event_id;
    }

    // Récupérer l'année actuelle
    // $anneeActuelle = annee::where('annee',date()->format('Y'))->first();

    // if (!$anneeActuelle) {
    //     return redirect()->back()->with('error', 'Aucune année académique actuelle définie.');
    // }

    // Créer la planification
    calender::create([
        'calendar_event_id' => $calendarEventId,
        'annee_id' => null,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
    ]);

    return redirect()->back()->with('success', 'Planification ajoutée avec succès.');
}
// === ÉTUDIANT ===

public function studentView()
{
    $etudiant = Auth::guard('etudiant')->user();

    // Récupérer les événements uniquement pour l'année de l'étudiant
    $plans = calender::with('event')
        ->where('annee_id', $etudiant->annee_id)
        ->get();

    // Mapper les données pour FullCalendar
    $events = $plans->map(function ($plan) {
        return [
            'title' => $plan->event->title ?? 'Sans titre',  // Titre de l'événement
            'start' => $plan->start_date,  // Début de l'événement
            'end'   => $plan->end_date,    // Fin de l'événement
        ];
    });

    // Passer les événements à la vue
    return view('etudiant.calendrier', compact('events'));
}




public function studentEvents()
{
    $etudiant = Auth::guard('etudiant')->user();
    $formation = $etudiant->formation;
    $annee_formation = $formation->annee_formation;
    $annee = $annee_formation[0]->annee;
    $events = calender::with('event')
        ->where('annee_id', $annee->id)
        ->get()
        ->map(function ($calendar) {
            return [
                'title' => $calendar->event->title,
                'start' => $calendar->start_date,
                'end' => $calendar->end_date,
                'allDay' => true,
            ];
        });
    return response()->json($events);
}


public function edit($id)
{
    $plan = calender::with('event')->findOrFail($id);
    $event = $plan->event; // L'événement lié à cette planification

    return view('responsable.edit_event', compact('plan', 'event'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'is_fixed' => 'nullable|boolean',
    ]);

   $plan = calender::with('event')->findOrFail($id);

    // 2. On récupère l'événement lié à cette planification
    $event = $plan->event;

    // 3. On met à jour l'événement
    $event->update([
        'title' => $request->title,
        'is_fixed' => $request->has('is_fixed') ? 1 : 0,
    ]);

    return response()->json(['success' => true, 'message' => 'Événement mis à jour avec succès.']);
}


public function delete($id)
{
    
    $plan = calender::find($id);

    if (!$plan) {
        return response()->json(['success' => false, 'message' => 'Événement introuvable.'], 404);
    }

    $plan->delete();

    return response()->json(['success' => true, 'message' => 'Événement supprimé avec succès.']);
}



public function getEvents()
    {

        // Vérifiez si l'utilisateur est authentifié en tant que responsable
        if (!Auth::guard('responsable')->check()) {
            return response()->json([], 403); // Accès refusé
        }

       $plans = calender::with('event')->get();

    $events = $plans->map(function ($plan) {
        return [
            'id' => $plan->id, // ID de calender
            'title' => $plan->event->title,
            'start' => $plan->start_date,
            'end' => $plan->end_date,
            'allDay' => true,
            'extendedProps' => [
                'eventId' => $plan->event->id,
                'isFixed' => $plan->event->is_fixed
            ]
        ];
    });

    return response()->json($events);

}
public function getEventJson($id)
{
     
    $plan = calender::with('event')->findOrFail($id);
    
    return response()->json([
        'id' => $plan->id,
        'title' => $plan->event->title,
        'isFixed' => $plan->event->is_fixed,
    ]);
}
}