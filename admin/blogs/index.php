<!-- <?php
require_once __DIR__ . '/../../includes/functions.php';
requireAdminLogin();
$pdo=getDB();$csrf=generateCsrfToken();
if(isset($_GET['delete'])){if(!verifyCsrfToken($_GET['csrf']??'')){setFlash('danger','CSRF error.');header('Location: index.php');exit;}$pdo->prepare("DELETE FROM blogs WHERE id=?")->execute([(int)$_GET['delete']]);setFlash('success','Blog deleted.');header('Location: index.php');exit;}
if(isset($_GET['toggle'])){if(!verifyCsrfToken($_GET['csrf']??'')){setFlash('danger','CSRF error.');header('Location: index.php');exit;}$pdo->prepare("UPDATE blogs SET status=1-status WHERE id=?")->execute([(int)$_GET['toggle']]);setFlash('success','Status updated.');header('Location: index.php');exit;}
$blogs=$pdo->query("SELECT * FROM blogs ORDER BY created_at DESC")->fetchAll();
$adminPageTitle='Manage Blogs';$adminActive='blogs';
require_once __DIR__ . '/../includes/admin_header.php';
?>
<?php $f=getFlash();if($f):?><div class="adm-alert adm-alert-<?=$f['type']==='success'?'success':'danger'?>" data-auto-dismiss="4000"><i class="bi bi-check-circle-fill"></i><?=e($f['message'])?></div><?php endif;?>
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
  <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.2rem;font-weight:700;color:#fff;margin:0;">Blog Posts (<?=count($blogs)?>)</h2>
  <a href="add.php" class="adm-btn adm-btn-primary"><i class="bi bi-plus-circle-fill"></i> New Blog Post</a>
</div>
<div class="adm-card"><div style="overflow-x:auto;"><table class="adm-table">
  <thead><tr><th>#</th><th>Title</th><th>Category</th><th>Author</th><th>Date</th><th>Status</th><th>Actions</th></tr></thead>
  <tbody>
    <?php if($blogs):foreach($blogs as $i=>$b):?>
    <tr>
      <td style="color:var(--adm-muted)"><?=$i+1?></td>
      <td><div style="font-weight:600;color:#fff;"><?=e(substr($b['title'],0,50))?></div><div style="font-size:0.72rem;color:var(--adm-muted)"><?=e($b['slug'])?></div></td>
      <td><span class="adm-badge adm-badge-blue"><?=e($b['category']??'General')?></span></td>
      <td style="font-size:0.82rem"><?=e($b['author']??'Admin')?></td>
      <td style="font-size:0.78rem;color:var(--adm-muted)"><?=date('d M Y',strtotime($b['created_at']))?></td>
      <td><a href="index.php?toggle=<?=$b['id']?>&csrf=<?=urlencode($csrf)?>" class="adm-badge <?=$b['status']?'adm-badge-green':'adm-badge-red'?>" style="cursor:pointer;text-decoration:none"><?=$b['status']?'Published':'Draft'?></a></td>
      <td><div style="display:flex;gap:6px;"><a href="add.php?edit=<?=$b['id']?>" class="adm-btn adm-btn-sm adm-btn-outline"><i class="bi bi-pencil-fill"></i> Edit</a><a href="index.php?delete=<?=$b['id']?>&csrf=<?=urlencode($csrf)?>" class="adm-btn adm-btn-sm adm-btn-danger" onclick="return confirm('Delete?')"><i class="bi bi-trash-fill"></i></a></div></td>
    </tr>
    <?php endforeach;else:?>
    <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--adm-muted)">No posts. <a href="add.php" style="color:var(--adm-primary)">Write one</a>.</td></tr>
    <?php endif;?>
  </tbody>
</table></div></div>
<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?> -->
