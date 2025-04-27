@props(['titre',"page_titre"]);
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page_titre }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    @vite('resources/css/app.css')
    <style>
      @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
      }

      @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
      }

      .animate-fade-in {
        animation: fade-in 0.5s ease-out both;
      }

      .animate-bounce-slow {
        animation: bounce-slow 0.4s ease-in-out infinite;
      }

      /* Simple JS-less filtering (à améliorer avec JS si tu veux) */
      .filter-btn.active {
        font-weight: bold;
        outline: 2px solid currentColor;
      }

      /* Cache les paiements filtrés */
      .hidden {
        display: none;
      }
        .sidebar {
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none; /* Internet Explorer 10+ */
        }

        .sidebar::-webkit-scrollbar {
        display: none; /* Chrome, Safari, Edge */
        }

    </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
  <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    @vite('resources/css/app.css')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Ajoutez ceci dans le fichier principal (par exemple, layouts/app.blade.php) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
    .fc {
      background-color: white;
      border-radius: 1rem;
      box-shadow:none;
      padding: 1.5rem;
    }

    .fc-header-toolbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1rem;
    }
    #eventModal {
    position: absolute; /* Allow dynamic positioning */
    z-index: 50; /* Ensure it appears above other elements */
    display: flex;
    align-items: center;
    justify-content: center;
}

.fc .fc-daygrid-day {
        background-color: white;
    }

    .fc-scrollgrid {
        background-color: white;
    }
    .fc-button {
      @apply bg-blue-600 text-white rounded px-3 py-1 text-sm font-medium mx-1 hover:bg-blue-700 transition;
    }
    .fc#calendar {
    height: 800px; /* Ajustez la hauteur selon vos besoins */
    width: 85%; /* Ajustez la largeur si nécessaire */
   margin-left: 8%;
   border-radius: 40%;
  }
  .min-h-screen {
    min-height: 100vh; /* Prend toute la hauteur de l'écran */
  }

  .flex {
    display: flex;
  }
  .fc-other-month {
  background-color: #f9f9f9; /* Couleur de fond plus claire */
  color: #ccc; /* Couleur du texte plus claire */
}
  .items-center {
    align-items: center; /* Centre verticalement */
  }

  .justify-center {
    justify-content: center; /* Centre horizontalement */
  }
    .fc-event {
      background-color:rgb(55, 122, 230) !important;
      color: white !important;
      padding: 0.25rem 0.5rem !important;
      border-radius: 0.375rem !important;
      border: none !important;
      transition: transform 0.2s ease-in-out;
      font-size: 0.875rem;
    }

    .fc-event:hover {
      transform: scale(1.05);
      cursor: pointer;
    }
  </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" style="height: 100vh; overflow-y: auto; overflow-x: hidden;">

        <div class="logo">
            <span class="logo-text">Portail Étudiant</span>
            <div class="burger-menu" id="mobile-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>

        <div class="nav-menu">
            <a href="{{ route("home") }}" class="nav-item {{ Route::is("home")  ? 'active' : ''  }}" data-page="accueil">
                <i class="fas fa-home"></i>
                <span>Accueil</span>
            </a>
            <a href="{{ route("notes") }}" class="nav-item {{ Route::is("notes")  ? 'active' : ''  }}" data-page="notes">
                <i class="far fa-sticky-note"></i>
                <span>Notes</span>
            </a>
            <a href="{{ route("demande_documents") }}" class="nav-item {{ Route::is("demande_documents")  ? 'active' : ''  }}" data-page="demandes">
                <i class="fas fa-file-alt"></i>
                <span>Demande documents</span>
            </a>
            <a href="{{ route("absence_justif") }}" class="nav-item {{ Route::is("absence_justif")  ? 'active' : ''  }}" data-page="absences">
                <i class="fas fa-user-clock"></i>
                <span>Absence et justif</span>
            </a>
            <a href="{{ route("paiement") }}" class="nav-item {{ Route::is("paiement")  ? 'active' : ''  }}" data-page="paiement">
                <i class="fas fa-money-bill-wave"></i>
                <span>Paiement</span>
            </a>
            <a href="{{ route("messagerie") }}" class="nav-item {{ Route::is("messagerie")  ? 'active' : ''  }}" data-page="messagerie">
                <i class="fa-solid fa-inbox"></i>
                <span>Messagerie</span>
            </a>
            <a href="{{ route("emploi") }}" class="nav-item {{ Route::is("emploi")  ? 'active' : ''  }}" data-page="emploi">
                <i class="fas fa-clock"></i>
                <span>Emploi du temps</span>
            </a>
            <a href="{{ route("calendrier") }}" class="nav-item {{ Route::is("calendrier")  ? 'active' : ''  }}" data-page="calendrier">
                <i class="far fa-calendar-alt"></i>
                <span>Calendrier</span>
            </a>
            <a href="{{ route("stages") }}" class="nav-item {{ Route::is("stages")  ? 'active' : ''  }}" data-page="stage">
                <i class="fas fa-briefcase"></i>
                <span>Stages</span>
            </a>
            <a href="{{ route("events") }}" class="nav-item {{ Route::is("events")  ? 'active' : ''  }}" data-page="event">
                <i class="fas fa-briefcase"></i>
                <span>Events</span>
            <a href="{{ route("news") }}" class="nav-item {{ Route::is("news")  ? 'active' : ''  }}" data-page="news">
                <i class="fas fa-newspaper"></i>
                <span>News</span>
            </a>
            <a href="{{ route("aide") }}" class="nav-item {{ Route::is("aide")  ? 'active' : ''  }}" data-page="aide">
                <i class="far fa-question-circle"></i>
                <span>Aide</span>
            </a>
            <button onclick="" class="filter-btn bg-red-500 text-white-700 font-medium px-4 py-1 rounded hover:bg-indigo-200 transition"><i class="fa-solid fa-right-from-bracket"></i>Log out</button>
 
        </div>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <div class="header-burger" id="header-toggle">
                <i class="fas fa-bars"></i>
            </div>
            <div class="header-title">{{ $titre }}</div>
        </div>
        <div class="header-actions">
            <i class="fas fa-bell"></i>
            <i class="fas fa-envelope"></i>
            <i class="fas fa-user-circle"></i>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="main-content">
        {{ $slot }}
    </main>
    @vite('resources/js/app.js')
        <!-- Script pour gérer le filtrage -->
        <script>
      document.getElementById('all').addEventListener('click', function() {
        filterPayments('all');
      });
      document.getElementById('cash').addEventListener('click', function() {
        filterPayments('cash');
      });
      document.getElementById('cheque').addEventListener('click', function() {
        filterPayments('cheque');
      });

      function filterPayments(filter) {
        const payments = document.querySelectorAll('.payment-row');
        payments.forEach(payment => {
          if (filter === 'all') {
            payment.classList.remove('hidden');
          } else if (filter === 'cash' && payment.classList.contains('payment-cash')) {
            payment.classList.remove('hidden');
          } else if (filter === 'cheque' && payment.classList.contains('payment-cheque')) {
            payment.classList.remove('hidden');
          } else {
            payment.classList.add('hidden');
          }
        });

        // Ajouter un style actif sur le bouton sélectionné
        const buttons = document.querySelectorAll('.filter-btn');
        buttons.forEach(button => {
          button.classList.remove('active');
        });
        document.getElementById(filter).classList.add('active');
      }
    </script>
</body>
</html>