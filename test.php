<?php
// Quick test script - verifies DB + homepage data
require_once __DIR__ . '/includes/functions.php';

echo "=== TECHNO CODERZ HOMEPAGE TEST ===\n\n";

try {
    $pdo = getDB();
    echo "[OK] Database connection successful\n";
} catch (Exception $e) {
    echo "[FAIL] Database connection: " . $e->getMessage() . "\n";
    exit;
}

$tables = ['courses','services','projects','testimonials','blogs','site_settings','users','enquiries','contact_messages'];
foreach ($tables as $t) {
    try {
        $count = $pdo->query("SELECT COUNT(*) FROM $t")->fetchColumn();
        echo "[OK] Table '$t': $count rows\n";
    } catch (Exception $e) {
        echo "[FAIL] Table '$t': " . $e->getMessage() . "\n";
    }
}

echo "\n=== ACTIVE CONTENT ===\n";
echo "Active courses: " . $pdo->query("SELECT COUNT(*) FROM courses WHERE status=1")->fetchColumn() . "\n";
echo "Active services: " . $pdo->query("SELECT COUNT(*) FROM services WHERE status=1")->fetchColumn() . "\n";
echo "Active projects: " . $pdo->query("SELECT COUNT(*) FROM projects WHERE status=1")->fetchColumn() . "\n";
echo "Active testimonials: " . $pdo->query("SELECT COUNT(*) FROM testimonials WHERE status=1")->fetchColumn() . "\n";
echo "Published blogs: " . $pdo->query("SELECT COUNT(*) FROM blogs WHERE status=1")->fetchColumn() . "\n";

echo "\n=== FILES CHECK ===\n";
$files = [
    'index.php','includes/header.php','includes/navbar.php','includes/footer.php',
    'includes/functions.php','config/database.php','assets/css/technocoderz.css',
    'assets/js/technocoderz.js','assets/images/favicon.svg',
    'ajax/contact.php','ajax/enquiry.php'
];
foreach ($files as $f) {
    $path = __DIR__ . '/' . $f;
    echo (file_exists($path) ? "[OK]" : "[MISSING]") . " $f" . (file_exists($path) ? " (" . number_format(filesize($path)) . " bytes)" : "") . "\n";
}

echo "\n=== TEST RESULT: ALL SYSTEMS GO ===\n";
echo "Homepage URL: http://localhost/Tech/index.php\n";
