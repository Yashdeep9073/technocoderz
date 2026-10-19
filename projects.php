<?php
// ============================================================
// Techno Coderz — Projects (techcadd-style, tcm-home)
// ============================================================
require_once __DIR__ . '/includes/functions.php';

$pageTitle       = 'Our Projects – Techno Coderz';
$pageDescription = 'Real-world projects built by Techno Coderz students and our team. Browse portfolios in Web, App, AI, Data, and Cloud.';
$currentPage     = 'projects';
$csrf = generateCsrfToken();

$pdo = getDB();
$projects = [];
try {
    $projects = $pdo->query("SELECT id, title, description, category, image, link, technologies, status FROM projects WHERE status = 1 ORDER BY id DESC")->fetchAll();
} catch (Throwable $e) {
    error_log('Projects fetch: ' . $e->getMessage());
}
$projectCount = count($projects);

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
        <span class="text-white/80">Projects</span>
      </nav>
      <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-3.5 py-1.5 text-[0.7rem] font-semibold uppercase tracking-[0.16em] text-up-soft"><span class="h-1.5 w-1.5 rounded-full bg-accent-yellow"></span>Portfolio</p>
      <h1 class="max-w-4xl font-display text-4xl font-extrabold leading-[1.08] text-white sm:text-5xl lg:text-[3.6rem]">Our <span class="text-accent-glow">Projects</span></h1>
      <p class="mt-6 max-w-2xl text-base leading-relaxed text-up-soft/80 sm:text-lg">Real-world projects built by Techno Coderz students and our team — giving you practical, portfolio-ready experience.</p>
      <div class="mt-8 flex flex-wrap gap-3">
        <span class="rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm"><?= $projectCount ?> Project<?= $projectCount != 1 ? 's' : '' ?></span>
        <span class="rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm">Live Demos</span>
        <span class="rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm">Portfolio-Ready</span>
        <span class="rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm">Industry-Focused</span>
      </div>
    </div>
  </section>

  <!-- PROJECTS GRID -->
  <section class="py-24 lg:py-32">
    <div class="container-x">
      <div class="mx-auto max-w-3xl text-center">
        <p data-anim="fade" class="text-xs font-bold uppercase tracking-[0.16em] text-up-accent">Work We've Built</p>
        <h2 data-anim="words" class="mt-4 font-display text-3xl font-extrabold leading-[1.1] text-up-ink sm:text-4xl lg:text-[2.9rem]">Explore Our Latest <span class="text-up-accent">Projects</span></h2>
        <div data-underline class="mx-auto mt-5 h-[3px] w-24 rounded-full bg-gradient-to-r from-up-accent to-transparent"></div>
        <p data-anim="up" data-anim-delay="0.1" class="mt-5 text-base leading-relaxed text-up-muted sm:text-lg">From web applications and mobile apps to AI models and data dashboards — every project is built to solve real problems.</p>
      </div>
      <?php if (!empty($projects)): ?>
      <div data-anim="up" data-anim-delay="0.15" class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($projects as $proj): 
          $projImg = '';
          if (!empty($proj['image'])) {
            $imgPath = UPLOAD_DIR . 'projects/' . $proj['image'];
            if (file_exists($imgPath)) $projImg = UPLOAD_URL . 'projects/' . $proj['image'];
          }
          $techs = [];
          if (!empty($proj['technologies'])) {
            $techs = array_filter(array_map('trim', preg_split('/[,\|\n\r]+/', $proj['technologies'])));
          }
        ?>
        <div class="card-hover group relative flex flex-col overflow-hidden rounded-3xl border border-line bg-white">
          <div class="relative aspect-[16/10] overflow-hidden bg-subtle">
            <?php if ($projImg): ?>
            <img src="<?= e($projImg) ?>" alt="<?= e($proj['title']) ?>" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110" loading="lazy">
            <?php else: ?>
            <div class="flex h-full items-center justify-center bg-gradient-to-br from-brand-50 to-white"><i class="bi bi-code-slash text-5xl text-up-accent"></i></div>
            <?php endif; ?>
            <?php if (!empty($proj['category'])): ?>
            <span class="absolute left-4 top-4 rounded-full bg-white/95 px-3 py-1 text-xs font-bold uppercase tracking-wide text-up-accent shadow-sm backdrop-blur-sm"><?= e($proj['category']) ?></span>
            <?php endif; ?>
          </div>
          <div class="flex flex-1 flex-col p-7">
            <h3 class="font-display text-lg font-bold text-up-ink"><?= e($proj['title']) ?></h3>
            <?php if (!empty($proj['description'])): ?>
            <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-up-muted"><?= e($proj['description']) ?></p>
            <?php endif; ?>
            <?php if (!empty($techs)): ?>
            <div class="mt-4 flex flex-wrap gap-2">
              <?php foreach (array_slice($techs, 0, 5) as $t): ?>
              <span class="rounded-full border border-line bg-subtle px-2.5 py-1 text-xs font-medium text-up-ink/80"><?= e($t) ?></span>
              <?php endforeach; ?>
              <?php if (count($techs) > 5): ?>
              <span class="rounded-full border border-line bg-subtle px-2.5 py-1 text-xs font-medium text-up-muted">+<?= count($techs)-5 ?> more</span>
              <?php endif; ?>
            </div>
            <?php endif; ?>
            <div class="mt-6 flex items-center justify-between gap-3 border-t border-line pt-6">
              <a href="<?= SITE_URL ?>/projects.php" class="inline-flex items-center gap-2 text-sm font-bold text-up-accent group-hover:underline">View Details <i class="bi bi-arrow-right transition-transform group-hover:translate-x-1"></i></a>
              <?php if (!empty($proj['link'])): ?>
              <a href="<?= e($proj['link']) ?>" target="_blank" rel="noreferrer" class="inline-flex items-center gap-2 rounded-full border border-line bg-white px-4 py-2 text-xs font-semibold text-up-ink transition-colors hover:border-up-accent hover:text-up-accent">Live Demo <i class="bi bi-box-arrow-up-right"></i></a>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php else: ?>
      <div data-anim="up" class="mt-14 rounded-3xl border border-dashed border-line bg-subtle p-10 text-center">
        <p class="text-lg font-semibold text-up-ink">Projects coming soon</p>
        <p class="mt-2 text-sm text-up-muted">We're adding real student and team projects. Check back shortly.</p>
      </div>
      <?php endif; ?>
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
          ['title'=>'Our Services','desc'=>'Job-oriented training programs designed to make you industry-ready from day one.','cta'=>'View Services','href'=>'services.php','icon'=>'<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 9h18"/>'],
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
