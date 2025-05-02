<x-home titre="Page d'accueil" page_titre="Page d'accueil" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ', ' . Auth::guard('etudiant')->user()->etudiant_prenom">
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Mon calendrier</h2>
    </x-slot>

    <div class="min-h-screen bg-gray-100 py-10 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-200">
                <div id="calendar" class="rounded-lg overflow-hidden"></div>
            </div>
        </div>
    </div>

    
        
    <style>
    /* General FullCalendar styles */
    .fc {
        font-family: 'Inter', sans-serif;
        font-size: 14px;
    }

    /* Toolbar title styling */
    .fc-toolbar-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1f2937; /* text-gray-800 */
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    /* Button styling */
    .fc-button {
        background: linear-gradient(145deg, #4f46e5, #3b82f6); /* Vibrant gradient */
        border: none !important;
        color: white !important;
        padding: 12px 18px;
        border-radius: 15px !important; /* Rounded corners */
        box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2), -3px -3px 6px rgba(255, 255, 255, 0.3); /* 3D shadow */
        transition: all 0.3s ease-in-out;
    }

    .fc-button:hover {
        background: linear-gradient(145deg, #3b82f6, #2563eb); /* Darker gradient on hover */
        transform: translateY(-3px); /* Lift effect */
        box-shadow: 7px 7px 14px rgba(0, 0, 0, 0.3), -4px -4px 8px rgba(255, 255, 255, 0.4); /* Enhanced shadow */
    }

    .fc-button:disabled {
        background: linear-gradient(145deg, #93c5fd, #60a5fa); /* Softer gradient for disabled */
        cursor: not-allowed;
        box-shadow: none;
    }

    /* Toolbar styling */
    .fc-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px;
        background: linear-gradient(145deg, #e5e7eb, #f3f4f6); /* Light 3D background */
        border-radius: 15px;
        box-shadow: inset 3px 3px 6px rgba(0, 0, 0, 0.1), inset -3px -3px 6px rgba(255, 255, 255, 0.5); /* Inner shadow for depth */
    }

    /* Calendar container styling */
    #calendar {
        background: linear-gradient(145deg, #ffffff, #f3f4f6); /* Subtle gradient */
        border-radius: 20px;
        box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2), -5px -5px 15px rgba(255, 255, 255, 0.5); /* 3D effect */
        padding: 20px;
    }

    /* Event styling */
    .fc-event {
        background: linear-gradient(145deg, #34d399, #059669); /* Green gradient for events */
        border: none;
        color: white;
        font-weight: bold;
        border-radius: 8px;
        box-shadow: 3px 3px 6px rgba(0, 0, 0, 0.2), -2px -2px 4px rgba(255, 255, 255, 0.3);
    }

    .fc-event:hover {
        transform: scale(1.05); /* Slight zoom on hover */
        box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3), -3px -3px 6px rgba(255, 255, 255, 0.4);
    }
</style>
    

    
        
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let calendarEl = document.getElementById('calendar');
        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'fr',
            firstDay: 1, // La semaine commence avec lundi
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: @json(route('calendrier.events')), // Assurez-vous que la route retourne un JSON valide
            height: 'auto',
            editable: false,
            selectable: false
        });
        calendar.render();
    });
</script>
    
</x-home>
