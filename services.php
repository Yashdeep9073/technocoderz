<?php
// ============================================================
// Techno Coderz — Services Page
// ============================================================
require_once __DIR__ . '/includes/functions.php';
$pageTitle='Services – Techno Coderz';$pageDescription='Techno Coderz offers professional web development, software development, UI/UX design, e-commerce solutions, and website maintenance services.';$currentPage='services';
$pdo=getDB();$services=$pdo->query("SELECT * FROM services WHERE status=1 ORDER BY sort_order ASC")->fetchAll();
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<script>window.TC_BASE_URL='<?=SITE_URL?>';</script>

<div class="tc-cta-section" style="padding: 60px 0;">
  <div class="container text-center reveal" style="position:relative;z-index:1;">
    <ul class="tc-breadcrumb" style="list-style:none; padding:0; display:flex; justify-content:center; gap:10px; margin-bottom:15px; font-size:0.9rem;">
      <li><a href="<?= SITE_URL ?>" style="color:var(--tc-white);"><i class="bi bi-house-fill"></i> Home</a></li>
      <li style="color:rgba(255,255,255,0.5);">/</li>
      <li style="color:rgba(255,255,255,0.8);">Services</li>
    </ul>
    <h1 class="tc-section-title" style="color:var(--tc-white); margin-bottom:10px;">Our <span>Services</span></h1>
    <p style="color:rgba(255,255,255,0.8); font-size:1.1rem; max-width:600px; margin:0 auto;">
      Beyond training, Techno Coderz delivers high-quality software development and digital solutions for businesses of all sizes.
    </p>
  </div>
</div>

<section class="tc-section">
  <div class="container">
    <?php if($services): ?>
    <div class="row g-4">
      <?php foreach($services as $i=>$svc): ?>
      <div class="col-lg-4 col-md-6 reveal" style="transition-delay:<?=($i%3)*0.1?>s">
        <div class="tc-service-card" style="height:100%; display:flex; flex-direction:column;">
          <div class="tc-service-icon" style="margin-bottom:20px;"><i class="<?=e($svc['icon']??'bi bi-gear')?>" style="color:var(--tc-primary); font-size:2rem;"></i></div>
          <h2 class="tc-service-title" style="font-family:var(--tc-font-head); font-size:1.3rem; color:var(--tc-heading); margin-bottom:12px;"><?=e($svc['title'])?></h2>
          <p class="tc-service-desc" style="color:var(--tc-text); font-size:0.95rem; margin-bottom:10px;"><?=e($svc['short_description'])?></p>
          <?php if($svc['description']):?>
          <p style="font-size:0.85rem; color:var(--tc-text-muted); line-height:1.7; margin-top:auto;"><?=e($svc['description'])?></p>
          <?php endif;?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else:?>
    <div class="text-center py-5" style="background:var(--tc-white); border-radius:var(--tc-radius-lg); border:1px solid var(--tc-border);">
      <i class="bi bi-briefcase" style="font-size:3rem; color:var(--tc-text-muted); display:block; margin-bottom:16px; opacity:0.4"></i>
      <p style="color:var(--tc-heading); font-size:1.1rem;">Services coming soon.</p>
    </div>
    <?php endif;?>
  </div>
</section>

<!-- Process -->
<section class="tc-section tc-section-alt">
  <div class="container">
    <div class="tc-section-header text-center reveal">
      <div class="tc-badge"><i class="bi bi-diagram-3-fill"></i> How We Work</div>
      <h2 class="tc-section-title">Our Development <span>Process</span></h2>
    </div>
    <div class="row g-4">
      <?php
      $steps=[
        ['num'=>'01','icon'=>'bi-chat-text-fill','title'=>'Discovery & Planning','desc'=>'We start by understanding your business, goals, users, and technical requirements through a thorough discovery session.'],
        ['num'=>'02','icon'=>'bi-palette-fill','title'=>'UI/UX Design','desc'=>'We create wireframes and prototypes that visualize the user experience before writing a single line of code.'],
        ['num'=>'03','icon'=>'bi-code-slash','title'=>'Development & Testing','desc'=>'Our developers build your solution using clean, maintainable code with regular testing and quality assurance cycles.'],
        ['num'=>'04','icon'=>'bi-rocket-takeoff-fill','title'=>'Launch & Support','desc'=>'We deploy your application, provide training, and offer ongoing maintenance and support packages.'],
      ];
      foreach($steps as $i=>$s):
      ?>
      <div class="col-lg-3 col-md-6 reveal" style="transition-delay:<?=$i*0.1?>s">
        <div class="tc-process-card" style="background:var(--tc-white); padding:30px; border-radius:var(--tc-radius); border:1px solid var(--tc-border); box-shadow:var(--tc-shadow-sm); height:100%; position:relative; overflow:hidden;">
          <div class="tc-process-num" style="position:absolute; top:-10px; right:-10px; font-size:5rem; font-family:var(--tc-font-head); font-weight:900; color:rgba(244,126,32,0.05); line-height:1;"><?=$s['num']?></div>
          <div class="tc-process-icon" style="width:60px; height:60px; background:rgba(244,126,32,0.1); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.8rem; color:var(--tc-primary); margin-bottom:20px; position:relative; z-index:1;"><i class="<?=$s['icon']?>"></i></div>
          <h3 class="tc-process-title" style="font-family:var(--tc-font-head); font-size:1.2rem; color:var(--tc-heading); margin-bottom:12px; position:relative; z-index:1;"><?=$s['title']?></h3>
          <p class="tc-process-desc" style="color:var(--tc-text); font-size:0.9rem; line-height:1.6; margin:0; position:relative; z-index:1;"><?=$s['desc']?></p>
        </div>
      </div>
      <?php endforeach;?>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="tc-cta-section">
  <div class="container text-center reveal">
    <h2 class="tc-section-title" style="color:var(--tc-white);">Have a Project <span>In Mind</span>?</h2>
    <p style="color:rgba(255,255,255,0.8); font-size:1.1rem; max-width:500px; margin:0 auto 32px;">Let's discuss how Techno Coderz can bring your vision to life with a custom-built solution.</p>
    <a href="<?=SITE_URL?>/contact.php" class="tc-btn tc-btn-primary tc-btn-lg"><i class="bi bi-chat-dots-fill"></i> Start a Conversation</a>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
