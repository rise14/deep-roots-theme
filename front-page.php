<?php
/**
 * Front page template.
 * Forces the 2-column × 8-row posts grid (16 posts).
 *
 * @package Skeleton_WP
 */

get_header();

// If a static front page is set and it has content, show it above the grid
if ( is_page() && have_posts() ) :
    while ( have_posts() ) : the_post();
        if ( get_the_content() ) :
?>
<div id="primary-full" class="u-full-width" style="padding: 40px 0 0;">
    <div class="container">
        <div class="entry-content" style="margin-bottom:30px;">
            <?php the_content(); ?>
        </div>
    </div>
</div>
<?php
        endif;
    endwhile;
endif;

// Fetch latest posts for the grid (overriding static front page query)
$grid_count = get_theme_mod( 'posts_per_page_grid', 10 );
$grid_query = new WP_Query( array(
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => absint( $grid_count ),
    'paged'               => get_query_var( 'paged', 1 ),
    'ignore_sticky_posts' => false,
) );
?>

<div class="container">
    <div id="content-area" class="clearfix" style="padding-top:40px;">

        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">

                <?php if ( $grid_query->have_posts() ) : ?>

                <div class="posts-grid">
                    <?php while ( $grid_query->have_posts() ) : $grid_query->the_post();

                        $cats    = get_the_category();
                        $primary = $cats ? $cats[0] : null;
                    ?>

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
                            <h2 class="post-card-title">
                                <a href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_title() ); ?></a>
                            </h2>

                            <div class="post-card-excerpt">
                                <?php skeleton_wp_excerpt( 18 ); ?>
                            </div>

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
                        </div>

                    </article>

                    <?php endwhile; wp_reset_postdata(); ?>
                </div><!-- /.posts-grid -->

                <!-- Pagination -->
                <div class="posts-pagination">
                    <?php
                    echo paginate_links( array(
                        'total'     => $grid_query->max_num_pages,
                        'current'   => max( 1, get_query_var( 'paged' ) ),
                        'prev_text' => '<i class="fa fa-chevron-left"></i>',
                        'next_text' => '<i class="fa fa-chevron-right"></i>',
                    ) );
                    ?>
                </div>

                <?php else : ?>
                    <p style="color:#999;"><?php esc_html_e( 'No posts found. Start publishing!', 'skeleton-wp' ); ?></p>
                <?php endif; ?>

            </main>
        </div><!-- /#primary -->

        <?php get_sidebar(); ?>

    </div><!-- /#content-area -->
</div><!-- /.container -->

<?php get_footer(); ?>
