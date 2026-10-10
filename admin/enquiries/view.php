<?php
require_once __DIR__ . '/../../includes/functions.php';
requireAdminLogin();
$pdo=getDB();$id=(int)($_GET['id']??0);
if(!$id){header('Location: index.php');exit;}
$enq=$pdo->prepare("SELECT * FROM enquiries WHERE id=?");$enq->execute([$id]);$enq=$enq->fetch();
if(!$enq){header('Location: index.php');exit;}
$adminPageTitle='View Enquiry';$adminActive='enquiries';
require_once __DIR__ . '/../includes/admin_header.php';
?>
<div style="max-width:680px;">
  <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px;"><a href="index.php" class="adm-btn adm-btn-sm adm-btn-outline"><i class="bi bi-arrow-left"></i> Back to Enquiries</a></div>
  <div class="adm-card">
    <div class="adm-card-header">
      <h3 class="adm-card-title">Enquiry from <?=e($enq['name'])?></h3>
      <span class="adm-badge adm-badge-<?=$enq['status']==='new'?'yel':($enq['status']==='resolved'?'green':'blue')?>"><?=ucfirst(str_replace('_',' ',$enq['status']))?></span>
    </div>
    <div class="adm-card-body">
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
        <div><div style="font-size:0.72rem;color:var(--adm-muted);text-transform:uppercase;letter-spacing:0.8px;margin-bottom:4px;">Name</div><div style="font-weight:600;color:#fff"><?=e($enq['name'])?></div></div>
        <div><div style="font-size:0.72rem;color:var(--adm-muted);text-transform:uppercase;letter-spacing:0.8px;margin-bottom:4px;">Email</div><div><a href="mailto:<?=e($enq['email'])?>" style="color:var(--adm-primary)"><?=e($enq['email'])?></a></div></div>
        <div><div style="font-size:0.72rem;color:var(--adm-muted);text-transform:uppercase;letter-spacing:0.8px;margin-bottom:4px;">Phone</div><div><?=e($enq['phone']??'Not provided')?></div></div>
        <div><div style="font-size:0.72rem;color:var(--adm-muted);text-transform:uppercase;letter-spacing:0.8px;margin-bottom:4px;">Course</div><div><?=e($enq['course']??'Not specified')?></div></div>
        <div><div style="font-size:0.72rem;color:var(--adm-muted);text-transform:uppercase;letter-spacing:0.8px;margin-bottom:4px;">Date</div><div><?=date('d M Y, h:i A',strtotime($enq['created_at']))?></div></div>
      </div>
      <?php if($enq['message']):?>
      <div><div style="font-size:0.72rem;color:var(--adm-muted);text-transform:uppercase;letter-spacing:0.8px;margin-bottom:8px;">Message</div>
      <div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:10px;padding:16px;font-size:0.87rem;line-height:1.75;color:var(--adm-text)"><?=nl2br(e($enq['message']))?></div></div>
      <?php endif;?>
      <div style="display:flex;gap:12px;margin-top:24px;">
        <a href="mailto:<?=e($enq['email'])?>" class="adm-btn adm-btn-primary"><i class="bi bi-envelope-fill"></i> Reply by Email</a>
        <?php if($enq['phone']):?><a href="tel:<?=e(preg_replace('/\s+/','',$enq['phone']))?>" class="adm-btn adm-btn-outline"><i class="bi bi-telephone-fill"></i> Call</a><?php endif;?>
        <a href="index.php" class="adm-btn adm-btn-outline">Back</a>
      </div>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>
