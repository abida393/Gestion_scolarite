<x-home titre="Profil" page_titre="Profil" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">

<div class="profile-wrapper">
    <div class="profile-card">

        <div class="profile-image">
            <img src="{{ asset('storage/' . $etudiant->PHOTOS) }}" alt="Photo de profil">
        </div>

        <h2 class="profile-title">Profil Étudiant</h2>

        <div class="profile-info">
            <div class="info-item">
                <span>Nom :</span>
                <span>{{ $etudiant->etudiant_nom }}</span>
            </div>
            <div class="info-item">
                <span>Prénom :</span>
                <span>{{ $etudiant->etudiant_prenom }}</span>
            </div>
            <div class="info-item">
                <span>CIN :</span>
                <span>{{ $etudiant->etudiant_cin }}</span>
            </div>
            <div class="info-item">
                <span>Classe :</span>
                <span>{{ $etudiant->classes_id }}</span>
            </div>
            <div class="info-item">
                <span>Filière :</span>
                <span>{{ $etudiant->filiere_id }}</span>
            </div>
            <div class="info-item">
                <span>Date de naissance :</span>
                <span>{{ $etudiant->etudiant_date_naissance }}</span>
            </div>
            <div class="info-item">
                <span>Email :</span>
                <span>{{ $etudiant->etudiant_email }}</span>
            </div>
           
            <div class="info-item">
                <span>Téléphone :</span>
                <span>{{ $etudiant->etudiant_tel }}</span>
            </div>

            <div class="info-item">
                <span>Adresse :</span>
                <span>{{ $etudiant->etudiant_adresse }}</span>
                <div class="profile-actions">
            <a href="{{ route('password.edit') }}" class="btn-password">Changer le mot de passe</a>
        </div>
            </div>
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
    max-width: 800px;
    margin: 40px auto;
    padding: 20px;
}

.profile-card {
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.profile-image {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.profile-image img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid #007bff;
}

.profile-title {
    font-size: 26px;
    margin-bottom: 30px;
    position: relative;
    display: inline-block;
}

.profile-title::after {
    content: "";
    width: 60px;
    height: 3px;
    background: #007bff;
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
}

.profile-info {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px 40px;
    margin-top: 30px;
    text-align: left;
}

.info-item {
    display: flex;
    flex-direction: column;
}

.info-item span:first-child {
    font-weight: bold;
    color: #4361ee;
    margin-bottom: 5px;
}

.profile-actions {
    margin-top: 40px;
}

.btn-password {
    background-color: #4361ee;
    color: white;
    padding: 8px 16px;
    border-radius: 8px;
    font-weight: bold;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.btn-password:hover {
    background-color: #364fc7;
}

/* Responsive pour téléphone */
@media (max-width: 600px) {
    .profile-info {
        grid-template-columns: 1fr;
    }
}
</style>

</x-home>
