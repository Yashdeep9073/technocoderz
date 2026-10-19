<?php
// ============================================================
// Techno Coderz — Contact Page
// Layout & visual structure replicated section-by-section from
// techcaddmohali.com/contact (same design system: dark hero,
// overlapping contact cards, support desks, virtual-counselling
// band, demo-class enquiry form + map aside, campus visit steps,
// campus / areas, FAQ, related cards, closing CTA).
// Re-themed to the Techno Coderz orange palette and filled with
// Techno Coderz data only.
// ============================================================
require_once __DIR__ . '/includes/functions.php';

$pageTitle       = 'Contact Us – Techno Coderz | IT Training Institute, Mohali';
$pageDescription = 'Talk to a counsellor at the Techno Coderz Mohali centre. Ask about session timings, fees, EMI options or which course fits your background — a ten-minute call usually settles it.';
$currentPage     = 'contact';
$csrf            = generateCsrfToken();

// ---- Data ----
$pdo = getDB();

$settings = [];
$courses  = [];
try {
    foreach ($pdo->query("SELECT setting_key, setting_value FROM site_settings") as $row) {
        if (trim($row['setting_value'] ?? '') !== '') {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
    }
    $courses = $pdo->query("SELECT title, category FROM courses WHERE status = 1 ORDER BY sort_order ASC, id ASC")->fetchAll();
} catch (Throwable $e) {
    error_log('Contact data: ' . $e->getMessage());
}

$siteName  = $settings['site_name'] ?? 'Techno Coderz';
$phone     = $settings['phone']  ?? '+91 98765 43210';
$phone2    = $settings['phone2'] ?? '+91 98704 43528';
$email     = $settings['email']  ?? 'info@technocoderz.com';
$email2    = $settings['email2'] ?? 'hr@technocoderz.com';
$address   = $settings['address'] ?? 'Office No. 36, Second Floor, D-185, Phase 8B, Sector 74, Sahibzada Ajit Singh Nagar, Mohali, Punjab 160055';
$location  = $settings['location'] ?? 'Mohali, Punjab';
$phoneRaw  = preg_replace('/\D/', '', $phone);
$phone2Raw = preg_replace('/\D/', '', $phone2);

$mapQuery = rawurlencode(trim(preg_replace('/\s+/', ' ', $address)));
$mapEmbed = 'https://www.google.com/maps?q=' . $mapQuery . '&output=embed';
$mapLink  = 'https://www.google.com/maps/search/?api=1&query=' . $mapQuery;
$waLink   = 'https://wa.me/' . $phoneRaw;

// ---- Support desks (four tabs) ----
$desks = [
    ['key' => 'student', 'label' => 'Student Desk',
     'icon' => '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0M17 5.5a3.5 3.5 0 0 1 0 7M18.5 20a6.6 6.6 0 0 0-3-5.4"/>',
     'eyebrow' => 'Student Desk', 'title' => 'Student Support',
     'desc' => 'Get help with courses, schedules, admissions and your learning journey.',
     'phone' => $phone2, 'email' => $email],
    ['key' => 'placement', 'label' => 'Placement Cell',
     'icon' => '<rect x="3" y="7.5" width="18" height="12" rx="2"/><path d="M9 7.5V6a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v1.5M3 12.5h18"/>',
     'eyebrow' => 'Placement Cell', 'title' => 'Career &amp; Placement Support',
     'desc' => 'Resume building, mock interviews and referrals through our hiring-partner network.',
     'phone' => $phone2, 'email' => $email2],
    ['key' => 'corporate', 'label' => 'Corporate Desk',
     'icon' => '<path d="M4 21V9l8-6 8 6v12"/><path d="M9 21v-6h6v6M9 12h.01M15 12h.01M9 8.5h.01M15 8.5h.01"/>',
     'eyebrow' => 'Corporate Desk', 'title' => 'Corporate Training &amp; Hiring',
     'desc' => 'Customised upskilling bootcamps, campus hiring and software projects for teams.',
     'phone' => $phone, 'email' => $email2],
    ['key' => 'admissions', 'label' => 'Admissions Desk',
     'icon' => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.5 2.5 4 5.7 4 9s-1.5 6.5-4 9c-2.5-2.5-4-5.7-4-9s1.5-6.5 4-9Z"/>',
     'eyebrow' => 'Admissions Desk', 'title' => 'Admissions, Fees &amp; Batches',
     'desc' => 'Fee structure, EMI options, batch timings and the right track for your background.',
     'phone' => $phone, 'email' => $email],
];
foreach ($desks as &$d) { $d['phoneRaw'] = preg_replace('/\D/', '', $d['phone']); }
unset($d);

// ---- FAQ ----
$faqs = [
    ['q' => 'What courses does Techno Coderz offer in Mohali?',
     'a' => 'We run job-oriented tracks across AI &amp; Data Science, Full Stack (MERN, MEAN, PHP), Core Programming (C, C++, Java, Python), Cyber Security, Cloud &amp; DevOps, Digital Marketing and CAD/CAM. Every track is built around live projects, small batches and placement support — browse the full catalogue on the Courses page.'],
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
     'a' => 'Every student who completes a course and its project requirements receives a Techno Coderz certificate. Our placement cell handles resume building, LinkedIn optimisation, mock interviews and referrals through our hiring-partner network until you are placed.'],
    ['q' => 'Can 12th pass students and non-engineering graduates get IT jobs here?',
     'a' => 'Yes. We run dedicated After-12th and professional certificate tracks in Full Stack, Data, Cloud and Cyber Security designed to move you into a corporate role without needing a four-year engineering degree.'],
    ['q' => 'How do I reach the Techno Coderz campus from Chandigarh or Kharar?',
     'a' => 'Our campus is at Phase 8B, Sector 74, Mohali — a short drive from Chandigarh and Kharar with free parking on site. Open the map on this page for turn-by-turn directions, or call ahead and we will keep a counsellor free for your visit.'],
    ['q' => 'Is the counselling and demo class really free?',
     'a' => 'Completely. Counselling, the campus tour and a demo class cost nothing and commit you to nothing. You judge the teaching before you pay for it — not after.'],
];

