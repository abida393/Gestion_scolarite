<x-home titre="Page news" page_titre="Page news" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualités</title>
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --accent: #4895ef;
            --light: #f8f9fa;
            --dark: #212529;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7ff;
            margin: 0;
            padding: 40px 20px;
        }

        .agenda-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .page-title {
            color: var(--primary);
            text-align: center;
            margin-bottom: 40px;
            font-size: 2.2rem;
        }

        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
        }

        .event-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(67, 97, 238, 0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(67, 97, 238, 0.15);
        }

        .event-card:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(to bottom, var(--primary), var(--accent));
        }

        .event-title {
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(67, 97, 238, 0.1);
        }

        .event-details {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .detail-item {
            display: flex;
            align-items: center;
        }

        .detail-icon {
            width: 36px;
            height: 36px;
            background: rgba(67, 97, 238, 0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            color: var(--primary);
        }

        .detail-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .detail-value {
            font-size: 1rem;
            font-weight: 500;
            color: var(--dark);
        }

        .event-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--accent);
            color: white;
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .event-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        @media (max-width: 600px) {
            .events-grid {
                grid-template-columns: 1fr;
            }

            .event-card {
                padding: 25px;
            }
        }
    </style>
</head>
<body>

<div class="agenda-container">
    <h1 class="page-title">Actualités</h1>

    <div class="events-grid">
        @foreach($news as $item)
        <div class="event-card">
            <span class="event-badge">News</span>

            @if($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" alt="Image News" class="event-image">
            @endif

            <h2 class="event-title">{{ $item->title }}</h2>

            <div class="event-details">
                <div class="detail-item">
                    <div class="detail-icon">
                        <i class="far fa-calendar-alt"></i>
                    </div>
                    <div>
                        <div class="detail-label">Date</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($item->date_news)->format('d/m/Y') }}</div>
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-icon">
                        <i class="far fa-newspaper"></i>
                    </div>
                    <div>
                        <div class="detail-label">Contenu</div>
                        <div class="detail-value">{{ Str::limit($item->content, 100) }}</div>
                    </div>
                </div>
            </div>

        </div>
        @endforeach

        @if($news->isEmpty())
            <p>Aucune actualité disponible pour le moment.</p>
        @endif
    </div>
</div>

</body>
</html>
<x-chat-button></x-chat-button>
</x-home>
