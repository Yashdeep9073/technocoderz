<?php
// ============================================================
// Techno Coderz — Brochure (curriculum preview + gated PDF)
// Layout reference: DreamsLMS contact page (contact-us)
//   breadcrumb banner → 3 info cards → rounded intro + form panel
//   → catalog → syllabus → highlights → CTA
// All data + the real PDF lead-capture flow are preserved.
// ============================================================
require_once __DIR__ . '/includes/functions.php';

$pageTitle       = 'Download Brochure – Techno Coderz';
$pageDescription = 'Preview the TechnoCoderz course modules and download the official curriculum brochure (PDF) for AI/ML & Data Science, Full Stack, DevSecOps / Cyber Security and DevOps | CI/CD.';
$currentPage     = 'brochure';
$csrf            = generateCsrfToken();

$pdo = getDB();

// --- Lead capture: submitted from this page, then the PDF is released ---
$flash = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token  = $_POST['csrf_token'] ?? '';
    $name   = sanitize($_POST['name'] ?? '');
    $email  = sanitize($_POST['email'] ?? '');
    $phone  = sanitize($_POST['phone'] ?? '');
    $course = sanitize($_POST['course'] ?? '');

    $errors = [];
    if (!verifyCsrfToken($token))          $errors[] = 'Security token expired. Please refresh the page.';
    if (strlen($name) < 2)                 $errors[] = 'Please enter your full name.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email address.';
    if (preg_replace('/\D/', '', $phone) === '' || strlen(preg_replace('/\D/', '', $phone)) < 10) $errors[] = 'Please enter a valid 10-digit mobile number.';
    if ($course === '')                    $errors[] = 'Please select the course you are interested in.';

    if ($errors) {
        $flash = ['type' => 'danger', 'text' => implode(' ', $errors)];
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO enquiries (name, email, phone, course, message, status) VALUES (?, ?, ?, ?, ?, 'new')");
            $stmt->execute([$name, $email, $phone, $course, 'Brochure / curriculum PDF downloaded from brochure.php']);
            $_SESSION['brochure_lead'] = ['name' => $name, 'email' => $email, 'at' => time()];
            $_SESSION['brochure_access'] = 1;
            header('Location: ' . SITE_URL . '/brochure.php?status=downloaded');
            exit;
        } catch (PDOException $ex) {
            error_log('Brochure lead error: ' . $ex->getMessage());
            $flash = ['type' => 'danger', 'text' => 'We could not save your details. Please try again.'];
        }
    }
}

$status   = $_GET['status'] ?? '';
$courses  = $pdo->query("SELECT * FROM courses WHERE status = 1 ORDER BY sort_order ASC, id ASC")->fetchAll();
$already  = !empty($_SESSION['brochure_access']);

$brochureMeta = [
    'name' => 'TechnoCoderz Curriculum Brochure',
    'file' => 'technocoderz-brochure.pdf',
    'size' => file_exists(__DIR__ . '/assets/downloads/technocoderz-brochure.pdf')
                ? round(filesize(__DIR__ . '/assets/downloads/technocoderz-brochure.pdf') / 1024) . ' KB'
                : 'PDF',
];

$inside = [
    ['icon' => 'bi-journal-text',       'text' => 'Complete module-wise syllabus for every programme'],
    ['icon' => 'bi-clock-history',      'text' => 'Batch timings, duration & course schedule'],
    ['icon' => 'bi-people-fill',        'text' => 'Mentorship, projects and placement process'],
    ['icon' => 'bi-patch-check-fill',   'text' => 'Certification and eligibility details'],
];

// --- Institute details (read-only) -------------------------------------
$siteSettings = [];
try {
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
    while ($row = $stmt->fetch()) {
        if (trim($row['setting_value'] ?? '') !== '') {
            $siteSettings[$row['setting_key']] = $row['setting_value'];
        }
    }
} catch (Exception $ex) {
    $siteSettings = $siteSettings ?: [];
}
$siteName    = $siteSettings['site_name']    ?? 'Techno Coderz';
$siteTagline = $siteSettings['tagline']      ?? 'Build Skills. Create Projects. Grow Your Tech Career.';
$sitePhone   = $siteSettings['phone']        ?? '+91 98765 43210';
$siteEmail   = $siteSettings['email']        ?? 'info@technocoderz.com';
$siteAddress = $siteSettings['address']      ?? 'Mohali, Punjab, India';
$siteLoc     = $siteSettings['location']     ?? 'Mohali, Punjab';

