<x-home titre="calendrier-page" page_titre="calendrier-page">
<div class="relative flex items-center justify-center min-h-screen bg-gray-50">
  <div class="w-full max-w-6xl">
    <h2 class="text-gray-800 text-4xl font-extrabold text-center mb-2 tracking-tight">
      <i class="fas fa-calendar-alt text-indigo-500 mr-3"></i> Calendrier
    </h2>
    <h4 id="currentDate" class="text-center text-gray-600 text-lg mb-6 font-medium"></h4>

    <div class="calendar-wrapper p-6 bg-white rounded-3xl shadow-xl border border-gray-100 backdrop-blur-md">
      <div id="calendar" class="bg-white rounded-2xl shadow-2xl p-6 backdrop-blur-xl bg-white/80 ring-1 ring-gray-200"></div>
    </div>
  </div>
</div>

<!-- MODAL -->
<div id="eventModal" class="absolute inset-0 bg-opacity-0 hidden items-center justify-center z-50">
  <div class="bg-white rounded-2xl shadow-xl p-8 max-w-lg w-full transition-all transform scale-95 opacity-0 ring-1 ring-gray-200">
    <h3 class="text-2xl font-semibold mb-4 text-gray-800">Ajouter un événement</h3>

    <label class="block text-sm text-gray-600 mb-1">Titre de l'événement</label>
    <input type="text" id="eventTitle" placeholder="Nom de l'événement"
      class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none transition-all duration-200">

    <label class="block text-sm text-gray-600 mb-1">Couleur de l'événement</label>
    <input type="color" id="eventColor" value="#007bff"
      class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-400 focus:outline-none">

    <label class="block text-sm text-gray-600 mb-1">Heure de début</label>
    <input type="time" id="eventStartTime"
      class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none transition-all duration-200">

    <label class="block text-sm text-gray-600 mb-1">Heure de fin</label>
    <input type="time" id="eventEndTime"
      class="w-full mb-6 px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none transition-all duration-200">

    <div class="flex justify-end space-x-4">
      <button id="cancelBtn"
        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-xl transition-all duration-200">Annuler</button>
      <button id="saveEventBtn"
        class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl shadow-md transition-all duration-200">Ajouter</button>
    </div>
  </div>
</div>

<style>
  .fc-day-grid-event {
    border-radius: 0.75rem;
    padding: 0.2rem 0.5rem;
    font-size: 0.85rem;
    font-weight: 500;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    transition: all 0.2s ease-in-out;
  }
  .fc-day-grid-event:hover {
    transform: scale(1.03);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
  }
  .fc-today {
    background-color: rgba(99, 102, 241, 0.1) !important;
    border-radius: 12px;
  }
  
</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const calendar = $('#calendar');
    let selectedDate = null;

    function updateCurrentDate() {
      const current = calendar.fullCalendar('getDate');
      const formatted = moment(current).format('dddd D MMMM YYYY');
      $('#currentDate').text(formatted.charAt(0).toUpperCase() + formatted.slice(1));
    }

    calendar.fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
      editable: true,
      events: '/events',
      selectable: true,
      selectHelper: true,
      showNonCurrentDates: false,
      select: function (start, end) {
        selectedDate = start;
        $('#eventModal').removeClass('hidden');
        $('#eventModal .bg-white').removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100');
      },
      eventDrop: async function (event, delta, revertFunc) {
        try {
          const response = await fetch(`/events/update/${event.id}`, {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
              start: event.start.format(),
              end: event.end ? event.end.format() : null
            })
          });
          if (!response.ok) revertFunc();
        } catch (error) {
          console.error(error); revertFunc();
        }
      },
      eventResize: async function (event, delta, revertFunc) {
        try {
          const response = await fetch(`/events/update/${event.id}`, {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
              start: event.start.format(),
              end: event.end ? event.end.format() : null
            })
          });
          if (!response.ok) revertFunc();
        } catch (error) {
          console.error(error); revertFunc();
        }
      },
      eventClick: async function (event) {
        if (confirm('Voulez-vous vraiment supprimer cet événement ?')) {
          try {
            const response = await fetch(`/events/${event.id}`, {
              method: 'DELETE',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              }
            });
            if (response.ok) {
              calendar.fullCalendar('removeEvents', event.id);
              alert('Événement supprimé avec succès.');
            }
          } catch (error) {
            console.error(error);
          }
        }
      },
      eventRender: function (event, element) {
        if (event.title) {
          element.find('.fc-title').html(`<div class="font-semibold">${event.title}</div>`);
        }
        if (event.color) {
          element.css('background-color', event.color);
        }
      }
    });

    updateCurrentDate();

    document.getElementById('saveEventBtn').addEventListener('click', async function () {
      const title = document.getElementById('eventTitle').value.trim();
      const startTime = document.getElementById('eventStartTime').value;
      const endTime = document.getElementById('eventEndTime').value;
      const color = document.getElementById('eventColor').value;

      if (title && startTime && endTime && selectedDate) {
        const start = moment(selectedDate.format('YYYY-MM-DD') + 'T' + startTime);
        const end = moment(selectedDate.format('YYYY-MM-DD') + 'T' + endTime);

        if (end.isAfter(start)) {
          try {
            const response = await fetch('/events', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              },
              body: JSON.stringify({ title, start: start.format(), end: end.format(), color })
            });

            if (response.ok) {
              const event = await response.json();
              calendar.fullCalendar('renderEvent', {
                title: event.titre,
                start: event.date + 'T' + event.heure_debut,
                end: event.date + 'T' + event.heure_fin,
                color: event.color
              }, true);

              document.getElementById('eventTitle').value = '';
              document.getElementById('eventStartTime').value = '';
              document.getElementById('eventEndTime').value = '';
              document.getElementById('eventColor').value = '#007bff';
              $('#eventModal').addClass('hidden');
              calendar.fullCalendar('unselect');
            }
          } catch (error) {
            console.error(error);
          }
        } else {
          alert("L'heure de fin doit être après l'heure de début.");
        }
      } else {
        alert("Merci de remplir tous les champs.");
      }
    });

    document.getElementById('cancelBtn').addEventListener('click', function () {
      document.getElementById('eventTitle').value = '';
      document.getElementById('eventStartTime').value = '';
      document.getElementById('eventEndTime').value = '';
      document.getElementById('eventColor').value = '#007bff';
      $('#eventModal').addClass('hidden');
      $('#eventModal .bg-white').removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
      calendar.fullCalendar('unselect');
    });
  });
</script>
</x-home>