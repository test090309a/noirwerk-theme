<?php
/**
 * Template Name: Fullwidth
 * Template Post Type: page
 */

get_header(); ?>

<section class="fullwidth-page" id="main">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article <?php post_class('fullwidth__article'); ?>>
            <header class="fullwidth__header">
                <h1 class="fullwidth__title"><?php the_title(); ?></h1>
            </header>
            <div class="fullwidth__content">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; endif; ?>
</section>

<?php get_footer(); ?>