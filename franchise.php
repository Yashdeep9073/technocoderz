<?php
require_once __DIR__ . '/includes/functions.php';
$pageTitle       = 'Franchise With Us – Techno Coderz';
$pageDescription = 'Partner with Techno Coderz and start your own computer training institute. Get brand support, curriculum, faculty training and marketing help.';
$currentPage     = 'franchise';
$csrf = generateCsrfToken();

$acCss = SITE_URL . '/assets/css/all-courses.css?v=' . filemtime(__DIR__ . '/assets/css/all-courses.css');
$extraHead = '<link rel="stylesheet" href="' . $acCss . '">';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<script>window.TC_BASE_URL='<?= SITE_URL ?>';</script>

<style>
.tcfr-sec{ padding:80px 0; }
.tcfr-sec.bg-soft{ background:#F8FAFC; }
.tcfr-head{ text-align:center; max-width:760px; margin:0 auto 46px; }
.tcfr-tag{ display:inline-block; font-size:12px; font-weight:800; letter-spacing:1.5px; text-transform:uppercase; color:#FF6B00; background:rgba(255,107,0,.10); padding:6px 16px; border-radius:50px; margin-bottom:14px; }
.tcfr-head h2{ font-family:var(--tc-font-head,inherit); font-size:34px; font-weight:800; color:var(--text-heading,#0F172A); margin:0 0 12px; letter-spacing:-.5px; }
.tcfr-head p{ font-size:16px; color:var(--text-muted,#64748B); margin:0; line-height:1.7; }
.tcfr-grid{ display:grid; grid-template-columns:repeat(3,1fr); gap:24px; }
.tcfr-card{ background:#fff; border:1px solid var(--border,#E2E8F0); border-radius:18px; padding:32px 26px; transition:.3s; }
.tcfr-card:hover{ transform:translateY(-6px); border-color:rgba(255,107,0,.4); box-shadow:0 20px 44px rgba(15,23,42,.10); }
.tcfr-ico{ width:58px; height:58px; border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:26px; color:#fff; background:linear-gradient(135deg,#FF6B00,#E55F00); margin-bottom:18px; }
.tcfr-card h3{ font-size:18px; font-weight:800; color:var(--text-heading,#0F172A); margin:0 0 9px; }
.tcfr-card p{ font-size:14.5px; color:var(--text-muted,#64748B); margin:0; line-height:1.7; }
.tcfr-steps{ display:grid; grid-template-columns:repeat(4,1fr); gap:22px; counter-reset:step; }
.tcfr-step{ position:relative; background:#fff; border:1px solid var(--border,#E2E8F0); border-radius:18px; padding:34px 24px 28px; text-align:center; }
.tcfr-step .num{ width:50px; height:50px; border-radius:50%; margin:0 auto 16px; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:20px; color:#FF6B00; background:rgba(255,107,0,.10); border:2px solid rgba(255,107,0,.25); }
.tcfr-step h3{ font-size:16.5px; font-weight:800; color:var(--text-heading,#0F172A); margin:0 0 8px; }
.tcfr-step p{ font-size:14px; color:var(--text-muted,#64748B); margin:0; line-height:1.65; }
.tcfr-cta{ background:linear-gradient(135deg,#FF6B00,#E55F00); border-radius:24px; padding:52px 40px; text-align:center; color:#fff; position:relative; overflow:hidden; }
.tcfr-cta h2{ font-family:var(--tc-font-head,inherit); font-size:32px; font-weight:800; margin:0 0 12px; position:relative; }
.tcfr-cta p{ font-size:16px; opacity:.94; margin:0 0 26px; position:relative; }
.tcfr-cta .btns{ display:flex; gap:14px; justify-content:center; flex-wrap:wrap; position:relative; }
.tcfr-btn{ display:inline-flex; align-items:center; gap:9px; padding:15px 32px; border-radius:50px; font-weight:800; font-size:15px; text-decoration:none; transition:.25s; }
.tcfr-btn.primary{ background:#fff; color:#FF6B00; box-shadow:0 12px 26px rgba(0,0,0,.18); }
.tcfr-btn.primary:hover{ transform:translateY(-2px); }
.tcfr-btn.ghost{ background:rgba(255,255,255,.14); color:#fff; border:2px solid rgba(255,255,255,.5); }
.tcfr-btn.ghost:hover{ background:rgba(255,255,255,.24); }
@media(max-width:992px){ .tcfr-grid{ grid-template-columns:repeat(2,1fr); } .tcfr-steps{ grid-template-columns:repeat(2,1fr); } }
@media(max-width:600px){ .tcfr-grid,.tcfr-steps{ grid-template-columns:1fr; } .tcfr-head h2{ font-size:26px; } .tcfr-cta{ padding:40px 22px; } .tcfr-cta h2{ font-size:25px; } }
</style>

<div class="tc-lms-page tcl-page">
  <div class="tcl-hero">
    <div class="container text-center">
      <div class="page-title"><h1 class="title">Franchise With Us</h1></div>
      <nav aria-label="breadcrumb">
        <ul class="edu-breadcrumb">
          <li class="breadcrumb-item"><a href="<?= SITE_URL ?>/index.php">Home</a></li>
          <li class="separator"><i class="bi bi-chevron-right"></i></li>
          <li class="breadcrumb-item active">Franchise</li>
        </ul>
      </nav>
    </div>
  </div>

  <section class="tcfr-sec">
    <div class="container">
      <div class="tcfr-head">
        <span class="tcfr-tag">Business Opportunity</span>
        <h2>Start Your Own Techno Coderz Training Centre</h2>
        <p>Join one of the fastest growing IT training networks. Get a proven curriculum, expert faculty training, complete branding and end-to-end marketing support so you can launch with confidence.</p>
      </div>
      <div class="tcfr-grid">
        <div class="tcfr-card"><div class="tcfr-ico"><i class="bi bi-award-fill"></i></div><h3>Proven Brand</h3><p>Use the trusted Techno Coderz name, logo and identity that thousands of students already recognise.</p></div>
        <div class="tcfr-card"><div class="tcfr-ico"><i class="bi bi-journal-code"></i></div><h3>Ready Curriculum</h3><p>Industry-ready course content, projects and study material across programming, AI, cloud and cyber security.</p></div>
        <div class="tcfr-card"><div class="tcfr-ico"><i class="bi bi-person-video3"></i></div><h3>Faculty Training</h3><p>We train and certify your trainers so quality teaching stays consistent from day one.</p></div>
        <div class="tcfr-card"><div class="tcfr-ico"><i class="bi bi-megaphone-fill"></i></div><h3>Marketing Support</h3><p>Ad creatives, digital campaigns, admission drives and lead generation help to keep your batches full.</p></div>
        <div class="tcfr-card"><div class="tcfr-ico"><i class="bi bi-gear-fill"></i></div><h3>Operational Setup</h3><p>Guidance on infrastructure, lab setup, placement process and day-to-day centre operations.</p></div>
        <div class="tcfr-card"><div class="tcfr-ico"><i class="bi bi-graph-up-arrow"></i></div><h3>High ROI</h3><p>A low-investment, fast-growing education business model with strong and reliable returns.</p></div>
      </div>
    </div>
  </section>

  <section class="tcfr-sec bg-soft">
    <div class="container">
      <div class="tcfr-head">
        <span class="tcfr-tag">Simple Process</span>
        <h2>How It Works</h2>
        <p>From your first enquiry to a fully running centre, our team stays with you at every step.</p>
      </div>
      <div class="tcfr-steps">
        <div class="tcfr-step"><div class="num">1</div><h3>Apply</h3><p>Fill the franchise enquiry form with your city and basic details.</p></div>
        <div class="tcfr-step"><div class="num">2</div><h3>Discussion</h3><p>Our team shares the business model, investment and expected returns.</p></div>
        <div class="tcfr-step"><div class="num">3</div><h3>Agreement</h3><p>Sign the partnership agreement and complete your centre setup.</p></div>
        <div class="tcfr-step"><div class="num">4</div><h3>Launch</h3><p>Get training, marketing kits and go live with your first admissions.</p></div>
      </div>
    </div>
  </section>

  <section class="tcfr-sec">
    <div class="container">
      <div class="tcfr-cta">
        <h2>Ready to Build Your Education Business?</h2>
        <p>Become a Techno Coderz franchise partner and launch a profitable IT training centre in your city.</p>
        <div class="btns">
          <a href="contact.php" class="tcfr-btn primary"><i class="bi bi-send-fill"></i> Enquire Now</a>
          <a href="tel:+919876543210" class="tcfr-btn ghost"><i class="bi bi-telephone-fill"></i> +91 98765 43210</a>
        </div>
      </div>
    </div>
  </section>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
