<?php
/**
 * Archive template (category, tag, author, date).
 *
 * @package Skeleton_WP
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php if ( have_posts() ) : ?>

            <header class="page-header" style="margin-bottom:25px;">
                <?php the_archive_title( '<h1 class="page-title" style="margin-bottom:10px;">', '</h1>' ); ?>
                <?php the_archive_description( '<div class="archive-description" style="color:#666;font-size:1.4rem;margin-top:-15px;margin-bottom:20px;">', '</div>' ); ?>
            </header>

            <div class="posts-grid">
            <?php
            while ( have_posts() ) :
                the_post();
                $cats    = get_the_category();
                $primary = $cats ? $cats[0] : null;
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>

                <div class="post-card-thumb">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>" tabindex="-1">
                            <?php the_post_thumbnail( 'skeleton-card', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
                        </a>
                    <?php else : ?>
                        <div class="post-card-thumb-placeholder">&#128247;</div>
                    <?php endif; ?>
                    <?php if ( $primary ) : ?>
                        <a class="post-card-category" href="<?php echo esc_url( get_category_link( $primary->term_id ) ); ?>">
                            <?php echo esc_html( $primary->name ); ?>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="post-card-body">
                    <div class="post-card-meta">
                        <span><?php echo get_the_date(); ?></span>
                        <span><i class="fa fa-user" aria-hidden="true"></i>
                            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                                <?php the_author(); ?>
                            </a>
                        </span>
                    </div>
                    <h2 class="post-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="post-card-excerpt"><?php skeleton_wp_excerpt( 18 ); ?></div>
                    <div class="post-card-footer">
                        <a class="post-card-readmore" href="<?php the_permalink(); ?>">
                            <?php esc_html_e( 'Read More', 'skeleton-wp' ); ?> <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

            </article>
            <?php endwhile; ?>
            </div>

            <div class="posts-pagination">
                <?php the_posts_pagination( array(
                    'prev_text' => '<i class="fa fa-chevron-left"></i>',
                    'next_text' => '<i class="fa fa-chevron-right"></i>',
                ) ); ?>
            </div>

        <?php else : ?>
            <p><?php esc_html_e( 'No posts found in this archive.', 'skeleton-wp' ); ?></p>
        <?php endif; ?>

    </main>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
