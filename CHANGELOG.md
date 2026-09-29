# Changelog

Every change to the theme bumps its version in `style.css` and gets an entry here.

- **Patch** (1.1.0 → 1.1.1): fixes and small adjustments
- **Minor** (1.1.x → 1.2.0): new pages or features
- **Major** (2.0.0): a big restructure

Assets (CSS and JS) don't need a version bump to refresh in browsers: each file is
versioned by when it last changed (`donphin_asset_version()` in `inc/helpers.php`).

## 1.1.0 (2026-09-29)

### Sections and structure
- Section registry (`inc/sections.php`): For You, Private Counsel and Speaking are each
  described once (name, tagline, home, templates, palette, menu, button and icon), and
  the header tabs, menus, detection, body class and stylesheets all follow from it.
- Speaking and Private Counsel each have their own About and Contact pages:
  `/speaking/about/`, `/speaking/contact/`, `/private-counsel/about/`,
  `/private-counsel/contact/`. The Journey and The 40|40 Solution moved into their sections.
- Header menus editable in Appearance > Menus, one location per section.
- `functions.php` split into modules in `inc/`.

### Pages
- New: The Journey, Private Counsel About, Speaking Contact (event booking form) and
  Private Counsel Contact (short personal form).
- Redesigned: Speaking About (The Arc, Highlights), Speaking framework with tinted
  Victim / Villain / Hero cards, The Shift, Private Counsel hero and sections, testimonials
  with headshots.
- 404 page follows the visitor's section (from the address, or the page they came from),
  offers both sections to visitors from elsewhere, and uses the new photo.

### Design
- Section palettes as tokens: `--dp-speaking-*` and `--dp-private-counsel-*`.
- Header logo, button, icons and focus colours follow the section.
- Full-screen mobile menu with the button at the foot, smooth open and close.
- Header button icons (calendar, send).
- Client logo marquee (home hero and Speaking).
- Soft fade as each page arrives.

### Behaviour and fixes
- Redirects follow pages wherever they live now: old addresses are remembered when a
  page moves, never loop, and are listed in Tools > Old Addresses.
- The 40|40 testimonial slider no longer scrolls the page; it rotates only while on screen.
- Header sits correctly under the WordPress toolbar on phones when logged in.
- Contact form's thank-you redirect works (thank-you page slug).
- robots.txt lets AI assistants read the site while search engines stay out on development.

## 1.0.0

- First version: Kadence child theme with the For You / Private Counsel / Speaking header.
