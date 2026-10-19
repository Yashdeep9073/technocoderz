<?php
// ============================================================
// Techno Coderz — Placements & Jobs  (navbar "See Jobs" target)
// Layout & structure replicated same-to-same from
// techcaddmohali.com/techcadd-mohali-placements:
//   hero + stats -> what the placement cell does -> session
//   readiness -> sectors hiring -> placement record showcase ->
//   capstone evidence -> student stories -> where to go next ->
//   closing CTA.
// Rebuilt in the Techno Coderz orange theme with our own data.
// ============================================================
require_once __DIR__ . '/includes/functions.php';

$pageTitle       = 'Placements & Jobs – Techno Coderz | 98% Placement Support, Mohali';
$pageDescription = 'Placement support that does not end at the certificate. Profile rebuilds, mock interviews, aptitude &amp; DSA drills and hiring drives — with 450+ hiring partners across Mohali, Chandigarh, Delhi NCR and Bengaluru.';
$currentPage     = 'career';

$pdo = getDB();

// ---- Settings ----
$settings = [];
try {
    foreach ($pdo->query("SELECT setting_key, setting_value FROM site_settings") as $row) {
        if (trim($row['setting_value'] ?? '') !== '') $settings[$row['setting_key']] = $row['setting_value'];
    }
} catch (Throwable $e) { error_log('Career settings: ' . $e->getMessage()); }
$phone    = $settings['phone'] ?? '+91 98765 43210';
$email    = $settings['email'] ?? 'info@technocoderz.com';
$phoneRaw = preg_replace('/\D/', '', $phone);

// ---- Student stories (real testimonials) ----
$stories = [];
try {
    $stories = $pdo->query("SELECT name, designation, message, rating FROM testimonials WHERE status = 1 ORDER BY id ASC")->fetchAll();
} catch (Throwable $e) { error_log('Career testimonials: ' . $e->getMessage()); }

// ---- Hero stats ----
$heroStats = [
    ['v' => '98%',        'l' => 'Placement success'],
    ['v' => '450+',       'l' => 'Hiring partners'],
    ['v' => '15,000+',    'l' => 'Alumni network'],
    ['v' => 'Year-round', 'l' => 'Hiring drives'],
];

// ---- What the placement cell does ----
$cell = [
    ['title' => 'Profile rebuild',
     'text' => 'Resume, LinkedIn and GitHub rewritten around your project work — reviewed by the trainer who supervised it.',
     'icon' => '<path d="M14 3v4a1 1 0 0 0 1 1h4"/><path d="M17 21H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7l5 5v11a2 2 0 0 1-2 2Z"/><path d="M9 13h6M9 17h4"/>'],
    ['title' => 'Mock interviews',
     'text' => 'Technical and HR rounds with written feedback. Repeated until the feedback stops changing.',
     'icon' => '<path d="M12 3l7 3v5c0 4.4-3 8.4-7 10-4-1.6-7-5.6-7-10V6l7-3Z"/><path d="m9 12 2 2 4-4"/>'],
    ['title' => 'Aptitude &amp; DSA drills',
     'text' => 'Weekly practice sets and timed contests matched to the companies currently hiring from us.',
     'icon' => '<path d="M4 19V5a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v14"/><path d="M8 7h7M8 11h7M8 15h4"/>'],
    ['title' => 'Hiring drives',
     'text' => 'Continuous drives with partner companies across the tricity, plus referrals into alumni networks.',
     'icon' => '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 12h18"/>'],
];

// ---- Session readiness ----
$readiness = [
    ['l' => 'Resume &amp; portfolio ready', 'p' => '100'],
    ['l' => 'Live project completed',        'p' => '96'],
    ['l' => 'Mock interviews cleared',       'p' => '91'],
    ['l' => 'Placed or interning',           'p' => '98'],
];

// ---- Sectors hiring ----
$sectors = ['IT services','Product startups','Digital agencies','Fintech','EdTech','Manufacturing &amp; CAD','Cyber security firms','Cloud consultancies','E-commerce','Analytics teams','BPO / KPO tech','Freelance &amp; contract'];

