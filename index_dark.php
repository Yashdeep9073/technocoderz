<?php 
// ============================================================ 
// Techno Coderz — Homepage 
// ============================================================ 
require_once __DIR__ . '/includes/functions.php'; 
 
$pageTitle       = 'Techno Coderz – Build Skills. Create Projects. Grow Your Tech Career.'; 
$pageDescription = 'Techno Coderz is a premier IT training institute and software development company in India. Learn Full Stack, PHP, Java, JavaScript, and more through industry-focused, project-based training.'; 
$currentPage     = 'home'; 
 
// Fetch dynamic data 
$pdo = getDB(); 
 
// Courses (max 6 for homepage) 
$courses = $pdo->query("SELECT * FROM courses WHERE status = 1 ORDER BY sort_order ASC, id ASC LIMIT 6")->fetchAll(); 
 
// Services (max 6) 
$services = $pdo->query("SELECT * FROM services WHERE status = 1 ORDER BY sort_order ASC LIMIT 6")->fetchAll(); 
 
// Projects (max 6) 
$projects = $pdo->query("SELECT * FROM projects WHERE status = 1 ORDER BY sort_order ASC LIMIT 6")->fetchAll(); 
 
// Testimonials 
$testimonials = $pdo->query("SELECT * FROM testimonials WHERE status = 1 ORDER BY id ASC")->fetchAll(); 
 
// Blogs (latest 3) 
$blogs = $pdo->query("SELECT * FROM blogs WHERE status = 1 ORDER BY created_at DESC LIMIT 3")->fetchAll(); 
 
// Fetch CSRF token for enquiry 
$csrf = generateCsrfToken(); 
 
require_once __DIR__ . '/includes/header.php'; 
require_once __DIR__ . '/includes/navbar.php'; 
?> 
<script>window.TC_BASE_URL = '<?= SITE_URL ?>';</script> 
 
<!-- ============================================================ --> 
<!--  HERO SECTION                                                  --> 
<!-- ============================================================ --> 
<section class="tc-hero" id="hero"> 
  <div class="container"> 
    <div class="row align-items-center g-5"> 
 
      <!-- Left: Content --> 
      <div class="col-lg-6 tc-hero-content"> 
        <div class="tc-hero-badge"> 
          <span class="pulse"></span> 
          IT Training &amp; Software Development Studio 
        </div> 
 
        <h1 class="tc-hero-title"> 
          Build Skills.<br> 
          Create <span class="highlight">Projects</span>.<br> 
          Grow Your <span class="highlight">Tech Career</span>. 
        </h1> 
 
        <p class="tc-hero-sub"> 
          From your first line of code to building real-world applications — Techno Coderz provides industry-focused training, mentorship, and hands-on project experience that employers actually want. 
        </p> 
 
        <!-- Typing --> 
        <div class="tc-hero-typing"> 
          <i class="bi bi-terminal-fill"></i> 
          <span class="label">Currently learning:</span> 
          <span id="tcTypingText"></span><span class="caret">|</span> 
        </div> 
 
        <div class="tc-hero-actions"> 
          <a href="<?= SITE_URL ?>/courses.php" class="tc-btn tc-btn-primary tc-btn-lg"> 
            <i class="bi bi-book-fill"></i> Explore Courses 
          </a> 
          <a href="<?= SITE_URL ?>/contact.php" class="tc-btn tc-btn-secondary tc-btn-lg"> 
            <i class="bi bi-chat-dots-fill"></i> Talk to a Counselor 
          </a> 
        </div> 
 
        <div class="tc-hero-trust"> 
          <span><i class="bi bi-check-circle-fill"></i> Placement support</span> 
          <span><i class="bi bi-check-circle-fill"></i> Real project work</span> 
          <span><i class="bi bi-check-circle-fill"></i> Completion certificate</span> 
        </div> 
      </div> 
 
      <!-- Right: Code Window Visual --> 
      <div class="col-lg-6 tc-hero-visual"> 
        <div class="tc-hero-visual-inner"> 
          <!-- Glow blob --> 
          <div class="tc-hero-glow"></div> 
 
          <!-- Code Window --> 
          <div class="tc-code-window"> 
            <div class="window-bar"> 
              <span class="dot dot-red"></span> 
              <span class="dot dot-yel"></span> 
              <span class="dot dot-grn"></span> 
              <span class="window-title">technocoderz/index.php</span> 
            </div> 
