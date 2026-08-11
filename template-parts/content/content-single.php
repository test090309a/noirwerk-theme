<?php
/**
 * Single Content Template Part
 */
?>

<article <?php post_class('single-post'); ?>>
    <div class="container">
        <div class="single-post__header">
            <div class="single-post__meta">
                <span class="single-post__date"><?php echo get_the_date(); ?></span>
                <span class="single-post__category"><?php the_category(', '); ?></span>
            </div>
            <h1 class="single-post__title"><?php the_title(); ?></h1>
            <?php if (has_excerpt()) : ?>
                <p class="single-post__excerpt"><?php echo get_the_excerpt(); ?></p>
            <?php endif; ?>
        </div>
        
        <?php if (has_post_thumbnail()) : ?>
            <div class="single-post__featured">
                <?php the_post_thumbnail('large'); ?>
            </div>
        <?php endif; ?>
        
        <div class="single-post__content">
            <?php the_content(); ?>
        </div>
        
        <div class="single-post__footer">
            <div class="single-post__tags">
                <?php the_tags('<span>', '</span><span>', '</span>'); ?>
            </div>
            
            <nav class="single-post__nav">
                <div class="nav-previous"><?php previous_post_link('%link', '? %title'); ?></div>
                <div class="nav-next"><?php next_post_link('%link', '%title ?'); ?></div>
            </nav>
        </div>
        
        <?php if (comments_open() || get_comments_number()) : ?>
            <div class="single-post__comments">
                <?php comments_template(); ?>
            </div>
        <?php endif; ?>
    </div>
</article>