# 03 — Why `index.php` and `about.php` are completely different

Short answer: **they were built as two different projects and never merged.**
`about.php` (and 12 other pages) follow the project's real architecture.
`index.php` is a static landing-page draft that was renamed to `index.php`.

---

## 1. Side-by-side (facts from this repo)

| Question | `index.php` (home) | `about.php` (and every other page) |
|----------|--------------------|------------------------------------|
| PHP tags in file | **0** — it is pure HTML | 6+ (`require`, `<?= ?>`) |
| Uses `includes/header.php`? | ❌ no — writes its own `<head>` | ✅ yes |
| Uses `includes/navbar.php`? | ❌ no — 2nd hand-written nav | ✅ yes |
| Uses `includes/footer.php`? | ❌ no — hand-written footer | ✅ yes |
| CSS system | **Tailwind CDN** + a small inline `<style>` | **Bootstrap 5 + `technocoderz.css`** |
| Colour language | `#05313F` teal, `#1B72E8` blue, `#FDFBF7` cream | `#FF6B00` orange, `#1E293B` slate |
| Reads the database? | ❌ no (all text hardcoded) | ✅ yes (`getDB()`) |
| Editable from `/admin`? | ❌ no | ✅ yes (courses, blogs, settings) |
| "Enquire Now" form | `onsubmit="preventDefault()"` → **saves nothing** | posts to `ajax/*.php` → real row + CSRF |
| Nav "About" link | was `#about` (anchor) → fixed to `about.php` | `about.php` |
| Header/nav count | desktop nav **and** mobile nav written twice | one shared `navbar.php` |

So: same brand, **two different websites glued together**.

---

## 2. Why did this happen? (the archaeology)

Files in the repo tell the story:

```
college-hero.html      ← early hero/landing draft (HTML only)
home-content.html      ← another draft fragment (HTML only)
index.php              ← a draft promoted to "the homepage" (still 0 PHP)
includes/index.php     ← a proper PHP homepage (uses includes + DB) — but
                          it sits INSIDE includes/, so nobody links to it
index_dark.php         ← a third homepage variant (dark theme, uses includes)
```

Timeline that fits the evidence:

1. A landing-page design (Tailwind) was dropped in as `index.php`.
2. The real LMS-style site was then built with `includes/` + Bootstrap +
   `technocoderz.css`: `courses.php`, `about.php`, `blog.php`, …
3. Someone built a proper homepage in the same system → `includes/index.php`
   (wrong folder, so it never became the live home).
4. A dark-theme experiment → `index_dark.php`.
5. Result: visitors land on the static page, then click into a *different*
   design system.

---

## 3. Why this hurts you (concrete symptoms)

| Symptom you've seen | Root cause |
|---------------------|-----------|
| Editing the home hero does nothing in admin | `index.php` has no PHP/DB |
| Menu looks different on home vs other pages | two hand-written navs vs `navbar.php` |
| Home colours are teal/blue, rest is orange | Tailwind palette vs `technocoderz.css` tokens |
| Home page "Enquire Now" never creates a lead | `preventDefault()` with no `fetch()` |
| Broken logo link → 404 | logo points to `index.html`, which was deleted |
| Extra page weight on home | Tailwind CDN (~300 KB) **and** Bootstrap+theme CSS |
| You fix mobile overflow, it returns | fixes applied to `technocoderz.css` don't exist on the Tailwind page |

---

## 4. Which one should survive?

**Keep the `includes/` architecture** (the one 13 pages + admin already use).

- It is DRY, DB-driven, admin-editable, CSRF-protected.
- `includes/index.php` is already ~90% of the correct homepage.
- Converting the static `index.php` means rewriting it anyway.

Candidate sources, best first:

1. `includes/index.php` — correct stack, already queries courses/services.
2. `index_dark.php` — correct stack, but dark theme (would need the light
   re-skin the other pages already have).
3. Current `index.php` — only for **copy/imagery** (hero text, project cards).

---

## 5. Migration plan (safe order, no backend changes until the end)

> Do this as separate commits/PR steps so you can roll back one step at a time.

**Step 0 — baseline (5 min)**
```powershell
# note current behaviour before touching anything
Invoke-WebRequest http://localhost/Tech/index.php | % StatusCode   # 200
```
Screenshot home at 375px and 1440px.

**Step 1 — pick the skeleton**
Copy `includes/index.php` → `index.php` (back up the old file as
`index.tailwind.bak.php`). Do NOT delete anything yet.

**Step 2 — make it render the current home content**
- Bring across the hero headline, enquire form markup and project cards from
  the old file, but **inside** the include skeleton:
  `functions.php → $vars → header → navbar → CONTENT → footer`.
- Delete the hand-written `<header>`/`<nav>`/`<footer>` blocks — `navbar.php`
  and `footer.php` now own them.

**Step 3 — port the form properly**
Replace `handleFormSubmit()` with the same `fetch('ajax/enquiry.php', …)` +
`csrf_token` pattern `contact.php` already uses. Delete `preventDefault()`-only
handlers. (This is backend-touching: do it in its own step.)

**Step 4 — port the visuals, not the framework**
- Rebuild Tailwind classes as Bootstrap classes + `technocoderz.css` utilities.
- Colour map: `#084C61/#05313F` headings → `#1E293B`, `#FF6B00` stays, cream
  `#FDFBF7` background stays, `#1B72E8` accents → `#FF6B00`.
- Wrap content in `<div class="tc-page-light">` like `courses.php`/`about.php`
  so the light theme applies.

**Step 5 — cleanup (only after Step 4 is verified)**
- Delete or archive: `index.tailwind.bak.php`, `includes/index.php`,
  `index_dark.php`, `college-hero.html`, `home-content.html`, `test.php`.
- Fix the logo link (`index.html` → `index.php`).

**Step 6 — verify**
```powershell
php -l index.php
# 200 + no PHP warnings on all pages
# nav "About" → about.php on home
# no horizontal overflow at 375px and 1440px
# enquiry submits → row appears in admin → enquiries
```

### Rollback
If anything breaks: restore the backup file as `index.php`, nothing else in the
project depends on it (that is the one benefit of a static homepage).

---

## 6. Rule going forward

> **One architecture.** Any new page = the 7-line skeleton from
> [02-page-lifecycle.md](02-page-lifecycle.md).
> No new Tailwind pages. No full pages inside `includes/`.
