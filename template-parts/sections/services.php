<?php
/**
 * Services Section Template Part
 */
?>

<section id="services" aria-label="<?php _e('Leistungen', 'noirwerk'); ?>">
    <div class="container">
        <div class="sec-head">
            <p class="eyebrow" data-reveal style="margin:0">
                <b>02</b>&nbsp;— <?php _e('Services', 'noirwerk'); ?>
            </p>
            <p class="num" data-reveal>[ 4 <?php _e('DISZIPLINEN', 'noirwerk'); ?> ]</p>
        </div>
        
        <div class="srv-grid">
            <?php
            $services = array(
                array(
                    'num' => '01',
                    'title' => __('Digital Products', 'noirwerk'),
                    'desc' => __('Plattformen und Produkte von der ersten Architektur bis zum hundertsten Release. Gebaut für Skalierung, gemacht für Menschen.', 'noirwerk'),
                    'tags' => array(__('Plattform', 'noirwerk'), __('SaaS', 'noirwerk'), __('Architektur', 'noirwerk')),
                    'icon' => 'rect'
                ),
                array(
                    'num' => '02',
                    'title' => __('Interface & Identity', 'noirwerk'),
                    'desc' => __('Designsysteme, die wie Hardware wirken: kantig, klar, konsistent. Jede Komponente ein präzises Werkzeug.', 'noirwerk'),
                    'tags' => array(__('Designsystem', 'noirwerk'), __('UI', 'noirwerk'), __('Brand', 'noirwerk')),
                    'icon' => 'circle'
                ),
                array(
                    'num' => '03',
                    'title' => __('Creative Engineering', 'noirwerk'),
                    'desc' => __('WebGL, Canvas, Shader, Echtzeit. Wenn die Idee eine Engine braucht, bauen wir die Engine — performant und wartbar.', 'noirwerk'),
                    'tags' => array(__('WebGL', 'noirwerk'), __('Shader', 'noirwerk'), __('Prototyp', 'noirwerk')),
                    'icon' => 'triangle'
                ),
                array(
                    'num' => '04',
                    'title' => __('Motion & Realtime', 'noirwerk'),
                    'desc' => __('Bewegung als Sprache: Choreografie für Marken, Launch-Filme, interaktive 3D-Welten mit cineastischem Timing.', 'noirwerk'),
                    'tags' => array(__('Motion', 'noirwerk'), __('3D', 'noirwerk'), __('Launch', 'noirwerk')),
                    'icon' => 'wave'
                )
            );
            
            foreach ($services as $service) : ?>
                <article class="srv" data-reveal>
                    <div class="srv__top">
                        <span class="srv__num">/ <?php echo esc_html($service['num']); ?></span>
                        <span class="srv__ico" aria-hidden="true">
                            <?php echo noirwerk_get_icon($service['icon']); ?>
                        </span>
                    </div>
                    <div>
                        <h3><?php echo esc_html($service['title']); ?></h3>
                        <p><?php echo esc_html($service['desc']); ?></p>
                        <ul class="srv__tags">
                            <?php foreach ($service['tags'] as $tag) : ?>
                                <li><?php echo esc_html($tag); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section> 