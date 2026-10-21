<?php
// ============================================================
// Techno Coderz — About Us
// Layout & visual structure replicated section-by-section from
// techcaddmohali.com/about (same design system: dark hero, stat
// band, who-we-are, ecosystem, domains, journey timeline, founder,
// values, campus, related cards, why, reviews marquee, next steps,
// CTA). Re-themed to the Techno Coderz orange palette and filled
// with Techno Coderz data.
// ============================================================
require_once __DIR__ . '/includes/functions.php';

$pageTitle       = 'About Us – Techno Coderz | IT Training Institute, Mohali';
$pageDescription = 'About Techno Coderz — a Mohali IT training institute turning students, graduates and career-changers into working engineers, analysts and marketers since 2016.';
$currentPage     = 'about';
$csrf = generateCsrfToken();

$pdo          = getDB();
$testimonials = [];
$settings     = [];
try {
    $testimonials = $pdo->query("SELECT name, designation, rating, message FROM testimonials WHERE status = 1 ORDER BY id ASC")->fetchAll();
    foreach ($pdo->query("SELECT setting_key, setting_value FROM site_settings") as $row) {
        if (trim($row['setting_value'] ?? '') !== '') $settings[$row['setting_key']] = $row['setting_value'];
    }
} catch (Throwable $e) {
    error_log('About data: ' . $e->getMessage());
}

$siteName  = $settings['site_name'] ?? 'Techno Coderz';
$phone     = $settings['phone']  ?? '+91 98765 43210';
$phoneRaw  = preg_replace('/\D+/', '', $phone);
$email     = $settings['email']  ?? 'info@technocoderz.com';
$address   = $settings['address'] ?? 'Office No. 36, Second Floor, D-185, Phase 8B, Sector 74, Sahibzada Ajit Singh Nagar, Mohali, Punjab 160055';
$mapQuery  = rawurlencode(trim(preg_replace('/\s+/', ' ', $address)));

$avgRating = 4.8;
$ratings = array_filter(array_map(fn($t) => (float) ($t['rating'] ?? 0), $testimonials));
if ($ratings) $avgRating = round(array_sum($ratings) / count($ratings), 1);

// ---- Stats band ----
$stats = [
    ['v' => 15000, 'suffix' => '+', 'label' => 'Students trained',   'icon' => '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0M17 5.5a3.5 3.5 0 0 1 0 7M18.5 20a6.6 6.6 0 0 0-3-5.4"/>'],
    ['v' => 450,   'suffix' => '+', 'label' => 'Hiring partners',    'icon' => '<rect x="3" y="7.5" width="18" height="12" rx="2"/><path d="M9 7.5V6a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v1.5M3 12.5h18"/>'],
    ['v' => 98,    'suffix' => '%', 'label' => 'Placement success',  'icon' => '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="4"/><circle cx="12" cy="12" r="0.6"/>'],
    ['v' => 15,    'suffix' => '+', 'label' => 'Years of excellence','icon' => '<circle cx="12" cy="9" r="5.5"/><path d="m8.5 13.5-1 7 4.5-2.5 4.5 2.5-1-7"/>'],
];

// ---- What we teach chips ----
$teachChips = ['Artificial Intelligence','Data Science','Machine Learning','Cyber Security','Cloud Computing','Full Stack Development','MERN Stack','Python','Web Development','Mobile App Development','Digital Marketing','Graphic Designing','UI/UX','Animation','Video Editing','CAD/CAM'];

// ---- Technology domains ----
$domains = [
    ['title' => 'Technology', 'items' => ['AI','Machine Learning','Data Science','Cyber Security','Cloud Computing','DevOps']],
    ['title' => 'Development', 'items' => ['Python','Full Stack','MERN','Web Development','Mobile App Development'], 'hot' => true],
    ['title' => 'Digital & Creative', 'items' => ['Digital Marketing','UI/UX','Graphic Designing','Video Editing','Animation']],
    ['title' => 'Professional & Technical Skills', 'items' => ['Advanced Excel','CAD/CAM','Accounting','Other career-focused programs']],
];

// ---- Journey timeline ----
$journey = [
    ['year' => '2016', 'title' => 'Techno Coderz is founded',      'text' => 'The first classroom opens in Mohali to close the gap between academic learning and industry needs.'],
    ['year' => '2017', 'title' => 'Industrial training at scale',  'text' => 'Six-week, 45-day and six-month tracks become full, structured programmes.'],
    ['year' => '2018', 'title' => 'A placement cell',              'text' => 'Hiring support becomes its own team rather than a trainer\'s side task.'],
    ['year' => '2019', 'title' => 'Colleges come on board',        'text' => 'Formal industrial training partnerships begin with universities across Punjab.'],
    ['year' => '2020', 'title' => 'Teaching through lockdown',     'text' => 'Live online sessions launch in weeks, and no cohort loses a term.'],
    ['year' => '2021', 'title' => 'Data on the syllabus',          'text' => 'Analytics and data science join the catalogue as full career tracks.'],
    ['year' => '2022', 'title' => 'Cloud and DevOps',              'text' => 'AWS, Docker and CI pipelines are added to the developer paths.'],
    ['year' => '2023', 'title' => 'Tricity expansion',             'text' => 'A dedicated hub for Tricity college students and Tricity IT employers.'],
    ['year' => '2024', 'title' => 'AI on the syllabus',            'text' => 'Generative and agentic AI arrive, taught on real projects.'],
    ['year' => '2026', 'title' => 'Today and beyond',              'text' => 'New labs, new tracks, and the same rule: you learn it by building it.'],
];

// ---- Four rules (values) ----
$rules = [
    ['n' => '01', 'title' => 'Outcome over syllabus', 'text' => 'A course is only finished when you can build the thing, explain it, and pass the interview about it.', 'tags' => ['Live project work','Weekly code review','Mock interviews']],
    ['n' => '02', 'title' => '1:1 sessions, real attention', 'text' => 'Small batches so a trainer notices when someone is stuck instead of moving on.', 'tags' => ['12–18 seats per session','Open practice hours','One-to-one doubt time']],
    ['n' => '03', 'title' => 'Current, not archived', 'text' => 'Curriculum is reviewed every quarter against live job descriptions from our hiring partners.', 'tags' => ['Reviewed every quarter','Built with hiring partners','AI folded into every track']],
    ['n' => '04', 'title' => 'Honest guidance', 'text' => 'If a track is wrong for you, our counsellors say so. We would rather lose an admission than a reputation.', 'tags' => ['Free counselling call','Track fit before fees','No pressure to enrol']],
];
$included = ['1:1 personalised sessions','Live project experience','Internship letter','ISO-certified certificate','Interview & resume prep','Recorded sessions for life'];

