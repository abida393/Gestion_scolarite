<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Étudiant</title>
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>
<body>
    <div class="profile-wrapper">
        <div class="profile-card">
            <div class="profile-image">
                <img src="{{ asset('storage/' . $etudiant->PHOTOS) }}" alt="Photo de profil">
            </div>
            <h2 class="profile-title">Profil Étudiant</h2>

            <div class="profile-info">
                <p><span>Nom :</span> {{ $etudiant->etudiant_nom }}</p>
                <p><span>Prénom :</span> {{ $etudiant->etudiant_prenom }}</p>
                <p><span>CIN :</span> {{ $etudiant->etudiant_cin }}</p>
                <p><span>Classe :</span> {{ $etudiant->classes_id }}</p> <!-- il faudrait charger la vraie classe dans ton Controller -->
                <p><span>Filière :</span> {{ $etudiant->filiere_id }}</p> <!-- pareil ici -->
                <p><span>Date de naissance :</span> {{ $etudiant->etudiant_date_naissance }}</p>
                <p><span>Email :</span> {{ $etudiant->etudiant_email }}</p>                      
                <p><span>Adresse :</span> {{ $etudiant->etudiant_adresse }}</p>
                <p><span>Téléphone :</span> {{ $etudiant->etudiant_tel }}</p>
            </div>

            <div class="profile-actions">
                <a href="{{ route('password.edit') }}" class="btn btn-warning">Changer le mot de passe</a>
            </div>
        </div>
    </div>
</body>
</html>
