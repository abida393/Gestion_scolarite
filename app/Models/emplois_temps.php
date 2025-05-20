<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class emplois_temps extends Model
{
    protected $table = 'emplois_temps';
    
    protected $fillable = [
        'classe_id',
        'matiere_id',
        'enseignant_id',
        'jour',
        'date',
        'heure_debut',
        'heure_fin',
        'salle'
    ];
    
    protected $casts = [
        'date' => 'date',
    ];
    
    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }
    
    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }
    
    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }
    
    public function getDureeAttribute(): string
    {
        $debut = \Carbon\Carbon::parse($this->heure_debut);
        $fin = \Carbon\Carbon::parse($this->heure_fin);
        return $debut->diff($fin)->format('%Hh%I');
    }
    
    public static function getJoursSemaine(): array
    {
        return ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
    }
    
    public static function generateTimeSlots(): array
    {
        $slots = [];
        $start = \Carbon\Carbon::createFromTime(8, 45); // Début à 8h45
        $end = \Carbon\Carbon::createFromTime(17, 30);  // Fin à 17h30
        
        while ($start < $end) {
            $next = $start->copy()->addMinutes(90); // Cours de 1h30
            
            if ($next > $end) break;
            
            $slots[] = [
                'debut' => $start->format('H:i'),
                'fin' => $next->format('H:i'),
                'label' => $start->format('H:i') . ' - ' . $next->format('H:i')
            ];
            
            // Pause de 15 minutes (30 minutes après le matin)
            $start = $next->copy()->addMinutes($start->hour < 12 ? 15 : 30);
        }
        
        return $slots;
    }
    public function scopeNormal($query)
    {
        return $query->where('statut', 'normal');
    }

    // Scope pour les cours annulés
    public function scopeAnnules($query)
    {
        return $query->where('statut', 'annule');
    }
}