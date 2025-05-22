<?php


namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\responsable;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('components.home', function ($view) {
            $unreadCount = 0;
            if (Auth::guard('etudiant')->check()) {
                $etudiant = Auth::guard('etudiant')->user();
                $responsables = responsable::all();
                foreach ($responsables as $responsable) {
                    $unreadCount += Message::where('sender_id', $responsable->id)
                        ->where('sender_type', 'responsable')
                        ->where('receiver_id', $etudiant->id)
                        ->where('receiver_type', 'etudiant')
                        ->where('is_read', false)
                        ->count();
                }
            }
            $view->with('unreadCount', $unreadCount);
        });
         // Pour le responsable
    View::composer('components.admin', function ($view) {
        $unreadCount = 0;
        if (Auth::guard('responsable')->check()) {
            $responsable = Auth::guard('responsable')->user();
            $etudiants = \App\Models\etudiant::all();
            foreach ($etudiants as $etudiant) {
                $unreadCount += Message::where('sender_id', $etudiant->id)
                    ->where('sender_type', 'etudiant')
                    ->where('receiver_id', $responsable->id)
                    ->where('receiver_type', 'responsable')
                    ->where('is_read', false)
                    ->count();
            }
        }
        $view->with('unreadCount', $unreadCount);
    });
    }
}