# Plan: Longer excerpts on index & category post cards

## Goal
Increase the excerpt length shown in `.post-card` article cards on the blog
index (`index.php`) and category/tag archives (`archive.php`), per user
request. Front page grid (`front-page.php`) is out of scope — not mentioned.

## Files to change
- `index.php` (line 57)
- `archive.php` (line 52)

## Approach
Both templates call the existing helper `skeleton_wp_excerpt( $length )`
(`functions.php:216`, default 18 words), passing `18` explicitly. The helper
already accepts any word count — no change needed to `functions.php` itself.
Just bump the word-count argument at each of the two call sites.

New length: **45 words** (up from 18) — approved by user.

## Steps
1. [x] Edit `index.php:57` — `skeleton_wp_excerpt( 18 )` → `skeleton_wp_excerpt( 45 )`
2. [x] Edit `archive.php:52` — `skeleton_wp_excerpt( 18 )` → `skeleton_wp_excerpt( 45 )`
3. [x] Edits applied — reload blog index and a category page locally to confirm card layout still looks right at the new length (visual check is yours to do in-browser)
