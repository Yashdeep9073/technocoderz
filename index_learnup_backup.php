<?php
// ============================================================
// Techno Coderz — Homepage
// Layout recreated from LearnUp "Home 4" (section order + visual
// structure, top to bottom), filled only with the content that
// already exists in this project / database. No new products,
// prices or CTAs were invented and no backend logic or schema was
// changed.
// ============================================================
require_once __DIR__ . '/includes/functions.php';

$pageTitle       = 'Techno Coderz | IT Training & Software Development Institute';
$pageDescription = 'Techno Coderz is a premier IT training and software development institute offering career-focused courses in AI & Data Science, Full Stack, DevSecOps and DevOps, with real projects and placement support.';
$currentPage     = 'home';
$csrf            = generateCsrfToken();

$pdo = getDB();

$courses = $services = $projects = $testimonials = $blogs = [];
$settings = [];

try {
    $courses      = $pdo->query("SELECT * FROM courses WHERE status = 1 ORDER BY sort_order ASC, id ASC")->fetchAll();
    $services     = $pdo->query("SELECT * FROM services WHERE status = 1 ORDER BY sort_order ASC, id ASC LIMIT 6")->fetchAll();
    $projects     = $pdo->query("SELECT * FROM projects WHERE status = 1 ORDER BY sort_order ASC, id ASC LIMIT 6")->fetchAll();
    $testimonials = $pdo->query("SELECT * FROM testimonials WHERE status = 1 ORDER BY id ASC LIMIT 6")->fetchAll();
    $blogs        = $pdo->query("SELECT * FROM blogs WHERE status = 1 ORDER BY created_at DESC, id DESC LIMIT 3")->fetchAll();
    foreach ($pdo->query("SELECT setting_key, setting_value FROM site_settings") as $row) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
} catch (Throwable $e) {
    error_log('Homepage data: ' . $e->getMessage());
}

$tagline    = $settings['tagline'] ?? 'Build Skills. Create Projects. Grow Your Tech Career.';
$siteName   = $settings['site_name'] ?? 'Techno Coderz';
$homePhone  = $settings['phone'] ?? '+91 98765 43210';
$homeEmail  = $settings['email'] ?? 'info@technocoderz.com';
$homePhone2 = $settings['phone2'] ?? '';
$homeEmail2 = $settings['email2'] ?? '';
$homeAddr   = $settings['address'] ?? 'Mohali, Punjab, India';
$homeCity   = $settings['location'] ?? '';

// Technology icon map (same set used on the courses page)
$techIcons = [
    'python' => 'python.svg', 'numpy' => 'numpy.svg', 'tensorflow' => 'tensorflow.svg',
    'scikit-learn' => 'scikitlearn.svg', 'jupyter' => 'jupyter.svg', 'sql' => 'mysql.svg',
    'mysql' => 'mysql.svg', 'html & css' => 'html5.svg', 'javascript' => 'javascript.svg',
    'typescript' => 'typescript.svg', 'react' => 'react.svg', 'node.js' => 'nodejs.svg',
    'mongodb' => 'mongodb.svg', 'angular' => 'angularjs.svg', 'express' => 'express.svg',
    'linux' => 'linux.svg', 'kali linux' => 'kalilinux.svg', 'bash' => 'bash.svg',
    'docker' => 'docker.svg', 'aws' => 'amazonwebservices.svg', 'git' => 'git.svg',
    'jenkins' => 'jenkins.svg', 'kubernetes' => 'kubernetes.svg', 'terraform' => 'terraform.svg',
    'postgresql' => 'postgresql.svg',
];

$whyFeatures = [
    ['icon' => 'bi-person-badge-fill', 'title' => 'Experienced Trainers', 'desc' => 'Learn from industry practitioners who ship real products every day.'],
    ['icon' => 'bi-laptop-code-fill',  'title' => 'Hands-On Projects',    'desc' => 'Build deployable, real-world projects that strengthen your portfolio.'],
    ['icon' => 'bi-trophy-fill',       'title' => 'Placement Support',    'desc' => 'Resume building, mock interviews and referrals with hiring partners.'],
    ['icon' => 'bi-infinity',          'title' => 'Lifetime Access',       'desc' => 'Revisit recordings, notes and updated material whenever you want.'],
];

// Category tiles — grouped from the active courses already loaded above
$categoryTiles = [];
foreach ($courses as $c) {
    $cat = trim($c['category'] ?? '');
    if ($cat === '') { continue; }
    $slug = slugify($cat);
    if (!isset($categoryTiles[$slug])) {
        $categoryTiles[$slug] = ['name' => $cat, 'count' => 0];
    }
    $categoryTiles[$slug]['count']++;
}
$categoryIcons = [
    'data-science'         => 'bi-bar-chart-fill',
    'software-development' => 'bi-code-slash',
    'cyber-security'       => 'bi-shield-lock-fill',
];

// Technology logo strip (icons that actually exist in assets/images/tech)
$techStrip = [
    ['file' => 'python.svg', 'name' => 'Python'],
    ['file' => 'tensorflow.svg', 'name' => 'TensorFlow'],
    ['file' => 'scikitlearn.svg', 'name' => 'scikit-learn'],
    ['file' => 'numpy.svg', 'name' => 'NumPy'],
    ['file' => 'jupyter.svg', 'name' => 'Jupyter'],
    ['file' => 'mysql.svg', 'name' => 'MySQL'],
    ['file' => 'postgresql.svg', 'name' => 'PostgreSQL'],
    ['file' => 'mongodb.svg', 'name' => 'MongoDB'],
    ['file' => 'react.svg', 'name' => 'React'],
    ['file' => 'angularjs.svg', 'name' => 'Angular'],
    ['file' => 'nodejs.svg', 'name' => 'Node.js'],
    ['file' => 'express.svg', 'name' => 'Express'],
    ['file' => 'typescript.svg', 'name' => 'TypeScript'],
    ['file' => 'javascript.svg', 'name' => 'JavaScript'],
    ['file' => 'docker.svg', 'name' => 'Docker'],
    ['file' => 'kubernetes.svg', 'name' => 'Kubernetes'],
    ['file' => 'terraform.svg', 'name' => 'Terraform'],
    ['file' => 'jenkins.svg', 'name' => 'Jenkins'],
    ['file' => 'amazonwebservices.svg', 'name' => 'AWS'],
    ['file' => 'azure.svg', 'name' => 'Azure'],
    ['file' => 'linux.svg', 'name' => 'Linux'],
    ['file' => 'kalilinux.svg', 'name' => 'Kali Linux'],
    ['file' => 'git.svg', 'name' => 'Git'],
];

// Learning benefits — the "what you get" band (fills the reference
// membership/pricing slot with genuine value points, no invented prices)
$benefits = [
    'Live trainer-led classes',
    'Hands-on real projects',
    'Doubt clearing 1-on-1',
    'Interview preparation',
    'Resume & LinkedIn help',
    'Course completion certificate',
];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<script>window.TC_BASE_URL = '<?= SITE_URL ?>';</script>
<script>document.addEventListener('DOMContentLoaded', function () { var c = document.getElementById('enquiryCsrf'); if (c) c.value = '<?= e($csrf) ?>'; });</script>

