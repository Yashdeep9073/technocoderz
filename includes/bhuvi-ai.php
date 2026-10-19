<?php
// ============================================================
// Bhuvi AI — floating assistant widget (site-wide)
// Layout / design mirrored from techcaddmohali.com "Bhuvi AI",
// re-themed to the Techno Coderz orange palette.
// Included from includes/footer.php so it appears on every page.
// ============================================================
if (!function_exists('getDB')) {
    require_once __DIR__ . '/functions.php';
}

$bhuiSettings = [];
$bhuiCats     = [];
$bhuiTop      = [];
$bhuiCount    = 0;

try {
    // Reuse the footer's already-open connection when available.
    if (!isset($pdo) || !($pdo instanceof PDO)) {
        $pdo = getDB();
    }

    foreach ($pdo->query("SELECT setting_key, setting_value FROM site_settings") as $row) {
        if (trim($row['setting_value'] ?? '') !== '') {
            $bhuiSettings[$row['setting_key']] = $row['setting_value'];
        }
    }

    $bhuiCats = $pdo->query("SELECT category AS name, COUNT(*) AS count FROM courses WHERE status = 1 AND category <> '' GROUP BY category ORDER BY count DESC")->fetchAll();
    $bhuiCount = (int) $pdo->query("SELECT COUNT(*) FROM courses WHERE status = 1")->fetchColumn();
    $bhuiTop = $pdo->query("SELECT title, slug FROM courses WHERE status = 1 ORDER BY sort_order ASC, id ASC LIMIT 4")->fetchAll();
} catch (Throwable $e) {
    error_log('Bhuvi AI data: ' . $e->getMessage());
}

$bhuiPhone    = $bhuiSettings['phone']   ?? '+91 98765 43210';
$bhuiPhone2   = $bhuiSettings['phone2']  ?? '';
$bhuiEmail    = $bhuiSettings['email']   ?? 'info@technocoderz.com';
$bhuiAddress  = $bhuiSettings['address'] ?? 'Mohali, Punjab, India';
$bhuiPhoneRaw = preg_replace('/\D/', '', $bhuiPhone);

$bhuiTopCourses = [];
foreach ($bhuiTop as $c) {
    $url = function_exists('coursePageUrl') ? coursePageUrl($c['slug']) : (SITE_URL . '/courses.php');
    $bhuiTopCourses[] = ['title' => $c['title'], 'url' => $url];
}

$bhuiConfig = [
    'site'        => $bhuiSettings['site_name'] ?? 'Techno Coderz',
    'phone'       => $bhuiPhone,
    'phoneRaw'    => $bhuiPhoneRaw,
    'phone2'      => $bhuiPhone2,
    'email'       => $bhuiEmail,
    'address'     => $bhuiAddress,
    'courseCount' => $bhuiCount,
    'categories'  => array_map(function ($c) {
        return ['name' => $c['name'], 'count' => (int) $c['count']];
    }, $bhuiCats),
    'topCourses'  => $bhuiTopCourses,
    'urls'        => [
        'courses'   => SITE_URL . '/courses.php',
        'contact'   => SITE_URL . '/contact.php',
        'career'    => SITE_URL . '/career.php',
        'placement' => SITE_URL . '/career.php',
        'projects'  => SITE_URL . '/projects.php',
        'verify'    => SITE_URL . '/certificate-verification.php',
    ],
];

$bhuiChips = ['Best course', 'Start freelancing', 'After 12th', 'AI careers', 'Fees & duration', 'Placements', 'Career switch', 'Admissions'];
$bhuiRobot = '<path d="M12 2.5v3"/><rect x="4" y="6" width="16" height="13" rx="4"/><path d="M4 12H2.2M22 12h-1.8"/><circle cx="9" cy="11.5" r="1.15" fill="currentColor" stroke="none"/><circle cx="15" cy="11.5" r="1.15" fill="currentColor" stroke="none"/><path d="M9.5 15.2h5"/>';
?>
<link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/bhuvi-ai.css?v=<?= @filemtime(__DIR__ . '/../assets/css/bhuvi-ai.css') ?: '1' ?>">

<div id="bhuviRoot">
  <!-- Chat panel -->
  <div id="bhuviPanel" class="bhui-panel" role="dialog" aria-label="Bhuvi AI chat assistant">
    <div class="bhui-glow"></div>

    <div class="bhui-header">
      <div class="bhui-logo" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><?= $bhuiRobot ?></svg>
      </div>
      <div class="bhui-who">
        <p class="bhui-name">Bhuvi AI</p>
        <div class="bhui-status"><span class="bhui-dot" aria-hidden="true"></span><p>Online now</p></div>
      </div>
      <button type="button" class="bhui-close" aria-label="Close chat">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m6 6 12 12M18 6 6 18"/></svg>
      </button>
    </div>

    <div class="bhui-divider"></div>

    <div class="bhui-body" id="bhuviBody">
      <div class="bhui-chips" id="bhuviChips">
        <?php foreach ($bhuiChips as $chip): ?>
        <button type="button" class="bhui-chip" data-q="<?= e($chip) ?>"><?= e($chip) ?></button>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="bhui-foot">
      <div class="bhui-inputwrap">
        <textarea id="bhuviInput" class="bhui-input" placeholder="Ask me anything..." rows="1"></textarea>
        <button type="button" id="bhuviSend" class="bhui-send" aria-label="Send message" disabled>
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3.478 2.405a.75.75 0 0 0-.926.94l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.405Z"/></svg>
        </button>
      </div>
      <p class="bhui-cap">Bhuvi AI &middot; Powered by <?= e($bhuiSettings['site_name'] ?? 'Techno Coderz') ?></p>
    </div>
  </div>

  <!-- Launcher -->
  <button type="button" id="bhuviLauncher" class="bhui-launcher" aria-label="Open Bhuvi AI" aria-expanded="false">
    <span class="bhui-ring bhui-ring--ping" aria-hidden="true"></span>
    <span class="bhui-ring bhui-ring--pulse" aria-hidden="true"></span>
    <svg class="bhui-launcher__ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?= $bhuiRobot ?></svg>
    <span class="bhui-launcher__txt">Ask Bhuvi</span>
  </button>
</div>

<script>window.BHUVI_CONFIG = <?= json_encode($bhuiConfig, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;</script>
<script src="<?= SITE_URL ?>/assets/js/bhuvi-ai.js?v=<?= @filemtime(__DIR__ . '/../assets/js/bhuvi-ai.js') ?: '1' ?>" defer></script>
