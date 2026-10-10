<?php
require_once __DIR__ . '/../../includes/functions.php';
requireAdminLogin();
$pdo=getDB();$editId=isset($_GET['edit'])?(int)$_GET['edit']:0;$t=$editId?fetchById('testimonials',$editId):null;$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  if(!verifyCsrfToken($_POST['csrf_token']??'')){$error='CSRF error.';}
  else{
    $name=sanitize($_POST['name']??'');$desig=sanitize($_POST['designation']??'');$msg=sanitize($_POST['message']??'');$rating=(int)($_POST['rating']??5);$status=isset($_POST['status'])?1:0;
    if(!$name||!$msg){$error='Name and message required.';}
    else{if($editId){$pdo->prepare("UPDATE testimonials SET name=?,designation=?,message=?,rating=?,status=? WHERE id=?")->execute([$name,$desig,$msg,$rating,$status,$editId]);setFlash('success','Testimonial updated!');}else{$pdo->prepare("INSERT INTO testimonials (name,designation,message,rating,status) VALUES (?,?,?,?,?)")->execute([$name,$desig,$msg,$rating,$status]);setFlash('success','Testimonial added!');}header('Location: index.php');exit;}
  }
}
$adminPageTitle=$editId?'Edit Testimonial':'Add Testimonial';$adminActive='testimonials';
require_once __DIR__ . '/../includes/admin_header.php';
?>
<div style="max-width:680px;">
  <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px;"><a href="index.php" class="adm-btn adm-btn-sm adm-btn-outline"><i class="bi bi-arrow-left"></i> Back</a><h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.1rem;font-weight:700;color:#fff;margin:0;"><?=$editId?'Edit':'Add'?> Testimonial</h2></div>
  <?php if($error):?><div class="adm-alert adm-alert-danger"><i class="bi bi-exclamation-triangle-fill"></i><?=e($error)?></div><?php endif;?>
  <div class="adm-card"><div class="adm-card-body"><form method="POST"><?=csrfField()?>
    <div class="row g-3">
      <div class="col-md-6"><div class="adm-form-group"><label class="adm-label">Full Name *</label><input type="text" name="name" class="adm-input" required value="<?=e($t['name']??'')?>" placeholder="e.g. Rahul Sharma"></div></div>
      <div class="col-md-6"><div class="adm-form-group"><label class="adm-label">Designation</label><input type="text" name="designation" class="adm-input" value="<?=e($t['designation']??'')?>" placeholder="e.g. PHP Developer, Infosys"></div></div>
      <div class="col-12"><div class="adm-form-group"><label class="adm-label">Testimonial Message *</label><textarea name="message" class="adm-input" rows="5" required><?=e($t['message']??'')?></textarea></div></div>
      <div class="col-md-4"><div class="adm-form-group"><label class="adm-label">Rating (1–5)</label><select name="rating" class="adm-input"><?php for($r=5;$r>=1;$r--):?><option value="<?=$r?>" <?=(($t['rating']??5)==$r)?'selected':''?>><?=$r?> Star<?=$r<2?'':'s'?></option><?php endfor;?></select></div></div>
      <div class="col-md-4" style="display:flex;align-items:flex-end;"><div class="adm-form-group w-100"><label class="adm-label">Status</label><label style="display:flex;align-items:center;gap:10px;cursor:pointer;padding:10px 14px;background:rgba(255,255,255,0.05);border:1px solid var(--adm-border);border-radius:8px;"><input type="checkbox" name="status" <?=($t['status']??1)?'checked':''?> style="width:16px;height:16px;accent-color:var(--adm-primary)"><span style="font-size:0.87rem;">Active</span></label></div></div>
    </div>
    <div style="display:flex;gap:12px;margin-top:8px;"><button type="submit" class="adm-btn adm-btn-primary"><i class="bi bi-check-circle-fill"></i> <?=$editId?'Update':'Save'?></button><a href="index.php" class="adm-btn adm-btn-outline">Cancel</a></div>
  </form></div></div>
</div>
<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>
