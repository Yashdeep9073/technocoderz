
<?php
// ============================================================
// Techno Coderz — About Us
// Layout reference: FiStudy Laravel /about
//   page-header → about-three (story + mission/vision tabs)
//   → why-choose-three → counter → testimonials → contact info
// All content below is existing / genuine Techno Coderz data.
// ============================================================
require_once __DIR__ . '/includes/functions.php';

$pageTitle       = 'About Us – Techno Coderz';
$pageDescription = 'Learn about Techno Coderz — our mission, vision, values, and how we have been shaping technology careers since 2016.';
$currentPage     = 'about';
$csrf = generateCsrfToken();

$pdo          = getDB();
$testimonials = $pdo->query("SELECT name, designation, rating, message FROM testimonials WHERE status = 1 ORDER BY id ASC")->fetchAll();

$settings = [];
try {
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
    while ($row = $stmt->fetch()) {
        if (trim($row['setting_value'] ?? '') !== '') {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
    }
} catch (Exception $ex) {
    $settings = $settings ?: [];
}
$siteName    = $settings['site_name'] ?? 'Techno Coderz';
$sitePhone   = $settings['phone']  ?? '+91 98765 43210';
$siteEmail   = $settings['email']  ?? 'info@technocoderz.com';
$siteAddress = $settings['address'] ?? 'Mohali, Punjab, India';

// Genuine value points, already published elsewhere on the site.
$values = [
    ['icon' => 'bi-hammer',                 'title' => 'Practical First',    'desc' => 'Developers are made through practice, not presentations. Every class involves hands-on coding and problem-solving.'],
    ['icon' => 'bi-people-fill',            'title' => 'Student-Centered',   'desc' => 'Small batch sizes, personalised mentorship and flexible schedules — every learner gets individual attention.'],
    ['icon' => 'bi-shield-check',           'title' => 'Industry Integrity', 'desc' => 'We teach what the industry actually uses, with a curriculum updated to real job-market requirements.'],
    ['icon' => 'bi-stars',                  'title' => 'Quality Obsessed',   'desc' => 'From our code to our course material to our mentors, we hold rigorous quality standards in everything.'],
];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<script>window.TC_BASE_URL = '<?= SITE_URL ?>';</script>
<script>document.addEventListener('DOMContentLoaded', function () { var c = document.getElementById('enquiryCsrf'); if (c) c.value = '<?= e($csrf) ?>'; });</script>

<div class="tc-page-light tc-about-page">

<!-- ================= Page Hero (FiStudy page-header) ================= -->
<div class="tc-page-hero">
  <div class="container text-center reveal">
    <ul class="tc-breadcrumb">
      <li><a href="<?= SITE_URL ?>"><i class="bi bi-house-fill"></i> Home</a></li>
      <li class="sep">/</li>
      <li class="current">About Us</li>
    </ul>
    <h1 class="tc-section-title" style="margin-bottom:10px;">About <span>Techno Coderz</span></h1>
    <p style="font-size:1.05rem; max-width:620px; margin:0 auto;">
      Discover who we are, what drives us, and why 1,200+ students have trusted us for their technology education.
    </p>
  </div>
</div>

<!-- ============ Story + Mission/Vision tabs (FiStudy about-three) ============ -->
<section class="tc-section">
  <div class="container">
    <div class="row align-items-center g-5">

      <!-- Left: media collage -->
      <div class="col-lg-5 reveal">
        <div class="tc-about-media">
          <div class="tc-about-media__main">
            <img src="<?= SITE_URL ?>/assets/images/institute/success-1.jpg" alt="Techno Coderz students building projects in a live coding session" loading="lazy">
          </div>
          <div class="tc-about-media__sub">
            <img src="<?= SITE_URL ?>/assets/images/institute/success-2.jpg" alt="Hands-on mentorship at Techno Coderz" loading="lazy">
          </div>
          <div class="tc-about-exp">
            <b>8+</b>
            <span>Years of<br>Training</span>
          </div>
        </div>
      </div>

      <!-- Right: story + tabs -->
      <div class="col-lg-7 reveal">
        <div class="tc-badge"><i class="bi bi-book-half"></i> Our Story</div>
        <h2 class="tc-section-title text-start" style="font-size:clamp(1.6rem,2.6vw,2.35rem);">
          From a Small Lab to India's<br>Trusted <span>IT Training Partner</span>
        </h2>
        <p style="color:var(--text-body); font-size:0.99rem; line-height:1.85; margin-bottom:16px;">
          Techno Coderz was founded in 2016 with a clear conviction: traditional education alone wasn't preparing students for real-world software development. Too many graduates left college with theoretical knowledge but couldn't build a working application.
        </p>
        <p style="color:var(--text-body); font-size:0.99rem; line-height:1.85; margin-bottom:22px;">
          We started as a small training lab with three mentors and a dozen students. Our approach was different from day one — every class involved real coding, every week produced something tangible, and every course ended with students having built actual, deployable projects.
        </p>

        <!-- Mission / Vision tabs -->
        <div class="tc-about-tabs" data-tabs>
          <div class="tc-about-tab-btns" role="tablist">
            <button type="button" class="tc-about-tab-btn is-active" data-tab="mission" role="tab" aria-selected="true">
              <i class="bi bi-rocket-takeoff-fill"></i> Our Mission
            </button>
            <button type="button" class="tc-about-tab-btn" data-tab="vision" role="tab" aria-selected="false">
              <i class="bi bi-eye-fill"></i> Our Vision
            </button>
          </div>

          <div class="tc-about-tab-panel is-active" data-panel="mission" role="tabpanel">
            <ul class="tc-about-mv-list">
              <li>
                <span class="ic"><i class="bi bi-bullseye"></i></span>
                <div>
                  <h4>Practical, project-first learning</h4>
                  <p>To bridge the gap between academic learning and industry expectations through practical, project-based education that empowers students to build real applications.</p>
                </div>
              </li>
              <li>
                <span class="ic"><i class="bi bi-diagram-3-fill"></i></span>
                <div>
                  <h4>Bridging learners and industry</h4>
                  <p>To connect graduates with a 15+ hiring-partner network through resume building, mock interviews and referrals until they are placed.</p>
                </div>
              </li>
            </ul>
          </div>

          <div class="tc-about-tab-panel" data-panel="vision" role="tabpanel">
            <ul class="tc-about-mv-list">
              <li>
                <span class="ic"><i class="bi bi-award-fill"></i></span>
                <div>
                  <h4>India's most trusted partner</h4>
                  <p>To become India's most trusted IT training and development partner, known for producing confident, capable software professionals.</p>
                </div>
              </li>
              <li>
                <span class="ic"><i class="bi bi-laptop"></i></span>
                <div>
                  <h4>Job-ready from day one</h4>
                  <p>Graduates who don't just know theory but can confidently build, deploy and maintain production-level software from day one.</p>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ============ Why Choose Us (FiStudy why-choose-three) ============ -->
<section class="tc-section tc-section-alt">
  <div class="container">
    <div class="row g-5 align-items-center">

      <!-- Left: heading + quote -->
      <div class="col-lg-6 reveal">
        <div class="tc-badge"><i class="bi bi-patch-check-fill"></i> Why Choose Us</div>
        <h2 class="tc-section-title text-start" style="font-size:clamp(1.6rem,2.6vw,2.3rem);">
          What Makes <span>Techno Coderz</span> Different
        </h2>
        <p class="tc-about-why-text">
          We combine project-based learning, small batches and working mentors so every learner gets the individual attention needed to become genuinely job-ready.
        </p>

        <?php if ($testimonials): $tm = $testimonials[0]; $stars = max(1, min(5, (int) ($tm['rating'] ?? 5))); ?>
        <div class="tc-about-quote">
          <i class="bi bi-quote tc-about-tm__quote"></i>
          <div class="tc-about-quote__stars">
            <?= str_repeat('<i class="bi bi-star-fill"></i>', $stars) ?><?= str_repeat('<i class="bi bi-star"></i>', 5 - $stars) ?>
          </div>
          <p class="tc-about-quote__text"><?= e($tm['message']) ?></p>
          <div class="tc-about-quote__who">
            <span class="tc-about-tm__ava"><?= e(strtoupper(substr(trim($tm['name']), 0, 1))) ?></span>
            <span>
              <b><?= e($tm['name']) ?></b>
              <small><?= e($tm['designation']) ?></small>
            </span>
          </div>
        </div>
        <?php endif; ?>
      </div>

      <!-- Right: 4 features -->
      <div class="col-lg-6 reveal">
        <ul class="tc-about-feat">
          <?php foreach ($values as $v): ?>
          <li>
            <span class="ic"><i class="bi <?= $v['icon'] ?>"></i></span>
            <div>
              <h4><?= e($v['title']) ?></h4>
              <p><?= e($v['desc']) ?></p>
            </div>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>

    </div>
  </div>
</section>

<!-- ============ Counter band (FiStudy counter-one) ============ -->
<section class="tc-counter-band">
  <div class="container">
    <div class="row g-4">
      <?php
      $counterStats = [
        ['v' => 8,    's' => '+', 'l' => 'Years in Operation', 'i' => 'bi-calendar3'],
        ['v' => 1200, 's' => '+', 'l' => 'Students Trained',   'i' => 'bi-people-fill'],
        ['v' => 98,   's' => '%', 'l' => 'Placement Success',  'i' => 'bi-graph-up-arrow'],
        ['v' => 15,   's' => '+', 'l' => 'Hiring Partners',    'i' => 'bi-building'],
      ];
      foreach ($counterStats as $cs):
      ?>
      <div class="col-6 col-lg-3 reveal">
        <div class="tc-counter">
          <span class="icon"><i class="bi <?= $cs['i'] ?>"></i></span>
          <b data-count="<?= $cs['v'] ?>" data-suffix="<?= $cs['s'] ?>">0<?= $cs['s'] ?></b>
          <span><?= $cs['l'] ?></span>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ Testimonials (FiStudy testimonial-two) ============ -->
<section class="tc-section">
  <div class="container">
    <div class="tc-section-header text-center reveal">
      <div class="tc-badge"><i class="bi bi-quote"></i> Student Voices</div>
      <h2 class="tc-section-title">What Our <span>Students Say</span></h2>
      <p>Real outcomes from learners who started exactly where you are today.</p>
    </div>
    <div class="row g-4">
      <?php if ($testimonials):
          foreach ($testimonials as $i => $tm):
            $stars = max(1, min(5, (int) ($tm['rating'] ?? 5)));
      ?>
      <div class="col-lg-4 col-md-6 reveal" style="transition-delay:<?= ($i % 3) * 0.08 ?>s">
        <div class="tc-about-tm">
          <i class="bi bi-quote tc-about-tm__quote"></i>
          <div class="tc-about-tm__stars">
            <?= str_repeat('<i class="bi bi-star-fill"></i>', $stars) ?><?= str_repeat('<i class="bi bi-star"></i>', 5 - $stars) ?>
          </div>
          <p class="tc-about-tm__text"><?= e($tm['message']) ?></p>
          <div class="tc-about-tm__who">
            <span class="tc-about-tm__ava"><?= e(strtoupper(substr(trim($tm['name']), 0, 1))) ?></span>
            <span>
              <b><?= e($tm['name']) ?></b>
              <small><?= e($tm['designation']) ?></small>
            </span>
          </div>
        </div>
      </div>
      <?php endforeach;
          else: ?>
      <p class="text-center text-muted w-100">Testimonials are loading soon.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ============ Sliding text band (FiStudy sliding-text-three) ============ -->
<section class="tc-about-marquee" aria-label="What we stand for">
  <div class="tc-about-marquee__track">
    <?php
    $marquee = ['Practical Training', 'Live Projects', 'Expert Mentors', 'Placement Support', 'Certified Courses'];
    for ($loop = 0; $loop < 2; $loop++):
      foreach ($marquee as $word): ?>
    <span class="tc-about-marquee__item"><?= e($word) ?></span>
    <span class="tc-about-marquee__dot" aria-hidden="true"><i class="bi bi-asterisk"></i></span>
    <?php endforeach;
    endfor; ?>
  </div>
</section>

<!-- ============ Newsletter (FiStudy newsletter-two) ============ -->
<section class="tc-section tc-about-news">
  <div class="container">
    <div class="tc-about-news__box reveal">
      <div class="tc-about-news__copy">
        <span class="tc-about-news__icon"><i class="bi bi-envelope-open-fill"></i></span>
        <div>
          <h2>Subscribe to our newsletter</h2>
          <p>Get course updates, career tips and new batch announcements — straight to your inbox.</p>
        </div>
      </div>
      <form class="tc-about-news__form" onsubmit="event.preventDefault(); submitNewsletter();">
        <i class="bi bi-envelope" aria-hidden="true"></i>
        <input type="email" id="nlEmail" class="tc-form-control" placeholder="Enter your email address" aria-label="Email address" required>
        <button type="submit" class="tc-btn tc-btn-primary"><i class="bi bi-send-fill"></i> Subscribe</button>
      </form>
      <p class="tc-nl-msg" id="nlMsg" role="status" aria-live="polite"></p>
    </div>
  </div>
</section>

<!-- ============ Contact info band (FiStudy contact-info-one) ============ -->
<section class="tc-section" style="background:var(--bg-light); border-top:1px solid rgba(30,41,59,.07);">
  <div class="container">
    <div class="tc-contact-cards tc-about-contact reveal">
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
          <p style="font-size:.78rem;">We reply within 24 hours</p>
        </div>
      </div>
    </div>
  </div>
</section>

</div><!-- /.tc-page-light -->

<script>
// Mission / Vision tabs (progressively enhances the base markup)
(function () {
  var root = document.querySelector('[data-tabs]');
  if (!root) return;
  var btns   = Array.prototype.slice.call(root.querySelectorAll('.tc-about-tab-btn'));
  var panels = Array.prototype.slice.call(root.querySelectorAll('.tc-about-tab-panel'));
  btns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      var key = btn.dataset.tab;
      btns.forEach(function (b) {
        var on = b === btn;
        b.classList.toggle('is-active', on);
        b.setAttribute('aria-selected', on ? 'true' : 'false');
      });
      panels.forEach(function (p) {
        p.classList.toggle('is-active', p.dataset.panel === key);
      });
    });
  });
})();
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
