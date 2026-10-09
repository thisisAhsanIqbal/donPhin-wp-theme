# Changelog

Every change to the theme bumps its version in `style.css` and gets an entry here.

- **Patch** (1.1.0 → 1.1.1): fixes and small adjustments
- **Minor** (1.1.x → 1.2.0): new pages or features
- **Major** (2.0.0): a big restructure

Assets (CSS and JS) don't need a version bump to refresh in browsers: each file is
versioned by when it last changed (`donphin_asset_version()` in `inc/helpers.php`).

## 1.16.3 (2026-10-10)

### Speaking blog: the card about Don
- The "Written by" card at the foot of a Speaking post is on the brand orange (`#FF6B35`)
  with a soft glow and rounded corners. Its words are white, and Don's portrait has a white
  ring. "More about Don" is white and turns deep navy on hover. Private Counsel's card is
  unchanged.

## 1.16.2 (2026-10-10)

### Blogs: "In this post" on phones and tablets
- Below 1200px, "In this post" is a card that folds away: its heading is a button with the
  number of sections and an arrow (open to begin with; choosing a heading folds it).
- Each heading is numbered (01, 02, 03) with an arrow, and the one being read is lit.
  Speaking: a navy card with a teal glow and bold teal numbers. Private Counsel: the soft
  band under a bronze rule, with italic bronze numerals in Fraunces.
- Choosing a heading scrolls to it smoothly (instantly with reduced motion). Without the
  script, the list simply shows.

## 1.16.1 (2026-10-10)

### Blogs: the post page lines up with the header
- The post page keeps to the header's own frame (1600px, with the header's gutter), so its
  edges meet the logo and the header's button at every width.
- Speaking, wide screens (1200px and up): the hero is two columns, the words from the logo's
  edge and the featured picture out to the button's. Below that, the picture sits under the
  words, inside the navy band.
- The sharing rail starts at the logo's edge, and "In this post" ends at the button's; the
  words stay in their centred column between them. "Keep reading" uses the same frame.
- Private Counsel keeps its centred hero, with the bronze rule under the byline and the
  framed picture below it.

## 1.16.0 (2026-10-09)

### Blogs: the post page, redesigned
- One reading column (760px) for the hero, the picture and the words, so all their edges line
  up.
- The hero: a back link to the blog, the category as a chip, the title, the excerpt as a
  summary (when the post has one), and a byline with Don's portrait, the date and the reading
  time.
- The featured picture keeps its own shape and is never cropped or enlarged past its size
  (pictures from the old site have their title baked in). On Speaking it sits over the hero's
  edge; on Private Counsel it's framed like a print.
- Wide screens: sharing links (LinkedIn, X, email, copy link) in a rail on the left, and
  "In this post" (the post's headings, marking the one being read) on the right. Below
  1200px, "In this post" sits above the words.
- A thin bar along the top shows how far through the post the reader is (`assets/js/blog.js`).
- The words: a larger opening line, a short stroke over each heading, and a list of bold-led
  points set as a panel (hairlines on Private Counsel).
- The end: the category and sharing links, a card about Don (bio per side, linking to that
  side's About page), previous and next as cards, the side's invitation, then "Keep reading"
  as the list's cards.
- Empty paragraphs and the old site's empty sharing footer in pasted posts are left out of the
  page; the post itself is unchanged.

## 1.15.0 (2026-10-09)

### Blogs: one for Speaking, one for Private Counsel
- Each side has its own blog, kept apart: Speaking Blog and Counsel Blog in the admin, each with
  its own posts and categories. A post belongs to one side only.
- Addresses: `/speaking/blog/` and `/private-counsel/blog/` for the lists, `{blog}/{post}/` for a
  post, `{blog}/topic/{category}/` for a category. "Blog" is in both headers.
- The list (`archive-blog.php`) and the post (`single-blog.php`) are shared, and each side
  brings its own look (`assets/css/blog.css`). Speaking: Montserrat in bold capitals on light
  gray, cards edged in teal, the post on a navy band, orange buttons. Private Counsel:
  Fraunces on cream and navy, an editorial column ruled in bronze, a bronze first letter,
  bronze buttons.
- A post page has the reading time, Don's note with the side's invitation, the posts before
  and after it, and three more from the same blog (its category first).
- Posts > "Move to Speaking Blog / Counsel Blog" moves an ordinary WordPress post into a side.
  Its old address redirects to the new one (301), as it does when a blog post's slug changes.
- The two blogs' headings and intros are placeholders in `donphin_blog_sides()` (`inc/blog.php`)
  until Don names them.

## 1.14.0 (2026-10-09)

### Speaking: footer
- On Speaking pages the footer takes the section's palette: the darkest navy (`#00303E`, a step
  below the closing band above it) with teal icons, rule under the name and edge along the top,
  and the name in bold Montserrat. Elsewhere it is unchanged.
- The footer's colours are tokens a section can set (`--dp-footer-bg`, `--dp-footer-accent`,
  `--dp-footer-title-weight`), as the header's are.

