<?php
// ============================================================
// Techno Coderz — On-open Demo / Enquiry Popup
// Layout & design replicated "same to same" from techcadd.com's
// on-load popup (#techcaddModal: blue-left / form-right two-column
// card), restyled to the Techno Coderz orange theme and wired to
// the existing ajax/enquiry.php handler.
// Auto-opens on the homepage after 4s (like techcadd).
// Self-contained: markup + styles + script.
// ============================================================

// Active courses for the select (graceful fallback)
$__popupCourses = [];
try {
    $__pdo = getDB();
    $__popupCourses = $__pdo->query("SELECT title FROM courses WHERE status = 1 ORDER BY sort_order ASC, id ASC")->fetchAll();
} catch (Exception $e) {
    $__popupCourses = [];
}
$__popupCsrf = function_exists('generateCsrfToken') ? generateCsrfToken() : '';

// Auto-open only where the page opted in (homepage sets $__popupAuto = true).
$__popupAutoOpen = !empty($__popupAuto);
?>
<style>
/* ---------- Techno Coderz Demo Popup (techcadd-style) ---------- */
.tcdp-overlay{
  position:fixed; inset:0; z-index:99998; display:none;
  justify-content:center; align-items:center; padding:20px;
  background:rgba(0,0,0,.55);
  -webkit-backdrop-filter:blur(6px); backdrop-filter:blur(6px);
}
.tcdp-overlay.active{ display:flex; }
.tcdp-box{
  background:#fff; width:100%; max-width:800px; border-radius:20px;
  display:flex; overflow:hidden;
  box-shadow:0 20px 50px rgba(0,0,0,.25);
  animation:tcdpFadeUp .4s ease;
}
@keyframes tcdpFadeUp{ from{ opacity:0; transform:translateY(40px);} to{ opacity:1; transform:translateY(0);} }

