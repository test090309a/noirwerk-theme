 <?php get_header(); ?>

<section class="archive-section" id="main">
    <div class="container">
        <!-- Archiv-Header -->
        <div class="archive-header">
            <h1 class="archive-title">
                <?php
                if (is_category()) {
                    single_cat_title();
                } elseif (is_tag()) {
                    single_tag_title();
                } elseif (is_author()) {
                    echo 'Beiträge von ' . get_the_author();
                } elseif (is_date()) {
                    echo get_the_date('F Y');
                } else {
                    _e('Archiv', 'noirwerk');
                }
                ?>
            </h1>
            <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
        </div>

        <!-- Beiträge -->
        <?php if (have_posts()) : ?>
            <div class="post-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article class="post-panel" data-cursor="LESEN">
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
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <?php
                echo paginate_links(array(
                    'prev_text' => '←',
                    'next_text' => '→',
                    'mid_size' => 2,
                ));
                ?>
            </div>

        <?php else : ?>
            <p class="no-posts"><?php _e('Keine Beiträge gefunden.', 'noirwerk'); ?></p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>