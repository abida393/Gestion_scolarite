<x-home titre="Page d'accueil" page_titre="Page d'accueil" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom.','.Auth::guard('etudiant')->user()->etudiant_prenom">
<div id="accueil-page">
    <section class="welcome-section">
        <h1>Bienvenue, <span class="student-name">{{ Auth::guard("etudiant")->user()->etudiant_nom.' , '.Auth::guard("etudiant")->user()->etudiant_prenom }}</span> !</h1>
        <p id="current-date-time"></p>
    </section>

  <div class="bg-gray-50 font-sans py-4 px-4">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-extrabold text-center text-blue-700 uppercase tracking-tight mb-10">
            Cours de {{ ucfirst($today) }}
        </h1>

        @if($emploisTemps->isEmpty())
            <div class="flex flex-col items-center justify-center text-center text-gray-500 mt-20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-lg font-medium">Pas de cours prévu aujourd'hui !</p>
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($emploisTemps as $cours)
                    <div class="bg-white border border-blue-100 rounded-xl shadow hover:shadow-lg transition duration-300 p-5 relative
                        @if($cours->statut === 'annule') border-red-200 bg-red-50 @endif
                        @if($cours->statut === 'reporte') border-yellow-200 bg-yellow-50 @endif">
                        
                        <!-- Badge d'absence -->
                        @if($cours->statut !== 'normal')
                        <div class="absolute -top-2 -right-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                @if($cours->statut === 'annule') bg-red-100 text-red-800 @endif
                                @if($cours->statut === 'reporte') bg-yellow-100 text-yellow-800 @endif">
                                @if($cours->statut === 'annule') Annulé @endif
                                @if($cours->statut === 'reporte') Reporté @endif
                            </span>
                        </div>
                        @endif

                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-blue-600 text-white text-sm font-medium px-4 py-1 rounded-full
                                @if($cours->statut === 'annule') bg-red-600 @endif
                                @if($cours->statut === 'reporte') bg-yellow-600 @endif">
                                {{ $cours->matiere->name }}
                            </span>
                            <span class="text-sm text-gray-500">{{ $cours->salle }}</span>
                        </div>

                        <div class="flex items-center text-sm text-gray-600 mb-2">
                            <svg class="w-5 h-5 text-blue-500 mr-2
                                @if($cours->statut === 'annule') text-red-500 @endif
                                @if($cours->statut === 'reporte') text-yellow-500 @endif" 
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ \Carbon\Carbon::parse($cours->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($cours->heure_fin)->format('H:i') }}
                        </div>

                        <div class="flex items-center text-sm text-gray-600 font-semibold">
                            <svg class="w-5 h-5 text-blue-500 mr-2
                                @if($cours->statut === 'annule') text-red-500 @endif
                                @if($cours->statut === 'reporte') text-yellow-500 @endif" 
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ $cours->enseignant->name }}
                        </div>

                        <!-- Section motif d'absence -->
                        @if($cours->statut !== 'normal')
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-500"><span class="font-medium">Motif :</span> {{ $cours->motif_annulation }}</p>
                        </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>


            <!-- Section Actualités et Événements -->
            <div class="mt-12">
                <style>
                    /* Scrollbar fine et discrète */
                    ::-webkit-scrollbar {
                      width: 4px;
                    }
                    ::-webkit-scrollbar-thumb {
                      background-color: #a0aec0;
                      border-radius: 20px;
                    }

                    /* Style du badge "News" avec une couleur et un écart des marges */
                    .news-badge {
                        font-size: 0.75rem;
                        font-weight: 600;
                        padding: 0.25rem 0.5rem;
                        position: absolute;
                        top: 10px;
                        right: 10px;
                        background-color: #3498db;
                        color: white;
                        border-radius: 12px;
                    }
                </style>
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Colonne Actualités -->
                    <div class="lg:w-1/2">
                        <h3 class="text-2xl font-bold text-blue-800 mb-6 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            Dernières Actualités
                        </h3>

                        @php
                            $latestNews = \App\Models\News::orderBy('date_news', 'desc')->take(2)->get();
                        @endphp

                        @if($latestNews->isEmpty())
                            <div class="bg-white rounded-lg shadow p-6 text-center">
                                <p class="text-gray-500">Aucune actualité récente</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 gap-6">
                                @foreach($latestNews as $item)
                                <div class="relative bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-transform transform hover:-translate-y-1 overflow-hidden">
                                    {{-- Badge "News" seulement pour les actualités récentes --}}
                                    @if(\Carbon\Carbon::parse($item->date_news)->diffInDays(now()) <= 7)
                                        <span class="news-badge">News</span>
                                    @endif

                                    {{-- Image --}}
                                    @if($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="Image News" class="w-full h-48 object-cover rounded-lg mb-4">
                                    @endif

                                    <div class="space-y-4">
                                        {{-- Titre --}}
                                        <h2 class="text-xl font-bold text-blue-600 mb-4 border-b border-gray-200 pb-2">{{ $item->title }}</h2>

                                        {{-- Contenu avec scroll vertical si nécessaire --}}
                                        <div class="text-sm text-gray-700 leading-relaxed overflow-y-auto max-h-40 pr-2 overflow-x-hidden">
                                            {{ $item->content }}
                                        </div>
                                    </div>

                                    {{-- Bas de la carte sans la date --}}
                                    <div class="mt-6 flex items-center justify-between text-xs text-gray-500">
                                        <div class="flex items-center gap-2">
                                            <div class="w-9 h-9 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                                                <i class="far fa-clock text-blue-400"></i>
                                            </div>
                                            <span>Posté {{ \Carbon\Carbon::parse($item->date_news)->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Colonne Événements -->
                    <div class="lg:w-1/2">
                        <h3 class="text-2xl font-bold text-indigo-800 mb-6 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Derniers Événements
                        </h3>

                        @php
                            $latestEvents = \App\Models\Evenement::orderBy('date', 'desc')
                                ->take(3)
                                ->get();
                        @endphp

                        @if($latestEvents->isEmpty())
                            <div class="bg-white rounded-xl border border-blue-100 shadow-md p-6 text-center">
                                <p class="text-gray-500">Aucun événement disponible</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 gap-6">
                                @foreach($latestEvents as $evenement)
                                @php
                                    $eventDate = \Carbon\Carbon::parse($evenement->date);
                                    $isPast = $eventDate->isPast();
                                @endphp

                                <div class="relative group">
                                    <!-- Trait stylé à gauche -->
                                    <div class="absolute -left-3 top-6 h-4 w-1.5 bg-blue-500 rounded-full"></div>

                                    <div class="h-full flex flex-col justify-between rounded-xl border border-blue-100 shadow-md bg-white p-6 transition-all duration-300 transform hover:shadow-xl hover:-translate-y-1 overflow-hidden {{ $isPast ? 'backdrop-blur-[2px] bg-white/90' : 'bg-gradient-to-br from-blue-50 via-white to-blue-100' }}">
                                        <div class="space-y-4">
                                            <h2 class="text-xl font-bold text-gray-800 group-hover:text-blue-600 transition duration-300">{{ $evenement->titre }}</h2>

                                            <div class="space-y-2 text-sm text-gray-600">
                                                <div class="flex items-center gap-2">
                                                    <i class="far fa-calendar-alt text-blue-500"></i>
                                                    <span>{{ $eventDate->translatedFormat('d M Y') }}</span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <i class="far fa-clock text-blue-500"></i>
                                                    <span>{{ $evenement->heure_debut }} - {{ $evenement->heure_fin }}</span>
                                                </div>
                                            </div>

                                            @unless($isPast)
                                                <span class="inline-block mt-3 px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full shadow-sm">🆕 Nouveau</span>
                                            @else
                                                <div class="absolute inset-0 flex items-center justify-center bg-white/70 backdrop-blur-[2px]">
                                                    <span class="text-blue-800 text-sm font-bold">Événement terminé</span>
                                                </div>
                                            @endunless
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <x-chat-button></x-chat-button>
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
    function updateDateTime() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const date = now.toLocaleDateString('fr-FR', options);
        const time = now.toLocaleTimeString('fr-FR');
        document.getElementById('current-date-time').textContent = `Nous sommes le ${date}, il est ${time}.`;
    }

    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>

</x-home>
