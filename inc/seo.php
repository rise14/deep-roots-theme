<?php
/**
 * SEO enhancements: preconnect hints, canonical URL, meta description,
 * Open Graph, Twitter Cards, and JSON-LD structured data.
 *
 * All functions bail early if Yoast SEO or Rank Math is active so there
 * is never a conflict with those plugins.
 *
 * @package Skeleton_WP
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* =====================================================
   HELPERS
   ===================================================== */

/**
 * Returns true if a full-featured SEO plugin is handling meta output.
 */
function skeleton_wp_seo_plugin_active() {
    return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEOP_VERSION' );
}

/**
 * Returns a clean, trimmed description string from the current context.
 */
function skeleton_wp_get_page_description() {
    $description = '';

    if ( is_singular() ) {
        $description = get_the_excerpt( get_the_ID() );
        if ( empty( $description ) ) {
            $description = wp_trim_words( get_post_field( 'post_content', get_the_ID() ), 30, '' );
        }
    } elseif ( is_front_page() || is_home() ) {
        $description = get_bloginfo( 'description' );
    } elseif ( is_category() || is_tag() || is_tax() ) {
        $description = wp_strip_all_tags( term_description() );
    } elseif ( is_author() ) {
        $description = get_the_author_meta( 'description', get_queried_object_id() );
    }

    return wp_strip_all_tags( wp_trim_words( $description, 30, '' ) );
}

/**
 * Returns the best available image URL for the current page.
 */
function skeleton_wp_get_page_image() {
    $image = '';

    if ( is_singular() && has_post_thumbnail() ) {
        $image = get_the_post_thumbnail_url( get_the_ID(), 'skeleton-single' );
    }

    if ( ! $image ) {
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        if ( $custom_logo_id ) {
            $logo_data = wp_get_attachment_image_src( $custom_logo_id, 'full' );
            $image     = $logo_data ? $logo_data[0] : '';
        }
    }

    if ( ! $image ) {
        $image = get_template_directory_uri() . '/images/deep-roots-magazine-logo.png';
    }

    return $image;
}

/* =====================================================
   PRECONNECT HINTS
   ===================================================== */

add_action( 'wp_head', 'skeleton_wp_preconnect_hints', 1 );
function skeleton_wp_preconnect_hints() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}

/* =====================================================
   FAVICON
   Theme-bundled icon. Skipped if a Site Icon is set in the
   Customizer (WordPress outputs its own tags in that case).
   ===================================================== */

add_action( 'wp_head', 'skeleton_wp_favicon', 2 );
function skeleton_wp_favicon() {
    if ( has_site_icon() ) return;

    $icon = get_template_directory_uri() . '/images/favicon.jpg';
    printf( '<link rel="icon" type="image/jpeg" href="%s">' . "\n", esc_url( $icon ) );
    printf( '<link rel="apple-touch-icon" href="%s">' . "\n", esc_url( $icon ) );
}

/* =====================================================
   CANONICAL URL
   ===================================================== */

/**
 * Appends the current /page/N/ segment to a base URL so paginated archives
 * get a self-referencing canonical instead of all pointing at page 1.
 */
function skeleton_wp_add_paged_segment( $url ) {
    $paged = absint( get_query_var( 'paged' ) );
    if ( $paged > 1 && $url ) {
        $url = user_trailingslashit( trailingslashit( $url ) . 'page/' . $paged, 'paged' );
    }
    return $url;
}

add_action( 'wp_head', 'skeleton_wp_canonical_tag', 2 );
function skeleton_wp_canonical_tag() {
    if ( skeleton_wp_seo_plugin_active() ) return;

    $canonical = '';

    if ( is_singular() ) {
        $canonical = get_permalink();
    } elseif ( is_front_page() || is_home() ) {
        $canonical = skeleton_wp_add_paged_segment( home_url( '/' ) );
    } elseif ( is_category() ) {
        $canonical = skeleton_wp_add_paged_segment( get_category_link( get_queried_object_id() ) );
    } elseif ( is_tag() ) {
        $canonical = skeleton_wp_add_paged_segment( get_tag_link( get_queried_object_id() ) );
    } elseif ( is_author() ) {
        $canonical = skeleton_wp_add_paged_segment( get_author_posts_url( get_queried_object()->ID ) );
    }

    if ( $canonical ) {
        printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $canonical ) );
    }
}

/* =====================================================
   NOINDEX SEARCH RESULTS
   ===================================================== */

add_action( 'wp_head', 'skeleton_wp_noindex_search', 2 );
function skeleton_wp_noindex_search() {
    if ( skeleton_wp_seo_plugin_active() ) return;
    if ( is_search() ) {
        echo '<meta name="robots" content="noindex, follow">' . "\n";
    }
}