## 1.13.9 (2026-10-09)

### Speaking page
- "The shift" and "Don in the room" labels lose the short teal line in front of them.

## 1.13.8 (2026-10-09)

### Fix
- Speaking page: the orange What Changes panel and the programs heading, which stay in view
  while their lists scroll, slid under the sticky header. They now stop 32px below it.

## 1.13.7 (2026-10-09)

### Speaking page
- What Changes After Don Speaks: the heading and "Remember… facts tell, and stories sell!" on
  the orange panel are white.

## 1.13.6 (2026-10-09)

### Speaking: header button
- "Book Don" in the Speaking header has no calendar icon, and is a little taller (36px → 44px).
  The button's height is now a header token, `--dp-header-cta-height`, which a section can set;
  the full-width button in the phone menu stays as it was.

## 1.13.5 (2026-10-09)

### Speaking page
- The teal glow in the hero's top-right corner is lighter (16% → 9%), and fainter and smaller
  still on phones (6%, over the top of the screen only).

## 1.13.4 (2026-10-09)

### Speaking page
- The Vistage award moves off the reel's corner to a credential line under the hero's
  buttons: the seal (`assets/images/speaking/vistage-seal-112.webp` and `-224.webp`, cut
  from the badge) with "Vistage Speaker · Top Performer Award" in words beside it.

## 1.13.3 (2026-10-09)

### Speaking page
- The hero's orange line, "How our stories and roles direct the sale.", is set in weight 600.

## 1.13.2 (2026-10-09)

### Speaking page: first screen
- The header, the hero and the "Trusted by" logos together fill the window on laptops and
  desktops, the logos along its foot; the hero takes the space the logos leave, its content
  centred in it. On tablets and phones the hero is as tall as its content.

## 1.13.1 (2026-10-09)

### Speaking page: first screen
- The headline reads in two parts: "Sales on Stage." on a line of its own, and "How our stories
  and roles direct the sale." in orange under it, a step smaller. Before, the orange line ran on
  from the end of the first, splitting it across lines on wide screens.
- With the header, the first screen fills the window on laptops and desktops, its content
  centred top to bottom. Stacked on tablets and phones, it is as tall as its content.

## 1.13.0 (2026-10-09)

### Speaking: new typefaces
- Speaking pages set headlines in Montserrat and text in Inter (the rest of the site keeps
  Fraunces and Zalando Sans). The fonts load only on Speaking pages: a section can now name
  its own Google Fonts stylesheet (`fonts` in `donphin_sections()`), and its palette stylesheet
  points `--dp-font-family` and `--dp-font-serif` at them.
- Each Speaking page's title and section headings are bold capitals; their italic accent lines
  stay light and in ordinary case. Program and resource titles, and the 40//40 page's
  headline sentence, stay as written.
- The testimonials on the Speaking page are set in Inter, as body text.

## 1.12.0 (2026-10-09)

### Speaking: new brand colours
- The Speaking side takes the client's new palette: High-Octane Orange `#FF6B35` for calls to
  action, Deep Trust Navy `#004E64` for headings and deep backgrounds, Electric Teal `#25CED1`
  for accents, and Crisp White `#F7F9F9` behind body text. All of it lives in
  `assets/css/speaking.css`; the about, contact, resources and single resource pages and the
  header's "Book Don" follow it.
- `--dp-speaking-gold` is now `--dp-speaking-teal`. New working shades: `--dp-speaking-deep`
  (type on orange and teal) and `--dp-speaking-orange-ink` (orange as large type on light,
  where the bright orange is too faint to read).
