<?php
// ============================================================
// Techno Coderz — Blog Detail
// ============================================================
require_once __DIR__ . '/includes/functions.php';
$slug=sanitize($_GET['slug']??'');$post=$slug?fetchBySlug('blogs',$slug):null;
if(!$post){header('HTTP/1.1 404 Not Found');$pageTitle='404 – Post Not Found';$currentPage='blog';require_once __DIR__.'/includes/header.php';require_once __DIR__.'/includes/navbar.php';echo '<div class="tc-section text-center"><div class="container"><h1 class="tc-section-title">Post <span>Not Found</span></h1><p style="color:var(--tc-text-muted)">This article doesn\'t exist.</p><a href="'.SITE_URL.'/blog.php" class="tc-btn tc-btn-primary mt-3"><i class="bi bi-arrow-left"></i> Blog</a></div></div>';require_once __DIR__.'/includes/footer.php';exit;}

// Increment views
$pdo=getDB();$pdo->prepare("UPDATE blogs SET views=views+1 WHERE id=?")->execute([$post['id']]);

$pageTitle=e($post['title']).' – Techno Coderz Blog';$pageDescription=e($post['excerpt']??$post['title']);$currentPage='blog';
// Recent posts for sidebar
$recent=$pdo->prepare("SELECT id,title,slug,category,created_at FROM blogs WHERE status=1 AND id!=? ORDER BY created_at DESC LIMIT 5");$recent->execute([$post['id']]);$recentPosts=$recent->fetchAll();

// Category cloud (read-only) for the sidebar widget
$blogCats=[];
try{
  $rows=$pdo->query("SELECT category, COUNT(*) AS total FROM blogs WHERE status=1 AND category IS NOT NULL AND TRIM(category)<>'' GROUP BY category ORDER BY total DESC, category ASC")->fetchAll();
  foreach($rows as $r){$blogCats[]= ['name'=>$r['category'],'total'=>(int)$r['total']];}
}catch(Exception $e){$blogCats=[];}

// Reading time + share-friendly meta
$readMins=max(1,(int)ceil(str_word_count(strip_tags((string)($post['content']??$post['excerpt']??'')))/200));
$postDate=date('d M Y',strtotime($post['created_at']));
$catLabel=trim($post['category']??'')!==''?$post['category']:'Article';

require_once __DIR__.'/includes/header.php';
require_once __DIR__.'/includes/navbar.php';
?>
<script>window.TC_BASE_URL='<?=SITE_URL?>';</script>

