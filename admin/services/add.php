<?php
require_once __DIR__ . '/../../includes/functions.php';
requireAdminLogin();
$pdo    = getDB();
$editId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$svc    = $editId ? fetchById('services', $editId) : null;
$error  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) { $error = 'CSRF error.'; }
    else {
        $title  = sanitize($_POST['title']             ?? '');
        $shortD = sanitize($_POST['short_description'] ?? '');
        $desc   = sanitize($_POST['description']       ?? '');
        $icon   = sanitize($_POST['icon']              ?? '');
        $status = isset($_POST['status']) ? 1 : 0;
        $order  = (int)($_POST['sort_order'] ?? 0);
        if (!$title) { $error = 'Title is required.'; }
        else {
            if ($editId) {
                $pdo->prepare("UPDATE services SET title=?,short_description=?,description=?,icon=?,status=?,sort_order=? WHERE id=?")->execute([$title,$shortD,$desc,$icon,$status,$order,$editId]);
                setFlash('success','Service updated!');
            } else {
                $pdo->prepare("INSERT INTO services (title,short_description,description,icon,status,sort_order) VALUES (?,?,?,?,?,?)")->execute([$title,$shortD,$desc,$icon,$status,$order]);
                setFlash('success','Service added!');
            }
            header('Location: index.php'); exit;
        }
    }
}
$adminPageTitle = $editId ? 'Edit Service' : 'Add Service';
$adminActive    = 'services';
require_once __DIR__ . '/../includes/admin_header.php';
?>
<div style="max-width:720px;">
  <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px;"><a href="index.php" class="adm-btn adm-btn-sm adm-btn-outline"><i class="bi bi-arrow-left"></i> Back</a><h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.1rem;font-weight:700;color:#fff;margin:0;"><?=$editId?'Edit Service':'Add Service'?></h2></div>
  <?php if($error): ?><div class="adm-alert adm-alert-danger"><i class="bi bi-exclamation-triangle-fill"></i><?=e($error)?></div><?php endif; ?>
  <div class="adm-card"><div class="adm-card-body"><form method="POST">
    <?=csrfField()?>
    <div class="row g-3">
      <div class="col-md-8"><div class="adm-form-group"><label class="adm-label">Title *</label><input type="text" name="title" class="adm-input" required value="<?=e($svc['title']??'')?>" placeholder="e.g. Website Development"></div></div>
      <div class="col-md-4"><div class="adm-form-group"><label class="adm-label">Bootstrap Icon Class</label><input type="text" name="icon" class="adm-input" value="<?=e($svc['icon']??'')?>" placeholder="bi bi-globe2"></div></div>
      <div class="col-12"><div class="adm-form-group"><label class="adm-label">Short Description</label><input type="text" name="short_description" class="adm-input" maxlength="300" value="<?=e($svc['short_description']??'')?>" placeholder="Shown on cards"></div></div>
      <div class="col-12"><div class="adm-form-group"><label class="adm-label">Full Description</label><textarea name="description" class="adm-input" rows="4"><?=e($svc['description']??'')?></textarea></div></div>
      <div class="col-md-4"><div class="adm-form-group"><label class="adm-label">Sort Order</label><input type="number" name="sort_order" class="adm-input" value="<?=e($svc['sort_order']??0)?>" min="0"></div></div>
      <div class="col-md-4" style="display:flex;align-items:flex-end;"><div class="adm-form-group w-100"><label class="adm-label">Status</label><label style="display:flex;align-items:center;gap:10px;cursor:pointer;padding:10px 14px;background:rgba(255,255,255,0.05);border:1px solid var(--adm-border);border-radius:8px;"><input type="checkbox" name="status" <?=($svc['status']??1)?'checked':''?> style="width:16px;height:16px;accent-color:var(--adm-primary)"><span style="font-size:0.87rem;">Active</span></label></div></div>
    </div>
    <div style="display:flex;gap:12px;margin-top:8px;"><button type="submit" class="adm-btn adm-btn-primary"><i class="bi bi-check-circle-fill"></i> <?=$editId?'Update':'Save'?></button><a href="index.php" class="adm-btn adm-btn-outline">Cancel</a></div>
  </form></div></div>
</div>
<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>
