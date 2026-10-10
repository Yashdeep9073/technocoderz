<?php
// ============================================================
// Techno Coderz — Career Page
// ============================================================
require_once __DIR__ . '/includes/functions.php';
$pageTitle='Career – Techno Coderz';$pageDescription='Build your technology career with Techno Coderz. Explore career opportunities and placement support.';$currentPage='career';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<script>window.TC_BASE_URL='<?=SITE_URL?>';</script>

<div class="tc-cta-section" style="padding: 60px 0;">
  <div class="container text-center reveal" style="position:relative;z-index:1;">
    <ul class="tc-breadcrumb" style="list-style:none; padding:0; display:flex; justify-content:center; gap:10px; margin-bottom:15px; font-size:0.9rem;">
      <li><a href="<?= SITE_URL ?>" style="color:var(--tc-white);"><i class="bi bi-house-fill"></i> Home</a></li>
      <li style="color:rgba(255,255,255,0.5);">/</li>
      <li style="color:rgba(255,255,255,0.8);">Career</li>
    </ul>
    <h1 class="tc-section-title" style="color:var(--tc-white); margin-bottom:10px;">Build Your <span>Tech Career</span></h1>
    <p style="color:rgba(255,255,255,0.8); font-size:1.1rem; max-width:600px; margin:0 auto;">
      At Techno Coderz, career development isn't an afterthought — it's built into every course from day one.
    </p>
  </div>
</div>

<!-- Career Support Features -->
<section class="tc-section" id="career">
  <div class="container">
    <div class="tc-section-header text-center reveal">
      <div class="tc-badge"><i class="bi bi-briefcase-fill"></i> Career Support</div>
      <h2 class="tc-section-title">How We Help You <span>Get Hired</span></h2>
      <p class="tc-section-subtitle">Our career support program is comprehensive and designed to make you stand out in the competitive tech job market.</p>
    </div>

    <div class="row g-4">
      <?php
      $careerFeatures = [
        ['icon'=>'bi-file-earmark-person-fill','title'=>'Resume Building','desc'=>'We help you craft a professional, ATS-friendly resume that highlights your technical skills, projects, and achievements effectively.'],
        ['icon'=>'bi-camera-video-fill','title'=>'Mock Interviews','desc'=>'Practice technical and HR interview rounds with our experienced mentors who simulate real company interview scenarios.'],
        ['icon'=>'bi-linkedin','title'=>'LinkedIn Optimization','desc'=>'We guide you in building a strong LinkedIn profile that attracts recruiters and showcases your developer portfolio.'],
        ['icon'=>'bi-folder2-open','title'=>'Portfolio Development','desc'=>'Graduate with 3–5 complete, deployed projects that demonstrate your abilities to potential employers and clients.'],
        ['icon'=>'bi-people-fill','title'=>'Hiring Partner Network','desc'=>'Our network of 15+ hiring partners across Bengaluru and pan-India actively recruit from our graduating batches.'],
        ['icon'=>'bi-graph-up-arrow','title'=>'Career Counseling','desc'=>'One-on-one sessions to identify your strengths, choose the right career path, and set achievable professional goals.'],
        ['icon'=>'bi-chat-square-text-fill','title'=>'Soft Skills Training','desc'=>'Communication, teamwork, and presentation skills that are essential for succeeding in professional tech environments.'],
        ['icon'=>'bi-infinity','title'=>'Lifetime Alumni Access','desc'=>'Even after graduation, access job referrals, community resources, and refresher content through our alumni network forever.'],
      ];
      foreach($careerFeatures as $i=>$f):
      ?>
      <div class="col-lg-3 col-md-6 reveal" style="transition-delay:<?=($i%4)*0.08?>s">
        <div class="tc-service-card" style="text-align:center; height:100%; display:flex; flex-direction:column; background:var(--tc-white); padding:30px 20px; border-radius:var(--tc-radius); border:1px solid var(--tc-border); box-shadow:var(--tc-shadow-sm);">
          <div class="tc-service-icon" style="margin:0 auto 20px;"><i class="<?=$f['icon']?>" style="color:var(--tc-primary); font-size:2rem;"></i></div>
          <h3 class="tc-service-title" style="font-family:var(--tc-font-head); font-size:1.1rem; color:var(--tc-heading); margin-bottom:12px;"><?=$f['title']?></h3>
          <p class="tc-service-desc" style="font-size:0.9rem; color:var(--tc-text); line-height:1.6; margin:0;"><?=$f['desc']?></p>
        </div>
      </div>
      <?php endforeach;?>
    </div>
  </div>