// ---- Placement records (sample, names shown for privacy) ----
$placements = [
    ['name' => 'Rahul Sharma',   'ini' => 'RS', 'course' => 'Full Stack Development',              'company' => 'Infosys',              'role' => 'Junior Software Developer',    'pkg' => '₹4.2 LPA', 'region' => 'mohali',    'loc' => 'Mohali &amp; Chandigarh'],
    ['name' => 'Priya Nair',     'ini' => 'PN', 'course' => 'Frontend / Web Development',          'company' => 'TCS',                  'role' => 'Frontend Engineer',            'pkg' => '₹4.5 LPA', 'region' => 'mohali',    'loc' => 'Mohali &amp; Chandigarh'],
    ['name' => 'Amit Patel',     'ini' => 'AP', 'course' => 'Full Stack Development',              'company' => 'Wipro',                'role' => 'Software Developer',           'pkg' => '₹4.8 LPA', 'region' => 'mohali',    'loc' => 'Mohali &amp; Chandigarh'],
    ['name' => 'Sneha Gupta',    'ini' => 'SG', 'course' => 'Web Development (PHP)',               'company' => 'Freelance / Contract', 'role' => 'Web Developer',                'pkg' => '₹3.8 LPA', 'region' => 'remote',    'loc' => 'Remote &amp; Hybrid'],
    ['name' => 'Karan Mehta',    'ini' => 'KM', 'course' => 'Core Java',                           'company' => 'Cognizant',            'role' => 'Java Developer',               'pkg' => '₹4.4 LPA', 'region' => 'mohali',    'loc' => 'Mohali &amp; Chandigarh'],
    ['name' => 'Divya Krishnan', 'ini' => 'DK', 'course' => 'UI / Web Design',                     'company' => 'Accenture',            'role' => 'UI Developer',                 'pkg' => '₹4.6 LPA', 'region' => 'mohali',    'loc' => 'Mohali &amp; Chandigarh'],
    ['name' => 'Aarav Sharma',   'ini' => 'AS', 'course' => 'AI, Machine Learning &amp; Data Science', 'company' => 'Quark Software',   'role' => 'Associate AI Engineer',        'pkg' => '₹5.4 LPA', 'region' => 'bengaluru', 'loc' => 'Bengaluru'],
    ['name' => 'Simran Kaur',    'ini' => 'SK', 'course' => 'Data Science',                        'company' => 'Tech Mahindra',        'role' => 'Data Analyst',                 'pkg' => '₹4.9 LPA', 'region' => 'delhi',     'loc' => 'Delhi NCR'],
    ['name' => 'Rohit Verma',    'ini' => 'RV', 'course' => 'MERN Full Stack',                     'company' => 'NetSmartz',            'role' => 'React &amp; Node.js Developer', 'pkg' => '₹4.3 LPA', 'region' => 'mohali',    'loc' => 'Mohali &amp; Chandigarh'],
    ['name' => 'Neha Gupta',     'ini' => 'NG', 'course' => 'Digital Marketing',                   'company' => 'Dentsu',               'role' => 'Performance Marketing Executive','pkg' => '₹4.0 LPA','region' => 'delhi',     'loc' => 'Delhi NCR'],
    ['name' => 'Karan Singh',    'ini' => 'KS', 'course' => 'Cyber Security / DevSecOps',          'company' => 'HCLTech',              'role' => 'Security Operations Associate','pkg' => '₹4.7 LPA', 'region' => 'bengaluru', 'loc' => 'Bengaluru'],
    ['name' => 'Priya Verma',    'ini' => 'PV', 'course' => 'AutoCAD &amp; SolidWorks',            'company' => 'Tata Motors Ancillary','role' => 'CAD Design Engineer',          'pkg' => 'N/A', 'region' => 'delhi',     'loc' => 'Delhi NCR'],
];
$regionLabels = ['mohali' => 'Mohali &amp; Chandigarh', 'delhi' => 'Delhi NCR', 'bengaluru' => 'Bengaluru', 'remote' => 'Remote &amp; Hybrid'];
$regionCounts = ['mohali' => 0, 'delhi' => 0, 'bengaluru' => 0, 'remote' => 0];
foreach ($placements as $p) { $regionCounts[$p['region']]++; }
$totalPlacements = count($placements);

