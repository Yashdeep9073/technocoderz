<?php
// ============================================================
// Techno Coderz — Projects Page
// ============================================================
require_once __DIR__ . '/includes/functions.php';
$pageTitle='Projects – Techno Coderz';$pageDescription='Explore projects built by Techno Coderz — real-world web applications, management systems, and software solutions.';$currentPage='projects';
$csrf = generateCsrfToken();
$pdo=getDB();$projects=$pdo->query("SELECT * FROM projects WHERE status=1 ORDER BY sort_order ASC")->fetchAll();
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<script>window.TC_BASE_URL='<?=SITE_URL?>';</script>
<script>document.addEventListener('DOMContentLoaded',function(){var c=document.getElementById('enquiryCsrf');if(c)c.value='<?=e($csrf)?>';});</script>

<div class="tc-page-header">
  <div class="container" style="position:relative;z-index:1;">
    <ul class="tc-breadcrumb"><li><a href="<?=SITE_URL?>"><i class="bi bi-house-fill"></i> Home</a></li><li class="sep">/</li><li class="current">Projects</li></ul>
    <h1 class="tc-section-title" style="margin-bottom:8px;">Our <span>Projects</span></h1>
    <p style="color:var(--tc-text-muted);font-size:0.95rem;max-width:560px;">Real applications built by our team and students — showcasing what's possible with practical education and skilled development.</p>
  </div>
</div>

<section class="tc-section">
  <div class="container">
    <?php if($projects):?>
    <div class="row g-4">
      <?php foreach($projects as $i=>$proj):?>
      <div class="col-lg-4 col-md-6 reveal" style="transition-delay:<?=($i%3)*0.08?>s">
        <div class="tc-project-card">
          <div class="tc-project-img">
            <?php if($proj['image'] && file_exists(UPLOAD_DIR.'projects/'.$proj['image'])):?>
            <img src="<?=UPLOAD_URL?>projects/<?=e($proj['image'])?>" alt="<?=e($proj['title'])?>" loading="lazy">
            <?php else:?>
            <div class="tc-project-fallback">
              <i class="bi bi-window-stack"></i>
              <span><?=e($proj['title'])?></span>
            </div>
            <?php endif;?>
            <?php if($proj['project_url']):?>
            <div class="tc-project-overlay">
              <a href="<?=e($proj['project_url'])?>" class="tc-btn tc-btn-primary tc-btn-sm" target="_blank" rel="noopener"><i class="bi bi-box-arrow-up-right"></i> Live Demo</a>
            </div>
            <?php endif;?>
          </div>
          <div class="tc-project-body">
            <h2 class="tc-project-title"><?=e($proj['title'])?></h2>
            <p class="tc-project-desc" style="-webkit-line-clamp:3;"><?=e($proj['description'])?></p>
            <div class="tc-tech-tags">
              <?php $tags=explode(',',$proj['technology']??'');foreach(array_slice($tags,0,5) as $tag):?>
              <span class="tc-tech-tag"><?=e(trim($tag))?></span>
              <?php endforeach;?>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach;?>
    </div>
    <?php else:?>
    <div class="text-center py-5"><p style="color:var(--tc-text-muted)">Projects portfolio coming soon.</p></div>
    <?php endif;?>
  </div>
</section>

<section class="tc-section tc-cta-section">
  <div class="container text-center reveal">
    <h2 class="tc-section-title">Want to Build Something <span>Similar</span>?</h2>
    <p style="color:var(--tc-text-muted);font-size:0.95rem;max-width:460px;margin:0 auto 32px;">Whether you want to learn how to build these projects or need one built for your business, we can help.</p>
    <div class="d-flex flex-wrap gap-3 justify-content-center">
      <a href="<?=SITE_URL?>/courses.php" class="tc-btn tc-btn-primary tc-btn-lg"><i class="bi bi-book-fill"></i> Learn to Build</a>
      <a href="<?=SITE_URL?>/contact.php" class="tc-btn tc-btn-secondary tc-btn-lg"><i class="bi bi-chat-dots-fill"></i> Hire Us</a>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
