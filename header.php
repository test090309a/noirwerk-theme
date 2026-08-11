 <!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#000000">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Skip to content link für Barrierefreiheit -->
<a class="skip-link" href="#main"><?php _e('Zum Inhalt springen', 'noirwerk'); ?></a>

<!-- Noise Overlay -->
<div class="noise" aria-hidden="true"></div>

<!-- Progress Bar -->
<div class="progress" id="progress" aria-hidden="true"></div>

<!-- Custom Cursor -->
<div class="cur-dot" id="curDot" aria-hidden="true"></div>
<div class="cur-ring" id="curRing" aria-hidden="true"></div>
<div class="cur-label" id="curLabel" aria-hidden="true"></div>
<div class="glow" id="glow" aria-hidden="true"></div>

<!-- Header -->
<header class="header" id="header" role="banner">
    <div class="container header__in">
<a href="<?php echo esc_url(home_url('/')); ?>" class="logo" aria-label="<?php bloginfo('name'); ?>">
    <span class="logo__text"><?php bloginfo('name'); ?></span>
    <small><?php echo date('Y'); ?></small>
</a>
        
        <nav class="nav" aria-label="<?php esc_attr_e('Hauptnavigation', 'noirwerk'); ?>">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => 'nav__list',
                'items_wrap' => '%3$s',
                'depth' => 1,
                'fallback_cb' => false,
            ));
            ?>
        </nav>
        
        <button class="burger" id="menuBtn" aria-label="<?php esc_attr_e('Menü öffnen', 'noirwerk'); ?>" aria-expanded="false" aria-controls="mnav">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>

<!-- Mobile Navigation -->
<nav class="mnav" id="mnav" aria-label="<?php esc_attr_e('Mobile Navigation', 'noirwerk'); ?>">
    <?php
    wp_nav_menu(array(
        'theme_location' => 'primary',
        'container' => false,
        'menu_class' => 'mnav__list',
        'depth' => 1,
        'fallback_cb' => false,
    ));
    ?>
</nav>

<!-- Back to Top Button -->
<button class="back-top" id="backTop" aria-label="<?php esc_attr_e('Zurück nach oben', 'noirwerk'); ?>">
    <svg viewBox="0 0 24 24"><path d="M12 5v14M5 12l7-7 7 7"/></svg>
</button>

<!-- Project Overlay -->
<div class="project-overlay" id="projectOverlay" role="dialog" aria-modal="true">
    <div class="project-overlay__content">
        <button class="project-overlay__close" id="projectOverlayClose" aria-label="<?php esc_attr_e('Schließen', 'noirwerk'); ?>">✕</button>
        <span class="project-overlay__num" id="projectOverlayNum">01</span>
        <h2 id="projectOverlayTitle"><?php _e('Projekt', 'noirwerk'); ?></h2>
        <div class="project-overlay__meta">
            <span id="projectOverlayYear">2026</span>
            <span id="projectOverlayCategory"><?php _e('Kategorie', 'noirwerk'); ?></span>
        </div>
        <p class="project-overlay__desc" id="projectOverlayDesc"></p>
        <div class="project-overlay__tags" id="projectOverlayTags"></div>
        <div class="project-overlay__cta">
            <a href="#kontakt" class="btn btn--red" data-magnetic data-cursor="<?php esc_attr_e('PROJEKT', 'noirwerk'); ?>">
                <?php _e('Projekt besprechen', 'noirwerk'); ?> <span class="arr">→</span>
            </a>
        </div>
    </div>
</div>

<main id="main">