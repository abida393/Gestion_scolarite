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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/fr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cascadia+Code:ital,wght@0,200..700;1,200..700&family=Jost:ital,wght@0,100..900;1,100..900&family=Lexend+Giga:wght@100..900&family=Lora:ital,wght@0,400..700;1,400..700&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Playwrite+RO:wght@100..400&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Ajoutez ceci dans le fichier principal (par exemple, layouts/app.blade.php) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>

<body style="">
    <!-- Sidebar -->
    <div class="sidebar" style="height: 100vh; overflow-y: auto; overflow-x: hidden;">

        <div class="logo">
            {{-- <img src="{{ asset('/images/logo2.png') }}" alt="Logo Établissement" style="align-items:left;width:150px"> --}}
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
            <a href="{{ route('absence_justif') }}" class="nav-item {{ Route::is('absence_justif') ? 'active' : '' }}"
                data-page="absences">
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
            <a href="{{ route('emploi.etudiant') }}"
                class="nav-item {{ Route::is('emploi.etudiant') ? 'active' : '' }}" data-page="emploi">
                <i class="fas fa-clock"></i>
                <span>Emploi du temps</span>
            </a>
            <a href="{{ route('calendrier') }}" class="nav-item {{ Route::is('calendrier') ? 'active' : '' }}"
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
            <a href="{{ route('news') }}" class="nav-item {{ Route::is('news') ? 'active' : '' }}" data-page="news">
                <i class="fas fa-newspaper"></i>
                <span>News</span>
            </a>
            <a href="{{ route('profile') }}" class="nav-item {{ Route::is('profile') ? 'active' : '' }}"
                data-page="profile">
                <i class="fas fa-newspaper"></i>
                <span>profile</span>
            </a>
            <a href="{{ route('aide') }}" class="nav-item {{ Route::is('aide') ? 'active' : '' }}" data-page="aide">
                <i class="far fa-question-circle"></i>
                <span>Aide</span>
            </a>
            {{-- <a href="{{ route('news') }}" class="nav-item {{ Route::is('news') ? 'active' : '' }}"
                    data-page="news">
                    <i class="fas fa-newspaper"></i>
                    <span>News</span>
                </a>
                <a href="{{ route('aide') }}" class="nav-item {{ Route::is('aide') ? 'active' : '' }}"
                    data-page="aide">
                    <i class="far fa-question-circle"></i>
                    <span>Aide</span>
                </a> --}}
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
                <i class="fa-regular fa-circle-user fa-2x"></i>
                <div class="dropdown-content">
                    <a href="#profile" class="px-4 py-2">Profile</a>
                    <form action="{{ route('logout') }}" method="post" onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?')">
                        @csrf
                    <button type="submit" class="w-full hover:bg-gray-100 px-4 py-2">Logout</button>
                    </form>
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
    </script>
</body>

</html>
