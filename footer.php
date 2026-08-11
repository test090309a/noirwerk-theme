</main>

<!-- Footer -->
<footer role="contentinfo">
    <div class="container">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="foot__word"><?php bloginfo('name'); ?></a>
        
        <div class="foot__grid">
            <div>
                <small><?php _e('Manifest', 'noirwerk'); ?></small>
                <p style="max-width:30ch;color:var(--w60);font-size:.8rem;font-weight:300">
                    <?php _e('Systeme aus Licht und Logik. Gebaut in Berlin, getestet gegen die Nacht.', 'noirwerk'); ?>
                </p>
            </div>
            
            <div>
                <small><?php _e('Menü', 'noirwerk'); ?></small>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'container' => false,
                    'menu_class' => 'footer-menu',
                    'depth' => 1,
                ));
                ?>
            </div>
            
            <div>
                <small><?php _e('Social', 'noirwerk'); ?></small>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'social',
                    'container' => false,
                    'menu_class' => 'social-menu',
                    'depth' => 1,
                ));
                ?>
            </div>
            
            <div>
                <small><?php _e('Rechtliches', 'noirwerk'); ?></small>
                <?php wp_nav_menu(array('theme_location' => 'legal')); ?>
            </div>
        </div>
        
        <div class="foot__bottom">
            <span>© <?php echo date('Y'); ?> <?php bloginfo('name'); ?> — <?php _e('Berlin', 'noirwerk'); ?></span>
            <span class="status">
                <i aria-hidden="true"></i>
                <?php _e('System online', 'noirwerk'); ?>
            </span>
            <span><?php _e('Local Time', 'noirwerk'); ?> <b id="clockFoot" style="color:var(--white);font-weight:500">--:--:--</b></span>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html> 