// ---- Where to go next ----
$nextCards = [
    ['href' => SITE_URL . '/faq.php', 'icon' => '<circle cx="12" cy="12" r="9"/><path d="m8.4 12.2 2.5 2.5 4.7-5.2"/>',
     'title' => 'Questions &amp; answers', 'text' => 'Straight answers on admissions, sessions, fees, certification and placement, organised so you can find yours fast.', 'cta' => 'Read the FAQs'],
    ['href' => SITE_URL . '/courses.php', 'icon' => '<path d="m12 3 8.5 4.5L12 12 3.5 7.5 12 3Z"/><path d="m4 12 8 4.3 8-4.3M4 16.3l8 4.3 8-4.3"/>',
     'title' => 'All courses', 'text' => 'Job-oriented tracks across AI, full stack, data, cyber security, cloud, digital marketing and CAD, each with live projects.', 'cta' => 'Browse the catalogue'],
    ['href' => SITE_URL . '/about.php', 'icon' => '<path d="m12 3 2.6 5.6 6.1.8-4.5 4.2 1.2 6-5.4-3-5.4 3 1.2-6L3.3 9.4l6.1-.8L12 3Z"/>',
     'title' => 'About Techno Coderz', 'text' => 'Our story, our trainers, our labs and the standard we hold every cohort to — learn it by building it.', 'cta' => 'Get to know us'],
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

<main class="overflow-x-hidden">

<!-- ============ 1. HERO ============ -->
<section class="relative overflow-hidden bg-gradient-to-br from-brand-900 via-hero-600 to-brand-700 pb-20 pt-[7.5rem] text-white lg:pb-24 lg:pt-[12rem]">
  <div class="absolute inset-0 bg-[radial-gradient(ellipse_80%_70%_at_20%_0%,rgba(255,194,61,0.30)_0%,transparent_60%),radial-gradient(ellipse_60%_60%_at_90%_40%,rgba(255,255,255,0.16)_0%,transparent_55%)]"></div>
  <div class="absolute inset-0 grid-lines"></div>
  <div data-parallax="60" class="glow-blob right-[5%] top-[10%] h-[380px] w-[380px] bg-accent-glow/20"></div>
  <div class="container-x relative">
    <nav data-anim="fade" class="mb-6 flex flex-wrap items-center gap-2 text-xs text-up-soft/60" aria-label="Breadcrumb">
      <a class="transition-colors hover:text-white" href="<?= SITE_URL ?>">Home</a>
      <span class="flex items-center gap-2">
        <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="opacity-50"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
        <span class="text-up-soft">Contact</span>
      </span>
    </nav>
    <p data-anim="fade" class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-3.5 py-1.5 text-[0.7rem] font-semibold uppercase tracking-[0.16em] text-up-soft">
      <span class="h-1.5 w-1.5 rounded-full bg-accent-yellow"></span>Admissions open
    </p>
    <h1 data-anim="words" class="max-w-4xl font-display text-4xl font-extrabold leading-[1.08] sm:text-5xl lg:text-[3.6rem]">Talk to a counsellor at the Mohali centre</h1>
    <p data-anim="up" data-anim-delay="0.15" class="mt-6 max-w-2xl text-base leading-relaxed text-up-soft/80 sm:text-lg">Ask about session timings, fees, EMI options or which course fits your background. A ten-minute call usually settles what an hour of browsing cannot.</p>
    <div data-anim="fade" data-anim-delay="0.3" class="mt-9 flex flex-wrap items-center gap-4">
      <a href="tel:<?= e($phoneRaw) ?>" class="group inline-flex items-center gap-2 rounded-full bg-white px-7 py-3.5 text-sm font-bold text-brand-600 shadow-xl transition-all hover:-translate-y-0.5 hover:shadow-2xl">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 3h3l2 5-2.5 1.5a12 12 0 0 0 6 6L16 13l5 2v3a2 2 0 0 1-2.2 2A17 17 0 0 1 4 5.2 2 2 0 0 1 6 3Z"/></svg>
        Call <?= e($phone) ?>
      </a>
      <a href="<?= e($waLink) ?>" target="_blank" rel="noreferrer" class="inline-flex items-center gap-2 rounded-full border border-white/25 px-7 py-3.5 text-sm font-semibold text-white transition-all hover:-translate-y-0.5 hover:border-white/50 hover:bg-white/5">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3a9 9 0 0 0-7.7 13.6L3 21l4.5-1.2A9 9 0 1 0 12 3Zm4.6 12.4c-.2.6-1.2 1.1-1.7 1.1-.4 0-1 .1-3-.8a10.6 10.6 0 0 1-4.3-4c-.3-.5-.8-1.4-.8-2.3s.5-1.4.7-1.6a.8.8 0 0 1 .6-.3h.4c.2 0 .4 0 .5.4l.7 1.7c.1.2 0 .4-.1.5l-.3.4c-.1.2-.3.3-.1.6a8 8 0 0 0 3.4 2.9c.3.1.4.1.6-.1l.7-.9c.2-.2.3-.2.5-.1l1.6.8c.2.1.4.2.4.3v.9Z"/></svg>
        WhatsApp us
      </a>
      <a href="#enquiry" class="inline-flex items-center gap-2 text-sm font-semibold text-up-soft transition-colors hover:text-white">Or fill the form
        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
      </a>
    </div>
    <div data-anim="up" data-anim-delay="0.4" data-anim-stagger="true" class="mt-12 grid max-w-2xl gap-4 sm:grid-cols-3">
      <div class="rounded-2xl border border-white/12 bg-white/5 p-5">
        <p class="font-display text-2xl font-extrabold text-white">1<span class="text-accent-yellow"> day</span></p>
        <p class="mt-1.5 text-xs leading-relaxed text-up-soft/70">Callback on every enquiry</p>
      </div>
      <div class="rounded-2xl border border-white/12 bg-white/5 p-5">
        <p class="font-display text-2xl font-extrabold text-white">0<span class="text-accent-yellow"> fee</span></p>
        <p class="mt-1.5 text-xs leading-relaxed text-up-soft/70">For counselling or a demo class</p>
      </div>
      <div class="rounded-2xl border border-white/12 bg-white/5 p-5">
        <p class="font-display text-2xl font-extrabold text-white">1<span class="text-accent-yellow"> campus</span></p>
        <p class="mt-1.5 text-xs leading-relaxed text-up-soft/70">In <?= e($location) ?></p>
      </div>
    </div>
  </div>
</section>

<!-- ============ 2. CONTACT CARDS ============ -->
<section class="relative z-10 -mt-12 lg:-mt-14">
  <div class="container-x">
    <div data-anim="up" data-anim-stagger="true" class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
      <a href="tel:<?= e($phoneRaw) ?>" class="card-hover group rounded-3xl border border-line bg-white p-7">
        <span class="grid h-12 w-12 place-items-center rounded-2xl bg-brand-50 text-up-accent transition-colors group-hover:bg-up-accent group-hover:text-white">
          <svg viewBox="0 0 24 24" width="21" height="21" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 3h3l2 5-2.5 1.5a12 12 0 0 0 6 6L16 13l5 2v3a2 2 0 0 1-2.2 2A17 17 0 0 1 4 5.2 2 2 0 0 1 6 3Z"/></svg>
        </span>
        <p class="mt-5 text-xs font-semibold uppercase tracking-wider text-up-muted">Call the centre</p>
        <p class="mt-1.5 text-base font-bold text-up-ink transition-colors group-hover:text-up-accent"><?= e($phone) ?></p>
        <p class="mt-2 text-xs leading-relaxed text-up-muted">Mon – Sun, 8 AM – 8 PM</p>
      </a>
      <a href="<?= e($waLink) ?>" target="_blank" rel="noreferrer" class="card-hover group rounded-3xl border border-line bg-white p-7">
        <span class="grid h-12 w-12 place-items-center rounded-2xl bg-brand-50 text-up-accent transition-colors group-hover:bg-up-accent group-hover:text-white">
          <svg viewBox="0 0 24 24" width="21" height="21" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3a9 9 0 0 0-7.7 13.6L3 21l4.5-1.2A9 9 0 1 0 12 3Zm4.6 12.4c-.2.6-1.2 1.1-1.7 1.1-.4 0-1 .1-3-.8a10.6 10.6 0 0 1-4.3-4c-.3-.5-.8-1.4-.8-2.3s.5-1.4.7-1.6a.8.8 0 0 1 .6-.3h.4c.2 0 .4 0 .5.4l.7 1.7c.1.2 0 .4-.1.5l-.3.4c-.1.2-.3.3-.1.6a8 8 0 0 0 3.4 2.9c.3.1.4.1.6-.1l.7-.9c.2-.2.3-.2.5-.1l1.6.8c.2.1.4.2.4.3v.9Z"/></svg>
        </span>
        <p class="mt-5 text-xs font-semibold uppercase tracking-wider text-up-muted">WhatsApp</p>
        <p class="mt-1.5 text-base font-bold text-up-ink transition-colors group-hover:text-up-accent"><?= e($phone) ?></p>
        <p class="mt-2 text-xs leading-relaxed text-up-muted">Usually replies within minutes</p>
      </a>
      <a href="mailto:<?= e($email) ?>" class="card-hover group rounded-3xl border border-line bg-white p-7">
        <span class="grid h-12 w-12 place-items-center rounded-2xl bg-brand-50 text-up-accent transition-colors group-hover:bg-up-accent group-hover:text-white">
          <svg viewBox="0 0 24 24" width="21" height="21" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2.5" y="5" width="19" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
        </span>
        <p class="mt-5 text-xs font-semibold uppercase tracking-wider text-up-muted">Email</p>
        <p class="mt-1.5 break-all text-base font-bold text-up-ink transition-colors group-hover:text-up-accent"><?= e($email) ?></p>
        <p class="mt-2 text-xs leading-relaxed text-up-muted">For detailed queries &amp; corporate training</p>
      </a>
      <a href="<?= e($mapLink) ?>" target="_blank" rel="noreferrer" class="card-hover group rounded-3xl border border-line bg-white p-7">
        <span class="grid h-12 w-12 place-items-center rounded-2xl bg-brand-50 text-up-accent transition-colors group-hover:bg-up-accent group-hover:text-white">
          <svg viewBox="0 0 24 24" width="21" height="21" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s7-5.5 7-11a7 7 0 1 0-14 0c0 5.5 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/></svg>
        </span>
        <p class="mt-5 text-xs font-semibold uppercase tracking-wider text-up-muted">Visit the campus</p>
        <p class="mt-1.5 text-base font-bold text-up-ink transition-colors group-hover:text-up-accent"><?= e($location) ?></p>
        <p class="mt-2 text-xs leading-relaxed text-up-muted"><?= e($address) ?></p>
      </a>
    </div>
  </div>
</section>

<!-- ============ 3. SUPPORT & ASSISTANCE ============ -->
<section class="bg-subtle py-20 lg:py-24">
  <div class="container-x">
    <div class="mx-auto max-w-3xl text-center">
      <p class="text-[0.68rem] font-bold uppercase tracking-[0.18em] text-up-accent">We are here to help</p>
      <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-up-ink sm:text-4xl">Support &amp; Assistance</h2>
      <p class="mt-4 text-base leading-relaxed text-up-muted">Reach the right desk directly — students, placement, corporate training or admissions.</p>
    </div>
    <div class="mx-auto mt-10 max-w-5xl rounded-[2rem] border border-line bg-white p-3 shadow-[0_25px_70px_-55px_rgba(11,26,38,0.55)] sm:p-5">
      <div role="tablist" aria-label="Support desks" class="grid gap-2 sm:grid-cols-2 lg:grid-cols-4">
        <?php foreach ($desks as $i => $d): ?>
        <button type="button" role="tab" data-desk="<?= e($d['key']) ?>" aria-selected="<?= $i === 0 ? 'true' : 'false' ?>" class="rounded-2xl px-4 py-3.5 text-left transition-all <?= $i === 0 ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30' : 'text-up-muted hover:bg-subtle hover:text-up-ink' ?>">
          <span class="flex items-center gap-2 text-sm font-bold">
            <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?= $d['icon'] ?></svg><?= $d['label'] ?>
          </span>
        </button>
        <?php endforeach; ?>
      </div>
      <?php foreach ($desks as $i => $d): ?>
      <div role="tabpanel" data-panel="<?= e($d['key']) ?>" aria-label="<?= e($d['label']) ?>" class="mt-3 rounded-3xl bg-gradient-to-br from-brand-50 via-white to-subtle p-6 sm:p-8<?= $i === 0 ? '' : ' hidden' ?>">
        <div class="flex flex-col gap-7 lg:flex-row lg:items-center lg:justify-between">
          <div class="max-w-lg">
            <div class="flex items-center gap-3">
              <span class="grid h-12 w-12 place-items-center rounded-2xl bg-brand-600 text-white">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 13a8 8 0 0 1 16 0"/><path d="M4 13v4a2 2 0 0 0 2 2h1v-6H6a2 2 0 0 0-2 2ZM20 13v4a2 2 0 0 1-2 2h-1v-6h1a2 2 0 0 1 2 2Z"/><path d="M17 19c0 1.1-.9 2-2 2h-3"/></svg>
              </span>
              <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-up-accent"><?= $d['eyebrow'] ?></p>
                <h3 class="mt-1 font-display text-2xl font-extrabold text-up-ink"><?= $d['title'] ?></h3>
              </div>
            </div>
            <p class="mt-5 text-sm leading-relaxed text-up-muted"><?= e($d['desc']) ?></p>
          </div>
          <div class="grid gap-4 sm:grid-cols-2 lg:min-w-[22rem]">
            <a href="tel:<?= e($d['phoneRaw']) ?>" class="rounded-2xl border border-line bg-white p-4 transition-colors hover:border-up-accent">
              <p class="text-xs font-semibold uppercase tracking-wider text-up-muted">Phone</p>
              <p class="mt-1.5 text-sm font-bold text-up-ink"><?= e($d['phone']) ?></p>
            </a>
            <a href="mailto:<?= e($d['email']) ?>" class="rounded-2xl border border-line bg-white p-4 transition-colors hover:border-up-accent">
              <p class="text-xs font-semibold uppercase tracking-wider text-up-muted">Email</p>
              <p class="mt-1.5 break-all text-sm font-bold text-up-ink"><?= e($d['email']) ?></p>
            </a>
          </div>
        </div>
        <div class="mt-7 flex flex-wrap gap-3 border-t border-line pt-6">
          <a href="tel:<?= e($d['phoneRaw']) ?>" class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-5 py-2.5 text-sm font-bold text-white transition-colors hover:bg-brand-700">
            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 3h3l2 5-2.5 1.5a12 12 0 0 0 6 6L16 13l5 2v3a2 2 0 0 1-2.2 2A17 17 0 0 1 4 5.2 2 2 0 0 1 6 3Z"/></svg>
            Call Now
          </a>
          <a href="https://wa.me/<?= e($d['phoneRaw']) ?>" target="_blank" rel="noreferrer" class="inline-flex items-center gap-2 rounded-full bg-[#25D366] px-5 py-2.5 text-sm font-bold text-white transition-colors hover:bg-[#1ebe5d]">
            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3a9 9 0 0 0-7.7 13.6L3 21l4.5-1.2A9 9 0 1 0 12 3Zm4.6 12.4c-.2.6-1.2 1.1-1.7 1.1-.4 0-1 .1-3-.8a10.6 10.6 0 0 1-4.3-4c-.3-.5-.8-1.4-.8-2.3s.5-1.4.7-1.6a.8.8 0 0 1 .6-.3h.4c.2 0 .4 0 .5.4l.7 1.7c.1.2 0 .4-.1.5l-.3.4c-.1.2-.3.3-.1.6a8 8 0 0 0 3.4 2.9c.3.1.4.1.6-.1l.7-.9c.2-.2.3-.2.5-.1l1.6.8c.2.1.4.2.4.3v.9Z"/></svg>
            WhatsApp
          </a>
          <a href="mailto:<?= e($d['email']) ?>" class="inline-flex items-center gap-2 rounded-full border border-line px-5 py-2.5 text-sm font-bold text-up-ink transition-colors hover:border-up-accent hover:text-up-accent">
            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2.5" y="5" width="19" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
            Email
          </a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ 4. SCHEDULE VIRTUAL COUNSELLING ============ -->
<section class="container-x py-20 lg:py-24">
  <section class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-hero-600 to-brand-700 px-6 py-10 text-white shadow-[0_30px_90px_-50px_rgba(255,107,0,0.6)] sm:px-10 lg:px-14 lg:py-12">
    <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_85%_20%,rgba(255,194,61,0.35),transparent_38%),radial-gradient(circle_at_10%_90%,rgba(255,255,255,0.16),transparent_35%)]"></div>
    <div class="relative flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
      <div class="max-w-2xl">
        <p class="text-[0.68rem] font-bold uppercase tracking-[0.18em] text-accent-yellow">Personalised guidance</p>
        <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight sm:text-4xl">Schedule Virtual Counselling</h2>
        <p class="mt-4 max-w-xl text-sm leading-relaxed text-up-soft/75 sm:text-base">Book a free 1:1 virtual counselling session. Pick your date and time slot — a Techno Coderz advisor calls you personally.</p>
      </div>
      <a href="#enquiry" class="group inline-flex shrink-0 items-center justify-center gap-2 rounded-full bg-white px-7 py-4 text-sm font-bold text-brand-600 shadow-xl transition-all hover:-translate-y-0.5 hover:shadow-2xl">
        Book Counselling Session
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform group-hover:translate-x-1"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
      </a>
    </div>
  </section>
