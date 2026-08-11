 <?php get_header(); ?>

<!-- Page -->
<section class="page-section" id="main">
    <div class="container">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            
            <article <?php post_class('page__article'); ?>>
                <!-- Seitenheader -->
                <header class="page__header">
                    <h1 class="page__title"><?php the_title(); ?></h1>
                    <?php if (has_excerpt()) : ?>
                        <p class="page__excerpt"><?php echo get_the_excerpt(); ?></p>
                    <?php endif; ?>
                </header>
                
                <!-- Seitenbild -->
                <?php if (has_post_thumbnail()) : ?>
                    <div class="page__featured">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>
                
                <!-- Seiteninhalt -->
                <div class="page__content">
                    <?php the_content(); ?>
                </div>
                
            </article>
            
        <?php endwhile; endif; ?>
    </div>
</section>

<?php get_footer(); ?>