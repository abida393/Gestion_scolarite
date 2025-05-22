<x-home titre="Tableau de Paiement" page_titre="Tableau de Paiement" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">
    <!-- Page Content -->
    <div class="bg-gradient-to-tr  p-6 sm:p-10">

        <!-- Container -->
        <div class="max-w-5xl mx-auto space-y-10">

            <!-- Header -->
            <div class="text-center">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-indigo-700">Tableau de Paiement</h1>
                <p class="text-gray-500 mt-2 text-sm sm:text-base">Détails des paiements effectués par l'étudiant</p>
            </div>

            <!-- Résumé -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

                <!-- Carte 1 -->
                <div class="bg-white rounded-2xl shadow-md p-6 text-center hover:shadow-xl transition">
                    <i class="ph ph-wallet text-indigo-600 text-4xl mb-3"></i>
                    <p class="text-sm text-gray-500">Montant total</p>
                    <p class="text-2xl font-bold text-indigo-800">{{ $paiements[0]->montant_total ?? 0 }} DHS</p>
                </div>

                <!-- Carte 2 -->
                <div class="bg-white rounded-2xl shadow-md p-6 text-center hover:shadow-xl transition">
                    <i class="ph ph-check-circle text-emerald-600 text-4xl mb-3"></i>
                    <p class="text-sm text-gray-500">Montant payé</p>
                    <p class="text-2xl font-bold text-emerald-700">{{ $montant_paye ?? 0 }} DHS</p>
                </div>

                <!-- Carte 3 -->
                <div class="bg-white rounded-2xl shadow-md p-6 text-center hover:shadow-xl transition">
                    <i class="ph ph-clock-counter-clockwise text-rose-500 text-4xl mb-3"></i>
                    <p class="text-sm text-gray-500">Montant restant</p>
                    <p class="text-2xl font-bold text-rose-600">{{ $montant_restant ?? 0 }} DHS</p>
                </div>

            </div>

            <!-- Historique des paiements -->
            <div class="bg-white rounded-3xl shadow-lg p-6 sm:p-8 space-y-5">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-4">
                    <h2 class="text-2xl font-semibold text-slate-800">Historique des paiements</h2>

                    <!-- Filtres -->
                    <div class="flex gap-2">
                        <button id="all"
                            class="filter-btn bg-indigo-100 text-indigo-700 font-medium px-4 py-1 rounded-full hover:bg-indigo-200 transition">Tous</button>
                        <button id="cash"
                            class="filter-btn bg-emerald-100 text-emerald-700 font-medium px-4 py-1 rounded-full hover:bg-emerald-200 transition">Cash</button>
                        <button id="cheque"
                            class="filter-btn bg-purple-100 text-purple-700 font-medium px-4 py-1 rounded-full hover:bg-purple-200 transition">Chèque</button>
                    </div>
                </div>

                @if(count($paiements) > 0)
                    @foreach ($paiements as $paiement)
                        <!-- Paiement 1 -->
                        @php
                            $paiement->mode_paiement == 'cash' ? $payment = 'payment-cash' : $payment = 'payment-cheque';
                        @endphp
                        <div class="payment-row group {{$payment}} animate-fade-in flex justify-between items-center border-b pb-4 p-3 rounded-xl transition duration-300 ease-in-out hover:-translate-y-[2px] hover:shadow-lg hover:bg-indigo-50 hover:border-indigo-300">
                            <div class="flex items-center gap-4">
                                @if ($paiement->mode_paiement == 'cash')
                                    <i class="ph ph-money text-indigo-600 text-2xl group-hover:animate-bounce-slow"></i>
                                @elseif ($paiement->mode_paiement == 'credit card')
                                    <i class="ph ph-bank text-purple-500 text-2xl group-hover:animate-bounce-slow"></i>
                                @elseif ($paiement->mode_paiement == 'cheque')
                                    <i class="ph ph-bank text-rose-500 text-2xl group-hover:animate-bounce-slow"></i>
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-700">{{ $paiement->montant_paye }} DHS</p>
                                    <p class="text-sm text-gray-400 capitalize">{{ $paiement->mode_paiement }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-1">
                                <p class="text-sm text-gray-500">{{ $paiement->date_paiement }}</p>
                                @if ($paiement->status == 'confirmé')
                                    <span class="text-xs font-medium px-2 py-1 bg-green-100 text-green-700 rounded-full">Validé</span>
                                @elseif ($paiement->status == 'en attente')
                                    <span class="text-xs font-medium px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full">En attente</span>
                                    @elseif ($paiement->status == 'refusé')
                                    <span class="text-xs font-medium px-2 py-1 bg-red-100 text-red-700 rounded-full">Refusé</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8">
                        <i class="ph ph-warning-circle text-4xl text-gray-400 mb-3"></i>
                        <p class="text-gray-500">Aucun paiement enregistré</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
<x-chat-button></x-chat-button>
</x-home>
