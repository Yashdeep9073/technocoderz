<?php
// ============================================================
// Techno Coderz — Admin: Site Settings
// ============================================================
require_once __DIR__ . '/../includes/functions.php';
requireAdminLogin();

$pdo   = getDB();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $error = 'Security token expired. Please refresh.';
    } else {
        $saved = 0;
        $values = $_POST['settings'] ?? [];

        foreach ((array) $values as $key => $value) {
            $key = trim((string) $key);
            if (!preg_match('/^[a-z0-9_]{2,60}$/', $key)) {
                continue;
            }
            $pdo->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = ?")
                ->execute([trim((string) $value), $key]);
            $saved++;
        }

        // Optional: add a brand-new setting
        $newKey   = strtolower(trim($_POST['new_key'] ?? ''));
        $newValue = trim($_POST['new_value'] ?? '');
        if ($newKey !== '') {
            if (!preg_match('/^[a-z0-9_]{2,60}$/', $newKey)) {
                $error = 'New key may only contain lowercase letters, numbers and underscores.';
            } elseif ($newValue === '') {
                $error = 'New setting needs a value.';
            } else {
                $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?)")
                    ->execute([$newKey, $newValue]);
                $saved++;
            }
        }

        if (!$error && $saved > 0) {
            setFlash('success', "Settings updated ($saved saved).");
            header('Location: settings.php');
            exit;
        }
        if (!$error && $saved === 0) {
            $error = 'No settings to save.';
        }
    }
}

$rows = $pdo->query("SELECT setting_key, setting_value FROM site_settings ORDER BY setting_key ASC")->fetchAll();

$labels = [
    'site_name' => ['Site Name', 'Shown in the navbar brand, browser title and footer.'],
    'tagline'   => ['Tagline', 'Short line used on the homepage hero and contact page.'],
    'email'     => ['Contact Email', 'Shown in the footer, contact page and enquiry notifications.'],
    'phone'     => ['Phone Number', 'Shown in the navbar, footer and contact page.'],
    'address'   => ['Office Address', 'Shown in the footer and contact page.'],
    'facebook'  => ['Facebook URL', 'Footer social link.'],
    'instagram' => ['Instagram URL', 'Footer social link.'],
    'linkedin'  => ['LinkedIn URL', 'Footer social link.'],
    'youtube'   => ['YouTube URL', 'Footer social link.'],
    'twitter'   => ['X (Twitter) URL', 'Footer social link.'],
];

$adminPageTitle = 'Site Settings';
$adminActive    = 'settings';
require_once __DIR__ . '/includes/admin_header.php';
?>
<div style="max-width:820px;">
  <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px;">
    <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.1rem;font-weight:700;color:#fff;margin:0;">
      <i class="bi bi-sliders me-2" style="color:var(--adm-primary);"></i>Site Settings
    </h2>
  </div>

  <?php $flash = getFlash(); if ($flash): ?>
    <div class="adm-alert adm-alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?>" data-auto-dismiss="4000">
      <i class="bi bi-<?= $flash['type'] === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill' ?>"></i>
      <?= e($flash['message']) ?>
    </div>
  <?php endif; ?>

  <?php if ($error): ?>
    <div class="adm-alert adm-alert-danger"><i class="bi bi-exclamation-triangle-fill"></i><?= e($error) ?></div>
  <?php endif; ?>

  <div class="adm-card">
    <div class="adm-card-body">
      <p style="font-size:0.83rem;color:var(--adm-muted);margin-bottom:20px;">
        These values are the live source of truth for the public site — the navbar, footer and contact page read them on every load.
      </p>

      <form method="POST">
        <?= csrfField() ?>

        <div class="row g-3">
          <?php foreach ($rows as $row): $k = $row['setting_key']; ?>
            <?php $meta = $labels[$k] ?? [ucwords(str_replace('_', ' ', $k)), 'Custom setting used by the site.']; ?>
            <div class="col-12">
              <div class="adm-form-group">
                <label class="adm-label"><?= e($meta[0]) ?> <span style="color:var(--adm-muted);font-weight:400;">— <?= e($meta[1]) ?></span></label>
                <?php if (in_array($k, ['address', 'tagline'], true)): ?>
                  <textarea name="settings[<?= e($k) ?>]" class="adm-input" rows="2"><?= e($row['setting_value']) ?></textarea>
                <?php elseif (filter_var($row['setting_value'], FILTER_VALIDATE_URL)): ?>
                  <input type="url" name="settings[<?= e($k) ?>]" class="adm-input" value="<?= e($row['setting_value']) ?>" placeholder="https://">
                <?php else: ?>
                  <input type="text" name="settings[<?= e($k) ?>]" class="adm-input" value="<?= e($row['setting_value']) ?>">
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <hr style="border-color:var(--adm-border);margin:8px 0 20px;">

        <div class="row g-3">
          <div class="col-md-5">
            <div class="adm-form-group">
              <label class="adm-label">New Setting Key</label>
              <input type="text" name="new_key" class="adm-input" placeholder="e.g. whatsapp" pattern="[a-z0-9_]{2,60}">
            </div>
          </div>
          <div class="col-md-7">
            <div class="adm-form-group">
              <label class="adm-label">New Setting Value</label>
              <input type="text" name="new_value" class="adm-input" placeholder="Value">
            </div>
          </div>
        </div>

        <div style="display:flex;gap:12px;margin-top:8px;">
          <button type="submit" class="adm-btn adm-btn-primary"><i class="bi bi-check-circle-fill"></i> Save Settings</button>
          <a href="dashboard.php" class="adm-btn adm-btn-outline">Cancel</a>
        </div>
      </form>

    </div>
  </div>
</div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
