<?php
// ============================================================
// Techno Coderz — AJAX: Course Enquiry Handler
// ============================================================
header('Content-Type: application/json');
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// CSRF
$token = $_POST['csrf_token'] ?? '';
if (!verifyCsrfToken($token)) {
    echo json_encode(['success' => false, 'message' => 'Security token expired. Please refresh the page.']);
    exit;
}

// Sanitize
$name    = sanitize($_POST['name']    ?? '');
$email   = sanitize($_POST['email']   ?? '');
$phone   = sanitize($_POST['phone']   ?? '');
$course  = sanitize($_POST['course']  ?? '');
$message = sanitize($_POST['message'] ?? '');

// Validate
$errors = [];
if (empty($name) || strlen($name) < 2)     $errors[] = 'Name is required.';
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
if (empty($course))                         $errors[] = 'Please select a course.';
if (strlen($name) > 100)                    $errors[] = 'Name too long.';

if ($errors) {
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

// Save
try {
    $pdo  = getDB();
    $stmt = $pdo->prepare("
        INSERT INTO enquiries (name, email, phone, course, message, status)
        VALUES (?, ?, ?, ?, ?, 'new')
    ");
    $stmt->execute([$name, $email, $phone, $course, $message]);
    echo json_encode(['success' => true, 'message' => 'Enquiry submitted! We\'ll reach out within 24 hours.']);
} catch (PDOException $e) {
    error_log('Enquiry DB error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error. Please try again.']);
}
