<?php
/**
 * Template for the Contact page (slug: contact).
 *
 * @package Skeleton_WP
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'contact-page' ); ?>>

            <header class="entry-header">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            </header>

            <div class="entry-content contact-page-content">

                <p class="contact-intro">Have a question, a tip, or just want to say hello? Drop us a line — we&rsquo;d love to hear from you.</p>

                <form class="contact-form" action="https://formspree.io/f/mkolowbb" method="POST">
                    <div class="contact-form-group">
                        <label for="contact-email"><?php esc_html_e( 'Your Email', 'skeleton-wp' ); ?></label>
                        <input
                            id="contact-email"
                            type="email"
                            name="email"
                            placeholder="you@example.com"
                            required
                            autocomplete="email"
                        />
                    </div>
                    <div class="contact-form-group">
                        <label for="contact-message"><?php esc_html_e( 'Your Message', 'skeleton-wp' ); ?></label>
                        <textarea
                            id="contact-message"
                            name="message"
                            rows="8"
                            placeholder="<?php esc_attr_e( 'Write your message here…', 'skeleton-wp' ); ?>"
                            required
                        ></textarea>
                    </div>
                    <button type="submit" class="contact-submit">
                        <?php esc_html_e( 'Send Message', 'skeleton-wp' ); ?>
                    </button>
                </form>

            </div>

            <footer class="entry-footer">
                <?php edit_post_link( esc_html__( 'Edit This Page', 'skeleton-wp' ), '<span class="edit-link">', '</span>' ); ?>
            </footer>

        </article>

        <?php endwhile; ?>

    </main>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
