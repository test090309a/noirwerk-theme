<?php
/**
 * Hero Template Part
 */
?>

<section class="hero" id="home" aria-label="<?php _e('Intro', 'noirwerk'); ?>">
    <div class="hero__media">
        <canvas id="rain" aria-hidden="true"></canvas>
        
        <video class="hero__video is-live" autoplay muted loop playsinline aria-hidden="true" tabindex="-1">
            <source src="<?php echo get_template_directory_uri(); ?>/assets/videos/hero.mp4" type="video/mp4">
        </video>
        
        <div class="hero__shade"></div>
    </div>
    
    <div class="hero__frame" aria-hidden="true">
        <span></span><span></span><span></span><span></span>
    </div>
    
    <div class="hero__content">
        <p class="hero__eyebrow">
            <span class="dot" aria-hidden="true"></span>
            <?php echo get_bloginfo('description'); ?>
        </p>
        
        <h1 class="hero__title">
            <?php 
            $title = get_bloginfo('name');
            $parts = explode(' ', $title);
            if (count($parts) >= 3) : ?>
                <span class="hero__line"><span><?php echo esc_html($parts[0]); ?>.</span></span>
                <span class="hero__line"><span><?php echo esc_html($parts[1]); ?>.</span></span>
                <span class="hero__line hero__line--ghost"><span><?php echo esc_html($parts[2]); ?><em>.</em></span></span>
            <?php else : ?>
                <span class="hero__line"><span><?php echo esc_html($title); ?></span></span>
            <?php endif; ?>
        </h1>
        
        <div class="hero__row">
            <p class="hero__sub"><?php echo get_bloginfo('description'); ?></p>
            <div class="hero__cta">
                <a href="<?php echo esc_url(home_url('/#kontakt')); ?>" class="btn btn--red" data-magnetic data-cursor="GO">
                    <?php _e('Projekt starten', 'noirwerk'); ?> <span class="arr">→</span>
                </a>
                <a href="<?php echo esc_url(home_url('/#projekte')); ?>" class="btn" data-magnetic data-cursor="SEHEN">
                    <?php _e('Arbeit ansehen', 'noirwerk'); ?>
                </a>
            </div>
        </div>
    </div>
    
    <div class="hero__meta" aria-hidden="true">
        <b>Sector 07</b> — Neon District<br>
        35.6762° N / 139.6503° O<br>
        <?php _e('Local Time', 'noirwerk'); ?> <b id="clockHero">--:--:--</b>
    </div>
    
    <div class="hero__scroll" aria-hidden="true">
        <small><?php _e('Scroll', 'noirwerk'); ?></small><i></i>
    </div>
</section>