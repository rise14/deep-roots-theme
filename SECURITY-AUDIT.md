# Security Audit — Deep Roots Theme (Skeleton WP)
**Date:** 2026-06-04  
**Scope:** All theme PHP, JS, and template files

---

## Summary

| Severity | Count |
|----------|-------|
| High     | 1     |
| Medium   | 4     |
| Low      | 3     |
| Info     | 2     |

Overall the theme is in decent shape. Output escaping is largely consistent, the AJAX handler is nonce-protected, and the Customizer settings all have sanitize callbacks. The issues below are real but confined in blast radius.

---

## HIGH

### 1. Unescaped output: `get_search_query()` in two search forms

**Files:** `header.php` line 24, `searchform.php` line 12

```php
// header.php — VULNERABLE
value="<?php echo get_search_query(); ?>">

// searchform.php — VULNERABLE
value="<?php echo get_search_query(); ?>" name="s">
```

`get_search_query()` returns the raw `?s=` query string. Without escaping, a crafted URL like `?s="><script>alert(1)</script>` injects into the `value` attribute — a reflected XSS. WordPress's `get_search_query()` accepts an optional `$escaped` boolean parameter that defaults to `true` in most WP versions, but relying on that default is fragile. The safe form is explicit:

```php
value="<?php echo esc_attr( get_search_query() ); ?>"
```

**Fix both files.**

---

## MEDIUM

### 2. Unescaped breadcrumb output in `functions.php`

**File:** `functions.php` lines 280–303

Several branches of `skeleton_wp_breadcrumbs()` echo without escaping:

```php
echo single_cat_title( '', false );   // line 281 — no escape
echo single_tag_title( '', false );   // line 283 — no escape
the_author();                          // line 285 — no escape
echo get_the_date();                   // lines 287, 289, 291 — no escape
printf( esc_html__( 'Search: %s', 'skeleton-wp' ), get_search_query() ); // line 293 — search query unescaped in sprintf
the_title();                           // line 303 — no escape
```

While WordPress filters most of these values on save, they should still be wrapped in `esc_html()` at output. The `get_search_query()` case is the most dangerous (same reflected-XSS vector as issue #1). The `the_title()` / `the_author()` cases depend on data sanitized by WP core on input, but defense-in-depth requires escaping at output too.

**Fixes:**
```php
echo esc_html( single_cat_title( '', false ) );
echo esc_html( single_tag_title( '', false ) );
echo esc_html( get_the_author() );
echo esc_html( get_the_date() );
printf( esc_html__( 'Search: %s', 'skeleton-wp' ), esc_html( get_search_query() ) );
echo esc_html( get_the_title() );
```

### 3. Unescaped output in template files — `the_title()` and `get_the_date()`

**Files:** `index.php`, `front-page.php`, `archive.php`, `footer.php`, `header.php`

Multiple places call `the_title()` (which echoes unescaped) inside anchor tags, and `get_the_date()` / `the_date()` without wrapping:

```php
// index.php line 71, front-page.php line 75, archive.php line 54
<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

// index.php line 59, archive.php line 47, footer.php line 83
<?php echo get_the_date(); ?>
<?php the_date(); ?>   // header.php line 148
```

Post titles go through `wp_filter_kses` on save for non-admins, but admin-authored titles can contain unfiltered HTML. `the_title()` does not escape for HTML context. Use `the_title_attribute()` for `value`/`alt` contexts and `esc_html( get_the_title() )` inside link text:

```php
<a href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_title() ); ?></a>
echo esc_html( get_the_date() );
```

### 4. `get_bloginfo( 'description' )` echoed unescaped in `header.php`

**File:** `header.php` line 58

```php
<p class="site-description"><?php echo $description; // phpcs:ignore ?></p>
```

The `phpcs:ignore` comment was added to silence the linter, but the underlying issue remains. The site tagline is admin-controlled, but should still be escaped:

```php
<p class="site-description"><?php echo esc_html( $description ); ?></p>
```

### 5. `bloginfo( 'name' )` / `bloginfo( 'description' )` unescaped in `footer.php`

**File:** `footer.php` lines 26–27

```php
<div class="footer-site-title"><?php bloginfo( 'name' ); ?></div>
<div class="footer-tagline"><?php bloginfo( 'description' ); ?></div>
```

`bloginfo()` echoes with `display` context by default, which applies `convert_chars()` but not full HTML escaping. Use `esc_html( get_bloginfo('name') )` for consistent output escaping.

---

## LOW

### 6. `skeletonWP.ajaxUrl` exposes admin-ajax.php to the front-end

**File:** `functions.php` line 134

```php
wp_localize_script( 'skeleton-wp-slider', 'skeletonWP', array(
    'ajaxUrl' => admin_url( 'admin-ajax.php' ),
    ...
) );
```

This is standard WordPress practice and admin-ajax.php is publicly accessible by design. However, it tells any visitor (or scraper) the exact admin-ajax URL and that AJAX load-more is wired up. Consider filtering the localized data to only include what the JS actually needs — remove `ajaxUrl` if the current page has no "load more" button, or move it to a dedicated load-more script handle rather than the slider script.

### 7. AJAX handler lacks an explicit capability check for post type restriction

**File:** `functions.php` lines 467–487

The `skeleton_wp_load_more_posts` AJAX handler correctly uses `check_ajax_referer()` for CSRF protection and limits `post_type` to `'post'` and `post_status` to `'publish'`. The only remaining concern: the `$page` parameter (`absint()` sanitized) has no upper-bound limit, so a bot could crawl all pages by incrementing it indefinitely. Not a security vulnerability per se, but worth noting if you want to limit automated scraping.

### 8. Slider arrow-key handler fires globally (not scoped to focused slider)

**File:** `js/slider.js` lines 59–64

```js
document.addEventListener( 'keydown', function ( e ) {
    var slider = document.getElementById( 'slider-section' );
    if ( ! slider ) return;
    if ( e.key === 'ArrowLeft' )  goTo( current - 1 );
    if ( e.key === 'ArrowRight' ) goTo( current + 1 );
} );
```

Arrow keys advance the slider regardless of where focus is on the page. This can surprise users navigating form fields or other interactive elements. It's an accessibility/UX concern rather than a security one, but worth fixing by scoping the listener to when the slider section has focus.

---

## INFO

### 9. No Content Security Policy header

The theme does not set a `Content-Security-Policy` header. WordPress themes can't easily set HTTP headers (that's typically done in `.htaccess` or `wp-config.php`), but it's worth configuring at the server level to restrict `script-src`, `style-src`, and `connect-src`. The current use of external CDNs (Google Fonts, cdnjs, Font Awesome) must be allowlisted.

### 10. Physical address and email hardcoded in `inc/seo.php` JSON-LD

**File:** `inc/seo.php` lines 237–244

The physical street address (`201 West 85th Street-5B, New York, NY 10024`) and email (`deeprootsmag@gmail.com`) are hardcoded in the Organization schema. This isn't a security vulnerability — it's public contact info that the magazine presumably wants indexed — but if that information ever changes, it requires a code edit rather than a Customizer update. Consider exposing these as Customizer fields.

---

## Recommended Fix Order

1. **Immediately:** Fix `get_search_query()` escaping in `header.php` and `searchform.php` (reflected XSS).
2. **Soon:** Fix breadcrumb escaping in `functions.php`, especially the `get_search_query()` branch.
3. **Next pass:** Sweep `the_title()` → `esc_html( get_the_title() )` across all templates; escape `get_the_date()` / `bloginfo()` outputs.
4. **Housekeeping:** Scope slider keyboard handler to focused element; consider AJAX URL conditional loading.