// ---- Facilities ----
$facilities = ['High-spec lab machines','Open practice hours','Recorded sessions portal','Interview prep rooms','Free Wi-Fi & workstations','Placement cell on campus'];

// ---- Why (four things that change the outcome) ----
$whyCards = [
    ['stat' => '15+ yrs', 'sub' => 'average centre experience', 'title' => 'Trainers who still build', 'desc' => 'Every instructor is a practising engineer or marketer. You learn current tooling and the judgement calls that come with it — not a syllabus written five years ago.'],
    ['stat' => '4+', 'sub' => 'portfolio projects per track', 'title' => 'Live projects, not exercises', 'desc' => 'From week three you work on project code with requirements, reviews and deadlines. That is what fills a portfolio and what interviewers ask about.'],
    ['stat' => '450+', 'sub' => 'hiring partners', 'title' => 'Placement machinery that runs', 'desc' => 'A dedicated cell handles resumes, mock interviews and a hiring-partner network across Mohali, Chandigarh and beyond. Support continues until you are placed.'],
    ['stat' => '98%', 'sub' => 'course completion rate', 'title' => 'Sessions built around your life', 'desc' => 'Morning, evening, weekend and online sessions, all recorded. Students, working professionals and career-changers train in the same programme on their own schedule.'],
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
      <span class="text-white/80">About</span>
    </nav>
   
<div>
    <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/30 bg-black/20 px-3.5 py-1.5 text-[0.7rem] font-semibold uppercase tracking-[0.16em] text-white">
        <span class="h-1.5 w-1.5 rounded-full bg-yellow-400"></span>
        A skill-building ecosystem
    </p>

    <h1 class="max-w-4xl font-display text-4xl font-extrabold leading-[1.08] text-white drop-shadow-[0_2px_10px_rgba(0,0,0,0.5)] sm:text-5xl lg:text-[3.6rem]">
        A skill-building ecosystem
    </h1>


<p class="mt-6 max-w-2xl text-[1.05rem] font-semibold leading-relaxed text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)] sm:text-lg">
    Techno Coderz is a skill-building ecosystem built to help students, graduates, and career-changers turn knowledge into job-ready skills through hands-on training, live projects, and industry-aligned learning.
</p>

</div>

</section>

<!-- ============ 2. STATS BAND ============ -->
<section class="relative z-10 -mt-14 lg:-mt-16">
  <div class="container-x">
    <div class="relative grid overflow-hidden rounded-3xl border border-line bg-white shadow-[0_28px_60px_-28px_rgba(122,50,0,0.4)] sm:grid-cols-2 lg:grid-cols-4">
      <?php foreach ($stats as $st): ?>
      <div class="group relative border-line px-7 py-8 transition-colors hover:bg-subtle sm:[&:nth-child(odd)]:border-r lg:border-r lg:last:border-r-0">
        <span class="absolute inset-x-0 top-0 h-0.5 origin-left scale-x-0 bg-gradient-to-r from-hero-600 to-accent-glow transition-transform duration-500 group-hover:scale-x-100"></span>
        <span class="mb-4 grid h-11 w-11 place-items-center rounded-xl bg-brand-50 text-up-accent transition-colors group-hover:bg-up-accent group-hover:text-white"><svg viewBox="0 0 24 24" width="21" height="21" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?= $st['icon'] ?></svg></span>
        <p class="font-display text-3xl font-extrabold text-up-ink lg:text-4xl"><span data-count="<?= (int) $st['v'] ?>">0</span><span class="text-up-accent"><?= e($st['suffix']) ?></span></p>
        <p class="mt-1.5 text-sm text-up-muted"><?= e($st['label']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ 3. WHO WE ARE ============ -->
<section class="py-16 lg:py-24">
  <div class="container-x grid gap-14 lg:grid-cols-[1.1fr_1fr] lg:items-start lg:gap-20">
    <div>
      <p data-anim="fade" class="text-xs font-bold uppercase tracking-[0.16em] text-up-accent">Who we are</p>
      <h2 data-anim="words" class="mt-4 font-display text-3xl font-extrabold leading-[1.12] text-up-ink sm:text-4xl lg:text-[2.75rem]">Empowering Skills. Enabling Careers. <span class="text-up-accent">Building the Future.</span></h2>
      <div data-anim="up" data-anim-delay="0.1" class="mt-7 space-y-5 text-sm leading-relaxed text-up-muted lg:text-[15px]">
        <p>Founded in 2016, <strong class="font-bold text-up-ink">Techno Coderz</strong> is an IT training and skill-development organization focused on bridging the gap between academic learning and evolving industry requirements. We combine practical exposure, emerging technologies, project-based learning and career-oriented training so learners develop relevant skills and the confidence to use them.</p>
        <p>From Artificial Intelligence, Data Science, Machine Learning, Cyber Security and Cloud Computing to Full Stack Development, MERN Stack, Python, Web Development, Mobile App Development, Digital Marketing, Graphic Designing, UI/UX, Animation, Video Editing and CAD/CAM, we give learners real pathways into the digital economy.</p>
      </div>
      <div data-anim="up" data-anim-delay="0.15" class="mt-8">
        <p class="text-sm font-bold text-up-ink">What we teach</p>
        <p class="mt-1.5 text-sm leading-relaxed text-up-muted">From Artificial Intelligence to CAD/CAM and other technology-focused disciplines, we teach skills for the evolving digital economy.</p>
        <div class="mt-5 flex flex-wrap gap-2.5">
          <?php foreach ($teachChips as $chip): ?>
          <span class="rounded-full border border-line bg-white px-4 py-2 text-sm font-medium text-up-ink/80"><?= e($chip) ?></span>
          <?php endforeach; ?>
        </div>
      </div>
      <p class="mt-8 border-t border-line pt-6 text-sm text-up-muted">Headquartered in Mohali, Punjab. <span class="font-semibold text-up-ink">Team Techno Coderz</span></p>
    </div>
    <div data-anim="right" class="grid grid-cols-2 gap-4">
      <figure class="relative col-span-2 aspect-[16/9] overflow-hidden rounded-2xl bg-subtle"><img src="<?= SITE_URL ?>/assets/images/institute/success-1.jpg" alt="Techno Coderz classroom in Mohali" class="h-full w-full object-cover" loading="lazy"></figure>
      <figure class="relative aspect-square overflow-hidden rounded-2xl bg-subtle"><img src="<?= SITE_URL ?>/assets/images/institute/success-3.jpg" alt="Students working on live projects" class="h-full w-full object-cover" loading="lazy"></figure>
      <figure class="relative aspect-square overflow-hidden rounded-2xl bg-subtle"><img src="<?= SITE_URL ?>/assets/images/institute/success-5.jpeg" alt="Placement drive at Techno Coderz" class="h-full w-full object-cover" loading="lazy"></figure>
    </div>
  </div>
</section>

<!-- ============ 4. SKILL-BUILDING ECOSYSTEM ============ -->
<section class="relative overflow-hidden bg-hero-950 py-16 text-white lg:py-24">
  <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_80%_70%_at_10%_20%,#3a2410_0%,transparent_60%)]"></div>
  <div class="pointer-events-none absolute inset-0 grid-lines opacity-50"></div>
  <div class="glow-blob right-[6%] top-[8%] h-[320px] w-[320px] bg-accent-glow/15"></div>
  <div class="container-x relative grid items-center gap-14 lg:grid-cols-2 lg:gap-20">
    <div>
      <p data-anim="fade" class="text-xs font-bold uppercase tracking-[0.16em] text-accent-glow">More than training</p>

<h2 data-anim="words" class="mt-4 max-w-4xl font-display text-3xl font-extrabold leading-[1.08] text-white drop-shadow-[0_2px_10px_rgba(0,0,0,0.5)] sm:text-4xl lg:text-[3rem]">
    A skill-building ecosystem.
</h2>

      <div data-anim="up" data-anim-delay="0.1" class="mt-7 space-y-5 text-[1.05rem] leading-relaxed text-up-soft/90">
        <p>At Techno Coderz, technology education is designed to go beyond textbooks and conventional classroom learning. The focus is on helping learners learn, implement and grow — combining conceptual understanding with practical application.</p>
        <p>Students work on assignments, live projects, industrial training and internship-oriented experiences that show how technology is applied in real environments — across mobile development, cloud computing, AI/ML, DevOps and data.</p>
      </div>
    </div>
    <div data-anim="right" class="grid grid-cols-2 gap-4">
      <figure class="relative aspect-[3/4] overflow-hidden rounded-2xl bg-white/5 ring-1 ring-white/10"><img src="<?= SITE_URL ?>/assets/images/institute/success-2.jpg" alt="Hands-on lab session" class="h-full w-full object-cover" loading="lazy"></figure>
      <figure class="relative mt-10 aspect-[3/4] overflow-hidden rounded-2xl bg-white/5 ring-1 ring-white/10"><img src="<?= SITE_URL ?>/assets/images/institute/success-4.jpeg" alt="Mentor guiding a student" class="h-full w-full object-cover" loading="lazy"></figure>
    </div>
  </div>
</section>

<!-- ============ 5. TECHNOLOGY DOMAINS ============ -->
<section class="py-16 lg:py-24">
  <div class="container-x">
    <div class="max-w-3xl">
      <div data-anim="fade" class="mb-4 inline-flex items-center gap-2 rounded-full border px-3.5 py-1.5 text-[0.7rem] font-semibold uppercase tracking-[0.16em] border-up-line bg-brand-50 text-up-accent"><span class="h-1.5 w-1.5 rounded-full bg-up-accent"></span>What you can learn</div>
      <h2 data-anim="words" class="text-3xl font-extrabold leading-[1.1] sm:text-4xl lg:text-[2.9rem] text-up-ink">Building skills across technology domains</h2>
      <div data-underline class="mt-5 h-[3px] w-24 rounded-full bg-gradient-to-r from-up-accent to-transparent"></div>
      <p data-anim="up" data-anim-delay="0.1" class="mt-5 text-base leading-relaxed sm:text-lg text-up-muted">Whether a learner wants to code an application, analyse data, build an AI solution, secure a network, manage cloud infrastructure, design a digital experience, create visual content or grow a business online, Techno Coderz provides multiple learning pathways.</p>
    </div>
    <div data-anim="up" data-anim-delay="0.15" class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
      <?php foreach ($domains as $d): $hot = !empty($d['hot']); ?>
      <div class="rounded-2xl border bg-white p-6 <?= $hot ? 'border-up-accent/50 ring-1 ring-up-accent/20' : 'border-line' ?>">
        <h3 class="text-base font-bold text-up-ink"><?= e($d['title']) ?></h3>
        <span aria-hidden="true" class="mt-2.5 block h-0.5 w-6 rounded-full bg-gradient-to-r from-up-accent to-accent-glow"></span>
        <ul class="mt-4 space-y-2">
          <?php foreach ($d['items'] as $it): ?>
          <li class="flex items-start gap-2 text-sm text-up-muted"><span aria-hidden="true" class="mt-2 h-1 w-1 shrink-0 rounded-full bg-up-accent"></span><?= e($it) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ 6. JOURNEY TIMELINE ============ -->
<section class="relative overflow-hidden bg-hero-950 py-16 text-white lg:py-24">
  <div class="pointer-events-none absolute inset-0 grid-lines opacity-40"></div>
  <div aria-hidden="true" class="pointer-events-none absolute -left-1/4 -top-1/3 h-[140%] w-[70%] -rotate-12 bg-gradient-to-br from-brand-600/25 via-brand-700/10 to-transparent blur-[120px]"></div>
  <div aria-hidden="true" class="pointer-events-none absolute -bottom-1/3 -right-1/4 h-[120%] w-[55%] -rotate-12 bg-gradient-to-tl from-accent-glow/20 to-transparent blur-[120px]"></div>
  <div class="container-x relative">
    <div class="mx-auto max-w-2xl text-center">
      <p data-anim="fade" class="text-xs font-bold uppercase tracking-[0.16em] text-accent-glow">Our journey</p>

<h2 data-anim="words" class="mt-3 max-w-4xl font-display text-3xl font-extrabold leading-[1.08] text-white drop-shadow-[0_2px_10px_rgba(0,0,0,0.5)] sm:text-4xl lg:text-[3rem]">
    A decade of building careers
</h2>

      <p data-anim="up" data-anim-delay="0.1" class="mx-auto mt-4 text-sm leading-relaxed text-white/65 lg:text-base">What began in 2016 has evolved into a technology-focused training ecosystem with an expanding portfolio of courses and practical learning initiatives — moving towards AI, automation, cloud, cybersecurity, data and modern software development.</p>
    </div>
    <div class="relative mt-16">
      <span aria-hidden="true" class="absolute inset-y-0 left-[7px] w-px bg-white/15 sm:left-1/2"></span>
      <ol class="space-y-12 lg:space-y-14">
        <?php foreach ($journey as $i => $j): $right = ($i % 2) === 1; ?>
        <li class="relative pl-9 sm:grid sm:grid-cols-2 sm:items-center sm:gap-x-12 sm:pl-0">
          <span aria-hidden="true" class="absolute left-1 top-1/2 size-2.5 -translate-y-1/2 rounded-full bg-accent-glow ring-4 ring-accent-glow/25 sm:left-1/2 sm:-translate-x-1/2"></span>
          <span aria-hidden="true" class="absolute top-1/2 hidden h-px w-6 -translate-y-1/2 bg-white/15 sm:block <?= $right ? 'left-1/2' : 'right-1/2' ?>"></span>
          <div class="flex items-center gap-4 <?= $right ? 'sm:col-start-2' : 'sm:col-start-1 sm:flex-row-reverse sm:text-right' ?>">
            <div class="w-14 shrink-0 overflow-hidden rounded-xl border border-white/15 bg-white/5 text-center backdrop-blur-sm">
              <div class="bg-up-accent py-0.5 font-mono text-[10px] tracking-widest text-white"><?= e(substr($j['year'], 0, 2)) ?></div>
              <div class="py-1.5 font-display text-xl font-bold leading-none text-white"><?= e(substr($j['year'], 2)) ?></div>
            </div>
            <div class="min-w-0">
              <h3 class="font-display text-sm font-bold lg:text-[15px]"><?= e($j['year']) ?>: <?= e($j['title']) ?></h3>
              <p class="mt-1 text-xs leading-relaxed text-white/60"><?= e($j['text']) ?></p>
            </div>
          </div>
        </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>

<!-- ============ 7. FOUNDER / LEADERSHIP ============ -->
<section id="founder" class="scroll-mt-32 bg-subtle py-16 lg:py-24">
  <div class="container-x">
    <div class="mx-auto max-w-3xl text-center">
      <div data-anim="fade" class="mb-4 inline-flex items-center gap-2 rounded-full border px-3.5 py-1.5 text-[0.7rem] font-semibold uppercase tracking-[0.16em] border-up-line bg-brand-50 text-up-accent"><span class="h-1.5 w-1.5 rounded-full bg-up-accent"></span>Leadership</div>
      <h2 data-anim="words" class="text-3xl font-extrabold leading-[1.1] sm:text-4xl lg:text-[2.9rem] text-up-ink">The people behind Techno Coderz</h2>
      <div data-underline class="mx-auto mt-5 h-[3px] w-24 rounded-full bg-gradient-to-r from-up-accent to-transparent"></div>
      <p data-anim="up" data-anim-delay="0.1" class="mt-5 text-base leading-relaxed sm:text-lg text-up-muted">One classroom in Mohali in 2016, now a multi-branch training network across Punjab — built by a team that still teaches.</p>
    </div>
    <div data-anim="up" class="mx-auto mt-14 max-w-4xl">
      <div class="rounded-[1.75rem] border border-line bg-white p-8 lg:p-12">
        <div class="flex flex-col items-center gap-6 sm:flex-row sm:items-start">
          <img src="<?= SITE_URL ?>/assets/images/team/rakesh.jpg" alt="Mr. Rakesh Raai, Founder & CEO of Techno Coderz" class="h-20 w-20 shrink-0 rounded-3xl object-cover shadow-lg shadow-hero-600/25" loading="lazy">
          <div class="text-center sm:text-left">
            <h3 class="font-display text-2xl font-extrabold text-up-ink">Mr. Rakesh Raai</h3>
            <p class="mt-1 text-sm font-semibold uppercase tracking-[0.14em] text-up-accent">Founder &amp; CEO, Techno Coderz</p>
            <p class="mt-5 text-sm leading-relaxed text-up-muted">He started Techno Coderz in 2016 to give young people in Punjab technology skills and the confidence to use them. The method has not changed since that first classroom: practising engineers as trainers, project work instead of slide decks, and a curriculum rewritten whenever the industry moves — which is how AI, cloud and cyber security joined the syllabus.</p>
            <blockquote class="mt-6 border-l-2 border-up-accent pl-4 text-sm font-medium italic text-up-ink">“The future belongs to learners who continuously adapt, innovate and build.”</blockquote>
          </div>
        </div>
        <div class="mt-8 grid gap-4 border-t border-line pt-8 sm:grid-cols-3">
          <?php
          $traits = [
              ['p' => 'Practitioner-led', 's' => 'Every trainer still builds for a living.'],
              ['p' => 'Industry-aligned', 's' => 'Curriculum reviewed against live hiring briefs.'],
              ['p' => 'Career-integrated', 's' => 'Placement support is part of the course, not an add-on.'],
          ];
          foreach ($traits as $t): ?>
          <div class="rounded-2xl border border-line bg-subtle p-4">
            <p class="text-sm font-bold text-up-ink"><?= e($t['p']) ?></p>
            <p class="mt-1 text-xs leading-relaxed text-up-muted"><?= e($t['s']) ?></p>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ 8. FOUR RULES (VALUES) ============ -->
<section id="values" class="relative scroll-mt-32 overflow-hidden bg-hero-950 py-16 text-white lg:py-24">
  <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_65%_50%_at_50%_-5%,rgba(194,65,12,0.28),transparent_70%)]"></div>
  <div class="pointer-events-none absolute inset-0 grid-lines opacity-40"></div>
  <div class="container-x relative">
    <div class="mx-auto max-w-3xl text-center">
      <p data-anim="fade" class="text-xs font-bold uppercase tracking-[0.16em] text-accent-glow">How we work</p>
      