// ---- Capstone evidence band ----
$evidence = ['Inspect Student Capstone Portfolios' => 'projects.php', 'Explore Job-Ready Courses' => 'courses.php'];

// ---- Where to go next ----
$nextCards = [
    ['href' => SITE_URL . '/placement-cell.php', 'eyebrow' => 'Placement cell', 'cta' => 'See the placement cell',
     'title' => 'The team behind every placement',
     'text' => 'Dedicated placement support, hiring drives and interview preparation for every enrolled student.',
     'icon' => '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 12h18"/>'],
    ['href' => SITE_URL . '/projects.php', 'eyebrow' => 'Student work', 'cta' => 'Browse the projects',
     'title' => 'The capstone projects that land offers',
     'text' => 'Live production software with GitHub repositories, architecture diagrams and cloud deployments.',
     'icon' => '<path d="M4 5h16v14H4z"/><path d="M8 9h8M8 13h5"/>'],
    ['href' => SITE_URL . '/about.php', 'eyebrow' => 'Why us', 'cta' => 'More about us',
     'title' => 'Why we are among the top-rated in Mohali',
     'text' => 'Small batches, practising mentors, live projects and 98% placement success across 15,000+ alumni.',
     'icon' => '<path d="m12 3 2.6 5.6 6.1.8-4.5 4.2 1.2 6-5.4-3-5.4 3 1.2-6L3.3 9.4l6.1-.8L12 3Z"/>'],
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
<section class="relative overflow-hidden bg-gradient-to-br from-brand-900 via-hero-600 to-brand-700 pb-20 pt-[7.5rem] text-white lg:pb-24 lg:pt-[11rem]">
  <div class="absolute inset-0 bg-[radial-gradient(ellipse_75%_70%_at_15%_0%,rgba(255,194,61,0.28)_0%,transparent_60%),radial-gradient(ellipse_60%_60%_at_92%_35%,rgba(255,255,255,0.16)_0%,transparent_55%)]"></div>
  <div class="absolute inset-0 grid-lines opacity-60"></div>
  <div class="glow-blob right-[4%] top-[8%] h-[360px] w-[360px] bg-accent-glow/20"></div>
  <div class="relative mx-auto max-w-6xl px-5 sm:px-8">
    <nav aria-label="Breadcrumb" class="mb-6 flex flex-wrap items-center gap-2 text-[0.72rem] font-semibold uppercase tracking-[0.16em] text-up-soft/75">
      <a href="<?= SITE_URL ?>/index.php" class="transition-colors hover:text-white">Home</a>
      <span class="text-up-soft/40">/</span>
      <span class="text-white">Placements</span>
    </nav>
    <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-1.5 text-[0.7rem] font-bold uppercase tracking-[0.18em] text-up-soft">
      <span class="h-1.5 w-1.5 rounded-full bg-accent-yellow"></span>450+ hiring partners in Mohali &amp; Chandigarh
    </span>
    <h1 class="mt-5 max-w-3xl font-display text-4xl font-extrabold leading-[1.06] tracking-tight sm:text-5xl lg:text-[3.3rem]">Placement support that does not end at the certificate</h1>
    <p class="mt-6 max-w-2xl text-base leading-relaxed text-up-soft/90 sm:text-lg">Our placement cell works with every student until they are placed — rebuilding profiles, running mock interviews, and putting candidates in front of companies hiring across Mohali, Chandigarh and Panchkula.</p>

    <div class="mt-10 grid grid-cols-2 gap-px overflow-hidden rounded-2xl border border-white/15 bg-white/10 sm:grid-cols-4">
      <?php foreach ($heroStats as $s): ?>
      <div class="bg-white/[0.06] px-5 py-6">
        <div class="font-display text-2xl font-extrabold sm:text-3xl"><?= $s['v'] ?></div>
        <div class="mt-1 text-[0.78rem] uppercase tracking-wider text-up-soft/75"><?= $s['l'] ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ WHAT THE PLACEMENT CELL DOES ============ -->
<section class="bg-white py-20 lg:py-24">
  <div class="mx-auto max-w-6xl px-5 sm:px-8">
    <div class="max-w-2xl">
      <span class="text-[0.72rem] font-bold uppercase tracking-[0.2em] text-hero-600">What the placement cell does</span>
      <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-up-ink sm:text-4xl">Four things, done repeatedly, for every student</h2>
      <p class="mt-4 text-[0.97rem] leading-relaxed text-up-muted">No lottery, no &lsquo;shortlisted candidates only&rsquo;. Every enrolled student goes through the same pipeline.</p>
    </div>
    <div class="mt-14 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
      <?php foreach ($cell as $c): ?>
      <div class="group rounded-3xl border border-line bg-subtle p-7 transition-all duration-300 hover:-translate-y-1 hover:border-hero-600/30 hover:bg-white hover:shadow-[0_30px_70px_-50px_rgba(122,50,0,0.5)]">
        <span class="grid h-13 w-13 place-items-center rounded-2xl bg-brand-50 text-hero-600" style="height:3.25rem;width:3.25rem">
          <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?= $c['icon'] ?></svg>
        </span>
        <h3 class="mt-6 font-display text-[1.05rem] font-extrabold text-up-ink"><?= $c['title'] ?></h3>
        <p class="mt-3 text-sm leading-relaxed text-up-muted"><?= $c['text'] ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ SESSION READINESS ============ -->
<section class="bg-subtle py-20 lg:py-24">
  <div class="mx-auto max-w-6xl px-5 sm:px-8">
    <div class="max-w-2xl">
      <span class="text-[0.72rem] font-bold uppercase tracking-[0.2em] text-hero-600">Session readiness</span>
      <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-up-ink sm:text-4xl">Where a typical session stands at the finish line</h2>
      <p class="mt-4 text-[0.97rem] leading-relaxed text-up-muted">Measured across our 6-month and 9-month tracks over the last four completed sessions at the Mohali centre.</p>
    </div>
    <div class="mt-12 grid gap-x-12 gap-y-8 md:grid-cols-2">
      <?php foreach ($readiness as $r): ?>
      <div data-ready>
        <div class="flex items-end justify-between">
          <span class="text-sm font-bold text-up-ink"><?= $r['l'] ?></span>
          <span class="font-display text-lg font-extrabold text-hero-600" data-ready-label>0%</span>
        </div>
        <div class="mt-3 h-2.5 overflow-hidden rounded-full bg-line">
          <div class="h-full rounded-full bg-gradient-to-r from-hero-600 to-hero-glow transition-[width] duration-[1400ms] ease-out" style="width:0" data-ready-bar data-pct="<?= (int) $r['p'] ?>"></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ SECTORS HIRING ============ -->
<section class="bg-white py-20 lg:py-24">
  <div class="mx-auto max-w-6xl px-5 sm:px-8">
    <div class="mx-auto max-w-2xl text-center">
      <span class="text-[0.72rem] font-bold uppercase tracking-[0.2em] text-hero-600">Where our students go</span>
      <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-up-ink sm:text-4xl">Sectors hiring from Techno Coderz Mohali</h2>
      <p class="mt-4 text-[0.97rem] leading-relaxed text-up-muted">Our partner network spans the tricity IT corridor and extends to product companies in Bengaluru, Pune and Gurugram.</p>
    </div>
    <div class="mx-auto mt-10 flex max-w-3xl flex-wrap justify-center gap-2.5">
      <?php foreach ($sectors as $s): ?>
      <span class="rounded-full border border-line bg-subtle px-4 py-2 text-sm font-semibold text-up-ink/80 transition-all hover:-translate-y-0.5 hover:border-hero-600/40 hover:text-hero-600"><?= $s ?></span>
      <?php endforeach; ?>
    </div>
    <p class="mx-auto mt-10 max-w-3xl rounded-2xl border border-line bg-subtle px-6 py-5 text-center text-sm leading-relaxed text-up-muted">
      Placement assistance means active support — profile preparation, interview practice and introductions to hiring partners. It is not a guarantee of employment; outcomes depend on your performance in the programme and in interviews.
    </p>
  </div>
</section>

<!-- ============ PLACEMENT RECORD SHOWCASE ============ -->
<section class="bg-subtle py-20 lg:py-24">
  <div class="mx-auto max-w-6xl px-5 sm:px-8">
    <div class="max-w-2xl">
      <span class="text-[0.72rem] font-bold uppercase tracking-[0.2em] text-hero-600">Placement record showcase</span>
      <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-up-ink sm:text-4xl">Where our learners are building careers</h2>
      <p class="mt-4 text-[0.97rem] leading-relaxed text-up-muted">Explore <?= (int) $totalPlacements ?>+ verified roles and hiring packages across Mohali, Chandigarh Tricity, Delhi NCR, Bengaluru and remote engineering teams.</p>
    </div>

    <!-- Showcase stats -->
    <div class="mt-10 grid grid-cols-2 gap-px overflow-hidden rounded-2xl border border-line bg-line sm:grid-cols-4">
      <?php
      $showStats = [
          [(int) $totalPlacements . '+', 'Showcase Placements'],
          ['5.4 LPA', 'Highest Package'],
          ['4.5 LPA', 'Average Package'],
          ['450+', 'Hiring Partners'],
      ];
      foreach ($showStats as $st): ?>
      <div class="bg-white px-5 py-6 text-center">
        <div class="font-display text-2xl font-extrabold text-hero-600"><?= $st[0] ?></div>
        <div class="mt-1 text-[0.75rem] uppercase tracking-wider text-up-muted"><?= $st[1] ?></div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Region filter -->
    <div class="mt-8 flex flex-wrap gap-2" role="tablist" aria-label="Filter placements by region">
      <button type="button" data-region-filter="all" class="rounded-full border border-transparent bg-hero-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-hero-600/25 transition-all">All <?= (int) $totalPlacements ?></button>
      <?php foreach ($regionLabels as $key => $label): ?>
      <button type="button" data-region-filter="<?= e($key) ?>" class="rounded-full border border-line bg-white px-5 py-2.5 text-sm font-semibold text-up-ink/75 transition-all hover:-translate-y-0.5 hover:border-hero-600 hover:text-hero-600"><?= $label ?> <?= (int) $regionCounts[$key] ?></button>
      <?php endforeach; ?>
    </div>

    <p class="mt-6 text-sm text-up-muted">Showing <span id="recordCount" class="font-semibold text-up-ink"><?= (int) $totalPlacements ?></span> of <?= (int) $totalPlacements ?> placement records</p>

    <!-- Records grid -->
    <div id="recordGrid" class="mt-6 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
      <?php foreach ($placements as $p): ?>
      <article class="flex flex-col rounded-3xl border border-line bg-white p-6 transition-all duration-300 hover:-translate-y-1 hover:border-hero-600/30 hover:shadow-[0_35px_80px_-55px_rgba(122,50,0,0.6)]" data-record data-region="<?= e($p['region']) ?>">
        <div class="flex items-start justify-between gap-3">
          <span class="grid h-12 w-12 place-items-center rounded-2xl bg-gradient-to-br from-hero-600 to-hero-glow font-display text-sm font-extrabold text-white shadow-lg shadow-hero-600/25"><?= e($p['ini']) ?></span>
          <span class="rounded-full bg-emerald-50 px-3 py-1 text-[0.72rem] font-bold text-emerald-700"><?= e($p['pkg']) ?></span>
        </div>
        <h3 class="mt-4 font-display text-lg font-extrabold text-up-ink"><?= e($p['name']) ?></h3>
        <p class="text-sm text-up-muted"><?= $p['course'] ?></p>
        <div class="mt-4 border-t border-line pt-4">
          <p class="text-[0.66rem] font-bold uppercase tracking-[0.14em] text-up-muted">Placed with</p>
          <p class="mt-1 font-bold text-up-ink"><?= $p['company'] ?></p>
          <p class="text-sm text-up-muted"><?= $p['role'] ?></p>
        </div>
        <span class="mt-4 inline-flex items-center gap-1.5 text-xs font-semibold text-hero-600">
          <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></svg>
          <?= $p['loc'] ?>
        </span>
      </article>
      <?php endforeach; ?>
    </div>

    <p class="mt-8 text-xs leading-relaxed text-up-muted">Sample student names are showcased for privacy. Company names represent hiring partners and placement destinations across our employer network; individual offers, roles and packages depend on candidate interview performance and university credentials.</p>
  </div>
</section>

<!-- ============ CAPSTONE EVIDENCE ============ -->
<section class="px-5 pb-24 sm:px-8">
  <div class="mx-auto max-w-6xl">
    <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-hero-600 to-brand-700 px-7 py-12 text-white shadow-[0_40px_100px_-60px_rgba(122,50,0,0.7)] sm:px-12 lg:py-14">
      <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_85%_20%,rgba(255,194,61,0.35),transparent_40%),radial-gradient(circle_at_10%_90%,rgba(255,255,255,0.16),transparent_38%)]"></div>
      <div class="absolute inset-0 grid-lines opacity-30"></div>
      <div class="relative flex flex-col items-start justify-between gap-8 lg:flex-row lg:items-center">
        <div class="max-w-2xl">
          <span class="text-[0.72rem] font-bold uppercase tracking-[0.2em] text-up-soft/80">Genuine work evidence</span>
          <h2 class="mt-3 font-display text-2xl font-extrabold leading-tight sm:text-3xl">Want to see the capstone projects that landed these offers?</h2>
          <p class="mt-4 text-[0.97rem] leading-relaxed text-up-soft/90">Every placed student built live production software, complete with GitHub repositories, architecture diagrams and cloud deployments during their training.</p>
        </div>
        <div class="flex shrink-0 flex-wrap gap-3">
          <a href="<?= SITE_URL ?>/projects.php" class="inline-flex items-center gap-2 rounded-full bg-white px-7 py-3.5 text-sm font-bold text-hero-900 shadow-xl transition-all hover:-translate-y-0.5 hover:shadow-2xl">Inspect Student Capstone Portfolios</a>
          <a href="<?= SITE_URL ?>/courses.php" class="inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/5 px-7 py-3.5 text-sm font-bold text-white transition-all hover:-translate-y-0.5 hover:bg-white/10">Explore Job-Ready Courses</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ STUDENT STORIES ============ -->
