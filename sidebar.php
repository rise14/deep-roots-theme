<?php
/**
 * Sidebar template — appears to the right of main content.
 *
 * @package Skeleton_WP
 */

if ( ! is_active_sidebar( 'sidebar-main' ) ) {
    return;
}
?>

<aside id="secondary" class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Sidebar', 'skeleton-wp' ); ?>">

    <?php if ( is_active_sidebar( 'sidebar-main' ) ) : ?>
        <?php dynamic_sidebar( 'sidebar-main' ); ?>
    <?php else : ?>

        <!-- ===========================
             DEFAULT SIDEBAR CONTENT
             (shown until widgets are added)
        =========================== -->

        <!-- Advertisement Placeholder -->
        <section class="widget widget-banner">
            <div class="banner-placeholder">
                <i class="fa fa-ad" style="font-size:2.5rem;margin-bottom:10px;display:block;"></i>
                <?php esc_html_e( 'Advertisement', 'skeleton-wp' ); ?><br>
                <small><?php esc_html_e( '300 × 250', 'skeleton-wp' ); ?></small>
            </div>
        </section>

        <!-- Recent Posts -->
        <section class="widget widget-recent-posts">
            <h3 class="widget-title"><?php esc_html_e( 'Recent Posts', 'skeleton-wp' ); ?></h3>
            <?php
            $recent_args = array(
                'posts_per_page'      => 5,
                'post_status'         => 'publish',
                'no_found_rows'       => true,
                'ignore_sticky_posts' => true,
            );
            $recent_query = new WP_Query( $recent_args );
            if ( $recent_query->have_posts() ) :
            ?>
            <ul>
            <?php while ( $recent_query->have_posts() ) : $recent_query->the_post(); ?>
                <li>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail( 'skeleton-sidebar', array( 'class' => 'rp-thumb' ) ); ?>
                        </a>
                    <?php else : ?>
                        <div class="rp-thumb-placeholder">&#128247;</div>
                    <?php endif; ?>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <span class="rp-date">
                        <i class="fa fa-clock" aria-hidden="true"></i>
                        <?php echo get_the_date(); ?>
                    </span>
                </li>
            <?php endwhile; wp_reset_postdata(); ?>
            </ul>
            <?php else : ?>
                <p><?php esc_html_e( 'No posts found.', 'skeleton-wp' ); ?></p>
            <?php endif; ?>
        </section>

        <!-- Categories -->
        <section class="widget">
            <h3 class="widget-title"><?php esc_html_e( 'Categories', 'skeleton-wp' ); ?></h3>
            <ul>
                <?php
                $cats = get_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'number' => 10 ) );
                if ( $cats ) :
                    foreach ( $cats as $cat ) :
                ?>
                <li>
                    <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>">
                        <?php echo esc_html( $cat->name ); ?>
                    </a>
                    <span class="count"><?php echo absint( $cat->count ); ?></span>
                </li>
                <?php
                    endforeach;
                else :
                    echo '<li>' . esc_html__( 'No categories yet.', 'skeleton-wp' ) . '</li>';
                endif;
                ?>
            </ul>
        </section>

        <!-- Popular Tags -->
        <section class="widget">
            <h3 class="widget-title"><?php esc_html_e( 'Tags', 'skeleton-wp' ); ?></h3>
            <?php
            $tags = get_tags( array( 'number' => 20, 'orderby' => 'count', 'order' => 'DESC' ) );
            if ( $tags ) :
            ?>
            <div class="tagcloud">
                <?php foreach ( $tags as $tag ) : ?>
                    <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>"
                       style="font-size: <?php echo min( 1.6, 1.1 + ( $tag->count * 0.05 ) ); ?>rem;">
                        <?php echo esc_html( $tag->name ); ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <?php else : ?>
                <p><?php esc_html_e( 'No tags found.', 'skeleton-wp' ); ?></p>
            <?php endif; ?>
        </section>

        <!-- Archives -->
        <section class="widget">
            <h3 class="widget-title"><?php esc_html_e( 'Archives', 'skeleton-wp' ); ?></h3>
            <ul>
                <?php wp_get_archives( array( 'type' => 'monthly', 'limit' => 12, 'show_post_count' => true ) ); ?>
            </ul>
        </section>

        <!-- Second Ad Placeholder -->
        <section class="widget widget-banner">
            <div class="banner-placeholder">
                <i class="fa fa-ad" style="font-size:2.5rem;margin-bottom:10px;display:block;"></i>
                <?php esc_html_e( 'Advertisement', 'skeleton-wp' ); ?><br>
                <small><?php esc_html_e( '300 × 600', 'skeleton-wp' ); ?></small>
            </div>
        </section>

    <?php endif; ?>

</aside><!-- /#secondary -->
