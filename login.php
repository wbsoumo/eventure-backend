<?php
/**
 * Eventure CMS — Administrator Login Page
 */
declare(strict_types=1);

require_once __DIR__ . '/config/config.php';

if (is_logged_in()) {
    redirect(BASE_URL . '/dashboard.php');
}

$error = '';
$redirectUrl = $_GET['redirect'] ?? (BASE_URL . '/dashboard.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token    = $_POST['csrf_token'] ?? '';
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!verify_csrf_token($token)) {
        $error = 'Security session expired. Please refresh and try again.';
    } elseif (empty($email) || empty($password)) {
        $error = 'Please enter both your email address and password.';
    } else {
        if (attempt_login($email, $password)) {
            set_flash('success', 'Welcome back, ' . ($_SESSION['admin_name'] ?? 'Admin') . '!');
            redirect($redirectUrl);
        } else {
            $error = 'Invalid email address or password. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login — Eventure</title>

  <!-- Google Fonts: Inter & Cormorant Garamond -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- AdminLTE 3.2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <!-- Custom Styling -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/custom.css">

  <style>
    body.login-page {
      background: radial-gradient(circle at 50% 20%, #1a1a20 0%, #0a0a0b 80%) !important;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #f7f3ec;
    }
    .login-box {
      width: 420px;
      max-width: 90vw;
    }
    .login-logo {
      margin-bottom: 1.5rem;
    }
    .login-logo a {
      font-family: 'Cormorant Garamond', serif;
      font-size: 2.2rem;
      letter-spacing: 0.18em;
      color: #d4af37 !important;
      font-weight: 500;
      text-decoration: none;
    }
    .login-card-body {
      background: #121215 !important;
      border: 1px solid #2c2c31;
      border-radius: 18px !important;
      padding: 2.5rem !important;
      box-shadow: 0 25px 60px rgba(0, 0, 0, 0.8) !important;
    }
  </style>
</head>
<body class="hold-transition login-page dark-mode">
<div class="login-box">
  <div class="login-logo text-center">
    <a href="https://myeventure.in" target="_blank">
      <i class="fas fa-gem mr-2 text-warning"></i>EVENTURE
    </a>
    <p class="text-xs text-muted text-uppercase tracking-widest mt-1">Management Portal</p>
  </div>
  <!-- /.login-logo -->
  <div class="card login-card-body">
    <p class="login-box-msg text-muted pb-3">Sign in to control your website &amp; events</p>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger py-2 px-3 text-sm mb-4">
        <i class="fas fa-exclamation-triangle mr-1"></i> <?= e($error) ?>
      </div>
    <?php endif; ?>

    <form action="" method="post">
      <?= csrf_field() ?>

      <div class="form-group mb-3">
        <label for="email">Admin Email</label>
        <div class="input-group">
          <input type="email" id="email" name="email" class="form-control" placeholder="admin@myeventure.in" required autofocus value="<?= e($_POST['email'] ?? 'admin@myeventure.in') ?>">
          <div class="input-group-append">
            <div class="input-group-text bg-dark border-secondary">
              <span class="fas fa-envelope text-warning"></span>
            </div>
          </div>
        </div>
      </div>

      <div class="form-group mb-4">
        <label for="password">Password</label>
        <div class="input-group">
          <input type="password" id="password" name="password" class="form-control" placeholder="••••••••••••" required value="Eventure@2026">
          <div class="input-group-append">
            <div class="input-group-text bg-dark border-secondary">
              <span class="fas fa-lock text-warning"></span>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <button type="submit" class="btn btn-gold btn-block">
            <i class="fas fa-sign-in-alt mr-2"></i> Access Dashboard
          </button>
        </div>
      </div>
    </form>

    <div class="mt-4 pt-3 border-top border-secondary text-center text-xs text-muted">
      <p class="mb-1"><strong>Default credentials:</strong></p>
      <code>admin@myeventure.in</code> &middot; <code>Eventure@2026</code>
    </div>

  </div>
  <!-- /.login-card-body -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
