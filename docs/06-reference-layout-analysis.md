# Techno Coderz — 3 Reference Websites Layout Analysis & Redesign Planning Document

**Project:** Techno Coderz (existing PHP + MySQL website)
**Working directory:** `C:\laragon\www\technocoderz-main`
**Analysis date:** 2026-10-13
**Analyst role:** Senior UI/UX Designer · Website Layout Analyst · PHP Developer

---

## 0. Method, tooling & honesty statement

- Every reference page was rendered at **1440px width in headless Chrome** and inspected through the
  **live DOM** (element rectangles, computed styles, section order, block structure) — not from memory
  and not from screenshots alone.
- **This model cannot view image pixels.** No screenshot was "eyeballed". All conclusions below come from
  rendered geometry and computed CSS. Where a conclusion depends on *visual* appearance that could only be
  confirmed by looking at a picture, it is labelled **Partial** or **Suggested**, never **Verified**.
- **Do not assume a section exists if it cannot be verified.** Pages/sections that could not be captured are
  listed explicitly in §1.4 and §7.
- Confidence labels used throughout:
  - **Verified** — directly observed in the live rendered DOM at 1440px.
  - **Partial** — only part of the section could be inspected (e.g. structure yes, appearance no).
  - **Suggested** — recommended design direction; **not** verified as an existing reference section.

### Reference sites inspected

| # | Reference | Root URL | Role in this plan |
|---|-----------|----------|-------------------|
| 1 | LearnUp — Home 4 (Shreethemes) | `https://learnup-shreethemes.netlify.app/home-4` | Inspires the **Home page** |
| 2 | FiStudy — Laravel | `https://fistudy-laravel.mnsithub.com/` | Inspires **About Us** and **Contact** |
| 3 | DreamsLMS — HTML Template (DreamsTechnologies) | `https://dreamslms.dreamstechnologies.com/html/template/index.html` | Inspires **Courses, Blog, FAQ** inner-page shell |

---

## 1. Step 1 — Inspection of the three reference websites

### 1.1 LearnUp — Home 4

| Aspect | Observation | Confidence |
|--------|-------------|-----------|
| Title | “LearnUp - Online Course & Education LMS Template” | Verified |
| Header / nav | Sticky top navbar, 80px tall (hero begins at `y=80`). Footer nav groups = **Navigations / New Categories / Help & Support / Download Apps**. Links observed: About Us, FAQs Page, Checkout, Contact, Blog. | Partial (nav links verified from footer; header item styling not visually confirmed) |
| Hero / banner | `.hero_banner.home-7.position-relative.border-bottom`, padding 80/80, height **690px**, container 1320. H1 “The #1 Place to Learn, Grow, and Succeed”. Two CTAs: “Join For Free”, “Browse Our Courses”. 7 images. | Verified |
| Typography | **Outfit, sans-serif** for body **and** headings. Body colour `#334155`, base H1 **50px / 700 / #212529**, H2 **30px**. | Verified |
| Colour usage | Primary **blue `#0068D9`** (`rgb(0,104,217)`); dark navy `#00305C`; light tints `#EDF1FB` / `#F1F4F9`; white surfaces; newsletter band solid `#0068D9` with a background image. | Verified |
| Content width / spacing | Container **1320px**. Section vertical padding mostly **80/80**. | Verified |
| Cards / grids / images / icons | Course grid (6 cards in ref), category tiles, 6 instructor profile cards, 3 pricing cards, blog cards (image + floating chip + date + author). Card radii **4–16px**. Bootstrap Icons / inline SVG. | Partial (structure verified; visual detail limited) |
| Course / category sections | “Explore Our Courses” (category filter tabs + 6 course cards) and “Discover Categories” (6 tiles). | Verified |
| About / intro section | No standalone “About the institute” split in Home 4; intro is folded into “Why LearnUp Learning Platform?”. | Verified |
| Features / benefits | “Why LearnUp Learning Platform?” — media + 4 feature items. | Verified |
| Stats / achievements | Stats appear in the promo/certificate band (icon row), not a dedicated 4-counter band. | Partial |
| Testimonials | Home 4 uses **“Meet Our Instructors”** (6 profile cards) instead of student testimonials. | Verified |
| Blog cards | Blog image with absolute category chip + date, bold title, author row, “Read More”. | Verified |
| CTA sections | Membership/certificate promo band (“Join LearnUp Membership & Get Certificate!”), pricing “Get Membership”, “Hello! / Become Tutor Today” enquiry block, newsletter band. | Verified |
| Footer | `.dark-footer`, background **`#13293D`**, 60px padding, 5+ columns, bottom credit “Shreethemes”. | Verified |
| Inner pages | **Not inspected** — only Home 4 was supplied as a reference for this plan. | n/a |
| Responsive | Not separately captured in this pass; the template ships Bootstrap grid classes (`col-lg-*`, `col-md-*`). | Partial |