// --- Catalog summary numbers ------------------------------------------
$totalCourses = count($courses);
$totalLessons = array_sum(array_column($courses, 'lessons'));
$heroCtaHref  = $already ? (SITE_URL . '/download-brochure.php') : '#download';

$highlights = [
    ['icon' => 'bi-rocket-takeoff-fill', 'title' => 'Hands-on Projects',
     'text'  => 'Every programme ships with real, portfolio-grade builds — dashboards, APIs, pipelines and capstones reviewed by mentors.'],
    ['icon' => 'bi-patch-check-fill',    'title' => 'Certifications',
     'text'  => 'Earn a verified TechnoCoderz certificate plus course-aligned credentials that recruiters actually recognise.'],
    ['icon' => 'bi-briefcase-fill',      'title' => 'Career Support',
     'text'  => 'Resume clinics, mock interviews, mock HR rounds and direct referrals until you are placed.'],
    ['icon' => 'bi-person-video3',       'title' => 'Mentorship',
     'text'  => 'Live 1:1 mentorship from working engineers, weekly code reviews and dedicated doubt-clearing sessions.'],
];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<script>window.TC_BASE_URL = '<?= SITE_URL ?>';</script>

<style>
/* ============================================================
   Brochure page (scoped) — DreamsLMS contact-us layout
   ============================================================ */

/* Rounded intro + form panel (DreamsLMS "bg-light border rounded-4") */
.bc-panel {
  background: #F1F4F9;
  border: 1px solid rgba(30, 41, 59, 0.08);
  border-radius: 26px;
  padding: 40px;
  margin-top: 26px;
}
.bc-panel-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 26px; }
.bc-inside-list { list-style: none; padding: 0; margin: 0; display: grid; grid-template-columns: 1fr; gap: 12px; }
.bc-inside-list li { display: flex; align-items: flex-start; gap: 12px; font-size: 0.94rem; color: var(--text-body); line-height: 1.55; }
.bc-inside-list .ic {
  width: 40px; height: 40px; flex-shrink: 0; border-radius: 12px; display: inline-flex;
  align-items: center; justify-content: center; font-size: 1.05rem;
  color: var(--primary-orange); background: rgba(255, 107, 0, 0.12);
}

/* Form card (DreamsLMS card card-body) */
.bc-form-card {
  background: #ffffff; border: 1px solid rgba(30, 41, 59, 0.08); border-radius: 22px;
  padding: 32px; box-shadow: 0 18px 44px rgba(30, 41, 59, 0.08);
}
.bc-form-card h3 { font-family: var(--tc-font-head); font-size: 1.25rem; font-weight: 700; color: var(--text-dark); margin: 0 0 6px; }
.bc-form-card > p { font-size: 0.94rem; color: var(--text-muted); margin: 0 0 22px; }
.bc-form-card .tc-btn { width: 100%; justify-content: center; }

/* Info cards (3 across at lg) */
@media (min-width: 992px) { .tc-brochure-contact { grid-template-columns: repeat(3, 1fr); } }

/* Section heading helper */
.bc-head { max-width: 720px; margin: 0 auto 34px; text-align: center; }
.bc-head .tc-section-title { margin-bottom: 12px; }
.bc-head p { color: var(--text-muted); font-size: 1rem; margin: 0; }

