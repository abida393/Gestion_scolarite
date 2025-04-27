<x-home titre="Page news" page_titre="Page news">

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Actualités</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .news-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .news-card {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 350px;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s;
        }
        .news-card:hover {
            transform: translateY(-5px);
        }
        .news-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .news-content {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .news-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #222;
        }
        .news-date {
            font-size: 14px;
            color: #888;
            margin-bottom: 10px;
        }
        .news-text {
            font-size: 15px;
            color: #555;
            flex-grow: 1;
        }
        .read-more {
            margin-top: 15px;
            text-align: right;
        }
        .read-more a {
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }
        @media (max-width: 768px) {
            .news-card {
                max-width: 90%;
            }
        }
        @media (max-width: 480px) {
            .news-card img {
                height: 150px;
            }
        }
    </style>
</head>
<body>

    <h1>Actualités</h1>

    <div class="news-container">
        @foreach($news as $item) 
            <div class="news-card">
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                <div class="news-content">
                    <div class="news-title">{{ $item->title }}</div>
                    <div class="news-date">{{ \Carbon\Carbon::parse($item->date_news)->format('d/m/Y') }}</div>
                    <div class="news-text">{{ \Illuminate\Support\Str::limit($item->content, 100) }}</div>
                    <div class="read-more">
                        <a href="#">Lire plus</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</body>
</html>

</x-home>