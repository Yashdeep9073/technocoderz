<?php
// ============================================================
// Techno Coderz — Training page template
// Layout reference: techcadd.com industrial-training page (orange theme)
// Usage: set $trainingSlug before requiring this file (or pass ?slug=)
// ============================================================
require_once __DIR__ . '/functions.php';

$slug = isset($trainingSlug) && $trainingSlug !== '' ? $trainingSlug : sanitize($_GET['slug'] ?? '');
$trainings = require __DIR__ . '/training-data.php';

if (!isset($trainings[$slug])) {
    header('HTTP/1.1 404 Not Found');
    $pageTitle   = '404 – Training Not Found';
    $currentPage = 'training';
    require_once __DIR__ . '/header.php';
    require_once __DIR__ . '/navbar.php';
    echo '<div class="tc-section text-center"><div class="container"><h1 class="tc-section-title">Training <span>Not Found</span></h1><p style="color:var(--tc-text-muted)">The training programme you\'re looking for doesn\'t exist.</p><a href="' . SITE_URL . '/courses.php" class="tc-btn tc-btn-primary mt-3"><i class="bi bi-arrow-left"></i> Browse Courses</a></div></div>';
    require_once __DIR__ . '/footer.php';
    exit;
}

$t = $trainings[$slug];

$pageTitle       = $t['title'] . ' – Techno Coderz';
$pageDescription = 'Join the best ' . $t['label'] . ' in Mohali at Techno Coderz. Hands-on live projects, expert mentorship, certification and placement assistance.';
$currentPage     = 'training';
$csrf = generateCsrfToken();

$pdo = getDB();

/* Settings */
$settings = [];
try {
    foreach ($pdo->query("SELECT setting_key, setting_value FROM site_settings") as $row) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
} catch (Exception $e) { /* ignore */ }
$phone = $settings['phone'] ?? '+91 98765 43210';

/* Demo-form course options */
$allCourses = [];
try {
    $allCourses = $pdo->query("SELECT title, slug FROM courses WHERE status = 1 ORDER BY sort_order ASC, id ASC")->fetchAll();
} catch (Exception $e) { /* ignore */ }

/* Top categories (active courses) */
$cats = [];
try {
    $cats = $pdo->query("SELECT title, slug FROM courses WHERE status = 1 ORDER BY sort_order ASC, id ASC LIMIT 4")->fetchAll();
} catch (Exception $e) { /* ignore */ }
$catIcons = ['bi-robot', 'bi-code-slash', 'bi-shield-lock', 'bi-gear'];

/* Reviews (reuse testimonials) */
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

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/navbar.php';
?>
<script>window.TC_BASE_URL = '<?= SITE_URL ?>';</script>
<script>document.addEventListener('DOMContentLoaded',function(){var c=document.getElementById('enquiryCsrf');if(c)c.value='<?= e($csrf) ?>';});</script>

<style>
/* ============================================================
   Training pages — techcadd layout, Techno Coderz orange theme
   ============================================================ */
.tcx-page{ background:var(--bg-light); }
.tcx-page .text-just{ text-align:justify; }

