<?php
// ============================================================
// Techno Coderz — Course Details Page
// ============================================================
require_once __DIR__ . '/includes/functions.php';

$slug   = sanitize($_GET['slug'] ?? '');
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

$pageTitle       = e($course['title']) . ' – Techno Coderz';
$pageDescription = e($course['short_description'] ?? $course['title']);
$currentPage     = 'courses';
$csrf = generateCsrfToken();

// Related courses (same level first, then others) — real DB data
$pdo = getDB();
$relStmt = $pdo->prepare("SELECT * FROM courses WHERE status = 1 AND id != ? ORDER BY (level = ?) DESC, sort_order ASC LIMIT 3");
$relStmt->execute([$course['id'], $course['level']]);
$related = $relStmt->fetchAll();

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<script>window.TC_BASE_URL = '<?= SITE_URL ?>';</script>
<script>document.addEventListener('DOMContentLoaded',function(){var c=document.getElementById('enquiryCsrf');if(c)c.value='<?=e($csrf)?>';});</script>

<div class="tc-page-header">
  <div class="container" style="position:relative;z-index:1;">
    <ul class="tc-breadcrumb">
      <li><a href="<?= SITE_URL ?>"><i class="bi bi-house-fill"></i> Home</a></li>
      <li class="sep">/</li>
      <li><a href="<?= SITE_URL ?>/courses.php">Courses</a></li>
      <li class="sep">/</li>
      <li class="current"><?= e($course['title']) ?></li>
    </ul>
    <div class="tc-page-head-row">
      <div class="tc-page-head-icon"><i class="<?= e($course['icon'] ?? 'bi bi-code-square') ?>"></i></div>
      <div>
        <h1 class="tc-section-title" style="margin-bottom:8px;font-size:clamp(1.6rem,3vw,2.4rem);"><?= e($course['title']) ?></h1>
        <p style="color:var(--tc-text-muted);font-size:0.95rem;max-width:620px;margin:0;">
          <?= e($course['short_description']) ?>
        </p>
      </div>
    </div>
  </div>
</div>

