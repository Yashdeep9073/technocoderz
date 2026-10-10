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
$address = $footerSettings['address'] ?? 'Bengaluru, Karnataka, India';
$fb      = $footerSettings['facebook']  ?? '#';
$ig      = $footerSettings['instagram'] ?? '#';
$li      = $footerSettings['linkedin']  ?? '#';
$yt      = $footerSettings['youtube']   ?? '#';
$tw      = $footerSettings['twitter']   ?? '#';
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
<footer class="tc-footer">
  <div class="container">
    <div class="row g-5">

      <!-- Brand Column -->
      <div class="col-lg-4 col-md-6">
        <a href="<?= SITE_URL ?>/index.php" style="display:inline-block; margin-bottom:20px;">
          <img src="<?= SITE_URL ?>/assets/images/image.png" alt="Techno Coderz Logo" style="height:45px; filter:brightness(0) invert(1);">
        </a>
        <p class="tc-footer-desc">
          Techno Coderz is a premier IT training and software development institute helping learners build industry-ready skills through practical, project-based education.
        </p>
        <div class="tc-social-links">
          <a href="<?= e($fb) ?>" class="tc-social-link" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
          <a href="<?= e($ig) ?>" class="tc-social-link" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
          <a href="<?= e($li) ?>" class="tc-social-link" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
          <a href="<?= e($yt) ?>" class="tc-social-link" target="_blank" rel="noopener" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
          <a href="<?= e($tw) ?>" class="tc-social-link" target="_blank" rel="noopener" aria-label="Twitter/X"><i class="bi bi-twitter-x"></i></a>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="col-lg-2 col-md-6 col-6">
        <h6 class="tc-footer-heading">Quick Links</h6>
        <ul class="tc-footer-links">
          <li><a href="<?= SITE_URL ?>/index.php">Home</a></li>
          <li><a href="<?= SITE_URL ?>/about.php">About Us</a></li>
          <li><a href="<?= SITE_URL ?>/courses.php">Courses</a></li>
          <li><a href="<?= SITE_URL ?>/brochure.php">Brochure</a></li>
          <li><a href="<?= SITE_URL ?>/blog.php">Our Blogs</a></li>
          <li><a href="<?= SITE_URL ?>/contact.php">Contact Us</a></li>
        </ul>
      </div>

      <!-- Courses -->
      <div class="col-lg-3 col-md-6 col-6">
        <h6 class="tc-footer-heading">Top Courses</h6>
        <ul class="tc-footer-links">
          <?php
          $shown = 0;
          foreach ($footerCourses as $fc):
              if ($shown >= 6) break;
              $shown++;
          ?>
          <li><a href="<?= SITE_URL ?>/course-details.php?slug=<?= urlencode($fc['slug']) ?>"><?= e($fc['title']) ?></a></li>
          <?php endforeach; ?>
          <?php if (!$shown): ?>
          <li><a href="<?= SITE_URL ?>/courses.php">View All Courses</a></li>
          <?php endif; ?>
        </ul>
      </div>

      <!-- Contact -->
      <div class="col-lg-3 col-md-6">
        <h6 class="tc-footer-heading">Contact Us</h6>
        <div class="tc-footer-contact-item">
          <i class="bi bi-geo-alt-fill"></i>
          <span><?= e($address) ?></span>
        </div>
        <div class="tc-footer-contact-item">
          <i class="bi bi-telephone-fill"></i>
          <a href="tel:<?= e(preg_replace('/\s+/', '', $phone)) ?>" style="color:var(--tc-text-muted)"><?= e($phone) ?></a>
        </div>
        <div class="tc-footer-contact-item">
          <i class="bi bi-envelope-fill"></i>
          <a href="mailto:<?= e($email) ?>" style="color:var(--tc-text-muted)"><?= e($email) ?></a>
        </div>
        <div class="mt-3">
          <a href="<?= SITE_URL ?>/contact.php" class="tc-btn tc-btn-primary tc-btn-sm">
            <i class="bi bi-chat-dots-fill"></i> Get In Touch
          </a>
        </div>
      </div>

    </div><!-- /row -->

    <!-- Footer Bottom -->
    <div class="tc-footer-bottom">
      <p>&copy; <?= date('Y') ?> <strong style="color:#fff">Techno Coderz</strong>. All rights reserved.</p>
      <p class="tc-footer-bottom-links">
        <a href="<?= SITE_URL ?>/courses.php" class="me-3">Courses</a>
        <a href="<?= SITE_URL ?>/brochure.php" class="me-3">Brochure</a>
        <a href="<?= SITE_URL ?>/blog.php" class="me-3">Blog</a>
        <a href="<?= SITE_URL ?>/faq.php" class="me-3">FAQ</a>
        <a href="<?= SITE_URL ?>/contact.php">Contact</a>
      </p>
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
</body>
</html>
