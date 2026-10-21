<?php
// ============================================================
// Techno Coderz — Course Details Page
// Layout reference: techcadd.com course detail page (orange theme)
// ============================================================
require_once __DIR__ . '/includes/functions.php';

$slug   = (isset($courseSlug) && $courseSlug !== '') ? sanitize($courseSlug) : sanitize($_GET['slug'] ?? '');
$course = $slug ? fetchBySlug('courses', $slug) : null;

if (!$course) {
    header('HTTP/1.1 404 Not Found');
    $pageTitle = '404 – Course Not Found';
    $currentPage = 'courses';
    require_once __DIR__ . '/includes/header.php';
    require_once __DIR__ . '/includes/navbar.php';
    echo '<div class="tc-section text-center"><div class="container"><h1 class="tc-section-title">Course <span>Not Found</span></h1><p style="color:var(--tc-text-muted)">The course you\'re looking for doesn\'t exist or has been deactivated.</p><a href="' . SITE_URL . '/courses.php" class="tc-btn tc-btn-primary mt-3"><i class="bi bi-arrow-left"></i> Browse Courses</a></div></div>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$pageTitle       = $course['title'] . ' – Techno Coderz';
$pageDescription = $course['short_description'] ?? $course['title'];
$currentPage     = 'courses';
$csrf = generateCsrfToken();

$pdo = getDB();

/* ------------------------------------------------------------
 * Course meta
 * ------------------------------------------------------------ */
$duration     = trim((string) ($course['duration'] ?? ''));
$level        = trim((string) ($course['level'] ?? ''));
$category     = trim((string) ($course['category'] ?? ''));
$lessons      = (int) ($course['lessons'] ?? 0);
$price        = (float) ($course['price'] ?? 0);
$isFree       = $price <= 0;

$technologies = array_values(array_filter(array_map('trim', explode(',', (string) ($course['technologies'] ?? '')))));
$highlights    = array_values(array_filter(array_map('trim', explode(',', (string) ($course['highlights'] ?? '')))));
$modules       = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) ($course['description'] ?? '')))));

$shortDesc = trim((string) ($course['short_description'] ?? ''));

/* ------------------------------------------------------------
 * Settings (phone / email)
 * ------------------------------------------------------------ */
$settings = [];
try {
    foreach ($pdo->query("SELECT setting_key, setting_value FROM site_settings") as $row) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
} catch (Exception $e) { /* ignore */ }
$phone = $settings['phone'] ?? '+91 98765 43210';
$email = $settings['email'] ?? 'info@technocoderz.com';

/* ------------------------------------------------------------
 * Reviews (reuse testimonials as course reviews)
 * ------------------------------------------------------------ */
$reviews = [];
try {
    $reviews = $pdo->query("SELECT name, designation, message, rating FROM testimonials WHERE status = 1 ORDER BY id ASC LIMIT 6")->fetchAll();
} catch (Exception $e) { /* ignore */ }
$reviewCount = count($reviews);
$ratingSum   = 0;
$starBuckets = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
foreach ($reviews as $r) {
    $rt = (int) ($r['rating'] ?? 5);
    $ratingSum += $rt;
    if (isset($starBuckets[$rt])) $starBuckets[$rt]++;
}
$avgRating = $reviewCount ? round($ratingSum / $reviewCount, 1) : 5.0;

/* ------------------------------------------------------------
 * Course options (demo form select)
 * ------------------------------------------------------------ */
$allCourses = [];
try {
    $allCourses = $pdo->query("SELECT title FROM courses WHERE status = 1 ORDER BY sort_order ASC, id ASC")->fetchAll();
} catch (Exception $e) { /* ignore */ }

/* ------------------------------------------------------------
 * Generated content — job roles by category
 * ------------------------------------------------------------ */
$rolesMap = [
    'Data Science'         => ['Data Analyst', 'Data Scientist', 'Machine Learning Engineer', 'AI Engineer', 'Business Intelligence Analyst', 'Python Developer'],
    'Cyber Security'       => ['Cyber Security Analyst', 'Ethical Hacker / Penetration Tester', 'Security Engineer', 'SOC Analyst', 'Cloud Security Engineer', 'DevSecOps Engineer'],
    'Software Development' => ['Full Stack Developer', 'Frontend Developer', 'Backend Developer', 'DevOps Engineer', 'Web Application Developer', 'Software Engineer'],
];
$roles = $rolesMap[$category] ?? ['Software Developer', 'Web Developer', 'Application Developer', 'Technical Support Engineer', 'Systems Engineer', 'Freelance Developer'];

