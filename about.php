
<?php
// ============================================================
// Techno Coderz — About Us
// ============================================================
require_once __DIR__ . '/includes/functions.php';

$pageTitle       = 'About Us – Techno Coderz';
$pageDescription = 'Learn about Techno Coderz — our mission, vision, team, and how we have been shaping technology careers since 2016.';
$currentPage     = 'about';
$csrf = generateCsrfToken();

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<script>window.TC_BASE_URL = '<?= SITE_URL ?>';</script>

<div class="tc-page-light">

<!-- Page Hero -->
<div class="tc-page-hero">
  <div class="container text-center reveal">
    <ul class="tc-breadcrumb">
      <li><a href="<?= SITE_URL ?>"><i class="bi bi-house-fill"></i> Home</a></li>
      <li class="sep">/</li>
      <li class="current">About Us</li>
    </ul>
    <h1 class="tc-section-title" style="margin-bottom:10px;">About <span>Techno Coderz</span></h1>
    <p style="font-size:1.05rem; max-width:600px; margin:0 auto;">
      Discover who we are, what drives us, and why 1,200+ students have trusted us for their technology education.
    </p>
  </div>
</div>

<!-- Main Content -->
<section class="tc-section">
  <div class="container">
    <div class="row align-items-center g-5 mb-5">

      <!-- Left: Story -->
      <div class="col-lg-7 reveal">
        <div class="tc-badge"><i class="bi bi-book-half"></i> Our Story</div>
        <h2 class="tc-section-title text-start" style="font-size:1.8rem;">
          From a Small Lab to India's<br>Trusted <span>IT Training Partner</span>
        </h2>
        <p style="color:var(--tc-text); font-size:1rem; line-height:1.85; margin-bottom:18px;">
          Techno Coderz was founded in 2016 with a clear conviction: traditional education alone wasn't preparing students for real-world software development. Too many graduates left college with theoretical knowledge but couldn't build a working application.
        </p>
        <p style="color:var(--tc-text); font-size:1rem; line-height:1.85; margin-bottom:18px;">
          We started as a small training lab with three mentors and a dozen students. Our approach was different from day one — every class involved real coding, every week produced something tangible, and every course ended with students having built actual, deployable projects.
        </p>
        <p style="color:var(--tc-text); font-size:1rem; line-height:1.85; margin-bottom:28px;">
          Today, Techno Coderz has trained over 1,200 students, many of whom work at leading technology companies across India. We've also expanded into software development, building custom web applications, management systems, and digital solutions for businesses.
        </p>
      </div>

      <!-- Right: Stats panel (elevated white card) -->
      <div class="col-lg-5 reveal">
        <div class="tc-stats-card">
          <h3 class="tc-stats-title">
            <i class="bi bi-trophy-fill"></i> By The Numbers
          </h3>
          <div class="tc-stats-grid">
            <?php
            $aboutStats = [
              ['val'=>'8+','lbl'=>'Years in Operation','icon'=>'bi-calendar3'],
              ['val'=>'1200+','lbl'=>'Students Trained','icon'=>'bi-people-fill'],
              ['val'=>'98%','lbl'=>'Placement Success','icon'=>'bi-graph-up-arrow'],
              ['val'=>'60+','lbl'=>'Projects Delivered','icon'=>'bi-folder-check'],
              ['val'=>'25+','lbl'=>'Courses Available','icon'=>'bi-book-fill'],
              ['val'=>'15+','lbl'=>'Hiring Partners','icon'=>'bi-building'],
            ];
            foreach ($aboutStats as $as):
            ?>
            <div class="tc-stat-cell">
              <span class="tc-stat-icon"><i class="bi <?=$as['icon']?>"></i></span>
              <div class="tc-stat-val"><?=$as['val']?></div>
              <div class="tc-stat-lbl"><?=$as['lbl']?></div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Mission & Vision -->
<section class="tc-section tc-section-alt">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-6 reveal">
        <div class="tc-value-card">
          <div class="tc-value-icon">
            <i class="bi bi-rocket-takeoff-fill"></i>
          </div>
          <h3>Our Mission</h3>
          <p>
            To bridge the gap between academic learning and industry expectations by providing practical, project-based technology education that empowers students to build real applications and launch successful tech careers.
          </p>
        </div>
      </div>
      <div class="col-lg-6 reveal">
        <div class="tc-value-card">
          <div class="tc-value-icon">
            <i class="bi bi-eye-fill"></i>
          </div>
          <h3>Our Vision</h3>
          <p>
            To become India's most trusted IT training and development partner — known for producing graduates who don't just know theory but can confidently build, deploy, and maintain production-level software from day one.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Values -->
<section class="tc-section">
  <div class="container">
    <div class="tc-section-header text-center reveal">
      <div class="tc-badge"><i class="bi bi-diamond-fill"></i> Core Values</div>
      <h2 class="tc-section-title">What We <span>Stand For</span></h2>
    </div>
    <div class="row g-4">
      <?php
      $values = [
        ['icon'=>'bi-hammer','title'=>'Practical First','desc'=>'We believe developers are made through practice, not presentations. Every class involves hands-on coding and problem-solving.'],
        ['icon'=>'bi-people-fill','title'=>'Student-Centered','desc'=>'Small batch sizes, personalized mentorship, and flexible schedules — because every learner deserves individual attention.'],
        ['icon'=>'bi-shield-check','title'=>'Industry Integrity','desc'=>'We teach what the industry actually uses. Our curriculum is updated regularly based on real job market requirements.'],
        ['icon'=>'bi-stars','title'=>'Quality Obsessed','desc'=>'From our code to our course material to our mentors — we maintain rigorous quality standards in everything we do.'],
        ['icon'=>'bi-arrow-up-right-circle','title'=>'Continuous Growth','desc'=>'Technology never stops evolving, and neither do we. We continuously improve our courses, methods, and technology stack.'],
        ['icon'=>'bi-heart-fill','title'=>'Community Driven','desc'=>'Our alumni network is a lifelong resource. We build communities, not just classrooms — students support each other long after graduation.'],
      ];
      foreach ($values as $i => $v):
      ?>
      <div class="col-lg-4 col-md-6 reveal" style="transition-delay:<?=$i*0.08?>s">
        <div class="tc-feature-card" style="flex-direction:column; text-align:center; height:100%;">
          <div class="tc-feature-icon" style="margin:0 auto 20px;">
            <i class="bi <?=$v['icon']?>"></i>
          </div>
          <div>
            <h4 class="tc-feature-title"><?=$v['title']?></h4>
            <p class="tc-feature-desc" style="text-align:center; color:var(--tc-text); font-size:0.95rem; line-height:1.6;"><?=$v['desc']?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA (light LMS container) -->
<section class="tc-section tc-cta-light-wrap">
  <div class="container">
    <div class="tc-cta-light reveal">
      <h2 class="tc-section-title">Ready to Be Part of<br>the <span>Techno Coderz</span> Story?</h2>
      <p>Join 1,200+ students who have already built their tech careers with us.</p>
      <div class="tc-cta-actions">
        <a href="<?= SITE_URL ?>/courses.php" class="tc-btn tc-btn-primary tc-btn-lg">
          <i class="bi bi-book-fill"></i> Explore Courses
        </a>
        <a href="<?= SITE_URL ?>/contact.php" class="tc-btn tc-btn-secondary tc-btn-lg">
          <i class="bi bi-chat-dots-fill"></i> Contact Us
        </a>
      </div>
    </div>
  </div>
</section>

</div><!-- /.tc-page-light -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