<h2 data-anim="words" class="mt-4 max-w-4xl font-display text-3xl font-extrabold leading-[1.08] text-white drop-shadow-[0_2px_10px_rgba(0,0,0,0.5)] sm:text-4xl lg:text-[2.6rem]">
    Four rules we do not bend
</h2>

      <div data-underline class="mx-auto mt-5 h-[3px] w-24 rounded-full bg-gradient-to-r from-accent-glow to-transparent"></div>
      <p data-anim="up" data-anim-delay="0.1" class="mt-5 text-sm leading-relaxed text-up-soft/80 lg:text-base">They sound obvious. Keeping them when a session is full and a deadline is close is the actual work.</p>
    </div>
    <div class="mt-14 grid gap-6 lg:grid-cols-2">
      <?php foreach ($rules as $r): ?>
      <div class="card-hover glass-dark glass-sheen group relative overflow-hidden rounded-3xl p-8 lg:p-10">
        <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-hero-glow/20 blur-xl transition-transform duration-700 group-hover:scale-[2.2]"></div>
        <div class="relative flex items-start gap-6">
          <div class="w-20 shrink-0 rounded-2xl bg-gradient-to-br from-hero-600 to-hero-glow px-3 py-3.5 text-center text-white shadow-lg shadow-hero-600/25">
            <p class="font-display text-xl font-extrabold leading-none"><?= e($r['n']) ?></p>
          </div>
          <div>
            <h3 class="text-xl font-bold text-white"><?= e($r['title']) ?></h3>
            <p class="mt-3 text-sm leading-relaxed text-up-soft/70"><?= e($r['text']) ?></p>
            <div class="mt-4 flex flex-wrap gap-2">
              <?php foreach ($r['tags'] as $tag): ?>
              <span class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-[0.7rem] font-medium text-up-soft/80"><?= e($tag) ?></span>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="glass-dark relative mt-8 overflow-hidden rounded-3xl p-8 lg:p-10">
      <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
        <div class="max-w-sm">
          <p class="text-xs font-bold uppercase tracking-[0.16em] text-accent-glow">What we protect</p>
          <p class="mt-2 font-display text-xl font-bold text-white">No add-ons, no separate fee</p>
        </div>
        <ul class="flex flex-wrap gap-x-6 gap-y-3">
          <?php foreach ($included as $inc): ?>
          <li class="flex items-center gap-2 text-sm text-up-soft/80"><span aria-hidden="true" class="h-1.5 w-1.5 rounded-full bg-accent-glow"></span><?= e($inc) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ============ 9. CAMPUS ============ -->
