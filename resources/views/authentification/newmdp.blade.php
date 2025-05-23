<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe - Gestion Scolaire</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style type="text/tailwindcss">
        @layer utilities {
            .bg-gradient-primary {
                background: linear-gradient(to right, #4361ee, #4895ef);
            }
            .text-gradient-primary {
                background: linear-gradient(to right, #4361ee, #4cc9f0);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            .backdrop-blur-6 {
                backdrop-filter: blur(6px);
            }
            .shadow-3d {
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1), 0 5px 15px rgba(0, 0, 0, 0.05);
            }
            .rotate-3d {
                transform: rotateY(0) rotateX(0);
                transition: transform 0.5s ease-out;
            }
            .rotate-3d:hover {
                transform: rotateY(10deg) rotateX(10deg);
            }
            .floating {
                animation: floating 6s infinite ease-in-out;
            }
            @keyframes floating {
                0%, 100% { transform: translateY(0) rotate(0deg); }
                50% { transform: translateY(-15px) rotate(2deg); }
            }
        }
        html {
            height: 100%;
            overflow: hidden;
        }
        body {
            height: 100vh;
            margin: 0;
            padding: 0;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            overflow: auto;
        }
    </style>
</head>
<body class="h-full font-poppins bg-white" style="background-image: url('{{ asset('images/tech.jpg') }}');">

    <!-- Floating decorative elements -->
    <div class="absolute top-1/4 left-1/4 w-16 h-16 rounded-full bg-primary/10 blur-xl floating"></div>
    <div class="absolute top-1/3 right-1/4 w-24 h-24 rounded-full bg-accent/10 blur-xl floating" style="animation-delay: 2s"></div>
    <div class="absolute bottom-1/4 right-1/3 w-20 h-20 rounded-full bg-success/10 blur-xl floating" style="animation-delay: 4s"></div>

    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white/65 backdrop-blur-sm rounded-2xl shadow-3d transform transition-all duration-500 hover:rotate-y-3 hover:rotate-x-2 group p-8 sm:p-10 shadow-lg mx-auto">
            <!-- Logo section -->
            <div class="text-center mb-10 transform transition-all duration-300 group-hover:-translate-y-1">
                <div class="relative inline-block animate-pulse">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo"
                        class="mx-auto w-40 h-40 object-contain border-0 bg-transparent"
                        style="border-radius:0; box-shadow:none; filter: blur(0.5px);">
                </div>
                <p class="text-gray-500 mt-2 text-sm font-medium">Réinitialiser votre mot de passe</p>
            </div>

            <!-- Error/Success Messages -->
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4">
                    <div class="font-medium text-red-600">
                        {{ __('Whoops! Something went wrong.') }}
                    </div>
                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Reset password form -->
            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email Field (hidden if email is pre-filled) -->
                @if(empty($email))
                <div class="relative transform transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-r from-primary/10 to-accent/10 rounded-xl blur-sm -z-10"></div>
                    <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-gradient-primary"></i>
                    <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required
                        class="w-full pl-12 pr-4 py-4 border border-gray-200/80 rounded-xl bg-white/90 focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none shadow-sm transition-all duration-300 hover:shadow-md"
                        placeholder="Votre email">
                </div>
                @else
                <input type="hidden" name="email" value="{{ $email }}">
                @endif

                <!-- New password input -->
                <div class="relative transform transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-r from-primary/10 to-accent/10 rounded-xl blur-sm -z-10"></div>
                    <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gradient-primary"></i>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="w-full pl-12 pr-10 py-4 border border-gray-200/80 rounded-xl bg-white/90 focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none shadow-sm transition-all duration-300 hover:shadow-md"
                        placeholder="Nouveau mot de passe">
                    <button type="button" onclick="togglePassword('password')" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-primary/80">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>

                <!-- Confirm password input -->
                <div class="relative transform transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-r from-primary/10 to-accent/10 rounded-xl blur-sm -z-10"></div>
                    <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gradient-primary"></i>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="w-full pl-12 pr-10 py-4 border border-gray-200/80 rounded-xl bg-white/90 focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none shadow-sm transition-all duration-300 hover:shadow-md"
                        placeholder="Confirmer le mot de passe">
                    <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-primary/80">
                        <i class="fas fa-eye"></i>
                    </button>
                    <p id="password-error" class="text-red-500 text-sm mt-2 hidden">Les mots de passe ne correspondent pas.</p>
                </div>

                <!-- Reset button -->
                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-primary hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-check-circle"></i>
                        </span>
                        Réinitialiser le mot de passe
                    </button>
                </div>
            </form>

            <!-- Footer -->
            <div class="text-center text-gray-500 text-xs mt-8">
                &copy; {{ date('Y') }} UOR - Tous droits réservés
            </div>
        </div>
    </div>

    <script>
        // 3D effect on mouse move
        const resetContainer = document.querySelector('.group');
        if (resetContainer) {
            resetContainer.addEventListener('mousemove', (e) => {
                const xAxis = (window.innerWidth / 2 - e.pageX) / 25;
                const yAxis = (window.innerHeight / 2 - e.pageY) / 25;
                resetContainer.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
            });

            resetContainer.addEventListener('mouseleave', () => {
                resetContainer.style.transform = 'rotateY(0) rotateX(0)';
            });
        }

        // Password toggle functionality
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling.querySelector('i');
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // Password confirmation validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            const errorElement = document.getElementById('password-error');

            if (password !== passwordConfirmation) {
                e.preventDefault();
                errorElement.classList.remove('hidden');
                // Scroll to error
                errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                errorElement.classList.add('hidden');
            }
        });

        // Real-time password matching check
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const passwordConfirmation = this.value;
            const errorElement = document.getElementById('password-error');

            if (passwordConfirmation.length > 0 && password !== passwordConfirmation) {
                errorElement.classList.remove('hidden');
            } else {
                errorElement.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
