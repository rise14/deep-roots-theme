<?php
/**
 * Template part: post card.
 *
 * Used by the AJAX load-more handler (skeleton_load_more action in functions.php)
 * and can also be called via get_template_part( 'template-parts/content', 'card' )
 * from any listing template.
 *
 * Assumes the loop is already set up by the caller.
 *
 * @package Skeleton_WP
 */

$cats    = get_the_category();
$primary = $cats ? $cats[0] : null;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>

    <!-- Thumbnail -->
    <div class="post-card-thumb">
        <?php if ( has_post_thumbnail() ) : ?>
            <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                <?php the_post_thumbnail( 'skeleton-card', array(
                    'alt'     => the_title_attribute( 'echo=0' ),
                    'loading' => 'lazy',
                ) ); ?>
            </a>
        <?php else : ?>
            <div class="post-card-thumb-placeholder">&#128247;</div>
        <?php endif; ?>

        <!-- Category badge over thumb -->
        <?php if ( $primary ) : ?>
            <a class="post-card-category"
               href="<?php echo esc_url( get_category_link( $primary->term_id ) ); ?>">
                <?php echo esc_html( $primary->name ); ?>
            </a>
        <?php endif; ?>
    </div><!-- /.post-card-thumb -->

    <!-- Body -->
    <div class="post-card-body">

        <!-- Meta -->
        <div class="post-card-meta">
            <span class="meta-date"><?php echo esc_html( get_the_date() ); ?></span>
            <span class="meta-author">
                <i class="fa fa-user" aria-hidden="true"></i>
                <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                    <?php the_author(); ?>
                </a>
            </span>
        </div>

        <!-- Title -->
        <h2 class="post-card-title">
            <a href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_title() ); ?></a>
        </h2>

        <!-- Excerpt -->
        <div class="post-card-excerpt">
            <?php skeleton_wp_excerpt( 18 ); ?>
        </div>

        <!-- Footer -->
        <div class="post-card-footer">
            <a class="post-card-readmore" href="<?php the_permalink(); ?>">
                <?php esc_html_e( 'Read More', 'skeleton-wp' ); ?>
                <i class="fa fa-arrow-right" aria-hidden="true"></i>
            </a>
            <?php if ( get_comments_number() > 0 ) : ?>
                <span class="post-card-comments">
                    <i class="fa fa-comment" aria-hidden="true"></i>
                    <?php echo absint( get_comments_number() ); ?>
                </span>
            <?php endif; ?>
        </div>

    </div><!-- /.post-card-body -->
</article><!-- /.post-card -->
