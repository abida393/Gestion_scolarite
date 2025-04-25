<x-home titre="absences-page" page_titre="absences-page">
    <div id="absences-page">
        <div class="container">
            <header>
                <h1><i class="fas fa-calendar-times"></i> Mes Absences</h1>
                <p class="subtitle">Historique de vos absences enregistrées</p>
            </header>

            <main>
                <section class="absence-list">
                    <article class="dashboard-card">
                        <div class="card-header">
                            <h2><i class="far fa-calendar-alt"></i> 12/09/2024</h2>
                            <span class="status unjustified"><i class="fas fa-times-circle"></i> Non justifiée</span>
                        </div>

                        <div class="card-grid">
                            <div class="detail-item">
                                <div class="detail-label"><i class="far fa-bookmark"></i> Séance</div>
                                <div>Algorithmique avancée</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label"><i class="far fa-clock"></i> Heures</div>
                                <div>08:30 - 10:00 (1h30)</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label"><i class="far fa-comment-alt"></i> Justification</div>
                                <div>-</div>
                            </div>
                        </div>
                    </article>
                </section>

                <section class="document-request-container">
                    <header class="document-request-header">
                        <h1><i class="far fa-edit"></i> Justifier une absence</h1>
                    </header>

                    <form id="absence-justification-form">
                        <div class="form-group">
                            <label for="absence-select"><i class="far fa-list-alt"></i> Séance absente</label>
                            <select id="absence-select" name="absence_id" required>
                                <option value="">-- Sélectionnez une séance --</option>
                                <option value="1">12/09/2024 - Algorithmique avancée (08:30-10:00)</option>
                            </select>
                            <p class="duration-info"><i class="far fa-hourglass"></i> Durée standard des séances : 1
                                heure 30 minutes</p>
                        </div>

                        <div class="form-group">
                            <label for="justification-text"><i class="far fa-file-alt"></i> Motif de l'absence</label>
                            <textarea id="justification-text" name="justification" required
                                placeholder="Décrivez précisément le motif de votre absence..."></textarea>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-submit">
                                <i class="far fa-paper-plane"></i> Soumettre la justification
                            </button>
                            <button type="reset" class="btn-reset">
                                <i class="fas fa-times"></i> Annuler
                            </button>
                        </div>
                    </form>
                </section>
            </main>
        </div>
    </div>
</x-home>