**LearnUp Home 4 section order (top → bottom), verified:**

1. Hero banner (`.hero_banner`) — 690px
2. Brand / tech logo strip (266px, 9 images)
3. “Explore Our Courses” (`pt-0`) — category tabs + course grid
4. Membership / certificate promo band (`py-0`) — 320px
5. “Discover Categories” — 6 tiles (712px)
6. “Meet Our Instructors” (`bg-light` `#F1F4F9`) — 6 profile cards (618px)
7. “Why LearnUp Learning Platform?” — media + features (634px)
8. “Get Membership” (`bg-light`) — 3 pricing plans ($19/$99/$149) (870px)
9. “Hello! / Become Tutor Today” — enquiry block (535px)
10. Newsletter band (`bg-main` `#0068D9` + bg image) — “Join Thousand of Happy Students!” (327px)
→ Footer `.dark-footer` `#13293D`

---

### 1.2 FiStudy — Laravel

| Aspect | Observation | Confidence |
|--------|-------------|-----------|
| Title (about) | “About Us || Fistudy || Fistudy Laravel Template” | Verified |
| Header / nav | `main-header.main-header-three`, logo `logo-1.png` (106px), header block height **150px** (includes a top bar with `support@example.com` / `+12 (123) 456 78900`). Mega-menu with course categories (Tech & Programming, Creative Art, Business & Finance, Health & Wellness, Writing & Communication, Digital Marketing, Lifestyle & Productivity). | Verified |
| Hero / banner | `section.page-header`, height **419px**, gradient `linear-gradient(92.7deg, #F1F3FF, #F4…)`, breadcrumb + big title + social icons. | Verified |
| Typography | **Outfit, sans-serif**. Body colour `#6B778B`, H2 **60px**, H1/H2 weight heavy (700–800). | Verified |
| Colour usage | Primary **indigo `#687EFF`** (`rgb(104,126,255)`); accent **orange `#F87A53`** (`rgb(248,122,83)`) used for the contact-info strip; dark **`#052143`**; light `#F1F3FF`/`#FCFCFC`; white. | Verified |
| Content width / spacing | Outer container measured **~1424px**, inner content **1314px**. About page sections use **120/120px** vertical padding. | Verified |
| Cards / grids / images / icons | Numbered “why-choose” cards, image collages with floating badges, icon fonts (`icon-envelope`, `icon-phone`). Card radii **12–25px**. | Partial |
| Course / category sections | `/course` = “Course Grid”: banner + `course-grid` section (left filter sidebar: Search Now, Price Filter, Categories, Skills Level, 20% Discount promo + results grid). | Verified |
| About / intro | `about-three`: image/media collage (5 images) + text, mission/vision list cards (8 cards). | Verified |
| Features / benefits | `why-choose-three`: “Discover Why Our Students and Clients Choose…” with 4 numbered items (AI-Driven Personalization, Mobile-Optimized Learning, Gamified Learning Modules, Real-Time Analytics and Reporting). | Verified |
| Stats / achievements | `counter-one`: solid indigo **`#687EFF`** band, 3 counters, height 270px. | Verified |
| Testimonials | `testimonial-two`: slider, names (Mitchela Smith, Sarah Smith, Mitchel Clack…), ~90 card nodes, 19 images, large padding 145/200. | Verified |
| Sliding text | `sliding-text-three`: marquee ribbon of repeated large text (“Testimonial”) with a shape image between items. | Verified |
| Blog cards | Blog grid pages exist; card pattern not captured in this pass. | Not verified |
| CTA sections | `newsletter-two`: boxed “Subscribe our Newsletter” band (image + like icon + email input + Subscribe). `contact-info-one`: solid **`#F87A53`** strip with email + phone. | Verified |
| Footer | `site-footer-two`, columns (Home, About Us, Courses, FAQs, Contact, Live Class, Became Partners, Privacy & Policy), credit “FiStudy”. | Verified |
| Inner pages | Available: `/about`, `/course`, `/course-details`, `/contact`, `/faq`, `/pricing`, `/become-a-teacher`, `/workshop`, `/privacy-policy`, `/refund-policy`, `/terms`. | Verified (URLs); layouts captured for about/course/contact/faq |
| Responsive | Not separately captured; Bootstrap-based. | Partial |

**FiStudy About section order (verified):**
`page-header` → `about-three` → `why-choose-three` → `counter-one` → `testimonial-two` → `sliding-text-three` → `newsletter-two` → `contact-info-one` → footer.

**FiStudy Contact section order (verified):**
`page-header` → `contact-two` “Our Address” (Contact Number / Email Address / Class Schedule) → `contact-three` (form “Full Name / Email / Subject / Message” + info) → `newsletter-two` → `contact-info-one`.