</section>

<!-- ============ 5. ENQUIRY (FORM + ASIDE) ============ -->
<section id="enquiry" class="scroll-mt-28 py-20 lg:py-28">
  <div class="container-x grid gap-12 lg:grid-cols-[1.15fr_0.85fr] lg:gap-16">
    <div data-anim="up">
      <form id="tcContactForm" class="rounded-3xl border border-line bg-white p-8 shadow-[0_30px_80px_-50px_rgba(255,107,0,0.35)] lg:p-10" novalidate>
        <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
        <h3 class="font-display text-2xl font-extrabold text-up-ink">Book a free demo class</h3>
        <p class="mt-2 text-sm text-up-muted">Tell us a little about yourself. No fee, no obligation — a counsellor will call you back.</p>
        <div class="mt-8 grid gap-5 sm:grid-cols-2">
          <div class="sm:col-span-1">
            <label for="tc-name" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-up-muted">Full name *</label>
            <input id="tc-name" name="name" required placeholder="Your name" class="w-full rounded-xl border border-up-line bg-white px-4 py-3 text-sm text-up-ink outline-none transition-colors placeholder:text-up-muted/60 focus:border-up-accent">
          </div>
          <div class="sm:col-span-1">
            <label for="tc-phone" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-up-muted">Phone / WhatsApp *</label>
            <input id="tc-phone" name="phone" required inputmode="tel" placeholder="98765 43210" class="w-full rounded-xl border border-up-line bg-white px-4 py-3 text-sm text-up-ink outline-none transition-colors placeholder:text-up-muted/60 focus:border-up-accent">
          </div>
          <div class="sm:col-span-2">
            <label for="tc-email" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-up-muted">Email</label>
            <input id="tc-email" name="email" type="email" placeholder="you@example.com" class="w-full rounded-xl border border-up-line bg-white px-4 py-3 text-sm text-up-ink outline-none transition-colors placeholder:text-up-muted/60 focus:border-up-accent">
          </div>
          <div class="sm:col-span-1">
            <label for="tc-course" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-up-muted">Course of interest</label>
            <select id="tc-course" name="course" class="w-full rounded-xl border border-up-line bg-white px-4 py-3 text-sm text-up-ink outline-none transition-colors focus:border-up-accent">
              <option value="" selected>Not sure yet</option>
              <?php foreach ($courses as $c): ?>
              <option value="<?= e($c['title']) ?>"><?= e($c['title']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="sm:col-span-1">
            <label for="tc-mode" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-up-muted">Preferred session</label>
            <select id="tc-mode" name="mode" class="w-full rounded-xl border border-up-line bg-white px-4 py-3 text-sm text-up-ink outline-none transition-colors focus:border-up-accent">
              <option value="Morning" selected>Morning</option>
              <option value="Afternoon">Afternoon</option>
              <option value="Evening">Evening</option>
              <option value="Weekend">Weekend</option>
              <option value="Live online">Live online</option>
            </select>
          </div>
          <div class="sm:col-span-2">
            <label for="tc-message" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-up-muted">Anything we should know?</label>
            <textarea id="tc-message" name="message" rows="4" placeholder="Your background, what you want to do next, questions about fees…" class="w-full resize-none rounded-xl border border-up-line bg-white px-4 py-3 text-sm text-up-ink outline-none transition-colors placeholder:text-up-muted/60 focus:border-up-accent"></textarea>
          </div>
        </div>
        <button type="submit" class="group mt-8 inline-flex w-full items-center justify-center gap-2 rounded-full bg-gradient-to-r from-hero-600 to-hero-glow px-8 py-4 text-sm font-bold text-white shadow-lg shadow-hero-600/25 transition-all hover:-translate-y-0.5 hover:shadow-xl disabled:cursor-not-allowed disabled:opacity-70">
          Request a call back
          <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform group-hover:translate-x-1"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
        </button>
        <p id="tcFormMsg" class="mt-4 hidden text-center text-sm"></p>
        <p class="mt-4 text-center text-xs text-up-muted">We use your details only to contact you about this enquiry.</p>
      </form>
    </div>
    <div class="space-y-6 lg:sticky lg:top-28 lg:self-start">
      <div data-anim="right" class="group overflow-hidden rounded-3xl border border-line bg-white shadow-[0_30px_80px_-60px_rgba(255,107,0,0.4)]">
        <div class="relative">
          <iframe title="<?= e($siteName) ?> campus on Google Maps" src="<?= e($mapEmbed) ?>" class="h-[22rem] w-full border-0 grayscale-[0.25] transition-all duration-700 group-hover:grayscale-0" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          <span class="pointer-events-none absolute left-4 top-4 inline-flex items-center gap-1.5 rounded-full bg-white/90 px-3 py-1.5 text-[0.65rem] font-bold uppercase tracking-[0.14em] text-up-ink shadow-sm backdrop-blur">
            <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-up-accent"></span><?= e($location) ?>
          </span>
        </div>
        <div class="p-7">
          <h3 class="font-display text-lg font-extrabold text-up-ink"><?= e($siteName) ?>, <?= e($location) ?></h3>
          <p class="mt-2.5 text-sm leading-relaxed text-up-muted"><?= e($address) ?></p>
          <div class="mt-5 flex flex-wrap items-center gap-4">
            <a href="<?= e($mapLink) ?>" target="_blank" rel="noreferrer" class="group/link inline-flex items-center gap-2 rounded-full bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white transition-all hover:-translate-y-0.5 hover:bg-brand-700">
              Get directions
              <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform group-hover/link:translate-x-0.5 group-hover/link:-translate-y-0.5"><path d="M7 17 17 7M9 7h8v8"/></svg>
            </a>
            <a href="tel:<?= e($phoneRaw) ?>" class="inline-flex items-center gap-1.5 text-sm font-semibold text-up-accent hover:underline">
              <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 3h3l2 5-2.5 1.5a12 12 0 0 0 6 6L16 13l5 2v3a2 2 0 0 1-2.2 2A17 17 0 0 1 4 5.2 2 2 0 0 1 6 3Z"/></svg>
              Call before you visit
            </a>
          </div>
        </div>
      </div>
      <div data-anim="right" data-anim-delay="0.1" class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-brand-700 to-hero-600 p-8 text-white">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,194,61,0.35)_0%,transparent_65%)]"></div>
        <div class="relative">
          <p class="text-[0.68rem] font-bold uppercase tracking-[0.16em] text-accent-yellow">Centre hours</p>
          <p class="mt-3 font-display text-xl font-extrabold">Mon – Sun, 8 AM – 8 PM</p>
          <p class="mt-2 text-sm text-up-soft/75">Labs stay open for practice outside class hours. Sunday visits by appointment.</p>
          <div class="mt-6 flex flex-wrap gap-2">
            <span class="rounded-full border border-white/15 bg-white/5 px-3.5 py-1.5 text-xs text-up-soft">Free counselling</span>
            <span class="rounded-full border border-white/15 bg-white/5 px-3.5 py-1.5 text-xs text-up-soft">Campus tour</span>
            <span class="rounded-full border border-white/15 bg-white/5 px-3.5 py-1.5 text-xs text-up-soft">Demo class</span>
            <span class="rounded-full border border-white/15 bg-white/5 px-3.5 py-1.5 text-xs text-up-soft">Fee &amp; EMI details</span>
          </div>
        </div>
      </div>
      <div data-anim="right" data-anim-delay="0.18" class="rounded-3xl border border-line bg-subtle p-7">
        <p class="text-[0.68rem] font-bold uppercase tracking-[0.16em] text-up-accent">Already a student?</p>
        <p class="mt-2.5 text-sm leading-relaxed text-up-muted">For session changes, certificates or placement support, call the centre directly — the front desk routes you to your trainer or the placement cell.</p>
        <a class="group mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-up-accent" href="<?= SITE_URL ?>/placement-cell.php">
          Placement support
          <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform group-hover:translate-x-1"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ============ 6. WHAT A CAMPUS VISIT LOOKS LIKE ============ -->
<section class="relative overflow-hidden bg-subtle py-24 lg:py-32">
  <div class="pointer-events-none absolute inset-0 grid-lines-light opacity-60"></div>
  <div data-parallax="-60" class="glow-blob right-[-4%] top-[18%] h-[320px] w-[320px] bg-brand-200/50"></div>
  <div class="container-x relative">
    <div class="mx-auto max-w-3xl text-center">
      <div data-anim="fade" class="mb-4 inline-flex items-center gap-2 rounded-full border border-up-line bg-brand-50 px-3.5 py-1.5 text-[0.7rem] font-semibold uppercase tracking-[0.16em] text-up-accent">
        <span class="h-1.5 w-1.5 rounded-full bg-up-accent"></span>Before you enrol
      </div>
      <h2 data-anim="words" class="text-3xl font-extrabold leading-[1.1] text-up-ink sm:text-4xl lg:text-[2.9rem]">What a campus visit looks like</h2>
      <div data-underline="true" class="mx-auto mt-5 h-[3px] w-24 rounded-full bg-gradient-to-r from-up-accent to-transparent"></div>
      <p data-anim="up" data-anim-delay="0.1" class="mt-5 text-base leading-relaxed text-up-muted sm:text-lg">Nothing is charged and nothing is committed until you have seen a class run. Walk in during centre hours, or call ahead and we will keep a counsellor free.</p>
    </div>
    <div data-anim="up" data-anim-stagger="true" class="mt-14 grid gap-6 lg:grid-cols-3">
      <div class="card-hover group relative overflow-hidden rounded-3xl border border-line bg-white p-8">
        <span class="absolute right-6 top-6 font-display text-5xl font-extrabold text-brand-50 transition-colors group-hover:text-brand-100">01</span>
        <span class="relative grid h-12 w-12 place-items-center rounded-2xl bg-brand-50 text-up-accent transition-colors group-hover:bg-up-accent group-hover:text-white">
          <svg viewBox="0 0 24 24" width="21" height="21" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0M17 5.5a3.5 3.5 0 0 1 0 7M18.5 20a6.6 6.6 0 0 0-3-5.4"/></svg>
        </span>
        <h3 class="relative mt-6 font-display text-lg font-extrabold text-up-ink">Free counselling</h3>
        <p class="relative mt-3 text-sm leading-relaxed text-up-muted">Twenty minutes with a counsellor on what you have studied, what you want to do next, and which track actually gets you there — including the ones we would talk you out of.</p>
      </div>
      <div class="card-hover group relative overflow-hidden rounded-3xl border border-line bg-white p-8">
        <span class="absolute right-6 top-6 font-display text-5xl font-extrabold text-brand-50 transition-colors group-hover:text-brand-100">02</span>
        <span class="relative grid h-12 w-12 place-items-center rounded-2xl bg-brand-50 text-up-accent transition-colors group-hover:bg-up-accent group-hover:text-white">
          <svg viewBox="0 0 24 24" width="21" height="21" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2.5" y="4" width="19" height="13" rx="2"/><path d="M9 21h6M12 17v4"/></svg>
        </span>
        <h3 class="relative mt-6 font-display text-lg font-extrabold text-up-ink">Campus tour &amp; demo class</h3>
        <p class="relative mt-3 text-sm leading-relaxed text-up-muted">Sit in on a live session, see the labs, meet the trainer who would take your class. You judge the teaching before you pay for it, not after.</p>
      </div>
      <div class="card-hover group relative overflow-hidden rounded-3xl border border-line bg-white p-8">
        <span class="absolute right-6 top-6 font-display text-5xl font-extrabold text-brand-50 transition-colors group-hover:text-brand-100">03</span>
        <span class="relative grid h-12 w-12 place-items-center rounded-2xl bg-brand-50 text-up-accent transition-colors group-hover:bg-up-accent group-hover:text-white">
          <svg viewBox="0 0 24 24" width="21" height="21" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="7.5" width="18" height="12" rx="2"/><path d="M9 7.5V6a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v1.5M3 12.5h18"/></svg>
        </span>
        <h3 class="relative mt-6 font-display text-lg font-extrabold text-up-ink">Fees, EMI &amp; session slot</h3>
        <p class="relative mt-3 text-sm leading-relaxed text-up-muted">The full fee written down, EMI options explained, and a session held in the slot that fits your week — morning, evening, weekend or live online.</p>
      </div>
    </div>
    <div data-anim="fade" data-anim-delay="0.2" class="mt-12 text-center">
      <a href="#enquiry" class="group inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-hero-600 to-hero-glow px-8 py-4 text-sm font-bold text-white shadow-lg shadow-hero-600/25 transition-all hover:-translate-y-0.5 hover:shadow-xl">
        Book a free demo class
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform group-hover:translate-x-1"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
      </a>
    </div>
  </div>
</section>

<!-- ============ 7. CAMPUS & AREAS WE SERVE ============ -->
<section id="branches" class="relative scroll-mt-28 overflow-hidden bg-white py-24 lg:py-32">
  <div class="pointer-events-none absolute inset-0 grid-lines-light opacity-70"></div>
  <div data-parallax="-50" class="glow-blob left-[-6%] top-[12%] h-[340px] w-[340px] bg-brand-200/40"></div>
  <div class="container-x relative">
    <div class="max-w-3xl">
      <div data-anim="fade" class="mb-4 inline-flex items-center gap-2 rounded-full border border-up-line bg-brand-50 px-3.5 py-1.5 text-[0.7rem] font-semibold uppercase tracking-[0.16em] text-up-accent">
        <span class="h-1.5 w-1.5 rounded-full bg-up-accent"></span><?= e($location) ?>
      </div>
      <h2 data-anim="words" class="text-3xl font-extrabold leading-[1.1] text-up-ink sm:text-4xl lg:text-[2.9rem]">One campus, and the whole Tricity</h2>
      <div data-underline="true" class="mt-5 h-[3px] w-24 rounded-full bg-gradient-to-r from-up-accent to-transparent"></div>
      <p data-anim="up" data-anim-delay="0.1" class="mt-5 text-base leading-relaxed text-up-muted sm:text-lg">Techno Coderz runs a single purpose-built campus in Mohali. Every batch — in person or live online — is taught from here, so the syllabus, the trainers and the standard are the same for everyone.</p>
    </div>
    <div data-anim="up" data-anim-stagger="true" class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
      <div class="relative overflow-hidden rounded-3xl border border-up-accent/25 bg-subtle p-7 shadow-[0_30px_70px_-50px_rgba(255,107,0,0.3)]">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-up-accent to-accent-glow"></div>
        <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-3 py-1 text-[0.62rem] font-bold uppercase tracking-[0.14em] text-up-accent">
          <span class="h-1.5 w-1.5 rounded-full bg-up-accent"></span>You are here
        </span>
        <h3 class="mt-4 font-display text-xl font-extrabold text-up-ink"><?= e($siteName) ?> — <?= e($location) ?></h3>
        <p class="mt-2.5 text-sm leading-relaxed text-up-muted"><?= e($address) ?></p>
        <div class="mt-4 flex flex-wrap gap-1.5">
          <span class="rounded-full border border-up-line bg-white px-2.5 py-1 text-[0.68rem] font-medium text-up-muted">Phase 8B</span>
          <span class="rounded-full border border-up-line bg-white px-2.5 py-1 text-[0.68rem] font-medium text-up-muted">Sector 74</span>
          <span class="rounded-full border border-up-line bg-white px-2.5 py-1 text-[0.68rem] font-medium text-up-muted">Chandigarh</span>
          <span class="rounded-full border border-up-line bg-white px-2.5 py-1 text-[0.68rem] font-medium text-up-muted">Kharar</span>
        </div>
        <a href="<?= e($mapLink) ?>" target="_blank" rel="noreferrer" class="group mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-up-accent">
          Open in Maps
          <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5"><path d="M7 17 17 7M9 7h8v8"/></svg>
        </a>
      </div>
      <?php
      $areas = [
          ['name' => 'Chandigarh', 'text' => 'A short drive from Sector 43, the IT Park and Panjab University.', 'chips' => ['IT Park', 'Sector 17', 'Sector 43']],
          ['name' => 'Mohali', 'text' => 'Walking distance from the Phase 8B and Sector 74 commercial belt.', 'chips' => ['Phase 3–11', 'Sector 70', 'Aerocity']],
          ['name' => 'Kharar', 'text' => 'On the Kharar–Mohali highway with free parking at the campus.', 'chips' => ['Kharar', 'Gharuan', 'Landran']],
          ['name' => 'Zirakpur &amp; Panchkula', 'text' => 'Direct transit links from Zirakpur, Dhakoli and Panchkula.', 'chips' => ['Zirakpur', 'Dhakoli', 'Panchkula']],
          ['name' => 'Banur &amp; Rajpura', 'text' => 'A convenient stop for students from the Banur education belt.', 'chips' => ['Banur', 'Rajpura', 'Lalru']],
      ];
      foreach ($areas as $a): ?>
      <div class="card-hover group relative overflow-hidden rounded-3xl border border-line bg-subtle p-7">
        <div class="flex items-start justify-between gap-3">
          <span class="grid h-11 w-11 place-items-center rounded-2xl bg-brand-50 text-up-accent transition-colors group-hover:bg-up-accent group-hover:text-white">
            <svg viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s7-5.5 7-11a7 7 0 1 0-14 0c0 5.5 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/></svg>
          </span>
        </div>
        <h3 class="mt-5 font-display text-xl font-extrabold text-up-ink transition-colors group-hover:text-up-accent"><?= $a['name'] ?></h3>
        <p class="mt-2 text-sm leading-relaxed text-up-muted"><?= $a['text'] ?></p>
        <div class="mt-4 flex flex-wrap gap-1.5">
          <?php foreach ($a['chips'] as $chip): ?>
          <span class="rounded-full border border-up-line bg-white px-2.5 py-1 text-[0.68rem] font-medium text-up-muted"><?= $chip ?></span>
          <?php endforeach; ?>
        </div>
        <a href="#enquiry" class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-up-accent">
          Plan your visit
          <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
    <div data-anim="up" data-anim-delay="0.1" class="mt-8 flex flex-col gap-5 rounded-3xl border border-line bg-subtle p-7 sm:flex-row sm:items-center sm:justify-between lg:p-9">
      <div>
        <p class="text-[0.68rem] font-bold uppercase tracking-[0.16em] text-up-accent">Can't visit in person?</p>
        <p class="mt-2 text-sm leading-relaxed text-up-muted">Join a live virtual counselling session or a demo class online — same trainers, same syllabus, from anywhere in India.</p>
      </div>
      <a href="#enquiry" class="group inline-flex shrink-0 items-center gap-2 rounded-full border border-up-line px-6 py-3 text-sm font-semibold text-up-ink transition-all hover:-translate-y-0.5 hover:border-up-accent hover:text-up-accent">
        Book online
        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5"><path d="M7 17 17 7M9 7h8v8"/></svg>
      </a>
    </div>
  </div>
</section>

<!-- ============ 8. FAQ ============ -->
<section id="faqs" class="relative scroll-mt-32 overflow-hidden bg-gradient-to-br from-brand-900 via-hero-600 to-brand-900 py-24 text-white lg:py-32">
  <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_55%_50%_at_25%_20%,rgba(255,194,61,0.30),transparent_68%)]"></div>
  <div class="pointer-events-none absolute inset-0 grid-lines opacity-40"></div>
  <div class="container-x relative">
    <div class="grid gap-14 lg:grid-cols-[0.85fr_1.15fr] lg:gap-20">
      <div class="lg:sticky lg:top-32 lg:self-start">
        <div class="max-w-3xl">
          <div data-anim="fade" class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-3.5 py-1.5 text-[0.7rem] font-semibold uppercase tracking-[0.16em] text-up-soft">
            <span class="h-1.5 w-1.5 rounded-full bg-accent-glow"></span>FAQs
          </div>
          <h2 data-anim="words" class="text-3xl font-extrabold leading-[1.1] text-white sm:text-4xl lg:text-[2.9rem]">Questions we get every week</h2>
          <div data-underline="true" class="mt-5 h-[3px] w-24 rounded-full bg-gradient-to-r from-accent-glow to-transparent"></div>
          <p data-anim="up" data-anim-delay="0.1" class="mt-5 text-base leading-relaxed text-up-soft/80 sm:text-lg">Still unsure? A ten-minute call with a counsellor usually settles it faster than any brochure.</p>
        </div>
        <div data-anim="up" data-anim-delay="0.15" class="glass-dark relative mt-8 rounded-2xl p-6">
          <p class="text-sm font-semibold text-white">Ask us directly</p>
          <div class="mt-4 space-y-2.5 text-sm">
            <a href="tel:<?= e($phoneRaw) ?>" class="flex items-center gap-2.5 text-up-soft/70 transition-colors hover:text-white">
              <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="text-up-accent"><path d="M6 3h3l2 5-2.5 1.5a12 12 0 0 0 6 6L16 13l5 2v3a2 2 0 0 1-2.2 2A17 17 0 0 1 4 5.2 2 2 0 0 1 6 3Z"/></svg>
              <?= e($phone) ?>
            </a>
            <a href="<?= e($waLink) ?>" target="_blank" rel="noreferrer" class="flex items-center gap-2.5 text-up-soft/70 transition-colors hover:text-white">
              <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="text-up-accent"><path d="M12 3a9 9 0 0 0-7.7 13.6L3 21l4.5-1.2A9 9 0 1 0 12 3Zm4.6 12.4c-.2.6-1.2 1.1-1.7 1.1-.4 0-1 .1-3-.8a10.6 10.6 0 0 1-4.3-4c-.3-.5-.8-1.4-.8-2.3s.5-1.4.7-1.6a.8.8 0 0 1 .6-.3h.4c.2 0 .4 0 .5.4l.7 1.7c.1.2 0 .4-.1.5l-.3.4c-.1.2-.3.3-.1.6a8 8 0 0 0 3.4 2.9c.3.1.4.1.6-.1l.7-.9c.2-.2.3-.2.5-.1l1.6.8c.2.1.4.2.4.3v.9Z"/></svg>
              WhatsApp <?= e($phone) ?>
            </a>
            <a href="mailto:<?= e($email) ?>" class="flex items-center gap-2.5 text-up-soft/70 transition-colors hover:text-white">
              <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="text-up-accent"><rect x="2.5" y="5" width="19" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
              <?= e($email) ?>
            </a>
          </div>
        </div>
      </div>
      <div data-anim="up" data-anim-stagger="true" data-faq-group class="space-y-3">
        <?php foreach ($faqs as $i => $f): $open = $i === 0; ?>
        <div class="glass-dark relative overflow-hidden rounded-2xl transition-colors duration-300<?= $open ? ' !border-accent-glow/35 !bg-white/[0.11]' : '' ?>">
          <button type="button" aria-expanded="<?= $open ? 'true' : 'false' ?>" class="flex w-full items-center justify-between gap-6 px-6 py-5 text-left">
            <span class="text-base font-semibold transition-colors <?= $open ? 'text-accent-glow' : 'text-white' ?>"><?= $f['q'] ?></span>
            <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full transition-all duration-300 <?= $open ? 'rotate-45 bg-accent-glow text-brand-700' : 'bg-white/10 text-up-soft/70' ?>">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
            </span>
          </button>
          <div data-faq-body class="grid transition-all duration-400 ease-out <?= $open ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0' ?>">
            <div class="overflow-hidden">
              <p class="px-6 pb-6 text-sm leading-relaxed text-up-soft/70"><?= $f['a'] ?></p>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ============ 9. WHERE TO GO NEXT ============ -->
