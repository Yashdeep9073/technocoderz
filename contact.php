<?php
// ============================================================
// Techno Coderz — Contact Page
// ============================================================
require_once __DIR__ . '/includes/functions.php';

$pageTitle       = 'Contact Us – Techno Coderz';
$pageDescription = 'Get in touch with TechnoCoderz — call us, email us or visit our office in Mohali, Punjab. Send an enquiry about any course and we will respond within 24 hours.';
$currentPage     = 'contact';
$csrf            = generateCsrfToken();

// Fetch settings
$pdo = getDB();
$settings = [];
$stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
while ($row = $stmt->fetch()) {
    if (trim($row['setting_value'] ?? '') !== '') {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
}

$contactPhone  = $settings['phone']  ?? '+91 98765 43210';
$contactPhone2 = $settings['phone2'] ?? '';
$contactEmail  = $settings['email']  ?? 'info@technocoderz.com';
$contactEmail2 = $settings['email2'] ?? '';
$contactAddr   = $settings['address'] ?? 'Office No. 36, Second Floor, D-185, Phase 8B, Sector 74, Sahibzada Ajit Singh Nagar, Mohali, Punjab 160055';
$contactCity   = $settings['location'] ?? 'Mohali, Punjab';
$mapUrl        = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($contactAddr);

// Course dropdown options
$courses = $pdo->query("SELECT title FROM courses WHERE status = 1 ORDER BY sort_order ASC, id ASC")->fetchAll();

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<script>window.TC_BASE_URL = '<?= SITE_URL ?>';</script>
<script>document.addEventListener('DOMContentLoaded',function(){var c=document.getElementById('ctCsrf');if(c)c.value='<?=e($csrf)?>';});</script>

<div class="tc-page-light tc-contact-page">

<!-- Page Hero -->
<div class="tc-page-hero">
  <div class="container text-center reveal">
    <ul class="tc-breadcrumb">
      <li><a href="<?= SITE_URL ?>"><i class="bi bi-house-fill"></i> Home</a></li>
      <li class="sep">/</li>
      <li class="current">Contact Us</li>
    </ul>
    <h1 class="tc-section-title" style="margin-bottom:10px;">Get In <span>Touch</span></h1>
    <p style="font-size:1.05rem; max-width:620px; margin:0 auto;">
      Have a question about our courses, need a quote, or just want to say hello? Our team replies within 24 hours.
    </p>
  </div>
</div>

<!-- Contact Info Cards (FiStudy contact-two "Our Address") -->
<section class="tc-section" style="padding:56px 0 0;">
  <div class="container">
    <div class="tc-contact-cards reveal">
      <div class="tc-contact-info--top">
        <div class="tc-contact-icon"><i class="bi bi-telephone-fill"></i></div>
        <div>
          <h3>Call Us</h3>
          <p><a class="tc-link" href="tel:<?= e(preg_replace('/\s+/', '', $contactPhone)) ?>"><?= e($contactPhone) ?></a></p>
          <p style="font-size:.78rem;">Mon – Sat, 9:00 AM – 7:00 PM</p>
        </div>
      </div>
      <div class="tc-contact-info--top">
        <div class="tc-contact-icon"><i class="bi bi-envelope-fill"></i></div>
        <div>
          <h3>Email Us</h3>
          <p><a class="tc-link" href="mailto:<?= e($contactEmail) ?>"><?= e($contactEmail) ?></a></p>
          <p style="font-size:.78rem;">We reply within 24 hours</p>
        </div>
      </div>
      <div class="tc-contact-info--top">
        <div class="tc-contact-icon"><i class="bi bi-geo-alt-fill"></i></div>
        <div>
          <h3>Visit Us</h3>
          <p><?= e($contactCity) ?>, Punjab</p>
          <p style="font-size:.78rem;">Sahibzada Ajit Singh Nagar, India</p>
        </div>
      </div>
      <div class="tc-contact-info--top">
        <div class="tc-contact-icon"><i class="bi bi-clock-fill"></i></div>
        <div>
          <h3>Working Hours</h3>
          <p>Mon – Sat</p>
          <p style="font-size:.78rem;">9:00 AM – 7:00 PM</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Contact Content -->
<section class="tc-section">
  <div class="container">
    <div class="row g-5">

      <!-- Enquiry Form -->
      <div class="col-lg-7 reveal">
        <div class="tc-form-panel">
          <h2 style="font-size:1.75rem; margin-bottom:8px;">
            <i class="bi bi-chat-dots-fill me-2" style="color:var(--primary-orange)"></i>Send Us an Enquiry
          </h2>
          <p style="font-size:0.98rem; color:var(--text-muted); margin-bottom:26px;">
            Fill in the details below and our course counselor will call you back.
          </p>

          <div id="contactMsg" class="mb-3" style="display:none"></div>

          <form id="contactForm" onsubmit="event.preventDefault(); submitContact();" novalidate>
            <input type="hidden" name="csrf_token" id="ctCsrf" value="<?= e($csrf) ?>">

            <div class="row g-3">
              <div class="col-md-6">
                <label for="ctName" class="tc-form-label">Full Name <span style="color:var(--primary-orange)">*</span></label>
                <input type="text" id="ctName" name="name" class="tc-form-control" placeholder="e.g. Rahul Sharma" required>
              </div>
              <div class="col-md-6">
                <label for="ctEmail" class="tc-form-label">Email Address <span style="color:var(--primary-orange)">*</span></label>
                <input type="email" id="ctEmail" name="email" class="tc-form-control" placeholder="you@example.com" required>
              </div>
              <div class="col-md-6">
                <label for="ctPhone" class="tc-form-label">Mobile Number <span style="color:var(--primary-orange)">*</span></label>
                <input type="tel" id="ctPhone" name="phone" class="tc-form-control" placeholder="+91 98765 43210" required>
              </div>
              <div class="col-md-6">
                <label for="ctCourse" class="tc-form-label">Select Course <span style="color:var(--primary-orange)">*</span></label>
                <select id="ctCourse" name="course" class="tc-form-control" required>
                  <option value="">-- Select a Course --</option>
                  <?php foreach ($courses as $c): ?>
                  <option value="<?= e($c['title']) ?>"><?= e($c['title']) ?></option>
                  <?php endforeach; ?>
                  <option value="Other / Not Sure">Other / Not Sure</option>
                </select>
              </div>
              <div class="col-12">
                <label for="ctMessage" class="tc-form-label">Message <span style="color:var(--primary-orange)">*</span></label>
                <textarea id="ctMessage" name="message" class="tc-form-control" rows="5" placeholder="Tell us about your background, goals or any specific questions..." required></textarea>
              </div>
              <div class="col-12 mt-4">
                <button type="submit" id="submitContact" class="tc-btn tc-btn-cta tc-btn-lg" style="justify-content:center;">
                  <i class="bi bi-send-fill"></i> Send Enquiry
                </button>
                <p style="font-size:0.78rem; color:var(--text-muted); margin:14px 0 0;">
                  <i class="bi bi-shield-check me-1"></i> Your details stay private — we never share them with third parties.
                </p>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Contact Info / Quick Help -->
      <div class="col-lg-5 reveal">

        <div class="d-flex flex-column gap-3">

          <!-- Talk to a counselor -->
          <div class="tc-form-panel tc-help-panel">
            <span class="tc-help-icon"><i class="bi bi-headset"></i></span>
            <h3 style="margin:6px 0 8px;">Talk to a Course Counselor</h3>
            <p>Prefer a quick call? Our admissions team will help you pick the right course, check batch availability and explain fees.</p>
            <a href="tel:<?= e(preg_replace('/\s+/', '', $contactPhone)) ?>" class="tc-btn tc-btn-cta tc-btn-lg" style="width:100%; justify-content:center;">
              <i class="bi bi-telephone-fill"></i> <?= e($contactPhone) ?>
            </a>
            <?php if ($contactPhone2 !== ''): ?>
            <p style="margin-top:8px; font-size:.86rem; color:var(--text-muted);">
              Support: <a class="tc-link" href="tel:<?= e(preg_replace('/\s+/', '', $contactPhone2)) ?>"><?= e($contactPhone2) ?></a>
            </p>
            <?php endif; ?>
            <p style="font-size:.78rem; color:var(--text-muted); margin:12px 0 0;">
              <i class="bi bi-clock me-1"></i> Mon – Sat, 9:00 AM – 7:00 PM
            </p>
          </div>

          <!-- Directions (link only — no fake map embed) -->
          <div class="tc-form-panel" style="padding:24px;">
            <h3 style="font-size:1.05rem; margin-bottom:10px;">Get Directions</h3>
            <p style="font-size:.9rem; color:var(--text-muted); line-height:1.7; margin:0 0 16px;"><?= e($contactAddr) ?></p>
            <a href="<?= e($mapUrl) ?>" target="_blank" rel="noopener" class="tc-btn tc-btn-secondary" style="width:100%; justify-content:center;">
              <i class="bi bi-map me-1"></i> Open in Google Maps
            </a>
          </div>

          <!-- Social -->
          <div class="tc-form-panel" style="padding:24px; text-align:center;">
            <h3 style="font-size:1.05rem; margin-bottom:14px;">Follow Us</h3>
            <div class="d-flex gap-3 justify-content-center">
              <a href="<?= e($settings['facebook'] ?? '#') ?>" target="_blank" rel="noopener" aria-label="Facebook" class="tc-contact-icon" style="width:44px;height:44px;font-size:1.1rem;"><i class="bi bi-facebook"></i></a>
              <a href="<?= e($settings['instagram'] ?? '#') ?>" target="_blank" rel="noopener" aria-label="Instagram" class="tc-contact-icon" style="width:44px;height:44px;font-size:1.1rem;"><i class="bi bi-instagram"></i></a>
              <a href="<?= e($settings['linkedin'] ?? '#') ?>" target="_blank" rel="noopener" aria-label="LinkedIn" class="tc-contact-icon" style="width:44px;height:44px;font-size:1.1rem;"><i class="bi bi-linkedin"></i></a>
              <a href="<?= e($settings['youtube'] ?? '#') ?>" target="_blank" rel="noopener" aria-label="YouTube" class="tc-contact-icon" style="width:44px;height:44px;font-size:1.1rem;"><i class="bi bi-youtube"></i></a>
            </div>
          </div>

        </div>
      </div>

    </div><!-- /row -->
  </div>
</section>

<!-- Quick CTA -->
<section class="tc-section" style="padding-top:0;">
  <div class="container">
    <div class="tc-cta-card reveal">
      <div class="tc-cta-card-body">
        <span class="tc-badge"><i class="bi bi-file-earmark-pdf-fill"></i> Official Curriculum</span>
        <h2 class="tc-section-title" style="margin:14px 0 10px;">Want To See The Full<br><span>Curriculum First</span>?</h2>
        <p style="color:var(--text-muted); font-size:1.02rem; max-width:560px; margin:0;">
          Download the official TechnoCoderz brochure with course modules, durations and programme highlights.
        </p>
      </div>
      <div class="tc-cta-card-actions">
        <a href="<?= SITE_URL ?>/brochure.php" class="tc-btn tc-btn-cta tc-btn-lg">
          <i class="bi bi-download"></i> Download Brochure
        </a>
        <a href="tel:<?= e(preg_replace('/\s+/', '', $contactPhone)) ?>" class="tc-btn tc-btn-outline-dark tc-btn-lg">
          <i class="bi bi-telephone-fill"></i> <?= e($contactPhone) ?>
        </a>
      </div>
    </div>
  </div>
</section>

</div><!-- /.tc-page-light -->

<?php require_once __DIR__ . '/includes/footer.php'; ?>
