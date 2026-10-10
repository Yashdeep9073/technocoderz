<?php
// ============================================================
// Admin — Services List + CRUD
// ============================================================
require_once __DIR__ . '/../../includes/functions.php';
requireAdminLogin();
$pdo  = getDB();
$csrf = generateCsrfToken();

if (isset($_GET['delete'])) {
    if (!verifyCsrfToken($_GET['csrf'] ?? '')) { setFlash('danger','CSRF error.'); header('Location: index.php'); exit; }
    $pdo->prepare("DELETE FROM services WHERE id=?")->execute([(int)$_GET['delete']]);
    setFlash('success','Service deleted.'); header('Location: index.php'); exit;
}
if (isset($_GET['toggle'])) {
    if (!verifyCsrfToken($_GET['csrf'] ?? '')) { setFlash('danger','CSRF error.'); header('Location: index.php'); exit; }
    $pdo->prepare("UPDATE services SET status=1-status WHERE id=?")->execute([(int)$_GET['toggle']]);
    setFlash('success','Status updated.'); header('Location: index.php'); exit;
}

$services = $pdo->query("SELECT * FROM services ORDER BY sort_order ASC, id ASC")->fetchAll();
$adminPageTitle = 'Manage Services';
$adminActive    = 'services';
require_once __DIR__ . '/../includes/admin_header.php';
?>
<?php $f=getFlash(); if($f): ?><div class="adm-alert adm-alert-<?=$f['type']==='success'?'success':'danger'?>" data-auto-dismiss="4000"><i class="bi bi-check-circle-fill"></i><?=e($f['message'])?></div><?php endif; ?>
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
  <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.2rem;font-weight:700;color:#fff;margin:0;">Services (<?=count($services)?>)</h2>
  <a href="add.php" class="adm-btn adm-btn-primary"><i class="bi bi-plus-circle-fill"></i> Add Service</a>
</div>
<div class="adm-card"><div style="overflow-x:auto;"><table class="adm-table">
  <thead><tr><th>#</th><th>Title</th><th>Icon</th><th>Status</th><th>Actions</th></tr></thead>
  <tbody>
    <?php if($services): foreach($services as $i=>$s): ?>
    <tr>
      <td style="color:var(--adm-muted)"><?=$i+1?></td>
      <td><div style="font-weight:600;color:#fff;"><?=e($s['title'])?></div><div style="font-size:0.75rem;color:var(--adm-muted)"><?=e(substr($s['short_description']??'',0,60))?></div></td>
      <td><i class="<?=e($s['icon']??'bi bi-gear')?>" style="font-size:1.2rem;color:var(--adm-muted)"></i></td>
      <td><a href="index.php?toggle=<?=$s['id']?>&csrf=<?=urlencode($csrf)?>" class="adm-badge <?=$s['status']?'adm-badge-green':'adm-badge-red'?>" style="cursor:pointer;text-decoration:none"><?=$s['status']?'Active':'Inactive'?></a></td>
      <td><div style="display:flex;gap:6px;"><a href="add.php?edit=<?=$s['id']?>" class="adm-btn adm-btn-sm adm-btn-outline"><i class="bi bi-pencil-fill"></i> Edit</a><a href="index.php?delete=<?=$s['id']?>&csrf=<?=urlencode($csrf)?>" class="adm-btn adm-btn-sm adm-btn-danger" onclick="return confirm('Delete?')"><i class="bi bi-trash-fill"></i></a></div></td>
    </tr>
    <?php endforeach; else: ?>
    <tr><td colspan="5" style="text-align:center;padding:40px;color:var(--adm-muted)">No services yet. <a href="add.php" style="color:var(--adm-primary)">Add one</a>.</td></tr>
    <?php endif; ?>
  </tbody>
</table></div></div>
<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>
