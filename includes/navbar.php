<?php
// ============================================================
// Techno Coderz â€” Navbar (techcadd-style layout, orange theme)
// Proper partial: outputs only the navbar markup (no html/body)
// ============================================================
if (!isset($currentPage)) $currentPage = '';
$tcNav = function ($page) use ($currentPage) {
    return $page === $currentPage ? ' active' : '';
};

// Course catalogue (techcadd-style "Courses" menu) grouped by category
$__courseCatalogue = require __DIR__ . '/courses-data.php';
$__courseGroups = [];
foreach ($__courseCatalogue as $__c) {
    $__courseGroups[$__c['category']][] = $__c;
}
// Fixed display order of the four course groups
$__groupOrder = ['Programming', 'Digital Marketing', 'AI Courses', 'Cyber Courses'];

// Techcadd "After 12th" menu (mega-menu content -> dedicated pages)
$__after12 = [
    '6 Months Courses' => [
        ['t' => 'Advanced Certificate in Digital Marketing and Communication', 'u' => coursePageUrl('advanced-certificate-in-digital-marketing-and-communication')],
        ['t' => 'Professional Certificate Python Programming Course',         'u' => coursePageUrl('professional-certificate-python-programming-course')],
        ['t' => 'Certificate Course Program in ML & AI',                      'u' => coursePageUrl('certificate-course-program-in-ml-ai')],
        ['t' => 'Certificate course in cybersecurity',                        'u' => coursePageUrl('certificate-course-in-cyber-security')],
    ],
    '1 year Courses' => [
        ['t' => 'Advanced Certificate Program in Generative AI',                     'u' => coursePageUrl('advance-certificate-programme-in-generative-ai')],
        ['t' => 'Professional Certificate Program in Cloud Computing and DevOps',    'u' => coursePageUrl('professional-certificate-program-in-cloud-computing-and-devops')],
        ['t' => 'Advanced Certificate in Artificial Intelligence and Data Science',  'u' => coursePageUrl('advance-certificate-course-in-artificial-intelligence-and-data-science')],
        ['t' => 'Certificate Course in Machine Learning and Deep Learning',          'u' => coursePageUrl('certificate-course-in-machine-learning-and-deep-learning')],
        ['t' => 'Advanced program in cybersecurity and ethical hacking',             'u' => coursePageUrl('advanced-program-in-cybersecurity-and-ethical-hacking')],
    ],
    'Civil / Architecture / Mechanical' => [
        ['t' => 'AutoCad',    'u' => coursePageUrl('best-autocad-course-in-mohali')],
        ['t' => 'Solid Works','u' => coursePageUrl('best-solid-works-course-in-mohali')],
        ['t' => "3Ds Max",    'u' => coursePageUrl('best-3d-s-max-course-in-mohali')],
        ['t' => 'Revit',      'u' => coursePageUrl('best-revit-course-in-mohali')],
    ],
    'Quick Links' => [
        ['t' => 'Contact Support', 'u' => 'contact.php'],
        ['t' => 'Franchise',       'u' => 'franchise.php'],
        ['t' => 'Placement Cell',  'u' => 'placement-cell.php'],
        ['t' => 'Student Login',   'u' => 'student-login.php'],
        ['t' => 'Employee Login',  'u' => 'employee-login.php'],
        ['t' => 'Portal Login',    'u' => 'portal-login.php'],
    ],
];
?>
<!-- ================= TOP BAR ================= -->
<div class="tcn-topbar">
  <div class="tcn-topbar-inner">
    <div class="tcn-topbar-left">
      <a class="tcn-pill" href="after-12th-courses.php"><i class="bi bi-mortarboard-fill"></i> After 12<sup>th</sup> Courses</a>
    </div>
    <div class="tcn-topbar-right">
      <a href="career.php"><i class="bi bi-briefcase"></i> See Jobs</a>
      <a href="certificate-verification.php"><i class="bi bi-patch-check"></i> Certificate verification</a>
      <a href="tel:+919876543210"><i class="bi bi-telephone"></i> +91 98765 43210</a>
      <div class="tcn-social">
        <a class="tcn-fb" href="https://facebook.com/technocoderz" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
        <a class="tcn-ig" href="https://instagram.com/technocoderz" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
        <a class="tcn-li" href="https://linkedin.com/company/technocoderz" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
        <a class="tcn-yt" href="https://youtube.com/@technocoderz" target="_blank" rel="noopener" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
        <a class="tcn-tw" href="https://twitter.com/technocoderz" target="_blank" rel="noopener" aria-label="Twitter/X"><i class="bi bi-twitter-x"></i></a>
        <a class="tcn-wa" href="https://wa.me/919876543210" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
      </div>
    </div>
  </div>
</div>

