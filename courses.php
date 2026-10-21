<?php
// ============================================================
// Techno Coderz — All Courses
// Layout & structure replicated from techcaddmohali.com/courses
// (dark hero -> pill-filtered catalog grid -> FAQ -> related ->
// closing CTA), re-themed to the Techno Coderz orange palette and
// filled with our own course data.
// ============================================================
require_once __DIR__ . '/includes/functions.php';

$csrf = generateCsrfToken();

$pdo     = getDB();
$courses = $pdo->query("SELECT * FROM courses WHERE status = 1 ORDER BY sort_order ASC, id ASC")->fetchAll();
$totalCourses = count($courses);

$pageTitle       = 'All Courses – Techno Coderz | IT Training Institute, Mohali';
$pageDescription = 'Explore every Techno Coderz programme — AI & Data Science, full stack, cyber security, cloud &amp; DevOps, digital marketing, programming and CAD. Live projects, internship option and placement support.';
$currentPage     = 'courses';

// ---- Category pills (preserve catalogue order) ----
$cats = [];
foreach ($courses as $c) {
    $cat = trim((string) ($c['category'] ?? ''));
    if ($cat !== '' && !isset($cats[$cat])) $cats[$cat] = 0;
    if ($cat !== '') $cats[$cat]++;
}

// ---- Decorative status badge derived from the real level ----
function courseBadge(?string $level): ?array {
    switch (trim((string) $level)) {
        case 'Advanced':   return ['Trending', 'bg-accent-yellow text-hero-950'];
        case 'All Levels': return ['Hot', 'bg-accent-yellow text-hero-950'];
        case 'Beginner':   return ['New', 'bg-emerald-400 text-hero-950'];
        default:           return null; // Intermediate / unknown -> no badge
    }
}

// ---- FAQ ----
$faqs = [
    ['q' => 'What courses does Techno Coderz offer in Mohali?',
     'a' => 'We run job-oriented tracks across AI &amp; Data Science, Full Stack (MERN, MEAN, PHP), Core Programming (C, C++, Java, Python), Cyber Security, Cloud &amp; DevOps, Digital Marketing and CAD/CAM. Every track is built around live projects, small batches and placement support — use the filter above to narrow the catalogue.'],
    ['q' => 'Do I need prior coding experience to join?',
     'a' => 'Not at all. Most of our tracks start from the fundamentals and assume zero prior programming experience. If you already have a background, our counsellors place you in an intermediate or advanced batch so you are not repeating what you already know.'],
    ['q' => 'What are the batch timings and do you offer online classes?',
     'a' => 'We run morning, afternoon, evening and weekend batches to fit students and working professionals. You can attend in person at our Mohali campus, join the same session live online, or switch between both — every class is recorded for revision.'],
    ['q' => 'How large are the batches?',
     'a' => 'Batches are deliberately small (around 12–18 seats) so a trainer can notice when someone is stuck rather than moving on. That is what makes one-to-one doubt time and weekly reviews possible.'],
    ['q' => 'What is the fee structure and are EMI options available?',
     'a' => 'Fees are competitive and depend on the track and duration. We offer flexible installments across the course and partner with education-finance providers for no-cost EMI on eligible programmes. Call the admissions desk for the current fee schedule.'],
    ['q' => 'Will I work on real projects during the course?',
     'a' => 'Yes — every programme is project-first. From early in the course you build deployable applications with real requirements, reviews and deadlines. Those projects become your portfolio and the thing interviewers actually ask about.'],
    ['q' => 'Do you provide a certificate and placement assistance?',
     'a' => 'Every student who completes a course and its project requirements receives a verifiable Techno Coderz certificate. Our placement cell handles resume building, LinkedIn optimisation, mock interviews and referrals through our hiring-partner network until you are placed.'],
    ['q' => 'Can 12th pass students and non-engineering graduates get IT jobs here?',
     'a' => 'Yes. We run dedicated After-12th and professional certificate tracks in Full Stack, Data, Cloud and Cyber Security designed to move you into a corporate role without needing a four-year engineering degree.'],
];
$faqFirst = true;

