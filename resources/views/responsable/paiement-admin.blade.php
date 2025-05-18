<x-admin titre="paiement" page_titre="paiement" :nom_complete="Auth::guard('responsable')->user()->respo_nom . ' ' . Auth::guard('responsable')->user()->respo_prenom">
    <div class="container mx-auto px-4 py-8">

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Payment Form Card -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-10">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Ajouter un paiement</h2>

                <form action="{{ route('paiements.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Student Selection -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="etudiant_id" class="block text-sm font-medium text-gray-700 mb-1">Étudiant</label>
                            <select id="etudiant_id" name="etudiant_id" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required onchange="updateMontantTotal()">
                                <option value="">-- Sélectionner un étudiant --</option>
                                @foreach($etudiants as $etudiant)
                                    <option value="{{ $etudiant->id }}" data-montant="{{ $etudiant->montant_total ?? 5000 }}">
                                        {{ $etudiant->etudiant_nom }} {{ $etudiant->etudiant_prenom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Total Amount -->
                        <div>
                            <label for="montant_total" class="block text-sm font-medium text-gray-700 mb-1">Montant total</label>
                            <input type="number" step="0.01" name="montant_total" id="montant_total" class="w-full p-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" readonly required>
                        </div>

                        <!-- Paid Amount -->
                        <div>
                            <label for="montant_paye" class="block text-sm font-medium text-gray-700 mb-1">Montant payé</label>
                            <input type="number" step="0.01" name="montant_paye" id="montant_paye" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required oninput="calculateMontantRestant()">
                        </div>

                        <!-- Remaining Amount -->
                        <div>
                            <label for="montant_restant" class="block text-sm font-medium text-gray-700 mb-1">Montant restant</label>
                            <input type="number" step="0.01" name="montant_restant" id="montant_restant" class="w-full p-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" readonly required>
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <label for="mode_paiement" class="block text-sm font-medium text-gray-700 mb-1">Mode de paiement</label>
                            <select name="mode_paiement" id="mode_paiement" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required onchange="toggleChequeInput()">
                                <option value="">-- Sélectionner --</option>
                                <option value="cash">Cash</option>
                                <option value="virement">Virement</option>
                                <option value="cheque">Chèque</option>
                            </select>
                        </div>

                        <!-- Check Number (Conditional) -->
                        <div id="cheque_section" class="hidden">
                            <label for="numero_cheque" class="block text-sm font-medium text-gray-700 mb-1">Numéro de chèque</label>
                            <input type="text" name="numero_cheque" id="numero_cheque" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Payment Date -->
                        <div>
                            <label for="date_paiement" class="block text-sm font-medium text-gray-700 mb-1">Date de paiement</label>
                            <input type="date" name="date_paiement" id="date_paiement" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
         <!-- Search Form -->
         <form method="GET" action="{{ route('paiements.index') }}" class="mb-4">
    <input type="text" name="search" value="{{ request('search') }}"
        placeholder="Rechercher par nom ou prénom..."
        class="border p-2 rounded w-1/3" />
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded ml-2">Rechercher</button>
</form>

        <!-- Payment History -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Historique des paiements</h2>
                
                <div class="w-full">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Étudiant</th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payé</th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Restant</th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mode</th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Chèque</th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($paiements as $paiement)
                                <tr>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $paiement->etudiant->etudiant_nom }} {{ $paiement->etudiant->etudiant_prenom }}
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $paiement->montant_total }} MAD
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $paiement->montant_paye }} MAD
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $paiement->montant_restant }} MAD
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ ucfirst($paiement->mode_paiement) }}
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $paiement->numero_cheque ?? '-' }}
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $paiement->date_paiement }}
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($paiement->status === 'confirmé') bg-green-100 text-green-800
                                            @elseif($paiement->status === 'refusé') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ $paiement->status }}
                                        </span>

                                        @if($paiement->mode_paiement === 'cheque' && $paiement->status === 'en attente')
                                            <div class="mt-1 flex flex-col sm:flex-row gap-1">
                                                <form action="{{ route('paiements.changer-statut', $paiement->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="confirmé">
                                                    <button type="submit" class="text-xs text-green-600 hover:text-green-800 hover:underline">Confirmer</button>
                                                </form>

                                                <form action="{{ route('paiements.changer-statut', $paiement->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="refusé">
                                                    <button type="submit" class="text-xs text-red-600 hover:text-red-800 hover:underline">Refuser</button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateMontantTotal() {
            const select = document.getElementById('etudiant_id');
            const selectedOption = select.options[select.selectedIndex];
            const montant = selectedOption.getAttribute('data-montant') || 0;
            document.getElementById('montant_total').value = montant;
            calculateMontantRestant();
        }

        function calculateMontantRestant() {
            const total = parseFloat(document.getElementById('montant_total').value) || 0;
            const paye = parseFloat(document.getElementById('montant_paye').value) || 0;
            const restant = total - paye;
            document.getElementById('montant_restant').value = restant >= 0 ? restant.toFixed(2) : 0;
        }

        function toggleChequeInput() {
            const mode = document.getElementById('mode_paiement').value;
            const chequeSection = document.getElementById('cheque_section');
            if (mode === 'cheque') {
                chequeSection.classList.remove('hidden');
            } else {
                chequeSection.classList.add('hidden');
            }
        }
    </script>
</x-admin>