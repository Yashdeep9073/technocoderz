<?php
// ============================================================
// Admin — Courses List
// ============================================================
require_once __DIR__ . '/../../includes/functions.php';
requireAdminLogin();

// Handle delete
if (isset($_GET['delete'])) {
    if (!verifyCsrfToken($_GET['csrf'] ?? '')) {
        setFlash('danger', 'CSRF token invalid.'); header('Location: index.php'); exit;
    }
    $id = (int)$_GET['delete'];
    $pdo = getDB();
    $pdo->prepare("DELETE FROM courses WHERE id = ?")->execute([$id]);
    setFlash('success', 'Course deleted successfully.');
    header('Location: index.php'); exit;
}

// Handle status toggle
if (isset($_GET['toggle'])) {
    if (!verifyCsrfToken($_GET['csrf'] ?? '')) {
        setFlash('danger', 'CSRF token invalid.'); header('Location: index.php'); exit;
    }
    $id  = (int)$_GET['toggle'];
    $pdo = getDB();
    $pdo->prepare("UPDATE courses SET status = 1 - status WHERE id = ?")->execute([$id]);
    setFlash('success', 'Course status updated.');
    header('Location: index.php'); exit;
}

$pdo = getDB();
$courses = $pdo->query("SELECT * FROM courses ORDER BY sort_order ASC, id ASC")->fetchAll();

$adminPageTitle = 'Manage Courses';
$adminActive    = 'courses';
$csrf           = generateCsrfToken();
require_once __DIR__ . '/../includes/admin_header.php';
?>

<?php $flash = getFlash(); if ($flash): ?>
<div class="adm-alert adm-alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?>" data-auto-dismiss="4000">
  <i class="bi bi-<?= $flash['type'] === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill' ?>"></i>
  <?= e($flash['message']) ?>
</div>
<?php endif; ?>

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
  <div>
    <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.2rem;font-weight:700;color:#fff;margin:0;">
      All Courses <span style="color:var(--adm-muted);font-weight:400;font-size:0.9rem;">(<?= count($courses) ?>)</span>
    </h2>
  </div>
  <a href="<?= ADMIN_URL ?>/courses/add.php" class="adm-btn adm-btn-primary">
    <i class="bi bi-plus-circle-fill"></i> Add New Course
  </a>
</div>

<div class="adm-card">
  <div style="overflow-x:auto;">
    <table class="adm-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Title</th>
          <th>Duration</th>
          <th>Level</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($courses): ?>
          <?php foreach ($courses as $i => $c): ?>
          <tr>
            <td style="color:var(--adm-muted);font-size:0.78rem;"><?= $i + 1 ?></td>
            <td>
              <div style="font-weight:600;color:#fff;"><?= e($c['title']) ?></div>
              <div style="font-size:0.75rem;color:var(--adm-muted);"><?= e($c['slug']) ?></div>
            </td>
            <td><?= e($c['duration'] ?? '-') ?></td>
            <td><span class="adm-badge adm-badge-blue"><?= e($c['level']) ?></span></td>
            <td>
              <a href="index.php?toggle=<?= $c['id'] ?>&csrf=<?= urlencode($csrf) ?>"
                 class="adm-badge <?= $c['status'] ? 'adm-badge-green' : 'adm-badge-red' ?>"
                 style="cursor:pointer;text-decoration:none;"
                 title="Click to toggle">
                <?= $c['status'] ? 'Active' : 'Inactive' ?>
              </a>
            </td>
            <td>
              <div style="display:flex;gap:6px;">
                <a href="add.php?edit=<?= $c['id'] ?>" class="adm-btn adm-btn-sm adm-btn-outline"><i class="bi bi-pencil-fill"></i> Edit</a>
                <a href="index.php?delete=<?= $c['id'] ?>&csrf=<?= urlencode($csrf) ?>"
                   class="adm-btn adm-btn-sm adm-btn-danger"
                   data-confirm="Delete this course permanently?"
                   onclick="return confirm('Delete this course?')">
                   <i class="bi bi-trash-fill"></i>
                </a>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" style="text-align:center;padding:40px;color:var(--adm-muted);">
              <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:8px;"></i>
              No courses found. <a href="add.php" style="color:var(--adm-primary);">Add your first course</a>.
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>