<pre><code><span class="code-c">// Welcome to Techno Coderz</span> 
<span class="code-k">class</span> <span class="code-f">TechnoCoderz</span> { 
 
  <span class="code-k">private</span> <span class="code-v">$mission</span> = <span class="code-s">'Build Tech Careers'</span>; 
  <span class="code-k">private</span> <span class="code-v">$stack</span>   = [<span class="code-s">'PHP'</span>, <span class="code-s">'Java'</span>, <span class="code-s">'JS'</span>]; 
 
  <span class="code-k">public function</span> <span class="code-f">train</span>(<span class="code-v">$student</span>) { 
    <span class="code-v">$student</span><span class="code-o">-&gt;</span><span class="code-f">learnSkills</span>(<span class="code-v">$this</span><span class="code-o">-&gt;</span><span class="code-v">stack</span>); 
    <span class="code-v">$student</span><span class="code-o">-&gt;</span><span class="code-f">buildProjects</span>(); 
    <span class="code-v">$student</span><span class="code-o">-&gt;</span><span class="code-f">getPlaced</span>(); <span class="code-c">// career support</span> 
    <span class="code-k">return</span> <span class="code-s">'Future Developer!'</span>; 
  } 
 
}</code></pre> 
          </div> 
 
          <!-- Floating Badges --> 
          <div class="tc-float-badge" style="top:-20px;right:-10px;animation-delay:0s;"> 
            <i class="bi bi-patch-check-fill" style="color:var(--tc-secondary)"></i> Certificate Included 
          </div> 
          <div class="tc-float-badge" style="bottom:20px;left:-20px;animation-delay:1.5s;"> 
            <i class="bi bi-people-fill" style="color:var(--tc-primary-light)"></i> 1200+ Alumni 
          </div> 
          <div class="tc-float-badge" style="bottom:-10px;right:60px;animation-delay:0.8s;font-size:0.7rem;"> 
            <i class="bi bi-award-fill" style="color:#f59e0b"></i> Placement Support 
          </div> 
        </div> 
      </div> 
 
    </div> 
  </div> 
</section> 
 
<style> 
@keyframes cursorBlink { 0%,100%{opacity:1} 50%{opacity:0} } 
.tc-hero-typing{display:flex;align-items:center;flex-wrap:wrap;gap:8px;margin:-16px 0 34px;font-size:0.92rem;color:var(--tc-text-muted)} 
.tc-hero-typing i{color:var(--tc-secondary)} 
.tc-hero-typing #tcTypingText{color:var(--tc-secondary);font-weight:600;min-width:250px;display:inline-block;font-family:'Space Grotesk',sans-serif} 
.tc-hero-typing .caret{color:var(--tc-primary);animation:cursorBlink 1s step-end infinite} 
.tc-hero-visual-inner{position:relative} 
.tc-hero-glow{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:350px;height:350px;background:radial-gradient(circle,rgba(108,63,245,0.18) 0%,transparent 70%);border-radius:50%;z-index:0;pointer-events:none} 
</style> 
 
<!-- ============================================================ --> 
<!-- STATS STRIP                                                    --> 
<!-- ============================================================ --> 
<div class="tc-stats-strip"> 
  <div class="container"> 
    <div class="row g-4 text-center"> 
      <div class="col-6 col-md-3 tc-stat-item reveal"> 
        <div class="tc-stat-num" data-count="1200" data-suffix="+">0+</div> 
        <div class="tc-stat-label">Students Trained</div> 
      </div> 
      <div class="col-6 col-md-3 tc-stat-item reveal"> 
        <div class="tc-stat-num" data-count="98" data-suffix="%">0%</div> 
        <div class="tc-stat-label">Placement Rate</div> 
      </div> 
      <div class="col-6 col-md-3 tc-stat-item reveal"> 
        <div class="tc-stat-num" data-count="60" data-suffix="+">0+</div> 
        <div class="tc-stat-label">Real Projects Built</div> 
      </div> 
      <div class="col-6 col-md-3 tc-stat-item reveal"> 
        <div class="tc-stat-num" data-count="25" data-suffix="+">0+</div> 
        <div class="tc-stat-label">Courses Available</div> 
      </div> 
    </div> 
  </div> 
</div> 
 