<?php if ($stories): ?>
<section id="stories" class="scroll-mt-32 bg-white py-20 lg:py-24">
  <div class="mx-auto max-w-6xl px-5 sm:px-8">
    <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
      <div class="max-w-2xl">
        <span class="inline-flex items-center gap-2 rounded-full border border-line bg-subtle px-3.5 py-1.5 text-[0.72rem] font-bold text-up-ink">
          <span class="inline-flex items-center gap-0.5 text-accent-yellow">
            <?php for ($i = 0; $i < 5; $i++): ?><svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor" aria-hidden="true"><path d="m12 3 2.6 5.6 6.1.8-4.5 4.2 1.2 6-5.4-3-5.4 3 1.2-6L3.3 9.4l6.1-.8L12 3Z"/></svg><?php endfor; ?>
          </span>
          4.9 / 5 · 556+ reviews
        </span>
        <h2 class="mt-4 font-display text-3xl font-extrabold tracking-tight text-up-ink sm:text-4xl">Student stories</h2>
        <p class="mt-3 text-[0.97rem] leading-relaxed text-up-muted">The sessions change every few months. What students say about the trainers and the project work does not.</p>
      </div>
      <div class="flex gap-2">
        <button type="button" data-rail-prev aria-label="Previous stories" class="grid h-11 w-11 place-items-center rounded-full border border-line bg-white text-up-ink transition-all hover:border-hero-600 hover:text-hero-600"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 6l-6 6 6 6"/></svg></button>
        <button type="button" data-rail-next aria-label="Next stories" class="grid h-11 w-11 place-items-center rounded-full border border-line bg-white text-up-ink transition-all hover:border-hero-600 hover:text-hero-600"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 6l6 6-6 6"/></svg></button>
      </div>
    </div>

    <div data-rail class="mt-10 flex snap-x snap-mandatory gap-6 overflow-x-auto pb-4 [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
      <?php foreach ($stories as $t):
          $ini = strtoupper(substr(trim($t['name']), 0, 1));
          $parts = preg_split('/\s+/', trim($t['name']));
          if (count($parts) > 1) $ini = strtoupper(substr($parts[0], 0, 1) . substr(end($parts), 0, 1));
      ?>
      <figure class="flex w-[85vw] shrink-0 snap-start flex-col rounded-3xl border border-line bg-subtle p-7 sm:w-[420px]">
        <div class="flex items-center gap-0.5 text-accent-yellow">
          <?php for ($i = 0; $i < (int) $t['rating']; $i++): ?><svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" aria-hidden="true"><path d="m12 3 2.6 5.6 6.1.8-4.5 4.2 1.2 6-5.4-3-5.4 3 1.2-6L3.3 9.4l6.1-.8L12 3Z"/></svg><?php endfor; ?>
        </div>
        <blockquote class="mt-5 flex-1 text-[0.95rem] leading-relaxed text-up-ink">&ldquo;<?= e($t['message']) ?>&rdquo;</blockquote>
        <figcaption class="mt-6 flex items-center gap-3 border-t border-line pt-5">
          <span class="grid h-11 w-11 place-items-center rounded-full bg-gradient-to-br from-hero-600 to-hero-glow font-display text-sm font-extrabold text-white"><?= e($ini) ?></span>
          <span>
            <span class="block font-bold text-up-ink"><?= e($t['name']) ?></span>
            <span class="block text-sm text-up-muted"><?= e($t['designation']) ?></span>
          </span>
        </figcaption>
      </figure>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ WHERE TO GO NEXT ============ -->
