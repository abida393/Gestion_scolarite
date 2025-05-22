<?php

namespace App\Http\Controllers;

use App\Models\etudiant;
use App\Models\Message;
use App\Models\responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
{
    $etudiant = Auth::guard('etudiant')->user();
    $responsables = responsable::all();
    $receivedMessages = $etudiant->receivedMessages;

    // Ajoute unread_count à chaque responsable
    foreach ($responsables as $responsable) {
        $responsable->unread_count = Message::where('sender_id', $responsable->id)
            ->where('sender_type', 'responsable')
            ->where('receiver_id', $etudiant->id)
            ->where('receiver_type', 'etudiant')
            ->where('is_read', false)
            ->count();
    }

    // Calcul du total pour la notif globale
    $unreadCount = $responsables->sum('unread_count');

    return view('etudiant.messagerie', compact('responsables', 'etudiant', 'receivedMessages', 'unreadCount'));
}
    public function indexResponsable()
{
    $responsable = Auth::guard('responsable')->user();
    $etudiants = etudiant::all();

    // Ajoute unread_count à chaque étudiant
    foreach ($etudiants as $etudiant) {
        $etudiant->unread_count = Message::where('sender_id', $etudiant->id)
            ->where('sender_type', 'etudiant')
            ->where('receiver_id', $responsable->id)
            ->where('receiver_type', 'responsable')
            ->where('is_read', false)
            ->count();
    }

    // Calcul du total pour la notif globale
    $unreadCount = $etudiants->sum('unread_count');

    return view('responsable.messagerie', compact('responsable', 'etudiants', 'unreadCount'));
}
public function markAsReadByResponsable($etudiantId)
{
    $responsableId = Auth::guard('responsable')->id();

    Message::where('sender_id', $etudiantId)
        ->where('sender_type', 'etudiant')
        ->where('receiver_id', $responsableId)
        ->where('receiver_type', 'responsable')
        ->where('is_read', false)
        ->update(['is_read' => true]);

    return response()->json(['success' => true]);
}

    public function getMessages($responsableId)
    {
        $etudiantId = Auth::guard('etudiant')->id();

        $messages = Message::where(function ($query) use ($etudiantId, $responsableId) {
            $query->where('sender_id', $etudiantId)
                ->where('sender_type', 'etudiant')
                ->where('receiver_id', $responsableId)
                ->where('receiver_type', 'responsable');
        })->orWhere(function ($query) use ($etudiantId, $responsableId) {
            $query->where('sender_id', $responsableId)
                ->where('sender_type', 'responsable')
                ->where('receiver_id', $etudiantId)
                ->where('receiver_type', 'etudiant');
        })->orderBy('created_at')->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'responsable_id' => 'required|exists:responsables,id',
        ]);

        $etudiant = Auth::guard('etudiant')->user();

        $message = Message::create([
            'content' => $request->input('content'),
            'sender_id' => $etudiant->id,
            'sender_type' => 'etudiant',
            'receiver_id' => $request->responsable_id,
            'receiver_type' => 'responsable',
        ]);

        return response()->json(['message' => $message]);
    }

    public function getEtudiantMessages($etudiantId)
    {
        $responsableId = Auth::guard('responsable')->id();

        $messages = Message::where(function ($query) use ($etudiantId, $responsableId) {
            $query->where('sender_id', $etudiantId)
                ->where('sender_type', 'etudiant')
                ->where('receiver_id', $responsableId)
                ->where('receiver_type', 'responsable');
        })->orWhere(function ($query) use ($etudiantId, $responsableId) {
            $query->where('sender_id', $responsableId)
                ->where('sender_type', 'responsable')
                ->where('receiver_id', $etudiantId)
                ->where('receiver_type', 'etudiant');
        })->orderBy('created_at')->get();

        return response()->json($messages);
    }

    public function sendResponsableMessage(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'etudiant_id' => 'required|exists:etudiants,id',
        ]);

        $responsable = Auth::guard('responsable')->user();

        $message = Message::create([
            'content' => $request->input('content'),
            'sender_id' => $responsable->id,
            'sender_type' => 'responsable',
            'receiver_id' => $request->etudiant_id,
            'receiver_type' => 'etudiant',
        ]);

        return response()->json(['message' => $message]);
    }
    public function markAsRead($responsableId)
{
    $etudiantId = Auth::guard('etudiant')->id();

    Message::where('sender_id', $responsableId)
        ->where('sender_type', 'responsable')
        ->where('receiver_id', $etudiantId)
        ->where('receiver_type', 'etudiant')
        ->where('is_read', false)
        ->update(['is_read' => true]);

    return response()->json(['success' => true]);
}
}
