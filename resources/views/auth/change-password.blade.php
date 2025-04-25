<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Changer le mot de passe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-color: #f9f9f9;
        }
        .container {
            background: white;
            max-width: 500px;
            margin: auto;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        button {
            margin-top: 20px;
            padding: 10px;
            width: 100%;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .success {
            color: green;
            margin-bottom: 10px;
        }
        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Changer le mot de passe</h2>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf

            <label for="current_password">Mot de passe actuel</label>
            <input type="password" name="current_password" required>
            @error('current_password')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="new_password">Nouveau mot de passe</label>
            <input type="password" name="new_password" required>
            @error('new_password')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="new_password_confirmation">Confirmer le mot de passe</label>
            <input type="password" name="new_password_confirmation" required>

            <button type="submit">Changer</button>
        </form>
    </div>
</body>
</html>