// ---- Where to go next ----
$nextCards = [
    ['href' => SITE_URL . '/faq.php', 'icon' => '<circle cx="12" cy="12" r="9"/><path d="M9.5 9a2.5 2.5 0 1 1 3.3 2.4c-.8.3-1.3 1-1.3 1.9v.2M12 17h.01"/>',
     'eyebrow' => 'Questions, answered', 'title' => 'Everything about admissions, fees &amp; batches', 'cta' => 'Read the FAQs'],
    ['href' => SITE_URL . '/contact.php', 'icon' => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"/>',
     'eyebrow' => 'Talk it through', 'title' => 'Not sure which track fits your background?', 'cta' => 'Book a free demo'],
    ['href' => SITE_URL . '/about.php', 'icon' => '<path d="m12 3 2.6 5.6 6.1.8-4.5 4.2 1.2 6-5.4-3-5.4 3 1.2-6L3.3 9.4l6.1-.8L12 3Z"/>',
     'eyebrow' => 'Why us', 'title' => 'The standard we hold every cohort to', 'cta' => 'See why we are #1'],
];

// ---- Extra head : Tailwind (orange theme) + shared component CSS ----
$extraHead = <<<'HTML'
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      corePlugins: { preflight: true },
      theme: { extend: {
        colors: {
          subtle: '#f8fafc',
          line: '#e2e8f0',
          panel: '#0b1220',
          logo: '#c2410c',
          brand: { 50:'#fff4ec', 100:'#ffe6d5', 200:'#ffccab', 300:'#ffb077', 400:'#ff9143', 500:'#ff7a1a', 600:'#ff6b00', 700:'#e55f00', 900:'#7a3200' },
          hero:  { 950:'#7a3200', 900:'#c2410c', 800:'#e55f00', 600:'#c2410c', glow:'#ff6b00' },
          accent:{ 400:'#ffa94d', 500:'#ff7a00', glow:'#ff8a3d', yellow:'#ffc23d' },
          up:    { ink:'#0f172a', muted:'#475569', line:'#e2e8f0', accent:'#ff6b00', bright:'#ff8533', soft:'#ffd9bf', gold:'#ffb020' }
        },
        fontFamily: { display: ['"Plus Jakarta Sans"','ui-sans-serif','system-ui','sans-serif'] }
      }}
    };
  </script>
  <link rel="stylesheet" href="__SITE__/assets/css/tcm-home.css?v=1">
HTML;
$extraHead = str_replace('__SITE__', SITE_URL, $extraHead);
$extraScripts = '<script src="' . SITE_URL . '/assets/js/tcm-home.js?v=2"></script>';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<script>window.TC_BASE_URL = '<?= SITE_URL ?>';</script>

<main class="overflow-x-hidden bg-subtle">

<!-- ============ HERO ============ -->
<section class="relative overflow-hidden bg-gradient-to-br from-brand-900 via-hero-600 to-brand-700 pb-20 pt-[7.5rem] text-white lg:pb-24 lg:pt-[12rem]">
  <div class="absolute inset-0 bg-[radial-gradient(ellipse_80%_70%_at_20%_0%,rgba(255,194,61,0.28)_0%,transparent_60%),radial-gradient(ellipse_60%_60%_at_90%_40%,rgba(255,255,255,0.16)_0%,transparent_55%)]"></div>
  <div class="absolute inset-0 grid-lines opacity-60"></div>
  <div class="glow-blob right-[5%] top-[10%] h-[380px] w-[380px] bg-accent-glow/20"></div>
  <div class="relative mx-auto max-w-6xl px-5 sm:px-8">
    <nav aria-label="Breadcrumb" class="mb-6 flex flex-wrap items-center gap-2 text-xs text-up-soft/70">
      <a href="<?= SITE_URL ?>/index.php" class="transition-colors hover:text-white">Home</a>
      <span class="text-up-soft/40">/</span>
      <span class="text-white">Courses</span>
    </nav>
    <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-3.5 py-1.5 text-[0.7rem] font-semibold uppercase tracking-[0.16em] text-up-soft">
      <span class="h-1.5 w-1.5 rounded-full bg-accent-yellow"></span><?= (int) $totalCourses ?> job-oriented tracks
    </p>
    <h1 data-anim="words" class="max-w-4xl font-display text-4xl font-extrabold leading-[1.08] tracking-tight sm:text-5xl lg:text-[3.6rem]">Courses built around what Mohali employers hire for</h1>
    <p class="mt-6 max-w-2xl text-base leading-relaxed text-up-soft/85 sm:text-lg">Filter by field or search for a technology. Every track includes live projects, an internship option, interview preparation and placement support.</p>
    <ul class="mt-8 flex flex-wrap gap-x-6 gap-y-3 text-sm text-up-soft/85">
      <?php foreach (['Weekday, weekend &amp; online sessions', 'EMI options', 'Certificate + internship letter', 'Free demo class'] as $f): ?>
      <li class="inline-flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-accent-glow"></span><?= $f ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

