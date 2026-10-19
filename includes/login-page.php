<?php
// ============================================================
// Techno Coderz — Login page template (techcadd-style layout)
// Expects: $loginTitle, $loginHeading, $loginText, $loginIcon,
//          $loginBadge, $loginNote
// Self-contained: hero + centered login card.
// ============================================================
require_once __DIR__ . '/functions.php';

if (!isset($loginTitle))   $loginTitle   = 'Login';
if (!isset($loginHeading)) $loginHeading = 'Login';
if (!isset($loginText))    $loginText    = 'Sign in to continue to your Techno Coderz account.';
if (!isset($loginIcon))    $loginIcon    = 'bi bi-box-arrow-in-right';
if (!isset($loginBadge))   $loginBadge   = 'Secure Access';
if (!isset($loginNote))    $loginNote    = 'Having trouble signing in? Call +91 98765 43210 or email info@technocoderz.com.';

$pageTitle       = $loginTitle . ' – Techno Coderz';
$pageDescription = $loginText;
$currentPage     = $loginPage ?? '';
$csrf = generateCsrfToken();

$acCss = SITE_URL . '/assets/css/all-courses.css?v=' . filemtime(__DIR__ . '/../assets/css/all-courses.css');
$extraHead = '<link rel="stylesheet" href="' . $acCss . '">';

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/navbar.php';
?>
<script>window.TC_BASE_URL='<?= SITE_URL ?>';</script>

<div class="tc-lms-page tcl-page">
  <div class="tcl-hero">
    <div class="container text-center">
      <div class="page-title"><h1 class="title"><?= e($loginHeading) ?></h1></div>
      <nav aria-label="breadcrumb">
        <ul class="edu-breadcrumb">
          <li class="breadcrumb-item"><a href="<?= SITE_URL ?>/index.php">Home</a></li>
          <li class="separator"><i class="bi bi-chevron-right"></i></li>
          <li class="breadcrumb-item active"><?= e($loginHeading) ?></li>
        </ul>
      </nav>
    </div>
  </div>

  <section class="edu-course-area edu-section-gap bg-color-white">
    <div class="container">
      <div class="tclg-wrap">
        <form class="tclg-card" id="tclgForm" novalidate>
          <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
          <div class="tclg-icon"><i class="<?= e($loginIcon) ?>"></i></div>
          <span class="tclg-badge"><?= e($loginBadge) ?></span>
          <h2 class="tclg-title"><?= e($loginHeading) ?></h2>
          <p class="tclg-text"><?= e($loginText) ?></p>

          <div class="tclg-field">
            <label>Email / Username</label>
            <input type="text" name="username" placeholder="Enter your email or username" required>
          </div>
          <div class="tclg-field">
            <label>Password</label>
            <div class="tclg-pass">
              <input type="password" name="password" placeholder="Enter your password" required>
              <button type="button" class="tclg-eye" aria-label="Show password"><i class="bi bi-eye"></i></button>
            </div>
          </div>
          <div class="tclg-row">
            <label class="tclg-remember"><input type="checkbox" name="remember"> Remember me</label>
            <a href="contact.php" class="tclg-forgot">Forgot password?</a>
          </div>

          <button type="submit" class="tclg-btn">Login <i class="bi bi-arrow-right"></i></button>
          <p class="tclg-note"><?= e($loginNote) ?></p>
        </form>
      </div>
    </div>
  </section>
</div>

<style>
.tclg-wrap{ display:flex; justify-content:center; }
.tclg-card{
  width:100%; max-width:450px; background:#fff; border:1px solid var(--border,#E2E8F0);
  border-radius:20px; padding:40px 34px; box-shadow:0 24px 60px rgba(15,23,42,.10);
  text-align:center; position:relative;
}
.tclg-icon{
  width:72px; height:72px; border-radius:50%; margin:0 auto 16px; display:flex;
  align-items:center; justify-content:center; font-size:30px; color:#fff;
  background:linear-gradient(135deg,#FF6B00,#E55F00); box-shadow:0 12px 26px rgba(255,107,0,.35);
}
.tclg-badge{
  display:inline-block; font-size:11px; font-weight:800; letter-spacing:1px; text-transform:uppercase;
  color:#FF6B00; background:rgba(255,107,0,.10); padding:5px 14px; border-radius:50px; margin-bottom:12px;
}
.tclg-title{ font-family:var(--tc-font-head,inherit); font-size:24px; font-weight:800; color:var(--text-heading,#0F172A); margin:0 0 8px; }
.tclg-text{ font-size:14px; color:var(--text-muted,#64748B); margin:0 0 24px; line-height:1.6; }
.tclg-field{ text-align:left; margin-bottom:16px; }
.tclg-field label{ display:block; font-size:13px; font-weight:700; color:var(--text-heading,#0F172A); margin-bottom:7px; }
.tclg-field input{
  width:100%; padding:13px 15px; border:2px solid #e5e7eb; border-radius:12px; font-size:15px;
  font-family:inherit; outline:none; transition:.25s; color:#0F172A;
}
.tclg-field input:focus{ border-color:#FF6B00; box-shadow:0 0 0 4px rgba(255,107,0,.13); }
.tclg-pass{ position:relative; }
.tclg-eye{ position:absolute; right:6px; top:50%; transform:translateY(-50%); background:none; border:0; color:#94a3b8; cursor:pointer; padding:8px 10px; font-size:16px; }
.tclg-row{ display:flex; align-items:center; justify-content:space-between; margin:4px 0 22px; font-size:13px; }
.tclg-remember{ display:flex; align-items:center; gap:7px; color:var(--text-body,#334155); font-weight:600; cursor:pointer; }
.tclg-remember input{ width:16px; height:16px; accent-color:#FF6B00; }
.tclg-forgot{ color:#FF6B00; font-weight:700; text-decoration:none; }
.tclg-forgot:hover{ text-decoration:underline; }
.tclg-btn{
  width:100%; padding:15px; border:0; border-radius:12px; cursor:pointer; color:#fff; font-size:16px;
  font-weight:800; font-family:inherit; background:linear-gradient(135deg,#FF6B00,#E55F00);
  box-shadow:0 12px 26px rgba(255,107,0,.32); transition:.25s;
}
.tclg-btn:hover{ transform:translateY(-2px); box-shadow:0 16px 34px rgba(255,107,0,.42); }
.tclg-note{ font-size:12.5px; color:var(--text-light,#94A3B8); margin:16px 0 0; line-height:1.6; }
@media(max-width:520px){ .tclg-card{ padding:30px 22px; } .tclg-title{ font-size:20px; } }
</style>

<script>
(function(){
  var form = document.getElementById('tclgForm');
  if (!form) return;
  var eye = form.querySelector('.tclg-eye');
  var pass = form.querySelector('[name="password"]');
  if (eye && pass) {
    eye.addEventListener('click', function(){
      var show = pass.type === 'password';
      pass.type = show ? 'text' : 'password';
      eye.innerHTML = '<i class="bi ' + (show ? 'bi-eye-slash' : 'bi-eye') + '"></i>';
    });
  }
  form.addEventListener('submit', function(e){
    e.preventDefault();
    var u = form.querySelector('[name="username"]').value.trim();
    var p = form.querySelector('[name="password"]').value.trim();
    if (!u || !p) { if (typeof tcToast === 'function') tcToast('Please enter your username and password.', 'error'); return; }
    if (typeof tcToast === 'function') tcToast('Login portal is launching soon. Please contact the institute for access.', 'success');
  });
})();
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
