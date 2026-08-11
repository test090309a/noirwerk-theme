<?php
/**
 * Content Template Part (für Blog-Archiv)
 */
?>

<article <?php post_class('post-panel'); ?> data-cursor="<?php _e('LESEN', 'noirwerk'); ?>">
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