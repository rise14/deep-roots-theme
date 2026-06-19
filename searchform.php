<?php
/**
 * Custom search form template.
 *
 * @package Skeleton_WP
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label>
        <span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'skeleton-wp' ); ?></span>
        <input type="search" class="search-field u-full-width" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'skeleton-wp' ); ?>"
               value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
    </label>
    <button type="submit" class="search-submit button button-primary u-full-width">
        <?php echo skeleton_wp_icon( 'search' ); ?>
        <?php echo esc_html_x( 'Search', 'submit button', 'skeleton-wp' ); ?>
    </button>
</form>
