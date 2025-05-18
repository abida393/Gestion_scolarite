<x-home titre="absences-page" page_titre="absences-page" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">
    <style>
        /* Scrollbar fine et discrète */
        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #a0aec0;
            border-radius: 20px;
        }
    </style>
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- En-tête -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-indigo-800 mb-2">
                <i class="fas fa-calendar-times mr-2"></i>Mes Absences
            </h1>
            <p class="text-gray-500">Historique de vos absences enregistrées</p>
        </div>

        @if (count($absences) > 0)
            <!-- Filtres -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <h2 class="text-xl font-semibold text-indigo-700 mb-4">
                    <i class="fas fa-filter mr-2"></i>Filtrer les absences
                </h2>
                <div class="flex flex-wrap gap-3 justify-center">
                    <button onclick="filterAbsences('all')"
                        class="px-4 py-2 rounded-full font-medium bg-indigo-100 text-indigo-700 hover:bg-indigo-200 transition-all">
                        Toutes
                    </button>
                    <button onclick="filterAbsences('justified')"
                        class="px-4 py-2 rounded-full font-medium bg-green-100 text-green-700 hover:bg-green-200 transition-all">
                        Justifiées
                    </button>
                    <button onclick="filterAbsences('pending')"
                        class="px-4 py-2 rounded-full font-medium bg-yellow-100 text-yellow-700 hover:bg-yellow-200 transition-all">
                        En validation
                    </button>
                    <button onclick="filterAbsences('unjustified')"
                        class="px-4 py-2 rounded-full font-medium bg-red-100 text-red-700 hover:bg-red-200 transition-all">
                        Non justifiées
                    </button>
                </div>
            </div>

            <!-- Liste des absences -->
            <section class="space-y-5 mb-12" id="absence-list">
                @foreach ($absences as $absence)
                    <div class="absence-container">
                        <article
                            class="absence-card bg-white rounded-xl shadow-md overflow-hidden border-l-4
                            @if ($absence->justifier == 1) border-green-500
                            @elseif(!$absence->justifier && $absence->justification != null) border-yellow-500
                            @else border-red-500 @endif
                            transition-all hover:shadow-lg hover:-translate-y-0.5"
                            data-status="@if ($absence->justifier == 1) justified
                                        @elseif(!$absence->justifier && $absence->justification != null)pending
                                        @else unjustified @endif">

                            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                                <div class="flex items-center text-lg font-semibold text-gray-700">
                                    <i class="far fa-calendar-alt text-indigo-500 mr-2"></i>
                                    {{ \Carbon\Carbon::parse($absence->date_justif)->format('d/m/Y') }}
                                </div>

                                @if ($absence->justifier == 1)
                                    <span
                                        class="status px-3 py-1 rounded-full text-sm font-medium bg-green-50 text-green-600">
                                        <i class="fas fa-check-circle mr-1"></i>Justifiée
                                    </span>
                                @elseif(!$absence->justifier && $absence->justification != null)
                                    <span
                                        class="status px-3 py-1 rounded-full text-sm font-medium bg-yellow-50 text-yellow-600">
                                        <i class="fas fa-hourglass-half mr-1"></i>En validation
                                    </span>
                                @else
                                    <span
                                        class="status px-3 py-1 rounded-full text-sm font-medium bg-red-50 text-red-600">
                                        <i class="fas fa-times-circle mr-1"></i>Non justifiée
                                    </span>
                                @endif
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 p-5">
                                <div>
                                    <p class="text-sm text-gray-500 flex items-center">
                                        <i class="far fa-bookmark text-indigo-400 mr-2"></i>Matiére
                                    </p>
                                    <p class="font-medium">
                                        {{ $absence->seance->matiere->nom_matiere ?? 'Séance inconnue' }}</p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500 flex items-center">
                                        <i class="far fa-clock text-indigo-400 mr-2"></i>Heures
                                    </p>
                                    <p class="font-medium">
                                        {{ $absence->seance ? $absence->seance->heure_debut : '--:--' }} -
                                        {{ $absence->seance ? $absence->seance->heure_fin : '--:--' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500 flex items-center">
                                        <i class="far fa-comment-alt text-indigo-400 mr-2"></i>Justification
                                    </p>
                                    <p class="font-medium">{{ $absence->justification ?? '-' }}</p>
                                </div>

                                <!-- Affichage du document justificatif -->
                                @if ($absence->justification_file)
                                    <div>
                                        <p class="text-sm text-gray-500 flex items-center">
                                            <i class="far fa-file-alt text-indigo-400 mr-2"></i>Document
                                        </p>
                                        <p class="font-medium">
                                            <a href="{{ asset('storage/' . $absence->justification_file) }}"
                                                target="_blank" class="text-blue-500 hover:underline">
                                                {{ basename($absence->justification_file) }}
                                            </a>
                                        </p>
                                    </div>
                                @endif
                            </div>

                            @if (!$absence->justifier && $absence->justification == null)
                                <div class="px-5 pb-5">
                                    <button onclick="toggleJustificationForm('{{ $absence->id }}', this)"
                                        class="w-full md:w-auto px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-medium transition-all flex items-center justify-center">
                                        <i class="fas fa-file-upload mr-2"></i>Justifier cette absence
                                    </button>
                                </div>
                            @endif
                        </article>

                        <!-- Formulaire de justification pour cette absence spécifique -->
                        <div id="justification-form-{{ $absence->id }}"
                            class="justification-form hidden bg-white rounded-xl shadow-md p-6 mt-4">
                            <header class="mb-6">
                                <h2 class="text-xl font-bold text-indigo-800 flex items-center">
                                    <i class="far fa-edit mr-3"></i>Justifier cette absence
                                </h2>
                                <p class="text-gray-500 text-sm mt-1">Pour la séance du
                                    {{ \Carbon\Carbon::parse($absence->date_justif)->format('d/m/Y') }}</p>
                            </header>

                            <form action="{{ route('justifier-absence') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="absence_id" value="{{ $absence->id }}">

                                <div class="mb-6">
                                    <label for="justification-text-{{ $absence->id }}"
                                        class="block text-gray-700 font-medium mb-2 flex items-center">
                                        <i class="far fa-file-alt text-indigo-500 mr-2"></i>Motif de l'absence
                                    </label>
                                    <textarea id="justification-text-{{ $absence->id }}" name="justification" required
                                        placeholder="Décrivez précisément le motif de votre absence..."
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all min-h-[120px]"></textarea>
                                </div>

                                <div class="mb-6">
                                    <label for="justification-file-{{ $absence->id }}"
                                        class="block text-gray-700 font-semibold mb-2">
                                        <span class="flex items-center">
                                            <i class="far fa-file-pdf text-red-500 mr-2 text-lg"></i>Joindre un
                                            justificatif (PDF uniquement)
                                        </span>
                                    </label>

                                    <div
                                        class="relative border-2 border-dashed border-gray-300 rounded-lg p-5 text-center hover:border-indigo-400 transition-all">
                                        <input type="file" id="justification-file-{{ $absence->id }}"
                                            name="justification_file" accept="application/pdf"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />

                                        <div class="text-gray-500 z-0 pointer-events-none">
                                            <i class="fas fa-upload text-indigo-500 text-3xl mb-2"></i>
                                            <p class="text-sm">Cliquez ici ou glissez un fichier PDF</p>
                                        </div>

                                        <!-- Affichage dynamique du nom du fichier ici -->
                                        <div id="file-name-display-{{ $absence->id }}"
                                            class="mt-3 text-sm text-indigo-600 font-medium"></div>
                                    </div>
                                </div>
                                <div class="flex justify-end space-x-3">
                                    <button type="button"
                                        onclick="toggleJustificationForm('{{ $absence->id }}', this.closest('.absence-container').querySelector('button'))"
                                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium transition-all">
                                        Annuler
                                    </button>
                                    <button type="submit"
                                        class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-all flex items-center">
                                        <i class="far fa-paper-plane mr-2"></i>Soumettre
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </section>

            <!-- Message si aucune absence ne correspond au filtre -->
            <div id="no-results" class="hidden text-center py-10 bg-white rounded-xl shadow">
                <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
                <p class="text-gray-500 text-lg">Aucune absence trouvée pour ce filtre</p>
            </div>
        @else
            <!-- Message si aucune absence du tout -->
            <div class="text-center py-10 bg-white rounded-xl shadow">
                <i class="fas fa-check-circle text-4xl text-green-500 mb-4"></i>
                <p class="text-gray-500 text-lg">Vous n'avez aucune absence enregistrée</p>
            </div>
        @endif
    </div>

    <script>
        function filterAbsences(filter) {
            const containers = document.querySelectorAll('.absence-container');
            let hasVisibleCards = false;

            containers.forEach(container => {
                const card = container.querySelector('.absence-card');
                const status = card.getAttribute('data-status').trim();

                if (filter === 'all' || status === filter) {
                    container.style.display = 'block';
                    hasVisibleCards = true;
                    // Close any open forms
                    const form = container.querySelector('.justification-form');
                    if (form) form.classList.add('hidden');
                } else {
                    container.style.display = 'none';
                }
            });

            const noResults = document.getElementById('no-results');
            if (noResults) {
                noResults.style.display = hasVisibleCards ? 'none' : 'block';
            }
        }

        function toggleJustificationForm(absenceId, button) {
            const container = button.closest('.absence-container');
            const form = container.querySelector(`#justification-form-${absenceId}`);

            // Close all other open forms
            document.querySelectorAll('.justification-form').forEach(otherForm => {
                if (otherForm !== form) {
                    otherForm.classList.add('hidden');
                }
            });

            // Toggle current form
            form.classList.toggle('hidden');

            // Scroll to form if opened
            if (!form.classList.contains('hidden')) {
                form.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });

                // Focus the textarea
                const textarea = form.querySelector('textarea');
                if (textarea) textarea.focus();
            }
        }

        // Initialize file name displays
        function setupFileInputs() {
            document.querySelectorAll('input[type="file"][name="justification_file"]').forEach(input => {
                const id = input.id.split('-')[2]; // Get the absence ID
                const displayElement = document.getElementById(`file-name-display-${id}`);

                input.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        displayElement.textContent = this.files[0].name;
                    } else {
                        displayElement.textContent = '';
                    }
                });
            });
        }

        // Initialize on DOM load
        document.addEventListener('DOMContentLoaded', function() {
            @if (count($absences) > 0)
                filterAbsences('all');
            @endif
            setupFileInputs();
        });
    </script>
    <x-chat-button></x-chat-button>
</x-home>
