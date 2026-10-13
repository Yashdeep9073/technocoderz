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

<div class="tc-page-light tc-home-page">

  <!-- ======================== 1 · HERO ======================== -->
  <section class="tc-home-hero">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-6 reveal">
          <span class="tc-home-pill">
            <span class="tc-home-pill__tag">New</span>
            <span>Empower your learning journey</span>
          </span>
          <h1 class="tc-home-hero__title"><?= e($tagline) ?></h1>
          <p class="tc-home-hero__sub">
            Real-world projects and mentor-led training in AI &amp; Data Science, Full Stack, and
            DevOps &amp; Cyber Security — everything you need to become job-ready at <?= e($siteName) ?>.
          </p>
          <ul class="tc-home-hero__list">
            <li><i class="bi bi-patch-check-fill"></i> Industry-Aligned Curriculum</li>
            <li><i class="bi bi-patch-check-fill"></i> Hands-On Live Projects</li>
            <li><i class="bi bi-patch-check-fill"></i> Placement Support</li>
          </ul>
          <div class="tc-home-hero__actions">
            <a href="<?= SITE_URL ?>/courses.php" class="tc-btn tc-btn-primary tc-btn-lg">
              Explore Courses <i class="bi bi-arrow-right"></i>
            </a>
            <button type="button" class="tc-btn tc-btn-secondary tc-btn-lg" onclick="openEnquiry()">
              <i class="bi bi-chat-dots-fill"></i> Talk to a Counsellor
            </button>
          </div>
        </div>

        <div class="col-lg-6 reveal">
          <div class="tc-home-hero__visual">
            <div class="tc-home-hero__media">
              <img class="tc-home-hero__vector"
                   src="<?= SITE_URL ?>/assets/images/Vector.png"
                   alt="Techno Coderz training illustration"
                   fetchpriority="high" decoding="async">
            </div>
            <div class="tc-home-hero__float tc-home-hero__float--a">
              <i class="bi bi-book-half"></i> Project-Based Learning
            </div>
            <div class="tc-home-hero__float tc-home-hero__float--b">
              <i class="bi bi-people-fill"></i> Live Mentorship
            </div>
            <div class="tc-home-hero__float tc-home-hero__float--c">
              <i class="bi bi-shield-fill-check"></i> Certified Training
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ==================== 2 · BRAND / TECH MARQUEE ==================== -->
  <?php
    // Only ship logos that actually exist on disk (no broken images).
    $techItems = array_values(array_filter($techStrip, function ($t) {
        return is_file(__DIR__ . '/assets/images/tech/' . $t['file']);
    }));
  ?>
  <section class="tc-home-tech">
    <div class="container">
      <p class="tc-home-tech__label reveal">Technologies &amp; tools you'll master</p>
    </div>
    <?php if ($techItems): ?>
    <div class="tc-home-tech__marquee reveal" aria-label="Technologies and tools you'll master">
      <div class="tc-home-tech__track">
        <?php foreach ($techItems as $t): ?>
        <span class="tc-home-tech__item" title="<?= e($t['name']) ?>">
          <img src="<?= SITE_URL ?>/assets/images/tech/<?= e($t['file']) ?>" alt="<?= e($t['name']) ?>" loading="lazy" decoding="async">
        </span>
        <?php endforeach; ?>
        <?php foreach ($techItems as $t): // duplicate set — makes the loop seamless ?>
        <span class="tc-home-tech__item" aria-hidden="true">
          <img src="<?= SITE_URL ?>/assets/images/tech/<?= e($t['file']) ?>" alt="" loading="lazy" decoding="async">
        </span>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>
  </section>

  <!-- ==================== 3 · EXPLORE OUR COURSES ==================== -->
  <?php if ($courses): ?>
  <section class="tc-section tc-home-courses">
    <div class="container">
      <div class="tc-section-header text-center reveal">
        <div class="tc-badge"><i class="bi bi-mortarboard-fill"></i> Our Courses</div>
        <h2 class="tc-section-title">Explore Our <span>Courses</span></h2>
        <p class="tc-section-subtitle">Learn from industry experts and advance your career with practical, job-ready skills.</p>
      </div>

      <!-- Category filter (LearnUp-style tabs) -->
      <div class="tc-home-filters reveal">
        <a class="tc-chip active" href="<?= SITE_URL ?>/courses.php">All Courses</a>
        <?php foreach ($categoryTiles as $catSlug => $catTile): ?>
        <a class="tc-chip" href="<?= SITE_URL ?>/courses.php?cat=<?= urlencode($catSlug) ?>"><?= e($catTile['name']) ?></a>
        <?php endforeach; ?>
      </div>

      <div class="row g-4 justify-content-center">
        <?php $shown = 0; foreach ($courses as $i => $course):
            if ($shown >= 6) break; $shown++;
            $cat    = trim($course['category'] ?? '');
            $techs  = array_values(array_filter(array_map('trim', explode(',', $course['technologies'] ?? ''))));
            $img    = $course['image'] ?? '';
            $lessons = (int) ($course['lessons'] ?? 0);
        ?>
        <div class="col-md-6 col-xl-4 reveal" style="transition-delay:<?= (($shown - 1) % 3) * 0.08 ?>s">
          <div class="tc-course-card">
            <div class="tc-course-img">
              <?php if ($img && file_exists(UPLOAD_DIR . 'courses/' . $img)): ?>
              <img src="<?= UPLOAD_URL ?>courses/<?= e($img) ?>" alt="<?= e($course['title']) ?>" loading="lazy">
              <?php else: ?>
              <div class="tc-course-icon-wrap"><i class="<?= e($course['icon'] ?? 'bi bi-laptop') ?>"></i></div>
              <?php endif; ?>
              <span class="tc-course-badge"><i class="bi bi-clock-fill"></i> <?= e($course['duration'] ?? '') ?></span>
              <?php if ($cat !== ''): ?><span class="tc-course-cat"><?= e($cat) ?></span><?php endif; ?>
            </div>
            <div class="tc-course-body">
              <div class="tc-course-stats">
                <div class="tc-course-stat"><b><?= $lessons > 0 ? $lessons : '—' ?></b><span>Lessons</span></div>
                <div class="tc-course-stat"><b><?= e($course['duration'] ?? '') ?></b><span>Duration</span></div>
                <div class="tc-course-stat"><b><?= e($course['level'] ?? '') ?></b><span>Level</span></div>
              </div>
              <h3 class="tc-course-title"><?= e($course['title']) ?></h3>
              <p class="tc-course-desc"><?= e($course['short_description'] ?? '') ?></p>
              <?php if ($techs): ?>
              <div class="tc-tech-list">
                <?php foreach (array_slice($techs, 0, 5) as $t):
                    $iconFile = $techIcons[strtolower($t)] ?? null;
                ?>
                <span class="tc-tech-chip" title="<?= e($t) ?>">
                  <?php if ($iconFile && file_exists(__DIR__ . '/assets/images/tech/' . $iconFile)): ?>
                  <img src="<?= SITE_URL ?>/assets/images/tech/<?= e($iconFile) ?>" alt="<?= e($t) ?>" loading="lazy" onerror="this.remove()">
                  <?php else: ?><i class="bi bi-puzzle-piece"></i><?php endif; ?>
                  <?= e($t) ?>
                </span>
                <?php endforeach; ?>
              </div>
              <?php endif; ?>
              <div class="tc-course-actions">
                <a href="<?= SITE_URL ?>/course-details.php?slug=<?= urlencode($course['slug']) ?>" class="tc-btn tc-btn-secondary tc-btn-sm">
                  <i class="bi bi-journal-text"></i> Syllabus
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

      <div class="text-center mt-5 reveal">
        <a href="<?= SITE_URL ?>/courses.php" class="tc-btn tc-btn-secondary tc-btn-lg">
          View All Courses <i class="bi bi-arrow-right"></i>
        </a>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- ==================== 4 · PROMO / CERTIFICATE BAND ==================== -->
  <section class="tc-home-promo">
    <div class="container">
      <div class="tc-home-promo__inner reveal">
        <div class="tc-home-promo__copy">
          <span class="tc-home-promo__eyebrow"><i class="bi bi-patch-check-fill"></i> Get Certified</span>
          <h2>Become a Certified <span><?= e($siteName) ?></span> Professional</h2>
          <p>Finish your programme with a course completion certificate and a portfolio of deployable projects that prove your skills to employers.</p>
        </div>
        <div class="tc-home-promo__media">
          <img src="<?= SITE_URL ?>/assets/images/institute/success-5.jpeg" alt="Techno Coderz certification" loading="lazy" decoding="async">
        </div>
        <div class="tc-home-promo__action">
          <a href="<?= SITE_URL ?>/courses.php" class="tc-btn tc-btn-primary tc-btn-lg">
            Explore Courses <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- ==================== 5 · DISCOVER CATEGORIES ==================== -->
  <?php if ($categoryTiles): ?>
  <section class="tc-section tc-home-categories">
    <div class="container">
      <div class="tc-section-header text-center reveal">
        <div class="tc-badge"><i class="bi bi-grid-1x2-fill"></i> Discover</div>
        <h2 class="tc-section-title">Browse By <span>Category</span></h2>
        <p class="tc-section-subtitle">Browse a wide range of subjects and start learning what you love.</p>
      </div>
      <div class="row g-4 justify-content-center">
        <?php $ci = 0; foreach ($categoryTiles as $catSlug => $catTile): ?>
        <div class="col-lg-4 col-md-6 reveal" style="transition-delay:<?= $ci++ * 0.08 ?>s">
          <a class="tc-cat-tile" href="<?= SITE_URL ?>/courses.php?cat=<?= urlencode($catSlug) ?>">
            <span class="tc-cat-tile__icon"><i class="<?= e($categoryIcons[$catSlug] ?? 'bi-collection-fill') ?>"></i></span>
            <span class="tc-cat-tile__body">
              <b><?= e($catTile['name']) ?></b>
              <small><?= (int) $catTile['count'] ?> <?= $catTile['count'] === 1 ? 'Course' : 'Courses' ?></small>
            </span>
            <i class="bi bi-arrow-right tc-cat-tile__arrow"></i>
          </a>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- ==================== 6 · SUCCESS STORIES ==================== -->
  <?php if ($testimonials): ?>
  <section class="tc-section tc-section-alt tc-home-stories">
    <div class="container">
      <div class="tc-section-header text-center reveal">
        <div class="tc-badge"><i class="bi bi-chat-quote-fill"></i> Testimonials</div>
        <h2 class="tc-section-title">Success <span>Stories</span></h2>
        <p class="tc-section-subtitle">Hear from learners who built their tech careers with <?= e($siteName) ?>.</p>
      </div>
      <div class="row g-4">
        <?php foreach ($testimonials as $i => $t): ?>
        <div class="col-lg-4 col-md-6 reveal" style="transition-delay:<?= ($i % 3) * 0.08 ?>s">
          <article class="tc-testimonial-card">
            <div class="tc-testi-stars"><?= starRating((int) ($t['rating'] ?? 5)) ?></div>
            <p class="tc-testi-msg">“<?= e($t['message']) ?>”</p>
            <div class="tc-testi-author">
              <span class="tc-testi-avatar"><i class="bi bi-person-fill"></i></span>
              <span>
                <span class="tc-testi-name"><?= e($t['name']) ?></span>
                <span class="tc-testi-role"><?= e($t['designation'] ?? '') ?></span>
              </span>
            </div>
          </article>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- ==================== 7 · WHY CHOOSE US ==================== -->
  <section class="tc-section tc-home-why">
    <div class="container">
      <div class="tc-why-band reveal">
        <div class="tc-why-head">
          <div class="tc-badge"><i class="bi bi-stars"></i> Why Choose Us</div>
          <h2 class="tc-section-title">Why <?= e($siteName) ?> Learning Platform?</h2>
          <p>Everything in a <?= e($siteName) ?> programme is engineered towards one goal — a job you are genuinely proud of.</p>
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

  <!-- ==================== 8 · LEARNING BENEFITS ==================== -->
  <section class="tc-section tc-section-alt tc-home-benefits">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-6 reveal">
          <div class="tc-badge"><i class="bi bi-patch-check-fill"></i> Why Learn With Us</div>
          <h2 class="tc-section-title" style="text-align:left;">Everything You Need To <span>Grow Your Career</span></h2>
          <p style="color:var(--text-muted); font-size:0.98rem; line-height:1.85; margin-bottom:24px;">
            A learner-first environment that blends live teaching, practical work and career guidance so you finish
            with skills employers actually look for.
          </p>
          <ul class="tc-benefit-list">
            <?php foreach ($benefits as $b): ?>
            <li><i class="bi bi-patch-check-fill"></i> <?= e($b) ?></li>
            <?php endforeach; ?>
          </ul>
          <a href="<?= SITE_URL ?>/courses.php" class="tc-btn tc-btn-primary tc-btn-lg">
            Get Started <i class="bi bi-arrow-right"></i>
          </a>
        </div>
        <div class="col-lg-6 reveal">
          <div class="tc-home-about__media">
            <img src="<?= SITE_URL ?>/assets/images/institute/success-1.jpg" alt="Techno Coderz learners collaborating in a training session" loading="lazy" decoding="async">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ==================== 9 · CONTACT / ENQUIRY ==================== -->
  <section class="tc-section tc-home-contact" id="enquire-form">
    <div class="container">
      <div class="row g-5 align-items-start">
        <div class="col-lg-5 reveal">
          <div class="tc-badge"><i class="bi bi-headset"></i> Get In Touch</div>
          <h2 class="tc-section-title" style="text-align:left;">Have A Question? <span>Let's Talk</span></h2>
          <p style="color:var(--text-muted); font-size:0.98rem; line-height:1.85; margin-bottom:26px;">
            Talk to our counsellors about courses, batches and career paths. We usually reply within 24 hours.
          </p>
          <ul class="tc-home-contact__info">
            <li>
              <span class="tc-home-contact__icon"><i class="bi bi-telephone-fill"></i></span>
              <span>
                <small>Call Us</small>
                <a href="tel:<?= e(preg_replace('/\s+/', '', $homePhone)) ?>"><?= e($homePhone) ?></a>
                <?php if ($homePhone2): ?><a href="tel:<?= e(preg_replace('/\s+/', '', $homePhone2)) ?>"><?= e($homePhone2) ?></a><?php endif; ?>
              </span>
            </li>
            <li>
              <span class="tc-home-contact__icon"><i class="bi bi-envelope-fill"></i></span>
              <span>
                <small>Email Us</small>
                <a href="mailto:<?= e($homeEmail) ?>"><?= e($homeEmail) ?></a>
                <?php if ($homeEmail2): ?><a href="mailto:<?= e($homeEmail2) ?>"><?= e($homeEmail2) ?></a><?php endif; ?>
              </span>
            </li>
            <li>
              <span class="tc-home-contact__icon"><i class="bi bi-geo-alt-fill"></i></span>
              <span>
                <small>Visit Us</small>
                <span><?= e($homeAddr) ?></span>
              </span>
            </li>
          </ul>
        </div>

        <div class="col-lg-7 reveal">
          <div class="tc-home-contact__form">
            <h3>Send Us An Enquiry</h3>
            <div id="cfMsg" class="tc-form-msg" style="display:none"></div>
            <form onsubmit="event.preventDefault(); submitHomeContact();" novalidate>
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="tc-form-label">Your Name</label>
                  <input type="text" id="cfName" class="tc-form-control" placeholder="Your full name" required>
                </div>
                <div class="col-md-6">
                  <label class="tc-form-label">Email Address</label>
                  <input type="email" id="cfEmail" class="tc-form-control" placeholder="you@example.com" required>
                </div>
                <div class="col-md-6">
                  <label class="tc-form-label">Phone Number</label>
                  <input type="tel" id="cfPhone" class="tc-form-control" placeholder="+91 98765 43210">
                </div>
                <div class="col-md-6">
                  <label class="tc-form-label">Course Interested In</label>
                  <select id="cfCourse" class="tc-form-control">
                    <option value="">-- Select a Course --</option>
                    <?php foreach ($courses as $c): ?>
                    <option value="<?= e($c['title']) ?>"><?= e($c['title']) ?></option>
                    <?php endforeach; ?>
                    <option value="Other / Not Sure">Other / Not Sure</option>
                  </select>
                </div>
                <div class="col-12">
                  <label class="tc-form-label">Your Message</label>
                  <textarea id="cfMessage" class="tc-form-control" rows="4" placeholder="Tell us about your background, goals, or any specific questions..."></textarea>
                </div>
                <div class="col-12">
                  <button type="submit" class="tc-btn tc-btn-primary tc-btn-lg">
                    <i class="bi bi-send-fill"></i> Send Enquiry
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ==================== 10 · NEWSLETTER ==================== -->
  <section class="tc-section tc-home-newsletter">
    <div class="container">
      <div class="tc-newsletter reveal">
        <div class="tc-newsletter__copy">
          <span class="tc-newsletter__icon"><i class="bi bi-envelope-open-fill"></i></span>
          <div>
            <h2>Subscribe to our newsletter</h2>
            <p>Get course updates, career tips and new batch announcements — straight to your inbox.</p>
          </div>
        </div>
        <form class="tc-newsletter__form" onsubmit="event.preventDefault(); submitNewsletter();">
          <i class="bi bi-envelope" aria-hidden="true"></i>
          <input type="email" id="nlEmail" class="tc-form-control" placeholder="Enter your email address" aria-label="Email address" required>
          <button type="submit" class="tc-btn tc-btn-primary"><i class="bi bi-send-fill"></i> Subscribe</button>
        </form>
        <p class="tc-nl-msg" id="nlMsg" role="status" aria-live="polite"></p>
      </div>
    </div>
  </section>

