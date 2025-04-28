<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
   :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --accent: #4895ef;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #4cc9f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7ff;
            color: var(--dark);
            line-height: 1.6;
        }

        header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 3rem 0;
            text-align: center;
            margin-bottom: 2rem;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            font-weight: 300;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .offres-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .offre-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .offre-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            display: flex;
            align-items: center;
            padding: 1.5rem;
            background: linear-gradient(135deg, #f5f7ff, #e6ebff);
            border-bottom: 1px solid #e0e0e0;
        }

        .entreprise-logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border-radius: 8px;
            margin-right: 1rem;
            background: white;
            padding: 5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .entreprise-info {
            flex: 1;
        }

        .entreprise-nom {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 0.2rem;
        }

        .entreprise-secteur {
            font-size: 0.9rem;
            color: #666;
            font-weight: 500;
        }

        .card-body {
            padding: 1.5rem;
        }

        .offre-titre {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .offre-description {
            color: #555;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            line-height: 1.7;
            background-color: #f9f9f9;
            padding: 1rem;
            border-radius: 8px;
            border-left: 4px solid var(--accent);
        }

        .duree-stage {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 1rem;
            display: block;
        }

        .besoins-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--secondary);
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .besoins-list {
            list-style-type: none;
            margin-bottom: 1.5rem;
        }

        .besoins-list li {
            padding: 0.3rem 0;
            padding-left: 1.5rem;
            position: relative;
            font-size: 0.9rem;
        }

        .besoins-list li:before {
            content: "•";
            color: var(--accent);
            font-size: 1.2rem;
            position: absolute;
            left: 0;
            top: 0;
        }

        .apply-btn {
            display: inline-block;
            background: linear-gradient(135deg, var(--accent), var(--primary));
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            width: 100%;
            font-size: 1rem;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }

        .apply-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(67, 97, 238, 0.4);
            background: linear-gradient(135deg, var(--primary), var(--accent));
        }

        .filters {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            background: white;
            border: 1px solid #ddd;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }

        .filter-btn:hover, .filter-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        @media (max-width: 768px) {
            .offres-grid {
                grid-template-columns: 1fr;
            }

            h1 {
                font-size: 2rem;
            }

            .filters {
                justify-content: flex-start;
            }
        }
</style>
<x-home titre="stage-page" page_titre="stage-page" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">
<div class="welcome-section">
        <h1><i class="fas fa-briefcase"></i> Offres de Stage</h1>
        <p>Trouvez le stage parfait pour votre parcours académique</p>
    </div>



       <!-- Filtres optionnels -->
    <div class="dashboard-card" style="margin-bottom: 30px;">
        <div class="card-header">
            <h2><i class="fas fa-filter"></i> Filtres</h2>
        </div>
        <div class="filters">
            <button class="filter-btn active">Tous</button>
            <button class="filter-btn">Informatique</button>
            <button class="filter-btn">Marketing</button>
            <button class="filter-btn">Finance</button>
            <button class="filter-btn">Ingénierie</button>
        </div>
    </div>
        <div class="offres-grid">
            <!-- Offre dynamique avec toutes vos variables -->
            @foreach ($stages as $stage)
            <div class="offre-card">
                <div class="card-header">
                    <img src="{{ asset('storage/' . $stage->photo) }}" alt="Logo {{ $stage->entreprise }}" class="entreprise-logo">
                    <div class="entreprise-info">
                        <h3 class="entreprise-nom">{{ $stage->entreprise }}</h3>
                        <p class="entreprise-secteur">{{ $stage->duree }}</p>
                    </div>
                </div>
                <div class="card-body">
                    <h4 class="offre-titre">{{ $stage->nom_stage }}</h4>
                    <span class="duree-stage">Durée: {{ $stage->duree}}</span>

                    <!-- DESCRIPTION BIEN VISIBLE AVEC UNE MISE EN FORME SPÉCIFIQUE -->
                    <div class="offre-description">
                        <strong>Description du stage:</strong><br>
                        {{ $stage->description }}
                    </div>

                    <h5 class="besoins-title">Informations de contact</h5>
                    <ul class="besoins-list">
                        <li>Email: {{ $stage->email_entreprise }}</li>
                    </ul>

                    <a href="mailto:{{ $stage->email_entreprise }}" class="apply-btn">Postuler maintenant</a>
                </div>
            </div>
            @endforeach
        </div>


</x-home>