<!-- ============================================================ --> 
<!-- COURSES SECTION                                               --> 
<!-- ============================================================ --> 
<section class="tc-section" id="courses"> 
  <div class="container"> 
    <div class="tc-section-header text-center reveal"> 
      <div class="tc-badge"><i class="bi bi-book-fill"></i> Our Courses</div> 
      <h2 class="tc-section-title">Learn. Build. <span>Get Hired</span>.</h2> 
      <p class="tc-section-subtitle"> 
        Industry-aligned courses designed around real job requirements. Each course includes hands-on projects, doubt-clearing sessions, and placement support. 
      </p> 
    </div> 
 
    <div class="row g-4"> 
      <?php if ($courses): ?> 
        <?php foreach ($courses as $i => $course): ?> 
        <div class="col-lg-4 col-md-6 reveal" style="transition-delay:<?= ($i % 3) * 0.08 ?>s"> 
          <div class="tc-course-card"> 
            <div class="tc-course-img"> 
              <?php if ($course['image'] && file_exists(UPLOAD_DIR . 'courses/' . $course['image'])): ?> 
              <img src="<?= UPLOAD_URL ?>courses/<?= e($course['image']) ?>" alt="<?= e($course['title']) ?>" loading="lazy" style="width:100%;height:100%;object-fit:cover;"> 
              <?php else: ?> 
              <div class="tc-course-icon-wrap"> 
                <i class="<?= e($course['icon'] ?? 'bi bi-code-square') ?>"></i> 
              </div> 
              <?php endif; ?> 
              <span class="tc-course-badge"><?= e($course['level']) ?></span> 
            </div> 
            <div class="tc-course-body"> 
              <div class="tc-course-level"> 
                <i class="bi bi-mortarboard-fill"></i> <?= e($course['level']) ?> 
              </div> 
              <h3 class="tc-course-title"><?= e($course['title']) ?></h3> 
              <p class="tc-course-desc"><?= e($course['short_description']) ?></p> 
              <div class="tc-course-meta"> 
                <span><i class="bi bi-clock"></i> <?= e($course['duration']) ?></span> 
                <span><i class="bi bi-patch-check"></i> Certificate</span> 
              </div> 
              <div class="tc-course-actions"> 
                <a href="<?= SITE_URL ?>/course-details.php?slug=<?= urlencode($course['slug']) ?>" class="tc-btn tc-btn-secondary tc-btn-sm" style="justify-content:center"> 
                  <i class="bi bi-eye"></i> Details 
                </a> 
                <button onclick="openEnquiry('<?= e($course['title']) ?>')" class="tc-btn tc-btn-primary tc-btn-sm" style="justify-content:center"> 
                  <i class="bi bi-send-fill"></i> Enquire 
                </button> 
              </div> 
            </div> 
          </div> 
        </div> 
        <?php endforeach; ?> 
      <?php else: ?> 
        <div class="col-12 text-center py-5"> 
          <p style="color:var(--tc-text-muted);">Courses coming soon. Check back shortly!</p> 
        </div> 
      <?php endif; ?> 
    </div> 
 
    <div class="text-center mt-5 reveal"> 
      <a href="<?= SITE_URL ?>/courses.php" class="tc-btn tc-btn-primary tc-btn-lg"> 
        <i class="bi bi-grid-3x3-gap-fill"></i> View All Courses 
      </a> 
    </div> 
  </div> 
</section> 
 
<!-- ============================================================ --> 
<!-- ABOUT SECTION                                                  --> 
<!-- ============================================================ --> 
<section class="tc-section tc-section-dark" id="about"> 
  <div class="container"> 
    <div class="row align-items-center g-5"> 
 
      <!-- Left: Image --> 
      <div class="col-lg-5 reveal"> 
        <div class="tc-about-img-wrap"> 
          <div class="tc-panel" style="text-align:center;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:22px;min-height:380px;"> 
            <div style="font-size:4.5rem;line-height:1;">🚀</div> 
            <div style="font-family:'Space Grotesk',sans-serif;font-size:1.45rem;font-weight:800;color:#fff;">Since 2016</div> 
            <p style="font-size:0.9rem;color:var(--tc-text-muted);max-width:280px;line-height:1.7;margin:0;">Shaping the next generation of technology professionals through practical education and real-world experience.</p> 
            <div style="display:flex;gap:32px;text-align:center;"> 
              <div> 
                <div style="font-size:1.75rem;font-weight:900;font-family:'Space Grotesk',sans-serif;background:var(--tc-grad-primary);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">1200+</div> 
                <div style="font-size:0.72rem;color:var(--tc-text-muted);text-transform:uppercase;letter-spacing:0.8px;">Students</div> 
              </div> 
              <div> 
                <div style="font-size:1.75rem;font-weight:900;font-family:'Space Grotesk',sans-serif;background:var(--tc-grad-primary);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">98%</div> 
                <div style="font-size:0.72rem;color:var(--tc-text-muted);text-transform:uppercase;letter-spacing:0.8px;">Placement</div> 
              </div> 
              <div> 
                <div style="font-size:1.75rem;font-weight:900;font-family:'Space Grotesk',sans-serif;background:var(--tc-grad-primary);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">60+</div> 
                <div style="font-size:0.72rem;color:var(--tc-text-muted);text-transform:uppercase;letter-spacing:0.8px;">Projects</div> 
              </div> 
            </div> 
          </div> 
        </div> 
      </div> 
 
      <!-- Right: Content --> 
      <div class="col-lg-7 reveal"> 
        <div class="tc-badge"><i class="bi bi-info-circle-fill"></i> Who We Are</div> 
        <h2 class="tc-section-title text-start"> 
          More Than a Training Center.<br>We Build <span>Tech Careers</span>. 
        </h2> 
        <p style="color:var(--tc-text-muted);font-size:0.95rem;line-height:1.8;margin-bottom:20px;"> 
          At Techno Coderz, we believe that great developers aren't just taught syntax — they're built through real practice, real projects, and real mentorship. Since 2016, we've been combining structured curriculum with hands-on project experience to create job-ready professionals. 
        </p> 
        <p style="color:var(--tc-text-muted);font-size:0.95rem;line-height:1.8;margin-bottom:28px;"> 
          We are a dual-mission organization: an IT training institute that prepares you for industry, and a software development company that builds actual products — giving our students real exposure to professional development environments. 
        </p> 
 
        <ul class="tc-about-list mb-4"> 
          <li>Practical, project-based curriculum built for industry needs</li> 
          <li>Learn from mentors with 5–10+ years of real industry experience</li> 
          <li>Build a portfolio of real projects during your training</li> 
          <li>Dedicated placement support and career guidance</li> 
          <li>Small batch sizes for personalized attention</li> 
        </ul> 
 
        <div class="d-flex flex-wrap gap-3"> 
          <a href="<?= SITE_URL ?>/about.php" class="tc-btn tc-btn-primary"> 
            <i class="bi bi-info-circle-fill"></i> Our Full Story 
          </a> 
          <a href="<?= SITE_URL ?>/courses.php" class="tc-btn tc-btn-secondary"> 
            <i class="bi bi-book-fill"></i> Browse Courses 
          </a> 
        </div> 
      </div> 
 
    </div> 
  </div> 