<section id="campus" class="scroll-mt-32 py-16 lg:py-24">
  <div class="container-x">
    <div class="grid items-center gap-14 lg:grid-cols-2 lg:gap-20">
      <div data-anim="left" class="relative overflow-hidden rounded-[1.75rem] bg-hero-950 p-10 text-white">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_right,rgba(255,107,0,0.5)_0%,transparent_65%)]"></div>
        <div class="absolute inset-0 grid-lines opacity-60"></div>
        <div class="relative">
          <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="text-accent-glow"><path d="M12 21s7-5.5 7-11a7 7 0 1 0-14 0c0 5.5 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/></svg>
          <h3 class="mt-5 font-display text-2xl font-extrabold">The Mohali campus</h3>
          <p class="mt-4 text-sm leading-relaxed text-up-soft/80"><?= e($address) ?>. Modern lab rooms, open six days a week, with practice machines available outside class hours.</p>
          <a href="https://www.google.com/maps/search/?api=1&amp;query=<?= $mapQuery ?>" target="_blank" rel="noreferrer" class="group mt-7 inline-flex items-center gap-2 rounded-full border border-white/20 px-6 py-3 text-sm font-semibold text-white transition-colors hover:bg-white/5">Open in Google Maps<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform group-hover:translate-x-0.5"><path d="M7 17 17 7M9 7h8v8"/></svg></a>
        </div>
      </div>
      <div>
        <div class="max-w-3xl">
          <div data-anim="fade" class="mb-4 inline-flex items-center gap-2 rounded-full border px-3.5 py-1.5 text-[0.7rem] font-semibold uppercase tracking-[0.16em] border-up-line bg-brand-50 text-up-accent"><span class="h-1.5 w-1.5 rounded-full bg-up-accent"></span>Facilities</div>
          <h2 data-anim="words" class="text-3xl font-extrabold leading-[1.1] sm:text-4xl lg:text-[2.9rem] text-up-ink">Everything you need is on site</h2>
          <div data-underline class="mt-5 h-[3px] w-24 rounded-full bg-gradient-to-r from-up-accent to-transparent"></div>
          <p data-anim="up" data-anim-delay="0.1" class="mt-5 text-base leading-relaxed sm:text-lg text-up-muted">Classrooms are labs. You are on a machine from the first session, not taking notes about one.</p>
        </div>
        <ul data-anim="up" data-anim-delay="0.15" class="mt-8 grid gap-3 sm:grid-cols-2">
          <?php foreach ($facilities as $f): ?>
          <li class="flex items-center gap-3 rounded-2xl border border-line bg-white p-4 text-sm font-medium text-up-ink">
            <span class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-brand-50 text-up-accent"><svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m8.4 12.2 2.5 2.5 4.7-5.2"/></svg></span><?= e($f) ?>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ============ 10. THREE THINGS WORTH READING NEXT ============ -->
