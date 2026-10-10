# Techno Coderz — Project Documentation

> Start here. This folder explains **what** this project is, **how** it works,
> **why** it is built this way, **what is wrong** with it, and **how you should
> work** on it safely.

Written for a fresher developer (< 2 months experience). Every doc uses plain
language, real file names from this repo, and diagrams.

---

## Reading order

| # | File | Read it when you want to know |
|---|------|-------------------------------|
| 01 | [01-architecture.md](01-architecture.md) | Folder structure — what every folder/file is for |
| 02 | [02-page-lifecycle.md](02-page-lifecycle.md) | How a page actually runs, **why `includes/` exists**, **why `config/` exists** |
| 03 | [03-index-vs-about.md](03-index-vs-about.md) | **Why `index.php` and `about.php` look/behave totally different** and how to unify them |
| 04 | [04-problems.md](04-problems.md) | Every problem in the code, sorted by severity with fixes |
| 05 | [05-working-rules.md](05-working-rules.md) | Daily rules: what you may edit, what you must never touch, how to verify |

**Minimum path if you have 10 minutes:** 01 → 03 → 04.

> Note: this folder sits inside the web root (`localhost/Tech/docs/`), so the
> markdown is publicly readable on a local machine. Harmless for dev; exclude
> it from a production deploy.

---

## Project in 30 seconds

```
Techno Coderz = Public website (PHP) + Admin panel (PHP) + MySQL database
```

- **Public site** — what a visitor sees: home, courses, blog, brochure, contact…
- **Admin panel** (`/admin`) — login, add/edit courses, blogs, see enquiries.
- **Database** — MySQL `technocoderz`, tables like `courses`, `blogs`, `enquiries`.
- **Stack** — plain PHP (no framework), Bootstrap 5 + custom CSS, a bit of
  vanilla JavaScript, MySQL via PDO.

### Tech stack

| Layer | Technology | Where |
|-------|-----------|-------|
| Language | PHP 8.x (procedural, no framework) | `*.php` |
| Database | MySQL, accessed through **PDO** | `config/database.php` |
| Styling | Bootstrap 5.3.3 + `technocoderz.css` (+ Tailwind **only** on `index.php`) | `assets/css/`, `includes/header.php` |
| JS | Vanilla JS (no jQuery) | `assets/js/technocoderz.js` |
| Server | Apache (Laragon), site at `http://localhost/Tech` | `config/database.php` → `SITE_URL` |

### Glossary (fresher edition)

| Term | Meaning |
|------|---------|
| **Include / require** | "Paste another PHP file's code here." `require_once` = must exist or fatal error; also guarantees it is loaded **only once** even if two files ask for it. |
| **DRY** | Don't Repeat Yourself. The header is written once in `includes/header.php`, reused by every page. |
| **Partial** | A fragment of a page (header/navbar/footer) — not a full page by itself. |
| **PDO** | PHP's safe way to talk to MySQL. With prepared statements it prevents SQL injection. |
| **CSRF token** | A secret from your session, sent with every form, so other sites cannot post fake data as you. |
| **AJAX endpoint** | A PHP file that returns JSON (not HTML), called by `fetch()` without reloading the page. |
| **Singleton** | Create once, reuse everywhere — here `getDB()` makes one DB connection per request. |
| **Specificity** | Which CSS rule wins when two rules target the same element (`.a .b` beats `.b`). |
| **XSS** | Injecting `<script>` via text fields; prevented here by `e()` (htmlspecialchars). |
