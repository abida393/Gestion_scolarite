<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Ajouter un Emploi du Temps</title>
</head>
<body class="bg-gray-100 font-sans">

<div class="max-w-3xl mx-auto py-10 px-6">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-10 uppercase">Ajouter un Cours</h1>

    <form action="{{ route('emploi.store') }}" method="POST" class="bg-white p-8 rounded-lg shadow-md space-y-6 border border-gray-200">
        @csrf

        <!-- Formation, Filière et Classe -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Formation</label>
            <input type="text" value="{{ $formation->nom_formation }}" class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly>
            <input type="hidden" name="formation_id" value="{{ $formation->id }}">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Filière</label>
            <input type="text" value="{{ $filiere->nom_filiere }}" class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly>
            <input type="hidden" name="filiere_id" value="{{ $filiere->id }}">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Classe</label>
            <input type="text" value="{{ $classe->nom_classe }}" class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly>
            <input type="hidden" name="classe_id" value="{{ $classe->id }}">
        </div>

        <!-- Jour -->
        <div>
            <label for="jour" class="block text-sm font-semibold text-gray-700 mb-1">Jour</label>
            <select name="jour" id="jour" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                <option value="Lundi">Lundi</option>
                <option value="Mardi">Mardi</option>
                <option value="Mercredi">Mercredi</option>
                <option value="Jeudi">Jeudi</option>
                <option value="Vendredi">Vendredi</option>
                <option value="Samedi">Samedi</option>
                <option value="Dimanche">Dimanche</option>
            </select>
        </div>

        <!-- Date et Salle -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="date" class="block text-sm font-semibold text-gray-700 mb-1">Date</label>
                <input type="date" name="date" id="date" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label for="salle" class="block text-sm font-semibold text-gray-700 mb-1">Salle</label>
                <input type="text" name="salle" id="salle" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>
        </div>

        <!-- Heure de début et Heure de fin -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="heure_debut" class="block text-sm font-semibold text-gray-700 mb-1">Heure de début</label>
                <input type="time" name="heure_debut" id="heure_debut" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label for="heure_fin" class="block text-sm font-semibold text-gray-700 mb-1">Heure de fin</label>
                <input type="time" name="heure_fin" id="heure_fin" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>
        </div>

        <!-- Matière et Enseignant -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="matiere_id" class="block text-sm font-semibold text-gray-700 mb-1">Matière</label>
                <select name="matiere_id" id="matiere_id" class="w-full px-4 py-2 border rounded-lg" required>
                    @foreach ($matieres as $matiere)
                        <option value="{{ $matiere->id }}">{{ $matiere->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="enseignant_id" class="block text-sm font-semibold text-gray-700 mb-1">Enseignant</label>
                <select name="enseignant_id" id="enseignant_id" class="w-full px-4 py-2 border rounded-lg" required>
                    @foreach ($enseignants as $enseignant)
                        <option value="{{ $enseignant->id }}">{{ $enseignant->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Bouton Ajouter -->
        <div class="pt-4 flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition shadow">
                ➕ Ajouter
            </button>
        </div>
    </form>
</div>

<!-- Affichage des erreurs -->
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded-lg">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

</body>
</html>