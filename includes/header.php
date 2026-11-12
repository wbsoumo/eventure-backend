<?php
/**
 * Eventure CMS — AdminLTE 3 Header & Top Navbar
 */
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_login();

$user = current_user();
$pageTitle = $pageTitle ?? 'Dashboard';

// Count new unread enquiries for navbar badge
$unreadLeadsCount = 0;
try {
    $stmt = $pdo->query("SELECT COUNT(*) FROM `enquiries` WHERE `status` = 'new'");
    $unreadLeadsCount = (int)$stmt->fetchColumn();
} catch (Exception $e) {}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle) ?> — Eventure Admin</title>

  <!-- Google Fonts: Inter & Cormorant Garamond -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Font Awesome 6 Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- AdminLTE 3.2 CSS (Dark mode base) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <!-- SweetAlert2 Dark Theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css">

  <!-- Custom Eventure Luxury Gold Theme -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/custom.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed dark-mode">
<div class="wrapper">

  <!-- Top Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?= BASE_URL ?>/dashboard.php" class="nav-link"><i class="fas fa-home mr-1"></i> Dashboard</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="https://myeventure.in" target="_blank" class="nav-link text-warning">
          <i class="fas fa-external-link-alt mr-1"></i> View Live Site
        </a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Leads Notification Dropdown -->
      <li class="nav-item">
        <a class="nav-link" href="<?= BASE_URL ?>/inquiries/index.php" title="Event Inquiries">
          <i class="far fa-bell"></i>
          <?php if ($unreadLeadsCount > 0): ?>
            <span class="badge badge-warning navbar-badge"><?= $unreadLeadsCount ?></span>
          <?php endif; ?>
        </a>
      </li>

      <!-- Fullscreen toggle -->
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

      <!-- User Profile Dropdown -->
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <i class="fas fa-user-circle text-gold mr-1"></i>
          <span class="d-none d-md-inline"><?= e($user['name'] ?? 'Admin') ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right card-primary">
          <li class="user-header bg-dark">
            <i class="fas fa-user-shield fa-3x text-warning mb-2"></i>
            <p>
              <?= e($user['name'] ?? 'Administrator') ?>
              <small class="text-muted"><?= e($user['email'] ?? '') ?></small>
            </p>
          </li>
          <li class="user-footer bg-dark border-top border-secondary">
            <a href="<?= BASE_URL ?>/settings/site.php" class="btn btn-outline-secondary btn-sm">Settings</a>
            <a href="<?= BASE_URL ?>/logout.php" class="btn btn-danger btn-sm float-right">Logout</a>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <?php require_once __DIR__ . '/sidebar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-gold" style="font-family: 'Cormorant Garamond', serif; font-size: 2rem;">
              <?= e($pageTitle) ?>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/dashboard.php" class="text-gold">Home</a></li>
              <li class="breadcrumb-item active"><?= e($pageTitle) ?></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
