<x-home titre="calendrier-etudiant" page_titre="calendrier-etudiant" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">
<div class="bg-white 500 min-h-screen p-4 md:p-6">
  <div class="w-full max-w-6xl mx-auto">
    <h2 class="text-grey text-3xl md:text-4xl font-bold text-center mb-2 drop-shadow-lg">
      <i class="fas fa-calendar-alt text-grey text-center mr-2 md:mr-3"></i> Mon Calendrier
    </h2>
    <h4 id="currentDate" class="text-center text-grey text-base md:text-lg mb-4 md:mb-6 font-medium"></h4>

    <div class="calendar-wrapper p-3 md:p-6 bg-white rounded-xl md:rounded-3xl shadow-lg border border-white/20 backdrop-blur-sm">
      <div id="calendar" class="bg-white rounded-xl md:rounded-2xl shadow-md p-3 md:p-6 backdrop-blur-sm bg-white/90"></div>
    </div>
  </div>
</div>
<style>
  .fc-day-grid-event {
    border-radius: 0.5rem;
    padding: 0.2rem 0.4rem;
    font-size: 0.85rem;
    font-weight: 500;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    transition: all 0.2s ease;
    margin: 1px 0;
  }

  .fc-day-grid-event:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }

  .fc-today {
    background-color: rgba(99, 102, 241, 0.15) !important;
  }

  .fc-day-header {
    padding: 8px 4px;
    font-weight: 600;
  }

  /* Responsive adjustments */
  @media (max-width: 768px) {
    .fc-toolbar {
      flex-direction: column;
      gap: 0.5rem;
    }

    .fc-toolbar .fc-left,
    .fc-toolbar .fc-center,
    .fc-toolbar .fc-right {
      width: 100%;
      justify-content: center;
    }

    .fc-header-toolbar h2 {
      font-size: 1.1rem;
      margin: 0.5rem 0;
    }

    .fc-day-header {
      font-size: 0.75rem;
      padding: 4px 2px;
    }

    .fc-day-grid-event {
      font-size: 0.7rem;
      padding: 0.1rem 0.3rem;
    }
  }

  @media (max-width: 576px) {
    .calendar-wrapper {
      padding: 1rem;
    }

    #calendar {
      padding: 0.5rem;
    }

    .fc-button {
      padding: 0.25rem 0.5rem;
      font-size: 0.8rem;
    }
  }

  .calendar-wrapper {
    margin-bottom: 2rem;
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const calendar = $('#calendar');

  function updateCurrentDate() {
    const current = calendar.fullCalendar('getDate');
    const formatted = moment(current).format('dddd D MMMM YYYY');
    moment.locale('fr');
    $('#currentDate').text(formatted.charAt(0).toUpperCase() + formatted.slice(1));
  }

  calendar.fullCalendar({
    locale: 'fr',
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
    defaultView: 'month',
    contentHeight: 'auto',
    aspectRatio: 1.5,
    editable: false,
    selectable: false,
    events: '/events',
    eventRender: function(event, element) {
      if (event.title) {
        element.find('.fc-title').html(`<div class="font-semibold truncate">${event.title}</div>`);
      }
      if (event.color) {
        element.css({
          'background-color': event.color,
          'border-color': event.color
        });
      }
    },
    viewRender: function(view) {
      updateCurrentDate();
    },
    dayClick: function(date, jsEvent, view) {
      updateCurrentDate();
    },
    eventAfterAllRender: function(view) {
      updateCurrentDate();
    }
  });

  // Initial date display
  updateCurrentDate();

  // Handle window resize
  $(window).on('resize', function() {
    calendar.fullCalendar('render');
  });
});
</script>
<x-chat-button></x-chat-button>
</x-home>