<!-- ================= MAIN HEADER ================= -->
<header class="tcn-header" id="tcNavbar">
  <div class="tcn-header-inner">
    <a class="tcn-logo" href="index.php">
      <img src="<?= SITE_URL ?>/assets/images/image.png" alt="Techno Coderz">
    </a>

    <ul class="tcn-nav">
      <li><a class="tcn-link tcn-underline<?= $tcNav('home') ?>" href="index.php">Home</a></li>
      <li class="tcn-has-mega">
        <a class="tcn-link tcn-underline<?= $tcNav('about') ?>" href="about.php" role="button" aria-haspopup="true" aria-expanded="false">About <i class="bi bi-chevron-down tcn-caret"></i></a>
        <div class="tcn-mega tcn-mega--about">
          <div class="tcn-about-grid">
            <div class="tcn-about-links">
              <a class="tcn-about-link" href="about.php">About Techno Coderz</a>
              <a class="tcn-about-link" href="mission-vision.php">Mission &amp; Vision</a>
              <a class="tcn-about-link" href="about.php#campus">Campus &amp; Facilities</a>
              <a class="tcn-about-link" href="founder.php">Founder &amp; Team</a>
              <a class="tcn-about-cta" href="contact.php">Talk to a counsellor <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="tcn-about-cards">
              <a class="tcn-acard" href="about.php">
                <span class="tcn-acard-img"><img src="<?= SITE_URL ?>/assets/images/institute/success-1.jpg" alt="About Techno Coderz" loading="lazy"></span>
                <span class="tcn-acard-title">About Techno Coderz</span>
                <span class="tcn-acard-meta"><span class="tcn-acard-tag">Story</span><span class="tcn-acard-sub">Since 2016</span></span>
              </a>
              <a class="tcn-acard" href="mission-vision.php">
                <span class="tcn-acard-img"><img src="<?= SITE_URL ?>/assets/images/courses-coding.jpg" alt="Techno Coderz mission and vision" loading="lazy"></span>
                <span class="tcn-acard-title">Mission &amp; Vision</span>
                <span class="tcn-acard-meta"><span class="tcn-acard-tag">Purpose</span><span class="tcn-acard-sub">Our direction</span></span>
              </a>
              <a class="tcn-acard" href="about.php#campus">
                <span class="tcn-acard-img"><img src="<?= SITE_URL ?>/assets/images/gallery/gallery-7.jpg" alt="Techno Coderz Mohali campus" loading="lazy"></span>
                <span class="tcn-acard-title">Campus &amp; Facilities</span>
                <span class="tcn-acard-meta"><span class="tcn-acard-tag">Proof</span><span class="tcn-acard-sub">Mohali campus</span></span>
              </a>
              <a class="tcn-acard" href="founder.php">
                <span class="tcn-acard-img"><img src="<?= SITE_URL ?>/assets/images/team/rakesh.jpg" alt="Techno Coderz founder and team" loading="lazy"></span>
                <span class="tcn-acard-title">Founder &amp; Team</span>
                <span class="tcn-acard-meta"><span class="tcn-acard-tag">Profile</span><span class="tcn-acard-sub">Rakesh Raai</span></span>
              </a>
            </div>
          </div>
          <div class="tcn-about-foot">
            <p>Since 2016 &mdash; 450+ hiring partners, 15,000+ students trained, one method that works.</p>
            <a href="contact.php">Talk to a counsellor <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </li>

      <li class="tcn-has-mega">
        <a class="tcn-link tcn-underline" id="tcnMegaTrigger" href="courses.php" role="button" aria-haspopup="true" aria-expanded="false">Courses <i class="bi bi-chevron-down tcn-caret"></i></a>
        <div class="tcn-mega" id="tcnMega">
          <div class="tcn-mega-grid">
            <?php foreach ($__groupOrder as $__gname): if (empty($__courseGroups[$__gname])) continue; ?>
            <div>
              <h5><?= e($__gname) ?></h5>
              <?php foreach ($__courseGroups[$__gname] as $__c): ?>
              <a href="<?= e(coursePageUrl($__c['slug'] ?? slugify($__c['title']))) ?>"><?= e($__c['title']) ?><?php if (!empty($__c['trending'])): ?> <span class="tcn-badge">Trending</span><?php endif; ?></a>
              <?php endforeach; ?>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </li>

      <li class="tcn-has-dropdown">
        <a class="tcn-link tcn-underline<?= $tcNav('training') ?>" href="industrial-training.php">Internship &amp; Training <i class="bi bi-chevron-down tcn-caret"></i></a>
        <ul class="tcn-submenu">
          <li><a href="industrial-training.php">Industrial Training <span class="tcn-badge">Trending</span></a></li>
          <li><a href="industrial-training-45-days.php">45 Days Training <span class="tcn-badge">Trending</span></a></li>
          <li><a href="industrial-training-6-months.php">6 Months Training</a></li>
          <li><a href="industrial-training-6-weeks.php">6 Weeks Training <span class="tcn-badge">Trending</span></a></li>
          <li><a href="php-training.php">PHP Training</a></li>
          <li><a href="django-training.php">Django Training</a></li>
          <li><a href="seo-training.php">SEO Training</a></li>
          <li><a href="react-training.php">React Training</a></li>
        </ul>
      </li>

      <li class="tcn-has-mega">
        <a class="tcn-link tcn-underline" href="after-12th-courses.php" role="button">After 12<sup>th</sup> Courses <i class="bi bi-chevron-down tcn-caret"></i></a>
        <div class="tcn-mega tcn-mega--after12">
          <div class="tcn-a12-grid">
            <div class="tcn-a12-col">
              <span class="tcn-a12-num">01</span>
              <h4 class="tcn-a12-title">After 12th 6-Month Courses</h4>
              <p class="tcn-a12-sub">One subject, one term, one live project</p>
              <div class="tcn-a12-rule"></div>
              <ul class="tcn-a12-list">
                <?php foreach ($__after12['6 Months Courses'] as $__l): ?>
                <li><a href="<?= e($__l['u']) ?>"><?= e($__l['t']) ?></a></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <div class="tcn-a12-col">
              <span class="tcn-a12-num">02</span>
              <h4 class="tcn-a12-title">After 12th 1-Year Courses</h4>
              <p class="tcn-a12-sub">Half a year, finishing with a portfolio</p>
              <div class="tcn-a12-rule"></div>
              <ul class="tcn-a12-list">
                <?php foreach ($__after12['1 year Courses'] as $__l): ?>
                <li><a href="<?= e($__l['u']) ?>"><?= e($__l['t']) ?></a></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <div class="tcn-a12-col">
              <span class="tcn-a12-num">03</span>
              <h4 class="tcn-a12-title">Civil / Architecture / Mechanical</h4>
              <p class="tcn-a12-sub">The longest track, with placement preparation</p>
              <div class="tcn-a12-rule"></div>
              <ul class="tcn-a12-list">
                <?php foreach ($__after12['Civil / Architecture / Mechanical'] as $__l): ?>
                <li><a href="<?= e($__l['u']) ?>"><?= e($__l['t']) ?></a></li>
                <?php endforeach; ?>
              </ul>
              <h5 class="tcn-a12-mini">Quick Links</h5>
              <ul class="tcn-a12-list">
                <?php foreach ($__after12['Quick Links'] as $__l): ?>
                <li><a href="<?= e($__l['u']) ?>"><?= e($__l['t']) ?></a></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
          <div class="tcn-a12-foot">
            <p>Not sure where to start? A counsellor maps your stream and marks to a track in ten minutes.</p>
            <a href="after-12th-courses.php">Browse After 12th courses <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </li>

      <li class="tcn-has-mega">
        <a class="tcn-link tcn-underline" href="projects.php" role="button" aria-haspopup="true" aria-expanded="false">See More <i class="bi bi-chevron-down tcn-caret"></i></a>
        <div class="tcn-mega tcn-mega--more">
          <div class="tcn-more-grid">
            <div class="tcn-more-col">
              <span class="tcn-more-num">01</span>
              <h4 class="tcn-more-title">Learn &amp; Explore</h4>
              <p class="tcn-more-sub">Student work, services, guides and answers to help you pick a track.</p>
              <div class="tcn-more-rule"></div>
              <ul class="tcn-more-list">
                <li><a href="projects.php">Student Projects</a></li>
                <li><a href="services.php">Our Services</a></li>
                <li><a href="blog.php">Tech Blog</a></li>
                <li><a href="faq.php">FAQs</a></li>
              </ul>
            </div>
            <div class="tcn-more-col">
              <span class="tcn-more-num">02</span>
              <h4 class="tcn-more-title">Career &amp; Support</h4>
              <p class="tcn-more-sub">Placement help, campus details and the fastest ways to reach us.</p>
              <div class="tcn-more-rule"></div>
              <ul class="tcn-more-list">
                <li><a href="career.php">Placements &amp; Jobs</a></li>
                <li><a href="placement-cell.php">Placement Cell</a></li>
                <li><a href="franchise.php">Franchise</a></li>
                <li><a href="brochure.php">Download Brochure</a></li>
              </ul>
              <h5 class="tcn-more-mini">About Us</h5>
              <ul class="tcn-more-list">
                <li><a href="about.php">About Techno Coderz</a></li>
                <li><a href="mission-vision.php">Mission &amp; Vision</a></li>
                <li><a href="founder.php">Founder &amp; Team</a></li>
              </ul>
            </div>
            <a class="tcn-more-feature" href="contact.php">
              <span class="tcn-more-feature-img"><img src="<?= SITE_URL ?>/assets/images/institute/success-1.jpg" alt="Talk to a Techno Coderz counsellor" loading="lazy"></span>
              <span class="tcn-more-feature-body">
                <span class="tcn-more-feature-tag">Popular</span>
                <span class="tcn-more-feature-title">Not sure where to start?</span>
                <span class="tcn-more-feature-text">Tell us your background and we will point you at the right track.</span>
                <span class="tcn-more-feature-cta">Talk to a counsellor <i class="bi bi-arrow-right"></i></span>
              </span>
            </a>
          </div>
          <div class="tcn-more-foot">
            <p>Explore the Techno Coderz campus, student work and placement record.</p>
            <a href="about.php">Explore more <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </li>

      <li><a class="tcn-link tcn-underline<?= $tcNav('contact') ?>" href="contact.php">Contact</a></li>
    </ul>

    <div class="tcn-actions">
      <button type="button" class="tcn-btn tcn-enquire" data-open-demo>Book Demo</button>
      <button id="tcnMobileToggle" class="tcn-mobile-toggle" aria-label="Open menu"><i class="bi bi-list"></i></button>
    </div>
  </div>
