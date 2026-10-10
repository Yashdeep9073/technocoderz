<?php
// ============================================================
// Techno Coderz — Admin Dashboard
// ============================================================
require_once __DIR__ . '/../includes/functions.php';
requireAdminLogin();

$adminPageTitle = 'Dashboard';
$adminActive    = 'dashboard';

$pdo = getDB();

// Stats
$totalCourses      = $pdo->query("SELECT COUNT(*) FROM courses")->fetchColumn();
$totalServices     = $pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();
$totalProjects     = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
$totalBlogs        = $pdo->query("SELECT COUNT(*) FROM blogs")->fetchColumn();
$totalEnquiries    = $pdo->query("SELECT COUNT(*) FROM enquiries")->fetchColumn();
$newEnquiries      = $pdo->query("SELECT COUNT(*) FROM enquiries WHERE status='new'")->fetchColumn();
$totalMessages     = $pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();
$unreadMessages    = $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_read=0")->fetchColumn();
$totalTestimonials = $pdo->query("SELECT COUNT(*) FROM testimonials")->fetchColumn();

// Recent Enquiries
$recentEnquiries = $pdo->query("SELECT * FROM enquiries ORDER BY created_at DESC LIMIT 5")->fetchAll();
// Recent Messages
$recentMessages  = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5")->fetchAll();

require_once __DIR__ . '/includes/admin_header.php';
?>

<?php
$flash = getFlash();
if ($flash):
?>
<div class="adm-alert adm-alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?>" data-auto-dismiss="4000">
  <i class="bi bi-<?= $flash['type'] === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill' ?>"></i>
  <?= e($flash['message']) ?>
</div>
<?php endif; ?>

<!-- Welcome -->
<div style="margin-bottom:28px;">
  <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.4rem;font-weight:800;color:#fff;margin:0 0 6px;">
    Welcome back, <?= e($_SESSION['admin_name'] ?? 'Admin') ?>! 👋
  </h2>
  <p style="color:var(--adm-muted);font-size:0.87rem;margin:0;">
    Here's your Techno Coderz website overview for today — <?= date('l, d F Y') ?>
  </p>
</div>

<!-- Stat Cards -->
<div class="row g-4 mb-5">
  <?php
  $stats = [
    ['label'=>'Total Courses',    'value'=>$totalCourses,      'icon'=>'bi-book-fill',         'color'=>'rgba(108,63,245,0.2)',  'icolor'=>'#8b6af8', 'link'=>ADMIN_URL.'/courses/index.php'],
    ['label'=>'Services',         'value'=>$totalServices,     'icon'=>'bi-gear-fill',          'color'=>'rgba(0,212,170,0.2)',   'icolor'=>'#00d4aa', 'link'=>ADMIN_URL.'/services/index.php'],
    ['label'=>'Projects',         'value'=>$totalProjects,     'icon'=>'bi-folder2-open',       'color'=>'rgba(255,107,53,0.2)', 'icolor'=>'#ff6b35', 'link'=>ADMIN_URL.'/projects/index.php'],
    ['label'=>'Blog Posts',       'value'=>$totalBlogs,        'icon'=>'bi-rss-fill',           'color'=>'rgba(96,165,250,0.2)', 'icolor'=>'#60a5fa', 'link'=>ADMIN_URL.'/blogs/index.php'],
    ['label'=>'Total Enquiries',  'value'=>$totalEnquiries,    'icon'=>'bi-send-fill',          'color'=>'rgba(245,158,11,0.2)', 'icolor'=>'#f59e0b', 'link'=>ADMIN_URL.'/enquiries/index.php'],
    ['label'=>'New Enquiries',    'value'=>$newEnquiries,      'icon'=>'bi-bell-fill',          'color'=>'rgba(239,68,68,0.2)',  'icolor'=>'#ef4444', 'link'=>ADMIN_URL.'/enquiries/index.php'],
    ['label'=>'Messages',         'value'=>$totalMessages,     'icon'=>'bi-envelope-fill',      'color'=>'rgba(34,197,94,0.2)',  'icolor'=>'#22c55e', 'link'=>ADMIN_URL.'/messages/index.php'],
    ['label'=>'Testimonials',     'value'=>$totalTestimonials, 'icon'=>'bi-chat-quote-fill',    'color'=>'rgba(168,85,247,0.2)','icolor'=>'#a855f7', 'link'=>ADMIN_URL.'/testimonials/index.php'],
  ];
  foreach ($stats as $s):
  ?>
  <div class="col-lg-3 col-md-6">
    <a href="<?= $s['link'] ?>" style="text-decoration:none;">
      <div class="adm-stat-card" style="transition:all 0.2s ease;" onmouseover="this.style.borderColor='rgba(108,63,245,0.4)'" onmouseout="this.style.borderColor='rgba(108,63,245,0.2)'">
        <div class="adm-stat-icon" style="background:<?= $s['color'] ?>">
          <i class="bi <?= $s['icon'] ?>" style="color:<?= $s['icolor'] ?>"></i>
        </div>
        <div>
          <div class="adm-stat-num"><?= $s['value'] ?></div>
          <div class="adm-stat-label"><?= $s['label'] ?></div>
        </div>
      </div>
    </a>
  </div>
  <?php endforeach; ?>
