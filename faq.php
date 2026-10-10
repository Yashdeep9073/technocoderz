<?php
// ============================================================
// Techno Coderz — FAQ Page
// ============================================================
require_once __DIR__ . '/includes/functions.php';
$pageTitle='FAQ – Techno Coderz';$pageDescription='Find answers to common questions about Techno Coderz courses, training, fees, duration, placement, and more.';$currentPage='faq';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<script>window.TC_BASE_URL='<?=SITE_URL?>';</script>

<div class="tc-cta-section" style="padding: 60px 0;">
  <div class="container text-center reveal" style="position:relative;z-index:1;">
    <ul class="tc-breadcrumb" style="list-style:none; padding:0; display:flex; justify-content:center; gap:10px; margin-bottom:15px; font-size:0.9rem;">
      <li><a href="<?= SITE_URL ?>" style="color:var(--tc-white);"><i class="bi bi-house-fill"></i> Home</a></li>
      <li style="color:rgba(255,255,255,0.5);">/</li>
      <li style="color:rgba(255,255,255,0.8);">FAQ</li>
    </ul>
    <h1 class="tc-section-title" style="color:var(--tc-white); margin-bottom:10px;">Frequently Asked <span>Questions</span></h1>
    <p style="color:rgba(255,255,255,0.8); font-size:1.1rem; max-width:600px; margin:0 auto;">Everything you need to know before joining Techno Coderz.</p>
  </div>
</div>

