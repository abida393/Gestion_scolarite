
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récupération de mot de passe - Gestion Scolaire</title>
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
                <p class="text-gray-500 mt-2 text-sm font-medium">Entrez votre email pour réinitialiser votre mot de passe</p>
            </div>

            <!-- Password reset form -->
            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf
                @error("email")
                <div class="text-red-500 text-sm mt-2">
                    {{ $message }}
                </div>
                @enderror
                <div class="relative">
                    <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-primary/80"></i>
                    <input id="email" type="email" name="email" placeholder="Adresse Email" required autofocus
                        class="w-full pl-12 pr-4 py-4 border border-gray-200/80 rounded-xl bg-white focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none shadow-sm transition-all duration-300 hover:shadow-md">
                </div>
                <div class="pt-2">
                    <button type="submit"
                        class="w-full py-4 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-primary hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary/50 shadow-lg hover:shadow-xl active:scale-95 transition-all duration-300 transform hover:-translate-y-1">
                        <span class="relative z-10 flex items-center justify-center">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Envoyer le lien
                        </span>
                    </button>
                </div>
            </form>

            <!-- Back to login link -->
            <div class="text-center mt-6">
                <a href="{{ route('home.welcome') }}" class="text-sm font-medium text-primary hover:text-primary/70 transition-colors inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à la page de connexion
                </a>
            </div>

            <!-- Footer -->
            <div class="text-center text-gray-400 text-xs mt-10">
                &copy; {{ date('Y') }} UOR - Tous droits réservés
            </div>
        </div>
    </div>
</body>
</html>