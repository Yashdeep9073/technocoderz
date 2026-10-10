# 01 — Architecture & Folder Structure

## 1. The big picture

```
                    ┌────────────────────────────────────────────┐
 Browser ──────────▶│  Public pages (root *.php)                 │
 (visitor)          │  index / courses / blog / brochure / ...   │
                    └───────────────┬────────────────────────────┘
                                    │ uses
                    ┌───────────────▼────────────────────────────┐
                    │  includes/  → header, navbar, footer,      │
                    │               functions (shared code)      │
                    └───────────────┬────────────────────────────┘
                                    │ uses
                    ┌───────────────▼────────────────────────────┐
                    │  config/database.php → DB credentials +    │
                    │                        getDB() connection  │
                    └───────────────┬────────────────────────────┘
                                    │
                              MySQL (technocoderz)

 Browser ──────────▶  ajax/*.php  → returns JSON (form data saved)
 Admin user ────────▶  admin/*.php → login → CRUD on same tables
```

Three kinds of PHP files exist in this project. **Never confuse them:**

| Kind | Example | Returns | Has `<html>`? |
|------|---------|---------|---------------|
| **Page** (full HTML) | `about.php` | HTML page | Yes |
| **Partial** (piece of HTML) | `includes/navbar.php` | Only a `<nav>` chunk | No (a fragment) |
| **Endpoint** (no HTML) | `ajax/contact.php` | JSON | No |

---

## 2. Annotated folder tree (actual repo)

```
Tech/                              ← project root = web root (localhost/Tech)
│
├── index.php                      ← ⚠️ HOME PAGE but written as STATIC HTML (0 PHP tags!)
├── about.php                      ← ✅ normal page: uses includes/ + DB-ready
├── courses.php                    ← ✅ normal page (course list from DB)
├── course-details.php             ← ✅ one course by ?id= (reads DB)
├── blog.php / blog-details.php    ← ✅ blog list / single post from DB
├── brochure.php                   ← ✅ lead-capture form → session → PDF download
├── download-brochure.php          ← ⚙️ ENDPOINT: streams the PDF (no HTML)
├── contact.php                    ← ✅ contact form page (saves via ajax/contact.php)
├── faq.php, services.php, career.php, projects.php  ← ✅ normal pages
│
├── index_dark.php                 ← ⚠️ ANOTHER homepage (dark theme) — duplicate
├── test.php                       ← ⚠️ throwaway file, should be deleted
├── college-hero.html, home-content.html  ← ⚠️ leftover design drafts (HTML only)
│
├── config/
│   └── database.php               ← 🔐 ALL settings: DB host/user/pass, SITE_URL,
│                                     upload paths + getDB() (one shared PDO connection)
│
├── includes/                      ← shared pieces used by pages
│   ├── functions.php              ← session start, helpers (e(), sanitize),
│   │                                 CSRF, DB helpers, flash messages
│   ├── header.php                 ← <head>, CSS links, <body> opening
│   ├── navbar.php                 ← the navigation menu (nav array + markup)
│   ├── footer.php                 ← footer + JS scripts
│   └── index.php                  ← ⚠️ a full HOMEPAGE accidentally sitting here
│
├── ajax/                          ← JSON endpoints (called by fetch(), no HTML)
│   ├── contact.php                ← saves contact_messages row
│   └── enquiry.php                ← saves enquiries row
│
├── admin/                         ← admin panel (own login, own header/footer)
│   ├── login.php / logout.php / dashboard.php / settings.php
│   ├── includes/admin_header.php, admin_footer.php
│   ├── courses/  blogs/  projects/  services/  testimonials/
│   ├── enquiries/  messages/     ← see what visitors submitted
│
├── assets/                        ← everything the browser downloads (NO PHP here)
│   ├── css/technocoderz.css       ← the one big theme file (light + dark layers)
│   ├── js/technocoderz.js         ← filters, form submits, modals
│   ├── images/…  uploads/…        ← static images + user uploads
│   └── downloads/…                ← brochure PDF
│
├── database/technocoderz.sql      ← table structure (import this into MySQL)
│
└── docs/                          ← 📚 you are here
```

### Folder rules (the "why" of each folder)

| Folder | Why it exists | Rule |
|--------|---------------|------|
| **root** | Public URLs are short: `localhost/Tech/courses.php` | Only full pages + tiny endpoints live here |
| **`config/`** | Secrets and settings in **one** place. Change DB password once → whole site follows | Never echo its values; never copy credentials into pages |
| **`includes/`** | DRY: header/nav/footer written once, reused by 15 pages | Only fragments + shared functions. **No full pages here** |
| **`ajax/`** | Form handling separated from rendering (JSON in → JSON out) | Must `header('Content-Type: application/json')`, must verify CSRF |
| **`admin/`** | Visitor-facing code and admin code stay separate; admin can be protected as a unit | Every admin file starts with `requireAdminLogin()` |
| **`assets/`** | Static files are served directly by Apache (fast, no PHP) | No PHP inside `assets/` ever |
| **`database/`** | Schema lives in version control, so a fresh machine can rebuild | SQL file is structure, not live data |

---

## 3. What runs when someone opens a page

Example: `http://localhost/Tech/about.php`

```
1. Apache sees about.php → asks PHP to execute it
2. about.php line 6:  require functions.php
        │
        ├── functions.php line 6:  require config/database.php
        │         → constants (DB_*, SITE_URL) defined
        │         → getDB() available (connection created on first call)
        └── functions.php: session_start()  → cookie set for this visitor
3. about.php: $pageTitle, $currentPage set   ← these MUST be set before header
4. require header.php  → prints <!DOCTYPE>, <head>, opens <body>
        (uses e($pageTitle) and SITE_URL)
5. require navbar.php  → prints the <nav> (active link highlighted via $currentPage)
6. about.php: HTML content + any DB queries (getDB()->query(...))
7. require footer.php  → prints footer, closes </html>, loads JS
8. PHP output → Apache → browser
```

**Key idea:** the page file contains only *its own content*. Everything else
(top of page, menu, bottom of page, database, session) is injected by includes.

---

## 4. Data flow (how a form becomes a database row)

```
contact.php  (renders form + CSRF token)
     │  submit (fetch, no page reload)
     ▼
assets/js/technocoderz.js  →  POST ajax/contact.php  {fields…, csrf_token}
     ▼
ajax/contact.php
     ├── method must be POST
     ├── verifyCsrfToken()     ← reject fakes
     ├── sanitize() inputs
     ├── prepared INSERT into contact_messages
     └── echo {"success":true, ...}      ← JS shows the message
```

Brochure download uses a **gate** instead of AJAX:

```
brochure.php (POST) → INSERT enquiries → $_SESSION['brochure_access'] = 1
                      → redirect brochure.php?status=downloaded
download-brochure.php → if session flag missing → redirect ?status=locked
                        else → stream assets/downloads/*.pdf
```

That gate is backend logic. **Do not touch it during UI work.**

---

## 5. Where styling lives

| What | File |
|------|------|
| Global theme, tokens (`--primary-orange`, `--text-dark`), page themes | `assets/css/technocoderz.css` |
| Utility classes on `index.php` only | Tailwind CDN (`cdn.tailwindcss.com`) |
| Grid/buttons base | Bootstrap 5 CDN (loaded in `includes/header.php`) |
| Page-specific one-offs | Inline `style="..."` in the page markup |

⚠️ Because `index.php` uses Tailwind and every other page uses Bootstrap +
`technocoderz.css`, the site currently ships **two styling systems**.
See [03-index-vs-about.md](03-index-vs-about.md).
