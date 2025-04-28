<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emploi du Temps</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">

@if (session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="max-w-7xl mx-auto p-8">
    <h1 class="text-3xl font-bold text-center text-blue-800 mb-8 uppercase tracking-wide">
        Emploi du Temps 
        @if (request('classe_id'))
            de "{{ $classes->firstWhere('id', request('classe_id'))->nom_classe }}"
        @endif
    </h1>

    <!-- Boutons pour ajouter un cours ou un emploi -->
    <div class="flex justify-end mb-4 space-x-2">
        <a href="{{ route('emploi.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded shadow font-semibold text-sm sm:text-base">
            + Ajouter un cours
        </a>
        <a href="{{ route('emploi.create_complet') }}" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded shadow font-semibold text-sm sm:text-base">
            ➕ Créer un nouvel emploi du temps
        </a>
    </div>

    <!-- Formulaire de filtre -->
    <form action="{{ route('emploi') }}" method="GET" class="mb-6">
        <div class="flex items-center space-x-4">
            <label for="classe_id" class="text-sm font-semibold text-gray-700">Filtrer par classe :</label>
            <select name="classe_id" id="classe_id" class="w-full max-w-xs px-4 py-2 border rounded-lg">
                <option value="">-- Toutes les classes --</option>
                @foreach ($classes as $classe)
                    <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                        {{ $classe->nom_classe }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                Filtrer
            </button>
        </div>
    </form>

    <!-- Affichage des emplois du temps -->
    @if (request('classe_id'))
        @php
            $emploisClasse = $emploisTemps->where('classe_id', request('classe_id'));
            $jourOrdre = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
            $grouped = $emploisClasse->sortBy(function($e) use ($jourOrdre) {
                return array_search(strtolower($e->jour), $jourOrdre);
            })->groupBy('jour');
        @endphp

        @if ($emploisClasse->isEmpty())
            <p class="text-center text-gray-600">Aucun emploi du temps trouvé pour cette classe.</p>
        @else
            <h2 class="text-2xl font-semibold text-gray-800 mt-10 mb-4">
                {{ $classes->firstWhere('id', request('classe_id'))->nom_classe }}
            </h2>
            <div class="overflow-x-auto rounded-lg shadow mb-8">
                <table class="min-w-full border-collapse bg-white text-gray-700 text-sm">
                    <thead class="bg-blue-100 text-gray-900 uppercase text-xs sm:text-sm tracking-wider text-center">
                        <tr>
                            <th class="py-3 px-4 border text-left">Jour</th>
                            <th class="py-3 px-4 border">Cours 1</th>
                            <th class="py-3 px-4 border">Cours 2</th>
                            <th class="py-3 px-4 border">Cours 3</th>
                            <th class="py-3 px-4 border">Cours 4</th>
                            <th class="py-3 px-4 border">Cours 5</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($grouped as $jour => $coursDuJour)
                            <tr class="text-center hover:bg-gray-50 border-t border-gray-200" style="height: 120px;">
                                <td class="px-4 py-2 border text-left font-semibold text-gray-800">{{ ucfirst($jour) }}</td>

                                @php
                                    $maxCours = 5;
                                    $coursCount = count($coursDuJour);
                                @endphp

                                @foreach ($coursDuJour as $cours)
                                    <td class="px-2 py-4 border align-top">
                                        <div class="flex flex-col items-center justify-center space-y-2 break-words text-xs sm:text-sm">
                                            <div class="font-bold text-blue-800">{{ $cours->matiere->name }}</div>
                                            <div class="flex flex-col items-center text-gray-600 font-medium">
                                                <span>{{ \Carbon\Carbon::parse($cours->date)->format('d/m/Y') }}</span>
                                                <span>{{ $cours->enseignant->name }}</span>
                                                <span>{{ \Carbon\Carbon::parse($cours->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($cours->heure_fin)->format('H:i') }}</span>
                                            </div>
                                            <div class="text-gray-700 font-semibold text-center">
                                                <strong>{{ $cours->salle }}</strong>
                                            </div>

                                            <!-- Boutons Modifier et Supprimer -->
                                            <div class="flex space-x-2 mt-2">
    <!-- Modifier -->
    <a href="{{ route('emploi.edit', $cours->id) }}" 
       class="text-blue-500 hover:text-blue-700 text-xs sm:text-sm font-semibold">
        Modifier
    </a>

    <!-- Supprimer -->
    <form action="{{ route('emploi.destroy', $cours->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?');">
        @csrf
        @method('DELETE')
        <button type="submit" 
                class="text-red-500 hover:text-red-700 text-xs sm:text-sm font-semibold">
            Supprimer
        </button>
    </form>
</div>
                                        </div>
                                    </td>
                                @endforeach

                                {{-- Cases vides si besoin --}}
                                @for ($i = $coursCount; $i < $maxCours; $i++)
                                    <td class="border bg-gray-50"></td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @else
        <p class="text-center text-gray-600">Veuillez sélectionner une classe pour afficher son emploi du temps.</p>
    @endif
</div>

</body>
</html>