<section class="border-t border-line bg-subtle py-20 lg:py-24" aria-labelledby="related-heading">
  <div class="container-x">
    <p class="text-xs font-bold uppercase tracking-[0.16em] text-up-accent">Keep exploring</p>
    <h2 id="related-heading" data-anim="words" class="mt-3 font-display text-2xl font-extrabold text-up-ink sm:text-3xl">Where to go next</h2>
    <div data-underline="true" class="mt-4 h-[3px] w-20 rounded-full bg-gradient-to-r from-up-accent to-transparent"></div>
    <div data-anim="up" data-anim-stagger="true" class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
      <?php foreach ($nextCards as $card): ?>
      <a class="card-hover group flex flex-col rounded-3xl border border-line bg-white p-7" href="<?= e($card['href']) ?>">
        <span class="grid h-11 w-11 place-items-center rounded-2xl bg-brand-50 text-up-accent transition-colors group-hover:bg-up-accent group-hover:text-white">
          <svg viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?= $card['icon'] ?></svg>
        </span>
        <span class="mt-5 font-display text-lg font-bold leading-snug text-up-ink transition-colors group-hover:text-up-accent"><?= $card['title'] ?></span>
        <span class="mt-2.5 flex-1 text-sm leading-relaxed text-up-muted"><?= $card['text'] ?></span>
        <span class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-up-accent"><?= $card['cta'] ?>
          <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform group-hover:translate-x-1"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
        </span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ 10. FINAL CTA ============ -->