/* Left panel */
.tcdp-left{ flex:1; background:#FF6B00; color:#fff; padding:40px 24px; }
.tcdp-left h2{ font-family:var(--tc-font-head,inherit); font-size:26px; font-weight:800; margin:0 0 12px; color:#fff; }
.tcdp-left p{ margin:0 0 16px; font-size:16px; color:#fff; }
.tcdp-left ul{ list-style:none; padding:0; margin:0; }
.tcdp-left li{ display:flex; align-items:center; margin:10px 0; font-size:15px; color:#fff; }
.tcdp-left .tcdp-ico{
  flex:0 0 auto; width:32px; height:32px; margin-right:10px; border-radius:50%;
  background:#fff; color:#FF6B00; display:inline-flex; align-items:center; justify-content:center; font-size:15px;
}
.tcdp-wave{ display:inline-block; transform-origin:70% 70%; animation:tcdpWave 1.6s infinite; }
@keyframes tcdpWave{
  0%{transform:rotate(0)} 15%{transform:rotate(14deg)} 30%{transform:rotate(-8deg)}
  45%{transform:rotate(14deg)} 60%{transform:rotate(-4deg)} 75%{transform:rotate(10deg)} 100%{transform:rotate(0)}
}

/* Right panel */
.tcdp-right{
  flex:1.3; padding:40px 32px; position:relative;
  background:linear-gradient(135deg,#fff7ed,#ffedd5);
}
.tcdp-form-title{ font-size:20px; font-weight:700; margin:0 0 18px; color:#1f2937; line-height:1.4; }
.tcdp-form-title span{ color:#FF6B00; font-weight:800; }
.tcdp-close{
  position:absolute; top:18px; right:22px; font-size:26px; line-height:1; cursor:pointer;
  color:#FF6B00; font-weight:bold; background:none; border:0; padding:0;
  transition:transform .3s, color .3s;
}
.tcdp-close:hover{ color:#ef4444; transform:rotate(90deg) scale(1.1); }

/* Form */
#tcdpForm{ display:flex; flex-direction:column; gap:14px; }
#tcdpForm input,
#tcdpForm select{
  padding:12px; border:1px solid #d1d5db; border-radius:10px; font-size:15px;
  font-family:inherit; color:#1f2937; outline:none; background:#fff;
  transition:border .3s, box-shadow .3s;
}
#tcdpForm input::placeholder{ color:#9ca3af; }
#tcdpForm input:focus,
#tcdpForm select:focus{ border-color:#FF6B00; box-shadow:0 0 0 3px rgba(255,107,0,.2); }
.tcdp-submit{
  background:linear-gradient(135deg,#FF6B00,#E55F00); color:#fff; font-weight:700;
  border:none; border-radius:10px; padding:12px; cursor:pointer; font-size:15px; font-family:inherit;
  transition:transform .2s;
}
.tcdp-submit:hover{ transform:scale(1.03); }
.tcdp-submit:disabled{ opacity:.85; cursor:default; transform:none; }
.tcdp-msg{ display:none; padding:10px 13px; border-radius:10px; font-size:14px; }
.tcdp-msg.danger{ background:#fef2f2; color:#b91c1c; border:1px solid #fecaca; }
.tcdp-msg.success{ background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }

/* Responsive */
@media (max-width:768px){
  .tcdp-box{ flex-direction:column; max-width:95%; }
  .tcdp-left, .tcdp-right{ flex:unset; padding:24px 20px; text-align:center; }
  .tcdp-left h2{ font-size:22px; }
  .tcdp-left p{ font-size:14px; }
  .tcdp-left li{ justify-content:center; }
  .tcdp-form-title{ font-size:18px; }
  #tcdpForm input, #tcdpForm select{ font-size:14px; padding:11px; }
  .tcdp-submit{ padding:11px; font-size:14px; }
  .tcdp-close{ top:12px; right:16px; font-size:22px; }
}
</style>

<div id="tcdpOverlay" class="tcdp-overlay" aria-hidden="true">
  <div class="tcdp-box" role="dialog" aria-modal="true" aria-labelledby="tcdpTitle">
    <!-- Left section -->
    <div class="tcdp-left">
      <h2 id="tcdpTitle"><span class="tcdp-wave">&#128075;</span> Wait! Techno Coderz Can Help You</h2>
      <p>Before you go, let Techno Coderz experts assist you with:</p>
      <ul>
        <li><span class="tcdp-ico"><i class="bi bi-signpost-split"></i></span> Personalized Career Roadmap</li>
        <li><span class="tcdp-ico"><i class="bi bi-currency-rupee"></i></span> Budget-Friendly Course Guidance</li>
        <li><span class="tcdp-ico"><i class="bi bi-mortarboard-fill"></i></span> Free Career Counseling</li>
        <li><span class="tcdp-ico"><i class="bi bi-briefcase-fill"></i></span> Placement &amp; Job Support</li>
        <li><span class="tcdp-ico"><i class="bi bi-headset"></i></span> Direct Expert Consultation</li>
      </ul>
    </div>

    <!-- Right section -->
    <div class="tcdp-right">
      <button type="button" class="tcdp-close" id="tcdpClose" aria-label="Close">&times;</button>
      <h3 class="tcdp-form-title">
        Ready to start your learning journey?<br>
        <span>Book your free demo now!</span>
      </h3>
      <form id="tcdpForm" novalidate>
        <input type="hidden" name="csrf_token" id="tcdpCsrf" value="<?= e($__popupCsrf) ?>">
        <input type="text" name="name" placeholder="Full Name" required minlength="2" maxlength="60" autocomplete="name">
        <input type="tel" name="phone" placeholder="Phone Number" required pattern="[0-9]{10}" maxlength="10" inputmode="numeric" autocomplete="tel">
        <select name="course" required>
          <option value="">Select Course...</option>
          <?php foreach ($__popupCourses as $__pc): ?>
          <option value="<?= e($__pc['title']) ?>"><?= e($__pc['title']) ?></option>
          <?php endforeach; ?>
          <option value="Other">Other</option>
        </select>
        <div class="tcdp-msg" id="tcdpMsg"></div>
        <button type="submit" class="tcdp-submit">Submit</button>
      </form>
    </div>
  </div>
</div>

<script>
(function () {
  'use strict';
  var overlay = document.getElementById('tcdpOverlay');
  if (!overlay) return;

  window.TC_BASE_URL = window.TC_BASE_URL || '<?= SITE_URL ?>';

  function openPopup() {
    overlay.classList.add('active');
    overlay.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    try { sessionStorage.setItem('tcdpShown', 'true'); } catch (e) {}
  }
  function closePopup() {
    overlay.classList.remove('active');
    overlay.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }
  window.openDemoPopup = openPopup;

  // Auto-open only on the homepage (which opts in via $__popupAuto), after 1s.
  if (<?= $__popupAutoOpen ? 'true' : 'false' ?>) {
    setTimeout(openPopup, 1000);
  }

  document.getElementById('tcdpClose').addEventListener('click', closePopup);
  overlay.addEventListener('click', function (e) { if (e.target === overlay) closePopup(); });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && overlay.classList.contains('active')) closePopup();
  });

  var form = document.getElementById('tcdpForm');
  if (!form) return;
  var msgBox = document.getElementById('tcdpMsg');
  var field = function (n) { return form.querySelector('[name="' + n + '"]'); };

  function showMsg(text, type) {
    msgBox.textContent = text;
    msgBox.className = 'tcdp-msg ' + (type || 'danger');
    msgBox.style.display = 'block';
  }

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    msgBox.style.display = 'none';

    var name   = (field('name').value || '').trim();
    var phone  = (field('phone').value || '').replace(/\D/g, '');
    var course = field('course').value || '';

    if (name.length < 2) { showMsg('Please enter your full name.', 'danger'); return; }
    if (!/^[0-9]{10}$/.test(phone)) { showMsg('Please enter a valid 10-digit phone number.', 'danger'); return; }
    if (!course) { showMsg('Please select a course.', 'danger'); return; }

    var btn = form.querySelector('.tcdp-submit');
    var original = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = 'Submitting...';

    var fd = new FormData();
    fd.append('name', name);
    fd.append('phone', phone);
    fd.append('course', course);
    fd.append('message', 'Course enquiry via homepage popup.');
    fd.append('csrf_token', document.getElementById('tcdpCsrf').value);

    fetch(window.TC_BASE_URL + '/ajax/enquiry.php', { method: 'POST', body: fd })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data && data.success) {
          btn.innerHTML = '&#10003; Submitted!';
          btn.style.background = 'linear-gradient(135deg,#22c55e,#16a34a)';
          if (typeof window.tcToast === 'function') {
            window.tcToast('Demo booked! We\'ll contact you shortly.', 'success');
          }
          setTimeout(function () {
            form.reset();
            btn.innerHTML = original;
            btn.style.background = '';
            btn.disabled = false;
            closePopup();
          }, 1800);
        } else {
          btn.disabled = false;
          btn.innerHTML = original;
          showMsg((data && data.message) || 'Something went wrong. Please try again.', 'danger');
        }
      })
      .catch(function () {
        btn.disabled = false;
        btn.innerHTML = original;
        showMsg('Network error. Please check your connection.', 'danger');
      });
  });
})();
</script>
