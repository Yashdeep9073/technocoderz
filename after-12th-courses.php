<?php
// ============================================================
// Techno Coderz — After 12th Courses (Landing Page)
// Layout: techcadd-style (EduBlink) with orange theme
// ============================================================
require_once __DIR__ . '/includes/functions.php';

$pageTitle       = 'After 12th Courses – Techno Coderz';
$pageDescription = 'After 12th courses at Techno Coderz: 6 Months, 1 Year certificate programmes, Civil/Architecture/Mechanical training with practical projects.';
$currentPage     = 'after12';
$csrf = generateCsrfToken();

$pdo = getDB();
$courses = $pdo->query("
  SELECT * FROM courses 
  WHERE status = 1 AND category LIKE 'After 12th%' 
  ORDER BY 
    CASE 
      WHEN category LIKE '%6 Months%' THEN 1
      WHEN category LIKE '%1 Year%' THEN 2
      WHEN category LIKE '%Civil%' THEN 3
      ELSE 4
    END,
    sort_order ASC, id ASC
")->fetchAll();

$acCss = SITE_URL . '/assets/css/all-courses.css?v=' . filemtime(__DIR__ . '/assets/css/all-courses.css');
$extraHead = '<link rel="stylesheet" href="' . $acCss . '">';
$extraScripts = '<script src="' . SITE_URL . '/assets/js/course-grid.js?v=' . filemtime(__DIR__ . '/assets/js/course-grid.js') . '"></script>';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<script>window.TC_BASE_URL='<?= SITE_URL ?>';</script>

<div class="tc-lms-page tcl-page">
  <div class="tcl-hero">
    <div class="container text-center">
      <div class="page-title">
        <h1 class="title">After 12<sup>th</sup> Courses</h1>
      </div>
      <nav aria-label="breadcrumb">
        <ul class="edu-breadcrumb">
          <li class="breadcrumb-item"><a href="<?= SITE_URL ?>/index.php">Home</a></li>
          <li class="separator"><i class="bi bi-chevron-right"></i></li>
          <li class="breadcrumb-item active">After 12<sup>th</sup> Courses</li>
        </ul>
      </nav>
    </div>
  </div>

  <div class="edu-course-area edu-section-gap bg-color-white">
    <div class="container">
      <?php if ($courses): ?>
      <div class="row g-4" id="courseGrid">
        <?php foreach ($courses as $course):
          $cat = trim((string)($course['category'] ?? ''));
          $lessons = (int)($course['lessons'] ?? 0);
          $duration = trim((string)($course['duration'] ?? ''));
          $level = trim((string)($course['level'] ?? ''));
          $price = (float)($course['price'] ?? 0);
          $isFree = $price <= 0;
          $url = coursePageUrl($course['slug']);
          $rating = number_format(min(5,4.5+(($course['id']%5)*0.1)),1);
          $stars = (int)round($rating);
        ?>
        <div class="col-md-6 col-lg-4 course-item-wrap">
          <div class="edu-course course-style-1 hover-button-bg-white">
            <div class="inner">
              <div class="thumbnail">
                <a href="<?= $url ?>">
                  <img src="<?= e(courseImage($course['image'] ?? null)) ?>" alt="<?= e($course['title']) ?>" loading="lazy">
                </a>
                <div class="time-top">
                  <?php if ($isFree): ?><span class="tcl-free">Free</span>
                  <?php else: ?><span class="course-price">&#8377;<?= number_format($price,0) ?></span><?php endif; ?>
                </div>
              </div>
              <div class="content">
                <?php if ($cat): ?><span class="course-level"><?= e($cat) ?></span><?php endif; ?>
                <h6 class="title"><a href="<?= $url ?>"><?= e($course['title']) ?></a></h6>
                <div class="course-rating">
                  <div class="rating"><?php for($s=1;$s<=5;$s++): ?><i class="bi bi-star<?= $s<=$stars?'-fill':'' ?>"></i><?php endfor; ?></div>
                  <span class="rating-count">(<?= e($rating) ?> /5 Rating)</span>
                </div>
                <ul class="course-meta">
                  <?php if ($lessons>0): ?><li><i class="bi bi-journal-text"></i><?= $lessons ?> Lessons</li><?php endif; ?>
                  <?php if ($duration): ?><li><i class="bi bi-clock"></i><?= e($duration) ?></li><?php endif; ?>
                  <?php if ($level): ?><li><i class="bi bi-bar-chart"></i><?= e($level) ?></li><?php endif; ?>
                </ul>
                <div class="tcl-card-foot">
                  <h5 class="course-price<?= $isFree?' tcl-free-txt':'' ?>"><?= $isFree?'Free':'&#8377;'.number_format($price,0) ?></h5>
                  <a href="<?= $url ?>" class="edu-btn btn-secondary btn-small">View Course <i class="bi bi-arrow-right"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php else: ?>
      <div class="tcl-empty">
        <i class="bi bi-journal-x"></i>
        <p>After 12<sup>th</sup> courses are being prepared.</p>
        <span>Please check back soon!</span>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