</header>

<!-- ================= MOBILE MENU ================= -->
<div id="tcnMobileOverlay" class="tcn-mobile-overlay"></div>
<aside id="tcnMobile" class="tcn-mobile" aria-hidden="true">
  <div class="tcn-mobile-head">
    <img src="<?= SITE_URL ?>/assets/images/image.png" alt="Techno Coderz">
    <button id="tcnMobileClose" class="tcn-mobile-close" aria-label="Close menu"><i class="bi bi-x-lg"></i></button>
  </div>
  <nav>
    <div class="tcn-mlinks">
      <a href="index.php"><i class="bi bi-house"></i> Home</a>
    </div>

    <button class="tcn-accord-btn" data-target="tcn-m-about">
      <span><i class="bi bi-info-circle"></i> About</span>
      <i class="bi bi-chevron-down tcn-accord-icon"></i>
    </button>
    <div id="tcn-m-about" class="tcn-accord-panel">
      <div class="tcn-accord-inner">
        <a class="tcn-accord-link" href="about.php">About Techno Coderz</a>
        <a class="tcn-accord-link" href="mission-vision.php">Mission &amp; Vision</a>
        <a class="tcn-accord-link" href="about.php#campus">Campus &amp; Facilities</a>
        <a class="tcn-accord-link" href="founder.php">Founder &amp; Team</a>
      </div>
    </div>

    <button class="tcn-accord-btn" data-target="tcn-m-courses">
      <span><i class="bi bi-mortarboard"></i> Courses</span>
      <i class="bi bi-chevron-down tcn-accord-icon"></i>
    </button>
    <div id="tcn-m-courses" class="tcn-accord-panel">
      <div class="tcn-accord-inner">
        <?php foreach ($__groupOrder as $__gname): if (empty($__courseGroups[$__gname])) continue; ?>
        <div class="tcn-accord-title"><?= e($__gname) ?></div>
        <?php foreach ($__courseGroups[$__gname] as $__c): ?>
        <a class="tcn-accord-link" href="<?= e(coursePageUrl($__c['slug'] ?? slugify($__c['title']))) ?>"><?= e($__c['title']) ?></a>
        <?php endforeach; ?>
        <?php endforeach; ?>
        <div class="tcn-accord-title">Quick Links</div>
        <a class="tcn-accord-link" href="courses.php">All Courses</a>
        <a class="tcn-accord-link" href="projects.php">Projects</a>
        <a class="tcn-accord-link" href="services.php">Services</a>
      </div>
    </div>

    <button class="tcn-accord-btn" data-target="tcn-m-training">
      <span><i class="bi bi-laptop"></i> Internship &amp; Training</span>
      <i class="bi bi-chevron-down tcn-accord-icon"></i>
    </button>
    <div id="tcn-m-training" class="tcn-accord-panel">
      <div class="tcn-accord-inner">
        <a class="tcn-accord-link" href="industrial-training.php">Industrial Training</a>
        <a class="tcn-accord-link" href="industrial-training-45-days.php">45 Days Training</a>
        <a class="tcn-accord-link" href="industrial-training-6-months.php">6 Months Training</a>
        <a class="tcn-accord-link" href="industrial-training-6-weeks.php">6 Weeks Training</a>
        <a class="tcn-accord-link" href="php-training.php">PHP Training</a>
        <a class="tcn-accord-link" href="django-training.php">Django Training</a>
        <a class="tcn-accord-link" href="seo-training.php">SEO Training</a>
        <a class="tcn-accord-link" href="react-training.php">React Training</a>
      </div>
    </div>

    <button class="tcn-accord-btn" data-target="tcn-m-after12">
      <span><i class="bi bi-mortarboard"></i> After 12<sup>th</sup> Courses</span>
      <i class="bi bi-chevron-down tcn-accord-icon"></i>
    </button>
    <div id="tcn-m-after12" class="tcn-accord-panel">
      <div class="tcn-accord-inner">
        <?php foreach ($__after12 as $__title => $__links): ?>
        <div class="tcn-accord-title"><?= e($__title) ?></div>
        <?php foreach ($__links as $__l): ?>
        <a class="tcn-accord-link" href="<?= e($__l['u']) ?>"><?= e($__l['t']) ?></a>
        <?php endforeach; ?>
        <?php endforeach; ?>
      </div>
    </div>

    <button class="tcn-accord-btn" data-target="tcn-m-more">
      <span><i class="bi bi-three-dots"></i> See More</span>
      <i class="bi bi-chevron-down tcn-accord-icon"></i>
    </button>
    <div id="tcn-m-more" class="tcn-accord-panel">
      <div class="tcn-accord-inner">
        <div class="tcn-accord-title">Learn &amp; Explore</div>
        <a class="tcn-accord-link" href="projects.php">Student Projects</a>
        <a class="tcn-accord-link" href="services.php">Our Services</a>
        <a class="tcn-accord-link" href="blog.php">Tech Blog</a>
        <a class="tcn-accord-link" href="faq.php">FAQs</a>
        <div class="tcn-accord-title">Career &amp; Support</div>
        <a class="tcn-accord-link" href="career.php">Placements &amp; Jobs</a>
        <a class="tcn-accord-link" href="placement-cell.php">Placement Cell</a>
        <a class="tcn-accord-link" href="franchise.php">Franchise</a>
        <a class="tcn-accord-link" href="brochure.php">Download Brochure</a>
        <div class="tcn-accord-title">About Us</div>
        <a class="tcn-accord-link" href="about.php">About Techno Coderz</a>
        <a class="tcn-accord-link" href="mission-vision.php">Mission &amp; Vision</a>
        <a class="tcn-accord-link" href="founder.php">Founder &amp; Team</a>
      </div>
    </div>

    <div class="tcn-mlinks">
      <a href="contact.php"><i class="bi bi-telephone"></i> Contact</a>
    </div>

    <div class="tcn-mobile-cta">
      <button type="button" class="tcn-btn tcn-enquire" data-open-demo>Book Demo</button>
      <a href="contact.php" class="tcn-btn tcn-enquire-alt">Enquire Now</a>
    </div>
  </nav>