<section class="bg-subtle py-16 lg:py-24">
  <div class="container-x">
    <div class="mx-auto max-w-3xl text-center">
      <div data-anim="fade" class="mb-4 inline-flex items-center gap-2 rounded-full border px-3.5 py-1.5 text-[0.7rem] font-semibold uppercase tracking-[0.16em] border-up-line bg-brand-50 text-up-accent"><span class="h-1.5 w-1.5 rounded-full bg-up-accent"></span>More about Techno Coderz</div>
      <h2 data-anim="words" class="text-3xl font-extrabold leading-[1.1] sm:text-4xl lg:text-[2.9rem] text-up-ink">Three things worth reading next</h2>
      <div data-underline class="mx-auto mt-5 h-[3px] w-24 rounded-full bg-gradient-to-r from-up-accent to-transparent"></div>
      <p data-anim="up" data-anim-delay="0.1" class="mt-5 text-base leading-relaxed sm:text-lg text-up-muted">Where we are headed, what the certificate stands for, and the people who started it.</p>
    </div>
    <div data-anim="up" data-anim-delay="0.15" class="mt-14 grid gap-6 sm:grid-cols-3">
      <?php
      $readNext = [
          ['tag' => 'Purpose', 'title' => 'Mission & Vision', 'desc' => 'What we are aiming at, and the four things it commits us to daily.', 'href' => 'mission-vision.php', 'icon' => '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="4"/><circle cx="12" cy="12" r="0.6"/>'],
          ['tag' => 'Proof', 'title' => 'Accreditations & Awards', 'desc' => 'ISO-certified training, documented internship letters, and a 450+ partner network.', 'href' => '#campus', 'icon' => '<circle cx="12" cy="9" r="5.5"/><path d="m8.5 13.5-1 7 4.5-2.5 4.5 2.5-1-7"/>'],
          ['tag' => 'Profile', 'title' => 'Founder & Team', 'desc' => 'The people behind Techno Coderz — why we started, and what has not changed since.', 'href' => 'founder.php', 'icon' => '<circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/>'],
      ];
      foreach ($readNext as $r): ?>
      <a href="<?= e($r['href']) ?>" class="card-hover group rounded-3xl border border-line bg-white p-8">
        <span class="grid h-12 w-12 place-items-center rounded-2xl bg-brand-50 text-up-accent transition-colors group-hover:bg-up-accent group-hover:text-white"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?= $r['icon'] ?></svg></span>
        <p class="mt-6 text-[0.66rem] font-bold uppercase tracking-[0.16em] text-up-muted/80"><?= e($r['tag']) ?></p>
        <h3 class="mt-1.5 text-lg font-bold text-up-ink transition-colors group-hover:text-up-accent"><?= e($r['title']) ?></h3>
        <p class="mt-2.5 text-sm leading-relaxed text-up-muted"><?= e($r['desc']) ?></p>
        <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-up-accent">Read more<svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform duration-300 group-hover:translate-x-1.5"><path d="M4 12h16M14 6l6 6-6 6"/></svg></span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ 11. WHY (FOUR THINGS THAT CHANGE THE OUTCOME) ============ -->
