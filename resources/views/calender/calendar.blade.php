<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Calendrier Scolaire</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>


</head>
<body class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 min-h-screen flex items-center justify-center p-6">
  <div class="w-full max-w-6xl mx-auto">
    <h2 class="text-white text-4xl font-bold text-center mb-2 drop-shadow-lg">✨ Calendrier ✨</h2>
    <h4 id="currentDate" class="text-center text-white text-lg mb-4 font-medium drop-shadow"></h4>

    <div id="calendar" class="bg-white rounded-lg shadow-xl p-6"></div>
  </div>

  <!-- MODAL -->
  <div id="eventModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-2xl p-8 max-w-lg w-full transition-all transform scale-95 opacity-0">
      <h3 class="text-2xl font-semibold mb-4 text-gray-800">Ajouter un événement</h3>

      <label class="block text-sm text-gray-600 mb-1">Titre de l'événement</label>
      <input type="text" id="eventTitle" placeholder="Nom de l'événement"
        class="w-full mb-3 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">

      <label class="block text-sm text-gray-600 mb-1">Heure de début</label>
      <input type="time" id="eventStartTime"
        class="w-full mb-3 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">

      <label class="block text-sm text-gray-600 mb-1">Heure de fin</label>
      <input type="time" id="eventEndTime"
        class="w-full mb-6 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">

      <div class="flex justify-end space-x-4">
        <button id="cancelBtn" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-5 py-2 rounded-lg focus:outline-none">Annuler</button>
        <button id="saveEventBtn"
          class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg focus:outline-none">Ajouter</button>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function () {
      const calendar = $('#calendar');
      let selectedDate = null;

      // Mise à jour de la date actuelle
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
        events: '/events', // Charger les événements à partir de Laravel
        selectable: true,
        selectHelper: true,
        select: function (start, end) {
          selectedDate = start;
          $('#eventModal').removeClass('hidden');
          $('#eventModal .bg-white').removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100');
        },
        eventLimit: true,
        viewRender: function(view) {
          updateCurrentDate();
        },
        eventRender: function(event, element) {
          if (event.start && event.end) {
            const start = moment(event.start).format('HH:mm');
            const end = moment(event.end).format('HH:mm');
            element.find('.fc-title').html(`
              <div class="font-semibold">${event.title}</div>
              <div class="text-xs text-white">${start} - ${end}</div>
            `);
          }
          if (event.color) {
            element.css('background-color', event.color);  // Appliquer la couleur
          }
        }
      });

      updateCurrentDate();

      // Vérifier s'il y a déjà 3 événements à la même heure
      function checkMaxEventsAtTime(startTime, endTime) {
        const eventsAtTime = calendar.fullCalendar('clientEvents', function(event) {
          return (moment(event.start).isSame(startTime, 'day') &&
                  moment(event.start).isBetween(startTime, endTime, null, '[)'));
        });

        return eventsAtTime.length >= 3;  // Si 3 événements existent déjà, ne pas autoriser l'ajout
      }

      // Sauvegarder l'événement
      $('#saveEventBtn').on('click', function () {
        const title = $('#eventTitle').val().trim();
        const startTime = $('#eventStartTime').val();
        const endTime = $('#eventEndTime').val();

        if (title && startTime && endTime && selectedDate) {
          const start = moment(selectedDate.format('YYYY-MM-DD') + 'T' + startTime);
          const end = moment(selectedDate.format('YYYY-MM-DD') + 'T' + endTime);

          if (end.isAfter(start)) {
            // Vérifier s'il y a déjà 3 événements à cet horaire
            if (checkMaxEventsAtTime(start, end)) {
              alert("Vous ne pouvez pas ajouter plus de 3 événements à la même heure.");
              return;
            }

            // Récupérer le token CSRF pour l'envoyer avec la requête AJAX
            var token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
              url: '/events',
              type: 'POST',
              data: {
                title: title,
                start: start.format(),
                end: end.format(),
                _token: token // Envoi du token CSRF avec la requête
              },
              success: function(event) {
                calendar.fullCalendar('renderEvent', {
                  title: event.title,
                  start: event.start,
                  end: event.end,
                  color: event.color
                }, true);  // L'événement est maintenant ajouté au calendrier

                // Réinitialiser les champs et cacher la modal
                $('#eventTitle').val('');
                $('#eventStartTime').val('');
                $('#eventEndTime').val('');
                $('#eventModal').addClass('hidden');
                $('#eventModal .bg-white').removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
                calendar.fullCalendar('unselect');
              },
              error: function(xhr, status, error) {
                alert('Une erreur est survenue : ' + error);
              }
            });
          } else {
            alert("L'heure de fin doit être après l'heure de début.");
          }
        } else {
          alert("Merci de remplir tous les champs.");
        }
      });

      // Annuler l'ajout d'événement
      $('#cancelBtn').on('click', function () {
        $('#eventTitle').val('');
        $('#eventStartTime').val('');
        $('#eventEndTime').val('');
        $('#eventModal').addClass('hidden');
        $('#eventModal .bg-white').removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
        calendar.fullCalendar('unselect');
      });
    });
  </script>
</body>
</html>
