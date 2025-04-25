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
    </style>
</head>
<body class="min-h-screen font-poppins bg-white bg-combined">
    <div class="absolute inset-0 overflow-hidden">
    <body class="min-h-screen font-poppins bg-white bg-cover" style="background-image: url('{{ asset('images/tech.jpg') }}'); background-size: cover; background-position: center;">

    <!-- Floating decorative elements -->
    <div class="absolute top-1/4 left-1/4 w-16 h-16 rounded-full bg-primary/10 blur-xl animate-floating"></div>
    <div class="absolute top-1/3 right-1/4 w-24 h-24 rounded-full bg-accent/10 blur-xl animate-floating animation-delay-2000"></div>
    <div class="absolute bottom-1/4 right-1/3 w-20 h-20 rounded-full bg-success/10 blur-xl animate-floating animation-delay-4000"></div>

    <div class="relative min-h-screen flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8 card-3d">
        <div class="w-full max-w-md bg-white/65 backdrop-blur-sm rounded-2xl shadow-3d transform transition-all duration-500 hover:rotate-y-3 hover:rotate-x-2 group p-8 sm:p-10 inner-3d shadow-lg">
            <!-- Logo section with enhanced 3D -->
            <div class="text-center mb-10 transform transition-all duration-300 group-hover:-translate-y-1">
            <div class="relative inline-block animate-pulse">
                    <i class="fas fa-key text-6xl text-gradient-primary"></i>
                    <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-accent/20 rounded-full blur-md -z-10"></div>
                </div>
                <h1 class="text-4xl font-bold text-gradient-primary mt-4">Gestion Scolaire</h1>
                <p class="text-gray-500 mt-2 text-sm font-medium">Réinitialiser votre mot de passe</p>
            </div>

            <!-- Reset password form -->
            <form method="POST" action="" class="space-y-6">
                @csrf
                <!-- New password input -->
                <div class="relative transform transition-all duration-300 hover:-translate-y-1">
    <div class="absolute inset-0 bg-gradient-to-r from-primary/10 to-accent/10 rounded-xl blur-sm -z-10"></div>
    <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gradient-primary"></i>
    <input id="new-password" type="password" name="new-password" placeholder="Nouveau mot de passe" required
        class="w-full pl-12 pr-4 py-4 border border-gray-200/80 rounded-xl bg-white/90 focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none shadow-sm transition-all duration-300 hover:shadow-md">
</div>

                <!-- Confirm password input -->
                <div class="relative transform transition-all duration-300 hover:-translate-y-1">
    <div class="absolute inset-0 bg-gradient-to-r from-primary/10 to-accent/10 rounded-xl blur-sm -z-10"></div>
    <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gradient-primary"></i>
    <input id="confirm-password" type="password" name="confirm-password" placeholder="Confirmer le mot de passe" required
        class="w-full pl-12 pr-4 py-4 border border-gray-200/80 rounded-xl bg-white/90 focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none shadow-sm transition-all duration-300 hover:shadow-md">
</div>

                <!-- Reset button -->
                <div>
    <button type="submit" 
        class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-primary hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
            <i class="fas fa-check-circle text-gradient-primary"></i>
        </span>
        Réinitialiser le mot de passe
    </button>
</div>
            </form>

            <!-- Footer -->
            <div class="text-center text-gray-500 text-xs mt-8">
                &copy; {{ date('Y') }} Système de Gestion Scolaire - Tous droits réservés
            </div>
        </div>
    </div>

    <script>
        // 3D effect on mouse move
        const resetContainer = document.querySelector('.group');
        resetContainer.addEventListener('mousemove', (e) => {
            const xAxis = (window.innerWidth / 2 - e.pageX) / 25;
            const yAxis = (window.innerHeight / 2 - e.pageY) / 25;
            resetContainer.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
        });

        // Reset when mouse leaves
        resetContainer.addEventListener('mouseleave', () => {
            resetContainer.style.transform = 'rotateY(0) rotateX(0)';
        });
    </script>
</body>
</html>
