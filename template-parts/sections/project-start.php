<!-- ============================================================ -->
<!-- PROJEKT STARTEN (06) – Multi-Step Formular mit AJAX -->
<!-- ============================================================ -->

<section id="projekt-starten" class="project-start-section" aria-label="<?php _e('Projekt starten', 'noirwerk'); ?>">
    <div class="container">
        <p class="eyebrow" data-reveal><b>06</b>&nbsp;— <?php _e('Projekt starten', 'noirwerk'); ?></p>

        <div class="project-start__grid">
            <!-- Linke Spalte: Formular -->
            <div class="project-start__form" data-reveal>
                <h2><?php _e('Ihr Projekt – in 4 Schritten', 'noirwerk'); ?></h2>
                <p class="project-start__sub"><?php _e('Beantworten Sie ein paar Fragen.', 'noirwerk'); ?></p>

                <!-- Schritt-Indikator -->
                <div class="step-indicator">
                    <div class="step-dot active" data-step="1"><span>1</span></div>
                    <div class="step-line"></div>
                    <div class="step-dot" data-step="2"><span>2</span></div>
                    <div class="step-line"></div>
                    <div class="step-dot" data-step="3"><span>3</span></div>
                    <div class="step-line"></div>
                    <div class="step-dot" data-step="4"><span>4</span></div>
                </div>

                <!-- ⭐ FORMULAR MIT AJAX (kein action mehr) -->
                <form id="projectStartForm" class="project-form" method="post">
                    <?php wp_nonce_field('noirwerk_project_start', 'project_start_nonce'); ?>

                    <!-- Schritt 1: Projekt-Typ -->
                    <div class="form-step active" data-step="1">
                        <h3><?php _e('1. Was möchten Sie realisieren?', 'noirwerk'); ?></h3>
                        <div class="project-type-grid">
                            <?php
                            $types = array(
                                'website' => __('Website', 'noirwerk'),
                                'app' => __('App', 'noirwerk'),
                                'branding' => __('Branding', 'noirwerk'),
                                'motion' => __('Motion', 'noirwerk'),
                                'consulting' => __('Consulting', 'noirwerk')
                            );
                            foreach ($types as $value => $label) : ?>
                                <label class="type-option">
                                    <input type="radio" name="project_type" value="<?php echo esc_attr($value); ?>" required>
                                    <span><?php echo esc_html($label); ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="step-next btn btn--red"><?php _e('Weiter →', 'noirwerk'); ?></button>
                    </div>

                    <!-- Schritt 2: Budget -->
                    <div class="form-step" data-step="2">
                        <h3><?php _e('2. Welches Budget haben Sie?', 'noirwerk'); ?></h3>
                        <div class="budget-grid">
                            <?php
                            $budgets = array(
                                'under-10k' => __('< 10.000 €', 'noirwerk'),
                                '10-30k' => __('10.000 – 30.000 €', 'noirwerk'),
                                '30-50k' => __('30.000 – 50.000 €', 'noirwerk'),
                                'over-50k' => __('> 50.000 €', 'noirwerk')
                            );
                            foreach ($budgets as $value => $label) : ?>
                                <label class="budget-option">
                                    <input type="radio" name="budget" value="<?php echo esc_attr($value); ?>" required>
                                    <span><?php echo esc_html($label); ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <div class="step-nav">
                            <button type="button" class="step-prev btn">← <?php _e('Zurück', 'noirwerk'); ?></button>
                            <button type="button" class="step-next btn btn--red"><?php _e('Weiter →', 'noirwerk'); ?></button>
                        </div>
                    </div>

                    <!-- Schritt 3: Beschreibung -->
                    <div class="form-step" data-step="3">
                        <h3><?php _e('3. Beschreiben Sie Ihr Projekt', 'noirwerk'); ?></h3>
                        <textarea name="project_description" rows="5" placeholder="<?php esc_attr_e('Was möchten Sie erreichen? Welche Ziele verfolgen Sie?', 'noirwerk'); ?>" required></textarea>
                        <div class="step-nav">
                            <button type="button" class="step-prev btn">← <?php _e('Zurück', 'noirwerk'); ?></button>
                            <button type="button" class="step-next btn btn--red"><?php _e('Weiter →', 'noirwerk'); ?></button>
                        </div>
                    </div>


                    <!-- Schritt 4: Kontaktdaten -->
                    <div class="form-step" data-step="4">
                        <h3><?php _e('4. Ihre Kontaktdaten', 'noirwerk'); ?></h3>
                        <div class="form-group">
                            <label for="project-name"><?php _e('Name *', 'noirwerk'); ?></label>
                            <input type="text" id="project-name" name="name" placeholder="<?php esc_attr_e('Ihr vollständiger Name', 'noirwerk'); ?>" data-required>
                        </div>
                        <div class="form-group">
                            <label for="project-email"><?php _e('E-Mail *', 'noirwerk'); ?></label>
                            <input type="email" id="project-email" name="email" placeholder="<?php esc_attr_e('ihre@email.de', 'noirwerk'); ?>" data-required>
                        </div>
                        <div class="form-group">
                            <label for="project-phone"><?php _e('Telefon', 'noirwerk'); ?></label>
                            <input type="tel" id="project-phone" name="phone" placeholder="<?php esc_attr_e('+49 123 456789', 'noirwerk'); ?>" pattern="^[+]?[0-9\s\-]{5,20}$">
                            <small><?php _e('Optional – für Rückfragen', 'noirwerk'); ?></small>
                        </div>
                        <div class="step-nav">
                            <button type="button" class="step-prev btn">← <?php _e('Zurück', 'noirwerk'); ?></button>
                            <button type="submit" class="btn btn--red" id="projectSubmitBtn">
                                <?php _e('Anfrage senden →', 'noirwerk'); ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Rechte Spalte: Infos -->
            <div class="project-start__info" data-reveal>
                <h3><?php _e('Warum Noirwerk?', 'noirwerk'); ?></h3>
                <ul>
                    <li>✅ <?php _e('Individuelle Beratung', 'noirwerk'); ?></li>
                    <li>✅ <?php _e('Transparente Preisgestaltung', 'noirwerk'); ?></li>
                    <li>✅ <?php _e('Agile Entwicklung', 'noirwerk'); ?></li>
                    <li>✅ <?php _e('Langfristige Partnerschaft', 'noirwerk'); ?></li>
                </ul>
                <div class="project-start__contact">
                    <p><strong><?php _e('Direkter Kontakt', 'noirwerk'); ?></strong></p>
                    <p><a href="mailto:test090309a@gmail.com">hello@noirwerk.studio</a></p>
                    <p><?php _e('Lerchenfelderstrasse, Wien', 'noirwerk'); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ⭐ SUCCESS OVERLAY (Popup) -->
<div id="projectSuccessOverlay" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.92); z-index:9999; align-items:center; justify-content:center; backdrop-filter:blur(16px); animation:fadeIn 0.5s ease;">
    <div style="max-width:500px; padding:3rem 2rem; border:1px solid #D6001C; text-align:center; background:#000; border-radius:4px;">
        <h2 style="color:#D6001C;">✅ Projektanfrage gesendet</h2>
        <p style="color:var(--w80); margin:1.5rem 0;">Wir melden uns innerhalb von 24 Stunden.</p>
        <button onclick="document.getElementById('projectSuccessOverlay').style.display='none'" class="btn btn--red" style="cursor:pointer;">
            Weiter zum Theme →
        </button>
    </div>
</div>

<style>
    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: scale(0.95);
        }

        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    #projectSuccessOverlay.show {
        display: flex !important;
    }
</style>