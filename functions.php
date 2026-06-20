<?php
/**
 * Skeleton WP Theme Functions
 *
 * @package Skeleton_WP
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// SEO enhancements: OG tags, Twitter Cards, canonical, schema markup.
require_once get_template_directory() . '/inc/seo.php';

/* =====================================================
   THEME SETUP
   ===================================================== */

if ( ! function_exists( 'skeleton_wp_setup' ) ) :
function skeleton_wp_setup() {

    // Make theme available for translation
    load_theme_textdomain( 'skeleton-wp', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails
    add_theme_support( 'post-thumbnails' );

    // Custom image sizes
    add_image_size( 'skeleton-card',     400, 230, true );  // Post card thumbnail
    add_image_size( 'skeleton-slide',   1200, 500, true );  // Slider image
    add_image_size( 'skeleton-sidebar',  300, 180, true );  // Sidebar recent posts
    add_image_size( 'skeleton-single',  1200, 600, true );  // Single post hero

    // Register navigation menus
    register_nav_menus( array(
        'primary'      => esc_html__( 'Primary Menu', 'skeleton-wp' ),
        'footer-links' => esc_html__( 'Footer Links', 'skeleton-wp' ),
    ) );

    // HTML5 support
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list',
        'gallery', 'caption', 'script', 'style',
    ) );

    // Post Formats
    add_theme_support( 'post-formats', array(
        'aside', 'image', 'video', 'quote', 'link', 'gallery',
    ) );

    // Custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 280,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Custom background
    add_theme_support( 'custom-background', array(
        'default-color' => 'CEC5B2',
    ) );

    // Custom header
    add_theme_support( 'custom-header', array(
        'default-image'  => '',
        'width'          => 1200,
        'height'         => 500,
        'flex-width'     => true,
        'flex-height'    => true,
    ) );

    // Selective refresh for widgets
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Wide / full blocks alignment
    add_theme_support( 'align-wide' );

    // Responsive embeds
    add_theme_support( 'responsive-embeds' );
}
endif;
add_action( 'after_setup_theme', 'skeleton_wp_setup' );

/* =====================================================
   CONTENT WIDTH
   ===================================================== */

function skeleton_wp_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'skeleton_wp_content_width', 860 );
}
add_action( 'after_setup_theme', 'skeleton_wp_content_width', 0 );

/* =====================================================
   ENQUEUE SCRIPTS & STYLES
   ===================================================== */