<section class="relative overflow-hidden bg-subtle py-24 lg:py-32">
  <div class="pointer-events-none absolute right-[6%] top-1/2 h-16 w-16 -translate-y-1/2 rounded-full border border-up-line"></div>
  <div class="pointer-events-none absolute left-[7%] top-[22%] h-10 w-10 rounded-full border border-up-line"></div>
  <div class="container-x relative text-center">
    <p data-anim="fade" class="text-[0.72rem] font-bold uppercase tracking-[0.2em] text-up-bright">Ready to get started?</p>
    <h2 data-anim="up" data-anim-delay="0.08" class="mx-auto mt-5 max-w-2xl font-display text-[2.4rem] font-extrabold leading-[1.06] tracking-tight text-up-ink sm:text-5xl lg:text-[3.6rem]">Start building your career today.</h2>
    <p data-anim="up" data-anim-delay="0.16" class="mx-auto mt-6 max-w-xl text-[1.02rem] leading-relaxed text-up-muted">Talk to a counsellor today. One call is usually enough to know which track fits your degree, your schedule and the job you want.</p>
    <div data-anim="up" data-anim-delay="0.24" class="mt-10 flex justify-center">
      <form id="tcCtaForm" class="w-full" onsubmit="return false;">
        <div class="mx-auto flex w-full max-w-xl flex-col items-stretch gap-3 sm:flex-row">
          <label for="tc-cta-phone" class="sr-only">Your mobile number</label>
          <input id="tc-cta-phone" type="tel" inputmode="tel" autocomplete="tel" placeholder="Your mobile number" class="min-w-0 flex-1 rounded-full border border-up-line bg-white px-6 py-4 text-[0.95rem] text-up-ink outline-none transition-colors placeholder:text-up-muted/60 focus:border-up-accent">
          <button type="submit" class="accent-fill shrink-0 rounded-full px-8 py-4 text-[0.9rem] font-bold transition-all hover:-translate-y-0.5">Book Demo</button>
        </div>
      </form>
    </div>
    <a data-anim="up" data-anim-delay="0.3" href="tel:<?= e($phoneRaw) ?>" class="group mt-8 inline-flex items-center gap-3.5 rounded-full bg-hero-600 py-3 pl-3 pr-7 text-left text-white shadow-[0_18px_45px_-16px_rgba(255,107,0,0.85)] transition-all hover:-translate-y-0.5 hover:bg-hero-glow">
      <span class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-white/20">
        <svg viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 3h3l2 5-2.5 1.5a12 12 0 0 0 6 6L16 13l5 2v3a2 2 0 0 1-2.2 2A17 17 0 0 1 4 5.2 2 2 0 0 1 6 3Z"/></svg>
      </span>
      <span class="leading-tight">
        <span class="block text-[0.62rem] font-bold uppercase tracking-[0.16em] text-white/70">Call now</span>
        <span class="block text-[1.05rem] font-extrabold"><?= e($phone) ?></span>
      </span>
    </a>
    <ul data-anim="fade" data-anim-delay="0.36" class="mt-10 flex flex-wrap items-center justify-center gap-x-6 gap-y-3 text-[0.88rem] text-up-muted">
      <?php foreach (['Free career counselling', 'No registration fee', 'Placement support included'] as $li): ?>
      <li class="flex items-center">
        <span class="inline-flex items-center gap-2">
          <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="shrink-0 text-up-bright"><circle cx="12" cy="12" r="9"/><path d="m8.4 12.2 2.5 2.5 4.7-5.2"/></svg><?= e($li) ?>
        </span>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

