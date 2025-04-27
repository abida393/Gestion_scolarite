<x-home titre="profile" page_titre="profile">

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
    <style>
    body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f4f6f9;
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
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.profile-image img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid #007bff;
    margin-bottom: 20px;
}

.profile-title {
    font-size: 24px;
    margin-bottom: 20px;
    position: relative;
    display: inline-block;
}

.profile-title::after {
    content: "";
    width: 40%;
    height: 3px;
    background: #007bff;
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
}

.profile-info {
    display: grid;
    grid-template-columns: 150px 1fr;
    row-gap: 12px;
    column-gap: 15px;
    font-size: 16px;
    color: #444;
    text-align: left;
    margin-top: 20px;
}

.profile-info p {
    margin: 0;
    display: contents;
}

.profile-info span {
    font-weight: 600;
    color: #4361ee;
    text-align: right;
}

.profile-actions {
    margin-top: 30px;
    text-align: center;
}

.btn-password {
    background-color: #4361ee;
    color: white;
    padding: 12px 25px;
    text-decoration: none;
    border-radius: 8px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.btn-password:hover {
    background-color: #4361ee;
}

/* Responsive */
@media (max-width: 600px) {
    .profile-info {
        grid-template-columns: 1fr;
    }

    .profile-info span {
        text-align: left;
        display: block;
        margin-bottom: 5px;
    }

    .profile-info p {
        display: block;
        margin-bottom: 10px;
    }
}
</style> 
</x-home>