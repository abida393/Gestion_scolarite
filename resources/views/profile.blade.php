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
                <img src="{{ asset('storage/' . $etudiant->photo) }}" alt="Photo de profil">
            </div>
            <h2 class="profile-title">Profil Étudiant</h2>

            <div class="profile-info">
                <p><span>Nom :</span> {{ $etudiant->nom }}</p>
                <p><span>Prénom :</span> {{ $etudiant->prenom }}</p>
                <p><span>CIN :</span> {{ $etudiant->cin }}</p>
                <p><span>Classe :</span> {{ $etudiant->classe }}</p>
                <p><span>filiere :</span> {{ $etudiant->filiere }}</p>
                <p><span>Date de naissance :</span> {{ $etudiant->date_naissance }}</p>
                <p><span>Email :</span> {{ $etudiant->email }}</p>                      
                <p><span>Adresse :</span> {{ $etudiant->adresse }}</p>
                <p><span>Téléphone :</span> {{ $etudiant->telephone }}</p>
            </div>

            <div class="profile-actions">
                <a href="{{ route('password.edit') }}" class="btn btn-warning">Changer le mot de passe</a>

            </div>
        </div>
    </div>
</body>
</html>