**FiStudy FAQ section order (verified):**
`page-header` → `faq-page` (accordion of Q&A) → `newsletter-two` → `contact-info-one`.

---

### 1.3 DreamsLMS — HTML Template

| Aspect | Observation | Confidence |
|--------|-------------|-----------|
| Title | “Dreams LMS | Advanced Learning Management System Template” | Verified |
| Header / nav | `header-two`, logo “Logo” (156px), sticky header **69px** tall; an optional `header-topbar` (46px, black) appears on some pages. Mega-menu (Home, General Education, Online Course, Online Academy, Digital Learning, University, Kinder Garden, Language Academy, Gym Training, Courses). | Verified |
| Hero / banner | Inner pages use `div.breadcrumb-bar.text-center` (compact, **70–156px**) instead of a large hero. Home has its own hero. | Verified |
| Typography | **system-ui / `-apple-system, "Segoe UI", Roboto, …`** — i.e. the Bootstrap 5 default stack. **Not Outfit.** Body `#212529`, H1 **40px / 500**. | Verified |
| Colour usage | Primarily **Bootstrap default palette** (`btn-primary = #0D6EFD`), neutral surfaces (`#F0F0F0`, light grays), white. A violet/purple accent appears in a stat band in the template CSS. | Partial |
| Content width / spacing | Container **1320px**; sections often 60/60 padding. | Verified |
| Cards / grids / images / icons | Bootstrap cards, rounded (8–24px). Course cards, blog cards, testimonial cards. | Partial |
| Course / category sections | `course-grid.html` = **single `course-content` section only** — left filter sidebar (Categories, Instructors, Price, Range, Level, Reviews) + right course grid. **No page banner on this page.** `course-details.html` = single `course-details-two` section (video + content + curriculum accordion + sidebar). | Verified |
| About / intro | `about-us.html` = `about-section-two` “Empowering Learning, Inspiring Growth”, `benefit-section`, `counter-sec`, testimonials, `faq-section`. Also a `client-section` logo band. | Verified |
| Features / benefits | `benefit-section` “Master the Skills to Drive your Career”. | Verified |
| Stats / achievements | `counter-sec` (10K / 200+ / 6K+ / 60K+). | Verified |
| Testimonials | `testimonials-section` “Top Class & Professional Instructors” (Brenda Slaton, Adrian Dennis…). | Verified |
| Blog | `blog-grid.html`: `header-two` + `breadcrumb-bar text-center` “Blog 1 Grid” (70px) + `div.content` (12 images, blog grid + pagination) + `footer`. | Verified (block-level) |
| FAQ | `faq.html`: topbar + `header-two` + `breadcrumb-bar` “FAQ” (156px) + `div.content` “Most frequently asked questions” + `footer`. | Verified (block-level) |
| Contact | `contact-us.html` = single `contact-sec` “Get in touch with us today” (phone, email, “Send Us Message” form) **+ 1 iframe (map)**. | Verified |
| CTA sections | No standalone full-width CTA band captured on the inner pages inspected. | Partial |
| Footer | `footer` with container + columns; links include Search Mentors, Login, Register, Booking, Students Dashboard, Appointments, Chat; Terms & Conditions, Privacy Policy. | Verified |
| Inner pages | About Us, Course Grid, Course List, Course Category, Course Details, Blog Grid, Blog Details, Contact Us, FAQ, Pricing Plan, Become an Instructor, Testimonials, etc. | Verified (URLs); layouts captured for about/course-grid/course-details/blog-grid/contact/faq |
| Responsive | Not separately captured; Bootstrap-based. | Partial |

**DreamsLMS inner-page shell (verified):** `header` → `div.breadcrumb-bar.text-center` (breadcrumb + page title) → `div.content` → `footer`. (Blog-grid/FAQ use `div.content`; course-grid omits the breadcrumb entirely.)

---

### 1.4 Pages/sections that could NOT be verified (recorded separately)

- **LearnUp** inner pages (about, courses listing, blog, contact) — not supplied as references; not inspected.
- **LearnUp** exact header item styling, fonts of individual cards, and per-breakpoint behaviour — not visually confirmed.
- **FiStudy** blog card pattern, pricing table layout, workshop page, policy pages — URLs exist but layouts not captured.
- **DreamsLMS** `blog-details.html` inner structure (only that it renders a `content` block), `course-list`, `course-category`, `pricing-plan`, `become-an-instructor`, `testimonials` — not captured.
- **All three** — pixel-level visual styling (brand marks, illustration style, shadows) — cannot be judged without viewing images.
- **Responsive** — mobile/tablet layouts were not captured per reference in this pass.

---

## 2. Step 2 — Which layout to use where (page-by-page recommendation)

> Guiding constraint (from Step 6): this is an **existing IT-training institute** site. **No** shopping/checkout,
> student dashboard, LMS, or instructor-marketplace functionality is introduced unless the project already has it.
> The project has **no instructors table and no pricing plans**, so those reference slots are filled with the
> closest *genuine* Techno Coderz data, never fabricated.

