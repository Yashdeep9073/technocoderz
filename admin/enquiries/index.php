<?php
require_once __DIR__ . '/../../includes/functions.php';
requireAdminLogin();
$pdo=getDB();$csrf=generateCsrfToken();

// Status update
if($_SERVER['REQUEST_METHOD']==='POST'&&isset($_POST['update_status'])){
  if(!verifyCsrfToken($_POST['csrf_token']??'')){setFlash('danger','CSRF error.');}
  else{$pdo->prepare("UPDATE enquiries SET status=? WHERE id=?")->execute([sanitize($_POST['status']),$_POST['id']]);setFlash('success','Status updated.');}
  header('Location: index.php');exit;
}
if(isset($_GET['delete'])){if(!verifyCsrfToken($_GET['csrf']??'')){setFlash('danger','CSRF error.');header('Location: index.php');exit;}$pdo->prepare("DELETE FROM enquiries WHERE id=?")->execute([(int)$_GET['delete']]);setFlash('success','Enquiry deleted.');header('Location: index.php');exit;}

$filter=$_GET['status']??'all';
$where=$filter!=='all'?"WHERE status='".htmlspecialchars($filter,ENT_QUOTES)."'":'';
$enquiries=$pdo->query("SELECT * FROM enquiries $where ORDER BY created_at DESC")->fetchAll();
$adminPageTitle='Enquiries';$adminActive='enquiries';
require_once __DIR__ . '/../includes/admin_header.php';
?>
<?php $f=getFlash();if($f):?><div class="adm-alert adm-alert-<?=$f['type']==='success'?'success':'danger'?>" data-auto-dismiss="4000"><i class="bi bi-check-circle-fill"></i><?=e($f['message'])?></div><?php endif;?>
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
  <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.2rem;font-weight:700;color:#fff;margin:0;">Enquiries (<?=count($enquiries)?>)</h2>
  <div style="display:flex;gap:8px;">
    <?php foreach(['all','new','in_progress','resolved'] as $st):$lbl=ucfirst(str_replace('_',' ',$st));?>
    <a href="?status=<?=$st?>" class="adm-btn adm-btn-sm <?=($filter===$st)?'adm-btn-primary':'adm-btn-outline'?>"><?=$lbl?></a>
    <?php endforeach;?>
  </div>
</div>
<div class="adm-card"><div style="overflow-x:auto;"><table class="adm-table">
  <thead><tr><th>#</th><th>Name / Email</th><th>Phone</th><th>Course</th><th>Date</th><th>Status</th><th>Actions</th></tr></thead>
  <tbody>
    <?php if($enquiries):foreach($enquiries as $i=>$enq):?>
    <tr>
      <td style="color:var(--adm-muted)"><?=$i+1?></td>
      <td><div style="font-weight:600;color:#fff;"><?=e($enq['name'])?></div><div style="font-size:0.75rem;color:var(--adm-muted)"><?=e($enq['email'])?></div></td>
      <td style="font-size:0.82rem"><?=e($enq['phone']??'-')?></td>
      <td style="font-size:0.82rem"><?=e(substr($enq['course']??'-',0,35))?></td>
      <td style="font-size:0.78rem;color:var(--adm-muted)"><?=date('d M Y',strtotime($enq['created_at']))?></td>
      <td>
        <form method="POST" style="display:inline;"><?=csrfField()?><input type="hidden" name="update_status" value="1"><input type="hidden" name="id" value="<?=$enq['id']?>">
          <select name="status" class="adm-input" style="padding:4px 8px;font-size:0.75rem;width:auto;" onchange="this.form.submit()">
            <?php foreach(['new','in_progress','resolved'] as $st):?><option value="<?=$st?>" <?=$enq['status']===$st?'selected':''?>><?=ucfirst(str_replace('_',' ',$st))?></option><?php endforeach;?>
          </select>
        </form>
      </td>
      <td><div style="display:flex;gap:6px;"><a href="view.php?id=<?=$enq['id']?>" class="adm-btn adm-btn-sm adm-btn-outline"><i class="bi bi-eye"></i> View</a><a href="index.php?delete=<?=$enq['id']?>&csrf=<?=urlencode($csrf)?>" class="adm-btn adm-btn-sm adm-btn-danger" onclick="return confirm('Delete?')"><i class="bi bi-trash-fill"></i></a></div></td>
    </tr>
    <?php endforeach;else:?>
    <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--adm-muted)">No enquiries found.</td></tr>
    <?php endif;?>
  </tbody>
</table></div></div>
<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>
