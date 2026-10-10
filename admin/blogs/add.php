<?php
require_once __DIR__ . '/../../includes/functions.php';
requireAdminLogin();
$pdo=getDB();$editId=isset($_GET['edit'])?(int)$_GET['edit']:0;$blog=$editId?fetchById('blogs',$editId):null;$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  if(!verifyCsrfToken($_POST['csrf_token']??'')){$error='CSRF error.';}
  else{
    $title=sanitize($_POST['title']??'');$slug=slugify($_POST['slug']?:$title);if($slug==='')$slug='post-'.time();$excerpt=sanitize($_POST['excerpt']??'');$content=trim($_POST['content']??'');$author=sanitize($_POST['author']??'Techno Coderz Team');$cat=sanitize($_POST['category']??'');$tags=sanitize($_POST['tags']??'');$status=isset($_POST['status'])?1:0;
    if(!$title){$error='Title required.';}
    else{
      $imgError='';$newImage=uploadImage($_FILES['image']??[],'blogs',$imgError);
      if($imgError){$error=$imgError;}
      else{
        $image=$blog['image']??null;
        if(!empty($_POST['remove_image'])&&$editId){deleteUploadedImage('blogs',$blog['image']??null);$image=null;}
        if($newImage!==''){deleteUploadedImage('blogs',$blog['image']??null);$image=$newImage;}
        $checkSlug=$pdo->prepare("SELECT id FROM blogs WHERE slug=? AND id!=?");$checkSlug->execute([$slug,$editId]);if($checkSlug->rowCount()>0)$slug.='-'.time();
        if($editId){$pdo->prepare("UPDATE blogs SET title=?,slug=?,excerpt=?,content=?,author=?,category=?,tags=?,image=?,status=? WHERE id=?")->execute([$title,$slug,$excerpt,$content,$author,$cat,$tags,$image,$status,$editId]);setFlash('success','Blog updated!');}
        else{$pdo->prepare("INSERT INTO blogs (title,slug,excerpt,content,author,category,tags,image,status) VALUES (?,?,?,?,?,?,?,?,?)")->execute([$title,$slug,$excerpt,$content,$author,$cat,$tags,$image,$status]);setFlash('success','Blog post created!');}
        header('Location: index.php');exit;
      }
    }
  }
}
$adminPageTitle=$editId?'Edit Blog Post':'New Blog Post';$adminActive='blogs';
require_once __DIR__ . '/../includes/admin_header.php';
?>
<div style="max-width:860px;">
  <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px;"><a href="index.php" class="adm-btn adm-btn-sm adm-btn-outline"><i class="bi bi-arrow-left"></i> Back</a><h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.1rem;font-weight:700;color:#fff;margin:0;"><?=$editId?'Edit Post':'New Blog Post'?></h2></div>
  <?php if($error):?><div class="adm-alert adm-alert-danger"><i class="bi bi-exclamation-triangle-fill"></i><?=e($error)?></div><?php endif;?>
  <div class="adm-card"><div class="adm-card-body"><form method="POST" enctype="multipart/form-data"><?=csrfField()?>
    <div class="row g-3">
      <div class="col-md-9"><div class="adm-form-group"><label class="adm-label">Post Title *</label><input type="text" name="title" class="adm-input" required value="<?=e($blog['title']??'')?>" placeholder="Enter a compelling article title..."></div></div>
      <div class="col-md-3"><div class="adm-form-group"><label class="adm-label">Slug</label><input type="text" name="slug" class="adm-input" value="<?=e($blog['slug']??'')?>" placeholder="auto-generated"></div></div>
      <div class="col-md-4"><div class="adm-form-group"><label class="adm-label">Category</label><input type="text" name="category" class="adm-input" value="<?=e($blog['category']??'')?>" placeholder="e.g. PHP, Career, Tutorial"></div></div>
      <div class="col-md-4"><div class="adm-form-group"><label class="adm-label">Author</label><input type="text" name="author" class="adm-input" value="<?=e($blog['author']??'Techno Coderz Team')?>"></div></div>
      <div class="col-md-4"><div class="adm-form-group"><label class="adm-label">Tags (comma separated)</label><input type="text" name="tags" class="adm-input" value="<?=e($blog['tags']??'')?>" placeholder="php,tutorial,mysql"></div></div>
      <div class="col-12"><div class="adm-form-group"><label class="adm-label">Featured Image (JPG/PNG/WebP, max 2 MB)</label><input type="file" name="image" class="adm-input" accept="image/jpeg,image/png,image/webp"><?php if(!empty($blog['image'])):?><div style="display:flex;align-items:center;gap:12px;margin-top:10px;"><img src="<?=e(blogImage($blog['image']))?>" alt="" style="width:64px;height:44px;object-fit:cover;border-radius:8px;border:1px solid var(--adm-border);"><label style="display:flex;align-items:center;gap:8px;font-size:0.78rem;color:var(--adm-muted);cursor:pointer;margin:0;"><input type="checkbox" name="remove_image" value="1" style="width:14px;height:14px;accent-color:var(--adm-primary);"> Remove current image</label></div><?php endif;?></div></div>
      <div class="col-12"><div class="adm-form-group"><label class="adm-label">Excerpt (shown on listing)</label><textarea name="excerpt" class="adm-input" rows="2" maxlength="400"><?=e($blog['excerpt']??'')?></textarea></div></div>
      <div class="col-12"><div class="adm-form-group"><label class="adm-label">Full Content</label><textarea name="content" class="adm-input" rows="14"><?=e($blog['content']??'')?></textarea></div></div>
      <div class="col-md-4" style="display:flex;align-items:flex-end;"><div class="adm-form-group w-100"><label class="adm-label">Status</label><label style="display:flex;align-items:center;gap:10px;cursor:pointer;padding:10px 14px;background:rgba(255,255,255,0.05);border:1px solid var(--adm-border);border-radius:8px;"><input type="checkbox" name="status" <?=($blog['status']??1)?'checked':''?> style="width:16px;height:16px;accent-color:var(--adm-primary)"><span style="font-size:0.87rem;">Published</span></label></div></div>
    </div>
    <div style="display:flex;gap:12px;margin-top:8px;"><button type="submit" class="adm-btn adm-btn-primary"><i class="bi bi-check-circle-fill"></i> <?=$editId?'Update Post':'Publish Post'?></button><a href="index.php" class="adm-btn adm-btn-outline">Cancel</a></div>
  </form></div></div>
</div>
<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>