</section> 
 
<!-- ============================================================ --> 
<!-- WHY CHOOSE US                                                  --> 
<!-- ============================================================ --> 
<section class="tc-section" id="why-us"> 
  <div class="container"> 
    <div class="row align-items-center g-5"> 
 
      <div class="col-lg-5 reveal"> 
        <div class="tc-badge"><i class="bi bi-award-fill"></i> Why Techno Coderz</div> 
        <h2 class="tc-section-title text-start"> 
          What Makes Us <span>Different</span>? 
        </h2> 
        <p style="color:var(--tc-text-muted);font-size:0.95rem;line-height:1.8;margin-bottom:24px;"> 
          While other institutes focus on slides and theory, we put you in front of a keyboard from day one. Every concept is reinforced through code, projects, and real problem-solving. 
        </p> 
        <div style="display:flex;flex-direction:column;gap:16px;"> 
          <?php 
          $highlights = [ 
            ['icon' => 'bi bi-graph-up-arrow', 'title' => 'Proven Track Record', 'desc' => '98% placement rate with 1200+ alumni at top companies'], 
            ['icon' => 'bi bi-people-fill',     'title' => 'Expert Mentors',     'desc' => 'Learn from developers with 5–10+ years of industry experience'], 
            ['icon' => 'bi bi-laptop-fill',     'title' => 'Hands-On Labs',      'desc' => 'Fully equipped computer labs for practical sessions'], 
          ]; 
          foreach ($highlights as $h): 
          ?> 
          <div style="display:flex;align-items:center;gap:16px;background:var(--tc-dark-card);border:1px solid var(--tc-border-subtle);border-radius:var(--tc-radius);padding:16px 20px;"> 
            <div style="width:44px;height:44px;background:var(--tc-grad-card);border:1px solid var(--tc-border);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:var(--tc-primary-light);flex-shrink:0;"> 
              <i class="<?= $h['icon'] ?>"></i> 
            </div> 
            <div> 
              <div style="font-weight:700;font-size:0.92rem;color:#fff;margin-bottom:3px;"><?= $h['title'] ?></div> 
              <div style="font-size:0.82rem;color:var(--tc-text-muted);"><?= $h['desc'] ?></div> 
            </div> 
          </div> 
          <?php endforeach; ?> 
        </div> 
      </div> 
 
      <div class="col-lg-7 reveal"> 
        <div class="row g-3"> 
          <?php 
          $features = [ 
            ['icon' => 'bi bi-hammer',           'title' => 'Practical Training',   'desc' => 'Every class involves live coding, real examples, and working on actual project modules.'], 
            ['icon' => 'bi bi-folder2-open',      'title' => 'Real Project Portfolio','desc' => 'Graduate with complete, deployable projects to show employers.'], 
            ['icon' => 'bi bi-shield-lock-fill',  'title' => 'Industry Standards',   'desc' => 'We teach security, clean code practices, and professional development workflows.'], 
            ['icon' => 'bi bi-person-video3',     'title' => 'Personal Mentorship',  'desc' => 'Small batches ensure every student gets direct attention and feedback.'], 
            ['icon' => 'bi bi-briefcase-fill',    'title' => 'Career Guidance',      'desc' => 'Resume building, mock interviews, LinkedIn profile optimization, and job referrals.'], 
            ['icon' => 'bi bi-infinity',          'title' => 'Lifetime Support',     'desc' => 'Alumni get lifetime access to resources, recordings, and our student community.'], 
          ]; 
          foreach ($features as $i => $f): 
          ?> 
          <div class="col-md-6"> 
            <div class="tc-feature-card" style="transition-delay:<?= $i * 0.06 ?>s"> 
              <div class="tc-feature-icon"><i class="<?= $f['icon'] ?>"></i></div> 
              <div> 
                <h4 class="tc-feature-title"><?= $f['title'] ?></h4> 
                <p class="tc-feature-desc"><?= $f['desc'] ?></p> 
              </div> 
            </div> 
          </div> 
          <?php endforeach; ?> 
        </div> 
      </div> 
 
    </div> 
  </div> 