<section class="tc-section">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8 reveal">
        <?php
        $faqGroups = [
          'About Courses' => [
            ['q'=>'What courses does Techno Coderz offer?','a'=>'We offer a wide range of IT training programs including Full Stack Web Development, Core Java, PHP & MySQL, PHP & Laravel, Frontend Development, JavaScript Mastery, React Basics, and MySQL & Database Design.'],
            ['q'=>'Do I need prior coding experience to enroll?','a'=>'Not at all. Most of our courses are designed for complete beginners. If you have some background, we also offer intermediate and advanced-level programs.'],
            ['q'=>'Are classes conducted online or offline?','a'=>'We primarily conduct in-person classes at our Bengaluru center for the best learning experience. We also offer a hybrid model with recorded sessions for review, and fully online options for outstation students.'],
            ['q'=>'How many students are in each batch?','a'=>'We maintain small batch sizes of 15–20 students to ensure personalized mentorship and individual attention for every learner.'],
          ],
          'Duration & Timing' => [
            ['q'=>'How long are the courses?','a'=>'Course duration ranges from 1.5 months (MySQL & Database Design) to 6 months (Full Stack Web Development). Most core courses are 2–3 months long.'],
            ['q'=>'What are the class timings?','a'=>'We offer flexible batches: Morning (9 AM – 12 PM), Afternoon (1 PM – 4 PM), Evening (5 PM – 8 PM), and Weekend (Saturday & Sunday) batches to accommodate students and working professionals.'],
            ['q'=>'Can I take multiple courses?','a'=>'Absolutely! Many students start with Frontend Development and then move to PHP or Full Stack. We offer combo packages and discounts for multi-course enrollments.'],
          ],
          'Projects & Certification' => [
            ['q'=>'Will I build real projects during the course?','a'=>'Yes — this is a core part of our methodology. Depending on your course, you will build 3–5 complete, deployable real-world projects. These projects become part of your professional portfolio.'],
            ['q'=>'Do you provide certificates after completion?','a'=>'Yes, every student who completes a course and meets the project submission requirements receives an industry-recognized Techno Coderz completion certificate.'],
            ['q'=>'Are the certifications recognized by employers?','a'=>'Our certificates carry weight because they come with verifiable project work. Employers value the practical skills and portfolio our students bring, more than just a paper certificate.'],
          ],
          'Fees & Payment' => [
            ['q'=>'What is the fee structure?','a'=>'Our fees are competitive and significantly lower than large ed-tech platforms. Please contact our admissions team for the current fee schedule — we offer special pricing, EMI options, and need-based scholarships.'],
            ['q'=>'Do you offer EMI or installment options?','a'=>'Yes, we offer flexible payment plans. You can pay in 2–3 installments spread over the course duration. We also partner with select financing options for eligible students.'],
            ['q'=>'Is there a refund policy?','a'=>'We offer a 7-day satisfaction guarantee. If you\'re not satisfied with the training quality within the first week, you can request a full refund.'],
          ],
          'Career & Placement' => [
            ['q'=>'Do you provide placement assistance?','a'=>'Yes! Placement support is a core part of every course. This includes resume building, LinkedIn optimization, mock interviews, soft skills training, and job referrals through our 15+ hiring partner network.'],
            ['q'=>'What is your placement success rate?','a'=>'Our placement rate is 98% for students who complete the full program. Our alumni work at companies like Infosys, TCS, Wipro, Cognizant, Accenture, and many startups.'],
            ['q'=>'Can I switch courses if I change my mind?','a'=>'Yes — you can transfer to a different course within the first two weeks of enrollment at no extra cost, subject to batch availability.'],
          ],
        ];
        foreach($faqGroups as $group=>$faqs):
        ?>
        <h2 style="font-family:var(--tc-font-head); font-size:1.4rem; font-weight:700; color:var(--tc-heading); margin:<?=$group==='About Courses'?'0':'32px'?> 0 16px;">
          <?=e($group)?>
        </h2>
        <?php foreach($faqs as $i=>$faq):?>
        <div class="tc-faq-item">
          <button class="tc-faq-q" type="button">
            <?=e($faq['q'])?>
            <i class="bi bi-plus icon"></i>
          </button>
          <div class="tc-faq-a"><?=e($faq['a'])?></div>
        </div>
        <?php endforeach;endforeach;?>
      </div>

      <!-- Sidebar -->
      <div class="col-lg-4 reveal">
        <div style="position:sticky; top:100px;">
          <div style="background:var(--tc-white); border:1px solid var(--tc-border); border-radius:var(--tc-radius-lg); padding:32px; text-align:center; margin-bottom:20px; box-shadow:var(--tc-shadow-sm);">
            <i class="bi bi-headset" style="font-size:2.5rem; color:var(--tc-primary); display:block; margin-bottom:16px;"></i>
            <h3 style="font-family:var(--tc-font-head); font-size:1.3rem; font-weight:700; color:var(--tc-heading); margin-bottom:10px;">Still Have Questions?</h3>
            <p style="font-size:0.95rem; color:var(--tc-text); margin-bottom:24px; line-height:1.7;">
              Can't find what you're looking for? Our admissions team is happy to help.
            </p>
            <a href="<?=SITE_URL?>/contact.php" class="tc-btn tc-btn-primary w-100" style="justify-content:center;"><i class="bi bi-chat-dots-fill"></i> Contact Us</a>
            <div style="margin-top:16px; font-size:0.9rem; color:var(--tc-text-muted);">
              Or call us at <a href="tel:+919876543210" style="color:var(--tc-primary); font-weight:600;">+91 98765 43210</a>
            </div>
          </div>
          <div style="background:var(--tc-bg-alt); border:1px solid var(--tc-border); border-radius:var(--tc-radius-lg); padding:24px; text-align:center; box-shadow:var(--tc-shadow-sm);">
            <h3 style="font-family:var(--tc-font-head); font-size:1.2rem; font-weight:700; color:var(--tc-heading); margin-bottom:8px;">Ready to Enroll?</h3>
            <p style="font-size:0.9rem; color:var(--tc-text); margin-bottom:16px;">Join the next batch and start your coding journey.</p>
            <a href="<?=SITE_URL?>/courses.php" class="tc-btn tc-btn-secondary tc-btn-sm w-100" style="justify-content:center;"><i class="bi bi-rocket-takeoff-fill"></i> Explore Courses</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
