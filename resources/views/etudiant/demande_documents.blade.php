<x-home titre="Page demandes de documents" page_titre="Page demandes de documents" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">
<div id="demandes-page">
            <div class="document-request-container">
                <header class="document-request-header">
                    <h1><i class="fas fa-file-alt"></i> Demande de documents académiques</h1>
                </header>

                <form id="document-request-form">
                    <div class="form-group">
                        <label for="document-type"><i class="fas fa-file-signature"></i> Type de document</label>
                        <select id="document-type" name="document-type" required>
                            <option value="">-- Sélectionnez un document --</option>
                            <option value="releve">Relevé de notes</option>
                            <option value="bulletin">Bulletin de notes</option>
                            <option value="attestation">Attestation scolaire</option>
                            <option value="certificat">Certificat de scolarité</option>
                            <option value="autre">Autre document</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="annee"><i class="fas fa-calendar-alt"></i> Année académique</label>
                        <select id="annee" name="annee" required>
                            <option value="">-- Sélectionnez une année --</option>
                            <option value="2023-2024">2023-2024</option>
                            <option value="2022-2023">2022-2023</option>
                            <option value="2021-2022">2021-2022</option>
                            <option value="2020-2021">2020-2021</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-check-circle"></i> Confirmation</label>
                        <div class="checkbox-group">
                            <label>
                                <input type="checkbox" name="confirmation" required>
                                Je confirme ma demande des documents académiques.
                            </label>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane"></i> Soumettre la demande
                        </button>
                        <button type="reset" class="btn-reset">
                            <i class="fas fa-times"></i> Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <x-chat-button></x-chat-button>
</x-home>