<section id="why" class="relative scroll-mt-32 overflow-hidden bg-hero-950 py-16 text-white lg:py-24">
  <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_60%_50%_at_75%_25%,rgba(194,65,12,0.35),transparent_68%)]"></div>
  <div class="pointer-events-none absolute inset-0 grid-lines opacity-40"></div>
  <div class="container-x relative">
    <div class="mx-auto max-w-3xl text-center">
      <div data-anim="fade" class="mb-4 inline-flex items-center gap-2 rounded-full border px-3.5 py-1.5 text-[0.7rem] font-semibold uppercase tracking-[0.16em] border-white/15 bg-white/5 text-up-soft"><span class="h-1.5 w-1.5 rounded-full bg-accent-glow"></span>Why Techno Coderz Mohali</div>
      <h2 data-anim="words" class="text-3xl font-extrabold leading-[1.1] sm:text-4xl lg:text-[2.9rem] text-white">Four things that change the outcome</h2>
      <div data-underline class="mx-auto mt-5 h-[3px] w-24 rounded-full bg-gradient-to-r from-accent-glow to-transparent"></div>
      <p data-anim="up" data-anim-delay="0.1" class="mt-5 text-base leading-relaxed sm:text-lg text-up-soft/80">Any training centre can list a syllabus. These are the parts that decide whether you actually land a job.</p>
    </div>
    <div data-anim="up" data-anim-delay="0.15" class="mt-14 grid gap-6 lg:grid-cols-2">
      <?php foreach ($whyCards as $w): ?>
      <div class="card-hover glass-dark glass-sheen group relative overflow-hidden rounded-3xl p-8 lg:p-10">
        <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-hero-glow/20 blur-xl transition-transform duration-700 group-hover:scale-[2.2]"></div>
        <div class="relative flex items-start gap-6">
          <div class="w-28 shrink-0 rounded-2xl bg-gradient-to-br from-hero-600 to-hero-glow px-3 py-3.5 text-center text-white shadow-lg shadow-hero-600/25">
            <p class="font-display text-xl font-extrabold leading-none"><?= e($w['stat']) ?></p>
            <p class="mt-1 text-[0.55rem] font-medium uppercase leading-tight tracking-wider text-white/70"><?= e($w['sub']) ?></p>
          </div>
          <div>
            <h3 class="text-xl font-bold text-white"><?= e($w['title']) ?></h3>
            <p class="mt-3 text-sm leading-relaxed text-up-soft/70"><?= e($w['desc']) ?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="glass-dark relative mt-8 overflow-hidden rounded-3xl p-8 lg:p-10">
      <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
        <div class="max-w-sm">
          <p class="text-xs font-bold uppercase tracking-[0.16em] text-accent-glow">Included with every course</p>
          <p class="mt-2 font-display text-xl font-bold text-white">No add-ons, no separate fee</p>
        </div>
        <ul class="flex flex-wrap gap-x-6 gap-y-3">
          <?php foreach ($included as $inc): ?>
          <li class="flex items-center gap-2 text-sm text-up-soft/80"><span aria-hidden="true" class="h-1.5 w-1.5 rounded-full bg-accent-glow"></span><?= e($inc) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ============ 12. REVIEWS MARQUEE ============ -->
