<?php
// ============================================================
// Techno Coderz — AJAX: Contact Form Handler
// ============================================================
header('Content-Type: application/json');
require_once __DIR__ . '/../includes/functions.php';

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// CSRF Verification
$token = $_POST['csrf_token'] ?? '';
if (!verifyCsrfToken($token)) {
    echo json_encode(['success' => false, 'message' => 'Security token expired. Please refresh the page.']);
    exit;
}

// Sanitize inputs
$name    = sanitize($_POST['name']    ?? '');
$email   = sanitize($_POST['email']   ?? '');
$phone   = sanitize($_POST['phone']   ?? '');
$course  = sanitize($_POST['course']  ?? '');
$subject = sanitize($_POST['subject'] ?? '');
$message = sanitize($_POST['message'] ?? '');

// Validation
$errors = [];
if (empty($name) || strlen($name) < 2)     $errors[] = 'Name must be at least 2 characters.';
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email address is required.';
if (empty($phone) || preg_replace('/\D/', '', $phone) === '')     $errors[] = 'Mobile number is required.';
if (empty($message) || strlen($message) < 10) $errors[] = 'Message must be at least 10 characters.';
if (strlen($name) > 100)    $errors[] = 'Name is too long.';
if (strlen($subject) > 300) $errors[] = 'Subject is too long.';
if (strlen($course) > 200)  $errors[] = 'Course name is too long.';
if (strlen($message) > 5000) $errors[] = 'Message is too long.';

if ($errors) {
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

if ($course !== '' && $subject === '') {
    $subject = 'Course enquiry: ' . $course;
}

// Save to DB
try {
    $pdo  = getDB();
    $stmt = $pdo->prepare("
        INSERT INTO contact_messages (name, email, phone, subject, message)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([$name, $email, $phone, $subject, $message]);
    echo json_encode(['success' => true, 'message' => 'Your message has been received!']);
} catch (PDOException $e) {
    error_log('Contact form DB error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error. Please try again.']);
}