</aside>

<style>
/* ===== TechnoCoderz Navbar (techcadd layout, orange theme) ===== */
.tcn-topbar {
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
  color: #fff;
  font-size: 14px;
  position: relative;
  z-index: 1001;
}
.tcn-topbar-inner {
  max-width: 1400px; margin: 0 auto; padding: 10px 20px;
  display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;
}
.tcn-topbar-left a.tcn-pill {
  background: rgba(255,255,255,.18); color: #fff; text-decoration: none;
  padding: 8px 14px; border-radius: 999px; font-weight: 700; transition: .25s;
  display: inline-flex; align-items: center; gap: 8px;
}
.tcn-topbar-left a.tcn-pill:hover { transform: translateY(-1px); background: rgba(255,255,255,.28); }
.tcn-topbar-right { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; }
.tcn-topbar-right > a {
  color: rgba(255,255,255,.92); text-decoration: none; padding: 6px 10px; border-radius: 8px;
  transition: .25s; display: flex; align-items: center; gap: 8px;
}
.tcn-topbar-right > a:hover { background: rgba(255,255,255,.15); color: #fff; }
.tcn-social { display: flex; gap: 8px; }
.tcn-social a {
  width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center;
  justify-content: center; color: #fff; text-decoration: none; transition: .25s; font-size: 14px;
}
.tcn-social a.tcn-fb { background: #1877f2; }
.tcn-social a.tcn-ig { background: linear-gradient(45deg,#f58529,#dd2a7b,#8134af,#515bd4); }
.tcn-social a.tcn-li { background: #0a66c2; }
.tcn-social a.tcn-yt { background: #ff0000; }
.tcn-social a.tcn-tw { background: #111; }
.tcn-social a.tcn-wa { background: #25d366; }
.tcn-social a:hover { transform: translateY(-2px); }

.tcn-header {
  position: sticky; top: 0; z-index: 1000;
  background: rgba(255,255,255,.96); backdrop-filter: blur(20px);
  border-bottom: 1px solid rgba(226,232,240,.8); box-shadow: 0 2px 12px rgba(0,0,0,.06);
}
.tcn-header.scrolled { box-shadow: 0 6px 22px rgba(15,23,42,.1); }
.tcn-header-inner {
  max-width: 1400px; margin: 0 auto; padding: 14px 20px;
  display: flex; align-items: center; justify-content: space-between; gap: 20px;
  position: relative;
}
.tcn-logo { flex-shrink: 0; }
.tcn-logo img { height: 52px; display: block; transition: .25s; }
.tcn-logo:hover img { transform: scale(1.03); }

.tcn-nav {
  display: flex; align-items: center; gap: 28px; flex: 1; justify-content: center;
  margin: 0 20px; padding: 0;
}
.tcn-nav > li { list-style: none; position: relative; }
.tcn-nav > li.tcn-has-mega { position: static; }
.tcn-link {
  color: #0F172A; text-decoration: none; font-weight: 700; font-size: 15px;
  padding: 12px 8px; display: flex; align-items: center; gap: 6px; transition: .25s; white-space: nowrap;
}
.tcn-link:hover, .tcn-link.active { color: var(--primary); }
.tcn-caret { font-size: 11px; transition: transform .25s; }
.tcn-has-dropdown:hover .tcn-caret, .tcn-has-mega:hover .tcn-caret, .tcn-has-mega.open .tcn-caret { transform: rotate(180deg); }
.tcn-underline::after {
  content: ""; position: absolute; left: 0; bottom: 4px; height: 3px; width: 0;
  background: linear-gradient(135deg, var(--primary), var(--primary-dark));
  border-radius: 2px; transition: .25s;
}
li:hover > .tcn-underline::after, .tcn-link.active.tcn-underline::after { width: 100%; }

.tcn-submenu {
  position: absolute; top: 100%; left: 0; min-width: 250px; background: #fff;
  border: 1px solid rgba(226,232,240,.9); border-radius: 14px; padding: 12px;
  box-shadow: 0 16px 40px rgba(15,23,42,.1); opacity: 0; visibility: hidden;
  transform: translateY(10px); transition: .25s; z-index: 30; margin: 0;
}
.tcn-submenu li { list-style: none; }
.tcn-submenu a {
  display: block; text-decoration: none; color: #64748b; font-weight: 600;
  padding: 10px 12px; border-radius: 10px; transition: .25s;
}
.tcn-submenu a:hover { color: var(--primary); background: rgba(255,107,0,.06); padding-left: 16px; }
.tcn-has-dropdown:hover > .tcn-submenu { opacity: 1; visibility: visible; transform: translateY(0); }

.tcn-mega {
  position: absolute; top: 100%; left: 50%; transform: translate(-50%,12px) scale(.98);
  width: min(1080px, 96vw); background: #fff; border: 1px solid rgba(226,232,240,.9);
  border-radius: 16px; padding: 26px 28px; box-shadow: 0 24px 60px rgba(15,23,42,.16);
  opacity: 0; visibility: hidden; transform-origin: top center; transition: .28s ease; z-index: 30;
}
.tcn-has-mega:hover > .tcn-mega,
.tcn-has-mega.open > .tcn-mega,
.tcn-mega:hover { opacity: 1; visibility: visible; transform: translate(-50%,0) scale(1); }
.tcn-mega-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 28px; }
.tcn-mega-grid > div:not(:last-child) { border-right: 1px solid #eef2f7; padding-right: 24px; }
.tcn-mega h5 {
  font-size: 12px; text-transform: uppercase; letter-spacing: .6px; color: var(--primary);
  margin: 0 0 14px; font-weight: 800; position: relative; padding-bottom: 8px;
}
.tcn-mega h5::after {
  content: ""; position: absolute; left: 0; bottom: 0; width: 26px; height: 3px;
  border-radius: 3px; background: linear-gradient(135deg, var(--primary), var(--primary-dark));
}
.tcn-mega a {
  display: flex; align-items: center; gap: 8px; color: #4A5568; text-decoration: none;
  padding: 9px 12px; margin: 0 -12px; border-radius: 8px; font-weight: 600;
  font-size: 14px; cursor: pointer; transition: color .22s, background .22s, transform .22s;
}
.tcn-mega a:hover, .tcn-mega a:focus-visible {
  color: var(--primary); background: var(--primary-soft); transform: translateX(4px); outline: none;
}
.tcn-badge {
  background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: #fff;
  font-size: 10px; padding: 2px 8px; border-radius: 999px; font-weight: 700;
  letter-spacing: .3px; box-shadow: 0 4px 10px rgba(255,107,0,.28);
}

/* About mega-menu (techcadd layout, orange theme) */
.tcn-mega--about {
  padding: 0; overflow: hidden; width: min(1180px, 96vw);
  border-radius: 22px; box-shadow: 0 30px 80px rgba(15,23,42,.18);
}
.tcn-about-grid {
  display: grid; grid-template-columns: minmax(0,16rem) 1fr; gap: 34px; padding: 30px 32px;
}
.tcn-about-links { border-right: 1px solid #eef2f7; padding-right: 30px; display: flex; flex-direction: column; }
.tcn-about-link {
  display: block; padding: 10px 0; font-weight: 700; color: #0F172A;
  text-decoration: none; font-size: 15px; transition: color .2s, transform .2s;
}
.tcn-about-link:hover { color: var(--primary); transform: translateX(4px); }
.tcn-about-cta {
  margin-top: 22px; display: inline-flex; align-items: center; gap: 8px;
  color: var(--primary); font-weight: 700; font-size: 14px; text-decoration: none; transition: gap .25s;
}
.tcn-about-cta:hover { gap: 13px; }
.tcn-about-cards { display: grid; grid-template-columns: repeat(4,1fr); gap: 18px; }
.tcn-acard { display: block; text-decoration: none; }
.tcn-acard-img {
  position: relative; display: block; aspect-ratio: 4 / 3; overflow: hidden;
  border-radius: 14px; background: #f1f5f9;
}
.tcn-acard-img img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .5s; }
.tcn-acard:hover .tcn-acard-img img { transform: scale(1.06); }
.tcn-acard-title {
  display: block; margin-top: 12px; font-weight: 800; color: #0F172A; font-size: 15px;
  line-height: 1.3; transition: color .2s;
}
.tcn-acard:hover .tcn-acard-title { color: var(--primary); }
.tcn-acard-meta { display: flex; align-items: center; gap: 10px; margin-top: 8px; }
.tcn-acard-tag {
  background: var(--primary-soft); color: var(--primary); font-size: 10px; font-weight: 800;
  text-transform: uppercase; letter-spacing: .5px; padding: 4px 8px; border-radius: 6px; line-height: 1;
}
.tcn-acard-sub { font-size: 11px; text-transform: uppercase; letter-spacing: .1em; color: #94a3b8; }
/* Popup cards are <a> inside .tcn-mega; the generic .tcn-mega a flex rule must not style them */
.tcn-mega .tcn-acard {
  display: block; padding: 0; margin: 0; border-radius: 0; gap: 0;
  font-size: inherit; color: inherit; background: none; transform: none;
}
.tcn-mega .tcn-acard:hover,
.tcn-mega .tcn-acard:focus-visible {
  transform: none; background: none; color: inherit; padding: 0;
}
.tcn-mega .tcn-acard-img { width: 100%; }
.tcn-about-foot {
  display: flex; align-items: center; justify-content: space-between; gap: 24px;
  border-top: 1px solid #eef2f7; background: #f8fafc; padding: 16px 32px;
}
.tcn-about-foot p { margin: 0; color: #64748b; font-size: 14px; }
.tcn-about-foot a {
  color: var(--primary); font-weight: 700; font-size: 14px; text-decoration: none;
  display: inline-flex; align-items: center; gap: 8px; white-space: nowrap; transition: gap .25s;
}
.tcn-about-foot a:hover { gap: 13px; }
@media (max-width: 1399.98px) {
  .tcn-about-grid { gap: 26px; padding: 26px 26px; grid-template-columns: minmax(0,14rem) 1fr; }
  .tcn-about-cards { gap: 14px; }
}
/* After 12th mega-menu (techcadd layout, orange theme) */
.tcn-mega--after12 { width: min(1240px, 96vw); padding: 0; overflow: hidden; border-radius: 22px; }
.tcn-a12-grid {
  display: grid; grid-template-columns: repeat(3, 1fr); gap: 34px;
  padding: 32px 36px; align-items: start;
}
.tcn-a12-num {
  display: block; font-size: 12px; font-weight: 700; letter-spacing: .08em;
  color: #94a3b8;
}
.tcn-a12-title {
  margin: 6px 0 0; font-size: 19px; font-weight: 800; color: #0F172A; line-height: 1.3;
}
.tcn-a12-sub { margin: 8px 0 0; font-size: 13px; color: #64748b; line-height: 1.5; }
.tcn-a12-rule {
  height: 1px; background: #e8edf5; margin: 18px 0 14px;
}
.tcn-a12-list { list-style: none; margin: 0; padding: 0; }
.tcn-a12-list li + li { margin-top: 2px; }
.tcn-a12-list a {
  display: block; color: #4A5568; text-decoration: none; font-weight: 600;
  font-size: 14px; line-height: 1.45; padding: 5px 10px; margin: 0 -10px;
  border-radius: 8px; transition: color .2s, background .2s, transform .2s;
}
.tcn-a12-list a:hover, .tcn-a12-list a:focus-visible {
  color: var(--primary); background: var(--primary-soft); transform: translateX(4px); outline: none;
}
.tcn-a12-mini {
  margin: 22px 0 10px; font-size: 12px; text-transform: uppercase; letter-spacing: .6px;
  color: var(--primary); font-weight: 800; position: relative; padding-bottom: 8px;
}
.tcn-a12-mini::after {
  content: ""; position: absolute; left: 0; bottom: 0; width: 26px; height: 3px;
  border-radius: 3px; background: linear-gradient(135deg, var(--primary), var(--primary-dark));
}
.tcn-a12-foot {
  display: flex; align-items: center; justify-content: space-between; gap: 24px;
  border-top: 1px solid #eef2f7; background: #f8fafc; padding: 16px 36px;
}
.tcn-a12-foot p { margin: 0; color: #64748b; font-size: 14px; }
.tcn-a12-foot a {
  color: var(--primary); font-weight: 700; font-size: 14px; text-decoration: none;
  display: inline-flex; align-items: center; gap: 8px; white-space: nowrap; transition: gap .25s;
}
.tcn-a12-foot a:hover { gap: 13px; }
@media (max-width: 1399.98px) {
  .tcn-a12-grid { gap: 24px; padding: 26px 28px; }
}
/* See More mega-menu (techcadd layout, Techno Coderz orange theme + data) */
.tcn-mega--more { width: min(1080px, 96vw); padding: 0; overflow: hidden; border-radius: 22px; }
.tcn-more-grid {
  display: grid; grid-template-columns: 1fr 1fr 1.2fr; gap: 34px;
  padding: 32px 36px; align-items: start;
}
.tcn-more-col { min-width: 0; }
.tcn-more-num {
  display: block; font-size: 12px; font-weight: 700; letter-spacing: .08em; color: #94a3b8;
}
.tcn-more-title { margin: 6px 0 0; font-size: 19px; font-weight: 800; color: #0F172A; line-height: 1.3; }
.tcn-more-sub { margin: 8px 0 0; font-size: 13px; color: #64748b; line-height: 1.5; }
.tcn-more-rule { height: 1px; background: #e8edf5; margin: 18px 0 14px; }
.tcn-more-list { list-style: none; margin: 0; padding: 0; }
.tcn-more-list li + li { margin-top: 2px; }
.tcn-more-list a {
  display: block; color: #4A5568; text-decoration: none; font-weight: 600; font-size: 14px;
  line-height: 1.45; padding: 6px 10px; margin: 0 -10px; border-radius: 8px;
  transition: color .2s, background .2s, transform .2s;
}
.tcn-more-list a:hover, .tcn-more-list a:focus-visible {
  color: var(--primary); background: var(--primary-soft); transform: translateX(4px); outline: none;
}
.tcn-more-mini {
  margin: 22px 0 10px; font-size: 12px; text-transform: uppercase; letter-spacing: .6px;
  color: var(--primary); font-weight: 800; position: relative; padding-bottom: 8px;
}
.tcn-more-mini::after {
  content: ""; position: absolute; left: 0; bottom: 0; width: 26px; height: 3px;
  border-radius: 3px; background: linear-gradient(135deg, var(--primary), var(--primary-dark));
}
/* Featured promo card (an <a> inside .tcn-mega, so neutralise the generic link rule) */
.tcn-mega .tcn-more-feature {
  display: block; padding: 0; margin: 0; gap: 0; border: 1px solid #eef2f7; border-radius: 16px;
  overflow: hidden; background: #fff; font-size: inherit; color: inherit;
  transition: transform .25s, box-shadow .25s, border-color .25s;
}
.tcn-mega .tcn-more-feature:hover,
.tcn-mega .tcn-more-feature:focus-visible {
  transform: translateY(-3px); box-shadow: 0 18px 40px rgba(15,23,42,.12);
  border-color: var(--primary-soft-2, #ffd0ab); background: #fff; color: inherit;
}
.tcn-more-feature-img { display: block; aspect-ratio: 16 / 9; overflow: hidden; background: #f1f5f9; }
.tcn-more-feature-img img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .5s; }
.tcn-mega .tcn-more-feature:hover .tcn-more-feature-img img { transform: scale(1.05); }
.tcn-more-feature-body { display: block; padding: 18px 20px 20px; }
.tcn-more-feature-tag {
  display: inline-block; background: var(--primary-soft); color: var(--primary);
  font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .5px;
  padding: 4px 9px; border-radius: 999px; line-height: 1;
}
.tcn-more-feature-title { display: block; margin-top: 10px; font-size: 16px; font-weight: 800; color: #0F172A; }
.tcn-more-feature-text { display: block; margin-top: 6px; font-size: 13px; color: #64748b; line-height: 1.5; }
.tcn-more-feature-cta {
  display: inline-flex; align-items: center; gap: 8px; margin-top: 12px;
  color: var(--primary); font-weight: 700; font-size: 13px; transition: gap .25s;
}
.tcn-mega .tcn-more-feature:hover .tcn-more-feature-cta { gap: 13px; }
.tcn-more-foot {
  display: flex; align-items: center; justify-content: space-between; gap: 24px;
  border-top: 1px solid #eef2f7; background: #f8fafc; padding: 16px 36px;
}
.tcn-more-foot p { margin: 0; color: #64748b; font-size: 14px; }
.tcn-more-foot a {
  color: var(--primary); font-weight: 700; font-size: 14px; text-decoration: none;
  display: inline-flex; align-items: center; gap: 8px; white-space: nowrap; transition: gap .25s;
}
.tcn-more-foot a:hover { gap: 13px; }
@media (max-width: 1399.98px) {
  .tcn-more-grid { gap: 24px; padding: 26px 28px; grid-template-columns: 1fr 1fr 1.1fr; }
}

.tcn-actions { display: flex; align-items: center; gap: 12px; flex-shrink: 0; justify-content: flex-end; }
.tcn-btn {
  display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 10px;
  font-weight: 700; font-size: 15px; text-decoration: none; transition: .25s; white-space: nowrap;
}
.tcn-enquire {
  background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: #fff;
  box-shadow: 0 8px 20px rgba(255,107,0,.25); border: none; cursor: pointer; font-family: inherit;
}
.tcn-enquire:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(255,107,0,.34); color: #fff; }
.tcn-enquire-alt {
  background: #fff; color: var(--primary); border: 2px solid var(--primary);
  box-shadow: none;
}
.tcn-enquire-alt:hover { background: var(--primary); color: #fff; transform: translateY(-2px); }
.tcn-mobile-toggle {
  display: none; background: var(--primary); color: #fff; border: none;
  width: 44px; height: 44px; border-radius: 10px; font-size: 22px;
  align-items: center; justify-content: center; cursor: pointer;
}

/* Off-canvas mobile menu */
.tcn-mobile-overlay {
  position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 1998;
  display: none; opacity: 0; transition: opacity .3s;
}
.tcn-mobile-overlay.show { display: block; opacity: 1; }
.tcn-mobile {
  position: fixed; top: 0; bottom: 0; left: 0; width: min(88vw, 380px); background: #fff;
  z-index: 1999; transform: translateX(-100%); transition: transform .35s cubic-bezier(.4,0,.2,1);
  box-shadow: 12px 0 30px rgba(0,0,0,.15); overflow: auto; -webkit-overflow-scrolling: touch;
}
.tcn-mobile.open { transform: translateX(0); }
.tcn-mobile-head {
  display: flex; align-items: center; justify-content: space-between;
  padding: 16px; border-bottom: 1px solid #e2e8f0;
}
.tcn-mobile-head img { height: 40px; }
.tcn-mobile-close {
  background: rgba(255,107,0,.12); color: var(--primary); border: none;
  width: 40px; height: 40px; border-radius: 50%; font-size: 18px; cursor: pointer;
}
.tcn-mlinks > a, .tcn-accord-btn {
  display: flex; align-items: center; gap: 12px; width: 100%; text-decoration: none;
  color: #0F172A; font-weight: 700; padding: 15px 18px; border: none;
  border-bottom: 1px solid #f1f5f9; font-size: 15px; background: none; cursor: pointer; text-align: left;
}
.tcn-mlinks > a i, .tcn-accord-btn span i { color: var(--primary); font-size: 17px; width: 20px; text-align: center; }
.tcn-accord-btn { justify-content: space-between; }
.tcn-accord-btn span { display: flex; align-items: center; gap: 12px; }
.tcn-accord-icon { color: #64748b; transition: .25s; }
.tcn-accord-btn.open .tcn-accord-icon { transform: rotate(180deg); }
.tcn-accord-panel { height: 0; overflow: hidden; transition: height .3s ease; background: #f8fafc; }
.tcn-accord-inner { padding: 10px 0 10px 18px; }
.tcn-accord-title { color: var(--primary); font-size: 13px; font-weight: 800; margin: 10px 0 6px; text-transform: uppercase; letter-spacing: .4px; }
.tcn-accord-link { display: block; padding: 8px 0; color: #64748b; text-decoration: none; font-weight: 600; }
.tcn-accord-link:hover { color: var(--primary); }
.tcn-mobile-cta { padding: 18px; display: flex; flex-direction: column; gap: 10px; }
.tcn-mobile-cta .tcn-btn { width: 100%; justify-content: center; }

@media (max-width: 1439.98px) {
  .tcn-nav { gap: 18px; margin: 0 12px; }
  .tcn-link { font-size: 14px; padding: 10px 6px; }
  .tcn-logo img { height: 48px; }
  .tcn-header-inner { gap: 14px; }
  .tcn-actions { gap: 8px; }
  .tcn-btn { padding: 11px 18px; font-size: 14px; }
}
@media (max-width: 1279.98px) {
  .tcn-nav { display: none; }
  .tcn-mobile-toggle { display: inline-flex; }
  .tcn-topbar { display: none; }
  .tcn-header-inner { padding: 12px 16px; gap: 16px; }
  .tcn-logo img { height: 44px; }
}
@media (max-width: 767.98px) {
  .tcn-actions .tcn-enquire { display: none; }
}
@media (max-width: 575.98px) {
  .tcn-logo img { height: 40px; }
}
</style>

<script>
(function () {
  var toggle  = document.getElementById('tcnMobileToggle');
  var mobile  = document.getElementById('tcnMobile');
  var overlay = document.getElementById('tcnMobileOverlay');
  var closeBtn = document.getElementById('tcnMobileClose');
  if (!mobile) return;

  function openMenu() {
    mobile.classList.add('open');
    overlay.classList.add('show');
    mobile.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }
  function closeMenu() {
    mobile.classList.remove('open');
    overlay.classList.remove('show');
    mobile.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }
  if (toggle) toggle.addEventListener('click', openMenu);
  if (closeBtn) closeBtn.addEventListener('click', closeMenu);
  if (overlay) overlay.addEventListener('click', closeMenu);

  document.querySelectorAll('.tcn-accord-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var panel = document.getElementById(btn.getAttribute('data-target'));
      if (!panel) return;
      if (btn.classList.contains('open')) {
        panel.style.height = panel.scrollHeight + 'px';
        requestAnimationFrame(function () { panel.style.height = '0px'; });
        btn.classList.remove('open');
      } else {
        panel.style.height = panel.scrollHeight + 'px';
        btn.classList.add('open');
        panel.addEventListener('transitionend', function handler() {
          panel.style.height = 'auto';
          panel.removeEventListener('transitionend', handler);
        });
      }
    });
  });

  /* ---- Mega-menus (Courses, About): hover (CSS) + click/keyboard toggle ---- */
  document.querySelectorAll('.tcn-has-mega').forEach(function (li) {
    var trigger = li.querySelector(':scope > a[aria-haspopup="true"]');
    if (!trigger) return;
    function setMega(open) {
      li.classList.toggle('open', open);
      trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
    }
    trigger.addEventListener('click', function (e) {
      e.preventDefault();
      setMega(!li.classList.contains('open'));
    });
    trigger.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') { setMega(false); trigger.blur(); }
    });
    document.addEventListener('click', function (e) {
      if (!li.contains(e.target)) setMega(false);
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') setMega(false);
    });
  });

  /* ---- "Book Demo" (techcadd-style navbar CTA) opens the demo popup ---- */
  document.addEventListener('click', function (e) {
    var trigger = e.target.closest('[data-open-demo]');
    if (!trigger) return;
    e.preventDefault();
    if (typeof window.openDemoPopup === 'function') {
      window.openDemoPopup();
    } else {
      window.location.href = 'contact.php';
    }
  });
})();
</script>