</section>

<!-- Placement Stats -->
<section class="tc-section tc-section-alt">
  <div class="container text-center reveal">
    <div class="tc-badge" style="display:inline-flex;margin:0 auto 20px;"><i class="bi bi-trophy-fill"></i> Our Track Record</div>
    <h2 class="tc-section-title">Placement <span>Statistics</span></h2>
    <div class="row g-4 mt-4">
      <?php
      $placementStats = [
        ['val'=>'98%','lbl'=>'Placement Rate','icon'=>'bi-check-circle-fill','col'=>'var(--tc-primary)'],
        ['val'=>'1200+','lbl'=>'Students Placed','icon'=>'bi-people-fill','col'=>'var(--tc-primary)'],
        ['val'=>'15+','lbl'=>'Hiring Partners','icon'=>'bi-building','col'=>'var(--tc-primary)'],
        ['val'=>'₹3.5L','lbl'=>'Avg. Starting CTC','icon'=>'bi-currency-rupee','col'=>'var(--tc-primary)'],
      ];
      foreach($placementStats as $ps):
      ?>
      <div class="col-md-3 col-6">
        <div style="background:var(--tc-white); border:1px solid var(--tc-border); border-radius:var(--tc-radius-lg); padding:32px 20px; box-shadow:var(--tc-shadow-sm);">
          <i class="bi <?=$ps['icon']?>" style="font-size:2rem; color:<?=$ps['col']?>; display:block; margin-bottom:12px;"></i>
          <div style="font-family:var(--tc-font-head); font-size:2.5rem; font-weight:900; color:var(--tc-heading); line-height:1; margin-bottom:8px;"><?=$ps['val']?></div>
          <div style="font-size:0.85rem; color:var(--tc-text-muted); font-weight:600; text-transform:uppercase; letter-spacing:0.8px;"><?=$ps['lbl']?></div>
        </div>
      </div>
      <?php endforeach;?>
    </div>
  </div>
</section>

<!-- Join Us CTA -->
<section class="tc-cta-section">
  <div class="container text-center reveal">
    <h2 class="tc-section-title" style="color:var(--tc-white);">Interested in Working <span>With Us</span>?</h2>
    <p style="color:rgba(255,255,255,0.8); font-size:1.1rem; max-width:600px; margin:0 auto 12px;">
      We're always looking for passionate mentors and team members. If you love teaching technology or building software, let's talk.
    </p>
    <p style="font-size:1rem; color:var(--tc-white); margin-bottom:32px;">
      Send your CV to: <a href="mailto:careers@technocoderz.com" style="color:var(--tc-white); font-weight:700; text-decoration:underline;">careers@technocoderz.com</a>
    </p>
    <div class="d-flex flex-wrap gap-3 justify-content-center">
      <a href="<?=SITE_URL?>/courses.php" class="tc-btn tc-btn-primary tc-btn-lg" style="background:var(--tc-white); color:var(--tc-primary);"><i class="bi bi-book-fill"></i> Start Learning</a>
      <a href="<?=SITE_URL?>/contact.php" class="tc-btn tc-btn-secondary tc-btn-lg"><i class="bi bi-chat-dots-fill"></i> Contact Us</a>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