/* =====================================================
   META DESCRIPTION FALLBACK
   ===================================================== */

add_action( 'wp_head', 'skeleton_wp_meta_description', 3 );
function skeleton_wp_meta_description() {
    if ( skeleton_wp_seo_plugin_active() ) return;

    $description = skeleton_wp_get_page_description();

    if ( $description ) {
        printf( '<meta name="description" content="%s">' . "\n", esc_attr( $description ) );
    }
}

/* =====================================================
   OPEN GRAPH TAGS
   ===================================================== */

add_action( 'wp_head', 'skeleton_wp_open_graph', 4 );
function skeleton_wp_open_graph() {
    if ( skeleton_wp_seo_plugin_active() ) return;

    $type        = is_singular() ? 'article' : 'website';
    $title       = is_singular() ? get_the_title() : get_bloginfo( 'name' );
    $description = skeleton_wp_get_page_description();
    $image       = skeleton_wp_get_page_image();

    // Canonical URL for og:url
    $url = '';
    if ( is_singular() ) {
        $url = get_permalink();
    } elseif ( is_front_page() || is_home() ) {
        $url = skeleton_wp_add_paged_segment( home_url( '/' ) );
    } else {
        global $wp;
        $url = home_url( add_query_arg( array(), $wp->request ) );
    }

    echo '<meta property="og:type" content="' . esc_attr( $type ) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
    echo '<meta property="og:locale" content="' . esc_attr( get_locale() ) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";

    if ( $title ) {
        echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
    }
    if ( $description ) {
        echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
    }
    if ( $image ) {
        echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
        echo '<meta property="og:image:alt" content="' . esc_attr( $title ) . '">' . "\n";

        // Dimensions help social platforms render the card without reflow.
        if ( is_singular() && has_post_thumbnail() ) {
            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'skeleton-single' );
            if ( $thumb ) {
                echo '<meta property="og:image:width" content="' . absint( $thumb[1] ) . '">' . "\n";
                echo '<meta property="og:image:height" content="' . absint( $thumb[2] ) . '">' . "\n";
            }
        }
    }

    // Article-specific timestamps
    if ( 'article' === $type ) {
        echo '<meta property="article:published_time" content="' . esc_attr( get_the_date( 'c' ) ) . '">' . "\n";
        echo '<meta property="article:modified_time" content="' . esc_attr( get_the_modified_date( 'c' ) ) . '">' . "\n";
    }
}

/* =====================================================
   TWITTER CARD TAGS
   ===================================================== */

add_action( 'wp_head', 'skeleton_wp_twitter_cards', 5 );
function skeleton_wp_twitter_cards() {
    if ( skeleton_wp_seo_plugin_active() ) return;

    $title       = is_singular() ? get_the_title() : get_bloginfo( 'name' );
    $description = skeleton_wp_get_page_description();
    $image       = skeleton_wp_get_page_image();
    $card        = ( is_singular() && has_post_thumbnail() ) ? 'summary_large_image' : 'summary';

    echo '<meta name="twitter:card" content="' . esc_attr( $card ) . '">' . "\n";

    if ( $title ) {
        echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
    }
    if ( $description ) {
        echo '<meta name="twitter:description" content="' . esc_attr( $description ) . '">' . "\n";
    }
    if ( $image ) {
        echo '<meta name="twitter:image" content="' . esc_url( $image ) . '">' . "\n";
    }
}

/* =====================================================
   JSON-LD: ORGANIZATION SCHEMA
   Outputs on every page — declares Deep Roots as a
   NewsMediaOrganization so Google knows who runs the site.
   ===================================================== */

add_action( 'wp_head', 'skeleton_wp_schema_organization', 6 );
function skeleton_wp_schema_organization() {
    $logo_url       = '';
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    if ( $custom_logo_id ) {
        $logo_data = wp_get_attachment_image_src( $custom_logo_id, 'full' );
        $logo_url  = $logo_data ? $logo_data[0] : '';
    }
    if ( ! $logo_url ) {
        $logo_url = get_template_directory_uri() . '/images/deep-roots-magazine-logo.png';
    }

    $schema = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'NewsMediaOrganization',
        'name'        => get_bloginfo( 'name' ),
        'url'         => home_url( '/' ),
        'description' => get_bloginfo( 'description' ),
        'email'       => 'deeprootsmag@gmail.com',
        'logo'        => array(
            '@type' => 'ImageObject',
            'url'   => $logo_url,
        ),
        'address'     => array(
            '@type'           => 'PostalAddress',
            'streetAddress'   => '201 West 85th Street-5B',
            'addressLocality' => 'New York',
            'addressRegion'   => 'NY',
            'postalCode'      => '10024',
            'addressCountry'  => 'US',
        ),
    );

    echo '<script type="application/ld+json">' . "\n";
    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
    echo "\n" . '</script>' . "\n";
}

