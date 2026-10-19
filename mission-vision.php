<?php
// ============================================================
// Techno Coderz — Mission & Vision
// Layout & visual structure replicated from
// techcaddmohali.com/about/mission-vision (dark hero, vision &
// mission statements, four commitments, where-to-go-next, CTA).
// Re-themed to the Techno Coderz orange palette and filled with
// Techno Coderz data.
// ============================================================
require_once __DIR__ . '/includes/functions.php';

$pageTitle       = 'Mission & Vision – Techno Coderz | Where We Are Going';
$pageDescription = 'The mission and vision behind Techno Coderz — what we are aiming at, and the four commitments that decide what we teach and how we run every session.';
$currentPage     = 'about';
$csrf = generateCsrfToken();

$pdo      = getDB();
$settings = [];
try {
    foreach ($pdo->query("SELECT setting_key, setting_value FROM site_settings") as $row) {
        if (trim($row['setting_value'] ?? '') !== '') $settings[$row['setting_key']] = $row['setting_value'];
    }
} catch (Throwable $e) {
    error_log('Mission data: ' . $e->getMessage());
}

$siteName = $settings['site_name'] ?? 'Techno Coderz';
$phone    = $settings['phone']  ?? '+91 98765 43210';
$phoneRaw = preg_replace('/\D+/', '', $phone);

// ---- Four things that follow from the mission ----
$pledges = [
    ['n' => '01', 'title' => 'Sessions small enough to notice you', 'text' => '12–18 students, so a trainer sees where you are stuck instead of moving on with the room.', 'icon' => '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0M17 5.5a3.5 3.5 0 0 1 0 7M18.5 20a6.6 6.6 0 0 0-3-5.4"/>'],
    ['n' => '02', 'title' => 'Projects with real requirements', 'text' => 'From week three you work to a brief, a review and a deadline — the work that fills a portfolio.', 'icon' => '<path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H19v15H6.5A2.5 2.5 0 0 0 4 20.5Zm0 0v15"/><path d="M9 7.5h6M9 11h4"/>'],
    ['n' => '03', 'title' => 'A curriculum that keeps moving', 'text' => 'Reviewed every quarter against live job descriptions from the hiring partners we place into.', 'icon' => '<path d="M21 12a9 9 0 1 1-2.6-6.4"/><path d="M21 4v5h-5"/>'],
    ['n' => '04', 'title' => 'Support that outlasts the course', 'text' => 'Resume rebuilds, mock interviews and introductions continue after your certificate, until you are placed.', 'icon' => '<path d="M12 21s7-5.5 7-11a7 7 0 1 0-14 0c0 5.5 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/>'],
];

// ---- Where to go next ----
$nextSteps = [
    ['title' => 'About Techno Coderz', 'desc' => 'A decade of training in Mohali, working-engineer trainers, live projects and a placement cell behind them.', 'cta' => 'Read the story', 'href' => 'about.php', 'icon' => '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="4"/><circle cx="12" cy="12" r="0.6"/>'],
    ['title' => 'Our founder & team', 'desc' => 'The people who started Techno Coderz on one principle: a student should leave with work an employer can open and inspect.', 'cta' => 'Meet the team', 'href' => 'founder.php', 'icon' => '<circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/>'],
    ['title' => 'Industrial training', 'desc' => '45 days, 6 weeks, 6 months and 9 months, aligned to university requirements and closed with an internship letter.', 'cta' => 'See the tracks', 'href' => 'courses.php', 'icon' => '<path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H19v15H6.5A2.5 2.5 0 0 0 4 20.5Zm0 0v15"/>'],
];

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
          hero:  { 950:'#0b1220', 900:'#131c2e', 800:'#3a2410', 600:'#c2410c', glow:'#ff6b00' },
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
<script>document.addEventListener('DOMContentLoaded', function () { var c = document.getElementById('enquiryCsrf'); if (c) c.value = '<?= e($csrf) ?>'; });</script>

<main class="overflow-x-hidden">

<!-- ============ 1. HERO ============ -->
<section class="relative overflow-hidden bg-hero-950 pb-20 pt-[7.5rem] text-white lg:pb-24 lg:pt-[12rem]">
  <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_80%_70%_at_20%_0%,#3a2410_0%,transparent_60%),radial-gradient(ellipse_60%_60%_at_100%_100%,rgba(255,107,0,0.16),transparent_60%)]"></div>
  <div class="pointer-events-none absolute inset-0 grid-lines"></div>
  <div class="glow-blob right-[5%] top-[10%] h-[380px] w-[380px] bg-accent-glow/20"></div>
  <div class="container-x relative">
    <nav aria-label="Breadcrumb" class="mb-6 flex items-center gap-2 text-[0.78rem] font-semibold text-up-soft/60">
      <a href="index.php" class="transition-colors hover:text-white">Home</a>
      <span aria-hidden="true">/</span>
      <a href="about.php" class="transition-colors hover:text-white">About</a>
      <span aria-hidden="true">/</span>
      <span class="text-white/80">Mission &amp; Vision</span>
    </nav>
    <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-3.5 py-1.5 text-[0.7rem] font-semibold uppercase tracking-[0.16em] text-up-soft"><span class="h-1.5 w-1.5 rounded-full bg-accent-yellow"></span>Why we exist</p>
    <h1 class="max-w-4xl font-display text-4xl font-extrabold leading-[1.08] sm:text-5xl lg:text-[3.6rem] text-white">Where we are going, and <span class="text-accent-glow">how we get there</span></h1>
    <p class="mt-6 max-w-2xl text-base leading-relaxed text-up-soft/80 sm:text-lg">Two statements that decide everything else — what we teach, how large a session gets, and when we consider a student finished.</p>
  </div>
