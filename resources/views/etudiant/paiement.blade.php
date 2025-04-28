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
                    <p class="text-2xl font-bold text-indigo-800">{{ $paiements[0]->montant_total }} DHS</p>
                </div>

                <!-- Carte 2 -->
                <div class="bg-white rounded-2xl shadow-md p-6 text-center hover:shadow-xl transition">
                    <i class="ph ph-check-circle text-emerald-600 text-4xl mb-3"></i>
                    <p class="text-sm text-gray-500">Montant payé</p>
                    <p class="text-2xl font-bold text-emerald-700">{{ $montant_paye }} DHS</p>
                </div>

                <!-- Carte 3 -->
                <div class="bg-white rounded-2xl shadow-md p-6 text-center hover:shadow-xl transition">
                    <i class="ph ph-clock-counter-clockwise text-rose-500 text-4xl mb-3"></i>
                    <p class="text-sm text-gray-500">Montant restant</p>
                    <p class="text-2xl font-bold text-rose-600">{{ $montant_restant }} DHS</p>
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

                @foreach ($paiements as $paiement)
                    <!-- Paiement 1 -->
                    @php
                        $paiement->mode_paiement == 'cash' ? $payment = 'payment-cash' : $payment = 'payment-cheque';
                    @endphp
                    <div
                        class="payment-row group {{$payment}} animate-fade-in flex justify-between items-center border-b pb-4 p-3 rounded-xl transition duration-300 ease-in-out hover:-translate-y-[2px] hover:shadow-lg hover:bg-indigo-50 hover:border-indigo-300">
                        <div class="flex items-center gap-4">
                            @if ($paiement->mode_paiement == 'cash')
                                <i class="ph ph-money text-indigo-600 text-2xl group-hover:animate-bounce-slow"></i>
                            @endif
                            @if ($paiement->mode_paiement == 'credit card')
                                <i class="ph ph-bank text-purple-500 text-2xl group-hover:animate-bounce-slow"></i>
                            @endif
                            <div>
                                <p class="font-semibold text-gray-700">{{ $paiement->montant_paye }}DHS</p>
                                <p class="text-sm text-gray-400">{{ $paiement->mode_paiement }}</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500">{{ $paiement->date_paiement }}</p>
                    </div>
                @endforeach


                {{-- <!-- Paiement 2 -->
        <div class="payment-row group payment-cheque animate-fade-in flex justify-between items-center border-b pb-4 p-3 rounded-xl transition duration-300 ease-in-out hover:-translate-y-[2px] hover:shadow-lg hover:bg-purple-50 hover:border-purple-300">
          <div class="flex items-center gap-4">
            <i class="ph ph-bank text-purple-500 text-2xl group-hover:animate-bounce-slow"></i>
            <div>
              <p class="font-semibold text-gray-700">8 000 DHS</p>
              <p class="text-sm text-gray-400">Chèque</p>
            </div>
          </div>
          <p class="text-sm text-gray-500">28 Fév 2025</p>
        </div> --}}

                {{-- <!-- Paiement 3 -->
        <div class="payment-row group payment-cash animate-fade-in flex justify-between items-center pb-4 p-3 rounded-xl transition duration-300 ease-in-out hover:-translate-y-[2px] hover:shadow-lg hover:bg-indigo-50 hover:border-indigo-300">
          <div class="flex items-center gap-4">
            <i class="ph ph-money text-indigo-600 text-2xl group-hover:animate-bounce-slow"></i>
            <div>
              <p class="font-semibold text-gray-700">6 000 DHS</p>
              <p class="text-sm text-gray-400">Cash</p>
            </div>
          </div>
          <p class="text-sm text-gray-500">10 Mars 2025</p>
        </div> --}}

            </div>
        </div>
    </div>

</x-home>
