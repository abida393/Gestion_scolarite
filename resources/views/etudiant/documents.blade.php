<x-home titre="Page demandes de documents" page_titre="Page demandes de documents"
    :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ' ' . Auth::guard('etudiant')->user()->etudiant_prenom">

    <!-- Styles et polices -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>

    <!-- Contenu principal -->
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-8 px-4 sm:px-6 lg:px-8 font-['Poppins']">
        <!-- En-tête -->
        <div class="max-w-7xl mx-auto text-center mb-12 animate-fade-in">
            <div class="inline-flex items-center justify-center bg-white p-3 rounded-full shadow-lg mb-6">
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-file-alt text-blue-600 text-2xl"></i>
                </div>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-3 bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600">
                Demande de Documents Scolaires
            </h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Sélectionnez les documents dont vous avez besoin et suivez l'avancement de vos demandes
            </p>
        </div>

        <!-- Conteneur principal -->
        <div class="max-w-4xl mx-auto">
            <!-- Barre de titre et historique -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-lg mr-4">
                        <i class="fas fa-file text-blue-600 text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-semibold text-gray-800">Sélection du Document</h2>
                </div>
                
                <!-- Nouveau Combobox historique amélioré -->
                <div class="relative w-full sm:w-72">
                    <button type="button" 
                            class="w-full flex items-center justify-between gap-3 px-4 py-3 bg-white border border-gray-200 rounded-xl shadow-sm hover:border-blue-400 transition-all duration-200 text-left"
                            onclick="toggleCombobox('history')"
                            aria-haspopup="listbox"
                            aria-expanded="false"
                            id="history-combobox">
                        <div class="flex items-center">
                            <i class="fas fa-history text-blue-500 mr-3"></i>
                            <span class="truncate">Mes demandes</span>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200" id="history-chevron"></i>
                    </button>

                    <!-- Liste des options -->
                    <div class="absolute z-10 mt-2 w-full bg-white shadow-lg rounded-xl py-1 ring-1 ring-black ring-opacity-5 focus:outline-none hidden"
                         id="history-options"
                         role="listbox"
                         aria-labelledby="history-combobox">
                        @if($demandes->isEmpty())
                            <div class="px-4 py-3 text-center text-gray-500 text-sm">
                                Aucune demande trouvée
                            </div>
                        @else
                            @foreach($demandes as $demande)
                                @php
                                    $statusClass = [
                                        'demande-recue' => 'bg-yellow-100 text-yellow-800',
                                        'en-preparation' => 'bg-blue-100 text-blue-800',
                                        'document-pret' => 'bg-purple-100 text-purple-800',
                                        'termine' => 'bg-green-100 text-green-800',
                                        'refus' => 'bg-red-100 text-red-800'
                                    ][strtolower(str_replace(' ', '-', $demande->etat_demande))] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <button type="button"
                                        class="w-full text-left px-4 py-3 hover:bg-blue-50 transition-colors duration-150 flex items-center justify-between border-b border-gray-100 last:border-b-0"
                                        role="option"
                                        onclick="showRequestDetails('{{ $demande->id }}', '{{ $demande->document->nom_document }}', '{{ $demande->annee_academique }}', '{{ strtolower(str_replace(' ', '-', $demande->etat_demande)) }}', '{{ $demande->created_at }}', '{{ $demande->updated_at }}', '{{ $demande->fichier }}', '{{ $demande->justif_refus }}')">
                                    <div class="truncate pr-2">
                                        <div class="font-medium text-gray-800 truncate">{{ $demande->document->nom_document }}</div>
                                        <div class="text-sm text-gray-500 truncate">{{ $demande->annee_academique }}</div>
                                    </div>
                                    <span class="status-badge text-xs px-2.5 py-1 rounded-full {{ $statusClass }} whitespace-nowrap">
                                        {{ $demande->etat_demande }}
                                    </span>
                                </button>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Carte de formulaire -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-all duration-300 mb-8 animate-fade-in-up" id="form-container">
                <div class="relative p-8">
                    <div id="alertContainer"></div>
                    
                    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <!-- Sélection du document -->
                        <div class="space-y-2">
                            <label for="id_document" class="block text-sm font-medium text-gray-700 flex items-center">
                                <i class="fas fa-file-download mr-2 text-blue-500"></i> Documents Disponibles
                            </label>
                            <select name="id_document" id="id_document" required class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200 appearance-none bg-white bg-[url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"%3e%3cpolyline points=\"6 9 12 15 18 9\"%3e%3c/polyline%3e%3c/svg%3e')] bg-no-repeat bg-right-3">
                                <option value="" disabled selected class="text-gray-400">Sélectionnez un document</option>
                                @foreach($documents as $document)
                                    <option value="{{ $document->id }}" class="text-gray-800">{{ $document->nom_document }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Année académique -->
                        <div class="space-y-2">
                            <label for="annee_academique" class="block text-sm font-medium text-gray-700 flex items-center">
                                <i class="fas fa-calendar-alt mr-2 text-blue-500"></i> Année Académique
                            </label>
                            <select name="annee_academique" id="annee_academique" required class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200 appearance-none bg-white bg-[url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"%3e%3cpolyline points=\"6 9 12 15 18 9\"%3e%3c/polyline%3e%3c/svg%3e')] bg-no-repeat bg-right-3">
                                <option value="" disabled selected class="text-gray-400">Sélectionnez une année</option>
                                @for ($i = now()->year; $i >= 2000; $i--)
                                    <option value="{{ $i }}-{{ $i+1 }}" class="text-gray-800">{{ $i }}-{{ $i+1 }}</option>
                                @endfor
                            </select>
                        </div>
                        
                        <!-- Confirmation -->
                        <div class="flex items-start bg-blue-50 p-4 rounded-lg border border-blue-100">
                            <div class="flex items-center h-5">
                                <input id="confirmRequest" name="confirmRequest" type="checkbox" required class="focus:ring-blue-500 h-5 w-5 text-blue-600 border-gray-300 rounded">
                            </div>
                            <label for="confirmRequest" class="ml-3 block text-sm text-gray-700">
                                Je confirme ma demande de documents.
                            </label>
                        </div>
                        
                        <!-- Boutons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-4">
                            <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center transform hover:-translate-y-1">
                                <i class="fas fa-paper-plane mr-2"></i> Soumettre la demande
                            </button>
                            <button type="button" id="cancelBtn" class="flex-1 bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white font-medium py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center">
                                <i class="fas fa-times-circle mr-2"></i> Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Section détails de la demande (cachée par défaut) -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden hidden animate-fade-in-up" id="request-details-container">
                <div class="relative p-8">
                    <!-- Timeline -->
                    <div class="mb-10">
                        <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-tasks mr-3 text-blue-500"></i> État d'avancement de votre demande
                        </h3>
                        
                        <div class="relative h-2 bg-gray-200 rounded-full mb-10">
                            <div class="absolute top-0 left-0 h-full bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full transition-all duration-500" id="progress-bar"></div>
                        </div>
                        
                        <div class="grid grid-cols-4 gap-4">
                            <!-- Étape 1 -->
                            <div class="flex flex-col items-center" id="step1">
                                <div class="w-12 h-12 rounded-full border-4 border-gray-200 bg-white flex items-center justify-center mb-2 transition-all duration-300" id="step1-icon">
                                    <i class="fas fa-inbox text-gray-400"></i>
                                </div>
                                <span class="text-sm text-center text-gray-500" id="step1-label">Demande reçue</span>
                            </div>
                            
                            <!-- Étape 2 -->
                            <div class="flex flex-col items-center" id="step2">
                                <div class="w-12 h-12 rounded-full border-4 border-gray-200 bg-white flex items-center justify-center mb-2 transition-all duration-300" id="step2-icon">
                                    <i class="fas fa-cog text-gray-400"></i>
                                </div>
                                <span class="text-sm text-center text-gray-500" id="step2-label">En préparation</span>
                            </div>
                            
                            <!-- Étape 3 -->
                            <div class="flex flex-col items-center" id="step3">
                                <div class="w-12 h-12 rounded-full border-4 border-gray-200 bg-white flex items-center justify-center mb-2 transition-all duration-300" id="step3-icon">
                                    <i class="fas fa-file-alt text-gray-400"></i>
                                </div>
                                <span class="text-sm text-center text-gray-500" id="step3-label">Document prêt</span>
                            </div>
                            
                            <!-- Étape 4 -->
                            <div class="flex flex-col items-center" id="step4">
                                <div class="w-12 h-12 rounded-full border-4 border-gray-200 bg-white flex items-center justify-center mb-2 transition-all duration-300" id="step4-icon">
                                    <i class="fas fa-check-circle text-gray-400"></i>
                                </div>
                                <span class="text-sm text-center text-gray-500" id="step4-label">Terminé</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Détails de la demande -->
                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 mb-8">
                        <h4 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-info-circle mr-2 text-blue-500"></i> Détails de la demande
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <span class="block text-sm font-medium text-gray-700">Document demandé:</span>
                                <span class="block text-gray-900" id="detail-document"></span>
                            </div>
                            
                            <div class="space-y-1">
                                <span class="block text-sm font-medium text-gray-700">Année académique:</span>
                                <span class="block text-gray-900" id="detail-annee"></span>
                            </div>
                            
                            <div class="space-y-1">
                                <span class="block text-sm font-medium text-gray-700">Statut actuel:</span>
                                <span class="block text-gray-900" id="detail-status"></span>
                            </div>
                            
                            <div class="space-y-1">
                                <span class="block text-sm font-medium text-gray-700">Date de demande:</span>
                                <span class="block text-gray-900" id="detail-date-demande"></span>
                            </div>
                            
                            <div class="space-y-1">
                                <span class="block text-sm font-medium text-gray-700">Dernière mise à jour:</span>
                                <span class="block text-gray-900" id="detail-date-update"></span>
                            </div>
                        </div>

                        <!-- Section Motif de refus (visible seulement si la demande est refusée) -->
                        <div class="mt-4 hidden" id="refus-section">
                            <div class="space-y-1">
                                <span class="block text-sm font-medium text-gray-700">Motif de refus:</span>
                                <span class="block text-gray-900" id="detail-motif-refus"></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Section Téléchargement -->
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hidden" id="download-section">
                        <!-- Icône PDF -->
                        <div class="inline-flex items-center justify-center bg-blue-50 p-4 rounded-full mb-4 shadow-inner">
                            <i class="fas fa-file-pdf text-4xl text-red-500"></i>
                        </div>
                        
                        <!-- Métadonnées -->
                        <div class="space-y-3 mb-6">
                            <div>
                                <p class="font-medium text-gray-800">
                                    <span class="font-semibold text-gray-900">État :</span> 
                                    <span id="detail-status-text" class="text-blue-600"></span>
                                </p>
                                <p class="text-sm text-gray-500 mt-1" id="detail-date-text"></p>
                            </div>
                        </div>

                        <!-- Bouton de téléchargement -->
                        <a href="#" 
                           id="download-btn"
                           class="inline-flex items-center justify-center bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-600 hover:to-teal-600 text-white font-medium py-3 px-8 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 mb-6"
                           target="_blank"
                           download>
                            <i class="fas fa-download mr-3"></i>
                            <span>Télécharger</span>
                            <span id="file-name" class="ml-2 font-semibold underline decoration-white/30"></span>
                        </a>

                        <!-- QR Code -->
                        <div id="qr-code-wrapper">
                            <span class="block text-sm font-medium text-gray-700 mb-3">Telecharger votre fichier !!!</span>
                            <div id="qr-code-container" class="flex justify-center"></div>
                        </div>

                        <!-- Message d'indisponibilité -->
                        <div id="unavailable-message" class="p-4 bg-amber-50 border border-amber-100 text-amber-700 rounded-lg">
                            <div class="flex items-center justify-center space-x-2">
                                <i class="fas fa-clock text-amber-500"></i>
                                <span class="font-medium">Document non disponible</span>
                            </div>
                            <p class="text-sm mt-1 text-amber-600" id="status-message">Statut: En traitement</p>
                        </div>
                    </div>
                    
                    <!-- Bouton retour -->
                    <button onclick="showForm()" class="mt-6 bg-white border border-gray-300 text-gray-700 font-medium py-2 px-6 rounded-lg shadow-sm hover:bg-gray-50 transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-arrow-left mr-2"></i> Retour au formulaire
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Styles personnalisés -->
    <style>
        /* Animation personnalisée */
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes fade-in-up {
            from { 
                opacity: 0;
                transform: translateY(20px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in {
            animation: fade-in 0.6s ease-out forwards;
        }
        
        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out forwards;
        }
        
        /* Styles pour le combobox */
        #history-options {
            max-height: 300px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }
        
        #history-options::-webkit-scrollbar {
            width: 8px;
        }
        
        #history-options::-webkit-scrollbar-track {
            background: #f7fafc;
            border-radius: 0 0 8px 8px;
        }
        
        #history-options::-webkit-scrollbar-thumb {
            background-color: #cbd5e0;
            border-radius: 4px;
        }
        
        /* Rotation de la flèche */
        .rotate-180 {
            transform: rotate(180deg);
        }
        
        /* Styles pour la timeline */
        .completed .fa {
            color: white !important;
        }
        
        .active .fa {
            color: #3b82f6 !important;
        }
    </style>

    <!-- Scripts (conservés tels quels) -->
    <script>
        // Vos fonctions JavaScript existantes
        function showRequestDetails(id, documentName, anneeAcademique, status, dateDemande, dateUpdate, fileName, justifRefus) {
            document.getElementById('form-container').classList.add('hidden');
            document.getElementById('request-details-container').classList.remove('hidden');
            
            document.getElementById('detail-document').textContent = documentName;
            document.getElementById('detail-annee').textContent = anneeAcademique;
            document.getElementById('detail-status').textContent = formatStatus(status);
            document.getElementById('detail-date-demande').textContent = formatDate(dateDemande);
            document.getElementById('detail-date-update').textContent = formatDate(dateUpdate);
            
            const downloadSection = document.getElementById('download-section');
            downloadSection.classList.remove('hidden');
            
            const downloadBtn = document.getElementById('download-btn');
            const unavailableMsg = document.getElementById('unavailable-message');
            const statusText = document.getElementById('detail-status-text');
            const dateText = document.getElementById('detail-date-text');
            const qrWrapper = document.getElementById('qr-code-wrapper');
            
            statusText.textContent = formatStatus(status);
            dateText.textContent = `Dernière mise à jour: ${formatDate(dateUpdate)}`;
            
            // Gestion du motif de refus
            const refusSection = document.getElementById('refus-section');
            const motifRefus = document.getElementById('detail-motif-refus');
            
            if (status === 'refus') {
                refusSection.classList.remove('hidden');
                motifRefus.textContent = justifRefus || 'Aucun motif spécifié';
                downloadBtn.classList.add('hidden');
                unavailableMsg.classList.remove('hidden');
                qrWrapper.classList.add('hidden');
                document.getElementById('status-message').textContent = `Statut: ${formatStatus(status)}`;
                unavailableMsg.classList.remove('bg-amber-50', 'border-amber-100', 'text-amber-700');
                unavailableMsg.classList.add('bg-red-50', 'border-red-100', 'text-red-700');
            } 
            else if (status === 'termine' && fileName) {
                refusSection.classList.add('hidden');
                downloadBtn.classList.remove('hidden');
                unavailableMsg.classList.add('hidden');
                qrWrapper.classList.remove('hidden');
                
                downloadBtn.href = `/storage/documents/${fileName}`;
                downloadBtn.setAttribute('download', fileName);
                document.getElementById('file-name').textContent = fileName;
                
                // Générer le QR code
                const qrContainer = document.getElementById('qr-code-container');
                qrContainer.innerHTML = '';
                const fileUrl = `${window.location.origin}/storage/documents/${fileName}`;
                
                // QRCode.toCanvas(qrContainer, fileUrl, { width: 150 }, function (error) {
                //     if (error) console.error(error);
                // });
            } else {
                refusSection.classList.add('hidden');
                downloadBtn.classList.add('hidden');
                unavailableMsg.classList.remove('hidden');
                qrWrapper.classList.add('hidden');
                document.getElementById('status-message').textContent = `Statut: ${formatStatus(status)}`;
                unavailableMsg.classList.remove('bg-red-50', 'border-red-100', 'text-red-700');
                unavailableMsg.classList.add('bg-amber-50', 'border-amber-100', 'text-amber-700');
            }
            
            updateTimeline(status);
        }

        function toggleCombobox(id) {
            const options = document.getElementById(`${id}-options`);
            const chevron = document.getElementById(`${id}-chevron`);
            
            options.classList.toggle('hidden');
            chevron.classList.toggle('rotate-180');
            
            // Fermer les autres combobox ouverts
            document.querySelectorAll('.combobox-options').forEach(box => {
                if (box.id !== `${id}-options` && !box.classList.contains('hidden')) {
                    box.classList.add('hidden');
                    const otherChevron = document.getElementById(box.id.replace('-options', '-chevron'));
                    if (otherChevron) otherChevron.classList.remove('rotate-180');
                }
            });
        }
        
        function formatStatus(status) {
            const statusMap = {
                'demande-recue': 'Demande reçue',
                'en-preparation': 'En préparation',
                'document-pret': 'Document prêt',
                'termine': 'Terminé',
                'refus': 'Refusé'
            };
            
            return statusMap[status] || status.charAt(0).toUpperCase() + status.slice(1).replace('-', ' ');
        }
        
        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            
            const date = new Date(dateString);
            return date.toLocaleDateString('fr-FR', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
        
        function updateTimeline(status) {
    // Réinitialiser toutes les étapes
    for (let i = 1; i <= 4; i++) {
        const icon = document.getElementById(`step${i}-icon`);
        const label = document.getElementById(`step${i}-label`);
        
        // Réinitialiser les classes
        icon.className = 'w-12 h-12 rounded-full border-4 border-gray-200 bg-white flex items-center justify-center mb-2 transition-all duration-300';
        label.className = 'text-sm text-center text-gray-500';
        
        // Réinitialiser le contenu de l'icône (important pour l'étape 4 qui pourrait avoir un X)
        if (i === 4) {
            icon.innerHTML = '<i class="fas fa-check-circle text-gray-400"></i>';
            label.textContent = 'Terminé';
        } else if (i === 1) {
            icon.innerHTML = '<i class="fas fa-inbox text-gray-400"></i>';
            label.textContent = 'Demande reçue';
        } else if (i === 2) {
            icon.innerHTML = '<i class="fas fa-cog text-gray-400"></i>';
            label.textContent = 'En préparation';
        } else if (i === 3) {
            icon.innerHTML = '<i class="fas fa-file-alt text-gray-400"></i>';
            label.textContent = 'Document prêt';
        }
    }

    let currentStep = 1;
    let progressWidth = '0%';
    let isRefused = status === 'refus';
    
    if (isRefused) {
        // Configuration pour le cas refusé
        document.getElementById('progress-bar').style.width = '100%';
        document.getElementById('progress-bar').style.background = 'linear-gradient(to right, #ef4444, #dc2626)';
        
        // Étapes 1 à 3 en rouge
        for (let i = 1; i <= 3; i++) {
            const icon = document.getElementById(`step${i}-icon`);
            const label = document.getElementById(`step${i}-label`);
            
            icon.classList.add('border-red-500', 'bg-red-500');
            icon.querySelector('i').classList.add('text-white');
            label.classList.add('text-red-600', 'font-medium');
        }
        
        // Configuration spéciale pour l'étape 4 (refus)
        const lastStepIcon = document.getElementById('step4-icon');
        const lastStepLabel = document.getElementById('step4-label');
        
        lastStepIcon.innerHTML = '<i class="fas fa-times text-white"></i>';
        lastStepIcon.classList.add('border-red-500', 'bg-red-500');
        lastStepLabel.textContent = 'Refusé';
        lastStepLabel.classList.add('text-red-600', 'font-medium');
        
        return;
    }
    
    // Configuration pour les autres états
    document.getElementById('progress-bar').style.background = 'linear-gradient(to right, #3b82f6, #6366f1)';
    
    switch(status) {
        case 'demande-recue':
            currentStep = 1;
            progressWidth = '16%';
            break;
        case 'en-preparation':
            currentStep = 2;
            progressWidth = '33%';
            break;
        case 'document-pret':
            currentStep = 3;
            progressWidth = '66%';
            break;
        case 'termine':
            currentStep = 4;
            progressWidth = '100%';
            break;
    }
    
    document.getElementById('progress-bar').style.width = progressWidth;
    
    // Appliquer les styles pour l'état actuel
    for (let i = 1; i <= 4; i++) {
        const icon = document.getElementById(`step${i}-icon`);
        const label = document.getElementById(`step${i}-label`);
        
        if (i < currentStep) {
            icon.classList.add('border-blue-500', 'bg-blue-500');
            icon.querySelector('i').classList.add('text-white');
            label.classList.add('text-blue-600', 'font-medium');
        } else if (i === currentStep) {
            icon.classList.add('border-blue-500');
            icon.querySelector('i').classList.add('text-blue-500');
            label.classList.add('text-blue-600', 'font-medium');
        }
    }
}
        
        function showForm() {
            document.getElementById('request-details-container').classList.add('hidden');
            document.getElementById('form-container').classList.remove('hidden');
        }

        // Gestion des clics en dehors du combobox pour le fermer
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.relative.w-full.sm\\:w-72')) {
                document.getElementById('history-options').classList.add('hidden');
                document.getElementById('history-chevron').classList.remove('rotate-180');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('cancelBtn').addEventListener('click', function() {
                if (confirm('Voulez-vous vraiment annuler votre demande ?')) {
                    document.querySelector('form').reset();
                    showAlert('error', 'Demande annulée', 'Votre demande a été annulée avec succès.');
                }
            });

            function showAlert(type, title, message) {
                const alertContainer = document.getElementById('alertContainer');
                const alertTypes = {
                    success: {
                        icon: 'fa-check-circle',
                        className: 'bg-green-100 border-green-400 text-green-700'
                    },
                    error: {
                        icon: 'fa-times-circle',
                        className: 'bg-red-100 border-red-400 text-red-700'
                    }
                };
                
                const alert = document.createElement('div');
                alert.className = `border-l-4 ${alertTypes[type].className} p-4 mb-4 rounded-lg flex items-start`;
                alert.innerHTML = `
                    <i class="fas ${alertTypes[type].icon} mt-1 mr-3"></i>
                    <div>
                        <strong class="font-bold">${title}</strong>
                        <span class="block sm:inline">${message}</span>
                    </div>
                `;
                
                while (alertContainer.firstChild) {
                    alertContainer.removeChild(alertContainer.firstChild);
                }
                
                alertContainer.appendChild(alert);
                
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }, 5000);
            }
        });
    </script>
</x-home>