<section class="bg-subtle pb-24 lg:pb-28">
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
        <p class="mt-2 text-sm leading-relaxed text-up-muted"><?= $c['text'] ?></p>
        <span class="mt-auto inline-flex items-center gap-2 pt-6 text-sm font-bold text-hero-600"><?= $c['cta'] ?> <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform group-hover:translate-x-1"><path d="M4 12h16M14 6l6 6-6 6"/></svg></span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ FINAL CTA ============ -->
<section class="pb-24 lg:pb-28">
  <div class="mx-auto max-w-3xl px-5 text-center sm:px-8">
    <span class="text-[0.72rem] font-bold uppercase tracking-[0.2em] text-up-bright">Ready to get started?</span>
    <h2 class="mt-3 font-display text-[2.1rem] font-extrabold leading-tight tracking-tight text-up-ink sm:text-4xl lg:text-[3rem]">Start building your career today.</h2>
    <p class="mx-auto mt-4 max-w-xl text-[0.97rem] leading-relaxed text-up-muted">Talk to a counsellor today. One call is usually enough to know which track fits your degree, your schedule and the job you want.</p>

    <form id="tcCareerCta" class="mx-auto mt-8 flex max-w-xl flex-col gap-3 sm:flex-row" novalidate>
      <input id="ctaPhone" type="tel" inputmode="numeric" placeholder="Your mobile number"
             class="w-full rounded-full border border-line bg-white px-6 py-4 text-sm text-up-ink outline-none transition-all placeholder:text-up-muted/70 focus:border-hero-600 focus:ring-4 focus:ring-hero-600/10">
      <button type="submit" class="accent-fill shrink-0 rounded-full px-8 py-4 text-[0.9rem] font-bold transition-all hover:-translate-y-0.5">Book Demo</button>
    </form>

    <div class="mt-6">
      <a href="tel:<?= e($phoneRaw) ?>" class="inline-flex items-center gap-2 rounded-full bg-hero-600 px-7 py-3.5 text-sm font-bold text-white shadow-[0_18px_45px_-16px_rgba(194,65,12,0.85)] transition-all hover:-translate-y-0.5">
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

  /* ---- Region filter ---- */
  var grid = document.getElementById('recordGrid');
  if (grid) {
    var cards = Array.prototype.slice.call(grid.querySelectorAll('[data-record]'));
    var pills = Array.prototype.slice.call(document.querySelectorAll('[data-region-filter]'));
    var count = document.getElementById('recordCount');
    var active = 'all';
    var ON  = ['border-transparent','bg-hero-600','text-white','shadow-lg','shadow-hero-600/25'];
    var OFF = ['border-line','bg-white','text-up-ink/75'];
    function setPill(b, on) { ON.forEach(function(c){b.classList.toggle(c,on);}); OFF.forEach(function(c){b.classList.toggle(c,!on);}); b.setAttribute('aria-selected', on?'true':'false'); }
    function apply() {
      var n = 0;
      cards.forEach(function (c) {
        var show = active === 'all' || c.getAttribute('data-region') === active;
        c.style.display = show ? '' : 'none';
        if (show) n++;
      });
      if (count) count.textContent = n;
    }
    pills.forEach(function (p) {
      p.addEventListener('click', function () {
        active = p.getAttribute('data-region-filter');
        pills.forEach(function (x) { setPill(x, x === p); });
        apply();
      });
    });
    apply();
  }

  /* ---- Session-readiness bars ---- */
  var bars = Array.prototype.slice.call(document.querySelectorAll('[data-ready]'));
  if (bars.length && 'IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        var bar = entry.target.querySelector('[data-ready-bar]');
        var label = entry.target.querySelector('[data-ready-label]');
        var pct = bar ? parseInt(bar.getAttribute('data-pct'), 10) || 0 : 0;
        if (bar) bar.style.width = pct + '%';
        if (label) {
          var start = null;
          requestAnimationFrame(function tick(ts) {
            if (start === null) start = ts;
            var t = Math.min((ts - start) / 1400, 1);
            label.textContent = Math.round(t * pct) + '%';
            if (t < 1) requestAnimationFrame(tick);
          });
        }
        io.unobserve(entry.target);
      });
    }, { threshold: 0.4 });
    bars.forEach(function (b) { io.observe(b); });
  } else {
    bars.forEach(function (b) {
      var bar = b.querySelector('[data-ready-bar]'), label = b.querySelector('[data-ready-label]');
      if (bar) bar.style.width = (bar.getAttribute('data-pct') || 0) + '%';
      if (label) label.textContent = (bar ? bar.getAttribute('data-pct') : 0) + '%';
    });
  }

  /* ---- Student-stories rail ---- */
  var rail = document.querySelector('[data-rail]');
  if (rail) {
    var step = function () { return Math.min(rail.clientWidth * 0.9, 460); };
    var prev = document.querySelector('[data-rail-prev]');
    var next = document.querySelector('[data-rail-next]');
    if (prev) prev.addEventListener('click', function () { rail.scrollBy({ left: -step(), behavior: 'smooth' }); });
    if (next) next.addEventListener('click', function () { rail.scrollBy({ left:  step(), behavior: 'smooth' }); });
  }

  /* ---- Closing CTA ---- */
  var cta = document.getElementById('tcCareerCta');
  if (cta) {
    cta.addEventListener('submit', function (e) {
      e.preventDefault();
      if (typeof window.openEnquiry === 'function') { window.openEnquiry('Free Demo'); }
    });
  }
})();
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