$reasons = [
    ['title' => 'High Industry Demand',                 'text' => $course['title'] . ' skills are among the most sought-after by employers across India — and demand keeps growing every year.'],
    ['title' => 'Never-Ending Career Opportunities',    'text' => 'Open doors to multiple roles, from developer and analyst to engineer and consultant, across startups and MNCs.'],
    ['title' => 'High Earning Potential',               'text' => 'Skilled professionals in this field command strong starting packages and rapid salary growth.'],
    ['title' => 'Beginner-Friendly & Project-Based',    'text' => 'Start from the fundamentals and progress to advanced topics through live, real-world projects.'],
    ['title' => 'Expert Mentorship',                    'text' => 'Learn directly from trainers with real industry experience and get 1-on-1 guidance throughout the course.'],
    ['title' => 'Placement & Career Support',           'text' => 'Resume building, mock interviews and dedicated placement assistance to help you land your first role.'],
];

$faqs = [
    ['q' => 'What is ' . $course['title'] . '?',        'a' => $shortDesc !== '' ? $shortDesc : ($course['title'] . ' is an industry-focused programme designed to take you from the fundamentals to job-ready expertise through practical, project-based learning.')],
    ['q' => 'Who can join this course?',                'a' => 'Anyone can join — school/college students, fresh graduates, working professionals and career-switchers. No prior coding experience is required for beginner tracks.'],
    ['q' => 'What is the course duration?',             'a' => 'This programme runs for ' . ($duration !== '' ? $duration : 'a flexible duration') . ' and ' . ($lessons > 0 ? 'includes ' . $lessons . ' structured lessons' : 'includes structured lessons') . ' with hands-on projects.'],
    ['q' => 'Do you provide placement assistance?',     'a' => 'Yes. Techno Coderz offers dedicated placement support including resume building, mock interviews and job referrals.'],
];

$techList = $technologies ? implode(', ', array_slice($technologies, 0, 4)) : 'modern, industry-standard tools and frameworks';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<script>window.TC_BASE_URL = '<?= SITE_URL ?>';</script>
<script>document.addEventListener('DOMContentLoaded',function(){var c=document.getElementById('enquiryCsrf');if(c)c.value='<?=e($csrf)?>';});</script>

<style>
/* ============================================================
   Course Details — techcadd layout, Techno Coderz orange theme
   ============================================================ */
.tcd-page{ background:var(--bg-light); }
.tcd-page .text-just{ text-align:justify; }

