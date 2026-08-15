<?php

/**
 * Process Sektion – 5 Steps mit GSAP Animation
 */
?><section id="prozess" aria-label="<?php _e('Prozess', 'noirwerk'); ?>">
    <div class="container">
        <p class="eyebrow" data-reveal><b>04</b>&nbsp;— <?php _e('Prozess', 'noirwerk'); ?></p>

        <!-- Horizontal Progress Line (Rail) -->
        <div class="process__rail">
            <span><?php _e('+ 12 Monate', 'noirwerk'); ?></span>
            <div class="process__line"></div>
        </div>
        <h2 data-split style="margin-bottom:clamp(3rem,7vh,5rem)">
            <?php _e('Fünf Schritte.', 'noirwerk'); ?><br>
            <?php _e("Null Umwege.", 'noirwerk'); ?>
        </h2>
        <div class="steps-wrapper">
            <?php
            $steps = array(
                array(
                    'num'  => 'PHASE 01',
                    'title' => __('Analyse', 'noirwerk'),
                    'desc'  => __(
                        'Wir zerlegen das&nbsp;Problem, bevor wir es gestalten. ' .
                            'Systemlandkarten, Lastprofile, Nutzerrealität — die Grundlage für jede Entscheidung danach.',
                        'noirwerk'
                    ),
                ),
                array(
                    'num'  => 'PHASE 02',
                    'title' => __('Konzept', 'noirwerk'),
                    'desc'  => __(
                        'Informationsarchitektur und Flow zuerst. Ein Konzept, das auf Papier nicht funktioniert, überlebt keine Produktion.',
                        'noirwerk'
                    ),
                ),
                array(
                    'num'  => 'PHASE 03',
                    'title' => __('Design', 'noirwerk'),
                    'desc'  => __(
                        'High-Fidelity-Systeme in Echtzeit gebaut, nicht in Mockups versprochen. ' .
                            'Typografie, Grid, Motion — als eine Entscheidung.',
                        'noirwerk'
                    ),
                ),
                array(
                    'num'  => 'PHASE 04',
                    'title' => __('Engineering', 'noirwerk'),
                    'desc'  => __(
                        'Performanter, wartbarer Code als Designfortsetzung mit anderen Mitteln. ' .
                            'GPU-beschleunigt, barrierearm, dokumentiert.',
                        'noirwerk'
                    ),
                ),
                array(
                    'num'  => 'PHASE 05',
                    'title' => __('Launch & Orbit', 'noirwerk'),
                    'desc'  => __(
                        'Release ist der Anfang. Monitoring, Iteration und Pflege halten das System lebendig — lange nach dem Launch-Film.',
                        'noirwerk'
                    ),
                )
            );
            foreach ($steps as $idx => $step) : ?>
                <div class="step-wrapper" data-reveal>
                    <article style="padding:clamp(1rem,2vw,4rem)">
                        <!-- GSAP Reveal Trigger -->
                        <span data-reveal><b><?php echo esc_html($step['num']); ?></b></span> <!-- GSAP Reveal Text (opacity:30 + translate 8 px!) -->
                        <h2 data-split style="margin-bottom:clamp(1rem,3vw,2rem)">
                            <?php echo esc_html($step['title']); ?>
                        </h2>

                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<style>
    /* Step-wrapper container (margin: -8px 0) für GSAP */

    .step-wrapper {
        position: relative;
    }

    /* Horizontal Line + Rail Positionierung (innerhalb des Step-Containers) */
    /* Rail-Container mit progress-line: width 35%+1,9rem → horizontal Linie relativ zur Rail */
    .step-wrapper {
        margin-top: -8px;
    }
</style>
<script>
    // GSAP Counter & SplitText sind hier integriert! 🚀🎉✅
</script>