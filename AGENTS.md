# AGENTS.md

This file provides guidance to Codex (Codex.ai/code) when working with code in this repository.

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

### Front-page grid vs. main query
`front-page.php` creates its own `$grid_query` using `WP_Query`. The post count comes from the Customizer setting `posts_per_page_grid` (default 10). The main WordPress query for the page is only used to render optional static front-page content above the grid.

### Post card markup
The `.post-card` article markup is duplicated across `index.php`, `archive.php`, and `front-page.php`. There is a `template-parts/content-card.php` reference in the AJAX handler (`skeleton_wp_load_more_posts`), but that partial does not currently exist on disk — the AJAX load-more is wired up but the partial is missing.

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
- `skeleton_wp_load_more_posts()` — AJAX handler at action `skeleton_load_more`

### Navigation menus
Two locations registered: `primary` (header nav) and `footer-links` (footer column 2). If no menu is assigned to `primary`, `skeleton_wp_fallback_menu()` (in `inc/fallback-menu.php`) renders Home + first 5 pages.

## Coding conventions

- Escape all output: `esc_html()`, `esc_url()`, `esc_attr()`, `wp_kses_post()`.
- Use `absint()` for any integer from user/theme-mod input.
- Always call `wp_reset_postdata()` after a custom `WP_Query` loop.
- Grid/layout uses Skeleton's 12-column class names (`.six.columns`, `.three.columns`, etc.) at breakpoints defined in `style.css`.

## Imported Claude Cowork project instructions

Work on this Wordpress theme
