<?php
// ============================================================
// Techno Coderz — Footer Include
// ============================================================
// Fetch quick settings + courses from DB
$footerSettings = [];
$footerCourses  = [];
try {
    $pdo = getDB();
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
    while ($row = $stmt->fetch()) {
        $footerSettings[$row['setting_key']] = $row['setting_value'];
    }
    $footerCourses = $pdo->query("SELECT title, slug FROM courses WHERE status = 1 ORDER BY sort_order ASC, id ASC")->fetchAll();
} catch (Exception $e) {
    $footerSettings = $footerSettings ?: [];
}

$phone   = $footerSettings['phone']   ?? '+91 98765 43210';
$email   = $footerSettings['email']   ?? 'info@technocoderz.com';
$address = $footerSettings['address'] ?? 'Mohali, Punjab, India';
$fb      = $footerSettings['facebook']  ?? '#';
$ig      = $footerSettings['instagram'] ?? '#';
$li      = $footerSettings['linkedin']  ?? '#';
$yt      = $footerSettings['youtube']   ?? '#';
$tw      = $footerSettings['twitter']   ?? '#';
$mapQuery = rawurlencode($address);
?>

<!-- Enquiry Modal -->
<div class="modal fade" id="enquiryModal" tabindex="-1" aria-labelledby="enquiryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div>
          <h5 class="modal-title" id="enquiryModalLabel">
            <i class="bi bi-send-fill me-2" style="color:var(--tc-secondary)"></i>Course Enquiry
          </h5>
          <p style="font-size:0.8rem;color:var(--tc-text-muted);margin:4px 0 0">We'll get back to you within 24 hours</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="enquiryMsg" class="mb-3" style="display:none"></div>
        <form id="enquiryForm" novalidate>
          <input type="hidden" name="csrf_token" id="enquiryCsrf" value="">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="tc-form-label">Your Full Name <span style="color:var(--tc-accent)">*</span></label>
              <input type="text" id="enqName" name="name" class="tc-form-control" placeholder="e.g. Rahul Sharma" required>
            </div>
            <div class="col-md-6">
              <label class="tc-form-label">Email Address <span style="color:var(--tc-accent)">*</span></label>
              <input type="email" id="enqEmail" name="email" class="tc-form-control" placeholder="you@example.com" required>
            </div>
            <div class="col-md-6">
              <label class="tc-form-label">Phone Number</label>
              <input type="tel" id="enqPhone" name="phone" class="tc-form-control" placeholder="+91 98765 43210">
            </div>
            <div class="col-md-6">
              <label class="tc-form-label">Course Interested In <span style="color:var(--tc-accent)">*</span></label>
              <select id="enqCourse" name="course" class="tc-form-control">
                <option value="">-- Select a Course --</option>
                <?php foreach ($footerCourses as $fc): ?>
                <option value="<?= e($fc['title']) ?>"><?= e($fc['title']) ?></option>
                <?php endforeach; ?>
                <option value="Other / Not Sure">Other / Not Sure</option>
              </select>
            </div>
            <div class="col-12">
              <label class="tc-form-label">Your Message</label>
              <textarea id="enqMessage" name="message" class="tc-form-control" placeholder="Tell us about your background, goals, or any specific questions..."></textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="tc-btn tc-btn-secondary tc-btn-sm" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="tc-btn tc-btn-primary tc-btn-sm" id="submitEnquiry" onclick="submitEnquiry()">
          <i class="bi bi-send-fill"></i> Send Enquiry
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ============================================================ -->
<!-- FOOTER                                                        -->
<!-- ============================================================ -->
<style>
.tcf-footer{ background:#f7f9fc; color:var(--text-body); font-size:15px; line-height:1.73; }
.tcf-footer .container{ max-width:1200px; }
.tcf-top{ padding:84px 0 72px; }
.tcf-widget-title{
  font-family:var(--tc-font-head); font-size:20px; font-weight:800; color:var(--text-heading);
  margin:0 0 24px; letter-spacing:.2px;
}
.tcf-logo{ display:inline-block; margin-bottom:20px; }
.tcf-logo img{ height:46px; width:auto; }
.tcf-desc{ color:var(--text-body); font-size:15px; line-height:1.85; margin:0 0 22px; max-width:360px; }

.tcf-info ul{ list-style:none; padding:0; margin:0; }
.tcf-info li{ margin-bottom:9px; font-size:15px; }
.tcf-info li:last-child{ margin-bottom:0; }
.tcf-info li span{ font-weight:700; color:var(--text-heading); margin-right:5px; }
.tcf-info li a{ color:var(--text-body); text-decoration:none; transition:.25s; }
.tcf-info li a:hover{ color:var(--primary); }

.tcf-social{ display:flex; gap:10px; margin-top:20px; }
.tcf-social a{
  width:38px; height:38px; border-radius:50%; display:flex; align-items:center; justify-content:center;
  background:#fff; color:var(--text-heading); box-shadow:0 2px 8px rgba(15,23,42,.08); text-decoration:none; transition:.25s;
}
.tcf-social a:hover{ background:var(--primary); color:#fff; transform:translateY(-3px); }

.tcf-links{ list-style:none; padding:0; margin:0; }
.tcf-links li + li{ margin-top:11px; }
.tcf-links a{ display:block; line-height:26px; color:var(--text-body); text-decoration:none; font-size:15px; transition:.25s; }
.tcf-links a:hover{ color:var(--primary); padding-left:5px; }

.tcf-map{ margin-bottom:16px; }
.tcf-map iframe{ width:100%; height:190px; border:0; border-radius:12px; display:block; box-shadow:0 4px 16px rgba(15,23,42,.08); }
.tcf-policies{ display:flex; flex-wrap:wrap; gap:6px 18px; }
.tcf-policies a{ color:var(--primary); text-decoration:none; font-size:15px; font-weight:600; transition:.25s; }
.tcf-policies a:hover{ color:var(--primary-dark); }

.tcf-bottom{ background:#ebeff0; border-top:1px solid #e5e5e5; padding:24px 0; }
.tcf-bottom-inner{ display:flex; flex-wrap:wrap; gap:10px 20px; align-items:center; justify-content:space-between; }
.tcf-bottom p{ margin:0; font-size:14px; color:var(--text-body); }
.tcf-bottom strong{ color:var(--text-heading); font-weight:800; }
.tcf-bottom-links a{ color:var(--text-body); text-decoration:none; margin-left:20px; font-size:14px; transition:.25s; }
.tcf-bottom-links a:first-child{ margin-left:0; }
.tcf-bottom-links a:hover{ color:var(--primary); }
.tcf-bottom-links button{ background:none; border:0; padding:0; margin-left:20px; color:var(--text-body); font-size:14px; font-family:inherit; cursor:pointer; transition:.25s; }
.tcf-bottom-links button:hover{ color:var(--primary); }

@media(max-width:991px){ .tcf-top{ padding:60px 0; } .tcf-widget-title{ margin-bottom:18px; font-size:18px; } }
@media(max-width:575px){
  .tcf-top{ padding:48px 0; } .tcf-desc{ max-width:none; }
  .tcf-bottom-inner{ justify-content:center; text-align:center; }
  .tcf-bottom-links a{ margin:0 10px; }
}
</style>

<footer class="tcf-footer">
  <div class="tcf-top">
    <div class="container">
      <div class="row g-5">

        <!-- Brand + info -->
        <div class="col-lg-3 col-md-6">
          <div class="tcf-logo">
            <a href="<?= SITE_URL ?>/index.php">
              <img src="<?= SITE_URL ?>/assets/images/image.png" alt="Techno Coderz">
            </a>
          </div>
          <p class="tcf-desc">
            Techno Coderz is a premier IT training and software development institute. We help learners build industry-ready skills through practical, project-based education and expert mentorship.
          </p>
          <div class="tcf-info">
            <ul>
              <li><span>Add:</span><?= e($address) ?></li>
              <li><span>Call:</span><a href="tel:<?= e(preg_replace('/\s+/', '', $phone)) ?>"><?= e($phone) ?></a></li>
              <li><span>Email:</span><a href="mailto:<?= e($email) ?>"><?= e($email) ?></a></li>
            </ul>
          </div>
          <div class="tcf-social">
            <a href="<?= e($fb) ?>" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="<?= e($ig) ?>" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            <a href="<?= e($li) ?>" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
            <a href="<?= e($yt) ?>" target="_blank" rel="noopener" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
            <a href="<?= e($tw) ?>" target="_blank" rel="noopener" aria-label="Twitter/X"><i class="bi bi-twitter-x"></i></a>
          </div>
        </div>

        <!-- Courses -->
        <div class="col-lg-3 col-sm-6">
          <h4 class="tcf-widget-title">COURSES</h4>
          <ul class="tcf-links">
            <?php
            $shown = 0;
            foreach ($footerCourses as $fc):
                if ($shown >= 6) break;
                $shown++;
            ?>
            <li><a href="<?= e(coursePageUrl($fc['slug'])) ?>"><?= e($fc['title']) ?></a></li>
            <?php endforeach; ?>
            <?php if (!$shown): ?>
            <li><a href="<?= SITE_URL ?>/courses.php">View All Courses</a></li>
            <?php endif; ?>
          </ul>
        </div>

        <!-- Quick links -->
        <div class="col-lg-3 col-sm-6">
          <h4 class="tcf-widget-title">Quick Links</h4>
          <ul class="tcf-links">
            <li><a href="<?= SITE_URL ?>/index.php">Home</a></li>
            <li><a href="<?= SITE_URL ?>/about.php">About Us</a></li>
            <li><a href="<?= SITE_URL ?>/mission-vision.php">Mission &amp; Vision</a></li>
            <li><a href="<?= SITE_URL ?>/founder.php">Founder &amp; Team</a></li>
            <li><a href="<?= SITE_URL ?>/courses.php">All Courses</a></li>
            <li><a href="<?= SITE_URL ?>/projects.php">Projects</a></li>
            <li><a href="<?= SITE_URL ?>/services.php">Services</a></li>
            <li><a href="<?= SITE_URL ?>/blog.php">Our Blogs</a></li>
            <li><a href="<?= SITE_URL ?>/career.php">Careers</a></li>
            <li><a href="<?= SITE_URL ?>/contact.php">Contact Us</a></li>
          </ul>
        </div>

        <!-- Location + policies -->
        <div class="col-lg-3 col-md-6">
          <h4 class="tcf-widget-title">Our Location</h4>
          <div class="tcf-map">
            <iframe src="https://www.google.com/maps?q=<?= $mapQuery ?>&output=embed" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Techno Coderz location"></iframe>
          </div>
          <div class="tcf-policies">
            <a href="<?= SITE_URL ?>/brochure.php">Brochure</a>
            <a href="<?= SITE_URL ?>/faq.php">FAQ</a>
            <a href="<?= SITE_URL ?>/contact.php">Get In Touch</a>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Copyright -->
  <div class="tcf-bottom">
    <div class="container">
      <div class="tcf-bottom-inner">
        <p>&copy; <?= date('Y') ?> <strong>Techno Coderz</strong>. All rights reserved.</p>
        <p class="tcf-bottom-links">
          <a href="<?= SITE_URL ?>/courses.php">Courses</a>
          <a href="<?= SITE_URL ?>/blog.php">Blog</a>
          <a href="<?= SITE_URL ?>/faq.php">FAQ</a>
          <a href="<?= SITE_URL ?>/contact.php">Contact</a>
          <button type="button" data-cookie-settings>Cookie Settings</button>
        </p>
      </div>
    </div>
  </div>
</footer>

<!-- Back to Top -->
<button id="backToTop" title="Back to top" aria-label="Back to top">
  <i class="bi bi-arrow-up"></i>
</button>

<!-- Toast Wrapper -->
<div class="tc-toast-wrap" id="tcToastWrap"></div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Techno Coderz Custom JS -->
<script src="<?= SITE_URL ?>/assets/js/technocoderz.js"></script>
<?php if (!empty($extraScripts)) echo $extraScripts; ?>

<!-- Bhuvi AI Assistant -->
<?php require __DIR__ . '/bhuvi-ai.php'; ?>

<!-- Floating social + WhatsApp -->
<?php require __DIR__ . '/whatsapp-widget.php'; ?>

<!-- Auto Demo / Enquiry Popup -->
<?php require __DIR__ . '/demo-popup.php'; ?>

<!-- Cookie & Privacy Consent -->
<?php require __DIR__ . '/cookie-consent.php'; ?>
</body>
</html>
