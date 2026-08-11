<?php get_header(); ?>

<!-- Hero Section -->
<section class="hero" id="home" aria-label="<?php _e('Intro', 'noirwerk'); ?>">
    <div class="hero__media">
        <canvas id="rain" aria-hidden="true"></canvas>
        <?php if (has_post_thumbnail()) : ?>
            <video class="hero__video is-live" autoplay muted loop playsinline aria-hidden="true" tabindex="-1">
                <source src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/videos/hero.mp4" type="video/mp4">
            </video>
        <?php endif; ?>
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
                <span class="hero__line"><span><?php echo $parts[0]; ?>.</span></span>
                <span class="hero__line"><span><?php echo $parts[1]; ?>.</span></span>
                <span class="hero__line hero__line--ghost"><span><?php echo $parts[2]; ?><em>.</em></span></span>
            <?php else : ?>
                <span class="hero__line"><span><?php echo $title; ?></span></span>
            <?php endif; ?>
        </h1>
        <div class="hero__row">
            <p class="hero__sub"><?php echo get_bloginfo('description'); ?></p>
            <div class="hero__cta">
                <a href="#kontakt" class="btn btn--red" data-magnetic data-cursor="GO">
                    <?php _e('Projekt starten', 'noirwerk'); ?> <span class="arr">→</span>
                </a>
                <a href="#projekte" class="btn" data-magnetic data-cursor="SEHEN">
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

<!-- Marquee -->
<div class="marquee" aria-hidden="true">
    <div class="marquee__track">
        <span>
            <?php _e('Interfaces', 'noirwerk'); ?><i></i>
            <?php _e('Markensysteme', 'noirwerk'); ?><i></i>
            <?php _e('Creative Engineering', 'noirwerk'); ?><i></i>
            <?php _e('Realtime 3D', 'noirwerk'); ?><i></i>
            <?php _e('Motion', 'noirwerk'); ?><i></i>
            <?php _e('Strategie', 'noirwerk'); ?><i></i>
        </span>
        <span>
            <?php _e('Interfaces', 'noirwerk'); ?><i></i>
            <?php _e('Markensysteme', 'noirwerk'); ?><i></i>
            <?php _e('Creative Engineering', 'noirwerk'); ?><i></i>
            <?php _e('Realtime 3D', 'noirwerk'); ?><i></i>
            <?php _e('Motion', 'noirwerk'); ?><i></i>
            <?php _e('Strategie', 'noirwerk'); ?><i></i>
        </span>
    </div>
</div>

<!-- Blog Posts Loop -->
<section id="projekte" aria-label="<?php _e('Neueste Beiträge', 'noirwerk'); ?>">
    <div class="container">
        <div class="sec-head">
            <p class="eyebrow" data-reveal style="margin:0">
                <b>03</b>&nbsp;— <?php _e('Neueste Beiträge', 'noirwerk'); ?>
            </p>
            <p class="num" data-reveal>[ <?php echo wp_count_posts()->publish; ?> ]</p>
        </div>
        
        <div class="post-grid">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article class="post-panel" data-cursor="<?php _e('LESEN', 'noirwerk'); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="panel__img">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="panel__bar">
                        <div>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <small><?php echo get_the_date(); ?></small>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="panel__go">
                            <?php _e('Lesen →', 'noirwerk'); ?>
                        </a>
                    </div>
                </article>
            <?php endwhile; 
                the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => __('←', 'noirwerk'),
                    'next_text' => __('→', 'noirwerk'),
                ));
            endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?> 