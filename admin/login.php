<?php
// ============================================================
// Techno Coderz — Admin Login
// ============================================================
require_once __DIR__ . '/../includes/functions.php';

// Redirect if already logged in
if (isAdminLoggedIn()) {
    header('Location: ' . ADMIN_URL . '/dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF check
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $error = 'Security token expired. Please refresh.';
    } else {
        $email    = sanitize($_POST['email']    ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $error = 'Please enter both email and password.';
        } else {
            try {
                $pdo  = getDB();
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND status = 1 LIMIT 1");
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password'])) {
                    // Regenerate session ID on login (security)
                    session_regenerate_id(true);
                    $_SESSION['admin_id']   = $user['id'];
                    $_SESSION['admin_name'] = $user['name'];
                    $_SESSION['admin_email']= $user['email'];
                    $_SESSION['admin_role'] = $user['role'];
                    header('Location: ' . ADMIN_URL . '/dashboard.php');
                    exit;
                } else {
                    $error = 'Invalid email or password.';
                }
            } catch (PDOException $e) {
                error_log('Admin login error: ' . $e->getMessage());
                $error = 'Database error. Please try again.';
            }
        }
    }
}

$csrf = generateCsrfToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login — Techno Coderz</title>
  <meta name="robots" content="noindex,nofollow">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/admin.css">
  <style>
    body { display:flex; align-items:center; justify-content:center; min-height:100vh; padding:20px; }
    .login-wrap { width:100%; max-width:420px; }
    .login-card {
      background:var(--adm-card);
      border:1px solid var(--adm-border);
      border-radius:20px;
      padding:40px 36px;
      box-shadow:0 20px 60px rgba(0,0,0,0.5);
    }
  </style>
</head>
<body>
<div class="login-wrap">
  <div class="login-card">

    <!-- Brand -->
    <div class="text-center mb-32" style="margin-bottom:28px;">
      <div style="font-family:'Space Grotesk',sans-serif;font-size:1.6rem;font-weight:800;color:#fff;margin-bottom:6px;">
        <i class="bi bi-cpu-fill me-2" style="background:linear-gradient(135deg,#6c3ff5,#00d4aa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;"></i>
        Techno <span style="background:linear-gradient(135deg,#6c3ff5,#00d4aa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Coderz</span>
      </div>
      <div style="font-size:0.82rem;color:var(--adm-muted);">Admin Control Panel</div>
    </div>

    <!-- Error -->
    <?php if ($error): ?>
    <div class="adm-alert adm-alert-danger">
      <i class="bi bi-exclamation-triangle-fill"></i>
      <?= e($error) ?>
    </div>
    <?php endif; ?>

    <!-- Form -->
    <form method="POST" novalidate>
      <?= csrfField() ?>

      <div class="adm-form-group">
        <label class="adm-label">Email Address</label>
        <div style="position:relative;">
          <i class="bi bi-envelope-fill" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--adm-muted);font-size:0.9rem;"></i>
          <input type="email" name="email" class="adm-input" style="padding-left:38px;"
                 placeholder="admin@technocoderz.com" value="<?= e($_POST['email'] ?? '') ?>" required autocomplete="email">
        </div>
      </div>

      <div class="adm-form-group">
        <label class="adm-label">Password</label>
        <div style="position:relative;">
          <i class="bi bi-lock-fill" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--adm-muted);font-size:0.9rem;"></i>
          <input type="password" name="password" id="adminPwd" class="adm-input" style="padding-left:38px;padding-right:38px;"
                 placeholder="••••••••" required autocomplete="current-password">
          <button type="button" onclick="togglePwd()" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--adm-muted);cursor:pointer;padding:0;line-height:1;" aria-label="Toggle password">
            <i class="bi bi-eye" id="pwdEye"></i>
          </button>
        </div>
      </div>

      <button type="submit" class="adm-btn adm-btn-primary w-100" style="justify-content:center;padding:12px;font-size:0.9rem;margin-top:8px;">
        <i class="bi bi-box-arrow-in-right"></i> Sign In to Dashboard
      </button>
    </form>

    <div style="text-align:center;margin-top:24px;font-size:0.78rem;color:var(--adm-muted);">
      <a href="<?= SITE_URL ?>" style="color:var(--adm-muted);">
        <i class="bi bi-arrow-left me-1"></i>Back to Website
      </a>
    </div>
  </div>

  <p style="text-align:center;font-size:0.75rem;color:var(--adm-muted);margin-top:20px;">
    &copy; <?= date('Y') ?> Techno Coderz. Secure Admin Area.
  </p>
</div>

<script>
function togglePwd() {
  const inp = document.getElementById('adminPwd');
  const eye = document.getElementById('pwdEye');
  if (inp.type === 'password') {
    inp.type = 'text';
    eye.className = 'bi bi-eye-slash';
  } else {
    inp.type = 'password';
    eye.className = 'bi bi-eye';
  }
}
</script>
</body>
</html>
