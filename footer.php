</main>

<!-- Footer -->
<footer role="contentinfo">
    <div class="container">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="foot__word"><?php bloginfo('name'); ?></a>
        
        <div class="foot__grid">
            <div>
                <small><?php _e('Manifest', 'noirwerk'); ?></small>
                <p style="max-width:30ch;color:var(--w60);font-size:.8rem;font-weight:300">
                    <?php _e('Systeme aus Licht und Logik. Gebaut in Wien, getestet gegen die Nacht.', 'noirwerk'); ?>
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
            <span>© <?php echo date('Y'); ?> <?php bloginfo('name'); ?> — <?php _e('Wien', 'noirwerk'); ?></span>
            <span class="status">
                <i aria-hidden="true"></i>
                <?php _e('System online', 'noirwerk'); ?>
            </span>
            <span><?php _e('Local Time', 'noirwerk'); ?> <b id="clockFoot" style="color:var(--white);font-weight:500">--:--:--</b></span>
        </div>
    </div>
</footer>

<!-- ============ SECRET ARCADE OVERLAY (DOOM) ============ -->
<div class="doom" id="doom" role="dialog" aria-modal="true" aria-label="Geheimes Terminal" aria-hidden="true">
    <div class="doom__shell" id="doomShell">
        <canvas id="doomCanvas" width="320" height="200"></canvas>
        <div class="doom__boot" id="doomBoot"><pre id="doomBootTxt"></pre></div>
        <div class="doom__scan" aria-hidden="true"></div>
        <div class="doom__flicker" aria-hidden="true"></div>
        <div class="doom__vig" aria-hidden="true"></div>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html> 