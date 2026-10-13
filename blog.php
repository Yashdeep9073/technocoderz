<?php
// ============================================================
// Techno Coderz — Blog Listing
// ============================================================
require_once __DIR__ . '/includes/functions.php';
$pageTitle='Our Blogs – Techno Coderz';$pageDescription='Read tutorials, career tips, and technology insights from the Techno Coderz expert team.';$currentPage='blog';
$pdo=getDB();$blogs=$pdo->query("SELECT * FROM blogs WHERE status=1 ORDER BY created_at DESC")->fetchAll();

// Category tabs derived from the already-fetched posts (view layer only)
$blogCategories = [];
foreach ($blogs as $b) {
    $cat = trim($b['category'] ?? '');
    if ($cat !== '' && !in_array($cat, $blogCategories, true)) $blogCategories[] = $cat;
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<script>window.TC_BASE_URL='<?=SITE_URL?>';</script>

<div class="tc-page-light tc-blog-page">

<div class="tc-page-hero">
  <div class="container text-center reveal" style="position:relative;z-index:1;">
    <ul class="tc-breadcrumb">
      <li><a href="<?= SITE_URL ?>"><i class="bi bi-house-fill"></i> Home</a></li>
      <li class="sep">/</li>
      <li class="current">Our Blogs</li>
    </ul>
    <h1 class="tc-section-title" style="margin-bottom:10px;">Our <span>Blogs</span></h1>
    <p style="font-size:1.05rem; max-width:640px; margin:0 auto;">Tutorials, industry insights, career guidance, and technology deep-dives from our expert instructors.</p>
  </div>
</div>

<section class="tc-section">
  <div class="container">
    <?php if($blogs):?>

    <!-- Search + Category Tabs (LearnUp / DreamsLMS style) -->
    <div class="tc-filter-bar reveal">
      <div class="tc-filter-chips" id="blogChips">
        <button type="button" class="tc-btn tc-btn-sm active" data-level="all">All Posts</button>
        <?php foreach($blogCategories as $cat):?>
        <button type="button" class="tc-btn tc-btn-sm" data-level="<?= e(slugify($cat)) ?>"><?= e($cat) ?></button>
        <?php endforeach;?>
      </div>

     <div class="tc-search-wrap tc-blog-search">
  <i class="bi bi-search" aria-hidden="true"></i>
  <input type="search" id="blogSearch" class="tc-form-control"
         placeholder="Search articles, topics, authors..."
         aria-label="Search blog posts">
</div>
    </div>

    <!-- Blog Grid (3-column institutional cards) -->
    <div class="row g-4" id="blogGrid">
      <?php foreach($blogs as $i=>$post):
        $cat      = trim($post['category'] ?? 'Article');
        $catSlug  = slugify($cat);
        $pubDate  = date('M j, Y', strtotime($post['created_at']));
        $haystack = strtolower($post['title'].' '.($post['excerpt'] ?? '').' '.($post['tags'] ?? '').' '.$cat.' '.($post['author'] ?? ''));
      ?>
      <div class="col-lg-4 col-md-6 blog-item reveal"
           data-level="<?= e($catSlug) ?>"
           data-search="<?= e($haystack) ?>"
           style="transition-delay:<?=($i%3)*0.08?>s">
        <article class="tc-blog-card">

          <!-- Thumbnail + category tag + publication date -->
          <div class="tc-blog-img">
            <?php if($post['image'] && file_exists(UPLOAD_DIR.'blogs/'.$post['image'])):?>
            <img src="<?=UPLOAD_URL?>blogs/<?=e($post['image'])?>" alt="<?=e($post['title'])?>" loading="lazy">
            <?php else:?>
            <div class="tc-blog-fallback text-center">
              <i class="bi bi-journal-text"></i>
              <span><?= e($cat) ?></span>
            </div>
            <?php endif;?>
            <span class="tc-blog-tag"><?= e($cat) ?></span>
            <span class="tc-blog-date"><i class="bi bi-calendar3"></i> <?= e($pubDate) ?></span>
          </div>

          <div class="tc-blog-body">
            <span class="tc-blog-cat"><i class="bi bi-folder2-open"></i> <?= e($cat) ?></span>

            <h2 class="tc-blog-title">
              <a href="<?=SITE_URL?>/blog-details.php?slug=<?=urlencode($post['slug'])?>"><?=e($post['title'])?></a>
            </h2>

            <p class="tc-blog-excerpt"><?=e($post['excerpt'])?></p>

            <div class="tc-blog-footer">
              <span class="tc-blog-author">
                <span class="tc-author-avatar"><i class="bi bi-person-fill"></i></span>
                <span class="tc-author-meta">
                  <b><?=e($post['author'])?></b>
                  <small><i class="bi bi-clock"></i> 5 min read</small>
                </span>
              </span>
              <a href="<?=SITE_URL?>/blog-details.php?slug=<?=urlencode($post['slug'])?>" class="tc-blog-more">
                Read More <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        </article>
      </div>
      <?php endforeach;?>
    </div>

    <div class="tc-empty-state text-center py-5" id="blogEmpty" style="display:none;">
      <i class="bi bi-search"></i>
      <p>No articles match your search.</p>
      <small>Try a different keyword or pick another category.</small>
    </div>

    <?php else:?>
    <div class="tc-empty-state text-center py-5">
      <i class="bi bi-journal-text"></i>
      <p>Blog posts coming soon.</p>
      <small>Check back shortly!</small>
    </div>
    <?php endif;?>
  </div>
</section>

</div><!-- /.tc-page-light -->

<?php if($blogs):?>
<script>
(function () {
  var grid = document.getElementById('blogGrid');
  if (!grid) return;

  var chips  = Array.from(document.querySelectorAll('#blogChips .tc-btn'));
  var search = document.getElementById('blogSearch');
  var empty  = document.getElementById('blogEmpty');
  var items  = Array.from(grid.querySelectorAll('.blog-item'));
  var level  = 'all';

  function apply() {
    var q = (search && search.value ? search.value : '').trim().toLowerCase();
    var visible = 0;
    items.forEach(function (item) {
      var matchLevel = level === 'all' || (item.dataset.level || '') === level;
      var matchText  = !q || (item.dataset.search || '').indexOf(q) !== -1;
      var show = matchLevel && matchText;
      item.style.display = show ? '' : 'none';
      if (show) visible++;
    });
    if (empty) empty.style.display = visible ? 'none' : 'block';
  }

  chips.forEach(function (chip) {
    chip.addEventListener('click', function () {
      chips.forEach(function (c) { c.classList.remove('active'); });
      chip.classList.add('active');
      level = chip.dataset.level || 'all';
      apply();
    });
  });

  if (search) search.addEventListener('input', apply);
})();
</script>
<?php endif;?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
