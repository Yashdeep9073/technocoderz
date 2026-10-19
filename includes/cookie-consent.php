<?php
// ============================================================
// Techno Coderz — Cookie & Privacy Consent popup
// Layout / design replicated "same to same" from techcaddmohali.com's
// cookie consent bottom-sheet (4 categories, trust row, toast),
// restyled to the Techno Coderz orange palette.
// Auto-opens ~1.2s after load; a "Cookie Settings" footer button
// reopens it. Plain CSS/JS so it loads on every page.
// ============================================================

$__cookieCategories = [
    [
        'key'         => 'necessary',
        'label'       => 'Strictly Necessary',
        'pill'        => 'Always Active',
        'pillClass'   => 'tcc-pill--req',
        'disabled'    => true,
        'description' => 'Essential for security, network management, session continuity, and verifying CSRF tokens. These cookies cannot be switched off.',
        'basis'       => 'Exempt from consent under DPDPA 2023 &amp; GDPR Section 5(2) as they are technically required for basic service delivery.',
        'cookies'     => ['techno_coderz_cookie_consent', 'session_token', 'csrf_token'],
        'retention'   => '1 Year / Session',
    ],
    [
        'key'         => 'analytics',
        'label'       => 'Performance &amp; Analytics',
        'pill'        => 'Optional',
        'pillClass'   => 'tcc-pill--off',
        'disabled'    => false,
        'description' => 'Help us measure site traffic, popular course tracks, bounce rates, and load performance so we can keep improving our learning resources.',
        'basis'       => 'Aggregated, anonymized metrics processed strictly in compliance with applicable privacy regulations.',
        'cookies'     => ['_ga', '_ga_*', '_gid'],
        'retention'   => '13 Months',
    ],
    [
        'key'         => 'functional',
        'label'       => 'Functional &amp; User Preferences',
        'pill'        => 'Optional',
        'pillClass'   => 'tcc-pill--off',
        'disabled'    => false,
        'description' => 'Remember your selected course categories, saved calculator formulas, contrast-mode preference, and in-progress form drafts.',
        'basis'       => 'Enhance your experience on our site without tracking you across third-party websites.',
        'cookies'     => ['pref_mode', 'last_track', 'calc_state'],
        'retention'   => '6 Months',
    ],
    [
        'key'         => 'marketing',
        'label'       => 'Marketing &amp; Attribution',
        'pill'        => 'Optional',
        'pillClass'   => 'tcc-pill--off',
        'disabled'    => false,
        'description' => 'Enable relevant course notifications and measure campaign performance across our educational partner platforms.',
        'basis'       => 'Activated only with your explicit prior consent. Techno Coderz never sells your personal data.',
        'cookies'     => ['_fbp', 'gcl_au', 'ad_track'],
        'retention'   => '90 Days',
    ],
];
?>
<link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/cookie-consent.css?v=<?= @filemtime(__DIR__ . '/../assets/css/cookie-consent.css') ?: '1' ?>">

<div id="tcCookieRoot">
  <!-- Saved toast -->
  <div class="tcc-toast" id="tccToast" role="status" aria-live="polite">
    <span class="tcc-toast__icon">&#10003;</span>
    <span>Cookie preferences saved and stored securely.</span>
  </div>

  <!-- Bottom-sheet dialog -->
  <div class="tcc-panel" id="tccPanel" role="dialog" aria-modal="true" aria-label="Cookie and Privacy Consent" aria-hidden="true">
    <div class="tcc-card">
      <div class="tcc-inner">
        <div class="tcc-head">
          <div class="tcc-head-left">
            <span class="tcc-emoji" aria-hidden="true">&#127850;</span>
            <div>
              <div class="tcc-title-row">
                <h3 class="tcc-title">We value your privacy &amp; transparency</h3>
                <span class="tcc-badge">DPDPA 2023 &amp; GDPR Compliant</span>
              </div>
              <p class="tcc-desc">
                Techno Coderz uses strictly verified cookies to keep the site secure, remember your
                preferences, and understand which courses help students the most. You are always in
                control &mdash; choose exactly what you allow.
              </p>
            </div>
          </div>
          <button type="button" class="tcc-close" data-tcc-act="close" aria-label="Close">
            <i class="bi bi-x-lg"></i>
          </button>
        </div>

        <div class="tcc-trust">
          <span><i class="bi bi-shield-check"></i> 1-Year Expiry Limit</span>
          <span><i class="bi bi-check2-circle"></i> Zero Third-Party Data Sale</span>
          <span><i class="bi bi-patch-check"></i> Audit Trail Token Generated</span>
          <a href="<?= SITE_URL ?>/contact.php">Full Cookie Policy &rarr;</a>
        </div>

        <div class="tcc-list" id="tccList">
          <?php foreach ($__cookieCategories as $__cat): ?>
          <div class="tcc-item">
            <div class="tcc-item-row">
              <div class="tcc-item-main">
                <div class="tcc-item-title">
                  <span class="tcc-item-label"><?= $__cat['label'] ?></span>
                  <span class="tcc-pill <?= $__cat['pillClass'] ?>"><?= $__cat['pill'] ?></span>
                </div>
                <p class="tcc-item-desc"><?= $__cat['description'] ?></p>
                <div class="tcc-meta">
                  <span><strong>Legal Basis:</strong> <?= $__cat['basis'] ?></span>
                  <span><strong>Cookies:</strong>
                    <?php foreach ($__cat['cookies'] as $__ck): ?><code><?= e($__ck) ?></code> <?php endforeach; ?>
                  </span>
                  <span><strong>Retention:</strong> <?= $__cat['retention'] ?></span>
                </div>
              </div>
              <button type="button" class="tcc-switch"
                      data-tcc-key="<?= $__cat['key'] ?>"
                      role="switch"
                      aria-checked="<?= $__cat['disabled'] ? 'true' : 'false' ?>"
                      aria-label="<?= strip_tags($__cat['label']) ?> cookies"
                      <?= $__cat['disabled'] ? 'disabled' : '' ?>>
                <span></span>
              </button>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <div class="tcc-footer">
          <div class="tcc-actions">
            <button type="button" class="tcc-btn tcc-btn--primary" data-tcc-act="accept-all">Accept All Cookies</button>
            <button type="button" class="tcc-btn tcc-btn--ghost" data-tcc-act="reject">Reject Non-Essential</button>
            <button type="button" class="tcc-btn tcc-btn--soft" data-tcc-act="save">Save Preferences</button>
          </div>
          <button type="button" class="tcc-manage" data-tcc-act="manage">Manage Preferences &rarr;</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?= SITE_URL ?>/assets/js/cookie-consent.js?v=<?= @filemtime(__DIR__ . '/../assets/js/cookie-consent.js') ?: '1' ?>" defer></script>
