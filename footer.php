            </div><!-- /#content-area -->
        </div><!-- /.container -->
    </div><!-- /#content -->


    <!-- ==========================================
         FOOTER
    ========================================== -->
    <footer id="colophon" class="site-footer" role="contentinfo">

        <!-- Footer Widgets (3 columns) -->
        <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
        <div class="container">
            <div class="footer-widgets">

                <!-- Footer Column 1 — Logo / About -->
                <div class="footer-widget-area footer-col-1">
                    <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                        <?php dynamic_sidebar( 'footer-1' ); ?>
                    <?php else : ?>
                        <div class="footer-logo">
                            <?php if ( has_custom_logo() ) : ?>
                                <?php the_custom_logo(); ?>
                            <?php else : ?>
                                <div class="footer-site-title"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></div>
                                <div class="footer-tagline"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></div>
                            <?php endif; ?>
                        </div>
                        <p><?php esc_html_e( 'Your source for the latest news, articles, and features. Add widgets to the Footer 1 sidebar area to customise this column.', 'skeleton-wp' ); ?></p>
                        <div class="footer-social">
                            <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                            <a href="<?php echo esc_url( get_feed_link() ); ?>" aria-label="RSS"><i class="fa fa-rss"></i></a>
                        </div>
                    <?php endif; ?>
                </div><!-- /.footer-col-1 -->

                <!-- Footer Column 2 -->
                <div class="footer-widget-area footer-col-2">
                    <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                        <?php dynamic_sidebar( 'footer-2' ); ?>
                    <?php else : ?>
                        <h4 class="widget-title"><?php esc_html_e( 'Quick Links', 'skeleton-wp' ); ?></h4>
                        <?php wp_nav_menu( array(
                            'theme_location' => 'footer-links',
                            'fallback_cb'    => function() {
                                echo '<ul>';
                                $pages = get_pages( array( 'number' => 6, 'sort_column' => 'menu_order' ) );
                                foreach ( $pages as $page ) {
                                    printf( '<li><a href="%s">%s</a></li>',
                                        esc_url( get_permalink( $page->ID ) ),
                                        esc_html( $page->post_title ) );
                                }
                                echo '</ul>';
                            },
                            'container' => false,
                        ) ); ?>
                    <?php endif; ?>
                </div><!-- /.footer-col-2 -->

                <!-- Footer Column 3 -->
                <div class="footer-widget-area footer-col-3">
                    <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                        <?php dynamic_sidebar( 'footer-3' ); ?>
                    <?php else : ?>
                        <h4 class="widget-title"><?php esc_html_e( 'Recent Posts', 'skeleton-wp' ); ?></h4>
                        <?php
                        $recent = new WP_Query( array(
                            'posts_per_page'      => 4,
                            'post_status'         => 'publish',
                            'no_found_rows'       => true,
                            'ignore_sticky_posts' => true,
                        ) );
                        if ( $recent->have_posts() ) :
                        ?>
                        <ul class="footer-recent-posts">
                        <?php while ( $recent->have_posts() ) : $recent->the_post(); ?>
                            <li>
                                <a href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_title() ); ?></a>
                                <span style="display:block;font-size:1.1rem;color:#666;margin-top:3px;">
                                    <?php echo esc_html( get_the_date() ); ?>
                                </span>
                            </li>
                        <?php endwhile; wp_reset_postdata(); ?>
                        </ul>
                        <?php endif; ?>
                    <?php endif; ?>
                </div><!-- /.footer-col-3 -->

            </div><!-- /.footer-widgets -->
        </div><!-- /.container -->
        <?php endif; ?>

        <!-- Footer Bottom Bar -->
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-credits">
                    <p>
                        <strong><?php esc_html_e( 'Founder/Publisher/Editor:', 'skeleton-wp' ); ?></strong>
                        <?php esc_html_e( 'David McGee', 'skeleton-wp' ); ?>
                    </p>
                    <p>
                        <strong><?php esc_html_e( 'Design/IT:', 'skeleton-wp' ); ?></strong>
                        <?php esc_html_e( 'Kieran McGee', 'skeleton-wp' ); ?>
                    </p>
                    <p>
                        <strong><?php esc_html_e( 'Contributing Editors:', 'skeleton-wp' ); ?></strong>
                        <?php esc_html_e( 'Billy Altman, Julie Danielson (Jules, Seven Impossible Things Before Breakfast), Christopher Hill, Robert Hugill (Classical), David Manners, Bob Marovich (Gospel), Derk Richardson, Michael Sigman, Duncan Strauss (Talking Animals), Chip Stern', 'skeleton-wp' ); ?>
                    </p>
                    <p>
                        <strong><?php esc_html_e( 'Mailing Address:', 'skeleton-wp' ); ?></strong>
                        <?php esc_html_e( 'Deep Roots, 201 West 85th Street-5B, New York, NY 10024', 'skeleton-wp' ); ?>
                    </p>
                    <p>
                        <strong><?php esc_html_e( 'Email:', 'skeleton-wp' ); ?></strong>
                        <a href="mailto:deeprootsmag@gmail.com">deeprootsmag@gmail.com</a>
                    </p>
                </div>

                <div class="footer-copyright">
                    <?php
                    $copyright = get_theme_mod( 'footer_copyright',
                        sprintf( '&copy; %d %s. %s',
                            date('Y'),
                            get_bloginfo('name'),
                            esc_html__( 'All Rights Reserved.', 'skeleton-wp' ) )
                    );
                    echo wp_kses_post( $copyright );
                    ?>
                </div>
            </div>
        </div><!-- /.footer-bottom -->

    </footer><!-- /#colophon -->

</div><!-- /#page -->

<?php wp_footer(); ?>

</body>
</html>