</section>

<!-- ============ 2. VISION & MISSION ============ -->
<section class="py-24 lg:py-32">
  <div class="container-x grid gap-6 lg:grid-cols-2 lg:gap-8">
    <div data-anim="left" class="relative overflow-hidden rounded-[1.75rem] bg-hero-950 p-9 text-white lg:p-12">
      <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,107,0,0.28),transparent_65%)]"></div>
      <div class="absolute inset-0 grid-lines opacity-50"></div>
      <div class="relative">
        <p class="text-xs font-bold uppercase tracking-[0.16em] text-white">Where we are going</p>
        <h2 class="mt-4 font-display text-3xl font-extrabold sm:text-[2.5rem]">Our Vision</h2>
        <span aria-hidden="true" class="mt-5 block h-[3px] w-24 rounded-full bg-gradient-to-r from-accent-glow to-transparent"></span>
        <p class="mt-6 text-[1.02rem] leading-relaxed text-up-soft/80">To be the centre Punjab&rsquo;s employers name first — where someone can walk in without a line of code to their name and walk out an engineer a company is glad to have hired. Not a certificate mill; a place a career actually starts.</p>
      </div>
    </div>
    <div data-anim="right" class="relative overflow-hidden rounded-[1.75rem] border border-line bg-white p-9 lg:p-12">
      <div class="relative">
        <p class="text-xs font-bold uppercase tracking-[0.16em] text-up-accent">What we do daily</p>
        <h2 class="mt-4 font-display text-3xl font-extrabold text-up-ink sm:text-[2.5rem]">Our Mission</h2>
        <span aria-hidden="true" class="mt-5 block h-[3px] w-24 rounded-full bg-gradient-to-r from-up-accent to-transparent"></span>
        <p class="mt-6 text-[1.02rem] leading-relaxed text-up-muted">To teach what the industry genuinely runs on, in sessions small enough that a trainer notices when you are stuck, on projects with real requirements and real deadlines — and to stay with every student until the offer letter arrives.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ 3. FOUR COMMITMENTS ============ -->
