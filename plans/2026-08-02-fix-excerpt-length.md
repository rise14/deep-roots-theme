# Fix: index/archive excerpts stuck at ~20 words

## Goal
Make `skeleton_wp_excerpt( 45 )` actually print up to 45 words on index/category pages.

## Root cause
`functions.php:352` — `add_filter( 'excerpt_length', function() { return 20; }, 999 );`
caps every auto-generated excerpt at 20 words *before* `skeleton_wp_excerpt()` sees it.
The function's own trimming (`functions.php:216`) can only shorten, never lengthen,
so the commit 6313e95 change (18 → 45 in `index.php` / `archive.php`) has no visible effect
on posts without a hand-written excerpt.

## Files to change
- `functions.php` (one line)

## Approach
In `skeleton_wp_excerpt()`, decide the fallback with `has_excerpt()` instead of
`empty( get_the_excerpt() )`. Posts without a manual excerpt then take the
content-fallback path, which trims from the full content and honors `$length`.
Hand-written excerpts still pass through untouched (trimmed to `$length` if longer).

Alternative rejected: raising the global `excerpt_length` filter to 45 — that would
also lengthen every other `the_excerpt()` output (feeds, widgets) as a side effect.

## Steps
- [x] Change `if ( empty( $excerpt ) )` → `if ( ! has_excerpt() )` and move the
      `get_the_excerpt()` call into the else branch in `skeleton_wp_excerpt()`
- [x] Reload index + a category page in MAMP; confirm ~45-word excerpts
      (verified live: auto-excerpt posts now show 45 words ending in "…")
- [x] Confirm front-page grid (length 18) unchanged
