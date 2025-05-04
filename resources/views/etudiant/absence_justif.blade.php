<x-home titre="absences-page" page_titre="absences-page" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">
<style>
        :root {
            --primary:rgb(20, 38, 118);
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f8961e;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #adb5bd;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --transition: all 0.3s ease;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
            color: var(--dark);
            background-color: #f1f5f9;
            padding: 2rem 1rem;
        }

        .container {
            width: 800px;
            margin: 0 auto;
        }

        header {
            margin-bottom: 2.5rem;
            text-align: center;
        }

        h1 {
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
            font-size: 2rem;
            letter-spacing: -0.025em;
        }

        .subtitle {
            color: var(--gray);
            font-size: 1rem;
            font-weight: 400;
        }

        /* Carte d'absence */
        .absence-list {
            display: grid;
            gap: 1.25rem;
            margin-bottom: 3rem;
        }

        .absence-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            border-left: 4px solid var(--primary);
            transition: var(--transition);
        }

        .absence-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .absence-date {
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .absence-date i {
            color: var(--primary);
        }

        .status {
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .status.justified {
            background-color: rgba(76, 201, 240, 0.1);
            color: var(--success);
        }

        .status.unjustified {
            background-color: rgba(247, 37, 133, 0.1);
            color: var(--danger);
        }

        .status.pending {
            background-color: rgba(248, 150, 30, 0.1);
            color: var(--warning);
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.25rem;
        }

        .detail-item {
            margin-bottom: 0.5rem;
        }

        .detail-label {
            font-size: 0.85rem;
            color: var(--gray);
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        /* Formulaire */
        .justification-form {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: var(--card-shadow);
            margin-top: 2rem;
        }

        h2 {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
            font-size: 0.95rem;
        }

        select, textarea, input[type="file"] {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-family: inherit;
            font-size: 1rem;
            transition: var(--transition);
            background-color: var(--light);
        }

        select:focus, textarea:focus, input[type="file"]:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .btn {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn:hover {
            background-color: #3a56d4;
            transform: translateY(-1px);
        }

        .btn-justify {
            background-color: var(--warning);
            margin-top: 1rem;
        }

        .btn-justify:hover {
            background-color: #e07e0c;
        }

        .duration-info {
            font-size: 0.85rem;
            color: var(--gray);
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        /* État vide */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--gray);
        }

        .empty-state i {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--primary);
            opacity: 0.5;
        }

        @media (max-width: 600px) {
            .card-grid {
                grid-template-columns: 1fr;
            }

            .container {
                padding: 1rem;
            }
        }
    </style>
<div class="container">
    <div class="welcome-section">
    <h1><i class="fas fa-calendar-times"></i> <b>Mes Absences</b></h1>
        <p class="subtitle">Historique de vos absences enregistrées</p>
    </div>
    <main>
        <!-- Boutons de filtre -->
<div class="filter-buttons" style="margin-bottom: 20px; text-align: center;">
    </div>
<div class="welcome-section">
        <h1><i class="fa-solid fa-filter"></i> Filtre</h1>
    <button onclick="filterAbsences('all')" class="filter-btn bg-indigo-300 text-indigo-700 font-medium px-4 py-1 rounded-full hover:bg-indigo-200 transition">Toutes</button>
    <button onclick="filterAbsences('justified')" class="filter-btn bg-green-400 text-indigo-700 font-medium px-4 py-1 rounded-full hover:bg-indigo-200 transition">Justifiées</button>
    <button onclick="filterAbsences('pending')" class="filter-btn bg-yellow-400 text-indigo-700 font-medium px-4 py-1 rounded-full hover:bg-indigo-200 transition">En cours de validation</button>
    <button onclick="filterAbsences('unjustified')" class="filter-btn bg-red-400 text-indigo-700 font-medium px-4 py-1 rounded-full hover:bg-indigo-200 transition">Non justifiées</button>

    </div>
<section class="absence-list">
    @foreach($absences as $absence)
        <article class="absence-card"
            data-status="
                @if($absence->justifier==1)
                    justified
                @elseif(!$absence->justifier && $absence->justification!=null)
                    pending
                @else
                    unjustified
                @endif
            ">
            <div class="card-header">
                <span class="absence-date">
                    <i class="far fa-calendar-alt"></i>
                    {{ \Carbon\Carbon::parse($absence->date_justif)->format('d/m/Y') }}
                </span>

                @if($absence->justifier==1)
                    <span class="status justified"><i class="fas fa-check-circle"></i> Justifiée</span>
                @elseif(!$absence->justifier && $absence->justification!=null)
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

            @if(!$absence->justifier && $absence->justification==null)
                <button class="btn btn-justify" onclick="scrollToJustification('{{ $absence->id }}')">
                    <i class="fas fa-file-upload"></i> Justifier cette absence
                </button>
            @endif
        </article>
    @endforeach
</section>

<!-- JavaScript pour filtrer -->
<script>
function filterAbsences(filter) {
    const cards = document.querySelectorAll('.absence-card');
    cards.forEach(card => {
        const status = card.getAttribute('data-status').trim();
        if (filter === 'all' || status === filter) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>



        <section id="justification-form" class="justification-form">
        <header>
        <h1><i class="far fa-edit"></i>Justifier une absence</h1>
        <p class="subtitle">Historique de vos absences enregistrées</p>
    </header>

            <form action="{{ route('justifier-absence') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="absence-select"><i class="far fa-list-alt"></i> Séance absente</label>
                    <select id="absence-select" name="absence_id" required>
                        <option value="">-- Sélectionnez une séance --</option>
                        @foreach($absences->where('justifier', 0)->where('justification', '') as $absence)

                            <option value="{{ $absence->id }}">
                            {{ \Carbon\Carbon::parse($absence->date_justif)->format('d/m/Y') }}
                            ({{ $absence->seance->heure_debut }} - {{ $absence->seance->heure_fin }})
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
