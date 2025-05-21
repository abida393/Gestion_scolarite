<x-admin titre="Page Events" page_titre="Page events" :nom_complete="Auth::guard('responsable')->user()?->respo_nom . ' ' . Auth::guard('responsable')->user()?->respo_prenom">
    <div>
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        
        <!-- Delete Confirmation Modal -->
        <div id="delete-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black bg-opacity-50">
            <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full max-w-md">
                <div class="p-6">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-rose-100 rounded-full mb-4">
                        <i class="fas fa-exclamation-triangle text-rose-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 text-center mb-2">Confirmer la suppression</h3>
                    <p class="text-gray-600 text-center mb-6">Êtes-vous sûr de vouloir supprimer cet événement ? Cette action est irréversible.</p>
                    <div class="flex justify-center space-x-4">
                        <button id="cancel-delete" class="px-6 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors">
                            Annuler
                        </button>
                        <form id="delete-form" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-6 py-2 rounded-lg bg-rose-500 text-white hover:bg-rose-600 transition-colors">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content container -->
        <div class="relative max-w-6xl mx-auto z-10">
            <!-- Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-20 h-20 mb-6 rounded-2xl bg-gradient-to-r from-blue-500 to-indigo-600 shadow-lg">
                    <i class="fas fa-calendar-alt text-3xl text-white"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                    Gestion des <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Événements</span>
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Organisez et planifiez les événements de votre établissement en toute simplicité</p>
            </div>

            <!-- Flash messages -->
            <div class="max-w-5xl mx-auto mb-10 space-y-4">
                @if (session('message'))
                <div class="p-4 rounded-xl bg-white shadow-md border-l-4 border-emerald-500 flex items-start animate-fade-in">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                            <i class="fas fa-check text-emerald-500"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-800">{{ session('message') }}</h3>
                    </div>
                </div>
                @endif
                @if (session('error'))
                <div class="p-4 rounded-xl bg-white shadow-md border-l-4 border-rose-500 flex items-start animate-fade-in">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-rose-100 flex items-center justify-center">
                            <i class="fas fa-exclamation text-rose-500"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-800">{{ session('error') }}</h3>
                    </div>
                </div>
                @endif
            </div>

            <!-- Add event form (hidden by default) -->
            <div id="event-form-container" class="hidden bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-10 transition-all duration-300 hover:shadow-md">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <!-- Icône dans un cercle -->
                            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg">
                                <i class="fas fa-calendar-alt text-xl text-white drop-shadow-md"></i>
                            </div>
                            <!-- Titre -->
                            <h2 class="text-xl font-semibold text-gray-800">
                                Créer un nouvel événement
                            </h2>
                        </div>
                        <button onclick="toggleEventForm()" 
                                class="text-sm font-medium px-4 py-2 rounded-lg bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all flex items-center">
                            <i class="fas fa-arrow-left mr-2 text-blue-500"></i> Retour aux événements
                        </button>
                    </div>
                </div>

                <div class="p-6">
                    <form action="{{ route('responsable.events.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @csrf
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Titre de l'événement <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-heading text-gray-400"></i>
                                </div>
                                <input type="text" name="title" required value="{{ old('title') }}"
                                       class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-all duration-200"
                                       placeholder="Nommez votre événement">
                            </div>
                            @error('title') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="far fa-calendar text-gray-400"></i>
                                </div>
                                <input type="date" name="start" required value="{{ old('start') }}"
                                       class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-all duration-200">
                            </div>
                            @error('start') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Heure de début <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="far fa-clock text-gray-400"></i>
                                </div>
                                <input type="time" name="start_time" required value="{{ old('start_time') }}"
                                       class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-all duration-200">
                            </div>
                            @error('start_time') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Heure de fin <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="far fa-clock text-gray-400"></i>
                                </div>
                                <input type="time" name="end_time" required value="{{ old('end_time') }}"
                                       class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-all duration-200">
                            </div>
                            @error('end_time') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2 pt-2">
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium py-3 px-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center">
                                <i class="fas fa-calendar-plus mr-3 transform transition-transform duration-300 group-hover:scale-110"></i>
                                Planifier l'événement
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Events list -->
            <div id="events-list-container">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
                        <div class="flex items-center">
                            <span class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                                <i class="fas fa-calendar-day text-indigo-500 text-sm"></i>
                            </span>
                            <h2 class="text-xl font-semibold text-gray-800">Événements à venir</h2>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Search bar -->
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" id="event-search" placeholder="Rechercher un événement..."
                                       class="pl-10 w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-all duration-200">
                            </div>
                            <!-- Add event button -->
                            <button onclick="toggleEventForm()" 
                                    class="text-sm font-medium px-4 py-2 rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 text-white hover:from-blue-600 hover:to-blue-700 transition-all flex items-center">
                                <i class="fas fa-plus mr-2"></i> Ajouter un événement
                            </button>
                        </div>
                    </div>
                    
                    <div class="divide-y divide-gray-100" id="events-list">
                        @forelse ($evenements as $event)
                        <div class="p-6 hover:bg-gray-50 transition-colors duration-200 group event-item" data-title="{{ strtolower($event->titre) }}">
                            <div class="flex flex-col md:flex-row md:items-center gap-6">
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center text-blue-500 shadow-inner">
                                        <i class="fas fa-calendar-day text-2xl"></i>
                                    </div>
                                </div>
                                
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">{{ $event->titre }}</h3>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                            <i class="far fa-clock mr-2"></i>
                                            {{ \Carbon\Carbon::parse($event->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->heure_fin)->format('H:i') }}
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-50 text-purple-700">
                                            <i class="far fa-calendar mr-2"></i>
                                            {{ \Carbon\Carbon::parse($event->date)->isoFormat('LL') }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-2 mt-4 md:mt-0">
                                    <button onclick="toggleEditForm('edit-form-{{ $event->id }}')"
                                            class="text-sm font-medium px-4 py-2 rounded-lg bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all flex items-center">
                                        <i class="fas fa-pencil-alt mr-2 text-blue-500"></i> Modifier
                                    </button>
                                    
                                    <button onclick="showDeleteModal('{{ route('responsable.events.destroy', $event->id) }}')"
                                            class="text-sm font-medium px-4 py-2 rounded-lg bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all flex items-center">
                                        <i class="fas fa-trash-alt mr-2 text-rose-500"></i> Supprimer
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Edit form (hidden by default) -->
                            <div id="edit-form-{{ $event->id }}" class="hidden mt-6 pt-6 border-t border-gray-100">
                                <form action="{{ route('responsable.events.update', $event->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Titre <span class="text-rose-500">*</span></label>
                                        <input type="text" name="title" required value="{{ $event->titre }}"
                                               class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-all duration-200">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Date <span class="text-rose-500">*</span></label>
                                        <input type="date" name="start" required value="{{ $event->date }}"
                                               class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-all duration-200">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Heure début <span class="text-rose-500">*</span></label>
                                        <input type="time" name="start_time" required value="{{ \Carbon\Carbon::parse($event->heure_debut)->format('H:i') }}"
                                               class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-all duration-200">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Heure fin <span class="text-rose-500">*</span></label>
                                        <input type="time" name="end_time" required value="{{ \Carbon\Carbon::parse($event->heure_fin)->format('H:i') }}"
                                               class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-all duration-200">
                                    </div>
                                    
                                    <div class="md:col-span-2 flex gap-3 pt-2">
                                        <button type="submit" 
                                                class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center">
                                            <i class="fas fa-save mr-3"></i> Enregistrer
                                        </button>
                                        <button type="button" onclick="toggleEditForm('edit-form-{{ $event->id }}')" 
                                                class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-3 px-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center">
                                            <i class="fas fa-times mr-3"></i> Annuler
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @empty
                        <div class="p-10 text-center">
                            <div class="mx-auto w-20 h-20 bg-blue-50 rounded-xl flex items-center justify-center text-blue-400 mb-5">
                                <i class="fas fa-calendar-times text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-700 mb-2">Aucun événement programmé</h3>
                            <p class="text-gray-500 text-sm">Créez votre premier événement en utilisant le formulaire ci-dessus</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Smooth transitions for interactive elements */
        button, input, .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        /* Modal animation */
        #delete-modal {
            animation: fadeInModal 0.2s ease-out forwards;
        }
        @keyframes fadeInModal {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>

    <script>
        function toggleEditForm(formId) {
            const form = document.getElementById(formId);
            form.classList.toggle('hidden');
            
            if (!form.classList.contains('hidden')) {
                setTimeout(() => {
                    form.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'nearest',
                        inline: 'start'
                    });
                }, 50);
            }
        }

        function toggleEventForm() {
            const formContainer = document.getElementById('event-form-container');
            const listContainer = document.getElementById('events-list-container');
            
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

        // Search functionality
        document.getElementById('event-search').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const events = document.querySelectorAll('.event-item');
            
            events.forEach(event => {
                const title = event.getAttribute('data-title');
                if (title.includes(searchTerm)) {
                    event.style.display = '';
                } else {
                    event.style.display = 'none';
                }
            });
        });

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
    </script>
</x-admin>