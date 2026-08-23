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

    <?php /* Newsletter Subscribe — mc4wp form disabled, replaced by Brevo
    <section class="widget widget-newsletter">
        <?php echo do_shortcode( '[mc4wp_form id="20854"]' ); ?>
    </section>
    */ ?>

    <section class="widget widget-newsletter">
        <!-- Begin Brevo Form -->

        <style>
            @font-face {
                font-display: block;
                font-family: Roboto;
                src: url(https://assets.brevo.com/font/Roboto/Latin/normal/normal/7529907e9eaf8ebb5220c5f9850e3811.woff2) format("woff2"), url(https://assets.brevo.com/font/Roboto/Latin/normal/normal/25c678feafdc175a70922a116c9be3e7.woff) format("woff")
            }

            @font-face {
                font-display: fallback;
                font-family: Roboto;
                font-weight: 600;
                src: url(https://assets.brevo.com/font/Roboto/Latin/medium/normal/6e9caeeafb1f3491be3e32744bc30440.woff2) format("woff2"), url(https://assets.brevo.com/font/Roboto/Latin/medium/normal/71501f0d8d5aa95960f6475d5487d4c2.woff) format("woff")
            }

            @font-face {
                font-display: fallback;
                font-family: Roboto;
                font-weight: 700;
                src: url(https://assets.brevo.com/font/Roboto/Latin/bold/normal/3ef7cf158f310cf752d5ad08cd0e7e60.woff2) format("woff2"), url(https://assets.brevo.com/font/Roboto/Latin/bold/normal/ece3a1d82f18b60bcce0211725c476aa.woff) format("woff")
            }

            :where(.sib-form-message-panel) {
                display: none;
            }

            :where(.sib-form-message-panel .sib-notification__icon) {
                width: 20px;
                height: 20px;
            }


            #sib-container input:-ms-input-placeholder {
                font-family: Helvetica, sans-serif;
                text-align: left;
                color: #c0ccda;
            }

            #sib-container input::placeholder {
                font-family: Helvetica, sans-serif;
                text-align: left;
                color: #c0ccda;
            }

            #sib-container textarea::placeholder {
                font-family: Helvetica, sans-serif;
                text-align: left;
                color: #c0ccda;
            }


            #sib-container a {
                text-decoration: underline;
                color: #2BB2FC;
            }
        </style>
        <link rel="stylesheet" href="https://sibforms.com/forms/end-form/build/sib-styles.css">

        <div class="sib-form" style="text-align: center;
                 background-color: #EFF2F7;



                ">
            <div id="sib-form-container" class="sib-form-container">
                <div id="error-message" class="sib-form-message-panel" style="font-family:Helvetica, sans-serif; font-size:16px; text-align:left; color:#661d1d; background-color:#ffeded; border-color:#ff4949; border-radius:3px;
                max-width:540px;">
                    <div class="sib-form-message-panel__text sib-form-message-panel__text--center">
                        <svg viewBox="0 0 512 512" class="sib-icon sib-notification__icon">
                            <path d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-11.49 120h22.979c6.823 0 12.274 5.682 11.99 12.5l-7 168c-.268 6.428-5.556 11.5-11.99 11.5h-8.979c-6.433 0-11.722-5.073-11.99-11.5l-7-168c-.283-6.818 5.167-12.5 11.99-12.5zM256 340c-15.464 0-28 12.536-28 28s12.536 28 28 28 28-12.536 28-28-12.536-28-28-28z" />
                        </svg>
                        <span class="sib-form-message-panel__inner-text">
                            Your subscription could not be saved. Please try again.
                        </span>
                    </div>
                </div>
                <div></div>
                <div id="success-message" class="sib-form-message-panel" style="font-family:Helvetica, sans-serif; font-size:16px; text-align:left; color:#085229; background-color:#e7faf0; border-color:#13ce66; border-radius:3px;
                max-width:540px;">
                    <div class="sib-form-message-panel__text sib-form-message-panel__text--center">
                        <svg viewBox="0 0 512 512" class="sib-icon sib-notification__icon">
                            <path d="M256 8C119.033 8 8 119.033 8 256s111.033 248 248 248 248-111.033 248-248S392.967 8 256 8zm0 464c-118.664 0-216-96.055-216-216 0-118.663 96.055-216 216-216 118.664 0 216 96.055 216 216 0 118.663-96.055 216-216 216zm141.63-274.961L217.15 376.071c-4.705 4.667-12.303 4.637-16.97-.068l-85.878-86.572c-4.667-4.705-4.637-12.303.068-16.97l8.52-8.451c4.705-4.667 12.303-4.637 16.97.068l68.976 69.533 163.441-162.13c4.705-4.667 12.303-4.637 16.97.068l8.451 8.52c4.668 4.705 4.637 12.303-.068 16.97z" />
                        </svg>
                        <span class="sib-form-message-panel__inner-text">
                            Your subscription has been successful.
                        </span>
                    </div>
                </div>
                <div></div>
                <div id="sib-container" class="sib-container--large sib-container--vertical" style="max-width:540px; text-align:center; background-color:rgba(255,255,255,1); border-width:1px; border-style:solid; border-color:#C0CCD9; border-radius:3px; direction:ltr">
                    <form id="sib-form" method="POST" action="https://f2e41c68.sibforms.com/serve/MUIFAGBZV5IrOJt7IfcPj-3pVhV5h5TKPGa9glW1lYkS4SoYvnRq3AlGLp9Bxam_dLMNNuMD1epRX25aHVAoRy952zJs51wU7I5Tgo8Gnu26RG0dehwfZtyFp6L797wgvGOdlRxBkcXg1BQNYhTykkY00VdiOme7-r5yRjd01xGDvtNJUcnkZCoVk86gNjY_h6KsERmCgIChCoPlcw==" data-type="subscription">

                        <div style="padding: 8px 0;">
                            <div class="sib-form-block" style="font-family:Helvetica, sans-serif; font-size:22px; font-weight:700; text-align:left; color:#3C4858; background-color:transparent; text-align:left">
                                <p>Newsletter</p>
                            </div>
                        </div>

                        <div style="padding: 8px 0;">
                            <div class="sib-form-block" style="font-family:Helvetica, sans-serif; font-size:16px; text-align:left; color:#3C4858; background-color:transparent; text-align:left">
                                <div class="sib-text-form-block">
                                    <p>Subscribe to our newsletter and stay updated.</p>
                                </div>
                            </div>
                        </div>

                        <div style="padding: 8px 0;">
                            <div class="sib-input sib-form-block">
                                <div class="form__entry entry_block">
                                    <div class="form__label-row ">
                                        <label class="entry__label" style="font-weight: 700; text-align: left; font-family:Helvetica, sans-serif; font-size:16px; font-weight:700; text-align:left; color:#3c4858;" for="EMAIL" data-required="*">Enter your email address to subscribe</label>

                                        <div class="entry__field">
                                            <input class="input " type="text" id="EMAIL" name="EMAIL" autocomplete="off" value="" placeholder="EMAIL" data-required="true" required />
                                        </div>
                                    </div>

                                    <label class="entry__error entry__error--primary" style="font-family:Helvetica, sans-serif; font-size:16px; text-align:left; color:#661d1d; background-color:#ffeded; border-color:#ff4949; border-radius:3px;">
                                    </label>

                                    <label class="entry__specification" style="font-family:Helvetica, sans-serif; font-size:12px; text-align:left; color:#8390A4; text-align: left ">
                                        Provide your email address to subscribe. For e.g abc@xyz.com
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div style="padding: 8px 0;">
                            <div class="sib-form-block" style="text-align: left">
                                <button class="sib-form-block__button sib-form-block__button-with-loader" style="font-family:Helvetica, sans-serif; font-size:16px; font-weight:700; text-align:left; color:#FFFFFF; background-color:#3E4857; border-width:0px; border-radius:3px;" form="sib-form" type="submit">
                                    <svg class="icon clickable__icon progress-indicator__icon sib-hide-loader-icon" viewBox="0 0 512 512">
                                        <path d="M460.116 373.846l-20.823-12.022c-5.541-3.199-7.54-10.159-4.663-15.874 30.137-59.886 28.343-131.652-5.386-189.946-33.641-58.394-94.896-95.833-161.827-99.676C261.028 55.961 256 50.751 256 44.352V20.309c0-6.904 5.808-12.337 12.703-11.982 83.556 4.306 160.163 50.864 202.11 123.677 42.063 72.696 44.079 162.316 6.031 236.832-3.14 6.148-10.75 8.461-16.728 5.01z" />
                                    </svg>
                                    SUBSCRIBE
                                </button>
                            </div>
                        </div>

                        <div style="padding: 8px 0;">
                            <div class="g-recaptcha-v3" data-sitekey="6Ld2GZQtAAAAAKkFVmfjMhfii4AvachXs-tI6A4M" style="display: none"></div>
                        </div>

                        <input type="text" name="email_address_check" value="" class="input--hidden">
                        <input type="hidden" name="locale" value="en">
                    </form>
                </div>
            </div>
        </div>

        <script>
            window.REQUIRED_CODE_ERROR_MESSAGE = 'Please choose a country code';
            window.LOCALE = 'en';

            window.EMAIL_INVALID_MESSAGE = window.SMS_INVALID_MESSAGE = "The information provided is invalid. Please review the field format and try again.";

            window.REQUIRED_ERROR_MESSAGE = "This field cannot be left blank. ";

            window.GENERIC_INVALID_MESSAGE = "The information provided is invalid. Please review the field format and try again.";

            window.INVALID_NUMBER = "The information provided is invalid. Please review the field format and try again.";

            window.INVALID_DATE = "Please enter a valid date";

            window.REQUIRED_MULTISELECT_MESSAGE = 'Please select at least 1 option';

            window.translation = {
                common: {
                    selectedList: '{quantity} list selected',
                    selectedLists: '{quantity} lists selected',
                    selectedOption: '{quantity} selected',
                    selectedOptions: '{quantity} selected',
                }
            };

            var AUTOHIDE = Boolean(0);
        </script>
        <script defer src="https://sibforms.com/forms/end-form/build/main.js"></script>
        <script src="https://www.google.com/recaptcha/api.js?render=6Ld2GZQtAAAAAKkFVmfjMhfii4AvachXs-tI6A4M&hl=en" async defer></script>

        <!-- End Brevo Form -->
    </section>

    <?php /* Newsletter Subscribe — mailchimp form disabled, replaced by plugin
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
                        <div class="cf-turnstile" data-sitekey="<?php echo esc_attr( TURNSTILE_SITE_KEY ); ?>" data-size="compact"></div>
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
    </section>
    */ ?>

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

    <br />

    <!-- Panthera -->
    <section class="widget widget-sidebar-banner">
        <a href="http://www.panthera.org" target="_blank" rel="noopener noreferrer">
            <img src="https://deeprootsmag.org/sidebar/panthera-logo.jpg"
                 alt="Panthera"
                 style="width:100%;height:auto;display:block;" />
        </a>
    </section>

    <br />

    <!-- Save The Manatee -->
    <section class="widget widget-sidebar-banner">
        <a href="http://www.savethemanatee.org" target="_blank" rel="noopener noreferrer">
            <img src="https://deeprootsmag.org/sidebar/manatee-holiday.jpg"
                 alt="Save The Manatee"
                 style="width:100%;height:auto;display:block;" />
        </a>
    </section>

    <br />

    <!-- Matthew Shepard Foundation -->
    <section class="widget widget-sidebar-banner">
        <a href="https://www.matthewshepard.org/" target="_blank" rel="noopener noreferrer">
            <img src="https://deeprootsmag.org/sidebar/shepard-vert-banner.jpg"
                 alt="Matthew Shepard Foundation"
                 style="width:100%;height:auto;display:block;" />
        </a>
    </section>

</aside><!-- /#secondary -->
