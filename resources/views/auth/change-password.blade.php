<x-home titre="Changer mot de passe" page_titre="Modifier mot de passe" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">

    <div class="change-password-wrapper">
        <h2>Changer le mot de passe</h2>

        <!-- Affichage du message de succès -->
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Affichage des erreurs -->
        @if($errors->any())
            <div class="alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
 <form action="{{ route('password.update') }}" method="POST">
        <!-- Formulaire -->
        <form action="{{ route('password.update') }}" method="POST" class="change-password-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="current_password">Mot de passe actuel</label>
                <input type="password" name="current_password" id="current_password" required>
            </div>

            <div class="form-group">
                <label for="new_password">Nouveau mot de passe</label>
                <input type="password" name="new_password" id="new_password" required>
            </div>

            <div class="form-group">
                <label for="new_password_confirmation">Confirmer le nouveau mot de passe</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" required>
            </div>

            <button type="submit" class="btn-submit">Mettre à jour</button>
        </form>
    </div>

    <!-- Style -->
    <style>
    .change-password-wrapper {
        max-width: 500px;
        margin: 3rem auto;
        background: #ffffff;
        padding: 2.5rem;
        border-radius: 16px;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.05);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        border: 1px solid rgba(0, 0, 0, 0.03);
    }
    
    h2 {
        text-align: center;
        color: #1a365d;
        margin-bottom: 2rem;
        font-size: 1.8rem;
        font-weight: 700;
        letter-spacing: -0.5px;
        background: linear-gradient(90deg, #2b6cb0 0%, #3182ce 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .alert-success {
        background-color: #f0fff4;
        padding: 1rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid #48bb78;
        color: #2f855a;
        border-radius: 6px;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .alert-danger {
        background-color: #fff5f5;
        padding: 1rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid #f56565;
        color: #c53030;
        border-radius: 6px;
        font-size: 0.95rem;
    }
    
    .alert-danger ul {
        margin: 0.5rem 0 0 0;
        padding-left: 1.2rem;
    }
    
    .alert-danger li {
        margin: 0.25rem 0;
        position: relative;
        line-height: 1.5;
    }
    
    .alert-danger li::before {
        content: "•";
        color: #f56565;
        font-weight: bold;
        display: inline-block;
        width: 1em;
        margin-left: -1em;
    }
    
    .change-password-form {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    
    .form-group {
        display: flex;
        flex-direction: column;
        position: relative;
    }
    
    label {
        margin-bottom: 0.5rem;
        color: #4a5568;
        font-weight: 500;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }
    
    input[type="password"] {
        padding: 0.875rem 1.25rem;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background-color: #f8fafc;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.03);
    }
    
    input[type="password"]:hover {
        border-color: #cbd5e0;
    }
    
    input[type="password"]:focus {
        outline: none;
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15);
        background-color: #ffffff;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #3182ce 0%, #2b6cb0 100%);
        color: white;
        padding: 1rem;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-top: 0.5rem;
        letter-spacing: 0.25px;
        box-shadow: 0 4px 6px rgba(50, 115, 220, 0.15);
        position: relative;
        overflow: hidden;
    }
    
    .btn-submit:hover {
        background: linear-gradient(135deg, #2b6cb0 0%, #3182ce 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(50, 115, 220, 0.2);
    }
    
    .btn-submit:active {
        transform: translateY(0);
        box-shadow: 0 2px 4px rgba(50, 115, 220, 0.2);
    }
    
    .btn-submit::after {
        content: "";
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(45deg);
        pointer-events: none;
        transition: all 0.5s ease;
    }
    
    .btn-submit:hover::after {
        left: 100%;
    }
    
    @media (max-width: 576px) {
        .change-password-wrapper {
            padding: 1.75rem;
            margin: 1.5rem;
            border-radius: 12px;
        }
        
        h2 {
            font-size: 1.6rem;
            margin-bottom: 1.5rem;
        }
        
        input[type="password"] {
            padding: 0.75rem 1rem;
        }
        
        .btn-submit {
            padding: 0.875rem;
        }
    }
</style>
</x-home>
