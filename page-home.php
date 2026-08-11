<?php
/**
 * Template Name: Startseite
 * Template Post Type: page
 */

get_header(); ?>

<!-- Hero Section -->
<section class="hero" id="home" aria-label="Intro">
    <div class="hero__media">
        <canvas id="rain" aria-hidden="true"></canvas>
        <video class="hero__video is-live" autoplay muted loop playsinline aria-hidden="true" tabindex="-1">
            <source src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/videos/hero.mp4" type="video/mp4">
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

<!-- Marquee -->
<div class="marquee" aria-hidden="true">
    <div class="marquee__track">
        <span>Interfaces<i></i>Markensysteme<i></i>Creative Engineering<i></i>Realtime 3D<i></i>Motion<i></i>Strategie<i></i></span>
        <span>Interfaces<i></i>Markensysteme<i></i>Creative Engineering<i></i>Realtime 3D<i></i>Motion<i></i>Strategie<i></i></span>
    </div>
</div>

<!-- Services -->
<section id="services" aria-label="<?php _e('Leistungen', 'noirwerk'); ?>">
    <div class="container">
        <div class="sec-head">
            <p class="eyebrow" data-reveal style="margin:0"><b>02</b>&nbsp;— <?php _e('Services', 'noirwerk'); ?></p>
            <p class="num" data-reveal>[ 4 <?php _e('DISZIPLINEN', 'noirwerk'); ?> ]</p>
        </div>
        <div class="srv-grid">
            <?php
            $services = array(
                array('num' => '01', 'title' => __('Digital Products', 'noirwerk'), 'desc' => __('Plattformen und Produkte von der ersten Architektur bis zum hundertsten Release.', 'noirwerk'), 'tags' => array(__('Plattform', 'noirwerk'), __('SaaS', 'noirwerk'), __('Architektur', 'noirwerk'))),
                array('num' => '02', 'title' => __('Interface & Identity', 'noirwerk'), 'desc' => __('Designsysteme, die wie Hardware wirken: kantig, klar, konsistent.', 'noirwerk'), 'tags' => array(__('Designsystem', 'noirwerk'), __('UI', 'noirwerk'), __('Brand', 'noirwerk'))),
                array('num' => '03', 'title' => __('Creative Engineering', 'noirwerk'), 'desc' => __('WebGL, Canvas, Shader, Echtzeit. Wenn die Idee eine Engine braucht, bauen wir die Engine.', 'noirwerk'), 'tags' => array(__('WebGL', 'noirwerk'), __('Shader', 'noirwerk'), __('Prototyp', 'noirwerk'))),
                array('num' => '04', 'title' => __('Motion & Realtime', 'noirwerk'), 'desc' => __('Bewegung als Sprache: Choreografie für Marken, Launch-Filme, interaktive 3D-Welten.', 'noirwerk'), 'tags' => array(__('Motion', 'noirwerk'), __('3D', 'noirwerk'), __('Launch', 'noirwerk')))
            );
            foreach ($services as $service) : ?>
                <article class="srv" data-reveal>
                    <div class="srv__top"><span class="srv__num">/ <?php echo esc_html($service['num']); ?></span></div>
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

<!-- Blog Posts -->
<section id="projekte" aria-label="<?php _e('Neueste Beiträge', 'noirwerk'); ?>">
    <div class="container">
        <div class="sec-head">
            <p class="eyebrow" data-reveal style="margin:0"><b>03</b>&nbsp;— <?php _e('Neueste Beiträge', 'noirwerk'); ?></p>
            <p class="num" data-reveal>[ <?php echo wp_count_posts()->publish; ?> ]</p>
        </div>
        <div class="post-grid">
            <?php 
            $posts = new WP_Query(array('posts_per_page' => 6));
            if ($posts->have_posts()) : while ($posts->have_posts()) : $posts->the_post(); ?>
                <article class="post-panel" data-cursor="LESEN">
                    <div class="panel__bar">
                        <div>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <small><?php echo get_the_date(); ?></small>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="panel__go"><?php _e('Lesen →', 'noirwerk'); ?></a>
                    </div>
                </article>
            <?php endwhile; wp_reset_postdata(); endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>