<x-home titre="Page demandes de documents" page_titre="Page demandes de documents"
    :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ' ' . Auth::guard('etudiant')->user()->etudiant_prenom">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #4270f4;
            --secondary-color: #3b3f5c;
            --accent-color: #fd79a8;
            --success-color: #a29bfe;
            --error-color: #fd79a8;
            --light-color: #f5f6fa;
            --dark-color: #2d3436;
            --text-color: #333;
            --border-radius: 12px;
            --box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
           color: var(--text-color);
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        .document-request-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 30px;
            margin-bottom: 30px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .document-request-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(to bottom, var(--primary-color), var(--accent-color));
        }

        .document-request-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        h1 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            position: relative;
            padding-bottom: 10px;
        }

        h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
            border-radius: 2px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark-color);
        }

        select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: var(--border-radius);
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            transition: var(--transition);
            background-color: white;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 15px;
        }

        select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.2);
        }

        .document-select {
            margin-bottom: 15px;
        }

        .confirmation {
            background-color:rgb(237, 236, 247);
            padding: 15px;
            border-radius: var(--border-radius);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            border-left: 4px solid var(--success-color);
        }

        .confirmation input[type="checkbox"] {
            margin-right: 15px;
            width: 20px;
            height: 20px;
            accent-color: var(--success-color);
        }

        .confirmation label {
            margin-bottom: 0;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: var(--border-radius);
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
           
            position: relative;
            overflow: hidden;
        }

        .btn::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(30deg);
            transition: var(--transition);
        }

        .btn:hover::after {
            left: 100%;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 4px 15px rgba(108, 92, 231, 0.3);
        }

        .btn-primary:hover {
            background-color: #5649c0;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 92, 231, 0.4);
        }

        .btn-danger {
            background-color: var(--error-color);
            color: white;
            box-shadow: 0 4px 15px rgba(214, 48, 49, 0.3);
        }

        .btn-danger:hover {
            background-color:rgb(176, 110, 165);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(214, 48, 49, 0.4);
        }

        .icon {
            font-size: 18px;
        }

        .alert {
            padding: 15px;
            border-radius: var(--border-radius);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            animation: slideIn 0.5s ease-out forwards;
            opacity: 0;
            transform: translateY(-20px);
        }

        .alert-success {
            background-color: rgba(0, 184, 148, 0.2);
            border-left: 4px solid var(--success-color);
            color: var(--success-color);
        }

        .alert-error {
            background-color: rgba(214, 48, 49, 0.2);
            border-left: 4px solid var(--error-color);
            color: var(--error-color);
        }

        .alert-icon {
            margin-right: 15px;
            font-size: 24px;
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: -1;
            overflow: hidden;
        }

        .shape {
            position: absolute;
            opacity: 0.1;
            border-radius: 50%;
        }

        .shape-1 {
            width: 100px;
            height: 100px;
            background: var(--primary-color);
            top: -30px;
            right: -30px;
        }

        .shape-2 {
            width: 150px;
            height: 150px;
            background: var(--accent-color);
            bottom: -50px;
            left: -50px;
        }

        @media (max-width: 768px) {
            .button-group {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .document-request-card {
            animation: fadeIn 0.6s ease-out forwards;
        }

        .btn {
            animation: pulse 2s infinite;
        }

        .btn:hover {
            animation: none;
        }
    </style>

<style>
    .combobox-options {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e0 #f7fafc;
    }
    
    .combobox-options::-webkit-scrollbar {
        width: 8px;
    }
    
    .combobox-options::-webkit-scrollbar-track {
        background: #f7fafc;
        border-radius: 0 0 8px 8px;
    }
    
    .combobox-options::-webkit-scrollbar-thumb {
        background-color: #cbd5e0;
        border-radius: 4px;
    }
    
    .rotate-180 {
        transform: rotate(180deg);
    }
    
    .transition-transform {
        transition: transform 0.2s ease;
    }
    
    /* Styles pour la timeline */
    .timeline-container {
        margin-top: 30px;
        padding: 20px;
    }
    
    .timeline-title {
        font-size: 1.5rem;
        color: var(--primary-color);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .timeline {
        position: relative;
        max-width: 100%;
        margin: 0 auto;
    }
    
    .timeline::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 4px;
        background: #e0e0e0;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        z-index: 1;
    }
    
    .progress-bar {
        position: absolute;
        height: 4px;
        background: var(--primary-color);
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        z-index: 2;
        transition: width 0.5s ease;
    }
    
    .timeline-steps {
        display: flex;
        justify-content: space-between;
        position: relative;
        z-index: 3;
    }
    
    .timeline-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
    }
    
    .step-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #fff;
        border: 3px solid #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }
    
    .step-icon.active {
        border-color: var(--primary-color);
        background-color: var(--primary-color);
        color: white;
    }
    
    .step-icon.completed {
        border-color: var(--primary-color);
        background-color: var(--primary-color);
        color: white;
    }
    
    .step-label {
        font-size: 0.9rem;
        text-align: center;
        max-width: 100px;
        color: #666;
    }
    
    .step-label.active {
        color: var(--primary-color);
        font-weight: 500;
    }
    
    .step-label.completed {
        color: var(--primary-color);
    }
    
    .request-details {
        margin-top: 30px;
        background: #f9f9f9;
        padding: 20px;
        border-radius: var(--border-radius);
    }
    
    .detail-row {
        display: flex;
        margin-bottom: 10px;
    }
    
    .detail-label {
        font-weight: 500;
        min-width: 150px;
        color: var(--dark-color);
    }
    
    .detail-value {
        color: var(--text-color);
    }
    
    .back-to-form {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 20px;
        background: var(--primary-color);
        color: white;
        border-radius: var(--border-radius);
        text-decoration: none;
        transition: var(--transition);
    }
    
    .back-to-form:hover {
        background: #5649c0;
        transform: translateY(-2px);
    }
    
    .hidden {
        display: none;
    }
</style>

        <div class="container">
            <p class="text-primary text-3xl font-bold mb-3 flex items-center justify-center gap-3">
                <i class="fas fa-file-alt"></i> Demande de Documents Scolaires
            </p>
            <p class="text-gray text-lg max-w-2xl mx-auto">
                Sélectionnez les documents dont vous avez besoin et soumettez votre demande
            </p>
        </div>

       
        <div class="container max-w-4xl mx-auto px-5 py-10">
    <div class="flex justify-between items-center mb-1">
        <h2 class="section-title text-primary text-2xl font-semibold pb-2 border-b-2 border-secondary flex items-center gap-3">
            <i class="fas fa-file"></i> Sélection du Document
        </h2>
        <div class="relative">
            <!-- Combobox sélectionné -->
            <div class="combobox-selected bg-light border-2 border-border rounded-lg p-3 cursor-pointer flex items-center justify-between hover:border-primary transition-all"
                 onclick="toggleCombobox('history')">
                <span><i class="fas fa-history mr-2"></i> Mes demandes</span>
                <i class="fas fa-chevron-down text-gray transition-transform" id="history-chevron"></i>
            </div>

            <div class="combobox-options absolute top-full right-0 bg-white border border-border rounded-lg max-h-60 overflow-y-auto shadow-lg z-50 w-64 hidden"
     id="history-options">
    @if($demandes->isEmpty())
        <div class="p-3 text-center text-gray">
            Aucune demande trouvée
        </div>
    @else
        @foreach($demandes as $demande)
            @php
                $statusClass = [
                    'demande-recue' => 'bg-yellow-400 text-yellow-800',
                    'en-preparation' => 'bg-blue-400 text-blue-800',
                    'document-pret' => 'bg-purple-400 text-purple-800',
                    'termine' => 'bg-green-400 text-green-800'
                ][strtolower(str_replace(' ', '-', $demande->etat_demande))] ?? 'bg-gray-100 text-gray-800';
            @endphp
            <div class="combobox-option p-3 flex items-center justify-between cursor-pointer hover:bg-[rgba(76,201,240,0.1)] transition-all border-b border-border last:border-b-0"
                 onclick="showRequestDetails('{{ $demande->id }}', '{{ $demande->document->nom_document }}', '{{ $demande->annee_academique }}', '{{ strtolower(str_replace(' ', '-', $demande->etat_demande)) }}', '{{ $demande->created_at }}', '{{ $demande->updated_at }}')">
                <div>
                    <div class="font-medium truncate max-w-[150px]">{{ $demande->document->nom_document }}</div>
                    <div class="text-sm text-gray">{{ $demande->annee_academique }}</div>
                </div>
                <span class="status-badge text-xs px-2 py-1 rounded-full {{ $statusClass }}">
                    {{ $demande->etat_demande }}
                </span>
            </div>
        @endforeach
    @endif
</div>
        </div>
    </div>
</div>

        
    <div class="container">
        <div class="document-request-card" id="form-container">
            <div class="floating-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
            </div>
            <div id="alertContainer"></div>
            
            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="id_document"><i class="fas fa-file-download icon"></i> Documents Disponibles</label>
                    <div class="document-select">
                        <select name="id_document" id="id_document" required required>
                            <option value="" disabled selected>Sélectionnez un document</option>
                            @foreach($documents as $document)
                            <option value="{{ $document->id }}">{{ $document->nom_document }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label for="annee_academique"><i class="fas fa-calendar-alt icon"></i> Année Académique</label>
                    <select name="annee_academique" id="annee_academique" required>
                        <option value="" disabled selected>Sélectionnez une année</option>
                        @for ($i = now()->year; $i >= 2000; $i--)
                        <option value="{{ $i }}-{{ $i+1 }}">{{ $i }}-{{ $i+1 }}</option>
                    @endfor
                    </select>
                </div>
                
                <div class="confirmation">
                    <input type="checkbox" id="confirmRequest" name="confirmRequest" required>
                    <label for="confirmRequest">Je confirme ma demande de documents.</label>
                </div>
                
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane icon"></i> Soumettre la demande
                    </button>
                    <button type="button" id="cancelBtn" class="btn btn-danger">
                        <i class="fas fa-times-circle icon"></i> Annuler
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Section pour afficher les détails de la demande -->
        <div class="document-request-card hidden" id="request-details-container">
            <div class="floating-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
            </div>
            
            <div class="timeline-container">
                <h3 class="timeline-title">
                    <i class="fas fa-tasks"></i> État d'avancement de votre demande
                </h3>
                
                <div class="timeline">
                    <div class="progress-bar" id="progress-bar"></div>
                    <div class="timeline-steps">
                        <div class="timeline-step" id="step1">
                            <div class="step-icon" id="step1-icon">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <span class="step-label" id="step1-label">Demande reçue</span>
                        </div>
                        
                        <div class="timeline-step" id="step2">
                            <div class="step-icon" id="step2-icon">
                                <i class="fas fa-cog"></i>
                            </div>
                            <span class="step-label" id="step2-label">En préparation</span>
                        </div>
                        
                        <div class="timeline-step" id="step3">
                            <div class="step-icon" id="step3-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <span class="step-label" id="step3-label">Document prêt</span>
                        </div>
                        
                        <div class="timeline-step" id="step4">
                            <div class="step-icon" id="step4-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <span class="step-label" id="step4-label">Terminé</span>
                        </div>
                    </div>
                </div>
                
                <div class="request-details">
                    <h4>
                        <i class="fas fa-info-circle"></i> Détails de la demande
                    </h4>
                    
                    <div class="detail-row">
                        <span class="detail-label">Document demandé:</span>
                        <span class="detail-value" id="detail-document"></span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label">Année académique:</span>
                        <span class="detail-value" id="detail-annee"></span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label">Statut actuel:</span>
                        <span class="detail-value" id="detail-status"></span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label">Date de demande:</span>
                        <span class="detail-value" id="detail-date-demande"></span>
                    </div>
                   
                    <div class="detail-row">
                        <span class="detail-label">Dernière mise à jour:</span>
                        <span class="detail-value" id="detail-date-update"></span>
                        
                    </div>
<div>
<span id="file-name">oui :</span>
</div>

                    
<div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hidden" id="download-section">
    <!-- Icône PDF -->
    <i class="fas fa-file-pdf text-4xl text-red-500 mb-2"></i>
    
    <!-- État de la demande -->
    <p class="font-medium mb-1">
        <strong>État de la demande :</strong> <span id="detail-status-text"></span>
    </p>
    
    <!-- Date -->
    <p class="text-sm text-gray-500 mb-3" id="detail-date-text"></p>

    <!-- ✅ Lien de téléchargement dynamique -->
    <a href="#" 
       id="download-btn"
       class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded inline-flex items-center hidden"
       target="_blank">
        <i class="fas fa-download mr-2"></i>
        Télécharger <span id="file-name" class="ml-2 font-semibold"></span>
    </a>

    <!-- Message d'indisponibilité -->
    <div id="unavailable-message" class="bg-gray-100 text-gray-700 px-4 py-2 rounded inline-flex items-center hidden">
        <i class="fas fa-clock mr-2"></i>
        Document non disponible
    </div>
</div>

                <button class="back-to-form" onclick="showForm()">
                    <i class="fas fa-arrow-left"></i> Retour au formulaire
                </button>
            </div>
        </div>
    </div>


    <!-- Modifiez la fonction showRequestDetails pour : -->
        <script>
 function showRequestDetails(id, documentName, anneeAcademique, status, dateDemande, dateUpdate, fileName) {
    // Masquer le formulaire
    document.getElementById('form-container').classList.add('hidden');
    
    // Afficher la section des détails
    document.getElementById('request-details-container').classList.remove('hidden');
    
    // Remplir les détails
    document.getElementById('detail-document').textContent = documentName;
    document.getElementById('detail-annee').textContent = anneeAcademique;
    document.getElementById('detail-status').textContent = formatStatus(status);
    document.getElementById('detail-date-demande').textContent = formatDate(dateDemande);
    document.getElementById('detail-date-update').textContent = formatDate(dateUpdate);
    
    // Afficher la section de téléchargement
    const downloadSection = document.getElementById('download-section');
    downloadSection.classList.remove('hidden');
    
    // Gérer l'état de téléchargement
    const downloadBtn = document.getElementById('download-btn');
    const unavailableMsg = document.getElementById('unavailable-message');
    const statusText = document.getElementById('detail-status-text');
    const dateText = document.getElementById('detail-date-text');
    
    statusText.textContent = formatStatus(status);
    dateText.textContent = `Dernière mise à jour: ${formatDate(dateUpdate)}`;
    
    // Afficher ou masquer le bouton de téléchargement en fonction du statut
    if (status === 'termine') {
        downloadBtn.classList.remove('hidden');
        unavailableMsg.classList.add('hidden');
        
        // Mettre à jour dynamiquement l'URL du bouton avec le fichier réel
        downloadBtn.href = `/storage/documents/${fileName}`;
    } else {
        downloadBtn.classList.add('hidden');
        unavailableMsg.classList.remove('hidden');
    }
    
    // Mettre à jour la timeline en fonction du statut
    updateTimeline(status);

    // Afficher le nom du fichier dans le texte de téléchargement
    document.getElementById('file-name').textContent = fileName;
}

</script>



    <script>
    // Fonction pour basculer l'affichage du combobox
    function toggleCombobox(id) {
        const options = document.getElementById(`${id}-options`);
        const chevron = document.getElementById(`${id}-chevron`);
        
        options.classList.toggle('hidden');
        chevron.classList.toggle('rotate-180');
    }
    
    
    function formatStatus(status) {
    const statusMap = {
        'demande-recue': 'Demande reçue',
        'en-preparation': 'En préparation',
        'document-pret': 'Document prêt',
        'termine': 'Terminé'
    };
    
    return statusMap[status] || status.charAt(0).toUpperCase() + status.slice(1).replace('-', ' ');
}
    
    // Fonction pour formater la date
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
    
    // Fonction pour mettre à jour la timeline
    function updateTimeline(status) {
        // Réinitialiser tous les étapes
        for (let i = 1; i <= 4; i++) {
            document.getElementById(`step${i}-icon`).classList.remove('active', 'completed');
            document.getElementById(`step${i}-label`).classList.remove('active', 'completed');
        }
        
        // Déterminer l'étape actuelle
        let currentStep = 1;
        let progressWidth = '0%';
        
        switch(status) {
            case 'demande-recue':
                currentStep = 1;
                progressWidth = '0%';
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
        
        // Mettre à jour la barre de progression
        document.getElementById('progress-bar').style.width = progressWidth;
        
        // Mettre à jour les étapes
        for (let i = 1; i <= 4; i++) {
            if (i < currentStep) {
                // Étapes complétées
                document.getElementById(`step${i}-icon`).classList.add('completed');
                document.getElementById(`step${i}-label`).classList.add('completed');
            } else if (i === currentStep) {
                // Étape actuelle
                document.getElementById(`step${i}-icon`).classList.add('active');
                document.getElementById(`step${i}-label`).classList.add('active');
            }
        }
    }
    
    // Fonction pour revenir au formulaire
    function showForm() {
        document.getElementById('request-details-container').classList.add('hidden');
        document.getElementById('form-container').classList.remove('hidden');
    }

</script>
    <script>
    
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion de l'annulation
            document.getElementById('cancelBtn').addEventListener('click', function() {
                if (confirm('Voulez-vous vraiment annuler votre demande ?')) {
                    document.getElementById('documentRequestForm').reset();
                    showAlert('error', 'Demande annulée', 'Votre demande a été annulée avec succès.');
                }
            });

            // Simulation de soumission du formulaire
            document.getElementById('documentRequestForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const academicYear = document.getElementById('academicYear').value;
                const documentType = document.getElementById('documentType').value;
                
                if (!academicYear || !documentType) {
                    showAlert('error', 'Erreur', 'Veuillez sélectionner une année et un document.');
                    return;
                }
                
                if (!document.getElementById('confirmRequest').checked) {
                    showAlert('error', 'Erreur', 'Veuillez confirmer votre demande.');
                    return;
                }
                
                // Simulation d'envoi réussi
                showAlert('success', 'Succès', `Votre demande pour ${document.getElementById('documentType').selectedOptions[0].text} (${academicYear}) a été soumise avec succès.`);
                
                // Réinitialiser le formulaire après soumission
                this.reset();
            });

            // Fonction pour afficher les alertes
            function showAlert(type, title, message) {
                const alertContainer = document.getElementById('alertContainer');
                const alertTypes = {
                    success: {
                        icon: 'fa-check-circle',
                        className: 'alert-success'
                    },
                    error: {
                        icon: 'fa-times-circle',
                        className: 'alert-error'
                    }
                };
                
                const alert = document.createElement('div');
                alert.className = `alert ${alertTypes[type].className}`;
                alert.innerHTML = `
                    <i class="fas ${alertTypes[type].icon} alert-icon"></i>
                    <div>
                        <strong>${title}</strong><br>
                        ${message}
                    </div>
                `;
                
                // Supprimer les anciennes alertes
                while (alertContainer.firstChild) {
                    alertContainer.removeChild(alertContainer.firstChild);
                }
                
                alertContainer.appendChild(alert);
                
                // Supprimer l'alerte après 5 secondes
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }, 5000);
            }
        });
    </script>


</x-home>