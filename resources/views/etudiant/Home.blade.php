@if (session('etudiant'))
    @php
        $etudiant = session('etudiant');
    @endphp

@endif
<x-home titre="Page d'accueil" page_titre="Page d'accueil" >
    <div id="accueil-page">
        <section class="welcome-section">
            <h1>Bienvenue, <span class="student-name">{{ $etudiant->etudiant_nom}} , {{$etudiant->etudiant_prenom }}</span> !</h1>
            <p id="current-date-time"></p> <!-- Conteneur pour la date et l'heure -->
        </section>
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
