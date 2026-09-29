# Changelog

Every change to the theme bumps its version in `style.css` and gets an entry here.

- **Patch** (1.1.0 → 1.1.1): fixes and small adjustments
- **Minor** (1.1.x → 1.2.0): new pages or features
- **Major** (2.0.0): a big restructure

Assets (CSS and JS) don't need a version bump to refresh in browsers: each file is
versioned by when it last changed (`donphin_asset_version()` in `inc/helpers.php`).

## 1.3.4 (2026-09-29)

### Design
- Gateway: the Keynote Speaking card now uses Don on stage at the podium
  (`phinOnStagespeaking.webp`, copied to `assets/images/gateway/speaking-800.webp` and
  `speaking-1400.webp`).

## 1.3.3 (2026-09-29)

### Design
- Gateway: the Private Counsel card now uses Don's headshot on grey
  (`donPhin-graybg.webp`, copied to `assets/images/gateway/counsel-800.webp` and
  `counsel-1024.webp`) instead of the study photo.

## 1.3.2 (2026-09-29)

### Copy
- Gateway: the Private Counsel card's line no longer repeats its title. "Private Counsel
  for Successful Men" is now "For successful men ready for what comes next."

## 1.3.1 (2026-09-29)

### Copy
- Gateway card titles: "The Inner Climb" is now "Private Counsel", and "Speaking" is now
  "Keynote Speaking".

## 1.3.0 (2026-09-29)

### Home page is now a gateway
- `front-page.php` is a door into the two sides of Don's work and nothing else: no site
  header or footer. "Don Phin, Esq. / Two ways to work with me." over two full-height
  photo cards: **The Inner Climb** (Private Counsel for Successful Men) and **Speaking**
  (Mastering the Emotional Edge), each with an Explore button in its section's gold.
- Hover draws one door in (photo closer, rule widens, button fills) and dims the other.
  On phones the doors stack.
- New `assets/css/gateway.css` and photos in `assets/images/gateway/`. The front page no
  longer loads `home.css`, `home.js`, the header script or the scroll reveal. The old home
  sections stay in `template-parts/` for reuse.

## 1.2.0 (2026-09-29)

### Pages
- New Speaking Resources page (`/speaking/resources/`, template "Speaking — Resources"),
  from `reference/resources-page-v4.png` in the Speaking palette: the intro, Don's line
  on a navy band, two downloads (The Emotional Edge, the one-sheet), press photos with
  full-size downloads, and Tools & Programs (The 40||40 Solution, and more to come).
- A download's button asks for a copy through Speaking's contact page until its PDF is
  added to `assets/docs/` (`the-emotional-edge.pdf`, `don-phin-speaking-one-sheet.pdf`),
  then becomes a direct download by itself.

## 1.1.2 (2026-09-29)

### Copy
- Home headline no longer points to AI: "Now, the AI side of change." (the retired
  TRANSFORM line) is now "Take the stage, or take the journey.", setting up the choice
  between Speaking and Private Counsel under "Forty years on the human side of business."
- The two choices sit directly under the headline, each linking to its section:
  "Keynote Speaker — For sales leaders and conferences." and "Private Counsel — For
  successful men ready for what comes next.", edged in each section's colour.
- The two doors are now the hero's only calls to action: "Talk to Don" (which led to
  Speaking's contact page, the wrong side for Private Counsel visitors) and "Watch Don
  speak" (Speaking-only, and off to YouTube before a side is chosen) are removed. The
  reel stays on the Speaking home.
- "Trusted by" logos removed from the home hero (they remain on the Speaking page), and
  the short line before the "Speaker · Author · Counsel" eyebrow removed.
- The Speaking card on the home page no longer mentions "what AI is really doing to
  work": none of Don's current programs is an AI talk.

## 1.1.1 (2026-09-29)

### Fixes
- Restored the 404 page's background photo (`assets/images/404.webp`), which had been
  deleted by accident and was missing on the live site.

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
