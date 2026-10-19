<?php
// ============================================================
// Techno Coderz — Services (techcadd-style, tcm-home)
// ============================================================
require_once __DIR__ . '/includes/functions.php';

$pageTitle       = 'Our Services – Techno Coderz';
$pageDescription = 'Job-oriented training programs at Techno Coderz: Web Development, App Development, AI/ML, Data Science, Cloud, Cyber Security & more.';
$currentPage     = 'services';
$csrf = generateCsrfToken();

$pdo = getDB();
$services = [];
try {
    $services = $pdo->query("SELECT id, title, description, icon, features, status FROM services WHERE status = 1 ORDER BY id DESC")->fetchAll();
} catch (Throwable $e) {
    error_log('Services fetch: ' . $e->getMessage());
}
$serviceCount = count($services);

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
          brand: {50:'#fff4ec',100:'#ffe6d5',200:'#ffccab',300:'#ffb077',400:'#ff9143',500:'#ff7a1a',600:'#ff6b00',700:'#e55f00'},
          hero: {950:'#0b1220',600:'#c2410c',glow:'#ff6b00'},
          up: {ink:'#0f172a',muted:'#475569',line:'#e2e8f0',accent:'#ff6b00',bright:'#ff8533',soft:'#ffd9bf'}
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
<script>window.TC_BASE_URL='<?= SITE_URL ?>';</script>
<script>document.addEventListener('DOMContentLoaded',function(){var c=document.getElementById('enquiryCsrf');if(c)c.value='<?= e($csrf) ?>';});</script>

