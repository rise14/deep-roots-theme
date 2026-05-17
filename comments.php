<?php
/**
 * Comments template.
 *
 * @package Skeleton_WP
 */

if ( post_password_required() ) return;
?>

<div id="comments" class="comments-area">

    <?php if ( have_comments() ) : ?>

        <h2 class="comments-title">
            <?php
            $count = get_comments_number();
            if ( '1' === $count ) {
                printf( esc_html__( 'One thought on &ldquo;%s&rdquo;', 'skeleton-wp' ), get_the_title() );
            } else {
                printf(
                    esc_html( _n( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $count, 'skeleton-wp' ) ),
                    number_format_i18n( $count ),
                    get_the_title()
                );
            }
            ?>
        </h2>

        <?php the_comments_navigation(); ?>

        <ol class="comment-list">
            <?php
            wp_list_comments( array(
                'style'      => 'ol',
                'short_ping' => true,
                'callback'   => 'skeleton_wp_comment',
            ) );
            ?>
        </ol>

        <?php the_comments_navigation(); ?>

    <?php endif; ?>

    <?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
        <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'skeleton-wp' ); ?></p>
    <?php endif; ?>

    <?php
    comment_form( array(
        'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
        'title_reply_after'  => '</h2>',
        'class_container'    => 'comment-respond',
        'label_submit'       => esc_html__( 'Post Comment', 'skeleton-wp' ),
        'class_submit'       => 'submit button-primary',
        'comment_notes_before' => '',
    ) );
    ?>

</div><!-- /#comments -->
