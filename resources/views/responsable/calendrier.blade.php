<x-admin titre="calendrier" page_titre="calendrier" :nom_complete="Auth::guard('responsable')->user()->respo_nom . ',' . Auth::guard('responsable')->user()->respo_prenom">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- MODAL DE SUPPRESSION -->
    <div id="deleteEventModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 opacity-0 invisible transition-all duration-300">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95">
            <!-- EN-TÊTE MODAL -->
            <div class="bg-gray-800 p-6 rounded-t-xl flex justify-between items-center">
                <h2 class="text-xl font-bold text-white">Événement</h2>
                <button onclick="closeDeleteModal()" class="text-white hover:text-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- MESSAGE DE CONFIRMATION -->
            <div class="p-6 space-y-4">
                <p class="text-gray-700">
                    Que souhaitez-vous faire avec cet événement ?<br>
                    ❌supprimer (action irréversible) .
                </p>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeDeleteModal()"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-300">
                        Annuler
                    </button>
                    <button type="button" id="editEventButton"
                        class="px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition-colors duration-300">
                        Modifier
                    </button>
                    <button id="confirmDeleteButton" type="button"
                        class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-300">
                        Supprimer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL D'ÉDITION -->
    <div id="editEventModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 opacity-0 invisible transition-all duration-300">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95">
            <!-- HEADER BLEU -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-6 rounded-t-xl flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536M9 13h3l8-8a2.828 2.828 0 10-4-4l-8 8v3z" />
                    </svg>
                    <h2 class="text-xl font-bold text-white">Modifier l'Événement</h2>
                </div>
                <button onclick="closeEditModal()"
                    class="text-white hover:text-gray-200 text-2xl font-bold leading-none">
                    &times;
                </button>
            </div>
            <!-- FORMULAIRE -->
            <form id="editEventForm" class="p-6 space-y-4">
                @csrf
                <div>
                    <label for="edit_title" class="block text-gray-700">Titre</label>
                    <input type="text" name="title" id="edit_title"
                        class="w-full border border-gray-300 rounded-lg p-3" required>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="is_fixed" id="edit_is_fixed" value="1"
                        class="h-5 w-5 text-blue-600 rounded border-gray-300">
                    <label for="edit_is_fixed" class="ml-2 text-gray-700">Événement fixe (récurrent)</label>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeEditModal()"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Annuler</button>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- CALENDRIER AVEC TITRE ET BOUTON -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Calendrier des Événements</h1>
            <button onclick="openEventForm()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                <span>Nouvel Événement</span>
            </button>
        </div>

        <!-- CALENDRIER -->
        <div id="calendar" class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100"></div>

        <!-- MODAL MODERNE (création) -->
        <div id="eventFormModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 opacity-0 invisible transition-all duration-300">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95">
                <!-- EN-TÊTE MODAL -->
                <div
                    class="bg-gradient-to-r from-blue-600 to-blue-800 p-6 rounded-t-xl flex justify-between items-center">
                    <h2 class="text-xl font-bold text-white">➕ Planifier un Événement</h2>
                    <button onclick="closeEventForm()" class="text-white hover:text-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <!-- CORPS DU FORMULAIRE -->
                <form method="POST" action="{{ route('responsable.calendar.plan.store') }}" id="eventForm"
                    class="p-6 space-y-6">
                    @csrf
                    <!-- CHOIX TYPE D'ÉVÉNEMENT -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Type d'événement</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label
                                class="inline-flex items-center p-3 border rounded-lg cursor-pointer hover:bg-blue-50 transition-colors duration-200">
                                <input type="radio" name="event_type" value="existing" checked
                                    class="form-radio h-5 w-5 text-blue-600" onchange="toggleEventType()">
                                <span class="ml-3 text-gray-700">Événement existant</span>
                            </label>
                            <label
                                class="inline-flex items-center p-3 border rounded-lg cursor-pointer hover:bg-blue-50 transition-colors duration-200">
                                <input type="radio" name="event_type" value="new"
                                    class="form-radio h-5 w-5 text-blue-600" onchange="toggleEventType()">
                                <span class="ml-3 text-gray-700">Nouvel événement</span>
                            </label>
                        </div>
                    </div>
                    <!-- SECTION ÉVÉNEMENT EXISTANT -->
                    <div id="existingEventSection" class="space-y-2">
                        <label for="calendar_event_id"
                            class="block text-sm font-medium text-gray-700">Sélectionner</label>
                        <select name="calendar_event_id" id="calendar_event_id"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">
                            @foreach ($events as $event)
                                <option value="{{ $event->id }}">{{ $event->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- SECTION NOUVEL ÉVÉNEMENT -->
                    <div id="newEventSection" class="hidden space-y-4">
                        <div class="space-y-2">
                            <label for="new_event_title" class="block text-sm font-medium text-gray-700">Titre</label>
                            <input type="text" name="title" id="new_event_title"
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                                placeholder="Nom de l'événement">
                        </div>
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" name="is_fixed" id="new_event_fixed" value="1"
                                class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500 border-gray-300">
                            <label for="new_event_fixed" class="text-sm font-medium text-gray-700">Événement fixe
                                (récurrent)</label>
                        </div>
                    </div>
                    <!-- DATES -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Date de
                                début</label>
                            <input type="date" name="start_date" id="start_date"
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                                required>
                        </div>
                        <div class="space-y-2">
                            <label for="end_date" class="block text-sm font-medium text-gray-700">Date de fin</label>
                            <input type="date" name="end_date" id="end_date"
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                                required>
                        </div>
                    </div>
                    <!-- BOUTONS -->
                    <div class="flex justify-end space-x-4 pt-4">
                        <button type="button" onclick="closeEventForm()"
                            class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-300">
                            Annuler
                        </button>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-300 flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Planifier</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* STYLE PERSONNALISÉ POUR FULLCALENDAR */
        .fc {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .fc-header-toolbar {
            @apply mb-4;
        }

        .fc-button {
            @apply bg-white text-gray-800 border border-gray-300 hover:bg-gray-100 transition-colors duration-200;
        }

        .fc-button-primary {
            @apply bg-blue-600 text-white border-blue-600 hover:bg-blue-700 hover:border-blue-700;
        }

        .fc-daygrid-day-number,
        .fc-col-header-cell-cushion {
            @apply text-gray-700 hover:text-blue-600;
        }

        .fc-day-today {
            @apply bg-blue-50;
        }

        .fc-event {
            @apply bg-blue-600 border-blue-600 text-white rounded-lg px-2 py-1 text-sm cursor-pointer;
        }

        .fc-event:hover {
            @apply bg-blue-700 border-blue-700;
        }
    </style>
    <script>
        let eventToDeleteId = null;
        let eventToEditId = null;

        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const modal = document.getElementById('eventFormModal');
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            // INITIALISATION DU CALENDRIER
            const calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'fr',
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                firstDay: 1,
                selectable: true,
                select: function(info) {
                    startDateInput.value = info.startStr;
                    endDateInput.value = info.endStr;
                    openEventForm();
                },
                eventClick: function(info) {
                    openDeleteModal(info.event.id);
                },
                events: "{{ route('responsable.calendar.events') }}",
                eventDisplay: 'block',
                height: 'auto',
                navLinks: true,
                nowIndicator: true,
                dayMaxEvents: true
            });

            calendar.render();
        });

        function toggleEventType() {
            const eventType = document.querySelector('input[name="event_type"]:checked').value;
            const existingSection = document.getElementById('existingEventSection');
            const newSection = document.getElementById('newEventSection');
            if (eventType === 'existing') {
                existingSection.classList.remove('hidden');
                newSection.classList.add('hidden');
                document.getElementById('new_event_title').required = false;
            } else {
                existingSection.classList.add('hidden');
                newSection.classList.remove('hidden');
                document.getElementById('new_event_title').required = true;
            }
        }

        function openEventForm() {
            const modal = document.getElementById('eventFormModal');
            modal.classList.remove('invisible', 'opacity-0');
            modal.classList.add('opacity-100', 'visible');
            modal.querySelector('div').classList.remove('scale-95');
            modal.querySelector('div').classList.add('scale-100');
        }

        function closeEventForm() {
            const modal = document.getElementById('eventFormModal');
            modal.classList.remove('opacity-100', 'visible');
            modal.classList.add('opacity-0', 'invisible');
            modal.querySelector('div').classList.remove('scale-100');
            modal.querySelector('div').classList.add('scale-95');
        }

        // MODAL SUPPRESSION
        function openDeleteModal(eventId) {
            eventToDeleteId = eventId;
            const modal = document.getElementById('deleteEventModal');
            modal.classList.remove('invisible', 'opacity-0');
            modal.classList.add('opacity-100', 'visible');
            modal.querySelector('div').classList.remove('scale-95');
            modal.querySelector('div').classList.add('scale-100');
            // Ouvre le modal d'édition au clic sur Modifier
            document.getElementById('editEventButton').onclick = function() {
                closeDeleteModal();
                openEditModal(eventId);
            };
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteEventModal');
            modal.classList.remove('opacity-100', 'visible');
            modal.classList.add('opacity-0', 'invisible');
            modal.querySelector('div').classList.remove('scale-100');
            modal.querySelector('div').classList.add('scale-95');
            eventToDeleteId = null;
        }

        document.getElementById('confirmDeleteButton').addEventListener('click', function() {
            if (eventToDeleteId !== null) {
                deleteCalendar(eventToDeleteId);
                closeDeleteModal();
            }
        });

        function deleteCalendar(id) {
            fetch(`/responsable/calendar/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Erreur lors de la suppression');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Erreur : ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur :', error);
                    alert('Erreur lors de la suppression.');
                });
        }

        // MODAL ÉDITION
        function openEditModal(eventId) {
            eventToEditId = eventId;
            // Récupère les infos de l'événement via une route dédiée
            fetch(`/responsable/calendar/${eventId}/json`)
                .then(response => response.json())
                .then(event => {
                    document.getElementById('edit_title').value = event.title;
                    document.getElementById('edit_is_fixed').checked = event.isFixed ? true : false;
                    const modal = document.getElementById('editEventModal');
                    modal.classList.remove('invisible', 'opacity-0');
                    modal.classList.add('opacity-100', 'visible');
                    modal.querySelector('div').classList.remove('scale-95');
                    modal.querySelector('div').classList.add('scale-100');
                });
        }

        function closeEditModal() {
            const modal = document.getElementById('editEventModal');
            modal.classList.remove('opacity-100', 'visible');
            modal.classList.add('opacity-0', 'invisible');
            modal.querySelector('div').classList.remove('scale-100');
            modal.querySelector('div').classList.add('scale-95');
            eventToEditId = null;
        }

        document.getElementById('editEventForm').addEventListener('submit', function(e) {
            e.preventDefault();
            fetch(`/responsable/event/update/${eventToEditId}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        title: document.getElementById('edit_title').value,
                        is_fixed: document.getElementById('edit_is_fixed').checked ? 1 : 0
                    })
                })
                .then(response => response.json())
                .then(data => {
                    closeEditModal();
                    location.reload();
                })
                .catch(error => {
                    alert('Erreur lors de la modification');
                    closeEditModal();
                });
        });
    </script>
</x-admin>
