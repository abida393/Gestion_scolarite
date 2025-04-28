<x-home titre="calendrier-etudiant" page_titre="calendrier-etudiant" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">
<div class="relative flex items-center justify-center min-h-screen bg-gray-50">
  <div class="w-full max-w-6xl">
    <h2 class="text-gray-800 text-4xl font-extrabold text-center mb-2 tracking-tight">
      <i class="fas fa-calendar-alt text-indigo-500 mr-3"></i> Mon Calendrier
    </h2>
    <h4 id="currentDate" class="text-center text-gray-600 text-lg mb-6 font-medium"></h4>

    <div class="calendar-wrapper p-6 bg-white rounded-3xl shadow-xl border border-gray-100 backdrop-blur-md">
      <div id="calendar" class="bg-white rounded-2xl shadow-2xl p-6 backdrop-blur-xl bg-white/80 ring-1 ring-gray-200"></div>
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
