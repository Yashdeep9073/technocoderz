<?php
// ============================================================
// Techno Coderz — Admin: Shared Header
// ============================================================
// Usage: include at the top of every admin page after auth check
// Requires: $adminPageTitle to be set
if (!isset($adminPageTitle)) $adminPageTitle = 'Dashboard';
if (!isset($adminActive))    $adminActive    = 'dashboard';
$adminName = $_SESSION['admin_name'] ?? 'Admin';

// Fetch counts for sidebar badges
try {
    $pdo = getDB();
    $newEnq   = $pdo->query("SELECT COUNT(*) FROM enquiries     WHERE status='new'")->fetchColumn();
    $newMsg   = $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_read=0")->fetchColumn();
} catch (Exception $e) { $newEnq = $newMsg = 0; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($adminPageTitle) ?> — Techno Coderz Admin</title>
  <meta name="robots" content="noindex,nofollow">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/admin.css">
</head>
<body>

<!-- ---- SIDEBAR ---- -->
<aside class="adm-sidebar" id="admSidebar">
  <div class="adm-brand">
    <i class="bi bi-cpu-fill me-2"></i>Techno <span>Coderz</span>
    <div style="font-size:0.65rem;font-weight:400;color:var(--adm-muted);margin-top:2px;">Admin Panel</div>
  </div>

  <nav class="adm-nav">
    <div class="adm-nav-section">Main</div>
    <a href="<?= ADMIN_URL ?>/dashboard.php"   class="adm-nav-link <?= $adminActive==='dashboard'?'active':'' ?>"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a>

    <div class="adm-nav-section">Content</div>
    <a href="<?= ADMIN_URL ?>/courses/index.php"      class="adm-nav-link <?= $adminActive==='courses'?'active':'' ?>"><i class="bi bi-book-fill"></i> Courses</a>
    <a href="<?= ADMIN_URL ?>/services/index.php"     class="adm-nav-link <?= $adminActive==='services'?'active':'' ?>"><i class="bi bi-gear-fill"></i> Services</a>
    <a href="<?= ADMIN_URL ?>/projects/index.php"     class="adm-nav-link <?= $adminActive==='projects'?'active':'' ?>"><i class="bi bi-folder2-open"></i> Projects</a>
    <a href="<?= ADMIN_URL ?>/blogs/index.php"        class="adm-nav-link <?= $adminActive==='blogs'?'active':'' ?>"><i class="bi bi-rss-fill"></i> Blogs</a>
    <a href="<?= ADMIN_URL ?>/testimonials/index.php" class="adm-nav-link <?= $adminActive==='testimonials'?'active':'' ?>"><i class="bi bi-chat-quote-fill"></i> Testimonials</a>

    <div class="adm-nav-section">CRM</div>
    <a href="<?= ADMIN_URL ?>/enquiries/index.php"  class="adm-nav-link <?= $adminActive==='enquiries'?'active':'' ?>">
      <i class="bi bi-send-fill"></i> Enquiries
      <?php if ($newEnq > 0): ?><span style="background:var(--adm-primary);color:#fff;font-size:0.65rem;font-weight:700;padding:2px 7px;border-radius:20px;margin-left:auto"><?= $newEnq ?></span><?php endif; ?>
    </a>
    <a href="<?= ADMIN_URL ?>/messages/index.php"   class="adm-nav-link <?= $adminActive==='messages'?'active':'' ?>">
      <i class="bi bi-envelope-fill"></i> Messages
      <?php if ($newMsg > 0): ?><span style="background:#ef4444;color:#fff;font-size:0.65rem;font-weight:700;padding:2px 7px;border-radius:20px;margin-left:auto"><?= $newMsg ?></span><?php endif; ?>
    </a>

    <div class="adm-nav-section">Settings</div>
    <a href="<?= ADMIN_URL ?>/settings.php"        class="adm-nav-link <?= $adminActive==='settings'?'active':'' ?>"><i class="bi bi-sliders"></i> Site Settings</a>
    <a href="<?= SITE_URL ?>"                      class="adm-nav-link" target="_blank"><i class="bi bi-box-arrow-up-right"></i> View Site</a>
    <a href="<?= ADMIN_URL ?>/logout.php"          class="adm-nav-link" style="color:#ef4444;"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </nav>
</aside>

<!-- ---- MAIN ---- -->
<main class="adm-main">

  <!-- Topbar -->
  <div class="adm-topbar">
    <div style="display:flex;align-items:center;gap:16px;">
      <button onclick="document.getElementById('admSidebar').classList.toggle('open')" style="background:none;border:none;color:var(--adm-text);font-size:1.3rem;cursor:pointer;display:none;" class="d-lg-none" aria-label="Menu">
        <i class="bi bi-list"></i>
      </button>
      <h1 class="adm-page-title"><?= e($adminPageTitle) ?></h1>
    </div>
    <div style="display:flex;align-items:center;gap:16px;">
      <a href="<?= ADMIN_URL ?>/enquiries/index.php" style="position:relative;color:var(--adm-muted);font-size:1.2rem;" title="Enquiries">
        <i class="bi bi-bell-fill"></i>
        <?php if ($newEnq > 0): ?><span style="position:absolute;top:-4px;right:-4px;width:16px;height:16px;background:#ef4444;color:#fff;font-size:0.55rem;font-weight:700;border-radius:50%;display:flex;align-items:center;justify-content:center;"><?= $newEnq ?></span><?php endif; ?>
      </a>
      <div style="display:flex;align-items:center;gap:10px;padding:6px 14px;background:rgba(108,63,245,0.1);border:1px solid rgba(108,63,245,0.2);border-radius:10px;font-size:0.83rem;">
        <i class="bi bi-person-circle" style="font-size:1.1rem;color:var(--adm-muted)"></i>
        <span style="color:#fff;font-weight:600;"><?= e($adminName) ?></span>
      </div>
    </div>
  </div>

  <!-- Page Content Area -->
  <div class="adm-content">
