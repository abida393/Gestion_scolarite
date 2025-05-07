<x-home titre="stage-page" page_titre="stage-page" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>

<style>
   :root {
    --primary: #4361ee;
    --secondary:rgb(68, 47, 116);
    --accent: #4895ef;
    --accent-light: #4cc9f0;
    --light: #f8f9fa;
    --dark: #212529;
    --success: #38b000;
    --gradient-primary: linear-gradient(135deg, var(--primary), var(--secondary));
    --gradient-accent: linear-gradient(135deg, var(--accent), var(--accent-light));
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background-color: #f8faff;
    color: var(--dark);
    line-height: 1.6;
    overflow-x: hidden;
}

/* Header avec animation de fond */
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
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
    animation: pulse 15s infinite alternate;
}

@keyframes pulse {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

h1 {
    text-align: center;
    margin-bottom: 0.5rem;
    font-weight: 700;
    position: relative;
    display: inline-block;
}

h1::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: var(--accent-light);
    border-radius: 2px;
}

.subtitle {
    font-size: 1.3rem;
    opacity: 0.9;
    font-weight: 300;
    max-width: 700px;
    margin: 0 auto;
}

.container {
    max-width: 1300px;
    margin: 0 auto;
    padding: 0 30px;
}

/* Section Filtres améliorée */
.filters-section {
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 3rem;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
}

.section-title {
    display: flex;
    align-items: center;
    font-size: 1.5rem;
    color: var(--secondary);
    margin-bottom: 1.5rem;
}

.section-title i {
    margin-right: 12px;
    color: var(--accent);
}

.filters {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1rem;
}

.filter-btn {
    padding: 0.7rem 1.5rem;
    border-radius: 50px;
    background: white;
    border: 1px solid #e0e0e0;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.95rem;
    font-weight: 500;
    display: flex;
    align-items: center;
}

.filter-btn i {
    margin-right: 8px;
    font-size: 0.9rem;
}

.filter-btn:hover, .filter-btn.active {
    background: var(--gradient-primary);
    color: white;
    border-color: transparent;
    box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
    transform: translateY(-2px);
}

/* Grid des offres modernisées */
.offres-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 2.5rem;
    margin-bottom: 5rem;
}

.offre-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    display: flex;
    flex-direction: column;
    height: 100%;
    position: relative;
}

.offre-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: var(--gradient-accent);
}

.offre-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
}

.card-header {
    display: flex;
    align-items: center;
    padding: 1.8rem 1.8rem 1rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.entreprise-logo {
    width: 70px;
    height: 70px;
    object-fit: contain;
    border-radius: 12px;
    margin-right: 1.2rem;
    background: white;
    padding: 8px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    border: 1px solid #eee;
    transition: transform 0.3s ease;
}

.offre-card:hover .entreprise-logo {
    transform: scale(1.05);
}

.entreprise-info {
    flex: 1;
}

.entreprise-nom {
    font-size: 1.4rem;
    font-weight: 600;
    color: var(--secondary);
    margin-bottom: 0.3rem;
}

.entreprise-secteur {
    font-size: 0.95rem;
    color: #666;
    font-weight: 500;
    display: inline-block;
    padding: 0.3rem 0.8rem;
    background: rgba(67, 97, 238, 0.1);
    border-radius: 50px;
}

.card-body {
    padding: 1.8rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.offre-titre {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 1.2rem;
    color: var(--dark);
    line-height: 1.4;
}

.offre-description {
    color: #555;
    margin-bottom: 1.8rem;
    font-size: 0.97rem;
    line-height: 1.7;
    background-color: #fafbff;
    padding: 1.2rem;
    border-radius: 10px;
    border-left: 4px solid var(--accent);
}

.duree-stage {
    display: flex;
    align-items: center;
    color: var(--primary);
    font-weight: 600;
    margin-bottom: 1.2rem;
    font-size: 0.95rem;
}

.duree-stage i {
    margin-right: 8px;
    font-size: 1.1rem;
}

.besoins-title {
    font-weight: 600;
    margin-bottom: 0.8rem;
    color: var(--secondary);
    font-size: 1rem;
    display: flex;
    align-items: center;
}

.besoins-title i {
    margin-right: 8px;
    color: var(--accent);
}

.besoins-list {
    list-style-type: none;
    margin-bottom: 2rem;
}

.besoins-list li {
    padding: 0.4rem 0;
    padding-left: 1.8rem;
    position: relative;
    font-size: 0.93rem;
}

.besoins-list li:before {
    content: "▹";
    color: var(--accent);
    position: absolute;
    left: 0;
    top: 0.4rem;
}

/* Bouton postuler premium */
.apply-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: var(--gradient-primary);
    color: white;
    padding: 1rem 1.8rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    text-align: center;
    transition: all 0.4s ease;
    border: none;
    cursor: pointer;
    width: 100%;
    font-size: 1rem;
    box-shadow: 0 5px 20px rgba(67, 97, 238, 0.3);
    margin-top: auto;
    overflow: hidden;
    position: relative;
}

.apply-btn i {
    margin-right: 10px;
    transition: transform 0.3s ease;
}

.apply-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(67, 97, 238, 0.4);
    background: linear-gradient(135deg, var(--secondary), var(--primary));
}

.apply-btn:hover i {
    transform: translateX(5px);
}

.apply-btn:active {
    transform: translateY(0);
}

/* Bouton QR Code */
.qr-circle-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--accent);
    color: white;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    margin-left: 10px;
}

.qr-circle-btn:hover {
    background: var(--primary);
    transform: scale(1.1);
}

