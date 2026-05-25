<?php
/**
 * Single post template.
 *
 * @package Skeleton_WP
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <header class="entry-header">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                <?php skeleton_wp_post_meta( true ); ?>
            </header>

            <?php if ( has_post_thumbnail() ) : ?>
            <div class="entry-thumbnail">
                <?php the_post_thumbnail( 'skeleton-single', array( 'class' => 'u-full-width' ) ); ?>
            </div>
            <?php endif; ?>

            <div class="entry-content">
                <?php
                the_content( sprintf(
                    wp_kses(
                        /* translators: %s: Name of current post. Only visible to screen readers */
                        __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'skeleton-wp' ),
                        array( 'span' => array( 'class' => array() ) )
                    ),
                    get_the_title()
                ) );

                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'skeleton-wp' ),
                    'after'  => '</div>',
                ) );
                ?>
            </div>

        </article><!-- /#post -->

        <!-- Comments -->
        <?php if ( comments_open() || get_comments_number() ) : ?>
        <?php comments_template(); ?>
        <?php endif; ?>

        <?php endwhile; ?>

    </main><!-- /#main -->
</div><!-- /#primary -->

<?php get_footer(); ?>
