@php
    $etudiant = Auth::guard('etudiant')->user();
    $filiere = $etudiant->filiere;
@endphp
@props(['titre', 'page_titre', 'nom_complete']);
<!DOCTYPE html>
<html lang="fr">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page_titre }}</title>

    <!-- Font Awesome (dernière version) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;400;600;800&display=swap" rel="stylesheet">

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <!-- Vite (CSS et JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce-slow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-4px);
            }
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
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* Internet Explorer 10+ */
        }

        .sidebar::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, Edge */
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            border-radius: 5px;
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            width: 100px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            border-radius: 5px;
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            border-radius: 5px;
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown i {
            cursor: pointer;
        }
    </style>
    

    
</head>

<body style="">
    <!-- Sidebar -->
    <div class="sidebar" style="height: 100vh; overflow-y: auto; overflow-x: hidden;">

        <div class="logo">
            <img src="{{ asset('/images/logo.jpeg') }}" alt="Logo Établissement" style="align-items:left;width:150px">
            <div class="burger-menu" id="mobile-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
        <br>
        <div class="nav-menu">
            <a href="{{ route('home') }}" class="nav-item {{ Route::is('home') ? 'active' : '' }}" data-page="accueil">
                <i class="fas fa-home"></i>
                <span>Accueil</span>
            </a>
            <a href="{{ route('notes') }}" class="nav-item {{ Route::is('notes') ? 'active' : '' }}" data-page="notes">
                <i class="far fa-sticky-note"></i>
                <span>Notes</span>
            </a>
            <a href="{{ route('demande_documents') }}"
                class="nav-item {{ Route::is('demande_documents') ? 'active' : '' }}" data-page="demandes">
                <i class="fas fa-file-alt"></i>
                <span>Demande documents</span>
            </a>
            <a href="{{ route('absence_justif') }}"
                class="nav-item {{ Route::is('absence_justif') ? 'active' : '' }}" data-page="absences">
                <i class="fas fa-user-clock"></i>
                <span>Absence et justif</span>
            </a>
            <a href="{{ route('paiement') }}" class="nav-item {{ Route::is('paiement') ? 'active' : '' }}"
                data-page="paiement">
                <i class="fas fa-money-bill-wave"></i>
                <span>Paiement</span>
            </a>
            <a href="{{ route('messagerie') }}" class="nav-item {{ Route::is('messagerie') ? 'active' : '' }}"
                data-page="messagerie">
                <i class="fa-solid fa-inbox"></i>
                <span>Messagerie</span>
            </a>
            <a href="{{ route('emploi.etudiant') }}" class="nav-item {{ Route::is('emploi.etudiant') ? 'active' : '' }}"
                data-page="emploi">
                <i class="fas fa-clock"></i>
                <span>Emploi du temps</span>
            </a>
            <a href="{{ route('calendar.calendrier') }}" class="nav-item {{ Route::is('calendar.calendrier') ? 'active' : '' }}"
                data-page="calendrier">
                <i class="far fa-calendar-alt"></i>
                <span>Calendrier</span>
            </a>
            <a href="{{ route('events') }}" class="nav-item {{ Route::is('events') ? 'active' : '' }}"
                data-page="event">
                <i class="fas fa-briefcase"></i>
                <span>Evenements</span>
            </a>
            <a href="{{ route('stages') }}" class="nav-item {{ Route::is('stages') ? 'active' : '' }}"
                data-page="stage">
                <i class="fas fa-briefcase"></i>
                <span>Stages</span>
            </a>
            <a href="{{ route("news") }}" class="nav-item {{ Route::is("news")  ? 'active' : ''  }}" data-page="news">
                <i class="fas fa-newspaper"></i>
                <span>News</span>
            </a>
            <a href="{{ route("profile") }}" class="nav-item {{ Route::is("profile")  ? 'active' : ''  }}" data-page="profile">
                <i class="fas fa-newspaper"></i>
                <span>profile</span>
            </a>
            <a href="{{ route("aide") }}" class="nav-item {{ Route::is("aide")  ? 'active' : ''  }}" data-page="aide">
                <i class="far fa-question-circle"></i>
                <span>Aide</span>
            </a>
            <a href="{{ route('events') }}" class="nav-item {{ Route::is('events') ? 'active' : '' }}"
                data-page="event">
                <i class="fas fa-briefcase"></i>
                <span>Events</span>
                </a>
               
        </div>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <div class="header-burger" id="header-toggle">
                <i class="fa-solid fa-bars fa-lg"></i>
            </div>
            <div class="header-title">{{ $page_titre }}</div>
        </div>
        <div class="header-actions">


            {{-- <img src="{{ asset('/images/banner.png') }}" alt="Profile" class="profile-image"  style="height: 40px; width: 40px; border-radius: 50%; object-fit: cover;"> --}}
            <div class="dropdown">
                <i class="fa-regular fa-circle-user fa-2x" style="font-size: 25px;"></i>
                <div class="dropdown-content">
                    <a href="#profile">Profile</a>
                    <a href="#logout">Logout</a>
                </div>
            </div>
            <div class="profile-info">
                <div class="profile-name" style="color:rgba(8, 0, 58, 0.868)"><b>{!! $nom_complete !!}</b></div>
                <div class="profile-class" style="color: rgba(8, 0, 58, 0.874);">{{ $filiere->nom_filiere }}</div>
            </div>
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
            filterPayments('credit card');
        });

        function filterPayments(filter) {
            const payments = document.querySelectorAll('.payment-row');
            payments.forEach(payment => {
                if (filter === 'all') {
                    payment.classList.remove('hidden');
                } else if (filter === 'cash' && payment.classList.contains('payment-cash')) {
                    payment.classList.remove('hidden');
                } else if (filter === 'credit card' && payment.classList.contains('payment-cheque')) {
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
        @stack('scripts')
    </script>
</body>

</html>
