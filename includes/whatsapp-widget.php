<?php
// ============================================================
// Floating social stack + WhatsApp button (site-wide)
// Mirrors techcaddmohali.com bottom-right floating widget:
//   expandable social links  +  persistent WhatsApp button.
// Techno Coderz orange toggle, standard WhatsApp green.
// Included from includes/footer.php.
// ============================================================
if (!isset($footerSettings) || !is_array($footerSettings)) {
    $footerSettings = [];
    try {
        if (!function_exists('getDB')) {
            require_once __DIR__ . '/functions.php';
        }
        if (!isset($pdo) || !($pdo instanceof PDO)) {
            $pdo = getDB();
        }
        foreach ($pdo->query("SELECT setting_key, setting_value FROM site_settings") as $row) {
            if (trim($row['setting_value'] ?? '') !== '') {
                $footerSettings[$row['setting_key']] = $row['setting_value'];
            }
        }
    } catch (Throwable $e) {
        error_log('WhatsApp widget data: ' . $e->getMessage());
    }
}

$waPhone = $phone ?? ($footerSettings['phone'] ?? '+91 98765 43210');
$waNum   = preg_replace('/\D/', '', $waPhone);
$waSite  = $footerSettings['site_name'] ?? 'Techno Coderz';
$waMsg   = rawurlencode('Hi ' . $waSite . ', I would like to know more about your courses and admissions.');
$waLink  = 'https://wa.me/' . $waNum . '?text=' . $waMsg;

$waSocials = [
    ['key' => 'instagram', 'mod' => 'ig', 'label' => 'Instagram', 'url' => $ig ?? ($footerSettings['instagram'] ?? '#'),
     'path' => '<path fill-rule="evenodd" d="M7.5 2h9A5.5 5.5 0 0 1 22 7.5v9a5.5 5.5 0 0 1-5.5 5.5h-9A5.5 5.5 0 0 1 2 16.5v-9A5.5 5.5 0 0 1 7.5 2Zm9 2h-9A3.5 3.5 0 0 0 4 7.5v9A3.5 3.5 0 0 0 7.5 20h9a3.5 3.5 0 0 0 3.5-3.5v-9A3.5 3.5 0 0 0 16.5 4ZM12 7.75a4.25 4.25 0 1 1 0 8.5 4.25 4.25 0 0 1 0-8.5Zm0 2a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5ZM17.5 6.5a1 1 0 1 1 0 2 1 1 0 0 1 0-2Z"/>'],
    ['key' => 'facebook', 'mod' => 'fb', 'label' => 'Facebook', 'url' => $fb ?? ($footerSettings['facebook'] ?? '#'),
     'path' => '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3V2Z"/>'],
    ['key' => 'linkedin', 'mod' => 'li', 'label' => 'LinkedIn', 'url' => $li ?? ($footerSettings['linkedin'] ?? '#'),
     'path' => '<path fill-rule="evenodd" d="M6.5 2h11A4.5 4.5 0 0 1 22 6.5v11a4.5 4.5 0 0 1-4.5 4.5h-11A4.5 4.5 0 0 1 2 17.5v-11A4.5 4.5 0 0 1 6.5 2ZM4 6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v11a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 17.5v-11ZM8.2 7a1.2 1.2 0 1 1 0 2.4 1.2 1.2 0 0 1 0-2.4ZM7.2 10.8h2v6.4h-2v-6.4Zm4-0h1.9v.9a3.1 3.1 0 0 1 2.6-1.1c2 0 2.5 1.3 2.5 3v3.6h-2v-3.2c0-.9 0-2-1.3-2s-1.5 1-1.5 2v3.2h-2v-6.4Z"/>'],
    ['key' => 'youtube', 'mod' => 'yt', 'label' => 'YouTube', 'url' => $yt ?? ($footerSettings['youtube'] ?? '#'),
     'path' => '<path d="M23 12s0-3.2-.4-4.7a2.5 2.5 0 0 0-1.8-1.8C19.2 5 12 5 12 5s-7.2 0-8.8.5A2.5 2.5 0 0 0 1.4 7.3C1 8.8 1 12 1 12s0 3.2.4 4.7a2.5 2.5 0 0 0 1.8 1.8C4.8 19 12 19 12 19s7.2 0 8.8-.5a2.5 2.5 0 0 0 1.8-1.8C23 15.2 23 12 23 12ZM10 15V9l5 3-5 3Z"/>'],
];
?>
<link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/whatsapp-widget.css?v=<?= @filemtime(__DIR__ . '/../assets/css/whatsapp-widget.css') ?: '1' ?>">

<div id="tcSocialStack">
  <div class="tcs-socials">
    <?php foreach ($waSocials as $s): ?>
    <a href="<?= e($s['url']) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= e($s['label']) ?>" class="tcs-social tcs-social--<?= e($s['mod']) ?>">
      <svg viewBox="0 0 24 24" aria-hidden="true"><?= $s['path'] ?></svg>
    </a>
    <?php endforeach; ?>
  </div>

  <button type="button" id="tcSocialToggle" class="tcs-toggle" aria-label="Open social links" aria-expanded="false">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
  </button>

  <a href="<?= e($waLink) ?>" target="_blank" rel="noopener noreferrer" class="tcs-wa" aria-label="Chat with <?= e($waSite) ?> on WhatsApp">
    <span class="tcs-wa__ping" aria-hidden="true"></span>
    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3a9 9 0 0 0-7.7 13.6L3 21l4.5-1.2A9 9 0 1 0 12 3Zm4.6 12.4c-.2.6-1.2 1.1-1.7 1.1-.4 0-1 .1-3-.8a10.6 10.6 0 0 1-4.3-4c-.3-.5-.8-1.4-.8-2.3s.5-1.4.7-1.6a.8.8 0 0 1 .6-.3h.4c.2 0 .4 0 .5.4l.7 1.7c.1.2 0 .4-.1.5l-.3.4c-.1.2-.3.3-.1.6a8 8 0 0 0 3.4 2.9c.3.1.4.1.6-.1l.7-.9c.2-.2.3-.2.5-.1l1.6.8c.2.1.4.2.4.3v.9Z"/></svg>
  </a>
</div>

<script src="<?= SITE_URL ?>/assets/js/whatsapp-widget.js?v=<?= @filemtime(__DIR__ . '/../assets/js/whatsapp-widget.js') ?: '1' ?>" defer></script>
