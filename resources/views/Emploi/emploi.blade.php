<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-6">Emploi du Temps</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('emploi.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Ajouter un cours</a>

    <table class="min-w-full bg-white shadow-md rounded-lg">
        <thead>
            <tr class="border-b">
                <th class="py-2 px-4 text-left">Jour</th>
                <th class="py-2 px-4 text-left">Date</th>
                <th class="py-2 px-4 text-left">Heure de début</th>
                <th class="py-2 px-4 text-left">Heure de fin</th>
                <th class="py-2 px-4 text-left">Matière</th>
                <th class="py-2 px-4 text-left">Enseignant</th>
                <th class="py-2 px-4 text-left">Salle</th>
                <th class="py-2 px-4 text-left">Classe</th>
                <th class="py-2 px-4 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($emploisTemps as $emploiTemp)
                <tr class="border-b">
                    <td class="py-2 px-4">{{ $emploiTemp->jour }}</td>
                    <td class="py-2 px-4">{{ $emploiTemp->date }}</td>
                    <td class="py-2 px-4">{{ $emploiTemp->heure_debut }}</td>
                    <td class="py-2 px-4">{{ $emploiTemp->heure_fin }}</td>
                    <td class="py-2 px-4">{{ $emploiTemp->matiere->name }}</td>
                    <td class="py-2 px-4">{{ $emploiTemp->enseignant->name }}</td>
                    <td class="py-2 px-4">{{ $emploiTemp->salle }}</td>
                    <td class="py-2 px-4">{{ $emploiTemp->classe->name }}</td>
                    <td class="py-2 px-4">
                        <a href="{{ route('emploi.edit', $emploiTemp) }}" class="text-blue-500 hover:underline">Modifier</a>
                        |
                        <form action="{{ route('emploi.destroy', $emploiTemp) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet emploi du temps ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>