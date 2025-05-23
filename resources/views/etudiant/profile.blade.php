<x-home titre="Profil etudiant" page_titre="Profil etudiant" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ', ' . Auth::guard('etudiant')->user()->etudiant_prenom">
    @php
        $etudiant = Auth::guard('etudiant')->user();
    @endphp

    <div class="profile-wrapper">
        <div class="profile-card animated-fade">
            <div class="profile-header">
                <div class="profile-image hover-scale shadow-lg ring-4 ring-blue-200">
                    @if ($etudiant->PHOTOS)
                        <img src="{{ asset('storage/' . $etudiant->PHOTOS) }}" alt="Photo de profil">
                    @else
                        @php
                            $firstInitial = strtoupper(substr($etudiant->etudiant_prenom, 0, 1));
                            $lastInitial = strtoupper(substr($etudiant->etudiant_nom, 0, 1));
                        @endphp
                        <div class="profile-initials">{{ $lastInitial }}{{ $firstInitial }}</div>
                    @endif
                </div>
                <h2 class="profile-name gradient-text">{{ $etudiant->etudiant_prenom }} {{ $etudiant->etudiant_nom }}</h2>
                <p class="profile-email"><i class="fas fa-envelope mr-2 text-blue-400"></i>{{ $etudiant->email_ecole }}</p>
            </div>

            <div class="profile-body two-columns">
                <div class="info-item"><span class="label"><i class="fas fa-id-card mr-1"></i>CIN :</span><span class="value">{{ $etudiant->etudiant_cin }}</span></div>
                <div class="info-item"><span class="label"><i class="fas fa-users mr-1"></i>Classe :</span><span class="value">{{ $classe->nom_classe ?? '' }}</span></div>
                <div class="info-item"><span class="label"><i class="fas fa-book mr-1"></i>Filière :</span><span class="value">{{ $filiere->nom_filiere ?? '' }}</span></div>
                <div class="info-item"><span class="label"><i class="fas fa-birthday-cake mr-1"></i>Date de naissance :</span><span class="value">{{ $etudiant->etudiant_date_naissance }}</span></div>
                <div class="info-item"><span class="label"><i class="fas fa-phone mr-1"></i>Téléphone :</span><span class="value">{{ $etudiant->etudiant_tel }}</span></div>
                <div class="info-item"><span class="label"><i class="fas fa-home mr-1"></i>Adresse :</span><span class="value">{{ $etudiant->etudiant_adresse }}</span></div>
            </div>

            <div class="profile-footer">
                <a href="{{ route('password.edit') }}" class="btn-password shadow-lg"><i class="fas fa-key mr-2"></i>Changer le mot de passe</a>
            </div>
        </div>
    </div>

    <style>
        .profile-wrapper { max-width: 950px; margin: 40px auto; padding: 20px;}
        .profile-card { background: linear-gradient(135deg, #f8fafc 60%, #e0e7ff 100%); padding: 35px; border-radius: 24px; box-shadow: 0 10px 30px rgba(67,97,238,0.10); text-align: center;}
        .animated-fade { animation: fadeInUp 0.8s ease-in-out;}
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px);} to { opacity: 1; transform: translateY(0);}
        }
        .profile-header { display: flex; flex-direction: column; align-items: center; margin-bottom: 30px;}
        .profile-image { width: 150px; height: 150px; border-radius: 50%; overflow: hidden; border: 4px solid #3b82f6; display: flex; align-items: center; justify-content: center; margin-bottom: 15px; background: #e0e7ff;}
        .hover-scale:hover { transform: scale(1.05);}
        .profile-image img { width: 100%; height: 100%; object-fit: cover;}
        .profile-initials { width: 100%; height: 100%; font-size: 48px; font-weight: bold; color: #fff; background: linear-gradient(135deg, #3b82f6, #6366f1); display: flex; align-items: center; justify-content: center;}
        .profile-name { font-size: 26px; font-weight: 700; margin-top: 5px; margin-bottom: 2px;}
        .gradient-text { background: linear-gradient(90deg, #3b82f6, #6366f1); -webkit-background-clip: text; -webkit-text-fill-color: transparent;}
        .profile-email { font-size: 15px; color: #3b82f6; margin-bottom: 10px;}
        .profile-body { margin-top: 25px; text-align: left;}
        .two-columns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px 32px;
        }
        .info-item { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(67,97,238,0.06); padding: 18px 14px; margin-bottom: 0; display: flex; flex-direction: column; align-items: flex-start;}
        .label { font-weight: bold; color: #3b82f6; font-size: 15px; margin-bottom: 4px;}
        .value { color: #343a40; font-size: 15px;}
        .profile-footer {
            margin-top: 40px;
            text-align: center;
        }
        .btn-password {
            background: linear-gradient(135deg, #4361ee, #364fc7);
            color: white;
            padding: 14px 32px;
            border-radius: 12px;
            font-weight: bold;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.18);
            transition: background 0.3s, transform 0.2s;
            display: inline-block;
            font-size: 16px;
            letter-spacing: 1px;
        }
        .btn-password:hover {
            background: linear-gradient(135deg, #364fc7, #2e3fae);
            transform: scale(1.04);
        }
        @media (max-width: 1100px) {
            .two-columns { grid-template-columns: 1fr; }
        }
        @media (max-width: 700px) {
            .two-columns { grid-template-columns: 1fr; }
            .profile-card { padding: 18px;}
        }
    </style>
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
</x-home>