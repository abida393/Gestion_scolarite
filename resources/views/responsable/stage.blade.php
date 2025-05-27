<x-admin titre="Page Stages" page_titre="Page Stages" :nom_complete="Auth::guard('responsable')->user()?->respo_nom . ' ' . Auth::guard('responsable')->user()?->respo_prenom">
    <div class="min-h-screen p-4 md:p-6">
        <!-- Delete Confirmation Modal -->
        <div id="delete-modal"
            class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black bg-opacity-50">
            <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full max-w-md">
                <div class="p-6">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-rose-100 rounded-full mb-4">
                        <i class="fas fa-exclamation-triangle text-rose-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 text-center mb-2">Confirmer la suppression</h3>
                    <p class="text-gray-600 text-center mb-6">Êtes-vous sûr de vouloir supprimer ce stage ? Cette action
                        est irréversible.</p>
                    <div class="flex justify-center space-x-4">
                        <button id="cancel-delete"
                            class="px-6 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors">
                            Annuler
                        </button>
                        <form id="delete-form" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-6 py-2 rounded-lg bg-rose-500 text-white hover:bg-rose-600 transition-colors">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message de succès -->
        @if (session('success'))
            <div
                class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 mb-6 rounded-lg shadow-sm flex items-start animate-fade-in">
                <i class="fas fa-check-circle text-emerald-500 mt-1 mr-3"></i>
                <div>
                    <p class="font-medium">Succès !</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- En-tête -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full mb-4">
                <i class="fas fa-briefcase text-indigo-600 text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Gestion des Stages</h1>
            <p class="text-gray-500 max-w-lg mx-auto">Créez et gérez les offres de stages pour vos étudiants</p>
        </div>

        <div class="max-w-4xl mx-auto space-y-8">
            <!-- Formulaire de création (masqué par défaut) -->
            <div id="stage-form-container"
                class="hidden bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-white-600 to-indigo-500 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-white flex items-center">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Ajouter un nouveau stage
                        </h2>
                        <button onclick="toggleStageForm()"
                            class="text-sm font-medium px-4 py-2 rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 text-white hover:from-blue-600 hover:to-blue-700 transition-all flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i> Retour
                        </button>
                    </div>
                </div>

                <form action="{{ route('stages.store') }}" method="POST" enctype="multipart/form-data"
                    class="p-6 space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="nom_stage" class="block text-sm font-medium text-gray-700 mb-2">Nom du Stage
                                <span class="text-red-500">*</span></label>
                            <input type="text"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition"
                                id="nom_stage" name="nom_stage" placeholder="Ex: Stage Développement Web" required>
                        </div>

                        <div>
                            <label for="entreprise" class="block text-sm font-medium text-gray-700 mb-2">Entreprise
                                <span class="text-red-500">*</span></label>
                            <input type="text"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition"
                                id="entreprise" name="entreprise" placeholder="Ex: Google" required>
                        </div>

                        <div>
                            <label for="domaine" class="block text-sm font-medium text-gray-700 mb-2">Domaine <span
                                    class="text-red-500">*</span></label>
                            <select id="domaine" name="domaine"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition appearance-none"
                                required>
                                <option value="">Sélectionner un domaine</option>
                                <option value="informatique">Informatique</option>
                                <option value="marketing">Marketing</option>
                                <option value="finance">Finance</option>
                                <option value="electronique">Électronique</option>
                                <option value="design">Design</option>
                                <option value="management">Management</option>
                            </select>
                        </div>

                        <div>
                            <label for="duree" class="block text-sm font-medium text-gray-700 mb-2">Durée <span
                                    class="text-red-500">*</span></label>
                            <input type="text"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition"
                                id="duree" name="duree" placeholder="Ex: 3 mois" required>
                        </div>

                        <div>
                            <label for="email_entreprise" class="block text-sm font-medium text-gray-700 mb-2">Email
                                Entreprise <span class="text-red-500">*</span></label>
                            <input type="email"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition"
                                id="email_entreprise" name="email_entreprise" placeholder="contact@entreprise.com"
                                required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Logo Entreprise <span
                                    class="text-red-500">*</span></label>
                            <div id="dropZone"
                                class="relative flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-lg transition-all duration-200 overflow-hidden bg-gray-50 hover:bg-gray-100 hover:border-indigo-400">
                                <!-- Input file masqué mais fonctionnel -->
                                <input id="photo" name="photo" type="file"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*"
                                    required onchange="handleFileSelect(event)">

                                <!-- État initial (avant sélection) -->
                                <div id="uploadPrompt" class="text-center p-4">
                                    <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-2"></i>
                                    <p class="text-sm text-gray-500">Glissez-déposez votre logo ici</p>
                                    <p class="text-xs text-gray-400 mt-1">ou cliquez pour sélectionner</p>
                                </div>

                                <!-- Aperçu de l'image (caché initialement) -->
                                <div id="imagePreviewContainer"
                                    class="hidden absolute inset-0 flex items-center justify-center bg-white">
                                    <img id="imagePreview" class="max-h-full max-w-full object-contain p-2">
                                </div>
                            </div>

                            <!-- Nom du fichier -->
                            <p id="fileName" class="text-xs text-indigo-600 mt-1 truncate"></p>
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description
                            <span class="text-red-500">*</span></label>
                        <textarea
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition min-h-[120px]"
                            id="description" name="description" placeholder="Décrivez les missions du stage..." required></textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3.5 rounded-lg font-medium flex items-center justify-center transition duration-300 shadow-md hover:shadow-lg">
                            <i class="fas fa-save mr-2"></i> Publier l'offre de stage
                        </button>
                    </div>
                </form>
            </div>

            <!-- Liste des stages -->
            <div id="stages-list-container">
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-white-800 to-gray-700 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-white flex items-center">
                                <i class="fas fa-list mr-2"></i>
                                Liste des stages disponibles
                            </h2>
                            <button onclick="toggleStageForm()"
                                class="text-sm font-medium px-4 py-2 rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 text-white hover:from-blue-600 hover:to-blue-700 transition-all flex items-center">
                                <i class="fas fa-plus mr-2"></i> Ajouter
                            </button>
                        </div>
                    </div>

                    @if ($stages->isEmpty())
                        <div class="text-center py-12 bg-gray-50 rounded-b-lg">
                            <div
                                class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-inbox text-gray-400 text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-700 mb-1">Aucun stage disponible</h3>
                            <p class="text-gray-500 max-w-md mx-auto">Commencez par ajouter une nouvelle offre de stage
                            </p>
                        </div>
                    @else
                        <div class="divide-y divide-gray-200">
                            @foreach ($stages as $stage)
                                <div class="p-6 hover:bg-gray-50 transition duration-150">
                                    <!-- En-tête de la carte -->
                                    <div class="flex items-start mb-4">
                                        <div class="flex-shrink-0 mr-4">
                                            <img class="h-14 w-14 rounded-lg object-cover border border-gray-200"
                                                src="{{ asset('storage/' . $stage->photo) }}" alt="Logo entreprise">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-lg font-semibold text-gray-900 truncate">
                                                {{ $stage->nom_stage }}</h3>
                                            <p class="text-sm text-indigo-600 font-medium">{{ $stage->entreprise }}</p>
                                            <div class="mt-1 flex flex-wrap gap-2">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    {{ $stage->domaine }}
                                                </span>
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    <i class="fas fa-clock mr-1 text-gray-500"></i> {{ $stage->duree }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <div class="flex space-x-2">
                                                <button onclick="toggleEditForm('edit-form-{{ $stage->id }}')"
                                                    class="w-10 h-10 flex items-center justify-center bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-full transition-all duration-300 shadow-sm hover:shadow-lg hover:scale-110"
                                                    title="Modifier">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                                <button
                                                    onclick="showDeleteModal('{{ route('stages.destroy', $stage->id) }}')"
                                                    class="w-10 h-10 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-700 rounded-full transition-all duration-300 shadow-sm hover:shadow-lg hover:scale-110"
                                                    title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Détails -->
                                    <div class="pl-18">
                                        <p class="text-gray-600 text-sm mb-4">{{ $stage->description }}</p>

                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class="fas fa-envelope mr-2 text-gray-400"></i>
                                            <a href="mailto:{{ $stage->email_entreprise }}"
                                                class="hover:text-indigo-600 hover:underline">{{ $stage->email_entreprise }}</a>
                                        </div>
                                    </div>

                                    <!-- Formulaire d'édition (caché) -->
                                    <div id="edit-form-{{ $stage->id }}"
                                        class="hidden mt-6 bg-gray-50 p-5 rounded-lg border border-gray-200 animate-slide-down">
                                        <h4 class="font-medium text-gray-800 mb-4 flex items-center">
                                            <i class="fas fa-edit text-indigo-500 mr-2"></i>
                                            Modifier le stage
                                        </h4>
                                        <form action="{{ route('stages.update', $stage->id) }}" method="POST"
                                            enctype="multipart/form-data" class="space-y-4">
                                            @csrf
                                            @method('PUT')
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                                                    <input type="text"
                                                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition"
                                                        name="nom_stage" value="{{ $stage->nom_stage }}" required>
                                                </div>
                                                <div>
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 mb-1">Entreprise</label>
                                                    <input type="text"
                                                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition"
                                                        name="entreprise" value="{{ $stage->entreprise }}" required>
                                                </div>
                                                <div>
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 mb-1">Domaine</label>
                                                    <input type="text"
                                                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition"
                                                        name="domaine" value="{{ $stage->domaine }}" required>
                                                </div>
                                                <div>
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 mb-1">Durée</label>
                                                    <input type="text"
                                                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition"
                                                        name="duree" value="{{ $stage->duree }}" required>
                                                </div>
                                                <div>
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                                    <input type="email"
                                                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition"
                                                        name="email_entreprise"
                                                        value="{{ $stage->email_entreprise }}" required>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Logo
                                                        actuel</label>
                                                    <div class="flex items-center space-x-3">
                                                        <img src="{{ asset('storage/' . $stage->photo) }}"
                                                            alt="Logo"
                                                            class="h-10 rounded-lg object-cover border border-gray-200">
                                                        <span class="text-xs text-gray-500">(Actuel)</span>
                                                    </div>
                                                </div>
                                                <div class="md:col-span-2">
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nouveau
                                                        logo</label>
                                                    <input type="file"
                                                        class="w-full text-sm border border-gray-200 rounded-lg p-2 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition"
                                                        name="photo" accept="image/*">
                                                </div>
                                                <div class="md:col-span-2">
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                                    <textarea
                                                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition min-h-[100px]"
                                                        name="description" required>{{ $stage->description }}</textarea>
                                                </div>
                                            </div>
                                            <div class="flex space-x-3 pt-2">
                                                <button type="submit"
                                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-lg font-medium transition duration-300">
                                                    <i class="fas fa-save mr-1"></i> Enregistrer
                                                </button>
                                                <button type="button"
                                                    onclick="toggleEditForm('edit-form-{{ $stage->id }}')"
                                                    class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2.5 rounded-lg font-medium transition duration-300">
                                                    <i class="fas fa-times mr-1"></i> Annuler
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Gestion du glisser-déposer
        const dropZone = document.getElementById('dropZone');

        ['dragenter', 'dragover'].forEach(event => {
            dropZone.addEventListener(event, (e) => {
                e.preventDefault();
                dropZone.classList.add('border-indigo-500', 'bg-indigo-50');
            });
        });

        ['dragleave', 'drop'].forEach(event => {
            dropZone.addEventListener(event, (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
            });
        });

        dropZone.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                document.getElementById('photo').files = files;
                handleFileSelect({
                    target: {
                        files
                    }
                });
            }
        });

        // Gestion de la sélection de fichier
        function handleFileSelect(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                // Afficher l'aperçu
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imagePreviewContainer').classList.remove('hidden');
                document.getElementById('uploadPrompt').classList.add('hidden');

                // Afficher le nom du fichier
                document.getElementById('fileName').textContent = file.name;

                // Redimensionner la zone pour s'adapter à l'image
                dropZone.classList.add('border-indigo-400');
                dropZone.classList.remove('border-dashed');
            };
            reader.readAsDataURL(file);
        }

        // Optionnel: Réinitialiser si besoin
        function resetFileInput() {
            document.getElementById('photo').value = '';
            document.getElementById('imagePreviewContainer').classList.add('hidden');
            document.getElementById('uploadPrompt').classList.remove('hidden');
            document.getElementById('fileName').textContent = '';
            dropZone.classList.remove('border-indigo-400');
            dropZone.classList.add('border-dashed');
        }

        function toggleEditForm(formId) {
            const form = document.getElementById(formId);
            form.classList.toggle('hidden');

            // Scroll vers le formulaire si on l'ouvre
            if (!form.classList.contains('hidden')) {
                form.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }
        }

        function toggleStageForm() {
            const formContainer = document.getElementById('stage-form-container');
            const listContainer = document.getElementById('stages-list-container');

            formContainer.classList.toggle('hidden');
            listContainer.classList.toggle('hidden');

            if (!formContainer.classList.contains('hidden')) {
                setTimeout(() => {
                    formContainer.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    });
                }, 50);
            } else {
                setTimeout(() => {
                    listContainer.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    });
                }, 50);
            }
        }

        // Delete modal functions
        function showDeleteModal(formAction) {
            const modal = document.getElementById('delete-modal');
            const form = document.getElementById('delete-form');

            form.action = formAction;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function hideDeleteModal() {
            const modal = document.getElementById('delete-modal');
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Event listeners for modal
        document.getElementById('cancel-delete').addEventListener('click', hideDeleteModal);

        // Close modal when clicking outside
        document.getElementById('delete-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideDeleteModal();
            }
        });

        // Animation pour le message flash
        document.addEventListener('DOMContentLoaded', () => {
            const flashMessage = document.querySelector('[class*="animate-fade-in"]');
            if (flashMessage) {
                setTimeout(() => {
                    flashMessage.style.opacity = '0';
                    flashMessage.style.transition = 'opacity 0.5s ease-out';
                    setTimeout(() => flashMessage.remove(), 500);
                }, 5000);
            }
        });
    </script>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        .animate-slide-down {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

</x-admin>