</main>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // ---- Support desk tabs ----
    var tabBtns = document.querySelectorAll('[data-desk]');
    var panels = document.querySelectorAll('[data-panel]');
    tabBtns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var key = btn.getAttribute('data-desk');
        tabBtns.forEach(function (b) {
          var on = b === btn;
          b.setAttribute('aria-selected', on ? 'true' : 'false');
          b.classList.toggle('bg-brand-600', on);
          b.classList.toggle('text-white', on);
          b.classList.toggle('shadow-lg', on);
          b.classList.toggle('shadow-brand-600/30', on);
          b.classList.toggle('text-up-muted', !on);
          b.classList.toggle('hover:bg-subtle', !on);
          b.classList.toggle('hover:text-up-ink', !on);
        });
        panels.forEach(function (p) {
          p.classList.toggle('hidden', p.getAttribute('data-panel') !== key);
        });
      });
    });

    // ---- FAQ accordion (single open) ----
    var group = document.querySelector('[data-faq-group]');
    if (group) {
      group.querySelectorAll('.glass-dark').forEach(function (item) {
        var btn = item.querySelector('button');
        var body = item.querySelector('[data-faq-body]');
        var label = btn ? btn.querySelector('span') : null;
        var icon = btn ? btn.querySelector('span:last-child') : null;
        if (!btn || !body) return;
        btn.addEventListener('click', function () {
          var isOpen = btn.getAttribute('aria-expanded') === 'true';
          group.querySelectorAll('.glass-dark').forEach(function (i) {
            var b = i.querySelector('button');
            var bd = i.querySelector('[data-faq-body]');
            var lb = b ? b.querySelector('span') : null;
            var ic = b ? b.querySelector('span:last-child') : null;
            if (!b || !bd) return;
            b.setAttribute('aria-expanded', 'false');
            bd.classList.remove('grid-rows-[1fr]', 'opacity-100');
            bd.classList.add('grid-rows-[0fr]', 'opacity-0');
            i.classList.remove('!border-accent-glow/35', '!bg-white/[0.11]');
            if (lb) { lb.classList.remove('text-accent-glow'); lb.classList.add('text-white'); }
            if (ic) { ic.classList.remove('rotate-45', 'bg-accent-glow', 'text-brand-700'); ic.classList.add('bg-white/10', 'text-up-soft/70'); }
          });
          if (!isOpen) {
            btn.setAttribute('aria-expanded', 'true');
            body.classList.remove('grid-rows-[0fr]', 'opacity-0');
            body.classList.add('grid-rows-[1fr]', 'opacity-100');
            item.classList.add('!border-accent-glow/35', '!bg-white/[0.11]');
            if (label) { label.classList.add('text-accent-glow'); label.classList.remove('text-white'); }
            if (icon) { icon.classList.add('rotate-45', 'bg-accent-glow', 'text-brand-700'); icon.classList.remove('bg-white/10', 'text-up-soft/70'); }
          }
        });
      });
    }

    // ---- Enquiry form ----
    var form = document.getElementById('tcContactForm');
    if (form) {
      var msgBox = document.getElementById('tcFormMsg');
      var submitBtn = form.querySelector('button[type="submit"]');
      function showMsg(ok, text) {
        if (!msgBox) return;
        msgBox.textContent = text;
        msgBox.classList.remove('hidden', 'text-green-600', 'text-red-600');
        msgBox.classList.add(ok ? 'text-green-600' : 'text-red-600');
      }
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        var name = (document.getElementById('tc-name').value || '').trim();
        var phone = (document.getElementById('tc-phone').value || '').trim();
        var email = (document.getElementById('tc-email').value || '').trim();
        var course = document.getElementById('tc-course').value || '';
        var mode = document.getElementById('tc-mode').value || '';
        var message = (document.getElementById('tc-message').value || '').trim();

        if (name.length < 2) { showMsg(false, 'Please enter your name.'); return; }
        if (phone.replace(/\D/g, '').length < 10) { showMsg(false, 'Please enter a valid 10-digit mobile number.'); return; }
        if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { showMsg(false, 'Please enter a valid email address.'); return; }

        var full = message;
        if (mode) full += (full ? '\n' : '') + 'Preferred session: ' + mode;
        if (full.trim().length < 10) full = 'Enquiry from the contact page. Preferred session: ' + (mode || 'Morning') + '. ' + message;

        var data = new FormData();
        data.append('csrf_token', form.querySelector('input[name="csrf_token"]').value);
        data.append('name', name);
        data.append('phone', phone);
        data.append('email', email);
        data.append('course', course);
        data.append('message', full);

        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-70');
        fetch('<?= SITE_URL ?>/ajax/contact.php', { method: 'POST', body: data })
          .then(function (r) { return r.json(); })
          .then(function (res) {
            showMsg(!!res.success, res.message || (res.success ? 'Thank you! We will call you back.' : 'Something went wrong. Please try again.'));
            if (res.success) form.reset();
          })
          .catch(function () { showMsg(false, 'Network error. Please try again or call us directly.'); })
          .finally(function () { submitBtn.disabled = false; submitBtn.classList.remove('opacity-70'); });
      });
    }

    // ---- Closing CTA (phone only) ----
    var cta = document.getElementById('tcCtaForm');
    if (cta) {
      cta.addEventListener('submit', function () {
        var p = document.getElementById('tc-cta-phone');
        if (p && p.value && p.value.trim().replace(/\D/g, '').length >= 10) {
          if (typeof window.openEnquiry === 'function') { window.openEnquiry('Free Demo'); }
          else { location.href = '#enquiry'; }
        } else if (p) {
          p.focus();
        }
      });
    }
  });
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
