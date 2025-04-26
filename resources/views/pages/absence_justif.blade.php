<x-home titre="absences-page" page_titre="absences-page">
<div class="container">
    <header>
        <h1><i class="fas fa-calendar-times"></i> Mes Absences</h1>
        <p class="subtitle">Historique de vos absences enregistrées</p>
    </header>
    
    <main>
        <section class="absence-list">

            @foreach($absences as $absence)
                <article class="absence-card">
                    <div class="card-header">
                        <span class="absence-date">
                            <i class="far fa-calendar-alt"></i> 
                            {{ \Carbon\Carbon::parse($absence->date_justif)->format('d/m/Y') }}
                        </span>
                        
                        @if($absence->justifier)
                            <span class="status justified"><i class="fas fa-check-circle"></i> Justifiée</span>
                        @elseif(!$absence->justifier && !empty($absence->justification))
                            <span class="status pending"><i class="fas fa-hourglass-half"></i> En cours de validation</span>
                        @else
                            <span class="status unjustified"><i class="fas fa-times-circle"></i> Non justifiée</span>
                        @endif
                    </div>

                    <div class="card-grid">
                        <div class="detail-item">
                            <div class="detail-label"><i class="far fa-bookmark"></i> Séance</div>
                            <div>{{ $absence->seance->matiere->nom_matiere ?? 'Séance inconnue' }}</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label"><i class="far fa-clock"></i> Heures</div>
                            <div>
    {{ $absence->seance ? $absence->seance->heure_debut : '--:--' }} - 
    {{ $absence->seance ? $absence->seance->heure_fin : '--:--' }}
</div>

                        </div>

                        <div class="detail-item">
                            <div class="detail-label"><i class="far fa-comment-alt"></i> Justification</div>
                            <div>{{ $absence->justification ?? '-' }}</div>
                        </div>
                    </div>

                    @if(!$absence->justifier)
                        <button class="btn btn-justify" onclick="scrollToJustification('{{ $absence->id }}')">
                            <i class="fas fa-file-upload"></i> Justifier cette absence
                        </button>
                    @endif
                </article>
            @endforeach

        </section>

        <section id="justification-form" class="justification-form">
            <h2><i class="far fa-edit"></i> Justifier une absence</h2>

            <form action="" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="absence-select"><i class="far fa-list-alt"></i> Séance absente</label>
                    <select id="absence-select" name="absence_id" required>
                        <option value="">-- Sélectionnez une séance --</option>
                        @foreach($absences->where('is_justified', false) as $absence)
                            <option value="{{ $absence->id }}">
                                {{ \Carbon\Carbon::parse($absence->date)->format('d/m/Y') }} - {{ $absence->seance }} ({{ $absence->heures }})
                            </option>
                        @endforeach
                    </select>
                    <p class="duration-info"><i class="far fa-hourglass"></i> Durée standard des séances : 1 heure 30 minutes</p>
                </div>

                <div class="form-group">
                    <label for="justification-text"><i class="far fa-file-alt"></i> Motif de l'absence</label>
                    <textarea id="justification-text" name="justification" required 
                              placeholder="Décrivez précisément le motif de votre absence..."></textarea>
                </div>

                <div class="form-group">
                    <label for="justification-file"><i class="far fa-image"></i> Preuve justificative (optionnel)</label>
                    <input type="file" id="justification-file" name="justification_file" accept="image/*,.pdf">
                    <p class="duration-info"><i class="far fa-info-circle"></i> Formats acceptés : JPG, PNG, PDF (max 5MB)</p>
                </div>

                <button type="submit" class="btn"><i class="far fa-paper-plane"></i> Soumettre la justification</button>
            </form>
        </section>
    </main>
</div>
    </div>
    <script>
        function scrollToJustification(absenceId) {
            // Sélectionner automatiquement l'absence correspondante
            document.getElementById('absence-select').value = absenceId;
            
            // Faire défiler jusqu'au formulaire
            document.getElementById('justification-form').scrollIntoView({
                behavior: 'smooth'
            });
            
            // Donner le focus au champ de texte
            document.getElementById('justification-text').focus();
        }
    </script>
</x-home>
