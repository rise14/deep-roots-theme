<?php
/**
 * Main template — blog index / category / tag / search results.
 * Displays posts in a 2-column grid with 8 rows (16 posts per page).
 *
 * @package Skeleton_WP
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php if ( have_posts() ) : ?>

            <!-- 2-Column Post Grid -->
            <div class="posts-grid">
                <?php
                while ( have_posts() ) :
                    the_post();

                    /*
                     * Inline the card template to keep the theme self-contained.
                     * You can also use:  get_template_part( 'template-parts/content', 'card' );
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
                                    'alt' => the_title_attribute( 'echo=0' ),
                                ) ); ?>
                            </a>
                        <?php else : ?>
                            <div class="post-card-thumb-placeholder">&#128247;</div>
                        <?php endif; ?>
                        <?php if ( $primary ) : ?>
                            <a class="post-card-category" href="<?php echo esc_url( get_category_link( $primary->term_id ) ); ?>">
                                <?php echo esc_html( $primary->name ); ?>
                            </a>
                        <?php endif; ?>
                    </div><!-- /.post-card-thumb -->

                    <!-- Body -->
                    <div class="post-card-body">

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

                <?php endwhile; ?>
            </div><!-- /.posts-grid -->

            <!-- Pagination -->
            <div class="posts-pagination">
                <?php
                the_posts_pagination( array(
                    'mid_size'  => 2,
                    'prev_text' => '<i class="fa fa-chevron-left" aria-hidden="true"></i><span class="screen-reader-text">' . esc_html__( 'Previous', 'skeleton-wp' ) . '</span>',
                    'next_text' => '<i class="fa fa-chevron-right" aria-hidden="true"></i><span class="screen-reader-text">' . esc_html__( 'Next', 'skeleton-wp' ) . '</span>',
                ) );
                ?>
            </div>

        <?php else : ?>

            <!-- No posts found -->
            <section class="no-results not-found">
                <header class="page-header">
                    <h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'skeleton-wp' ); ?></h1>
                </header>
                <div class="page-content">
                    <?php if ( is_search() ) : ?>
                        <p><?php esc_html_e( 'Sorry, nothing matched your search terms. Please try again with different keywords.', 'skeleton-wp' ); ?></p>
                        <?php get_search_form(); ?>
                    <?php else : ?>
                        <p><?php esc_html_e( 'It seems we cannot find what you are looking for. Perhaps searching can help.', 'skeleton-wp' ); ?></p>
                        <?php get_search_form(); ?>
                    <?php endif; ?>
                </div>
            </section>

        <?php endif; ?>

    </main><!-- /#main -->
</div><!-- /#primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