</section> 
 
<!-- ============================================================ --> 
<!-- TECHNOLOGY STACK SECTION                                       --> 
<!-- ============================================================ --> 
<section class="tc-section tc-section-dark" id="technologies"> 
  <div class="container"> 
    <div class="tc-section-header text-center reveal"> 
      <div class="tc-badge"><i class="bi bi-cpu-fill"></i> Technology Stack</div> 
      <h2 class="tc-section-title">Technologies You'll <span>Master</span></h2> 
      <p class="tc-section-subtitle"> 
        Our curriculum covers the most in-demand languages, frameworks, and tools used by top companies worldwide. 
      </p> 
    </div> 
 
    <div class="tc-tech-grid"> 
      <?php 
      $techs = [ 
        ['icon' => '☕', 'name' => 'Java',        'color' => '#f89820'], 
        ['icon' => '🐘', 'name' => 'PHP',         'color' => '#8892bf'], 
        ['icon' => '🔴', 'name' => 'Laravel',     'color' => '#ff2d20'], 
        ['icon' => '🌐', 'name' => 'HTML5',       'color' => '#e34f26'], 
        ['icon' => '🎨', 'name' => 'CSS3',        'color' => '#1572b6'], 
        ['icon' => '⚡', 'name' => 'JavaScript',  'color' => '#f0db4f'], 
        ['icon' => '🅱',  'name' => 'Bootstrap',  'color' => '#7952b3'], 
        ['icon' => '⚛',  'name' => 'React',       'color' => '#61dafb'], 
        ['icon' => '🗄',  'name' => 'MySQL',       'color' => '#00758f'], 
        ['icon' => '🐙', 'name' => 'Git',         'color' => '#f05032'], 
        ['icon' => '🐱', 'name' => 'GitHub',      'color' => '#ffffff'], 
        ['icon' => '🖥',  'name' => 'Linux',       'color' => '#fcc624'], 
      ]; 
      foreach ($techs as $i => $tech): 
      ?> 
      <div class="tc-tech-card reveal" style="transition-delay:<?= $i * 0.05 ?>s"> 
        <div class="tech-icon"> 
          <span style="font-size:1.8rem;"><?= $tech['icon'] ?></span> 
        </div> 
        <div class="tech-name"><?= e($tech['name']) ?></div> 
      </div> 
      <?php endforeach; ?> 
    </div> 
 
  </div> 
</section> 
 
<!-- ============================================================ --> 
<!-- SERVICES SECTION                                               --> 
<!-- ============================================================ --> 
<section class="tc-section" id="services"> 
  <div class="container"> 
    <div class="tc-section-header text-center reveal"> 
      <div class="tc-badge"><i class="bi bi-gear-fill"></i> Our Services</div> 
      <h2 class="tc-section-title">What We <span>Build For You</span></h2> 
      <p class="tc-section-subtitle"> 
        Beyond training — Techno Coderz is also a full-service software development company delivering tailored digital solutions. 
      </p> 
    </div> 
 
    <div class="row g-4"> 
      <?php if ($services): ?> 
        <?php foreach ($services as $i => $svc): ?> 
        <div class="col-lg-4 col-md-6 reveal" style="transition-delay:<?= ($i % 3) * 0.1 ?>s"> 
          <div class="tc-service-card"> 
            <div class="tc-service-icon"> 
              <i class="<?= e($svc['icon'] ?? 'bi bi-gear-fill') ?>"></i> 
            </div> 
            <h3 class="tc-service-title"><?= e($svc['title']) ?></h3> 
            <p class="tc-service-desc"><?= e($svc['short_description']) ?></p> 
          </div> 
        </div> 
        <?php endforeach; ?> 
      <?php endif; ?> 
    </div> 
 
    <div class="text-center mt-5 reveal"> 
      <a href="<?= SITE_URL ?>/services.php" class="tc-btn tc-btn-primary tc-btn-lg"> 
        <i class="bi bi-arrow-right-circle-fill"></i> Explore All Services 
      </a> 
    </div> 
  </div> 
</section> 
 