.qr-circle-btn i {
    font-size: 18px;
}

.button-group {
    display: flex;
    align-items: center;
    margin-top: auto;
}

/* Modal QR */
.qr-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.8);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}

.qr-container {
    background: white;
    padding: 30px;
    border-radius: 15px;
    text-align: center;
    max-width: 300px;
    animation: fadeIn 0.3s;
}

.qr-close {
    position: absolute;
    top: 20px;
    right: 20px;
    color: white;
    font-size: 30px;
    cursor: pointer;
}

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}

/* Bouton contact flottant */
.floating-contact-btn {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background: var(--gradient-accent);
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    box-shadow: 0 10px 30px rgba(72, 149, 239, 0.4);
    z-index: 100;
    transition: all 0.3s ease;
    animation: float 3s ease-in-out infinite;
    text-decoration: none;
}

.floating-contact-btn:hover {
    transform: scale(1.1) translateY(-5px);
    box-shadow: 0 15px 40px rgba(72, 149, 239, 0.6);
}

@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
}

/* Responsive */
@media (max-width: 992px) {
    .offres-grid {
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    }
}

@media (max-width: 768px) {
    header {
        padding: 3rem 0;
    }
    
    h1 {
        font-size: 2.2rem;
    }
    
    .subtitle {
        font-size: 1.1rem;
        padding: 0 20px;
    }
    
    .container {
        padding: 0 20px;
    }
    
    .filters {
        justify-content: center;
    }
    
    .offre-card {
        max-width: 100%;
    }
}

@media (max-width: 576px) {
    .offres-grid {
        grid-template-columns: 1fr;
    }
    
    .filter-btn {
        padding: 0.6rem 1.2rem;
        font-size: 0.9rem;
    }
    
    .card-header {
        flex-direction: column;
        text-align: center;
        padding-bottom: 1.5rem;
    }
    
    .entreprise-logo {
        margin-right: 0;
        margin-bottom: 1rem;
    }
    
    .button-group {
        flex-direction: column;
    }
    
    .qr-circle-btn {
        margin-left: 0;
        margin-top: 10px;
    }
}
</style>      
    <header>
        <div class="container">
            <h1 class="text-4xl font-bold text-900 text-center mb-14"><i class="fas fa-briefcase"></i> Offres de Stage</h1>
            <p class="subtitle" style="font-size:20px">Trouvez le stage idéal pour booster votre carrière parmi nos opportunités exclusives</p>
        </div>
    </header>

    <div class="container">
        <section class="filters-section">
            <h2 class="section-title"><i class="fas fa-filter"></i> Filtres Avancés</h2>
            <div class="filters">
                <button class="filter-btn active" data-filter="tous">
                    <i class="fas fa-layer-group"></i> Tous
                </button>
                <button class="filter-btn" data-filter="informatique">
                    <i class="fas fa-laptop-code"></i> Informatique
                </button>
                <button class="filter-btn" data-filter="marketing">
                    <i class="fas fa-bullhorn"></i> Marketing
                </button>
                <button class="filter-btn" data-filter="finance">
                    <i class="fas fa-chart-line"></i> Finance
                </button>
                <button class="filter-btn" data-filter="electronique">
                    <i class="fas fa-cogs"></i> Electronique
                </button>
            </div>
        </section>

        <div class="offres-grid">
            @foreach ($stages as $stage)
            <div class="offre-card" data-domaine="{{ strtolower($stage->domaine) }}">
                <div class="card-header">
                    <img src="{{ asset('storage/' . $stage->photo) }}" alt="Logo {{ $stage->entreprise }}" class="entreprise-logo">
                    <div class="entreprise-info">
                        <h3 class="entreprise-nom">{{ $stage->entreprise }}</h3>
                        <span class="entreprise-secteur">{{ $stage->domaine }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <h4 class="offre-titre">{{ $stage->nom_stage }}</h4>
                    <span class="duree-stage">
                        <i class="far fa-clock"></i> Durée: {{ $stage->duree }}
                    </span>

                    <div class="offre-description">
                        <strong>Description du poste :</strong><br>
                        {{ $stage->description }}
                    </div>

                    <h5 class="besoins-title"><i class="fas fa-info-circle"></i> Informations de contact</h5>
                    <ul class="besoins-list">
                        <li><strong>Email :</strong> {{ $stage->email_entreprise }}</li>
                        <li><strong>Duree :</strong> {{ $stage->duree}}</li>
                    </ul>

                    <div class="button-group">
                    @php
                    $email = $stage->email_entreprise;
                    $subject = $stage->nom_stage;
                    @endphp 

                    @if(!empty($email))
                        <a href="https://mail.google.com/mail/?view=cm&to={{ urlencode($email) }}&su={{ urlencode($subject) }}" target="_blank" class="apply-btn">
                        <i class="fab fa-google"></i> Postuler
                        </a>
                    @else
                        <button class="btn-disabled" disabled>
                            <i class="fas fa-exclamation-circle"></i> Email non disponible
                        </button>
                    @endif
                        
                  </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
  <script>
        // Animation des filtres
        const buttons = document.querySelectorAll('.filter-btn');
        const cards = document.querySelectorAll('.offre-card');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                buttons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');

                const filter = button.getAttribute('data-filter').toLowerCase();

                cards.forEach(card => {
                    const domaine = card.getAttribute('data-domaine').toLowerCase();

                    if (filter === 'tous' || domaine.includes(filter)) {
                        card.style.display = 'flex';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, 50);
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });

        // Animation au scroll
        const observerOptions = {
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.offre-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    </script>
</x-home>
