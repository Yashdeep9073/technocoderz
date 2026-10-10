<?php
// ============================================================
// Admin — Add / Edit Course
// ============================================================
require_once __DIR__ . '/../../includes/functions.php';
requireAdminLogin();

$pdo    = getDB();
$editId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$course = $editId ? fetchById('courses', $editId) : null;
$error  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $error = 'Security token invalid. Please refresh.';
    } else {
        $title    = sanitize($_POST['title']             ?? '');
        $slug     = slugify($_POST['slug'] ?: $title);
        if ($slug === '') { $slug = 'course-' . time(); }
        $shortD   = sanitize($_POST['short_description'] ?? '');
        $desc     = sanitize($_POST['description']       ?? '');
        $duration = sanitize($_POST['duration']          ?? '');
        $level    = sanitize($_POST['level']             ?? 'Beginner');
        $icon     = sanitize($_POST['icon']              ?? '');
        $status   = isset($_POST['status']) ? 1 : 0;
        $order    = (int)($_POST['sort_order'] ?? 0);

        if (empty($title)) { $error = 'Title is required.'; }
        else {
            // Optional image upload (JPG/PNG/WebP, max 2 MB)
            $imgError = '';
            $newImage = uploadImage($_FILES['image'] ?? [], 'courses', $imgError);
            if ($imgError) {
                $error = $imgError;
            } else {
            $image = $course['image'] ?? null;

            if (!empty($_POST['remove_image']) && $editId) {
                deleteUploadedImage('courses', $course['image'] ?? null);
                $image = null;
            }

            if ($newImage !== '') {
                deleteUploadedImage('courses', $course['image'] ?? null);
                $image = $newImage;
            }

            // Check slug uniqueness
            $checkSlug = $pdo->prepare("SELECT id FROM courses WHERE slug = ? AND id != ?");
            $checkSlug->execute([$slug, $editId]);
            if ($checkSlug->rowCount() > 0) {
                $slug .= '-' . time();
            }

            if ($editId) {
                $stmt = $pdo->prepare("UPDATE courses SET title=?,slug=?,short_description=?,description=?,duration=?,level=?,icon=?,image=?,status=?,sort_order=? WHERE id=?");
                $stmt->execute([$title,$slug,$shortD,$desc,$duration,$level,$icon,$image,$status,$order,$editId]);
                setFlash('success', 'Course updated successfully!');
            } else {
                $stmt = $pdo->prepare("INSERT INTO courses (title,slug,short_description,description,duration,level,icon,image,status,sort_order) VALUES (?,?,?,?,?,?,?,?,?,?)");
                $stmt->execute([$title,$slug,$shortD,$desc,$duration,$level,$icon,$image,$status,$order]);
                setFlash('success', 'Course added successfully!');
            }
            header('Location: index.php'); exit;
            }
        }
    }
}

$adminPageTitle = $editId ? 'Edit Course' : 'Add New Course';
$adminActive    = 'courses';
require_once __DIR__ . '/../includes/admin_header.php';
?>