<div class="tc-home-hero-wrapper">
  <section class="tc-hero2">
    <div class="tc-hero2__bg" aria-hidden="true">
      <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=1920&q=80" alt="" class="tc-hero2__bg-img">
    </div>
    <div class="tc-hero2__overlay" aria-hidden="true"></div>

    <div class="container tc-hero2__inner">
      <div class="row">
        <div class="col-lg-9 mx-auto text-center">
          <div class="tc-hero2__content">
            <span class="tc-hero2__sub">Best IT &amp; Software Training Institute</span>
            <h1 class="tc-hero2__title">Transform Your Career With Techno Coderz</h1>
            <p class="tc-hero2__text">Join Techno Coderz for hands-on Web Development, PHP, Java, Spring Boot, Full Stack, and Software Engineering courses. Learn from industry experts and get real-world live project experience with 100% placement assistance.</p>
            <div class="tc-hero2__actions">
              <a href="courses.php" class="tc-hero2__btn tc-hero2__btn--primary">Explore Courses <i class="bi bi-arrow-right"></i></a>
              <a href="contact.php" class="tc-hero2__btn tc-hero2__btn--outline">Get In Touch <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <style>
  /* ===== Hero (techcadd.com 1:1) — scoped to .tc-hero2 only ===== */
  .tc-hero2 { position: relative; overflow: hidden; color: #fff; background: #0a1a33; }
  .tc-hero2__bg { position: absolute; inset: 0; z-index: 0; overflow: hidden; }
  .tc-hero2__bg-img { width: 100%; height: 100%; object-fit: cover; display: block; transform-origin: center center; animation: tc-hero2-kenburns 20s ease-in-out infinite; will-change: transform; }
  .tc-hero2__overlay { position: absolute; inset: 0; z-index: 1; background: linear-gradient(rgba(2,6,23,0.85), rgba(2,6,23,0.7)); }
  @keyframes tc-hero2-kenburns {
    0%   { transform: scale(1.08) translate(0, 0); }
    50%  { transform: scale(1.2)  translate(-1.5%, -1.5%); }
    100% { transform: scale(1.08) translate(0, 0); }
  }
  @media (prefers-reduced-motion: reduce) { .tc-hero2__bg-img { animation: none; } }
  .tc-hero2__inner { position: relative; z-index: 2; }
  .tc-hero2__content { position: relative; z-index: 2; padding: 205px 0 201px; }
  @media (max-width: 1199.98px) { .tc-hero2__content { padding: 120px 0; } }
  @media (max-width: 991.98px) { .tc-hero2__content { max-width: 600px; } }

  .tc-hero2__sub {
    position: relative; display: block; margin: 0 0 20px;
    font-family: var(--tc-font-main); font-weight: 500; font-size: 30px;
    line-height: 1.3; letter-spacing: 0.02em; color: #fff;
  }
  @media (max-width: 767.98px) { .tc-hero2__sub { font-size: 20px; } }

  .tc-hero2__title {
    font-family: var(--tc-font-head); font-size: 84px; font-weight: 800;
    line-height: 1.1; letter-spacing: -0.02em; text-transform: capitalize;
    color: #fff; margin: 0 0 25px;
  }
  @media (max-width: 1500px) { .tc-hero2__title { font-size: 74px; } }
  @media (max-width: 1299.98px) { .tc-hero2__title { font-size: 68px; } }
  @media (max-width: 1199.98px) { .tc-hero2__title { font-size: 50px; } }
  @media (max-width: 991.98px) { .tc-hero2__title { font-size: 50px; } }
  @media (max-width: 767.98px) { .tc-hero2__title { font-size: 44px; line-height: 1.4; } }
  @media (max-width: 575.98px) { .tc-hero2__title { font-size: 35px; } }

  .tc-hero2__text {
    font-family: var(--tc-font-main); font-weight: 500; font-size: 20px;
    line-height: 1.5; color: #fff; max-width: 720px; margin: 0 auto 30px;
  }
  @media (max-width: 767.98px) { .tc-hero2__text { font-size: 16px; } }

  .tc-hero2__actions { display: inline-flex; flex-wrap: wrap; align-items: center; gap: 26px; }

  .tc-hero2__btn {
    display: inline-flex; align-items: center; justify-content: center; gap: 8px;
    padding: 15px 29.5px; border-radius: 10px;
    font-family: var(--tc-font-main); font-size: 16px; font-weight: 400;
    text-transform: capitalize; text-decoration: none; line-height: 1;
    border: 1px solid transparent; transition: all 0.3s ease-out;
  }
  .tc-hero2__btn i { font-size: 20px; transform: rotate(-45deg); transition: transform 0.4s ease; }
  .tc-hero2__btn:hover i { transform: rotate(0); }
  .tc-hero2__btn--primary { background: var(--primary); color: #fff; border-color: var(--primary); box-shadow: 0 10px 24px rgba(255,107,0,0.3); }
  .tc-hero2__btn--primary:hover { background: var(--primary-dark); color: #fff; border-color: var(--primary-dark); }
  .tc-hero2__btn--outline { background: transparent; color: #fff; border-color: #fff; }
  .tc-hero2__btn--outline:hover { background: #fff; color: var(--primary); }
  </style>
  <!-- ======================== FEATURES BAR (techcadd layout) ======================== -->
  <div class="tc-featurebar">
    <div class="row gx-0 justify-content-center">
      <div class="col-xl-4 col-lg-6">
        <div class="tc-featurebar__item">
          <div class="tc-featurebar__icon"><i class="bi bi-person-workspace"></i></div>
          <div class="tc-featurebar__body">
            <h3 class="tc-featurebar__title">Expert Industry Trainers</h3>
            <p class="tc-featurebar__text">Learn directly from experienced software engineers and full-stack developers. Get hands-on live coding sessions, code reviews, and personal mentorship.</p>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-lg-6">
        <div class="tc-featurebar__item">
          <div class="tc-featurebar__icon"><i class="bi bi-code-square"></i></div>
          <div class="tc-featurebar__body">
            <h3 class="tc-featurebar__title">Job-Oriented Live Projects</h3>
            <p class="tc-featurebar__text">Work on real-world web applications using PHP, MySQL, Spring Boot, and modern frontend frameworks to build an impressive portfolio for hiring.</p>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-lg-6">
        <div class="tc-featurebar__item">
          <div class="tc-featurebar__icon"><i class="bi bi-briefcase-fill"></i></div>
          <div class="tc-featurebar__body">
            <h3 class="tc-featurebar__title">100% Placement Support</h3>
            <p class="tc-featurebar__text">Comprehensive interview preparation, resume building, technical mock tests, and direct career placement assistance with top IT companies.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ======================== STYLING ======================== -->
<style>
/* Main Wrapper & Theme Variables */
.tc-home-hero-wrapper {
  position: relative;
  background-color: #FDFBF7;
  overflow: hidden;
  font-family: 'Inter', system-ui, -apple-system, sans-serif;
}

/* Hero Section */
.tc-home-hero {
  position: relative;
  padding: 100px 0 130px 0;
  background: linear-gradient(135deg, rgba(15, 23, 42, 0.92) 0%, rgba(30, 41, 59, 0.88) 100%), 
              url('https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
  color: #ffffff;
}

/* Techno Coderz Badge Styling */
.tc-home-hero__badge {
  display: inline-flex;
  align-items: center;
  font-size: 0.9rem;
  font-weight: 600;
  color: #ffffff;
  background: rgba(255, 255, 255, 0.1);
  padding: 8px 18px;
  border-radius: 50px;
  backdrop-filter: blur(8px);
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.tc-home-hero__dot {
  width: 8px;
  height: 8px;
  background-color: #FF6B00;
  border-radius: 50%;
  display: inline-block;
  margin-right: 8px;
  box-shadow: 0 0 10px #FF6B00;
}

.tc-home-hero__line {
  width: 22px;
  height: 2px;
  background-color: rgba(255, 255, 255, 0.4);
  display: inline-block;
  margin-right: 12px;
}

/* Headings & Text */
.tc-home-hero__title {
  font-size: 3.3rem;
  font-weight: 800;
  color: #ffffff;
  line-height: 1.2;
  margin-bottom: 22px;
  letter-spacing: -0.5px;
}

.tc-home-hero__sub {
  font-size: 1.05rem;
  color: #E2E8F0;
  max-width: 680px;
  line-height: 1.65;
  margin-bottom: 38px;
}

/* Buttons (Techno Coderz Accent Color #FF6B00) */
.tc-home-hero__actions {
  display: flex;
  gap: 16px;
  align-items: center;
}

.tc-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 13px 28px;
  font-size: 0.95rem;
  font-weight: 600;
  border-radius: 8px;
  text-decoration: none;
  transition: all 0.3s ease;
}

.tc-btn-primary {
  background-color: #FF6B00;
  color: #ffffff;
  border: 2px solid #FF6B00;
  box-shadow: 0 4px 15px rgba(255, 107, 0, 0.3);
}

.tc-btn-primary:hover {
  background-color: #e56000;
  border-color: #e56000;
  color: #ffffff;
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(255, 107, 0, 0.4);
}

.tc-btn-outline {
  background-color: transparent;
  color: #ffffff;
  border: 2px solid rgba(255, 255, 255, 0.35);
}

.tc-btn-outline:hover {
  background-color: #ffffff;
  color: #0F172A;
  border-color: #ffffff;
  transform: translateY(-2px);
}

/* Bottom Feature Cards Section */
.tc-features-bar {
  padding: 0 0 70px 0;
  margin-top: -50px;
  position: relative;
  z-index: 3;
}

.tc-feature-card {
  background: #ffffff;
  border: 1px solid #E2E8F0;
  border-radius: 12px;
  padding: 28px 24px;
  height: 100%;
  box-shadow: 0 10px 25px rgba(15, 23, 42, 0.05);
  display: flex;
  gap: 18px;
  align-items: flex-start;
  transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
}

.tc-feature-card:hover {
  transform: translateY(-5px);
  border-color: #FF6B00;
  box-shadow: 0 15px 30px rgba(255, 107, 0, 0.12);
}

.tc-feature-card__icon {
  width: 48px;
  height: 48px;
  min-width: 48px;
  background: rgba(255, 107, 0, 0.1);
  color: #FF6B00;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.35rem;
}

.tc-feature-card__title {
  font-size: 1.12rem;
  font-weight: 700;
  color: #1E293B;
  margin-bottom: 8px;
}

.tc-feature-card__desc {
  font-size: 0.88rem;
  color: #64748B;
  line-height: 1.55;
  margin-bottom: 0;
}
/* Features Bar (techcadd layout) */
.tc-featurebar {
  background: #F2F5FA;
}

.tc-featurebar__item {
  position: relative;
  display: flex;
  align-items: flex-start;
  padding: 35px 140px;
  transition: all 0.4s ease-in-out;
}

.tc-featurebar__icon {
  width: 64px;
  height: 64px;
  min-width: 64px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #ffffff;
  border-radius: 20px;
  margin-right: 20px;
  color: var(--tc-primary);
  font-size: 28px;
  transition: background-color 0.4s ease-in-out;
}

.tc-featurebar__icon i {
  transition: transform 0.4s ease-in-out;
}

.tc-featurebar__title {
  font-family: var(--tc-font-head);
  font-size: 24px;
  font-weight: 700;
  line-height: 1.2;
  color: var(--tc-heading);
  margin: 0 0 7px;
  transition: color 0.4s;
}

.tc-featurebar__text {
  font-family: var(--tc-font-main);
  font-weight: 400;
  font-size: 16px;
  line-height: 26px;
  color: var(--tc-text);
  margin: 0;
  transition: color 0.4s;
}

.tc-featurebar__item:hover {
  background-color: var(--tc-primary);
}

.tc-featurebar__item:hover .tc-featurebar__icon {
  background-color: #ffffff;
}

.tc-featurebar__item:hover .tc-featurebar__icon i {
  transform: rotateY(180deg);
}

.tc-featurebar__item:hover .tc-featurebar__title {
  color: #ffffff;
}

.tc-featurebar__item:hover .tc-featurebar__text {
  color: #ffffff;
}

@media (max-width: 1900px) {
  .tc-featurebar__item { padding: 40px 100px; }
}
@media (max-width: 1600px) {
  .tc-featurebar__item { padding: 40px 80px; }
}
@media (max-width: 1500px) {
  .tc-featurebar__item { padding: 40px; }
}
@media (max-width: 1299.98px) {
  .tc-featurebar__title { font-size: 20px; }
}
@media (max-width: 991.98px) {
  .tc-featurebar__item { padding: 32px; }
}
@media (max-width: 575.98px) {
  .tc-featurebar__item { padding: 20px; }
}

/* Mobile Adjustments */
@media (max-width: 768px) {
  .tc-home-hero {
    padding: 70px 0 100px 0;
  }
  .tc-home-hero__title {
    font-size: 2.2rem;
  }
  .tc-home-hero__actions {
    flex-direction: column;
    width: 100%;
  }
  .tc-btn {
    width: 100%;
    justify-content: center;
  }
  .tc-features-bar {
    margin-top: -30px;
  }
  @keyframes heroAnimation {
    0% { transform: scale(1) translate(0px, 0px); }
    50% { transform: scale(1.08) translate(-10px, -10px); }
    100% { transform: scale(1) translate(0px, 0px); }
  }
  .animate-hero-bg {
    animation: heroAnimation 15s infinite ease-in-out;
  }
}
</style>

<!-- ==================== 2 · EXPLORE OUR COURSES ==================== -->
<?php if (!empty($courses)): ?>
<section class="tc-section tc-home-courses py-5">
  <div class="container">
    <div class="tc-section-header text-center reveal mb-4">
      <span class="text-primary fw-semibold text-uppercase small tracking-wide">Our Courses</span>
      <h2 class="tc-section-title fw-bold mt-1">Career-Focused IT Training at <span>Techno Coderz</span></h2>
    </div>

    <!-- Category Filter Tabs -->
    <div class="tc-home-filters d-flex justify-content-center flex-wrap gap-2 mb-4 reveal">
      <a class="tc-chip active btn btn-primary btn-sm rounded-pill px-3 fw-semibold" href="<?= SITE_URL ?>/courses.php">All Courses</a>
      <?php foreach ($categoryTiles as $catSlug => $catTile): ?>
      <a class="tc-chip btn btn-outline-primary btn-sm rounded-pill px-3" href="<?= SITE_URL ?>/courses.php?cat=<?= urlencode($catSlug) ?>"><?= e($catTile['name']) ?></a>
      <?php endforeach; ?>
    </div>

    <!-- Course Cards Grid -->
    <div class="row g-4 justify-content-center">
      <?php $shown = 0; foreach ($courses as $i => $course):
          if ($shown >= 4) break;
          $shown++;
          $img = $course['image'] ?? '';
      ?>
      <div class="col-6 col-md-3 reveal" style="transition-delay:<?= ($shown * 0.08) ?>s">
        <div class="tc-cat-card">
          <a href="<?= e(coursePageUrl($course['slug'])) ?>" class="tc-cat-img">
            <?php if ($img && file_exists(UPLOAD_DIR . 'courses/' . $img)): ?>
              <img src="<?= UPLOAD_URL ?>courses/<?= e($img) ?>" alt="<?= e($course['title']) ?>" loading="lazy">
            <?php else: ?>
              <span class="tc-cat-icon"><i class="<?= e($course['icon'] ?? 'bi bi-laptop') ?>"></i></span>
            <?php endif; ?>
          </a>
          <h3 class="tc-cat-title">
            <a href="<?= e(coursePageUrl($course['slug'])) ?>"><?= e($course['title']) ?></a>
          </h3>
          <p class="tc-cat-text"><?= e($course['short_description'] ?? '') ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <style>
  .tc-home-courses .tc-cat-card { text-align: center; }
  .tc-home-courses .tc-cat-img { display: block; border-radius: 24px; margin-bottom: 22px; overflow: hidden; background: #eef2f7; aspect-ratio: 4 / 3; }
  .tc-home-courses .tc-cat-img img { width: 100%; height: 100%; object-fit: cover; display: block; border-radius: 24px; transition: transform 1.3s ease; }
  .tc-home-courses .tc-cat-card:hover .tc-cat-img img { transform: scale(1.3); }
  .tc-home-courses .tc-cat-icon { display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; font-size: 3rem; color: var(--primary); }
  .tc-home-courses .tc-cat-title { font-size: 1.15rem; font-weight: 700; margin: 0 0 5px; line-height: 1.35; }
  .tc-home-courses .tc-cat-title a { color: var(--tc-heading); text-decoration: none; transition: color .25s ease; }
  .tc-home-courses .tc-cat-title a:hover { color: var(--primary); }
  .tc-home-courses .tc-cat-text { color: var(--tc-text); font-size: .92rem; margin: 0; }
  </style>
</section>
<?php endif; ?>

<!-- ==================== 3 · TECHNOLOGIES WE MASTER (techcadd layout) ==================== -->
<section class="tcs-section">
  <div class="tcs-container">
    <div class="tcs-header">
      <h2 class="tcs-title">Technologies We Master</h2>
      <p class="tcs-subtitle">
        From <strong>AI</strong> to <strong>Cloud</strong>, from <strong>Web Development</strong> to <strong>DevOps</strong> —
        we train you on the latest and most in-demand technologies to build a successful career.
      </p>
    </div>

    <?php
    $tcsCats = [
        'programming' => ['icon' => '💻', 'label' => 'Programming', 'items' => [
            ['python.svg', 'Python', 'Language'], ['javascript.svg', 'JavaScript', 'Web'], ['typescript.svg', 'TypeScript', 'Web'],
        ]],
        'frameworks' => ['icon' => '⚡', 'label' => 'Frameworks', 'items' => [
            ['react.svg', 'React', 'Frontend'], ['angularjs.svg', 'Angular', 'Frontend'], ['nodejs.svg', 'Node.js', 'Backend'], ['express.svg', 'Express', 'Backend'],
        ]],
        'ai' => ['icon' => '🤖', 'label' => 'AI &amp; ML', 'items' => [
            ['tensorflow.svg', 'TensorFlow', 'ML'], ['scikitlearn.svg', 'scikit-learn', 'ML'], ['numpy.svg', 'NumPy', 'Data'], ['jupyter.svg', 'Jupyter', 'Notebook'],
        ]],
        'databases' => ['icon' => '🗄️', 'label' => 'Databases', 'items' => [
            ['mysql.svg', 'MySQL', 'RDBMS'], ['postgresql.svg', 'PostgreSQL', 'RDBMS'], ['mongodb.svg', 'MongoDB', 'NoSQL'],
        ]],
        'devops' => ['icon' => '🔧', 'label' => 'DevOps', 'items' => [
            ['docker.svg', 'Docker', 'Containers'], ['kubernetes.svg', 'Kubernetes', 'Orchestration'], ['terraform.svg', 'Terraform', 'IaC'], ['jenkins.svg', 'Jenkins', 'CI/CD'], ['git.svg', 'Git', 'VCS'],
        ]],
        'cloud' => ['icon' => '☁️', 'label' => 'Cloud', 'items' => [
            ['amazonwebservices.svg', 'AWS', 'Cloud'], ['azure.svg', 'Azure', 'Cloud'],
        ]],
        'os' => ['icon' => '🐧', 'label' => 'OS &amp; Tools', 'items' => [
            ['linux.svg', 'Linux', 'OS'], ['kalilinux.svg', 'Kali Linux', 'Security'],
        ]],
    ];
    $tcsActive = [];
    foreach ($tcsCats as $slug => $cat) {
        $ok = array_values(array_filter($cat['items'], function ($it) {
            return is_file(__DIR__ . '/assets/images/tech/' . $it[0]);
        }));
        if ($ok) { $cat['items'] = $ok; $tcsActive[$slug] = $cat; }
    }
    ?>
    <?php if ($tcsActive): ?>
    <div class="tcs-nav">
      <div class="tcs-nav-wrap">
        <?php $first = true; foreach ($tcsActive as $slug => $cat): ?>
        <button type="button" class="tcs-tab<?= $first ? ' active' : '' ?>" data-cat="<?= e($slug) ?>">
          <span class="tcs-tab-icon"><?= $cat['icon'] ?></span><?= $cat['label'] ?>
        </button>
        <?php $first = false; endforeach; ?>
      </div>
    </div>

    <div class="tcs-showcase">
      <?php $first = true; foreach ($tcsActive as $slug => $cat):
          $base = $cat['items']; $filled = [];
          while (count($filled) < 8) { $filled = array_merge($filled, $base); }
      ?>
      <div class="tcs-marquee<?= $first ? ' active' : '' ?>" data-cat="<?= e($slug) ?>">
        <div class="tcs-track">
          <?php foreach ($filled as $it): ?>
          <div class="tcs-card">
            <div class="tcs-icon"><img src="<?= SITE_URL ?>/assets/images/tech/<?= e($it[0]) ?>" alt="<?= e($it[1]) ?>" loading="lazy" decoding="async"></div>
            <div class="tcs-info">
              <span class="tcs-name"><?= e($it[1]) ?></span>
              <span class="tcs-type"><?= e($it[2]) ?></span>
            </div>
          </div>
          <?php endforeach; ?>
          <?php foreach ($filled as $it): ?>
          <div class="tcs-card" aria-hidden="true">
            <div class="tcs-icon"><img src="<?= SITE_URL ?>/assets/images/tech/<?= e($it[0]) ?>" alt="" loading="lazy" decoding="async"></div>
            <div class="tcs-info">
              <span class="tcs-name"><?= e($it[1]) ?></span>
              <span class="tcs-type"><?= e($it[2]) ?></span>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php $first = false; endforeach; ?>
    </div>
    <?php endif; ?>
  </div>

  <style>
  .tcs-section { position: relative; padding: 100px 0; background: linear-gradient(135deg, #0f1629 0%, #1e3a8a 50%, #1e40af 100%); overflow: hidden; }
  .tcs-section::before { content: ""; position: absolute; inset: 0; background: radial-gradient(circle at 20% 20%, rgba(59,130,246,.3) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(96,165,250,.2) 0%, transparent 50%), radial-gradient(circle at 40% 40%, rgba(147,197,253,.1) 0%, transparent 50%); pointer-events: none; }
  .tcs-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; position: relative; z-index: 2; }
  .tcs-header { text-align: center; margin-bottom: 60px; }
  .tcs-title { font-size: clamp(2.5rem,5vw,4rem); font-weight: 800; background: linear-gradient(135deg,#fff 0%,#93c5fd 100%); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; margin: 0 0 20px; line-height: 1.2; }
  .tcs-subtitle { font-size: 1.2rem; color: rgba(255,255,255,.7); max-width: 640px; margin: 0 auto; line-height: 1.6; }
  .tcs-nav { display: flex; justify-content: center; margin-bottom: 50px; }
  .tcs-nav-wrap { display: flex; gap: 8px; background: rgba(59,130,246,.1); -webkit-backdrop-filter: blur(20px); backdrop-filter: blur(20px); border: 1px solid rgba(59,130,246,.2); border-radius: 20px; padding: 8px; flex-wrap: wrap; justify-content: center; }
  .tcs-tab { position: relative; display: flex; align-items: center; gap: 8px; padding: 12px 20px; border-radius: 16px; cursor: pointer; transition: all .4s cubic-bezier(.4,0,.2,1); background: transparent; color: rgba(255,255,255,.6); font-weight: 600; font-size: 14px; border: none; outline: none; }
  .tcs-tab:hover { color: #fff; transform: translateY(-2px); }
  .tcs-tab.active { background: linear-gradient(135deg,#2563eb 0%,#1d4ed8 100%); color: #fff; box-shadow: 0 8px 32px rgba(37,99,235,.4); transform: translateY(-2px); }
  .tcs-tab-icon { font-size: 18px; }
  .tcs-showcase { position: relative; background: rgba(59,130,246,.05); -webkit-backdrop-filter: blur(20px); backdrop-filter: blur(20px); border: 1px solid rgba(59,130,246,.2); border-radius: 24px; padding: 40px 0; overflow: hidden; }
  .tcs-marquee { display: none; position: relative; z-index: 2; }
  .tcs-marquee.active { display: block; }
  .tcs-track { display: flex; gap: 40px; align-items: center; width: max-content; padding: 0 20px; animation: tcsMarquee 40s linear infinite; }
  .tcs-track:hover { animation-play-state: paused; }
  @keyframes tcsMarquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
  .tcs-card { position: relative; display: flex; flex-direction: column; align-items: center; min-width: 160px; padding: 24px 16px; background: rgba(59,130,246,.08); -webkit-backdrop-filter: blur(20px); backdrop-filter: blur(20px); border: 1px solid rgba(59,130,246,.2); border-radius: 20px; transition: all .4s cubic-bezier(.4,0,.2,1); overflow: hidden; }
  .tcs-card:hover { transform: translateY(-8px) scale(1.05); border-color: rgba(59,130,246,.4); box-shadow: 0 20px 60px rgba(37,99,235,.3); background: rgba(59,130,246,.12); }
  .tcs-icon { width: 64px; height: 64px; margin-bottom: 16px; position: relative; z-index: 2; }
  .tcs-icon img { width: 100%; height: 100%; object-fit: contain; filter: drop-shadow(0 4px 20px rgba(59,130,246,.2)); transition: filter .4s ease; }
  .tcs-card:hover .tcs-icon img { filter: drop-shadow(0 8px 30px rgba(59,130,246,.4)); }
  .tcs-info { text-align: center; position: relative; z-index: 2; }
  .tcs-name { display: block; font-size: 16px; font-weight: 700; color: #fff; margin-bottom: 4px; letter-spacing: .5px; }
  .tcs-type { display: block; font-size: 12px; font-weight: 500; color: rgba(255,255,255,.6); text-transform: uppercase; letter-spacing: 1px; }
  @media (max-width: 768px) {
    .tcs-section { padding: 60px 0; }
    .tcs-nav-wrap { gap: 4px; padding: 4px; }
    .tcs-tab { padding: 8px 12px; font-size: 12px; }
    .tcs-tab-icon { font-size: 14px; }
    .tcs-track { gap: 20px; }
    .tcs-card { min-width: 120px; padding: 16px 12px; }
    .tcs-icon { width: 48px; height: 48px; }
    .tcs-name { font-size: 14px; }
  }
  </style>
  <script>
  (function () {
    var tabs = document.querySelectorAll('.tcs-tab');
    var marquees = document.querySelectorAll('.tcs-marquee');
    tabs.forEach(function (tab) {
      function activate() {
        tabs.forEach(function (t) { t.classList.remove('active'); });
        marquees.forEach(function (m) { m.classList.remove('active'); });
        tab.classList.add('active');
        var target = document.querySelector('.tcs-marquee[data-cat="' + tab.dataset.cat + '"]');
        if (target) target.classList.add('active');
      }
      tab.addEventListener('mouseenter', activate);
      tab.addEventListener('click', activate);
    });
  })();
  </script>
</section>
<!-- ==================== ABOUT TECHNO CODERZ (techcadd 1:1) ==================== -->
<section class="tca-about">
  <div class="container">
    <div class="row align-items-center">

      <!-- Left Column: Image -->
      <div class="col-xl-6">
        <div class="tca-img-box reveal">
          <img src="<?= SITE_URL ?>/assets/images/institute/success-1.jpg" alt="Techno Coderz students building projects in a live coding session" class="img-fluid" loading="lazy">
        </div>
      </div>

      <!-- Right Column: Content -->
      <div class="col-xl-6">
        <div class="tca-content">
          <div class="tca-title-box reveal">
            <span class="tca-sub-title">About Techno Coderz</span>
            <h2 class="tca-sec-title">Best IT Training Institute for Career Growth</h2>
            <p class="tca-sec-text">
              <strong>Techno Coderz</strong> is a premier IT training and web development academy dedicated to bridging the gap between academia and industry requirements. We offer hands-on, project-based training in <strong>PHP Development, Full-Stack Web Technologies, Java, MySQL, and Software Engineering</strong>. Our goal is to empower learners with practical coding expertise and build job-ready tech professionals.
            </p>
          </div>

          <!-- Highlights -->
          <div class="tca-item-wrap">
            <div class="tca-item reveal">
              <div class="tca-item-img"><i class="bi bi-code-square"></i></div>
              <div class="tca-item-content">
                <h5 class="tca-box-title">Practical &amp; Project-Based Learning</h5>
                <p class="tca-item-text">Master <strong>PHP, JavaScript, Spring Boot, MySQL, Bootstrap, and Tailwind CSS</strong> through live web development projects and real code deployment.</p>
              </div>
            </div>

            <div class="tca-item reveal">
              <div class="tca-item-img"><i class="bi bi-person-check-fill"></i></div>
              <div class="tca-item-content">
                <h5 class="tca-box-title">100% Career &amp; Placement Support</h5>
                <p class="tca-item-text">We guide students with professional internships, industry-recognized certificates, resume building, and placement assistance for top IT roles.</p>
              </div>
            </div>
          </div>

          <div class="tca-btn-wrap reveal">
            <a href="<?= SITE_URL ?>/about.php" class="tca-btn">Learn More <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </div>

    </div>
  </div>
  <style>
  .tca-about { position: relative; overflow: hidden; padding: 50px 0 100px; background: #fff; }
  .tca-about .tca-img-box { margin-bottom: 20px; }
  .tca-about .tca-img-box img { width: 100%; border-radius: 20px; box-shadow: 0 1rem 2rem rgba(11,20,34,.12); }
  .tca-about .tca-content { padding-left: 30px; }
  @media (max-width: 1199px) {
    .tca-about .tca-content { padding-left: 0; margin-top: 40px; }
    .tca-about .tca-img-box { margin-bottom: 50px; }
  }
  .tca-about .tca-sub-title { display: block; font-weight: 500; font-size: 20px; letter-spacing: .02em; color: var(--primary); margin-top: -.2em; margin-bottom: 5px; }
  .tca-about .tca-sec-title { font-size: 48px; line-height: 1.327; font-weight: 700; color: var(--tc-heading); margin: 0 0 22px; }
  @media (max-width: 1199px) { .tca-about .tca-sec-title { font-size: 36px; line-height: 1.3; } }
  @media (max-width: 767px) { .tca-about .tca-sec-title { font-size: 34px; line-height: 1.3; } }
  .tca-about .tca-sec-text { font-size: 16px; line-height: 26px; color: var(--tc-text); margin: 0 0 30px; }
  .tca-about .tca-item { display: flex; gap: 16px; max-width: 420px; }
  .tca-about .tca-item:not(:last-child) { margin-bottom: 30px; }
  .tca-about .tca-item-img { min-width: 72px; height: 72px; border-radius: 20px; background: var(--primary); color: #fff; font-size: 30px; display: flex; align-items: center; justify-content: center; transition: all .4s ease-in-out; }
  .tca-about .tca-item-img i { transition: all .4s ease-in-out; }
  .tca-about .tca-item:hover .tca-item-img { background: var(--tc-heading); }
  .tca-about .tca-item:hover .tca-item-img i { transform: rotateY(180deg); }
  .tca-about .tca-box-title { font-size: 24px; line-height: 1.4; font-weight: 500; color: var(--tc-heading); margin: 0 0 7px; }
  .tca-about .tca-item-text { font-size: 16px; line-height: 26px; color: var(--tc-text); margin: 0 0 -.3rem; }
  .tca-about .tca-btn-wrap { margin-top: 35px; }
  .tca-about .tca-btn { position: relative; z-index: 1; overflow: hidden; display: inline-flex; align-items: center; justify-content: center; gap: 8px; background: var(--primary); color: #fff; font-size: 16px; font-weight: 400; padding: 19px 40px; border-radius: 10px; text-decoration: none; transition: all .3s ease-out; }
  .tca-about .tca-btn::before { content: ''; position: absolute; top: 0; left: -5%; width: 0; height: 100%; border-radius: 10px; background: var(--tc-heading); z-index: -1; transition: .5s ease; }
  .tca-about .tca-btn:hover { color: #fff; }
  .tca-about .tca-btn:hover::before { width: 110%; }
  .tca-about .tca-btn i { font-size: 20px; transform: rotate(-45deg); transition: .4s; }
  .tca-about .tca-btn:hover i { transform: rotate(0deg); }
  </style>
</section>

<!-- ==================== OUR POPULAR COURSES (techcadd 1:1) ==================== -->
<section class="tcc-courses">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-12">
        <div class="tcc-title-box">
          <span class="tcc-sub-title">Our Popular Courses</span>
          <h2 class="tcc-sec-title">Techno Coderz: Career-Ready IT Courses</h2>
          <p class="tcc-sec-text">Explore our industry-focused IT courses designed to equip you with practical skills, certifications, and hands-on experience for a successful tech career.</p>
        </div>
      </div>
    </div>

    <!-- Category Tabs -->
    <div class="tcc-tabs">
      <a href="<?= SITE_URL ?>/courses.php?cat=programming" class="tcc-tab active">Programming &amp; Development</a>
      <a href="<?= SITE_URL ?>/courses.php?cat=web-uiux" class="tcc-tab">Web &amp; UI/UX</a>
      <a href="<?= SITE_URL ?>/courses.php?cat=digital-marketing" class="tcc-tab">Digital Marketing</a>
      <a href="<?= SITE_URL ?>/courses.php?cat=ai" class="tcc-tab">Artificial Intelligence</a>
      <a href="<?= SITE_URL ?>/courses.php?cat=cybersecurity" class="tcc-tab">Cybersecurity</a>
      <a href="<?= SITE_URL ?>/courses.php?cat=cloud-devops" class="tcc-tab">Cloud &amp; DevOps</a>
      <a href="<?= SITE_URL ?>/courses.php?cat=cad-cam" class="tcc-tab">CAD / CAM</a>
    </div>

    <!-- Big coding showcase image -->
    <div class="tcc-bigimage reveal">
      <img src="<?= SITE_URL ?>/assets/images/courses-coding.jpg" alt="Techno Coderz students learning coding" loading="lazy">
    </div>
  </div>
  <style>
  .tcc-courses { position: relative; overflow: hidden; padding: 120px 0; background: #fff; }
  @media (max-width: 991px) { .tcc-courses { padding: 80px 0; } }
  .tcc-courses .tcc-title-box { text-align: center; margin-bottom: 0; }
  .tcc-courses .tcc-sub-title { display: block; font-weight: 500; font-size: 20px; letter-spacing: .02em; color: var(--primary); margin: -.2em 0 5px; }
  .tcc-courses .tcc-sec-title { font-size: 48px; line-height: 1.327; font-weight: 700; color: var(--tc-heading); margin: 0 0 22px; }
  @media (max-width: 1199px) { .tcc-courses .tcc-sec-title { font-size: 36px; line-height: 1.3; } }
  @media (max-width: 767px) { .tcc-courses .tcc-sec-title { font-size: 34px; line-height: 1.3; } }
  .tcc-courses .tcc-sec-text { font-size: 16px; line-height: 26px; color: var(--tc-text); margin: 0 auto; max-width: 776px; }

  .tcc-tabs { display: flex; justify-content: center; flex-wrap: wrap; gap: 21px; margin-top: 50px; margin-bottom: 40px; }
  @media (max-width: 1500px) { .tcc-tabs { gap: 10px; } }
  @media (max-width: 1199px) { .tcc-tabs { margin-top: 0; margin-bottom: 40px; } }
  .tcc-tabs .tcc-tab { display: inline-flex; align-items: center; justify-content: center; font-size: 14px; line-height: 1.5; font-weight: 500; padding: 6px 24px; border-radius: 10px; color: #0B1422; background-color: #EEF1FF; text-decoration: none; transition: all .3s ease-out; }
  @media (max-width: 1299px) { .tcc-tabs .tcc-tab { padding: 6px 12px; } }
  .tcc-tabs .tcc-tab:hover, .tcc-tabs .tcc-tab.active { color: #fff; background: var(--primary); }

  .tcc-box { position: relative; border-radius: 24px; overflow: hidden; }
  .tcc-box .tcc-img { position: relative; overflow: hidden; border-radius: 24px; aspect-ratio: 4 / 5; }
  .tcc-box .tcc-img img { width: 100%; height: 100%; object-fit: cover; border-radius: 24px; transition: .4s ease-in-out; display: block; }
  .tcc-box:hover .tcc-img img { transform: scale(1.08); }
  .tcc-box .tcc-img::before { content: ''; position: absolute; inset: 0; border-radius: 24px; background: linear-gradient(180deg, rgba(11,20,34,0) 45%, rgba(11,20,34,.82) 100%); z-index: 1; transition: .4s; }
  .tcc-box .tcc-content { position: absolute; left: 0; right: 0; bottom: 40px; padding: 0 40px; z-index: 2; }
  @media (max-width: 991px) { .tcc-box .tcc-content { bottom: 20px; padding: 0 20px; } }
  .tcc-box .tcc-box-title { font-size: 24px; line-height: 1.417; font-weight: 600; margin-bottom: 0; color: #fff; }
  .tcc-box .tcc-box-title a { color: #fff; text-decoration: none; }
  .tcc-box .tcc-box-title a:hover { color: var(--primary); }
  .tcc-box .tcc-subtitle { font-size: 16px; color: var(--white-color, #fff); opacity: .85; }

  .tcc-bigimage { margin-top: 10px; border-radius: 30px; overflow: hidden; box-shadow: 0 30px 60px rgba(2,6,23,.12); }
  .tcc-bigimage img { width: 100%; display: block; aspect-ratio: 16 / 9; object-fit: cover; border-radius: 30px; transition: transform .6s ease; }
  .tcc-bigimage:hover img { transform: scale(1.03); }
  @media (max-width: 767px) { .tcc-bigimage { margin-top: 5px; } .tcc-bigimage img { aspect-ratio: 4 / 3; } }
  </style>
</section>
<!-- ==================== 1. OUR SEMINARS (techcadd 1:1) ==================== -->
<section class="tcsem-area">
  <div class="container">
    <div class="row">
      <div class="col-xl-12">
        <div class="tcsem-title-box">
          <span class="tcsem-sub-title">Our Seminars</span>
          <h2 class="tcsem-sec-title">Past Seminars &amp; Workshops at Leading Colleges</h2>
        </div>
      </div>
    </div>

    <div class="row g-4 justify-content-center">
      <?php
      $seminars = [
        ['title' => 'Workshop on Full-Stack Web Development', 'place' => '@ Leading Technical Universities', 'text' => 'Hands-on PHP, MySQL and responsive web development with live projects.', 'img' => 'success-1.jpg'],
      ];
      foreach ($seminars as $s):
      ?>
      <div class="col-lg-4 col-md-6 reveal">
        <div class="tcsem-card">
          <div class="tcsem-img">
            <a href="#"><img src="<?= SITE_URL ?>/assets/images/institute/<?= e($s['img']) ?>" alt="<?= e($s['title']) ?>" loading="lazy"></a>
          </div>
          <div class="tcsem-content">
            <h3 class="tcsem-box-title">
              <a href="#"><?= e($s['title']) ?> <br><small><?= e($s['place']) ?></small></a>
            </h3>
            <p class="tcsem-text"><?= e($s['text']) ?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <style>
  .tcsem-area { padding: 120px 0; background: #fff; }
  @media (max-width: 991px) { .tcsem-area { padding: 80px 0; } }
  .tcsem-area .tcsem-title-box { text-align: center; margin-bottom: 0; }
  .tcsem-area .tcsem-sub-title { display: block; font-weight: 500; font-size: 20px; letter-spacing: .02em; color: var(--primary); margin: -.2em 0 5px; }
  .tcsem-area .tcsem-sec-title { font-size: 48px; line-height: 1.327; font-weight: 700; color: var(--tc-heading); margin: 0 0 40px; }
  @media (max-width: 1199px) { .tcsem-area .tcsem-sec-title { font-size: 36px; line-height: 1.3; } }
  @media (max-width: 767px) { .tcsem-area .tcsem-sec-title { font-size: 34px; line-height: 1.3; } }

  .tcsem-card { padding: 20px; background: #fff; border: 1px solid #E1E4E5; border-radius: 30px; height: 100%; transition: all 500ms ease; }
  .tcsem-card:hover { transform: translate(0, -15px); }
  .tcsem-card .tcsem-img { border-radius: 20px; overflow: hidden; }
  .tcsem-card .tcsem-img a { display: block; }
  .tcsem-card .tcsem-img img { width: 100%; display: block; aspect-ratio: 4 / 3; object-fit: cover; border-radius: 20px; transition: 1.3s all ease; }
  .tcsem-card:hover .tcsem-img img { transform: scale(1.2); }
  .tcsem-card .tcsem-content { padding: 30px 10px 10px; text-align: left; }
  .tcsem-card .tcsem-box-title { font-size: 24px; line-height: 1.4; font-weight: 600; color: var(--tc-heading); margin: 0 0 8px; }
  @media (max-width: 1399px) { .tcsem-card .tcsem-box-title { font-size: 20px; } }
  .tcsem-card .tcsem-box-title a { color: var(--tc-heading); text-decoration: none; }
  .tcsem-card .tcsem-box-title a:hover { color: var(--primary); }
  .tcsem-card .tcsem-box-title small { display: inline-block; margin-top: 4px; font-size: .8em; font-weight: 500; color: var(--primary); }
  .tcsem-card .tcsem-text { font-size: 16px; line-height: 1.6; color: var(--tc-text); margin: 0; }
  </style>
</section>

<!-- ==================== 2. GALLERY GRID SECTION (techcadd 1:1) ==================== -->
<section class="tcg-area">
  <div class="container">
    <div class="tcg-title-box">
      <span class="tcg-sub-title">Our Gallery</span>
      <h2 class="tcg-sec-title">Techno Coderz: Student Success &amp; Training Gallery</h2>
      <p class="tcg-sec-text">
        Explore our latest student projects, classroom activities, and hands-on training sessions at Techno Coderz. See how we empower learners with real-world IT skills and industry exposure.
      </p>
    </div>

    <?php
    // techcadd gallery rhythm: single | double (stacked) | tall single | double (stacked)
    // techcadd gallery rhythm: 5 columns — single | double | tall single | double | single (7 images)
    $tcgColumns = [
        ['class' => 'tcg-col--single', 'items' => [
            ['img' => 'institute/success-1.jpg',  'alt' => 'Techno Coderz students building projects in a live coding session'],
        ]],
        ['class' => 'tcg-col--double', 'items' => [
            ['img' => 'institute/success-2.jpg',  'alt' => 'Hands-on mentorship at Techno Coderz'],
            ['img' => 'institute/success-3.jpg', 'alt' => 'A Techno Coderz classroom training session'],
        ]],
        ['class' => 'tcg-col--tall', 'items' => [
            ['img' => 'institute/success-4.jpeg', 'alt' => 'Techno Coderz learners collaborating on a project'],
        ]],
        ['class' => 'tcg-col--double', 'items' => [
            ['img' => 'institute/success-5.jpeg', 'alt' => 'Techno Coderz group discussion and practical lab'],
            ['img' => 'institute/success-6.jpeg', 'alt' => 'Techno Coderz placement and career session'],
        ]],
        ['class' => 'tcg-col--single2', 'items' => [
            ['img' => 'gallery/gallery-7.jpg', 'alt' => 'Techno Coderz hands-on training session'],
        ]],
    ];
    ?>
    <div class="row tcg-row justify-content-center align-items-center">
      <?php foreach ($tcgColumns as $col): ?>
      <div class="col-6 col-lg-2 tcg-col <?= e($col['class']) ?> reveal">
        <?php foreach ($col['items'] as $item): ?>
        <div class="tcg-card">
          <div class="tcg-img">
            <a href="<?= SITE_URL ?>/assets/images/<?= e($item['img']) ?>" class="tcg-popup">
              <span class="tcg-icon-btn"><i class="bi bi-zoom-in"></i></span>
              <img src="<?= SITE_URL ?>/assets/images/<?= e($item['img']) ?>" alt="<?= e($item['alt']) ?>" loading="lazy" decoding="async">
            </a>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="tcg-lightbox" id="tcgLightbox" aria-hidden="true">
    <button type="button" class="tcg-lightbox-close" aria-label="Close gallery">&times;</button>
    <img src="" alt="Techno Coderz gallery preview">
  </div>

  <style>
  .tcg-area { padding: 120px 0; background: #fff; position: relative; }
  @media (max-width: 991px) { .tcg-area { padding: 80px 0; } }

  .tcg-title-box { text-align: center; margin-bottom: 50px; position: relative; z-index: 2; }
  .tcg-sub-title { display: block; font-weight: 500; font-size: 20px; letter-spacing: .02em; color: var(--primary); margin: -.2em 0 5px; }
  .tcg-sec-title { font-size: 48px; line-height: 1.327; font-weight: 700; color: var(--tc-heading); margin: 0 0 12px; }
  @media (max-width: 1199px) { .tcg-sec-title { font-size: 36px; line-height: 1.3; } }
  @media (max-width: 767px) { .tcg-sec-title { font-size: 34px; line-height: 1.3; } }
  .tcg-sec-text { font-size: 16px; line-height: 26px; color: var(--tc-text); max-width: 720px; margin: 0 auto; }

  .tcg-row { --bs-gutter-x: 17px; --bs-gutter-y: 10px; }

  .tcg-card { border-radius: 24px; }
  .tcg-card:nth-child(2) { margin-top: 17px; }

  .tcg-img { position: relative; overflow: hidden; border-radius: 24px; -webkit-transition: all .5s ease-out; transition: all .5s ease-out; }
  .tcg-img > a { display: block; position: relative; }
  .tcg-img img { display: block; width: 100%; height: auto; object-fit: cover; border-radius: 24px; -webkit-transition: 1.3s all ease; transition: 1.3s all ease; }

  .tcg-col--single .tcg-img img { aspect-ratio: 750 / 702; }
  .tcg-col--single2 .tcg-img img { aspect-ratio: 750 / 579; }
  .tcg-col--tall .tcg-img img { aspect-ratio: 729 / 1178; }
  .tcg-col--double .tcg-img img { aspect-ratio: 750 / 579; }

  .tcg-img::after { content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 0; background: rgba(255,255,255,.5); opacity: 1; pointer-events: none; z-index: 9; }
  .tcg-img:hover::after { height: 100%; opacity: 0; -webkit-transition: all .4s linear; transition: all .4s linear; }
  .tcg-img:hover img { -webkit-transform: scale(1.3); transform: scale(1.3); }

  .tcg-icon-btn { position: absolute; top: 50%; left: 50%; z-index: 10; color: #fff; font-size: 40px; line-height: 1; -webkit-transform: translate(-50%,-50%) scale(0); transform: translate(-50%,-50%) scale(0); -webkit-transition: .4s ease-in-out; transition: .4s ease-in-out; text-shadow: 0 2px 14px rgba(0,0,0,.45); }
  .tcg-card:hover .tcg-icon-btn { -webkit-transform: translate(-50%,-50%) scale(1); transform: translate(-50%,-50%) scale(1); }

  .tcg-lightbox { position: fixed; inset: 0; z-index: 2000; display: none; align-items: center; justify-content: center; padding: 24px; background: rgba(15,23,42,.9); }
  .tcg-lightbox.open { display: flex; }
  .tcg-lightbox img { max-width: 92vw; max-height: 88vh; border-radius: 12px; box-shadow: 0 24px 60px rgba(0,0,0,.5); }
  .tcg-lightbox-close { position: absolute; top: 18px; right: 26px; background: transparent; border: 0; color: #fff; font-size: 42px; line-height: 1; cursor: pointer; }
  </style>

  <script>
  (function () {
    var lb = document.getElementById('tcgLightbox');
    if (!lb) return;
    var lbImg = lb.querySelector('img');
    var closeBtn = lb.querySelector('.tcg-lightbox-close');
    function close() {
      lb.classList.remove('open');
      lb.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
    }
    document.querySelectorAll('.tcg-popup').forEach(function (a) {
      a.addEventListener('click', function (e) {
        e.preventDefault();
        lbImg.src = a.getAttribute('href');
        lb.classList.add('open');
        lb.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
      });
    });
    closeBtn.addEventListener('click', close);
    lb.addEventListener('click', function (e) { if (e.target === lb) close(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && lb.classList.contains('open')) close(); });
  })();
  </script>
</section>

<!-- ==================== 3. STATS / COUNTERS (techcadd 1:1) ==================== -->
<section class="tstat-area">
  <div class="container">
    <div class="tstat-wrap">
      <div class="row">
        <?php
        // techcadd counter rhythm: staggered circular counters
        $tstatItems = [
            ['value' => 15,  'suffix' => '+', 'label' => 'Years of Excellence'],
            ['value' => 10,  'suffix' => 'k+', 'label' => 'Students Trained'],
            ['value' => 100, 'suffix' => '+', 'label' => 'Industry Courses'],
            ['value' => 100, 'suffix' => '%', 'label' => 'Placement Support'],
        ];
        foreach ($tstatItems as $stat):
        ?>
        <div class="col-6 col-xl-3 tstat-card-wrap">
          <div class="tstat-card">
            <div class="tstat-shape"><span></span></div>
            <div class="tstat-body">
              <h3 class="tstat-number"><span class="tstat-counter" data-target="<?= (int) $stat['value'] ?>">0</span><?= e($stat['suffix']) ?></h3>
              <h6 class="tstat-title"><?= e($stat['label']) ?></h6>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <style>
  .tstat-area { padding: 120px 0; background: #fff; overflow: hidden; }
  @media (max-width: 991px) { .tstat-area { padding: 80px 0; } }

  .tstat-wrap { position: relative; }
  .tstat-card-wrap { margin: 50px 0 25px; }
  @media (max-width: 1199px) { .tstat-card-wrap { margin: 0; } }

  .tstat-card { position: relative; background: var(--bg-light); padding: 93px 28px; width: 264px; height: 264px; display: block; margin: auto; text-align: center; border-radius: 50%; z-index: 2; margin-top: 158px; }
  @media (max-width: 1199px) { .tstat-card { margin-top: 100px; } }
  @media (max-width: 767px) { .tstat-card { width: 250px; height: 250px; padding: 81px 28px; margin-top: 0; } }
  @media (max-width: 575px) { .tstat-card { margin-top: 20px; } }

  .tstat-card-wrap:nth-child(even) .tstat-card { margin-top: 0; }
  @media (max-width: 767px) { .tstat-card-wrap:nth-child(even) .tstat-card { margin: 70px auto; } }
  @media (max-width: 575px) { .tstat-card-wrap:nth-child(even) .tstat-card { margin: 70px auto 50px; } }

  .tstat-shape { position: absolute; inset: -24px; width: 312px; height: 312px; border-radius: 50%; border: 1px solid var(--primary); -webkit-transition: all .4s ease-in-out; transition: all .4s ease-in-out; }
  @media (max-width: 767px) { .tstat-shape { width: 290px; height: 290px; inset: -20px; } }
  .tstat-shape span { position: absolute; bottom: 55px; right: 15px; width: 24px; height: 24px; display: block; border-radius: 50%; background: var(--primary-soft-2); z-index: 2; }
  @media (max-width: 767px) { .tstat-shape span { bottom: 51px; right: 13px; } }
  .tstat-shape::before, .tstat-shape::after { content: ""; position: absolute; bottom: 20%; right: 7%; width: 10px; height: 10px; border-radius: 50%; background: var(--primary); }
  .tstat-card-wrap:nth-child(even) .tstat-shape span { top: 24px; right: 43px; bottom: auto; }
  .tstat-card-wrap:nth-child(even) .tstat-shape::before, .tstat-card-wrap:nth-child(even) .tstat-shape::after { bottom: auto; top: 10%; right: 16%; }

  .tstat-card .tstat-number { font-weight: 700; font-size: 48px; line-height: 48px; text-transform: capitalize; color: var(--tc-heading); margin-bottom: 7px; }
  .tstat-card .tstat-title { font-weight: 500; font-size: 22px; line-height: 36px; color: var(--tc-heading); margin: 0; }
  @media (max-width: 575px) { .tstat-card .tstat-title { font-size: 20px; } }

  .tstat-card:hover .tstat-shape { -webkit-animation: tstatSpin 10s linear infinite; animation: tstatSpin 10s linear infinite; }
  @keyframes tstatSpin { 100% { -webkit-transform: rotate(360deg); transform: rotate(360deg); } }
  </style>

  <script>
  (function () {
    var counters = document.querySelectorAll('.tstat-counter');
    if (!counters.length) return;
    function animate(el) {
      var target = parseInt(el.getAttribute('data-target'), 10) || 0;
      var duration = 1600, start = null;
      function step(ts) {
        if (!start) start = ts;
        var p = Math.min((ts - start) / duration, 1);
        el.textContent = Math.floor(p * target);
        if (p < 1) { requestAnimationFrame(step); } else { el.textContent = target; }
      }
      requestAnimationFrame(step);
    }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) { animate(entry.target); io.unobserve(entry.target); }
      });
    }, { threshold: 0.4 });
    counters.forEach(function (el) { io.observe(el); });
  })();
  </script>
</section>
<!-- ==================== 1. MEET OUR EXPERT TEAM ==================== -->
<!-- ==================== 1. MEET OUR EXPERT TEAM (techcadd 1:1) ==================== -->
<section class="tctm-area">
  <div class="container">
    <div class="title-area tctm-title">
      <span class="sub-title">Our Team Members</span>
      <h2 class="sec-title">Meet Our Techno Coderz Expert Team</h2>
      <p class="sec-text">Our team of experienced trainers and software developers is dedicated to delivering the best IT training, guiding you through every step of your tech journey.</p>
    </div>

    <div class="row g-4 justify-content-center">
      <?php
        // Techno Coderz expert team
        $teamMembers = [
            ['name' => 'Aakanksha',  'role' => 'Full Stack Development Trainer',      'img' => 'aakanksha.jpg'],
            ['name' => 'Geetanjali', 'role' => 'Java & Backend Development Trainer',  'img' => 'geetanjali.jpg'],
            ['name' => 'Jagjit',     'role' => 'Python & Data Science Trainer',       'img' => 'jagjit.jpg'],
            ['name' => 'Rakesh',     'role' => 'DevOps & Cyber Security Trainer',     'img' => 'rakesh.jpg'],
        ];
        foreach ($teamMembers as $member):
      ?>
      <div class="col-6 col-lg-3 reveal">
        <div class="tctm-card">
          <div class="tctm-img">
            <img src="<?= SITE_URL ?>/assets/images/team/<?= e($member['img']) ?>" alt="<?= e($member['name']) ?>" loading="lazy">
          </div>
          <div class="tctm-body">
            <h3 class="tctm-name"><?= e($member['name']) ?></h3>
            <span class="tctm-role"><?= e($member['role']) ?></span>
            <div class="tctm-socials">
              <a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
              <a href="#" aria-label="GitHub"><i class="bi bi-github"></i></a>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <style>
  .tctm-area { padding: 120px 0; background: #F2F5FA; overflow: hidden; }
  @media (max-width: 991px) { .tctm-area { padding: 80px 0; } }

  .tctm-title { text-align: center; margin-bottom: 55px; }
  .tctm-title .sub-title { display: block; font-weight: 500; font-size: 20px; letter-spacing: .02em; color: var(--primary); margin: 0 0 6px; }
  .tctm-title .sec-title { font-size: 48px; line-height: 1.327; font-weight: 700; color: var(--tc-heading); margin: 0 0 18px; }
  .tctm-title .sec-text { font-size: 16px; line-height: 26px; color: var(--tc-text); max-width: 760px; margin: 0 auto; }
  @media (max-width: 1199px) { .tctm-title .sec-title { font-size: 36px; } }
  @media (max-width: 767px)  { .tctm-title .sec-title { font-size: 34px; } }
  @media (max-width: 575px)  { .tctm-title .sec-title { font-size: 28px; } .tctm-title .sub-title { font-size: 18px; } }

  .tctm-card { background: #fff; border: 1px solid #E3E8F5; border-radius: 30px; overflow: hidden; text-align: center; height: 100%; transition: transform .4s ease, box-shadow .4s ease; }
  .tctm-card:hover { transform: translateY(-8px); box-shadow: 0 22px 48px rgba(15,23,42,.12); }
  .tctm-img { position: relative; aspect-ratio: 1 / 1; overflow: hidden; background: #E9EDF5; }
  .tctm-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease; }
  .tctm-card:hover .tctm-img img { transform: scale(1.08); }
  .tctm-body { padding: 22px 18px 26px; }
  .tctm-name { font-size: 22px; font-weight: 600; color: var(--tc-heading); margin: 0 0 4px; }
  .tctm-role { display: block; font-size: 15px; font-weight: 500; color: var(--primary); margin-bottom: 16px; }
  .tctm-socials { display: flex; justify-content: center; gap: 10px; }
  .tctm-socials a { width: 38px; height: 38px; display: grid; place-items: center; border-radius: 50%; background: var(--bg-light); color: var(--primary); font-size: 16px; transition: all .3s ease; }
  .tctm-socials a:hover { background: var(--primary); color: #fff; }
  </style>
</section>

<!-- ==================== 2. STUDENT TESTIMONIALS (techcadd 1:1) ==================== -->
<section class="tct-area">
  <div class="container">
    <div class="title-area tct-title">
      <span class="sub-title">Testimonials</span>
      <h2 class="sec-title">What Techno Coderz Students Say</h2>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-9 col-xl-8">
      <?php
        // Fallback testimonial (used when the database is empty / offline)
        if (empty($testimonials)) {
            $testimonials = [
                ['name' => 'Rahul Sharma', 'designation' => 'Junior PHP Developer, Infosys', 'message' => 'Techno Coderz completely transformed my career. The Full Stack course was practical, project-driven, and the mentors were always supportive. I landed my first job within 2 months of completing the course!', 'rating' => 5, 'image' => ''],
            ];
        }
        // Only one testimonial is shown on the homepage (techcadd layout)
        $t      = $testimonials[0];
        $stars  = max(1, min(5, (int) ($t['rating'] ?? 5)));
        $avatar = !empty($t['image']) ? SITE_URL . '/' . ltrim($t['image'], '/') : SITE_URL . '/assets/images/institute/success-1.jpg';
      ?>
      <div class="tct-card">
        <div class="tct-card_wrapper">
          <div class="tct-card_profile">
            <div class="tct-card_avater"><img src="<?= e($avatar) ?>" alt="<?= e($t['name']) ?>" loading="lazy"></div>
            <div class="tct-media-body">
              <h3 class="tct-box-title"><?= e($t['name']) ?></h3>
              <span class="tct-card_desig"><?= e($t['designation'] ?? '') ?></span>
            </div>
          </div>
          <div class="tct-card_review">
            <?php for ($s = 0; $s < $stars; $s++): ?><i class="bi bi-star-fill"></i><?php endfor; ?>
          </div>
        </div>
        <p class="tct-card_text">&ldquo;<?= e($t['message']) ?>&rdquo;</p>
        <div class="tct-card-quote"><i class="bi bi-quote"></i></div>
      </div>
    </div>
  </div>

  <style>
  .tct-area { padding: 120px 0 90px; background: #fff; overflow: hidden; }
  @media (max-width: 991px) { .tct-area { padding: 80px 0 60px; } }

  .tct-title { text-align: center; margin-bottom: 30px; }
  .tct-title .sub-title { display: block; font-weight: 500; font-size: 20px; letter-spacing: .02em; color: var(--primary); margin: 0 0 6px; }
  .tct-title .sec-title { font-size: 48px; line-height: 1.327; font-weight: 700; color: var(--tc-heading); margin: 0; }
  @media (max-width: 1199px) { .tct-title .sec-title { font-size: 36px; } }
  @media (max-width: 767px)  { .tct-title .sec-title { font-size: 34px; } }
  @media (max-width: 575px)  { .tct-title .sec-title { font-size: 28px; } .tct-title .sub-title { font-size: 18px; } }

  .tct-card { position: relative; margin: 20px auto 40px; padding: 40px 40px 64px; background: #F2F5FA; border-radius: 24px; transition: margin .5s ease-out; }
  @media (max-width: 991px) { .tct-card { padding: 30px 30px 64px; } }
  @media (max-width: 575px) { .tct-card { padding: 25px 25px 64px; } }

  .tct-card_wrapper { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 20px; }
  @media (max-width: 480px) { .tct-card_wrapper { display: block; } .tct-card_review { margin-top: 10px; } }
  .tct-card_profile { display: flex; align-items: center; gap: 16px; }
  .tct-card_avater { flex: 0 0 90px; width: 90px; height: 90px; border-radius: 50%; overflow: hidden; background: #E9EDF5; }
  .tct-card_avater img { width: 100%; height: 100%; object-fit: cover; }
  @media (max-width: 575px) { .tct-card_avater { flex-basis: 68px; width: 68px; height: 68px; } }
  .tct-card .tct-box-title { margin: 0; font-size: 24px; line-height: 1.3; font-weight: 600; color: var(--tc-heading); }
  @media (max-width: 575px) { .tct-card .tct-box-title { font-size: 20px; } }
  .tct-card_desig { color: var(--tc-text-muted); font-size: 15px; }
  .tct-card_review { white-space: nowrap; }
  .tct-card_review i { color: #FFA944; font-size: 14px; margin-right: 3px; }
  .tct-card_text { color: var(--tc-text); font-size: 20px; font-weight: 500; line-height: 1.5; margin: 0; }
  @media (max-width: 575px) { .tct-card_text { font-size: 17px; } }
  .tct-card-quote { position: absolute; left: 50%; bottom: -39px; transform: translateX(-50%); width: 78px; height: 78px; display: grid; place-items: center; border-radius: 50%; background: var(--primary); color: #fff; font-size: 34px; box-shadow: 0 10px 24px rgba(15,23,42,.08); transition: all .4s ease; }
  </style>
</section>

<!-- ==================== 3. BLOG & ARTICLES (techcadd 1:1) ==================== -->
<section class="tcb-area">
  <div class="container">
    <div class="title-area tcb-title">
      <span class="sub-title">Blog &amp; Articles</span>
      <h2 class="sec-title">Career &amp; Course Insights from Techno Coderz</h2>
      <p class="sec-text">Explore expert tips, coding best practices, and career guidance from Techno Coderz instructors.</p>
    </div>

  </div>

  <style>
  .tcb-area { padding: 120px 0; background: #F2F5FA; overflow: hidden; }
  @media (max-width: 991px) { .tcb-area { padding: 80px 0; } }

  .tcb-title { text-align: center; margin-bottom: 55px; }
  .tcb-title .sub-title { display: block; font-weight: 500; font-size: 20px; letter-spacing: .02em; color: var(--primary); margin: 0 0 6px; }
  .tcb-title .sec-title { font-size: 48px; line-height: 1.327; font-weight: 700; color: var(--tc-heading); margin: 0 0 18px; }
  .tcb-title .sec-text { font-size: 16px; line-height: 26px; color: var(--tc-text); max-width: 780px; margin: 0 auto; }
  @media (max-width: 1199px) { .tcb-title .sec-title { font-size: 36px; } }
  @media (max-width: 767px)  { .tcb-title .sec-title { font-size: 34px; } }
  @media (max-width: 575px)  { .tcb-title .sec-title { font-size: 28px; } .tcb-title .sub-title { font-size: 18px; } }

  .tcb-card { background: #fff; border: 1px solid #E3E8F5; border-radius: 30px; overflow: hidden; height: 100%; display: flex; flex-direction: column; transition: transform .4s ease, box-shadow .4s ease; }
  .tcb-card:hover { transform: translateY(-6px); box-shadow: 0 22px 48px rgba(15,23,42,.10); }
  .tcb-img { position: relative; display: block; aspect-ratio: 16 / 10; overflow: hidden; border-radius: 30px 30px 0 0; background: #E9EDF5; }
  .tcb-img:before { content: ""; position: absolute; top: 0; left: -100%; width: 50%; height: 100%; background: rgba(255,255,255,.25); transform: skewX(25deg); z-index: 2; }
  .tcb-card:hover .tcb-img:before { animation: tcbShine 1.2s; }
  @keyframes tcbShine { 100% { left: 125%; } }
  .tcb-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s ease; }
  .tcb-card:hover .tcb-img img { transform: scale(1.08); }

  .tcb-content { padding: 15px 30px 30px 40px; display: flex; flex-direction: column; flex: 1; }
  @media (max-width: 1299px) { .tcb-content { padding: 20px; } }
  .tcb-tags { font-size: 12px; font-weight: 700; color: var(--primary); letter-spacing: .48px; text-transform: uppercase; padding-bottom: 10px; margin-bottom: 25px; border-bottom: 1px solid #E1E5EB; }
  .tcb-box-title { font-size: 22px; font-weight: 600; line-height: 1.4; letter-spacing: -.24px; margin: 0 0 12px; }
  .tcb-box-title a { color: var(--tc-heading); text-decoration: none; background-image: linear-gradient(to left, var(--primary), var(--primary)); background-repeat: no-repeat; background-position: bottom left; background-size: 0 2px; transition: background-size .5s ease-in-out, color .3s ease; }
  .tcb-box-title a:hover { color: var(--primary); background-size: 100% 2px; }
  .tcb-text { color: var(--tc-text); font-size: 15px; line-height: 26px; margin: 0 0 20px; }
  .tcb-profile { display: flex; align-items: center; gap: 10px; margin-top: auto; padding-top: 18px; border-top: 1px solid #E1E5EB; }
  .tcb-author { flex: 0 0 40px; width: 40px; height: 40px; border-radius: 50%; overflow: hidden; background: #E9EDF5; }
  .tcb-author img { width: 100%; height: 100%; object-fit: cover; }
  .tcb-name { display: block; font-size: 16px; font-weight: 600; color: var(--tc-heading); }
  .tcb-date { font-size: 12px; color: var(--tc-text-muted); }
  .tcb-line-btn { display: inline-flex; align-items: center; gap: 6px; margin-top: 18px; font-size: 16px; font-weight: 600; color: var(--primary); text-decoration: none; }
  .tcb-line-btn i { transition: transform .3s ease; }
  .tcb-line-btn:hover i { transform: translateX(4px); }
  </style>
</section>

<?php // Homepage ends right after the Blog & Articles section (no site footer) ?>

<!-- Back to Top -->
<button id="backToTop" title="Back to top" aria-label="Back to top">
  <i class="bi bi-arrow-up"></i>
</button>

<!-- Toast Wrapper -->
<div class="tc-toast-wrap" id="tcToastWrap"></div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Techno Coderz Custom JS -->
<script src="<?= SITE_URL ?>/assets/js/technocoderz.js"></script>
<?php if (!empty($extraScripts)) echo $extraScripts; ?>

<!-- Auto Demo / Enquiry Popup -->
<?php $__popupAuto = true; require __DIR__ . '/includes/demo-popup.php'; ?>
</body>
</html>
