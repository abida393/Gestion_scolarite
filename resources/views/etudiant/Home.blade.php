<x-home titre="Page d'accueil" page_titre="Page d'accueil" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">
    <div id="accueil-page">
        <section class="welcome-section">
            <h1>Bienvenue, <span
                    class="student-name">{{ Auth::guard('etudiant')->user()->etudiant_nom . ' , ' . Auth::guard('etudiant')->user()->etudiant_prenom }}</span>
                !</h1>
            <p id="current-date-time"></p> <!-- Conteneur pour la date et l'heure -->
        </section>
        <!-- dashboard -->
        <div class="bg-gray-100 font-sans">
            <div class="max-w-7xl mx-auto py-10 px-6">
                <h1 class="text-3xl font-bold text-center text-blue-800 mb-10 uppercase tracking-wide">
                    Cours de {{ ucfirst($today) }}
                </h1>

                @if ($emploisTemps->isEmpty())
                    <div class="text-gray-500 text-center">
                        🎉 Pas de cours prévu aujourd'hui !
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($emploisTemps as $cours)
                            <div
                                class="bg-gradient-to-r from-blue-100 to-blue-200 p-4 rounded-lg shadow flex flex-col justify-between h-full">
                                <div class="flex justify-between items-center mb-2">
                                    <span
                                        class="bg-blue-600 text-white text-xs px-3 py-1 rounded-full shadow">{{ $cours->matiere->name }}</span>
                                    <span class="text-sm font-semibold text-gray-600">{{ $cours->salle }}</span>
                                </div>

                                <div class="text-sm text-gray-700 mb-1">
                                    📅 {{ \Carbon\Carbon::parse($cours->date)->format('d/m') }}
                                </div>

                                <div class="text-sm text-gray-700 mb-1">
                                    🕒 {{ \Carbon\Carbon::parse($cours->heure_debut)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($cours->heure_fin)->format('H:i') }}
                                </div>

                                <div class="text-sm text-gray-700 font-bold">
                                    👨‍🏫 Enseignant : {{ $cours->enseignant->name }}
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
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
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