/* =====================================================
   JSON-LD: ARTICLE SCHEMA (single posts only)
   ===================================================== */

add_action( 'wp_head', 'skeleton_wp_schema_article', 7 );
function skeleton_wp_schema_article() {
    if ( ! is_singular( 'post' ) ) return;

    $post_id    = get_the_ID();
    $author_id  = absint( get_post_field( 'post_author', $post_id ) );
    $image_url  = get_the_post_thumbnail_url( $post_id, 'skeleton-single' );

    $logo_url       = '';
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    if ( $custom_logo_id ) {
        $logo_data = wp_get_attachment_image_src( $custom_logo_id, 'full' );
        $logo_url  = $logo_data ? $logo_data[0] : '';
    }
    if ( ! $logo_url ) {
        $logo_url = get_template_directory_uri() . '/images/deep-roots-magazine-logo.png';
    }

    $description = get_the_excerpt( $post_id );
    if ( empty( $description ) ) {
        $description = wp_trim_words( get_post_field( 'post_content', $post_id ), 30, '' );
    }
    $description = wp_strip_all_tags( $description );

    $schema = array(
        '@context'      => 'https://schema.org',
        '@type'         => 'NewsArticle',
        'headline'      => get_the_title( $post_id ),
        'description'   => $description,
        'url'           => get_permalink( $post_id ),
        'datePublished' => get_the_date( 'c', $post_id ),
        'dateModified'  => get_the_modified_date( 'c', $post_id ),
        'author'        => array(
            '@type' => 'Person',
            'name'  => get_the_author_meta( 'display_name', $author_id ),
            'url'   => get_author_posts_url( $author_id ),
        ),
        'publisher'     => array(
            '@type' => 'NewsMediaOrganization',
            'name'  => get_bloginfo( 'name' ),
            'logo'  => array(
                '@type' => 'ImageObject',
                'url'   => $logo_url,
            ),
        ),
    );

    if ( $image_url ) {
        $schema['image'] = array(
            '@type' => 'ImageObject',
            'url'   => $image_url,
        );
    }

    $cats = get_the_category( $post_id );
    if ( $cats ) {
        $schema['articleSection'] = $cats[0]->name;
        $schema['keywords']       = implode( ', ', wp_list_pluck( $cats, 'name' ) );
    }

    echo '<script type="application/ld+json">' . "\n";
    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
    echo "\n" . '</script>' . "\n";
}

/* =====================================================
   JSON-LD: BREADCRUMB SCHEMA
   Mirrors the visible breadcrumbs output by skeleton_wp_breadcrumbs().
   ===================================================== */

add_action( 'wp_head', 'skeleton_wp_schema_breadcrumbs', 8 );
function skeleton_wp_schema_breadcrumbs() {
    if ( is_front_page() ) return;

    $items = array(
        array(
            '@type'    => 'ListItem',
            'position' => 1,
            'name'     => get_bloginfo( 'name' ),
            'item'     => home_url( '/' ),
        ),
    );

    $position = 2;

    if ( is_singular( 'post' ) ) {
        $cats = get_the_category();
        if ( $cats ) {
            $items[] = array(
                '@type'    => 'ListItem',
                'position' => $position++,
                'name'     => $cats[0]->name,
                'item'     => get_category_link( $cats[0]->term_id ),
            );
        }
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position,
            'name'     => get_the_title(),
            'item'     => get_permalink(),
        );
    } elseif ( is_singular( 'page' ) ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position,
            'name'     => get_the_title(),
            'item'     => get_permalink(),
        );
    } elseif ( is_category() ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position,
            'name'     => single_cat_title( '', false ),
            'item'     => get_category_link( get_queried_object_id() ),
        );
    } elseif ( is_tag() ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position,
            'name'     => single_tag_title( '', false ),
            'item'     => get_tag_link( get_queried_object_id() ),
        );
    } elseif ( is_author() ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position,
            'name'     => get_the_author_meta( 'display_name', get_queried_object_id() ),
            'item'     => get_author_posts_url( get_queried_object_id() ),
        );
    }

    // Only output if there's more than just the home item
    if ( count( $items ) < 2 ) return;

    $schema = array(
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $items,
    );

    echo '<script type="application/ld+json">' . "\n";
    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
    echo "\n" . '</script>' . "\n";
}
