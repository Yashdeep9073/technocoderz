<?php
require_once __DIR__ . '/../../includes/functions.php';
requireAdminLogin();
$pdo=$getDB=getDB();$csrf=generateCsrfToken();
if(isset($_GET['delete'])){if(!verifyCsrfToken($_GET['csrf']??'')){setFlash('danger','CSRF error.');header('Location: index.php');exit;}$pdo->prepare("DELETE FROM projects WHERE id=?")->execute([(int)$_GET['delete']]);setFlash('success','Project deleted.');header('Location: index.php');exit;}
if(isset($_GET['toggle'])){if(!verifyCsrfToken($_GET['csrf']??'')){setFlash('danger','CSRF error.');header('Location: index.php');exit;}$pdo->prepare("UPDATE projects SET status=1-status WHERE id=?")->execute([(int)$_GET['toggle']]);setFlash('success','Status updated.');header('Location: index.php');exit;}
$projects=$pdo->query("SELECT * FROM projects ORDER BY sort_order ASC,id ASC")->fetchAll();
$adminPageTitle='Manage Projects';$adminActive='projects';
require_once __DIR__ . '/../includes/admin_header.php';
?>
<?php $f=getFlash();if($f):?><div class="adm-alert adm-alert-<?=$f['type']==='success'?'success':'danger'?>" data-auto-dismiss="4000"><i class="bi bi-check-circle-fill"></i><?=e($f['message'])?></div><?php endif;?>
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
  <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.2rem;font-weight:700;color:#fff;margin:0;">Projects (<?=count($projects)?>)</h2>
  <a href="add.php" class="adm-btn adm-btn-primary"><i class="bi bi-plus-circle-fill"></i> Add Project</a>
</div>
<div class="adm-card"><div style="overflow-x:auto;"><table class="adm-table">
  <thead><tr><th>#</th><th>Title</th><th>Technology</th><th>Status</th><th>Actions</th></tr></thead>
  <tbody>
    <?php if($projects):foreach($projects as $i=>$p):?>
    <tr>
      <td style="color:var(--adm-muted)"><?=$i+1?></td>
      <td><div style="font-weight:600;color:#fff;"><?=e($p['title'])?></div></td>
      <td style="font-size:0.8rem;color:var(--adm-muted)"><?=e(substr($p['technology']??'',0,50))?></td>
      <td><a href="index.php?toggle=<?=$p['id']?>&csrf=<?=urlencode($csrf)?>" class="adm-badge <?=$p['status']?'adm-badge-green':'adm-badge-red'?>" style="cursor:pointer;text-decoration:none"><?=$p['status']?'Active':'Inactive'?></a></td>
      <td><div style="display:flex;gap:6px;"><a href="add.php?edit=<?=$p['id']?>" class="adm-btn adm-btn-sm adm-btn-outline"><i class="bi bi-pencil-fill"></i> Edit</a><a href="index.php?delete=<?=$p['id']?>&csrf=<?=urlencode($csrf)?>" class="adm-btn adm-btn-sm adm-btn-danger" onclick="return confirm('Delete?')"><i class="bi bi-trash-fill"></i></a></div></td>
    </tr>
    <?php endforeach;else:?>
    <tr><td colspan="5" style="text-align:center;padding:40px;color:var(--adm-muted)">No projects. <a href="add.php" style="color:var(--adm-primary)">Add one</a>.</td></tr>
    <?php endif;?>
  </tbody>
</table></div></div>
<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>
