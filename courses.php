<?php
// ============================================================
// Techno Coderz — Courses Page (LMS layout)
// ============================================================
require_once __DIR__ . '/includes/functions.php';

$pageTitle       = 'Our Courses – Techno Coderz';
$pageDescription = 'Explore TechnoCoderz programmes — AI, Machine Learning & Data Science, Full Stack (MERN & MEAN), DevSecOps / Cyber Security and DevOps | CI/CD with real projects and placement support.';
$currentPage     = 'courses';
$csrf = generateCsrfToken();

$pdo     = getDB();
$courses = $pdo->query("SELECT * FROM courses WHERE status = 1 ORDER BY sort_order ASC, id ASC")->fetchAll();

// Pre-fill live search from the homepage / college-search form (?q=...)
$courseQuery = trim($_GET['q'] ?? '');

// Category filter tabs (LearnUp style)
$categoryTabs = [
    ''                     => 'All Courses',
    'software-development' => 'Software Development',
    'data-science'         => 'Data Science',
    'cyber-security'       => 'Cyber Security',
];

// Technology logo map (local devicon SVGs in assets/images/tech)
$techIcons = [
    'python'        => 'python.svg',
    'numpy'         => 'numpy.svg',
    'tensorflow'    => 'tensorflow.svg',
    'scikit-learn'  => 'scikitlearn.svg',
    'jupyter'       => 'jupyter.svg',
    'sql'           => 'mysql.svg',
    'mysql'         => 'mysql.svg',
    'html & css'    => 'html5.svg',
    'javascript'    => 'javascript.svg',
    'typescript'    => 'typescript.svg',
    'react'         => 'react.svg',
    'node.js'       => 'nodejs.svg',
    'mongodb'       => 'mongodb.svg',
    'angular'       => 'angularjs.svg',
    'express'       => 'express.svg',
    'linux'         => 'linux.svg',
    'kali linux'    => 'kalilinux.svg',
    'bash'          => 'bash.svg',
    'docker'        => 'docker.svg',
    'aws'           => 'amazonwebservices.svg',
    'git'           => 'git.svg',
    'jenkins'       => 'jenkins.svg',
    'kubernetes'    => 'kubernetes.svg',
    'terraform'     => 'terraform.svg',
    'postgresql'    => 'postgresql.svg',
];

$highlightPills = [
    ['icon' => 'bi-hand-index-thumb-fill',      'label' => 'Hands-on Learning'],
    ['icon' => 'bi-calendar2-week-fill',        'label' => '2-Month & 6-Month Programs'],
    ['icon' => 'bi-rocket-takeoff-fill',        'label' => 'Real-World Projects'],
    ['icon' => 'bi-briefcase-fill',             'label' => 'Placement Assistance'],
    ['icon' => 'bi-person-video3-fill',         'label' => '1-on-1 Mentorship'],
];

$whyFeatures = [
    ['icon' => 'bi-person-badge-fill', 'title' => '10–15 Years Experienced Trainers', 'desc' => 'Learn directly from industry practitioners who have shipped real products — not just textbook trainers.'],
    ['icon' => 'bi-infinity',          'title' => 'Lifetime Access',                 'desc' => 'Revisit recordings, notes and updated course material whenever you want, even after you graduate.'],
    ['icon' => 'bi-laptop-code-fill',  'title' => 'Hands-On Projects',               'desc' => 'Build deployable, real-world projects for every module that strengthen your portfolio from day one.'],
    ['icon' => 'bi-trophy-fill',       'title' => '100% Placement Support',          'desc' => 'Resume building, mock interviews, referrals and drives with our 15+ hiring partner network.'],
];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<script>window.TC_BASE_URL = '<?= SITE_URL ?>';</script>
<script>document.addEventListener('DOMContentLoaded',function(){var c=document.getElementById('enquiryCsrf');if(c)c.value='<?=e($csrf)?>';});</script>

<div class="tc-page-light">

