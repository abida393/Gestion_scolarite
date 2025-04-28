<x-home titre="calendrier-etudiant" page_titre="calendrier-etudiant">
<div class="relative flex items-center justify-center min-h-[90vh] bg-gray-50"> <!-- Réduction de la hauteur -->
<div class="w-full max-w-6xl px-2 sm:px-3 lg:px-6">
<h2 class="text-gray-800 text-2xl sm:text-3xl lg:text-4xl font-extrabold text-center mb-1 tracking-tight">
  <i class="fas fa-calendar-alt text-indigo-500 mr-3"></i> Mon Calendrier
</h2>
<h4 id="currentDate" class="text-center text-gray-600 text-sm sm:text-base lg:text-lg mb-3 font-medium"></h4>
<div class="calendar-wrapper p-2 sm:p-3 bg-white rounded-3xl shadow-xl border border-gray-100 backdrop-blur-md">
        <div id="calendar" class="bg-white rounded-2xl shadow-2xl p-4 sm:p-6 backdrop-blur-xl bg-white/80 ring-1 ring-gray-200 w-full sm:w-auto"></div>
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
  @media (max-width: 640px) {
    .fc-toolbar {
      flex-wrap: wrap;
      justify-content: center;
    }
    .fc-toolbar .fc-left, .fc-toolbar .fc-right {
      margin-bottom: 0.5rem;
    }
    .fc-day-grid-event {
      font-size: 0.75rem; /* Réduire la taille de la police */
    }
  }
  .calendar-wrapper {
    margin-top: 0; /* Supprime l'espace au-dessus */
    padding-top: 0.5rem;
    margin-bottom: 070%;/* Réduit le padding supérieur */
  }
  h2 {
    margin-bottom: 0.5rem; /* Réduit l'espace sous le titre principal */
  }
  h4 {
    margin-bottom: 0.5rem; /* Réduit l'espace sous la date */
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const calendar = $('#calendar');

    function updateCurrentDate() {
      const current = calendar.fullCalendar('getDate');
      const formatted = moment(current).format('dddd D MMMM YYYY');
      moment.locale('fr');
      $('#currentDate').text(formatted.charAt(0).toUpperCase() + formatted.slice(1));
    }

    calendar.fullCalendar({
      locale: 'fr', // Définit la langue en français
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'Aujourd\'hui',
        month: 'Mois',
        week: 'Semaine',
        day: 'Jour'
      },
      contentHeight: 'auto',
      editable: false,
      selectable: false,
      events: '/events', // Laravel route qui retourne les événements liés à l’étudiant
      eventRender: function (event, element) {
        if (event.title) {
          element.find('.fc-title').html(`<div class="font-semibold">${event.title}</div>`);
        }
        if (event.color) {
          element.css('background-color', event.color);
        }
      },
      showNonCurrentDates: false
    });

    updateCurrentDate();
  });
</script>
</x-home>
