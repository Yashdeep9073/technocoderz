<?php
// ============================================================
// Techno Coderz — Online Certificate Verification
// Layout & structure replicated same-to-same from
// techcaddmohali.com/verify-certificate:
//   hero (with embedded verify card) -> Verification Procedure (4
//   steps) -> Anti-Fraud & Authenticity (4 cards) -> Dedicated
//   Verification Desk -> Where to go next -> closing CTA.
// Rebuilt in the Techno Coderz orange theme with our own data and
// looked up against the `certificates` table.
// ============================================================
require_once __DIR__ . '/includes/functions.php';

$pageTitle       = 'Online Certificate Verification & Credential Authenticity – Techno Coderz';
$pageDescription = 'Verify the authenticity of any Techno Coderz certificate or internship letter. Enter the candidate roll number printed on the document for an instant registry lookup.';
$currentPage     = 'certificate-verification';
$csrf            = generateCsrfToken();

$pdo = getDB();

// ---- Settings (contact details) ----
$settings = [];
try {
    foreach ($pdo->query("SELECT setting_key, setting_value FROM site_settings") as $row) {
        if (trim($row['setting_value'] ?? '') !== '') {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
    }
} catch (Throwable $e) {
    error_log('Cert-verify settings: ' . $e->getMessage());
}
$phone    = $settings['phone'] ?? '+91 98765 43210';
$email    = $settings['email'] ?? 'info@technocoderz.com';
$phoneRaw = preg_replace('/\D/', '', $phone);

// ---- Verification lookup ----
$certQuery        = '';
$certResult       = null;   // array = found, false = not found, null = no search yet
$certError        = '';
$certTableMissing = false;

$raw = trim((string) ($_POST['cert_no'] ?? $_GET['id'] ?? ''));
if ($raw !== '') {
    $certQuery = strtoupper(preg_replace('/\s+/', '', $raw));
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $certError = 'Your session expired. Please refresh the page and try again.';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM certificates WHERE cert_no = ? AND status = 1 LIMIT 1");
            $stmt->execute([$certQuery]);
            $certResult = $stmt->fetch() ?: false;
        } catch (Throwable $e) {
            $certTableMissing = true;
            error_log('Cert-verify lookup: ' . $e->getMessage());
        }
    }
}

// ---- Hero trust chips ----
$trustChips = [
    ['Authentic Credentials', '<path d="M12 3l7 3v5c0 4.4-3 8.4-7 10-4-1.6-7-5.6-7-10V6l7-3Z"/><path d="m9 12 2 2 4-4"/>'],
    ['Instant Online Check', '<path d="M13 2 4 14h6l-1 8 9-12h-6l1-8Z"/>'],
    ['No Login Required', '<rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0"/>'],
    ['Employer &amp; BGV Ready', '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 12h18"/>'],
];

// ---- Verification procedure (4 steps) ----
$steps = [
    ['n' => '01', 'title' => 'Locate Candidate Roll Number',
     'text' => 'Check the top-right corner of the official Techno Coderz certificate or training / internship letter for the unique registration code (for example TC-2025-0001).'],
    ['n' => '02', 'title' => 'Submit Verification Request',
     'text' => 'Enter the roll number in the box above, or email our Verification Desk with the candidate&rsquo;s authorisation consent.'],
    ['n' => '03', 'title' => 'Immediate Record Validation',
     'text' => 'Our secure registry validates the candidate name, course discipline, training tenure, project details and the letter&rsquo;s issue date &mdash; instantly.'],
    ['n' => '04', 'title' => 'Official HR Confirmation',
     'text' => 'Employers and BGV agencies can request an official digital sign-off report, issued on Techno Coderz letterhead within 24 to 48 business hours.'],
];