<!-- ============================================================ --> 
<!-- PROJECTS SECTION                                               --> 
<!-- ============================================================ --> 
<section class="tc-section tc-section-dark" id="projects"> 
  <div class="container"> 
    <div class="tc-section-header text-center reveal"> 
      <div class="tc-badge"><i class="bi bi-grid-3x3-gap-fill"></i> Our Work</div> 
      <h2 class="tc-section-title">Projects Built by <span>Techno Coderz</span></h2> 
      <p class="tc-section-subtitle"> 
        Real applications built by our team and students — proof that we don't just teach code, we write it. 
      </p> 
    </div> 
 
    <div class="row g-4"> 
      <?php if ($projects): ?> 
        <?php foreach ($projects as $i => $proj): ?> 
        <div class="col-lg-4 col-md-6 reveal" style="transition-delay:<?= ($i % 3) * 0.08 ?>s"> 
          <div class="tc-project-card"> 
            <div class="tc-project-img"> 
              <?php if ($proj['image'] && file_exists(UPLOAD_DIR . 'projects/' . $proj['image'])): ?> 
                <img src="<?= UPLOAD_URL ?>projects/<?= e($proj['image']) ?>" alt="<?= e($proj['title']) ?>" loading="lazy"> 
              <?php else: ?> 
                <div class="tc-project-fallback"> 
                  <i class="bi bi-window-stack"></i> 
                  <span><?= e($proj['title']) ?></span> 
                </div> 
              <?php endif; ?> 
              <div class="tc-project-overlay"> 
                <a href="<?= SITE_URL ?>/projects.php" class="tc-btn tc-btn-primary tc-btn-sm"> 
                  <i class="bi bi-eye-fill"></i> View Project 
                </a> 
              </div> 
            </div> 
            <div class="tc-project-body"> 
              <h3 class="tc-project-title"><?= e($proj['title']) ?></h3> 
              <p class="tc-project-desc"><?= e($proj['description']) ?></p> 
              <div class="tc-tech-tags"> 
                <?php 
                $tags = explode(',', $proj['technology'] ?? ''); 
                foreach (array_slice($tags, 0, 4) as $tag): 
                ?> 
                <span class="tc-tech-tag"><?= e(trim($tag)) ?></span> 
                <?php endforeach; ?> 
              </div> 
            </div> 
          </div> 
        </div> 
        <?php endforeach; ?> 
      <?php endif; ?> 
    </div> 
 
    <div class="text-center mt-5 reveal"> 
      <a href="<?= SITE_URL ?>/projects.php" class="tc-btn tc-btn-secondary tc-btn-lg"> 
        <i class="bi bi-folder2-open"></i> See All Projects 
      </a> 
    </div> 
  </div> 
</section> 
 
<!-- ============================================================ --> 
<!-- LEARNING PROCESS                                               --> 
<!-- ============================================================ --> 
<section class="tc-section" id="process"> 
  <div class="container"> 
    <div class="tc-section-header text-center reveal"> 
      <div class="tc-badge"><i class="bi bi-map-fill"></i> How It Works</div> 
      <h2 class="tc-section-title">Your Journey at <span>Techno Coderz</span></h2> 
      <p class="tc-section-subtitle"> 
        A structured, proven four-stage path from complete beginner to confident, job-ready developer. 
      </p> 
    </div> 
 
    <div class="row g-4"> 
      <?php 
      $steps = [ 
        ['num' => '01', 'icon' => 'bi bi-compass-fill',      'title' => 'Choose Your Path',    'desc' => 'Tell us your background and goals. We\'ll recommend the right course, batch timing, and learning track tailored specifically for you.'], 
        ['num' => '02', 'icon' => 'bi bi-code-square',       'title' => 'Learn & Practice',    'desc' => 'Deep-dive into your chosen technology through daily live classes, recorded sessions, coding labs, and problem-solving exercises.'], 
        ['num' => '03', 'icon' => 'bi bi-tools',             'title' => 'Build Real Projects', 'desc' => 'Apply everything you\'ve learned by building complete, real-world applications with mentor guidance and code reviews.'], 
        ['num' => '04', 'icon' => 'bi bi-briefcase-fill',    'title' => 'Launch Your Career',  'desc' => 'Polish your portfolio, nail your interviews with our mock sessions, and leverage our placement network to land your first tech role.'], 
      ]; 
      foreach ($steps as $i => $step): 
      ?> 
      <div class="col-lg-3 col-md-6 reveal" style="transition-delay:<?= $i * 0.1 ?>s"> 
        <div class="tc-process-card"> 
          <div class="tc-process-num"><?= $step['num'] ?></div> 
          <div class="tc-process-icon"><i class="<?= $step['icon'] ?>"></i></div> 
          <h3 class="tc-process-title"><?= $step['title'] ?></h3> 
          <p class="tc-process-desc"><?= $step['desc'] ?></p> 
        </div> 
      </div> 
      <?php endforeach; ?> 
    </div> 
 
  </div> 
</section> 
 