<!-- ============ CATALOG ============ -->
<section class="bg-subtle py-16 lg:py-24">
  <div class="mx-auto max-w-6xl px-5 sm:px-8">

    <!-- Filter toolbar -->
    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
      <div class="flex flex-wrap gap-2" role="tablist" aria-label="Filter courses by category">
        <button type="button" data-filter="all" class="rounded-full border border-transparent bg-hero-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-hero-600/25 transition-all">All courses</button>
        <?php foreach ($cats as $name => $n): ?>
        <button type="button" data-filter="<?= e(slugify($name)) ?>" class="rounded-full border border-line bg-white px-5 py-2.5 text-sm font-semibold text-up-ink/75 transition-all hover:-translate-y-0.5 hover:border-hero-600 hover:text-hero-600"><?= e($name) ?></button>
        <?php endforeach; ?>
      </div>
      <div class="relative w-full lg:w-72">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-up-muted"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
        <input type="text" id="courseSearch" placeholder="Search a course or tool." aria-label="Search courses"
               class="w-full rounded-full border border-line bg-white py-3 pl-11 pr-4 text-sm text-up-ink outline-none transition-all placeholder:text-up-muted/70 focus:border-hero-600 focus:ring-4 focus:ring-hero-600/10">
      </div>
    </div>

    <p class="mt-6 text-sm text-up-muted">Showing <span id="courseCount" class="font-semibold text-up-ink"><?= (int) $totalCourses ?></span> courses</p>

    <?php if ($courses): ?>
    <!-- Grid -->
    <div id="courseGrid" class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
      <?php foreach ($courses as $course):
          $category = trim((string) ($course['category'] ?? ''));
          $catSlug  = slugify($category);
          $level    = trim((string) ($course['level'] ?? ''));
          $duration = trim((string) ($course['duration'] ?? ''));
          $desc     = trim((string) ($course['short_description'] ?? ''));
          $url      = coursePageUrl((string) $course['slug']);
          $techs    = array_values(array_filter(array_map('trim', explode(',', (string) ($course['technologies'] ?? '')))));
          $hl       = array_values(array_filter(array_map('trim', explode(',', (string) ($course['highlights'] ?? '')))));
          $hl       = array_slice($hl, 0, 3);
          $badge    = courseBadge($course['level'] ?? null);
          $meta     = trim($duration . ($duration !== '' && $level !== '' ? ' • ' : '') . $level);
          $haystack = strtolower($course['title'] . ' ' . $desc . ' ' . $category . ' ' . $level . ' ' . implode(' ', $techs) . ' ' . implode(' ', $hl));
      ?>
      <a class="card-hover group relative flex flex-col overflow-hidden rounded-3xl border border-line bg-white"
         href="<?= e($url) ?>" data-course data-cat="<?= e($catSlug) ?>" data-search="<?= e($haystack) ?>">
        <div class="relative overflow-hidden bg-hero-950 px-7 py-8">
          <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_left,#c2410c_0%,transparent_65%)] opacity-70 transition-opacity duration-500 group-hover:opacity-100"></div>
          <div class="absolute inset-0 grid-lines opacity-50"></div>
          <div class="absolute -bottom-10 -right-8 h-32 w-32 rounded-full bg-accent-glow/20 blur-2xl transition-transform duration-700 group-hover:scale-150"></div>
          <div class="relative flex items-start justify-between gap-3">
            <?php if ($category !== ''): ?>
            <span class="rounded-full border border-white/15 bg-white/10 px-3 py-1 text-[0.65rem] font-semibold uppercase tracking-wider text-up-soft backdrop-blur-sm"><?= e($category) ?></span>
            <?php else: ?><span></span><?php endif; ?>
            <?php if ($badge): ?>
            <span class="rounded-full px-2.5 py-1 text-[0.6rem] font-bold uppercase tracking-wider <?= $badge[1] ?>"><?= e($badge[0]) ?></span>
            <?php endif; ?>
          </div>
          <h3 class="relative mt-6 font-display text-xl font-bold leading-snug text-white"><?= e($course['title']) ?></h3>
          <?php if ($meta !== ''): ?><p class="relative mt-2 text-xs text-up-soft/70"><?= e($meta) ?></p><?php endif; ?>
        </div>
        <div class="flex flex-1 flex-col p-7">
          <?php if ($desc !== ''): ?><p class="text-sm leading-relaxed text-up-muted"><?= e($desc) ?></p><?php endif; ?>
          <?php if ($hl): ?>
          <ul class="mt-5 space-y-2">
            <?php foreach ($hl as $h): ?>
            <li class="flex items-start gap-2.5 text-sm text-up-ink/80">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="mt-0.5 shrink-0 text-up-accent"><path d="m4 12 5 5L20 6"/></svg>
              <?= e($h) ?>
            </li>
            <?php endforeach; ?>
          </ul>
          <?php endif; ?>
          <div class="mt-auto flex items-end justify-between gap-4 pt-7">
            <?php if ($techs): ?>
            <span class="flex flex-wrap gap-1.5">
              <?php foreach (array_slice($techs, 0, 4) as $t): ?>
              <span class="rounded-md bg-subtle px-2 py-1 text-[0.65rem] font-medium text-up-muted"><?= e($t) ?></span>
              <?php endforeach; ?>
            </span>
            <?php else: ?><span></span><?php endif; ?>
            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-brand-50 text-up-accent transition-all duration-300 group-hover:bg-up-accent group-hover:text-white">
              <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M9 7h8v8"/></svg>
            </span>
          </div>
        </div>
      </a>
      <?php endforeach; ?>
    </div>

    <!-- Empty state -->
    <div id="courseEmpty" class="mt-10 hidden flex-col items-center justify-center rounded-3xl border border-dashed border-line bg-white py-16 text-center">
      <svg viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="text-up-muted/60"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
      <p class="mt-4 font-display text-lg font-bold text-up-ink">No courses match your search.</p>
      <span class="mt-1 text-sm text-up-muted">Try a different keyword or pick another category.</span>
    </div>
    <?php else: ?>
    <div class="mt-10 rounded-3xl border border-dashed border-line bg-white py-16 text-center">
      <p class="font-display text-lg font-bold text-up-ink">Courses are being prepared.</p>
      <span class="mt-1 text-sm text-up-muted">Please check back soon!</span>
    </div>
    <?php endif; ?>

  </div>
