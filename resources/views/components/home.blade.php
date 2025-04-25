@props(['titre',"page_titre"]);
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page_titre }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    @vite('resources/css/app.css')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
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
            <a href="{{ route("calendrier") }}" class="nav-item {{ Route::is("calendrier")  ? 'active' : ''  }}" data-page="calendrier">
                <i class="far fa-calendar-alt"></i>
                <span>Calendrier</span>
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
            <a href="{{ route("stages") }}" class="nav-item {{ Route::is("stages")  ? 'active' : ''  }}" data-page="stage">
                <i class="fas fa-briefcase"></i>
                <span>Stages</span>
            </a>
            <a href="{{ route("aide") }}" class="nav-item {{ Route::is("aide")  ? 'active' : ''  }}" data-page="aide">
                <i class="far fa-question-circle"></i>
                <span>Aide</span>
            </a>
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
</body>
</html>