<section class="bg-subtle py-24 lg:py-32">
  <div class="container-x">
    <div class="mx-auto max-w-3xl text-center">
      <p data-anim="fade" class="text-xs font-bold uppercase tracking-[0.16em] text-up-accent">What it commits us to</p>
      <h2 data-anim="words" class="mt-4 font-display text-3xl font-extrabold leading-[1.1] text-up-ink sm:text-4xl lg:text-[2.9rem]">Four things that follow from it</h2>
      <div data-underline class="mx-auto mt-5 h-[3px] w-24 rounded-full bg-gradient-to-r from-up-accent to-transparent"></div>
      <p data-anim="up" data-anim-delay="0.1" class="mt-5 text-base leading-relaxed text-up-muted sm:text-lg">A mission is only worth writing down if it changes what you actually do. These are the parts of Techno Coderz it decides.</p>
    </div>
    <div data-anim="up" data-anim-delay="0.15" class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
      <?php foreach ($pledges as $p): ?>
      <div class="card-hover group relative flex flex-col rounded-3xl border border-line bg-white p-7">
        <div class="flex items-center justify-between">
          <span class="grid h-11 w-11 place-items-center rounded-2xl bg-brand-50 text-up-accent transition-colors group-hover:bg-up-accent group-hover:text-white"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?= $p['icon'] ?></svg></span>
          <span class="font-display text-2xl font-extrabold text-up-line transition-colors group-hover:text-up-accent/60"><?= e($p['n']) ?></span>
        </div>
        <h3 class="mt-5 text-lg font-bold leading-snug text-up-ink"><?= e($p['title']) ?></h3>
        <p class="mt-3 flex-1 text-sm leading-relaxed text-up-muted"><?= e($p['text']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
    <div data-anim="up" class="mt-10 text-center">
      <a href="about.php#campus" class="group inline-flex items-center gap-2 rounded-full border border-up-line bg-white px-6 py-3 text-sm font-semibold text-up-ink transition-colors hover:border-up-accent hover:text-up-accent">See our accreditations<svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform group-hover:translate-x-1"><path d="M4 12h16M14 6l6 6-6 6"/></svg></a>
    </div>
  </div>
</section>

<!-- ============ 4. WHERE TO GO NEXT ============ -->
<section class="border-t border-line bg-subtle py-20 lg:py-24" aria-labelledby="related-heading">
  <div class="container-x">
    <p class="text-xs font-bold uppercase tracking-[0.16em] text-up-accent">Keep exploring</p>
    <h2 id="related-heading" data-anim="words" class="mt-3 font-display text-2xl font-extrabold text-up-ink sm:text-3xl">Where to go next</h2>
    <div data-underline class="mt-4 h-[3px] w-20 rounded-full bg-gradient-to-r from-up-accent to-transparent"></div>
    <div data-anim="up" data-anim-delay="0.1" class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
      <?php foreach ($nextSteps as $n): ?>
      <a href="<?= e($n['href']) ?>" class="card-hover group flex flex-col rounded-3xl border border-line bg-white p-7">
        <span class="grid h-11 w-11 place-items-center rounded-2xl bg-brand-50 text-up-accent transition-colors group-hover:bg-up-accent group-hover:text-white"><svg viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?= $n['icon'] ?></svg></span>
        <span class="mt-5 font-display text-lg font-bold leading-snug text-up-ink transition-colors group-hover:text-up-accent"><?= e($n['title']) ?></span>
        <span class="mt-2.5 flex-1 text-sm leading-relaxed text-up-muted"><?= e($n['desc']) ?></span>
        <span class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-up-accent"><?= e($n['cta']) ?><svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform group-hover:translate-x-1"><path d="M4 12h16M14 6l6 6-6 6"/></svg></span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ 5. CTA ============ -->
<section class="relative overflow-hidden bg-subtle py-24 lg:py-32">
  <div class="pointer-events-none absolute right-[6%] top-1/2 h-16 w-16 -translate-y-1/2 rounded-full border border-up-line"></div>
  <div class="pointer-events-none absolute left-[7%] top-[22%] h-10 w-10 rounded-full border border-up-line"></div>
  <div class="container-x relative text-center">
    <p data-anim="fade" class="text-[0.72rem] font-bold uppercase tracking-[0.2em] text-up-bright">Ready to get started?</p>
    <h2 data-anim="up" data-anim-delay="0.08" class="mx-auto mt-5 max-w-2xl font-display text-[2.4rem] font-extrabold leading-[1.06] tracking-tight text-up-ink sm:text-5xl lg:text-[3.6rem]">Start building your career today.</h2>
    <p data-anim="up" data-anim-delay="0.16" class="mx-auto mt-6 max-w-xl text-[1.02rem] leading-relaxed text-up-muted">Talk to a counsellor today. One call is usually enough to know which track fits your degree, your schedule and the job you want.</p>
    <div data-anim="up" data-anim-delay="0.24" class="mt-10 flex justify-center">
      <form id="tcmMvCta" class="w-full" onsubmit="return false;">
        <div class="mx-auto flex w-full max-w-xl flex-col items-stretch gap-3 sm:flex-row">
          <label for="mv-cta-phone" class="sr-only">Your mobile number</label>
          <input id="mv-cta-phone" type="tel" inputmode="tel" autocomplete="tel" placeholder="Your mobile number" class="min-w-0 flex-1 rounded-full border border-up-line bg-white px-6 py-4 text-[0.95rem] text-up-ink outline-none transition-colors placeholder:text-up-muted/60 focus:border-up-accent" value="">
          <button type="submit" class="accent-fill shrink-0 rounded-full px-8 py-4 text-[0.9rem] font-bold transition-all hover:-translate-y-0.5">Book Demo</button>
        </div>
      </form>
    </div>
    <a data-anim="up" data-anim-delay="0.3" href="tel:<?= e($phoneRaw) ?>" class="group mt-8 inline-flex items-center gap-3.5 rounded-full bg-hero-600 py-3 pl-3 pr-7 text-left text-white shadow-[0_18px_45px_-16px_rgba(194,65,12,0.85)] transition-all hover:-translate-y-0.5 hover:bg-hero-glow">
      <span class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-white/20"><svg viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 3h3l2 5-2.5 1.5a12 12 0 0 0 6 6L16 13l5 2v3a2 2 0 0 1-2.2 2A17 17 0 0 1 4 5.2 2 2 0 0 1 6 3Z"/></svg></span>
      <span class="leading-tight"><span class="block text-[0.62rem] font-bold uppercase tracking-[0.16em] text-white/70">Call now</span><span class="block text-[1.05rem] font-extrabold"><?= e($phone) ?></span></span>
    </a>
    <ul data-anim="fade" data-anim-delay="0.36" class="mt-10 flex flex-wrap items-center justify-center gap-x-6 gap-y-3 text-[0.88rem] text-up-muted">
      <?php foreach (['Free career counselling', 'No registration fee', 'Placement support included'] as $li): ?>
      <li class="flex items-center"><span class="inline-flex items-center gap-2"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="shrink-0 text-up-bright"><circle cx="12" cy="12" r="9"/><path d="m8.4 12.2 2.5 2.5 4.7-5.2"/></svg><?= e($li) ?></span></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

</main>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var f = document.getElementById('tcmMvCta');
    if (!f) return;
    f.addEventListener('submit', function () {
      var p = document.getElementById('mv-cta-phone');
      if (p && p.value && p.value.trim().length >= 10) {
        if (typeof window.openEnquiry === 'function') { window.openEnquiry('Free Demo'); }
      }
    });
  });
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