<section id="reviews" class="relative scroll-mt-32 overflow-hidden bg-gradient-to-b from-white via-subtle to-white py-16 lg:py-24">
  <div class="pointer-events-none absolute inset-0">
    <div class="glow-blob left-[6%] top-[18%] h-[24rem] w-[24rem] bg-brand-300/45"></div>
    <div class="glow-blob bottom-[10%] right-[8%] h-[22rem] w-[22rem] bg-accent-400/35"></div>
  </div>
  <div class="container-x relative">
    <div class="mx-auto max-w-3xl text-center">
      <div data-anim="fade" class="mb-4 inline-flex items-center gap-2 rounded-full border px-3.5 py-1.5 text-[0.7rem] font-semibold uppercase tracking-[0.16em] border-up-line bg-brand-50 text-up-accent"><span class="h-1.5 w-1.5 rounded-full bg-up-accent"></span>Student stories</div>
      <h2 data-anim="words" class="text-3xl font-extrabold leading-[1.1] sm:text-4xl lg:text-[2.9rem] text-up-ink"><?= e($avgRating) ?> out of 5, across <span class="text-up-accent">556+ reviews</span></h2>
      <div data-underline class="mx-auto mt-5 h-[3px] w-24 rounded-full bg-gradient-to-r from-up-accent to-transparent"></div>
      <p data-anim="up" data-anim-delay="0.1" class="mt-5 text-base leading-relaxed sm:text-lg text-up-muted">The sessions change every few months. What students say about the trainers and the project work does not.</p>
    </div>
    <div data-anim="up" data-anim-delay="0.15" class="mt-9 flex justify-center">
      <a href="https://www.google.com/search?q=Techno+Coderz+Mohali+reviews" target="_blank" rel="noreferrer" class="glass glass-sheen group relative inline-flex items-center gap-4 rounded-full py-2.5 pl-5 pr-3 transition-transform duration-300 hover:-translate-y-0.5">
        <span class="relative flex items-center gap-2.5">
          <svg viewBox="0 0 24 24" width="22" height="22" role="img"><title>Google</title><path fill="#4285F4" d="M21.6 12.23c0-.75-.07-1.47-.19-2.16H12v4.09h5.38a4.6 4.6 0 0 1-2 3.02v2.5h3.24c1.89-1.74 2.98-4.3 2.98-7.45Z"/><path fill="#34A853" d="M12 22c2.7 0 4.96-.9 6.62-2.42l-3.24-2.5c-.9.6-2.05.96-3.38.96-2.6 0-4.8-1.76-5.59-4.12H3.06v2.58A10 10 0 0 0 12 22Z"/><path fill="#FBBC05" d="M6.41 13.92a6 6 0 0 1 0-3.84V7.5H3.06a10 10 0 0 0 0 9l3.35-2.58Z"/><path fill="#EA4335" d="M12 5.96c1.47 0 2.78.5 3.82 1.5l2.87-2.87C16.95 2.99 14.7 2 12 2A10 10 0 0 0 3.06 7.5l3.35 2.58C7.2 7.72 9.4 5.96 12 5.96Z"/></svg>
          <span class="text-left"><span class="block text-sm font-bold text-up-ink">Google Reviews</span><span class="block text-[0.72rem] text-up-muted">Techno Coderz Mohali · <?= e($avgRating) ?> ★</span></span>
        </span>
        <span class="grid h-9 w-9 place-items-center rounded-full bg-up-accent text-white transition-transform group-hover:translate-x-0.5"><svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M9 7h8v8"/></svg></span>
      </a>
    </div>
  </div>
  <?php
  $reviews = $testimonials ?: [
      ['name' => 'Rahul Sharma', 'designation' => 'Full Stack Developer', 'rating' => 5, 'message' => 'The live project work changed everything for me — I had real code to talk about in interviews instead of just a syllabus.'],
      ['name' => 'Priya Nair', 'designation' => 'Data Analyst', 'rating' => 5, 'message' => 'The trainers actually work in the field, so every session had context from real projects.'],
      ['name' => 'Amit Patel', 'designation' => 'Cloud Engineer', 'rating' => 5, 'message' => 'Deploying a full pipeline gave me something genuinely impressive for my portfolio.'],
  ];
  function about_review_card($t) {
      $name = trim($t['name'] ?? 'Student');
      $initials = strtoupper(substr($name, 0, 1) . (strpos($name, ' ') !== false ? substr($name, strpos($name, ' ') + 1, 1) : ''));
      $stars = max(1, min(5, (int) ($t['rating'] ?? 5)));
      $out  = '<figure class="glass glass-sheen relative mr-6 w-[21rem] shrink-0 rounded-3xl p-7 sm:w-[24rem]">';
      $out .= '<div class="relative flex items-center justify-between">';
      $out .= '<div class="flex items-center gap-2.5"><span class="grid h-9 w-9 place-items-center rounded-full bg-gradient-to-br from-hero-600 to-hero-glow font-display text-xs font-extrabold text-white">' . htmlspecialchars($initials, ENT_QUOTES) . '</span>';
      $out .= '<div><p class="text-sm font-bold text-up-ink">' . htmlspecialchars($name, ENT_QUOTES) . '</p><p class="text-[0.72rem] text-up-muted">' . htmlspecialchars($t['designation'] ?? '', ENT_QUOTES) . '</p></div></div>';
      $out .= '<svg viewBox="0 0 24 24" width="16" height="16" role="img" aria-label="Google"><path fill="#4285F4" d="M21.6 12.23c0-.75-.07-1.47-.19-2.16H12v4.09h5.38a4.6 4.6 0 0 1-2 3.02v2.5h3.24c1.89-1.74 2.98-4.3 2.98-7.45Z"/><path fill="#34A853" d="M12 22c2.7 0 4.96-.9 6.62-2.42l-3.24-2.5c-.9.6-2.05.96-3.38.96-2.6 0-4.8-1.76-5.59-4.12H3.06v2.58A10 10 0 0 0 12 22Z"/><path fill="#FBBC05" d="M6.41 13.92a6 6 0 0 1 0-3.84V7.5H3.06a10 10 0 0 0 0 9l3.35-2.58Z"/><path fill="#EA4335" d="M12 5.96c1.47 0 2.78.5 3.82 1.5l2.87-2.87C16.95 2.99 14.7 2 12 2A10 10 0 0 0 3.06 7.5l3.35 2.58C7.2 7.72 9.4 5.96 12 5.96Z"/></svg>';
      $out .= '</div>';
      $out .= '<div class="relative mt-3 flex gap-0.5 text-up-gold">' . str_repeat('<svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor" aria-hidden="true"><path d="m12 3 2.6 5.6 6.1.8-4.5 4.2 1.2 6-5.4-3-5.4 3 1.2-6L3.3 9.4l6.1-.8L12 3Z"/></svg>', $stars) . '</div>';
      $out .= '<p class="relative mt-3 text-sm leading-relaxed text-up-muted">' . htmlspecialchars($t['message'] ?? '', ENT_QUOTES) . '</p>';
      $out .= '</figure>';
      return $out;
  }
  $rowA = array_slice($reviews, 0, max(1, (int) ceil(count($reviews) / 2)));
  $rowB = array_slice($reviews, count($rowA));
  if (!$rowB) $rowB = $reviews;
  ?>
  <div class="relative mt-14 space-y-6">
    <div class="pointer-events-none absolute inset-y-0 left-0 z-10 w-24 bg-gradient-to-r from-subtle to-transparent sm:w-40"></div>
    <div class="pointer-events-none absolute inset-y-0 right-0 z-10 w-24 bg-gradient-to-l from-subtle to-transparent sm:w-40"></div>
    <div class="tcm-marquee group flex overflow-hidden">
      <div class="tcm-track" style="animation-duration:50s">
        <?php for ($k = 0; $k < 2; $k++) { foreach ($rowA as $t) echo about_review_card($t); } ?>
      </div>
    </div>
    <div class="tcm-marquee group flex overflow-hidden">
      <div class="tcm-track" style="animation-duration:58s;animation-direction:reverse">
        <?php for ($k = 0; $k < 2; $k++) { foreach ($rowB as $t) echo about_review_card($t); } ?>
      </div>
    </div>
  </div>
