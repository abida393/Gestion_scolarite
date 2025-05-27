<x-admin titre="notes" page_titre="Saisie des Notes" :nom_complete="Auth::guard('responsable')->user()->respo_nom . ',' . Auth::guard('responsable')->user()->respo_prenom">
    <div class="p-6 bg-white rounded-lg shadow-md">
        <div class="flex gap-4 mb-6">
            <button id="btn-saisie" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Saisie Note</button>
            <button id="btn-affiche" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Affiche Note</button>
        </div>

        {{-- Section Saisie des notes --}}
        <div id="saisie-section">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Saisie des notes</h2>

            <form method="POST" action="{{ route('notes.store') }}" class="bg-gray-50 p-6 rounded-lg">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="space-y-2">
                        <label for="filiere" class="block text-sm font-medium text-gray-700">Filière</label>
                        <select name="filiere_id" id="filiere" class="select-form" required>
                            <option value="">-- Choisir une filière --</option>
                            @foreach($filieres as $filiere)
                                <option value="{{ $filiere->id }}">{{ $filiere->nom_filiere }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label for="classe" class="block text-sm font-medium text-gray-700">Classe</label>
                        <select name="classe_id" id="classe" class="select-form" required></select>
                    </div>

                    <div class="space-y-2">
                        <label for="module" class="block text-sm font-medium text-gray-700">Module</label>
                        <select name="module_id" id="module" class="select-form" required></select>
                    </div>

                    <div class="space-y-2">
                        <label for="matiere" class="block text-sm font-medium text-gray-700">Matière</label>
                        <select name="matiere_id" id="matiere" class="select-form" required></select>
                    </div>

                    <div class="space-y-2">
                        <label for="exam_number" class="block text-sm font-medium text-gray-700">Quel examen ?</label>
                        <select name="exam_number" id="exam_number" class="select-form" required>
                            <option value="">-- Choisir --</option>
                            <option value="1">Examen 1</option>
                            <option value="2">Examen 2</option>
                        </select>
                    </div>
                </div>

                <div id="etudiants-list" class="mt-8"></div>
            </form>
        </div>

        {{-- Section Affichage des notes --}}
        <div id="affiche-section" style="display: none;">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Liste des Notes</h2>
            <div id="notes-affiche-content">Veuillez d'abord sélectionner la classe et la matière ci-dessus.</div>
        </div>
    </div>

    {{-- Modal d'édition --}}
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg w-full max-w-md">
            <h3 class="text-xl font-bold mb-4">Modifier les notes</h3>
            <form id="editNoteForm">
                @csrf
                <input type="hidden" id="edit_etudiant_id" name="etudiant_id">
                <input type="hidden" id="edit_matiere_id" name="matiere_id">
                
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Étudiant</label>
                    <p id="edit_etudiant_name" class="font-semibold"></p>
                </div>
                
                <div class="mb-4">
                    <label for="edit_note1" class="block text-gray-700 mb-2">Note 1</label>
                    <input type="number" step="0.01" min="0" max="20" id="edit_note1" name="note1" 
                           class="w-full px-3 py-2 border rounded">
                </div>
                
                <div class="mb-4">
                    <label for="edit_note2" class="block text-gray-700 mb-2">Note 2</label>
                    <input type="number" step="0.01" min="0" max="20" id="edit_note2" name="note2" 
                           class="w-full px-3 py-2 border rounded">
                </div>
                
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeEditModal()" 
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const filiereSelect = document.getElementById('filiere');
        const classeSelect = document.getElementById('classe');
        const moduleSelect = document.getElementById('module');
        const matiereSelect = document.getElementById('matiere');
        const examSelect = document.getElementById('exam_number');
        const etudiantsDiv = document.getElementById('etudiants-list');

        const btnSaisie = document.getElementById('btn-saisie');
        const btnAffiche = document.getElementById('btn-affiche');
        const saisieSection = document.getElementById('saisie-section');
        const afficheSection = document.getElementById('affiche-section');
        const notesAfficheDiv = document.getElementById('notes-affiche-content');

        // Gestion des boutons
        btnSaisie.addEventListener('click', () => {
            saisieSection.style.display = 'block';
            afficheSection.style.display = 'none';
        });

        btnAffiche.addEventListener('click', () => {
            saisieSection.style.display = 'none';
            afficheSection.style.display = 'block';
            loadNotesAffiche();
        });

        // Chargement dynamique
        filiereSelect.addEventListener('change', () => {
            const id = filiereSelect.value;
            fetch(`/get-classes/${id}`)
                .then(res => res.json())
                .then(data => {
                    classeSelect.innerHTML = '<option value="">-- Choisir une classe --</option>';
                    data.forEach(classe => {
                        classeSelect.innerHTML += `<option value="${classe.id}">${classe.nom_classe}</option>`;
                    });
                    moduleSelect.innerHTML = '';
                    matiereSelect.innerHTML = '';
                    etudiantsDiv.innerHTML = '';
                });
        });

        classeSelect.addEventListener('change', () => {
            const id = classeSelect.value;
            fetch(`/get-modules/${id}`)
                .then(res => res.json())
                .then(data => {
                    moduleSelect.innerHTML = '<option value="">-- Choisir un module --</option>';
                    data.forEach(mod => {
                        moduleSelect.innerHTML += `<option value="${mod.id}">${mod.nom_module}</option>`;
                    });
                });
            loadEtudiants();
        });

        moduleSelect.addEventListener('change', () => {
            const id = moduleSelect.value;
            fetch(`/get-matieres-from-module/${id}`)
                .then(res => res.json())
                .then(data => {
                    matiereSelect.innerHTML = '<option value="">-- Choisir une matière --</option>';
                    data.forEach(mat => {
                        matiereSelect.innerHTML += `<option value="${mat.id}">${mat.nom_matiere}</option>`;
                    });
                });
        });

        matiereSelect.addEventListener('change', loadEtudiants);
        examSelect.addEventListener('change', loadEtudiants);

        function loadEtudiants() {
            const classeId = classeSelect.value;
            const exam = examSelect.value;
            if (!classeId || !exam) return;

            fetch(`/get-etudiants/${classeId}`)
                .then(res => res.json())
                .then(data => {
                    let html = `
                        <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 border">Nom</th>
                                    <th class="px-4 py-2 border">Prénom</th>
                                    <th class="px-4 py-2 border">Note ${exam}</th>
                                </tr>
                            </thead>
                            <tbody>`;
                    data.forEach(e => {
                        html += `
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border">${e.etudiant_nom}</td>
                                <td class="px-4 py-2 border">${e.etudiant_prenom}</td>
                                <td class="px-4 py-2 border">
                                    <input type="number" step="0.01" name="notes[${e.id}][note${exam}]" class="w-20 px-2 py-1 border rounded" required>
                                </td>
                            </tr>`;
                    });
                    html += `
                            </tbody>
                        </table>
                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Enregistrer les notes</button>
                        </div>`;
                    etudiantsDiv.innerHTML = html;
                });
        }

        function loadNotesAffiche() {
            const classeId = classeSelect.value;
            const matiereId = matiereSelect.value;
            if (!classeId || !matiereId) {
                notesAfficheDiv.innerHTML = `<p class="text-red-600">Veuillez choisir une classe et une matière.</p>`;
                return;
            }

            fetch(`/affiche-notes/${classeId}/${matiereId}`)
                .then(res => res.json())
                .then(data => {
                    let html = `
                        <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 border">Nom</th>
                                    <th class="px-4 py-2 border">Prénom</th>
                                    <th class="px-4 py-2 border">Note 1</th>
                                    <th class="px-4 py-2 border">Note 2</th>
                                    <th class="px-4 py-2 border">Note Finale</th>
                                    <th class="px-4 py-2 border">Actions</th>
                                </tr>
                            </thead>
                            <tbody>`;
                    data.forEach(note => {
                        html += `
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border">${note.nom}</td>
                                <td class="px-4 py-2 border">${note.prenom}</td>
                                <td class="px-4 py-2 border">${note.note1 ?? '-'}</td>
                                <td class="px-4 py-2 border">${note.note2 ?? '-'}</td>
                                <td class="px-4 py-2 border font-semibold">${note.note_finale ?? '-'}</td>
                                <td class="px-4 py-2 border">
                                    <button onclick="openEditModal('${note.nom}', '${note.prenom}', ${note.note1 ?? 'null'}, ${note.note2 ?? 'null'}, ${matiereId}, ${note.etudiant_id})" 
                                            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        Modifier
                                    </button>
                                </td>
                            </tr>`;
                    });
                    html += '</tbody></table>';
                    notesAfficheDiv.innerHTML = html;
                })
                .catch(() => {
                    notesAfficheDiv.innerHTML = `<p class="text-red-600">Erreur lors du chargement des notes.</p>`;
                });
        }

        // Fonctions pour gérer le modal d'édition
        function openEditModal(nom, prenom, note1, note2, matiereId, etudiantId) {
            const modal = document.getElementById('editModal');
            document.getElementById('edit_etudiant_name').textContent = `${nom} ${prenom}`;
            document.getElementById('edit_note1').value = note1 !== null ? note1 : '';
            document.getElementById('edit_note2').value = note2 !== null ? note2 : '';
            document.getElementById('edit_matiere_id').value = matiereId;
            document.getElementById('edit_etudiant_id').value = etudiantId;
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Gestion de la soumission du formulaire
        document.addEventListener('DOMContentLoaded', function() {
            document.body.addEventListener('submit', function(e) {
                if (e.target && e.target.id === 'editNoteForm') {
                    e.preventDefault();
                    
                    const formData = new FormData(e.target);
                    const data = Object.fromEntries(formData.entries());
                    
                    fetch('/notes/update', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.success);
                            closeEditModal();
                            loadNotesAffiche(); // Recharger les notes
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Une erreur est survenue lors de la mise à jour');
                    });
                }
            });
        });
    </script>

    <style>
        .select-form {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
        }
    </style>
</x-admin>