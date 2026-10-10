# 05 — Working rules: how things should be done here

This is the contract for day-to-day work on this repo (especially design/UI
tasks). Follow it and you will not break the backend.

---

## 1. Golden rules

1. **Understand before editing.** Read the file (and its includes) first. Never
   edit a file you have not opened.
2. **Design tasks = HTML + CSS only.** Do not touch PHP logic, SQL, sessions,
   `ajax/*`, `download-brochure.php`, or JS form handlers unless the task
   explicitly says so.
3. **Never delete PHP calls** from markup (`e()`, `<?= SITE_URL ?>`,
   `csrf_token`, `foreach`, form `name`/`required` attributes). They are the
   security/data layer wearing an HTML costume.
4. **Keep original text content.** Restyle freely; do not rewrite headlines,
   paragraphs, or labels unless asked.
5. **One change at a time → verify → next change.** Never batch 10 edits and
   then test.
6. **Prove it, don't assume it.** Every task ends with the
   [verification checklist](#4-verification-checklist-run-this-every-time).

---

## 2. Edit matrix

| File / folder | UI task | Backend task | Notes |
|---------------|:-------:|:------------:|-------|
| Page markup in root `*.php` (HTML sections only) | ✅ | ⚠️ | Keep all PHP/SQL intact |
| `assets/css/technocoderz.css` | ✅ | — | Read [§3](#3-css-conventions--gotchas) first |
| Inline `style="…"` / Tailwind classes in a page | ✅ | — | Prefer moving big blocks into the CSS file |
| `assets/js/technocoderz.js` | ⚠️ | ⚠️ | `courseFilter()`, `submitContact()`, `openEnquiry()` are shared — touching one page can break another |
| `includes/header.php` `navbar.php` `footer.php` | ✅ | — | Markup tweaks OK; do not change `$navLinks` keys |
| `includes/functions.php` | ❌ | ⚠️ | Helpers are used by 15 pages + admin |
| `config/database.php` | ❌ | ⚠️ | Settings/secrets only |
| `ajax/*.php`, `download-brochure.php` | ❌ | ⚠️ | Gate + validation logic |
| `admin/**` | ❌ | ⚠️ | Has its own auth/CSRF flow |
| `database/*.sql` | ❌ | ⚠️ | Schema changes = migration plan |
| `docs/**` | ✅ | — | Keep them true when the code changes |

Legend: ✅ allowed · ⚠️ allowed only if the task says so · ❌ do not touch

---

## 3. CSS conventions & gotchas

**Design tokens** (defined near the top of `technocoderz.css`, re-declared for
light pages around line 3000):

```
--bg-light:      #FDFBF7   page background (off-white)
--primary-orange:#FF6B00   brand action colour (hover #E55F00, soft rgba(255,107,0,.12))
--text-dark:     #1E293B   headings
--text-body:     #1E293B   body copy
--text-muted:    #64748B   secondary copy
```

**Rules:**

- New colour? Add a token, never a bare hex in a component rule.
- A page that must look light wraps its content in
  `<div class="tc-page-light">…</div>`. That wrapper re-points all dark
  variables to light values (`--tc-heading`, `--tc-bg-alt`, …). Pages without
  the wrapper render the dark theme.
- Page CTA bands: `.tc-cta-section` = slate gradient **inside** a light wrapper,
  white card variant = `.tc-cta-light` (courses.php).
- Beware **grouped rules** — a selector list like
  `.tc-course-card, .tc-service-card, .tc-feature-card { color:#e4e6f1 }`
  (dark) will win over a later single-class light rule of equal specificity.
  When a light card shows wrong text colour, grep the selector name and check
  every group it appears in.
- Scope overrides: `.tc-page-light .xyz { … }` (specificity 0,2,0) beats
  `.xyz` (0,1,0) but loses to `.a .b .xyz` (0,3,0).
- **Keep brace balance.** After editing the big CSS file, run:
  ```powershell
  (Select-String -Path 'assets\css\technocoderz.css' -Pattern '\{' -AllMatches).Matches.Count
  (Select-String -Path 'assets\css\technocoderz.css' -Pattern '\}' -AllMatches).Matches.Count
  # both numbers must be equal
  ```
- Bump the cache-buster in `includes/header.php` after CSS edits
  (`technocoderz.css?v=YYYYMMDD`) or users see the old file.

---

## 4. Verification checklist (run this every time)

> Commands are PowerShell, run from `C:\laragon\www\Tech`.

**1. Syntax**
```powershell
php -l about.php          # repeat for every file you edited
```

**2. No PHP warnings in the output**
```powershell
foreach ($u in @('index.php','courses.php','about.php','blog.php','brochure.php','contact.php')) {
  $r = Invoke-WebRequest "http://localhost/Tech/$u" -UseBasicParsing
  $err = ([regex]::Matches($r.Content,'Warning:|Fatal error:|Deprecated:|Parse error:')).Count
  "{0,-14} {1} errors={2}" -f $u, $r.StatusCode, $err
}
# expect: every line = 200, errors=0
```

**3. Nothing overflows horizontally (mobile + desktop)**
Use a headless-Chrome probe (iframe the page at width 375 and 1400, compare
`document.documentElement.scrollWidth` vs `window.innerWidth`). Accept:
`H-OVERFLOW=false` and **0 overflowing elements**.

**4. Colours match the spec**
In the same probe, read `getComputedStyle(el).backgroundColor` for the key
selectors (hero, cards, buttons) and check against the tokens above, e.g.
`rgb(255, 107, 0)` = `#FF6B00`.

**5. Backend flows still work** (only if you were near a form)
```powershell
# brochure gate: submit form with valid csrf → expect 302 ?status=downloaded
# download → expect 200 + Content-Type: application/pdf + %PDF header
# fresh session → download → expect 302 ?status=locked
# contact ajax with bad token → expect {"success":false,"message":"Security token expired..."}
```
Use a **separate cookie jar per scenario**, otherwise sessions leak between
tests and results lie to you.

**6. Data unchanged**
```powershell
# blogs/courses/enquiries row counts before and after your work must match
# (a UI task must never create or delete rows)
```

**7. Git sanity before you report done**
```powershell
git status --short
git diff --stat
```
Confirm only the files you meant to change are listed.

---

## 5. Recipe: add a new page

```php
<?php
require_once __DIR__ . '/includes/functions.php';

$pageTitle       = 'Page Name – Techno Coderz';
$pageDescription = 'One sentence for Google.';
$currentPage     = 'pagekey';           // must match a 'key' in navbar.php
$csrf            = generateCsrfToken(); // only if the page has a form

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<div class="tc-page-light">            <!-- light theme wrapper -->
  <section class="tc-section"> … </section>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
```
Then: add the nav entry in `includes/navbar.php` (`$navLinks`), and run the
verification checklist.

---

## 6. Git habits

- Never commit unless explicitly asked.
- Before committing: `git status` → `git diff` → `git log --oneline -10`.
- Stage only the files for the task (`git add <file>`), never `git add .`
  (this working tree already contains unrelated changes).
- Commit message = what + why, e.g. `fix(index): point nav About link to about.php`.
- No force-push, no history rewrite, no committing secrets or uploads.

---

## 7. Daily loop (fresher-friendly)

```
READ     → open the file + its includes (02-page-lifecycle.md explains the flow)
PLAN     → list the exact lines/classes you will change; nothing else
EDIT     → HTML/CSS only; keep PHP calls and text intact
VERIFY   → §4 checklist (syntax, 200/0 warnings, overflow, colours, flows)
CLEANUP  → delete probe/test files you created; temp files outside the repo
REPORT   → what changed, which files, what you proved, what you did NOT touch
```

---

## 8. When you are unsure

Stop and ask before editing:
- anything in `config/`, `ajax/`, `download-brochure.php`, `includes/functions.php`
- SQL/schema, sessions, CSRF, upload handling
- deleting a file "that looks unused" (`includes/index.php` and
  `index_dark.php` are *load-bearing confusion* — see [03](03-index-vs-about.md))