</div><!-- /.tc-page-light -->

<script>
// Homepage contact form — posts to the existing enquiry endpoint.
function submitHomeContact() {
  var msg = document.getElementById('cfMsg');
  var name = (document.getElementById('cfName').value || '').trim();
  var email = (document.getElementById('cfEmail').value || '').trim();
  var phone = (document.getElementById('cfPhone').value || '').trim();
  var course = document.getElementById('cfCourse').value || '';
  var message = (document.getElementById('cfMessage').value || '').trim();

  if (!name || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    showFormMsg(msg, 'Please enter your name and a valid email address.', 'danger');
    return;
  }

  var csrfEl = document.getElementById('enquiryCsrf');
  var fd = new FormData();
  fd.append('name', name);
  fd.append('email', email);
  fd.append('phone', phone);
  fd.append('course', course || 'Homepage Enquiry');
  fd.append('message', message);
  fd.append('csrf_token', csrfEl ? csrfEl.value : '');

  showFormMsg(msg, 'Sending...', 'info');
  fetch(window.TC_BASE_URL + '/ajax/enquiry.php', { method: 'POST', body: fd })
    .then(function (r) { return r.json(); })
    .then(function (data) {
      if (data.success) {
        showFormMsg(msg, data.message || 'Thank you! Your enquiry has been sent.', 'success');
        document.getElementById('cfName').value = '';
        document.getElementById('cfEmail').value = '';
        document.getElementById('cfPhone').value = '';
        document.getElementById('cfMessage').value = '';
      } else {
        showFormMsg(msg, data.message || 'Something went wrong. Please try again.', 'danger');
      }
    })
    .catch(function () {
      showFormMsg(msg, 'Network error. Please check your connection.', 'danger');
    });
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
