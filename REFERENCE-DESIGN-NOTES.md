# Reference Design Notes — Techno Coderz Inner Pages

Working folder: `C:\laragon\www\technocoderz-main` only.
References measured live with headless Chrome (1440px): LearnUp Home 4, FiStudy Laravel, DreamsLMS HTML.

## Shared observations
- LearnUp and FiStudy use **Outfit** (body + headings). **DreamsLMS does NOT** — it uses the Bootstrap default `system-ui` stack (verified via computed styles; see `docs/06-reference-layout-analysis.md` §4).
- Every reference page opens with a **page-header banner** (coloured/tinted band): breadcrumb + big title + short lead, then white sections below.
- Section rhythm is alternating white / near-white (#F8FAFC / #F1F4F9) in LearnUp/FiStudy; DreamsLMS uses white + one purple stat band.
- Card radii: FiStudy 12–25px, LearnUp 4–16px, DreamsLMS mostly 8–24px (rounded).

## 1) Homepage — LearnUp Home 4 + FiStudy (already aligned)
Reference elements reproduced earlier: Outfit typography, white + #F1F4F9 section surfaces, 1320px container, tinted hero band with border-bottom, tuned card radii, stats band, category tiles, blog cards. This pass keeps that direction; no further change.

## 2) About Us — FiStudy `/about` + DreamsLMS `about-us.html`
FiStudy about page sections: `page-header` (banner) → `about-three` (image/text split) → `why-choose-three` (#FAFAFA, "Discover Why…" numbered cards) → `counter-one` (solid #687EFF stat band) → `testimonial-two` → newsletter.
DreamsLMS about sections: banner → `about-section-two` "Empowering Learning, Inspiring Growth" (image block + text) → `benefit-section` → `client-section` (logo band) → `counter-sec` (solid purple band) → testimonials → `faq-section`.

What we reproduce (genuine content only):
- Image/text split with a media collage + floating experience badge (FiStudy style).
- Full-width **counter band** (brand orange) with animated counts (existing, genuine figures already on about.php).
- Mission/Vision cards + numbered "Why Choose / Core Values" cards (Fixture why-choose-three).
- **Testimonials from the DB** (real student records).
- **FAQ** using existing published FAQ wording.
- Skip client/logo band (no genuine logo assets/data).
- Newsletter added in Task 2B-fix (see section 8) — FiStudy `newsletter-two` reproduced as a light boxed band.
- **Task 2B-fix**: FiStudy's `sliding-text-three` band and `newsletter-two` section were restored (were missing from the first 2B pass). Final section order now matches FiStudy 1:1: page-header → about-three → why-choose-three → counter-one → testimonial-two → sliding-text-three → newsletter-two → contact-info-one.

## 3) Courses — DreamsLMS `course-grid.html`
DreamsLMS course-grid = banner → single "course-content" section with a **left filter sidebar** (categories) + right results grid of course boxes.
We reproduce:
- **Sticky left sidebar**: category list (All / Software Development / Data Science / Cyber Security), live search moved into the sidebar, "Need help choosing?" CTA panel (DreamsLMS-style widgets).
- Main column keeps the working `#courseChips` + `#courseGrid` (search/filter JS unchanged) with card hover lift, 16/9 thumbnails, orange accent.
- Preserves `?cat=` / `?q=` behaviour and Syllabus/Enroll actions.

## 4) Blog — LearnUp Home 4 blog cards
LearnUp blog cards: image with absolute category chip + date, bold title that turns brand blue on hover, author row, "Read More".
We reproduce via card styling: 16/10 image with zoom-on-hover, floating white category pill + dark date pill, Outfit headings, orange hover on title, footer divider. Search + category chips filtering untouched.

## 5) Contact — LearnUp Home 4 + FiStudy `/contact`
FiStudy contact = `page-header` → `contact-two` "Our Address" (4 info cards) → `contact-three` (form + info) → newsletter.
We reproduce:
- A 4-card **"Our Address"-style info row** (Call / Email / Visit / Working hours) from live `site_settings`.
- Main form card (unchanged processing/validation/CSRF via `ajax/contact.php`).
- Right column = "Talk to a Course Counselor" panel, Get Directions (link only — no fake embed / no API key), social panel.
- Note: no map embed is inserted (site has no genuine embed/GMaps key); existing "Open in Google Maps" deep link used.

## 6) Brochure — DreamsLMS `contact-us.html` layout + FiStudy patterns
Neither FiStudy nor DreamsLMS has a brochure page (both 404 / absent from nav). The layout therefore follows the DreamsLMS **contact page** structure, re-populated with genuine brochure content:
- banner (breadcrumb + title + lead) → **3 info cards** (Visit Us / Call Us / Email Us, from `site_settings`) → **rounded light panel** (`#F1F4F9`, radius 26px): left `section-header` (badge + heading + "what's inside" list + Download/Browse CTAs) + right white **form card** (lead capture).
- Then the brochure's real content: catalogue cards, interactive syllabus accordion (tabs + expand/collapse + "View Syllabus" jump), highlights grid, quick CTA.
- Info cards use 1 / 2 / 3 columns at 390 / 768 / 1440 (`.tc-brochure-contact` overrides the shared 4-col contact grid).
- **Real PDF + gated flow preserved**: POST inserts into `enquiries`, sets `$_SESSION['brochure_access']`, redirects `?status=downloaded`, `download-brochure.php` streams `assets/downloads/technocoderz-brochure.pdf` (5.9 MB); locked sessions redirect to `?status=locked`. No fabricated PDF.

## Constraint compliance
- HTML/CSS only. No DB/schema/backend/route changes. Real data only (courses, testimonials, blogs, settings).
- All new styles scoped, appended at the end of `technocoderz.css` (shared template unaffected).
## 7) Homepage - LearnUp "Home 4" full layout recreation
Reference sections (extracted from the live rendered DOM at 1440px, top -> bottom):
1. Hero banner (.hero_banner, border-bottom, container 1320, pad 80/80, H1 50/700).
2. Brand / tech logo strip.
3. "Explore Our Courses" (pt-0) - category filter tabs + course-card grid.
4. Membership / certificate promo band (py-0) - tinted full-width band + media + CTA.
5. "Discover Categories" - category tiles.
6. "Meet Our Instructors" (bg-light #F1F4F9) - 6 profile cards.
7. "Why LearnUp Learning Platform?" - media + feature list.
8. "Get Membership" (bg-light) - pricing plans ($19/$99/$149).
9. "Hello!" contact - info + enquiry form.
10. Newsletter band (bg #0068D9 + bg image).
Footer: .dark-footer, bg #13293D, columns + bottom bar.

Techno Coderz mapping (genuine data only - 4 active courses, 3 categories, 6 testimonials, 6 benefits):
1. Hero                     -> kept (tagline + 2 existing CTAs + Vector.png visual).
2. Tech strip               -> kept (23 real tech logos).
3. Explore Our Courses      -> kept (filter = All + 3 real categories; cards = all 4 active courses).
4. Promo band               -> NEW (dark navy band, "Become a Certified Techno Coderz Professional"; reuses the existing "Explore Courses" CTA - no new button invented).
5. Discover Categories      -> kept (3 real category tiles with real course counts).
6. Success Stories          -> uses the real Testimonials (6) in a profile-card grid on bg-light.
                              NOTE: reference slot is "Instructors"; project has no instructor table/records, so the closest genuine data (student testimonials) was used instead of fabricating staff.
7. Why Techno Coderz?       -> kept (4 real why-features).
8. Learning Benefits        -> real benefit list (6) on bg-light.
                              NOTE: reference slot is paid "Get Membership" plans; project has no pricing plans (courses.price = 0 / no plans), so no prices were invented - the genuine benefits list fills the slot.
9. Contact / Enquiry        -> NEW inline section: real contact info (phone, phone2, email, email2, address) + enquiry form posting to the existing ajax/enquiry.php (same CSRF token). Reuses existing endpoint/handler function; only reuses existing CTA labels.
10. Newsletter              -> kept (real subscribe form, existing submitNewsletter()).
Footer                     -> restyled to a solid #13293D dark footer (LearnUp .dark-footer); same links/content.

Dropped from the old homepage (not present in LearnUp Home 4): search bar, stats band, About split, How-it-works, Services, Projects, Blog grid, FAQ accordion, "Not sure where to begin" CTA. These remain available on their own pages / nav.

Limitations:
- No image/screenshot review possible in this session (model has no image input); verification done via rendered DOM geometry + computed styles instead.
- Only 4 courses are active (status=1) in the DB, so "Explore Our Courses" shows 4 cards (reference shows 6). "Only as much data as exists" was honoured.
- No instructors and no pricing plans exist in the DB; those two reference slots were filled with the closest genuine data (testimonials / benefits) rather than fabricated content.

## 8) Task 2 pass (this session)
### 2A — "Technologies & tools you'll master" marquee (`index.php` + `technocoderz.css`)
Turned the static logo grid into a **continuous auto-scrolling marquee**: `.tc-home-tech__marquee` (overflow hidden + gradient `mask-image` fade) wraps `.tc-home-tech__track` (flex, `width:max-content`, `animation: tcHomeTechMarquee 42s linear infinite`). Each logo has `margin-right:16px` (not `gap`, so the `-50%` translate is seamless) and the item set is duplicated with `aria-hidden="true"` for the loop. Pauses on hover/`:focus-within`; mobile 30s + 12px spacing; `prefers-reduced-motion` falls back to a wrapped static grid (dup hidden). Verified 390/768/1440: 46 items = 23 logos ×2, no overflow.

### 2B — About page (`about.php`) rebuilt to FiStudy `/about`
Wrapper `.tc-page-light.tc-about-page` with 8 sections: banner → story (media collage + experience badge + Mission/Vision tabs) → Why Choose Us (quote from `$testimonials[0]` + 4 features) → counter band (4 genuine counters) → testimonials (6 from DB) → **sliding-text marquee band** → **newsletter box** → contact band (3 cards). Dropped the old FAQ/values/CTA. Reused shared `.tc-contact-*` / `.tc-about-tm__*` classes; new scoped `.tc-about-*` CSS. Verified: `php -l` clean, tab toggle works (2 buttons / 2 panels), no overflow 390/768/1440.

#### 2B-fix — restored FiStudy `sliding-text-three` + `newsletter-two`
The first 2B pass omitted two FiStudy About sections. Both are now restored (genuine content):
- **Sliding-text band** (`.tc-about-marquee`): orange gradient ribbon with a seamless marquee (`.tc-about-marquee__track`, `animation: tcAboutMarquee 28s linear infinite`, 5 value words ×2 = 10 items, `-50%` translate, hover-pause, `prefers-reduced-motion` → wrapped static). Height ~105px, `aria-label` for context.
- **Newsletter box** (`.tc-section.tc-about-news`): light card (`#fff`, radius 26px) with icon + heading + copy + inline email form (`#nlEmail` / `#nlMsg`, reuses the existing `submitNewsletter()` JS → `ajax/enquiry.php`). Because the global footer modal's `#enquiryCsrf` must carry the page token, `about.php` now also injects it (`document.getElementById('enquiryCsrf').value = '<?= e($csrf) ?>'`), matching index/courses/course-details/projects.
- Verified live: section order now matches FiStudy 1:1; marquee animates (computed `animationName: tcAboutMarquee`, `28s`); newsletter form present (`input[type=email]` + msg); `enquiryCsrf` = 64 chars; end-to-end POST returned `{"success":true}` against `ajax/enquiry.php`; no overflow/broken images/JS errors at 390/768/1440. Test `enquiries` row deleted afterwards.

### 2C — Brochure page (`brochure.php`) rebuilt to DreamsLMS `contact-us.html`
See section 6 above. Verified: `php -l` clean; HTTP 200; layout counts (3 info cards, form select = 6 options, 4 catalogue cards, 4 accordions, 4 highlights, CTA); no overflow 390/768/1440; end-to-end POST inserts an `enquiries` row and the gated PDF (application/pdf, 5.89 MB) is served; a fresh session is redirected to `?status=locked`. Test DB row cleaned up afterwards.
