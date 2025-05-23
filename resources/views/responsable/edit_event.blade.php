<x-admin titre="calendrier" page_titre="calendrier" :nom_complete="Auth::guard('responsable')->user()->respo_nom . ',' . Auth::guard('responsable')->user()->respo_prenom">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Modifier l'Événement</h1>
        <form method="POST" action="{{ route('responsable.calendar.event.update', $event->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Titre</label>
                <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}"
                    class="w-full border border-gray-300 rounded-lg p-3" required>
            </div>
            <div class="mb-4 flex items-center">
                <input type="checkbox" name="is_fixed" id="is_fixed" value="1"
                    {{ old('is_fixed', $event->is_fixed) ? 'checked' : '' }}
                    class="h-5 w-5 text-blue-600 rounded border-gray-300">
                <label for="is_fixed" class="ml-2 text-gray-700">Événement fixe (récurrent)</label>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('responsable.calendrier') }}"
                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</x-admin>
