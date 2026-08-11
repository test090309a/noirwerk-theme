 <?php
/**
 * Header Template Part
 */
?>

<header class="header" id="header" role="banner">
    <div class="container header__in">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo" aria-label="<?php bloginfo('name'); ?>">
            <?php 
            if (has_custom_logo()) {
                the_custom_logo();
            } else {
                echo '<span class="logo__text">NOIRWERK</span>';
            }
            ?>
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
                'fallback_cb' => 'noirwerk_fallback_menu',
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
        'fallback_cb' => 'noirwerk_fallback_menu',
    ));
    ?>
</nav>

<!-- Back to Top Button -->
<button class="back-top" id="backTop" aria-label="<?php esc_attr_e('Zurück nach oben', 'noirwerk'); ?>">
    <svg viewBox="0 0 24 24"><path d="M12 5v14M5 12l7-7 7 7"/></svg>
</button>