</div>

<!-- Tables Row -->
<div class="row g-4">

  <!-- Recent Enquiries -->
  <div class="col-lg-7">
    <div class="adm-card">
      <div class="adm-card-header">
        <h3 class="adm-card-title"><i class="bi bi-send-fill me-2" style="color:#f59e0b"></i>Recent Enquiries</h3>
        <a href="<?= ADMIN_URL ?>/enquiries/index.php" class="adm-btn adm-btn-sm adm-btn-outline">View All</a>
      </div>
      <div style="overflow-x:auto;">
        <table class="adm-table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Course</th>
              <th>Date</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($recentEnquiries): ?>
              <?php foreach ($recentEnquiries as $enq): ?>
              <tr>
                <td>
                  <div style="font-weight:600;color:#fff;"><?= e($enq['name']) ?></div>
                  <div style="font-size:0.75rem;color:var(--adm-muted);"><?= e($enq['email']) ?></div>
                </td>
                <td><?= e(substr($enq['course'] ?? 'N/A', 0, 30)) ?></td>
                <td style="font-size:0.78rem;color:var(--adm-muted);"><?= date('d M', strtotime($enq['created_at'])) ?></td>
                <td>
                  <?php
                  $sc = ['new'=>'adm-badge-yel','in_progress'=>'adm-badge-blue','resolved'=>'adm-badge-green'];
                  $sl = ['new'=>'New','in_progress'=>'In Progress','resolved'=>'Resolved'];
                  $st = $enq['status'] ?? 'new';
                  ?>
                  <span class="adm-badge <?= $sc[$st] ?? 'adm-badge-yel' ?>"><?= $sl[$st] ?? 'New' ?></span>
                </td>
                <td>
                  <a href="<?= ADMIN_URL ?>/enquiries/view.php?id=<?= $enq['id'] ?>" class="adm-btn adm-btn-sm adm-btn-outline">
                    <i class="bi bi-eye"></i> View
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="5" style="text-align:center;color:var(--adm-muted);padding:32px;">No enquiries yet.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Recent Messages -->
  <div class="col-lg-5">
    <div class="adm-card">
      <div class="adm-card-header">
        <h3 class="adm-card-title"><i class="bi bi-envelope-fill me-2" style="color:#22c55e"></i>Recent Messages</h3>
        <a href="<?= ADMIN_URL ?>/messages/index.php" class="adm-btn adm-btn-sm adm-btn-outline">View All</a>
      </div>
      <div style="overflow-x:auto;">
        <table class="adm-table">
          <thead>
            <tr><th>From</th><th>Subject</th><th>Date</th></tr>
          </thead>
          <tbody>
            <?php if ($recentMessages): ?>
              <?php foreach ($recentMessages as $msg): ?>
              <tr>
                <td>
                  <div style="font-weight:600;color:#fff;display:flex;align-items:center;gap:6px;">
                    <?php if (!$msg['is_read']): ?>
                    <span style="width:7px;height:7px;background:#ef4444;border-radius:50%;flex-shrink:0;"></span>
                    <?php endif; ?>
                    <?= e($msg['name']) ?>
                  </div>
                  <div style="font-size:0.72rem;color:var(--adm-muted);"><?= e($msg['email']) ?></div>
                </td>
                <td style="font-size:0.82rem;"><?= e(substr($msg['subject'] ?? 'No Subject', 0, 25)) ?>...</td>
                <td style="font-size:0.75rem;color:var(--adm-muted);"><?= date('d M', strtotime($msg['created_at'])) ?></td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="3" style="text-align:center;color:var(--adm-muted);padding:32px;">No messages yet.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div><!-- /row -->

<!-- Quick Actions -->
<div class="adm-card mt-4">
  <div class="adm-card-header">
    <h3 class="adm-card-title"><i class="bi bi-lightning-charge-fill me-2" style="color:var(--adm-primary)"></i>Quick Actions</h3>
  </div>
  <div class="adm-card-body">
    <div style="display:flex;flex-wrap:wrap;gap:12px;">
      <a href="<?= ADMIN_URL ?>/courses/add.php"      class="adm-btn adm-btn-primary"><i class="bi bi-plus-circle-fill"></i> Add Course</a>
      <a href="<?= ADMIN_URL ?>/blogs/add.php"        class="adm-btn adm-btn-primary"><i class="bi bi-plus-circle-fill"></i> New Blog Post</a>
      <a href="<?= ADMIN_URL ?>/projects/add.php"     class="adm-btn adm-btn-primary"><i class="bi bi-plus-circle-fill"></i> Add Project</a>
      <a href="<?= ADMIN_URL ?>/services/add.php"     class="adm-btn adm-btn-primary"><i class="bi bi-plus-circle-fill"></i> Add Service</a>
      <a href="<?= ADMIN_URL ?>/testimonials/add.php" class="adm-btn adm-btn-primary"><i class="bi bi-plus-circle-fill"></i> Add Testimonial</a>
      <a href="<?= ADMIN_URL ?>/enquiries/index.php"  class="adm-btn adm-btn-outline"><i class="bi bi-inbox-fill"></i> View Enquiries</a>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