<!-- ============================================================ --> 
<!-- TESTIMONIALS                                                   --> 
<!-- ============================================================ --> 
<?php if ($testimonials): ?> 
<section class="tc-section tc-section-dark" id="testimonials"> 
  <div class="container"> 
    <div class="tc-section-header text-center reveal"> 
      <div class="tc-badge"><i class="bi bi-chat-quote-fill"></i> Success Stories</div> 
      <h2 class="tc-section-title">Hear From Our <span>Alumni</span></h2> 
      <p class="tc-section-subtitle"> 
        Real stories from students who trained at Techno Coderz and are now working across the tech industry. 
      </p> 
    </div> 
 
    <div class="row g-4"> 
      <?php foreach ($testimonials as $i => $t): ?> 
      <div class="col-lg-4 col-md-6 reveal" style="transition-delay:<?= ($i % 3) * 0.1 ?>s"> 
        <div class="tc-testimonial-card"> 
          <div class="tc-testi-stars"> 
            <?= starRating((int)$t['rating']) ?> 
          </div> 
          <p class="tc-testi-msg">"<?= e($t['message']) ?>"</p> 
          <div class="tc-testi-author"> 
            <div class="tc-testi-avatar"> 
              <?php if ($t['image'] && file_exists(UPLOAD_DIR . 'avatars/' . $t['image'])): ?> 
                <img src="<?= UPLOAD_URL ?>avatars/<?= e($t['image']) ?>" alt="<?= e($t['name']) ?>"> 
              <?php else: ?> 
                <i class="bi bi-person-fill"></i> 
              <?php endif; ?> 
            </div> 
            <div> 
              <div class="tc-testi-name"><?= e($t['name']) ?></div> 
              <div class="tc-testi-role"><?= e($t['designation']) ?></div> 
            </div> 
          </div> 
        </div> 
      </div> 
      <?php endforeach; ?> 
    </div> 
 
  </div> 
</section> 
<?php endif; ?> 
 
<!-- ============================================================ --> 
<!-- FAQ SECTION                                                    --> 
<!-- ============================================================ --> 
<section class="tc-section" id="faq"> 
  <div class="container"> 
    <div class="row g-5 align-items-start"> 
 
      <div class="col-lg-4 reveal"> 
        <div class="tc-badge"><i class="bi bi-question-circle-fill"></i> FAQ</div> 
        <h2 class="tc-section-title text-start">Frequently Asked <span>Questions</span></h2> 
        <p style="color:var(--tc-text-muted);font-size:0.9rem;line-height:1.8;margin-bottom:28px;"> 
          Got questions before enrolling? We've answered the most common ones below. If you need more info, we're just one click away. 
        </p> 
        <a href="<?= SITE_URL ?>/faq.php" class="tc-btn tc-btn-primary"> 
          <i class="bi bi-list-check"></i> Read Full FAQ 
        </a> 
      </div> 
 
      <div class="col-lg-8 reveal"> 
        <?php 
        $faqs = [ 
          ['q' => 'Do I need prior coding experience to join?', 
           'a' => 'Not at all! Most of our courses start from absolute zero. The Full Stack, PHP, Java, and Frontend programs are all beginner-friendly. We\'ll guide you step by step from the very basics.'], 
          ['q' => 'How long are the courses and what are the class timings?', 
           'a' => 'Course duration ranges from 1.5 to 6 months depending on the program. We offer morning, evening, and weekend batches to fit different schedules including working professionals and students.'], 
          ['q' => 'Will I receive a certificate after completing the course?', 
           'a' => 'Yes! Every student who successfully completes a course and meets project submission requirements receives an industry-recognized Techno Coderz completion certificate.'], 
          ['q' => 'What kind of projects will I build during training?', 
           'a' => 'You\'ll build real, deployable projects — not toy examples. Depending on your course, this could include e-commerce sites, management systems, REST APIs, or interactive web apps using the technologies you\'re learning.'], 
          ['q' => 'Do you provide placement assistance after the course?', 
           'a' => 'Yes, placement support is a core part of our offering. This includes resume building, LinkedIn profile review, mock interviews, and direct referrals to our hiring partners and alumni network.'], 
          ['q' => 'What is the fee structure? Is it affordable?', 
           'a' => 'Course fees are highly competitive and significantly lower than large ed-tech platforms, while offering better mentorship quality. Contact us for the current fee schedule and available EMI/scholarship options.'], 
        ]; 
        foreach ($faqs as $i => $faq): 
        ?> 
        <div class="tc-faq-item <?= $i === 0 ? 'open' : '' ?>"> 
          <button class="tc-faq-q" type="button"> 
            <?= e($faq['q']) ?> 
            <i class="bi bi-plus icon"></i> 
          </button> 
          <div class="tc-faq-a"><?= e($faq['a']) ?></div> 
        </div> 
        <?php endforeach; ?> 
      </div> 
 
    </div> 
  </div> 
</section> 
 