<!-- Page Hero -->
<div class="tc-page-hero">
  <div class="container text-center reveal">
    <ul class="tc-breadcrumb">
      <li><a href="<?= SITE_URL ?>"><i class="bi bi-house-fill"></i> Home</a></li>
      <li class="sep">/</li>
      <li class="current">Courses</li>
    </ul>
    <h1 class="tc-section-title" style="margin-bottom:10px;">Our <span>Courses</span></h1>
    <p style="font-size:1.05rem; max-width:680px; margin:0 auto;">
      Career-focused programmes built with industry mentors — 2 to 6 months, project-driven, and designed to make you job-ready from the very first module.
    </p>

    <!-- Key Highlight Badges -->
    <div class="tc-highlight-strip">
      <?php foreach ($highlightPills as $hp): ?>
      <span class="tc-highlight-pill"><i class="<?= e($hp['icon']) ?>"></i> <?= e($hp['label']) ?></span>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<!-- Courses -->
<section class="tc-section">
  <div class="container">

    <?php if ($courses): ?>

    <!-- Filter + Search (LearnUp style) -->
    <div class="tc-filter-bar reveal">
      <div class="tc-filter-chips" id="courseChips">
        <?php foreach ($categoryTabs as $slug => $label): ?>
        <button type="button" class="tc-btn tc-btn-sm <?= ($slug === '') ? 'active' : '' ?>" data-level="<?= e($slug) ?>">
          <?= e($label) ?>
        </button>
        <?php endforeach; ?>
      </div>

      <div class="tc-search-wrap">
        <i class="bi bi-search"></i>
        <input type="search" id="courseSearch" class="tc-form-control"
               value="<?= e($courseQuery) ?>"
               placeholder="Search courses, tech stacks, modules..."
               aria-label="Search courses">
      </div>
    </div>

    <!-- Course Grid (DreamsLMS style) -->
    <div class="row g-4" id="courseGrid">
      <?php foreach ($courses as $i => $course):
          $catSlug  = slugify($course['category'] ?? '');
          $techs    = array_values(array_filter(array_map('trim', explode(',', $course['technologies'] ?? ''))));
          $hl       = array_values(array_filter(array_map('trim', explode(',', $course['highlights'] ?? ''))));
          $haystack = strtolower($course['title'] . ' ' . ($course['short_description'] ?? '') . ' ' . ($course['category'] ?? '') . ' ' . ($course['level'] ?? '') . ' ' . implode(' ', $techs) . ' ' . implode(' ', $hl));
      ?>
      <div class="col-lg-4 col-md-6 course-item reveal"
           data-level="<?= e($catSlug) ?>"
           data-search="<?= e($haystack) ?>"
           style="transition-delay:<?= ($i % 3) * 0.08 ?>s">
        <div class="tc-course-card">

          <!-- Thumbnail + duration badge -->
          <div class="tc-course-img">
            <?php if ($course['image'] && file_exists(UPLOAD_DIR . 'courses/' . $course['image'])): ?>
            <img src="<?= UPLOAD_URL ?>courses/<?= e($course['image']) ?>" alt="<?= e($course['title']) ?>" loading="lazy">
            <?php else: ?>
            <div class="tc-course-icon-wrap"><i class="<?= e($course['icon'] ?? 'bi bi-laptop') ?>"></i></div>
            <?php endif; ?>
            <span class="tc-course-badge"><i class="bi bi-clock-fill"></i> <?= e($course['duration']) ?></span>
            <span class="tc-course-cat"><?= e($course['category']) ?></span>
          </div>

          <div class="tc-course-body">

            <!-- Lesson count / duration / level -->
            <div class="tc-course-stats">
              <div class="tc-course-stat">
                <b><?= (int) $course['lessons'] > 0 ? (int) $course['lessons'] : '—' ?></b>
                <span>Lessons</span>
              </div>
              <div class="tc-course-stat">
                <b><?= e($course['duration']) ?></b>
                <span>Duration</span>
              </div>
              <div class="tc-course-stat">
                <b><?= e($course['level']) ?></b>
                <span>Level</span>
              </div>
            </div>

            <h2 class="tc-course-title"><?= e($course['title']) ?></h2>
            <p class="tc-course-desc"><?= e($course['short_description']) ?></p>

            <!-- Key highlights -->
            <?php if ($hl): ?>
            <ul class="tc-card-highlights">
              <?php foreach (array_slice($hl, 0, 3) as $h): ?>
              <li><i class="bi bi-check-circle-fill"></i> <?= e($h) ?></li>
              <?php endforeach; ?>
            </ul>
            <?php endif; ?>

            <!-- Technology icons -->
            <?php if ($techs): ?>
            <div class="tc-tech-list">
              <?php foreach (array_slice($techs, 0, 6) as $t):
                  $iconFile = $techIcons[strtolower($t)] ?? null;
              ?>
              <span class="tc-tech-chip" title="<?= e($t) ?>">
                <?php if ($iconFile && file_exists(__DIR__ . '/assets/images/tech/' . $iconFile)): ?>
                <img src="<?= SITE_URL ?>/assets/images/tech/<?= e($iconFile) ?>" alt="<?= e($t) ?>" loading="lazy" onerror="this.remove()">
                <?php else: ?>
                <i class="bi bi-puzzle-piece"></i>
                <?php endif; ?>
                <?= e($t) ?>
              </span>
              <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <div class="tc-course-actions">
              <a href="<?= SITE_URL ?>/course-details.php?slug=<?= urlencode($course['slug']) ?>" class="tc-btn tc-btn-secondary tc-btn-sm">
                <i class="bi bi-journal-text"></i> View Syllabus
              </a>
              <button type="button" onclick="openEnquiry('<?= e($course['title']) ?>')" class="tc-btn tc-btn-primary tc-btn-sm">
                Enroll Now
              </button>
            </div>

          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="tc-empty-state text-center py-5" id="courseEmpty" style="display:none; background:var(--tc-white); border-radius:var(--tc-radius-lg); border:1px solid var(--tc-border);">
      <i class="bi bi-search" style="font-size:3rem; color:var(--tc-text-muted); opacity:0.5; margin-bottom:15px; display:block;"></i>
      <p style="margin:0; font-size:1.1rem; color:var(--tc-heading);">No courses match your search.</p>
      <p style="color:var(--tc-text-muted);">Try a different keyword or category.</p>
    </div>

    <?php else: ?>
    <div class="text-center py-5" style="background:var(--tc-white); border-radius:var(--tc-radius-lg); border:1px solid var(--tc-border);">
      <i class="bi bi-book" style="font-size:3rem; color:var(--tc-text-muted); display:block; margin-bottom:16px; opacity:0.4"></i>
      <p style="color:var(--tc-heading); font-size:1.1rem; margin-bottom:5px;">Courses are being prepared.</p>
      <p style="color:var(--tc-text-muted);">Please check back soon!</p>
    </div>
    <?php endif; ?>

  </div>