/* Catalog overview cards */
.bc-catalog { display: grid; grid-template-columns: minmax(0, 1fr); gap: 20px; }
.bc-cat-card {
  background: #ffffff; border: 1px solid rgba(30, 41, 59, 0.09); border-radius: 20px; padding: 24px;
  box-shadow: 0 8px 26px rgba(30, 41, 59, 0.06); display: flex; flex-direction: column; height: 100%;
  transition: transform .3s cubic-bezier(.4,0,.2,1), box-shadow .3s cubic-bezier(.4,0,.2,1), border-color .3s;
}
.bc-cat-card:hover { transform: translateY(-5px); border-color: rgba(255, 107, 0, 0.35); box-shadow: 0 18px 40px rgba(30, 41, 59, 0.11); }
.bc-cat-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 12px; }
.bc-cat-num {
  font-family: var(--tc-font-head); font-size: .78rem; font-weight: 800; letter-spacing: 1px; color: var(--primary-orange);
  background: rgba(255, 107, 0, .10); border: 1px solid rgba(255, 107, 0, .22); border-radius: 999px; padding: 4px 11px;
}
.bc-cat-level {
  font-size: .68rem; font-weight: 800; letter-spacing: .7px; text-transform: uppercase; color: #084C61;
  background: rgba(8, 76, 97, .08); border: 1px solid rgba(8, 76, 97, .16); border-radius: 999px; padding: 4px 10px;
}
.bc-cat-card h3 { font-family: var(--tc-font-head); font-size: 1.06rem; font-weight: 700; color: var(--text-dark); line-height: 1.4; margin: 0 0 10px; }
.bc-cat-meta { display: flex; flex-wrap: wrap; gap: 12px; font-size: .76rem; font-weight: 700; color: var(--primary-orange); text-transform: uppercase; letter-spacing: .4px; margin-bottom: 14px; }
.bc-cat-modules { list-style: none; padding: 0; margin: 0 0 16px; display: flex; flex-direction: column; gap: 7px; }
.bc-cat-modules li { font-size: .83rem; line-height: 1.5; color: var(--text-body); display: flex; gap: 8px; align-items: flex-start; }
.bc-cat-modules li i { color: var(--primary-orange); font-size: .7rem; margin-top: 5px; }
.bc-cat-actions { margin-top: auto; display: flex; gap: 10px; flex-wrap: wrap; }