// ---- Anti-fraud & authenticity (4 cards) ----
$security = [
    ['title' => 'Unique Registration Number',
     'text' => 'Every credential carries a unique, non-transferable registration number mapped to the student&rsquo;s training and project archive.',
     'icon' => '<rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 7h8M8 11h8M8 15h5"/>'],
    ['title' => 'Authenticity Mark &amp; Seal',
     'text' => 'Each certificate is issued under signature and seal so the physical document can always be matched against our central record.',
     'icon' => '<path d="M12 3l7 3v5c0 4.4-3 8.4-7 10-4-1.6-7-5.6-7-10V6l7-3Z"/><path d="m9 12 2 2 4-4"/>'],
    ['title' => 'Verifiable Training &amp; Internship Letter',
     'text' => 'Internship letters document the live project tenure, mentor sign-off and the exact technology stack the candidate worked on.',
     'icon' => '<path d="M14 3v4a1 1 0 0 0 1 1h4"/><path d="M17 21H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7l5 5v11a2 2 0 0 1-2 2Z"/><path d="M9 13h6M9 17h4"/>'],
    ['title' => 'Centralised Registry Database',
     'text' => 'Records are held in a persistent digital registry, accessible to employers, BGV agencies and universities on request.',
     'icon' => '<ellipse cx="12" cy="6" rx="8" ry="3"/><path d="M4 6v6c0 1.7 3.6 3 8 3s8-1.3 8-3V6"/><path d="M4 12v6c0 1.7 3.6 3 8 3s8-1.3 8-3v-6"/>'],
];

