# 04 — Problems in this code (prioritized)

Severity:

- **P0** — a visitor/you loses data or hits a dead link. Fix now.
- **P1** — architecture debt that makes every task slower or risky.
- **P2** — quality/hygiene; fix when you touch the file.

Evidence is `file:line` as of the current working copy.

---

## P0 — things that are broken for real users

### P0-1 · Home "Enquire Now" form saves nothing
`index.php:185` + `index.php:584`
```js
onsubmit="event.preventDefault(); handleFormSubmit();"
function handleFormSubmit(){ /* shows a toast for 3.5s */ }
```
The visitor gets "success" but **no row is written** — no `enquiries` record,
no email, nothing in admin. Every lead from the homepage is silently lost.

**Fix:** reuse the existing pattern: `fetch('ajax/enquiry.php', {…, csrf_token})`
like `contact.php` does. (Backend already exists — no new PHP needed.)

### P0-2 · Logo links to a deleted file → 404
`index.php:112` → `href="index.php"`, but `index.html` no longer exists.

**Fix:** `href="index.php"`.

### P0-3 · `index.php` is invisible to the admin panel
Because it has **0 PHP tags**, none of its content (hero, projects, footer
address, phone) can be edited from `/admin`. Edits require a developer.

**Fix:** migrate to the include skeleton → [03-index-vs-about.md](03-index-vs-about.md).

### P0-4 · Homepage is a different design system than the rest
Two CSS frameworks loaded on different pages (Tailwind CDN vs
Bootstrap+`technocoderz.css`), two palettes (teal/blue vs orange/slate), two
navbars, two footers.
Consequences: inconsistent UX, double styling weight, and **bug fixes applied
to one page never reach the home page** (e.g. mobile overflow fixes live in
`technocoderz.css`, which home never loads).

---

## P1 — architecture debt

### P1-1 · Three homepages + two HTML drafts in the project
| File | Status |
|------|--------|
| `index.php` | live, static |
| `includes/index.php` | correct stack, **wrong folder**, never linked |
| `index_dark.php` | duplicate, dark theme |
| `college-hero.html`, `home-content.html` | design drafts |

New developers cannot tell which is the truth. **Fix:** keep one, archive the rest.

### P1-2 · A full page lives inside `includes/`
`includes/index.php` (33 KB) violates the folder rule from
[01-architecture.md](01-architecture.md): `includes/` = fragments only.
**Fix:** move it out (or merge it into `index.php` and delete it).

### P1-3 · `test.php` in the web root
Anything in the root is publicly reachable (`localhost/Tech/test.php`).
**Fix:** delete it, or move experiments outside the web root.

### P1-4 · Secrets committed to git
`config/database.php` holds `DB_USER=root`, `DB_PASS=''`, and `SITE_URL` is a
hard-coded localhost URL. When you deploy, someone must remember to edit it —
and the repo keeps leaking dev credentials.
**Fix (later):** read env vars (`getenv('DB_PASS')`) or a git-ignored
`config/local.php`; set `SITE_URL` from the request host when safe.

### P1-5 · One 103 KB / 747-rule CSS file for everything
`assets/css/technocoderz.css` contains **both** the dark theme and the light
theme layered on top of each other (`.tc-page-light` re-declares tokens so the
dark rules resolve to light colours). It works, but:
- you cannot remove a dark rule without risking a light page;
- new pages must remember the wrapper class;
- cascading surprises (e.g. a grouped rule at ~line 2884 forced dark text on
  white cards until it was overridden).

**Fix:** eventually split into `tokens.css`, `base.css`, `components.css`,
`pages/*.css` — or delete the dark layer once `index_dark.php` is gone.

### P1-6 · No `.env` / config separation for environments
Dev URL, prod URL, DB name are all the same constants.
**Fix:** one `ENV` constant driving `SITE_URL`, error display, and logging.

### P1-7 · No project `README.md`
A new developer has no setup steps (import `database/technocoderz.sql`,
Laragon config, default admin login).
**Fix:** 20-line root README pointing to `docs/`.

---

## P2 — code quality & hygiene

### P2-1 · Inline `style="…"` everywhere
Counts of `style="` per page: `course-details` 41, `index_dark` 48,
`brochure` 31, `contact` 27, `blog-details` 25 …
Inline styles beat every CSS rule, so components can't be themed consistently.
**Fix:** move repeated values into CSS classes as you touch each page.

### P2-2 · Negative transforms break mobile layout
`index.php:159/169/175` — `translateX(-19%)`, `translateX(-85px)`,
`translateX(-82px)`. At 375 px these elements stick out of the viewport
(measured: 6 overflowing nodes; `body{overflow-x:hidden}` hides it, so users
see cut-off content instead of a scrollbar).
**Fix:** use the grid columns to align instead of manual nudges.

### P2-3 · Duplicate/conflicting style blocks
The same selectors are redefined at several points in `technocoderz.css`
(`.tc-cta-section` appears 4×, `.tc-btn-primary` 3×). Whoever edits the wrong
copy sees no effect.
**Fix:** with P1-5, keep exactly one definition per selector.

### P2-4 · Hard-coded placeholder content
Footer office address (`Geneva 76, 50035`), phone `+91 98765 43210`, and
project cards "Project Name/Website" are placeholders shown to real visitors.
`site_settings` already stores phone/email/location — read from it.

### P2-5 · Missing engineering basics
- No 404 page (unknown URL shows Apache's default).
- No error log convention (`error_log()` only used in `getDB()`).
- No `.editorconfig` / linter / `php -l` in a pre-commit hook.
- No automated tests (even a smoke script hitting every URL would catch
  PHP warnings — see the verification checklist in
  [05-working-rules.md](05-working-rules.md)).

### P2-6 · Accessibility gaps
Nav hamburger button has no `aria-label`; several links are `href="#"`
(social icons); images on the home page come from unsplash URLs (slow, can
break offline).
**Fix:** add `aria-label`s, real URLs, and local images under `assets/images/`.

---

## Suggested order of attack

| # | Problem | Effort | Why first |
|---|---------|--------|-----------|
| 1 | P0-2 logo 404 | 1 line | zero risk |
| 2 | P0-1 enquire form | small (JS only) | stops losing leads |
| 3 | P1-3 delete `test.php`, P1-1 archive drafts | minutes | reduces confusion |
| 4 | P0-3/P0-4 + P1-1/P1-2 homepage migration | medium | big payoff, follow [03](03-index-vs-about.md) |
| 5 | P1-4 secrets, P1-6 env | small | before any deploy |
| 6 | P1-5 CSS split, P2-* | ongoing | do while touching files |
