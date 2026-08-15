<?php
/**
 * Kommentare Template für Noirwerk
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            if (1 === $comments_number) {
                printf(__('Ein Kommentar', 'noirwerk'));
            } else {
                printf(__('%s Kommentare', 'noirwerk'), number_format_i18n($comments_number));
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style' => 'ol',
                'short_ping' => true,
                'avatar_size' => 48,
                'callback' => function($comment, $args, $depth) {
                    ?>
                    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                        <article id="comment-<?php comment_ID(); ?>" class="comment-body">
                            <footer class="comment-meta">
                                <div class="comment-author vcard">
                                    <?php echo get_avatar($comment, 48); ?>
                                    <?php printf(__('%s', 'noirwerk'), get_comment_author_link()); ?>
                                </div>
                                <div class="comment-metadata">
                                    <time datetime="<?php comment_time('c'); ?>">
                                        <?php comment_date(); ?> um <?php comment_time(); ?>
                                    </time>
                                </div>
                            </footer>

                            <div class="comment-content">
                                <?php comment_text(); ?>
                            </div>

                            <div class="comment-reply">
                                <?php
                                comment_reply_link(array_merge($args, array(
                                    'depth' => $depth,
                                    'max_depth' => $args['max_depth'],
                                    'reply_text' => __('Antworten', 'noirwerk'),
                                )));
                                ?>
                            </div>
                        </article>
                    </li>
                    <?php
                }
            ));
            ?>
        </ol>

        <?php the_comments_pagination(array(
            'prev_text' => '← ' . __('Vorherige', 'noirwerk'),
            'next_text' => __('Nächste', 'noirwerk') . ' →',
        )); ?>

    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments"><?php _e('Kommentare sind geschlossen.', 'noirwerk'); ?></p>
    <?php endif; ?>

    <?php
    comment_form(array(
        'title_reply' => __('Schreibe einen Kommentar', 'noirwerk'),
        'title_reply_to' => __('Antworten auf %s', 'noirwerk'),
        'cancel_reply_link' => __('Abbrechen', 'noirwerk'),
        'label_submit' => __('Kommentar absenden', 'noirwerk'),
        'class_submit' => 'btn btn--red',
    ));
    ?>
</div>