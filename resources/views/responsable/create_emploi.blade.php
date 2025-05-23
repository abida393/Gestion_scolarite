<!-- resources/views/responsable/create.blade.php -->
<x-admin titre="Ajouter un Cours" page_titre="Ajouter un Cours" :nom_complete="Auth::guard('responsable')->user()->respo_nom . ',' . Auth::guard('responsable')->user()->respo_prenom">

<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Ajouter un nouveau cours</h2>

        <form action="{{ route('responsable.store') }}" method="POST">
            @csrf

            <input type="hidden" name="classe_id" value="{{ request('classe_id') }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Jour -->
                <div>
                    <label for="jour" class="block text-sm font-medium text-gray-700 mb-1">Jour</label>
                    <select name="jour" id="jour" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Sélectionner un jour</option>
                        <option value="Lundi">Lundi</option>
                        <option value="Mardi">Mardi</option>
                        <option value="Mercredi">Mercredi</option>
                        <option value="Jeudi">Jeudi</option>
                        <option value="Vendredi">Vendredi</option>
                        <option value="Samedi">Samedi</option>
                    </select>
                </div>

                <!-- Date -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" name="date" id="date" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Heure de début -->
                <div>
                    <label for="heure_debut" class="block text-sm font-medium text-gray-700 mb-1">Heure de début</label>
                    <input type="time" name="heure_debut" id="heure_debut" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <!-- Heure de fin -->
                <div>
                    <label for="heure_fin" class="block text-sm font-medium text-gray-700 mb-1">Heure de fin</label>
                    <input type="time" name="heure_fin" id="heure_fin" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Matière -->
                <div>
                    <label for="matiere_id" class="block text-sm font-medium text-gray-700 mb-1">Matière</label>
                    <select name="matiere_id" id="matiere_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Sélectionner une matière</option>
                        @foreach($matieres as $matiere)
                            <option value="{{ $matiere->id }}" data-color="{{ $matiere->couleur ?? 'blue' }}">
                                {{ $matiere->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Enseignant -->
                <div>
                    <label for="enseignant_id" class="block text-sm font-medium text-gray-700 mb-1">Enseignant</label>
                    <select name="enseignant_id" id="enseignant_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Sélectionner un enseignant</option>
                        @foreach($enseignants as $enseignant)
                            <option value="{{ $enseignant->id }}">
                                {{ $enseignant->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Salle -->
            <div class="mb-6">
                <label for="salle" class="block text-sm font-medium text-gray-700 mb-1">Salle</label>
                <input type="text" name="salle" id="salle" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Boutons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('responsable.emploi') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                    Annuler
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                    Ajouter le cours
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Validation des heures
    document.getElementById('heure_fin').addEventListener('change', function() {
        const debut = document.getElementById('heure_debut').value;
        const fin = this.value;

        if (debut && fin && fin <= debut) {
            alert('L\'heure de fin doit être après l\'heure de début');
            this.value = '';
        }
    });

    // Mise à jour automatique de la date en fonction du jour sélectionné
    document.getElementById('jour').addEventListener('change', function() {
        if (!this.value || !document.getElementById('date').value) return;

        const date = new Date(document.getElementById('date').value);
        const jours = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        const jourSelectionne = this.value;

        // Trouver le prochain jour correspondant
        while (jours[date.getDay()] !== jourSelectionne) {
            date.setDate(date.getDate() + 1);
        }

        document.getElementById('date').valueAsDate = date;
    });
</script>

</x-admin>
