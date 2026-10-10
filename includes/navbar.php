
<?php

// ============================================================
// Techno Coderz — Navbar Include
// ============================================================
// Contact details come from site_settings (source of truth)

$navPhone = '+91 98765 43210';
$navEmail = 'info@technocoderz.com';

try {

    $navPdo = getDB();

    $stmtP = $navPdo->prepare(
        "SELECT setting_value FROM site_settings WHERE setting_key = 'phone'"
    );
    $stmtP->execute();

    if ($p = $stmtP->fetchColumn()) {
        $navPhone = $p;
    }

    $stmtE = $navPdo->prepare(
        "SELECT setting_value FROM site_settings WHERE setting_key = 'email'"
    );
    $stmtE->execute();

    if ($e = $stmtE->fetchColumn()) {
        $navEmail = $e;
    }

} catch (Exception $ex) {
    // Keep default contact details
}

$navLinks = [

    // Kept identical on every page (matches the homepage navigation)
    ['href' => SITE_URL . '/index.php',   'label' => 'Home',      'key' => 'home'],
    ['href' => SITE_URL . '/about.php',   'label' => 'About',     'key' => 'about'],
    ['href' => SITE_URL . '/courses.php', 'label' => 'Courses',   'key' => 'courses'],
    ['href' => SITE_URL . '/blog.php',    'label' => 'Our Blogs', 'key' => 'blog'],
    ['href' => SITE_URL . '/brochure.php', 'label' => 'Brochure',  'key' => 'brochure'],
    ['href' => SITE_URL . '/contact.php', 'label' => 'Contact Us','key' => 'contact'],

];

?>

<!-- Top Bar -->
<div class="ref-topbar">

    <div class="container d-flex justify-content-between align-items-center">

        <div class="ref-topbar-left d-flex align-items-center gap-4">

            <a href="mailto:<?= e($navEmail) ?>">
                <i class="bi bi-envelope"></i>
                <?= e($navEmail) ?>
            </a>

            <a href="tel:<?= e(preg_replace('/\s+/', '', $navPhone)) ?>">
                <i class="bi bi-telephone"></i>
                <?= e($navPhone) ?>
            </a>

        </div>

        <div class="ref-topbar-right d-flex align-items-center gap-3">

            <a href="https://facebook.com/technocoderz" target="_blank" rel="noopener noreferrer" aria-label="Facebook" class="tc-topbar-social">
                <i class="bi bi-facebook"></i>
            </a>

            <a href="https://instagram.com/technocoderz" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="tc-topbar-social">
                <i class="bi bi-instagram"></i>
            </a>

            <a href="https://linkedin.com/company/technocoderz" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn" class="tc-topbar-social">
                <i class="bi bi-linkedin"></i>
            </a>

            <a href="https://youtube.com/@technocoderz" target="_blank" rel="noopener noreferrer" aria-label="YouTube" class="tc-topbar-social">
                <i class="bi bi-youtube"></i>
            </a>

            <a href="https://twitter.com/technocoderz" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)" class="tc-topbar-social">
                <i class="bi bi-twitter-x"></i>
            </a>

        </div>

    </div>

</div>

<!-- Main Navbar -->
<nav class="navbar navbar-expand-lg ref-navbar" id="tcNavbar">

    <div class="container align-items-center">

        <!-- Brand -->
        <a class="navbar-brand ref-navbar-brand" href="<?= SITE_URL ?>/index.php">
            <img src="<?= SITE_URL ?>/assets/images/image.png" alt="Techno Coderz">
        </a>

        <!-- Mobile toggle -->
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#tcNavMenu"
            aria-controls="tcNavMenu"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Nav Menu -->
        <div class="collapse navbar-collapse" id="tcNavMenu">

            <ul class="navbar-nav mx-auto gap-3">

                <?php foreach ($navLinks as $link): ?>

                    <li class="nav-item">

                        <a
                            class="nav-link <?= ($currentPage === $link['key']) ? 'active' : '' ?>"
                            href="<?= $link['href'] ?>"
                        >
                            <?= $link['label'] ?>
                        </a>

                    </li>

                <?php endforeach; ?>

            </ul>

            <!-- CTA -->
            <div class="ms-lg-3">

                <a
                    href="<?= SITE_URL ?>/index.php#enquire-form"
                    class="ref-nav-cta"
                >
                    Register Now
                </a>

            </div>

        </div>

    </div>

</nav>

