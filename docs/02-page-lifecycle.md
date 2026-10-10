# 02 — Page Lifecycle: how a page works, and WHY `includes/` and `config/` exist

## 1. The skeleton of every normal page

Open `about.php` — every real page in this project looks exactly like this:

```php
<?php
require_once __DIR__ . '/includes/functions.php';   // 1. tools + DB + session

$pageTitle       = 'About Us – Techno Coderz';      // 2. page metadata
$pageDescription = '...';
$currentPage     = 'about';                          // 3. tells navbar which link is active
$csrf            = generateCsrfToken();              // 4. form protection

require_once __DIR__ . '/includes/header.php';       // 5. <head> + open <body>
require_once __DIR__ . '/includes/navbar.php';       // 6. menu
?>

   ... ONLY THIS PAGE'S CONTENT HERE (HTML + a few PHP echoes) ...

<?php require_once __DIR__ . '/includes/footer.php'; ?>   // 7. footer + JS
```

**Order is the contract.** Steps 1–4 must run *before* `header.php`, because
`header.php` prints `<?= e($pageTitle) ?>`. If you move the `require` up, you get
"Undefined variable" warnings.

If you ever need a new page, copy those 7 lines and write content in the gap.

---

## 2. Why `config/` exists

`config/database.php` is the **only file that knows secrets and URLs**.

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'technocoderz');
define('SITE_URL', 'http://localhost/Tech');
...
function getDB(): PDO { /* creates ONE connection and reuses it */ }
```

### Why not put this in every page?

| If credentials were in every page… | With `config/` |
|------------------------------------|----------------|
| Change MySQL password → edit 15 files | Edit 1 file |
| One typo in one page → half the site breaks | Single source of truth |
| Real site URL differs from localhost → 15 edits | Change `SITE_URL` once |
| Secrets scattered → easy to commit by accident | One small file to protect |

`getDB()` is a **singleton**: the first call opens the connection, later calls
return the same one. So a page doing 5 queries opens the database only once.

**Chain of dependency (memorize this):**

```
page.php  →  includes/functions.php  →  config/database.php
 (content)     (helpers, session)         (settings, connection)
```

Nothing "below" a file may be required by a file "above" it. `config/` never
includes a page. `assets/` never contains PHP.

---

## 3. Why `includes/` exists (DRY, in practice)

`includes/` holds 4 partials + 1 helper file:

| File | Prints / provides | Used by |
|------|-------------------|---------|
| `functions.php` | nothing — defines `e()`, `sanitize()`, CSRF, `getDB()` helpers, sessions, flash | every PHP file |
| `header.php` | `<!DOCTYPE>` … `<body>` (title, meta, CSS) | every public page |
| `navbar.php` | the `<nav>` menu + the `$navLinks` array | every public page |
| `footer.php` | `</body>` (footer, JS, analytics) | every public page |

### The problem it solves

Without includes, changing the menu means editing **15 files**, and after the
first mistake the site has 2 different menus on different pages.

With includes:

- change phone number in the footer → **1 edit** → all pages update
- add a nav item → edit the `$navLinks` array in `navbar.php` → all pages update
- bump the CSS cache-buster (`?v=…`) → **1 edit** in `header.php`

That is **DRY**: one source, many users.

### What `includes/` must NEVER contain

- ❌ A full page (`includes/index.php` currently does this → problem #P1-3, see [04-problems.md](04-problems.md))
- ❌ Forms that write to the database (that belongs in `ajax/` or the page)
- ❌ Business logic only one page needs (keep it in that page)

---

## 4. The four page "types" and their lifecycle

### A. Public page (`about.php`, `courses.php`, …)

```
functions.php → set variables → header → navbar → content(+DB) → footer
```
Renders HTML. Safe to restyle (HTML/CSS only).

### B. AJAX endpoint (`ajax/contact.php`, `ajax/enquiry.php`)

```
Content-Type: application/json
require functions.php
reject if method != POST
verifyCsrfToken()
sanitize() → prepared INSERT → {"success":true}
```
No HTML, no session flash. Called by JS so the page doesn't reload.

### C. Download / file endpoint (`download-brochure.php`)

```
require functions.php
check $_SESSION flag → else redirect to locked page
clear output buffers → send PDF headers → readfile()
```
**Must** run before any HTML is printed (headers already sent = fatal error).

### D. Admin page (`admin/courses/index.php`)

```php
require_once __DIR__ . '/../../includes/functions.php';
requireAdminLogin();                 // ← redirects to login if not logged in
// optional: handle ?delete= with CSRF check
require admin_header.php → content → admin_footer.php
```

Admin pages reuse the **same** `functions.php` and the **same** database —
only the shell (admin header/footer) and the auth gate differ.

---

## 5. Security pieces you should recognize in the code

| Mechanism | Where | What it stops |
|-----------|-------|---------------|
| `e()` (htmlspecialchars) | any `<?= e($var) ?>` | XSS — text you print can't run as HTML/JS |
| `sanitize()` | form handlers | stray tags/whitespace in stored input |
| `generateCsrfToken()` / `verifyCsrfToken()` | forms + ajax + admin deletes | forged submissions from another site |
| PDO prepared statements | INSERT/SELECT helpers | SQL injection |
| `requireAdminLogin()` | every `admin/*.php` | anonymous admin access |
| `session` flag `brochure_access` | brochure flow | PDF downloaded without giving contact details |

While doing **design-only** work you must not remove any of these calls, even
if they look like "extra PHP" in your HTML.

---

## 6. Quick self-test

1. Where do you change the DB password? → `config/database.php` (1 place)
2. Where do you add a menu item? → `$navLinks` in `includes/navbar.php`
3. Where does a contact form row get inserted? → `ajax/contact.php`
4. Which file must run first in every page? → `includes/functions.php`
5. Can `assets/js/technocoderz.js` talk to the DB? → No. Only PHP endpoints can.