</section>

<!-- ============ FAQ ============ -->
<section id="faqs" class="relative scroll-mt-32 overflow-hidden bg-gradient-to-br from-brand-900 via-hero-600 to-brand-900 py-16 text-white lg:py-24">
  <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_55%_50%_at_25%_20%,rgba(255,194,61,0.30),transparent_68%)]"></div>
  <div class="absolute inset-0 grid-lines opacity-40"></div>
  <div class="relative mx-auto max-w-6xl px-5 sm:px-8">
    <div class="mx-auto max-w-2xl text-center">
      <span class="text-[0.72rem] font-bold uppercase tracking-[0.2em] text-up-soft/80">FAQs</span>
      <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight sm:text-4xl">Questions we get every week</h2>
      <div class="mx-auto mt-5 h-[3px] w-24 rounded-full bg-gradient-to-r from-accent-glow to-transparent"></div>
    </div>

    <div class="mx-auto mt-12 max-w-3xl space-y-3" data-faq-group>
      <?php foreach ($faqs as $i => $f): ?>
      <div class="faq-item overflow-hidden rounded-2xl border border-white/10 bg-white/[0.04] transition-all duration-300">
        <button type="button" class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left" aria-expanded="false">
          <span class="font-display text-[1.02rem] font-bold leading-snug text-white"><?= $f['q'] ?></span>
          <span class="faq-icon grid h-8 w-8 shrink-0 place-items-center rounded-full bg-white/10 text-up-soft/70 transition-all duration-300">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
          </span>
        </button>
        <div class="faq-body overflow-hidden px-6 transition-all duration-300" data-faq-body style="max-height:0;opacity:0">
          <p class="pb-6 text-sm leading-relaxed text-up-soft/75"><?= $f['a'] ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ WHERE TO GO NEXT ============ -->
