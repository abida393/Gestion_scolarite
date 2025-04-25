<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Document</title>
</head>
<body>
    
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Ajouter un Emploi du Temps</h1>

    <form action="{{ route('emploi.store') }}" method="POST" class="space-y-4">
        @csrf

        <div class="mb-4">
            <label for="jour" class="block text-sm font-medium text-gray-700">Jour</label>
            <input type="text" name="jour" id="jour" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
            <input type="date" name="date" id="date" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="heure_debut" class="block text-sm font-medium text-gray-700">Heure de début</label>
            <input type="time" name="heure_debut" id="heure_debut" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="heure_fin" class="block text-sm font-medium text-gray-700">Heure de fin</label>
            <input type="time" name="heure_fin" id="heure_fin" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="matiere_id" class="block text-sm font-medium text-gray-700">Matière</label>
            <select name="matiere_id" id="matiere_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                @foreach ($matieres as $matiere)
                    <option value="{{ $matiere->id }}">{{ $matiere->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="enseignant_id" class="block text-sm font-medium text-gray-700">Enseignant</label>
            <select name="enseignant_id" id="enseignant_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                @foreach ($enseignants as $enseignant)
                    <option value="{{ $enseignant->id }}">{{ $enseignant->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="salle" class="block text-sm font-medium text-gray-700">Salle</label>
            <input type="text" name="salle" id="salle" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="classe_id" class="block text-sm font-medium text-gray-700">Classe</label>
            <select name="classe_id" id="classe_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                @foreach ($classes as $classe)
                    <option value="{{ $classe->id }}">{{ $classe->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg">Ajouter</button>
        </div>
    </form>
</div>

</body>
</html>