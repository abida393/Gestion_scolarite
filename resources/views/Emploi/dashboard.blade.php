<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<div class="bg-gray-100 font-sans">
    <div class="max-w-7xl mx-auto py-10 px-6">
        <h1 class="text-3xl font-bold text-center text-blue-800 mb-10 uppercase tracking-wide">
            Tableau de Bord - Cours de {{ ucfirst($today) }}
        </h1>

        @if($emploisTemps->isEmpty())
            <div class="text-gray-500 text-center">
                🎉 Pas de cours prévu aujourd'hui !
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($emploisTemps as $cours)
                    <div class="bg-gradient-to-r from-blue-100 to-blue-200 p-4 rounded-lg shadow flex flex-col justify-between h-full">
                        <div class="flex justify-between items-center mb-2">
                            <span class="bg-blue-600 text-white text-xs px-3 py-1 rounded-full shadow">{{ $cours->matiere->name }}</span>
                            <span class="text-sm font-semibold text-gray-600">{{ $cours->salle }}</span>
                        </div>

                        <div class="text-sm text-gray-700 mb-1">
                            📅 {{ \Carbon\Carbon::parse($cours->date)->format('d/m/Y') }}
                        </div>

                        <div class="text-sm text-gray-700 mb-1">
                            🕒 {{ \Carbon\Carbon::parse($cours->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($cours->heure_fin)->format('H:i') }}
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
</html>