function skeleton_wp_scripts() {

    // Google Fonts
    wp_enqueue_style( 'skeleton-wp-google-fonts',
        'https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;1,9..144,400&family=Raleway:wght@300;400;600;700;900&display=swap',
        array(), null );

    // Icons are now inline SVG (see skeleton_wp_icon) — no Font Awesome request.

    // Main stylesheet (style.css)
    wp_enqueue_style( 'skeleton-wp-style', get_stylesheet_uri(), array(), '1.0.0' );

    // Theme JS
    wp_enqueue_script( 'skeleton-wp-navigation',
        get_template_directory_uri() . '/js/navigation.js',
        array(), '1.0.0', true );

    wp_enqueue_script( 'skeleton-wp-slider',
        get_template_directory_uri() . '/js/slider.js',
        array(), '1.0.0', true );

    // Comments reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    // Pass data to JS
    wp_localize_script( 'skeleton-wp-slider', 'skeletonWP', array(
        'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
        'themeUrl'    => get_template_directory_uri(),
        'autoplay'    => apply_filters( 'skeleton_wp_slider_autoplay', true ),
        'autoplayMs'  => apply_filters( 'skeleton_wp_slider_speed', 5000 ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'skeleton_wp_scripts' );

/* =====================================================
   REGISTER SIDEBARS
   ===================================================== */

function skeleton_wp_widgets_init() {

    // Main right sidebar
    register_sidebar( array(
        'name'          => esc_html__( 'Main Sidebar', 'skeleton-wp' ),
        'id'            => 'sidebar-main',
        'description'   => esc_html__( 'Appears on the right side of the main content area.', 'skeleton-wp' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    // Footer widget areas (3 columns)
    for ( $i = 1; $i <= 3; $i++ ) {
        register_sidebar( array(
            'name'          => sprintf( esc_html__( 'Footer %d', 'skeleton-wp' ), $i ),
            'id'            => 'footer-' . $i,
            'description'   => sprintf( esc_html__( 'Footer widget area %d (1 of 3 columns).', 'skeleton-wp' ), $i ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ) );
    }

    // Under-slider widget area
    register_sidebar( array(
        'name'          => esc_html__( 'Below Slider', 'skeleton-wp' ),
        'id'            => 'below-slider',
        'description'   => esc_html__( 'Full-width area that appears directly below the image slider.', 'skeleton-wp' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'skeleton_wp_widgets_init' );

/* =====================================================
   SLIDER — Retrieve posts for the homepage slider
   ===================================================== */

function skeleton_wp_get_slider_posts( $count = 5 ) {
    // Priority: posts tagged 'featured-slider', falling back to latest posts
    $args = array(
        'posts_per_page' => absint( $count ),
        'post_status'    => 'publish',
        'tag'            => 'featured-slider',
        'ignore_sticky_posts' => true,
    );
    $query = new WP_Query( $args );
    if ( ! $query->have_posts() ) {
        $args['tag'] = '';
        $query       = new WP_Query( $args );
    }
    return $query;
}

/* =====================================================
   TEMPLATE TAGS / HELPERS
   ===================================================== */

/**
 * Prints the post excerpt, falling back to a trimmed content.
 */
function skeleton_wp_excerpt( $length = 18 ) {
    $excerpt = get_the_excerpt();
    if ( empty( $excerpt ) ) {
        $excerpt = get_the_content();
        $excerpt = strip_shortcodes( $excerpt );
        $excerpt = wp_strip_all_tags( $excerpt );
        $words   = explode( ' ', $excerpt, $length + 1 );
        if ( count( $words ) > $length ) {
            array_pop( $words );
            $excerpt = implode( ' ', $words ) . '&hellip;';
        }
    } else {
        $words = explode( ' ', $excerpt, $length + 1 );
        if ( count( $words ) > $length ) {
            array_pop( $words );
            $excerpt = implode( ' ', $words ) . '&hellip;';
        }
    }
    echo esc_html( $excerpt );
}

/**
 * Post meta (date, author, comments, category).
 */
function skeleton_wp_post_meta( $show_cat = true ) {
    $author_name = get_the_author();
    $author_url  = get_author_posts_url( get_the_author_meta( 'ID' ) );
    $cats        = get_the_category();
    $primary     = $cats ? $cats[0] : null;

    echo '<div class="post-card-meta">';

    printf( '<span class="meta-date">%s</span>', esc_html( get_the_date() ) );

    if ( $author_name ) {
        printf( ' <span class="meta-author">%s <a href="%s">%s</a></span>',
            esc_html__( 'by', 'skeleton-wp' ),
            esc_url( $author_url ),
            esc_html( $author_name )
        );
    }

    if ( $show_cat && $primary ) {
        printf( ' <a class="meta-category" href="%s">%s</a>',
            esc_url( get_category_link( $primary->term_id ) ),
            esc_html( $primary->name )
        );
    }

    echo '</div>';
}

/**
 * Placeholder SVG image for posts without a thumbnail.
 */
function skeleton_wp_placeholder( $width = 400, $height = 230 ) {
    printf( '<div class="post-card-thumb-placeholder">&#128247;</div>' );
}

/**
 * Inline SVG icon (Font Awesome 6 free-solid paths). Replaces the render-blocking
 * Font Awesome CDN stylesheet — only the handful of icons the theme uses.
 * Sized to 1em / currentColor so it drops in wherever an <i class="fa"> was.
 *
 * @param string $name One of: search, bars, chevron-left, chevron-right,
 *                     arrow-right, comment, rss, home.
 * @return string SVG markup (already escaped-safe; paths are static literals).
 */
function skeleton_wp_icon( $name ) {
    $icons = array(
        'search'        => array( '0 0 512 512', 'M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z' ),
        'bars'          => array( '0 0 448 512', 'M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z' ),
        'chevron-left'  => array( '0 0 320 512', 'M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z' ),
        'chevron-right' => array( '0 0 320 512', 'M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z' ),
        'arrow-right'   => array( '0 0 448 512', 'M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z' ),
        'comment'       => array( '0 0 512 512', 'M512 240c0 114.9-114.6 208-256 208c-37.1 0-72.3-6.4-104.1-17.9c-11.9 8.7-31.3 20.6-54.3 30.6C73.6 471.1 44.7 480 16 480c-6.5 0-12.3-3.9-14.8-9.9c-2.5-6-1.1-12.8 3.4-17.4l0 0 .3-.3c.3-.3 .7-.7 1.3-1.4c1.1-1.2 2.8-3.1 4.9-5.7c4.1-5 9.6-12.4 15.2-21.6c10-16.6 19.5-38.4 21.4-62.9C17.7 326.8 0 285.1 0 240C0 125.1 114.6 32 256 32s256 93.1 256 208z' ),
        'rss'           => array( '0 0 448 512', 'M0 64C0 46.3 14.3 32 32 32c229.8 0 416 186.2 416 416c0 17.7-14.3 32-32 32s-32-14.3-32-32C384 253.6 226.4 96 32 96C14.3 96 0 81.7 0 64zM0 416a64 64 0 1 1 128 0A64 64 0 1 1 0 416zM32 160c159.1 0 288 128.9 288 288c0 17.7-14.3 32-32 32s-32-14.3-32-32c0-123.7-100.3-224-224-224c-17.7 0-32-14.3-32-32s14.3-32 32-32z' ),
        'home'          => array( '0 0 576 512', 'M575.8 255.5c0 18-15 32.1-32 32.1l-32 0 .7 160.2c0 2.7-.2 5.4-.5 8.1l0 16.2c0 22.1-17.9 40-40 40l-16 0c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1L416 512l-24 0c-22.1 0-40-17.9-40-40l0-24 0-64c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32 14.3-32 32l0 64 0 24c0 22.1-17.9 40-40 40l-24 0-31.9 0c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2l-16 0c-22.1 0-40-17.9-40-40l0-112c0-.9 0-1.9 .1-2.8l0-69.7-32 0c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z' ),
    );

    if ( ! isset( $icons[ $name ] ) ) {
        return '';
    }

    list( $viewbox, $path ) = $icons[ $name ];

    return sprintf(
        '<svg class="icon icon-%s" viewBox="%s" width="1em" height="1em" fill="currentColor" aria-hidden="true" focusable="false" style="display:inline-block;vertical-align:-0.125em"><path d="%s"/></svg>',
        esc_attr( $name ),
        esc_attr( $viewbox ),
        esc_attr( $path )
    );
}

/**
 * Prints breadcrumbs (lightweight, no plugin required).
 */
function skeleton_wp_breadcrumbs() {
    if ( is_front_page() ) return;

    $sep = '<span class="sep">&rsaquo;</span>';
    echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumbs', 'skeleton-wp' ) . '">';
    printf( '<a href="%s">%s</a> %s ', esc_url( home_url() ), esc_html__( 'Home', 'skeleton-wp' ), $sep );

    if ( is_category() ) {
        echo esc_html( single_cat_title( '', false ) );
    } elseif ( is_tag() ) {
        echo esc_html( single_tag_title( '', false ) );
    } elseif ( is_author() ) {
        echo esc_html( get_the_author() );
    } elseif ( is_day() ) {
        echo esc_html( get_the_date() );
    } elseif ( is_month() ) {
        echo esc_html( get_the_date( 'F Y' ) );
    } elseif ( is_year() ) {
        echo esc_html( get_the_date( 'Y' ) );
    } elseif ( is_search() ) {
        printf( esc_html__( 'Search: %s', 'skeleton-wp' ), esc_html( get_search_query() ) );
    } elseif ( is_singular() ) {
        if ( is_singular( 'post' ) ) {
            $cats = get_the_category();
            if ( $cats ) {
                printf( '<a href="%s">%s</a> %s ',
                    esc_url( get_category_link( $cats[0]->term_id ) ),
                    esc_html( $cats[0]->name ), $sep );
            }
        }
        echo esc_html( get_the_title() );
    }
    echo '</nav>';
}

/* =====================================================
   CUSTOM EXCERPT LENGTH & MORE LINK
   ===================================================== */

add_filter( 'excerpt_length', function() { return 20; }, 999 );
add_filter( 'excerpt_more',   function() {
    return '&hellip; <a class="post-card-readmore" href="' . esc_url( get_permalink() ) . '">' . esc_html__( 'Read More', 'skeleton-wp' ) . '</a>';
} );

/* =====================================================
   BODY CLASSES
   ===================================================== */

// Drop the "Category:" / "Tag:" / "Archives:" prefix from archive H1s.
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );

add_filter( 'body_class', function( $classes ) {
    if ( is_front_page() ) $classes[] = 'home-page';
    if ( is_singular() )   $classes[] = 'has-sidebar';
    return $classes;
} );

/* =====================================================
   COMMENT CALLBACK
   ===================================================== */

function skeleton_wp_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class( 'comment' ); ?> id="comment-<?php comment_ID(); ?>">
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
            <div class="comment-author vcard">
                <?php echo get_avatar( $comment, 40 ); ?>
                <b class="fn"><?php comment_author_link(); ?></b>
            </div>
            <div class="comment-metadata">
                <a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
                    <time datetime="<?php comment_time( 'c' ); ?>"><?php comment_date(); ?></time>
                </a>
                <?php edit_comment_link( esc_html__( 'Edit', 'skeleton-wp' ), ' ', '' ); ?>
            </div>
            <?php if ( '0' === $comment->comment_approved ) : ?>
                <p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'skeleton-wp' ); ?></p>
            <?php endif; ?>
            <div class="comment-content"><?php comment_text(); ?></div>
            <div class="reply">
                <?php comment_reply_link( array_merge( $args, array( 'add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </div>
        </article>
    <?php
}

/* =====================================================
   CUSTOMIZER ADDITIONS
   ===================================================== */

add_action( 'customize_register', function( $wp_customize ) {

    // --- Slider Section ---
    $wp_customize->add_section( 'skeleton_slider', array(
        'title'    => esc_html__( 'Image Slider', 'skeleton-wp' ),
        'priority' => 30,
    ) );
    $wp_customize->add_setting( 'slider_count', array( 'default' => 5, 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( 'slider_count', array(
        'label'   => esc_html__( 'Number of slider posts', 'skeleton-wp' ),
        'section' => 'skeleton_slider',
        'type'    => 'number',
    ) );
    $wp_customize->add_setting( 'slider_autoplay', array( 'default' => 1, 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( 'slider_autoplay', array(
        'label'   => esc_html__( 'Autoplay slider', 'skeleton-wp' ),
        'section' => 'skeleton_slider',
        'type'    => 'checkbox',
    ) );

    // --- Posts Grid Section ---
    $wp_customize->add_section( 'skeleton_posts_grid', array(
        'title'    => esc_html__( 'Posts Grid', 'skeleton-wp' ),
        'priority' => 35,
    ) );
    $wp_customize->add_setting( 'posts_per_page_grid', array( 'default' => 10, 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( 'posts_per_page_grid', array(
        'label'       => esc_html__( 'Posts per page (front page grid)', 'skeleton-wp' ),
        'section'     => 'skeleton_posts_grid',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 2, 'max' => 32 ),
    ) );

    // --- Footer Section ---
    $wp_customize->add_section( 'skeleton_footer', array(
        'title'    => esc_html__( 'Footer', 'skeleton-wp' ),
        'priority' => 100,
    ) );
    $wp_customize->add_setting( 'footer_copyright', array(
        'default'           => sprintf( esc_html__( '© %d %s. All Rights Reserved.', 'skeleton-wp' ), date('Y'), get_bloginfo('name') ),
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'footer_copyright', array(
        'label'   => esc_html__( 'Footer Copyright Text', 'skeleton-wp' ),
        'section' => 'skeleton_footer',
        'type'    => 'textarea',
    ) );
} );

/* =====================================================
   SIDEBAR WIDGET TWEAKS
   ===================================================== */

/**
 * Remove built-in widgets we never want to appear in any sidebar,
 * regardless of what's saved in the widget admin.
 */
add_action( 'widgets_init', function() {
    unregister_widget( 'WP_Widget_Recent_Comments' );
    unregister_widget( 'WP_Widget_Search' );
}, 11 );

/**
 * Cap the Archives widget at the 12 most recent months.
 */
add_filter( 'widget_archives_args', function( $args ) {
    $args['type']  = 'monthly';
    $args['limit'] = 12;
    return $args;
} );

add_filter( 'widget_archives_dropdown_args', function( $args ) {
    $args['type']  = 'monthly';
    $args['limit'] = 12;
    return $args;
} );

/**
 * Strip specific widget instances from the main sidebar at render time.
 * Add a widget's auto-generated ID (e.g. "block-2") to $remove to hide it.
 */
add_filter( 'sidebars_widgets', function( $widgets ) {
    $remove = array( 'block-2' );

    if ( isset( $widgets['sidebar-main'] ) && is_array( $widgets['sidebar-main'] ) ) {
        $widgets['sidebar-main'] = array_values( array_diff( $widgets['sidebar-main'], $remove ) );
    }
    return $widgets;
} );

/* =====================================================
   ENQUEUE BLOCK EDITOR STYLES
   ===================================================== */

add_action( 'enqueue_block_editor_assets', function() {
    wp_enqueue_style( 'skeleton-wp-editor',
        get_template_directory_uri() . '/css/editor-style.css',
        array(), '1.0.0' );
} );

/* =====================================================
   ARCHIVES PAGE: NAV MENU ITEM + INLINE STYLES
   Appends "Archives" to the primary menu automatically once a
   page with slug "archives" exists and is published. The page
   template page-archives.php is applied automatically by
   WordPress via the page-{slug} template hierarchy.
   ===================================================== */

add_filter( 'wp_nav_menu_items', 'skeleton_wp_archives_menu_item', 10, 2 );

function skeleton_wp_archives_menu_item( $items, $args ) {
    if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
        $page = get_page_by_path( 'archives' );
        if ( $page && 'publish' === $page->post_status ) {
            $items .= '<li class="menu-item menu-item-archives"><a href="'
                . esc_url( get_permalink( $page ) )
                . '">' . esc_html__( 'Archives', 'skeleton-wp' ) . '</a></li>';
        }
    }
    return $items;
}

add_action( 'wp_enqueue_scripts', 'skeleton_wp_archives_styles' );

function skeleton_wp_archives_styles() {
    $css = '
/* ---- Archives listing page ---- */
.archives-listing { margin-top: 10px; }
.archive-year { margin-bottom: 40px; }
.archive-year-heading {
    font-size: 2.4rem; font-weight: 700; color: #3d2f23;
    border-bottom: 3px solid #95755a; padding-bottom: 8px;
    margin-bottom: 20px;
}
.archive-month { margin-bottom: 24px; }
.archive-month-heading {
    font-size: 1.5rem; font-weight: 700; color: #95755a;
    text-transform: uppercase; letter-spacing: .08rem;
    margin-bottom: 10px; padding-left: 10px;
    border-left: 4px solid #95755a;
}
.archive-post-list { list-style: none; padding: 0; margin: 0; }
.archive-post-item {
    display: flex; justify-content: space-between; align-items: baseline;
    padding: 6px 0; border-bottom: 1px solid #ede8e0; font-size: 1.35rem;
}
.archive-post-item:last-child { border-bottom: none; }
.archive-post-item a { color: #3d2f23; text-decoration: none; flex: 1; padding-right: 12px; }
.archive-post-item a:hover { color: #95755a; text-decoration: underline; }
.archive-post-day { color: #999; font-size: 1.1rem; white-space: nowrap; }
@media (max-width: 749px) {
    .archive-post-item { flex-direction: column; gap: 2px; }
    .archive-post-day { font-size: 1.05rem; }
}
';
    wp_add_inline_style( 'skeleton-wp-style', $css );
}

/* =====================================================
   MOBILE NAV: CRITICAL STATE CSS
   The CSS debloat/optimiser plugin strips state-based rules
   (.toggled, .sub-menu-open) from style.css when it inlines
   critical CSS. Injecting them here via wp_add_inline_style
   ensures they survive and the hamburger menu actually works.
   ===================================================== */

add_action( 'wp_enqueue_scripts', 'skeleton_wp_mobile_nav_critical_css' );

function skeleton_wp_mobile_nav_critical_css() {
    $css = '
@media (max-width: 749px) {
  .main-navigation.toggled ul { display: flex !important; }
  .main-navigation ul li.sub-menu-open > ul { display: flex !important; }
}
';
    wp_add_inline_style( 'skeleton-wp-style', $css );
}

/* =====================================================
   AJAX: LISTMONK NEWSLETTER SUBSCRIBE
   ===================================================== */

add_action( 'wp_ajax_listmonk_subscribe',        'skeleton_wp_listmonk_subscribe' );
add_action( 'wp_ajax_nopriv_listmonk_subscribe', 'skeleton_wp_listmonk_subscribe' );

function skeleton_wp_listmonk_subscribe() {
    check_ajax_referer( 'listmonk_subscribe', 'listmonk_nonce' );

    $email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';

    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => esc_html__( 'Please enter a valid email address.', 'skeleton-wp' ) ) );
    }

    $response = wp_remote_post(
        'https://listmonk.zardoz14.synology.me/api/public/subscription',
        array(
            'headers' => array( 'Content-Type' => 'application/json' ),
            'body'    => wp_json_encode( array(
                'email'      => $email,
                'list_uuids' => array( '97e948da-61de-42e6-8e3a-5184ec2fcf11' ),
            ) ),
            'timeout' => 10,
        )
    );

    if ( is_wp_error( $response ) ) {
        wp_send_json_error( array( 'message' => esc_html__( 'Could not reach the mailing list server. Please try again later.', 'skeleton-wp' ) ) );
    }

    $code = wp_remote_retrieve_response_code( $response );

    if ( $code >= 200 && $code < 300 ) {
        wp_send_json_success( array( 'message' => esc_html__( 'Thank you! Check your email to confirm your subscription.', 'skeleton-wp' ) ) );
    } else {
        $body = json_decode( wp_remote_retrieve_body( $response ), true );
        $msg  = isset( $body['message'] ) ? $body['message'] : esc_html__( 'Subscription failed. Please try again.', 'skeleton-wp' );
        wp_send_json_error( array( 'message' => esc_html( $msg ) ) );
    }
}

/* =====================================================
   NEWSLETTER: INLINE ASSETS
   ===================================================== */

add_action( 'wp_enqueue_scripts', 'skeleton_wp_newsletter_assets' );

function skeleton_wp_newsletter_assets() {
    $css = '
.widget-newsletter { padding: 24px 0; }
.widget-newsletter .newsletter-desc { font-size: 0.92rem; line-height: 1.5; margin: 0 0 10px; }
.widget-newsletter .newsletter-input {
    display: block; width: 100%; box-sizing: border-box;
    padding: 8px 10px; margin-bottom: 8px;
    border: 1px solid #b0a090; border-radius: 3px;
    font-size: 0.9rem; font-family: inherit; background: #fff;
}
.widget-newsletter .newsletter-input:focus { outline: 2px solid #7a5c3a; border-color: #7a5c3a; }
.widget-newsletter .newsletter-btn {
    display: block; width: 100%; padding: 9px 12px;
    background: #7a5c3a; color: #fff; border: none; border-radius: 3px;
    font-size: 0.9rem; font-family: inherit; font-weight: 600;
    cursor: pointer; transition: background 0.2s;
}
.widget-newsletter .newsletter-btn:hover { background: #5e4328; }
.widget-newsletter .newsletter-btn:disabled { background: #aaa; cursor: not-allowed; }
#listmonk-message { margin-top: 8px; font-size: 0.88rem; line-height: 1.4; min-height: 1.4em; }
#listmonk-message.newsletter-success { color: #2d6a2d; }
#listmonk-message.newsletter-error   { color: #a32020; }
';
    wp_add_inline_style( 'skeleton-wp-style', $css );

    $js = '
(function () {
    var form = document.getElementById("listmonk-subscribe-form");
    if (!form) return;
    form.addEventListener("submit", function (e) {
        e.preventDefault();
        var msg   = document.getElementById("listmonk-message");
        var btn   = form.querySelector(".newsletter-btn");
        var email = document.getElementById("subscriber-email").value.trim();
        var nonce = form.querySelector("input[name=\'listmonk_nonce\']").value;
        msg.textContent = "";
        msg.className   = "";
        btn.disabled    = true;
        btn.textContent = "Subscribing…";
        var data = new FormData();
        data.append("action", "listmonk_subscribe");
        data.append("email", email);
        data.append("listmonk_nonce", nonce);
        fetch(skeletonWP.ajaxUrl, { method: "POST", body: data })
            .then(function (r) { return r.json(); })
            .then(function (res) {
                msg.textContent = res.data.message;
                msg.className   = res.success ? "newsletter-success" : "newsletter-error";
                if (res.success) { form.reset(); }
            })
            .catch(function () {
                msg.textContent = "An error occurred. Please try again.";
                msg.className   = "newsletter-error";
            })
            .finally(function () {
                btn.disabled    = false;
                btn.textContent = "Subscribe";
            });
    });
})();
';
    wp_add_inline_script( 'skeleton-wp-slider', $js );
}

/**
 * Show 10 posts per page on all archive pages (category, tag, date, author).
 */
add_action( 'pre_get_posts', 'skeleton_wp_archive_posts_per_page' );
function skeleton_wp_archive_posts_per_page( $query ) {
    if ( ! is_admin() && $query->is_main_query() && ( $query->is_archive() || $query->is_home() ) ) {
        $query->set( 'posts_per_page', 10 );
    }
}

/* =====================================================
   NEW POST EMAIL NOTIFICATION
   Sends an email to the site admin whenever another user
   publishes a post. Does NOT fire for the admin's own posts.
   ===================================================== */

add_action( 'transition_post_status', 'skeleton_wp_notify_admin_new_post', 10, 3 );

function skeleton_wp_notify_admin_new_post( $new_status, $old_status, $post ) {
    // Only fire on the first transition into "publish" (not on edits to
    // already-published posts), and only for regular posts.
    if ( 'publish' !== $new_status || 'publish' === $old_status || 'post' !== $post->post_type ) {
        return;
    }

    $post_id     = $post->ID;
    $admin_email = get_option( 'admin_email' );
    $author_id   = absint( $post->post_author );
    $author      = get_userdata( $author_id );

    // Skip if the post author is the admin (same email address).
    if ( $author && $author->user_email === $admin_email ) {
        return;
    }

    $author_name = $author ? $author->display_name : esc_html__( 'Unknown author', 'skeleton-wp' );
    $post_title  = get_the_title( $post_id );
    $post_url    = get_permalink( $post_id );
    $edit_url    = get_edit_post_link( $post_id, 'raw' );
    $site_name   = get_bloginfo( 'name' );

    $subject = sprintf(
        /* translators: 1: site name, 2: post title */
        esc_html__( '[%1$s] New post published: %2$s', 'skeleton-wp' ),
        $site_name,
        $post_title
    );

    $message = sprintf(
        /* translators: 1: author name, 2: post title, 3: post URL, 4: edit URL */
        __(
            "%1\$s just published a new post:\n\n\"%2\$s\"\n\nView: %3\$s\nEdit: %4\$s",
            'skeleton-wp'
        ),
        $author_name,
        $post_title,
        $post_url,
        $edit_url
    );

    wp_mail( $admin_email, $subject, $message );
}