<section class="bg-subtle py-16 lg:py-24">
  <div class="mx-auto max-w-6xl px-5 sm:px-8">
    <div class="max-w-2xl">
      <span class="text-[0.72rem] font-bold uppercase tracking-[0.2em] text-hero-600">Keep exploring</span>
      <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-up-ink sm:text-4xl">Where to go next</h2>
    </div>
    <div class="mt-12 grid gap-6 md:grid-cols-3">
      <?php foreach ($nextCards as $c): ?>
      <a href="<?= e($c['href']) ?>" class="group flex flex-col rounded-3xl border border-line bg-white p-7 transition-all duration-300 hover:-translate-y-1 hover:border-hero-600/30 hover:shadow-[0_35px_80px_-55px_rgba(122,50,0,0.6)]">
        <span class="grid h-12 w-12 place-items-center rounded-2xl bg-gradient-to-br from-hero-600 to-hero-glow text-white shadow-lg shadow-hero-600/25">
          <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?= $c['icon'] ?></svg>
        </span>
        <span class="mt-5 text-[0.68rem] font-bold uppercase tracking-[0.16em] text-up-muted"><?= $c['eyebrow'] ?></span>
        <h3 class="mt-2 font-display text-lg font-extrabold leading-snug text-up-ink"><?= $c['title'] ?></h3>
        <span class="mt-auto inline-flex items-center gap-2 pt-6 text-sm font-bold text-hero-600"><?= $c['cta'] ?> <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform group-hover:translate-x-1"><path d="M4 12h16M14 6l6 6-6 6"/></svg></span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ FINAL CTA ============ -->
<section class="py-16 lg:py-24">
  <div class="mx-auto max-w-3xl px-5 text-center sm:px-8">
    <span class="text-[0.72rem] font-bold uppercase tracking-[0.2em] text-up-bright">Ready to get started?</span>
    <h2 class="mt-3 font-display text-[2.1rem] font-extrabold leading-tight tracking-tight text-up-ink sm:text-4xl lg:text-[3rem]">Start building your career today.</h2>
    <p class="mx-auto mt-4 max-w-xl text-[0.97rem] leading-relaxed text-up-muted">Talk to a counsellor today. One call is usually enough to know which track fits your degree, your schedule and the job you want.</p>

    <form id="tcCoursesCta" class="mx-auto mt-8 flex max-w-xl flex-col gap-3 sm:flex-row" novalidate>
      <input id="ctaPhone" type="tel" inputmode="numeric" placeholder="Your mobile number"
             class="w-full rounded-full border border-line bg-white px-6 py-4 text-sm text-up-ink outline-none transition-all placeholder:text-up-muted/70 focus:border-hero-600 focus:ring-4 focus:ring-hero-600/10">
      <button type="submit" class="accent-fill shrink-0 rounded-full px-8 py-4 text-[0.9rem] font-bold transition-all hover:-translate-y-0.5">Book Demo</button>
    </form>

    <div class="mt-6">
      <a href="tel:<?= e(preg_replace('/\D/', '', $settingsPhone ?? '+91 98765 43210')) ?>" class="inline-flex items-center gap-2 rounded-full bg-hero-600 px-7 py-3.5 text-sm font-bold text-white shadow-[0_18px_45px_-16px_rgba(194,65,12,0.85)] transition-all hover:-translate-y-0.5">
        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"/></svg>
        Call now
      </a>
    </div>

    <ul class="mt-8 flex flex-wrap items-center justify-center gap-x-6 gap-y-3 text-sm text-up-muted">
      <?php foreach (['Free career counselling', 'No registration fee', 'Placement support included'] as $t): ?>
      <li class="inline-flex items-center gap-2">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="text-up-bright"><circle cx="12" cy="12" r="9"/><path d="m8 12 2.5 2.5L16 9"/></svg>
        <?= $t ?>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

