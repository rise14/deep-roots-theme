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

        <?php while ( have_posts() ) : the_post();

            $cats    = get_the_category();
            $primary = $cats ? $cats[0] : null;
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <header class="entry-header">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                <?php
                // WP Subtitle plugin output; no-ops when the plugin is inactive.
                do_action( 'plugins/wp_subtitle/the_subtitle', array(
                    'before' => '<h2 class="entry-subtitle">',
                    'after'  => '</h2>',
                ) );
                ?>
                <?php skeleton_wp_post_meta(); ?>
            </header>

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

        <?php if ( $primary ) :
            $related_query = new WP_Query( array(
                'category__in'        => array( $primary->term_id ),
                'post__not_in'        => array( get_the_ID() ),
                'posts_per_page'      => 4,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => true,
            ) );
        ?>
        <?php if ( $related_query->have_posts() ) : ?>
        <section class="related-posts">
            <h2 class="widget-title">
                <?php
                printf(
                    /* translators: %s: category name */
                    esc_html__( 'Related in %s', 'skeleton-wp' ),
                    esc_html( $primary->name )
                );
                ?>
            </h2>
            <div class="posts-grid">
                <?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>

                    <div class="post-card-thumb">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                                <?php the_post_thumbnail( 'skeleton-card', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
                            </a>
                        <?php else : ?>
                            <div class="post-card-thumb-placeholder">&#128247;</div>
                        <?php endif; ?>
                    </div>

                    <div class="post-card-body">
                        <h3 class="post-card-title">
                            <a href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_title() ); ?></a>
                        </h3>

                        <div class="post-card-excerpt">
                            <?php skeleton_wp_excerpt( 45 ); ?>
                        </div>

                        <div class="post-card-footer">
                            <a class="post-card-readmore" href="<?php the_permalink(); ?>">
                                <?php esc_html_e( 'Read More', 'skeleton-wp' ); ?>
                                <?php echo skeleton_wp_icon( 'arrow-right' ); ?>
                            </a>
                        </div>
                    </div>

                </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </section>
        <?php endif; ?>
        <?php endif; ?>

        <!-- Comments -->
        <?php if ( comments_open() || get_comments_number() ) : ?>
        <?php comments_template(); ?>
        <?php endif; ?>

        <?php endwhile; ?>

    </main><!-- /#main -->
</div><!-- /#primary -->

<?php get_footer(); ?>
