<x-home titre="Changer mot de passe" page_titre="Modifier mot de passe" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">

    <div class="change-password-wrapper">
        <h2>Changer le mot de passe</h2>

        <!-- Affichage du message de succès -->
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Affichage des erreurs -->
        @if ($errors->any())
            <div class="alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
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
</x-home>
