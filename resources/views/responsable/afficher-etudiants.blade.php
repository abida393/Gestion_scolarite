<x-admin titre="Gestion des Absences" page_titre="Tableau de Bord des Absences" :nom_complete="Auth::guard('responsable')->user()->respo_nom . ' ' . Auth::guard('responsable')->user()->respo_prenom">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Liste des Étudiants</h1>

        <!-- Search and Filter Card -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search Bar -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Rechercher</label>
                    <input type="text" id="search" name="search" placeholder="Nom, Prénom, CNE..."
                        class="w-full p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Class Filter -->
                <div>
                    <label for="class_filter" class="block text-sm font-medium text-gray-700 mb-1">Filtrer par Classe</label>
                    <select id="class_filter" name="class_filter"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Toutes les classes</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->nom_classe}}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Formation Filter -->
                <div>
                    <label for="formation_filter" class="block text-sm font-medium text-gray-700 mb-1">Filtrer par Formation</label>
                    <select id="formation_filter" name="formation_filter"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Toutes les formations</option>
                        @foreach($formations as $formation)
                            <option value="{{ $formation->id }}">{{ $formation->nom_formation }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Students Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom & Prénom</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CNE</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Classe</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Formation</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Téléphone</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="students-table-body">
                        @foreach($etudiants as $etudiant)
                        <tr class="student-row" data-class="{{ $etudiant->classes_id }}" data-formation="{{ $etudiant->formation_id }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ asset('storage/' . $etudiant->PHOTOS) }}" alt="Photo" class="h-10 w-10 rounded-full object-cover">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $etudiant->etudiant_nom }} {{ $etudiant->etudiant_prenom }}</div>
                                <div class="text-sm text-gray-500">{{ $etudiant->etudiant_email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $etudiant->etudiant_cne }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $etudiant->classe->nom_classe }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $etudiant->formation->nom_formation }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $etudiant->etudiant_tel }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('etudiants.edit', $etudiant->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Modifier</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-6 py-4">
                {{ $etudiants->links() }}
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const classFilter = document.getElementById('class_filter');
        const formationFilter = document.getElementById('formation_filter');
        const studentRows = document.querySelectorAll('.student-row');

        function filterStudents() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedClass = classFilter.value;
            const selectedFormation = formationFilter.value;

            studentRows.forEach(row => {
                const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const classId = row.getAttribute('data-class');
                const formationId = row.getAttribute('data-formation');

                const matchesSearch = name.includes(searchTerm);
                const matchesClass = selectedClass === '' || classId === selectedClass;
                const matchesFormation = selectedFormation === '' || formationId === selectedFormation;

                if (matchesSearch && matchesClass && matchesFormation) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', filterStudents);
        classFilter.addEventListener('change', filterStudents);
        formationFilter.addEventListener('change', filterStudents);
    });
    </script>
</x-admin>
