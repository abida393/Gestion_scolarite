@php
    $responsable = Auth::guard('responsable')->user();
@endphp
@props(['titre', 'page_titre', 'nom_complete'])

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page_titre }}</title>

    <!-- Font Awesome (latest version) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;400;600;800&display=swap" rel="stylesheet">

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Vite (CSS and JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* Header with background animation
        header {
            color: white;
            text-align: center;
            position: relative;
        }

        header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
            animation: pulse 15s infinite alternate;
        }

        @keyframes pulse {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        } */

        .logo {
            display: flex;
            margin: auto;
            padding:0 30px 10px;

        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" style="height: 100vh; overflow-y: auto; overflow-x: hidden;">
       <div class="flex justify-end p-3">
    <div class="burger-menu p-2 bg-[#4270f4]/10 hover:bg-[#4270f4]/20 text-[#4270f4] hover:text-[#4270f4]/90 cursor-pointer transition-all duration-200" id="mobile-toggle">
        <i class="fas fa-bars text-xl"></i>
    </div>
</div>
        <div class="logo">
            <img src="{{ asset('/images/logo1.jpg') }}" alt="Logo Établissement" style="align-items:left;width:150px">
            {{-- <div class="burger-menu" id="mobile-toggle">
                <i class="fas fa-bars"></i>
            </div> --}}
        </div>
        <br>
        <div class="nav-menu">
            <a href="{{ route('home') }}" class="nav-item {{ Route::is('home') ? 'active' : '' }}" data-page="accueil">
                <i class="fas fa-home"></i>
                <span>Accueil</span>
            </a>
            <a href="{{ route('responsable.absences.index') }}" 
            class="nav-item {{ Route::is('responsable.absences.index') ? 'active' : '' }}"
            data-page="absences">
            <i class="fas fa-user-clock"></i>
            <span>Absence et justif</span>
            </a>

            <a href="{{ route('calendar.calendrier') }}"
                class="nav-item {{ Route::is('calendar.calendrier') ? 'active' : '' }}" data-page="calendrier">
                <i class="far fa-calendar-alt"></i>
                <span>Calendrier</span>
            </a>

            <!-- Ajouter par imad -->
            <a href="{{ route('responsable.documents.index') }}"
            class="nav-item {{ Route::is('responsable.documents.index') ? 'active' : '' }}" data-page="demandes">
                <i class="fas fa-file-alt"></i>
                <span>Suivi documents</span>
            </a>
            <a href="{{ route('responsable.events') }}" class="nav-item {{ Route::is('responsable.events') ? 'active' : '' }}" data-page="evenements">
                    <i class="fas fa-briefcase"></i>
                    <span>Événements</span>
            </a>
            <!---------------------->

            <a href="{{ route('messagerie') }}" class="nav-item {{ Route::is('messagerie') ? 'active' : '' }}"
                data-page="messagerie">
                <i class="fa-solid fa-inbox"></i>
                <span>Messagerie</span>
            </a>
            <a href="{{ route('notes') }}" class="nav-item {{ Route::is('notes') ? 'active' : '' }}"
                data-page="notes">
                <i class="far fa-sticky-note"></i>
                <span>Notes</span>
            </a>

            <!-- Ajouter par imad -->
            <a href="{{ route('news.index') }}" class="nav-item {{ Route::is('news.index') ? 'active' : '' }}" data-page="news">
                <i class="fas fa-newspaper"></i>
                <span>News</span>
            </a>
            <!---------------------->

            <a href="{{ route('paiement') }}" class="nav-item {{ Route::is('paiement') ? 'active' : '' }}"
                data-page="paiement">
                <i class="fas fa-money-bill-wave"></i>
                <span>Paiement</span>
            </a>

            <!-- Ajouter par imad -->
            <a href="{{ route('stages-responsable') }}" class="nav-item {{ Route::is('stages-responsable') ? 'active' : '' }}" data-page="stage">
                <i class="fas fa-briefcase"></i>
                <span>Stages</span>
            </a>
            <!---------------------->

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
            <div class="relative group">
                @if (Auth::guard('responsable')->user()->profile_picture)
                    <img src="{{ asset('storage/' . Auth::guard('responsable')->user()->profile_picture) }}"
                        alt="Profile Picture"
                        class="w-10 h-10 rounded-full object-cover cursor-pointer border-2 border-indigo-500 hover:border-indigo-600 transition-all duration-200">
                @else
                    @php
                        $initial =
                            strtoupper(substr(Auth::guard('responsable')->user()->responsable_nom, 0, 1)) .
                            strtoupper(substr(Auth::guard('responsable')->user()->responsable_prenom, 0, 1));
                    @endphp
                    <div
                        class="w-10 h-10 flex items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-indigo-400 text-white font-bold text-sm cursor-pointer border-2 border-indigo-500 hover:border-indigo-600 transition-all duration-200 shadow-sm">
                        {{ $initial }}
                    </div>
                @endif

                <!-- Dropdown Menu -->
                <div
                    class="absolute right-0 mt-2 w-56 origin-top-right bg-white rounded-xl shadow-xl opacity-0 invisible scale-95 group-hover:opacity-100 group-hover:visible group-hover:scale-100 transition-all duration-200 z-50 border border-gray-100 overflow-hidden transform-gpu">
                    <div class="px-4 py-3 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-indigo-100">
                        <p class="text-sm font-medium text-indigo-900 truncate">
                            {{ Auth::guard('responsable')->user()->responsable_prenom }}
                            {{ Auth::guard('responsable')->user()->responsable_nom }}
                        </p>
                        <p class="text-xs text-indigo-600 truncate">
                            {{ Auth::guard('responsable')->user()->email ?? '' }}
                        </p>
                    </div>

                    <div class="py-1">
                        <a href="{{ route('profile') }}"
                            class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200">
                            <svg class="w-4 h-4 mr-3 text-indigo-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Mon Profil
                        </a>

                        <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="button" onclick="openModal()"
                                class="w-full flex items-center text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-red-600 transition-all duration-200">
                                <svg class="w-4 h-4 mr-3 text-red-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="profile-info flex flex-col items-start text-white">
                {{-- <div class="profile-name font-semibold text-lg">
                    {{ $nom_complete }}
                </div> --}}
            </div>
        </div>
    </header>

    <!-- Modal de confirmation -->
    <div id="confirmationModal"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-30 hidden z-50 transition-opacity duration-200">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full max-w-xs transform transition-all duration-200 scale-95 opacity-0"
            id="modalContent">
            <!-- Contenu du modal -->
            <div class="p-6 text-center">
                <!-- Icône -->
                <div class="mx-auto flex items-center justify-center w-16 h-16 rounded-full bg-[#4270f4]/10 mb-4">
                    <svg class="w-8 h-8 text-[#4270f4]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                </div>

                <!-- Texte -->
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Se déconnecter ?</h3>
                <p class="text-sm text-gray-500 mb-6">Êtes-vous sûr de vouloir vous déconnecter ?</p>

                <!-- Boutons -->
                <div class="flex gap-3">
                    <button onclick="closeModal()"
                        class="flex-1 py-2 text-sm font-medium rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                        Annuler
                    </button>
                    <button onclick="submitLogout()"
                        class="flex-1 py-2 text-sm font-medium rounded-lg bg-[#4270f4] text-white hover:bg-[#4270f4]/90 transition-colors duration-200">
                        Se déconnecter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        {{ $slot }}
        </main>

        @vite('resources/js/app.js')

        <!-- Script for filtering -->
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

                // Add active style to selected button
                const buttons = document.querySelectorAll('.filter-btn');
                buttons.forEach(button => {
                    button.classList.remove('active');
                });
                document.getElementById(filter).classList.add('active');
            }

            // Modal functions
            function openModal() {
                const modal = document.getElementById('confirmationModal');
                const content = document.getElementById('modalContent');

                modal.classList.remove('hidden');
                setTimeout(() => {
                    content.classList.remove('scale-95', 'opacity-0');
                    content.classList.add('scale-100', 'opacity-100');
                }, 10);
            }

            function closeModal() {
                const modal = document.getElementById('confirmationModal');
                const content = document.getElementById('modalContent');

                content.classList.remove('scale-100', 'opacity-100');
                content.classList.add('scale-95', 'opacity-0');

                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 200);
            }

            function submitLogout() {
                document.getElementById('logoutForm').submit();
            }
        </script>

        @stack('scripts')
</body>

</html>
