<!-- resources/views/responsable/edit.blade.php -->
<x-admin titre="Modifier un Cours" page_titre="Modifier un Cours">

<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Modifier le cours</h2>
        
<form action="{{ route('responsable.update', $emploiTemps->id) }}" method="POST">
    @csrf
    @method('PUT')

            <!-- Informations de base -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Classe (non modifiable) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Classe</label>
                    <input type="text" value="{{ $emploiTemps->classe->nom_classe }}" class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100" readonly>
                    <input type="hidden" name="classe_id" value="{{ $emploiTemps->classe_id }}">
                </div>
                
                <!-- Jour -->
                <div>
                    <label for="jour" class="block text-sm font-medium text-gray-700 mb-1">Jour</label>
                    <select name="jour" id="jour" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        @foreach(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $jour)
                            <option value="{{ $jour }}" {{ $emploiTemps->jour == $jour ? 'selected' : '' }}>{{ $jour }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Date et horaires -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Date -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>

<input type="date" name="date" id="date" value="{{ \Carbon\Carbon::parse($emploiTemps->date)->format('Y-m-d') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                
                <!-- Heure début -->
                <div>
                    <label for="heure_debut" class="block text-sm font-medium text-gray-700 mb-1">Heure début</label>
                    <input type="time" name="heure_debut" id="heure_debut" value="{{ $emploiTemps->heure_debut }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                
                <!-- Heure fin -->
                <div>
                    <label for="heure_fin" class="block text-sm font-medium text-gray-700 mb-1">Heure fin</label>
                    <input type="time" name="heure_fin" id="heure_fin" value="{{ $emploiTemps->heure_fin }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                </div>
            </div>

            <!-- Matière et enseignant -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Matière -->
                <div>
                    <label for="matiere_id" class="block text-sm font-medium text-gray-700 mb-1">Matière</label>
                    <select name="matiere_id" id="matiere_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Sélectionner une matière</option>
                        @foreach($matieres as $matiere)
                            <option value="{{ $matiere->id }}" {{ $emploiTemps->matiere_id == $matiere->id ? 'selected' : '' }}>
                                {{ $matiere->nom_matiere }}
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
                            <option value="{{ $enseignant->id }}" {{ $emploiTemps->enseignant_id == $enseignant->id ? 'selected' : '' }}>
                                {{ $enseignant->enseignant_nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Salle -->
            <div class="mb-6">
                <label for="salle" class="block text-sm font-medium text-gray-700 mb-1">Salle</label>
                <input type="text" name="salle" id="salle" value="{{ $emploiTemps->salle }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Boutons -->
       <div class="flex justify-end gap-3 mt-8">
    <a href="{{ route('responsable.emploi') }}"
       class="flex items-center bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md font-semibold transition-colors duration-150">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Annuler
    </a>
    <button type="submit"
            class="flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-semibold shadow transition-colors duration-150">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
        Enregistrer
    </button>
</div>
        </form>
    </div>

    <!-- Vérification des conflits -->
    <div id="conflits-container" class="mt-6 hidden">
        <div class="bg-red-50 border-l-4 border-red-500 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800" id="conflit-titre"></h3>
                    <div class="mt-2 text-sm text-red-700" id="conflit-details"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Vérification des conflits en temps réel
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input, select');
        
        inputs.forEach(input => {
            input.addEventListener('change', checkConflits);
        });
    });

    async function checkConflits() {
        const form = document.querySelector('form');
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        
        // On envoie les données au serveur pour vérification
        const response = await fetch('{{ route("responsable.checkConflits") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                ...data,
                emploi_id: '{{ $emploiTemps->id }}' // On exclut l'emploi actuel de la vérification
            })
        });
        
        const result = await response.json();
        const conflitsContainer = document.getElementById('conflits-container');
        
        if (result.conflit) {
            conflitsContainer.classList.remove('hidden');
            document.getElementById('conflit-titre').textContent = 'Conflit détecté !';
            document.getElementById('conflit-details').innerHTML = `
                <p>${result.message}</p>
                <ul class="list-disc pl-5 mt-2">
                    ${result.details.map(d => `<li>${d}</li>`).join('')}
                </ul>
            `;
        } else {
            conflitsContainer.classList.add('hidden');
        }
    }
</script>
</x-admin>