// ---- Where to go next ----
$nextCards = [
    ['href' => SITE_URL . '/courses.php', 'eyebrow' => 'Courses', 'cta' => 'Browse all courses',
     'title' => 'Every track, duration and technology we teach',
     'text' => 'AI &amp; Data Science, full stack, cyber security, cloud &amp; DevOps, digital marketing, programming and CAD — all with live projects.',
     'icon' => '<path d="M4 5h16v14H4z"/><path d="M8 9h8M8 13h5"/>'],
    ['href' => SITE_URL . '/about.php', 'eyebrow' => 'About us', 'cta' => 'More about us',
     'title' => 'The standard behind every certificate we issue',
     'text' => 'Who we are, how we teach, and the assessments a student must clear before a Techno Coderz credential is issued.',
     'icon' => '<path d="m12 3 2.6 5.6 6.1.8-4.5 4.2 1.2 6-5.4-3-5.4 3 1.2-6L3.3 9.4l6.1-.8L12 3Z"/>'],
    ['href' => SITE_URL . '/contact.php', 'eyebrow' => 'Visit or book a demo', 'cta' => 'Get in touch',
     'title' => 'Campus details, timings, fees and EMI options',
     'text' => 'Reach the Mohali campus, confirm a session time — or book a free demo class before you commit to anything.',
     'icon' => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"/>'],
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

<!-- ============ HERO + VERIFY CARD ============ -->
<section class="relative overflow-hidden bg-gradient-to-br from-brand-900 via-hero-600 to-brand-700 pb-20 pt-[7.5rem] text-white lg:pb-24 lg:pt-[11rem]">
  <div class="absolute inset-0 bg-[radial-gradient(ellipse_75%_70%_at_15%_0%,rgba(255,194,61,0.28)_0%,transparent_60%),radial-gradient(ellipse_60%_60%_at_92%_35%,rgba(255,255,255,0.16)_0%,transparent_55%)]"></div>
  <div class="absolute inset-0 grid-lines opacity-60"></div>
  <div class="glow-blob right-[3%] top-[8%] h-[360px] w-[360px] bg-accent-glow/20"></div>

  <div class="relative mx-auto grid max-w-6xl items-center gap-12 px-5 sm:px-8 lg:grid-cols-[1.05fr_0.95fr]">
    <!-- Left: copy -->
    <div>
      <nav aria-label="Breadcrumb" class="mb-6 flex flex-wrap items-center gap-2 text-[0.72rem] font-semibold uppercase tracking-[0.16em] text-up-soft/75">
        <a href="<?= SITE_URL ?>/index.php" class="transition-colors hover:text-white">Home</a>
        <span class="text-up-soft/40">/</span>
        <a href="<?= SITE_URL ?>/courses.php" class="transition-colors hover:text-white">Resources</a>
        <span class="text-up-soft/40">/</span>
        <span class="text-white">Verify Certificate</span>
      </nav>
      <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-1.5 text-[0.7rem] font-bold uppercase tracking-[0.18em] text-up-soft">
        <span class="h-1.5 w-1.5 rounded-full bg-accent-yellow"></span>Official Credential Registry
      </span>
      <h1 class="mt-5 font-display text-4xl font-extrabold leading-[1.06] tracking-tight sm:text-5xl lg:text-[3.3rem]">Online Certificate Verification &amp; Credential Authenticity</h1>
      <p class="mt-6 max-w-xl text-base leading-relaxed text-up-soft/90">For employers, background-verification agencies, colleges and students. Verify the authenticity of certificates and internship letters issued by Techno Coderz, Mohali.</p>
      <ul class="mt-8 flex flex-wrap gap-x-3 gap-y-3">
        <?php foreach ($trustChips as $chip): ?>
        <li class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-3.5 py-2 text-[0.78rem] font-semibold text-up-soft">
          <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="text-accent-glow"><?= $chip[1] ?></svg>
          <?= $chip[0] ?>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <!-- Right: verify card -->
    <div class="w-full">
      <div id="result" class="scroll-mt-32 overflow-hidden rounded-[1.75rem] border border-white/15 bg-white shadow-[0_45px_120px_-55px_rgba(0,0,0,0.7)]">
        <div class="relative overflow-hidden bg-gradient-to-br from-hero-600 to-brand-700 px-7 py-6 text-white">
          <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_85%_15%,rgba(255,194,61,0.35),transparent_45%)]"></div>
          <div class="relative flex items-start gap-3.5">
            <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-white/15 ring-1 ring-white/25">
              <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l7 3v5c0 4.4-3 8.4-7 10-4-1.6-7-5.6-7-10V6l7-3Z"/><path d="m9 12 2 2 4-4"/></svg>
            </span>
            <div>
              <h2 class="font-display text-xl font-extrabold leading-tight">Verify Student Credential</h2>
              <p class="mt-1 text-[0.82rem] leading-relaxed text-up-soft/90">Enter the candidate roll number exactly as printed on the certificate or internship letter.</p>
            </div>
          </div>
        </div>

        <div class="p-7">
          <form method="post" action="<?= SITE_URL ?>/certificate-verification.php#result" novalidate>
            <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
            <label for="cert_no" class="mb-2 block text-[0.7rem] font-bold uppercase tracking-[0.14em] text-up-muted">Candidate Roll / Registration Number</label>
            <div class="flex flex-col gap-3 sm:flex-row">
              <div class="relative flex-1">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-up-muted"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 7h8M8 11h8M8 15h5"/></svg>
                <input type="text" id="cert_no" name="cert_no" value="<?= e($certQuery) ?>" required autocomplete="off" spellcheck="false"
                       placeholder="e.g. TC-2025-0001"
                       class="w-full rounded-2xl border border-line bg-subtle py-3.5 pl-12 pr-4 text-[0.95rem] font-semibold text-up-ink outline-none transition-all placeholder:font-normal placeholder:text-up-muted/70 focus:border-hero-600 focus:bg-white focus:ring-4 focus:ring-hero-600/10">
              </div>
              <button type="submit" class="group inline-flex shrink-0 items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-hero-600 to-hero-glow px-8 py-3.5 text-sm font-bold text-white shadow-lg shadow-hero-600/25 transition-all hover:-translate-y-0.5 hover:shadow-xl hover:shadow-hero-glow/30">
                Verify
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform group-hover:translate-x-1"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
              </button>
            </div>
          </form>

          <!-- ============ RESULT ============ -->
          <?php if ($certError !== ''): ?>
            <div class="mt-5 flex items-start gap-3 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-rose-800">
              <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="mt-0.5 shrink-0"><circle cx="12" cy="12" r="9"/><path d="M12 8v4M12 16h.01"/></svg>
              <p class="text-sm font-semibold leading-relaxed"><?= e($certError) ?></p>
            </div>
          <?php elseif ($certTableMissing): ?>
            <div class="mt-5 flex items-start gap-3 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-amber-800">
              <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="mt-0.5 shrink-0"><path d="M12 3l9 16H3L12 3Z"/><path d="M12 10v4M12 18h.01"/></svg>
              <p class="text-sm font-semibold leading-relaxed">Verification is temporarily unavailable. Please contact the centre and we will confirm your certificate manually.</p>
            </div>
          <?php elseif ($certResult === false): ?>
            <div class="mt-5 rounded-2xl border border-rose-200 bg-rose-50 p-5">
              <div class="flex items-start gap-3.5">
                <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-rose-100 text-rose-600">
                  <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="m9 9 6 6M15 9l-6 6"/></svg>
                </span>
                <div>
                  <h3 class="font-display text-base font-extrabold text-rose-900">No certificate found</h3>
                  <p class="mt-1 text-sm leading-relaxed text-rose-800/90">We could not find a record matching <span class="font-bold"><?= e($certQuery) ?></span>. Please double-check the number and try again, or contact us and our team will verify it for you.</p>
                  <div class="mt-4 flex flex-wrap gap-3">
                    <a href="<?= SITE_URL ?>/certificate-verification.php" class="inline-flex items-center gap-2 rounded-full border border-rose-300 bg-white px-4 py-2 text-[0.82rem] font-bold text-rose-700 transition-all hover:-translate-y-0.5">&larr; Try another number</a>
                    <a href="tel:<?= e($phoneRaw) ?>" class="inline-flex items-center gap-2 rounded-full bg-hero-600 px-4 py-2 text-[0.82rem] font-bold text-white transition-all hover:-translate-y-0.5">
                      <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"/></svg>
                      Call us
                    </a>
                  </div>
                </div>
              </div>
            </div>
          <?php elseif (is_array($certResult)): ?>
            <div class="mt-5 overflow-hidden rounded-2xl border border-emerald-200">
              <div class="flex items-center gap-3 border-b border-emerald-200 bg-emerald-50 px-5 py-4">
                <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-emerald-500 text-white shadow-lg shadow-emerald-500/30">
                  <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m5 13 4 4 10-11"/></svg>
                </span>
                <div>
                  <h3 class="font-display text-base font-extrabold text-emerald-900">Certificate verified</h3>
                  <p class="text-[0.82rem] text-emerald-800/80">This credential is authentic and present in our records.</p>
                </div>
                <span class="ml-auto hidden rounded-full bg-emerald-500/15 px-3 py-1 text-[0.66rem] font-bold uppercase tracking-[0.14em] text-emerald-700 sm:inline-block">Valid</span>
              </div>
              <dl class="grid grid-cols-1 gap-px bg-line sm:grid-cols-2">
                <div class="bg-white px-5 py-4">
                  <dt class="text-[0.66rem] font-bold uppercase tracking-[0.14em] text-up-muted">Certificate Number</dt>
                  <dd class="mt-1 font-display text-[1.05rem] font-extrabold text-up-ink"><?= e($certResult['cert_no']) ?></dd>
                </div>
                <div class="bg-white px-5 py-4">
                  <dt class="text-[0.66rem] font-bold uppercase tracking-[0.14em] text-up-muted">Student Name</dt>
                  <dd class="mt-1 font-display text-[1.05rem] font-extrabold text-up-ink"><?= e($certResult['student_name']) ?></dd>
                </div>
                <div class="bg-white px-5 py-4 sm:col-span-2">
                  <dt class="text-[0.66rem] font-bold uppercase tracking-[0.14em] text-up-muted">Course</dt>
                  <dd class="mt-1 text-[0.95rem] font-bold text-up-ink"><?= e($certResult['course_title']) ?></dd>
                </div>
                <?php if (!empty($certResult['duration'])): ?>
                <div class="bg-white px-5 py-4">
                  <dt class="text-[0.66rem] font-bold uppercase tracking-[0.14em] text-up-muted">Duration</dt>
                  <dd class="mt-1 text-[0.95rem] font-bold text-up-ink"><?= e($certResult['duration']) ?></dd>
                </div>
                <?php endif; ?>
                <?php if (!empty($certResult['grade'])): ?>
                <div class="bg-white px-5 py-4">
                  <dt class="text-[0.66rem] font-bold uppercase tracking-[0.14em] text-up-muted">Grade</dt>
                  <dd class="mt-1 text-[0.95rem] font-bold text-up-ink"><?= e($certResult['grade']) ?></dd>
                </div>
                <?php endif; ?>
                <div class="bg-white px-5 py-4">
                  <dt class="text-[0.66rem] font-bold uppercase tracking-[0.14em] text-up-muted">Issue Date</dt>
                  <dd class="mt-1 text-[0.95rem] font-bold text-up-ink"><?= e(date('d M Y', strtotime($certResult['issue_date']))) ?></dd>
                </div>
                <div class="bg-white px-5 py-4">
                  <dt class="text-[0.66rem] font-bold uppercase tracking-[0.14em] text-up-muted">Status</dt>
                  <dd class="mt-1 inline-flex items-center gap-2 text-[0.95rem] font-bold text-emerald-600">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span> Record active
                  </dd>
                </div>
              </dl>
              <div class="flex flex-wrap items-center gap-3 border-t border-line bg-subtle px-5 py-4">
                <?php if (!empty($certResult['course_slug'])): ?>
                <a href="<?= e(coursePageUrl($certResult['course_slug'])) ?>" class="inline-flex items-center gap-2 rounded-full bg-hero-600 px-4 py-2 text-[0.82rem] font-bold text-white transition-all hover:-translate-y-0.5">View the course <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg></a>
                <?php endif; ?>
                <a href="<?= SITE_URL ?>/certificate-verification.php" class="inline-flex items-center gap-2 rounded-full border border-line bg-white px-4 py-2 text-[0.82rem] font-bold text-up-ink transition-all hover:-translate-y-0.5 hover:border-hero-600 hover:text-hero-600">Verify another</a>
              </div>
            </div>
          <?php endif; ?>

          <p class="mt-5 text-xs leading-relaxed text-up-muted">
            <span class="font-bold text-up-ink">For Corporate BGV requests:</span>
            You can also email scanned copies of the candidate credential directly to
            <a href="mailto:<?= e($email) ?>" class="font-semibold text-hero-600 underline decoration-hero-600/30 underline-offset-2 hover:decoration-hero-600"><?= e($email) ?></a>
            with the candidate&rsquo;s consent letter for written verification on official letterhead.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ VERIFICATION PROCEDURE ============ -->
