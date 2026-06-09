<?php
/**
 * Archives page — all posts listed by year and month.
 * WordPress applies this template automatically to the page with slug "archives".
 *
 * @package Skeleton_WP
 */

get_header();

// Single query; grouped in PHP. LiteSpeed cache keeps front-end renders fast.
$archive_query = new WP_Query( array(
    'posts_per_page'         => -1,
    'post_type'              => 'post',
    'post_status'            => 'publish',
    'orderby'                => 'date',
    'order'                  => 'DESC',
    'no_found_rows'          => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
) );

// Build [ year => [ month_num => [ 'name' => 'January', 'posts' => [...] ] ] ]
$grouped = array();
foreach ( $archive_query->posts as $post ) {
    $year      = mysql2date( 'Y', $post->post_date );
    $month_num = (int) mysql2date( 'n', $post->post_date );

    if ( ! isset( $grouped[ $year ] ) ) {
        $grouped[ $year ] = array();
    }
    if ( ! isset( $grouped[ $year ][ $month_num ] ) ) {
        $grouped[ $year ][ $month_num ] = array(
            'name'  => mysql2date( 'F', $post->post_date ),
            'posts' => array(),
        );
    }
    $grouped[ $year ][ $month_num ]['posts'][] = $post;
}
wp_reset_postdata();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <article class="page type-page">

            <header class="entry-header">
                <h1 class="entry-title"><?php esc_html_e( 'Archives', 'skeleton-wp' ); ?></h1>
            </header>

            <div class="entry-content archives-listing">

                <?php if ( empty( $grouped ) ) : ?>
                    <p><?php esc_html_e( 'No posts found.', 'skeleton-wp' ); ?></p>

                <?php else : ?>
                    <?php foreach ( $grouped as $year => $months ) : ?>

                        <section class="archive-year">
                            <h2 class="archive-year-heading"><?php echo esc_html( $year ); ?></h2>

                            <?php foreach ( $months as $month_data ) : ?>
                                <div class="archive-month">
                                    <h3 class="archive-month-heading"><?php echo esc_html( $month_data['name'] ); ?></h3>
                                    <ul class="archive-post-list">
                                        <?php foreach ( $month_data['posts'] as $p ) : ?>
                                            <li class="archive-post-item">
                                                <a href="<?php echo esc_url( get_permalink( $p ) ); ?>">
                                                    <?php echo esc_html( $p->post_title ); ?>
                                                </a>
                                                <span class="archive-post-day">
                                                    <?php echo esc_html( mysql2date( 'M j', $p->post_date ) ); ?>
                                                </span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endforeach; ?>

                        </section>

                    <?php endforeach; ?>
                <?php endif; ?>

            </div><!-- .entry-content -->

        </article>

    </main>
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
