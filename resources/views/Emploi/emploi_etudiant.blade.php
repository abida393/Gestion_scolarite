<x-home titre="absences-page" page_titre="absences-page" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">

<div class="bg-gray-100 font-sans">

<div class="max-w-7xl mx-auto py-10 px-6">
    <!-- Titre principal -->
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-10 uppercase tracking-wide">
        Emploi du Temps - {{ $classeName ?? 'Classe Non Spécifiée' }}
    </h1>

    <!-- Vérification des données -->
    @if ($emploisTemps->isEmpty())
        <p class="text-center text-gray-600">Aucun emploi du temps disponible pour votre classe.</p>
    @else
    <!-- Bouton de téléchargement -->
@if (!$emploisTemps->isEmpty())
    <div class="flex justify-end mb-4">
        <a href="{{ route('emploi_etudiant.download') }}"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow font-semibold text-sm sm:text-base">
            📥 Télécharger mon emploi du temps
        </a>
    </div>
@endif
        <!-- Tableau des emplois du temps -->
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 bg-white text-sm text-gray-700 rounded shadow">
                <thead class="bg-blue-100 text-gray-900 uppercase text-xs tracking-wider text-center">
                    <tr>
                        <th class="py-3 px-4 border text-left w-32">Jour</th>
                        <th class="py-3 px-4 border text-center">Cours 1</th>
                        <th class="py-3 px-4 border text-center">Cours 2</th>
                        <th class="py-3 px-4 border text-center">Cours 3</th>
                        <th class="py-3 px-4 border text-center">Cours 4</th>
                        <th class="py-3 px-4 border text-center">Cours 5</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Trier les emplois du temps par jour
                        $jourOrdre = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
                        $grouped = $emploisTemps->sortBy(function($e) use ($jourOrdre) {
                            return array_search(strtolower($e->jour), $jourOrdre);
                        })->groupBy('jour');
                    @endphp

                    @foreach ($grouped as $jour => $coursDuJour)
                        <tr class="text-center hover:bg-gray-50 border-t border-gray-200" style="height: 110px;">
                            <!-- Affichage du jour -->
                            <td class="px-4 py-2 border text-left font-semibold text-gray-800">
                                {{ ucfirst($jour) }}
                            </td>

                            @php
                                $maxCours = 5; // Nombre maximum de cours par jour
                                $coursCount = count($coursDuJour);
                            @endphp

                            <!-- Affichage des cours -->
                            @foreach ($coursDuJour as $cours)
                                <td class="px-2 py-2 border">
                                    <div class="font-bold text-blue-800 text-sm mb-1">{{ $cours->matiere->name }}</div>
                                    <div class="flex flex-col text-xs text-gray-600 font-medium mb-1">
                                        <span> {{ \Carbon\Carbon::parse($cours->date)->format('d/m') }}</span>
                                        <span> {{ \Carbon\Carbon::parse($cours->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($cours->heure_fin)->format('H:i') }}</span>
                                        <span> {{ $cours->enseignant->name }}</span>
                                    </div>
                                    <div class="text-xs text-gray-700">
                                        <strong> {{ $cours->salle }}</strong><br>
                                    </div>
                                </td>
                            @endforeach

                            <!-- Ajouter des cases vides si le nombre de cours est inférieur à 5 -->
                            @for ($i = $coursCount; $i < $maxCours; $i++)
                                <td class="border bg-gray-50"></td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

</div>
<x-chat-button></x-chat-button>
</x-home>
