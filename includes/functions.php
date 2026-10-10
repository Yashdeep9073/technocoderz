<?php
// ============================================================
// Techno Coderz - Global Functions
// ============================================================

require_once __DIR__ . '/../config/database.php';

// --- Session Start ---
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}

// ============================================================
// OUTPUT & SANITIZATION
// ============================================================

/**
 * Escape HTML output
 */
function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 * Sanitize input string
 */
function sanitize(string $input): string {
    return trim(strip_tags($input));
}

/**
 * Generate a URL-safe slug
 */
function slugify(string $text): string {
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}

// ============================================================
// CSRF PROTECTION
// ============================================================

function generateCsrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken(string $token): bool {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function csrfField(): string {
    return '<input type="hidden" name="csrf_token" value="' . e(generateCsrfToken()) . '">';
}

// ============================================================
// DATABASE HELPERS
// ============================================================

/**
 * Fetch all active records from a table
 */
function fetchAll(string $table, string $orderBy = 'sort_order ASC, id ASC'): array {
    $pdo = getDB();
    $stmt = $pdo->query("SELECT * FROM `$table` WHERE status = 1 ORDER BY $orderBy");
    return $stmt->fetchAll();
}

/**
 * Fetch a single record by id
 */
function fetchById(string $table, int $id): array|false {
    $pdo = getDB();
    $stmt = $pdo->prepare("SELECT * FROM `$table` WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

/**
 * Fetch a single record by slug
 */
function fetchBySlug(string $table, string $slug): array|false {
    $pdo = getDB();
    $stmt = $pdo->prepare("SELECT * FROM `$table` WHERE slug = ? AND status = 1");
    $stmt->execute([$slug]);
    return $stmt->fetch();
}

/**
 * Count records
 */
function countRecords(string $table, string $where = '1'): int {
    $pdo = getDB();
    $stmt = $pdo->query("SELECT COUNT(*) FROM `$table` WHERE $where");
    return (int) $stmt->fetchColumn();
}

// ============================================================
// FLASH MESSAGES
// ============================================================

function setFlash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlash(): ?array {
    if (!empty($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function renderFlash(): void {
    $flash = getFlash();
    if ($flash) {
        $icon = $flash['type'] === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill';
        echo '<div class="alert alert-' . e($flash['type']) . ' alert-dismissible d-flex align-items-center" role="alert">
            <i class="bi bi-' . $icon . ' me-2"></i>
            <div>' . e($flash['message']) . '</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>';
    }
}

// ============================================================
// AUTH
// ============================================================

function isAdminLoggedIn(): bool {
    return !empty($_SESSION['admin_id']) && !empty($_SESSION['admin_role']);
}

function requireAdminLogin(): void {
    if (!isAdminLoggedIn()) {
        header('Location: ' . ADMIN_URL . '/login.php');
        exit;
    }
}

// ============================================================
// IMAGE HELPERS
// ============================================================

function courseImage(string|null $image): string {
    if ($image && file_exists(UPLOAD_DIR . 'courses/' . $image)) {
        return UPLOAD_URL . 'courses/' . $image;
    }
    return SITE_URL . '/assets/images/default-course.svg';
}

function blogImage(string|null $image): string {
    if ($image && file_exists(UPLOAD_DIR . 'blogs/' . $image)) {
        return UPLOAD_URL . 'blogs/' . $image;
    }
    return SITE_URL . '/assets/images/default-blog.svg';
}

function projectImage(string|null $image): string {
    if ($image && file_exists(UPLOAD_DIR . 'projects/' . $image)) {
        return UPLOAD_URL . 'projects/' . $image;
    }
    return SITE_URL . '/assets/images/default-project.svg';
}

function avatarImage(string|null $image): string {
    if ($image && file_exists(UPLOAD_DIR . 'avatars/' . $image)) {
        return UPLOAD_URL . 'avatars/' . $image;
    }
    return SITE_URL . '/assets/images/default-avatar.svg';
}

/**
 * Validate and store an uploaded image.
 * Returns: '' when no file was sent (keep existing), a filename on success,
 *          or sets $error and returns '' on failure.
 */
function uploadImage(array $file, string $subdir, ?string &$error = null): string {
    $error = null;
    if (!isset($file['error'])) {
        // No file input was submitted at all.
        return '';
    }
    if (is_array($file['error'])) {
        $error = 'Invalid upload.';
        return '';
    }
    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        return '';
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $error = 'Upload failed (error code ' . (int) $file['error'] . ').';
        return '';
    }
    if (!is_uploaded_file($file['tmp_name'])) {
        $error = 'Invalid upload.';
        return '';
    }
    if ($file['size'] > 2 * 1024 * 1024) {
        $error = 'Image must be 2 MB or smaller.';
        return '';
    }

    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $mime    = function_exists('mime_content_type') ? (mime_content_type($file['tmp_name']) ?: '') : '';
    if (!isset($allowed[$mime])) {
        $error = 'Only JPG, PNG or WebP images are allowed.';
        return '';
    }

    $dir = UPLOAD_DIR . $subdir . '/';
    if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
        $error = 'Could not create the upload folder.';
        return '';
    }

    $name = 'img_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $allowed[$mime];
    if (!move_uploaded_file($file['tmp_name'], $dir . $name)) {
        $error = 'Could not save the uploaded image.';
        return '';
    }
    return $name;
}

/** Delete a previously stored upload. Returns true when removed. */
function deleteUploadedImage(string $subdir, string|null $file): bool {
    if (!$file) return false;
    $path = UPLOAD_DIR . $subdir . '/' . basename($file);
    return file_exists($path) ? unlink($path) : false;
}


// ============================================================
// MISC
// ============================================================

function timeAgo(string $datetime): string {
    $time = strtotime($datetime);
    $diff = time() - $time;
    if ($diff < 60) return 'Just now';
    if ($diff < 3600) return floor($diff / 60) . ' min ago';
    if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
    if ($diff < 604800) return floor($diff / 86400) . ' days ago';
    return date('d M Y', $time);
}

function formatDate(string $datetime, string $format = 'd M Y'): string {
    return date($format, strtotime($datetime));
}

function starRating(int $rating): string {
    $html = '';
    for ($i = 1; $i <= 5; $i++) {
        $html .= '<i class="bi bi-star' . ($i <= $rating ? '-fill' : '') . ' text-warning"></i>';
    }
    return $html;
}