### A. Home page — primary reference: **LearnUp Home 4**

| Section | Recommended inspiration | Why |
|---------|-------------------------|-----|
| Header / navbar | **LearnUp** navbar (keep the project's topbar + 6-item nav) | LearnUp’s clean sticky nav is the simplest fit; the project already has an equivalent. |
| Hero | **LearnUp** hero (tinted band, big H1, 2 CTAs, right visual) | Verified 690px tinted hero with two CTAs — matches the project’s existing structure. |
| Brand / tech strip | **LearnUp** logo strip, upgraded to the project’s animated marquee | Verified logo strip; project already reworked it into a marquee. |
| Course categories | **LearnUp** “Discover Categories” tiles | Verified 6-tile pattern; project shows its 3 real categories. |
| Featured courses / programs | **LearnUp** “Explore Our Courses” (filter tabs + cards) | Verified; project keeps its working filter + grid. |
| About the institute | **FiStudy** `about-three` split (media + text) | Verified on FiStudy About; gives the Home page a proper institute intro. |
| Why choose Techno Coderz | **FiStudy** `why-choose-three` numbered cards / **LearnUp** “Why LearnUp” | Both verified; project already has 4 real “why” features. |
| Technologies & skills taught | **LearnUp** brand strip → project **marquee** (original) | Verified strip; the marquee is a bespoke, on-brand extension. |
| Student achievements / success stories | **LearnUp** “Meet Our Instructors” slot → project **testimonials** | Verified slot; project has **no instructor data**, so genuine testimonials fill it (documented substitution). |
| Testimonials | **FiStudy** `testimonial-two` (slider) | Verified slider with names; project renders its 6 DB testimonials. |
| Stats / trust indicators | **FiStudy** `counter-one` / **DreamsLMS** `counter-sec` | Both verified solid stat bands; 8+, 1200+, 98%, 15+ are genuine. |
| Latest blogs | **LearnUp** blog cards (chip + date + title + Read More) | Verified card pattern. |
| Final CTA | **LearnUp** membership/tutor CTA band | Verified CTA band. |
| Footer | **LearnUp** `.dark-footer` (`#13293D`) | Verified; project footer restyled to a solid dark footer, same links. |

### B. About Us page — primary reference: **FiStudy `/about`** (+ DreamsLMS `about-us.html`)

| Section | Recommended inspiration | Why |
|---------|-------------------------|-----|
| Page banner / breadcrumb | **FiStudy** `page-header` | Verified tinted banner with breadcrumb + title. |
| Institute introduction | **FiStudy** `about-three` | Verified image/text split. |
| Mission & vision | **FiStudy** `about-three` mission/vision cards → project tabs | Verified list cards; project uses Mission/Vision tabs. |
| Why choose us | **FiStudy** `why-choose-three` | Verified numbered feature cards. |
| Teaching methodology | **FiStudy** `why-choose-three` copy / **DreamsLMS** `benefit-section` | Both verified; project uses its 4 real “values”. |
| Infrastructure / learning environment | Project media collage (FiStudy collage pattern) | FiStudy collage Verified; project uses real `institute/success-*.jpg`. |
| Achievements & testimonials | **FiStudy** `counter-one` + `testimonial-two` + `sliding-text-three` | All verified; project renders 4 counters, 6 testimonials, a marquee band. |
| CTA & footer | **FiStudy** `newsletter-two` + `contact-info-one`; project footer | Verified newsletter box + orange contact strip. |

### C. Courses page — primary reference: **DreamsLMS `course-grid.html`**

| Section | Recommended inspiration | Why |
|---------|-------------------------|-----|
| Page banner | Project banner (DreamsLMS course-grid has **none**) | DreamsLMS course-grid verified to have **no banner**; project keeps a consistent page hero. |
| Course category navigation | **DreamsLMS** left filter sidebar (Categories) | Verified sidebar filters; project adapts to Categories + live search. |
| Course cards / grid | **DreamsLMS** course grid + **LearnUp** card styling | Verified grid; project keeps its working `#courseGrid` cards. |
| Course descriptions | **DreamsLMS** card excerpt/meta | Verified card meta; project shows real short descriptions. |
| Course details links | **DreamsLMS** “Enroll Now” → project **Course Details** + **Syllabus/Enroll** | Verified CTA per card; project links to `course-details.php` and the brochure. |
| Course enquiry / admission CTA | **DreamsLMS** sidebar “help” widget → project “Need help choosing?” panel + CTA band | Verified widget; project keeps the working enquiry endpoint. |

> **Excluded on purpose:** DreamsLMS “Instructors”, “Reviews”, and “Price Range” filters — the project has **no instructors and no prices**, so those widgets are **not** introduced.

### D. Our Blog page — references: **LearnUp blog cards** + **DreamsLMS `blog-grid.html`** shell

| Section | Recommended inspiration | Why |
|---------|-------------------------|-----|
| Blog listing layout | **DreamsLMS** `breadcrumb-bar` + `content` shell | Verified shell (compact breadcrumb + content + footer). |
| Blog image proportions | **LearnUp** 16/10 with zoom-on-hover | Verified card media; project uses 16/10. |
| Blog cards | **LearnUp** card (floating category chip + date + author + Read More) | Verified card anatomy. |
| Category / date / title presentation | **LearnUp** chip + date pills; project keeps working category chips | Verified; project preserves its filter JS. |
| Read More buttons | **LearnUp** “Read More” | Verified. |
| Blog details page | **DreamsLMS** `blog-details.html` shell (content block) | Partial (only the content block verified). |
| Related articles | Project “You May Also Like” (DreamsLMS/DreamsLMS-style) | **Suggested** (not verified as a DreamsLMS blog-details section). |
| Footer | Project footer (**LearnUp** dark-footer) | Verified pattern. |

### E. Brochure page — **no reference exists → original design**

| Section | Recommended inspiration | Why |
|---------|-------------------------|-----|
| Whole page | **Original design**, using DreamsLMS `contact-us.html` boxed-panel pattern for structure and FiStudy `newsletter-two` for the CTA/form wording | **Neither LearnUp, FiStudy, nor DreamsLMS has a brochure page.** FiStudy `/brochure` → 404; DreamsLMS has no brochure route (checked nav, footer, sitemap). Per the brief, recommend an **original** layout rather than inventing a reference. |
| Structure to use (original) | Banner → 3 info cards → rounded light panel (intro + “what’s inside” + Download/Browse) → catalogue cards → interactive syllabus accordion → highlights → CTA | Reuses verified DreamsLMS/FiStudy *patterns* (boxed panel, info cards, accordion) in an original composition. |
| Document download | Project **real PDF** `assets/downloads/technocoderz-brochure.pdf` via gated `download-brochure.php` | Genuine asset + existing flow; **no fabricated PDF**. |

### F. Contact Us page — references: **FiStudy `/contact`** + **DreamsLMS `contact-us.html`**

| Section | Recommended inspiration | Why |
|---------|-------------------------|-----|
| Contact page banner | **FiStudy** `page-header` / **DreamsLMS** `breadcrumb-bar` | Verified (FiStudy full banner; DreamsLMS compact). |
| Contact information cards | **FiStudy** `contact-two` “Our Address” (4 cards) | Verified 4-card info row. |
| Contact form | **FiStudy** `contact-three` + **DreamsLMS** “Send Us Message” | Both verified; project keeps its working `ajax/contact.php` form. |
| Address & map section | **DreamsLMS** contact `iframe` (map) | Verified 1 iframe. **Project has no genuine map embed/key**, so it uses an “Open in Google Maps” deep link instead (documented). |
| Enquiry CTA | **FiStudy** `contact-info-one` strip → project CTA band | Verified orange strip. |
| Footer | **FiStudy** `site-footer-two` / project footer | Verified. |

---

## 3. Step 3 — Reference mapping table

Columns: **Techno Coderz Page | Section | Reference Website | Exact Reference URL | Layout/Pattern to Take | What to Customize | Confidence**

| Techno Coderz Page | Section | Reference Website | Exact Reference URL | Layout/Pattern to Take | What to Customize | Confidence |
|---|---|---|---|---|---|---|
| Global | Header / navbar | LearnUp | `https://learnup-shreethemes.netlify.app/home-4` | Sticky top nav, 80px, topbar + main nav | Keep 6 real nav items + real phone/email from `site_settings`; orange brand not blue | Verified |
| Global | Footer | LearnUp | `https://learnup-shreethemes.netlify.app/home-4` | `.dark-footer` solid `#13293D`, multi-column + bottom bar | Real links, courses, contact; brand colour accents | Verified |
| Global | Inner-page shell | DreamsLMS | `https://dreamslms.dreamstechnologies.com/html/template/blog-grid.html` | `header → breadcrumb-bar → content → footer` | Replace breadcrumb-bar with the project’s tinted page-hero for brand consistency | Verified |
| Home | Hero banner | LearnUp | `.../home-4` | Tinted band, H1 50/700, 2 CTAs, right visual, border-bottom | Real headline + existing CTAs; keep `Vector.png` visual | Verified |
| Home | Tech / brand strip | LearnUp | `.../home-4` | Horizontal logo strip under hero | 23 real tech logos as an animated marquee | Verified |
| Home | Explore Our Courses | LearnUp | `.../home-4` | Category filter tabs + course-card grid | Only the 4 real active courses; 3 real categories | Verified |
| Home | Promo / certificate band | LearnUp | `.../home-4` | Full-width tinted promo band + media + single CTA | Reuse existing “Explore Courses” CTA (no invented button) | Verified |
| Home | Discover Categories | LearnUp | `.../home-4` | Category tiles with counts | 3 real categories with real counts | Verified |
| Home | Success stories / profiles | LearnUp | `.../home-4` | `bg-light` profile-card row | **No instructor data** → use 6 real testimonials | Partial (slot verified; data substituted) |
| Home | Why Techno Coderz | LearnUp / FiStudy | `.../home-4`, `.../about` | “Why …” feature list (media + items) | 4 real “why” features | Verified |
| Home | Benefits / plans slot | LearnUp | `.../home-4` | `bg-light` pricing/benefit band | **No pricing data** → real benefits list (no prices invented) | Partial |
| Home | Contact / enquiry | LearnUp | `.../home-4` | “Hello!” info + enquiry form block | Real contact info + existing `ajax/enquiry.php` | Verified |
| Home | Newsletter | LearnUp | `.../home-4` | Newsletter band with email form | Existing `submitNewsletter()` + real settings | Verified |
| About | Page banner | FiStudy | `https://fistudy-laravel.mnsithub.com/about` | `page-header` tinted banner + breadcrumb + title | 8+ years / “About Techno Coderz” real copy | Verified |
| About | Institute introduction | FiStudy | `.../about` | `about-three` media collage + text | Real `institute/success-*.jpg` + “8+ Years” badge | Verified |
| About | Mission & vision | FiStudy | `.../about` | Mission/vision list cards | Mission/Vision tabs with real copy | Verified |
| About | Why choose us | FiStudy | `.../about` | `why-choose-three` numbered cards | 4 real values | Verified |
| About | Counter band | FiStudy | `.../about` | `counter-one` solid stat band | 4 real counters (8+, 1200+, 98%, 15+) | Verified |
| About | Testimonials | FiStudy | `.../about` | `testimonial-two` slider | 6 real DB testimonials | Verified |
| About | Sliding text ribbon | FiStudy | `.../about` | `sliding-text-three` marquee | Real value words (Practical Training, Live Projects …) | Verified |
| About | Newsletter box | FiStudy | `.../about` | `newsletter-two` boxed subscribe | Real copy + `submitNewsletter()` | Verified |
| About | Contact info strip | FiStudy | `.../about` | `contact-info-one` info strip | 3 real info cards (Visit / Call / Email) | Verified |
| Courses | Banner | Project (no ref banner) | `https://dreamslms.dreamstechnologies.com/html/template/course-grid.html` | (Ref has **no** banner) keep project page-hero | Consistent project banner | Verified (absence) |
| Courses | Category filter sidebar | DreamsLMS | `.../course-grid.html` | Left sidebar filters (Categories, search, help widget) | Real categories + live search; **drop Instructors/Price/Reviews** | Verified |
| Courses | Course grid | DreamsLMS | `.../course-grid.html` | Right card grid with meta | 4 real course cards, 16/9 thumbs | Verified |
| Courses | Course card CTA | DreamsLMS | `.../course-grid.html` | “Enroll Now” / detail link | Link to `course-details.php` + brochure | Verified |
| Courses | Help / admission CTA | DreamsLMS | `.../course-grid.html` | Sidebar help widget + bottom CTA | “Need help choosing?” + existing enquiry endpoint | Verified |
| Blog | Page shell | DreamsLMS | `.../blog-grid.html` | breadcrumb-bar + content + footer | Project page-hero + grid | Verified |
| Blog | Cards | LearnUp | `.../home-4` | Image + chip + date + author + Read More | Real 6 posts; keep filter chips | Verified |
| Blog | Details page | DreamsLMS | `.../blog-details.html` | Content block + sidebar | Real post body + related | Partial |
| Blog | Related articles | DreamsLMS | `.../blog-details.html` | “Related / You May Also Like” | Project related-posts block | Suggested |
| Brochure | Whole page | **None** | (no reference) | Original composition using DreamsLMS boxed panel + info cards | Real brochure content + real PDF flow | Suggested |
| Brochure | Download flow | Project | `assets/downloads/technocoderz-brochure.pdf` | Gated form → PDF | Existing `enquiries` insert + session gate | Verified (in project) |
| Contact | Banner | FiStudy | `https://fistudy-laravel.mnsithub.com/contact` | `page-header` banner | Real title/breadcrumb | Verified |
| Contact | Info cards | FiStudy | `.../contact` | `contact-two` 4-card “Our Address” | Real Call/Email/Visit/Hours from settings | Verified |
| Contact | Contact form | FiStudy / DreamsLMS | `.../contact`, `.../contact-us.html` | `contact-three` form + sidebar | Existing `ajax/contact.php`, CSRF, validation | Verified |
| Contact | Map | DreamsLMS | `.../contact-us.html` | Embedded map `iframe` | **No genuine key** → “Open in Google Maps” link | Partial |
| Contact | Enquiry CTA | FiStudy | `.../contact` | `contact-info-one` strip / CTA band | Real contact info + brochure CTA | Verified |
| FAQ | Shell + accordion | DreamsLMS / FiStudy | `.../faq.html`, `.../faq` | breadcrumb + accordion content | Real FAQ wording, grouped by category | Verified |

---

## 4. Step 4 — Are the reference layouts identical? (evidence-based)

**Conclusion: No. They are three distinct templates that share common education-template conventions, plus a few
visually similar individual sections. There is no exact or near-exact full-layout match between them.**

### Evidence

| Comparison axis | Finding | Evidence |
|---|---|---|
| Typography | **Different.** LearnUp & FiStudy use **Outfit**; DreamsLMS uses the **Bootstrap system-ui stack**. | Computed `font-family` at 1440px: LearnUp `Outfit, sans-serif`; FiStudy `Outfit, sans-serif`; DreamsLMS `system-ui, -apple-system, "Segoe UI", Roboto…`. |
| Primary palette | **Different.** Blue `#0068D9` (LearnUp) vs indigo `#687EFF` + orange `#F87A53` (FiStudy) vs Bootstrap `#0D6EFD` (DreamsLMS). | Computed button/background colours. |
| Hero composition | **Different.** LearnUp = tall 690px tinted hero with 2 CTAs; FiStudy = 419px gradient `page-header`; DreamsLMS = compact 70–156px `breadcrumb-bar`. | Rendered rects. |
| Navbar structure | **Similar convention, different product.** All have a sticky multi-column mega-menu; item sets differ entirely. | Captured nav lists. |
| Card / grid patterns | **Reusable convention.** All use Bootstrap card grids for courses/blog. Radii differ (4–16 / 12–25 / 8–24). | Computed styles. |
| Section order | **Different order per template** (see §1 lists). No two pages share an identical section sequence. | Section dumps. |
| Image placement | **Similar convention** (media-left/text-right splits) but different collage styles. | Structure only. |
| Background transitions | **Convention.** Alternating white / light-tint bands in all three; DreamsLMS adds one solid stat band, FiStudy adds an indigo counter band + orange contact strip. | Computed backgrounds. |
| CTA placement | **Convention.** Newsletter near the bottom in LearnUp & FiStudy; DreamsLMS puts map/form in the content block. | Section dumps. |
| Footer columns | **Similar convention, different names.** All multi-column; content differs. | Footer dumps. |

### Classified

1. **Similar design patterns** — tinted page banner, alternating section backgrounds, card grids, dark multi-column footer (common across education templates).
2. **Reusable education-template conventions** — Bootstrap 5 + 1320px container, badge + H2 + lead section headers, newsletter band, stat band.
3. **Visually similar individual sections** — e.g. LearnUp brand logo strip vs FiStudy client logo band; a stat band appears in all three with different colours.
4. **Exact / near-exact full-layout match** — **none found.** Each template has its own font, palette, hero height, and section sequence. No evidence supports calling any page a copy of another.

---

## 5. Step 5 — Inspection of the existing project

**Project directory (per instruction):** `C:\laragon\www\Tech` — verified to contain a nested git repo at
**`C:\laragon\www\Tech\Tech`** (`.git` present, last edited 2026-10-06 → 10-09).
**Session working directory:** `C:\laragon\www\technocoderz-main` (a newer copy **without** `.git`, last edited 2026-10-12 → 10-13).
**Per the decision for this document, analysis is based on `C:\laragon\www\technocoderz-main`** (it carries the latest redesign work). The two trees share the same file structure; only timestamps/content of the redesigned pages differ.

### 5.1 Actual file structure (verified)

```
technocoderz-main/
├─ index.php              # Home page (LearnUp Home 4 recreation)
├─ about.php              # About Us (FiStudy layout)
├─ courses.php            # Courses listing (DreamsLMS course-grid style)
├─ course-details.php     # Single course (?slug=)
├─ blog.php               # Blog listing
├─ blog-details.php       # Single post (?slug=)
├─ contact.php            # Contact (FiStudy/DreamsLMS style)
├─ faq.php                # FAQ accordion
├─ brochure.php           # Brochure / lead capture
├─ download-brochure.php  # Gated PDF stream
├─ services.php           # Services (no reference)
├─ projects.php           # Projects (no reference)
├─ career.php             # Career (no reference)
├─ index_dark.php, index_new.php, test.php, *_probe*.html, *.html   # extras/probes
├─ includes/
│  ├─ header.php          # <head> + Bootstrap 5.3.3 + bootstrap-icons 1.11.3 + technocoderz.css
│  ├─ navbar.php          # Topbar + navbar (Home, About, Courses, Our Blogs, Brochure, Contact Us)
│  ├─ footer.php          # Enquiry modal + 4 footer cols + social + scripts
│  ├─ functions.php       # CSRF, DB helpers, auth, uploads, formatting
│  └─ index.php
├─ ajax/
│  ├─ enquiry.php         # Enquiry + newsletter POST handler
│  └─ contact.php         # Contact form POST handler
├─ config/
│  └─ database.php        # PDO singleton; DB technocoderz; SITE_URL auto-detect; ADMIN_URL; UPLOAD_DIR
├─ admin/                 # Admin panel (auth + CRUD)
│  ├─ dashboard.php, index.php, login.php, logout.php, settings.php
│  ├─ blogs/ courses/ enquiries/ messages/ projects/ services/ testimonials/
│  └─ includes/
├─ assets/
│  ├─ css/  technocoderz.css, home.css, admin.css
│  ├─ js/   technocoderz.js   # reveal, tabs, openEnquiry/submitEnquiry, submitContact, submitNewsletter, tcToast
│  ├─ images/  institute/  team/  tech/  Vector.png  favicon.svg  default-*.svg  image.png
│  ├─ downloads/  technocoderz-brochure.pdf   (real, ~5.9 MB)
│  └─ uploads/
├─ database/
│  └─ technocoderz.sql    # schema + seed
├─ docs/                  # 01-architecture.md … 05-working-rules.md, README.md
└─ REFERENCE-DESIGN-NOTES.md
```

### 5.2 Database (config-verified)

- **Name:** `technocoderz`, host `localhost`, user `root`, empty password (local dev).
- **Tables:** `users, courses, services, projects, testimonials, blogs, enquiries, contact_messages, site_settings`.
- **Real content:** 4 active courses (`courses.status = 1`), 6 testimonials, 6 blogs, 6 services, 6 projects.
- **No** instructors table, **no** pricing-plans table, **no** stats table.

### 5.3 Existing backend / functionality to preserve

- CSRF tokens (`generateCsrfToken` / `verifyCsrfToken`), session (`TC_SESSION`).
- Form handlers: `ajax/enquiry.php` (enquiries + newsletter), `ajax/contact.php` (contact_messages).
- Gated brochure: POST → `enquiries` insert → `$_SESSION['brochure_access']` → `download-brochure.php` streams the PDF.
- Admin auth (`isAdminLoggedIn`, `requireAdminLogin`) + CRUD for blogs/courses/enquiries/messages/projects/services/testimonials/settings.
- Image upload helper (`uploadImage`, 2 MB, JPG/PNG/WebP) + delete helper.
- Auto-detected `SITE_URL`, `ADMIN_URL`, `UPLOAD_DIR`.

---

## 6. Step 6 — Protection & compliance rules (for any later build work)

1. Work **only** in `C:\laragon\www\technocoderz-main` (this document’s agreed target). Do **not** modify `C:\laragon\www\technocoderz`.
2. **Do not delete** existing files; do **not** create unnecessary duplicate files.
3. **Do not change** database schema, CRUD operations, admin functionality, routes, form processing, or backend logic.
4. **Preserve** database-driven content, working links, and form submissions.
5. **Reuse** existing components (`includes/*`, `assets/css/technocoderz.css`, `assets/js/technocoderz.js`) and assets.
6. **Do not replace** real Techno Coderz content with demo content.
7. CSS-only additions are appended/scoped so the shared template is unaffected.
8. Real content only — no fabricated statistics, prices, staff, testimonials, or files.

---

## 7. Summary of recommended reference per page

| Page | Primary reference | Secondary | Confidence |
|------|-------------------|-----------|-----------|
| Home | **LearnUp Home 4** | FiStudy (about split, testimonial slider) | Verified |
| About Us | **FiStudy `/about`** | DreamsLMS `about-us.html` | Verified |
| Courses | **DreamsLMS `course-grid.html`** | LearnUp card styling | Verified |
| Blog | **LearnUp blog cards** | DreamsLMS `blog-grid.html` shell | Verified / Partial |
| Brochure | **Original design** (no reference) | DreamsLMS contact panel + FiStudy newsletter | Suggested |
| Contact | **FiStudy `/contact`** | DreamsLMS `contact-us.html` | Verified |

### Known gaps / limitations

- No image-pixel review was possible; visual fidelity is asserted only where DOM/computed-style evidence exists.
- The project legitimately lacks instructor data, pricing plans, and a map key; corresponding reference slots are filled with genuine alternatives and are clearly flagged rather than fabricated.
- Only 4 courses are active, so the Home/Courses grids show 4 cards (references show 6).
- LearnUp inner pages and several DreamsLMS inner pages were outside the captured set (see §1.4).

---

*Prepared for the Techno Coderz redesign. This is a planning document — no page code was modified in producing it
(except prior, separately-approved work already present in `technocoderz-main`).*