<div style="max-width:780px;">

  <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px;">
    <a href="index.php" class="adm-btn adm-btn-sm adm-btn-outline"><i class="bi bi-arrow-left"></i> Back</a>
    <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.1rem;font-weight:700;color:#fff;margin:0;">
      <?= $editId ? 'Edit Course' : 'Add New Course' ?>
    </h2>
  </div>

  <?php if ($error): ?>
  <div class="adm-alert adm-alert-danger"><i class="bi bi-exclamation-triangle-fill"></i><?= e($error) ?></div>
  <?php endif; ?>

  <div class="adm-card">
    <div class="adm-card-body">
      <form method="POST" enctype="multipart/form-data" novalidate>
        <?= csrfField() ?>

        <div class="row g-3">
          <div class="col-md-8">
            <div class="adm-form-group">
              <label class="adm-label">Course Title *</label>
              <input type="text" name="title" class="adm-input" required
                     value="<?= e($course['title'] ?? '') ?>"
                     placeholder="e.g. Full Stack Web Development">
            </div>
          </div>
          <div class="col-md-4">
            <div class="adm-form-group">
              <label class="adm-label">Slug (auto-generated)</label>
              <input type="text" name="slug" class="adm-input"
                     value="<?= e($course['slug'] ?? '') ?>"
                     placeholder="full-stack-web-development">
            </div>
          </div>
          <div class="col-12">
            <div class="adm-form-group">
              <label class="adm-label">Short Description</label>
              <input type="text" name="short_description" class="adm-input" maxlength="300"
                     value="<?= e($course['short_description'] ?? '') ?>"
                     placeholder="Brief summary shown on cards (max 300 chars)">
            </div>
          </div>
          <div class="col-12">
            <div class="adm-form-group">
              <label class="adm-label">Full Description</label>
              <textarea name="description" class="adm-input" rows="5"
                        placeholder="Detailed course description..."><?= e($course['description'] ?? '') ?></textarea>
            </div>
          </div>
          <div class="col-md-4">
            <div class="adm-form-group">
              <label class="adm-label">Duration</label>
              <input type="text" name="duration" class="adm-input"
                     value="<?= e($course['duration'] ?? '') ?>" placeholder="e.g. 3 Months">
            </div>
          </div>
          <div class="col-md-4">
            <div class="adm-form-group">
              <label class="adm-label">Level</label>
              <select name="level" class="adm-input">
                <?php foreach (['Beginner','Intermediate','Advanced','All Levels'] as $lvl): ?>
                <option value="<?= $lvl ?>" <?= ($course['level'] ?? 'Beginner') === $lvl ? 'selected' : '' ?>><?= $lvl ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="adm-form-group">
              <label class="adm-label">Icon Class (Bootstrap Icons)</label>
              <input type="text" name="icon" class="adm-input"
                     value="<?= e($course['icon'] ?? '') ?>" placeholder="bi bi-layers-fill">
            </div>
          </div>
          <div class="col-md-4">
            <div class="adm-form-group">
              <label class="adm-label">Cover Image (JPG/PNG/WebP, max 2 MB)</label>
              <input type="file" name="image" class="adm-input" accept="image/jpeg,image/png,image/webp">
              <?php if (!empty($course['image'])): ?>
                <div style="display:flex;align-items:center;gap:12px;margin-top:10px;">
                  <img src="<?= e(courseImage($course['image'])) ?>" alt="" style="width:64px;height:44px;object-fit:cover;border-radius:8px;border:1px solid var(--adm-border);">
                  <label style="display:flex;align-items:center;gap:8px;font-size:0.78rem;color:var(--adm-muted);cursor:pointer;margin:0;">
                    <input type="checkbox" name="remove_image" value="1" style="width:14px;height:14px;accent-color:var(--adm-primary);">
                    Remove current image
                  </label>
                </div>
              <?php endif; ?>
            </div>
          </div>
          <div class="col-md-4">
            <div class="adm-form-group">
              <label class="adm-label">Sort Order</label>
              <input type="number" name="sort_order" class="adm-input"
                     value="<?= e($course['sort_order'] ?? 0) ?>" min="0">
            </div>
          </div>
          <div class="col-md-4" style="display:flex;align-items:flex-end;">
            <div class="adm-form-group w-100">
              <label class="adm-label">Status</label>
              <label style="display:flex;align-items:center;gap:10px;cursor:pointer;padding:10px 14px;background:rgba(255,255,255,0.05);border:1px solid var(--adm-border);border-radius:8px;">
                <input type="checkbox" name="status" <?= ($course['status'] ?? 1) ? 'checked' : '' ?> style="width:16px;height:16px;accent-color:var(--adm-primary);">
                <span style="font-size:0.87rem;">Active (show on website)</span>
              </label>
            </div>
          </div>
        </div>

        <div style="display:flex;gap:12px;margin-top:8px;">
          <button type="submit" class="adm-btn adm-btn-primary">
            <i class="bi bi-check-circle-fill"></i> <?= $editId ? 'Update Course' : 'Save Course' ?>
          </button>
          <a href="index.php" class="adm-btn adm-btn-outline">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>