/* Interactive syllabus accordion */
.bc-toolbar { display: flex; justify-content: space-between; align-items: center; gap: 14px; flex-wrap: wrap; margin-bottom: 20px; }
.bc-toolbar-tabs { display: flex; gap: 8px; flex-wrap: wrap; }
.bc-tab {
  border: 1px solid rgba(30, 41, 59, .14); background: #ffffff; color: var(--text-dark); border-radius: 999px;
  padding: 8px 16px; font-size: .8rem; font-weight: 700; cursor: pointer; transition: all .25s ease;
}
.bc-tab:hover { border-color: var(--primary-orange); color: var(--primary-orange); }
.bc-tab.is-active { background: var(--primary-orange); border-color: var(--primary-orange); color: #ffffff; box-shadow: 0 6px 18px rgba(255, 107, 0, .28); }
.bc-expand { display: flex; gap: 8px; }
.bc-expand button {
  background: transparent; border: 1px dashed rgba(30, 41, 59, .24); color: var(--text-muted); border-radius: 999px;
  padding: 7px 14px; font-size: .76rem; font-weight: 700; cursor: pointer; transition: all .25s ease;
}
.bc-expand button:hover { border-color: var(--primary-orange); color: var(--primary-orange); }

.bc-acc {
  background: #ffffff; border: 1px solid rgba(30, 41, 59, .09); border-radius: 20px; margin-bottom: 14px;
  box-shadow: 0 6px 20px rgba(30, 41, 59, .05); overflow: hidden; transition: border-color .3s ease, box-shadow .3s ease;
}
.bc-acc.open { border-color: rgba(255, 107, 0, .34); box-shadow: 0 14px 34px rgba(30, 41, 59, .10); }
.bc-acc-head { display: flex; align-items: center; gap: 16px; width: 100%; padding: 20px 22px; background: none; border: 0; text-align: left; cursor: pointer; }
.bc-acc-head:hover .bc-acc-title { color: var(--primary-orange); }
.bc-acc-title { font-family: var(--tc-font-head); font-size: 1.02rem; font-weight: 700; color: var(--text-dark); margin: 0 0 6px; transition: color .25s ease; }
.bc-acc-meta { display: flex; flex-wrap: wrap; gap: 12px; font-size: .74rem; font-weight: 700; color: var(--primary-orange); text-transform: uppercase; letter-spacing: .4px; }
.bc-acc-toggle {
  margin-left: auto; width: 38px; height: 38px; flex-shrink: 0; border-radius: 12px; display: flex; align-items: center; justify-content: center;
  background: rgba(255, 107, 0, .10); color: var(--primary-orange); font-size: 1.05rem; transition: transform .3s ease, background .3s ease;
}
.bc-acc.open .bc-acc-toggle { transform: rotate(180deg); background: var(--primary-orange); color: #ffffff; }
.bc-acc-body { display: none; padding: 0 22px; }
.bc-acc.open .bc-acc-body { display: block; padding-bottom: 22px; }
.bc-acc-body .tc-module-list { margin-bottom: 16px; }
.bc-acc-skills { display: flex; flex-wrap: wrap; gap: 7px; padding-top: 14px; border-top: 1px dashed rgba(30, 41, 59, .14); }
.bc-acc-skills::before {
  content: 'Skills'; width: 100%; font-size: .68rem; font-weight: 800; letter-spacing: 1px; text-transform: uppercase;
  color: var(--text-muted); margin-bottom: 2px;
}

/* Highlights */
.bc-hl { display: grid; grid-template-columns: 1fr; gap: 20px; }
.bc-hl-card {
  background: #ffffff; border: 1px solid rgba(30, 41, 59, .09); border-radius: 20px; padding: 26px; height: 100%;
  box-shadow: 0 8px 26px rgba(30, 41, 59, .06); transition: transform .3s cubic-bezier(.4,0,.2,1), box-shadow .3s;
}
.bc-hl-card:hover { transform: translateY(-5px); box-shadow: 0 18px 40px rgba(30, 41, 59, .11); }
.bc-hl-icon {
  width: 54px; height: 54px; border-radius: 16px; display: flex; align-items: center; justify-content: center;
  font-size: 1.4rem; margin-bottom: 16px; color: var(--primary-orange); background: rgba(255, 107, 0, .10);
  border: 1px solid rgba(255, 107, 0, .22);
}
.bc-hl-card h3 { font-family: var(--tc-font-head); font-size: 1.05rem; font-weight: 700; color: var(--text-dark); margin: 0 0 8px; }
.bc-hl-card p { font-size: .88rem; line-height: 1.7; color: var(--text-body); margin: 0; }

.bc-cat-card, .bc-acc-body { overflow-wrap: anywhere; }

@media (min-width: 576px) {
  .bc-catalog { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  .bc-hl { grid-template-columns: repeat(2, 1fr); }
}
@media (min-width: 992px) {
  .bc-catalog { grid-template-columns: repeat(3, minmax(0, 1fr)); }
  .bc-hl { grid-template-columns: repeat(4, 1fr); }
}
@media (max-width: 767.98px) {
  .bc-panel { padding: 26px 20px; }
  .bc-form-card { padding: 24px 20px; }
}
@media (max-width: 575.98px) {
  .bc-acc-head { padding: 16px 16px; gap: 12px; }
  .bc-acc-body { padding: 0 16px; }
  .bc-acc.open .bc-acc-body { padding-bottom: 18px; }
}
</style>

<div class="tc-page-light tc-brochure-page">

<!-- ============ BANNER (FiStudy / DreamsLMS breadcrumb) ============ -->
<div class="tc-page-hero">
  <div class="container text-center reveal">
    <ul class="tc-breadcrumb">
      <li><a href="<?= SITE_URL ?>"><i class="bi bi-house-fill"></i> Home</a></li>
      <li class="sep">/</li>
      <li class="current">Brochure</li>
    </ul>
    <h1 class="tc-section-title" style="margin-bottom:10px;">Course <span>Brochure</span></h1>
    <p style="font-size:1.05rem; max-width:660px; margin:0 auto;">
      Explore the full <?= e($siteName) ?> catalogue — module-wise syllabus, batch schedule, projects and
      certification details — then download the official curriculum PDF.
    </p>
  </div>
</div>

<?php if ($status === 'downloaded'): ?>
<div class="container" style="margin-top:26px;">
  <div class="alert alert-success d-flex align-items-center" role="alert" style="border-radius:14px; border:none; background:#DCFCE7; color:#166534;">
    <i class="bi bi-check-circle-fill me-2"></i>
    <div><strong>Thank you!</strong> Your brochure download has started. Our team will also reach out within 24 hours.</div>
  </div>
</div>
<script>window.addEventListener('load',function(){setTimeout(function(){window.location.href='<?= SITE_URL ?>/download-brochure.php';},400);});</script>
<?php elseif ($status === 'locked'): ?>
<div class="container" style="margin-top:26px;">
  <div class="alert d-flex align-items-center" role="alert" style="border-radius:14px; border:none; background:var(--primary-orange-soft); color:var(--primary-orange-hover);">
    <i class="bi bi-info-circle-fill me-2"></i>
    <div>Please share your details in the Download section below — the PDF downloads instantly after that.</div>
  </div>
</div>
<?php endif; ?>

<!-- ============ INFO CARDS + INTRO/FORM PANEL (DreamsLMS contact-us) ============ -->
<section class="tc-section">
  <div class="container">

    <!-- 3 info cards -->
    <div class="tc-contact-cards tc-brochure-contact reveal">
      <div class="tc-contact-info--top">
        <div class="tc-contact-icon"><i class="bi bi-geo-alt-fill"></i></div>
        <div>
          <h3>Visit Us</h3>
          <p><?= e($siteAddress) ?></p>
        </div>
      </div>
      <div class="tc-contact-info--top">
        <div class="tc-contact-icon"><i class="bi bi-telephone-fill"></i></div>
        <div>
          <h3>Call Us</h3>
          <p><a class="tc-link" href="tel:<?= e(preg_replace('/\s+/', '', $sitePhone)) ?>"><?= e($sitePhone) ?></a></p>
          <p style="font-size:.78rem;">Mon – Sat, 9:00 AM – 7:00 PM</p>
        </div>
      </div>
      <div class="tc-contact-info--top">
        <div class="tc-contact-icon"><i class="bi bi-envelope-fill"></i></div>
        <div>
          <h3>Email Us</h3>
          <p><a class="tc-link" href="mailto:<?= e($siteEmail) ?>"><?= e($siteEmail) ?></a></p>
          <p style="font-size:.78rem;">Replies within 24 hours</p>
        </div>
      </div>
    </div>

    <!-- Rounded panel: intro (left) + lead-capture form (right) -->
    <div class="bc-panel reveal" id="download">
      <div class="row g-5 align-items-center">

        <div class="col-lg-6">
          <span class="tc-badge"><i class="bi bi-collection-fill"></i> Course Catalog <?= date('Y') ?></span>
          <h2 class="tc-section-title" style="margin:16px 0 14px; font-size:clamp(1.6rem,2.6vw,2.3rem);">
            Everything You Learn, <span>Before You Enrol.</span>
          </h2>
          <p style="color:var(--text-muted); font-size:1rem; line-height:1.75; margin-bottom:22px;">
            <?= e($siteTagline) ?> Explore our <?= $totalCourses ?> programmes — module-wise syllabus, batch schedule,
            projects and certification — then download the official curriculum PDF.
          </p>
          <ul class="bc-inside-list">
            <?php foreach ($inside as $item): ?>
            <li><span class="ic"><i class="<?= e($item['icon']) ?>"></i></span><span><?= e($item['text']) ?></span></li>
            <?php endforeach; ?>
          </ul>
          <div class="bc-panel-actions">
            <a href="<?= e($heroCtaHref) ?>" class="tc-btn tc-btn-cta tc-btn-lg">
              <i class="bi bi-download"></i> Download PDF
            </a>
            <a href="#syllabus" class="tc-btn tc-btn-secondary tc-btn-lg">
              <i class="bi bi-journal-text"></i> Browse Syllabus
            </a>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="bc-form-card">
            <h3>Get The Curriculum PDF</h3>

            <?php if ($already): ?>
              <p>You have already shared your details. Hit the button to download the brochure again — no form needed.</p>
              <a href="<?= SITE_URL ?>/download-brochure.php" class="tc-btn tc-btn-cta tc-btn-lg">
                <i class="bi bi-download"></i> Download PDF Again
              </a>
              <p style="font-size:0.78rem; color:var(--text-muted); margin:16px 0 0; text-align:center;">
                <i class="bi bi-lock-fill me-1"></i> This PDF is released after a quick lead capture.
              </p>

            <?php else: ?>
              <p>Share your details and the official brochure downloads instantly.</p>

              <?php if ($flash): ?>
              <div class="mb-3" style="display:block">
                <div class="alert py-2 px-3 mb-0" style="font-size:0.87rem; border-radius:10px; background:var(--primary-orange-soft); border:1px solid rgba(255,107,0,0.35); color:var(--primary-orange-hover);">
                  <?= e($flash['text']) ?>
                </div>
              </div>
              <?php endif; ?>

              <form method="post" action="<?= SITE_URL ?>/brochure.php" novalidate>
                <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">

                <div class="mb-3">
                  <label class="tc-form-label">Full Name <span style="color:var(--primary-orange)">*</span></label>
                  <input type="text" name="name" class="tc-form-control" placeholder="e.g. Rahul Sharma" required>
                </div>

                <div class="mb-3">
                  <label class="tc-form-label">Email Address <span style="color:var(--primary-orange)">*</span></label>
                  <input type="email" name="email" class="tc-form-control" placeholder="you@example.com" required>
                </div>

                <div class="mb-3">
                  <label class="tc-form-label">Phone Number <span style="color:var(--primary-orange)">*</span></label>
                  <input type="tel" name="phone" class="tc-form-control" placeholder="+91 98765 43210" required>
                </div>

                <div class="mb-4">
                  <label class="tc-form-label">Course Interested In <span style="color:var(--primary-orange)">*</span></label>
                  <select name="course" class="tc-form-control" required>
                    <option value="">-- Select a Course --</option>
                    <?php foreach ($courses as $c): ?>
                    <option value="<?= e($c['title']) ?>"><?= e($c['title']) ?></option>
                    <?php endforeach; ?>
                    <option value="Other / Not Sure">Other / Not Sure</option>
                  </select>
                </div>

                <button type="submit" class="tc-btn tc-btn-cta tc-btn-lg">
                  <i class="bi bi-download"></i> Download Brochure (PDF)
                </button>

                <p style="font-size:0.78rem; color:var(--text-muted); margin:16px 0 0; text-align:center;">
                  <i class="bi bi-shield-check me-1"></i> No spam — only course details and your download link.
                </p>
              </form>
            <?php endif; ?>
          </div>
        </div>

      </div>
    </div>

  </div>
</section>

<!-- ============ COURSE CATALOG OVERVIEW ============ -->
<section class="tc-section" id="catalog">
  <div class="container">
    <div class="bc-head reveal">
      <span class="tc-badge"><i class="bi bi-grid-3x3-gap-fill"></i> Catalog Overview</span>
      <h2 class="tc-section-title" style="font-size:clamp(1.6rem,2.6vw,2.3rem);"><?= $totalCourses ?> Programmes.<br><span>One Career-Focused Path.</span></h2>
      <p>Each track is built with hiring managers — syllabus, tools and projects mirror what teams actually use on the job.</p>
    </div>

    <div class="bc-catalog">
      <?php if (!$courses): ?>
      <p class="bc-empty">Our course catalogue is being updated. Please contact us for programme details.</p>
      <?php endif; ?>
      <?php foreach ($courses as $i => $course): ?>
      <article class="bc-cat-card reveal" style="transition-delay:<?= ($i % 4) * 0.07 ?>s;">
        <div class="bc-cat-top">
          <span class="bc-cat-num"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></span>
          <span class="bc-cat-level"><?= e($course['category'] ?? $course['level'] ?? 'All Levels') ?></span>
        </div>
        <h3><?= e($course['title']) ?></h3>
        <div class="bc-cat-meta">
          <?php if (($course['lessons'] ?? 0) > 0): ?>
          <span><i class="bi bi-play-circle"></i> <?= (int) $course['lessons'] ?> Lessons</span>
          <?php endif; ?>
          <span><i class="bi bi-clock"></i> <?= e($course['duration'] ?? 'Contact us for duration') ?></span>
        </div>
        <ul class="bc-cat-modules">
          <?php
            $mods = array_values(array_filter(array_map('trim', explode("\n", (string) ($course['description'] ?? '')))));
            foreach (array_slice($mods, 0, 3) as $mod):
          ?>
          <li><i class="bi bi-caret-right-fill"></i><span><?= e($mod) ?></span></li>
          <?php endforeach; ?>
          <?php if (count($mods) > 3): ?>
          <li><i class="bi bi-plus-circle-fill"></i><span><?= count($mods) - 3 ?> more modules in the syllabus</span></li>
          <?php endif; ?>
        </ul>
        <div class="bc-cat-actions">
          <a href="#syllabus" class="tc-btn tc-btn-primary tc-btn-sm" data-jump="<?= $i ?>">
            <i class="bi bi-list-check"></i> View Syllabus
          </a>
          <a href="<?= e(coursePageUrl($course['slug'])) ?>" class="tc-btn tc-btn-secondary tc-btn-sm">
            Details
          </a>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ INTERACTIVE SYLLABUS / MODULE BREAKDOWN ============ -->
<section class="tc-section" id="syllabus" style="background:#f8fafc;border-top:1px solid rgba(30,41,59,.07);border-bottom:1px solid rgba(30,41,59,.07);">
  <div class="container">
    <div class="bc-head reveal">
      <span class="tc-badge"><i class="bi bi-journal-richtext"></i> Interactive Syllabus</span>
      <h2 class="tc-section-title" style="font-size:clamp(1.6rem,2.6vw,2.3rem);">Module <span>Breakdown</span></h2>
      <p>Tap any programme to expand its full module list and the skills you will walk away with.</p>
    </div>

    <div class="bc-toolbar reveal">
      <div class="bc-toolbar-tabs" id="bcTabs">
        <button type="button" class="bc-tab is-active" data-target="all">All Programmes</button>
        <?php foreach ($courses as $i => $c): ?>
        <button type="button" class="bc-tab" data-target="bc-acc-<?= $i ?>"><?= e($c['category'] ?? $c['title']) ?></button>
        <?php endforeach; ?>
      </div>
      <div class="bc-expand">
        <button type="button" id="bcExpandAll"><i class="bi bi-arrows-expand"></i> Expand all</button>
        <button type="button" id="bcCollapseAll"><i class="bi bi-arrows-compress"></i> Collapse all</button>
      </div>
    </div>

    <div id="bcAccordions">
      <?php foreach ($courses as $i => $course):
        $modules = array_values(array_filter(array_map('trim', explode("\n", (string) ($course['description'] ?? '')))));
        $techs   = array_values(array_filter(array_map('trim', explode(',', $course['technologies'] ?? ''))));
      ?>
      <div class="bc-acc reveal<?= $i === 0 ? ' open' : '' ?>" id="bc-acc-<?= $i ?>">
        <button type="button" class="bc-acc-head" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>">
          <span class="tc-module-num" aria-hidden="true"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></span>
          <span class="tc-module-head-body" style="display:block;">
            <span class="bc-acc-title" style="display:block;"><?= e($course['title']) ?></span>
            <span class="bc-acc-meta">
              <?php if (($course['lessons'] ?? 0) > 0): ?>
              <span><i class="bi bi-play-circle"></i> <?= (int) $course['lessons'] ?> Lessons</span>
              <?php endif; ?>
              <span><i class="bi bi-clock"></i> <?= e($course['duration'] ?? 'Contact us for duration') ?></span>
              <span><i class="bi bi-collection"></i> <?= count($modules) ?> Modules</span>
            </span>
          </span>
          <span class="bc-acc-toggle"><i class="bi bi-chevron-down"></i></span>
        </button>

        <div class="bc-acc-body">
          <?php if ($modules): ?>
          <ol class="tc-module-list">
            <?php foreach ($modules as $mod): ?>
            <li><?= e($mod) ?></li>
            <?php endforeach; ?>
          </ol>
          <?php endif; ?>

          <?php if ($techs): ?>
          <div class="bc-acc-skills">
            <?php foreach ($techs as $t): ?>
            <span class="tc-tech-chip"><i class="bi bi-puzzle-piece"></i> <?= e($t) ?></span>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>

          <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:18px;">
            <a href="<?= e(coursePageUrl($course['slug'])) ?>" class="tc-btn tc-btn-primary tc-btn-sm">
              <i class="bi bi-arrow-right"></i> Full Course Details
            </a>
            <a href="<?= e($heroCtaHref) ?>" class="tc-btn tc-btn-secondary tc-btn-sm">
              <i class="bi bi-download"></i> Download Syllabus
            </a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ HIGHLIGHTS ============ -->
<section class="tc-section" id="highlights">
  <div class="container">
    <div class="bc-head reveal">
      <span class="tc-badge"><i class="bi bi-star-fill"></i> Programme Highlights</span>
      <h2 class="tc-section-title" style="font-size:clamp(1.6rem,2.6vw,2.3rem);">More Than <span>A Syllabus</span></h2>
      <p>Projects, credentials and career coaching are baked into every track — not sold as add-ons.</p>
    </div>

    <div class="bc-hl">
      <?php foreach ($highlights as $i => $h): ?>
      <div class="bc-hl-card reveal" style="transition-delay:<?= $i * 0.07 ?>s;">
        <div class="bc-hl-icon"><i class="<?= e($h['icon']) ?>"></i></div>
        <h3><?= e($h['title']) ?></h3>
        <p><?= e($h['text']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Quick CTA -->
<section class="tc-section tc-cta-light-wrap">
 <div class="container">
 <div class="tc-cta-light reveal visible">
 <h2 class="tc-section-title">Ready to Be Part of<br>the <span>Techno Coderz</span> Story?</h2>
 <p>Join 1,200+ students who have already built their tech careers with us.</p>
 <div class="tc-cta-actions">
 <a href="<?= SITE_URL ?>/courses.php" class="tc-btn tc-btn-primary tc-btn-lg">
 <i class="bi bi-book-fill"></i> Explore Courses
 </a>
 <a href="<?= SITE_URL ?>/contact.php" class="tc-btn tc-btn-secondary tc-btn-lg">
 <i class="bi bi-chat-dots-fill"></i> Contact Us
 </a>
 </div>
 </div>
</div>
</section>
</div><!-- /.tc-page-light -->

<script>
(function () {
  var wrap = document.getElementById('bcAccordions');
  if (!wrap) return;
  var items = Array.prototype.slice.call(wrap.querySelectorAll('.bc-acc'));
  var tabs  = Array.prototype.slice.call(document.querySelectorAll('#bcTabs .bc-tab'));

  function setOpen(item, open) {
    item.classList.toggle('open', open);
    var head = item.querySelector('.bc-acc-head');
    if (head) head.setAttribute('aria-expanded', open ? 'true' : 'false');
  }

  items.forEach(function (item) {
    var head = item.querySelector('.bc-acc-head');
    if (!head) return;
    head.addEventListener('click', function () {
      var willOpen = !item.classList.contains('open');
      items.forEach(function (other) { setOpen(other, false); });
      setOpen(item, willOpen);
    });
  });

  tabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      tabs.forEach(function (t) { t.classList.remove('is-active'); });
      tab.classList.add('is-active');
      var target = tab.dataset.target;
      items.forEach(function (item) { setOpen(item, target !== 'all' && item.id === target); });
    });
  });

  var expandAll  = document.getElementById('bcExpandAll');
  var collapseAll = document.getElementById('bcCollapseAll');
  if (expandAll)  expandAll.addEventListener('click',  function () { items.forEach(function (i) { setOpen(i, true); }); });
  if (collapseAll) collapseAll.addEventListener('click', function () { items.forEach(function (i) { setOpen(i, false); }); });

  // "View Syllabus" buttons from the catalogue cards
  document.querySelectorAll('[data-jump]').forEach(function (link) {
    link.addEventListener('click', function () {
      var item = document.getElementById('bc-acc-' + link.dataset.jump);
      if (item) { items.forEach(function (i) { setOpen(i, false); }); setOpen(item, true); }
    });
  });
})();
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
