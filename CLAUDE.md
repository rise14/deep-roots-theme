# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A custom WordPress theme called **Skeleton WP** (package/text domain: `skeleton-wp`) for the **Deep Roots** music magazine. It is built on the Skeleton CSS framework v2.0.4, which is embedded directly in `style.css`. There are no build tools — no npm, webpack, or Sass. All CSS and JS are plain files loaded directly by WordPress.

The local dev environment is **MAMP** at `/Applications/MAMP/htdocs/deep-roots/`, served at `http://localhost:8888/deep-roots/`. To see changes: save the file, reload the browser. No compilation step.

## Template hierarchy

| Template | When it loads |
|---|---|
| `front-page.php` | Homepage — runs its own `WP_Query` for the posts grid (does NOT use the main query) |
| `index.php` | Blog index, category, tag, and search result pages |
| `archive.php` | Category / tag / author / date archives |
| `single.php` | Single post view (no sidebar; sidebar is added by `header.php` wrapper) |
| `page.php` | Static pages |
| `header.php` | Included in all templates; contains top-bar search, logo, nav, and the image slider (slider renders only on `is_front_page() || is_home()`) |
| `sidebar.php` | Right sidebar; silently no-ops when `sidebar-main` has no widgets |
| `footer.php` | 3-column widget areas + footer credits bar |

## Architecture notes

### Header / slider coupling
The slider markup lives inside `header.php`, not `front-page.php`. The slider is fired from `header.php` using `skeleton_wp_get_slider_posts()` from `functions.php`. Slider posts are pulled by the `featured-slider` tag; if none are tagged, it falls back to the five latest posts. Slider count and autoplay are editable in the Customizer under **Image Slider**.

### Department banners
`header.php` renders a department banner on single posts and category archive pages (`is_single() || is_category()`). It matches the post's (or queried category's) slug against files in `images/dept-banners/` named `{category-slug}-banner.{jpg,jpeg,png,webp,gif}` — first match wins, and it silently no-ops when no file matches. To add a banner for a department, drop a correctly named image into that directory; no code changes needed. Do not add a second banner mechanism in `single.php` — it will duplicate this one.

### Front-page grid vs. main query
`front-page.php` creates its own `$grid_query` using `WP_Query`. The post count comes from the Customizer setting `posts_per_page_grid` (default 10). The main WordPress query for the page is only used to render optional static front-page content above the grid.

### Post card markup
The `.post-card` article markup is duplicated across `index.php`, `archive.php`, and `front-page.php`. There is no shared partial — each template inlines the card markup.

### Registered image sizes
```
skeleton-card    400×230  (hard crop) — post grid thumbnails
skeleton-slide  1200×500  (hard crop) — slider images
skeleton-sidebar 300×180  (hard crop) — sidebar recent posts
skeleton-single 1200×600  (hard crop) — single post hero
```

### Widget areas
| ID | Location |
|---|---|
| `sidebar-main` | Right sidebar |
| `footer-1` / `footer-2` / `footer-3` | Footer 3-column area |
| `below-slider` | Full-width strip directly below slider |

The widget instance `block-2` is explicitly stripped from `sidebar-main` at runtime via the `sidebars_widgets` filter. `WP_Widget_Recent_Comments` and `WP_Widget_Search` are unregistered globally.

### Customizer settings
- `slider_count` — number of slider posts (default 5)
- `slider_autoplay` — checkbox (default on)
- `posts_per_page_grid` — front-page grid count, 2–32 (default 10)
- `footer_copyright` — copyright text (supports `wp_kses_post` HTML)

### JavaScript
Both JS files are plain ES5 IIFEs, no dependencies:
- `js/navigation.js` — mobile hamburger toggle; closes on outside-click and Escape
- `js/slider.js` — CSS `translateX` slider with dot nav, prev/next buttons, autoplay, keyboard arrows, touch/swipe, pause-on-hover/focus. Reads autoplay settings from `skeletonWP` object localized by `skeleton_wp_scripts()`.

### Theme function prefix
All custom functions use the `skeleton_wp_` prefix. Key helpers in `functions.php`:
- `skeleton_wp_get_slider_posts( $count )` — WP_Query for slider
- `skeleton_wp_excerpt( $length )` — prints trimmed excerpt, falls back to content
- `skeleton_wp_post_meta( $show_cat )` — date / author / category badge
- `skeleton_wp_breadcrumbs()` — lightweight breadcrumb nav (no plugin)
- `skeleton_wp_icon( $name )` — returns an inline SVG icon (see Icons below)

### Icons
Icons are inline SVG, not an icon font. `skeleton_wp_icon( $name )` in `functions.php` returns a `<svg>` (sized `1em`, `fill="currentColor"`) for one of a fixed set of names: `search`, `bars`, `chevron-left`, `chevron-right`, `arrow-right`, `comment`, `rss`, `home`. Templates call `echo skeleton_wp_icon( 'search' )` (or use it directly inside `paginate_links()`/`the_posts_pagination()` `prev_text`/`next_text` strings). Because the SVG uses `currentColor` and `1em`, it inherits the surrounding element's `color` and `font-size` — no extra CSS needed. Font Awesome was **removed** (no CDN stylesheet is enqueued); to add a new icon, add its Font Awesome 6 free-solid path to the `$icons` map in `skeleton_wp_icon()` rather than reintroducing the font.

### Favicon
`skeleton_wp_favicon()` in `inc/seo.php` outputs `<link rel="icon">` + `<link rel="apple-touch-icon">` on every page (hooked to `wp_head`), pointing at `images/favicon.png` (a 102×102 square PNG). It is skipped via `has_site_icon()` when a Site Icon is set in the Customizer, so WordPress's own tags take over instead of duplicating.

### Navigation menus
Two locations registered: `primary` (header nav) and `footer-links` (footer column 2). If no menu is assigned to `primary`, `skeleton_wp_fallback_menu()` (in `inc/fallback-menu.php`) renders Home + first 5 pages.

### New-post admin notification
`skeleton_wp_notify_admin_new_post()` in `functions.php` emails the site admin (`admin_email`) when a post is published. It hooks `transition_post_status` (NOT `publish_post`) so it can compare old/new status: it fires only on a genuine transition *into* `publish` (`'publish' === $old_status` bails), so editing an already-published post does **not** re-send. It is also limited to the `post` type and is skipped when the author's email matches `admin_email` (so the admin's own posts don't notify them). Uses `wp_mail()`, so actual delivery depends on the server's mail/SMTP config. Do not switch this back to the `publish_post` hook — that fires on every save of a published post and reintroduces duplicate emails.

## Coding conventions

- Escape all output: `esc_html()`, `esc_url()`, `esc_attr()`, `wp_kses_post()`.
- Use `absint()` for any integer from user/theme-mod input.
- Always call `wp_reset_postdata()` after a custom `WP_Query` loop.
- Grid/layout uses Skeleton's 12-column class names (`.six.columns`, `.three.columns`, etc.) at breakpoints defined in `style.css`.
