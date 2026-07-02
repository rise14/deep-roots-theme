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

    <!-- Mailchimp Subscribe -->
    <section class="widget widget-newsletter">
        <link href="//cdn-images.mailchimp.com/embedcode/classic-061523.css" rel="stylesheet" type="text/css">
        <style type="text/css">
            #mc_embed_signup{background:#fff;clear:left;font:14px Helvetica,Arial,sans-serif;width:100%;}
        </style>
        <div id="mc_embed_signup">
            <form action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate">
                <input type="hidden" name="action" value="mailchimp_subscribe">
                <?php wp_nonce_field( 'skeleton_wp_mailchimp_subscribe', 'mailchimp_nonce' ); ?>
                <div id="mc_embed_signup_scroll"><h2>Subscribe</h2>
                    <div class="mc-field-group"><label for="mce-EMAIL">Email Address <span class="asterisk">*</span></label><input type="email" name="EMAIL" class="required email" id="mce-EMAIL" required value=""></div>
                    <?php if ( defined( 'TURNSTILE_SITE_KEY' ) ) : ?>
                        <div class="cf-turnstile" data-sitekey="<?php echo esc_attr( TURNSTILE_SITE_KEY ); ?>"></div>
                    <?php endif; ?>
                    <div id="mce-responses" class="clear">
                        <div class="response" id="mce-error-response" style="display:none;"></div>
                        <div class="response" id="mce-success-response" style="display:none;"></div>
                    </div>
                    <div style="position:absolute;left:-5000px;" aria-hidden="true"><input type="text" name="b_e9f5b683830fc066840db426f_ba09028be2" tabindex="-1" value=""></div>
                    <div class="clear"><input type="submit" name="subscribe" id="mc-embedded-subscribe" class="button" value="Subscribe"></div>
                </div>
            </form>
        </div>
        <script type="text/javascript" src="//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js"></script>
        <script type="text/javascript">(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[3]='ADDRESS';ftypes[3]='address';fnames[4]='PHONE';ftypes[4]='phone';fnames[5]='BIRTHDAY';ftypes[5]='birthday';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
    </section>

    <?php /* Newsletter Subscribe — listmonk form disabled
    <section class="widget widget-newsletter">
        <h3 class="widget-title"><?php esc_html_e( 'Subscribe!', 'skeleton-wp' ); ?></h3>
<form id="listmonk-subscribe-form" novalidate>
            <?php wp_nonce_field( 'listmonk_subscribe', 'listmonk_nonce' ); ?>
            <label for="subscriber-email" class="screen-reader-text"><?php esc_html_e( 'Email address', 'skeleton-wp' ); ?></label>
            <input type="email"
                   id="subscriber-email"
                   name="subscriber_email"
                   class="newsletter-input"
                   placeholder="<?php esc_attr_e( 'Your email address', 'skeleton-wp' ); ?>"
                   required
                   autocomplete="email" />
            <button type="submit" class="newsletter-btn"><?php esc_html_e( 'Subscribe', 'skeleton-wp' ); ?></button>
            <div id="listmonk-message" role="alert" aria-live="polite"></div>
        </form>
    </section>
    */ ?>

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
