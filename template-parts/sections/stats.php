<?php
/**
 * Stats Section Template Part
 */
?>

<section class="stats" id="zahlen" aria-label="<?php _e('Kennzahlen', 'noirwerk'); ?>">
    <div class="container">
        <p class="eyebrow" data-reveal><b>05</b>&nbsp;— <?php _e('Zahlen', 'noirwerk'); ?></p>
        <div class="stats__grid">
            <?php
            $stats = array(
                array('value' => '87', 'suffix' => '+', 'label' => __('Projekte geliefert', 'noirwerk')),
                array('value' => '14', 'suffix' => '', 'label' => __('Internationale Awards', 'noirwerk')),
                array('value' => '12', 'suffix' => '', 'label' => __('Märkte & Zeitzonen', 'noirwerk')),
                array('value' => '99.9', 'suffix' => '%', 'label' => __('Uptime unserer Systeme', 'noirwerk'))
            );
            
            foreach ($stats as $stat) : ?>
                <div class="stat" data-reveal>
                    <div class="stat__val">
                        <span data-count="<?php echo esc_attr($stat['value']); ?>" <?php echo (strpos($stat['value'], '.') !== false) ? 'data-decimals="1"' : ''; ?>>
                            <?php echo esc_html($stat['value']); ?>
                        </span>
                        <?php if ($stat['suffix']) : ?>
                            <i><?php echo esc_html($stat['suffix']); ?></i>
                        <?php endif; ?>
                    </div>
                    <small><?php echo esc_html($stat['label']); ?></small>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>