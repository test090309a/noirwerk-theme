<?php
/**
 * Process Section Template Part
 */
?>

<section id="prozess" aria-label="<?php _e('Prozess', 'noirwerk'); ?>">
    <div class="container">
        <p class="eyebrow" data-reveal><b>04</b>&nbsp;— <?php _e('Prozess', 'noirwerk'); ?></p>
        <h2 data-split style="margin-bottom:clamp(3rem,7vh,5rem)">
            <?php _e('Fünf Schritte.', 'noirwerk'); ?><br>
            <?php _e('Null Umwege.', 'noirwerk'); ?>
        </h2>
        
        <div class="process__wrap">
            <div class="process__rail" aria-hidden="true">
                <div class="process__fill" id="procFill"></div>
            </div>
            
            <?php
            $steps = array(
                array(
                    'num' => 'PHASE 01',
                    'title' => __('Analyse', 'noirwerk'),
                    'desc' => __('Wir zerlegen das Problem, bevor wir es gestalten. Systemlandkarten, Lastprofile, Nutzerrealität — die Grundlage für jede Entscheidung danach.', 'noirwerk')
                ),
                array(
                    'num' => 'PHASE 02',
                    'title' => __('Konzept', 'noirwerk'),
                    'desc' => __('Informationsarchitektur und Flow zuerst. Ein Konzept, das auf Papier nicht funktioniert, überlebt keine Produktion.', 'noirwerk')
                ),
                array(
                    'num' => 'PHASE 03',
                    'title' => __('Design', 'noirwerk'),
                    'desc' => __('High-Fidelity-Systeme in Echtzeit gebaut, nicht in Mockups versprochen. Typografie, Grid, Motion — als eine Entscheidung.', 'noirwerk')
                ),
                array(
                    'num' => 'PHASE 04',
                    'title' => __('Engineering', 'noirwerk'),
                    'desc' => __('Performanter, wartbarer Code als Designfortsetzung mit anderen Mitteln. GPU-beschleunigt, barrierearm, dokumentiert.', 'noirwerk')
                ),
                array(
                    'num' => 'PHASE 05',
                    'title' => __('Launch & Orbit', 'noirwerk'),
                    'desc' => __('Release ist der Anfang. Monitoring, Iteration und Pflege halten das System lebendig — lange nach dem Launch-Film.', 'noirwerk')
                )
            );
            
            foreach ($steps as $step) : ?>
                <div class="step">
                    <span class="step__num"><?php echo esc_html($step['num']); ?></span>
                    <div>
                        <h3><?php echo esc_html($step['title']); ?></h3>
                        <p><?php echo esc_html($step['desc']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section> 