<main class="overflow-x-hidden">
  <!-- HERO -->
  <section class="relative overflow-hidden bg-hero-950 pb-20 pt-[7.5rem] text-white lg:pb-24 lg:pt-[12rem]">
    <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_80%_70%_at_20%_0%,#3a2410_0%,transparent_60%),radial-gradient(ellipse_60%_60%_at_100%_100%,rgba(255,107,0,0.16),transparent_60%)]"></div>
    <div class="pointer-events-none absolute inset-0 grid-lines"></div>
    <div class="glow-blob right-[5%] top-[10%] h-[380px] w-[380px] bg-accent-glow/20"></div>
    <div class="container-x relative">
      <nav aria-label="Breadcrumb" class="mb-6 flex items-center gap-2 text-[0.78rem] font-semibold text-up-soft/60">
        <a href="index.php" class="transition-colors hover:text-white">Home</a>
        <span aria-hidden="true">/</span>
        <span class="text-white/80">Services</span>
      </nav>
      <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-3.5 py-1.5 text-[0.7rem] font-semibold uppercase tracking-[0.16em] text-up-soft"><span class="h-1.5 w-1.5 rounded-full bg-accent-yellow"></span>Our Services</p>
      <h1 class="max-w-4xl font-display text-4xl font-extrabold leading-[1.08] text-white sm:text-5xl lg:text-[3.6rem]">Job-Oriented <span class="text-accent-glow">Training & Services</span></h1>
      <p class="mt-6 max-w-2xl text-base leading-relaxed text-up-soft/80 sm:text-lg">Industry-aligned training programs designed to bridge the gap between classroom learning and real-world job requirements.</p>
      <div class="mt-8 flex flex-wrap gap-3">
        <span class="rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm"><?= $serviceCount ?> Service<?= $serviceCount != 1 ? 's' : '' ?></span>
        <span class="rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm">Live Projects</span>
        <span class="rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm">100% Placement Support</span>
        <span class="rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm">Flexible Batches</span>
      </div>
    </div>
  </section>

  <!-- SERVICES GRID -->
  <section class="py-24 lg:py-32">
    <div class="container-x">
      <div class="mx-auto max-w-3xl text-center">
        <p data-anim="fade" class="text-xs font-bold uppercase tracking-[0.16em] text-up-accent">What We Offer</p>
        <h2 data-anim="words" class="mt-4 font-display text-3xl font-extrabold leading-[1.1] text-up-ink sm:text-4xl lg:text-[2.9rem]">Our <span class="text-up-accent">Services</span></h2>
        <div data-underline class="mx-auto mt-5 h-[3px] w-24 rounded-full bg-gradient-to-r from-up-accent to-transparent"></div>
        <p data-anim="up" data-anim-delay="0.1" class="mt-5 text-base leading-relaxed text-up-muted sm:text-lg">From coding bootcamps to professional certifications, we offer comprehensive training solutions tailored to your career goals.</p>
      </div>
      <?php if (!empty($services)): ?>
      <div data-anim="up" data-anim-delay="0.15" class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($services as $svc): ?>
        <div class="card-hover group flex flex-col rounded-3xl border border-line bg-white p-7">
          <?php if (!empty($svc['icon'])): ?>
          <span class="grid h-12 w-12 place-items-center rounded-2xl bg-brand-50 text-up-accent transition-colors group-hover:bg-up-accent group-hover:text-white">
            <i class="bi <?= e($svc['icon']) ?> text-xl"></i>
          </span>
          <?php else: ?>
          <span class="grid h-12 w-12 place-items-center rounded-2xl bg-brand-50 text-up-accent transition-colors group-hover:bg-up-accent group-hover:text-white">
            <i class="bi bi-code-slash text-xl"></i>
          </span>
          <?php endif; ?>
          <h3 class="mt-5 font-display text-lg font-bold text-up-ink"><?= e($svc['title']) ?></h3>
          <?php if (!empty($svc['description'])): ?>
          <p class="mt-2 flex-1 text-sm leading-relaxed text-up-muted"><?= e($svc['description']) ?></p>
          <?php endif; ?>
          <?php if (!empty($svc['features'])): 
            $f = array_filter(array_map('trim', preg_split('/[,\|\n\r]+/', $svc['features'])));
          ?>
          <ul class="mt-5 space-y-2">
            <?php foreach (array_slice($f, 0, 4) as $feat): ?>
            <li class="flex items-start gap-2 text-sm text-up-muted"><i class="bi bi-check-circle-fill text-up-accent mt-0.5"></i><?= e($feat) ?></li>
            <?php endforeach; ?>
          </ul>
          <?php endif; ?>
          <a href="<?= SITE_URL ?>/contact.php" class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-up-accent group-hover:underline">Enquire Now <i class="bi bi-arrow-right transition-transform group-hover:translate-x-1"></i></a>
        </div>
        <?php endforeach; ?>
      </div>
      <?php else: ?>
      <div data-anim="up" class="mt-14 rounded-3xl border border-dashed border-line bg-subtle p-10 text-center">
        <p class="text-lg font-semibold text-up-ink">Services coming soon</p>
        <p class="mt-2 text-sm text-up-muted">We're updating our service offerings. Please check back shortly.</p>
      </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- PROCESS -->
  <section class="bg-subtle py-24 lg:py-32">
    <div class="container-x">
      <div class="mx-auto max-w-3xl text-center">
        <p data-anim="fade" class="text-xs font-bold uppercase tracking-[0.16em] text-up-accent">How We Work</p>
        <h2 data-anim="words" class="mt-4 font-display text-3xl font-extrabold leading-[1.1] text-up-ink sm:text-4xl lg:text-[2.9rem]">Our Training <span class="text-up-accent">Process</span></h2>
        <div data-underline class="mx-auto mt-5 h-[3px] w-24 rounded-full bg-gradient-to-r from-up-accent to-transparent"></div>
        <p data-anim="up" data-anim-delay="0.1" class="mt-5 text-base leading-relaxed text-up-muted sm:text-lg">A structured approach to transform your learning journey into a successful career.</p>
      </div>
      <div data-anim="up" data-anim-delay="0.15" class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <?php $steps = [
          ['n'=>'01','title'=>'Career Consultation','desc'=>'Understand your goals and choose the right career path.'],
          ['n'=>'02','title'=>'Customized Learning','desc'=>'Get a tailored curriculum designed for your skill level.'],
          ['n'=>'03','title'=>'Hands-On Training','desc'=>'Learn through live projects, assignments and practical sessions.'],
          ['n'=>'04','title'=>'Placement Support','desc'=>'Resume prep, mock interviews and job referrals until placed.']
        ]; foreach ($steps as $st): ?>
        <div class="card-hover relative flex flex-col rounded-3xl border border-line bg-white p-7">
          <span class="font-display text-3xl font-extrabold text-up-accent/30"><?= $st['n'] ?></span>
          <h3 class="mt-3 text-lg font-bold text-up-ink"><?= $st['title'] ?></h3>
          <p class="mt-2 text-sm leading-relaxed text-up-muted"><?= $st['desc'] ?></p>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- WHERE TO GO NEXT -->
  <section class="border-t border-line bg-subtle py-20 lg:py-24">
    <div class="container-x">
      <p class="text-xs font-bold uppercase tracking-[0.16em] text-up-accent">Keep Exploring</p>
      <h2 data-anim="words" class="mt-3 font-display text-2xl font-extrabold text-up-ink sm:text-3xl">Where to Go <span class="text-up-accent">Next</span></h2>
      <div data-underline class="mt-4 h-[3px] w-20 rounded-full bg-gradient-to-r from-up-accent to-transparent"></div>
      <div data-anim="up" data-anim-delay="0.1" class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <?php $next = [
          ['title'=>'Our Projects','desc'=>'Portfolio of real applications and systems built by our team and students.','cta'=>'View Portfolio','href'=>'projects.php','icon'=>'<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M7 5v14M17 5v14M3 12h18"/>'],
          ['title'=>'Explore Courses','desc'=>'Job-oriented training in PHP, Java, Full Stack, Data, AI and more.','cta'=>'Browse Courses','href'=>'courses.php','icon'=>'<path d="M6 4h10l4 4v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"/><path d="M14 4v4h4"/>'],
          ['title'=>'Talk to Our Team','desc'=>'Questions about a course or your career path? We\'re happy to help.','cta'=>'Get in Touch','href'=>'contact.php','icon'=>'<path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5Z"/>']
        ]; foreach ($next as $n): ?>
        <a href="<?= e($n['href']) ?>" class="card-hover group flex flex-col rounded-3xl border border-line bg-white p-7">
          <span class="grid h-11 w-11 place-items-center rounded-2xl bg-brand-50 text-up-accent transition-colors group-hover:bg-up-accent group-hover:text-white"><svg viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><?= $n['icon'] ?></svg></span>
          <span class="mt-5 font-display text-lg font-bold leading-snug text-up-ink transition-colors group-hover:text-up-accent"><?= e($n['title']) ?></span>
          <span class="mt-2.5 flex-1 text-sm leading-relaxed text-up-muted"><?= e($n['desc']) ?></span>
          <span class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-up-accent"><?= e($n['cta']) ?><svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:translate-x-1"><path d="M4 12h16M14 6l6 6-6 6"/></svg></span>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
