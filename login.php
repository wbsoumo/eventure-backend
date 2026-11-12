<?php
/**
 * Eventure CMS — Administrator Login Page (AdminLTE 3 Light Theme)
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

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- AdminLTE 3.2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <!-- Custom Styling -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/custom.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="https://myeventure.in" target="_blank"><b>AdminLTE</b> 3</a>
  </div>
  <!-- /.login-logo -->
  <div class="card card-outline card-primary shadow-sm">
    <div class="card-header text-center">
      <h4 class="mb-0 font-weight-bold text-primary"><b>Eventure</b> CMS</h4>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger py-2 px-3 text-sm mb-3">
          <i class="fas fa-exclamation-triangle mr-1"></i> <?= e($error) ?>
        </div>
      <?php endif; ?>

      <form action="" method="post">
        <?= csrf_field() ?>

        <div class="input-group mb-3">
          <input type="email" id="email" name="email" class="form-control" placeholder="Email" required autofocus value="<?= e($_POST['email'] ?? 'admin@myeventure.in') ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" id="password" name="password" class="form-control" placeholder="Password" required value="Eventure@2026">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">
              <i class="fas fa-sign-in-alt mr-1"></i> Sign In
            </button>
          </div>
        </div>
      </form>

      <div class="mt-4 pt-3 border-top text-center text-xs text-muted">
        <p class="mb-1"><strong>Default credentials:</strong></p>
        <code>admin@myeventure.in</code> &middot; <code>Eventure@2026</code>
      </div>

    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
