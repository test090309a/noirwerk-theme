 <?php get_header(); ?>

<section class="error-404" id="main">
    <div class="container">
        <div class="error-404__content">
            <span class="error-404__code">404</span>
            <h1 class="error-404__title"><?php _e('Seite nicht gefunden', 'noirwerk'); ?></h1>
            <p class="error-404__desc">
                <?php _e('Die von Ihnen angeforderte Seite existiert nicht oder wurde verschoben.', 'noirwerk'); ?>
            </p>
            <div class="error-404__actions">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--red">
                    <?php _e('Zurück zur Startseite', 'noirwerk'); ?> <span class="arr">→</span>
                </a>
                <a href="javascript:history.back()" class="btn">
                    <?php _e('Zurück', 'noirwerk'); ?>
                </a>
            </div>
            
            <!-- Suche -->
            <div class="error-404__search">
                <p><?php _e('Oder suchen Sie hier:', 'noirwerk'); ?></p>
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>