/* ---- Breadcrumb band ---- */
.tcd-breadcrumb{
  position:relative; overflow:hidden; padding:95px 0 85px;
  background:linear-gradient(135deg,#0F172A 0%,#1E293B 55%,#3a2408 100%);
}
.tcd-breadcrumb::after{
  content:""; position:absolute; top:-140px; right:-140px; width:460px; height:460px;
  background:radial-gradient(circle,rgba(255,107,0,.38),transparent 68%); border-radius:50%;
}
.tcd-breadcrumb .container{ position:relative; z-index:2; }
.tcd-crumb{ list-style:none; display:flex; flex-wrap:wrap; gap:8px; margin:0 0 16px; padding:0; font-size:14px; }
.tcd-crumb li{ color:rgba(255,255,255,.75); }
.tcd-crumb a{ color:rgba(255,255,255,.78); text-decoration:none; transition:.2s; }
.tcd-crumb a:hover{ color:var(--primary); }
.tcd-crumb li.sep{ opacity:.55; }
.tcd-crumb li.active{ color:var(--primary); font-weight:700; }
.tcd-title{
  color:#fff; font-family:var(--tc-font-head); font-weight:800; line-height:1.15;
  font-size:clamp(1.8rem,4vw,3rem); max-width:860px; margin:0 0 20px;
}
.tcd-crumb-meta{ list-style:none; display:flex; flex-wrap:wrap; gap:28px; margin:0; padding:0; }
.tcd-crumb-meta li{ color:rgba(255,255,255,.92); font-weight:600; font-size:.92rem; display:flex; align-items:center; gap:9px; }
.tcd-crumb-meta li i{ color:var(--primary); font-size:1.1rem; }
.tcd-shape{ list-style:none; position:absolute; inset:0; margin:0; padding:0; z-index:1; }
.tcd-shape li{ position:absolute; border:1px solid rgba(255,255,255,.09); border-radius:50%; }
.tcd-shape li.s1{ width:470px; height:470px; top:-315px; left:-60px; }
.tcd-shape li.s2{ width:470px; height:470px; top:30px; right:-180px; }
@media(max-width:991px){ .tcd-breadcrumb{ padding:70px 0 60px; } }
@media(max-width:575px){ .tcd-breadcrumb{ padding:55px 0 45px; } .tcd-crumb-meta{ gap:16px; } }

/* ---- Section ---- */
.tcd-section{ padding:96px 0; }
@media(max-width:1023.98px){ .tcd-section{ padding:64px 0; } }

/* ---- Main content card ---- */
.tcd-main-card{ background:#fff; border-radius:14px; padding:34px 34px 42px; box-shadow:0 10px 50px rgba(26,46,85,.07); }
@media(max-width:575px){ .tcd-main-card{ padding:22px 18px 32px; } }

.tcd-tabs{ border-bottom:2px solid var(--border); gap:34px; margin:0; flex-wrap:wrap; }
.tcd-tabs .nav-link{
  border:0; background:none; border-radius:0; padding:0 0 16px; margin:0;
  font-family:var(--tc-font-head); font-weight:700; font-size:1rem; color:var(--text-heading);
  position:relative; transition:.25s;
}
.tcd-tabs .nav-link::after{
  content:""; position:absolute; left:0; bottom:-2px; height:3px; width:0;
  background:linear-gradient(135deg,var(--primary),var(--primary-dark)); border-radius:2px; transition:.3s;
}
.tcd-tabs .nav-link:hover{ color:var(--primary); }
.tcd-tabs .nav-link.active{ color:var(--primary); }
.tcd-tabs .nav-link.active::after{ width:100%; }

.tcd-tab-content{ margin-top:40px; }
.tcd-overview p{ color:var(--text-body); line-height:1.9; font-size:.95rem; margin-bottom:18px; }
.tcd-heading{ font-family:var(--tc-font-head); font-weight:800; color:var(--text-heading); font-size:1.35rem; margin:34px 0 16px; position:relative; padding-left:18px; }
.tcd-heading::before{ content:""; position:absolute; left:0; top:4px; bottom:4px; width:5px; border-radius:4px; background:linear-gradient(135deg,var(--primary),var(--primary-dark)); }

.tcd-reasons{ list-style:none; padding:0; margin:4px 0 10px; counter-reset:tcdr; }
.tcd-reasons li{ position:relative; padding:9px 0 9px 46px; color:var(--text-body); line-height:1.85; font-size:.93rem; }
.tcd-reasons li::before{
  counter-increment:tcdr; content:counter(tcdr);
  position:absolute; left:0; top:9px; width:28px; height:28px; border-radius:50%;
  background:var(--primary-soft-2); color:var(--primary); font-weight:800; font-size:.8rem;
  display:flex; align-items:center; justify-content:center;
}
.tcd-reasons li b{ color:var(--text-heading); }

.tcd-curriculum{ border:1px solid var(--border); border-radius:10px; padding:6px 24px; margin:4px 0; }
.tcd-module{ display:flex; gap:14px; padding:15px 0; border-bottom:1px solid var(--border-light); color:var(--text-body); font-size:.92rem; font-weight:600; }
.tcd-module:last-child{ border-bottom:0; }
.tcd-module i{ color:var(--primary); margin-top:3px; flex-shrink:0; }

.tcd-checklist{ list-style:none; padding:0; margin:4px 0 10px; }
.tcd-checklist li{ display:flex; gap:12px; padding:8px 0; color:var(--text-body); font-size:.93rem; line-height:1.75; }
.tcd-checklist li i{ color:var(--primary); margin-top:3px; flex-shrink:0; }

/* ---- Reviews ---- */
.tcd-review .tcd-rating-box{
  width:170px; height:170px; margin:0 auto; background:#fff; border-radius:10px;
  box-shadow:0 0 40px rgba(0,0,0,.08); display:flex; flex-direction:column;
  align-items:center; justify-content:center; padding:20px 10px;
}
.tcd-rating-number{ font-family:var(--tc-font-head); font-weight:800; font-size:28px; line-height:1; color:var(--primary); margin-bottom:10px; }
.tcd-stars{ color:#F8B81F; margin-bottom:5px; display:flex; gap:2px; }
.tcd-rating-box span{ font-size:14px; color:var(--text-muted); }
.tcd-review-wrapper .tcd-rating-row{ display:flex; align-items:center; gap:14px; margin-bottom:12px; }
.tcd-rating-text{ width:56px; flex-shrink:0; font-weight:600; color:var(--text-heading); font-size:.85rem; display:flex; align-items:center; gap:6px; }
.tcd-rating-text i{ color:#F8B81F; }
.tcd-review-wrapper .progress{ flex:1; height:6px; background:#f2f2f2; border-radius:30px; overflow:hidden; }
.tcd-review-wrapper .progress-bar{ background:linear-gradient(135deg,var(--primary),var(--primary-light)); }
.tcd-rating-value{ width:26px; text-align:right; font-weight:700; color:var(--text-heading); font-size:.85rem; flex-shrink:0; }

.tcd-comment-area{ margin-top:50px; border-top:1px solid var(--border); padding-top:34px; }
.tcd-comment{ display:flex; gap:18px; padding:22px 0; border-bottom:1px solid var(--border-light); }
.tcd-comment:last-child{ border-bottom:0; }
.tcd-avatar{
  width:58px; height:58px; border-radius:50%; flex-shrink:0; font-family:var(--tc-font-head);
  background:linear-gradient(135deg,var(--primary),var(--primary-dark)); color:#fff;
  font-weight:800; font-size:1.2rem; display:flex; align-items:center; justify-content:center;
}
.tcd-comment-content .tcd-stars{ margin-bottom:6px; }
.tcd-comment-content h5{ font-weight:700; color:var(--text-heading); font-size:1rem; margin:0 0 4px; }
.tcd-comment-content .tcd-desig{ font-size:.78rem; color:var(--primary); font-weight:700; display:block; margin-bottom:8px; }
.tcd-comment-content p{ color:var(--text-body); font-size:.9rem; line-height:1.8; margin:0; }

/* ---- Sidebar widgets ---- */
.tcd-widget{ background:#fff; border-radius:14px; box-shadow:0 10px 50px rgba(26,46,85,.07); margin-bottom:30px; overflow:hidden; }

.tcd-summary .tcd-thumb{ position:relative; margin:15px 15px 0; border-radius:10px; overflow:hidden; }
.tcd-summary .tcd-thumb img{ width:100%; display:block; aspect-ratio:16/11; object-fit:cover; }
.tcd-summary .tcd-thumb::after{ content:""; position:absolute; inset:0; background:rgba(15,23,42,.30); }
.tcd-play{
  position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); width:70px; height:70px;
  border-radius:50%; background:#fff; color:var(--primary); display:flex; align-items:center;
  justify-content:center; font-size:1.7rem; z-index:2; text-decoration:none; transition:.25s;
}
.tcd-play:hover{ background:var(--primary); color:#fff; transform:translate(-50%,-50%) scale(1.06); }
.tcd-summary-body{ padding:24px 25px 26px; }
.tcd-widget-title{ font-family:var(--tc-font-head); font-weight:800; color:var(--text-heading); font-size:1.05rem; margin:0 0 16px; }
.tcd-course-item{ list-style:none; padding:0; margin:0; }
.tcd-course-item li{ display:flex; align-items:center; justify-content:space-between; gap:10px; padding:14px 0; border-bottom:1px solid var(--border-light); font-size:.9rem; }
.tcd-course-item li:last-child{ border-bottom:0; }
.tcd-course-item .tcd-label{ display:flex; align-items:center; gap:10px; color:var(--text-muted); font-weight:600; }
.tcd-course-item .tcd-label i{ color:var(--primary); font-size:1.05rem; }
.tcd-course-item .tcd-value{ color:var(--text-heading); font-weight:700; text-align:right; }
.tcd-read-more{ margin:22px 0 26px; }

.tcd-btn{
  display:inline-flex; align-items:center; justify-content:center; gap:8px; width:100%;
  background:linear-gradient(135deg,var(--primary),var(--primary-dark)); color:#fff; border:0;
  border-radius:10px; padding:14px 22px; font-weight:700; font-size:.95rem; text-decoration:none;
  cursor:pointer; transition:.25s; box-shadow:0 10px 24px rgba(255,107,0,.28);
}
.tcd-btn:hover{ transform:translateY(-2px); box-shadow:0 14px 30px rgba(255,107,0,.36); color:#fff; }

.tcd-share .tcd-share-title{ font-weight:800; font-size:.95rem; color:var(--text-heading); margin:0 0 12px; }
.tcd-social-share{ list-style:none; display:flex; flex-wrap:wrap; gap:10px; padding:0; margin:0 0 14px; }
.tcd-social-share li a{ width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; text-decoration:none; transition:.25s; }
.tcd-social-share li a:hover{ transform:translateY(-2px); }
.tcd-social-share a.tcd-fb{ background:#1877f2; }
.tcd-social-share a.tcd-tw{ background:#111; }
.tcd-social-share a.tcd-li{ background:#0a66c2; }
.tcd-social-share a.tcd-yt{ background:#ff0000; }
.tcd-social-share a.tcd-ig{ background:linear-gradient(45deg,#f58529,#dd2a7b,#8134af,#515bd4); }
.tcd-contact{ font-weight:800; color:var(--primary); font-size:.95rem; margin:0; }

/* ---- Demo form widget ---- */
.tcd-demo{ padding:26px 24px; background:linear-gradient(135deg,#fff7f0,#ffffff); }
.tcd-demo-head{ text-align:center; margin-bottom:22px; }
.tcd-demo-head h4{
  font-family:var(--tc-font-head); font-weight:800; font-size:1.25rem; margin:0 0 6px;
  background:linear-gradient(90deg,var(--primary),var(--primary-light));
  -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent;
}
.tcd-demo-head p{ color:var(--text-muted); font-size:.88rem; margin:0; }
.tcd-field{ margin-bottom:16px; }
.tcd-field label{ display:block; font-weight:700; color:var(--text-heading); font-size:.82rem; margin-bottom:7px; }
.tcd-field input, .tcd-field select, .tcd-field textarea{
  width:100%; padding:14px 16px; border:2px solid var(--border); border-radius:12px;
  font-size:.92rem; background:#fff; transition:.25s; outline:none; color:var(--text-body);
}
.tcd-field input:focus, .tcd-field select:focus, .tcd-field textarea:focus{ border-color:var(--primary); box-shadow:0 0 0 3px rgba(255,107,0,.12); }
.tcd-field textarea{ resize:vertical; min-height:90px; }
.tcd-demo-msg{ display:none; border-radius:10px; padding:12px 14px; font-size:.86rem; font-weight:600; margin-bottom:16px; }
.tcd-demo-msg.ok{ display:block; background:var(--success-soft); color:#0f7a56; border:1px solid rgba(16,185,129,.3); }
.tcd-demo-msg.err{ display:block; background:#fee2e2; color:#b91c1c; border:1px solid #fecaca; }

/* ---- FAQ widget ---- */
.tcd-faq{ padding:26px 22px; }
.tcd-faq .tcd-widget-title{ text-align:center; }
.tcd-accordion .accordion-item{ border:1px solid var(--border); border-radius:10px; margin-bottom:12px; overflow:hidden; }
.tcd-accordion .accordion-button{
  font-family:var(--tc-font-head); font-weight:700; color:var(--text-heading);
  font-size:.92rem; padding:16px 18px; background:#fff; box-shadow:none;
}
.tcd-accordion .accordion-button:not(.collapsed){ color:var(--primary); background:var(--primary-soft); }
.tcd-accordion .accordion-button:focus{ box-shadow:none; border-color:var(--border); }
.tcd-accordion .accordion-body{ color:var(--text-body); font-size:.88rem; line-height:1.8; padding:0 18px 18px; }

/* ---- Responsive ---- */
@media(max-width:991px){
  .tcd-review .tcd-rating-box{ margin-bottom:26px; }
  .tcd-review-wrapper{ margin-top:6px; }
}
</style>

<div class="tcd-page">

  <!-- ============ Breadcrumb band ============ -->
  <div class="tcd-breadcrumb">
    <div class="container">
      <ol class="tcd-crumb">
        <li><a href="<?= SITE_URL ?>/index.php">Home</a></li>
        <li class="sep">/</li>
        <li><a href="<?= SITE_URL ?>/courses.php">Courses</a></li>
        <li class="sep">/</li>
        <li class="active"><?= e($course['title']) ?></li>
      </ol>
      <h1 class="tcd-title"><?= e($course['title']) ?></h1>
      <ul class="tcd-crumb-meta">
        <?php if ($level !== ''): ?><li><i class="bi bi-bar-chart-fill"></i> <?= e($level) ?></li><?php endif; ?>
        <?php if ($duration !== ''): ?><li><i class="bi bi-clock-fill"></i> <?= e($duration) ?></li><?php endif; ?>
        <?php if ($lessons > 0): ?><li><i class="bi bi-journal-text"></i> <?= $lessons ?> Lessons</li><?php endif; ?>
        <li><i class="bi bi-patch-check-fill"></i> Certificate Included</li>
      </ul>
    </div>
    <ul class="tcd-shape"><li class="s1"></li><li class="s2"></li></ul>
  </div>

  <!-- ============ Course details ============ -->
  <section class="tcd-section">
    <div class="container">
      <div class="row g-4">

        <!-- ============ Main column ============ -->
        <div class="col-lg-8">
          <div class="tcd-main-card">

            <ul class="nav tcd-tabs" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tcd-tab-overview" data-bs-toggle="tab" data-bs-target="#tcd-overview" type="button" role="tab" aria-controls="tcd-overview" aria-selected="true">Overview</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="tcd-tab-reviews" data-bs-toggle="tab" data-bs-target="#tcd-reviews" type="button" role="tab" aria-controls="tcd-reviews" aria-selected="false">Reviews</button>
              </li>
            </ul>

            <div class="tab-content tcd-tab-content">

              <!-- ---------- Overview ---------- -->
              <div class="tab-pane fade show active" id="tcd-overview" role="tabpanel" aria-labelledby="tcd-tab-overview">
                <div class="tcd-overview">
                  <p class="text-just">
                    <?php if ($shortDesc !== ''): ?><?= e($shortDesc) ?><?php else: ?>Looking to master <strong><?= e($course['title']) ?></strong>? You're in the right place.<?php endif; ?>
                    At <strong>Techno Coderz</strong>, our <strong><?= e($course['title']) ?></strong> programme is built for both beginners with zero background and working professionals looking to upgrade their skills. You will learn from the fundamentals to advanced, job-ready topics — all under the guidance of industry experts.
                  </p>
                  <p class="text-just">
                    With hands-on practical training, real-world projects and 1-on-1 mentorship, you will be ready to apply your skills from day one. Flexible timings and affordable fee plans mean anyone can learn <?= e($course['title']) ?>. Let Techno Coderz unlock exciting career opportunities for you.
                  </p>

                  <h3 class="tcd-heading">What is <?= e($course['title']) ?>?</h3>
                  <p class="text-just">
                    <?= e($course['title']) ?> is one of today's most in-demand technology skills, used across web development, data analysis, artificial intelligence, automation and more. Through this course you will build a strong base using <?= e($techList) ?> and open doors to some of the most exciting career options in the industry.
                  </p>

                  <h3 class="tcd-heading">Why should we learn <?= e($course['title']) ?> in <?= date('Y') ?>?</h3>
                  <p class="text-just">Here are some of the key reasons why learning this course is a smart move this year:</p>
                  <ol class="tcd-reasons">
                    <?php foreach ($reasons as $reason): ?>
                    <li><b><?= e($reason['title']) ?>:</b> <?= e($reason['text']) ?></li>
                    <?php endforeach; ?>
                  </ol>

                  <?php if ($modules): ?>
                  <h3 class="tcd-heading">Course Curriculum</h3>
                  <p class="text-just">A structured, module-by-module roadmap that takes you from the basics to advanced, production-ready skills:</p>
                  <div class="tcd-curriculum">
                    <?php foreach ($modules as $m): ?>
                    <div class="tcd-module"><i class="bi bi-collection-fill"></i><span><?= e($m) ?></span></div>
                    <?php endforeach; ?>
                  </div>
                  <?php endif; ?>

                  <h3 class="tcd-heading">Job Opportunities after <?= e($course['title']) ?></h3>
                  <p class="text-just">After completing this course you are all set for some of the most rewarding careers. Here are the most in-demand roles you can pursue:</p>
                  <ul class="tcd-checklist">
                    <?php foreach ($roles as $role): ?>
                    <li><i class="bi bi-check-circle-fill"></i><span><?= e($role) ?></span></li>
                    <?php endforeach; ?>
                  </ul>

                  <h3 class="tcd-heading">So why not start moving forward to a perfect career today?</h3>
                  <p class="text-just">
                    Our <strong><?= e($course['title']) ?></strong> course with expert trainers is a great opportunity with a highly practical approach. Our curriculum is always up to date and will equip you with the skills needed in today's tech-driven world. Join us today and welcome yourself to a fulfilling career — call us now to book your seat while the offer is still on.
                  </p>
                </div>
              </div>

              <!-- ---------- Reviews ---------- -->
              <div class="tab-pane fade" id="tcd-reviews" role="tabpanel" aria-labelledby="tcd-tab-reviews">
                <div class="tcd-review">
                  <h3 class="tcd-heading" style="margin-top:0;">Course Rating</h3>
                  <p class="text-just"><?= number_format($avgRating, 2) ?> average rating based on <?= $reviewCount ?> rating<?= $reviewCount === 1 ? '' : 's' ?></p>

                  <div class="row g-0 align-items-center mt-4">
                    <div class="col-sm-4">
                      <div class="tcd-rating-box">
                        <div class="tcd-rating-number"><?= number_format($avgRating, 1) ?></div>
                        <div class="tcd-stars">
                          <?php for ($s = 1; $s <= 5; $s++): ?>
                          <i class="bi bi-star<?= $s <= round($avgRating) ? '-fill' : '' ?>"></i>
                          <?php endfor; ?>
                        </div>
                        <span>(<?= $reviewCount ?> Review<?= $reviewCount === 1 ? '' : 's' ?>)</span>
                      </div>
                    </div>
                    <div class="col-sm-8">
                      <div class="tcd-review-wrapper">
                        <?php for ($star = 5; $star >= 1; $star--):
                            $count = $starBuckets[$star];
                            $pct   = $reviewCount ? round(($count / $reviewCount) * 100) : 0;
                        ?>
                        <div class="tcd-rating-row">
                          <div class="tcd-rating-text"><?= $star ?> <i class="bi bi-star-fill"></i></div>
                          <div class="progress"><div class="progress-bar" role="progressbar" style="width:<?= $pct ?>%" aria-valuenow="<?= $pct ?>" aria-valuemin="0" aria-valuemax="100"></div></div>
                          <span class="tcd-rating-value"><?= $count ?></span>
                        </div>
                        <?php endfor; ?>
                      </div>
                    </div>
                  </div>

                  <?php if ($reviews): ?>
                  <div class="tcd-comment-area">
                    <h3 class="tcd-heading">Reviews</h3>
                    <div class="tcd-comment-list">
                      <?php foreach ($reviews as $rev):
                          $rt     = (int) ($rev['rating'] ?? 5);
                          $name   = trim((string) ($rev['name'] ?? 'Student'));
                          $initial = strtoupper(mb_substr($name, 0, 1));
                      ?>
                      <div class="tcd-comment">
                        <div class="tcd-avatar"><?= e($initial) ?></div>
                        <div class="tcd-comment-content">
                          <div class="tcd-stars">
                            <?php for ($s = 1; $s <= 5; $s++): ?>
                            <i class="bi bi-star<?= $s <= $rt ? '-fill' : '' ?>"></i>
                            <?php endfor; ?>
                          </div>
                          <h5><?= e($name) ?></h5>
                          <?php if (!empty($rev['designation'])): ?><span class="tcd-desig"><?= e($rev['designation']) ?></span><?php endif; ?>
                          <p><?= e($rev['message'] ?? '') ?></p>
                        </div>
                      </div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                  <?php endif; ?>
                </div>
              </div>

            </div><!-- /tab-content -->
          </div>
        </div>
        <!-- ============ /Main column ============ -->

        <!-- ============ Sidebar ============ -->
        <div class="col-lg-4">
          <div class="tcd-sidebar">

            <!-- Course summary widget -->
            <div class="tcd-widget tcd-summary">
              <div class="tcd-thumb">
                <img src="<?= e(courseImage($course['image'] ?? null)) ?>" alt="<?= e($course['title']) ?>" loading="lazy">
                <a href="javascript:void(0);" class="tcd-play" aria-label="Book a free demo" onclick="openEnquiry('<?= e($course['title']) ?>')"><i class="bi bi-play-fill"></i></a>
              </div>
              <div class="tcd-summary-body">
                <h4 class="tcd-widget-title">Course Includes:</h4>
                <ul class="tcd-course-item">
                  <li>
                    <span class="tcd-label"><i class="bi bi-person-video3"></i>Instructor:</span>
                    <span class="tcd-value">Expert Trainers</span>
                  </li>
                  <?php if ($duration !== ''): ?>
                  <li>
                    <span class="tcd-label"><i class="bi bi-clock-history"></i>Duration:</span>
                    <span class="tcd-value"><?= e($duration) ?></span>
                  </li>
                  <?php endif; ?>
                  <?php if ($lessons > 0): ?>
                  <li>
                    <span class="tcd-label"><i class="bi bi-journal-text"></i>Lessons:</span>
                    <span class="tcd-value"><?= $lessons ?></span>
                  </li>
                  <?php endif; ?>
                  <li>
                    <span class="tcd-label"><i class="bi bi-kanban"></i>Projects:</span>
                    <span class="tcd-value">Hands-on</span>
                  </li>
                  <li>
                    <span class="tcd-label"><i class="bi bi-translate"></i>Language:</span>
                    <span class="tcd-value">English-Hindi</span>
                  </li>
                  <li>
                    <span class="tcd-label"><i class="bi bi-patch-check"></i>Certificate:</span>
                    <span class="tcd-value">Yes</span>
                  </li>
                  <li>
                    <span class="tcd-label"><i class="bi bi-bar-chart"></i>Level:</span>
                    <span class="tcd-value"><?= e($level !== '' ? $level : 'All Levels') ?></span>
                  </li>
                </ul>
                <div class="tcd-read-more">
                  <button type="button" class="tcd-btn" onclick="openEnquiry('<?= e($course['title']) ?>')">Start Now <i class="bi bi-arrow-right"></i></button>
                </div>
                <div class="tcd-share">
                  <h4 class="tcd-share-title">Share On:</h4>
                  <ul class="tcd-social-share">
                    <li><a class="tcd-fb" href="https://facebook.com/technocoderz" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a></li>
                    <li><a class="tcd-tw" href="https://twitter.com/technocoderz" target="_blank" rel="noopener" aria-label="Twitter/X"><i class="bi bi-twitter-x"></i></a></li>
                    <li><a class="tcd-li" href="https://linkedin.com/company/technocoderz" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a></li>
                    <li><a class="tcd-yt" href="https://youtube.com/@technocoderz" target="_blank" rel="noopener" aria-label="YouTube"><i class="bi bi-youtube"></i></a></li>
                    <li><a class="tcd-ig" href="https://instagram.com/technocoderz" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a></li>
                  </ul>
                  <h5 class="tcd-contact">Contact us: <?= e($phone) ?></h5>
                </div>
              </div>
            </div>

            <!-- Free demo form widget -->
            <div class="tcd-widget tcd-demo">
              <div class="tcd-demo-head">
                <h4>Techno Coderz</h4>
                <p>Fill out this form for booking a free demo session.</p>
              </div>
              <div id="tcdDemoMsg" class="tcd-demo-msg"></div>
              <form id="tcdDemoForm" onsubmit="event.preventDefault(); tcdSubmitDemo();" novalidate>
                <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
                <div class="tcd-field">
                  <label for="tcdName">Full Name *</label>
                  <input type="text" name="name" id="tcdName" placeholder="Enter your full name" required>
                </div>
                <div class="tcd-field">
                  <label for="tcdEmail">Email Address *</label>
                  <input type="email" name="email" id="tcdEmail" placeholder="you@example.com" required>
                </div>
                <div class="tcd-field">
                  <label for="tcdPhone">Phone Number *</label>
                  <input type="tel" name="phone" id="tcdPhone" placeholder="Enter 10-digit phone number" pattern="[0-9]{10}" required>
                </div>
                <div class="tcd-field">
                  <label for="tcdCourse">Select Course *</label>
                  <select name="course" id="tcdCourse" required>
                    <option value="" disabled>Choose your course</option>
                    <?php foreach ($allCourses as $oc): ?>
                    <option value="<?= e($oc['title']) ?>" <?= $oc['title'] === $course['title'] ? 'selected' : '' ?>><?= e($oc['title']) ?></option>
                    <?php endforeach; ?>
                    <option value="Other">Other</option>
                  </select>
                </div>
                <div class="tcd-field">
                  <label for="tcdMessage">Message (Optional)</label>
                  <textarea name="message" id="tcdMessage" placeholder="Tell us about your learning goals or any specific requirements..." rows="3"></textarea>
                </div>
                <button type="submit" id="tcdSubmitBtn" class="tcd-btn"><i class="bi bi-send-fill"></i> Submit Message</button>
              </form>
            </div>

            <!-- FAQ widget -->
            <div class="tcd-widget tcd-faq">
              <h4 class="tcd-widget-title">FAQ's</h4>
              <div class="accordion tcd-accordion" id="tcdFaq">
                <?php foreach ($faqs as $i => $faq): ?>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="tcdFaqHead<?= $i ?>">
                    <button class="accordion-button<?= $i === 0 ? '' : ' collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#tcdFaqBody<?= $i ?>" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>" aria-controls="tcdFaqBody<?= $i ?>">
                      <?= e($faq['q']) ?>
                    </button>
                  </h2>
                  <div id="tcdFaqBody<?= $i ?>" class="accordion-collapse collapse<?= $i === 0 ? ' show' : '' ?>" aria-labelledby="tcdFaqHead<?= $i ?>" data-bs-parent="#tcdFaq">
                    <div class="accordion-body"><?= e($faq['a']) ?></div>
                  </div>
                </div>
                <?php endforeach; ?>
              </div>
            </div>

          </div>
        </div>
        <!-- ============ /Sidebar ============ -->

      </div>
    </div>
  </section>

</div><!-- /.tcd-page -->

<script>
function tcdSubmitDemo() {
  var form  = document.getElementById('tcdDemoForm');
  var msg   = document.getElementById('tcdDemoMsg');
  var btn   = document.getElementById('tcdSubmitBtn');
  var name  = form.name.value.trim();
  var email = form.email.value.trim();
  var phone = form.phone.value.trim();
  var course = form.course.value;
  var message = form.message.value.trim();

  function show(type, text) { msg.className = 'tcd-demo-msg ' + type; msg.textContent = text; }

  if (name.length < 2) { show('err', 'Please enter your full name.'); return; }
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { show('err', 'Please enter a valid email address.'); return; }
  if (phone.replace(/\D/g, '').length < 10) { show('err', 'Please enter a valid 10-digit phone number.'); return; }
  if (!course) { show('err', 'Please select a course.'); return; }

  btn.disabled = true;
  var original = btn.innerHTML;
  btn.innerHTML = 'Sending...';

  var fd = new FormData();
  fd.append('name', name);
  fd.append('email', email);
  fd.append('phone', phone);
  fd.append('course', course);
  fd.append('message', message);
  fd.append('csrf_token', form.csrf_token.value);

  fetch(window.TC_BASE_URL + '/ajax/enquiry.php', { method: 'POST', body: fd })
    .then(function (r) { return r.json(); })
    .then(function (data) {
      if (data.success) {
        form.reset();
        show('ok', 'Thank you! Your demo request has been submitted. We will contact you soon.');
        if (typeof tcToast === 'function') tcToast('Demo request submitted successfully!', 'success');
      } else {
        show('err', data.message || 'Something went wrong. Please try again.');
      }
    })
    .catch(function () { show('err', 'Network error. Please check your connection.'); })
    .finally(function () { btn.disabled = false; btn.innerHTML = original; });
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
