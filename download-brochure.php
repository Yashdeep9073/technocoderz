<?php
// ============================================================
// Techno Coderz — Brochure PDF delivery (released after lead capture)
// ============================================================
require_once __DIR__ . '/includes/functions.php';

if (empty($_SESSION['brochure_access'])) {
    header('Location: ' . SITE_URL . '/brochure.php?status=locked');
    exit;
}

$file = __DIR__ . '/assets/downloads/technocoderz-brochure.pdf';

if (!file_exists($file)) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Brochure is temporarily unavailable. Please contact info@technocoderz.com';
    exit;
}

$size   = filesize($file);
$name   = 'TechnoCoderz-Curriculum-Brochure.pdf';

// Clear any output buffer so the PDF streams cleanly
while (ob_get_level() > 0) ob_end_clean();

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $name . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . $size);
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: no-referrer-when-downgrade');

readfile($file);

// Record that the learner actually received the file
try {
    if (!empty($_SESSION['brochure_lead']['email'])) {
        $_SESSION['brochure_lead']['downloaded_at'] = time();
    }
} catch (Throwable $e) {
    // non-critical
}

exit;
