<<<<<<< HEAD
<?php
=======
 <?php
>>>>>>> 2b7244c884dc4bb8a55445380d5fba8d39eb66f4
/**
 * Footer Template Part
 */
?>

<footer role="contentinfo">
    <div class="container">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="foot__word">
            <?php bloginfo('name'); ?>
        </a>
        
        <div class="foot__grid">
<<<<<<< HEAD
            <!-- WIDGET BEREICHE -->
            <div class="foot__widgets">
                <?php if (is_active_sidebar('footer-1')) : ?>
                    <div class="footer-widget-area">
                        <?php dynamic_sidebar('footer-1'); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (is_active_sidebar('footer-2')) : ?>
                    <div class="footer-widget-area">
                        <?php dynamic_sidebar('footer-2'); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (is_active_sidebar('footer-3')) : ?>
                    <div class="footer-widget-area">
                        <?php dynamic_sidebar('footer-3'); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (is_active_sidebar('footer-4')) : ?>
                    <div class="footer-widget-area">
                        <?php dynamic_sidebar('footer-4'); ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="foot__manifest">
                <small><?php _e('Manifest', 'noirwerk'); ?></small>
                <p><?php echo esc_html(get_theme_mod('noirwerk_footer_text', __('Systeme aus Licht und Logik.', 'noirwerk'))); ?></p>
=======
            <div class="foot__manifest">
                <small><?php _e('Manifest', 'noirwerk'); ?></small>
                <p><?php echo get_theme_mod('noirwerk_footer_text', __('Systeme aus Licht und Logik. Gebaut in Berlin, getestet gegen die Nacht.', 'noirwerk')); ?></p>
>>>>>>> 2b7244c884dc4bb8a55445380d5fba8d39eb66f4
            </div>
            
            <div class="foot__menu">
                <small><?php _e('Menü', 'noirwerk'); ?></small>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'container' => false,
                    'menu_class' => 'footer-menu',
                    'depth' => 1,
                    'fallback_cb' => false,
                ));
                ?>
            </div>
            
            <div class="foot__social">
                <small><?php _e('Social', 'noirwerk'); ?></small>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'social',
                    'container' => false,
                    'menu_class' => 'social-menu',
                    'depth' => 1,
                    'fallback_cb' => false,
                ));
                ?>
            </div>
            
            <div class="foot__legal">
                <small><?php _e('Rechtliches', 'noirwerk'); ?></small>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'legal',
                    'container' => false,
                    'menu_class' => 'legal-menu',
                    'depth' => 1,
                    'fallback_cb' => false,
                ));
                ?>
            </div>
        </div>
        
        <div class="foot__bottom">
            <span>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?> — <?php _e('Berlin', 'noirwerk'); ?></span>
            <span class="status">
                <i aria-hidden="true"></i>
                <?php _e('System online', 'noirwerk'); ?>
            </span>
            <span><?php _e('Local Time', 'noirwerk'); ?> <b id="clockFoot" style="color:var(--white);font-weight:500">--:--:--</b></span>
        </div>
    </div>
</footer>