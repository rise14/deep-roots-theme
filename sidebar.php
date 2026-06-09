<?php
/**
 * Sidebar template — appears to the right of main content.
 * Matches the sidebar on deeprootsmag.org.
 *
 * @package Skeleton_WP
 */
?>

<aside id="secondary" class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Sidebar', 'skeleton-wp' ); ?>">

    <?php if ( is_active_sidebar( 'sidebar-main' ) ) : ?>
        <?php dynamic_sidebar( 'sidebar-main' ); ?>
    <?php endif; ?>

    <!-- ===========================
         DEEP ROOTS SIDEBAR CONTENT
    =========================== -->

    <!-- The Bluegrass Special -->
    <section class="widget widget-sidebar-banner">
        <a href="http://www.thebluegrassspecial.com/archive/2013/december2013/indexdecember2013.html"
           target="_blank" rel="noopener noreferrer">
            <img src="https://deeprootsmag.org/sidebar/indexdecember2013thumb.jpeg"
                 alt="The Bluegrass Special"
                 style="width:100%;height:auto;display:block;" />
        </a>
        <p style="font-size:1.1rem;line-height:1.5;margin-top:6px;">
            Before Deep Roots existed, it was TheBluegrassSpecial.com, from April 2008 through July 2012.
        </p>
    </section>

    <!-- Panthera -->
    <section class="widget widget-sidebar-banner">
        <a href="http://www.panthera.org" target="_blank" rel="noopener noreferrer">
            <img src="https://deeprootsmag.org/sidebar/panthera-logo.jpg"
                 alt="Panthera"
                 style="width:100%;height:auto;display:block;" />
        </a>
    </section>

    <!-- Save The Manatee -->
    <section class="widget widget-sidebar-banner">
        <a href="http://www.savethemanatee.org" target="_blank" rel="noopener noreferrer">
            <img src="https://deeprootsmag.org/sidebar/manatee-holiday.jpg"
                 alt="Save The Manatee"
                 style="width:100%;height:auto;display:block;" />
        </a>
    </section>

    <!-- Matthew Shepard Foundation -->
    <section class="widget widget-sidebar-banner">
        <a href="https://www.matthewshepard.org/" target="_blank" rel="noopener noreferrer">
            <img src="https://deeprootsmag.org/sidebar/shepard-vert-banner.jpg"
                 alt="Matthew Shepard Foundation"
                 style="width:100%;height:auto;display:block;" />
        </a>
    </section>

</aside><!-- /#secondary -->
