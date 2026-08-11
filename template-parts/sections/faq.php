<?php
/**
 * FAQ Section Template Part
 */
?>

<section id="faq" aria-label="<?php _e('Häufige Fragen', 'noirwerk'); ?>">
    <div class="container">
        <p class="eyebrow" data-reveal><b>07</b>&nbsp;— <?php _e('FAQ', 'noirwerk'); ?></p>
        <h2 data-split style="margin-bottom:clamp(2.5rem,6vh,4rem)">
            <?php _e('Bevor Sie fragen.', 'noirwerk'); ?>
        </h2>
        
        <div class="faq" data-reveal>
            <?php
            $faqs = array(
                array(
                    'q' => __('Wie startet eine Zusammenarbeit?', 'noirwerk'),
                    'a' => __('Mit einem 45-minütigen Systemgespräch. Danach erhalten Sie innerhalb von fünf Werktagen eine Einschätzung: Scope, Team, Zeitrahmen, Budgetkorridor. Kein Pitch-Theater.', 'noirwerk')
                ),
                array(
                    'q' => __('Welche Budgetgröße ist üblich?', 'noirwerk'),
                    'a' => __('Produkt- und Markensysteme starten bei uns ab 40 T€. Realtime- und WebGL-Projekte werden individuell kalkuliert — abhängig von Komplexität, nicht von Folien.', 'noirwerk')
                ),
                array(
                    'q' => __('Wie lange dauert ein Projekt?', 'noirwerk'),
                    'a' => __('Fokussierte Systeme: 6–10 Wochen. Umfassende Plattformen: 3–6 Monate. Wir arbeiten in sichtbaren Zwei-Wochen-Zyklen — Sie sehen Fortschritt, nicht Versprechen.', 'noirwerk')
                ),
                array(
                    'q' => __('Welchen Stack setzen Sie ein?', 'noirwerk'),
                    'a' => __('Modern und bewusst reduziert: semantisches HTML, modernes CSS, Vanilla JS/TypeScript, GSAP, WebGL wo sinnvoll. Kein Framework-Ballast, keine Lock-ins, volle Übergabe.', 'noirwerk')
                ),
                array(
                    'q' => __('Betreuen Sie auch nach dem Launch?', 'noirwerk'),
                    'a' => __('Ja — in Orbit-Retainern: Monitoring, Performance-Pflege, iterative Weiterentwicklung. Systeme altern nicht, wenn man sie wartet.', 'noirwerk')
                )
            );
            
            foreach ($faqs as $index => $faq) : ?>
                <div class="faq__item">
                    <button class="faq__btn" aria-expanded="false">
                        <h3>
                            <small>Q<?php echo $index + 1; ?></small>
                            <?php echo esc_html($faq['q']); ?>
                        </h3>
                        <span class="faq__icon" aria-hidden="true"></span>
                    </button>
                    <div class="faq__panel">
                        <p><?php echo esc_html($faq['a']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>