<x-home titre="Profil" page_titre="Profil" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">
    <div class="profile-wrapper">
        <div class="profile-card animated-fade">

             <div class="profile-header">
                <div class="profile-image hover-scale">
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
                <h2 class="profile-name">{{ $etudiant->etudiant_prenom }} {{ $etudiant->etudiant_nom }}</h2>
                <p class="profile-email">{{ $etudiant->etudiant_email }}</p>
            </div>

            <div class="profile-body two-columns">
    <div class="info-item">
        <span class="label">CIN :</span>
        <span class="value">{{ $etudiant->etudiant_cin }}</span>
    </div>
    <div class="info-item">
        <span class="label">Classe :</span>
        <span class="value">{{ $classe->nom_classe }}</span>
    </div>
    <div class="info-item">
        <span class="label">Filière :</span>
        <span class="value">{{ $filiere->nom_filiere }}</span>
    </div>
    <div class="info-item">
        <span class="label">Date de naissance :</span>
        <span class="value">{{ $etudiant->etudiant_date_naissance }}</span>
    </div>
    <div class="info-item">
        <span class="label">Téléphone :</span>
        <span class="value">{{ $etudiant->etudiant_tel }}</span>
    </div>
    <div class="info-item">
        <span class="label">Adresse :</span>
        <span class="value">{{ $etudiant->etudiant_adresse }}</span>
    </div>
</div>


            <div class="profile-footer">
                <a href="{{ route('password.edit') }}" class="btn-password">Changer le mot de passe</a>
            </div>
        </div>
    </div>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #f4f6f9, #e9eef5);
            margin: 0;
            padding: 0;
        }

        .profile-wrapper {
            max-width: 700px;
            margin: 40px auto;
            padding: 20px;
        }

        .profile-card {
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: box-shadow 0.3s ease;
        }

        .profile-card:hover {
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
        }

        .animated-fade {
            animation: fadeInUp 0.8s ease-in-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .profile-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid #007bff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }

        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-initials {
            width: 100%;
            height: 100%;
            font-size: 48px;
            font-weight: bold;
            color: #fff;
            background: linear-gradient(135deg, #007bff, #00aaff);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-names {
            font-size: 22px;
            font-weight: 600;
            margin-top: 5px;
        }

        .profile-email {
            font-size: 14px;
            color: #6c757d;
        }

        .profile-body {
            margin-top: 25px;
            text-align: left;
        }

        .info-item {
            margin-bottom: 18px;
        }

        .label {
            font-weight: bold;
            color: #4361ee;
            font-size: 15px;
        }

        .value {
            display: block;
            margin-top: 4px;
            color: #343a40;
            font-size: 15px;
        }

        .profile-footer {
            margin-top: 35px;
            text-align: center;
        }

        .btn-password {
            background: linear-gradient(135deg, #4361ee, #364fc7);
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: bold;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .btn-password:hover {
            background: linear-gradient(135deg, #364fc7, #2e3fae);
            transform: scale(1.03);
        }

        @media (max-width: 600px) {
            .profile-card {
                padding: 20px;
            }

            .profile-names {
                font-size: 20px;
            }

            .profile-body {
                font-size: 14px;
            }
            .two-columns {
        grid-template-columns: 1fr;
    }
        }
        .two-columns {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px 40px;
}

    </style>
</style>
<x-chat-button></x-chat-button>
</x-home>
