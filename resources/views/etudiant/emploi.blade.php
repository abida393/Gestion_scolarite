
<x-home titre="emploi" page_titre="emploi" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">

<div class="bg-gradient-to-br from-gray-100 to-white min-h-screen font-sans">
    <div class="max-w-7xl mx-auto py-12 px-6 sm:px-10 lg:px-20">

        <!-- Titre principal -->
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-center text-gray-800 mb-12 tracking-wide uppercase">
            Emploi du Temps – {{ $classeName ?? 'Classe Non Spécifiée' }}
        </h1>

        @if ($emploisTemps->isEmpty())
            <div class="text-center text-gray-600 text-lg">
                Aucun emploi du temps disponible pour votre classe.
            </div>
        @else

        <!-- Bouton de téléchargement -->
        <div class="flex justify-end mb-6">
            <a href="{{ route('emploi_etudiant.download') }}"
               class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold px-5 py-3 rounded-xl shadow-lg transition-all duration-200 ease-in-out">
                📥 Télécharger mon emploi du temps
            </a>
        </div>

        <!-- Tableau des emplois du temps -->
        <div class="overflow-x-auto rounded-2xl shadow-2xl">
            <table class="w-full border border-gray-200 bg-white text-sm sm:text-base text-gray-700">
                <thead class="bg-indigo-100 text-gray-900 uppercase text-xs sm:text-sm tracking-widest">
                    <tr class="text-center">
                        <th class="py-4 px-4 border text-left font-semibold text-indigo-700">Jour</th>
                        @php
                            $horaires = [];
                            $start = \Carbon\Carbon::createFromTime(8, 45);
                            $end = \Carbon\Carbon::createFromTime(17, 30);
                            while ($start->copy()->addMinutes(90) <= $end) {
                                $fin = $start->copy()->addMinutes(90);
                                $horaires[] = [$start->format('H:i'), $fin->format('H:i')];
                                $start = $fin->copy()->addMinutes(15); // Pause
                            }
                        @endphp
                        @foreach ($horaires as $h)
                            <th class="py-4 px-4 border text-center">
                                <span>{{ $h[0] }} - {{ $h[1] }}</span>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                @php
                    $joursSemaine = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
                    $grouped = $emploisTemps->map(function($e) {
                       $e->jour = strtolower(trim($e->jour));
                        return $e;
                    })->groupBy('jour');
                @endphp

                @foreach ($joursSemaine as $jour)
                    <tr class="text-center hover:bg-gray-50 border-t border-gray-200">
                        <td class="px-4 py-3 border text-left font-semibold text-indigo-800 bg-gray-50">
                            {{ ucfirst($jour) }}
                        </td>

                        @foreach ($horaires as $h)
                            @php
                                $cours = $grouped->get($jour, collect())->first(function ($e) use ($h) {
                                    return \Carbon\Carbon::parse($e->heure_debut)->format('H:i') == $h[0] && \Carbon\Carbon::parse($e->heure_fin)->format('H:i') == $h[1];
                                });
                            @endphp
              
                            <td class="px-3 py-4 border {{ $cours ? 'bg-white' : 'bg-gray-50' }}">
                                @if ($cours)
                                    <div class="font-bold text-indigo-700 text-sm mb-1">{{ $cours->matiere->name }}</div>
                                    <div class="flex flex-wrap items-center text-xs text-gray-600 font-medium mb-1">
                                        <!-- <span>{{ \Carbon\Carbon::parse($cours->date)->format('d/m') }}</span>
                                        <span class="ml-2">{{ $cours->heure_debut }} - {{ $cours->heure_fin }}</span> -->
                                    </div>
                                     <div class="text-sm text-gray-800 font-semibold">
                                        {{ $cours->enseignant->name ?? 'Non spécifié' }}
                                                 </div>
                                    <div class="text-sm text-gray-700 font-bold">
                                       {{ $cours->salle }}
                                    </div>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @endif

    </div>
</div>

<x-chat-button />
</x-home>