</main>

<script>
(function () {
  'use strict';

  /* ---- Category pills + live search ---- */
  var grid = document.getElementById('courseGrid');
  if (grid) {
    var cards  = Array.prototype.slice.call(grid.querySelectorAll('[data-course]'));
    var pills  = Array.prototype.slice.call(document.querySelectorAll('[data-filter]'));
    var search = document.getElementById('courseSearch');
    var count  = document.getElementById('courseCount');
    var empty  = document.getElementById('courseEmpty');
    var active = 'all';

    var ON  = ['border-transparent','bg-hero-600','text-white','shadow-lg','shadow-hero-600/25'];
    var OFF = ['border-line','bg-white','text-up-ink/75'];

    function setPill(btn, on) {
      ON.forEach(function (c)  { btn.classList.toggle(c, on); });
      OFF.forEach(function (c) { btn.classList.toggle(c, !on); });
      btn.setAttribute('aria-selected', on ? 'true' : 'false');
    }

    function apply() {
      var q = (search ? search.value : '').trim().toLowerCase();
      var n = 0;
      cards.forEach(function (c) {
        var okCat = active === 'all' || c.getAttribute('data-cat') === active;
        var okQ   = !q || (c.getAttribute('data-search') || '').indexOf(q) > -1;
        var show  = okCat && okQ;
        c.style.display = show ? '' : 'none';
        if (show) n++;
      });
      if (count) count.textContent = n;
      if (empty) { empty.style.display = n ? 'none' : 'flex'; }
    }

    pills.forEach(function (p) {
      p.addEventListener('click', function () {
        active = p.getAttribute('data-filter');
        pills.forEach(function (x) { setPill(x, x === p); });
        apply();
      });
    });
    if (search) search.addEventListener('input', apply);
    apply();
  }

  /* ---- FAQ accordion (single open) ---- */
  Array.prototype.slice.call(document.querySelectorAll('[data-faq-group]')).forEach(function (group) {
    var items = Array.prototype.slice.call(group.querySelectorAll('.faq-item'));
    items.forEach(function (item) {
      var btn = item.querySelector('button');
      var body = item.querySelector('[data-faq-body]');
      var icon = item.querySelector('.faq-icon');
      if (!btn || !body) return;
      btn.addEventListener('click', function () {
        var wasOpen = item.classList.contains('open');
        items.forEach(function (i) {
          i.classList.remove('open');
          var b = i.querySelector('[data-faq-body]');
          if (b) { b.style.maxHeight = '0px'; b.style.opacity = '0'; }
          var ic = i.querySelector('.faq-icon');
          if (ic) { ic.classList.remove('rotate-45','bg-accent-glow','text-hero-950'); ic.classList.add('bg-white/10','text-up-soft/70'); }
          var ib = i.querySelector('button'); if (ib) ib.setAttribute('aria-expanded', 'false');
        });
        if (!wasOpen) {
          item.classList.add('open');
          body.style.maxHeight = body.scrollHeight + 'px';
          body.style.opacity = '1';
          if (icon) { icon.classList.add('rotate-45','bg-accent-glow','text-hero-950'); icon.classList.remove('bg-white/10','text-up-soft/70'); }
          btn.setAttribute('aria-expanded', 'true');
        }
      });
    });
  });

  /* ---- Closing CTA form ---- */
  var cta = document.getElementById('tcCoursesCta');
  if (cta) {
    cta.addEventListener('submit', function (e) {
      e.preventDefault();
      if (typeof window.openEnquiry === 'function') { window.openEnquiry('Free Demo'); }
    });
  }
})();
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
