<?php
// ============================================================
// Techno Coderz — On-open Enquiry / Demo Popup
// Layout & design replicated "same to same" from the enquiry
// modal that auto-opens on techcaddmohali.com:
//   • two-column card (dark left panel + gradient form panel)
//   • "Popular tracks — tap to pick" chip grid
//   • Google review card + "Expert response within 5 minutes."
//   • security verification (math captcha) + success state
// Colours use the Techno Coderz orange token remap already used
// by the rest of the site (index.php Tailwind config).
// Wired to the existing ajax/enquiry.php handler.
// Self-contained: markup + styles + script.
// ============================================================

// ---- Courses for the select + "popular tracks" chips ----
$__eqCourses = [];
try {
    $__eqPdo = getDB();
    $__eqCourses = $__eqPdo->query("SELECT title, slug, icon, category FROM courses WHERE status = 1 ORDER BY sort_order ASC, id ASC")->fetchAll();
} catch (Exception $e) {
    $__eqCourses = [];
}

// Preferred "popular tracks" order (mirrors the six techcadd shows)
$__eqPreferred = [
    'artificial-intelligence-course',
    'advance-certificate-programme-in-generative-ai',
    'data-science-course',
    'mern-stack-course',
    'digital-marketing-course',
    'cyber-security-course',
];
$__eqPopular = [];
foreach ($__eqPreferred as $__slug) {
    foreach ($__eqCourses as $__c) {
        if (($__c['slug'] ?? '') === $__slug) { $__eqPopular[] = $__c; break; }
    }
}
// Top-up / fallback to six using the first active courses
foreach ($__eqCourses as $__c) {
    if (count($__eqPopular) >= 6) break;
    $__dup = false;
    foreach ($__eqPopular as $__p) { if (($__p['slug'] ?? '') === ($__c['slug'] ?? '')) { $__dup = true; break; } }
    if (!$__dup) $__eqPopular[] = $__c;
}

// ---- Contact details (footer may already have loaded them) ----
$__eqPhone = $phone ?? '';
$__eqEmail = $email ?? '';
if (!$__eqPhone || !$__eqEmail) {
    try {
        if (!isset($__eqPdo) || !$__eqPdo) $__eqPdo = getDB();
        foreach ($__eqPdo->query("SELECT setting_key, setting_value FROM site_settings")->fetchAll() as $__s) {
            if ($__s['setting_key'] === 'phone' && !$__eqPhone) $__eqPhone = $__s['setting_value'];
            if ($__s['setting_key'] === 'email' && !$__eqEmail) $__eqEmail = $__s['setting_value'];
        }
    } catch (Exception $e) {}
}
$__eqPhone = $__eqPhone ?: '+91 98765 43210';
$__eqEmail = $__eqEmail ?: 'info@technocoderz.com';

// ---- Google review card data ----
$__eqRating      = 4.8;
$__eqReviewCount = '556+';
try {
    if (!isset($__eqPdo) || !$__eqPdo) $__eqPdo = getDB();
    $__eqRatings = $__eqPdo->query("SELECT rating FROM testimonials WHERE status = 1")->fetchAll(PDO::FETCH_COLUMN);
    $__eqRatings = array_filter(array_map('floatval', $__eqRatings));
    if ($__eqRatings) $__eqRating = round(array_sum($__eqRatings) / count($__eqRatings), 1);
} catch (Exception $e) {}
$__eqReviewUrl = 'https://www.google.com/search?q=' . rawurlencode('Techno Coderz Mohali reviews');