<section class="bg-white py-20 lg:py-24">
  <div class="mx-auto max-w-6xl px-5 sm:px-8">
    <div class="max-w-2xl">
      <span class="text-[0.72rem] font-bold uppercase tracking-[0.2em] text-hero-600">Verification Procedure</span>
      <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-up-ink sm:text-4xl">How the credential validation works</h2>
      <p class="mt-4 text-[0.97rem] leading-relaxed text-up-muted">A standardised process designed to ensure speed, accuracy and transparency for employers and verification agencies.</p>
    </div>
    <div class="mt-14 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
      <?php foreach ($steps as $s): ?>
      <div class="group relative rounded-3xl border border-line bg-subtle p-7 transition-all duration-300 hover:-translate-y-1 hover:border-hero-600/30 hover:bg-white hover:shadow-[0_30px_70px_-50px_rgba(122,50,0,0.5)]">
        <div class="flex items-center gap-3">
          <span class="grid h-11 w-11 place-items-center rounded-xl bg-gradient-to-br from-hero-600 to-hero-glow font-display text-sm font-extrabold text-white shadow-lg shadow-hero-600/25"><?= e($s['n']) ?></span>
          <span class="h-px flex-1 bg-line"></span>
        </div>
        <h3 class="mt-5 font-display text-[1.05rem] font-extrabold text-up-ink"><?= e($s['title']) ?></h3>
        <p class="mt-3 text-sm leading-relaxed text-up-muted"><?= $s['text'] ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ ANTI-FRAUD & AUTHENTICITY ============ -->