<!-- ============================================================ --> 
<!-- BLOG SECTION                                                   --> 
<!-- ============================================================ --> 
<?php if ($blogs): ?> 
<section class="tc-section tc-section-dark" id="blog"> 
  <div class="container"> 
    <div class="tc-section-header text-center reveal"> 
      <div class="tc-badge"><i class="bi bi-rss-fill"></i> Tech Blog</div> 
      <h2 class="tc-section-title">Insights From the <span>Techno Coderz</span> Team</h2> 
      <p class="tc-section-subtitle"> 
        Tutorials, career tips, and technology deep-dives written by our expert instructors. 
      </p> 
    </div> 
 
    <div class="row g-4"> 
      <?php foreach ($blogs as $i => $post): ?> 
      <div class="col-lg-4 col-md-6 reveal" style="transition-delay:<?= $i * 0.1 ?>s"> 
        <div class="tc-blog-card"> 
          <div class="tc-blog-img"> 
            <?php if ($post['image'] && file_exists(UPLOAD_DIR . 'blogs/' . $post['image'])): ?> 
              <img src="<?= UPLOAD_URL ?>blogs/<?= e($post['image']) ?>" alt="<?= e($post['title']) ?>" loading="lazy"> 
            <?php else: ?> 
              <div class="tc-blog-fallback"> 
                <i class="bi bi-file-earmark-code-fill" style="font-size:2.4rem;color:var(--tc-secondary);opacity:0.55;"></i> 
                <span style="font-size:0.7rem;color:var(--tc-text-muted);text-transform:uppercase;letter-spacing:0.8px;"><?= e($post['category'] ?? 'Article') ?></span> 
              </div> 
            <?php endif; ?> 
          </div> 
          <div class="tc-blog-body"> 
            <span class="tc-blog-cat"><?= e($post['category'] ?? 'Article') ?></span> 
            <h3 class="tc-blog-title"> 
              <a href="<?= SITE_URL ?>/blog-details.php?slug=<?= urlencode($post['slug']) ?>" style="color:inherit;text-decoration:none;"> 
                <?= e($post['title']) ?> 
              </a> 
            </h3> 
            <p class="tc-blog-excerpt"><?= e($post['excerpt']) ?></p> 
            <div class="tc-blog-footer"> 
              <span><i class="bi bi-person-fill me-1"></i><?= e($post['author']) ?></span> 
              <a href="<?= SITE_URL ?>/blog-details.php?slug=<?= urlencode($post['slug']) ?>" class="tc-btn tc-btn-primary tc-btn-sm" style="padding:5px 14px;font-size:0.75rem;"> 
                Read More 
              </a> 
            </div> 
          </div> 
        </div> 
      </div> 
      <?php endforeach; ?> 
    </div> 
 
    <div class="text-center mt-5 reveal"> 
      <a href="<?= SITE_URL ?>/blog.php" class="tc-btn tc-btn-secondary tc-btn-lg"> 
        <i class="bi bi-grid"></i> View All Articles 
      </a> 
    </div> 
  </div> 
</section> 
<?php endif; ?> 
 
<!-- ============================================================ --> 
<!-- CTA SECTION                                                    --> 
<!-- ============================================================ --> 
<section class="tc-section tc-cta-section" id="cta"> 
  <div class="container"> 
    <div class="row justify-content-center text-center"> 
      <div class="col-lg-8 reveal"> 
        <div class="tc-badge" style="margin:0 auto 20px;display:inline-flex;"><i class="bi bi-rocket-takeoff-fill"></i> Ready to Start?</div> 
        <h2 class="tc-section-title" style="font-size:clamp(2rem,4vw,3.2rem);"> 
          Begin Your Technology Journey<br>with <span>Techno Coderz</span> Today 
        </h2> 
        <p style="color:var(--tc-text-muted);font-size:1rem;max-width:560px;margin:0 auto 36px;line-height:1.8;"> 
          Students have already transformed their careers with us. Your first step is choosing the right course — and we'll guide you through everything from there. 
        </p> 
        <div class="d-flex flex-wrap gap-3 justify-content-center"> 
          <a href="<?= SITE_URL ?>/courses.php" class="tc-btn tc-btn-primary tc-btn-lg"> 
            <i class="bi bi-book-fill"></i> Explore All Courses 
          </a> 
          <a href="<?= SITE_URL ?>/contact.php" class="tc-btn tc-btn-secondary tc-btn-lg"> 
            <i class="bi bi-telephone-fill"></i> Talk to Us 
          </a> 
        </div> 
        <p style="margin-top:20px;font-size:0.82rem;color:var(--tc-text-muted);"> 
          <i class="bi bi-shield-check me-1" style="color:var(--tc-secondary)"></i> 
          Free counseling available &nbsp;•&nbsp; Flexible batch timings &nbsp;•&nbsp; Placement support 
        </p> 
      </div> 
    </div> 
  </div> 
</section> 
 
<?php 
// Inject CSRF token into enquiry modal hidden field via JS 
echo "<script> 
  document.addEventListener('DOMContentLoaded', function() { 
    const csrfField = document.getElementById('enquiryCsrf'); 
    if (csrfField) csrfField.value = '" . e($csrf) . "'; 
  }); 
</script>"; 
 
require_once __DIR__ . '/includes/footer.php'; 
?> 
 