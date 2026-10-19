<?php
require_once __DIR__ . '/includes/functions.php';
$pageTitle       = 'Placement Cell – Techno Coderz';
$pageDescription = 'Techno Coderz placement cell: 100% placement assistance, resume building, mock interviews and hiring partner network.';
$currentPage     = 'placement';
$csrf = generateCsrfToken();

$acCss = SITE_URL . '/assets/css/all-courses.css?v=' . filemtime(__DIR__ . '/assets/css/all-courses.css');
$extraHead = '<link rel="stylesheet" href="' . $acCss . '">';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<script>window.TC_BASE_URL='<?= SITE_URL ?>';</script>

<style>
.tcpc-sec{ padding:80px 0; }
.tcpc-sec.bg-soft{ background:#F8FAFC; }
.tcpc-head{ text-align:center; max-width:760px; margin:0 auto 46px; }
.tcpc-tag{ display:inline-block; font-size:12px; font-weight:800; letter-spacing:1.5px; text-transform:uppercase; color:#FF6B00; background:rgba(255,107,0,.10); padding:6px 16px; border-radius:50px; margin-bottom:14px; }
.tcpc-head h2{ font-family:var(--tc-font-head,inherit); font-size:34px; font-weight:800; color:var(--text-heading,#0F172A); margin:0 0 12px; letter-spacing:-.5px; }
.tcpc-head p{ font-size:16px; color:var(--text-muted,#64748B); margin:0; line-height:1.7; }
.tcpc-stats{ display:grid; grid-template-columns:repeat(4,1fr); gap:24px; margin-bottom:52px; }
.tcpc-stat{ background:#fff; border:1px solid var(--border,#E2E8F0); border-radius:18px; padding:32px 20px; text-align:center; box-shadow:0 12px 30px rgba(15,23,42,.06); }
.tcpc-stat .n{ font-size:40px; font-weight:800; color:#FF6B00; line-height:1; margin-bottom:8px; font-family:var(--tc-font-head,inherit); }
.tcpc-stat .l{ font-size:14px; font-weight:600; color:var(--text-muted,#64748B); }
.tcpc-partners{ display:grid; grid-template-columns:repeat(5,1fr); gap:16px; }
.tcpc-partner{ background:#fff; border:1px solid var(--border,#E2E8F0); border-radius:14px; height:82px; display:flex; align-items:center; justify-content:center; font-weight:800; color:var(--text-heading,#0F172A); font-size:15px; letter-spacing:.5px; transition:.25s; }
.tcpc-partner:hover{ border-color:rgba(255,107,0,.45); color:#FF6B00; transform:translateY(-3px); }
.tcpc-steps{ display:grid; grid-template-columns:repeat(4,1fr); gap:22px; }
.tcpc-step{ background:#fff; border:1px solid var(--border,#E2E8F0); border-radius:18px; padding:32px 22px; text-align:center; }
.tcpc-step .num{ width:50px; height:50px; border-radius:50%; margin:0 auto 16px; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:20px; color:#FF6B00; background:rgba(255,107,0,.10); border:2px solid rgba(255,107,0,.25); }
.tcpc-step h3{ font-size:16.5px; font-weight:800; color:var(--text-heading,#0F172A); margin:0 0 8px; }
.tcpc-step p{ font-size:14px; color:var(--text-muted,#64748B); margin:0; line-height:1.65; }
.tcpc-cta{ background:linear-gradient(135deg,#FF6B00,#E55F00); border-radius:24px; padding:52px 40px; text-align:center; color:#fff; position:relative; overflow:hidden; }
.tcpc-cta h2{ font-family:var(--tc-font-head,inherit); font-size:32px; font-weight:800; margin:0 0 12px; position:relative; }
.tcpc-cta p{ font-size:16px; opacity:.94; margin:0 0 26px; position:relative; }
.tcpc-cta .btns{ display:flex; gap:14px; justify-content:center; flex-wrap:wrap; position:relative; }
.tcpc-btn{ display:inline-flex; align-items:center; gap:9px; padding:15px 32px; border-radius:50px; font-weight:800; font-size:15px; text-decoration:none; transition:.25s; }
.tcpc-btn.primary{ background:#fff; color:#FF6B00; box-shadow:0 12px 26px rgba(0,0,0,.18); }
.tcpc-btn.primary:hover{ transform:translateY(-2px); }
.tcpc-btn.ghost{ background:rgba(255,255,255,.14); color:#fff; border:2px solid rgba(255,255,255,.5); }
.tcpc-btn.ghost:hover{ background:rgba(255,255,255,.24); }
@media(max-width:992px){ .tcpc-stats{ grid-template-columns:repeat(2,1fr); } .tcpc-partners{ grid-template-columns:repeat(3,1fr); } .tcpc-steps{ grid-template-columns:repeat(2,1fr); } }
@media(max-width:600px){ .tcpc-stats,.tcpc-partners,.tcpc-steps{ grid-template-columns:1fr; } .tcpc-head h2{ font-size:26px; } .tcpc-cta{ padding:40px 22px; } .tcpc-cta h2{ font-size:25px; } }
</style>

<div class="tc-lms-page tcl-page">
  <div class="tcl-hero">
    <div class="container text-center">
      <div class="page-title"><h1 class="title">Placement Cell</h1></div>
      <nav aria-label="breadcrumb">
        <ul class="edu-breadcrumb">
          <li class="breadcrumb-item"><a href="<?= SITE_URL ?>/index.php">Home</a></li>
          <li class="separator"><i class="bi bi-chevron-right"></i></li>
          <li class="breadcrumb-item active">Placement Cell</li>
        </ul>
      </nav>
    </div>
  </div>

  <section class="tcpc-sec">
    <div class="container">
      <div class="tcpc-head">
        <span class="tcpc-tag">Careers</span>
        <h2>100% Placement Assistance</h2>
        <p>Our dedicated placement cell prepares every Techno Coderz student for the real job market with resume building, mock interviews and direct access to hiring partners.</p>
      </div>
      <div class="tcpc-stats">
        <div class="tcpc-stat"><div class="n">15,000+</div><div class="l">Students Trained</div></div>
        <div class="tcpc-stat"><div class="n">500+</div><div class="l">Hiring Partners</div></div>
        <div class="tcpc-stat"><div class="n">₹4.5 LPA</div><div class="l">Average Package</div></div>
        <div class="tcpc-stat"><div class="n">100%</div><div class="l">Placement Support</div></div>
      </div>
      <div class="tcpc-head" style="margin-bottom:30px">
        <span class="tcpc-tag">Recruiters</span>
        <h2 style="font-size:26px">Our Hiring Partners</h2>
        <p>Our students work with leading IT companies, product startups and service firms across India.</p>
      </div>
      <div class="tcpc-partners">
        <div class="tcpc-partner">TCS</div>
        <div class="tcpc-partner">Infosys</div>
        <div class="tcpc-partner">Wipro</div>
        <div class="tcpc-partner">HCL</div>
        <div class="tcpc-partner">Tech Mahindra</div>
        <div class="tcpc-partner">Cognizant</div>
        <div class="tcpc-partner">Capgemini</div>
        <div class="tcpc-partner">Accenture</div>
        <div class="tcpc-partner">Amazon</div>
        <div class="tcpc-partner">Startups</div>
      </div>
    </div>
  </section>

  <section class="tcpc-sec bg-soft">
    <div class="container">
      <div class="tcpc-head">
        <span class="tcpc-tag">Process</span>
        <h2>How We Get You Placed</h2>
        <p>A structured placement journey that turns your training into a real career.</p>
      </div>
      <div class="tcpc-steps">
        <div class="tcpc-step"><div class="num">1</div><h3>Skill Assessment</h3><p>We evaluate your strengths and map them to the right job roles.</p></div>
        <div class="tcpc-step"><div class="num">2</div><h3>Resume &amp; Portfolio</h3><p>Build a job-ready resume and project portfolio that recruiters shortlist.</p></div>
        <div class="tcpc-step"><div class="num">3</div><h3>Mock Interviews</h3><p>Practise aptitude, technical and HR rounds with expert feedback.</p></div>
        <div class="tcpc-step"><div class="num">4</div><h3>Interview Calls</h3><p>Apply to hiring drives and partner openings until you land the offer.</p></div>
      </div>
    </div>
  </section>

  <section class="tcpc-sec">
    <div class="container">
      <div class="tcpc-cta">
        <h2>Start Your Career With Techno Coderz</h2>
        <p>Train with us, build real projects and get placed in your dream company.</p>
        <div class="btns">
          <a href="career.php" class="tcpc-btn primary"><i class="bi bi-briefcase-fill"></i> View Openings</a>
          <a href="contact.php" class="tcpc-btn ghost"><i class="bi bi-envelope-fill"></i> Talk to Placement Cell</a>
        </div>
      </div>
    </div>
  </section>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
