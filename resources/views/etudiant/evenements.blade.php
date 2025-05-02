<x-home titre="events-page" page_titre="events-page" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">
  <div class="max-w-7xl mx-auto px-4 py-12">
    <!-- En-tête -->
    <div class="text-center mb-10">
      <h1 class="text-3xl font-bold text-indigo-800 mb-2 mx-auto text-center">
        <i class="fas fa-calendar-times mr-2"></i>Mes Événements
      </h1>
      <p class="text-gray-500 mb-6 text-center">Vous trouverez ici tous les événements.</p>
    </div>

    <!-- Grille des événements -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
      @foreach($evenements->sortByDesc('date') as $evenement)
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

      @if($evenements->isEmpty())
        <p class="col-span-full text-center text-gray-500 text-sm">Aucun événement trouvé pour le moment.</p>
      @endif
    </div>
  </div>
</x-home>
