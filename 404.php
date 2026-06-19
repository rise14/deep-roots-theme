<?php
/**
 * 404 Error page.
 *
 * @package Skeleton_WP
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <section class="error-404 not-found" style="text-align:center;padding:80px 0;">
            <div style="font-size:10rem;line-height:1;margin-bottom:20px;">&#128214;</div>
            <h1 style="font-size:8rem;color:#1a1a2e;margin-bottom:10px;">404</h1>
            <h2 style="color:#555;margin-bottom:20px;"><?php esc_html_e( 'Page Not Found', 'skeleton-wp' ); ?></h2>
            <p style="color:#888;margin-bottom:30px;">
                <?php esc_html_e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'skeleton-wp' ); ?>
            </p>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button button-primary">
                <?php echo skeleton_wp_icon( 'home' ); ?>
                <?php esc_html_e( 'Back to Home', 'skeleton-wp' ); ?>
            </a>
            <div style="max-width:400px;margin:40px auto 0;">
                <h3 style="font-size:1.6rem;"><?php esc_html_e( 'Or try searching:', 'skeleton-wp' ); ?></h3>
                <?php get_search_form(); ?>
            </div>
        </section>

    </main>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