<section class="bg-subtle py-20 lg:py-24">
  <div class="mx-auto max-w-6xl px-5 sm:px-8">
    <div class="mx-auto max-w-2xl text-center">
      <span class="text-[0.72rem] font-bold uppercase tracking-[0.2em] text-hero-600">Anti-Fraud &amp; Authenticity</span>
      <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-up-ink sm:text-4xl">Security features on every Techno Coderz credential</h2>
      <p class="mt-4 text-[0.97rem] leading-relaxed text-up-muted">We maintain strict physical and digital protocols on all certificates and internship letters we issue.</p>
    </div>
    <div class="mt-14 grid gap-6 md:grid-cols-2">
      <?php foreach ($security as $f): ?>
      <div class="flex items-start gap-5 rounded-3xl border border-line bg-white p-7 transition-all duration-300 hover:-translate-y-1 hover:border-hero-600/30 hover:shadow-[0_30px_70px_-50px_rgba(122,50,0,0.5)]">
        <span class="grid h-13 w-13 shrink-0 place-items-center rounded-2xl bg-brand-50 text-hero-600" style="height:3.25rem;width:3.25rem">
          <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?= $f['icon'] ?></svg>
        </span>
        <div>
          <h3 class="font-display text-[1.05rem] font-extrabold text-up-ink"><?= $f['title'] ?></h3>
          <p class="mt-2 text-sm leading-relaxed text-up-muted"><?= $f['text'] ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ DEDICATED VERIFICATION DESK ============ -->
