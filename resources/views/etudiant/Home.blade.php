<x-home titre="Page d'accueil" page_titre="Page d'accueil" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom.','.Auth::guard('etudiant')->user()->etudiant_prenom">
<div id="accueil-page">
        <section class="welcome-section">
            <h1>Bienvenue, <span class="student-name">{{ Auth::guard("etudiant")->user()->etudiant_nom.' , '.Auth::guard("etudiant")->user()->etudiant_prenom }}</span> !</h1>
            <p id="current-date-time"></p> <!-- Conteneur pour la date et l'heure -->
        </section>
             <!-- dashboard -->
     <div class="bg-gray-100 font-sans">
    <div class="max-w-7xl mx-auto py-10 px-6">
        <h1 class="text-3xl font-bold text-center text-blue-800 mb-10 uppercase tracking-wide">
             Cours de {{ ucfirst($today) }}
        </h1>

        @if($emploisTemps->isEmpty())
            <div class="text-gray-500 text-center flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Pas de cours prévu aujourd'hui !
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($emploisTemps as $cours)
                    <div class="bg-gradient-to-r from-blue-100 to-blue-200 p-4 rounded-lg shadow flex flex-col justify-between h-full">
                        <div class="flex justify-between items-center mb-2">
                            <span class="bg-blue-600 text-white text-xs px-3 py-1 rounded-full shadow">{{ $cours->matiere->name }}</span>
                            <span class="text-sm font-semibold text-gray-600">{{ $cours->salle }}</span>
                        </div>

                        <div class="text-sm text-gray-700 mb-1 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ \Carbon\Carbon::parse($cours->date)->format('d/m/Y') }}
                        </div>

                        <div class="text-sm text-gray-700 mb-1 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ \Carbon\Carbon::parse($cours->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($cours->heure_fin)->format('H:i') }}
                        </div>

                        <div class="text-sm text-gray-700 font-bold flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Enseignant : {{ $cours->enseignant->name }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div> 
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <div class="card-header">
                    <h2><i class="fas fa-newspaper"></i> Dernières actualités</h2>
                    <i class="fas fa-ellipsis-h"></i>
                </div>
                
                <div class="news-list">
                    <div class="news-item">
                        <h3>Consignes de réouverture du campus</h3>
                        <p>L'université a publié des consignes mises à jour pour le prochain semestre.</p>
                        <div class="news-date">
                            <i class="far fa-clock"></i> Publié il y a 2 jours
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Fonction pour mettre à jour la date et l'heure
        function updateDateTime() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const date = now.toLocaleDateString('fr-FR', options); // Format de la date en français
            const time = now.toLocaleTimeString('fr-FR'); // Format de l'heure en français
            document.getElementById('current-date-time').textContent = `Nous sommes le ${date}, il est ${time}.`;
        }

        // Mettre à jour la date et l'heure toutes les secondes
        setInterval(updateDateTime, 1000);

        // Initialiser la date et l'heure au chargement de la page
        updateDateTime();
    </script>
</x-home>
