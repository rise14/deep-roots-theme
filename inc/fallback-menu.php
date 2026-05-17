<?php
/**
 * Fallback menu callback when no menu is assigned.
 *
 * @package Skeleton_WP
 */

function skeleton_wp_fallback_menu() {
    echo '<ul id="primary-menu" class="nav-menu">';
    printf( '<li><a href="%s">%s</a></li>', esc_url( home_url( '/' ) ), esc_html__( 'Home', 'skeleton-wp' ) );

    $pages = get_pages( array( 'number' => 5, 'sort_column' => 'menu_order' ) );
    foreach ( $pages as $page ) {
        printf( '<li><a href="%s">%s</a></li>',
            esc_url( get_permalink( $page->ID ) ),
            esc_html( $page->post_title ) );
    }
    echo '</ul>';
}