<section class="px-5 pb-24 sm:px-8">
  <div class="mx-auto max-w-6xl">
    <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-hero-600 to-brand-700 px-7 py-12 text-white shadow-[0_40px_100px_-60px_rgba(122,50,0,0.7)] sm:px-12 lg:py-14">
      <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_85%_20%,rgba(255,194,61,0.35),transparent_40%),radial-gradient(circle_at_10%_90%,rgba(255,255,255,0.16),transparent_38%)]"></div>
      <div class="absolute inset-0 grid-lines opacity-30"></div>
      <div class="relative flex flex-col items-start justify-between gap-8 lg:flex-row lg:items-center">
        <div class="max-w-2xl">
          <span class="text-[0.72rem] font-bold uppercase tracking-[0.2em] text-up-soft/80">Dedicated Verification Desk</span>
          <h2 class="mt-3 font-display text-2xl font-extrabold leading-tight sm:text-3xl">Need priority verification for urgent onboarding?</h2>
          <p class="mt-4 text-[0.97rem] leading-relaxed text-up-soft/90">Our verification desk is available Monday to Saturday, 8 AM to 8 PM, to process employer and background-check requests.</p>
        </div>
        <div class="flex shrink-0 flex-wrap gap-3">
          <a href="tel:<?= e($phoneRaw) ?>" class="inline-flex items-center gap-2 rounded-full bg-white px-7 py-3.5 text-sm font-bold text-hero-900 shadow-xl transition-all hover:-translate-y-0.5 hover:shadow-2xl">
            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"/></svg>
            Call <?= e($phone) ?>
          </a>
          <a href="mailto:<?= e($email) ?>" class="inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/5 px-7 py-3.5 text-sm font-bold text-white transition-all hover:-translate-y-0.5 hover:bg-white/10">
            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
            Email us
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

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

    <form id="tcCertCta" class="mx-auto mt-8 flex max-w-xl flex-col gap-3 sm:flex-row" novalidate>
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
  var cta = document.getElementById('tcCertCta');
  if (cta) {
    cta.addEventListener('submit', function (e) {
      e.preventDefault();
      if (typeof window.openEnquiry === 'function') { window.openEnquiry('Free Demo'); }
    });
  }
})();
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