/* ---- Breadcrumb band ---- */
.tcx-breadcrumb{
  position:relative; overflow:hidden; padding:96px 0 84px;
  background:linear-gradient(135deg,#0b1f33 0%,#12324f 45%,#1b3f63 100%);
}
.tcx-breadcrumb::after{
  content:""; position:absolute; inset:0; z-index:0; opacity:.9;
  background:
    radial-gradient(600px 380px at 12% 10%, rgba(255,107,0,.20), transparent 60%),
    radial-gradient(560px 420px at 88% 90%, rgba(255,107,0,.12), transparent 60%);
}
.tcx-breadcrumb .container{ position:relative; z-index:2; }
.tcx-crumb{ list-style:none; display:flex; flex-wrap:wrap; gap:8px; margin:0 0 16px; padding:0; font-size:.85rem; }
.tcx-crumb li{ color:rgba(255,255,255,.75); }
.tcx-crumb a{ color:rgba(255,255,255,.78); text-decoration:none; transition:.2s; }
.tcx-crumb a:hover{ color:var(--primary); }
.tcx-crumb li.sep{ opacity:.55; }
.tcx-crumb li.active{ color:var(--primary); font-weight:700; }
.tcx-title{ font-family:var(--tc-font-head); font-weight:800; color:#fff; font-size:clamp(1.6rem,3.4vw,2.6rem); line-height:1.2; margin:0 0 18px; max-width:900px; }
.tcx-crumb-meta{ list-style:none; display:flex; flex-wrap:wrap; gap:28px; margin:0; padding:0; }
.tcx-crumb-meta li{ color:rgba(255,255,255,.92); font-weight:600; font-size:.92rem; display:flex; align-items:center; gap:8px; }
.tcx-crumb-meta li i{ color:var(--primary); font-size:1.1rem; }
.tcx-shape{ list-style:none; position:absolute; inset:0; margin:0; padding:0; z-index:1; }
.tcx-shape li{ position:absolute; border:1px solid rgba(255,255,255,.09); border-radius:50%; }
.tcx-shape li.s1{ width:470px; height:470px; top:-315px; left:-60px; }
.tcx-shape li.s2{ width:470px; height:470px; top:30px; right:-180px; }
@media(max-width:991px){ .tcx-breadcrumb{ padding:70px 0 60px; } }
@media(max-width:575px){ .tcx-breadcrumb{ padding:55px 0 45px; } .tcx-crumb-meta{ gap:16px; } }

/* ---- Sections / cards ---- */
.tcx-section{ padding:96px 0; }
@media(max-width:1023.98px){ .tcx-section{ padding:64px 0; } }

.tcx-main-card{ background:#fff; border-radius:14px; padding:34px 34px 42px; box-shadow:0 10px 50px rgba(26,46,85,.08); }
@media(max-width:575px){ .tcx-main-card{ padding:22px 18px 32px; } }

.tcx-tabs{ border-bottom:2px solid var(--border); gap:34px; margin:0; flex-wrap:wrap; }
.tcx-tabs .nav-link{
  border:0; background:transparent; padding:0 0 16px; font-weight:700; color:var(--text-muted);
  font-family:var(--tc-font-head); font-size:1rem; cursor:pointer; position:relative;
}
.tcx-tabs .nav-link::after{ content:""; position:absolute; left:0; bottom:-2px; height:3px; width:0; background:linear-gradient(135deg,var(--primary),var(--primary-light)); transition:.25s; border-radius:3px; }
.tcx-tabs .nav-link:hover{ color:var(--primary); }
.tcx-tabs .nav-link.active{ color:var(--primary); }
.tcx-tabs .nav-link.active::after{ width:100%; }

.tcx-tab-content{ margin-top:40px; }
.tcx-overview p{ color:var(--text-body); line-height:1.9; font-size:.95rem; margin-bottom:18px; }
.tcx-heading{ font-family:var(--tc-font-head); font-weight:800; color:var(--text-heading); font-size:1.35rem; margin:34px 0 14px; position:relative; padding-left:18px; }
.tcx-heading::before{ content:""; position:absolute; left:0; top:4px; bottom:4px; width:5px; border-radius:3px; background:linear-gradient(180deg,var(--primary),var(--primary-light)); }
.tcx-h4{ font-family:var(--tc-font-head); font-weight:700; color:var(--text-heading); font-size:1.05rem; margin:26px 0 10px; }
.tcx-h5{ font-family:var(--tc-font-head); font-weight:700; color:var(--text-heading); font-size:.98rem; margin:24px 0 10px; }

.tcx-table{ width:100%; border-collapse:collapse; margin:6px 0 10px; border:1px solid var(--border); border-radius:10px; overflow:hidden; }
.tcx-table th, .tcx-table td{ padding:12px 16px; border-bottom:1px solid var(--border-light); text-align:left; font-size:.92rem; color:var(--text-body); }
.tcx-table thead th{ background:var(--primary-soft); color:var(--text-heading); font-family:var(--tc-font-head); font-weight:800; }
.tcx-table tbody tr:last-child td{ border-bottom:0; }
.tcx-table tbody tr:hover td{ background:var(--bg-light); }

.tcx-list{ list-style:none; padding:0; margin:4px 0 10px; }
.tcx-list li{ position:relative; padding:8px 0 8px 30px; color:var(--text-body); font-size:.94rem; line-height:1.85; }
.tcx-list li::before{ content:"\f26a"; font-family:"bootstrap-icons"; position:absolute; left:0; top:8px; color:var(--primary); }
.tcx-list li b{ color:var(--text-heading); }

.tcx-checklist{ list-style:none; padding:0; margin:4px 0 10px; }
.tcx-checklist li{ display:flex; gap:12px; padding:8px 0; color:var(--text-body); font-size:.93rem; line-height:1.7; }
.tcx-checklist li i{ color:var(--primary); margin-top:3px; flex-shrink:0; }

/* ---- Reviews ---- */
.tcx-review .tcx-rating-box{ background:var(--bg-light); border-radius:12px; padding:24px; text-align:center; }
.tcx-rating-number{ font-family:var(--tc-font-head); font-weight:800; font-size:28px; line-height:1; color:var(--text-heading); }
.tcx-stars{ color:#F8B81F; margin-bottom:5px; display:flex; gap:2px; }
.tcx-review .tcx-rating-box .tcx-stars{ justify-content:center; margin-top:6px; }
.tcx-rating-box span{ font-size:14px; color:var(--text-muted); }
.tcx-review-wrapper .tcx-rating-row{ display:flex; align-items:center; gap:14px; margin-bottom:12px; }
.tcx-rating-text{ width:56px; flex-shrink:0; font-weight:600; color:var(--text-heading); font-size:.85rem; display:flex; align-items:center; gap:4px; }
.tcx-rating-text i{ color:#F8B81F; }
.tcx-review-wrapper .progress{ flex:1; height:6px; background:#f2f2f2; border-radius:30px; overflow:hidden; }
.tcx-review-wrapper .progress-bar{ background:linear-gradient(135deg,var(--primary),var(--primary-light)); }
.tcx-rating-value{ width:26px; text-align:right; font-weight:700; color:var(--text-heading); font-size:.8rem; }
.tcx-comment-area{ margin-top:50px; border-top:1px solid var(--border); padding-top:34px; }
.tcx-comment{ display:flex; gap:18px; padding:22px 0; border-bottom:1px solid var(--border-light); }
.tcx-comment:last-child{ border-bottom:0; }
.tcx-avatar{ width:52px; height:52px; flex-shrink:0; border-radius:50%; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,var(--primary),var(--primary-dark)); color:#fff; font-weight:800; font-size:1.2rem; }
.tcx-comment-content h5{ font-family:var(--tc-font-head); font-weight:800; color:var(--text-heading); font-size:1rem; margin:6px 0 2px; }
.tcx-comment-content .tcx-desig{ color:var(--primary); font-size:.82rem; font-weight:600; }
.tcx-comment-content p{ color:var(--text-body); font-size:.92rem; line-height:1.8; margin:8px 0 0; }

/* ---- Sidebar ---- */
.tcx-sidebar{ display:flex; flex-direction:column; gap:24px; }
.tcx-widget{ background:#fff; border-radius:14px; padding:26px; box-shadow:0 10px 40px rgba(26,46,85,.08); }
.tcx-widget-title{ font-family:var(--tc-font-head); font-weight:800; color:var(--text-heading); font-size:1.15rem; margin:0 0 18px; padding-bottom:12px; border-bottom:2px solid var(--border-light); }
.tcx-thumb{ position:relative; border-radius:10px; overflow:hidden; margin-bottom:22px; }
.tcx-thumb img{ width:100%; height:200px; object-fit:cover; display:block; }
.tcx-play{ position:absolute; inset:0; margin:auto; width:58px; height:58px; border-radius:50%; background:rgba(255,107,0,.92); color:#fff; display:flex; align-items:center; justify-content:center; font-size:1.7rem; text-decoration:none; box-shadow:0 8px 24px rgba(255,107,0,.45); animation:tcxPulse 1.8s infinite; }
@keyframes tcxPulse{ 0%{box-shadow:0 8px 24px rgba(255,107,0,.45),0 0 0 0 rgba(255,107,0,.4)} 70%{box-shadow:0 8px 24px rgba(255,107,0,.45),0 0 0 16px rgba(255,107,0,0)} 100%{box-shadow:0 8px 24px rgba(255,107,0,.45),0 0 0 0 rgba(255,107,0,0)} }
.tcx-course-item{ list-style:none; padding:0; margin:0 0 18px; }
.tcx-course-item li{ display:flex; justify-content:space-between; gap:12px; padding:11px 0; border-bottom:1px solid var(--border-light); font-size:.9rem; }
.tcx-course-item li:last-child{ border-bottom:0; }
.tcx-label{ color:var(--text-muted); font-weight:600; display:flex; align-items:center; gap:8px; }
.tcx-label i{ color:var(--primary); }
.tcx-value{ color:var(--text-heading); font-weight:700; text-align:right; }
.tcx-read-more{ margin-bottom:20px; }
.tcx-btn{ display:inline-flex; align-items:center; justify-content:center; gap:9px; width:100%; background:linear-gradient(135deg,var(--primary),var(--primary-dark)); color:#fff; border:0; border-radius:11px; padding:14px 22px; font-weight:800; font-size:.95rem; cursor:pointer; transition:.25s; box-shadow:0 10px 24px rgba(255,107,0,.28); text-decoration:none; }
.tcx-btn:hover{ transform:translateY(-2px); box-shadow:0 14px 30px rgba(255,107,0,.36); color:#fff; }
.tcx-share{ border-top:1px solid var(--border-light); padding-top:18px; }
.tcx-share-title{ font-family:var(--tc-font-head); font-weight:800; color:var(--text-heading); font-size:.95rem; margin:0 0 12px; }
.tcx-social-share{ list-style:none; display:flex; gap:10px; padding:0; margin:0 0 14px; flex-wrap:wrap; }
.tcx-social-share a{ width:38px; height:38px; border-radius:10px; display:flex; align-items:center; justify-content:center; color:#fff; text-decoration:none; transition:.25s; }
.tcx-social-share a:hover{ transform:translateY(-3px); }
.tcx-fb{ background:#1877f2; } .tcx-tw{ background:#0f1419; } .tcx-li{ background:#0a66c2; } .tcx-yt{ background:#ff0000; } .tcx-ig{ background:linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888); }
.tcx-contact{ font-family:var(--tc-font-head); font-weight:800; color:var(--primary); font-size:.92rem; margin:0; }

/* ---- Demo form ---- */
.tcx-demo-head{ margin-bottom:16px; }
.tcx-demo-head h4{ font-family:var(--tc-font-head); font-weight:800; color:var(--text-heading); margin:0 0 4px; font-size:1.1rem; }
.tcx-demo-head p{ color:var(--text-muted); font-size:.86rem; margin:0; }
.tcx-field{ margin-bottom:14px; }
.tcx-field label{ display:block; font-weight:700; color:var(--text-heading); font-size:.82rem; margin-bottom:6px; }
.tcx-field input, .tcx-field select, .tcx-field textarea{
  width:100%; padding:12px 14px; border:2px solid var(--border); border-radius:10px; font-size:.9rem;
  background:var(--bg-light); color:var(--text-body); outline:none; transition:.2s;
}
.tcx-field input:focus, .tcx-field select:focus, .tcx-field textarea:focus{ border-color:var(--primary); background:#fff; box-shadow:0 0 0 3px rgba(255,107,0,.12); }
.tcx-field textarea{ resize:vertical; min-height:90px; }
.tcx-demo-msg{ display:none; border-radius:9px; padding:11px 14px; font-size:.85rem; margin-bottom:14px; }
.tcx-demo-msg.ok{ display:block; background:#e7f8ef; color:#0f7a43; border:1px solid #b6e6cc; }
.tcx-demo-msg.err{ display:block; background:#fdecec; color:#c0392b; border:1px solid #f5c6cb; }

/* ---- FAQ ---- */
.tcx-accordion .accordion-item{ border:1px solid var(--border); border-radius:10px; margin-bottom:10px; overflow:hidden; }
.tcx-accordion .accordion-button{ font-family:var(--tc-font-head); font-weight:700; color:var(--text-heading); font-size:.9rem; background:#fff; padding:15px 16px; box-shadow:none; }
.tcx-accordion .accordion-button:not(.collapsed){ background:var(--primary-soft); color:var(--primary); }
.tcx-accordion .accordion-button:focus{ box-shadow:none; border-color:transparent; }
.tcx-accordion .accordion-button::after{ background-size:.9rem; }
.tcx-accordion .accordion-body{ color:var(--text-body); font-size:.87rem; line-height:1.8; }

/* ---- Top categories ---- */
.tcx-cats{ display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.tcx-cat{ display:flex; flex-direction:column; align-items:center; gap:8px; text-align:center; padding:16px 10px; border:1px solid var(--border); border-radius:12px; text-decoration:none; transition:.25s; background:#fff; }
.tcx-cat:hover{ border-color:var(--primary); background:var(--primary-soft); transform:translateY(-3px); }
.tcx-cat-icon{ width:44px; height:44px; border-radius:50%; display:flex; align-items:center; justify-content:center; background:var(--primary-soft); color:var(--primary); font-size:1.25rem; transition:.25s; }
.tcx-cat:hover .tcx-cat-icon{ background:var(--primary); color:#fff; }
.tcx-cat-name{ font-family:var(--tc-font-head); font-weight:700; color:var(--text-heading); font-size:.82rem; line-height:1.35; }
@media(max-width:575px){ .tcx-cats{ grid-template-columns:1fr 1fr; } }
</style>

<div class="tcx-page">

  <!-- ============ Breadcrumb band ============ -->
  <div class="tcx-breadcrumb">
    <div class="container">
      <ol class="tcx-crumb">
        <li><a href="<?= SITE_URL ?>/index.php">Home</a></li>
        <li class="sep">/</li>
        <li><a href="<?= SITE_URL ?>/courses.php">Internship &amp; Training</a></li>
        <li class="sep">/</li>
        <li class="active"><?= e($t['label']) ?></li>
      </ol>
      <h1 class="tcx-title"><?= e($t['title']) ?></h1>
      <ul class="tcx-crumb-meta">
        <?php if (!empty($t['level'])): ?><li><i class="bi bi-bar-chart-fill"></i> <?= e($t['level']) ?></li><?php endif; ?>
        <?php if (!empty($t['duration'])): ?><li><i class="bi bi-clock-fill"></i> <?= e($t['duration']) ?></li><?php endif; ?>
        <li><i class="bi bi-patch-check-fill"></i> Certificate Included</li>
      </ul>
    </div>
    <ul class="tcx-shape"><li class="s1"></li><li class="s2"></li></ul>
  </div>

  <!-- ============ Training details ============ -->
  <section class="tcx-section">
    <div class="container">
      <div class="row g-4">

        <!-- ============ Main column ============ -->
        <div class="col-lg-8">
          <div class="tcx-main-card">

            <ul class="nav tcx-tabs" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tcx-tab-overview" data-bs-toggle="tab" data-bs-target="#tcx-overview" type="button" role="tab" aria-controls="tcx-overview" aria-selected="true">Overview</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="tcx-tab-reviews" data-bs-toggle="tab" data-bs-target="#tcx-reviews" type="button" role="tab" aria-controls="tcx-reviews" aria-selected="false">Reviews</button>
              </li>
            </ul>

            <div class="tab-content tcx-tab-content">

              <!-- ---------- Overview ---------- -->
              <div class="tab-pane fade show active" id="tcx-overview" role="tabpanel" aria-labelledby="tcx-tab-overview">
                <div class="tcx-overview">
                  <p class="text-just"><?= e($t['intro']) ?></p>

                  <h3 class="tcx-heading">What is <?= e($t['topic']) ?>?</h3>
                  <p class="text-just"><?= e($t['what']) ?> At <strong>Techno Coderz</strong>, you learn by doing — building real projects under the guidance of industry experts.</p>

                  <h3 class="tcx-heading">Our Training Modules</h3>
                  <p class="text-just">Choose from a wide range of technology modules, each available as a 45-day or 6-month programme:</p>
                  <table class="tcx-table">
                    <thead>
                      <tr><th style="width:70px">S. No.</th><th>Training Program</th><th style="width:200px">Duration</th></tr>
                    </thead>
                    <tbody>
                      <?php foreach ($t['modules'] as $i => $m): ?>
                      <tr><td><?= $i + 1 ?></td><td><?= e($m[0]) ?></td><td><?= e($m[1]) ?></td></tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>

                  <h4 class="tcx-h4">Techno Coderz provides flexible training options to cater to different needs:</h4>
                  <ul class="tcx-list">
                    <?php foreach ($t['flexible'] as $f): ?>
                    <li><b><?= e($f[0]) ?></b> <?= e($f[1]) ?></li>
                    <?php endforeach; ?>
                  </ul>

                  <h4 class="tcx-h4">Courses Offered by Techno Coderz:</h4>
                  <ul class="tcx-list">
                    <?php foreach ($t['offered'] as $o): ?>
                    <li><b><?= e($o[0]) ?></b> — <?= e($o[1]) ?></li>
                    <?php endforeach; ?>
                  </ul>

                  <h5 class="tcx-h5">What You'll Learn?</h5>
                  <ul class="tcx-checklist">
                    <?php foreach ($t['learn'] as $l): ?>
                    <li><i class="bi bi-check-circle-fill"></i><span><?= e($l) ?></span></li>
                    <?php endforeach; ?>
                  </ul>

                  <h3 class="tcx-heading">Why Techno Coderz is the Best Choice for <?= e($t['label']) ?> in Mohali</h3>
                  <ol class="tcx-list" style="list-style:none;">
                    <?php foreach ($t['why'] as $w): ?>
                    <li><b><?= e($w[0]) ?>:</b> <?= e($w[1]) ?></li>
                    <?php endforeach; ?>
                  </ol>

                  <p class="text-just" style="margin-top:22px;">
                    Our <strong><?= e($t['title']) ?></strong> programme with expert trainers is a great opportunity with a highly practical approach. Our curriculum is always up to date and equips you with the skills needed in today's tech-driven world. Join us today and start moving toward a fulfilling career — call us now to book your seat.
                  </p>
                </div>
              </div>

              <!-- ---------- Reviews ---------- -->
              <div class="tab-pane fade" id="tcx-reviews" role="tabpanel" aria-labelledby="tcx-tab-reviews">
                <div class="tcx-review">
                  <h3 class="tcx-heading" style="margin-top:0;">Course Rating</h3>
                  <p class="text-just"><?= number_format($avgRating, 2) ?> average rating based on <?= $reviewCount ?> rating<?= $reviewCount === 1 ? '' : 's' ?></p>

                  <div class="row g-0 align-items-center mt-4">
                    <div class="col-sm-4">
                      <div class="tcx-rating-box">
                        <div class="tcx-rating-number"><?= number_format($avgRating, 1) ?></div>
                        <div class="tcx-stars">
                          <?php for ($s = 1; $s <= 5; $s++): ?>
                          <i class="bi bi-star<?= $s <= round($avgRating) ? '-fill' : '' ?>"></i>
                          <?php endfor; ?>
                        </div>
                        <span>(<?= $reviewCount ?> Review<?= $reviewCount === 1 ? '' : 's' ?>)</span>
                      </div>
                    </div>
                    <div class="col-sm-8">
                      <div class="tcx-review-wrapper">
                        <?php for ($star = 5; $star >= 1; $star--):
                            $count = $starBuckets[$star];
                            $pct   = $reviewCount ? round(($count / $reviewCount) * 100) : 0;
                        ?>
                        <div class="tcx-rating-row">
                          <div class="tcx-rating-text"><?= $star ?> <i class="bi bi-star-fill"></i></div>
                          <div class="progress"><div class="progress-bar" role="progressbar" style="width:<?= $pct ?>%" aria-valuenow="<?= $pct ?>" aria-valuemin="0" aria-valuemax="100"></div></div>
                          <span class="tcx-rating-value"><?= $count ?></span>
                        </div>
                        <?php endfor; ?>
                      </div>
                    </div>
                  </div>

                  <?php if ($reviews): ?>
                  <div class="tcx-comment-area">
                    <h3 class="tcx-heading">Reviews</h3>
                    <div class="tcx-comment-list">
                      <?php foreach ($reviews as $rev):
                          $rt      = (int) ($rev['rating'] ?? 5);
                          $name    = trim((string) ($rev['name'] ?? 'Student'));
                          $initial = strtoupper(mb_substr($name, 0, 1));
                      ?>
                      <div class="tcx-comment">
                        <div class="tcx-avatar"><?= e($initial) ?></div>
                        <div class="tcx-comment-content">
                          <div class="tcx-stars">
                            <?php for ($s = 1; $s <= 5; $s++): ?>
                            <i class="bi bi-star<?= $s <= $rt ? '-fill' : '' ?>"></i>
                            <?php endfor; ?>
                          </div>
                          <h5><?= e($name) ?></h5>
                          <?php if (!empty($rev['designation'])): ?><span class="tcx-desig"><?= e($rev['designation']) ?></span><?php endif; ?>
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
          <div class="tcx-sidebar">

            <!-- Summary widget -->
            <div class="tcx-widget tcx-summary">
              <div class="tcx-thumb">
                <img src="<?= SITE_URL ?>/<?= e($t['image']) ?>" alt="<?= e($t['title']) ?>" loading="lazy">
                <a href="javascript:void(0);" class="tcx-play" aria-label="Book a free demo" onclick="openEnquiry('<?= e($t['title']) ?>')"><i class="bi bi-play-fill"></i></a>
              </div>
              <h4 class="tcx-widget-title">Training Includes:</h4>
              <ul class="tcx-course-item">
                <li><span class="tcx-label"><i class="bi bi-person-video3"></i>Instructor:</span><span class="tcx-value">Expert Trainers</span></li>
                <?php if (!empty($t['duration'])): ?>
                <li><span class="tcx-label"><i class="bi bi-clock-history"></i>Duration:</span><span class="tcx-value"><?= e($t['duration']) ?></span></li>
                <?php endif; ?>
                <li><span class="tcx-label"><i class="bi bi-journal-text"></i>Modules:</span><span class="tcx-value"><?= count($t['modules']) ?></span></li>
                <li><span class="tcx-label"><i class="bi bi-kanban"></i>Projects:</span><span class="tcx-value">Live Projects</span></li>
                <li><span class="tcx-label"><i class="bi bi-translate"></i>Language:</span><span class="tcx-value">English-Hindi</span></li>
                <li><span class="tcx-label"><i class="bi bi-patch-check"></i>Certificate:</span><span class="tcx-value">Yes</span></li>
                <li><span class="tcx-label"><i class="bi bi-bar-chart"></i>Level:</span><span class="tcx-value"><?= e($t['level'] ?: 'All Levels') ?></span></li>
              </ul>
              <div class="tcx-read-more">
                <button type="button" class="tcx-btn" onclick="openEnquiry('<?= e($t['title']) ?>')">Start Now <i class="bi bi-arrow-right"></i></button>
              </div>
              <div class="tcx-share">
                <h4 class="tcx-share-title">Share On:</h4>
                <ul class="tcx-social-share">
                  <li><a class="tcx-fb" href="https://facebook.com/technocoderz" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a></li>
                  <li><a class="tcx-tw" href="https://twitter.com/technocoderz" target="_blank" rel="noopener" aria-label="Twitter/X"><i class="bi bi-twitter-x"></i></a></li>
                  <li><a class="tcx-li" href="https://linkedin.com/company/technocoderz" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a></li>
                  <li><a class="tcx-yt" href="https://youtube.com/@technocoderz" target="_blank" rel="noopener" aria-label="YouTube"><i class="bi bi-youtube"></i></a></li>
                  <li><a class="tcx-ig" href="https://instagram.com/technocoderz" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a></li>
                </ul>
                <h5 class="tcx-contact">Contact us: <?= e($phone) ?></h5>
              </div>
            </div>

            <!-- Demo form widget -->
            <div class="tcx-widget tcx-demo">
              <div class="tcx-demo-head">
                <h4>Techno Coderz</h4>
                <p>Fill out this form for booking a free demo session.</p>
              </div>
              <div id="tcxDemoMsg" class="tcx-demo-msg"></div>
              <form id="tcxDemoForm" onsubmit="event.preventDefault(); tcxSubmitDemo();" novalidate>
                <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
                <div class="tcx-field">
                  <label for="tcxName">Full Name *</label>
                  <input type="text" name="name" id="tcxName" placeholder="Enter your full name" required>
                </div>
                <div class="tcx-field">
                  <label for="tcxEmail">Email Address *</label>
                  <input type="email" name="email" id="tcxEmail" placeholder="you@example.com" required>
                </div>
                <div class="tcx-field">
                  <label for="tcxPhone">Phone Number *</label>
                  <input type="tel" name="phone" id="tcxPhone" placeholder="Enter 10-digit phone number" pattern="[0-9]{10}" required>
                </div>
                <div class="tcx-field">
                  <label for="tcxCourse">Select Course *</label>
                  <select name="course" id="tcxCourse" required>
                    <option value="" disabled>Choose your course</option>
                    <?php foreach ($allCourses as $oc): ?>
                    <option value="<?= e($oc['title']) ?>"><?= e($oc['title']) ?></option>
                    <?php endforeach; ?>
                    <option value="<?= e($t['label']) ?>" selected><?= e($t['label']) ?></option>
                    <option value="Other">Other</option>
                  </select>
                </div>
                <div class="tcx-field">
                  <label for="tcxMessage">Message (Optional)</label>
                  <textarea name="message" id="tcxMessage" placeholder="Tell us about your learning goals or any specific requirements..." rows="3"></textarea>
                </div>
                <button type="submit" id="tcxSubmitBtn" class="tcx-btn"><i class="bi bi-send-fill"></i> Submit Message</button>
              </form>
            </div>

            <!-- FAQ widget -->
            <div class="tcx-widget tcx-faq">
              <h4 class="tcx-widget-title">FAQ's</h4>
              <div class="accordion tcx-accordion" id="tcxFaq">
                <?php foreach ($t['faqs'] as $i => $faq): ?>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="tcxFaqHead<?= $i ?>">
                    <button class="accordion-button<?= $i === 0 ? '' : ' collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#tcxFaqBody<?= $i ?>" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>" aria-controls="tcxFaqBody<?= $i ?>">
                      <?= e($faq['q']) ?>
                    </button>
                  </h2>
                  <div id="tcxFaqBody<?= $i ?>" class="accordion-collapse collapse<?= $i === 0 ? ' show' : '' ?>" aria-labelledby="tcxFaqHead<?= $i ?>" data-bs-parent="#tcxFaq">
                    <div class="accordion-body"><?= e($faq['a']) ?></div>
                  </div>
                </div>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- Top Categories widget -->
            <?php if ($cats): ?>
            <div class="tcx-widget">
              <h4 class="tcx-widget-title">Top Categories</h4>
              <div class="tcx-cats">
                <?php foreach ($cats as $ci => $cat): ?>
                <a class="tcx-cat" href="<?= e(coursePageUrl($cat['slug'])) ?>">
                  <span class="tcx-cat-icon"><i class="bi <?= e($catIcons[$ci] ?? 'bi-book') ?>"></i></span>
                  <span class="tcx-cat-name"><?= e($cat['title']) ?></span>
                </a>
                <?php endforeach; ?>
                <a class="tcx-cat" href="<?= SITE_URL ?>/courses.php">
                  <span class="tcx-cat-icon"><i class="bi bi-collection"></i></span>
                  <span class="tcx-cat-name">All Courses</span>
                </a>
                <a class="tcx-cat" href="<?= SITE_URL ?>/projects.php">
                  <span class="tcx-cat-icon"><i class="bi bi-kanban"></i></span>
                  <span class="tcx-cat-name">Projects</span>
                </a>
              </div>
            </div>
            <?php endif; ?>

          </div>
        </div>
        <!-- ============ /Sidebar ============ -->

      </div>
    </div>
  </section>

</div><!-- /.tcx-page -->

<script>
function tcxSubmitDemo() {
  var form  = document.getElementById('tcxDemoForm');
  var msg   = document.getElementById('tcxDemoMsg');
  var btn   = document.getElementById('tcxSubmitBtn');
  var name  = form.name.value.trim();
  var email = form.email.value.trim();
  var phone = form.phone.value.trim();
  var course = form.course.value;
  var message = form.message.value.trim();

  function show(type, text) { msg.className = 'tcx-demo-msg ' + type; msg.textContent = text; }

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

<?php require_once __DIR__ . '/footer.php'; ?>
