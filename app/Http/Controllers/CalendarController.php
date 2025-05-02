<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\annee;
use App\Models\Calendar;
use App\Models\CalendarEvent;
use App\Models\calender;
use App\Models\calender_events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    
public function index()
{
    $events = calender_events::all();
    $plans = calender::with('event')->get();
    $annees = annee::all(); // Récupération de toutes les années

    return view('calender.calendar', compact('events', 'plans', 'annees'));
}

    public function storeEvent(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'is_fixed' => 'nullable|boolean',
        ]);

        calender_events::create([
            'title' => $request->title,
            'is_fixed' => $request->has('is_fixed'),
        ]);

        return redirect()->back()->with('success', 'Événement créé avec succès.');
    }

    public function storePlan(Request $request)
{
    $request->validate([
        'calendar_event_id' => 'required|exists:calender_events,id', // Utilisez le nom correct de la table
        'annee_id' => 'required|exists:annee,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    calender::create($request->only([
        'calendar_event_id',
        'annee_id',
        'start_date',
        'end_date'
    ]));

    return redirect()->back()->with('success', 'Planification ajoutée.');
}
// === ÉTUDIANT ===


public function getStudentEvents()
{
    $etudiant = Auth::guard('etudiant')->user(); // On suppose que l'étudiant est connecté et a un annee_id

    $plans = calender::with('event')
        ->where('annee_id', $etudiant->annee_id)
        ->get();

    $events = $plans->map(function ($plan) {
        return [
            'title' => $plan->event->title,
            'start' => $plan->start_date,
            'end' => $plan->end_date,
            'allDay' => true,
        ];
    });
    dd($events, $plans, );
    return response()->json($events);
}
public function studentView()
{
    $etudiant = Auth::guard('etudiant')->user();

    // Charger uniquement les événements liés à l’année de l'étudiant
    $plans = calender::with('event')
        ->where('annee_id', $etudiant->annee_id)
        ->get();

    return view('calender.student', compact('plans'));
}

public function studentEvents()
{
    $etudiant = Auth::guard('etudiant')->user();

    $events = calender::with('event')
        ->where('annee_id', $etudiant->annee_id)
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
public function getEvents()
{
    $plans = calender::with('event')->get();

    $events = $plans->map(function ($plan) {
        return [
            'title' => $plan->event->title,
            'start' => $plan->start_date,
            'end' => $plan->end_date,
        ];
    });

    return response()->json($events);
}

}