$__eqCsrf     = function_exists('generateCsrfToken') ? generateCsrfToken() : '';
$__eqAutoOpen = !empty($__popupAuto);
?>
<style>
/* ---------- Techno Coderz Enquiry Popup (techcadd-style) ---------- */
.tceq-overlay{
  --eq-navy:#0b1220; --eq-hero800:#3a2410; --eq-hero600:#c2410c;
  --eq-accent:#ff7a00; --eq-glow:#ff8a3d; --eq-yellow:#ffc23d;
  --eq-soft:#ffd9bf; --eq-ink:#0f172a; --eq-bright:#ff8533;
  position:fixed; inset:0; z-index:99998; display:none;
  align-items:center; justify-content:center; padding:16px 24px;
  font-family:var(--tc-font-head,'Plus Jakarta Sans'),sans-serif;
}
.tceq-overlay.tceq-open{ display:flex; }
.tceq-overlay *{ box-sizing:border-box; }
.tceq-backdrop{
  position:absolute; inset:0; width:100%; height:100%; border:0; padding:0;
  background:rgba(11,18,32,.7); cursor:default;
  -webkit-backdrop-filter:blur(6px); backdrop-filter:blur(6px);
}
.tceq-card{
  position:relative; display:grid; grid-template-columns:1fr 1fr;
  width:100%; max-width:56rem; max-height:94svh; overflow:hidden;
  border-radius:1.75rem; box-shadow:0 50px 120px -40px rgba(0,0,0,.85);
  animation:tceqIn .5s cubic-bezier(.34,1.56,.64,1) both;
}
@keyframes tceqIn{ from{ opacity:0; transform:translateY(26px) scale(.96); } to{ opacity:1; transform:none; } }

/* close */
.tceq-close{
  position:absolute; top:20px; right:20px; z-index:20;
  width:40px; height:40px; display:grid; place-items:center;
  border-radius:50%; border:1px solid rgba(255,255,255,.3);
  background:rgba(255,255,255,.15); color:#fff; font-size:1.05rem; line-height:1; cursor:pointer;
  -webkit-backdrop-filter:blur(4px); backdrop-filter:blur(4px);
  transition:background-color .2s ease, transform .2s ease;
}
.tceq-close:hover{ background:rgba(255,255,255,.32); transform:rotate(90deg); }

