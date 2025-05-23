<x-admin titre="chatbot" page_titre="chatbot" :nom_complete="Auth::guard('responsable')->user()->respo_nom . ',' . Auth::guard('responsable')->user()->respo_prenom">
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <title>Gestion du Chatbot</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            function toggleEditForm(id) {
                document.querySelectorAll('.edit-form').forEach(form => form.classList.add('hidden'));
                document.getElementById('edit-form-' + id).classList.toggle('hidden');
            }
        </script>
    </head>

    <body class="bg-gray-100 p-6 min-h-screen">
        <div class="max-w-3xl mx-auto bg-white p-6 rounded-2xl shadow-lg">
            <h1 class="text-2xl font-bold mb-4 text-center text-blue-600">Gestion des Réponses du Chatbot</h1>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Formulaire d’ajout --}}
            <form method="POST" action="{{ route('chatbot.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="mot_cle" class="block text-gray-700 font-semibold">Mot Clé</label>
                    <input type="text" name="mot_cle" id="mot_cle"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
                <div>
                    <label for="reponse" class="block text-gray-700 font-semibold">Réponse</label>
                    <textarea name="reponse" id="reponse" rows="3"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required></textarea>
                </div>
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Ajouter</button>
            </form>

            <hr class="my-6">

            <h2 class="text-xl font-bold mb-4 text-gray-700">Réponses existantes</h2>
            <div class="space-y-3">
                @foreach ($reponses as $rep)
                    <div class="bg-gray-50 border rounded p-4 space-y-2">
                        <div class="flex flex-col md:flex-row md:items-center justify-between">
                            <div>
                                <p><strong class="text-blue-700">Mot Clé:</strong> {{ $rep->mot_cle }}</p>
                                <p><strong class="text-blue-700">Réponse:</strong> {{ $rep->reponse }}</p>
                            </div>
                            <div class="flex space-x-2 mt-2 md:mt-0">
                                <button onclick="toggleEditForm({{ $rep->id }})"
                                    class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition">Modifier</button>


                                <form action="{{ route('chatbot.destroy', $rep->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">Supprimer</button>
                                </form>
                            </div>
                        </div>

                        {{-- Formulaire d’édition caché --}}
                        <form action="{{ route('chatbot.update', $rep->id) }}" method="POST"
                            id="edit-form-{{ $rep->id }}" class="edit-form hidden space-y-3 mt-3">
                            @csrf
                            @method('PUT')
                            <div>
                                <label class="text-sm font-medium text-gray-700">Mot Clé</label>
                                <input type="text" name="mot_cle" value="{{ $rep->mot_cle }}"
                                    class="w-full border border-gray-300 rounded px-3 py-2">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-700">Réponse</label>
                                <textarea name="reponse" rows="3" class="w-full border border-gray-300 rounded px-3 py-2">{{ $rep->reponse }}</textarea>
                            </div>
                            <button type="submit"
                                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Enregistrer</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </body>

    </html>


</x-admin>
