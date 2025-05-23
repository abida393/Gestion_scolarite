<x-admin titre="Profil Responsable" page_titre="Profil Responsable" :nom_complete="Auth::guard('responsable')->user()->respo_nom . ', ' . Auth::guard('responsable')->user()->respo_prenom">
    @php
        $responsable = Auth::guard('responsable')->user();
        $formation = $responsable->formation ?? null;
        $profile = $responsable->profile ?? null;
    @endphp

    <div class="profile-wrapper">
        <div class="profile-card animated-fade">
            <div class="profile-header">
                <div class="profile-image hover-scale shadow-lg ring-4 ring-blue-200">
                    @if ($responsable->profile_picture)
                        <img src="{{ asset('storage/' . $responsable->profile_picture) }}" alt="Photo de profil">
                    @else
                        @php
                            $firstInitial = strtoupper(substr($responsable->respo_prenom, 0, 1));
                            $lastInitial = strtoupper(substr($responsable->respo_nom, 0, 1));
                        @endphp
                        <div class="profile-initials">{{ $lastInitial }}{{ $firstInitial }}</div>
                    @endif
                </div>
                <h2 class="profile-name gradient-text">{{ $responsable->respo_prenom }} {{ $responsable->respo_nom }}</h2>
                <p class="profile-email"><i class="fas fa-envelope mr-2 text-blue-400"></i>{{ $responsable->email_ecole }}</p>
            </div>

            <div class="profile-body three-columns">
                <div class="info-item"><span class="label"><i class="fas fa-id-card mr-1"></i>CIN :</span><span class="value">{{ $responsable->respo_cin }}</span></div>
                <div class="info-item"><span class="label"><i class="fas fa-venus-mars mr-1"></i>Sexe :</span><span class="value">{{ $responsable->respo_sex }}</span></div>
                <div class="info-item"><span class="label"><i class="fas fa-flag mr-1"></i>Nationalité :</span><span class="value">{{ $responsable->respo_nationalite }}</span></div>
                <div class="info-item"><span class="label"><i class="fas fa-birthday-cake mr-1"></i>Date de naissance :</span><span class="value">{{ $responsable->respo_date_naissance }}</span></div>
                <div class="info-item"><span class="label"><i class="fas fa-map-marker-alt mr-1"></i>Lieu de naissance :</span><span class="value">{{ $responsable->respo_lieu_naissance }}</span></div>
                <div class="info-item"><span class="label"><i class="fas fa-phone mr-1"></i>Téléphone :</span><span class="value">{{ $responsable->respo_tel }}</span></div>
                <div class="info-item"><span class="label"><i class="fas fa-home mr-1"></i>Adresse :</span><span class="value">{{ $responsable->respo_adresse }}</span></div>
                <div class="info-item"><span class="label"><i class="fas fa-at mr-1"></i>Email personnel :</span><span class="value">{{ $responsable->respo_email }}</span></div>
                <div class="info-item"><span class="label"><i class="fas fa-graduation-cap mr-1"></i>Diplômes :</span><span class="value">{{ $responsable->respo_diplomes }}</span></div>
                <div class="info-item"><span class="label"><i class="fas fa-file-contract mr-1"></i>Contrat :</span><span class="value">{{ $responsable->respo_contrat }}</span></div>
                <div class="info-item"><span class="label"><i class="fas fa-calendar-check mr-1"></i>Date d'embauche :</span><span class="value">{{ $responsable->respo_date_embauche }}</span></div>
                <div class="info-item"><span class="label"><i class="fas fa-money-check-alt mr-1"></i>Type de paiement :</span><span class="value">{{ $responsable->respo_type_paiement }}</span></div>
                <div class="info-item"><span class="label"><i class="fas fa-university mr-1"></i>Banque :</span><span class="value">{{ $responsable->respo_banque }}</span></div>
                <div class="info-item"><span class="label"><i class="fas fa-barcode mr-1"></i>RIB :</span><span class="value">{{ $responsable->respo_rib }}</span></div>
                <div class="info-item"><span class="label"><i class="fas fa-coins mr-1"></i>Salaire :</span><span class="value">{{ $responsable->respo_salaire }} DH</span></div>
                <div class="info-item"><span class="label"><i class="fas fa-book mr-1"></i>Formation :</span><span class="value">{{ $formation->nom_formation ?? '' }}</span></div>
            </div>

            <div class="profile-footer">
                <a href="#" onclick="openPasswordModal(); return false;" class="btn-password shadow-lg"><i class="fas fa-key mr-2"></i>Changer le mot de passe</a>
            </div>
        </div>
    </div>

    <!-- Modal Changement de mot de passe -->
    <div id="passwordModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-md relative animate-fade-in-down border-t-8 border-blue-500">
            <button onclick="closePasswordModal()" class="absolute top-3 right-3 text-gray-500 hover:text-red-500 text-xl">&times;</button>
            <h2 class="text-xl font-bold mb-4 text-blue-700 text-center">Changer le mot de passe</h2>
            @if ($errors->any())
                <div class="mb-4 text-red-600 text-sm">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <form method="POST" action="{{ route('password.responsable.update') }}">
                @csrf
                <div class="mb-4 relative">
                    <label class="block mb-1 font-bold text-gray-700">Ancien mot de passe</label>
                    <input type="password" id="oldPassword" name="old_password" class="w-full border-2 border-blue-200 rounded px-3 py-2 focus:ring-2 focus:ring-blue-400 pr-10" required>
                    <span class="absolute right-3 top-9 cursor-pointer text-gray-500" onclick="togglePassword('oldPassword', this)">
                        <i class="fa fa-eye" id="eye-oldPassword"></i>
                    </span>
                </div>
                <div class="mb-4 relative">
                    <label class="block mb-1 font-bold text-gray-700">Nouveau mot de passe</label>
                    <input type="password" id="newPassword" name="password" class="w-full border-2 border-blue-200 rounded px-3 py-2 focus:ring-2 focus:ring-blue-400 pr-10" required>
                    <span class="absolute right-3 top-9 cursor-pointer text-gray-500" onclick="togglePassword('newPassword', this)">
                        <i class="fa fa-eye" id="eye-newPassword"></i>
                    </span>
                </div>
                <div class="mb-6 relative">
                    <label class="block mb-1 font-bold text-gray-700">Confirmer le mot de passe</label>
                    <input type="password" id="confirmPassword" name="password_confirmation" class="w-full border-2 border-blue-200 rounded px-3 py-2 focus:ring-2 focus:ring-blue-400 pr-10" required>
                    <span class="absolute right-3 top-9 cursor-pointer text-gray-500" onclick="togglePassword('confirmPassword', this)">
                        <i class="fa fa-eye" id="eye-confirmPassword"></i>
                    </span>
                </div>
                <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-2 rounded-lg hover:from-blue-700 hover:to-indigo-700 w-full font-bold shadow">Valider</button>
            </form>
        </div>
    </div>

    <style>
        .profile-wrapper { max-width: 950px; margin: 40px auto; padding: 20px;}
        .profile-card { background: linear-gradient(135deg, #f8fafc 60%, #e0e7ff 100%); padding: 35px; border-radius: 24px; box-shadow: 0 10px 30px rgba(67,97,238,0.10); text-align: center;}
        .animated-fade { animation: fadeInUp 0.8s ease-in-out;}
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px);} to { opacity: 1; transform: translateY(0);}
        }
        .profile-header { display: flex; flex-direction: column; align-items: center; margin-bottom: 30px;}
        .profile-image { width: 150px; height: 150px; border-radius: 50%; overflow: hidden; border: 4px solid #3b82f6; display: flex; align-items: center; justify-content: center; margin-bottom: 15px; background: #e0e7ff;}
        .hover-scale:hover { transform: scale(1.05);}
        .profile-image img { width: 100%; height: 100%; object-fit: cover;}
        .profile-initials { width: 100%; height: 100%; font-size: 48px; font-weight: bold; color: #fff; background: linear-gradient(135deg, #3b82f6, #6366f1); display: flex; align-items: center; justify-content: center;}
        .profile-name { font-size: 26px; font-weight: 700; margin-top: 5px; margin-bottom: 2px;}
        .gradient-text { background: linear-gradient(90deg, #3b82f6, #6366f1); -webkit-background-clip: text; -webkit-text-fill-color: transparent;}
        .profile-email { font-size: 15px; color: #3b82f6; margin-bottom: 10px;}
        .profile-body { margin-top: 25px; text-align: left;}
        .three-columns {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 24px 32px;
        }
        .info-item { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(67,97,238,0.06); padding: 18px 14px; margin-bottom: 0; display: flex; flex-direction: column; align-items: flex-start;}
        .label { font-weight: bold; color: #3b82f6; font-size: 15px; margin-bottom: 4px;}
        .value { color: #343a40; font-size: 15px;}
        .profile-footer {
            margin-top: 40px;
            text-align: center;
        }
        .btn-password {
            background: linear-gradient(135deg, #4361ee, #364fc7);
            color: white;
            padding: 14px 32px;
            border-radius: 12px;
            font-weight: bold;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.18);
            transition: background 0.3s, transform 0.2s;
            display: inline-block;
            font-size: 16px;
            letter-spacing: 1px;
        }
        .btn-password:hover {
            background: linear-gradient(135deg, #364fc7, #2e3fae);
            transform: scale(1.04);
        }
        @media (max-width: 1100px) {
            .three-columns { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 700px) {
            .three-columns { grid-template-columns: 1fr; }
            .profile-card { padding: 18px;}
        }
        /* Modal animation */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px);}
            to { opacity: 1; transform: translateY(0);}
        }
        .animate-fade-in-down {
            animation: fadeInDown 0.4s ease;
        }
    </style>
    <script>
        function openPasswordModal() {
            document.getElementById('passwordModal').classList.remove('hidden');
        }
        function closePasswordModal() {
            document.getElementById('passwordModal').classList.add('hidden');
        }
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
        window.onload = function() {
            @if ($errors->any())
                openPasswordModal();
            @endif
        }
    </script>
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
</x-admin>