/* left panel */
.tceq-left{ position:relative; overflow-y:auto; background:var(--eq-navy); padding:24px; color:#fff; }
.tceq-left::before{
  content:""; position:absolute; inset:0; pointer-events:none;
  background:radial-gradient(ellipse 70% 50% at 20% 0%, rgba(194,65,12,.38), transparent 65%);
}
.tceq-gridlines{
  position:absolute; inset:0; pointer-events:none; opacity:.4;
  background-image:linear-gradient(90deg,rgba(255,255,255,.06) 1px,transparent 1px),linear-gradient(rgba(255,255,255,.06) 1px,transparent 1px);
  background-size:64px 64px;
  -webkit-mask-image:radial-gradient(80% 60% at 50% 40%,#000 40%,transparent 100%);
  mask-image:radial-gradient(80% 60% at 50% 40%,#000 40%,transparent 100%);
}
.tceq-left-inner{ position:relative; }
.tceq-left h2{ margin:0; font-size:1.6rem; font-weight:800; line-height:1.2; color:#fff; }
.tceq-wave{ display:inline-block; margin-right:8px; transform-origin:72% 78%; animation:tceqWave 2.6s ease-in-out infinite; }
@keyframes tceqWave{
  0%,62%,100%{ transform:rotate(0); } 10%,30%{ transform:rotate(15deg); }
  20%,40%{ transform:rotate(-9deg); } 50%{ transform:rotate(11deg); }
}
.tceq-sub{ margin:14px 0 0; font-size:.92rem; line-height:1.65; color:rgba(255,217,191,.7); }

/* popular tracks */
.tceq-tracks{ margin-top:24px; }
.tceq-tracks-label{ margin:0; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.16em; color:rgba(255,217,191,.5); }
.tceq-chips{ margin-top:12px; display:grid; grid-template-columns:1fr 1fr; gap:8px; }
.tceq-chip{
  display:flex; align-items:center; gap:10px; padding:10px; text-align:left;
  border-radius:12px; border:1px solid rgba(255,255,255,.12); background:rgba(255,255,255,.06);
  color:rgba(255,217,191,.75); font-family:inherit; font-size:.78rem; font-weight:600; line-height:1.25;
  cursor:pointer; transition:border-color .2s, background-color .2s, color .2s;
}
.tceq-chip:hover{ border-color:rgba(255,255,255,.25); background:rgba(255,255,255,.1); color:#fff; }
.tceq-chip.is-active{ border-color:rgba(255,138,61,.7); background:rgba(255,138,61,.15); color:#fff; }
.tceq-chip-ico{
  flex:0 0 auto; width:28px; height:28px; display:grid; place-items:center; border-radius:8px;
  background:rgba(255,255,255,.1); color:var(--eq-glow); font-size:.8rem; transition:background-color .2s, color .2s;
}
.tceq-chip.is-active .tceq-chip-ico{ background:var(--eq-glow); color:var(--eq-navy); }
.tceq-chip-txt{ min-width:0; }
.tceq-chip-tick{ margin-left:auto; flex:0 0 auto; display:none; color:var(--eq-glow); font-size:.9rem; }
.tceq-chip.is-active .tceq-chip-tick{ display:inline-block; }
.tceq-hint{ margin:10px 0 0; font-size:.76rem; color:rgba(255,217,191,.45); }

/* google card */
.tceq-google{
  margin-top:24px; display:flex; align-items:center; justify-content:space-between; gap:16px;
  padding:12px 16px; border-radius:16px; background:#fff; text-decoration:none;
  transition:transform .25s ease;
}
.tceq-google:hover{ transform:translateY(-2px); }
.tceq-google-l{ display:flex; align-items:center; gap:10px; min-width:0; }
.tceq-google-l svg{ flex:0 0 auto; }
.tceq-google-t{ display:flex; align-items:center; gap:6px; font-size:.88rem; font-weight:700; color:var(--eq-ink); }
.tceq-google-t i{ color:var(--eq-bright); font-size:.85rem; }
.tceq-google-s{ display:block; margin-top:2px; font-size:.72rem; color:rgba(15,23,42,.55); }
.tceq-google-r{ display:flex; align-items:center; gap:6px; flex:0 0 auto; }
.tceq-stars{ display:inline-flex; gap:2px; color:var(--eq-yellow); font-size:.75rem; }
.tceq-google-r .bi-arrow-up-right{ color:rgba(15,23,42,.35); transition:color .2s; }
.tceq-google:hover .tceq-google-r .bi-arrow-up-right{ color:var(--eq-ink); }
.tceq-note{ margin:16px 0 0; font-size:.8rem; line-height:1.6; color:rgba(255,217,191,.55); }
.tceq-note a{ color:#fff; font-weight:600; text-decoration:underline; }

/* right panel (form) */
.tceq-right{
  position:relative; overflow-y:auto; padding:24px;
  background:linear-gradient(135deg,var(--eq-hero800) 0%,var(--eq-hero600) 55%,var(--eq-accent) 100%);
}
.tceq-form-title{ margin:0; max-width:24rem; padding-right:48px; font-size:1.2rem; font-weight:800; line-height:1.3; color:#fff; }
.tceq-fields{ margin-top:20px; }
.tceq-fields > * + *{ margin-top:10px; }
.tceq-fields input,
.tceq-fields select{
  width:100%; padding:12px 20px; border-radius:16px;
  border:1px solid rgba(255,255,255,.25); background:rgba(255,255,255,.12);
  font-family:inherit; font-size:.95rem; color:#fff; outline:none;
  transition:border-color .2s, background-color .2s;
}
.tceq-fields input::placeholder{ color:rgba(255,255,255,.6); }
.tceq-fields input:focus,
.tceq-fields select:focus{ border-color:rgba(255,255,255,.6); background:rgba(255,255,255,.2); }
.tceq-fields select{ appearance:none; -webkit-appearance:none; padding-right:48px; cursor:pointer; }
.tceq-fields select option{ color:var(--eq-ink); }
.tceq-select-wrap{ position:relative; }
.tceq-chevron{ position:absolute; right:20px; top:50%; transform:translateY(-50%); color:rgba(255,255,255,.7); pointer-events:none; font-size:.85rem; }
.tceq-sec{ display:flex; flex-wrap:wrap; align-items:center; gap:10px; padding-top:2px; }
.tceq-sec-label{ font-size:.85rem; font-weight:600; color:#fff; }
.tceq-sec-pill{
  padding:4px 14px; border-radius:999px; background:rgba(255,255,255,.2); color:#fff;
  font-family:ui-monospace,SFMono-Regular,Menlo,Consolas,monospace; font-size:.85rem; font-weight:700; letter-spacing:.05em;
}
.tceq-refresh{
  width:32px; height:32px; display:grid; place-items:center; border-radius:50%;
  border:1px solid rgba(255,255,255,.3); background:transparent; color:#fff; font-size:.8rem; cursor:pointer;
  transition:background-color .2s;
}
.tceq-refresh:hover{ background:rgba(255,255,255,.2); }
.tceq-promise{
  margin:14px 0 0; display:flex; align-items:center; gap:10px;
  padding:12px 20px; border-radius:16px; background:var(--eq-glow); color:var(--eq-navy);
  font-size:.88rem; font-weight:700;
}
.tceq-error{ margin:10px 0 0; font-size:.82rem; font-weight:600; color:var(--eq-yellow); }
.tceq-error[hidden]{ display:none; }
.tceq-submit{
  margin-top:16px; display:inline-flex; align-items:center; gap:8px;
  padding:12px 32px; border:0; border-radius:999px; cursor:pointer;
  background:var(--eq-yellow); color:var(--eq-navy);
  font-family:inherit; font-size:.92rem; font-weight:700;
  box-shadow:0 18px 40px -18px rgba(255,194,61,.6);
  transition:transform .2s, background-color .2s, box-shadow .2s;
}
.tceq-submit:hover{ transform:translateY(-2px); background:#ffd36b; }
.tceq-submit:disabled{ opacity:.6; cursor:default; transform:none; }
.tceq-submit i{ transition:transform .2s; }
.tceq-submit:hover i{ transform:translateX(4px); }

/* success state */
.tceq-done{ min-height:22rem; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; }
.tceq-done[hidden]{ display:none; }
.tceq-done-ico{ width:64px; height:64px; display:grid; place-items:center; border-radius:50%; background:#fff; color:var(--eq-hero600); font-size:1.8rem; }
.tceq-done-t{ margin:24px 0 0; font-size:1.5rem; font-weight:800; color:#fff; }
.tceq-done-s{ margin:12px 0 0; max-width:20rem; font-size:.92rem; line-height:1.6; color:rgba(255,255,255,.75); }
.tceq-done-s a{ color:#fff; font-weight:700; text-decoration:underline; }
.tceq-done-btn{
  margin-top:32px; padding:12px 28px; border:0; border-radius:999px; background:#fff; color:var(--eq-hero600);
  font-family:inherit; font-size:.88rem; font-weight:700; cursor:pointer; transition:transform .2s;
}
.tceq-done-btn:hover{ transform:translateY(-2px); }

@media (min-width:640px){
  .tceq-left, .tceq-right{ padding:32px; }
  .tceq-left h2{ font-size:1.9rem; }
  .tceq-form-title{ font-size:1.4rem; }
}
@media (max-width:767px){
  /* Full-screen sheet: form first, marketing below, close always reachable */
  .tceq-overlay{ padding:0; }
  .tceq-card{
    display:flex; flex-direction:column;
    width:100%; max-width:100%;
    height:100dvh; max-height:100dvh;
    border-radius:0;
    overflow-y:auto;
  }
  .tceq-right{ order:1; overflow:visible; }
  .tceq-left{ order:2; overflow:visible; }
  .tceq-fields input,
  .tceq-fields select{ font-size:16px; } /* >=16px stops iOS from zooming the field on focus */
  .tceq-close{
    position:fixed; top:14px; right:14px;
    background:rgba(11,18,32,.55); border-color:rgba(255,255,255,.4);
  }
}
@media (prefers-reduced-motion: reduce){
  .tceq-card{ animation:none; }
  .tceq-wave{ animation:none; }
}
</style>

<div id="tceqOverlay" class="tceq-overlay" aria-hidden="true">
  <button type="button" class="tceq-backdrop" id="tceqBackdrop" aria-label="Close" tabindex="-1"></button>

  <div class="tceq-card" role="dialog" aria-modal="true" aria-labelledby="tceqTitle">
    <button type="button" class="tceq-close" id="tceqClose" aria-label="Close enquiry form"><i class="bi bi-x-lg"></i></button>

    <!-- Left panel -->
    <div class="tceq-left">
      <span class="tceq-gridlines" aria-hidden="true"></span>
      <div class="tceq-left-inner">
        <h2 id="tceqTitle"><span class="tceq-wave" aria-hidden="true">&#128075;</span> Still exploring? Let us help</h2>
        <p class="tceq-sub">Talk to a counsellor and we'll map the shortest route from where you are to the job you want.</p>

        <div class="tceq-tracks">
          <p class="tceq-tracks-label">Popular tracks &mdash; tap to pick</p>
          <div class="tceq-chips" id="tceqChips">
            <?php foreach ($__eqPopular as $__c): $__icon = trim((string) ($__c['icon'] ?? '')) ?: 'bi bi-book'; ?>
            <button type="button" class="tceq-chip" data-course="<?= e($__c['title']) ?>">
              <span class="tceq-chip-ico"><i class="<?= e($__icon) ?>"></i></span>
              <span class="tceq-chip-txt"><?= e($__c['title']) ?></span>
              <i class="bi bi-check-lg tceq-chip-tick" aria-hidden="true"></i>
            </button>
            <?php endforeach; ?>
          </div>
          <p class="tceq-hint">Not here? The dropdown lists all <?= count($__eqCourses) ?> courses.</p>
        </div>

        <a class="tceq-google" href="<?= e($__eqReviewUrl) ?>" target="_blank" rel="noreferrer">
          <span class="tceq-google-l">
            <svg viewBox="0 0 24 24" width="22" height="22" role="img" aria-label="Google"><path fill="#4285F4" d="M21.6 12.23c0-.75-.07-1.47-.19-2.16H12v4.09h5.38a4.6 4.6 0 0 1-2 3.02v2.5h3.24c1.89-1.74 2.98-4.3 2.98-7.45Z"/><path fill="#34A853" d="M12 22c2.7 0 4.96-.9 6.62-2.42l-3.24-2.5c-.9.6-2.05.96-3.38.96-2.6 0-4.8-1.76-5.59-4.12H3.06v2.58A10 10 0 0 0 12 22Z"/><path fill="#FBBC05" d="M6.41 13.92a5.99 5.99 0 0 1 0-3.84V7.5H3.06a10 10 0 0 0 0 9l3.35-2.58Z"/><path fill="#EA4335" d="M12 5.96c1.47 0 2.79.5 3.83 1.5l2.87-2.87C16.95 2.99 14.7 2 12 2A10 10 0 0 0 3.06 7.5l3.35 2.58C7.2 7.72 9.4 5.96 12 5.96Z"/></svg>
            <span>
              <span class="tceq-google-t">Google Verified <i class="bi bi-patch-check-fill"></i></span>
              <span class="tceq-google-s"><?= e($__eqRating) ?> from <?= e($__eqReviewCount) ?> reviews</span>
            </span>
          </span>
          <span class="tceq-google-r">
            <span class="tceq-stars">
              <?php for ($__i = 0; $__i < 5; $__i++): ?><i class="bi bi-star-fill"></i><?php endfor; ?>
            </span>
            <i class="bi bi-arrow-up-right"></i>
          </span>
        </a>

        <p class="tceq-note">You can also share your requirements at <a href="mailto:<?= e($__eqEmail) ?>"><?= e($__eqEmail) ?></a>, and our team will get back to you right away.</p>
      </div>
    </div>

    <!-- Right panel -->
    <div class="tceq-right">
      <form id="tceqForm" novalidate>
        <input type="hidden" name="csrf_token" value="<?= e($__eqCsrf) ?>">
        <p class="tceq-form-title">Tell us your goal. We'll map it to a track.</p>

        <div class="tceq-fields">
          <div class="tceq-select-wrap">
            <select name="course" id="tceqCourse" aria-label="Course of interest" required>
              <option value="" selected disabled>Select Your Course of Interest*</option>
              <?php foreach ($__eqCourses as $__c): ?>
              <option value="<?= e($__c['title']) ?>"><?= e($__c['title']) ?></option>
              <?php endforeach; ?>
            </select>
            <i class="bi bi-chevron-down tceq-chevron" aria-hidden="true"></i>
          </div>
          <input type="text" name="name" placeholder="Full Name*" autocomplete="name" required>
          <input type="tel" name="phone" inputmode="numeric" autocomplete="tel" placeholder="Contact Number (10 Digits)*" required>
          <div class="tceq-sec">
            <span class="tceq-sec-label">Security verification</span>
            <span class="tceq-sec-pill" id="tceqCaptcha">3 + 4 = ?</span>
            <button type="button" class="tceq-refresh" id="tceqRefresh" aria-label="New security question"><i class="bi bi-arrow-clockwise"></i></button>
          </div>
          <input type="text" name="answer" inputmode="numeric" autocomplete="off" placeholder="Answer" required>
        </div>

        <p class="tceq-promise"><i class="bi bi-check-circle-fill"></i> Expert response within 5 minutes.</p>
        <p class="tceq-error" id="tceqError" role="alert" hidden></p>
        <button type="submit" class="tceq-submit" id="tceqSubmit">Submit <i class="bi bi-arrow-right"></i></button>
      </form>

      <div class="tceq-done" id="tceqDone" hidden>
        <span class="tceq-done-ico"><i class="bi bi-check-circle-fill"></i></span>
        <p class="tceq-done-t">Thanks &mdash; we have your details.</p>
        <p class="tceq-done-s">A counsellor will call you shortly. If it is urgent, ring us on <a href="tel:<?= e(preg_replace('/\s+/', '', $__eqPhone)) ?>"><?= e($__eqPhone) ?></a>.</p>
        <button type="button" class="tceq-done-btn" id="tceqDoneClose">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
(function () {
  'use strict';
  var overlay = document.getElementById('tceqOverlay');
  if (!overlay) return;

  window.TC_BASE_URL = window.TC_BASE_URL || '<?= SITE_URL ?>';

  var AUTO_DELAY = 1000;

  var card       = overlay.querySelector('.tceq-card');
  var closeBtn   = document.getElementById('tceqClose');
  var backdrop   = document.getElementById('tceqBackdrop');
  var form       = document.getElementById('tceqForm');
  var doneBox    = document.getElementById('tceqDone');
  var doneClose  = document.getElementById('tceqDoneClose');
  var errorBox   = document.getElementById('tceqError');
  var submitBtn  = document.getElementById('tceqSubmit');
  var courseSel  = document.getElementById('tceqCourse');
  var captchaEl  = document.getElementById('tceqCaptcha');
  var refreshBtn = document.getElementById('tceqRefresh');
  var chips      = Array.prototype.slice.call(overlay.querySelectorAll('.tceq-chip'));
  var captcha    = [0, 0];
  var lastFocus  = null;
  var submitHTML = 'Submit <i class="bi bi-arrow-right"></i>';

  function newCaptcha() {
    captcha = [2 + Math.floor(Math.random() * 8), 2 + Math.floor(Math.random() * 8)];
    if (captchaEl) captchaEl.textContent = captcha[0] + ' + ' + captcha[1] + ' = ?';
  }

  function syncChips() {
    var val = courseSel ? courseSel.value : '';
    chips.forEach(function (chip) {
      chip.classList.toggle('is-active', !!val && chip.getAttribute('data-course') === val);
    });
  }

  function showError(text) {
    if (!errorBox) return;
    if (!text) { errorBox.hidden = true; errorBox.textContent = ''; return; }
    errorBox.hidden = false;
    errorBox.textContent = text;
  }

  function resetState() {
    if (form) form.reset();
    showError('');
    syncChips();
    newCaptcha();
    if (form) form.hidden = false;
    if (doneBox) doneBox.hidden = true;
    if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = submitHTML; }
  }

  function openPopup(course) {
    if (course && courseSel) {
      for (var i = 0; i < courseSel.options.length; i++) {
        if (courseSel.options[i].value === course || courseSel.options[i].text === course) {
          courseSel.selectedIndex = i;
          syncChips();
          break;
        }
      }
    }
    lastFocus = document.activeElement;
    overlay.classList.add('tceq-open');
    overlay.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    if (courseSel) setTimeout(function () { try { courseSel.focus(); } catch (e) {} }, 60);
  }

  function closePopup() {
    overlay.classList.remove('tceq-open');
    overlay.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    if (lastFocus && lastFocus.focus) { try { lastFocus.focus(); } catch (e) {} }
    if (doneBox && !doneBox.hidden) resetState();
  }

  window.openDemoPopup = openPopup;

  // Route the site-wide openEnquiry() CTAs to this popup (same design everywhere)
  window.openEnquiry = function (course) { openPopup(course || ''); };

  // Auto-open: ?enquiry=1 / #enquiry opens at once; otherwise on the homepage after 1s
  (function () {
    var forced = (new URLSearchParams(window.location.search)).get('enquiry') === '1' || window.location.hash === '#enquiry';
    if (forced) { openPopup(''); return; }
    if (!<?= $__eqAutoOpen ? 'true' : 'false' ?>) return;
    setTimeout(function () { openPopup(''); }, AUTO_DELAY);
  })();

  if (refreshBtn) refreshBtn.addEventListener('click', newCaptcha);

  chips.forEach(function (chip) {
    chip.addEventListener('click', function () {
      if (!courseSel) return;
      var val = chip.getAttribute('data-course') || '';
      courseSel.value = (courseSel.value === val) ? '' : val;
      showError('');
      syncChips();
    });
  });
  if (courseSel) courseSel.addEventListener('change', function () { showError(''); syncChips(); });

  if (closeBtn) closeBtn.addEventListener('click', closePopup);
  if (backdrop) backdrop.addEventListener('click', closePopup);
  if (doneClose) doneClose.addEventListener('click', closePopup);

  document.addEventListener('keydown', function (e) {
    if (!overlay.classList.contains('tceq-open')) return;
    if (e.key === 'Escape') { closePopup(); return; }
    if (e.key !== 'Tab' || !card) return;
    var f = Array.prototype.filter.call(
      card.querySelectorAll('a[href],button:not([disabled]),input,select,textarea,[tabindex]:not([tabindex="-1"])'),
      function (el) { return el.offsetParent !== null; }
    );
    if (!f.length) return;
    var first = f[0], last = f[f.length - 1];
    if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
    else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
  });

  newCaptcha();
  syncChips();

  if (!form) return;

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    showError('');

    var data   = new FormData(form);
    var name   = String(data.get('name') || '').trim();
    var phone  = String(data.get('phone') || '').replace(/\D/g, '');
    var course = String(data.get('course') || '').trim();
    var answer = String(data.get('answer') || '').trim();

    if (!course) { showError('Please choose a course.'); return; }
    if (name.length < 2) { showError('Please enter your full name.'); return; }
    if (!/^[0-9]{10}$/.test(phone)) { showError('Enter a 10-digit mobile number.'); return; }
    if (Number(answer) !== captcha[0] + captcha[1]) { showError('That security answer is not right.'); newCaptcha(); return; }

    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Sending\u2026';

    var fd = new FormData();
    fd.append('name', name);
    fd.append('phone', phone);
    fd.append('course', course);
    fd.append('message', 'Course enquiry via website popup.');
    fd.append('csrf_token', data.get('csrf_token') || '');

    fetch(window.TC_BASE_URL + '/ajax/enquiry.php', { method: 'POST', body: fd })
      .then(function (r) { return r.json(); })
      .then(function (res) {
        if (res && res.success) {
          form.hidden = true;
          doneBox.hidden = false;
          if (typeof window.tcToast === 'function') window.tcToast("Thanks! We'll call you shortly.", 'success');
        } else {
          submitBtn.disabled = false;
          submitBtn.innerHTML = submitHTML;
          showError((res && res.message) || 'Could not send that just now.');
          newCaptcha();
        }
      })
      .catch(function () {
        submitBtn.disabled = false;
        submitBtn.innerHTML = submitHTML;
        showError('Network error. Please try again.');
      });
  });
})();
</script>
