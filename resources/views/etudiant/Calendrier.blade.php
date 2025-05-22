<x-home titre="calendrier-etudiant" page_titre="calendrier-etudiant" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">
    <div class="bg-gradient-to-b from-indigo-50 via-white to-indigo-100 min-h-screen p-4 sm:p-6 md:p-10">
        <div class="w-full max-w-full md:max-w-6xl mx-auto">
            <h2 class="text-center text-gray-800 text-2xl sm:text-3xl md:text-4xl font-extrabold mb-2 drop-shadow-sm">
                <i class="fas fa-calendar-alt text-indigo-600 mr-2"></i> Mon Calendrier
            </h2>
            <h4 id="currentDate" class="text-center text-gray-600 text-sm sm:text-base md:text-lg mb-6 font-medium"></h4>

            <div
                class="calendar-wrapper flex-grow bg-white/60 backdrop-blur-xl rounded-3xl border border-white/40 shadow-[0_10px_30px_rgba(0,0,0,0.1)]">
                <div id="calendar" class="bg-white rounded-xl shadow-inner p-4 sm:p-5 md:p-6"></div>
            </div>
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


            <style>.fc-daygrid-event {
                border-radius: 0.75rem;
                padding: 0.35rem 0.6rem;
                font-size: 0.85rem;
                font-weight: 600;
                background: linear-gradient(to right, #6366f1, #818cf8);
                color: white;
                border: none;
                box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .fc-daygrid-event:hover {
                transform: translateY(-3px) scale(1.02);
                box-shadow: 0 6px 16px rgba(99, 102, 241, 0.5);
            }

            .fc-today {
                background-color: rgba(99, 102, 241, 0.1) !important;
                border-radius: 0.5rem;
            }

            .fc-toolbar-title {
                font-weight: 700;
                font-size: 1.3rem;
                color: #1f2937;
            }

            .fc-button {
                background: linear-gradient(to right, #6366f1, #4f46e5) !important;
                border: none !important;
                color: white !important;
                font-weight: 600;
                padding: 0.5rem 1rem !important;
                border-radius: 0.5rem !important;
                transition: background 0.3s ease, transform 0.2s ease;
            }
        }

        .calendar-wrapper {
            margin-bottom: 2rem;
        }
    </style>

    {{-- <script>
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
                                        element.find('.fc-title').html(
                                            `<div class="font-semibold truncate">${event.title}</div>`);
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

                                        .fc - button: hover {
                                            background: #4338ca !important;
          transform: scale(1.03);
        }

      // Initial date display
      updateCurrentDate();

      // Handle window resize
      $(window).on('resize', function() {
        calendar.fullCalendar('render');
        .fc-button-primary:disabled {
          background-color: # d1d5db!important;
                                            color: #9ca3af !important;
        }

        .fc-button-active {
          background-color: # 3730 a3!important;
                                        }

                                        @media(max - width: 768 px) {
                                                .fc - toolbar {
                                                        flex - direction: column;
                                                        gap: 0.5 rem;
                                                    }

                                                    .fc - toolbar > div {
                                                        width: 100 % ;
                                                        justify - content: center;
                                                    }

                                                    .fc - daygrid - event {
                                                        font - size: 0.75 rem;
                                                    }

                                                    .fc - toolbar - title {
                                                        font - size: 1.1 rem;
                                                    }

                                                    .fc - button {
                                                        padding: 0.5 rem 0.75 rem!important;
                                                        font - size: 0.75 rem!important;
                                                    }

                                                    .calendar - wrapper {
                                                        padding: 1 rem!important;
                                                    }
                                            } <
                                            /style> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');

            // Filtrer les événements pour exclure ceux qui sont terminés depuis plus de 24 heures
            const filteredEvents = Array.from(new Set(@json($events)
                    .map(event => JSON.stringify(event)))) // Supprime les doublons
                .map(event => JSON.parse(event)) // Reconvertit en objet
                .filter(event => {
                    const eventEndDate = new Date(event.end || event.start);
                    const now = new Date();
                    const twentyFourHoursAgo = new Date(now.getTime() - 24 *
                        60 * 60 * 1000);
                    return eventEndDate >=
                        twentyFourHoursAgo; // Inclure uniquement les événements valides
                });

            const calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'fr',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: "Aujourd'hui",
                    month: 'Mois',
                    week: 'Semaine',
                    day: 'Jour'
                },
                initialView: 'dayGridMonth',
                firstDay: 1,
                height: 'auto', // ✅ Fixe le problème de scroll interne
                events: filteredEvents, // Utiliser les événements filtrés
                eventDidMount: function(info) {
                    const titleEl = info.el.querySelector(
                        '.fc-event-title');
                    if (titleEl) {
                        titleEl.innerHTML =
                            `<div class="truncate">${info.event.title}</div>`;
                    }
                },
                noEventsContent: 'Aucun événement à afficher',
            });

            calendar.render();
        });
    </script>

    <x-chat-button></x-chat-button>
</x-home>
