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
    </style>
</head>
<body class="min-h-screen font-poppins bg-white bg-combined">
    <div class="absolute inset-0 overflow-hidden">
    <body class="min-h-screen font-poppins bg-white bg-cover" style="background-image: url('{{ asset('images/tech.jpg') }}'); background-size: cover; background-position: center;">
        <!-- Floating decorative elements -->
        <div class="absolute top-1/4 left-1/4 w-16 h-16 rounded-full bg-primary/10 blur-xl animate-floating"></div>
        <div class="absolute top-1/3 right-1/4 w-24 h-24 rounded-full bg-accent/10 blur-xl animate-floating animation-delay-2000"></div>
        <div class="absolute bottom-1/4 right-1/3 w-20 h-20 rounded-full bg-success/10 blur-xl animate-floating animation-delay-4000"></div>
    </div>

    <div class="relative min-h-screen flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8 card-3d">
        <div class="w-full max-w-md bg-white/65 backdrop-blur-sm rounded-2xl shadow-3d transform transition-all duration-500 hover:rotate-y-3 hover:rotate-x-2 group p-8 sm:p-10 inner-3d shadow-lg">
            <!-- Logo section with enhanced 3D -->
            <div class="text-center mb-10 transform transition-all duration-300 group-hover:-translate-y-1">
                <div class="relative inline-block animate-pulse">
                    <i class="fas fa-key text-6xl text-gradient-primary"></i>
                    <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-accent/20 rounded-full blur-md -z-10"></div>
                </div>
                <h1 class="text-4xl font-bold text-gradient-primary mt-4">Gestion Scolaire</h1>
                <p class="text-gray-500 mt-2 text-sm font-medium">Entrez votre email pour réinitialiser votre mot de passe</p>
            </div>

            <!-- Password reset form with 3D inputs -->
            <form method="POST" action="{{ route("password.email") }}" class="space-y-6">
                @csrf
                  <!-- Identifiant input with floating effect -->
                @error("email")
                <div class="text-red-500 text-sm mt-2">
                    {{ $message }}
                </div>
                @enderror
    <div class="relative transform transition-all duration-300 hover:-translate-y-1">
        <div class="absolute inset-0 bg-gradient-to-r from-primary/10 to-accent/10 rounded-xl blur-sm -z-10"></div>
        <i class="fas fa-user absolute left-4 top-1/2 transform -translate-y-1/2 text-primary/80"></i>
        <input id="identifiant" type="text" name="identifiant" placeholder="Identifiant" required
            class="w-full pl-12 pr-4 py-4 border border-gray-200/80 rounded-xl bg-white/90 focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none shadow-sm transition-all duration-300 hover:shadow-md">
    </div>

                <!-- Email input with floating effect -->
                <div class="relative transform transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-r from-primary/10 to-accent/10 rounded-xl blur-sm -z-10"></div>
                    <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-primary/80"></i>
                    <input id="email" type="email" name="email" placeholder="Adresse Email" required autofocus
                        class="w-full pl-12 pr-4 py-4 border border-gray-200/80 rounded-xl bg-white/90 focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none shadow-sm transition-all duration-300 hover:shadow-md">
                </div>

                <!-- Submit button with 3D press effect -->
                <div class="pt-2">
        <button type="submit"
            class="w-full py-4 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-to-r from-primary to-accent hover:from-primary/90 hover:to-accent/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary/50 shadow-lg hover:shadow-xl active:scale-95 transition-all duration-300 transform hover:-translate-y-0.5">
            <span class="relative z-10 flex items-center justify-center">
                <i class="fas fa-paper-plane mr-2"></i>
                Envoyer le lien
            </span>
            <span class="absolute inset-0 bg-gradient-to-r from-primary/80 to-accent/80 rounded-xl blur-md opacity-70 -z-10"></span>
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

            <!-- Footer with subtle animation -->
            <div class="text-center text-gray-400 text-xs mt-10 animate-float">
                &copy; {{ date('Y') }} Système de Gestion Scolaire - Tous droits réservés
            </div>
        </div>
    </div>

    <script>
        // 3D effect on mouse move
        const loginContainer = document.querySelector('.group');
        loginContainer.addEventListener('mousemove', (e) => {
            const xAxis = (window.innerWidth / 2 - e.pageX) / 25;
            const yAxis = (window.innerHeight / 2 - e.pageY) / 25;
            loginContainer.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
        });

        // Reset when mouse leaves
        loginContainer.addEventListener('mouseleave', () => {
            loginContainer.style.transform = 'rotateY(0) rotateX(0)';
        });
    </script>
</body>
</html>