<style>
/* ---- Blog detail (scoped): light, readable, Medium / Dev.to inspired ---- */
.bd-progress{position:fixed;top:0;left:0;height:3px;width:0;background:linear-gradient(90deg,#FF6B00,#E53835);z-index:1100;transition:width .1s linear;}

.bd-strip{background:#ffffff;border-bottom:1px solid rgba(15,23,42,.07);padding:22px 0;}
.bd-strip .tc-breadcrumb{justify-content:flex-start;margin-bottom:0;}
.bd-strip .tc-breadcrumb a{color:#0f172a;}
.bd-strip .tc-breadcrumb a:hover{color:#ff6b00;}
.bd-strip .tc-breadcrumb .sep{color:#94a3b8;}
.bd-strip .tc-breadcrumb .current{color:#ff6b00;}

.tc-page-light .bd-section{background:#f8fafc;padding:44px 0 70px;}

.bd-article{
  background:#ffffff;border:1px solid rgba(15,23,42,.07);border-radius:24px;
  padding:clamp(22px,4vw,42px);box-shadow:0 18px 44px rgba(15,23,42,.06);
}
.bd-cat{
  display:inline-flex;align-items:center;gap:6px;padding:5px 13px;border-radius:999px;
  background:rgba(255,107,0,.10);border:1px solid rgba(255,107,0,.24);color:#ff6b00;
  font-size:.7rem;font-weight:800;letter-spacing:.9px;text-transform:uppercase;
}
.bd-title{
  font-family:'Plus Jakarta Sans',var(--tc-font-main);font-weight:800;color:#084c61;
  font-size:clamp(1.55rem,3.2vw,2.35rem);line-height:1.2;letter-spacing:-.02em;margin:14px 0 18px;
}
.bd-meta{
  display:flex;flex-wrap:wrap;align-items:center;gap:8px 18px;
  padding-bottom:20px;margin-bottom:24px;border-bottom:1px solid rgba(15,23,42,.08);
}
.bd-who{display:flex;align-items:center;gap:11px;margin-right:auto;}
.bd-avatar{
  width:44px;height:44px;flex-shrink:0;border-radius:50%;display:flex;align-items:center;justify-content:center;
  background:linear-gradient(135deg,#FF6B00 0%,#E55F00 100%);color:#ffffff;font-weight:800;
  font-family:var(--tc-font-head);font-size:1rem;box-shadow:0 8px 18px rgba(255,107,0,.30);
}
.bd-who b{display:block;font-size:.92rem;color:#0f172a;line-height:1.3;}
.bd-who span{font-size:.76rem;color:#ff6b00;font-weight:700;letter-spacing:.3px;}
.bd-stat{display:inline-flex;align-items:center;gap:6px;font-size:.8rem;color:#64748b;font-weight:600;}
.bd-stat i{color:#ff6b00;}

.bd-cover{width:100%;height:auto;border-radius:16px;display:block;margin-bottom:26px;border:1px solid rgba(15,23,42,.07);}
.bd-cover-fallback{
  width:100%;height:260px;border-radius:16px;margin-bottom:26px;display:flex;flex-direction:column;
  align-items:center;justify-content:center;gap:8px;color:#ff6b00;
  background:linear-gradient(135deg,rgba(255,107,0,.10),rgba(8,76,97,.08));border:1px solid rgba(15,23,42,.07);
}
.bd-cover-fallback i{font-size:2.4rem;}
.bd-cover-fallback span{font-size:.8rem;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#64748b;}

.bd-lead{
  font-size:1.05rem;line-height:1.85;color:#0f172a;font-style:italic;
  padding-left:18px;border-left:3px solid #ff6b00;margin-bottom:26px;
}
.bd-content{color:#0f172a;font-size:1rem;line-height:1.92;overflow-wrap:anywhere;}
.bd-content strong,.bd-content b{color:#084c61;}

.bd-tags{margin-top:30px;padding-top:22px;border-top:1px solid rgba(15,23,42,.08);display:flex;flex-wrap:wrap;gap:8px;align-items:center;}
.bd-tags-label{font-size:.72rem;font-weight:800;letter-spacing:1px;text-transform:uppercase;color:#64748b;margin-right:4px;}
.bd-tag{
  display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:999px;font-size:.75rem;
  font-weight:700;color:#ff6b00;background:rgba(255,107,0,.09);border:1px solid rgba(255,107,0,.22);
  text-decoration:none;transition:all .25s ease;
}
.bd-tag:hover{background:#ff6b00;color:#ffffff;border-color:#ff6b00;}

.bd-nav{display:flex;flex-wrap:wrap;gap:12px;align-items:center;justify-content:space-between;margin-top:22px;}

/* ---- Sidebar ---- */
.bd-side{position:sticky;top:100px;display:flex;flex-direction:column;gap:18px;}
.bd-card{
  background:#ffffff;border:1px solid rgba(15,23,42,.07);border-radius:20px;padding:22px;
  box-shadow:0 10px 30px rgba(15,23,42,.06);
}
.bd-card-title{
  display:flex;align-items:center;gap:8px;font-family:var(--tc-font-head);font-size:.92rem;font-weight:700;
  color:#084c61;text-transform:uppercase;letter-spacing:.7px;margin:0 0 16px;
}
.bd-card-title i{color:#ff6b00;}

.bd-recent{list-style:none;margin:0;padding:0;}
.bd-recent li+li{border-top:1px dashed rgba(15,23,42,.12);}
.bd-recent a{display:flex;gap:12px;align-items:flex-start;padding:12px 0;text-decoration:none;}
.bd-recent-num{
  font-family:var(--tc-font-head);font-size:.72rem;font-weight:800;color:#ff6b00;
  background:rgba(255,107,0,.10);border-radius:9px;padding:4px 7px;line-height:1;flex-shrink:0;margin-top:2px;
}
.bd-recent b{display:block;font-size:.87rem;font-weight:600;color:#0f172a;line-height:1.45;margin-bottom:4px;transition:color .2s ease;}
.bd-recent a:hover b{color:#ff6b00;}
.bd-recent small{font-size:.72rem;color:#64748b;font-weight:600;}
.bd-recent small i{color:#ff6b00;}

.bd-cats{list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:8px;}
.bd-cats a{
  display:flex;align-items:center;justify-content:space-between;gap:10px;padding:11px 14px;border-radius:12px;
  background:#f8fafc;border:1px solid rgba(15,23,42,.07);color:#0f172a;font-size:.86rem;font-weight:600;
  text-decoration:none;transition:all .25s ease;
}
.bd-cats a span:first-child{display:flex;align-items:center;gap:8px;min-width:0;}
.bd-cats a i{color:#ff6b00;}
.bd-cats .bd-count{
  flex-shrink:0;background:#ff6b00;color:#ffffff;border-radius:999px;font-size:.7rem;font-weight:800;padding:2px 9px;
}
.bd-cats a:hover{background:rgba(255,107,0,.08);border-color:rgba(255,107,0,.32);color:#ff6b00;}

.bd-cta{background:linear-gradient(150deg,#0f172a 0%,#1e293b 100%);border-radius:20px;padding:24px;text-align:center;}
.bd-cta h3{font-family:var(--tc-font-head);font-size:1.02rem;font-weight:700;color:#ffffff;margin:0 0 8px;}
.bd-cta p{font-size:.83rem;line-height:1.65;color:rgba(255,255,255,.72);margin:0 0 16px;}
.bd-cta .tc-btn{width:100%;justify-content:center;}

@media (max-width: 991.98px){
  .bd-side{position:static;}
}
</style>

<div class="tc-page-light">

<div class="bd-progress" id="bdProgress" role="presentation"></div>

<!-- Breadcrumb strip -->
<div class="bd-strip">
  <div class="container">
    <ul class="tc-breadcrumb">
      <li><a href="<?=SITE_URL?>"><i class="bi bi-house-fill"></i> Home</a></li>
      <li class="sep">/</li>
      <li><a href="<?=SITE_URL?>/blog.php">Blog</a></li>
      <li class="sep">/</li>
      <li class="current"><?=e(mb_substr($post['title'],0,40))?><?=mb_strlen($post['title'])>40?'…':''?></li>
    </ul>
  </div>
</div>

<section class="tc-section bd-section">
  <div class="container">
    <div class="row g-5">

      <!-- ===== 8-col main article ===== -->
      <div class="col-lg-8 reveal">
        <article class="bd-article">

          <span class="bd-cat"><i class="bi bi-folder2-open"></i> <?=e($catLabel)?></span>

          <h1 class="bd-title"><?=e($post['title'])?></h1>

          <div class="bd-meta">
            <div class="bd-who">
              <span class="bd-avatar" aria-hidden="true"><?=e(mb_strtoupper(mb_substr($post['author']??'TC',0,1)))?></span>
              <span>
                <b><?=e($post['author']??'Techno Coderz')?></b>
                <span>Techno Coderz Team</span>
              </span>
            </div>
            <span class="bd-stat"><i class="bi bi-calendar3"></i> <?=$postDate?></span>
            <span class="bd-stat"><i class="bi bi-clock-history"></i> <?=$readMins?> min read</span>
            <span class="bd-stat"><i class="bi bi-eye-fill"></i> <?=$post['views']?> views</span>
          </div>

          <?php if($post['image'] && file_exists(UPLOAD_DIR.'blogs/'.$post['image'])):?>
          <img class="bd-cover" src="<?=UPLOAD_URL?>blogs/<?=e($post['image'])?>" alt="<?=e($post['title'])?>">
          <?php else:?>
          <div class="bd-cover-fallback">
            <i class="bi bi-journal-text"></i>
            <span><?=e($catLabel)?></span>
          </div>
          <?php endif;?>

          <?php if($post['excerpt']):?>
          <p class="bd-lead"><?=e($post['excerpt'])?></p>
          <?php endif;?>

          <div class="bd-content">
            <?=nl2br(e($post['content'] ?? $post['excerpt'] ?? 'Content coming soon.'))?>
          </div>

          <?php if($post['tags']):?>
          <div class="bd-tags">
            <span class="bd-tags-label">Tags</span>
            <?php foreach(explode(',',$post['tags']) as $tag):$tag=trim($tag);if($tag==='')continue;?>
            <a class="bd-tag" href="<?=SITE_URL?>/blog.php"><i class="bi bi-hash"></i><?=e($tag)?></a>
            <?php endforeach;?>
          </div>
          <?php endif;?>

          <div class="bd-nav">
            <a href="<?=SITE_URL?>/blog.php" class="tc-btn tc-btn-primary tc-btn-sm">
              <i class="bi bi-arrow-left"></i> All Articles
            </a>
            <a href="<?=SITE_URL?>/contact.php" class="tc-btn tc-btn-secondary tc-btn-sm">
              <i class="bi bi-chat-dots-fill"></i> Ask A Question
            </a>
          </div>

        </article>
      </div>

      <!-- ===== 4-col sticky sidebar ===== -->
      <div class="col-lg-4 reveal">
        <aside class="bd-side">

          <!-- Categories -->
          <div class="bd-card">
            <h2 class="bd-card-title"><i class="bi bi-bookmark-fill"></i> Categories</h2>
            <?php if($blogCats):?>
            <ul class="bd-cats">
              <?php foreach($blogCats as $c):?>
              <li>
                <a href="<?=SITE_URL?>/blog.php">
                  <span><i class="bi bi-folder-fill"></i><span><?=e($c['name'])?></span></span>
                  <span class="bd-count"><?=$c['total']?></span>
                </a>
              </li>
              <?php endforeach;?>
            </ul>
            <?php else:?>
            <p style="font-size:.83rem;color:#64748b;margin:0;">No categories yet.</p>
            <?php endif;?>
          </div>

          <!-- Recent posts -->
          <div class="bd-card">
            <h2 class="bd-card-title"><i class="bi bi-clock-history"></i> Recent Posts</h2>
            <?php if($recentPosts):?>
            <ul class="bd-recent">
              <?php foreach($recentPosts as $i=>$rp):?>
              <li>
                <a href="<?=SITE_URL?>/blog-details.php?slug=<?=urlencode($rp['slug'])?>">
                  <span class="bd-recent-num"><?=str_pad($i+1,2,'0',STR_PAD_LEFT)?></span>
                  <span>
                    <b><?=e(mb_substr($rp['title'],0,62))?><?=mb_strlen($rp['title'])>62?'…':''?></b>
                    <small><i class="bi bi-folder2-open"></i> <?=e($rp['category']??'Article')?></small>
                    <small style="display:block;margin-top:3px;"><i class="bi bi-calendar3"></i> <?=date('d M Y',strtotime($rp['created_at']))?></small>
                  </span>
                </a>
              </li>
              <?php endforeach;?>
            </ul>
            <?php else:?>
            <p style="font-size:.83rem;color:#64748b;margin:0;">No other posts yet.</p>
            <?php endif;?>
          </div>

          <!-- CTA -->
          <div class="bd-cta">
            <h3>Want to Learn Coding?</h3>
            <p>Join Techno Coderz and start building real, portfolio-ready projects today.</p>
            <a href="<?=SITE_URL?>/courses.php" class="tc-btn tc-btn-cta tc-btn-sm"><i class="bi bi-book-fill"></i> View Courses</a>
          </div>

        </aside>
      </div>

    </div>
  </div>
</section>

</div><!-- /.tc-page-light -->

<script>
(function () {
  var bar = document.getElementById('bdProgress');
  if (!bar) return;
  function update() {
    var doc = document.documentElement;
    var max = (doc.scrollHeight - doc.clientHeight) || 1;
    var pct = Math.min(100, Math.max(0, (doc.scrollTop / max) * 100));
    bar.style.width = pct + '%';
  }
  window.addEventListener('scroll', update, { passive: true });
  window.addEventListener('resize', update);
  update();
})();
</script>

<?php require_once __DIR__.'/includes/footer.php';?>
