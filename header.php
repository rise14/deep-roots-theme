<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

    <!-- ==========================================
         TOP BAR
    ========================================== -->
    <div id="top-bar">
        <div class="container">
            <form role="search" method="get" class="widget-search top-bar-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <label class="screen-reader-text" for="s-topbar"><?php esc_html_e( 'Search for:', 'skeleton-wp' ); ?></label>
                <input type="search" id="s-topbar" name="s"
                    placeholder="<?php esc_attr_e( 'Search&hellip;', 'skeleton-wp' ); ?>"
                    value="<?php echo esc_attr( get_search_query() ); ?>">
                <button type="submit" aria-label="<?php esc_attr_e( 'Search', 'skeleton-wp' ); ?>">
                    <?php echo skeleton_wp_icon( 'search' ); ?>
                </button>
            </form>
        </div>
    </div><!-- /#top-bar -->


    <!-- ==========================================
         HEADER / LOGO
    ========================================== -->
    <header id="masthead" class="site-header" role="banner">
        <div class="container">

            <!-- LOGO / BRANDING -->
            <div class="site-branding">
                <?php if ( has_custom_logo() ) : ?>
                    <div class="custom-logo-wrap">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <div class="site-logo-image">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/images/deep-roots-magazine-logo.png' ); ?>"
                                 alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
                                 width="960"
                                 height="216"
                                 class="site-logo" />
                        </a>
                        <?php
                        $description = get_bloginfo( 'description', 'display' );
                        if ( $description || is_customize_preview() ) :
                        ?>
                            <p class="site-description"><?php echo esc_html( $description ); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div><!-- /.site-branding -->

            <!-- PRIMARY NAVIGATION -->
            <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'skeleton-wp' ); ?>">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <?php echo skeleton_wp_icon( 'bars' ); ?>
                    <span class="screen-reader-text"><?php esc_html_e( 'Menu', 'skeleton-wp' ); ?></span>
                </button>
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'nav-menu',
                    'container'      => false,
                    'fallback_cb'    => 'skeleton_wp_fallback_menu',
                ) );
                ?>
            </nav><!-- /#site-navigation -->

        </div><!-- /.container -->
    </header><!-- /#masthead -->


    <?php
    /* ============================================
       IMAGE SLIDER — show only on front page
       ============================================ */
    if ( is_front_page() || is_home() ) :
        $slider_count = get_theme_mod( 'slider_count', 5 );
        $slider_query = skeleton_wp_get_slider_posts( $slider_count );
    ?>

    <?php
    /*
     * Visually hidden H1 for the front page.
     * The site logo acts as the visual brand identifier, but search engines
     * expect a page-level H1. This provides one without disrupting layout.
     */
    ?>
    <h1 class="screen-reader-text">
        <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
        <?php
        $tagline = get_bloginfo( 'description' );
        if ( $tagline ) {
            echo ' &mdash; ' . esc_html( $tagline );
        }
        ?>
    </h1>

    <section id="slider-section" aria-label="<?php esc_attr_e( 'Featured Posts Slider', 'skeleton-wp' ); ?>">
        <div class="slider-wrapper">

            <div class="slider-track" id="sliderTrack">
            <?php if ( $slider_query->have_posts() ) : $slide_i = 0; ?>

                <?php while ( $slider_query->have_posts() ) : $slider_query->the_post(); $slide_i++; ?>
                <?php
                $slide_thumb = get_the_post_thumbnail_url( get_the_ID(), 'skeleton-card' )
                    ?: get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' )
                    ?: get_the_post_thumbnail_url( get_the_ID(), 'full' );
                // First slide is the LCP element: load it eagerly at high priority.
                $slide_img_attr = ( 1 === $slide_i )
                    ? array( 'alt' => the_title_attribute( 'echo=0' ), 'class' => 'slide-image', 'loading' => 'eager', 'fetchpriority' => 'high' )
                    : array( 'alt' => the_title_attribute( 'echo=0' ), 'class' => 'slide-image' );
                ?>
                <div class="slide" data-thumb="<?php echo esc_url( $slide_thumb ); ?>">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail( 'skeleton-slide', $slide_img_attr ); ?>
                        </a>
                    <?php else : ?>
                        <a href="<?php the_permalink(); ?>" class="slide-placeholder">
                            <div class="slide-placeholder-inner">
                                <div class="slide-icon">&#128247;</div>
                                <h2><?php the_title(); ?></h2>
                                <p><?php esc_html_e( 'Click to read more', 'skeleton-wp' ); ?></p>
                            </div>
                        </a>
                    <?php endif; ?>

                    <div class="slide-caption">
                        <h2><a href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_title() ); ?></a></h2>
                        <p>
                            <?php echo esc_html( get_the_date() ); ?>
                        </p>
                    </div>
                </div><!-- /.slide -->
                <?php endwhile; wp_reset_postdata(); ?>

            <?php else : ?>
                <!-- Default placeholder slides when no posts exist yet -->
                <?php
                $placeholders = array(
                    array( 'title' => __( 'Welcome to Your New Site', 'skeleton-wp' ),     'sub' => __( 'Tag posts with "featured-slider" to display them here.', 'skeleton-wp' ) ),
                    array( 'title' => __( 'Beautiful & Responsive Theme', 'skeleton-wp' ), 'sub' => __( 'Built on the lightweight Skeleton CSS framework.', 'skeleton-wp' ) ),
                    array( 'title' => __( 'Fully Customizable', 'skeleton-wp' ),            'sub' => __( 'Use the Customizer to adjust colors, layout, and more.', 'skeleton-wp' ) ),
                );
                foreach ( $placeholders as $ph ) :
                ?>
                <div class="slide">
                    <div class="slide-placeholder">
                        <div class="slide-placeholder-inner">
                            <div class="slide-icon">&#127760;</div>
                            <h2><?php echo esc_html( $ph['title'] ); ?></h2>
                            <p><?php echo esc_html( $ph['sub'] ); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
            </div><!-- /#sliderTrack -->

            <!-- Prev / Next Buttons -->
            <button class="slider-prev" id="sliderPrev" aria-label="<?php esc_attr_e( 'Previous slide', 'skeleton-wp' ); ?>">
                <?php echo skeleton_wp_icon( 'chevron-left' ); ?>
            </button>
            <button class="slider-next" id="sliderNext" aria-label="<?php esc_attr_e( 'Next slide', 'skeleton-wp' ); ?>">
                <?php echo skeleton_wp_icon( 'chevron-right' ); ?>
            </button>

        </div><!-- /.slider-wrapper -->

        <!-- Thumbnail Dots -->
        <div class="slider-dots" id="sliderDots"></div>
    </section><!-- /#slider-section -->

    <?php
    /* Below-slider widget area */
    if ( is_active_sidebar( 'below-slider' ) ) :
    ?>
    <div id="below-slider-widgets">
        <div class="container">
            <?php dynamic_sidebar( 'below-slider' ); ?>
        </div>
    </div>
    <?php
    endif;

    endif; // end is_front_page / is_home
    ?>

    <!-- Breadcrumbs (not on front page) -->
    <?php if ( ! is_front_page() ) : ?>
    <div id="breadcrumbs-bar">
        <div class="container">
            <?php skeleton_wp_breadcrumbs(); ?>
        </div>
    </div>
    <?php endif; ?>

    <?php
    // Department banner: shown on single posts and category archive pages.
    if ( is_single() || is_category() ) :
        $banner_dir  = get_template_directory() . '/images/dept-banners/';
        $banner_base = get_template_directory_uri() . '/images/dept-banners/';
        $banner_src  = '';
        $banner_alt  = '';

        // Build the list of category slugs to check.
        if ( is_category() ) {
            $obj   = get_queried_object();
            $slugs = array( array( 'slug' => $obj->slug, 'name' => $obj->name ) );
        } else {
            $slugs = array_map( function( $cat ) {
                return array( 'slug' => $cat->slug, 'name' => $cat->name );
            }, get_the_category( get_queried_object_id() ) );
        }

        foreach ( $slugs as $item ) {
            $slug = $item['slug'];
            $file = '';
            foreach ( array( 'jpg', 'jpeg', 'png', 'webp', 'gif' ) as $ext ) {
                if ( file_exists( $banner_dir . $slug . '-banner.' . $ext ) ) {
                    $file = $slug . '-banner.' . $ext;
                    break;
                }
            }
            if ( $file && file_exists( $banner_dir . $file ) ) {
                $banner_src = $banner_base . $file;
                $banner_alt = $item['name'];
                break;
            }
        }

        if ( $banner_src ) : ?>
    <div class="dept-banner-bar">
        <img src="<?php echo esc_url( $banner_src ); ?>" alt="<?php echo esc_attr( $banner_alt ); ?>">
    </div>
    <?php endif; ?>
    <?php endif; ?>

    <!-- ==========================================
         MAIN CONTENT WRAPPER
    ========================================== -->
    <div id="content" class="site-content">
        <div class="container">
            <div id="content-area" class="clearfix">