- Buttons on Speaking pages (Book Don, the contact form's Send, the resource downloads, the
  about page's button) are orange with dark navy type, and navy with white type on hover.
  Private Counsel's buttons are unchanged.
- The testimonial headshots have teal backgrounds instead of yellow
  (`assets/images/speaking/*-teal-240.webp` and `-480.webp`; the originals are kept).

### Speaking page: layout
- The reel sits beside the headline, so it's in the first screen on laptops and desktops;
  on phones it comes straight after the headline. "Book Don" and "See the programs" sit
  under the lead, and the Vistage seal is pinned to the reel's corner.
- Proof comes higher: the client logos right under the first screen, then the numbers (now on
  navy), then the testimonials (now white cards), before the framework.
- A row of audience results ("40% increase in sales") sits at the top of the numbers band, once
  there are real figures: add them to `$results` in `page-speaking.php`. Until then the row
  is left out.
- Body text is larger throughout (about 19–23px on desktop, 18–19px on phones; small labels
  from 12–13px to 14–15px).
- Less empty space: section padding is down by about a third, and the stage photo is never
  taller than 72% of the screen.
- What Changes After Don Speaks puts its heading on an orange panel with a "Book Don" button,
  and the closing invitation is on navy with the orange button.

## 1.11.3 (2026-10-07)

### Safer handling
- Set up from Speaking checks every change it makes. Anything that fails is reported as
  "Not done" (with WordPress's reason) instead of "Done", and the notice turns to a warning;
  pressing Apply again retries just those. A category that can't be made no longer stops
  the page with an error.
- A category's short name, icon and order are saved only for people allowed to manage
  categories.
- The contact forms take at most 160 characters from a "Request a copy" link.
- Looking up a resource that doesn't exist returns nothing rather than an error.

## 1.11.2 (2026-10-07)

### Fix
- Private Counsel: "The 40//40 Solution on Amazon" linked to the Speaking side's 40//40
  page (`/speaking/purchase-the-40-40-solution/`), a link across sides. Set up from
  Speaking now points it straight to Amazon (`https://amzn.to/2maEiy3`): when moving it
  on a site not yet split, or as one "Link" change where the split is already done.

## 1.11.1 (2026-10-07)

### Fix
- Set up from Speaking: after Apply, it still listed copying The 40//40 Solution (full
  PDF) as to do, and pressing Apply again would have copied it twice. It looked for the
  copy under its Speaking category ("Books & Excerpts") rather than its Counsel one
  ("Books"); it now finds it by title.

## 1.11.0 (2026-10-07)

### Each side its own resources: HR Tools (Speaking) and Private Counsel
- Don split the one library in two. Speaking's Resources page now shows **HR Tools** (97
  resources, with his intro: "I have created a great deal of content related to the
  workplace. Some of it may benefit you!"); Private Counsel gets its own 24, in two groups
  (Books; Checklists, Reports, Tools and More).
- **Counsel Resources** is a new admin menu, Private Counsel's own library, with its own
  categories, its resources' pages at `/private-counsel/resources/{resource}/` in the
  Private Counsel header and colours, and requests for a copy going to its contact form
  (which now fills in the message, as Speaking's does).
- **Counsel Resources > Set up from Speaking** makes the split (`inc/resources-split.php`):
  it shows every change and the list each resource ends up on, and changes nothing until
  Apply is pressed. It moves the Private Counsel resources, copies the two on both lists
  (the 40//40 Solution full PDF, and the 90-Day Strategic Plan) keeping their document,
  makes the five on hold drafts (on hold, confirm with client), deletes From Chaos to Order
  (its document, if any, stays in the Media Library), and puts HR Tools' books in Don's
  order. Safe to run twice.
- New page template **Private Counsel — Resources** (`page-counsel-resources.php`,
  `counsel-resources.css`): the heading on navy, then the library.
- The library is now one part for both sides (`template-parts/resource-library.php`), in
  each side's colours and shapes (`resource-library.css`; its styles moved out of
  `speaking-resources.css`). Every number is counted from what's there, and categories
  with nothing in them don't show.
- Each Resources page has a **Resource library** box for its heading and intro (HR Tools
  and its intro on Speaking; "Resources" and none on Private Counsel, until changed).
- From Chaos to Order is gone from the starter list (`inc/resources-seed.php`).

## 1.10.3 (2026-10-07)

### Fix
- Private Counsel: "Wealth." in the five-dimensions line sat apart from the sentence (the
  line is a flex row, so the word took the row's gap); the sentence is now one piece.

## 1.10.2 (2026-10-07)

### Eyebrows without the rule
- The small gold line before the Private Counsel eyebrows (`.dp-pc-eyebrow`) is gone, on
  Private Counsel, The Journey and Counsel About.

## 1.10.1 (2026-10-07)

### Private Counsel and The Journey: updated copy
- Private Counsel (from `reference/Document1.docx`): one man at a time (hero note, the
  "Personal" term, the enquiry text); "100% about you" added to "Fully present"; the five
  dimensions now name Wealth; the one-room section opens with "It's not about another
  climb..." and closes on "a year-long process, not a singular event".
- The Journey (from `reference/Document2.docx`): monthly meetings added to the offer; the
  transformation story rewritten ("Who am I now?", "son or daughter", "on the court or up
  the trail", "permission and ability"); Immersions II and III reworded; "a former partner
  or spouse at dinner"; the access heading is now "I will only be able to take three men on
  this journey."; the gift is now Don's book *A Wealthy Man's Guide to The Next Journey:
  Letting Your Life Catch Up to Your Wealth* (kicker and subtitle styled in `journey.css`).

## 1.10.0 (2026-10-06)

### Resources, managed in the admin
- Each section now has its own library of resources, managed in the admin: "Speaking
  Resources" (Private Counsel can have its own later, by adding it to
  `donphin_resource_sides()` in `inc/resources.php`). Each resource has a title, a short
  summary (the excerpt), a description, a category, and either a document from the Media
  Library or a link (a video, a web tool, a page), plus an optional small label.
- Categories have a short name (for the filter buttons), an icon and an order, set on
  Speaking Resources > Categories.
- The list of resources in the admin shows which ones have their document yet.
- Import: while a library is empty, its list offers to import the starter resources (the
  125 from 1.9.0, in `inc/resources-seed.php`). Run it once on each site (it won't run
  into a library that already has resources).
- Every resource has a page of its own (`single-resource.php`, `assets/css/resource.css`)
  at `/speaking/resources/{resource}/`: the title and its download (or link, or "Request a
  copy") on a navy band; the preview beside its description, details and an invitation to
  book Don; then more from the same category. PDFs show in the browser's viewer (on phones,
  their first page and a button to open them); images, audio and video show in place, and
  YouTube or Vimeo links play in place. Anything else is a drawn page with its title.
  The page belongs to its section (header, menu, colours).
- The Speaking Resources page now reads its library from the admin. Each row opens the
  resource's page, and one with a document can also be downloaded straight from its row.
- `inc/resource-library.php` is replaced by `inc/resources.php` (post types, categories,
  data), `inc/resources-admin.php` (the admin) and `inc/resources-seed.php` (the starter
  list). `assets/docs/library/` is no longer used: documents go in the Media Library.

## 1.9.0 (2026-10-06)

### Speaking Resources: the library
- Everything Don has made is now on the page: 125 resources in eight categories (Books &
  Excerpts, Book Summaries, HR & Workplace Forms, HR & Management Checklists, Leadership,
  Mindset & Executive Performance, Coaching Worksheets, Posters & Printables, Videos &
  Lessons), in a new "The Library" section on white below Tools & Programs.
- A search narrows every category as you type, and says how many match (for screen
  readers too). Buttons along the top show one category. Long categories show their first
  six items, with "Show all". Without JavaScript the whole library simply shows.
- The contents live in `inc/resource-library.php` (new module), not in the page. Each item
  becomes a download by itself once its file is in `assets/docs/library/`, named after it
  (e.g. `library/hiring-checklist.pdf`; audio as `.mp3`). Videos take a link. Until then each
  item's "Request" opens the Speaking contact form with the message already filled in
  ("I'd like a copy of: …"), through a new `?resource=` on the contact page.
- The three toolkit columns from 1.8.0 are gone (their items are in the library), and so
  is `assets/docs/tools/`: use `assets/docs/library/` instead.
- Tools & Programs: the Employee Turnover Cost Calculator and the Engagement & Retention
  Program Planner now have cards of their own as interactive web tools. Each opens its
  tool once it has a link (in `donphin_resource_tools()`), and until then requests access.
- Downloads: the guide is now "Hiring and Retaining Employees in this Crazy Economy" (an
  E-book), and The Power of the Stories We Tell Ourselves is labelled a Manifesto, as Don
  names them.

## 1.8.0 (2026-10-06)

### Speaking Resources
- Downloads: two new free guides join The Emotional Edge and the one-sheet, "Hiring and
  Retaining Employees" (`assets/docs/hiring-and-retaining-employees.pdf`) and "The Power of
  the Stories We Tell Ourselves" (`assets/docs/the-power-of-the-stories-we-tell-ourselves.pdf`).
  Each card now has a small drawn cover in its own colour (navy, blue, gold, paper),
  tilted slightly and straightening on hover. On phones the cover sits above the words.
- Tools & Programs: the "Coming soon" card is gone. The 40//40 Solution is featured
  across the width on navy, the book breaking out of its top (new transparent image
  `assets/images/40-40/book-3d-clear.webp`). Below it the toolkit sits on three shelves:
  Calculators & Planners (Turnover Cost Calculator, Retention Planner), HR Checklists &
  Guides (OKRs, 60-Day Review, Stay Interviews), and Book Summaries (The Effective
  Executive, Mastery, Antifragile).
- Each toolkit item becomes a download once its PDF is added at
  `assets/docs/tools/{name}.pdf` (e.g. `tools/turnover-cost-calculator.pdf`). Until then
  it asks for a copy through the Speaking contact page, like the downloads.

## 1.7.1 (2026-10-06)

### Private Counsel About
- The hero's "Request an introduction" button now keeps the visitor on the page: it
  scrolls down to the invitation at the foot (the parent theme smooth-scrolls it), with
  its arrow pointing down. Only the invitation's button goes on to the contact page.
- The hero line no longer mentions keynotes (the Speaking side) or the offer's details:
  "Today I keynote, and I serve as private counsel to three men at a time…" is now Don's
  own words from A Year in the Life: "For over forty years, I've had the privilege of
  sitting with CEOs, entrepreneurs, physicians, attorneys, family business owners, and
  men who've built extraordinary lives."

## 1.7.0 (2026-10-06)

### Speaking
- The Vistage Speaker Top Performer Award in the hero, as a seal in the top-right corner
  beside the headline: on a cream plate edged in gold (the badge's words are dark), tilted
  slightly, straightening on hover. On tablets and phones it sits under the headline.
  Images: `assets/images/speaking/vistage-badge-220.webp` and `-440.webp`, trimmed from
  `vistagespeakerbadge.webp`.

## 1.6.3 (2026-10-06)

### Speaking
- New speaker reel in the hero: https://www.youtube.com/watch?v=fTTt8cN4qWA. Its still is
  the video's own YouTube thumbnail ("Don Phin · Speaker | Coach | Master of Emotional
  Energy"), saved as `assets/images/speaking/reel2-960.webp` and `reel2-1280.webp`.
- The play button sits in the dark space under the words, clear of the title and Don's
  face; on phones it is a little smaller and the "Watch the speaker reel" label is hidden.

## 1.6.2 (2026-09-29)

### Fixes
- WordPress no longer guesses where a missing address was meant to go. It matched by
  page name alone, so the Private Counsel menu's Resources link (no page yet) landed on
  Speaking's Resources page, across to the other side. Missing pages now show their own
  side's 404; moved pages are still redirected by the theme.

## 1.6.1 (2026-09-29)

### Pages
- Private Counsel About: "The experience" section ("Forty years, one line a year", the
  year-by-year timeline) removed at Don's request, with its styles. The page now reads:
  hero, My story, Why me, and the close.

## 1.6.0 (2026-09-29)

### Private Counsel side matches the offer: The Next Journey
From `reference/Part1_Offer_Architecture_The_Next_Journey.docx` and
`reference/A_Year_in_the_Life.pdf`. Prices are deliberately not published.

- **The Next Journey page** (`/private-counsel/the-journey/`, rebuilt): the journey in
  brief ("One man. One year. Built around you."); the transformation ("Nobody has been
  assigned to the man", the Tuesday morning after the sale, twelve months later, and the
  moment on the trail); how it unfolds (Day of Discovery, the Everything But Your Money™
  Whole-Life Assessment, the Personal Blueprint, the Journey); the three immersions
  (I Ground, II Deep Immersion, III Integration, with photos); between immersions
  (Counsel Days, the Counsel Line, Invitations); always vs. shaped around you; access
  (three men at any one time, by introduction, a quiet waitlist); the gift; Don's close.
  Menu label and page title: "The Next Journey".
- **Private Counsel home**: the offer's positioning line in the hero; "Three men at a time ·
  By introduction"; "Three men at any one time. Never more."; the first step names the
  assessment, the Day of Discovery and the Personal Blueprint, and links to The Next
  Journey; "Enquiries" is now "By introduction", with who introduces and the waitlist.
- **Contact**: "Request an introduction", with a required "Who introduced you?" field,
  saved and emailed as "Introduced by". Buttons across the side read "Request an
  introduction".
- **About**: "three men at a time"; 2026 is "Launches The Next Journey".

## 1.5.1 (2026-09-29)

### Speaking
- The numbers (800+, 16, 40+, 1M+) count up from zero, once, as the row comes near the
  screen (`assets/js/count-up.js`). Without JavaScript, or with reduced motion, they
  simply show.
- The twelve-logo row moves slower: 50s a loop (40s on phones), was 32s (24s).

### Copy
- The book's name is written "The 40//40 Solution" everywhere, as Don writes it. It had
  five spellings (40||40, 40 || 40, 40/ /40, 40| |40, 40|40): 24 in the theme, on the book
  page, its testimonials, Speaking Resources, Private Counsel About and the gift-book alt
  text. The local page title is now "The 40//40 Solution" too (its address is unchanged).

## 1.5.0 (2026-09-29)

### Speaking side matches Don's one-sheet (`reference/DonPhinSalesOnStage.docx`)
- The signature keynote is **Sales on Stage: How Our Stories and Roles Direct the Sale**.
  The Emotional Edge stays the book (Speaking Resources, About credentials).
- Speaking hero: "Sales on Stage. How our stories and roles direct the sale." with the
  one-sheet's pitch ("Buyer and seller walk onto the sales stage…"), replacing the
  AI-based lines.
- What Changes After Don Speaks: the one-sheet's six points (including the Coax,
  Encourage, and Inspire formula), introduced with "Remember… facts tell, and stories sell!"
- Numbers: 800+ presentations to executives, 16 LinkedIn Learning courses, 40+ years
  studying human potential, 1M+ professionals reached (was 700+, 40+ years, 1 company
  built & sold, 1M+).
- Close: "Book Don for Your Next Sales Meeting", with Keynote | Breakout | Executive Session.
- Trusted by: the one-sheet's twelve logos (`assets/images/icons/client-*.png`, cut from
  its logo sheet), shown in soft grey and in full colour on hover.
- Gateway: the Keynote Speaking card's line is now "Sales on Stage: How Our Stories and
  Roles Direct the Sale".
- Speaking About: 800+ presentations, 16 LinkedIn Learning courses, and Sales on Stage as
  today's signature keynote.

## 1.4.3 (2026-09-29)

### Pages
- The Journey: the "Between conversations" experiences section ("Conversation.
  Experience. Reflection. Integration.", its paragraph and the hiking and meditation
  photos) is removed for now, with its styles, while Don reworks the page. It is in git
  history, and the photos stay in `assets/images/Journey/`.

## 1.4.2 (2026-09-29)

### Design
- Gateway on phones fits one screen with no scrolling: exactly the screen's height
  (`100svh`, so nothing hides behind the browser's bars), Don's name on top and the two
  doors splitting the rest evenly, with tighter type. Phones turned sideways (too short
  for both doors) scroll instead, with the doors side by side.

## 1.4.1 (2026-09-29)

### Fixes
- Thank-you page: "Back to the home page" sent visitors to the gateway after a contact
  form. It now returns them to their own side ("Back to Speaking" or "Back to Private
  Counsel").

## 1.4.0 (2026-09-29)

### Each side keeps to itself
- The header's top bar is gone: no For You / Private counsel / Speaking tabs and no
  social icons. Once a visitor goes through the gateway, everything they see is about
  that side only. The header is now one white bar (logo, menu, button), 68px tall.
- The logo leads to the section's own home (`/speaking/` or `/private-counsel/`) instead
  of the gateway, so it never takes a visitor to the other side.
- The top bar's styles are removed from `style.css`, `speaking.css` and
  `private-counsel.css`.

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