</section>

<!-- Why Choose Us (FiStudy style) -->
<section class="tc-section" style="padding-top:0;">
  <div class="container">
    <div class="tc-why-band reveal">
      <div class="tc-why-head">
        <div class="tc-badge"><i class="bi bi-stars"></i> Why Choose Us</div>
        <h2 class="tc-section-title">Built For Students Who Want <span>Real Outcomes</span></h2>
        <p>Everything in a TechnoCoderz programme is engineered towards one goal — a job you are genuinely proud of.</p>
      </div>

      <div class="row g-4 tc-why-grid">
        <?php foreach ($whyFeatures as $wf): ?>
        <div class="col-lg-3 col-md-6">
          <div class="tc-why-item">
            <div class="tc-why-icon"><i class="<?= e($wf['icon']) ?>"></i></div>
            <h3><?= e($wf['title']) ?></h3>
            <p><?= e($wf['desc']) ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- Quick CTA (clean light container) -->
<section class="tc-section tc-cta-light-wrap">
  <div class="container">
    <div class="tc-cta-light reveal">
      <h2 class="tc-section-title">Not Sure Which Course<br>Is <span>Right For You</span>?</h2>
      <p>Our counselors can help you choose the perfect learning path based on your background, interests, and career goals.</p>
      <div class="tc-cta-actions">
        <a href="<?= SITE_URL ?>/contact.php" class="tc-btn tc-btn-primary tc-btn-lg">
          Get Free Counseling
        </a>
        <a href="<?= SITE_URL ?>/brochure.php" class="tc-btn tc-btn-secondary tc-btn-lg">
          <i class="bi bi-download"></i> Download Brochure
        </a>
      </div>
    </div>
  </div>
</section>

</div><!-- /.tc-page-light -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
