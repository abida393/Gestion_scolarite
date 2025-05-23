<x-home titre="Changer mot de passe" page_titre="Modifier mot de passe" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">

    <div class="flex justify-center items-center min-h-screen bg-gray-100 overflow-hidden">
        <div class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-md relative animate-fade-in-down border-t-8 border-blue-500">
            <!-- Bouton retour -->
            <a href="javascript:history.back()" class="absolute top-3 left-3 text-gray-500 hover:text-blue-600 text-xl" title="Retour">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="text-xl font-bold mb-4 text-blue-700 text-center">Changer le mot de passe</h2>

            <!-- Affichage du message de succès et redirection automatique -->
            @if (session('success'))
                <div class="mb-4 text-green-600 text-sm text-center">
                    {{ session('success') }}
                </div>
                <script>
                    setTimeout(function() {
                        window.location.href = "{{ route('profile') }}";
                    }, 2000);
                </script>
            @endif

            <!-- Affichage des erreurs -->
            @if ($errors->any())
                <div class="mb-4 text-red-600 text-sm">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Formulaire -->
            <form action="{{ route('password.change') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="mb-4 relative">
                    <label for="current_password" class="block mb-1 font-bold text-gray-700">Mot de passe actuel</label>
                    <input type="password" name="current_password" id="current_password" class="w-full border-2 border-blue-200 rounded px-3 py-2 focus:ring-2 focus:ring-blue-400 pr-10" required>
                    <span class="absolute right-3 top-9 cursor-pointer text-gray-500" onclick="togglePassword('current_password', this)">
                        <i class="fa fa-eye" id="eye-current_password"></i>
                    </span>
                </div>
                <div class="mb-4 relative">
                    <label for="new_password" class="block mb-1 font-bold text-gray-700">Nouveau mot de passe</label>
                    <input type="password" name="new_password" id="new_password" class="w-full border-2 border-blue-200 rounded px-3 py-2 focus:ring-2 focus:ring-blue-400 pr-10" required>
                    <span class="absolute right-3 top-9 cursor-pointer text-gray-500" onclick="togglePassword('new_password', this)">
                        <i class="fa fa-eye" id="eye-new_password"></i>
                    </span>
                </div>
                <div class="mb-6 relative">
                    <label for="new_password_confirmation" class="block mb-1 font-bold text-gray-700">Confirmer le mot de passe</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="w-full border-2 border-blue-200 rounded px-3 py-2 focus:ring-2 focus:ring-blue-400 pr-10" required>
                    <span class="absolute right-3 top-9 cursor-pointer text-gray-500" onclick="togglePassword('new_password_confirmation', this)">
                        <i class="fa fa-eye" id="eye-new_password_confirmation"></i>
                    </span>
                </div>
                <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-2 rounded-lg hover:from-blue-700 hover:to-indigo-700 w-full font-bold shadow">Valider</button>
            </form>
        </div>
    </div>

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        body {
            min-height: 100vh;
            background: #f3f4f6;
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px);}
            to { opacity: 1; transform: translateY(0);}
        }
        .animate-fade-in-down {
            animation: fadeInDown 0.4s ease;
        }
    </style>
    <script>
        function togglePassword(inputId, el) {
            const input = document.getElementById(inputId);
            const icon = el.querySelector('i');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
</x-home>