</section>

<!-- ============ 13. WHERE TO GO NEXT ============ -->
<section class="border-t border-line bg-subtle py-16 lg:py-24" aria-labelledby="related-heading">
  <div class="container-x">
    <p class="text-xs font-bold uppercase tracking-[0.16em] text-up-accent">Keep exploring</p>
    <h2 id="related-heading" data-anim="words" class="mt-3 font-display text-2xl font-extrabold text-up-ink sm:text-3xl">Where to go next</h2>
    <div data-underline class="mt-4 h-[3px] w-20 rounded-full bg-gradient-to-r from-up-accent to-transparent"></div>
    <div data-anim="up" data-anim-delay="0.1" class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
      <?php
      $nextSteps = [
          ['title' => 'Accreditations & awards', 'desc' => 'ISO-certified training, documented internship letters, university-compliant programmes and the recognitions behind them.', 'cta' => 'See the paperwork', 'href' => '#campus', 'icon' => '<path d="m12 2.6 2.5 1.9 3.1-.2.9 3 2.5 1.9-1.2 2.9 1.2 2.9-2.5 1.9-.9 3-3.1-.2L12 21.4l-2.5-1.9-3.1.2-.9-3L3 14.8l1.2-2.9L3 9l2.5-1.9.9-3 3.1.2L12 2.6Z"/><path d="m8.8 12.1 2.1 2.1 4.3-4.6"/>'],
          ['title' => 'Student reviews', 'desc' => 'Google reviews from Techno Coderz students on the trainers, the live projects and the placement support, across every track.', 'cta' => 'Read the reviews', 'href' => '#reviews', 'icon' => '<path d="m12 3 2.6 5.6 6.1.8-4.5 4.2 1.2 6-5.4-3-5.4 3 1.2-6L3.3 9.4l6.1-.8L12 3Z"/>'],
          ['title' => 'Best IT training Mohali', 'desc' => 'Why Techno Coderz is among the top-rated IT training centres in Mohali — 1:1 sessions, live projects, 15+ years and 98% placement success.', 'cta' => 'See why we are #1', 'href' => 'courses.php', 'icon' => '<path d="M4 20V10M10 20V4M16 20v-7M22 20H2"/>'],
      ];
      foreach ($nextSteps as $n): ?>
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

<!-- ============ 14. CTA ============ -->
<section class="relative overflow-hidden bg-subtle py-16 lg:py-24">
  <div class="pointer-events-none absolute right-[6%] top-1/2 h-16 w-16 -translate-y-1/2 rounded-full border border-up-line"></div>
  <div class="pointer-events-none absolute left-[7%] top-[22%] h-10 w-10 rounded-full border border-up-line"></div>
  <div class="container-x relative text-center">
    <p data-anim="fade" class="text-[0.72rem] font-bold uppercase tracking-[0.2em] text-up-bright">Ready to get started?</p>
    <h2 data-anim="up" data-anim-delay="0.08" class="mx-auto mt-5 max-w-2xl font-display text-[2.4rem] font-extrabold leading-[1.06] tracking-tight text-up-ink sm:text-5xl lg:text-[3.6rem]">Start building your career today.</h2>
    <p data-anim="up" data-anim-delay="0.16" class="mx-auto mt-6 max-w-xl text-[1.02rem] leading-relaxed text-up-muted">Talk to a counsellor today. One call is usually enough to know which track fits your degree, your schedule and the job you want.</p>
    <div data-anim="up" data-anim-delay="0.24" class="mt-10 flex justify-center">
      <form id="tcmAboutCta" class="w-full" onsubmit="return false;">
        <div class="mx-auto flex w-full max-w-xl flex-col items-stretch gap-3 sm:flex-row">
          <label for="about-cta-phone" class="sr-only">Your mobile number</label>
          <input id="about-cta-phone" type="tel" inputmode="tel" autocomplete="tel" placeholder="Your mobile number" class="min-w-0 flex-1 rounded-full border border-up-line bg-white px-6 py-4 text-[0.95rem] text-up-ink outline-none transition-colors placeholder:text-up-muted/60 focus:border-up-accent" value="">
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
    var f = document.getElementById('tcmAboutCta');
    if (!f) return;
    f.addEventListener('submit', function () {
      var p = document.getElementById('about-cta-phone');
      if (p && p.value && p.value.trim().length >= 10) {
        if (typeof window.openEnquiry === 'function') { window.openEnquiry('Free Demo'); }
      }
    });
  });
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