<section class="tc-section">
  <div class="container">
    <div class="row g-5">

      <!-- Main Content -->
      <div class="col-lg-8 reveal">

        <!-- Course facts -->
        <div class="tc-course-facts">
          <div class="tc-course-fact">
            <i class="bi bi-clock-fill"></i>
            <div><span>Duration</span><strong><?= e($course['duration']) ?></strong></div>
          </div>
          <div class="tc-course-fact">
            <i class="bi bi-bar-chart-fill"></i>
            <div><span>Level</span><strong><?= e($course['level']) ?></strong></div>
          </div>
          <div class="tc-course-fact">
            <i class="bi bi-patch-check-fill"></i>
            <div><span>Certificate</span><strong>Included</strong></div>
          </div>
          <div class="tc-course-fact">
            <i class="bi bi-briefcase-fill"></i>
            <div><span>Career</span><strong>Placement Support</strong></div>
          </div>
        </div>

        <!-- About this course -->
        <div class="tc-panel" style="margin-bottom:28px;">
          <h2 class="tc-panel-title"><i class="bi bi-journal-text" style="color:var(--tc-primary-light)"></i> About This Course</h2>
          <div style="color:var(--tc-text-muted);font-size:0.93rem;line-height:1.9;">
            <?= nl2br(e($course['description'] ?? $course['short_description'])) ?>
          </div>
        </div>

        <!-- What You'll Learn -->
        <div class="tc-panel" style="margin-bottom:28px;">
          <h2 class="tc-panel-title"><i class="bi bi-check2-all" style="color:var(--tc-secondary)"></i> What You'll Learn</h2>
          <div class="row g-3">
            <?php
            $learnings = [
              'Core concepts and fundamentals of the technology',
              'Building real, functional projects from scratch',
              'Industry best practices and clean code standards',
              'Working with databases and backend integration',
              'Version control with Git and GitHub workflow',
              'Deploying applications to production environments',
              'Debugging, testing, and error handling techniques',
              'Resume-worthy portfolio projects for job applications',
            ];
            foreach ($learnings as $l):
            ?>
            <div class="col-md-6">
              <div style="display:flex;align-items:flex-start;gap:10px;font-size:0.87rem;color:var(--tc-text);">
                <i class="bi bi-check-circle-fill" style="color:var(--tc-secondary);margin-top:3px;flex-shrink:0;"></i>
                <span><?= $l ?></span>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Who This Is For -->
        <div class="tc-panel">
          <h2 class="tc-panel-title"><i class="bi bi-people-fill" style="color:var(--tc-primary-light)"></i> Who Is This Course For?</h2>
          <ul class="tc-about-list">
            <li>College students looking to gain practical skills beyond academics</li>
            <li>Fresh graduates who want to become job-ready quickly</li>
            <li>Working professionals looking to switch to a tech career</li>
            <li>Freelancers who want to expand their service offerings</li>
            <li>Anyone passionate about learning technology and building projects</li>
          </ul>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="col-lg-4 reveal">
        <div style="position:sticky;top:100px;">

          <!-- Enroll Card -->
          <div class="tc-panel" style="border-color:var(--tc-border);margin-bottom:20px;">
            <div style="text-align:center;margin-bottom:24px;">
              <div style="width:80px;height:80px;background:rgba(108,63,245,0.15);border:1px solid rgba(108,63,245,0.3);border-radius:20px;display:flex;align-items:center;justify-content:center;font-size:2.5rem;color:var(--tc-primary-light);margin:0 auto 16px;">
                <i class="<?= e($course['icon'] ?? 'bi bi-code-square') ?>"></i>
              </div>
              <h3 style="font-family:'Space Grotesk',sans-serif;font-size:1.1rem;font-weight:700;color:#fff;margin-bottom:4px;"><?= e($course['title']) ?></h3>
              <div style="font-size:0.82rem;color:var(--tc-text-muted);"><?= e($course['duration']) ?> • <?= e($course['level']) ?></div>
            </div>

            <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:24px;">
              <div style="display:flex;justify-content:space-between;font-size:0.85rem;padding:8px 0;border-bottom:1px solid var(--tc-border-subtle);">
                <span style="color:var(--tc-text-muted)">Duration</span>
                <span style="color:#fff;font-weight:600"><?= e($course['duration']) ?></span>
              </div>
              <div style="display:flex;justify-content:space-between;font-size:0.85rem;padding:8px 0;border-bottom:1px solid var(--tc-border-subtle);">
                <span style="color:var(--tc-text-muted)">Difficulty</span>
                <span style="color:#fff;font-weight:600"><?= e($course['level']) ?></span>
              </div>
              <div style="display:flex;justify-content:space-between;font-size:0.85rem;padding:8px 0;border-bottom:1px solid var(--tc-border-subtle);">
                <span style="color:var(--tc-text-muted)">Certificate</span>
                <span style="color:var(--tc-secondary);font-weight:600">Yes</span>
              </div>
              <div style="display:flex;justify-content:space-between;font-size:0.85rem;padding:8px 0;">
                <span style="color:var(--tc-text-muted)">Placement</span>
                <span style="color:var(--tc-secondary);font-weight:600">Included</span>
              </div>
            </div>

            <button onclick="openEnquiry('<?= e($course['title']) ?>')" class="tc-btn tc-btn-primary w-100" style="justify-content:center;padding:14px;">
              <i class="bi bi-send-fill"></i> Enquire Now
            </button>
            <a href="<?= SITE_URL ?>/contact.php" class="tc-btn tc-btn-secondary w-100 mt-2" style="justify-content:center;">
              <i class="bi bi-telephone-fill"></i> Talk to Counselor
            </a>
          </div>

          <!-- Help card -->
          <div class="tc-panel" style="text-align:center;padding:20px;">
            <p style="font-size:0.85rem;color:var(--tc-text-muted);margin:0 0 10px;">
              <i class="bi bi-question-circle-fill me-1" style="color:var(--tc-primary-light)"></i>
              Need help choosing a course?
            </p>
            <a href="<?= SITE_URL ?>/faq.php" style="font-size:0.82rem;color:var(--tc-primary-light);">View our FAQ →</a>
          </div>

        </div>
      </div>

    </div>

    <!-- Related courses -->
    <?php if ($related): ?>
    <div class="mt-5 pt-4 reveal" style="border-top:1px solid var(--tc-border-subtle);">
      <h2 class="tc-related-title"><i class="bi bi-collection-fill me-2" style="color:var(--tc-primary-light)"></i>You May Also Like</h2>
      <div class="row g-4">
        <?php foreach ($related as $rc): ?>
        <div class="col-lg-4 col-md-6">
          <a href="<?= SITE_URL ?>/course-details.php?slug=<?= urlencode($rc['slug']) ?>" class="tc-course-card d-block" style="text-decoration:none;">
            <div class="tc-course-img">
              <?php if ($rc['image'] && file_exists(UPLOAD_DIR . 'courses/' . $rc['image'])): ?>
              <img src="<?= UPLOAD_URL ?>courses/<?= e($rc['image']) ?>" alt="<?= e($rc['title']) ?>" loading="lazy" style="width:100%;height:100%;object-fit:cover;">
              <?php else: ?>
              <div class="tc-course-icon-wrap"><i class="<?= e($rc['icon'] ?? 'bi bi-code-square') ?>"></i></div>
              <?php endif; ?>
              <span class="tc-course-badge"><?= e($rc['level']) ?></span>
            </div>
            <div class="tc-course-body">
              <div class="tc-course-level"><i class="bi bi-mortarboard-fill"></i> <?= e($rc['level']) ?></div>
              <h3 class="tc-course-title"><?= e($rc['title']) ?></h3>
              <p class="tc-course-desc"><?= e($rc['short_description']) ?></p>
              <div class="tc-course-meta">
                <span><i class="bi bi-clock"></i> <?= e($rc['duration']) ?></span>
                <span><i class="bi bi-arrow-right"></i> View Course</span>
              </div>
            </div>
          </a>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
