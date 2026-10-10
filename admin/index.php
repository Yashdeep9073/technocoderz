<?php
// Admin index — redirect to dashboard or login
require_once __DIR__ . '/../includes/functions.php';
if (isAdminLoggedIn()) {
    header('Location: dashboard.php');
} else {
    header('Location: login.php');
}
exit;
