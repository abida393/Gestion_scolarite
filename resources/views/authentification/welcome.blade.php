<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gestion Scolaire</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,aspect-ratio"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4361ee',
                        secondary: '#3f37c9',
                        accent: '#4895ef',
                        dark: '#1a1a2e',
                        light: '#f8f9fa',
                        success: '#4cc9f0',
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                    animation: {
                        float: 'float 8s infinite ease-in-out',
                        pulse: 'pulse 2s infinite ease-in-out',
                        'floating': 'floating 6s infinite ease-in-out',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        pulse: {
                            '0%, 100%': { transform: 'scale(1)' },
                            '50%': { transform: 'scale(1.05)' },
                        },
                        'floating': {
                            '0%, 100%': { transform: 'translateY(0) rotate(0deg)' },
                            '50%': { transform: 'translateY(-15px) rotate(2deg)' },
                        }
                    }
                }
            }
        }
    </script>
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
<body class="h-full font-poppins bg-white" style="background-image: url('{{ asset('images/bg1.png') }}');">

    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-3d p-8 sm:p-10 mx-auto">
            <!-- Logo section -->
            <div class="text-center mb-10">
                <div class="relative inline-block">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo"
                        class="mx-auto w-40 h-40 object-contain border-0 bg-transparent"
                        style="border-radius:0; box-shadow:none;">
                </div>
                <p class="text-gray-500 mt-4 text-sm font-medium">Connectez-vous à votre espace</p>
            </div>
            <!-- Login form -->
            <form method="POST" action="{{ route("login") }}" class="space-y-6">
                @csrf
                <div class="relative">
                    <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-primary/80"></i>
                    <input id="email" type="email" name="email" placeholder="Email"
                        class="w-full pl-12 pr-4 py-4 border border-gray-200/80 rounded-xl bg-white focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none shadow-sm transition-all duration-300 hover:shadow-md">
                    @error('email')
                        <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="relative">
                    <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-primary/80"></i>
                    <input id="password" type="password" name="password" placeholder="Mot de passe"
                        class="w-full pl-12 pr-10 py-4 border border-gray-200/80 rounded-xl bg-white focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none shadow-sm transition-all duration-300 hover:shadow-md">
                    <button type="button" id="togglePassword" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-primary/80 focus:outline-none">
                        <i class="fas fa-eye"></i>
                    </button>
                    @error('password')
                        <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-center justify-between">
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-medium text-primary hover:text-primary/80">Mot de passe oublié?</a>
                    </div>
                </div>
                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-primary hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-sign-in-alt"></i>
                        </span>
                        Se Connecter
                    </button>
                </div>
            </form>
            <div class="text-center text-gray-500 text-xs mt-8">
                &copy; {{ date('Y') }} UOR - Tous droits réservés
            </div>
        </div>
    </div>

    <script>
        // Password eye toggle
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');
        togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            togglePassword.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });
    </script>
</body>
</html>